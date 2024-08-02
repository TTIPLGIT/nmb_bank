<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class activeoperationController extends BaseController
{


    public function active_index(Request $request)
    {
       
        $from_date = "";
        $to_date = "";
        $user_id = $request->session()->get("userID");
        $process_type=" ";
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => LoginController => Register_screen';
        $request =  array();
        $request['user_id'] = $user_id;
        $gatewayURL = config('setting.api_gateway_url') . '/Activeoperation/login';
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
        $user_id=" ";  
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('activeoperation.index', compact('to_date', 'from_date', 'rows', 'menus', 'screens', 'modules','process_type', 'user_id'));
    }


    public function login_search(Request $request)
    {
        
       
        $logMethod = 'Method => activeoperationController => login_search';
        try {

            $user_id = $request->user_id;
            $from_date = $request->from_date;
            $to_date = $request->to_date;
            $process_type = $request->process_type;
            $uam_actions = $request->uam_actions;
            if (empty($user_id) && empty($from_date)  && empty($to_date)) {
                return redirect(url('activeoperation'))->with('error', 'No Input for Search');
            }
            $gatewayURL = config('setting.api_gateway_url') . '/Activeoperation/login';
            $data = array();
            $data['user_id'] = $user_id;
            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;
            $data['process_type'] =$process_type;
            $data['uam_actions'] =$uam_actions;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $logMethod);
            $response = json_decode($response);



            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $rows = json_decode(json_encode($objData->Data), true);
                        
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    $permission = $this->FillScreensByUser();
                    $screen_permission = $permission[0];
                    return view('activeoperation.index', compact('modules', 'screens', 'from_date', 'user_id', 'to_date', 'rows','process_type','uam_actions'));
                }
            }
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $logMethod;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
        }
    }
}
