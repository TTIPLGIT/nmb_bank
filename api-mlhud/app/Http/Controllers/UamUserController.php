<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;
class UamUserController extends BaseController
{

    public function get_user_data()
    {
        try {
            $method = 'Method => UamUserController => get_user_data';
            $rows = DB::table('users as a')
            ->select('a.id','a.name')
            ->join('uam_user_roles as b', 'b.user_id', '=' ,'a.id','inner')
            ->whereNotIn('a.id', DB::table('uam_user_screens')->pluck('user_id'))
            ->get();
            return $this->sendDataResponse($rows);
        } catch(\Exception $exc){
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    public function get_roles(Request $request)
    {
        try {
            $method = 'Method => UamUserController => get_roles';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'user_id' => $inputArray['user_id'],
            ];
            $user_id = $input['user_id'];
            $rows = DB::table('uam_user_roles as a')
            ->select('a.role_id','b.role_name')
            ->join('uam_roles as b', 'b.role_id', '=' ,'a.role_id','inner')
            ->where('a.user_id',$user_id)
            ->get();
            return $this->sendDataResponse($rows);
        } catch(\Exception $exc){
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    public function get_modules(Request $request)
    {
        try {
            $method = 'Method => UamUserController => get_modules';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'role_id' => $inputArray['role_id'],
            ];
            $role_id = $input['role_id'];
            $rows = DB::select("SELECT DISTINCT(b.module_id),b.module_name,a.role_id FROM uam_role_screens As a INNER JOIN uam_modules as b on b.module_id = a.module_id Where a.role_id = $role_id ");
            return $this->sendDataResponse($rows);
        } catch(\Exception $exc){
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    public function get_screens(Request $request)
    {
        try {
            $method = 'Method => UamUserController => get_screens';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'role_id' => $inputArray['role_id'],
                'module_id' => $inputArray['module_id'],
            ];
            $role_id = $input['role_id'];
            $module_id = $input['module_id'];
            $rows = DB::select("select a.screen_id,b.screen_name,a.role_id,a.module_id from uam_role_screens as a inner join uam_screens as b on a.screen_id = b.screen_id where module_id = $module_id  and role_id= $role_id");
            return $this->sendDataResponse($rows);
        } catch(\Exception $exc){
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    public function get_data()
    {
        try {
            $method = 'Method => UamUserController => get_data';
            $rows = DB::select("SELECT DISTINCT a.user_id,b.name,b.id from uam_user_roles as a inner join users as b on
                b.id = a.user_id ");
            return $this->sendDataResponse($rows);
        } catch(\Exception $exc){
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    public function modules_parents(Request $request)
    {

        try {
            $method = 'Method => UamUserController => modules_parents';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'user_id' => $inputArray['user_id'],
            ];
            $user_id = $input['user_id'];
            $rows = DB::select("select distinct module_id,module_name,user_id from uam_user_screens where user_id = $user_id");
            return $this->sendDataResponse($rows);
        } catch(\Exception $exc){
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    public function modules_screen(Request $request)
    {
        try {
            $method = 'Method => UamUserController => modules_screen';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'user_id' => $inputArray['user_id'],
                'module_id' => $inputArray['module_id'],
            ];
            $user_id = $input['user_id'];
            $module_id = $input['module_id'];
            $rows = DB::select("select  screen_id,screen_name, module_id,user_id,screen_id from uam_user_screens where user_id = $user_id and module_id = $module_id");
            return $this->sendDataResponse($rows);
        } catch(\Exception $exc){
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function screen_permission(Request $request)
    {
        try {
            $method = 'Method => UamUserController => screen_permission';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'user_id' => $inputArray['user_id'],
                'module_id' => $inputArray['module_id'],
                'screen_id' => $inputArray['screen_id'],
            ];
            $user_id = $input['user_id'];
            $module_id = $input['module_id'];
            $screen_id = $input['screen_id'];
            $rows = DB::select("select b.screen_permission_id,b.permission, a.screen_id,a.screen_name,a.module_id,a.user_id,a.screen_id from uam_user_screens as a
                inner join uam_user_screen_permissions as b on b.user_screen_id = a.user_screen_id
                where a.user_id = $user_id and a.module_id = $module_id and a.screen_id =$screen_id");
            return $this->sendDataResponse($rows);
        } catch(\Exception $exc){
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function storedata(Request $request)
    {
        try {
            $method = 'Method => UamUserController => storedata';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'user_id' => $inputArray['user_id'],
                'screen_id' => $inputArray['screen_id'],
                'permission_id' => $inputArray['permission_id']
            ];
            $rows1 = DB::table('uam_user_screens')->where('user_id', $input['user_id'])->delete();

            DB::transaction(function() use($input) {
                $screen_unique = array_unique($input['screen_id']);
                $unique = array_values($screen_unique);
                $screenidcount = count($unique);
                for ($i=0; $i < $screenidcount; $i++) { 
                    $iparr = explode(":", $unique[$i]); 
                    $screen_id = $iparr[2];
                    $module_id = $iparr[1];
                    $screenrows =  DB::select("select * from uam_screens where screen_id = $screen_id");
                    $modulesrows =  DB::select("select * from uam_modules where module_id = $module_id");
                    $parent_module_id = $modulesrows[0]->parent_module_id;
                    $module_name = $modulesrows[0]->module_name;
                    $module_name = $modulesrows[0]->module_name;
                    $screen_name = $screenrows[0]->screen_name;
                    $screen_url = $screenrows[0]->screen_url;
                      $route_url = $screenrows[0]->route_url;
                    $class_name = $screenrows[0]->class_name;
                    $display_order = $screenrows[0]->display_order;
                    $screen_permission_id = DB::table('uam_user_screens')->insertGetId([
                        'screen_id' => $screen_id,
                        'module_id' => $module_id,
                        'parent_module_id' => $parent_module_id,
                        'module_name'=> $module_name,
                        'screen_name'=> $screen_name,
                        'screen_url' => $screen_url,
                        'route_url' => $route_url,
                        'class_name' => $class_name,
                        'display_order' =>$display_order,
                        'user_id' => $input['user_id'],                                            
                        'active_flag' => 0,
                        'created_by' => auth()->user()->id,
                        'created_date' => NOW()
                    ]);
                }
                $permissioncount = count($input['permission_id']);
                for ($j=0; $j< $permissioncount; $j++) { 
                    $permission =  $input['permission_id'][$j];
                    $permissiondata = substr($permission,6);
                    $iparr = explode(":", $permissiondata); 
                    $user_id = $input['user_id'];
                    $module_id = $iparr[1];
                    $screen_id = $iparr[2];
                    $permission_id = $iparr[3];
                    $rows =  DB::select("select a.user_screen_id from uam_user_screens as a where a.module_id = $module_id and a.user_id = $user_id  and a.screen_id = $screen_id ");
                    $permissionrows =  DB::select("select a.permission,a.description,a.active_flag from uam_screen_permissions as a where a.screen_permission_id = $permission_id ");
                    $user_screen_id = $rows[0]->user_screen_id;
                    $permission_name = $permissionrows[0]->permission;
                    $description = $permissionrows[0]->description;
                    $active_flag = $permissionrows[0]->active_flag;
                    $role_screen_permissions_id = DB::table('uam_user_screen_permissions')->insertGetId([
                        'user_screen_id' =>  $user_screen_id,
                        'screen_permission_id' =>  $permission_id,  
                        'permission' => $permission_name,
                        'description' => $description,                                          
                        'active_flag' => $active_flag,
                        'created_by' => auth()->user()->id,
                        'created_date' => NOW()
                    ]);
                }
                $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
                    INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

                $role_name_fetch=$role_name[0]->role_name;
                $this->auditLog('uam_user_screens', $user_id , 'Create', 'Create uam user', auth()->user()->id, NOW(),$role_name_fetch);
            });
            return $this->sendResponse('Success', 'Uam user screen create successfully.');
        } catch(\Exception $exc){
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    public function updatedata(Request $request)
    {
      try {
        $method = 'Method => UamUserController => updatedata';
        $inputArray = $this->decryptData($request->requestData);
        $input = [
            'user_id' => $inputArray['user_id'],
            'screen_id' => $inputArray['screen_id'],
            'permission_id' => $inputArray['permission_id'],
        ];
        $rows1 = DB::table('uam_user_screens')->where('user_id', $input['user_id'])->delete();

        DB::transaction(function() use($input) {

            // DB::table('uam_roles')
            // ->where('role_id', $input['role_id'])
            // ->update([
            //     'role_name' => $input['role_name'],
            //     'active_flag' => 0,
            //     'last_modified_by' => auth()->user()->id,
            //     'last_modified_date' => NOW()
            // ]);
//echo json_encode($input['permission_id']);exit;

            $screen_unique = array_unique($input['screen_id']);
            $unique = array_values($screen_unique);
            $screenidcount = count($unique);
            for ($i=0; $i < $screenidcount; $i++) { 
                $iparr = explode(":", $unique[$i]); 

                    $screen_id = $iparr[1];
                    $module_id = $iparr[0];
                    $screenrows =  DB::select("select * from uam_screens where screen_id = $screen_id");
                    $modulesrows =  DB::select("select * from uam_modules where module_id = $module_id");
                    $parent_module_id = $modulesrows[0]->parent_module_id;
                    $module_name = $modulesrows[0]->module_name;
                    $module_name = $modulesrows[0]->module_name;
                    $screen_name = $screenrows[0]->screen_name;
                    $screen_url = $screenrows[0]->screen_url;
                    $route_url = $screenrows[0]->route_url;
                    $class_name = $screenrows[0]->class_name;
                    $display_order = $screenrows[0]->display_order;

               $screen_permission_id = DB::table('uam_user_screens')->insertGetId([
                        'screen_id' => $screen_id,
                        'module_id' => $module_id,
                        'parent_module_id' => $parent_module_id,
                        'module_name'=> $module_name,
                        'screen_name'=> $screen_name,
                        'screen_url' => $screen_url,
                        'route_url' => $route_url,
                        'class_name' => $class_name,
                        'display_order' =>$display_order,
                        'user_id' => $input['user_id'],                                            
                        'active_flag' => 0,
                        'created_by' => auth()->user()->id,
                        'created_date' => NOW()
                    ]);

            }
            
           $permissioncount = count($input['permission_id']);
                for ($j=0; $j< $permissioncount; $j++) { 
                    $permission =  $input['permission_id'][$j];
                    $permissiondata = substr($permission,6);
                    $iparr = explode(":", $permissiondata); 
                    $user_id = $input['user_id'];
                    $module_id = $iparr[1];
                    $screen_id = $iparr[2];
                    $permission_id = $iparr[0];
                    $rows =  DB::select("select a.user_screen_id from uam_user_screens as a where a.module_id = $module_id and a.user_id = $user_id  and a.screen_id = $screen_id ");
                    $permissionrows =  DB::select("select a.permission,a.description,a.active_flag from uam_screen_permissions as a where a.screen_permission_id = $permission_id ");
                    $user_screen_id = $rows[0]->user_screen_id;
                    $permission_name = $permissionrows[0]->permission;
                    $description = $permissionrows[0]->description;
                    $active_flag = $permissionrows[0]->active_flag;
                    $role_screen_permissions_id = DB::table('uam_user_screen_permissions')->insertGetId([
                        'user_screen_id' =>  $user_screen_id,
                        'screen_permission_id' =>  $permission_id,  
                        'permission' => $permission_name,
                        'description' => $description,                                          
                        'active_flag' => $active_flag,
                        'created_by' => auth()->user()->id,
                        'created_date' => NOW()
                    ]);
                }
                $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
                    INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

            $role_name_fetch=$role_name[0]->role_name;
            $this->auditLog('uam_user', $input['user_id'] , 'Update', 'Update uam screen', auth()->user()->id, NOW(),$role_name_fetch);
        });
        return $this->sendResponse('Success', 'Uam user update successfully.');
    } catch(\Exception $exc){
        return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
}

public function data_edit($id)
{
    try{
        $method = 'Method => UamRolesController => data_edit';
        $id = $this->decryptData($id);
        $rows = DB::table('users')
        ->select('*')
        ->where('id', $id)
        ->get();
        return $this->sendDataResponse($rows);             
    }catch(\Exception $exc){
        return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
}
// public function data_delete($id)
// {
//     try{
//         $method = 'Method => UamRolesController => data_delete';
//         $id = $this->decryptData($id);
//         DB::transaction(function() use($id){
//            $uam_modules_id =  DB::table('uam_roles')
//            ->where('role_id', $id)
//            ->delete();                  
//        });
//         return $this->sendResponse('Success', 'Deleted successfully.');               
//     }catch(\Exception $exc){
//         return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
//     }
// }
}