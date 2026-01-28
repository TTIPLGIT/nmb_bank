<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AIController extends BaseController
{
    public function ai_course_list(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $menus = $this->FillMenu();

        if ($menus == "401") {
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        $method = "GET";
        $gatewayURL = config('setting.api_gateway_url') . '/ai/course_list';

        $response = json_decode($this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method));
        if ($response->Status == 200 && $response->Success) {
            $objData = json_decode($this->decryptData($response->Data));
            $parant_data = json_decode(json_encode($objData->Data), true);

            // dd($levels);
        }
        //    dd(json_decode($response->Data));
        // dd($levels);

        return view("AI.course_list", compact('screens', 'modules'));
    }

    public function ai_course_create(Request $request)
    {

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $user_id = $request->session()->get("userID");
        $method = 'Method => vbpfeedbackController => create';


        $gatewayURL = config('setting.api_gateway_url') . '/ai/ai_course_create';

        $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

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

                return view('AI.course_create', compact('rows','menus', 'screens', 'modules'));
            }
            if ($objData->Code == "401") {
                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
        }
    }
    public function ai_createcourse(Request $request)
    {
        $method = 'Method => AIController => ai_createcourse';

       
        try {
             $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
            $data = array();
            $data['category'] = $request->course_category_id;
            $data['role'] = $request->role;
            $data['designation'] = $request->designation_id;
            $data['course_name'] = $request->course_name;
            $data['course_description'] = $request->course_description;
            $data['course_type'] = $request->course_type;
            $data['class_count'] = $request->class_count;
            $data['course_duration'] = $request->class_count;


            $encryptArray = $this->encryptData($data);
            $request = array();

            $request['requestData'] = $encryptArray;

            $gatewayURL = 'http://20.164.0.23:3300/create-course/';

            $response = $this->AIserviceRequest($gatewayURL, 'POST', '', $method);
        dd($response);

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
    }


    public function adaptive_learning_list(Request $request)
    {
        $method = 'Method=> governmentInstructionController => taskSubmission';
        try {
            $user_id = $request->session()->get("userID");



            $gatewayURL = config('setting.api_gateway_url') . '/adaptive/learning/list';
            $response = json_decode($this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method));

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
                    return view('AI.adaptive_learning', compact('menus', 'screens', 'modules', 'rows'));
                }
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function adaptive_learning(Request $request)
    {


        $method = 'Method => AIController => adaptive_learning';
        try {
            $data = array();
            $data['user_id'] = $request->user_name;
            $data['course_id'] = $request->course_name;



            $encryptArray = $this->encryptData($data);
            $request = array();

            $request['requestData'] = $encryptArray;
            $gatewayURL = 'http://20.164.0.23:3300/adaptive/decide-from-db/' . $data['user_id'] . '/' . $data['course_id'];

            $response = $this->AIserviceRequest($gatewayURL, 'GET', '', $method);
            $response1 = json_decode($response, true);
            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            if (!$response1) {
                return "Invalid JSON response from API";
            }

            if ($response1['status'] == 'success') {

                return view('AI.adaptive_learning_result', array_merge(
                    ['data' => $response1],
                    compact('menus', 'screens', 'modules')
                ));
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function predictive_analysis(Request $request)
    {
        $method = 'Method=> AIController => taskSubmission';
        try {
            $user_id = $request->session()->get("userID");


            $gatewayURL = 'http://20.164.0.23:3300/ai/predictive-analysis/run';
            $response = $this->AIserviceRequest($gatewayURL, 'POST', '', $method);
dd($response);

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
                    return view('AI.predictive_analysis', compact('menus', 'screens', 'modules', 'rows'));
                }
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
}
