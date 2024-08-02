<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Psy\Readline\Hoa\Console;
use Illuminate\Support\Facades\Redirect;

class FileuploadController extends BaseController
{
    
    public function fileupload_index(Request $request)
    {
        try {

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => FileuploadController => fileupload_index';

            $request =  array();

            $request['user_id'] = $user_id;


            $gatewayURL = config('setting.api_gateway_url') . '/fileupload/fileupload_index';
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

            return view('generaldetails_masters.fileuploadmasters_index', compact('rows', 'user_id', 'modules', 'menus', 'screens'));
        } catch (\Exception $exc) {


            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }


    public function fileupload_store(Request $request)
    
    {
        try {

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => FileuploadController => fileupload_store';

            $data = array();
            $data['file_type'] = $request->file_type;
            $data['file_size'] = $request->file_size;
            $data['user_id'] = $user_id;
            //dd($data);

            $encryptArray = $data;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/master/fileupload_store';
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

            return redirect(route('fileupload_index'))->with('success', 'File Details Stored Successfully');
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }
   
    public function fileupload_edit (Request $request)
    {
     
            try {
                $method = 'Method => FileuploadController => fileupload_edit';
                $data = array();
                $data['id'] = $request->id;
                //dd($data);
    
                $encryptArray = $data;
                $encryptArray = $this->encryptData($data);
                $request = array();
                $request['requestData'] = $encryptArray;
                $gatewayURL = config('setting.api_gateway_url') . '/master/fileupload_edit';
                $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
                $response = json_decode($response);
                if ($response->Status == 200 && $response->Success) {
                    $objData = json_decode($this->decryptData($response->Data));
                    if ($objData->Code == 200) {
                        $parant_data = json_decode(json_encode($objData->Data), true);
                        $rows =  $parant_data['rows'];
                        // $one_row =  $parant_data['one_rows'];
                        return $rows;
                    }
                } 
            } catch (\Exception $exc) {
                return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
            }
    }

    public function fileupload_update(Request $request)
    {

        try {

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => FileuploadController => fileupload_update';

            $data = array();
            $data['file_type'] = $request->file_type;         
            $data['file_size'] = $request->file_size;     
            $data['id'] = $request->id;
            $encryptArray = $data;

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/master/fileupload_update';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            //dd($response);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                return redirect(route('fileupload_index'))->with('success', 'File Details Updated Successfully');
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }






    
    public function fileupload_delete(Request $request)

    {
        try {
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => FileuploadController => fileupload_delete';
            $user_details = $request->user_details;

            $data['id'] = $request->id;
           
            $encryptArray = $data;
            $encryptArray = $this->encryptData($data);
        
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/master/fileupload_delete';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    return redirect(route('fileupload_index'))->with('success', 'file details Deleted Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('fileupload_index'))->with('fail', 'file details Already Exists');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {
            echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
      //
    }






}


