<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Validator;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Str;



class UamModulesController extends BaseController
{

    public function get_data(Request $request)
    {
        try {

            $method = 'Method => UamModulesController => get_data';
            $userID = auth()->user()->id;
            // $rows = DB::table('uam_modules as a')
            // ->rightjoin('uam_modules as b', 'b.parent_module_id', '=', 'a.module_id')
            // ->select('a.module_name as parent_module_name','b.module_name','b.display_order','b.module_id','a.module_id as moduleid')
            // ->orderBy('b.display_order', 'ASC')
            // ->where('b.active_flag',0)
            // ->get();
            $rows = DB::select('select `a`.`module_name` as `parent_module_name`, `b`.`module_name`, `b`.`display_order`, `b`.`module_id`, `a`.`module_id` as `moduleid` from `uam_modules` as `a` right join `uam_modules` as `b` on `b`.`parent_module_id` = `a`.`module_id` where `b`.`active_flag` = 0');




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
    //create

    public function get_uam_modules()
    {
        try {
            $method = 'Method => UamModulesController => get_uam_modules';
            $rows = DB::table('uam_modules')
                ->select('*')
                ->where([['active_flag', 0], ['parent_module_id', null]])
                ->get();
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
        try {

            $method = 'Method => UamModulesController => storedata';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'module_name' => $inputArray['module_name'],
                'display_order' => $inputArray['display_order'],
                'parent_module_id' => $inputArray['parent_module_id'],
                'module_type' => $inputArray['module_type'],
                'class_name' => $inputArray['class_name']
            ];


            $module_name = $input['module_name'];

            $module_check = DB::select("select * from uam_modules where module_name = '$module_name' and active_flag = 0 ");

            if ($module_check == []) {



                DB::transaction(function () use ($input) {

                    $display_order = $input['display_order'];

                    if ($display_order == "") {

                        $disp_order = 1;
                    } else {

                        $disp_order = $input['display_order'];
                    }


                    $uam_modules_id = DB::table('uam_modules')
                        ->insertGetId([
                            'module_name' => $input['module_name'],
                            'display_order' => $disp_order,
                            'parent_module_id' => $input['parent_module_id'],
                            'module_type' => $input['module_type'],
                            'class_name' => $input['class_name'],
                            'active_flag' => 0,

                        ]);


                    $notifications = DB::table('notifications')->insertGetId([
                        'user_id' => auth()->user()->id,
                        'notification_status' => 'Module Created',
                        'notification_url' => 'uam_modules',
                        'megcontent' => "Module " .  $input['module_name'] . " created Successfully .",
                        'alert_meg' => "Module " . $input['module_name'] . " created Successfully .",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);



                    $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
                    $role_name_fetch = $role_name[0]->role_name;
                    $this->auditLog('uam_modules', $uam_modules_id, 'Create', 'Create new uam module', auth()->user()->id, NOW(), $role_name_fetch);
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
            $this->WriteFileLog($exceptionResponse);
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
            $method = 'Method => UamModulesController => updatedata';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'module_name' => $inputArray['module_name'],
                'display_order' => $inputArray['display_order'],
                'parent_module_id' => $inputArray['parent_module_id'],
                'module_id' => $inputArray['module_id'],
                'module_type' => $inputArray['module_type'],
                'class_name' => $inputArray['class_name']

            ];
            $module_name  =  $input['module_name'];
            $id = $input['module_id'];


            $module_check = DB::select("select * from uam_modules where module_name = '$module_name' and module_id != '$id' and active_flag = 0 ");


            if ($module_check == []) {

                DB::transaction(function () use ($input) {

                    if ($input['parent_module_id'] == "") {
                        $parent = 0;
                    } else {
                        $parent = $input['parent_module_id'];
                    }


                    $display_order = $input['display_order'];

                    if ($display_order == "") {

                        $disp_order = 1;
                    } else {

                        $disp_order = $input['display_order'];
                    }


                    DB::table('uam_modules')
                        ->where('module_id', $input['module_id'])
                        ->update([
                            'module_name' => $input['module_name'],
                            'display_order' => $disp_order,
                            'parent_module_id' => $parent,
                            'active_flag' => 0,
                            'last_modified_by' => auth()->user()->id,
                            'last_modified_date' => NOW()
                        ]);

                    $notifications = DB::table('notifications')->insertGetId([
                        'user_id' => auth()->user()->id,
                        'notification_status' => 'Module Updated',
                        'notification_url' => 'uam_modules',
                        'megcontent' => "Module " . $input['module_name'] . " Updated Successfully .",
                        'alert_meg' => "Module " . $input['module_name'] . " Updated Successfully .",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);

                    //   $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
                    //       INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

                    //   $role_name_fetch=$role_name[0]->role_name;

                    $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
                    $role_name_fetch = $role_name[0]->role_name;
                    $this->auditLog('uam_modules', $input['module_id'], 'Update', 'Update uam module', auth()->user()->id, NOW(), $role_name_fetch);
                });

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


    // edit


    public function data_edit($id)
    {
        try {

            $method = 'Method => UamModulesController => data_edit';
            $id = $this->decryptData($id);
            $one_rows = DB::table('uam_modules')
                ->select('*')
                ->where('module_id', $id)
                ->get();

            if ($id != 5) {

                $rows = DB::table('uam_modules')
                    ->select('*')
                    ->where([['active_flag', 0], ['parent_module_id', null]])
                    ->get();
            } else {
                $rows = DB::table('uam_modules')
                    ->select('*')
                    ->get();
            }


            $response = [
                'rows' => $rows,
                'one_rows' => $one_rows
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

            $method = 'Method => UamModulesController => data_delete';
            $id = $this->decryptData($id);
            if ($id == 5) {

                $serviceResponse = array();
                $serviceResponse['Code'] = 400;
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = 1;
                $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
                return $sendServiceResponse;
            }

            $check = DB::select("select * from uam_module_screens where module_id = '$id' and active_flag = '0' ");

            if ($check != []) {

                DB::table('uam_modules')
                    ->where('module_id', $id)
                    ->update([
                        'active_flag' => 1,
                        'last_modified_by' => auth()->user()->id,
                        'last_modified_date' => NOW()
                    ]);

                $input = DB::select("select module_name from uam_modules where module_id =$id;");
                $module_name = $input[0]->module_name;
                $notifications = DB::table('notifications')->insertGetId([
                    'user_id' => auth()->user()->id,
                    'notification_status' => 'Module Deleted',
                    'notification_url' => 'uam_modules',
                    'megcontent' => "Module " . $module_name . " Deleted Successfully .",
                    'alert_meg' => "Module " . $module_name . " Deleted Successfully .",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);






                // $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
                //     INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

                // $role_name_fetch=$role_name[0]->role_name;

                $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
                $role_name_fetch = $role_name[0]->role_name;
                $this->auditLog('uam_modules', $id, 'Delete', 'Deleted the uam module', auth()->user()->id, NOW(), $role_name_fetch);

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
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }
}
