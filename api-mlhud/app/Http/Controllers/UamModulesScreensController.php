<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Validator;
use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Str;


class UamModulesScreensController extends BaseController
{

 public function getmodulesandscreens(Request $request)
 {
     
    try {
        $method = 'Method => UamModulesScreensController => getmodulesandscreens';

           $where_que=($request->dynamiclist=="dynamiclist")?"or 1=1 limit 1":"";

        // $modulesdata= DB::table('uam_modules')
        // ->whereNotIn('module_id', DB::table('uam_module_screens')->pluck('module_id'))
        // ->get();


        $modulesdata = DB::select("select * from uam_modules where not parent_module_id = 0 and active_flag = 0 ".$where_que); 


        $screensdata = DB::select("select a.screen_id,a.screen_name,GROUP_CONCAT( b.permission ) as 'permissions'  from uam_screens as a inner join uam_screen_permissions as b on b.screen_id = a.screen_id GROUP BY a.screen_id"); 


        $response = [
            'modulesdata' => $modulesdata,
            'screensdata' => $screensdata
        ];

        $serviceResponse = array();
        $serviceResponse['Code'] = config('setting.status_code.success');
        $serviceResponse['Message'] = config('setting.status_message.success');
        $serviceResponse['Data'] = $response;
        $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
        $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
        return $sendServiceResponse;


    } catch(\Exception $exc){
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

// public function getscreensname()
// {
//         //echo "naa";exit;
//     try {
//         $method = 'Method => UamModulesScreensController => getscreensname';

// $rows = DB::select("select a.screen_id,a.screen_name,GROUP_CONCAT( b.permission ) as 'permissions'  from uam_screens as a inner join uam_screen_permissions as b on b.screen_id = a.screen_id GROUP BY a.screen_id"); 


//         return $this->sendDataResponse($rows);
//     } catch(\Exception $exc){
//         return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
//     }
// }

public function get_data() 
{ 
    try {
        $method = 'Method => UamModulesScreensController => get_data';
        $rows = DB::select("select DISTINCT c.module_id,c.module_name,GROUP_CONCAT(b.screen_name) as 'screen_names',a.module_screen_id
           from uam_module_screens as a inner join uam_screens as b on b.screen_id = a.screen_id inner join uam_modules as c on c.module_id = a.module_id where a.active_flag = 0 GROUP BY a.module_screen_id "); 

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


    } catch(\Exception $exc){
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



public function get_modules_screen($id)
{
    //return $id;

    try {

        $method = 'Method => UamModulesScreensController => get_modules_screen';
        $id = $this->decryptData($id);
        

        $rows = DB::table('uam_module_screens as a')
        ->select('a.screen_id')
        ->where('a.module_id', $id)
        ->get();

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



    } catch(\Exception $exc){
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
    //return $request;
      try {
        $method = 'Method => UamModulesScreensController => storedata';
        $inputArray = $this->decryptData($request->requestData);
    
       // return $inputArray;
    
        $input = [
            'screen_id' => $inputArray['screen_id'],
            'module_id' => $inputArray['module_id'],
    
        ];
    
        $screenidcount = $inputArray['screen_id'];
    
    
        DB::transaction(function() use($input){
    
         $screenidcount = count($input['screen_id']);
    
         for ($i=0; $i < $screenidcount; $i++) { 
            $screen_permission_id = DB::table('uam_module_screens')->insertGetId([
                'screen_id' => $input['screen_id'][$i],
                'module_id' => $input['module_id'],                                               
                'active_flag' => 0,
                'created_by' => auth()->user()->id,
                'created_date' => NOW()
            ]);

            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'Module Screens Created',
                'notification_url' => 'uam_modules_screens',
                'megcontent' => "Module & Screens are Mapped created Successfully .",
                'alert_meg' => "Module & Screens are Mapped created Successfully .",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);




        }
         $role_name=DB::select("SELECT role_name FROM uam_roles AS ur  INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);   
         $role_name_fetch=$role_name[0]->role_name;   
        $this->auditLog('uam_modules_screens', $screen_permission_id, 'Create', 'create uam module screens', auth()->user()->id, NOW(),$role_name_fetch);
    });
    
    
    
        $serviceResponse = array();
        $serviceResponse['Code'] = config('setting.status_code.success');
        $serviceResponse['Message'] = config('setting.status_message.success');
        $serviceResponse['Data'] = 1;
        $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
        $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
        return $sendServiceResponse;
        
    
    
    } catch(\Exception $exc){
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
    





public function screen_data_get(Request $request)
{
    try {
        $method = 'Method => UamModulesScreensController => getmodulesandscreens';


         $inputArray = $this->decryptData($request->requestData);

   // return $inputArray;

    $input = [
       
        'module_id' => $inputArray['module_id'],

    ];
$module_id = $input['module_id'];



$rows =  DB::select("select `a`.`screen_id`, `a`.`screen_name`, GROUP_CONCAT(b.permission) AS permissions from `uam_screens` as `a` 
inner join `uam_screen_permissions` as `b` on `b`.`screen_id` = `a`.`screen_id`
where a.active_flag = 0 and  `a`.`screen_id` not in (select `c`.`screen_id` from `uam_module_screens` as `c` where (`c`.`module_id` = $module_id and `c`.`active_flag` = 0))  group by `a`.`screen_id`");


          






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


    } catch(\Exception $exc){
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

    ///return $request;

  try {
    $method = 'Method => UamModulesScreensController => updatedata';
    $inputArray = $this->decryptData($request->requestData);

    $input = [
        'screen_id' => $inputArray['screen_id'],
        'module_id' => $inputArray['module_id'],
    ];
// echo json_encode($input);exit;

    $screen_id = $inputArray['screen_id'];

    DB::transaction(function() use($input){
     $screenidcount = count($input['screen_id']);
     $rows1 = DB::table('uam_module_screens')->where('module_id', $input['module_id'])->delete();
     for ($i=0; $i < $screenidcount; $i++) { 

        $screen_permission_id = DB::table('uam_module_screens')->insertGetId([
            'module_id' => $input['module_id'],
            'screen_id' => $input['screen_id'][$i],                                             
            'active_flag' => 0,
            'created_by' => auth()->user()->id,
            'created_date' => NOW()
        ]);
    }

});



    $serviceResponse = array();
    $serviceResponse['Code'] = config('setting.status_code.success');
    $serviceResponse['Message'] = config('setting.status_message.success');
    $serviceResponse['Data'] = 1;
    $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
    $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
    return $sendServiceResponse;

} catch(\Exception $exc){
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

    //echo "sdfsdf";exit;
    
        try{
    
            $method = 'Method => UamModulesScreensController => data_edit';        
            $id = $this->decryptData($id);
    
            
    
    
    
            $rows = DB::select("select c.module_id,c.module_name from uam_module_screens as a inner join uam_modules as c on c.module_id = a.module_id where a.module_id = $id"); 
            
            
            // $screensdata = DB::select("select a.screen_id,a.screen_name,GROUP_CONCAT( b.permission ) as 'permissions'  from uam_screens as a inner join uam_screen_permissions as b on b.screen_id = a.screen_id GROUP BY a.screen_id"); 
    
            $screensdata =  DB::select("select `a`.`screen_id`, `a`.`screen_name`, GROUP_CONCAT(b.permission) AS permissions from `uam_screens` as `a` 
    inner join `uam_screen_permissions` as `b` on `b`.`screen_id` = `a`.`screen_id`
    where a.active_flag = 0 and  `a`.`screen_id`  in (select `c`.`screen_id` from `uam_module_screens` as `c` where (`c`.`module_id` = $id and `c`.`active_flag` = 0))  group by `a`.`screen_id`");
    
    
    
    
            $response = [
                'rows' => $rows,
                'screensdata' => $screensdata,
            ];
    
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $response;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;            
    
        }catch(\Exception $exc){
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
    try{

        $method = 'Method => UamModulesScreensController => data_delete';

        $id = $this->decryptData($id);

        $work_flow = DB::select("select * from uam_role_screens where module_screen_id = '$id'");

        if ($work_flow  == []) { 

            DB::transaction(function() use($id){
               $uam_modules_id =  DB::table('uam_module_screens')
               ->where('module_screen_id', $id)
               ->delete();                  
           });


           $notifications = DB::table('notifications')->insertGetId([
            'user_id' => auth()->user()->id,
            'notification_status' => 'Module Screens Deleted',
            'notification_url' => 'uam_modules_screens',
            'megcontent' => "Module & Screens are Mapped deleted Successfully .",
            'alert_meg' => "Module & Screens are Mapped deleted Successfully .",
            'created_by' => auth()->user()->id,
            'created_at' => NOW()
        ]);




            $role_name=DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);
             $role_name_fetch=$role_name[0]->role_name;
            $this->auditLog('uam_modules_screens', $id, 'Delete', 'Deleted the uam module screen', auth()->user()->id, NOW(),$role_name_fetch);

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = 1;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;     

        }

        else{
            $serviceResponse = array();
            $serviceResponse['Code'] = 400;
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = 1;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        }



    }catch(\Exception $exc){
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
