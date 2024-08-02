<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use NunoMaduro\Collision\Contracts\Writer;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;

class governmentInstructionController extends BaseController
{
    public function index()
    {
        $method = 'Method => governmentInstructionController => index';
        try {
            $user_id = Auth::user()->id;

            $alter_name = $this->get_user_role();
            $rows['tableData'] = [];
            $rows['trakerData'] = [];
            $rows['instructionData'] = [];
            $rows['userTaskData'] = [];
            $this->WriteFileLog(config('setting.ROLE_NAME.professional_member'));
            if ($alter_name->alter_name == config('setting.ROLE_NAME.professional_member')) {
                $rows['tableData'] = DB::table('government_task_tracker as gt')
                    ->select('gt.government_task_id', 'gd.task_name', 'gd.stakeholder_id', 'gt.status as task_status', 'gt.Status')
                    ->join('government_task_details as gd', 'gd.id', '=', 'gt.government_task_id')
                    ->join('government_instruction_details as gid', 'gid.government_task_id', '=', 'gt.government_task_id')
                    ->groupBy('gid.government_task_id', 'gt.government_task_id', 'gd.task_name', 'gd.stakeholder_id', 'gt.status', 'gt.Status')
                    ->where('gt.user_id', $user_id)
                    ->get();
                $rows['trakerData'] = [];

                $rows['instructionData'] = DB::table('government_task_details as gd')
                    ->join('government_instruction_details as gid', 'gid.government_task_id', '=', 'gd.id')
                    ->where('gid.user_id', $user_id)
                    ->groupBy('gd.id', 'gid.government_task_id') // Add both columns to the GROUP BY
                    ->select(
                        'gd.id',
                        'gd.task_name',
                        'gid.government_task_id',
                        DB::raw('MAX(gid.status) as task_status'), // Use MAX for non-aggregated column
                        DB::raw('MAX(gid.updated_by) as assigned_by'), // Use MAX for non-aggregated column
                        DB::raw('MAX(gd.status) as status') // Use MAX for non-aggregated column
                    )
                    ->get();
            } else if ($alter_name->alter_name == config('setting.ROLE_NAME.governmentStakeHolder')) {
                $rows['tableData'] =  DB::table('government_task_tracker as gt')
                    ->select('gt.government_task_id', 'gd.task_name', 'gd.stakeholder_id', 'gt.status as task_status', 'gt.Status', 'gd.id', 'gd.created_at', 'gd.status')
                    ->join('government_task_details as gd', 'gd.id', '=', 'gt.government_task_id')
                    ->join('government_instruction_details as gid', 'gid.government_task_id', '=', 'gt.government_task_id')
                    ->groupBy('gid.government_task_id', 'gt.government_task_id', 'gd.task_name', 'gd.stakeholder_id', 'gt.status', 'gt.Status', 'gt.id', 'gd.created_at', 'gd.status')
                    ->where('gt.created_by', $user_id)
                    ->get();


                foreach ($rows['tableData'] as $key => $row) {
                    $rows['trakerData'][$row->id] = DB::table('government_task_tracker as gt')
                        ->join('users as u', 'u.id', '=', 'gt.user_id')
                        ->where('gt.government_task_id', $row->id)
                        ->get();
                }
                $userTaskData = DB::table('government_instruction_details as gid')
                    ->select('gid.government_task_id', 'u.name', 'u.role_designation')
                    ->where('gid.created_by', $user_id)
                    ->join('users as u', 'u.id', '=', 'gid.user_id')
                    ->groupBy('gid.government_task_id', 'u.name', 'u.role_designation')
                    ->get();

                $userTaskArray = [];
                foreach ($userTaskData as $key => $row) {
                    $userTaskArray[$row->government_task_id] = $row;
                }
                $rows['userTaskData'] = $userTaskArray;

                $rows['instructionData'] = [];
            }
            foreach ($rows['tableData'] as $key => $row) {
                $enID = $this->encryptData($rows['tableData'][$key]->government_task_id);
                $rows['tableData'][$key]->government_task_id_en = $enID;
            }

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
    public function appointment(Request $request)
    {
        $method = 'Method => governmentInstructionController => appointment';
        try {
            $user_id = Auth::user()->id;
            $id = $this->decryptData($request->requestData);
            $this->WriteFileLog(config('setting.DESIGNATION.principalGovernmentValuer'));
            $alter_name = $this->get_user_role();   
            if ($alter_name->alter_name == config('setting.ROLE_NAME.professional_member')) {
                $this->WriteFileLog('professionalmember');
                $instructionHeaders = DB::table('government_task_tracker as gt')
                    ->select('gd.task_name', 'gd.task_description', 'u.name', 'gt.Status')
                    ->selectRaw("(SELECT status from government_instruction_details where government_task_id = $id limit 1) as taskstatus")
                    ->join('government_task_details as gd', 'gd.id', '=', 'gt.government_task_id')
                    ->join('users as u', 'u.id', '=', 'gd.stakeholder_id')
                    ->where('gt.government_task_id', $id)
                    ->first();
            } else {
                $instructionHeaders = DB::table('government_task_tracker as gt')
                    ->select('gd.task_name', 'gd.task_description', 'u.name', 'gt.Status')
                    ->selectRaw("(SELECT status from government_instruction_details where government_task_id = $id limit 1) as taskstatus")
                    ->join('government_task_details as gd', 'gd.id', '=', 'gt.government_task_id')
                    ->join('users as u', 'u.id', '=', 'gd.stakeholder_id')
                    ->where('gt.government_task_id', $id)
                    ->where('gt.user_id', $user_id)
                    ->first();
            }
            // assigend to data
            $assignedInstruction = DB::table('government_task_tracker as gt')
                ->join('users as u', 'u.id', '=', 'gt.user_id')
                ->where('gt.created_by', $user_id)
                ->latest('gt.created_by')
                ->first();
            $comments = DB::table('government_task_tracker as gt')
                ->select('gt.comments')
                ->where('gt.government_task_id', $id)
                ->whereNotNull('gt.comments')
                ->get();


            $commentArrayNew = [];
            for ($i = 0; $i < count($comments); $i++) {
                foreach ($comments as $key => $comment) {
                    $commenetArray = json_decode(($comment->comments));
                    if (isset($commenetArray[$i])) {
                        array_push($commentArrayNew, $commenetArray[$i]);
                    }
                }
            }




            $instructionDetails = DB::table('government_instruction_details as gi')
                ->select('i.instruction_name', 'i.description', 'gi.status', 'gi.id', 'gi.file_name', 'gi.government_task_id')
                ->leftJoin('users as u', 'u.id', 'gi.user_id')
                ->join('instruction_masters as i', 'i.instruction_id', 'gi.instruction_id')
                ->where('gi.government_task_id', $id)
                ->get();

            $assignedToData = DB::table('government_task_tracker as gt')
                ->join('users as u', 'u.id', '=', 'gt.created_by')
                ->where([['gt.government_task_id', $id], ['gt.user_id', $user_id]])
                ->first();
            if ($assignedToData?->Status == 3) {
                $assignedTo['id'] = $assignedToData?->created_by;
                $assignedTo['name'] = $assignedToData?->name;
            } else {
                $assignedTo = [];
            }

            $assignedRoles = [];

            if ($alter_name->role_designation == config('setting.DESIGNATION.chiefGovernmentValuer')) {
                $assistantCommisioner = $this->GetUserOnDesignation(config('setting.DESIGNATION.assistantCommissioner'));
                $principalGovernmentValuer = $this->GetUserOnDesignation(config('setting.DESIGNATION.principalGovernmentValuer'));
                $assignedRoles = [
                    'Assistant commissioner' => $assistantCommisioner,
                    'Principal government valuer' => $principalGovernmentValuer
                ];
            } elseif ($alter_name->role_designation == config('setting.DESIGNATION.assistantCommissioner')) {
                $principalGovernmentValuer = $this->GetUserOnDesignation(config('setting.DESIGNATION.principalGovernmentValuer'));
                $assignedRoles = [
                    'Principal government valuer' => $principalGovernmentValuer
                ];
            } elseif ($alter_name->role_designation == config('setting.DESIGNATION.principalGovernmentValuer')) {
                $this->WriteFileLog('principalGovernmentValuer');
                $seniorGovernmentValuer = $this->GetUserOnDesignation(config('setting.DESIGNATION.seniorGovernmentValuer'));
                $assignedRoles = [
                    'Senior government valuer' => $seniorGovernmentValuer
                ];
            } elseif ($alter_name->role_designation == config('setting.DESIGNATION.seniorGovernmentValuer')) {
                $governmentValuer = DB::table('users as u')
                    ->select('u.id', 'u.name')
                    ->join('professional_member_licence as l', 'l.user_id', '=', 'u.id')
                    ->where('u.active_flag', '0')
                    ->where('l.valuer_type', 'Government Valuer')
                    ->where('u.role_designation', 'GV')
                    ->where('l.status', '0')
                    ->get();

                $assignedRoles = [
                    'government valuer' => $governmentValuer
                ];
                $assignedInstruction = DB::table('government_instruction_details as gd')
                    ->join('users as u', 'u.id', '=', 'gd.user_id')
                    ->where('gd.government_task_id', $id)
                    ->first();
            }

            $upwardRejectedData = DB::table('government_task_tracker as gt')
                ->where('gt.government_task_id', $id)
                ->where('gt.user_id', $user_id)
                ->get();
            $rows['rejectedAssignedData'] = [];

            $government_instruction_details = DB::table('government_instruction_details as gd')
                ->where('gd.government_task_id', $id)
                ->get();
            $this->WriteFileLog($id);
            if ($government_instruction_details[0]->status == 5) {
                $useRole = $this->get_user_role();


                if ($useRole->role_designation == "SGV") {
                    $gvData = DB::table('government_instruction_details')
                        ->where('government_instruction_details.id', $id)
                        ->select(['users.name', 'users.id'])
                        ->join('users', 'users.id', '=', 'government_instruction_details.user_id')
                        ->first();

                    $rows['rejectedAssignedData'] = $gvData;
                } else {
                    $trackerCount = DB::table('government_task_tracker as gt')
                        ->where('gt.government_task_id', $id)
                        ->get();
                    $nextid = 0;
                    for ($i = 0; $i < count($trackerCount); $i++) {
                        if ($trackerCount[$i]->user_id == $user_id) {
                            $nextid = $trackerCount[$i + 1]->user_id;
                            break;
                        }
                    }
                    $gvData = DB::table('users')
                        ->where('id', $nextid)
                        ->select(['users.name', 'users.id'])
                        ->first();
                    $rows['rejectedAssignedData'] = $gvData;
                }
            }

            $rows['instructionHeaders'] = $instructionHeaders;
            $rows['instructionDetails'] = $instructionDetails;
            $rows['assignedRoles'] = $assignedRoles;
            $rows['comments'] = $commentArrayNew;
            $rows['government_task_id'] = $id;
            $rows['assignedInstruction'] = $assignedInstruction;
            $rows['assignedTo'] = $assignedTo;

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
    public function storeAppointment(Request $request)
    {
        $method = 'Method => governmentInstructionController => storeAppointment';

        try {
            $userId = Auth::user()->id;
            $responseData = $this->decryptData($request->requestData);
            $governmentTaskId = $responseData['government_task_id'];
            $nextId  = $responseData['assignedTo'];
            $comment = $responseData['comments'];
            if ($comment != '') {
                $currentCommentArray = array(
                    "comments" => $responseData['comments'],
                    "givenBy" => $this->getusername($userId),
                    "respondedAt" => now()
                );
                $userName = $currentCommentArray["givenBy"];
                $oldComments = DB::table('government_task_tracker')
                    ->where('government_task_id', $governmentTaskId)
                    ->where('user_id', $userId)
                    ->value('comments');
                if (!is_null($oldComments)) {
                    $oldCommentsArray = json_decode($oldComments);
                    $CommentsArray = array_merge($oldCommentsArray, $currentCommentArray);
                    $comment = json_encode(array($CommentsArray));
                } else {
                    $comment = json_encode(array($currentCommentArray));
                }
            } else {
                $comment = DB::table('government_task_tracker')
                    ->where('government_task_id', $governmentTaskId)
                    ->where('user_id', $userId)
                    ->value('comments');
            }
            $nextUserRole = $this->GetUserOnDesignation($nextId);
            $currentStatus = DB::table('government_task_tracker')
                ->where('government_task_id', $governmentTaskId)
                ->where('user_id', ($userId))
                ->value('Status');
            $input = [
                'userId' => $userId,
                'comments' => $comment,
                'nextId' => $nextId,
                'governmentTaskId' => $governmentTaskId,
            ];
            $alter_name = $this->get_user_role();
            if ($alter_name->role_designation == config('setting.DESIGNATION.seniorGovernmentValuer')) {
                if ($currentStatus == 1) {
                    DB::transaction(function () use ($input, $userName, $nextUserRole) {
                        $government_task_tracker =  DB::table('government_task_tracker')
                            ->where([['user_id',  $input['userId']], ['government_task_id',  $input['governmentTaskId']]])
                            ->update([
                                'Status' => 2,
                                'comments' => $input['comments'],
                                'updated_at' => NOW(),
                                'updated_by' => $input['userId'],
                            ]);

                        $this->AuditLog('government_task_tracker', $government_task_tracker, 'Update', '', $input['userId'], Now(), 'Government Valuer');
                        $this->notifications_insert(null, $input['userId'], "Dear $userName, The Task has been appointed Successfully for Government Valuer.", 'instruction');
                        // mail
                        $government_task_details =  DB::table('government_instruction_details')
                            ->where([['government_task_id',  $input['governmentTaskId']]])
                            ->update([
                                'user_id' => $input['nextId'],
                                'updated_at' => NOW(),
                                'updated_by' => $input['userId'],
                            ]);
                        $this->AuditLog('government_task_tracker', $government_task_tracker, 'Update', '', $input['nextId'], Now(), 'Government Valuer');
                        $this->notifications_insert(null, $input['nextId'], "Dear $userName, The Task has been appointed to you by 'Government Valuer", 'instruction');
                        // mail

                    });
                    $serviceResponse = array();
                    $serviceResponse['Code'] = config('setting.status_code.success');
                    $serviceResponse['Message'] = config('setting.status_message.success');
                    $serviceResponse['Data'] = 1;
                    $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                    $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
                    return $sendServiceResponse;
                }
            }

            // 1 => Downward
            // 3 => Upward
            if ($currentStatus == 1) {
                DB::transaction(function () use ($input, $userName, $nextUserRole) {
                    $government_task_tracker =  DB::table('government_task_tracker')
                        ->where([['user_id',  $input['userId']], ['government_task_id',  $input['governmentTaskId']]])
                        ->update([
                            'Status' => 2,
                            'comments' => $input['comments'],
                            'updated_at' => NOW(),
                            'updated_by' => $input['userId'],
                        ]);
                    $roleName = $this->GetUserOnDesignation($input['userId']);

                    $this->AuditLog('government_task_tracker', $government_task_tracker, 'Update', '', $input['userId'], Now(), $roleName);
                    $this->notifications_insert(null, $input['userId'], "Dear $userName, The Task has been appointed Successfully for $nextUserRole.", 'instruction');
                    // mail

                    $nextTaskID = DB::table('government_task_tracker')->insertGetId([
                        'user_id' => $input['nextId'],
                        'government_task_id' => $input['governmentTaskId'],
                        'status' => '1',
                        'created_by' => auth()->user()->id,
                        'created_at' => NOW()
                    ]);

                    $roleName = $this->GetUserOnDesignation($input['userId']);

                    $this->AuditLog('government_task_tracker', $government_task_tracker, 'Update', '', $input['nextId'], Now(), $roleName);
                    $this->notifications_insert(null, $input['nextId'], "Dear $userName, The Task has been appointed to you by $roleName.", 'instruction');
                    // mail


                });

                
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
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }
    public function taskSubmission(Request $request)
    {
        $method = 'Method => governmentInstructionController => taskSubmission';

        try {
            $user_id = Auth::user()->id;
            $id = $this->decryptData($request->requestData);

            $rows['instructionHeaders'] = DB::table('government_task_details as gd')
                ->join('users as u', 'u.id', 'gd.stakeholder_id')
                ->where('gd.id', $id)
                ->first();

            $comments = DB::table('government_task_tracker as gt')
                ->select('gt.comments')
                ->where('gt.government_task_id', $id)
                ->whereNotNull('gt.comments')
                ->get();


            $commentArrayNew = [];
            for ($i = 0; $i < count($comments); $i++) {
                foreach ($comments as $key => $comment) {
                    $commenetArray = json_decode(($comment->comments));
                    if (isset($commenetArray[$i])) {
                        array_push($commentArrayNew, $commenetArray[$i]);
                    }
                }
            }

            $rows['instructionDetails'] = DB::table('government_instruction_details as gid')
                ->join('instruction_masters as i', 'i.instruction_id', '=', 'gid.instruction_id')
                ->where('gid.government_task_id', $id)
                ->get();
            $rows['comments'] = $commentArrayNew;


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
    public function getData(Request $request)
    {
        $method = 'Method => governmentInstructionController => appointment';
        try {
            $user_id = Auth::user()->id;
            $id = $this->decryptData($request->requestData);
            $rows['instructionData'] = DB::table('government_instruction_details as gid')
                ->join('instruction_masters as im', 'im.instruction_id', '=', 'gid.instruction_id')
                ->where('gid.id', $id)
                ->first();

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
    public function instructionStore(Request $request)
    {
        $method = 'Method => instructionStore => instructionStore';

        try {
            $user_id = Auth::user()->id;
            $input = $this->decryptData($request->requestData);
            // Save Process
            if ($input['taskIsSave'] == 1) {
                DB::transaction(function () use ($input, $user_id) {
                    $userName = $this->getusername($user_id);
                    if (isset($input['instructionFileName'])) {
                        $taskSubmission =  DB::table('government_instruction_details')
                            ->where([['user_id',  $user_id], ['id',  $input['instructionID']]])
                            ->update([
                                'status' => 0,
                                'file_name' => $input['instructionFileName'],
                                'file_path' => $input['instructionFilePath'],
                                'comments' => $input['instructionComments'],
                                'updated_at' => NOW(),
                                'updated_by' => $user_id,
                            ]);
                    } else {
                        $taskSubmission =  DB::table('government_instruction_details')
                            ->where([['user_id',  $user_id], ['id',  $input['instructionID']]])
                            ->update([
                                'status' => 0,
                                'comments' => $input['instructionComments'],
                                'updated_at' => NOW(),
                                'updated_by' => $user_id,
                            ]);
                    }

                    $this->AuditLog('government_instruction_details', $taskSubmission, 'Update', '', $user_id, Now(), 'Government Valuer');
                    $data = $this->notifications_insert(null, $user_id, "Dear $userName, The Task has been Saved Successfully.", 'instruction');
                });

                $message = "Instruction has been Saved Successfully";
                $serviceResponse = array();
                $serviceResponse['Code'] = config('setting.status_code.success');
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = 1;
                $serviceResponse['successMessage'] = $message;
                $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
                return $sendServiceResponse;
            }
            // Submit Process
            else {
                DB::transaction(function () use ($input, $user_id) {
                    $userName = $this->getusername($user_id);
                    $instructionDetail = DB::table('government_instruction_details')
                        ->where([['government_instruction_id', $input['instructionID']]])
                        ->update([
                            'status' => 3,
                            'updated_at' => NOW(),
                            'updated_by' => $user_id
                        ]);
                    $this->AuditLog('government_instruction_details', $instructionDetail, 'Update', '', $user_id, Now(), 'Government Valuer');
                    $this->notifications_insert(null, $user_id, "Dear $userName, The Task has been Submitted Successfully.", 'instruction');

                    $instructionTaskTrackerDetails = DB::table('government_task_tracker')
                        ->where([['government_task_id', $input['instructionID']]])->orderBy('id', 'asc')
                        ->last();

                    $instructionTaskTracker = DB::table('government_task_tracker')
                        ->where([['government_task_id', $instructionTaskTrackerDetails->id]])
                        ->update([
                            "Status" => 3,
                            "updated_at" => now()
                        ]);

                    $chiefGVId = $instructionTaskTrackerDetails->user_id;
                    $chiefGVName = $this->getusername($chiefGVId);
                    $this->AuditLog('government_instruction_details', $instructionDetail, 'Update', '', $chiefGVId, Now(), 'CGV');
                    $this->notifications_insert(null, $chiefGVId, "Dear $chiefGVName, The Task has been Submitted by $userName and waiting for your Approval.", 'instruction');
                });
                $message = "Instruction has been Submitted Successfully";

                $serviceResponse = array();
                $serviceResponse['Code'] = config('setting.status_code.success');
                $serviceResponse['Message'] = config('setting.status_message.success');
                $serviceResponse['Data'] = 1;
                $serviceResponse['successMessage'] = $message;
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
    public function instructionSubmit(Request $request)
    {
        $method = 'Method => governmentInstructionController => instructionSubmit';

        try {
            $this->WriteFileLog("api Hitted");
            $user_id = Auth::user()->id;
            $input = $this->DecryptData($request->requestData);
            DB::transaction(function () use ($input, $user_id) {

                $userName = $this->getusername($user_id);
                $instructionDetail = DB::table('government_instruction_details')
                    ->where([['government_task_id', $input['governmentTaskId']]])
                    ->update([
                        'status' => 2,
                        'updated_at' => NOW(),
                        'updated_by' => $user_id
                    ]);
                $this->AuditLog('government_instruction_details', $instructionDetail, 'Update', '', $user_id, Now(), 'Government Valuer');
                $this->notifications_insert(null, $user_id, "Dear $userName, The Task has been Submitted Successfully.", 'instruction');

                $instructionTaskTrackerDetails = DB::table('government_task_tracker')
                    ->where([['government_task_id', $input['governmentTaskId']]])
                    ->orderBy('id', 'desc')
                    ->first();

                $instructionTaskTracker = DB::table('government_task_tracker')
                    ->where([['id', $instructionTaskTrackerDetails->id]])
                    ->update([
                        "Status" => 3,
                        "updated_at" => now()
                    ]);

                $chiefGVId = $instructionTaskTrackerDetails->user_id;
                $chiefGVName = $this->getusername($chiefGVId);
                $this->AuditLog('government_instruction_details', $instructionDetail, 'Update', '', $chiefGVId, Now(), 'CGV');
                $this->notifications_insert(null, $chiefGVId, "Dear $chiefGVName, The Task has been Submitted by $userName and waiting for your Approval.", 'instruction');
            });
            $message = "Instruction has been Submitted Successfully";

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = 1;
            $serviceResponse['successMessage'] = $message;
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
    public function upwardapproval(Request $request)
    {
        $method = 'Method => governmentInstructionController => upwardapproval';

        try {
            $userID = Auth::user()->id;
            $input = $this->DecryptData($request->requestData);
            DB::transaction(function () use ($input, $userID) {
                $government_task_id = $input['government_task_id'];
                $comments = $input['comments'];
                $escalatedUserID = $input['assignedTo'];
                $taskTrackerRows = DB::table("government_task_tracker as gt")
                    ->where('gt.government_task_id', $government_task_id)
                    ->get();

                $limit = 0;
                foreach ($taskTrackerRows as $key => $row) {
                    if ($row->Status == 3) {
                        break;
                    } else {
                        $limit++;
                    }
                }
                $taskTracker = DB::table('government_task_tracker as gt')
                    ->where('gt.government_task_id', $government_task_id)
                    ->whereNotIn('gt.Status', [3])
                    ->limit($limit)
                    ->get();

                $taskTrackerLastArray = $taskTracker[count($taskTracker) - 1];
                $updateID = $taskTrackerLastArray->id;

                $government_task_tracker_current = DB::table('government_task_tracker')
                    ->where([['id',  $updateID]])
                    ->update([
                        'Status' => 3,
                        'updated_at' => NOW(),
                        'updated_by' => $userID,
                    ]);

                $userDesignation = $this->get_user_role();
                $userName = $this->getusername($userID);
                $escalatedUser = $this->getusername($escalatedUserID);
                $this->AuditLog('government_instruction_details', $government_task_tracker_current, 'Update', '', $userID, Now(), $userDesignation->role_designation);
                $this->notifications_insert(null, $userID, "Dear $userName, The Task has been Escalated to $escalatedUser.", 'instruction');
                $currentTaskTracker = DB::table('government_task_tracker')
                    ->where([['government_task_id', $government_task_id], ['user_id', $userID]])
                    ->first();
                $updateID = $currentTaskTracker->id;
                $previousComment = $currentTaskTracker->comments;
                $previousCommentArray = json_decode($previousComment);
                $currentCommentArray = array(
                    "comments" => $comments,
                    "givenBy" => $this->getusername($userID),
                    "respondedAt" => now()
                );
                $previousCommentArray[] = $currentCommentArray;
                $previousCommentJSON = json_encode($previousCommentArray);
                $government_task_tracker =  DB::table('government_task_tracker')
                    ->where([['id',  $updateID]])
                    ->update([
                        'Status' => 2,
                        'comments' => $previousCommentJSON,
                        'updated_at' => NOW(),
                        'updated_by' => $userID,
                    ]);
                $this->AuditLog('government_instruction_details', $government_task_tracker, 'Update', '', $userID, Now(), $userDesignation->role_designation);
                $this->notifications_insert(null, $escalatedUserID, "Dear $escalatedUser, The Task has been Allocated by $userName for the Approval.", 'instruction');
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
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }
    public function cgvApproval(Request $request)
    {
        $method = 'Method => governmentInstructionController => cgvApproval';
        try {
            $userID = Auth::user()->id;
            $input = $this->DecryptData($request->requestData);
            DB::transaction(function () use ($input, $userID) {
                $government_task_id = $input['government_task_id'];
                $comments = $input['comments'];
                $escalatedUserID = $input['assignedTo'];
                $status = $input['status'];
                if ($status == "approve") {
                    $currentTaskTracker = DB::table('government_task_tracker')
                        ->where([['government_task_id', $government_task_id], ['user_id', $userID]])
                        ->first();
                    $updateID = $currentTaskTracker->id;
                    $previousComment = $currentTaskTracker->comments;
                    $previousCommentArray = json_decode($previousComment);
                    $currentCommentArray = array(
                        "comments" => $comments,
                        "givenBy" => $this->getusername($userID),
                        "respondedAt" => now()
                    );
                    $previousCommentArray[] = $currentCommentArray;
                    $previousCommentJSON = json_encode($previousCommentArray);
                    $government_task_tracker =  DB::table('government_task_tracker')
                        ->where([['id',  $updateID]])
                        ->update([
                            'Status' => 2,
                            'comments' => $previousCommentJSON,
                            'updated_at' => NOW(),
                            'updated_by' => $userID,
                        ]);

                    $stakeHolderID = DB::table('government_task_details')
                        ->where([['id', $government_task_id]])
                        ->value('stakeholder_id');
                    $userDesignation = $this->get_user_role();
                    $userName = $this->getusername($userID);
                    $stakeHolderName = $this->getusername($stakeHolderID);
                    $this->AuditLog('government_instruction_details', $government_task_tracker, 'Update', '', $userID, Now(), $userDesignation->role_designation);
                    $this->notifications_insert(null, $userID, "Dear $userName, The Task has been Approved by you.", 'instruction');

                    $this->AuditLog('government_instruction_details', $government_task_tracker, 'Update', '', $userID, Now(), $userDesignation->role_designation);
                    $this->notifications_insert(null, $stakeHolderID, "Dear $stakeHolderName, The Task has been Approved by the CGV and waiting for your confirmation.", 'instruction');

                    $government_task_tracker =  DB::table('government_task_tracker')
                        ->where([['government_task_id', $government_task_id]])
                        ->update([
                            'Status' => 4,
                            'updated_at' => NOW(),
                            'updated_by' => $userID,
                        ]);

                    $notificationUsers = DB::table('government_task_tracker')
                        ->where([['government_task_id', $government_task_id]])
                        ->get();

                    foreach ($notificationUsers as $key => $row) {
                        if ($row->id == $userID) {
                            continue;
                        }
                        $userName = $this->getusername($row->user_id);
                        $this->AuditLog('government_instruction_details', $government_task_tracker, 'Update', '', $userID, Now(), $userDesignation->role_designation);
                        $this->notifications_insert(null, $row->user_id, "Dear $userName, The Task has been Approved.", 'instruction');
                    }
                    $government_task_tracker =  DB::table('government_task_details')
                        ->where([['id', $government_task_id]])
                        ->update([
                            'status' => 'Submitted',
                            'updated_at' => NOW(),
                            'updated_by' => $userID,
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
    public function stakeholderApproval(Request $request)
    {
        $method = 'Method=> governmentInstructionController => stakeholderApproval';
        try {
            $userID = Auth::user()->id;
            $input = $this->DecryptData($request->requestData);
            DB::transaction(function () use ($input, $userID) {
                $government_task_tracker = DB::table('government_task_details')
                    ->where('id', $input['government_task_id'])
                    ->update([
                        'status' => 'Approved'
                    ]);
                // $this->AuditLog('government_instruction_details', $government_task_tracker, 'Update', '', $userID, Now(), $userDesignation->role_designation);
                // $this->notifications_insert('', $row->user_id, `Dear $userName, The Task has been Completed.`, '/instruction');
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
