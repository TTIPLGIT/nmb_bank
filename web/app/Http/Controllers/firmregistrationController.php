<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use DateTime;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\Document;




class firmregistrationController extends BaseController
{
  // public function index()
  // {
  //   return view('auth.login');
  // }

  public function index()
  {
    // echo "cjvh";exit;

    try {
      $method = 'Method => firmregistrationController => login_screen';

      $gatewayURL = config('setting.api_gateway_url') . '/login/background';
      $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
      $response = json_decode($response);

      if ($response->Status == 200 && $response->Success) {
        $objData = json_decode($this->decryptData($response->Data));
        if ($objData->Code == 200) {
          $parant_data = json_decode(json_encode($objData->Data), true);
          $rows =  $parant_data['rows'];
          // echo json_encode($rows);exit;
          // $one_row =  $parant_data['one_rows'];


          return view('auth.login', compact('rows'));
        }
      } else {
        $objData = json_decode($this->decryptData($response->Data));
      }
    } catch (\Exception $exc) {
      echo $exc;
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }

  public function firm()
  {
    $method = 'Method => firmregistrationController => Register_screen';

    $gatewayURL = config('setting.api_gateway_url') . '/firm_register/screen';
    $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

    return view('auth.firmregister');
  }
  // login 
  public function firmregisterstore(Request $request)
  {


    try {
      $method = 'Method => firmregistrationController => Register_screen';

      $mobile = 0;
      if (isset($request->mobile)) {
        $mobile = 1;
      }
      $data = array();
      $data['email'] = $request->email;
      $data['firmname'] = $request->firmname;
      $data['password'] = bcrypt($request->password);
      $data['password_confirmation'] = $request->password_confirmation;
      // $data['dor'] = $request->dor;
      // $data['isu_membership_number'] = $request->isu_membership_number;
      $encryptArray = $this->encryptData($data);
      $request = array();
      $request['requestData'] = $encryptArray;
      // dd($data);
      $gatewayURL = config('setting.api_gateway_url') . '/firmRegister/store';
      $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

      $response1 = json_decode($response);
      // dd($response);

      if ($response1->Status == 200 && $response1->Success) {
        $objData = json_decode($this->decryptData($response1->Data));
        // dd($objData);
        if ($objData->Code == 200) {

          if ($mobile == 1) {

            return ['code' => 200, 'Message' => "Guest Role Registered Successfully"];
          }
          return redirect(url('/'))->with('success', 'Guest Role Registered Successfully');
        }

        if ($objData->Code == 400) {
          if ($mobile == 1) {

            return ['code' => 400, 'Message' => "Email-Id Already Exists"];
          }
          return Redirect::back()->with('error', 'Email-Id Already Exists');
        }
      }
    } catch (\Exception $exc) {

      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
    //
  }





  // Firm Registration //

  public function firm_index(Request $request)

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

      $method = 'Method => firmregistrationController => firm_index';
      $request =  array();

      $request['mlhud_id'] = $user_id;
      $gatewayURL = config('setting.api_gateway_url') . '/firm/firm_index';
      $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
      $response = json_decode($response);
      // dd($response);
      $objData = json_decode($this->decryptData($response->Data));
      // dd($objData);




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

      return view('Firm_Registration.Registrationfirm_index', compact('menus', 'screens', 'modules', 'rows'));
    } catch (\Exception $exc) {

      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
    //
  }

  public function firm_reg(Request $request)

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

      $method = 'Method => firmregister => store';
      $data = array();
      $data['firm_name'] = $request->firm_name;
      $data['description'] = $request->description;
      $data['partner_name'] = $request->partner;
      $data['user_id'] = $user_id;
      $encryptArray = $data;
      $storagepath_ursb_old = public_path() . '/uploads/URSB/' . $user_id; //system_store_pdf
      $storagepath_ursb = '/uploads/URSB/' . $user_id; //database_location
      if (!File::exists($storagepath_ursb_old)) {
        File::makeDirectory($storagepath_ursb_old); //folder_creation_when_folder_doesn't_esist
      }
      $data['ursbp'] = $storagepath_ursb;
      $documentsb =  $request['ursb'];
      $files = $documentsb->getClientOriginalName();
      $findspace = array(' ', '&', "'", '"');
      $replacewith = array('-', '-');
      $proposal_files = str_replace($findspace, $replacewith, $files); //proper_file_name-database field
      $documentsb->move($storagepath_ursb_old, $proposal_files); //storing the file in the system
      $data['ursbn'] = $proposal_files;
      // $pdf = $request->file('ursb');


      // location_proof
      $storagepath_locationproof_old = public_path() . '/uploads/locationProof/' . $user_id;
      $storagepath_locationproof = '/uploads/locationProof/' . $user_id;
      if (!File::exists($storagepath_locationproof_old)) {
        File::makeDirectory($storagepath_locationproof_old);
      }
      $data['locationproofp'] = $storagepath_locationproof;
      $documentsb =  $request['locationproof'];
      $files = $documentsb->getClientOriginalName();
      $findspace = array(' ', '&', "'", '"');
      $replacewith = array('-', '-');
      $proposal_files = str_replace($findspace, $replacewith, $files);
      $documentsb->move($storagepath_locationproof_old, $proposal_files);
      $data['locationproofn'] = $proposal_files;
      $pdf = $request->file('locationproof');

      // practising certificate

      $storagepath_validpractising_old = public_path() . '/validcertifi/practisingcertificate/' . $user_id;
      $storagepath_validpractisingcertificate = '/validcertifi/practisingcertificate/' . $user_id;
      if (!File::exists($storagepath_validpractising_old)) {
        File::makeDirectory($storagepath_validpractising_old);
      }
      $documentsb =  $request['validpractisingcertificate'];
      $this->WriteFileLog($request['validpractisingcertificate']);
      $data['validpractisingcertificatep'] = $storagepath_validpractisingcertificate;
      $this->WriteFileLog($data['validpractisingcertificatep']);
      foreach ($documentsb as $key => $row) {
        $files = $row->getClientOriginalName();

        $findspace = array(' ', '&', "'", '"');
        $replacewith = array('-', '-');
        $proposal_files = str_replace($findspace, $replacewith, $files);
        $row->move($storagepath_validpractising_old, $proposal_files);
        $data['validpractisingcertificaten'][$key] = $proposal_files;
        $pdf = $request->file('validpractisingcertificate');
      }


      // Particulars Directors //


      $storagepath_particularsdirectors_old = public_path() . '/particulars/directors/' . $user_id;
      $storagepath_particularsdirectors = '/particulars/directors/' . $user_id;
      if (!File::exists($storagepath_particularsdirectors_old)) {
        File::makeDirectory($storagepath_particularsdirectors_old);
      }
      $documentsb =  $request['particularsdirectors'];
      $data['particularsdirectorsp'] = $storagepath_particularsdirectors;
      foreach ($documentsb as $key => $row) {
        $files = $row->getClientOriginalName();
        $findspace = array(' ', '&', "'", '"');
        $replacewith = array('-', '-');
        $proposal_files = str_replace($findspace, $replacewith, $files);
        $row->move($storagepath_particularsdirectors_old, $proposal_files);
        $data['particularsdirectorsn'][$key] = $proposal_files;

        $pdf = $request->file('particularsdirectors');
      }
      $encryptArray = $this->encryptData($data);

      $request = array();
      $request['requestData'] = $encryptArray;


      $gatewayURL = config('setting.api_gateway_url') . '/firm/firm_reg';
      $response = $this->serviceRequest($gatewayURL, 'POST',  json_encode($request), $method);
      $response = json_decode($response);
// dd($response);
      if ($response->Status == 200 && $response->Success) {
        $objData = json_decode($this->decryptData($response->Data));
        $code = $objData->Code;
        if ($objData->Code == 200) {
          $menus = $this->FillMenu();
          $screens = $menus['screens'];
          $modules = $menus['modules'];
          if ($mobile == 1) {
            return ['status_code' => '200', 'message' => 'Firm Registration Submitted Successfully'];
          }
          return redirect(route('firm_index'))->with('success', 'Firm Registration Submitted Successfully');
        }

        if ($code == "401") {

          return redirect()->route('unauthenticated')->send();
        }
      } else {
        // return ['status_code' => '400', 'message' => 'Something went wrong'];
        return view('errros.errors');
      }
    } catch (\Exception $exc) {

      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
    //
  }

  // firm approval

  public function firm_approval_index(Request $request)
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
      $method = 'Method => LoginController => Register_screen';
      $request =  array();
      $request['mlhud_id'] = $user_id;
      $gatewayURL = config('setting.api_gateway_url') . '/firmapproval_index';
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


      return view('Firm_Registration.firm_approval_index', compact('user_id', 'menus', 'screens', 'modules', 'rows'));
    } catch (\Exception $exc) {

      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
    //
  }

  // Approval screen //

  public function firm_show(Request $request)
  {

    try {
      $method = 'Method => firmregistrationController => firm_show';
      $mobile = 0;
      if (isset($request->mobile)) {
        $mobile = 1;
      }
      $id = $request->id;
      $request =  array();
      $request['id'] = $id;
      $gatewayURL = config('setting.api_gateway_url') . '/firm_show';
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
      if ($mobile == 1) {
        $mobile_response = [
          'data' => $rows
        ];
        return $mobile_response;
      }
      //     return view('valuers.index', compact('user_id','rows','menus','screens','modules'));
      return view('Firm_Registration.firm_approval', compact('rows', 'menus', 'screens', 'modules'));
    } catch (\Exception $exc) {

      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
    //
  }



  public function firm_approveupdate(Request $request)
  {

    try {
      $user_id = $request->session()->get("userID");
      $mobile = 0;
      if (isset($request->mobile)) {
        $mobile = 1;
      }
      $method = 'Method => firmregistrationController => update_data';
      $data = array();

      $user_id = $request->session()->get("userID");
      $data['id'] = $request->id;
      $data['messages'] = $request->messages;

      $encryptArray = $this->encryptData($data);
      $request = array();
      $request['requestData'] = $encryptArray;
      $gatewayURL = config('setting.api_gateway_url') . '/firm_approve/updatedata';
      $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
      $response1 = json_decode($response);

      if ($response1->Status == 200 && $response1->Success) {
        $objData = json_decode($this->decryptData($response1->Data));
        if ($objData->Code == 200) {
          if ($mobile == 1) {
            return ['status_code' => '200', 'message' => 'Registration Approved Successfully'];
          }
          return redirect(route('Firm_approval_index'))->with('success', 'Registration Approved Successfully');
        }
        if ($objData->Code == 400) {
          if ($mobile == 1) {
            return ['status_code' => '400', 'message' => 'Approved Name Already Exists'];
          }
          return Redirect::back()->with('fail', 'Approved Name Already Exists');
        }
      } else {
        $objData = json_decode($this->decryptData($response1->Data));
        echo json_encode($objData->Code);
        exit;
      }
    } catch (\Exception $exc) {
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }




  public function firm_rejectupdate(Request $request)
  {
    try {
      $user_id = $request->session()->get("userID");
      $mobile = 0;
      if (isset($request->mobile)) {
        $mobile = 1;
      }
      $method = 'Method => firmregistrationController => update_data';
      $data = array();

      $user_id = $request->session()->get("userID");
      $data['id'] = $request->id;
      $data['messages'] = $request->messages;
      $encryptArray = $this->encryptData($data);
      $request = array();
      $request['requestData'] = $encryptArray;
      $gatewayURL = config('setting.api_gateway_url') . '/firm_reject/updatedata';
      $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
      $response1 = json_decode($response);

      if ($response1->Status == 200 && $response1->Success) {
        $objData = json_decode($this->decryptData($response1->Data));
        if ($objData->Code == 200) {
          if ($mobile == 1) {
            return ['status_code' => '200', 'message' => 'Rejected Successfully'];
          }
          return redirect(route('Firm_approval_index'))->with('success', 'Rejected Successfully');
        }
        if ($objData->Code == 400) {
          if ($mobile == 1) {
            return ['status_code' => '400', 'message' => 'Approved Name Already Exists'];
          }
          return Redirect::back()->with('fail', 'Approved Name Already Exists');
        }
      } else {
        $objData = json_decode($this->decryptData($response1->Data));
        echo json_encode($objData->Code);
        exit;
      }
    } catch (\Exception $exc) {
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }


  public function firmregistration_show()
  {
    try {

      $method = 'Method => firmregistrationController => firmregistration_show';

      $request =  array();


      $gatewayURL = config('setting.api_gateway_url') . '/firm/register_show';
      $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
      $response = json_decode($response);
      $objData = json_decode($this->decryptData($response->Data));
      $code = $objData->Code;
      if ($code == "401") {

        return redirect(url('/'))->with('danger', 'User session Exipired');
      }
      $rows = json_decode(json_encode($objData->Data), true);
      $menus = $this->FillMenu();
      $screens = $menus['screens'];
      $modules = $menus['modules'];
      return view('Firm_Registration.firm_show', compact('rows', 'menus', 'screens', 'modules'));
    } catch (\Exception $exc) {

      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
    //
  }

  public function active_update(Request $request)
  {
    try {

      $method = 'Method => firmregistrationController => active_update';
      $user_id = $request->session()->get("userID");

      if ($user_id == null) {
        return view('auth.login');
      }

      $gatewayURL = config('setting.api_gateway_url') . '/firm/register_show';
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
      return view('Firm_Registration.firm_edit', compact('user_id', 'rows', 'menus', 'screens', 'modules'));
    } catch (\Exception $exc) {

      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
    //
  }


  public function firmregistration_edit(Request $request)
  {
    try {

      $method = 'Method => firmregistrationController => firmregistration_edit';
      $user_id = $request->session()->get("userID");
      $mobile = 0;
      if (isset($request->mobile)) {
        $mobile = 1;
      }

      if ($user_id == null) {
        return view('auth.login');
      }
      $gatewayURL = config('setting.api_gateway_url') . '/firm/register_show';
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
      if ($mobile == 1) {
        $mobile_response = [
          'data' => $rows
        ];
        return $mobile_response;
      }
      return view('Firm_Registration.firm_edit', compact('user_id', 'rows', 'menus', 'screens', 'modules'));
    } catch (\Exception $exc) {

      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
    //
  }


  public function firmregistration_update(Request $request)
  {
    try {
// dd($request);
      $method = 'Method => firmregistrationController => firmregistration_edit';
      $user_id = $request->session()->get("userID");
      $mobile = 0;
      if (isset($request->mobile)) {
        $mobile = 1;
      }

      // dd('hi');
      if ($user_id == null) {
        return view('auth.login');
      }

      $data = array();
      $data['firm_name'] = $request->firm_name;
      $data['description'] = $request->description;
      $data['partner_name'] = $request->partner;
      $data['user_id'] = $user_id;

      $encryptArray = $data;
      //ursb
      if (isset($request->ursb_update) == true) {
        $storagepath_ursb_old = public_path() . '/uploads/URSB/' . $user_id;
        $storagepath_ursb = '/uploads/URSB/' . $user_id;
        if (!File::exists($storagepath_ursb_old)) {
          File::makeDirectory($storagepath_ursb_old);
        }
        $data['ursbp'] = $storagepath_ursb;
        $documentsb =  $request['ursb_update'];
        $files = $documentsb->getClientOriginalName();
        $findspace = array(' ', '&', "'", '"');
        $replacewith = array('-', '-');
        $proposal_files = str_replace($findspace, $replacewith, $files);
        $documentsb->move($storagepath_ursb_old, $proposal_files);
        $data['ursbn'] = $proposal_files;
      }

      // location_proof
      if (isset($request->proof_update) == true) {
        $storagepath_locationproof_old = public_path() . '/uploads/locationProof/' . $user_id;
        $storagepath_locationproof = '/uploads/locationProof/' . $user_id;
        if (!File::exists($storagepath_locationproof_old)) {
          File::makeDirectory($storagepath_locationproof_old);
        }
        $data['locationproofp'] = $storagepath_locationproof;
        $documentsb =  $request['proof_update'];
        $files = $documentsb->getClientOriginalName();
        $findspace = array(' ', '&', "'", '"');
        $replacewith = array('-', '-');
        $proposal_files = str_replace($findspace, $replacewith, $files);
        $documentsb->move($storagepath_locationproof_old, $proposal_files);
        $data['locationproofn'] = $proposal_files;
        $pdf = $request->file('locationproof');
      }

      

      $encryptArray = $data;
      $request = array();
      $request['requestData'] = $encryptArray;
      $gatewayURL = config('setting.api_gateway_url') . '/firm/register_update';
      $response = $this->serviceRequest($gatewayURL, 'POST',  json_encode($request), $method);
      $response = json_decode($response);
      // dd($response);
      $objData = json_decode($this->decryptData($response->Data));
      $code = $objData->Code;

      if ($objData->Code == 200) {
        if ($mobile == 1) {
          return ['status_code' => '200', 'message' => 'Firm Registration Updated Successfully'];
        }
        return redirect(route('firm_index'))->with('success', 'Firm Registration Updated Successfully');
      }

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

    } catch (\Exception $exc) {

      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
    //
  }
}
