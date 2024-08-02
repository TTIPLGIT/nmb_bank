<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Psy\Readline\Hoa\Console;
use Illuminate\Support\Facades\Redirect;

class firmadministrationController extends BaseController
{
    public function firm_admin_index(Request $request)
    {
        $user_id = $request->session()->get("userID");

        if ($user_id == null) {
            return view('auth.login');
        }
        $mobile = 0;
        if (isset($request->mobile)) {
            $mobile = 1;
        }
        $method = 'Method => firmadministrationControllerController => Admin_screen';
        $request =  array();
        $gatewayURL = config('setting.api_gateway_url') . '/firm_admin/screen';
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
        $response = json_decode($response);

        $objData = json_decode($this->decryptData($response->Data));

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
        if ($mobile == 1) {
            $mobile_response = [
                'data' => $rows
            ];
            return $mobile_response;
        }
        return view('firm_administration.firm_admin_index', compact('user_id', 'rows', 'menus', 'screens', 'modules'));
    }


    public function active_edit(Request $request)

    {
        $method = 'Method => firmadministrationController => active_update';
        $user_id = $request->session()->get("userID");

        if ($user_id == null) {
            return view('auth.login');
        }
        $mobile = 0;
        if (isset($request->mobile)) {
            $mobile = 1;
        }

        $data = array();
        $data['id'] = $request->id;
        $data['active_flag'] = $request->active_flag;
        $encryptArray = $this->encryptData($data);
        $request = array();
        $request['requestData'] = $encryptArray;

        $gatewayURL = config('setting.api_gateway_url') . '/firm/active_update';
        $response = $this->serviceRequest($gatewayURL, 'POST',  json_encode($request), $method);
        $response1 = json_decode($response);
        if ($response1->Status == 200 && $response1->Success) {
            $data = $this->decryptData($response1->Data);
            if ($mobile == 1) {
                $mobile_response = $data;

                return $mobile_response;
            }
            return  $data;
        }
    }



    public function Permission_edit(Request $request)

    {

        $method = 'Method => firmadministrationController => Permission_edit';
        $user_id = $request->session()->get("userID");

        if ($user_id == null) {
            return view('auth.login');
        }
        $data = array();
        $data['id'] = $request->id;
        $data['active_flag'] = $request->active_flag;
        $encryptArray = $this->encryptData($data);
        $request = array();
        $request['requestData'] = $encryptArray;

        $gatewayURL = config('setting.api_gateway_url') . '/firm/permission_update';
        $response = $this->serviceRequest($gatewayURL, 'POST',  json_encode($request), $method);
        $response1 = json_decode($response);
        if ($response1->Status == 200 && $response1->Success) {
            $data = $this->decryptData($response1->Data);
            return  $data;
        }
    }


    public function Permission_store(Request $request)

    {
        $method = 'Method => firmadministrationController => Permission_store';
        $user_id = $request->session()->get("userID");
        $mobile = 0;
        if (isset($request->mobile)) {
            $mobile = 1;
        }

        if ($user_id == null) {
            return view('auth.login');
        }
        $data = array();
        $data['firm_id'] = $request->firm_id;
        $data['partner_id'] = $request->partner_id;
        $data['delete_permission'] = $request->delete_permission ? $request->delete_permission : 'off';
        $data['give_permission'] = $request->give_permission ? $request->give_permission : 'off';
        $data['active_permission'] = $request->active_permission ? $request->active_permission : 'off';
        $encryptArray = $this->encryptData($data);
        $request = array();
        $request['requestData'] = $encryptArray;

        $gatewayURL = config('setting.api_gateway_url') . '/firm/permission_store';

        $response = $this->serviceRequest($gatewayURL, 'POST',  json_encode($request), $method);

        $response1 = json_decode($response);

        if ($response1->Status == 200 && $response1->Success) {
            $objData = json_decode($this->decryptData($response1->Data));
            if ($mobile == 1) {
                return ['status_code' => 200, 'message' => 'Permission Updated Successfully'];
            }
            return redirect(route('firm_admin_index'))->with('success', 'Permission Updated Successfully');
        } else {
            $objData = json_decode($this->decryptData($response1->Data));
            return view('errors.errors');
        }
    }


    public function firmadmin_fetch(Request $request)
    {

        try {

            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }

            $method = 'Method => firmadministrationController => firmadmin_fetch';
            // $user_id = $request->session()->get("userID");
            // if ($user_id == null) {
            //     return view('auth.login');
            // }
            $data['id'] = $request->id;
            $this->WriteFileLog($data);
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;


            $gatewayURL = config('setting.api_gateway_url') . '/firm_admin/fetch';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);

            $this->WriteFileLog($response);
            $response1 = json_decode($response);
            $objData = json_decode($this->decryptData($response1->Data));
            $rows = json_decode(json_encode($objData->Data), true);
            if ($mobile == 1) {
                $mobile_response = [
                    'data' => $rows
                ];
                return $mobile_response;
            }
            return $rows;
        } catch (\Exception $exc) {
            echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }



    public function firmadmin_leave(Request $request)
    {

        try {

            $method = 'Method => firmadministrationController => firmadmin_leave';
            // $user_id = $request->session()->get("userID");
            // if ($user_id == null) {
            //     return view('auth.login');
            // }
            // $data['id'] = $request->id;
            // $this->WriteFileLog($data);
            // $encryptArray = $this->encryptData($data);
            // $request = array();
            // $request['requestData'] = $encryptArray;


            $gatewayURL = config('setting.api_gateway_url') . '/firm_admin/leave';
            $response = $this->serviceRequest($gatewayURL, 'GET', "", $method);
            $this->WriteFileLog($response);
            $response1 = json_decode($response);
            $objData = json_decode($this->decryptData($response1->Data));
            $rows = json_decode(json_encode($objData->Data), true);
            return $rows;
        } catch (\Exception $exc) {
            echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
}
