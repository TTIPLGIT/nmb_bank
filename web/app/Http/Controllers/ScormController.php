<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Peopleaps\Scorm\Manager\ScormManager;
use Peopleaps\Scorm\Exception\InvalidScormArchiveException;
use Peopleaps\Scorm\Model\ScormModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use PDF;


class ScormController extends BaseController
{
    private $scormManager;

   

    /**
     * Display list of SCORM packages
     */
    public function index()
    {
        $scormPackages = DB::table('scorm')->paginate(10);
        $menus = $this->FillMenu();
        
        if ($menus == "401") {
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
         $screens = $menus['screens'];
        $modules = $menus['modules'];

         $roles = DB::table('uam_roles')
            ->select('*')
            ->where('active_flag', 0)
            ->get();
         $designations = DB::table('designation')
            ->select('*')
            ->orderBy('designation_id', 'desc')
            ->get();

        // Get users for dropdown
        $users = DB::table('users')
            ->select('*')
            ->orderBy('id', 'desc')
            ->get();
          $certificate_templates = DB::table('certificate_templates')
            ->where('active_flag', '0')
            ->get();
        
        return view('scorm.index', compact('scormPackages','screens','modules','roles','designations','users','certificate_templates'));
    }




public function upload(Request $request)
{
   $request->validate([
    'scorm_file' => 'required|mimes:zip|max:512000'
]);

    $uploadedFile = $request->file('scorm_file');

    // 1️⃣ Generate UUID
    $uuid = Str::uuid()->toString();

    // 2️⃣ Create extract folder
    $extractPath = public_path("scorm/$uuid");

    if (!file_exists($extractPath)) {
        mkdir($extractPath, 0777, true);
    }

    // 3️⃣ Move ZIP
    $zipName = $uploadedFile->getClientOriginalName();
    $zipPath = $extractPath . '/' . $zipName;
    $uploadedFile->move($extractPath, $zipName);

    // 4️⃣ Extract ZIP
    $zip = new \ZipArchive;

    if ($zip->open($zipPath) === TRUE) {
        $zip->extractTo($extractPath);
        $zip->close();
        unlink($zipPath);
    } else {
        return response()->json(['message' => 'Unable to extract zip'], 500);
    }

    // 5️⃣ Find imsmanifest.xml (recursive)
    $manifestPath = null;

    $files = new \RecursiveIteratorIterator(
        new \RecursiveDirectoryIterator($extractPath)
    );

    foreach ($files as $fileItem) {
        if (strtolower($fileItem->getFilename()) === 'imsmanifest.xml') {
            $manifestPath = $fileItem->getPathname();
            break;
        }
    }

    if (!$manifestPath || !file_exists($manifestPath)) {
        return response()->json(['message' => 'imsmanifest.xml not found'], 400);
    }

 
libxml_use_internal_errors(true);

$dom = new \DOMDocument();

// Read file content manually
$xmlContent = file_get_contents($manifestPath);

if ($xmlContent === false) {
    return response()->json(['message' => 'Cannot read imsmanifest.xml'], 400);
}

// Remove BOM if exists
$xmlContent = preg_replace('/^\xEF\xBB\xBF/', '', $xmlContent);

// Load XML string instead of file
if (!$dom->loadXML($xmlContent)) {

    $errors = libxml_get_errors();
    libxml_clear_errors();

    return response()->json([
        'message' => 'Invalid imsmanifest.xml',
        'errors' => $errors
    ], 400);
}

    // 🔹 Course Title (Namespace Safe)
    $title = 'Untitled Course';
    $organizations = $dom->getElementsByTagName('organization');

    if ($organizations->length > 0) {
        $titles = $organizations->item(0)->getElementsByTagName('title');
        if ($titles->length > 0) {
            $title = $titles->item(0)->nodeValue;
        }
    }

    // 🔹 Manifest Identifier
    $identifier = $dom->documentElement->getAttribute('identifier') ?: Str::uuid();

    // 7️⃣ Find Launchable Resource (SUPER SAFE - No Namespace Issues)
    $resourceNode = null;
    $resources = $dom->getElementsByTagName('resource');

    if ($resources->length === 0) {
        return response()->json(['message' => 'No resources found in manifest'], 400);
    }

    foreach ($resources as $res) {

        if (!$res instanceof \DOMElement) {
            continue;
        }

        $href = $res->getAttribute('href');

        if (!empty($href)) {
            $resourceNode = $res;
            break;
        }
    }

    if (!$resourceNode) {
        return response()->json(['message' => 'No launchable SCO found'], 400);
    }

    $launchFile = $resourceNode->getAttribute('href');

    if (empty($launchFile)) {
        return response()->json(['message' => 'Launch file not defined'], 400);
    }

    // 8️⃣ Build Entry URL
    $manifestDir = dirname($manifestPath);

    $relativePath = str_replace(public_path() . DIRECTORY_SEPARATOR, '', $manifestDir);
    $relativePath = str_replace('\\', '/', $relativePath);

    $entryUrl = $relativePath . '/' . $launchFile;

    // 9️⃣ Store in DB
    DB::table('scorm')->insert([
        'uuid' => $uuid,
        'title' => $title,
        'identifier' => $identifier,
        'entry_url' => $entryUrl,
        'created_at' => now(),
        'updated_at' => now()
    ]);

    return redirect()->route('scorm.index')
        ->with('success', 'SCORM package uploaded successfully');
}


public function commit(Request $request)
{
    $userId  = $request->session()->get("userID");
    $data    = $request->data;
    $scormId = $request->scorm_id;

    $lessonStatus = $data['cmi.core.lesson_status'] ?? null;
    $score        = $data['cmi.core.score.raw'] ?? null;

    // Save tracking
    DB::table('scorm_tracking')->updateOrInsert(
        [
            'user_id'  => $userId,
            'scorm_id' => $scormId,
        ],
        [
            'lesson_status' => $lessonStatus,
            'score'         => $score,
            'suspend_data'  => $data['cmi.suspend_data'] ?? null,
            'updated_at'    => now(),
        ]
    );

    // 🔎 Check course certificate setting
    $course = DB::table('scorm_courses')
        ->where('scorm_id', $scormId)
        ->where('status', '1')
        ->first();

    $certificateGenerated = false;

if ($course && $course->course_certificate == '1') {

    if ($lessonStatus === 'completed' || $lessonStatus === 'passed') {
       
        // Score no longer required
        $this->generateCertificate($userId, $scormId);
        $certificateGenerated = true;
    }
}

    return response()->json([
        'status' => 'success',
        'certificate' => $certificateGenerated,
        'lessonStatus'=> $lessonStatus,
        'encrypted_id' => encrypt($scormId)
    ]);
}

private function generateCertificate($user_id, $scormId)
{
    $courseDetails = DB::table('scorm_courses')
        ->where('scorm_id', $scormId)
        
        ->first();

    if (!$courseDetails || !$courseDetails->certificate_template) {
        return;
    }

    $certificate_template_id = $courseDetails->certificate_template;

    $signatories = DB::table('certificate_template_signatories')
        ->where('certificate_template_id', $certificate_template_id)
        ->orderBy('sort_order', 'asc')
        ->get();

    $get_template = DB::table('certificate_templates')
        ->where('certificate_templates_id', $certificate_template_id)
        ->first();

    $certificate_template_rows = DB::table('certificate_templates')
        ->select('*', DB::raw("CONCAT('" . config('setting.api_url') . "', logo) as logo_url"))
        ->where('certificate_templates_id', $certificate_template_id)
        ->first();
     $name = $this->getusername($user_id);
    $data = [
        'date'        => \Carbon\Carbon::today()->format('d-m-Y'),
        'course_name' => $courseDetails->course_name,
        'name'        => $name,
        'signatories' => $signatories,
        'course_id'   => $scormId,
        'logo_url'    => $certificate_template_rows->logo_url ?? '',
    ];
   
    $pdf = PDF::loadView(
        "certificate_template.{$get_template->template_name}.index",
        ['data' => $data]
    );
   
    $path = public_path("userdocuments/scorm_certificate/{$user_id}/{$scormId}");
   
    if (!File::exists($path)) {
        File::makeDirectory($path, 0777, true);
    }

    $filePath = $path . "/certificate.pdf";

    $pdf->save($filePath);
}

public function launch($encryptedId)
{
     $id = Crypt::decrypt($encryptedId);
    $scorm = DB::table('scorm')->where('id', $id)->first();
 $menus = $this->FillMenu();
        
        if ($menus == "401") {
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
         $screens = $menus['screens'];
        $modules = $menus['modules'];
    if (!$scorm) {
        abort(404);
    }
    
    return view('scorm.player', compact('scorm','screens','modules'));
}
public function view($encryptedId)
{
     $id = Crypt::decrypt($encryptedId);
    $scorm = DB::table('scorm')->where('id', $id)->first();
 $menus = $this->FillMenu();
        
        if ($menus == "401") {
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
         $screens = $menus['screens'];
        $modules = $menus['modules'];
    if (!$scorm) {
        abort(404);
    }
    
    return view('scorm.admin_player', compact('scorm','screens','modules'));
}
public function destroy($id)
{
    $package = DB::table('scorm')->where('id', $id)->first();

    if (!$package) {
        return response()->json([
            'status' => false,
            'message' => 'Package not found.'
        ]);
    }

    if (!empty($package->folder_path)) {
        $folderPath = public_path($package->folder_path);

        if (File::exists($folderPath)) {
            File::deleteDirectory($folderPath);
        }
    }

    DB::table('scorm')->where('id', $id)->delete();

    return response()->json([
        'status' => true,
        'message' => 'SCORM package deleted successfully.'
    ]);
    
}


public function scorm_course_publish(Request $request, $id)
{
    $method = 'Method => ScormController => scorm_course_publish';
  
    try {
        $user_id = session()->get("userID");
        if ($user_id == null) {
            return redirect()->route('login');
        }
        
        // Validate required fields
        $request->validate([
            'course_name' => 'required|string|max:255',
            'role_id' => 'required',
            'designation_id' => 'required',
            'user_ids' => 'required',
            'course_banner' => 'required|image|mimes:jpeg,png,jpg|max:2048',
           
        ]);

        // Update scorm table to mark as published
        DB::table('scorm')
            ->where('id', $id)
            ->update([
                'is_published' => '1',
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        // Handle banner upload
        $storagepath_ursb_old1 = public_path() . '/uploads/course/' . $user_id;
        $storagepath_ursb = '/uploads/course/' . $user_id;
        
        if (!File::exists($storagepath_ursb_old1)) {
            File::makeDirectory($storagepath_ursb_old1, 0777, true);
        }
        
        $proposal_files1 = null;
        if ($request->hasFile('course_banner')) {
            $documentsb = $request->file('course_banner');
            $files = $documentsb->getClientOriginalName();
            $findspace = array(' ', '&', "'", '"');
            $replacewith = array('-', '-');
            $proposal_files1 = str_replace($findspace, $replacewith, $files);
            $documentsb->move($storagepath_ursb_old1, $proposal_files1);
        }

        // Process user IDs
        $userIds = $request->input('user_ids', []);
        $processedUserIds = '';
        
        if (is_array($userIds)) {
            if (in_array('All', $userIds)) {
                // Get all user IDs from users table
                $allUsers = DB::table('users')->pluck('id')->toArray();
                $processedUserIds = implode(',', $allUsers);
            } else {
                $processedUserIds = implode(',', $userIds);
            }
        }

        // Prepare insert data for scorm_courses table
        $insertData = [
            'scorm_id' => $id,
            'course_name' => $request->course_name,
            'course_banner' => $proposal_files1,
            'role_id' => $request->role_id,
            'designation_id' => $request->designation_id,
            'user_ids' => $processedUserIds,
            'course_certificate' => $request->course_certificate,
            'certificate_template' => $request->certificate_template,
            'certificate_expiry' => $request->certificate_expiry,
            'expiry_date' => $request->expiry_date,
            'course_noperiod' => $request->course_noperiod,
            'course_start_period' => $request->course_start_period,
            'course_end_period' => $request->course_end_period,
            'restricted_access' => $request->restricted_access,
            'access_pin' => $request->access_pin,
            'status' => '1',
            'created_by' => $user_id,
            'updated_by' => $user_id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Remove null/empty values
        $insertData = array_filter($insertData, function($value) {
            return !is_null($value) && $value !== '';
        });

        // Insert into scorm_courses table
        $scormCourseId = DB::table('scorm_courses')->insertGetId($insertData);

     
            return redirect()->route('scorm.index')
                ->with('success', 'SCORM course has been published successfully');
        

    } catch (\Exception $exc) {
       
        
        return redirect()->back()
            ->with('error', 'An error occurred: ' . $exc->getMessage())
            ->withInput();
    }
}
public function certificate_view($course_id)
{
    $user_id = session('userID');
    $id = Crypt::decrypt($course_id);

    $pdfPath = "userdocuments/scorm_certificate/{$user_id}/{$id}/certificate.pdf";
   
    if (!file_exists(public_path($pdfPath))) {
        abort(404);
    }
     $menus = $this->FillMenu();
        
      
         $screens = $menus['screens'];
        $modules = $menus['modules'];
    
    return view('certificate_template.scorm_view', [
        'pdfPath' => asset($pdfPath),
        'screens' => $screens,
        'modules' => $modules,
    ]);
}


public function validatePin(Request $request)
{
    $courseId = Crypt::decrypt($request->course_id);

    $course = DB::table('scorm_courses')
        ->where('scorm_course_id', $courseId)
        ->first();
   
    if ($course && $course->access_pin == $request->pin) {

        return response()->json(['valid' => true]);

    }

    return response()->json(['valid' => false]);
}

}