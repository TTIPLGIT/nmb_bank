<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use DB;


class UamUserRolesController extends BaseController
{

 public function get_data()
 {
        //echo "naa";exit;
    try {
        $method = 'Method => UamUserRolesController => get_data';


        $rows = DB::select("select a.user_id,b.name,GROUP_CONCAT( c.role_name ) as 'rolename' from uam_user_roles as a inner join users as b on b.id = a.user_id inner join uam_roles as c on c.role_id = a.role_id GROUP BY a.user_id"); 

        

        return $this->sendDataResponse($rows);
    } catch(\Exception $exc){
        return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
}


public function get_user_data()
{
        //echo "naa";exit;
    try {
        $method = 'Method => UamUserRolesController => get_user_data';
        // $rows = DB::table('users')
        // ->select('*')
        // ->get();

        $rows= DB::table('users')
        ->whereNotIn('id', DB::table('uam_user_roles')->pluck('user_id'))
        ->get();


        return $this->sendDataResponse($rows);
    } catch(\Exception $exc){
        return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
}

public function get_roles_data()
{
        //echo "naa";exit;
    try {
        $method = 'Method => UamUserRolesController => get_roles_data';
        $rows = DB::table('uam_roles')
        ->select('*')
        ->get();
        return $this->sendDataResponse($rows);
    } catch(\Exception $exc){
        return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
}

public function getuserroles(Request $request)
{
        //echo "naa";exit;
    try {
        $method = 'Method => UamUserRolesController => getuserroles';
        
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



public function storedata(Request $request)
{

//return $request;

  try {
    $method = 'Method => UamUserRolesController => storedata';
    $inputArray = $this->decryptData($request->requestData);
    $input = [
        'user_id' => $inputArray['user_id'],
        'role_id' => $inputArray['role_id'],
        
    ];


    DB::transaction(function() use($input){
     $screenidcount = count($input['role_id']);
     for ($i=0; $i < $screenidcount; $i++) { 
        $uam_screen_id = DB::table('uam_user_roles')->insertGetId([
            'user_id' => $input['user_id'],
            'role_id' => $input['role_id'][$i],                                        
            'active_flag' => 0,
            'created_by' => auth()->user()->id,
            'created_date' => NOW()
        ]);
    };
    $screenidcount = count($input['role_id']);
    for ($i=0; $i < $screenidcount; $i++) { 
        $role_id = $input['role_id'][$i];
        $parentrow =  DB::select("select a.screen_id,a.module_screen_id,a.module_id from uam_role_screens as a where a.role_id = $role_id");
        $parentidcount = count($parentrow);

        for ($j=0; $j < $parentidcount; $j++) { 

            $module_id = $parentrow[$j]->module_id;
            $screen_id = $parentrow[$j]->screen_id;

            $modulesrows =  DB::select("select * from uam_modules where module_id = $module_id");

            $parent_module_id = $modulesrows[0]->parent_module_id;
            $module_name = $modulesrows[0]->module_name;

            $screenrows =  DB::select("select * from uam_screens where screen_id = $screen_id");

            $screen_name = $screenrows[0]->screen_name;
            $screen_url = $screenrows[0]->screen_url;
            $route_url = $screenrows[0]->route_url;
            $class_name = $screenrows[0]->class_name;
            $display_order = $screenrows[0]->display_order;

            $user_id = $input['user_id'];

            $check =DB::select("select * from uam_user_screens where module_id = $module_id and user_id = $user_id and screen_id = $screen_id ");
            $checkcount = count($check);



            if ($checkcount == '') {
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
                'user_id' => $user_id,                                            
                'active_flag' => 0,
                'created_by' => auth()->user()->id,
                'created_date' => NOW()
            ]);
         }else{

         }

     };
     
 };

 $user_id = $input['user_id'];

 $check =DB::select("select a.user_screen_id,a.screen_id,a.module_id from uam_user_screens as a where  a.user_id = $user_id ");

 $checkcount = count($check);

 for ($k = 0; $k < $checkcount; $k++) { 

   $screen_id = $check[$k]->screen_id;
   $user_screen_id = $check[$k]->user_screen_id;

   $permissioncheck =DB::select("select a.permission,a.screen_permission_id,a.description,a.active_flag from uam_screen_permissions as a where  a.screen_id = $screen_id ");

   $permissioncheckcount = count($permissioncheck);

   

   for ($m = 0; $m < $permissioncheckcount; $m++) { 

       $screen_permission_id = $permissioncheck[$m]->screen_permission_id;
       $permission_name = $permissioncheck[$m]->permission;
       $description = $permissioncheck[$m]->description;
       $active_flag = $permissioncheck[$m]->active_flag;

       $role_screen_permissions_id = DB::table('uam_user_screen_permissions')->insertGetId([
        'user_screen_id' =>  $user_screen_id,
        'screen_permission_id' =>  $screen_permission_id,  
        'permission' => $permission_name,
        'description' => $description,                                          
        'active_flag' => $active_flag,
        'created_by' => auth()->user()->id,
        'created_date' => NOW()
    ]);

   };

};
$role_name=DB::select("SELECT role_name FROM uam_roles AS ur
                    INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

    $role_name_fetch=$role_name[0]->role_name;

$this->auditLog('uam_user_roles', $uam_screen_id, 'Create', 'Create new uam role', auth()->user()->id, NOW(),$role_name_fetch);

});

    return $this->sendResponse('Success', 'Uam role create successfully.');

} catch(\Exception $exc){
    return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
}

}



public function updatedata(Request $request)
{




  try {
    $method = 'Method => UamUserRolesController => updatedata';
    $inputArray = $this->decryptData($request->requestData);
    $input = [
        'user_id' => $inputArray['user_id'],
        'role_id' => $inputArray['role_id'],
        'user_role_id' => $inputArray['user_role_id'],

    ];

    $rows1 = DB::table('uam_user_roles')->where('user_id', $input['user_id'])->delete();
    $rowdata = DB::table('uam_user_screens')->where('user_id', $input['user_id'])->delete();


    DB::transaction(function() use($input){

     $screenidcount = count($input['role_id']);

     for ($i=0; $i < $screenidcount; $i++) { 

        $uam_screen_id = DB::table('uam_user_roles')->insertGetId([
            'user_id' => $input['user_id'],
            'role_id' => $input['role_id'][$i],                                        
            'active_flag' => 0,
            'created_by' => auth()->user()->id,
            'created_date' => NOW()
        ]);
    };
    $screenidcount = count($input['role_id']);

    for ($i=0; $i < $screenidcount; $i++) { 

        $role_id = $input['role_id'][$i];

        $parentrow =  DB::select("select a.screen_id,a.module_screen_id,a.module_id from uam_role_screens as a where a.role_id = $role_id");

        $parentidcount = count($parentrow);


        for ($j=0; $j < $parentidcount; $j++) { 

            $module_id = $parentrow[$j]->module_id;
            $screen_id = $parentrow[$j]->screen_id;

            $modulesrows =  DB::select("select * from uam_modules where module_id = $module_id");

            $parent_module_id = $modulesrows[0]->parent_module_id;
            $module_name = $modulesrows[0]->module_name;

            $screenrows =  DB::select("select * from uam_screens where screen_id = $screen_id");

            $screen_name = $screenrows[0]->screen_name;
            $screen_url = $screenrows[0]->screen_url;
            $route_url = $screenrows[0]->route_url;
            $class_name = $screenrows[0]->class_name;
            $display_order = $screenrows[0]->display_order;

            $user_id = $input['user_id'];

            $check =DB::select("select * from uam_user_screens where module_id = $module_id and user_id = $user_id and screen_id = $screen_id ");
            $checkcount = count($check);



            if ($checkcount == '') {
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
                'user_id' => $user_id,                                            
                'active_flag' => 0,
                'created_by' => auth()->user()->id,
                'created_date' => NOW()
            ]);
         }else{

         }

     };
     
 };

 $user_id = $input['user_id'];

 $check =DB::select("select a.user_screen_id,a.screen_id,a.module_id from uam_user_screens as a where  a.user_id = $user_id ");

 $checkcount = count($check);

 for ($k = 0; $k < $checkcount; $k++) { 

   $screen_id = $check[$k]->screen_id;
   $user_screen_id = $check[$k]->user_screen_id;

   $permissioncheck =DB::select("select a.permission,a.screen_permission_id,a.description,a.active_flag from uam_screen_permissions as a where  a.screen_id = $screen_id ");

   $permissioncheckcount = count($permissioncheck);

   

   for ($m = 0; $m < $permissioncheckcount; $m++) { 

       $screen_permission_id = $permissioncheck[$m]->screen_permission_id;
       $permission_name = $permissioncheck[$m]->permission;
       $description = $permissioncheck[$m]->description;
       $active_flag = $permissioncheck[$m]->active_flag;

       $role_screen_permissions_id = DB::table('uam_user_screen_permissions')->insertGetId([
        'user_screen_id' =>  $user_screen_id,
        'screen_permission_id' =>  $screen_permission_id,  
        'permission' => $permission_name,
        'description' => $description,                                          
        'active_flag' => $active_flag,
        'created_by' => auth()->user()->id,
        'created_date' => NOW()
    ]);

   };

};
$role_name=DB::select("SELECT role_name FROM uam_roles AS ur
                    INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

    $role_name_fetch=$role_name[0]->role_name;

$this->auditLog('uam_user_roles', $uam_screen_id, 'Create', 'Create new uam role', auth()->user()->id, NOW(),$role_name_fetch);

});



    return $this->sendResponse('Success', 'Uam new user role update successfully.');

} catch(\Exception $exc){
    return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
}
}



public function data_edit($id)
{
    try{

        $method = 'Method => UamUserRolesController => data_edit';

        $id = $this->decryptData($id);

        // $rows = DB::table('uam_user_roles')
        // ->select('*')
        // ->where('user_role_id', $id)
        // ->get();

        $rows = DB::table('uam_user_roles as a')
        ->join('users as b', 'b.id', '=', 'a.user_id')
        //->join('uam_roles as c', 'c.role_id', '=', 'a.role_id')
        ->select('a.*','b.name','b.id')
        ->where('a.user_id', $id)
        ->get();


        return $this->sendDataResponse($rows);             

    }catch(\Exception $exc){
        return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
}




public function data_delete($id)
{
    try{

        $method = 'Method => UamUserRolesController => data_delete';

        $id = $this->decryptData($id);

        $user_screen_id = DB::select("select * from uam_user_screens where user_id = '$id'");

        $screenidcount = count($user_screen_id);


        for ($j=0; $j< $screenidcount; $j++) { 

           $uam_user_screen_permissions_id  =  $user_screen_id[$j]->user_screen_id;

           $delete_role_screen_id  = DB::table('uam_user_screen_permissions')->where('user_screen_id', $uam_user_screen_permissions_id)->delete();
           
       }



       DB::transaction(function() use($id){
         $uam_modules_id =  DB::table('uam_user_roles')
         ->where('user_id', $id)
         ->delete();                  
     });

       DB::transaction(function() use($id){
         $uam_user_screens =  DB::table('uam_user_screens')
         ->where('user_id', $id)
         ->delete();                  
     });

       DB::transaction(function() use($id){
         $users =  DB::table('users')
         ->where('id', $id)
         ->delete();                  
     });



       return $this->sendResponse('Success', 'Deleted successfully.');               

   }catch(\Exception $exc){
    return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
}
}





}
