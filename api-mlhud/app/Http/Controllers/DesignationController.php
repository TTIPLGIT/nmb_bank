<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Validator;
use DB;
use File;
use Illuminate\Support\Str;



class DesignationController extends BaseController
{

    public function get_data(Request $request)
    {
        try {
            $method = 'Method => DesignationController => get_data';


            $rows = DB::select('select `a`.* from `designation` as `a` where `a`.`active_flag` = 0 ');

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
    public function get_designation()
    {
        try {

            $method = 'Method => DesignationController => get_designation';





            $roles = DB::table('uam_roles')
                ->select('*')
                ->where('active_flag', 0)
                ->get();


            $response = [

                'roles' => $roles
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
        try {
            $method = 'Method => DesignationController => storedata';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'designation_name' => $inputArray['designation_name'],
                'notes' => $inputArray['notes'],
                'role_id' => $inputArray['role_id'],

            ];
            $name = $input['designation_name'];

            $designation_check = DB::select("select * from designation where designation_name = '$name' ");

            if ($designation_check == []) {
                //return auth()->user()->id;

                DB::transaction(function () use ($input) {
                    $uam_modules_id = DB::table('designation')
                        ->insertGetId([
                            'designation_name' => $input['designation_name'],
                            'role_id' => $input['role_id'],
                            'notes' => $input['notes'],
                            'created_by' => auth()->user()->id,



                        ]);
                    $role_name = DB::select("SELECT role_name FROM uam_roles AS ur
                    INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);

                    $role_name_fetch = $role_name[0]->role_name;
                    $this->auditLog('designation', $uam_modules_id, 'Create', 'Create Designation', auth()->user()->id, NOW(), $role_name_fetch);
                });

                // return $this->sendResponse('Success', 'Uam module update successfully.');

                $serviceResponse = array();
                $serviceResponse['Code'] = config('setting.status_code.success');
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = 1;
                $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
                return $sendServiceResponse;
            } else {
                $serviceResponse = array();
                $serviceResponse['Code'] = 400;
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = 1;
                $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
                return $sendServiceResponse;
            }
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

    public function updatedata(Request $request)
    {

        try {
            $method = 'Method => DesignationController => updatedata';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'designation_name' => $inputArray['designation_name'],
                'notes' => $inputArray['notes'],
                'id' => $inputArray['id'],
                'role_id' => $inputArray['role_id'],

            ];

            $name = $input['designation_name'];

            $id  =  $input['id'];

            $designation_check = DB::select("select * from designation where designation_name = '$name' and designation_id != '$id' ");




            if ($designation_check == []) {

                $this->WriteFileLog($input);
                DB::transaction(function () use ($input) {
                    DB::table('designation')
                        ->where('designation_id', $input['id'])
                        ->update([
                            'designation_name' => $input['designation_name'],
                            'notes' => $input['notes'],
                            'role_id' => $input['role_id'],
                            'last_modified_by' => auth()->user()->id,
                            'last_modified_date' => NOW()
                        ]);
                    $role_name = DB::select("SELECT role_name FROM uam_roles AS ur
                INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);

                    $role_name_fetch = $role_name[0]->role_name;
                    $this->auditLog('designation', $input['id'], 'Update', 'Update Designation', auth()->user()->id, NOW(), $role_name_fetch);
                });
                $this->WriteFileLog('data');
                $serviceResponse = array();
                $serviceResponse['Code'] = config('setting.status_code.success');
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = 1;
                $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
                return $sendServiceResponse;
            } else {


                $serviceResponse = array();
                $serviceResponse['Code'] = 400;
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = 1;
                $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
                return $sendServiceResponse;
            }
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



    public function data_edit($id)
    {
        try {

            $method = 'Method => DesignationController => data_edit';

            $id = $this->decryptData($id);

            // $one_rows = DB::table('uam_modules')
            // ->select('*')
            // ->where('module_id', $id)
            // ->get();

            $roles = DB::table('uam_roles')
                ->select('*')
                ->where('active_flag', 0)
                ->get();

            $rows = DB::table('designation')
                ->select('*')
                ->where('designation_id', $id)
                ->first();


            $response = [
                'rows' => $rows,
                'roles' => $roles
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




    public function data_delete($id)
    {
        try {

            $method = 'Method => DesignationController => data_delete';
            $id = $this->decryptData($id);
            DB::transaction(function () use ($id) {
                $uam_modules_id =  DB::table('faq_module_name')
                    ->where('id', $id)
                    ->delete();
            });



            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = 1;
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