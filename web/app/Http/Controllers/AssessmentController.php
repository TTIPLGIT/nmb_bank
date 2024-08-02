<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class AssessmentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function professional(Request $request)
    {

        try {
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }
            $method = 'Method => UserregisterfeeController => create';
            $gatewayURL = config('setting.api_gateway_url') . '/Professional/Competence';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            // dd($gatewayURL);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $rows = json_decode(json_encode($objData->Data), true);
                    $rows3 = json_decode(json_encode($objData->Data2), true);
                    $rows4 = json_decode(json_encode($objData->Data3), true);
                    $rows5 = json_decode(json_encode($objData->Data4), true);
                    $this->WriteFileLog($rows);
                    if($mobile == 1){
                        if($rows4 === 0){
                            return ['status_code' => '400', 'message' => 'Ethic Test Not Completed'];
                        }
                        if($rows4 != 0){
                           return  [
                                'status_code' => '200',
                                'data' => $rows,
                                'UIData' => $rows5

                            ];
                        }
                    }
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    return view('assessment.create', compact('screens', 'modules', 'rows', 'rows3', 'rows4', 'rows5'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function critical_approve(Request $request)
    {
        $method = 'Method => UserregisterfeeController => critical_approve';
        try {
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }
            $gatewayURL = config('setting.api_gateway_url') . '/critical/criticalapprove';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            // dd($gatewayURL);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $rows = json_decode(json_encode($objData->Data), true);
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    if ($mobile == 1) {
                        $mobile_response = [
                            'data' => $rows
                        ];
                        return $mobile_response;
                    }

                    return view('assessment.critical_Approve', compact('screens', 'modules', 'rows'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function level($id,Request $request)
    {

        try {
            $method = 'Method => UserregisterfeeController => level';
            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }
            $data =  array();
            $data['route_url'] = $id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/level/Competence/' . $id;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', json_encode($request), $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $rows = json_decode(json_encode($objData->Data), true);
                    $rows2 = json_decode(json_encode($objData->Data2), true);
                    $rows3 = json_decode(json_encode($objData->Data3), true);
                    // $rows4 = json_decode(json_encode($objData->Data4), true);
                    

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    if ($mobile == 1) {
                        $mobile_response = [
                            'data' => $rows,
                            'data2' => $rows2,
                            'data3' => $rows3,
                            // 'UIData' => $rows4
                        ];
                        return $mobile_response;
                    }
                    return view('assessment.level', compact('screens', 'modules', 'rows', 'rows2', 'rows3'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function Critical_Report(Request $request)
    {

        try {
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }

            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }
            $method = 'Method => AssessmentController => critical_report';
            $gatewayURL = config('setting.api_gateway_url') . '/critical/report';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $rows = json_decode(json_encode($objData->Data), true);
                    $exist = json_decode(json_encode($objData->Data2), true);
                    if(count($rows) != 0){
                        $rows[0]['file_path'] = url('/uploads/critical/'.$rows[0]['user_id'].'/'.$rows[0]['file_name']);
                    }
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    if ($mobile == 1) {
                        $mobile_response = [
                            'data' => $rows,
                            'exist' => $exist
                        ];
                        return $mobile_response;
                    }
                    return view('assessment.critical_report', compact('screens', 'modules', 'rows', 'exist'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    public function level_store(Request $request)
    {

        try {
            $method = 'Method => AssessmentController => level_store';
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }
            $data['valuer_comments'] = $request->valuer_comments;
            $data['is_submitted'] = $request->is_submitted;
            $data['assessment_id'] = $request->assessment_id;
            $data['level'] = $request->level;
            $data['word_count'] = $request->word_count;
            $is_submitted = $request->is_submitted;



            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;


            $gatewayURL = config('setting.api_gateway_url') . '/level/store';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    if(($objData->Data)=="mandatory"){
                        $tab = "tab1";
                        
                    }
                    else if(($objData->Data)=="professional-core"){
                        $tab = "tab2";
                        
                    }
                    else{
                        $tab = "tab3";
                        
                }
                    if($is_submitted == "0"){
                    $message = "Competency Saved Successfully";
                  }else if($is_submitted == "1"){
                    
                    $message = "Competency Submitted Successfully";
                  }
                if($mobile ==1){
                    return ['status_code' => 200, 'message' => $message];
                }
                 
                return redirect(url('Professional/Competence?tab=' . $tab))->with('success', $message);
                }
                if ($objData->Code == 400) {
                    return Redirect::back()->with('fail', 'approved Name Already Exists');
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function interview_updatenew(Request $request)
    {
        try {

            $method = 'Method => AssessmentController => level_store';
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }

            $method = 'Method => LoginController => Register_screen';

            $data =  array();
            $data['user_id'] = $request['id'];
            $data['status'] = $request['status'];
            $data['comments'] = $request['comments'];
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/interview/updatenew';
            $response = $this->serviceRequest($gatewayURL, 'POST',  json_encode($request), $method);
            $response = json_decode($response);

            $objData = json_decode($this->decryptData($response->Data));
            $code = $objData->Code;

            if ($code == "401") {

                return redirect(url('/'))->with('danger', 'User session Exipired');
            }

            $rows = json_decode(json_encode($objData->Data), true);


            $menus = $this->FillMenu();
            if ($menus == "401") {
                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
            $screens = $menus['screens'];
            $modules = $menus['modules'];


            return redirect(route('professional'))->with('success', 'Competency Updated Suceessfully');
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function critical_store(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'fileUpload' => 'required|mimetypes:application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ]);
    
            if ($validator->fails()) {
                // Validation failed
                return redirect()->back()->with('error', 'Files should be document');
            }
            $method = 'Method => AssessmentController => critical_store';
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }


            if (isset($request->fileUpload) == true) {
                $storagepath_ursb_old = public_path() . '/uploads/critical/' . $user_id;
                $storagepath_ursb = '/uploads/URSB/' . $user_id;
                if (!File::exists($storagepath_ursb_old)) {
                    File::makeDirectory($storagepath_ursb_old);
                }
                $documentsb =  $request['fileUpload'];
                $files = $documentsb->getClientOriginalName();
                $findspace = array(' ', '&', "'", '"');
                $replacewith = array('-', '-');
                $proposal_files = str_replace($findspace, $replacewith, $files);
                $documentsb->move($storagepath_ursb_old, $proposal_files);
                $data['fileUpload'] = $proposal_files;
            }


            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;


            $gatewayURL = config('setting.api_gateway_url') . '/critical/store';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    return redirect(route('Critical_Report'))->with('success', 'Critical Analysis Submitted Sucessfully');
                }
                if ($objData->Code == 400) {
                    return Redirect::back()->with('fail', 'approved Name Already Exists');
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function approvegt(Request $request)
    {

        try {
            $method = 'Method => AssessmentController => critical_store';
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }
            $data =  array();
            $data['gt_id'] = $request->gt_id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/critical/approvegt';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    if($mobile ==1){
                        return ['status_code' => 200, 'message' => 'GT Critical Analysis Report is Approved successfully.Please Move to interview process Module to Proceed further'];
                    }
                    return redirect(route('final_assesment'))->with('success', 'GT Critical Analysis Report is Approved successfully.Please Move to interview process Module to Proceed further');
                }
                if ($objData->Code == 400) {
                    if($mobile ==1){
                        return ['status_code' => 400, 'message' => 'Approved Name Already Exists'];
                    }
                    return Redirect::back()->with('fail', 'Approved Name Already Exists');
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function interview_store(Request $request)
    {

        try {
            $method = 'Method => AssessmentController => critical_store';
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }

            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }

            $data =  array();
            $data['gt_id'] = $request->gt_id;
            $data['date'] = $request->date;
            $data['address'] = $request->address;

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/interview/store';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    if($mobile ==1){
                        return ['status_code' => 200, 'message' => 'Interview Scheduled Sucessfully'];
                    }
                    return redirect(route('interview_process'))->with('success', 'Interview Scheduled Sucessfully');
                }
                if ($objData->Code == 400) {
                    if($mobile ==1){
                        return ['status_code' => 400, 'message' => 'This GT does not have the Experience of 2 Years So, You cant able to Schedule a Interview For him'];
                    }
                    return Redirect::back()->with('error', 'This GT does not have the Experience of 2 Years So, You cant able to Schedule a Interview For him');
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function interview_update(Request $request)
    {

        try {
            $method = 'Method => AssessmentController => critical_store';
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }
            $data =  array();
            $data['gt_id'] = $request->gt_id_updated;
            $data['date'] = $request->date_updated;
            $data['address'] = $request->address_updated;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;


            $gatewayURL = config('setting.api_gateway_url') . '/interview/update';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    if($mobile ==1){
                        return ['status_code' => 200, 'message' => 'Interview Details Updated Sucessfully'];
                    }
                    return redirect(route('interview_process'))->with('success', 'Interview Details Updated Sucessfully');
                }
                if ($objData->Code == 400) {
                    if($mobile ==1){
                        return ['status_code' => 400, 'message' => 'Approved Name Already Exists'];
                    }
                    return Redirect::back()->with('fail', 'Approved Name Already Exists');
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }





    public function competency_fetch(Request $request)
    {

        try {
            $method = 'Method => AssessmentController => level_store';
            // $user_id = $request->session()->get("userID");
            // if ($user_id == null) {
            //     return view('auth.login');
            // }
            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }

            $data['Competency'] = $request->Competency;
            $data['category'] = $request->category;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/competency/fetch';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $response1 = json_decode($response);
            $objData = json_decode($this->decryptData($response1->Data));
            $rows = json_decode(json_encode($objData->Data), true);
            if($mobile ==1){
                
                return ['status_code' => 200, 'data' => $rows,];
            }
            return $rows;
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function interview_fetch(Request $request)
    {

        try {
            $method = 'Method => AssessmentController => interview_fetch';
            // $user_id = $request->session()->get("userID");
            // if ($user_id == null) {
            //     return view('auth.login');
            // }
            $data['id'] = $request->id;
            $data['type'] = $request->type;

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;


            $gatewayURL = config('setting.api_gateway_url') . '/interview/fetch';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $this->WriteFileLog($response);
            $response1 = json_decode($response);
            $objData = json_decode($this->decryptData($response1->Data));
            $rows = json_decode(json_encode($objData->Data), true);
            return $rows;
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function competency_store(Request $request)
    {


        try {
            $method = 'Method => AssessmentController => level_store';
            // $user_id = $request->session()->get("userID");
            // if ($user_id == null) {
            //     return view('auth.login');
            // }

            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }
            $data['Competency'] = $request->Competency;
            $data['category'] = $request->category;

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/competency/store';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $response1 = json_decode($response);

            // $objData = json_decode($this->decryptData($response1->Data));
            // $rows = json_decode(json_encode($objData->Data), true);
            if ($response1->Status == 200 && $response1->Success) {
                $data = $this->decryptData($response1->Data);
                if ($mobile == 1) {

                    return ["status_code" => 200, "data" => json_decode($data)];
                }
                return $data;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function critical_decision(Request $request)
    {

        try {
            $method = 'Method => AssessmentController => level_store';
            // $user_id = $request->session()->get("userID");
            // if ($user_id == null) {
            //     return view('auth.login');
            // }
            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }
            $data['id'] = $request->id;
            $data['comment'] = $request->comment;
            $data['status'] = $request->status;
            $this->WriteFileLog($data);
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;


            $gatewayURL = config('setting.api_gateway_url') . '/critial/decision';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $response1 = json_decode($response);
            $objData = json_decode($this->decryptData($response1->Data));
            $rows = json_decode(json_encode($objData->Data), true);
            if($mobile ==1){
                
                return ['status_code' => 200, 'data' => $rows];
            }
            return $rows;
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function final_assesment(Request $request)
    {

        try {
            $method = 'Method => AssessmentController => level_store';
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }

            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }

            $gatewayURL = config('setting.api_gateway_url') . '/final/assessment';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                $rows = json_decode(json_encode($objData->Data), true);

                $menus = $this->FillMenu();
                $screens = $menus['screens'];
                $modules = $menus['modules'];
                if ($objData->Code == 200) {
                    if($mobile ==1){
                
                        return ['status_code' => 200, 'data' => $rows, 'message' => 'Approved Successfully'];
                    }
                    return view('assessment.final_assesment', compact('rows', 'modules', 'screens'));
                }
                if ($objData->Code == 400) {
                    if($mobile ==1){
                
                        return ['status_code' => 400, 'data' => $rows, 'message' => 'Approved Name Already Exists'];
                    }
                    return Redirect::back()->with('fail', 'Approved Name Already Exists');
                }
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function interview_process(Request $request)
    {
       
        try {
            $method = 'Method => AssessmentController => level_store';
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }

            $gatewayURL = config('setting.api_gateway_url') . '/interview/process';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                $rows = json_decode(json_encode($objData->Data), true);
                $rows2 = json_decode(json_encode($objData->Data2), true);

                $menus = $this->FillMenu();
                $screens = $menus['screens'];
                $modules = $menus['modules'];
                if ($objData->Code == 200) {
                    if ($mobile == 1) {
                        
                        return ['status_code' => 200, 'data' => $rows, 'data2' => $rows2, 'message' => 'Approved Successfully'];
                    }
                    return view('interview.interview', compact('rows', 'modules', 'screens', 'rows2'));
                }
                if ($objData->Code == 400) {
                    if ($mobile == 1) {
                        
                        return ['status_code' => 200, 'message' => 'Approved Name Already Exists'];
                    }
                    return Redirect()->back()->with('fail', 'Approved Name Already Exists');           
                }
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    
    public function interview_show(Request $request)
    {
       
        try {
            $method = 'Method => AssessmentController => interview_show';
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }

            $gatewayURL = config('setting.api_gateway_url') . '/interview/process';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $interview_show = DB::select("SELECT interview.user_id,interview.status,interview.comments,interview.address,interview.scheduled_date,users.name FROM interview inner join users on users.id=interview.user_id where interview.status=1 and interview.user_id=$user_id");
            $json_result = json_encode($interview_show);
            $decoded_result = json_decode($json_result);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                // $interview_show = json_decode(json_encode($objData->Data2), true);

                $menus = $this->FillMenu();
                $screens = $menus['screens'];
                $modules = $menus['modules'];
                if ($objData->Code == 200) {
                    
                    return view('interview.interview_show', compact('modules', 'screens','interview_show'));
                }
                if ($objData->Code == 400) {
                    
                    return Redirect()->back()->with('fail', 'Approved Name Already Exists');           
                }
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }




    public function final_approve(Request $request, $id)
    {

        try {
            $method = 'Method => AssessmentController => level_store';

            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }
            $data['id'] = $id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $baseurl = config('setting.base_url');
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/final/approve';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                $rows = json_decode(json_encode($objData->Data), true);

                $menus = $this->FillMenu();
                $screens = $menus['screens'];
                $modules = $menus['modules'];
                if ($objData->Code == 200) {
                    if ($mobile == 1) {
                        
                        return ['status_code' => 200, 'data' => $rows, 'message' => 'Approved Successfully'];
                    }
                    return view('assessment.final_approvement', compact('rows', 'modules', 'screens'));
                }
                if ($objData->Code == 400) {
                    if ($mobile == 1) {
                        return ['status_code' => 400, 'message' => 'Approved Name Already Exists'];
                    }
                    return Redirect::back()->with('fail', 'approved Name Already Exists');
                }
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function critical_analysis(Request $request)
    {

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => LoginController => Register_screen';

        $request =  array();
        $request['user_id'] = $user_id;

        $gatewayURL = config('setting.api_gateway_url') . '/critical/analysis';
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
        $response = json_decode($response);

        $objData = json_decode($this->decryptData($response->Data));
        $code = $objData->Code;

        if ($code == "401") {

            return redirect(url('/'))->with('danger', 'User session Exipired');
        }

        $rows = json_decode(json_encode($objData->Data), true);


        $menus = $this->FillMenu();
        if ($menus == "401") {
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];

        return view('assessment.critical_analysis', compact('user_id', 'rows', 'menus', 'screens', 'modules'));

        //
    }



    public function criticalfile_edit(Request $request)

    {
        $method = 'Method => AssessmentController => criticalfile_edit';
        $user_id = $request->session()->get("userID");
        $mobile = 0;
        if (isset($request->mobile)) {
            $mobile = 1;
        }
        $data = array();


        $storagepath_ursb_old = public_path() . '/uploads/critical/' . $user_id;
        if (!File::exists($storagepath_ursb_old)) {
            File::makeDirectory($storagepath_ursb_old);
        }
        $documentsb =  $request['fileUpload_name'];
        $files = $documentsb->getClientOriginalName();
        $findspace = array(' ', '&', "'", '"');
        $replacewith = array('-', '-');
        $proposal_files = str_replace($findspace, $replacewith, $files);
        $documentsb->move($storagepath_ursb_old, $proposal_files);
        $data['fileUpload_name'] = $proposal_files;


        $encryptArray = $this->encryptData($data);
        $request = array();
        $request['requestData'] = $encryptArray;

        $gatewayURL = config('setting.api_gateway_url') . '/critical/file_update';
        $response = $this->serviceRequest($gatewayURL, 'POST',  json_encode($request), $method);

        $response = json_decode($response);


        $objData = json_decode($this->decryptData($response->Data));

        $code = $objData->Code;

        if ($code == "401") {

            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $rows = json_decode(json_encode($objData->Data), true);

        return redirect(route('Critical_Report'))->with('success', 'Critical Report File Updated Successfully');
    }


    public function interview_delete(Request $request)
    {
        try {
            $this->WriteFileLog($request);
            $method = 'Method => generaldetailsMastersController => district_delete';

            $data['user_id'] = $request->user_id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;


            $gatewayURL = config('setting.api_gateway_url') . '/gt_interview/delete';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $this->WriteFileLog($response);
            $response1 = json_decode($response);
            $objData = json_decode($this->decryptData($response1->Data));
            $rows['data'] = json_decode(json_encode($objData->Data), true);
            $rows['message_cus'] = json_decode(json_encode($objData->response_message), true);
            return $rows;
        } catch (\Exception $exc) {
            echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    public function professional_show(Request $request)
    {

        try {
            $method = 'Method => AssessmentController => professional_show';
            $data['user_id'] = $request->user_id;
            $data['type'] = $request->type;
            $this->WriteFileLog($data);
            $this->WriteFileLog("hiindsjjjj");

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;


            $gatewayURL = config('setting.api_gateway_url') . '/professional_show';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $this->WriteFileLog($response);
            $response1 = json_decode($response);
            $objData = json_decode($this->decryptData($response1->Data));
            $rows = json_decode(json_encode($objData->Data), true);
            return $rows;
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }




    
}
