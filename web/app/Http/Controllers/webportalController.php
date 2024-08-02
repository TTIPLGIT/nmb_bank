<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\course;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class webportalController extends BaseController
{


    // ****** Member Start // 


    public function member_list(Request $request)
    {

        $method = 'Method => webportalController => member_list';
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => webportalController => member_list';
        try {

            $request =  array();
            $gatewayURL = config('setting.api_gateway_url') . '/member/member_list';
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

            return view('elearning.admin.memberlist.memberlist', compact('user_id', 'menus', 'screens', 'modules','rows'));
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function memberlist_store(Request $request)
    {

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => webportalController => memberlist_store';
        try {

            $data = array();
            $data['name'] = $request->name;
            $data['type'] = $request->type;
            $data['mclass'] = $request->mclass;
            $data['chapter'] = $request->chapter;
            $data['isu_reg_number'] = $request->isu_reg_number;
            $data['qualification'] = $request->qualification;
            $data['address'] = $request->address;
            $data['email'] = $request->email;
            $data['phone'] = $request->phone;
            $data['location'] = $request->location;
            $data['gender'] = $request->gender;
            $encryptArray = $data;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/webportal/member/store';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $menus = $this->FillMenu();

            $screens = $menus['screens'];
            $modules = $menus['modules'];

            $response1 = json_decode($response);


            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    return redirect(route('member_list'))->with('success', 'Member List Created Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('member_list'))->with('fail', 'Member List Added Failed');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {
            //echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    
    public function member_delete(Request $request)

    {
        $method = 'Method => webportalController => member_delete';
        try {
            $this->WriteFileLog("fefeef");
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => webportalController => member_delete';
            $user_details = $request->user_details;


            $data['user_id'] = $user_id;
            $data['id'] = $request->id;
            $encryptArray = $data;
            $request = array();
            $request['requestData'] = $encryptArray;
            $this->WriteFileLog($request);

            $gatewayURL = config('setting.api_gateway_url') . '/member/member_delete';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    return redirect(route('member_list'))->with('success', 'Member Deleted Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('member_list'))->with('fail', 'Member Details Already Exists');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {
            //echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }


     }

     

    public function member_show($id)
    {
        //dd($class_id);
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Show') !== false) {
            try {
                $method = 'Method => webportalController => member_show';
                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/member/member_show/' . $this->encryptData($id);
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
                        return view('elearning.admin.member.memberlist', compact('user_id', 'rows', 'menus', 'screens', 'modules'));
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

    public function member_fetch(Request $request)
    {

        $this->WriteFileLog($request);
        try {
            $this->WriteFileLog("feef");
            $method = 'Method => webportalController => member_fetch';

            $data['id'] = $request->id;

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $this->WriteFileLog($data);
            $gatewayURL = config('setting.api_gateway_url') . '/member/member_fetch';
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

    
    public function member_edit($id)
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Edit') !== false) {
            try {
                $method = 'Method => webportalController => edit';
                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/member/member_edit' . $this->encryptData($id);
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
                        return view('elearning.memberlist', compact('rows', 'modules', 'screens'));
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
    public function member_update(Request $request, $id)
    {

        try {

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => webportalController => update';

            $data = array();

            $data['name'] = $request->nameedit;
            $data['type'] = $request->typeedit;
            $data['mclass'] = $request->classedit;
            $data['chapter'] = $request->chapteredit;
            $data['isu_reg_number'] = $request->isu_reg_numberedit;
            $data['qualification'] = $request->qualificationedit;
            $data['address'] = $request->addressedit;
            $data['email'] = $request->emailedit;
            $data['phone'] = $request->phoneedit;
            $data['location'] = $request->locationedit;
            $data['gender'] = $request->genderedit;

           
            $data['id'] = $request->id;
            $encryptArray = $data;

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/member/member_update';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            //dd($response);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                return redirect(route('member_list'))->with('success', 'Member Updated Successfully');
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function bulk_upload()
{
    try{ 
        $method = 'Method => webportalController => reset_token_expire_method'; 

        $menus = $this->FillMenu();
                $screens = $menus['screens'];
                $modules = $menus['modules'];
                
                return view('elearning.member.memberlist', compact('modules','screens','menu'));

       
    }
    catch(\Exception $exc){  
        echo $exc;          
        return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
}


public function memberbulk_store(Request $request)
{
// dd($request);
    $method = 'Method => webportalController => memberbulk_store';
    try {
        $jsonData = $request->jsonData;
        $jsonData = json_decode($jsonData);
// foreach($jsonData as $data){
//     dd($data);
// }
        $data = array();
        $data['jsonData'] = $jsonData;
        // $data['name'] = $request->name;
        // $data['type'] = $request->type;
        // $data['mclass'] = $request->mclass;
        // $data['chapter'] = $request->chapter;
        // $data['isu_reg_number'] = $request->isu_reg_number;
        // $data['qualification'] = $request->qualification;
        // $data['address'] = $request->address;
        // $data['email'] = $request->email;
        // $data['phone'] = $request->phone;
        // $data['location'] = $request->location;
        // $data['gender'] = $request->gender;

        $encryptArray = $data;
        $encryptArray = $this->encryptData($data);
        $request = array();
        $request['requestData'] = $encryptArray;

        $gatewayURL = config('setting.api_gateway_url') . '/webportal/member_bulk/store';

        $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

        $menus = $this->FillMenu();

        $screens = $menus['screens'];
        $modules = $menus['modules'];

        $response1 = json_decode($response);


        if ($response1->Status == 200 && $response1->Success) {
            $objData = json_decode($this->decryptData($response1->Data));


            if ($objData->Code == 200) {
                return redirect(route('member_list'))->with('success', 'Member List Created Successfully');
            }

            if ($objData->Code == 400) {
                return redirect(route('member_list'))->with('fail', 'Member List Added Failed');
            }
        } else {
            $objData = json_decode($this->decryptData($response1->Data));
            return view('errors.errors');
            exit;
        }
    } catch (\Exception $exc) {
        //echo $exc;
        return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
}

public function member_listDrupal(Request $request)
{

    $method = 'Method => webportalController => member_listDrupal';

    $user_id = $request->session()->get("userID");
    if ($user_id == null) {
        return view('auth.login');
    }
    $method = 'Method => webportalController => member_listDrupal';
    try {

        $request =  array();
        $gatewayURL = config('setting.api_gateway_url') . '/member/member_listDrupal';
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
        //dd($response);
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

        return view('elearning.admin.memberlist.memberlist', compact('user_id', 'menus', 'screens', 'modules','rows'));
    } catch (\Exception $exc) {

        return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
}

}
