<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Attribute;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use League\CommonMark\Extension\Attributes\Node\Attributes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class generaldetailsMastersController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function gdmasters_index(Request $request)
    {
        try {

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => generaldetailsMastersController => gdmasters_index';

            $request =  array();

            $request['user_id'] = $user_id;


            $gatewayURL = config('setting.api_gateway_url') . '/generaldetails/gdmasters_index';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
            $response = json_decode($response);
            $objData = json_decode($this->decryptData($response->Data));
            $rows = json_decode(json_encode($objData->Data), true);
            $menus = $this->FillMenu();
            if ($menus == "401") {
                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
            $screens = $menus['screens'];
            $modules = $menus['modules'];

            return view('generaldetails_masters.gdmasters_index', compact('rows', 'user_id', 'modules', 'menus', 'screens'));
        } catch (\Exception $exc) {


            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }


    public function gdmastersdistrict_store(Request $request)

    {
        $method = 'Method => generaldetailsMastersController => gdmastersdistrict_store';
        try {

            $id = $request->session()->get("userID");
            if ($id == null) {
                return view('auth.login');
            }

            $data = array();
            $data['district_name'] = $request->district_name;
            $data['id'] = $id;

          
            $encryptArray = $data;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/master/gddistrict_store';
            $response = $this->serviceRequest($gatewayURL, 'POST',  json_encode($request), $method);
            $response = json_decode($response);

            $objData = json_decode($this->decryptData($response->Data));

            $code = $objData->Code;

            if ($code == "401") {

                return redirect()->route('unauthenticated')->send();
            }

            $menus = $this->FillMenu();

            if ($menus == "401") {
                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
            $screens = $menus['screens'];
            $modules = $menus['modules'];

            return redirect(route('gdmasters_index'))->with('success', 'District Name Added Successfully');
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }


    public function gdmastersconstituency_store(Request $request)

    {
        $method = 'Method => generaldetailsMastersController => gdmasters_store';
        try {

            $id = $request->session()->get("userID");
            if ($id == null) {
                return view('auth.login');
            }

            $data = array();
            $data['constituency_name'] = $request->constituency_name;
            $data['id'] = $id;
            $data['district_id'] = $request->district_id;


            $encryptArray = $data;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/master/gdconstituency_store';
            $response = $this->serviceRequest($gatewayURL, 'POST',  json_encode($request), $method);
            $response = json_decode($response);

            $objData = json_decode($this->decryptData($response->Data));

            $code = $objData->Code;

            if ($code == "401") {

                return redirect()->route('unauthenticated')->send();
            }

            $menus = $this->FillMenu();

            if ($menus == "401") {
                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
            $screens = $menus['screens'];
            $modules = $menus['modules'];

            return redirect(route('gdmasters_index'))->with('success', 'Constituency Added Successfully');
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }


    public function gdmastersvillage_store(Request $request)

    {
        $method = 'Method => generaldetailsMastersController => gdmastersvillage_store';
        try {

            $id = $request->session()->get("userID");
            if ($id == null) {
                return view('auth.login');
            }

            $data = array();
            $data['village_name'] = $request->village_name;
            $data['id'] = $id;
            $data['constituency'] = $request->constituency;

          
            $encryptArray = $data;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/master/gdvillage_store';
            $response = $this->serviceRequest($gatewayURL, 'POST',  json_encode($request), $method);
            $response = json_decode($response);

            $objData = json_decode($this->decryptData($response->Data));

            $code = $objData->Code;

            if ($code == "401") {

                return redirect()->route('unauthenticated')->send();
            }

            $menus = $this->FillMenu();

            if ($menus == "401") {
                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
            $screens = $menus['screens'];
            $modules = $menus['modules'];

            return redirect(route('gdmasters_index'))->with('success', 'village Name Added Successfully');
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }


    public function district_fetch(Request $request)
    {

        try {
            $method = 'Method => elearningEthnicTestController => fetch';
            // $user_id = $request->session()->get("userID");
            // if ($user_id == null) {
            //     return view('auth.login');
            // }
            $data['id'] = $request->id;
            $data['type'] = $request->type;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;


            $gatewayURL = config('setting.api_gateway_url') . '/district/fetch';
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

    public function district_update(Request $request)
    {

        try {

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => generaldetailsMastersController => district_update';

            $data = array();
            $data['district_name_edit'] = $request->district_name_edit;
            $data['eid'] = $request->eid;

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/district/update';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                return redirect(route('gdmasters_index'))->with('success', 'District  Updated Successfully');
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    public function district_delete(Request $request)
    {
        try {
            $this->WriteFileLog($request);
            $method = 'Method => generaldetailsMastersController => district_delete';
            // $user_id = $request->session()->get("userID");
            // if ($user_id == null) {
            //     return view('auth.login');
            // }
            $data['id'] = $request->id;
            $data['constituency_id'] = $request->constituency_id;
            // $data['village_id'] = $request->village_id;

            $data['tabletype'] = $request->tabletype;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;


            $gatewayURL = config('setting.api_gateway_url') . '/gt_district/delete';
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




public function constituency_fetch (Request $request)
{

    try {
        $method = 'Method => generaldetailsMastersController => constituency_fetch';
        // $user_id = $request->session()->get("userID");
        // if ($user_id == null) {
        //     return view('auth.login');
        // }
        $data['id'] = $request->id;
        $data['type'] = $request->type;
        $encryptArray = $this->encryptData($data);
        $request = array();
        $request['requestData'] = $encryptArray;


        $gatewayURL = config('setting.api_gateway_url') . '/constituency/fetch';
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

public function constituencydist_update(Request $request)
{

    try {

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => generaldetailsMastersController => district_update';

        $data = array();
        $data['district_name_edit'] = $request->district_name_edit;
        $data['eid'] = $request->eid;

        $encryptArray = $this->encryptData($data);
        $request = array();
        $request['requestData'] = $encryptArray;
        $gatewayURL = config('setting.api_gateway_url') . '/district/update';

        $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

        $response1 = json_decode($response);
        if ($response1->Status == 200 && $response1->Success) {
            return redirect(route('gdmasters_index'))->with('success', 'District  Updated Successfully');
        } else {
            $objData = json_decode($this->decryptData($response1->Data));
            return view('errors.errors');
            exit;
        }
    } catch (\Exception $exc) {
        return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
}







}