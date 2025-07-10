<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Redirect;
use Validator;
use GuzzleHttp\Client;
use DB;
use Illuminate\Support\Facades\Crypt;

class CertifcateTemplateController extends BaseController
{


    public function index(Request $request)
    {

        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];

        // else if(strpos($screen_permission['permissions'], 'View') !== false){
        try {
            $method = 'Method => DesignationController => index';
            $serviceResponse = array();

            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $gatewayURL = config('setting.api_gateway_url') . '/certificate_template/get_data';
            $response = $this->serviceRequest($gatewayURL, 'GET', $serviceResponse, $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data['rows'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    $permission = $this->FillScreensByUser();
                    $screen_permission = $permission[0];
                    return view('certificate_template.index', compact('rows', 'screens', 'modules', 'screen_permission'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        // }
        // else{
        //    return redirect()->route('not_allow');
        // }
    }


public function store(Request $request)
{
    $method = 'Method => CertificateTemplateController => store';

    try {
        // Step 1: Validation
        $rules = [
            'name' => 'required|array|max:2',
            'name.*' => 'required|string|max:255',
            'designation' => 'required|array|max:2',
            'designation.*' => 'required|string|max:255',
            'signature.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'existing_signature.*' => 'nullable|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Step 2: Prepare structured data
        $entries = [];
   
        foreach ($request->input('name') as $i => $name) {
            
            $signatureFile = $request->file('signature')[$i] ?? null;
            $existingSignature = $request->input('existing_signature')[$i] ?? null;

            $entry = [
                'name' => $name,
                'designation' => $request->input('designation')[$i],
                'certificate_templates_id' => $request->input('certificate_templates_id'),
                'certificate_template_signatories_id' => $request->input('certificate_template_signatories_id')[$i] ?? '',
            ];
   
            if ($signatureFile) {
                $entry['signature_file_name'] = $signatureFile->getClientOriginalName();
                $entry['signature_file_content'] = base64_encode(file_get_contents($signatureFile->getRealPath()));
                $entry['signature_mime_type'] = $signatureFile->getMimeType();
            } elseif ($existingSignature) {
                $entry['signature_path'] = $existingSignature;
            }

            $entries[] = $entry;
        }
        

        // Step 3: Encrypt & call API
        $encryptArray = $this->encryptData(['details' => $entries]);

        $apiRequest = [
            'requestData' => $encryptArray,
        ];

        $gatewayURL = config('setting.api_gateway_url') . '/certificate-template/store';
        $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($apiRequest), $method);
        $response1 = json_decode($response);

        // Step 4: Handle response
        if ($response1->Status == 200 && $response1->Success) {
            $objData = json_decode($this->decryptData($response1->Data), true);

            if ($objData['Code'] == 200) {
                return redirect()->route('certificate_template.index')->with('success', 'Certificate Template Saved Successfully');
            } elseif ($objData['Code'] == 400) {
                return Redirect::back()->with('fail', 'Template Already Exists')->withInput();
            }
        }

        return Redirect::back()->with('fail', 'Something went wrong')->withInput();

    } catch (\Exception $exc) {
        return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
}


   





    public function edit($id)
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Edit') !== false) {
            try {
                $method = 'Method => DesignationController => edit';
                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/certificate_template/data_edit_details/' . $this->encryptData($id);
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
                $response = json_decode($response);
            
                if ($response->Status == 200 && $response->Success) {
                    $objData = json_decode($this->decryptData($response->Data));
                    if ($objData->Code == 200) {
                        $parant_data = json_decode(json_encode($objData->Data), true);
                        $certificate_template_details =  $parant_data['rows'];
                        $certificate_templates = $parant_data['certificate_templates'];
                        $menus = $this->FillMenu();
                        $screens = $menus['screens'];
                        $modules = $menus['modules'];
                        return view('certificate_template.details', compact('certificate_template_details', 'modules', 'screens','certificate_templates'));
                    }
                } else {
                    $objData = json_decode($this->decryptData($response->Data));
                    echo json_encode($objData->Code);
                    exit;
                }
            } catch (\Exception $exc) {
                return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
            }
        } else {
            return redirect()->route('not_allow');
        }
    }


    public function show($id)
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Show') !== false) {
            try {
                $method = 'Method => DesignationController => show';
                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/certificate_template/data_edit/' . $this->encryptData($id);
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
                $response = json_decode($response);
                if ($response->Status == 200 && $response->Success) {
                    $objData = json_decode($this->decryptData($response->Data));
                    if ($objData->Code == 200) {
                        $parant_data = json_decode(json_encode($objData->Data), true);
                        $template =  $parant_data['rows'];
                        
                        $menus = $this->FillMenu();
                        $screens = $menus['screens'];
                        $modules = $menus['modules'];

                       
                       return view("certificate_template.{$template['template_name']}.preview", compact('template', 'modules', 'screens'));

                    }
                } else {
                    $objData = json_decode($this->decryptData($response->Data));
                    echo json_encode($objData->Code);
                    exit;
                }
            } catch (\Exception $exc) {
                return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
            }
        } else {
            return redirect()->route('not_allow');
        }
    }

    public function verify($id)
{
   $decryptedId = Crypt::decryptString($id);
    $certificate = DB::table('elearning_courses')
                ->select('*')
                ->where('course_id', $decryptedId)
                ->first();

    if ($certificate == null) {
        return response()->json(['message' => 'Certificate not found.'], 404);
    }
    
    $isExpired = now()->gt($certificate->course_expiry_period);

    return view('certificate_template.verification_result', [
        'name' => $certificate->course_pay,
        'course' => $certificate->course_name,
        'date' => $certificate->course_expiry_period,
        'status' => $isExpired ? 'Expired' : 'Valid',
    ]);
}




  








}