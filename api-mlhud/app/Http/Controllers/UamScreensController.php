<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\User;
use Validator;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Str;


class UamScreensController extends BaseController
{

    public function get_data(Request $request)
    {
        try {
            $userID = auth()->user()->id;
            $method = 'Method => UamScreensController => get_data';

            $rows = DB::table('uam_screens as a')
                ->select('a.*')
                ->where('a.active_flag', 0)
                ->orderBy('a.display_order', 'ASC')
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
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }

    public function get_work_flow_data_screen($id)
    {
        //echo "naa";exit;
        try {
            $id = $this->decryptData($id);
            $method = 'Method => UamScreensController => get_work_flow_data_screen';

            $rows = DB::table('work_flow')
                ->select('work_flow.*')
                ->join('uam_screens', 'uam_screens.work_flow_id', '=', 'work_flow.work_flow_id', 'inner')
                ->where('uam_screens.screen_id', $id)
                ->get();



            return $this->sendOneDataResponse($rows);
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


    public function get_work_flow_data()
    {
        //echo "naa";exit;
        try {
            $method = 'Method => UamScreensController => get_work_flow_data';


            $rows = DB::table('uam_screens')
                ->whereNotIn('uam_screens.work_flow_id', function ($query) {
                    $query->select('uam_screens.work_flow_id')->from('uam_screens');
                })
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
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }



    public function getscreenpermission($id)
    {
        // return $id;

        try {

            $method = 'Method => UamScreensController => getscreenpermission';
            $id = $this->decryptData($id);


            $rows = DB::table('uam_screen_permissions as a')

                ->select('a.screen_permission_id', 'a.permission')

                ->where('a.screen_id', $id)
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
            $this->WriteFileLog($exceptionResponse);
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
        //return $request;
        try {
            $method = 'Method => UamScreensController => storedata';
            $inputArray = $this->decryptData($request->requestData);


            $input = [
                'screen_name' => $inputArray['screen_name'],
                'screen_url' => $inputArray['screen_url'],
                'route_url' => $inputArray['route_url'],

                'display_order' => $inputArray['display_order'],
                'screen_permission' => $inputArray['screen_permission'],
                'work_flow_id' => $inputArray['work_flow_id'],
            ];


            $screen_name = $input['screen_name'];

            $screen_check = DB::select("select * from uam_screens where screen_name = '$screen_name' and active_flag = 0 ");

            if ($screen_check == []) {

                DB::transaction(function () use ($input) {
                    $display_order = $input['display_order'];

                    if ($display_order == "") {

                        $disp_order = 1;
                    } else {

                        $disp_order = $input['display_order'];
                    }

                    $uam_screen_id = DB::table('uam_screens')
                        ->insertGetId([
                            'screen_name' => $input['screen_name'],
                            'screen_url' => $input['screen_url'],
                            'route_url' => $input['route_url'],

                            'display_order' =>  $disp_order,
                            'active_flag' => 0,
                            'created_by' => auth()->user()->id,
                            'created_date' => NOW()
                        ]);


                    $screenidcount = count($input['screen_permission']);
                    for ($i = 0; $i < $screenidcount; $i++) {
                        $screen_permission_id = DB::table('uam_screen_permissions')->insertGetId([
                            'permission' => $input['screen_permission'][$i],
                            'screen_id' => $uam_screen_id,
                            'active_flag' => 0,
                            'created_by' => auth()->user()->id,
                            'created_date' => NOW()
                        ]);

                        $notifications = DB::table('notifications')->insertGetId([
                            'user_id' => auth()->user()->id,
                            'notification_status' => 'Screen Created',
                            'notification_url' => 'uam_screens',
                            'megcontent' => "Screen " . $input['screen_name'] . " created Successfully .",
                            'alert_meg' => "Screen " . $input['screen_name'] . " created Successfully .",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                    }

                    $role_name = DB::select("SELECT ur.role_name,us.name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
                    $role_name_fetch = $role_name[0]->role_name;
                    $name = $role_name[0]->name;
                    $this->auditLog('uam_screens', $uam_screen_id, 'Create', "New screen created by ''", auth()->user()->id, NOW(), $role_name_fetch);
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


    public function updatedata(Request $request)
    {
        try {
            $method = 'Method => UamScreensController => updatedata';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'screen_name' => $inputArray['screen_name'],
                'screen_url' => $inputArray['screen_url'],
                'route_url' => $inputArray['route_url'],

                'display_order' => $inputArray['display_order'],
                'screen_id' => $inputArray['screen_id'],
                'screen_permission' => $inputArray['screen_permission'],
                'work_flow_id' => $inputArray['work_flow_id'],

            ];


            $screen_name  =  $input['screen_name'];
            $id = $input['screen_id'];


            $screen_check = DB::select("select * from uam_screens where screen_name = '$screen_name' and screen_id != '$id' and active_flag = 0 ");


            if ($screen_check == []) {

                DB::transaction(function () use ($input) {

                    $display_order = $input['display_order'];

                    if ($display_order == "") {

                        $disp_order = 1;
                    } else {

                        $disp_order = $input['display_order'];
                    }


                    DB::table('uam_screens')
                        ->where('screen_id', $input['screen_id'])
                        ->update([
                            'screen_name' => $input['screen_name'],
                            'screen_url' => $input['screen_url'],
                            'route_url' => $input['route_url'],
                            'display_order' => $disp_order,
                            'active_flag' => 0,
                            'last_modified_by' => auth()->user()->id,
                            'last_modified_date' => NOW()
                        ]);
                    // deepika

                    $notifications = DB::table('notifications')->insertGetId([
                        'user_id' => auth()->user()->id,
                        'notification_status' => 'Screen Updated',
                        'notification_url' => 'uam_screens',
                        'megcontent' => "Screen " . $input['screen_name'] . " Updated Successfully .",
                        'alert_meg' => "Screen " . $input['screen_name'] . " Updated Successfully .",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);

                    $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
                    $role_name_fetch = $role_name[0]->role_name;
                    $this->auditLog('uam_screens', $input['screen_id'], 'Updated', 'Updated the uam screens', auth()->user()->id, NOW(), $role_name_fetch);


                    DB::table('uam_user_screens')
                        ->where('screen_id', $input['screen_id'])
                        ->update([
                            'screen_name' => $input['screen_name'],
                            'screen_url' => $input['screen_url'],
                            'route_url' => $input['route_url'],
                            'display_order' => $disp_order,
                        ]);



                    $screenidcount = count($input['screen_permission']);

                    $screeniddata = $input['screen_permission'];

                    // $rows1 = DB::table('uam_screen_permissions')->where('screen_id', $input['screen_id'])->delete();

                    for ($i = 0; $i < $screenidcount; $i++) {

                        $rows = DB::select("select at.permission from uam_screen_permissions as at where at.screen_id = '" . $input['screen_id'] . "' and at.permission = '" . $screeniddata[$i] . "'");

                        if ($rows == null) {
                            $screen_permission_id = DB::table('uam_screen_permissions')->insertGetId([
                                'permission' => $input['screen_permission'][$i],
                                'screen_id' => $input['screen_id'],
                                'active_flag' => 0,
                                'created_by' => auth()->user()->id,
                                'created_date' => NOW()
                            ]);
                        }
                    }
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



    public function data_edit($id)
    {
        try {

            $method = 'Method => UamScreensController => data_edit';


            $id = $this->decryptData($id);

            $rows = DB::table('uam_screens as a')
                ->select('a.*')
                ->where('a.screen_id', $id)
                ->get();


            //    $work_flow_row = DB::table('work_flow')
            //  ->select('work_flow.*')
            //  ->join('uam_screens','uam_screens.work_flow_id','=','work_flow.work_flow_id','inner')
            // ->where ('uam_screens.screen_id', $id)
            //  ->get();

            // select a.* from work_flow as a where   a.work_flow_id not in
            // (select b.work_flow_id from uam_screens as b where not b.screen_id = 70);

            // $work_flow_row=DB::table('work_flow')
            // ->whereNotIn('work_flow.work_flow_id',function ($query) use ($id){
            //     $query->select('uam_screens.work_flow_id')->from('uam_screens')->where('screen_id', '!=' , $id);
            // })
            // ->get();



            $response = [
                'rows' => $rows,
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

            $method = 'Method => UamScreensController => data_delete';

            $id = $this->decryptData($id);

            $screen_check = DB::select("select * from uam_module_screens where screen_id = '$id'");

            if ($screen_check  != []) {

                DB::table('uam_screens')
                    ->where('screen_id', $id)
                    ->update([
                        'active_flag' => 1,
                        'last_modified_by' => auth()->user()->id,
                        'last_modified_date' => NOW()
                    ]);

                //    deepika
                $input = DB::select("select screen_name from uam_screens where screen_id =$id;");
                $screen_name = $input[0]->screen_name;
                $notifications = DB::table('notifications')->insertGetId([
                    'user_id' => auth()->user()->id,
                    'notification_status' => 'Screen Deleted',
                    'notification_url' => 'uam_screens',
                    'megcontent' => "Screen " . $screen_name . " Deleted Successfully .",
                    'alert_meg' => "Screen " . $screen_name . " Deleted Successfully .",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);


                $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
                $role_name_fetch = $role_name[0]->role_name;
                $this->auditLog('uam_screens', $id, 'Delete', 'Deleted the uam screen', auth()->user()->id, NOW(), $role_name_fetch);



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
