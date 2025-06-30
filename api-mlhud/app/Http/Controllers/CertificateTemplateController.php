<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Validator;
use DB;
use File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;




class CertificateTemplateController extends BaseController
{

    public function get_data(Request $request)
    {
        try {
            $method = 'Method => CertificateTemplateController => get_data';


            $rows = DB::select('select `a`.* from `certificate_templates` as `a` where `a`.`active_flag` = 0 ');

            $response = [
                'rows' => $rows
            ];

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $response;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }
 



public function storedata(Request $request)
{
    $userID = auth()->user()->id;
    $method = 'Method => CertificateTemplateController => storedata';

    try {
        $inputArray = $this->decryptData($request->requestData);
        $entries = $inputArray['details'] ?? [];

        if (empty($entries)) {
            return $this->SendServiceResponse(
                json_encode(['Code' => 422, 'Message' => 'No data provided', 'Data' => null], JSON_FORCE_OBJECT),
                422,
                false
            );
        }

       

        DB::transaction(function () use ($entries, $userID) {
            $certificateTemplateId = $entries[0]['certificate_templates_id'] ?? null;
            $submittedIds = [];
            $sort = 1;
           
            foreach ($entries as $entry) {
                $signatoryId = $entry['certificate_template_signatories_id']  ?? null;
                $name = $entry['name'];
                $title = $entry['designation'];
                $relativePath = null;

                // Handle new file upload or use existing path
                if (!empty($entry['signature_file_content'])) {
                    $fileName = $entry['signature_file_name'];
                    $fileContent = base64_decode($entry['signature_file_content']);

                    $storagePath = public_path('images/signatures');
                    if (!file_exists($storagePath)) {
                        mkdir($storagePath, 0755, true);
                    }

                    $uniqueFileName = uniqid() . '_' . $fileName;
                    $filePath = $storagePath . '/' . $uniqueFileName;
                    file_put_contents($filePath, $fileContent);

                    $relativePath = 'images/signatures/' . $uniqueFileName;
                } elseif (!empty($entry['signature_path'])) {
                    $relativePath = $entry['signature_path'];
                }

              
              
                if ($signatoryId) {
                    // Update existing signatory
                    DB::table('certificate_template_signatories')
                        ->where('certificate_template_signatories_id', $signatoryId)
                        ->update([
                            'name' => $name,
                            'title' => $title,
                            'signature_path' => $relativePath,
                            'sort_order' => $sort++,
                            'updated_at' => now(),
                        ]);

                       

                    if (!empty($signatoryId)) {
                        $submittedIds[] = $signatoryId;
                    }

                  
                } else {
                    // Insert new signatory
                    $newId = DB::table('certificate_template_signatories')->insertGetId([
                        'certificate_template_id' => $certificateTemplateId,
                        'name' => $name,
                        'title' => $title,
                        'signature_path' => $relativePath,
                        'sort_order' => $sort++,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
   
                    $submittedIds[] = $newId;
                }
            }
           
                // Delete removed signatories
                    DB::table('certificate_template_signatories')
                        ->where('certificate_template_id', $certificateTemplateId)
                        ->whereNotIn('certificate_template_signatories_id', $submittedIds)
                        ->delete();
          
        });

        $serviceResponse = [
            'Code' => config('setting.status_code.success'),
            'Message' => config('setting.status_message.success'),
            'Data' => 1,
        ];

        return $this->SendServiceResponse(json_encode($serviceResponse, JSON_FORCE_OBJECT), config('setting.status_code.success'), true);

    } catch (\Exception $exc) {
        $exceptionResponse = [
            'ServiceMethod' => $method,
            'Exception' => $exc->getMessage(),
        ];

        $serviceResponse = [
            'Code' => config('setting.status_code.exception'),
            'Message' => $exc->getMessage(),
        ];

        return $this->SendServiceResponse(json_encode($serviceResponse, JSON_FORCE_OBJECT), config('setting.status_code.exception'), false);
    }
}





    public function data_edit($id)
    {
        try {

            $method = 'Method => CertificateTemplateController => data_edit';

            $id = $this->decryptData($id);

         

            $rows = DB::table('certificate_templates')
                ->select('*')
                ->where('certificate_templates_id', $id)
                ->first();


            $response = [
                'rows' => $rows
               
            ];

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $response;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }

     public function data_edit_details($id)
    {
        try {

            $method = 'Method => CertificateTemplateController => data_edit';

            $id = $this->decryptData($id);
            $certificate_templates = DB::table('certificate_templates')
                ->select('*')
                ->where('certificate_templates_id', $id)
                ->first();
           

            $rows = DB::table('certificate_template_signatories')
                ->select('*')
                ->where('certificate_template_id', $id)
                ->get();


            $response = [
                'rows' => $rows,
                'certificate_templates' =>$certificate_templates
               
            ];

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $response;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
           
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }





}