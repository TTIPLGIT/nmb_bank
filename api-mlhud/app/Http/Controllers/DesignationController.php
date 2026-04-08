<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Validator;

use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Str;



class DesignationController extends BaseController
{

    public function get_data(Request $request)
    {
        try {
            $method = 'Method => DesignationController => get_data';


            $rows = DB::select("
                SELECT *
                FROM designation AS a
                WHERE a.active_flag = 0
            ");



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
            $isMobile = isset($request['isMobile']);

            $inputArray = $isMobile ? $request : $this->decryptData($request->requestData);

            $input = [
                'designation_name' => $inputArray['designation_name'],
                'notes' => $inputArray['notes'],
                'role_id' => $inputArray['role_id'],
                'client_designation_id' => $inputArray['client_designation_id'] ?? null

            ];
            //  $this->WriteFileLog($inputArray);


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
                            'client_designation_id' => $input['client_designation_id'],
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
                $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true, $isMobile);
                return $sendServiceResponse;
            } else {
                $serviceResponse = array();
                $serviceResponse['Code'] = 400;
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = 1;
                $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true, $isMobile);
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
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false, $isMobile);
            return $sendServiceResponse;
        }
    }

    public function updatedata(Request $request)
    {

        try {
            $method = 'Method => DesignationController => updatedata';
            $isMobile = isset($request['isMobile']);

            $inputArray = $isMobile ? $request : $this->decryptData($request->requestData);
            $input = [
                'designation_name' => $inputArray['designation_name'],
                'notes' => $inputArray['notes'],
                'id' => $inputArray['id'],
                'role_id' => $inputArray['role_id'],
                'client_designation_id' => $inputArray['client_designation_id'] ?? null

            ];

            $name = $input['designation_name'];

            $id  =  $input['id'];

            if ($isMobile) {


                $designation_id = DB::table('designation')
                    ->where('active_flag', 0)
                    ->where('client_designation_id', $input['client_designation_id'])
                    ->value('client_designation_id');

                DB::table('designation')
                    ->where('client_designation_id', $designation_id)
                    ->update([
                        'designation_name'   => $input['designation_name'],
                        'notes' => $input['notes'],
                        'role_id' => $input['role_id'],
                        'active_flag'        => 0,
                        'last_modified_by'   => auth()->user()->id,
                        'last_modified_date' => NOW()
                    ]);


                $serviceResponse = array();
                $serviceResponse['Code'] = config('setting.status_code.success');
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = 1;
                $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true, $isMobile);
                return $sendServiceResponse;
            } else {

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
                    $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true, $isMobile);
                    return $sendServiceResponse;
                } else {


                    $serviceResponse = array();
                    $serviceResponse['Code'] = 400;
                    $serviceResponse['Message'] = config('setting.status_message.success');
                    $serviceResponse['Data'] = 1;
                    $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                    $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true, $isMobile);
                    return $sendServiceResponse;
                }
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
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false, $isMobile);
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

    public function delete_data(Request $request)
    {

        try {

            $method = 'Method => DesignationController => deletedata';
            $isMobile = isset($request['isMobile']);

            $inputArray = $isMobile ? $request : $this->decryptData($request->requestData);
            $input = [
                'designation_name' => $inputArray['designation_name'],
                'notes' => $inputArray['notes'],
                'id' => $inputArray['id'],
                'role_id' => $inputArray['role_id'],
                'client_designation_id' => $inputArray['client_designation_id']

            ];


            if ($isMobile) {
                // $this->WriteFileLog('jii1');


                $designation_id = DB::table('designation')
                    ->where('active_flag', 0)
                    ->where('client_designation_id', $input['client_designation_id'])
                    ->value('designation_id');

                DB::table('designation')
                    ->where('designation_id', $designation_id)
                    ->update([

                        'active_flag'        => 1,

                    ]);


                $serviceResponse = array();
                $serviceResponse['Code'] = config('setting.status_code.success');
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = 1;
                $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true, $isMobile);
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
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false, $isMobile);
            return $sendServiceResponse;
        }
    }

    public function custom_filed(Request $request)
    {
        try {
            $method = 'Method => DesignationController => custom_filed';


            $rows = DB::select("
                SELECT id,field_label,field_name,field_type
                FROM custom_fields AS a
                WHERE a.status = 1");



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

    public function custom_filed_create()
    {
        try {

            $method = 'Method => DesignationController => custom_filed_create';

            $roles = DB::table('uam_roles')
                ->select('role_id', 'role_name')
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

    public function custom_filed_store(Request $request)
    {
        try {
            $this->WriteFileLog($request);

            $method = 'Method => coursecategoryController => store';
            $inputArray = $request->requestData;

            $inputArray = $this->decryptData($inputArray);
            $input = [

                'field_label' => $inputArray['field_label'],
                'field_name' => $inputArray['field_name'],
                'field_type' => $inputArray['field_type'],
                'field_options' => $inputArray['field_options'],
                'is_required' => $inputArray['is_required'],

            ];


            $rows = DB::table('custom_fields')->insertGetId([

                'field_label' => $input['field_label'],
                'field_name' => $input['field_name'],
                'field_type' => $input['field_type'],
                'field_options' => $input['field_options'],
                'is_required' => $input['is_required'],
                'created_by' => auth()->user()->id,
                'created_at' => NOW()

            ]);
            $this->notifications_insert(null, auth()->user()->id, "Custom Field Created Successfully", "/custom_filed");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog($input['field_name'], $rows, 'Create', 'Custom Field Successfully', auth()->user()->id, NOW(), $role_name_fetch);


            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $rows;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }

    public function custom_filed_fetch($id)
    {

        $method = 'Method => coursecategoryController =>custom_filed_fetch';
        try {
            $id = $this->decryptData($id);

            $rows = DB::select("SELECT * FROM custom_fields WHERE id = ?", [$id]);

            $response = [
                'rows' => $rows,

            ];

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] =  $response;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }

    public function custom_filed_update(Request $request)
    {
        try {
            $this->WriteFileLog($request);

            $method = 'Method => coursecategoryController => store';
            $inputArray = $request->requestData;

            $inputArray = $this->decryptData($inputArray);
            $input = [

                'field_label' => $inputArray['field_label'],
                'field_name' => $inputArray['field_name'],
                'field_type' => $inputArray['field_type'],
                'field_options' => $inputArray['field_options'],
                'is_required' => $inputArray['is_required'],
                'id' => $inputArray = $this->decryptData($inputArray['id'])

            ];

            $rows = DB::table('custom_fields')
                ->where('id', $input['id'])
                ->update([
                    'field_label' => $input['field_label'],
                    'field_name' => $input['field_name'],
                    'field_type' => $input['field_type'],
                    'field_options' => $input['field_options'],
                    'is_required' => $input['is_required'],
                    // 'updated_by' => auth()->user()->id,
                    'updated_at' => now()
                ]);
            $this->notifications_insert(null, auth()->user()->id, "Custom Field updated Successfully", "/custom_filed");
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog($input['field_name'], $rows, 'Updat', 'Custom Field Successfully', auth()->user()->id, NOW(), $role_name_fetch);


            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $rows;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }

    public function custom_filed_delete($id)
    {

        try {
            $method = 'Method => DesignationController => deletedata';
            $id = $this->decryptData($id);


            $check = DB::select("select * from custom_fields where id = $id and status = 1");


            if ($check != []) {

                DB::table('custom_fields')
                    ->where('id', $id)
                    ->update([

                        'status'        => 0,
                        'updated_at' => NOW()

                    ]);
                $input = DB::select("select field_name from custom_fields where id =$id;");
                $field_name = $input[0]->field_name;
                $notifications = DB::table('notifications')->insertGetId([
                    'user_id' => auth()->user()->id,
                    'notification_status' => 'Module Deleted',
                    'notification_url' => 'uam_modules',
                    'megcontent' => "Module " . $field_name . " Deleted Successfully .",
                    'alert_meg' => "Module " . $field_name . " Deleted Successfully .",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);

                $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
                $role_name_fetch = $role_name[0]->role_name;
                $this->auditLog('uam_modules', $id, 'Delete', 'Deleted the Custom Field', auth()->user()->id, NOW(), $role_name_fetch);
            }

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
