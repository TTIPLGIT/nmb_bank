<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;


class UamFaqController extends BaseController
{

//    public function get_data()
//    {
//         //echo "naa";exit;
//     try {
//         $method = 'Method => UamScreensController => get_data';
//         $rows = DB::table('uam_screens as a')
//         ->select('a.*')
//         ->get();
//         return $this->sendDataResponse($rows);
//     } catch(\Exception $exc){
//         return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
//     }
// }

 public function get_work_flow_user_data($id)
 {

    try {
     $id = $this->decryptData($id);

     $user_id  = auth()->user()->id;

     $method = 'Method => UamFaqController => get_work_flow_user_data';

     $rows = DB::table('work_flow')
     ->select('work_flow.work_flow_name','work_flow_level.work_flow_level_name','work_flow_level.work_flow_level_id','work_flow_level_user.user_id','work_flow_level.level_id')

     ->join('work_flow_level', 'work_flow_level.work_flow_id', '=', 'work_flow.work_flow_id')

     ->join('work_flow_level_user', 'work_flow_level_user.work_flow_level_id', '=', 'work_flow_level.work_flow_level_id')

     ->where([['work_flow.work_flow_id', '=', $id ],['work_flow_level.work_flow_level_name', '=', "Level 1"],['work_flow_level_user.user_id', '=', $user_id] ])

     ->get();

     return $this->sendDataResponse($rows);
 } catch(\Exception $exc){
    return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
}
}



public function get_uam_screen_data($id)
{


//echo "xgfdg";exit;

    try {

        $method = 'Method => UamScreensController => get_uam_screen_data';
        $id = $this->decryptData($id);
        $user_id = auth()->user()->id;


        $rows = DB::table('uam_screens')
        ->select('*')
        ->where('work_flow_org_id', $id)
        ->get();
// return $rows;
        $notes_data = DB::Select("select a.level_id,a.work_flow_status,b.name,a.notes,a.created_at from task_details_status a inner join users b on b.id = a.user_id where a.work_flow_id = '$id'");

        $uam_screen = DB::select("select screen_id from uam_screens where work_flow_org_id = '$id' ");

        $screen_id = $uam_screen[0]->screen_id;

       // return $screen_id;

        $screen_permissions = DB::select("select  * from uam_user_screens where screen_id = '$screen_id' and user_id = '$user_id' ");   

   // return $screen_permissions;

        $user_screen_id = $screen_permissions[0]->user_screen_id;

        $uam_screen_permissions = DB::select("select  * from uam_user_screen_permissions where 
            user_screen_id = '$user_screen_id'");


        $task_details = DB::select("select  * from task_details_status as a where work_flow_id = '$id' and user_id = '$user_id' ");

        $last = DB::select("SELECT * FROM task_details_status  where work_flow_id = '$id' ORDER BY task_details_status_id DESC LIMIT 1 ");

        $user_level = DB::select("select a.*,b.user_id,c.screen_url from  work_flow_level a inner join work_flow_level_user b on b.work_flow_level_id = a.work_flow_level_id inner join uam_screens c on c.work_flow_id = a.work_flow_id
            where a.work_flow_id = '$id' and b.user_id = '$user_id' ORDER BY b.work_flow_level_id ASC");

        $admin = "Admin";
        $next_process=DB::table('work_flow_level_user')
        ->join('users', 'users.id', '=', 'work_flow_level_user.user_id')
        ->join('work_flow_level', 'work_flow_level.work_flow_level_id', '=', 'work_flow_level_user.work_flow_level_id')
        ->where([['users.name','!=',$admin],['work_flow_level.work_flow_id','=',$id]])
        ->orderBy('work_flow_level.level_id', 'ASC')
        ->whereNotIn('work_flow_level_user.work_flow_level_id',function ($query) {
            $query->select('task_details_status.work_flow_level_id')->from('task_details_status');
            
        })
        ->get();

        return $this->sendWorkDataResponse($rows,$notes_data,$next_process,$uam_screen_permissions,$task_details,$last,$user_level);
    } catch(\Exception $exc){
        return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
}




public function storedata(Request $request)
{
  try {
    $method = 'Method => UamFaqController => storedata';
    $inputArray = $this->decryptData($request->requestData);

    $input = [
        'work_flow_id' => $inputArray['work_flow_id'],
        'work_flow_level_id' => $inputArray['work_flow_level_id'],
        'work_flow_level_name' => $inputArray['work_flow_level_name'],
        'work_flow_status' => $inputArray['work_flow_status'],
        'level_id' => $inputArray['level_id'],
        'notes' => $inputArray['notes'],
        'attachment' => $inputArray['attachment'],
    ];

    $data = [
     'work_flow_id' => $inputArray['work_flow_id'],
     'work_flow_level_id' => $inputArray['work_flow_level_id'],
     'work_flow_level_name' => $inputArray['work_flow_level_name'],
     'work_flow_status' => $inputArray['work_flow_status'],
     'level_id' => $inputArray['level_id'],
     'notes' => $inputArray['notes'],
 ];


 $id = $input['work_flow_id'];

 $uam_screens = DB::select("select * from uam_screens where work_flow_id = '$id' ");

        $screen_url = $uam_screens[0]->screen_url;

 $email_alert = DB::select("SELECT work_flow.work_flow_id, work_flow_level.work_flow_level_id,work_flow_level_user.user_id,users.name,users.email,users.id from work_flow
    inner join work_flow_level on work_flow_level.work_flow_id = work_flow.work_flow_id 
    inner join work_flow_level_user on work_flow_level_user.work_flow_level_id = work_flow_level.work_flow_level_id 
    inner join users on users.id = work_flow_level_user.user_id 
    where work_flow.work_flow_id = '$id' ");

 $screenidcount = count($email_alert);

 for ($i=0; $i < $screenidcount; $i++) { 

    $notifications = DB::table('notifications')->insertGetId([
        'user_id' => $email_alert[$i]->id,
        'notification_status' => 'Initiated',  
        'notification_type' => $screen_url, 
        'work_flow_id' => $id, 
        'notification_type_id' =>  $email_alert[$i]->work_flow_level_id,                                        
        'created_by' => auth()->user()->id,
        'created_at' => NOW()
    ]);


    Mail::to($email_alert[$i]->email)->send(new SendMail($data));

}




DB::transaction(function() use($input, $screen_url) {
    $task_details_status_id = DB::table('task_details_status')
    ->insertGetId([
        'work_flow_id' => $input['work_flow_id'],
        'notes' => $input['notes'],
        'user_id' => auth()->user()->id,
        'work_flow_level_id' => $input['work_flow_level_id'],
        'work_flow_status' =>$input['work_flow_status'],
        'level_id' =>$input['level_id'],
        'task_name' => $screen_url,
        'created_by' => auth()->user()->id,
        
    ]);


   // $this->auditLog('uam_screens', $uam_screen_id, 'Create', 'Create new uam screen', auth()->user()->id, NOW());



           // $this->auditLog('task_details_status', $task_details_status_id, 'Create', 'Create task_details_status_id', auth()->user()->id, NOW());
});






return $this->sendResponse('Success', 'Work Flow Initiated successfully.');

} catch(\Exception $exc){
    return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
}
}



// public function updatedata(Request $request)
// {
//   try {
//     $method = 'Method => UamScreensController => updatedata';
//     $inputArray = $this->decryptData($request->requestData);
//     $input = [
//         'screen_name' => $inputArray['screen_name'],
//         'screen_url' => $inputArray['screen_url'],
//         'class_name' => $inputArray['class_name'],
//         'display_order' => $inputArray['display_order'],
//         'screen_id' => $inputArray['screen_id'],
//         'screen_permission' => $inputArray['screen_permission'],

//     ];



//     $screenidcount = $inputArray['screen_permission'];


//     if ($screenidcount == "") {

//         DB::transaction(function() use($input) {
//             DB::table('uam_screens')
//             ->where('screen_id', $input['screen_id'])
//             ->update([
//                 'screen_name' => $input['screen_name'],
//                 'screen_url' => $input['screen_url'],
//                 'class_name' => $input['class_name'],
//                 'display_order' => $input['display_order'],
//                 'active_flag' => 0,
//                 'last_modified_by' => auth()->user()->id,
//                 'last_modified_date' => NOW()
//             ]);
// $rows = DB::table('uam_screen_permissions')->where('screen_id',  $input['screen_id'] )->delete();
//             $this->auditLog('uam_screens', $input['screen_id'] , 'Update', 'Update uam screen', auth()->user()->id, NOW());
//         });
//         return $this->sendResponse('Success', 'Uam module update successfully.');

//     }

//     else{

//      DB::transaction(function() use($input) {
//         DB::table('uam_screens')
//         ->where('screen_id', $input['screen_id'])
//         ->update([
//             'screen_name' => $input['screen_name'],
//             'screen_url' => $input['screen_url'],
//             'class_name' => $input['class_name'],
//             'display_order' => $input['display_order'],
//             'active_flag' => 0,
//             'last_modified_by' => auth()->user()->id,
//             'last_modified_date' => NOW()
//         ]);


//         DB::transaction(function() use($input){

//            $screenidcount = count($input['screen_permission']);

//            $screeniddata = $input['screen_permission'];

//            $rows1 = DB::table('uam_screen_permissions')->where('screen_id', $input['screen_id'])->delete();

//            for ($i=0; $i < $screenidcount; $i++) { 

//              $rows = DB::select("select at.permission from uam_screen_permissions as at where at.screen_id = '". $input['screen_id']."' and at.permission = '".$screeniddata[$i]."'"); 

//              if ($rows == null) {
//                 $screen_permission_id = DB::table('uam_screen_permissions')->insertGetId([
//                     'permission' => $input['screen_permission'][$i],
//                     'screen_id' => $input['screen_id'],                                               
//                     'active_flag' => 0,
//                     'created_by' => auth()->user()->id,
//                     'created_date' => NOW()
//                 ]);
//             }
//         }
//     });


//     });


//      return $this->sendResponse('Success', 'Uam screen update successfully.');


//  }




// } catch(\Exception $exc){
//     return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
// }

// }



// public function data_edit($id)
// {
//     try{

//         $method = 'Method => UamScreensController => data_edit';

//         $id = $this->decryptData($id);

//         $rows = DB::table('uam_screens as a')
//         ->select('a.*')
//         ->where('a.screen_id', $id)
//         ->get();

//         return $this->sendDataResponse($rows);             

//     }catch(\Exception $exc){
//         return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
//     }
// }




// public function data_delete($id)
// {
//     try{

//         $method = 'Method => UamScreensController => data_delete';

//         $id = $this->decryptData($id);


//         DB::transaction(function() use($id){
//            $uam_modules_id =  DB::table('uam_screens')
//            ->where('screen_id', $id)
//            ->delete();                  
//        });


//         return $this->sendResponse('Success', 'Deleted successfully.');               

//     }catch(\Exception $exc){
//         return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
//     }
// }





}
