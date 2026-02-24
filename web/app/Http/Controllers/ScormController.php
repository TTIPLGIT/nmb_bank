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
    'file' => 'required|mimes:zip|max:512000'
]);

    $uploadedFile = $request->file('file');

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
    $userId = auth()->id();

    $data = $request->data;

    DB::table('scorm_tracking')->updateOrInsert(
        [
            'user_id'  => $userId,
            'scorm_id' => $request->scorm_id,
        ],
        [
            'lesson_status' => $data['cmi.core.lesson_status'] ?? null,
            'score'         => $data['cmi.core.score.raw'] ?? null,
            'suspend_data'  => $data['cmi.suspend_data'] ?? null,
            'updated_at'    => now(),
        ]
    );

    return response()->json(['status' => 'success']);
}

public function launch($id)
{
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
public function scorm_course_publish($id, Request $request)
{
   dd($request->all());
}
}