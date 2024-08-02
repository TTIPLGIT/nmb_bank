<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use DB;


class WorkFlowTaskController extends BaseController
{





    public function my_work_flow_task(Request $request)
    {
      try {
        $method = 'Method => WorkFlowTaskController => my_work_flow_task';
        $inputArray = $this->decryptData($request->requestData);

        $input = [
            'login_user_id' => $inputArray['login_user_id'],
        ];

        $user_id = $input['login_user_id'];



        // $rows = DB::select("select uam_screens.screen_name,work_flow_level.work_flow_level_name,work_flow_level.work_flow_id,work_flow_level.stage_id,work_flow_level.work_flow_level_id,task_details_status.task_name
        //     from 
        //     uam_screens inner join work_flow_level on work_flow_level.work_flow_id = uam_screens.work_flow_org_id
        //     inner join work_flow_level_user  on work_flow_level_user.work_flow_level_id = work_flow_level.work_flow_level_id 
        //     inner join task_details_status on task_details_status.work_flow_id = uam_screens.work_flow_org_id 
        //     where work_flow_level_user.user_id = '$user_id' GROUP BY uam_screens.screen_name,work_flow_level.work_flow_level_name,work_flow_level.work_flow_id,work_flow_level.stage_id,work_flow_level.work_flow_level_id,task_details_status.task_name");

     $rows = DB::select("select e.task_name  ,c.work_flow_level_name,a.work_flow_id from uam_screens a 
inner join work_flow b on b.work_flow_id = a.work_flow_id
inner join work_flow_level c on c.work_flow_id = a.work_flow_id
inner join work_flow_level_user d on d.work_flow_level_id = c.work_flow_level_id
inner join document_receipt e on e.work_flow_id = a.work_flow_id
inner join document_receipt_work_flow f on e.document_receipt_id = e.document_receipt_id
where d.user_id = '$user_id' GROUP BY a.work_flow_id,e.task_name,c.work_flow_level_name");


        



        return $rows;

    } catch(\Exception $exc){
        return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }

}



public function task_details_get(Request $request) 
{
  try {
    $method = 'Method => WorkFlowTaskController => task_details_get';
    $inputArray = $this->decryptData($request->requestData);

    $input = [
        'login_user_id' => $inputArray['login_user_id'],
        'work_flow_id' => $inputArray['work_flow_id'],
    ];

    $login_id = $input['login_user_id'];
    $work_flow_id = $input['work_flow_id'];

    $rows = DB::select("select b.level_id,a.screen_id,a.screen_name,b.work_flow_level_id,b.work_flow_level_name,a.work_flow_org_id,c.user_id from uam_screens as a  inner join work_flow_level as b on a.work_flow_org_id = b.work_flow_id inner join work_flow_level_user as c on c.work_flow_level_id = b.work_flow_level_id where a.work_flow_org_id = '$work_flow_id' and c.user_id = '$login_id'");

    $screen_id = $rows[0]->screen_id;

    $screen_permissions = DB::select("select  * from uam_user_screens where screen_id = '$screen_id' and user_id = '$login_id' ");   

    $user_screen_id = $screen_permissions[0]->user_screen_id;

    $uam_screen_permissions = DB::select("select  * from uam_user_screen_permissions where user_screen_id = '$user_screen_id'  ");   


    $task_details = DB::select("select  * from task_details_status as a where work_flow_id = '$work_flow_id' and user_id = '$login_id' ");


    $notes_details = DB::select("select a.notes,b.name,c.work_flow_level_name from task_details_status as a inner join users as b on b.id = a.user_id inner join work_flow_level  as c on c.work_flow_level_id = a.work_flow_level_id where a.work_flow_id = '$work_flow_id' ORDER BY c.work_flow_level_name ASC ");


    $last = DB::select("SELECT * FROM task_details_status  where work_flow_id = '$work_flow_id' ORDER BY task_details_status_id DESC LIMIT 1  ");




// $users = DB::table("work_flow_level_user as a")->select('a.*')
//             ->whereIn('a.user_id',function($query){
//                $query->select('b.user_id')->from('task_details_status as b');
//             })
//             ->get();

    $result=DB::table('work_flow_level_user as a')
    ->join('work_flow_level as c', 'c.work_flow_level_id', '=', 'a.work_flow_level_id')
    ->join('users as d', 'd.id', '=', 'a.user_id')
    ->where('c.work_flow_id', $work_flow_id)
    ->whereNotIn('a.user_id',function ($query) {
        $query->select('b.user_id')->from('task_details_status as b');

    })
    ->get();




    return $this->sendrowResponse($rows,$notes_details,$task_details,$last,$result,$uam_screen_permissions);

} catch(\Exception $exc){
    return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
}

}

public function task_details_save(Request $request)
{

  try {
    $method = 'Method => WorkFlowTaskController => task_details_save';
    $inputArray = $this->decryptData($request->requestData);
    $input = [
        'task_name' => $inputArray['task_name'],
        'work_flow_level_id' => $inputArray['work_flow_level_id'],
        'work_flow_id' => $inputArray['work_flow_id'],
        'level_id' => $inputArray['level_id'],
        'user_id' => $inputArray['user_id'],
        'notes' => $inputArray['notes'],
        'work_flow_status' => $inputArray['work_flow_status'],

    ];

    $level_id = $input['level_id'];

    $work_flow_id = $input['work_flow_id'];

    $work_flow_level_id  = DB::select("select * from work_flow_level a where work_flow_id = '$work_flow_id' ORDER BY level_id DESC LIMIT 1");


    $work_level_id  = $work_flow_level_id[0]->level_id;


  //   if ($level_id == $work_level_id) {

  //     DB::transaction(function() use($input) {
  //       DB::table('uam_screens')
  //       ->where('work_flow_org_id', $input['work_flow_id'])
  //       ->update([
  //           'active_flag' => 0,
  //           'last_modified_by' => auth()->user()->id,
  //           'last_modified_date' => NOW()
  //       ]);


  //   });
  // }



  DB::transaction(function() use($input) {
    $uam_modules_id = DB::table('task_details_status')
    ->insertGetId([
        'task_name' => $input['task_name'],
        'work_flow_level_id' => $input['work_flow_level_id'],
        'work_flow_id' => $input['work_flow_id'],
        'level_id' => $input['level_id'],
        'user_id' => $input['user_id'],
        'notes' => $input['notes'],
        'work_flow_status' => $input['work_flow_status'],
        'created_by' => auth()->user()->id,
    ]);
$role_name=DB::select("SELECT role_name FROM uam_roles AS ur
                    INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

    $role_name_fetch=$role_name[0]->role_name;
    $this->auditLog('task_details_status', $uam_modules_id, 'update', 'update my task details', auth()->user()->id, NOW(),$role_name_fetch);
});
  return $this->sendResponse('Success', 'Task details create successfully.');

} catch(\Exception $exc){
    return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
}
}




}
