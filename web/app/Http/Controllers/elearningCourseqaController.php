<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Psy\Readline\Hoa\Console;
use Illuminate\Support\Facades\Redirect;
use App\Models\course;
use Illuminate\Support\Facades\Crypt;

class elearningCourseqaController extends BaseController
{
    public function index(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => elearningCourseqaController => index';
        try {
            $request =  array();
            $request['mlhud_id'] = $user_id;
            $gatewayURL = config('setting.api_gateway_url') . '/elearningadminqa';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
            $response = json_decode($response);
            //dd($response);

            $objData = json_decode($this->decryptData($response->Data));
            //dd($objData);
            $code = $objData->Code;

            if ($code == "401") {

                return redirect()->route('unauthenticated')->send();
            }
            $rows = json_decode(json_encode($objData->Data), true);

            $menus = $this->FillMenu();
            if ($menus == "401") {
                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            return view('elearningqaadmin.index', compact('user_id', 'rows', 'menus', 'screens', 'modules'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function question_delete(Request $request)
    {
        try {
            $this->WriteFileLog($request);
            $method = 'Method => elearningCourseqaController => question_delete';
            // $user_id = $request->session()->get("userID");
            // if ($user_id == null) {
            //     return view('auth.login');
            // }
            $data['question_id'] = $request->question_id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/adminqa/delete';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $this->WriteFileLog($response);
            $response1 = json_decode($response);
            $objData = json_decode($this->decryptData($response1->Data));
            $rows = json_decode(json_encode($objData->Data), true);
            return $rows;
        } catch (\Exception $exc) {
            //echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function fetch(Request $request)
    {

        $this->WriteFileLog($request);
        try {
            $this->WriteFileLog("feef");
            $method = 'Method => elearningCourseqaController => fetch';
            // $user_id = $request->session()->get("userID");
            // if ($user_id == null) {
            //     return view('auth.login');
            // }
            $data['question_id'] = $request->question_id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;

            $this->WriteFileLog($data);
            $gatewayURL = config('setting.api_gateway_url') . '/adminqa/fetch';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $this->WriteFileLog($response);
            $response1 = json_decode($response);
            $objData = json_decode($this->decryptData($response1->Data));
            $rows = json_decode(json_encode($objData->Data), true);
            return $rows;
        } catch (\Exception $exc) {
            //echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function show($id)
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Show') !== false) {
            try {
                $method = 'Method => elearningCourseqaController => show';
                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/adminqa/show' . $this->encryptData($id);
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
                $response = json_decode($response);
                if ($response->Status == 200 && $response->Success) {
                    $objData = json_decode($this->decryptData($response->Data));
                    if ($objData->Code == 200) {
                        $parant_data = json_decode(json_encode($objData->Data), true);
                        $rows =  $parant_data['rows'];
                        // $one_row =  $parant_data['one_rows'];
                        $menus = $this->FillMenu();
                        $screens = $menus['screens'];
                        $modules = $menus['modules'];
                        return view('elearningqaadmin.index', compact('rows', 'modules', 'screens'));
                    }
                } else {
                    $objData = json_decode($this->decryptData($response->Data));
                    return view('errors.errors');
                    exit;
                }
            } catch (\Exception $exc) {
                return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
            }
        } else {
            return redirect()->route('not_allow');
        }
    }
    public function reply_index(Request $request, $id)
    {
        //dd($request);
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => elearningCourseqaController => reply_index';
        try {
            $request =  array();
            $request['mlhud_id'] = $user_id;
            $request['question_id'] = $id;
            // $request['id'] = $id;

            //dd($request);
            $encryptArray = $this->encryptData($request);

            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/reply/index';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
            $response = json_decode($response);
            //dd($response);

            $objData = json_decode($this->decryptData($response->Data));
            //dd($objData);
            $code = $objData->Code;

            if ($code == "401") {

                return redirect()->route('unauthenticated')->send();
            }
            $rows = json_decode(json_encode($objData->Data), true);

            $menus = $this->FillMenu();
            if ($menus == "401") {
                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            return view('elearningqaadmin.replyindex', compact('user_id', 'rows', 'menus', 'screens', 'modules'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function reply_fetch(Request $request)
    {

        $this->WriteFileLog($request);
        try {
            $this->WriteFileLog("feef");
            $method = 'Method => elearningCourseqaController => reply_fetch';
            // $user_id = $request->session()->get("userID");
            // if ($user_id == null) {
            //     return view('auth.login');
            // }course_reply_id
            $data['question_id'] = $request->question_id;
            $data['id'] = $request->id;

            $data['type'] = $request->type;
            $this->WriteFileLog($data);
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;

          
            $gatewayURL = config('setting.api_gateway_url') . '/reply/fetch';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $this->WriteFileLog($response);
            $response1 = json_decode($response);    
            $objData = json_decode($this->decryptData($response1->Data));
            $rows = json_decode(json_encode($objData->Data), true);
            return $rows;
        } catch (\Exception $exc) {
            //echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function store(Request $request)
    {

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => elearningCourseqaController => store';
        try {
            $data = array();
            $data['question_id'] = $request->question_id;
            $data['course_id'] = $request->course_id;
            $data['course_reply_id'] = $request->course_reply_id;
            // $data['reply_details'] = $request->reply_details;
            $data['reply_details'] = $request->add_reply;


            $encryptArray = $this->encryptData($data);
            $request = array();

            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/reply/store';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    return redirect()->back()->with('success', 'Reply Added Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('adminquestion.reply_index'))->with('fail', 'Reply Not Added');
                }
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        // else {
        //     $objData = json_decode($this->decryptData($response1->Data));
        //     return view('errors.errors');
        //     exit;
        // }
    }
    public function reply_delete(Request $request)
    {
        try {
            $this->WriteFileLog($request);
            $method = 'Method => elearningCourseqaController => question_delete';
            // $user_id = $request->session()->get("userID");
            // if ($user_id == null) {
            //     return view('auth.login');
            // }
            $data['id'] = $request->id;
            
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/reply/delete';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $this->WriteFileLog($response);
            $response1 = json_decode($response);
            $objData = json_decode($this->decryptData($response1->Data));
            $rows = json_decode(json_encode($objData->Data), true);
            return $rows;
        } catch (\Exception $exc) {
            //echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
}
