<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Peopleaps\Scorm\Manager\ScormManager;
use Peopleaps\Scorm\Exception\InvalidScormArchiveException;
use Peopleaps\Scorm\Model\ScormModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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
        
        return view('scorm.index', compact('scormPackages','screens','modules'));
    }




public function upload(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:zip|max:512000'
    ]);

    $uploadedFile = $request->file('file');

    // 1️⃣ Generate UUID
    $uuid = Str::uuid()->toString();

    // 2️⃣ Create extract folder inside public/scorm
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

    // 5️⃣ Find imsmanifest.xml
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

    if (!$manifestPath) {
        return response()->json(['message' => 'imsmanifest.xml not found'], 400);
    }

    // 6️⃣ Parse Manifest Properly (Namespace Safe)
    libxml_use_internal_errors(true);

    $dom = new \DOMDocument();
    $dom->load($manifestPath);

    $xpath = new \DOMXPath($dom);

    // Register namespaces
    $xpath->registerNamespace('imscp', 'http://www.imsproject.org/xsd/imscp_rootv1p1p2');
    $xpath->registerNamespace('adlcp12', 'http://www.adlnet.org/xsd/adlcp_rootv1p2');
    $xpath->registerNamespace('adlcp2004', 'http://www.adlnet.org/xsd/adlcp_v1p3');

    // 🔹 Course Title
    $titleNode = $xpath->query('//imscp:organization/imscp:title')->item(0);
    $title = $titleNode ? $titleNode->nodeValue : 'Untitled Course';

    // 🔹 Manifest Identifier
    $identifier = $dom->documentElement->getAttribute('identifier');

    // 🔹 Find Launchable SCO (Robust Way)
    $resources = $xpath->query('//imscp:resource');

    $resourceNode = null;

    foreach ($resources as $res) {

        // SCORM 1.2
        $scormType12 = $res->getAttributeNS(
            'http://www.adlnet.org/xsd/adlcp_rootv1p2',
            'scormtype'
        );

        // SCORM 2004
        $scormType2004 = $res->getAttributeNS(
            'http://www.adlnet.org/xsd/adlcp_v1p3',
            'scormType'
        );

        if (strtolower($scormType12) === 'sco' || strtolower($scormType2004) === 'sco') {
            $resourceNode = $res;
            break;
        }
    }

    if (!$resourceNode) {
        return response()->json(['message' => 'No launchable SCO found'], 400);
    }

    $launchFile = $resourceNode->getAttribute('href');

    if (!$launchFile) {
        return response()->json(['message' => 'Launch file not defined'], 400);
    }

    // 7️⃣ Build Entry URL
    $manifestDir = dirname($manifestPath);

    $relativePath = str_replace(public_path() . DIRECTORY_SEPARATOR, '', $manifestDir);
    $relativePath = str_replace('\\', '/', $relativePath);

    $entryUrl = $relativePath . '/' . $launchFile;

    // 8️⃣ Store in DB
    DB::table('scorm')->insert([
        'uuid' => $uuid,
        'title' => $title,
        'identifier' => $identifier,
        'entry_url' => $entryUrl,
        'created_at' => now(),
        'updated_at' => now()
    ]);

    return response()->json([
        'message' => 'SCORM uploaded successfully',
        'entry_url' => $entryUrl
    ]);
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


}