<?php

namespace App\Http\Controllers;

use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Writer;
use Svg\Tag\Rect;
use BaconQrCode\Renderer\Image\Png;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use PDF;

class governmentInstructionController extends BaseController
{
    public function index(Request $request)
    {
        $method = 'Method => governmentInstructionController => index';
        try {
            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }
            $gatewayURL = config('setting.api_gateway_url') . '/instruction/index';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data;
                    $alter_name = $this->get_user_role();
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    $permission = $this->FillScreensByUser();
                    if ($mobile == 1) {
                        $mobile_response = [
                            'data' => $rows
                        ];
                        return $mobile_response;
                    }
                    return view('GovernmentInstruction.index', compact('rows', 'menus', 'screens', 'modules', 'alter_name', 'permission'));
                }
            } else {
                return view('errors.error');
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function compareComments($comment1, $comment2)
    {
        $time1 = strtotime($comment1["respondedAt"]);
        $time2 = strtotime($comment2["respondedAt"]);

        return $time1 - $time2;
    }
    public function appointment(Request $request, $id, $type)
    {
        try {
            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }
            $method = 'Method=> governmentInstructionController => appointment';
            $user_id = $request->session()->get("userID");
            $requestArray['requestData'] = $id;
            $decryptedID = $this->decryptData($id);
            $userRole = $this->get_user_role();
            $isValidRequest = DB::table('government_task_tracker')
                ->where('government_task_id', $decryptedID)
                ->where('user_id', $user_id)
                ->get()->all();
            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            if ($isValidRequest == [] && $userRole->alter_name != "gtstake") {
                return view('alert.notallowed', compact('menus', 'screens', 'modules'));
            }
            $response = $this->apiCall($method, 'Get', '/instruction/appointment', $requestArray);
            if ($response->Status == 200 && $response->Success) {

                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {

                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data;
                    $commentsCollection = collect($rows['comments']);
                    $sortedComments = $commentsCollection->sortBy(function ($comment) {
                        return strtotime($comment['respondedAt']);
                    })->all();
                    $rows['comments'] = $sortedComments;
                    $alter_name = $this->get_user_role();
                    if ($mobile == 1) {
                        $mobile_response = [
                            'data' => $rows,
                            'altername' =>$alter_name,
                            'user_role' =>$userRole,
                            'type' =>$type
                          ];
                          return $mobile_response;
                    }
                    // upward Flow
                    if (isset($rows['instructionHeaders']['Status']) && $rows['instructionHeaders']['Status'] == 3) {
                        return view('GovernmentInstruction.upwardApproval', compact('rows', 'menus', 'screens', 'modules', 'alter_name', 'type'));
                    }
                    // downwardFlow
                    else {
                        return view('GovernmentInstruction.downwardApproval', compact('rows', 'menus', 'screens', 'modules', 'alter_name', 'type'));
                    }
                }
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function storeAppointment(Request $request)
    {
        try {

           
            $method = 'Method=> governmentInstructionController => storeAppointment';
            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }
            $data['assignedTo'] = $request->assignedTo;
            $data['comments'] = $request->comments;
            $data['government_task_id'] = $request->government_task_id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $response = $this->apiCall($method, 'POST', '/instruction/storeAppointment', $request);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    if ($mobile == 1) {
                        return ['status_code' => '200', 'message' => 'Instruction Appointed Successfully'];
                      }
                    return redirect(route('instruction.index'))->with('success', 'Instruction Appointed Successfully');
                }
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function taskSubmission(Request $request, $id, $type)
    {
        $method = 'Method=> governmentInstructionController => taskSubmission';
        try {
            $requestArray['requestData'] = $id;
            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }
            dd('ji');
            $response = $this->apiCall($method, 'Get', '/instruction/tasksubmission', $requestArray);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data;
                    $alter_name = $this->get_user_role();
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    if ($mobile == 1) {
                        $mobile_response = [
                          'data' => $rows
                        ];
                        return $mobile_response;
                      }
                    return view('GovernmentInstruction.taskSubmission', compact('rows', 'menus', 'screens', 'modules', 'alter_name', 'type'));
                }
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function getData(Request $request)
    {
        $method = 'Method=> governmentInstructionController => getData';
        try {
            $requestArray['requestData'] = $this->encryptData($request->id);
            $response = $this->apiCall($method, 'Get', '/instruction/getData', $requestArray);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $rows = json_decode(json_encode($objData->Data), true);
                    return $rows;
                }
            } else {
                return 500;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function instructionStore(Request $request)
    {
        $method = 'Method=> governmentInstructionController => instructionStore';
        try {
            $user_id = $request->session()->get("userID");
            $taskID = $request->taskIdModal;
            $instructionID = $request->instructionId;

            $instructionComments = $request->instructionComments;
            $taskIsSave = $request->taskIsSave;

            // if file is there
            if (isset($request->instructionFileUpload)) {
                $storagePath = 'userdocuments/instruction/' . $user_id . '/' . $taskID . '/' . $instructionID;
                $sourceFile = public_path($storagePath);

                if (!Storage::exists($sourceFile)) {
                    Storage::makeDirectory($sourceFile);
                }

                $documentsf =  $request->instructionFileUpload;

                $fileName = $documentsf->getClientOriginalName();
                $filteredFileName = $this->documentNameFilter($fileName);
                $documentsf->move($sourceFile, $filteredFileName);
                $data['instructionFileName'] = $filteredFileName;
                $data['instructionFilePath'] = $storagePath;
            }

            $data['taskID'] = $taskID;
            $data['instructionID'] = $instructionID;
            $data['instructionComments'] = $instructionComments;

            $data['taskIsSave'] = $taskIsSave;


            $encryptArray = $this->encryptData($data);
            $input['requestData'] = $encryptArray;

            $response = $this->apiCall($method, 'POST', '/instruction/task/store', $input);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $message = $objData->successMessage;
                    return redirect()->back()->with('success', $message);
                }
            } else {
                return view('errors.errors');
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function instructionSubmit(Request $request)
    {
        $method = 'Method=> governmentInstructionController => instructionSubmit';
        try {
            $governmentTaskId = $request->governmentTaskId;

            $data['governmentTaskId'] = $governmentTaskId;

            $encryptArray = $this->encryptData($data);
            $input['requestData'] = $encryptArray;

            $response = $this->apiCall($method, 'Post', '/instruction/task/submit', $input);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $message = $objData->successMessage;
                    return response()->json(['message' => $message], 200);
                }
            } else {
                return response()->json(['errors' => 'Something Went Wrong'], 500);
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function upwardapproval(Request $request)
    {
        $method = 'Method=> governmentInstructionController => upwardapproval';

        try {
            $userID = $request->session()->get("userID");
            $government_task_id = $request->government_task_id;
            $assignedTo = $request->assignedTo;
            $comments = $request->comments;
            $status = $request->status;

            $data['government_task_id'] = $government_task_id;
            $data['assignedTo'] = $assignedTo;
            $data['comments'] = $comments;

            $encryptArray = $this->encryptData($data);
            $input['requestData'] = $encryptArray;
            $response = $this->apiCall($method, 'POST', '/instruction/upwardapproval', $input);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    return response()->json(['message' => "Task has been Escalated Successfully."], 200);
                }
            } else {
                return response()->json(['message' => 'Something Went Wrong'], 500);
            }
        } catch (\Exception $exc) {
            $this->WriteFileLog($exc);
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function cgvApproval(Request $request)
    {
        $method = 'Method=> governmentInstructionController => cgvApproval';
        try {
            $userID = $request->session()->get("userID");
            $government_task_id = $request->government_task_id;
            $assignedTo = $request->assignedTo;
            $comments = $request->comments;
            $status = $request->status;
            if ($status == 'approve') {
                $message = "Task has been Approved Successfully";
            }

            $data['government_task_id'] = $government_task_id;
            $data['assignedTo'] = $assignedTo;
            $data['comments'] = $comments;
            $data['status'] = $status;
            $encryptArray = $this->encryptData($data);
            $input['requestData'] = $encryptArray;

            $response = $this->apiCall($method, 'POST', '/instruction/cgvApproval', $input);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    return response()->json(['message' => $message], 200);
                }
            } else {
                return response()->json(['message' => 'Something Went Wrong'], 500);
            }
        } catch (\Exception $exc) {
            $this->WriteFileLog($exc);
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function stakeholderApproval(Request $request)
    {
        $method = 'Method=> governmentInstructionController => stakeholderApproval';
        try {
            $userID = $request->session()->get("userID");
            $government_task_id = $request->government_task_id;


            $renderer = new ImageRenderer(
                new RendererStyle(400),
                new SvgImageBackEnd()
            );
            $writer = new Writer($renderer);
            $url = config("setting.base_url") . '?exlink=instruction/appointment/' . Crypt::encrypt($government_task_id) . '/show';
            $storagePath = public_path() . '/userdocuments/qrcode/' . $government_task_id;
            if (!File::exists($storagePath)) {
                File::makeDirectory($storagePath);
            }
            $writer->writeFile($url, $storagePath . '/qrcode.svg');


            $data = [
                'government_task_id' => $government_task_id
            ];
            $pdf = PDF::loadView('instructionSample', $data);
            $filePath = public_path('/userdocuments/instructionReport/document_' . $government_task_id . '.pdf');
            $pdf->save($filePath);

            $data['government_task_id'] = $government_task_id;
            $encryptArray = $this->encryptData($data);
            $input['requestData'] = $encryptArray;

            $response = $this->apiCall($method, 'POST', '/instruction/stakeholderApproval', $input);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    return response()->json(['message' => "Task has been Accepted Successfully"], 200);
                }
            } else {
                return response()->json(['message' => 'Something Went Wrong'], 500);
            }
        } catch (\Exception $exc) {
            $this->WriteFileLog($exc);
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
}
