<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Psy\Readline\Hoa\Console;
use Illuminate\Support\Facades\Redirect;

class nrvController extends BaseController
{



  public function index(Request $request)
  {
    try {
      $user_id = $request->session()->get("userID");
      if ($user_id == null) {
        return view('auth.login');
      }
      $mobile=0;
      if(isset($request->mobile)){
        $mobile=1;
      }
      $method = 'Method => nrvController => Register_screen';
      $request =  array();
      $request['mlhud_id'] = $user_id;
      $gatewayURL = config('setting.api_gateway_url') . '/nrv/screen';
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
      if($mobile==1){
        return ['rows'=>$rows,
                'code'=>200];
      }

      return view('nrv_approval.nrv_approval_index', compact('user_id', 'rows', 'menus', 'screens', 'modules'));
    } catch (\Exception $exc) {
      if($mobile==1){
        return ['Message'=>"Something Went Wrong",
                'code'=>500];
      }
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request, $id)
  {
  }
  public function approve_screen(Request $request,$id)
  {
    $mobile = 0;
    if(isset($request->mobile)){
      $mobile = 1;
    }

    $method = 'Method => NRVController => Approve_screen';
    $data['id'] = $id;
    $encryptArray = $this->encryptData($data);
    $request = array();
    $request['requestData'] = $encryptArray;



    $gatewayURL = config('setting.api_gateway_url') . '/nrv/approve';
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
    if($mobile == 1){
      
      return ['rows'=>$rows,
              'code'=>200];
    }

    //     return view('valuers.index', compact('user_id','rows','menus','screens','modules'));
    return view('nrv_approval.nrv_approval', compact('menus', 'screens', 'modules', 'rows'));
  }



  public function approvescreen_update(Request $request)
  {


    try {
      $user_id = $request->session()->get("userID");

      $method = 'Method => nrvapproveController => update_data';
      $data = array();
      $mobile=0;
      if(isset($request->mobile)){
        $mobile=1;
      }
      $user_id = $request->session()->get("userID");
      $data['gt_id'] = $request->gt_id;
      $data['status'] = $request->status;
      if ($request->previous_comment == null) {
        $message = $request->messages;
      } else {
        $message = $request->previous_comment . '<br>' . $request->messages;
      }
      $data['messages'] = $message;
      $encryptArray = $this->encryptData($data);
      $request = array();
      $request['requestData'] = $encryptArray;
      $gatewayURL = config('setting.api_gateway_url') . '/approvescreen/update';
      $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

      $response1 = json_decode($response);
      if ($response1->Status == 200 && $response1->Success) {
        $objData = json_decode($this->decryptData($response1->Data));
        if ($objData->Code == 200) {
          if ($objData->Data == 1) {
            if($mobile==1){
              return ['code'=>200,
                      'Message'=>"Approved Successfully"];
            }
            return redirect(route('nrv_approval.index'))->with('success', 'approved successfully');
          } else {
            if($mobile==1){
              return ['code'=>200,
                      'Message'=>"Rejected Successfully"];
            }
            return redirect(route('nrv_approval.index'))->with('success', 'Rejected successfully');
          }
        }
        if ($objData->Code == 400) {
          return Redirect::back()->with('fail', 'approved Name Already Exists');
        }
      } else {
        if($mobile==1){
          return ['code'=>500,
                  'Message'=>"Something Went Wrong"];
        }
        $objData = json_decode($this->decryptData($response1->Data));
        echo json_encode($objData->Code);
        exit;
      }
    } catch (\Exception $exc) {
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }




  public function rejectupdate(Request $request)
  {

    try {
      $user_id = $request->session()->get("userID");

      $method = 'Method => nrvapproveController => update_data';
      $data = array();

      $user_id = $request->session()->get("userID");
      $data['gt_id'] = $request->gt_id;
      $data['user_id'] = $request->user_id;

      $encryptArray = $this->encryptData($data);
      $request = array();
      $request['requestData'] = $encryptArray;
      $gatewayURL = config('setting.api_gateway_url') . '/user_reject/updatedata';
      $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
      $this->WriteFileLog($response);
      $response1 = json_decode($response);
      return $response1;
    } catch (\Exception $exc) {
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }



  public function approvereject(Request $request)
  {


    try {
      $user_id = $request->session()->get("userID");

      $method = 'Method => nrvapproveController => update_data';
      $data = array();


      $data['gt_id'] = $request->user_id;



      $encryptArray = $this->encryptData($data);
      $request = array();
      $request['requestData'] = $encryptArray;
      $gatewayURL = config('setting.api_gateway_url') . '/user_approvereject';
      $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
      $response1 = json_decode($response);
      $objData = json_decode($this->decryptData($response1->Data));

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

      return redirect(route('Registration.index'))->with('success', 'Approvel Details Updated Successfully');
    } catch (\Exception $exc) {
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }

  public function rejecter(Request $request)
  {
    $this->WriteFileLog($request);

    try {
      $user_id = $request->session()->get("userID");

      $method = 'Method => gtapproveController => update_data';
      $data = array();

      $data['gt_id'] = $request->gt_id;



      $encryptArray = $this->encryptData($data);
      $request = array();
      $request['requestData'] = $encryptArray;
      $gatewayURL = config('setting.api_gateway_url') . '/user_rejecter';
      $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
      $response1 = json_decode($response);
      $objData = json_decode($this->decryptData($response1->Data));

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

      return redirect(route('Registration.index'))->with('success', 'Approvel Details Updated Successfully');
    } catch (\Exception $exc) {
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }
}
