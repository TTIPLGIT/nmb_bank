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




class licenseapprovalController extends BaseController
{
  // public function index()
  // {
  //   return view('auth.login');
  // }





  public function license_payment(Request $request)

  {


    $user_id = $request->session()->get("userID");
    if ($user_id == null) {
      return view('auth.login');
    }
    $mobile = 0;
    if (isset($request->mobile)) {
      $mobile = 1;
    }

    $method = 'Method => licenseapprovalController => license_payment';
    $request =  array();
    $request['mlhud_id'] = $user_id;
    $gatewayURL = config('setting.api_gateway_url') . '/license/license_index';

    $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
    $response = json_decode($response);
    $objData = json_decode($this->decryptData($response->Data));

    $code = $objData->Code;
    if ($code == 404) {
      if ($mobile == 1) {
        $mobile_response =
          [
            'status_code' => $code,
            'message' => "You don't have enough CPT points to Optain Licenced, you must have atleast 20 CPT points. you can view your CPT Points on E-Learning->CPT POINTS"
          ];

        return $mobile_response;
      }
      return redirect()->back()->with('error', "You don't have enough CPT points to Optain Licenced, you must have atleast 20 CPT points. you can view your CPT Points on E-Learning->CPT POINTS");
    }

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
        'code' => $code,
        'data' => $rows
      ];
      return $mobile_response;
    }

    return view('License.license_index', compact('menus', 'screens', 'modules', 'rows'));
  }

  public function license_register(Request $request)
  {

    $user_id = $request->session()->get("userID");
    if ($user_id == null) {
      return view('auth.login');
    }
    $method = 'Method => licenseregister => store';

    $data = array();
    $data['firm_names'] = $request->firm;
    $data['user_id'] = $user_id;
    $data['valuer_id'] = $request->valuer_id;


    $encryptArray = $data;
    // $storagepath_annualcpd_old = public_path() . '/professioanl/annualcpd/' . $user_id;
    // $storagepath_annualcpd = '/professioanl/annualcpd/' . $user_id;
    // if (!File::exists( $storagepath_annualcpd_old)) {
    //   File::makeDirectory( $storagepath_annualcpd_old);
    // }
    // $data['annualcpdp'] = $storagepath_annualcpd;
    // $documentsb =  $request['annualcpd'];
    // $files = $documentsb->getClientOriginalName();
    // $findspace = array(' ', '&', "'", '"');
    // $replacewith = array('-', '-');
    // $proposal_files = str_replace($findspace, $replacewith, $files);
    // $documentsb->move( $storagepath_annualcpd_old, $proposal_files);
    // $data['annualcpdn'] = $proposal_files;
    // $pdf = $request->file('');
    $encryptArray = $this->encryptData($data);
    $request = array();
    $request['requestData'] = $encryptArray;
    $gatewayURL = config('setting.api_gateway_url') . '/license/license_reg';
    $response = $this->serviceRequest($gatewayURL, 'POST',  json_encode($request), $method);
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
    return redirect(route('license_payment'))->with('success', 'License Registration Submitted Successfully');
  }
}
