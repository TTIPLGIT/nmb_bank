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


            $rows = DB::select('select `a`.* from `certificate_templates` as `a`');

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
            

            // $template_id = $inputArray['details'][0]['certificate_templates_id'];
            // $this->WriteFileLog($template_id);
            if (empty($entries)) {
                return $this->SendServiceResponse(
                    json_encode(['Code' => 422, 'Message' => 'No data provided', 'Data' => null], JSON_FORCE_OBJECT),
                    422,
                    false
                );
            }
            DB::transaction(function () use ($entries, $userID) {

                $certificateTemplateId = $entries[0]['certificate_templates_id'] ?? null;

                if (empty($certificateTemplateId)) {

                    $certificateTemplateId = DB::table('certificate_templates')->insertGetId([
                        'template_name' => $entries[0]['name'],
                        'file_name' => $entries[0]['name'],
                        'active_flag' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                $submittedIds = [];
                $sort = 1;

                foreach ($entries as $entry) {

                    $signatoryId = $entry['certificate_template_signatories_id'] ?? null;

                    // ---- SIGNATURE FILE ----
                    $relativePath = null;
                    if (!empty($entry['signature_file_content'])) {
                        $fileContent = base64_decode($entry['signature_file_content']);
                        $uniqueFileName = uniqid() . '_' . $entry['signature_file_name'];
                        file_put_contents(public_path('images/signatures/' . $uniqueFileName), $fileContent);
                        $relativePath = 'images/signatures/' . $uniqueFileName;
                    }

                    if ($signatoryId) {
                        DB::table('certificate_template_signatories')
                            ->where('certificate_template_signatories_id', $signatoryId)
                            ->update([
                                'name' => $entry['name'],
                                'title' => $entry['designation'],
                                'signature_path' => $relativePath,
                                'sort_order' => $sort++,
                                'updated_at' => now(),
                            ]);

                        $submittedIds[] = $signatoryId;
                    } else {
                        $newId = DB::table('certificate_template_signatories')->insertGetId([
                            'certificate_template_id' => $certificateTemplateId,
                            'name' => $entry['name'],
                            'title' => $entry['designation'],
                            'signature_path' => $relativePath,
                            'sort_order' => $sort++,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        $submittedIds[] = $newId;
                    }
                }

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
                ->select(
                    '*',
                    DB::raw("CONCAT('" . config('setting.api_url') . "', logo) as logo_url")
                )
                ->where('certificate_templates_id', $id)
                ->first();

            $rows1 = DB::table('certificate_templates as ct')
                ->join('certificate_template_signatories as cts', 'ct.certificate_templates_id', '=', 'cts.certificate_template_id')
                ->select('ct.*', 'cts.*')
                ->where('ct.certificate_templates_id', $id)
                ->get();



            $response = [
                'rows' => $rows,
                'rows1' => $rows1
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
                'certificate_templates' => $certificate_templates

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
