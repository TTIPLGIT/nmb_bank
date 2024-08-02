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

class EducationMastersController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function educationcourse_index(Request $request)
    {
        try {
         
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => EducationMastersController => educationcourse_index';

            $request =  array();
          
            $request['user_id'] = $user_id;
                   

            $gatewayURL = config('setting.api_gateway_url') . '/education/course_index';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
            $response = json_decode($response);
            $objData = json_decode($this->decryptData($response->Data));
            $rows=json_decode(json_encode($objData->Data), true); 
            $menus = $this->FillMenu();
            if ($menus == "401") {
                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
            $screens = $menus['screens'];
            $modules = $menus['modules'];
        
            return view('educationcourse_masters.educationcourse_index', compact('rows','user_id', 'modules', 'menus', 'screens'));
        } catch (\Exception $exc) {


            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }


    public function educationcourse_store(Request $request)

    {

        try {

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => EducationMastersController => educationcourse_store';

            $data = array();
            $data['course_name'] = $request->Course_name;
            $data['user_id'] = $user_id;
            //dd($data);

            $encryptArray = $data;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/master/educationcourse_store';
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

            return redirect(route('educationcourse_index'))->with('success', 'Course Name Added Successfully');
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }

    public function educationcourse_edit (Request $request)
    {
     
            try {
                $method = 'Method => EducationMastersController => edit';
                $data = array();
                $data['id'] = $request->id;
                //dd($data);
    
                $encryptArray = $data;
                $encryptArray = $this->encryptData($data);
                $request = array();
                $request['requestData'] = $encryptArray;
                $gatewayURL = config('setting.api_gateway_url') . '/education/educationcourse_edit';
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

    public function educationcourse_update(Request $request)
    {

        try {

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => EducationMastersController => educationcourse_update';

            $data = array();
            $data['course_name'] = $request->edit_course;         
            $data['id'] = $request->id;
            $encryptArray = $data;

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/education/educationcourse_update';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            //dd($response);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                return redirect(route('educationcourse_index'))->with('success', 'Course Name Updated Successfully');
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function educationcourse_delete(Request $request)

    {
        try {
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => EducationMastersController => educationcourse_delete';
            $user_details = $request->user_details;


            $data['id'] = $request->id;
           
            $encryptArray = $data;
            $encryptArray = $this->encryptData($data);
        
            $request = array();
            $request['requestData'] = $encryptArray;
            


            $gatewayURL = config('setting.api_gateway_url') . '/education/education_delete';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    return redirect(route('educationcourse_index'))->with('success', 'Course Name Deleted Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('educationcourse_index'))->with('fail', 'Course Name Already Exists');
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
