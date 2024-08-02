<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Validator;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Str;


class UamRolesController extends BaseController
{

    public function get_data()
    {

        try {
            $method = 'Method => UamRolesController => get_data';
            $rows = DB::table('uam_roles')
                ->select('*')
                ->where('active_flag', 0)
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




    public function getmodulesandscreens()
    {

        try {
            $method = 'Method => UamRolesController => getmodulesandscreens';

            $parent_module_data = DB::table('uam_modules')
                ->select('*')
                ->where([['parent_module_id', null], ['active_flag', 0]])
                ->get();

            $module_data = DB::table('uam_modules')
                ->select('*')
                ->where([['parent_module_id', '!=', 0], ['active_flag', 0]])
                ->get();

            $screens_data =  DB::select("select b.screen_id,b.screen_name,c.module_id
             from uam_module_screens as a inner join uam_screens as b on b.screen_id = a.screen_id inner join uam_modules as c on c.module_id = a.module_id where b.active_flag = 0");

            $permissions_data = DB::table('uam_screen_permissions')
                ->select('*')
                ->get();

            $response = [
                'parent_module_data' => $parent_module_data,
                'module_data' => $module_data,
                'screens_data' => $screens_data,
                'permissions_data' => $permissions_data
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

    public function get_roles_screen($id)
    {

        try {
            $method = 'Method => UamRolesController => get_roles_screen';
            $id = $this->decryptData($id);
            $rows =  DB::select("select a.screen_id,a.role_id,a.module_id,b.parent_module_id,c.screen_permission_id
            from uam_role_screens as a inner join uam_modules as b on b.module_id = a.module_id inner join uam_role_screen_permissions as c on c.role_screen_id = a.role_screen_id where a.role_id = '$id' ");

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
       
        try {
            $method = 'Method => UamRolesController => storedata';
            $inputArray = $this->decryptData($request->requestData);

            $input = [
                'role_name' => $inputArray['role_name'],
                'screen_id' => $inputArray['screen_id'],
                'permission_id' => $inputArray['permission_id'],

            ];
            $role_name = $input['role_name'];

            $role_name_check = DB::select("select * from uam_roles where role_name = '$role_name'");

            if (json_encode($role_name_check) == '[]') {



                DB::transaction(function () use ($input) {
                    $role_id = DB::table('uam_roles')
                        ->insertGetId([
                            'role_name' => $input['role_name'],
                            'active_flag' => 0,
                            'created_by' => auth()->user()->id,
                            'created_date' => NOW()
                        ]);
                    // Deepika
                    $notifications = DB::table('notifications')->insertGetId([
                        'user_id' => auth()->user()->id,
                        'notification_status' => 'Role Created',
                        'notification_url' => 'uam_roles',
                        'megcontent' => "Role " .  $input['role_name'] . " created Successfully .",
                        'alert_meg' => "Role " . $input['role_name'] . " created Successfully .",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);



                    

                    $screen_unique = array_unique($input['screen_id']);




                    $unique = array_values($screen_unique);

                    $screenidcount = count($unique);
                    for ($i = 0; $i < $screenidcount; $i++) {

                        $iparr = explode(":", $unique[$i]);

                        $rowsdata =  DB::select("select a.module_screen_id from uam_module_screens as a where a.module_id = $iparr[0]   and a.screen_id = $iparr[1] ");
                        $screen_permission_id = DB::table('uam_role_screens')->insertGetId([
                            'screen_id' => $iparr[1],
                            'module_id' => $iparr[0],
                            'module_screen_id' => json_encode($rowsdata[0]->module_screen_id),
                            'role_id' => $role_id,
                            'active_flag' => 0,
                            'created_by' => auth()->user()->id,
                            'created_date' => NOW()
                        ]);
                    }

                    $permissioncount = count($input['permission_id']);

                    for ($j = 0; $j < $permissioncount; $j++) {

                        $permission =  $input['permission_id'][$j];

                        $permissiondata = substr($permission, 6);

                        $iparr = explode("-", $permissiondata);

                        $module_id = $iparr[1];

                        $screen_id = $iparr[2];

                        $role_id = $role_id;

                        $rows =  DB::select("select a.role_screen_id from uam_role_screens as a where a.module_id = $module_id and a.role_id = $role_id  and a.screen_id = $screen_id ");

                        $role_screen_permissions_id = DB::table('uam_role_screen_permissions')->insertGetId([
                            'role_screen_id' =>  json_encode($rows[0]->role_screen_id),
                            'screen_permission_id' => $iparr[0],
                            'array_permission' => $permission,
                            'role_id' => $role_id,
                            'active_flag' => 0,
                            'created_by' => auth()->user()->id,
                            'created_date' => NOW()
                        ]);
                    }

                    // Deepika
                    $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
                    $role_name_fetch = $role_name[0]->role_name;
                    $this->auditLog('uam_roles', $role_id, 'Create', 'Create uam role', auth()->user()->id, NOW(), $role_name_fetch);
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
            $method = 'Method => UamRolesController => updatedata';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'role_name' => $inputArray['role_name'],
                'role_id' => $inputArray['role_id'],
                'screen_id' => $inputArray['screen_id'],
                'permission_id' => $inputArray['permission_id'],

            ];

            
            $role_name = $input['role_name'];
            $role_id = $input['role_id'];

            $role_name_check = DB::select("select * from uam_roles where not role_id = '$role_id' and role_name = '$role_name' ");
           
            if (json_encode($role_name_check) == '[]') {


                DB::transaction(function () use ($input) {

                    $rows1 = DB::table('uam_role_screens')->where('role_id', $input['role_id'])->delete();

                    $rows2 = DB::table('uam_role_screen_permissions')->where('role_id', $input['role_id'])->delete();

                    DB::table('uam_roles')
                        ->where('role_id', $input['role_id'])
                        ->update([
                            'role_name' => $input['role_name'],
                            'active_flag' => 0,
                            'last_modified_by' => auth()->user()->id,
                            'last_modified_date' => NOW()
                        ]);


                    // deepika
                    $notifications = DB::table('notifications')->insertGetId([
                        'user_id' => auth()->user()->id,
                        'notification_status' => 'Role Updated',
                        'notification_url' => 'uam_roles',
                        'megcontent' => "Role " .  $input['role_name'] . " updated Successfully .",
                        'alert_meg' => "Role " . $input['role_name'] . " updated Successfully .",
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);

                    $screen_unique = array_unique($input['screen_id']);

                    $unique = array_values($screen_unique);

                    $screenidcount = count($unique);

                    for ($i = 0; $i < $screenidcount; $i++) {

                        $iparr = explode(":", $unique[$i]);

                        $rowsdata =  DB::select("select a.module_screen_id from uam_module_screens as a where a.module_id = $iparr[0]   and a.screen_id = $iparr[1] ");


                        $screen_permission_id = DB::table('uam_role_screens')->insertGetId([
                            'screen_id' => $iparr[1],
                            'module_id' => $iparr[0],
                            'module_screen_id' => json_encode($rowsdata[0]->module_screen_id),
                            'role_id' => $input['role_id'],
                            'active_flag' => 0,
                            'created_by' => auth()->user()->id,
                            'created_date' => NOW()
                        ]);
                    }

                    $permissioncount = count($input['permission_id']);

                    for ($j = 0; $j < $permissioncount; $j++) {

                        $permission =  $input['permission_id'][$j];

                        $permissiondata = substr($permission, 6);

                        $iparr = explode("-", $permissiondata);

                        $module_id = $iparr[1];

                        $screen_id = $iparr[2];

                        $role_id = $input['role_id'];

                        $rows =  DB::select("select a.role_screen_id from uam_role_screens as a where a.module_id = $module_id and a.role_id = $role_id  and a.screen_id = $screen_id ");

                        $role_screen_permissions_id = DB::table('uam_role_screen_permissions')->insertGetId([
                            'role_screen_id' =>  json_encode($rows[0]->role_screen_id),
                            'screen_permission_id' => $iparr[0],
                            'role_id' => $input['role_id'],
                            'array_permission' => $permission,
                            'active_flag' => 0,
                            'created_by' => auth()->user()->id,
                            'created_date' => NOW()
                        ]);
                    }
                    // Deepika
                    $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
                    $role_name_fetch = $role_name[0]->role_name;
                    $this->auditLog('uam_roles', $input['role_id'], 'Update', 'Update uam role', auth()->user()->id, NOW(), $role_name_fetch);
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
            $method = 'Method => UamRolesController => data_edit';

            $id = $this->decryptData($id);

            $rows = DB::table('uam_roles')
                ->select('*')
                ->where([['role_id', $id], ['active_flag', 0]])
                ->get();

            $rows = DB::select("select a.role_id,a.role_name,c.array_permission from uam_roles as a 
            inner join uam_role_screen_permissions as c on c.role_id = a.role_id where a.role_id = '$id' and a.active_flag = 0");



            $parent_module_data = DB::table('uam_modules')
                ->select('*')
                ->where([['parent_module_id', null], ['active_flag', 0]])
                ->get();

            $module_data = DB::table('uam_modules')
                ->select('*')
                ->where([['parent_module_id', '!=', 0], ['active_flag', 0]])
                ->get();

            $screens_data =  DB::select("select b.screen_id,b.screen_name,c.module_id
         from uam_module_screens as a inner join uam_screens as b on b.screen_id = a.screen_id inner join uam_modules as c on c.module_id = a.module_id where b.active_flag = 0 ");

            $permissions_data = DB::table('uam_screen_permissions')
                ->select('*')
                ->get();


            $response = [
                'rows' => $rows,
                'parent_module_data' => $parent_module_data,
                'module_data' => $module_data,
                'screens_data' => $screens_data,
                'permissions_data' => $permissions_data
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
            
           
            $method = 'Method => UamRolesController => data_delete';
            $id = $this->decryptData($id);

            $role_check = DB::select("select * from uam_user_roles where role_id = '$id'");
           

            if ($role_check == []) {
                DB::table('uam_roles')
                    ->where('role_id', $id)
                    ->update([
                        'active_flag' => 1,
                        'last_modified_by' => auth()->user()->id,
                        'last_modified_date' => NOW()
                    ]);

                $input = DB::select("select role_name from uam_roles where role_id =$id;");
                $role_name = $input[0]->role_name;

                $notifications = DB::table('notifications')->insertGetId([
                    'user_id' => auth()->user()->id,
                    'notification_status' => 'Role Deleted',
                    'notification_url' => 'uam_roles',
                    'megcontent' => "Role " . $role_name . " Deleted Successfully .",
                    'alert_meg' => "Role " . $role_name . " Deleted Successfully .",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);


                //    $role_screen_id = DB::select("select * from uam_role_screens where role_id = '$id'");
                //    $screenidcount = count($role_screen_id);
                //    for ($j=0; $j< $screenidcount; $j++) { 
                //       $role_screen_permission_id  =  $role_screen_id[$j]->role_screen_id;
                //       $delete_role_screen_id  = DB::table('uam_role_screen_permissions')->where('role_screen_id', $role_screen_permission_id)->delete();
                //   }
                //   DB::transaction(function() use($id){
                //     $uam_modules_id =  DB::table('uam_roles')
                //     ->where('role_id', $id)
                //     ->delete();                  
                // });
                //   DB::transaction(function() use($id){
                //     $uam_role_screens =  DB::table('uam_role_screens')
                //     ->where('role_id', $id)
                //     ->delete();                  
                // });

                // Deepika

                $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
                $role_name_fetch = $role_name[0]->role_name;
                $this->auditLog('uam_roles', $id, 'Delete', 'Deleted the uam role', auth()->user()->id, NOW(), $role_name_fetch);


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
