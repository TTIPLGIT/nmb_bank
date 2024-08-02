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

class RegistrationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => LoginController => Register_screen';

            $request =  array();
            $request['user_id'] = $user_id;

            $gatewayURL = config('setting.api_gateway_url') . '/Register/screenapl';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
            $response = json_decode($response);
            $objData = json_decode($this->decryptData($response->Data));
            $code = $objData->Code;

            if ($code == "401") {
                if ($code == "401") {
                    return redirect(url('/'))->with('danger', 'User session Exipired');
                }
                return redirect(url('/'))->with('danger', 'User session Exipired');
            }

            $rows = json_decode(json_encode($objData->Data), true);

            $gd_status = $rows['data3'][0]['active_flag'];
            $menus = $this->FillMenu();
            if ($menus == "401") {
                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            if ($mobile == 1) {
                return $rows;
            }

            return view('Registration.index', compact('user_id', 'rows', 'menus', 'screens', 'modules', 'gd_status'));
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    public function education_index(Request $request)
    {
        try {
            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => LoginController => Register_screen';

            $request =  array();
            $request['user_id'] = $user_id;

            $gatewayURL = config('setting.api_gateway_url') . '/Register/screenapl';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
            $response = json_decode($response);
            $objData = json_decode($this->decryptData($response->Data));
            $code = $objData->Code;

            if ($code == "401") {

                return redirect(url('/'))->with('danger', 'User session Exipired');
            }

            $rows = json_decode(json_encode($objData->Data), true);

            $gd_status = $rows['data3'][0]['active_flag'];
            $menus = $this->FillMenu();
            if ($menus == "401") {
                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            if ($mobile == 1) {
                $mobile_status['code'] = $code;
                $mobile_status['rows'] = $rows;
                return $mobile_status;
            }

            return view('Registration.education_index', compact('user_id', 'rows', 'menus', 'screens', 'modules', 'gd_status'));

            //
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }

    public function workexp_index(Request $request)
    {
        try {
            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => LoginController => Register_screen';

            $request =  array();
            $request['user_id'] = $user_id;
            $gatewayURL = config('setting.api_gateway_url') . '/Register/screenapl';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
            $response = json_decode($response);

            $objData = json_decode($this->decryptData($response->Data));
            $code = $objData->Code;

            if ($code == "401") {

                return redirect(url('/'))->with('danger', 'User session Exipired');
            }

            $rows = json_decode(json_encode($objData->Data), true);
            $gd_status = $rows['data3'][0]['active_flag'];
            $menus = $this->FillMenu();
            if ($menus == "401") {
                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            if ($mobile == 1) {
                return $rows;
            }

            return view('Registration.workexp_index', compact('user_id', 'rows', 'menus', 'screens', 'modules', 'gd_status'));

            //
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }

    public function approvalprocess_index(Request $request)
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
            $request['user_id'] = $user_id;
            $request['exist'] = "exist";

            $gatewayURL = config('setting.api_gateway_url') . '/Register/screenapl';

            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
            $response = json_decode($response);



            $objData = json_decode($this->decryptData($response->Data));


            if ($objData->Code == 400) {
                $url = $objData->Data;
                $mobile_response = [
                    'code' => $objData->Code,
                    'Message' => "Kindly fill all the details above to proceed further"
                ];
                if ($mobile == 1) {
                    return $mobile_response;
                }
                return redirect(route($url))->with('error', 'Kindly fill all the details above to proceed further');
            };
            $code = $objData->Code;

            if ($code == "401") {

                return redirect(url('/'))->with('danger', 'User session Exipired');
            }

            $rows = json_decode(json_encode($objData->Data), true);



            $gd_status = $rows['data3'][0]['active_flag'];

            $menus = $this->FillMenu();
            if ($menus == "401") {
                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            $response = [
                'code' => 200,
                'Data' => $rows
            ];
            if ($mobile == 1) {
                return $response;
            }

            return view('Registration.approvalprocess_index', compact('user_id', 'rows', 'menus', 'screens', 'modules', 'gd_status'));

            //
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }
    public function  Committee_index(Request $request)
    {
        try {

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => LoginController => Register_screen';

            $request =  array();
            $request['user_id'] = $user_id;
            $request['exist'] = "exist";

            $gatewayURL = config('setting.api_gateway_url') . '/Register/screenapl';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
            $response = json_decode($response);

            $objData = json_decode($this->decryptData($response->Data));
            if ($objData->Code == 400) {
                $url = $objData->Data;
                return redirect(route($url))->with('error', 'Kindly fill all the details above to proceed further');
            };
            $code = $objData->Code;

            if ($code == "401") {

                return redirect(url('/'))->with('danger', 'User session Exipired');
            }

            $rows = json_decode(json_encode($objData->Data), true);

            $gd_status = $rows['data3'][0]['active_flag'];
            $menus = $this->FillMenu();
            if ($menus == "401") {
                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
            $screens = $menus['screens'];
            $modules = $menus['modules'];

            return view('Registration.committee_index', compact('user_id', 'rows', 'menus', 'screens', 'modules', 'gd_status'));

            //
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }


    public function  approvenrv_index(Request $request)

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

            $method = 'Method => RegistrationController => approvenrv_screen';

            $gatewayURL = config('setting.api_gateway_url') . '/Register/approvenrv_index';

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
                return [
                    'code' => 200,
                    'rows' => $rows
                ];
            }

            return view('Registration.approvenrv_index', compact('user_id', 'rows', 'menus', 'screens', 'modules'));
        } catch (\Exception $exc) {
            if ($mobile == 1) {
                return [
                    'code' => 500,
                    'message' => "Something went Wrong"
                ];
            }
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }

    public function approvenrv_edit(Request $request)
    {
        try {
            //
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => RegistrationController => Register_screen';
            $id = $request->id;
            $request =  array();
            $request['id'] = $id;
            $this->WriteFileLog($request);

            $gatewayURL = config('setting.api_gateway_url') . '/approvenrv/screenedit';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);

            $response = json_decode($response);
            $objData = json_decode($this->decryptData($response->Data));
            $rows = json_decode(json_encode($objData->Data), true);

            return $rows;
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }



    public function update_store(Request $request)
    {
        try {
            //
            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => RegistrationController => Register_screen';
            $data = array();

            $storagepath_approvedcertificate_old = public_path() . '/approved/certificate/' . $user_id;
            $storagepath_approvedcertificateproof = '/approved/certificate/' . $user_id;
            if (!File::exists($storagepath_approvedcertificate_old)) {
                File::makeDirectory($storagepath_approvedcertificate_old);
            }
            $data['approvedcertificateproofp'] = $storagepath_approvedcertificateproof;
            $documentsb =  $request['approvedcertificate'];

            $files = $documentsb->getClientOriginalName();
            $findspace = array(' ', '&', "'", '"');
            $replacewith = array('-', '-');
            $proposal_files = str_replace($findspace, $replacewith, $files);
            $documentsb->move($storagepath_approvedcertificate_old, $proposal_files);
            $data['approvedcertificateproofn'] = $proposal_files;
            $pdf = $request->file('approvedcertificate');

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/approve/update_store';
            $response = $this->serviceRequest($gatewayURL, 'POST',  json_encode($request), $method);

            $response = json_decode($response);
            $objData = json_decode($this->decryptData($response->Data));
            $rows = json_decode(json_encode($objData->Data), true);
            if ($mobile == 1) {
                return ['code' => 200, 'message' => 'Approved File Updated Successfully'];
            }
            return redirect(route('approvenrv_index'))->with('success', 'Approved File Updated Successfully');
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }
    public function approvenrv_store(Request $request)

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

            $method = 'Method =>RegistrationController => store';

            $data = array();

            $storagepath_approvedcertificate_old = public_path() . '/approved/certificate/' . $user_id;
            $storagepath_approvedcertificateproof = '/approved/certificate/' . $user_id;
            if (!File::exists($storagepath_approvedcertificate_old)) {
                File::makeDirectory($storagepath_approvedcertificate_old);
            }
            $data['approvedcertificateproofp'] = $storagepath_approvedcertificateproof;
            $documentsb =  $request['approvedcertificate'];

            $files = $documentsb->getClientOriginalName();
            $findspace = array(' ', '&', "'", '"');
            $replacewith = array('-', '-');
            $proposal_files = str_replace($findspace, $replacewith, $files);
            $documentsb->move($storagepath_approvedcertificate_old, $proposal_files);
            $data['approvedcertificateproofn'] = $proposal_files;
            $pdf = $request->file('approvedcertificate');




            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;


            $gatewayURL = config('setting.api_gateway_url') . '/Register/approvenrvstore';
            $response = $this->serviceRequest($gatewayURL, 'POST',  json_encode($request), $method);
            $response = json_decode($response);

            $objData = json_decode($this->decryptData($response->Data));
            $code = $objData->Code;

            if ($code == "401") {

                return redirect()->route('unauthenticated')->send();
            }
            $rows = json_decode(json_encode($objData->Data), true);
            if ($mobile == 1) {
                return 200;
            }

            return redirect(route('approvenrv_index'))->with('success', 'Approved File Submitted Successfully');
        } catch (\Exception $exc) {
            if ($mobile == 1) {
                return 500;
            }

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }



    // public function Registration()
    // {
    //     //
    // }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request)
    {
        try {
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $user_id = $request->session()->get("userID");
            $method = 'Method => LoginController => Register_screen';

            $urd = $request->urd;
            if ($urd == "exp") {
                $gatewayURL = config('setting.api_gateway_url') . '/Register/expcreate';
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
                $response = json_decode($response);
                $objData = json_decode($this->decryptData($response->Data));
                $user_id = json_decode(json_encode($objData->Data), true);
                $menus = $this->FillMenu();
                if ($menus == "401") {
                    return redirect(url('/'))->with('danger', 'User session Exipired');
                }
                $screens = $menus['screens'];
                $modules = $menus['modules'];
                return view('Registration.workexpcreate', compact('user_id', 'menus', 'screens', 'modules'));
            } else {
                return view('errors.errors');
            }
            //
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }

    public function educreate(Request $request)
    {
        try {
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }

            $method = 'Method => LoginController => Register_screen';


            $gatewayURL = config('setting.api_gateway_url') . '/Register/educreate';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            $objData = json_decode($this->decryptData($response->Data));
            $user_id = json_decode(json_encode($objData->Data), true);
            $menus = $this->FillMenu();
            if ($menus == "401") {
                return redirect(url('/'))->with('danger', 'User session Exipired');
            }

            $screens = $menus['screens'];
            $modules = $menus['modules'];
            return view('Registration.educationcreatenew', compact('user_id', 'menus', 'screens', 'modules'));

            //
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }



    public function nruworkexp_index(Request $request)
    {
        try {

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $user_id = $request->session()->get("userID");
            $method = 'Method => LoginController => nrvworkexp_index';

            $urd = $request->urd;
            $gatewayURL = config('setting.api_gateway_url') . '/Register/screenapl';
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

            return view('Registration.nruworkexp_index', compact('menus', 'screens', 'modules', 'rows'));
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }
    
    public function coursename_list(Request $request)
    {


        $method = 'Method => RegistrationController => course_list';
        try {

            $id = $request->session()->get("userID");
            if ($id == null) {
                return view('auth.login');
            }


            $gatewayURL = config('setting.api_gateway_url') . '/education/coursename_list';
            $response = $this->serviceRequest($gatewayURL, 'GET',  '', $method);
            $response = json_decode($response);

            $objData = json_decode($this->decryptData($response->Data));

            $code = $objData->Code;
            $rows = json_decode(json_encode($objData->Data), true);


            // if ($code == "401") {

            //     return redirect()->route('unauthenticated')->send();
            // }

            // $menus = $this->FillMenu();

            // if ($menus == "401") {
            //     return redirect(url('/'))->with('danger', 'User session Exipired');
            // }
            // $screens = $menus['screens'];
            // $modules = $menus['modules'];
            return $rows;
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }
    public function nruworkexp_create(Request $request)
    {

        try {
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $user_id = $request->session()->get("userID");
            $method = 'Method => LoginController => nruworkexp_create';

            $urd = $request->urd;
            $gatewayURL = config('setting.api_gateway_url') . '/Register/screenapl';
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

            return view('Registration.nrvworkexpcreate', compact('menus', 'screens', 'modules', 'rows'));
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }







    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->WriteFileLog($request);
            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => RegistrationController => store';
            $user_details = $request->user_details;


            if ($user_details == "general") {
                $data = array();
                // $data['fname'] = $request->fname;
                // $data['lname'] = $request->lname;
                // $data['gender'] = $request->gender;
                $data['Address_line1'] = $request->Address_line1;
                $data['district'] = $request->district;
                $data['constituency'] = $request->constituency;
                $data['village'] = $request->village;
                $data['ninfn_format'] = $request->ninfn_format;
                // $data['lvc'] = $request->lvc;
                // $data['role_c'] = $request->role_c;
                $data['user_id'] = $user_id;
                $data['nin'] = $request->nin_input;
                $data['document_type'] = $request->document_type;

                // $data['passport'] = $request->passport;
                // $rules = [
                //     'fname' => 'required',
                //     'password' => 'required',
                //     // 'recaptcha' => 'required|captcha'
                //   ];

                //   $messages = [
                //     'fname.required' => 'Email is required',
                //     'password.required' => 'Password is required',

                //   ];  

                //   $remember_me = $request->has('remember_me') ? true : false; 

                //   $validator = Validator::make($data, $rules, $messages);



                $storagepath_ninf = public_path() . '/userdocuments/registration/general/nin/' . $user_id;
                $storagepath_ninf1 = '/userdocuments/registration/general/nin/' . $user_id;
                if (!File::exists($storagepath_ninf)) {
                    File::makeDirectory($storagepath_ninf);
                }
                $data['ninfp'] = $storagepath_ninf1;
                // $storagepath_ppf = public_path() . '/userdocuments/registration/general/pp/'. $user_id ;
                // $storagepath_ppf1 = '/userdocuments/registration/general/pp/'. $user_id ;
                // if (!File::exists($storagepath_ppf)) {
                //     File::makeDirectory($storagepath_ppf);
                // }
                // $data['ppfp'] = $storagepath_ppf1;
                $documentsf =  $request['nin_file'];

                $files = $documentsf->getClientOriginalName();
                $findspace = array(' ', '&', "'", '"');
                $replacewith = array('-', '-');
                $proposal_files = str_replace($findspace, $replacewith, $files);
                $maxFileSize = 2 * 1024 * 1024;
                if ($documentsf->getSize() > $maxFileSize) {
                    return redirect(route('Registration.index'))->with('error', 'File Size should be within 2mb');
                } else {
                    $documentsf->move($storagepath_ninf, $proposal_files);
                    // $data['instruction_file'] = $proposal_files;
                    $data['ninfn'] = $proposal_files;
                }



                // $documentsf =  $request['ppf'];

                // $files = $documentsf->getClientOriginalName();

                // $findspace = array(' ', '&',"'",'"');
                // $replacewith = array('-', '-');
                // $proposal_files = str_replace($findspace, $replacewith, $files);
                // $documentsf->move($storagepath_ppf, $proposal_files);
                // $data['ppf'] = $proposal_files;          
                $encryptArray = $data;
                $this->WriteFileLog($encryptArray);
                $request = array();
                $encryptArray = $this->encryptData($data);

                $request['requestData'] = $encryptArray;

                $gatewayURL = config('setting.api_gateway_url') . '/user_general/storedata';

                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

                $response1 = json_decode($response);

                if ($response1->Status == 200 && $response1->Success) {
                    $objData = json_decode($this->decryptData($response1->Data));


                    if ($objData->Code == 200) {
                        if ($mobile == 1) {
                            $res_data = [
                                "status_code" => config('setting.status_code.success'),
                                "message" => "General Details Submitted Successfully"
                            ];
                            return $res_data;
                        }
                        return redirect(route('Registration.index'))->with('success', 'General Details Submitted Successfully');
                    }

                    if ($objData->Code == 400) {
                        if ($mobile == 1) {
                            $res_data = [
                                "status_code" => config('setting.status_code.unauthenticated'),
                                "message" => "Data Already Exist"
                            ];
                            return $res_data;
                        }
                        return redirect(route('Registration.index'))->with('error', 'Nin number Already Exists,Kinldy check the Number');
                    }
                } else {
                    $objData = json_decode($this->decryptData($response1->Data));
                    if ($mobile == 1) {
                        return 500;
                    }
                    return view('errors.errors');
                    exit;
                }
            } else if ($user_details == "educate") {

                if ($request->course_typedip == "Diploma") {
                    $storagepath_repgcc = public_path() . '/userdocuments/registration/education/dip/cc/' . $user_id; //system_store_pdf
                    $storagepath_repgcc1 = '/userdocuments/registration/education/dip/cc/' . $user_id; //database_location
                    if (!File::exists($storagepath_repgcc)) {
                        File::makeDirectory($storagepath_repgcc); //folder_creation_when_folder_doesn't_esist
                    }
                    $data['graduationcertifipath'] = $storagepath_repgcc1;
                    if (isset($request['graduationcertifipath'])) {
                        $documentsb =  $request['graduationcertifipath'];
                        $files = $documentsb->getClientOriginalName();
                        $findspace = array(' ', '&', "'", '"');
                        $replacewith = array('-', '-');
                        $proposal_files = str_replace($findspace, $replacewith, $files); //proper_file_name-database field
                        $documentsb->move($storagepath_repgcc, $proposal_files); //storing the file in the system
                        $data['graduationcertifiname'] = $proposal_files;
                    } else {
                        $data['graduationcertifiname'] = "";
                        $data['graduationcertifipath'] = "";
                    }


                    $storagepath_repgcc = public_path() . '/userdocuments/registration/education/dip/cc/' . $user_id; //system_store_pdf
                    $storagepath_repgcc1 = '/userdocuments/registration/education/dip/cc/' . $user_id; //database_location
                    if (!File::exists($storagepath_repgcc)) {
                        File::makeDirectory($storagepath_repgcc); //folder_creation_when_folder_doesn't_esist
                    }
                    if (isset($request['otherdocuments'])) {
                        $data['otherdocuments_path'] = $storagepath_repgcc1;
                        $documentsb =  $request['otherdocuments'];
                        $files = $documentsb->getClientOriginalName();
                        $findspace = array(' ', '&', "'", '"');
                        $replacewith = array('-', '-');
                        $proposal_files = str_replace($findspace, $replacewith, $files); //proper_file_name-database field
                        $documentsb->move($storagepath_repgcc, $proposal_files); //storing the file in the system
                        $data['otherdocuments_name'] = $proposal_files;
                    } else {
                        $data['otherdocuments_path'] = "";
                        $data['otherdocuments_name'] = "";
                    }
                } elseif ($request->course_typedip == "PostGraduation") {

                    $storagepath_repgcc = public_path() . '/userdocuments/registration/education/pg/gc/' . $user_id; //system_store_pdf
                    $storagepath_repgcc1 = '/userdocuments/registration/education/pg/gc/' . $user_id; //database_location
                    if (!File::exists($storagepath_repgcc)) {
                        File::makeDirectory($storagepath_repgcc1); //folder_creation_when_folder_doesn't_esist
                    }
                    if (isset($request['graduationcertifipath'])) {
                        $data['graduationcertifipath'] = $storagepath_repgcc1;
                        $documentsb =  $request['graduationcertifipath'];
                        $files = $documentsb->getClientOriginalName();
                        $findspace = array(' ', '&', "'", '"');
                        $replacewith = array('-', '-');
                        $proposal_files = str_replace($findspace, $replacewith, $files); //proper_file_name-database field
                        $documentsb->move($storagepath_repgcc, $proposal_files); //storing the file in the system
                        $data['graduationcertifiname'] = $proposal_files;
                    }



                    $storagepath_repgcc = public_path() . '/userdocuments/registration/education/pg/gc/' . $user_id; //system_store_pdf
                    $storagepath_repgcc1 = '/userdocuments/registration/education/pg/gc/' . $user_id; //database_location
                    if (!File::exists($storagepath_repgcc)) {
                        File::makeDirectory($storagepath_repgcc1); //folder_creation_when_folder_doesn't_exist
                    }
                    if (isset($request['otherdocuments'])) {
                        $data['otherdocuments_path'] = $storagepath_repgcc1;
                        $documentsb =  $request['otherdocuments'];
                        $files = $documentsb->getClientOriginalName();
                        $findspace = array(' ', '&', "'", '"');
                        $replacewith = array('-', '-');
                        $proposal_files = str_replace($findspace, $replacewith, $files); //proper_file_name-database field
                        $documentsb->move($storagepath_repgcc, $proposal_files); //storing the file in the system
                        $data['otherdocuments_name'] = $proposal_files;
                    } else {
                        $data['otherdocuments_path'] = "";
                        $data['otherdocuments_name'] = "";
                    }
                } else {
                    $storagepath_repgcc = public_path() . '/userdocuments/registration/education/ug/cc/' . $user_id; //system_store_pdf
                    $storagepath_repgcc1 = '/userdocuments/registration/education/ug/cc/' . $user_id; //database_location
                    if (!File::exists($storagepath_repgcc)) {
                        File::makeDirectory($storagepath_repgcc); //folder_creation_when_folder_doesn't_esist

                    }

                    if (isset($request['graduationcertifipath'])) {
                        $data['graduationcertifipath'] = $storagepath_repgcc1;
                        $documentsb = $request['graduationcertifipath'];
                        $files = $documentsb->getClientOriginalName();
                        $findspace = array(' ', '&', "'", '"');
                        $replacewith = array('-', '-');
                        $proposal_files = str_replace($findspace, $replacewith, $files); //proper_file_name-database field
                        $documentsb->move($storagepath_repgcc, $proposal_files); //storing the file in the system
                        $data['graduationcertifiname'] = $proposal_files;
                    } else {
                        $data['graduationcertifiname'] = "";
                        $data['graduationcertifipath'] = "";
                    }
                    $storagepath_repgcc = public_path() . '/userdocuments/registration/education/ug/cc/' . $user_id; //system_store_pdf
                    $storagepath_repgcc1 = '/userdocuments/registration/education/ug/cc/' . $user_id; //database_location
                    if (!File::exists($storagepath_repgcc)) {
                        File::makeDirectory($storagepath_repgcc1); //folder_creation_when_folder_doesn't_exist
                    }
                    if (isset($request['otherdocuments'])) {
                        $data['otherdocuments_path'] = $storagepath_repgcc;
                        $documentsb =  $request['otherdocuments'];
                        $files = $documentsb->getClientOriginalName();
                        $findspace = array(' ', '&', "'", '"');
                        $replacewith = array('-', '-');
                        $proposal_files = str_replace($findspace, $replacewith, $files); //proper_file_name-database field
                        $documentsb->move($storagepath_repgcc, $proposal_files); //storing the file in the system
                        $data['otherdocuments_name'] = $proposal_files;
                    } else {
                        $data['otherdocuments_name'] = "";
                        $data['otherdocuments_path'] = "";
                    }
                }

                $data['id'] = $request->id;
                $data['graduation'] = $request->course_typedip;
                $data['university_name'] = $request->university_name;
                $data['course_name'] = $request->course_name;
                $data['yop'] = $request->yop;
                $data['m_percentage'] = $request->m_percentage;

                $encryptArray = $data;
                $encryptArray = $this->encryptData($encryptArray);
                $request = array();
                $request['requestData'] = $encryptArray;


                // $data['user_id'] = $user_id;
                // for($i=0; $i < $countphd; $i++){
                // $data['phd'][$i] = $request['phd'][$i];       
                // }

                $gatewayURL = config('setting.api_gateway_url') . '/user_general/storedynamic';

                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

                $response1 = json_decode($response);

                if ($response1->Status == 200 && $response1->Success) {
                    $objData = json_decode($this->decryptData($response1->Data));

                    if ($objData->Code == 200) {
                        $message = $objData->custom_message;
                        if ($mobile == 1) {
                            $mobile_response = [
                                'code' => 200,
                                'message' => $message
                            ];
                            return $mobile_response;
                        }
                        return redirect(route('education_index'))->with('success', $message);
                    }


                    if ($objData->Code == 400) {
                        return redirect(route('education_index'))->with('fail', 'Email Name Already Exists');
                    }
                } else {
                    $objData = json_decode($this->decryptData($response1->Data));
                    return view('errors.errors');
                    exit;
                }
            } else if ($user_details == "exp") {
                if ($request->wrqch == "no") {

                    $data['user_id'] = $user_id;
                    $data['cert'] = $request->cert;
                    $data['wrq'] = $request->wrq;
                    $data['experience'] = 0;
                    $data['is_experiences'] = 0;
                    $countc = $request->attachment_countc;
                    for ($i = 0; $i < $countc; $i++) {
                        $data['cert'][$i] = $request['cert'][$i];
                        $storagepath_reugcc = public_path() . '/userdocuments/registration/workexp/wc/' . $user_id;
                        $storagepath_reugcc1 = '/userdocuments/registration/workexp/wc/' . $user_id;
                        if (!File::exists($storagepath_reugcc)) {
                            File::makeDirectory($storagepath_reugcc);
                        }
                        $storagepath_reugcc = public_path() . '/userdocuments/registration/workexp/wc/' . $user_id . '/' . $i;
                        $storagepath_reugcc1 = '/userdocuments/registration/workexp/wc/' . $user_id . '/' . $i;
                        // dd($storagepath_reugcc1);
                        if (!File::exists($storagepath_reugcc)) {
                            File::makeDirectory($storagepath_reugcc);
                        }
                        if ($request['cert'][$i]['nopb'] != "") {
                            $data['cert'][$i]['certfp'] = $storagepath_reugcc1;
                            $documentsf =  $request['cert'][$i]['certd'];
                            $files = $documentsf->getClientOriginalName();
                            $findspace = array(' ', '&');
                            $replacewith = array('-', '-');
                            $proposal_files = str_replace($findspace, $replacewith, $files);
                            $documentsf->move($storagepath_reugcc, $proposal_files);



                            $data['cert'][$i]['certfn'] = $proposal_files;
                            $data['cert'][$i]['table'] = 'user_exp_cert_details';
                            $data['cert'][$i]['user_id'] = $user_id;
                        }
                    }

                    $encryptArray = $data;

                    $request = array();
                    $request['requestData'] = $encryptArray;
                    $gatewayURL = config('setting.api_gateway_url') . '/user_general/storedynamic1';
                    $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
                    $response1 = json_decode($response);
                    if ($response1->Status == 200 && $response1->Success) {
                        $objData = json_decode($this->decryptData($response1->Data));

                        if ($objData->Code == 200) {
                            if ($mobile == 1) {
                                return [
                                    'status_code' => config('setting.status_code.success'),
                                    'message' => "Work Experience Details Submitted Successfully"
                                ];
                            }
                            return redirect(route('workexp_index'))->with('success', 'Work Experience Details Submitted Successfully');
                        }

                        if ($objData->Code == 400) {
                            if ($mobile == 1) {
                                return [
                                    'status_code' => config('setting.status_code.validation'),
                                    'message' => "Email Name Already Exists"
                                ];
                            }
                            return redirect(route('workexp_index'))->with('fail', 'Email Name Already Exists');
                        }
                    } else {
                        $objData = json_decode($this->decryptData($response1->Data));

                        if ($objData->Code == 401) {
                            if ($mobile == 1) {
                                return [
                                    'status_code' => config('setting.status_code.unauthenticated'),
                                    'message' => "User session Exipired"
                                ];
                            }
                            return redirect(url('/'))->with('danger', 'User session Exipired');
                        }
                        if ($mobile == 1) {
                            return [
                                'status_code' => config('setting.status_code.exception'),
                                'message' => "Something Went wrong"
                            ];
                        }
                        return view('errors.errors');
                        exit;
                    }
                }
                if ($request->wrqch == "yes") {

                    $data['wrq'] = $request->wrq;
                    $data['experience'] = $request->experience;
                    $countc = $request->attachment_countc;
                    for ($i = 0; $i < $countc; $i++) {
                        $data['cert'][$i] = $request['cert'][$i];
                        $storagepath_reugcc = public_path() . '/userdocuments/registration/workexp/wc/' . $user_id;
                        $storagepath_reugcc1 = '/userdocuments/registration/workexp/wc/' . $user_id;
                        if (!File::exists($storagepath_reugcc)) {
                            File::makeDirectory($storagepath_reugcc);
                        }
                        $storagepath_reugcc = public_path() . '/userdocuments/registration/workexp/wc/' . $user_id . '/' . $i;
                        $storagepath_reugcc1 = '/userdocuments/registration/workexp/wc/' . $user_id . '/' . $i;
                        // dd($storagepath_reugcc1);
                        if (!File::exists($storagepath_reugcc)) {
                            File::makeDirectory($storagepath_reugcc);
                        }
                        if ($request['cert'][$i]['nopb'] != "") {
                            $data['cert'][$i]['certfp'] = $storagepath_reugcc1;
                            $documentsf =  $request['cert'][$i]['certd'];
                            $files = $documentsf->getClientOriginalName();

                            $findspace = array(' ', '&');
                            $replacewith = array('-', '-');
                            $proposal_files = str_replace($findspace, $replacewith, $files);
                            $documentsf->move($storagepath_reugcc, $proposal_files);


                            $data['cert'][$i]['certfn'] = $proposal_files;
                            $data['cert'][$i]['table'] = 'user_exp_cert_details';
                            $data['cert'][$i]['user_id'] = $user_id;
                        }
                    }
                    $data['user_id'] = "";
                    $data['is_experiences'] = $request->wrqch;
                    $encryptArray = $data;
                    $request = array();
                    $request['requestData'] = $encryptArray;
                    $gatewayURL = config('setting.api_gateway_url') . '/user_general/storedynamic1';
                    $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
                }


                $response1 = json_decode($response);

                if ($response1->Status == 200 && $response1->Success) {
                    $objData = json_decode($this->decryptData($response1->Data));

                    if ($objData->Code == 200) {
                        if ($mobile == 1) {
                            return [
                                'status_code' => config('setting.status_code.success'),
                                'message' => "Work Experience Details Submitted Successfully"
                            ];
                        }
                        return redirect(route('workexp_index'))->with('success', 'Work Experience Details Submitted Successfully');
                    }

                    if ($objData->Code == 400) {
                        if ($mobile == 1) {
                            return [
                                'status_code' => config('setting.status_code.unauthenticated'),
                                'message' => "User session Exipired"
                            ];
                        }
                        return redirect(route('workexp_index'))->with('fail', 'Email Name Already Exists');
                    }
                } else {
                    $objData = json_decode($this->decryptData($response1->Data));
                    if ($mobile == 1) {
                        return [
                            'status_code' => config('setting.status_code.exception'),
                            'message' => "Something Went wrong"
                        ];
                    }
                    return view('errors.errors');
                    exit;
                }
            } else if ($user_details == "approvel_process") {


                $data['user_id'] = $user_id;
                $data['status'] = $request->status;
                $data['approval_persons_id'][0] = $request->counselor;
                $data['approval_persons_id'][1] = $request->supervisor;

                $encryptArray = $data;
                $request = array();
                $request['requestData'] = $encryptArray;
                $gatewayURL = config('setting.api_gateway_url') . '/user_general/storeeqans';
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
                $response1 = json_decode($response);

                if ($response1->Status == 200 && $response1->Success) {
                    $objData = json_decode($this->decryptData($response1->Data));

                    if ($objData->Code == 200) {
                        if ($mobile == 1) {
                            return 200;
                        }
                        return redirect(route('approvalprocess_index'))->with('success', 'Approval Status Submitted Successfully');
                    }

                    if ($objData->Code == 400) {
                        if ($mobile == 1) {
                            return 400;
                        }

                        return redirect(route('approvalprocess_index'))->with('fail', 'Approval Details Already Exists');
                    }
                } else {
                    $objData = json_decode($this->decryptData($response1->Data));
                    if ($mobile == 1) {
                        return 500;
                    }
                    return view('errors.errors');
                    exit;
                }
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }
    public function view_proposal_documents(Request $request)
    {
        try {
            
        $path = $request->id;
        Log::info($path);
        $storagepath = public_path() . $path;
        Log::info($storagepath);

        $converter = new OfficeConverterController($storagepath);
        $converter->convertTo('document-view.pdf');
        $documentViewPath = '/documents/pdfview' . '/document-view.pdf';
        Log::info($documentViewPath);
        return $documentViewPath;
        } catch (\Exception $exc) {
            Log::info($exc);
        }

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        try {
            //
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => LoginController => Register_screen';

            $request =  array();
            $request['user_id'] = $user_id;

            $gatewayURL = config('setting.api_gateway_url') . '/Register/screenapl';
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
            return view('Registration.generalshow', compact('user_id', 'rows', 'menus', 'screens', 'modules'));
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function edushow(Request $request, $id)
    {
        try {
            //
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => LoginController => Register_screen';

            $request =  array();
            $request['user_id'] = $user_id;
            $request['id'] = $id;

            $gatewayURL = config('setting.api_gateway_url') . '/Register/screenapl';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
            $response = json_decode($response);
            $objData = json_decode($this->decryptData($response->Data));
            $code = $objData->Code;

            if ($code == "401") {

                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
            $rows = json_decode(json_encode($objData->Data), true);
            $education = $rows['education'];
            $educationstate = $rows['educationstate'];
            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            return view('Registration.educationshownew', compact('user_id', 'rows', 'education', 'educationstate', 'menus', 'screens', 'modules'));
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }
    public function expshow(Request $request, $id)
    {
        try {
            //
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => LoginController => Register_screen';

            $request =  array();
            $request['user_id'] = $user_id;

            $gatewayURL = config('setting.api_gateway_url') . '/Register/screenapl';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);

            $response = json_decode($response);
            $objData = json_decode($this->decryptData($response->Data));
            $code = $objData->Code;

            if ($code == "401") {

                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
            $rows = json_decode(json_encode($objData->Data), true);
            $Experience = $rows['Experience'];
            $check = $rows['check'];
            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            return view('Registration.workexpshow', compact('user_id', 'rows', 'Experience', 'check', 'menus', 'screens', 'modules'));
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        try {
            //
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => LoginController => Register_screen';

            $request =  array();
            $request['user_id'] = $user_id;

            $gatewayURL = config('setting.api_gateway_url') . '/Register/screenapl';
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
            return view('Registration.generaledit', compact('user_id', 'rows', 'menus', 'screens', 'modules'));
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }

    public function eduedit(Request $request, $id)
    {

        try {

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
                $id = $this->encryptData($id);
            }

            $method = 'Method => LoginController => Register_screen';

            $request =  array();
            $request['user_id'] = $user_id;
            $request['id'] = $id;

            $gatewayURL = config('setting.api_gateway_url') . '/Register/screenapl';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);

            $response = json_decode($response);
            $objData = json_decode($this->decryptData($response->Data));
            $code = $objData->Code;

            if ($code == "401") {

                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
            $rows = json_decode(json_encode($objData->Data), true);
            $education = $rows['education'];
            $educationstate = $rows['educationstate'];

            $menus = $this->FillMenu();
            if ($menus == "401") {
                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            if ($mobile == 1) {
                return [
                    'rows' => $rows,
                    'status' => 200
                ];
            }

            return view('Registration.educationeditnew', compact('user_id', 'rows', 'education', 'educationstate', 'menus', 'screens', 'modules'));
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }

    public function expedit(Request $request, $id)
    {
        try {

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => LoginController => Register_screen';

            $request =  array();
            $request['user_id'] = $user_id;

            $gatewayURL = config('setting.api_gateway_url') . '/Register/screenapl';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);

            $response = json_decode($response);
            $objData = json_decode($this->decryptData($response->Data));
            $code = $objData->Code;

            if ($code == "401") {

                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
            $rows = json_decode(json_encode($objData->Data), true);
            $Experience = $rows['Experience'];
            $check = $rows['check'];
            $menus = $this->FillMenu();
            if ($menus == "401") {
                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
            $screens = $menus['screens'];
            $modules = $menus['modules'];

            return view('Registration.workexpedit', compact('user_id', 'rows', 'Experience', 'check', 'menus', 'screens', 'modules'));
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        try {
            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => UamModulesController => store';
            $user_details = $request->user_details;
            if ($user_details == "eligibleq") {
                $countq = count($request->q);

                $data = array();
                for ($i = 0; $i < $countq; $i++) {
                    $data['q'][$i] = $request['q'][$i + 1];
                    $data['q'][$i]['table'] = 'user_eligible_qa_details';
                    $data['q'][$i]['user_id'] = $user_id;
                }

                $data['user_id'] = $user_id;

                $encryptArray = $data;
                $request = array();
                $request['requestData'] = $encryptArray;

                $gatewayURL = config('setting.api_gateway_url') . '/user_general/updateeqans';

                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

                $response1 = json_decode($response);
                if ($response1->Status == 200 && $response1->Success) {
                    $objData = json_decode($this->decryptData($response1->Data));

                    if ($objData->Code == 200) {
                        return redirect(route('Registration.approvalprocess_index'))->with('success', 'Eligible Details Updated Successfully');
                    }

                    if ($objData->Code == 400) {
                        return redirect(route('Registration.approvalprocess_index'))->with('fail', 'Eligibile Details Already Exists');
                    }
                } else {
                    $objData = json_decode($this->decryptData($response1->Data));
                    return view('errors.errors');
                    exit;
                }
            } elseif ($user_details == "general") {


                $data = array();
                //   $data['fname'] = $request->fname;
                //   $data['lname'] = $request->lname;
                //   $data['gender'] = $request->gender;
                $data['Address_line1'] = $request->Address_line1;
                $data['district'] = $request->district_edit;
                $data['constituency'] = $request->constituency;
                $data['village'] = $request->village;
                $data['document_type'] = $request->document_type;
                //   $data['role_c'] = $request->role_c;
                $data['user_id'] = $user_id;

                $data['nin'] = $request->nin;


                //   $data['passport'] = $request->passport;

                $storagepath_ninf = public_path() . '/userdocuments/registration/general/nin/' . $user_id;
                $storagepath_ninf1 = '/userdocuments/registration/general/nin/' . $user_id;
                if (!File::exists($storagepath_ninf)) {
                    File::makeDirectory($storagepath_ninf);
                }

                $data['ninfp'] = $storagepath_ninf1;
                //   $storagepath_ppf = public_path() . '/userdocuments/registration/general/pp/'. $user_id ;
                //   $storagepath_ppf1 = '/userdocuments/registration/general/pp/'. $user_id ;
                //   if (!File::exists($storagepath_ppf)) {
                //       File::makeDirectory($storagepath_ppf);
                //   }
                //   $data['ppfp'] = $storagepath_ppf1;
                $f1 = $request['f1'];
                $f2 = $request['f2'];
                if ($f1 == '0') {
                    // if (!File::exists($storagepath_ppf)) {
                    //     File::cleanDirectory($storagepath_ppf);
                    // }
                    $storagepath_ppf = public_path() . '/userdocuments/registration/general/nin/' . $user_id;

                    if (!File::exists($storagepath_ppf)) {
                        File::makeDirectory($storagepath_ppf);
                    }
                    $documentsf =  $request['ninf'];

                    $files = $documentsf->getClientOriginalName();

                    $findspace = array(' ', '&', "'", '"');
                    $replacewith = array('-', '-');
                    $proposal_files = str_replace($findspace, $replacewith, $files);
                    $maxFileSize = 2 * 1024 * 1024;
                    $data['ninfn'] = $files;
                    if ($documentsf->getSize() > $maxFileSize) {
                        if ($mobile == 1) {
                            return ['status' => 500, 'message' => 'File Size should be within 2mb'];
                        }
                        return redirect(route('Registration.index'))->with('error', 'File Size should be within 2mb');
                    }
                } else {

                    // $data['instruction_file'] = $proposal_files;
                    $data['ninfn'] = $request['oldninfn'];
                }
                // if ($f2 == '0') {

                //     if (File::exists($storagepath_ppf)) {
                //         File::cleanDirectory($storagepath_ppf);
                //     }
                //     $storagepath_ppf = public_path() . '/userdocuments/registration/general/pp/' . $user_id;

                //     if (!File::exists($storagepath_ppf)) {
                //         File::makeDirectory($storagepath_ppf);
                //     }
                //     $documentsf =  $request['ppf'];

                //     $files = $documentsf->getClientOriginalName();

                //     $findspace = array(' ', '&');
                //     $replacewith = array('-', '-');
                //     $proposal_files = str_replace($findspace, $replacewith, $files);
                //     $documentsf->move($storagepath_ppf, $proposal_files);
                //     $data['ppfn'] = $proposal_files;
                // } else {
                //     $data['ppfn'] = $request['oldppfn'];
                // }



                $encryptArray = $data;
                $request = array();
                $request['requestData'] = $encryptArray;


                $gatewayURL = config('setting.api_gateway_url') . '/user_general/updatedata';

                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

                $response1 = json_decode($response);
                if ($response1->Status == 200 && $response1->Success) {
                    $objData = json_decode($this->decryptData($response1->Data));

                    if ($objData->Code == 200) {
                        if ($mobile == 1) {
                            return ['status' => 200, 'message' => 'General Details updated Successfully'];
                        }
                        return redirect(route('Registration.index'))->with('success', 'General Details updated Successfully');
                    }

                    if ($objData->Code == 400) {
                        if ($mobile == 1) {
                            return 400;
                        }
                        return redirect(route('Registration.index'))->with('fail', 'General Details Already Exists');
                    }
                } else {
                    $objData = json_decode($this->decryptData($response1->Data));
                    if ($mobile == 1) {
                        return 500;
                    }
                    return view('errors.errors');
                    exit;
                }
            } else if ($user_details == "educate") {

                $countug = $request->attachment_countug;
                $countpg = $request->attachment_countpg;
                $countdip = $request->attachment_countdip;
                $countphd = $request->attachment_countphd;
                $randomId       =   rand(2, 50);
                $data = array();
                if ($countug === "0") {
                    $data['ug'] = "";
                }
                if ($countpg === "0") {
                    $data['pg'] = "";
                }
                if ($countdip === "0") {
                    $data['dip'] = "";
                }
                for ($i = 0; $i < $countug; $i++) {
                    $data['ug'][$i] = $request['ug'][$i];
                    $storagepath_reugcc = public_path() . '/userdocuments/registration/education/ug/cc/' . $user_id;
                    $storagepath_reugcc1 = '/userdocuments/registration/education/ug/cc/' . $user_id;
                    if (!File::exists($storagepath_reugcc)) {
                        File::makeDirectory($storagepath_reugcc);
                    }
                    $storagepath_reugcc = public_path() . '/userdocuments/registration/education/ug/cc/' . $user_id . '/' . $i;
                    $storagepath_reugcc1 = '/userdocuments/registration/education/ug/cc/' . $user_id . '/' . $i;
                    if (!File::exists($storagepath_reugcc)) {
                        File::makeDirectory($storagepath_reugcc);
                    }
                    $storagepath_reuggc = public_path() . '/userdocuments/registration/education/ug/gc/' . $user_id;
                    $storagepath_reuggc1 = '/userdocuments/registration/education/ug/gc/' . $user_id;

                    if (!File::exists($storagepath_reuggc)) {
                        File::makeDirectory($storagepath_reuggc);
                    }
                    $storagepath_reuggc = public_path() . '/userdocuments/registration/education/ug/gc/' . $user_id . '/' . $i;
                    $storagepath_reuggc1 = '/userdocuments/registration/education/ug/gc/' . $user_id . '/' . $i;

                    if (!File::exists($storagepath_reuggc)) {
                        File::makeDirectory($storagepath_reuggc);
                    }
                    $ugcyn1 = $i + 1;
                    $ugcyn = $request["ugcyn" . $ugcyn1];

                    if ($ugcyn == "0") {

                        $data['ug'][$i]['cfp'] = $storagepath_reugcc1;
                        $documentsf =  $request['ug'][$i]['consolidate_mark'];

                        $files = $documentsf->getClientOriginalName();

                        $findspace = array(' ', '&');
                        $replacewith = array('-', '-');
                        $proposal_files = str_replace($findspace, $replacewith, $files);

                        $documentsf->move($storagepath_reugcc, $proposal_files);
                        $data['ug'][$i]['cfn'] = $proposal_files;
                    } else {
                        $data['ug'][$i]['cfp'] = $request['ug'][$i]['ocfp'];
                        $data['ug'][$i]['cfn'] = $request['ug'][$i]['ocfn'];
                    }
                    $uggyn1 = $i + 1;
                    $uggyn = $request["uggyn" . $uggyn1];
                    if ($uggyn == "0") {
                        $data['ug'][$i]['gfp'] = $storagepath_reuggc1;
                        $documentsf =  $request['ug'][$i]['garduation_certificate'];

                        $files = $documentsf->getClientOriginalName();

                        $findspace = array(' ', '&');
                        $replacewith = array('-', '-');
                        $proposal_files = str_replace($findspace, $replacewith, $files);
                        $documentsf->move($storagepath_reuggc, $proposal_files);

                        $data['ug'][$i]['gfn'] = $proposal_files;
                    } else {
                        $data['ug'][$i]['gfp'] = $request['ug'][$i]['ogfp'];
                        $data['ug'][$i]['gfn'] = $request['ug'][$i]['ogfn'];
                    }
                    $data['ug'][$i]['table'] = 'user_education_ug_details';
                    $data['ug'][$i]['user_id'] = $user_id;
                }

                for ($i = 0; $i < $countpg; $i++) {
                    $data['pg'][$i] = $request['pg'][$i];
                    $storagepath_repgcc = public_path() . '/userdocuments/registration/education/pg/cc/' . $user_id;
                    $storagepath_repgcc1 = '/userdocuments/registration/education/pg/cc/' . $user_id;

                    if (!File::exists($storagepath_repgcc)) {
                        File::makeDirectory($storagepath_repgcc);
                    }
                    $storagepath_repgcc = public_path() . '/userdocuments/registration/education/pg/cc/' . $user_id . '/' . $i;
                    $storagepath_repgcc1 = '/userdocuments/registration/education/pg/cc/' . $user_id . '/' . $i;
                    if (!File::exists($storagepath_repgcc)) {
                        File::makeDirectory($storagepath_repgcc);
                    }
                    $storagepath_repggc = public_path() . '/userdocuments/registration/education/pg/gc/' . $user_id;
                    $storagepath_repggc1 = '/userdocuments/registration/education/pg/gc/' . $user_id;


                    if (!File::exists($storagepath_repggc)) {
                        File::makeDirectory($storagepath_repggc);
                    }
                    $storagepath_repggc = public_path() . '/userdocuments/registration/education/pg/gc/' . $user_id . '/' . $i;
                    $storagepath_repggc1 = '/userdocuments/registration/education/pg/gc/' . $user_id . '/' . $i;
                    if (!File::exists($storagepath_repggc)) {
                        File::makeDirectory($storagepath_repggc);
                    }
                    $pgcyn1 = $i + 1;
                    $pgcyn = $request["pgcyn" . $pgcyn1];
                    if ($pgcyn == "0") {
                        $data['pg'][$i]['cfp'] = $storagepath_repgcc1;
                        $documentsf =  $request['pg'][$i]['consolidate_mark'];

                        $files = $documentsf->getClientOriginalName();

                        $findspace = array(' ', '&');
                        $replacewith = array('-', '-');
                        $proposal_files = str_replace($findspace, $replacewith, $files);
                        $documentsf->move($storagepath_repgcc, $proposal_files);
                        $data['pg'][$i]['cfn'] = $proposal_files;
                    } else {
                        $data['pg'][$i]['cfp'] = $request['pg'][$i]['ocfp'];
                        $data['pg'][$i]['cfn'] = $request['pg'][$i]['ocfn'];
                    }
                    $pggyn1 = $i + 1;
                    $pggyn = $request["pggyn" . $pggyn1];
                    if ($pggyn == "0") {
                        $data['pg'][$i]['gfp'] = $storagepath_repggc1;
                        $documentsf =  $request['pg'][$i]['garduation_certificate'];

                        $files = $documentsf->getClientOriginalName();

                        $findspace = array(' ', '&');
                        $replacewith = array('-', '-');
                        $proposal_files = str_replace($findspace, $replacewith, $files);
                        $documentsf->move($storagepath_repggc, $proposal_files);
                        $data['pg'][$i]['gfn'] = $proposal_files;
                    } else {
                        $data['pg'][$i]['gfp'] = $request['pg'][$i]['ogfp'];
                        $data['pg'][$i]['gfn'] = $request['pg'][$i]['ogfn'];
                    }
                    $data['pg'][$i]['table'] = 'user_education_pg_details';
                    $data['pg'][$i]['user_id'] = $user_id;
                }
                for ($i = 0; $i < $countdip; $i++) {
                    $data['dip'][$i] = $request['dip'][$i];
                    $storagepath_repgcc = public_path() . '/userdocuments/registration/education/dip/cc/' . $user_id;
                    $storagepath_repgcc1 = '/userdocuments/registration/education/dip/cc/' . $user_id;

                    if (!File::exists($storagepath_repgcc)) {
                        File::makeDirectory($storagepath_repgcc);
                    }

                    $storagepath_repgcc = public_path() . '/userdocuments/registration/education/dip/cc/' . $user_id . '/' . $i;
                    $storagepath_repgcc1 = '/userdocuments/registration/education/dip/cc/' . $user_id . '/' . $i;
                    if (!File::exists($storagepath_repgcc)) {
                        File::makeDirectory($storagepath_repgcc);
                    }
                    $storagepath_repggc = public_path() . '/userdocuments/registration/education/dip/gc/' . $user_id;
                    $storagepath_repggc1 = '/userdocuments/registration/education/dip/gc/' . $user_id;

                    if (!File::exists($storagepath_repggc)) {
                        File::makeDirectory($storagepath_repggc);
                    }
                    $storagepath_repggc = public_path() . '/userdocuments/registration/education/dip/gc/' . $user_id . '/' . $i;
                    $storagepath_repggc1 = '/userdocuments/registration/education/dip/gc/' . $user_id . '/' . $i;

                    if (!File::exists($storagepath_repggc)) {
                        File::makeDirectory($storagepath_repggc);
                    }
                    $dipcyn1 = $i + 1;
                    $dipcyn = $request["dipcyn" . $dipcyn1];
                    if ($dipcyn == "0") {
                        $data['dip'][$i]['cfp'] = $storagepath_repgcc1;
                        $documentsf =  $request['dip'][$i]['consolidate_mark'];

                        $files = $documentsf->getClientOriginalName();

                        $findspace = array(' ', '&');
                        $replacewith = array('-', '-');
                        $proposal_files = str_replace($findspace, $replacewith, $files);
                        $documentsf->move($storagepath_repgcc, $proposal_files);
                        $data['dip'][$i]['cfn'] = $proposal_files;
                    } else {
                        $data['dip'][$i]['cfp'] = $request['dip'][$i]['ocfp'];
                        $data['dip'][$i]['cfn'] = $request['dip'][$i]['ocfn'];
                    }
                    $dipgyn1 = $i + 1;
                    $dipgyn = $request["dipgyn" . $dipgyn1];
                    if ($dipgyn == "0") {
                        $data['dip'][$i]['gfp'] = $storagepath_repggc1;
                        $documentsf =  $request['dip'][$i]['garduation_certificate'];

                        $files = $documentsf->getClientOriginalName();

                        $findspace = array(' ', '&');
                        $replacewith = array('-', '-');
                        $proposal_files = str_replace($findspace, $replacewith, $files);
                        $documentsf->move($storagepath_repggc, $proposal_files);
                        $data['dip'][$i]['gfn'] = $proposal_files;
                    } else {
                        $data['dip'][$i]['gfp'] = $request['dip'][$i]['ogfp'];
                        $data['dip'][$i]['gfn'] = $request['dip'][$i]['ogfn'];
                    }

                    $data['dip'][$i]['table'] = 'user_education_dip_details';
                    $data['dip'][$i]['user_id'] = $user_id;
                }

                $data['delete']['table'] = 'user_education_dip_details';
                $data['user_id'] = $user_id;
                for ($i = 0; $i < $countphd; $i++) {
                    $data['phd'][$i] = $request['phd'][$i];
                }
                $encryptArray = $data;
                // dd($encryptArray);

                $request = array();
                $request['requestData'] = $encryptArray;

                $gatewayURL = config('setting.api_gateway_url') . '/user_general/updatedynamicdata';

                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

                $response1 = json_decode($response);
                if ($response1->Status == 200 && $response1->Success) {
                    $objData = json_decode($this->decryptData($response1->Data));

                    if ($objData->Code == 200) {
                        return redirect(route('education_index'))->with('success', 'Education Details Updated Successfully');
                    }

                    if ($objData->Code == 400) {
                        return redirect(route('education_index'))->with('fail', 'Email Name Already Exists');
                    }
                } else {
                    $objData = json_decode($this->decryptData($response1->Data));
                    return view('errors.errors');
                    exit;
                }
            } else if ($user_details == "exp") {
                // $countc = $request->attachment_countc;
                // $counte = $request->attachment_counte;
                $this->WriteFileLog($request->cert[0]['certfn_old']);
                $this->WriteFileLog($request->cert[0]['certfp_old']);
                $data = array();
                if (isset($request->wrq) == 0 && isset($request->cert) == 0) {
                    if ($mobile == 1) {
                        return ['status' => config('setting.status_code.exist'), 'message' => 'No Changes were found'];
                    }
                    return redirect(route('workexp_index'))->with('error', 'No Changes were found');
                }

                if (isset($request['cert'])) {
                    for ($i = 0; $i < count($request['cert']); $i++) {
                        $data['cert'][$i] = $request['cert'][$i];


                        $storagepath_reugcc = public_path() . '/userdocuments/registration/workexp/wc/' . $user_id;
                        $storagepath_reugcc1 = '/userdocuments/registration/workexp/wc/' . $user_id;
                        if (!File::exists($storagepath_reugcc)) {
                            File::makeDirectory($storagepath_reugcc);
                        }
                        $storagepath_reugcc = public_path() . '/userdocuments/registration/workexp/wc/' . $user_id . '/' . $i;
                        $storagepath_reugcc1 = '/userdocuments/registration/workexp/wc/' . $user_id . '/' . $i;
                        if (!File::exists($storagepath_reugcc)) {
                            File::makeDirectory($storagepath_reugcc);
                        }

                        if (isset($request['cert'][$i]['certd'])) {
                            $data['cert'][$i]['certfp'] = $storagepath_reugcc1;
                            $documentsf =  $request['cert'][$i]['certd'];

                            $files = $documentsf->getClientOriginalName();

                            $findspace = array(' ', '&');
                            $replacewith = array('-', '-');
                            $proposal_files = str_replace($findspace, $replacewith, $files);
                            $documentsf->move($storagepath_reugcc, $proposal_files);
                            $data['cert'][$i]['certfn'] = $proposal_files;
                        } else {
                            $data['cert'][$i]['certfn'] = $request['cert'][$i]['certfn_old'];
                            $data['cert'][$i]['certfp'] = $request['cert'][$i]['certfp_old'];
                        }
                    }
                    foreach ($data['cert'] as $key => $subArray) {
                        if (isset($subArray['certd'])) {
                            unset($data['cert'][$key]['certd']); // Remove the specified key from this sub-array
                        }
                    }
                } else {
                    $data['cert'] = null;
                }
                // for ($i = 0; $i < $counte; $i++) {
                //     $data['wre'][$i] = $request['wre'][$i];

                //     $data['wre'][$i]['table'] = 'user_exp_wre_details';
                //     $data['wre'][$i]['user_id'] = $user_id;
                // }
                $data['wrq'] = $request['wrq'];
                // $data['wrq_data'] = $request['wrq'];
                // $data['wrq']['table'] = "user_exp_wrq_details";
                // $data['wrq']['experience'] = $request['experience'];
                // $data['wrq']['user_id'] = $user_id;
                // $data['exp']['we'] = $request['we'];
                // $data['exp']['wrqch'] = $request['wrqch'];
                // $data['exp']['certc'] = $countc;
                // $data['exp']['expc'] = $counte;
                // $data['user_id'] = $user_id;
                $encryptArray = $this->encryptData($data);
                $requestArray['requestData'] = $encryptArray;

                $gatewayURL = config('setting.api_gateway_url') . '/user_general/updatedynamicdata1';

                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($requestArray), $method);
                $response1 = json_decode($response);
                if ($response1->Status == 200 && $response1->Success) {
                    $objData = json_decode($this->decryptData($response1->Data));

                    if ($objData->Code == 200) {
                        if ($mobile == 1) {
                            return ['status' => config('setting.status_code.success'), 'message' => 'Experience Details Updated Successfully'];
                        }
                        return redirect(route('workexp_index'))->with('success', 'Experience Details Updated Successfully');
                    }

                    if ($objData->Code == 400) {
                        if ($mobile == 1) {
                            return ['status' => config('setting.status_code.validation'), 'message' => 'Something Went Wrong'];
                        }
                        return redirect(route('workexp_index'))->with('fail', 'Email Name Already Exists');
                    }
                } else {
                    $objData = json_decode($this->decryptData($response1->Data));
                    if ($mobile == 1) {
                        return ['status' => config('setting.status_code.validation'), 'message' => 'Something Went Wrong'];
                    }

                    return view('errors.errors');
                    exit;
                }
            }
        } catch (\Exception $exc) {
            if ($mobile == 1) {
                return ['status' => config('setting.status_code.error'), 'message' => $exc->getMessage()];
            }

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }


        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => UamModulesController => store';
            $user_details = $request->user_details;


            $data['user_id'] = $user_id;
            $data['q'][0]['table'] = 'user_eligible_qa_details';
            $encryptArray = $data;
            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/user_general/deleteeqans';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    if ($mobile == 1) {
                        return 200;
                    }

                    return redirect(route('Registration.index'))->with('success', 'Eligible Details Deleted Successfully');
                }

                if ($objData->Code == 400) {
                    if ($mobile == 1) {
                        return 500;
                    }
                    return redirect(route('Registration.index'))->with('fail', 'Eligibile Details Already Exists');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }


        //
    }
    public function destroygen(Request $request)
    {
        try {
            $user_id = $request->session()->get("userID");
            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => UamModulesController => store';
            $user_details = $request->user_details;


            $data['user_id'] = $user_id;
            $data['q'][0]['table'] = 'user_general_details';
            $encryptArray = $data;
            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/user_general/deletegen';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    if ($mobile == 1) {
                        return [
                            'code' => 200,
                            'Message' => 'General Details Deleted Successfully'
                        ];
                    }
                    return redirect(route('Registration.index'))->with('success', 'General Details Deleted Successfully');
                }

                if ($objData->Code == 400) {
                    if ($mobile == 1) {
                        return [
                            'code' => 500,
                            'Message' => 'General Details Already Exists'
                        ];
                    }
                    return redirect(route('Registration.index'))->with('fail', 'General Details Already Exists');
                }
            } else {
                if ($mobile == 1) {
                    return [
                        'code' => 500,
                        'Message' => 'Something Went Wrong'
                    ];
                }
                $objData = json_decode($this->decryptData($response1->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }


        //
    }
    public function destroyexp(Request $request, $id = null)
    {
        try {
            $mobile = 0;
            if (isset($request->mobile)) {
                $data['id'] = $id;
                $mobile = 1;
            } else {
                $data['id'] = $this->decryptData($id);
            }
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => UamModulesController => store';
            $user_details = $request->user_details;


            $data['id'] = $this->decryptData($id);
            $data['we']['cert'][0]['table'] = 'user_exp_cert_details';
            $data['we']['wrq'][0]['table'] = 'user_exp_wre_details';
            $encryptArray = $data;

            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/user_general/deleteexp';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    if ($mobile == 1) {
                        return [
                            'code' => 200,
                            'message' => "Experience Details Deleted Successfully"
                        ];
                    }
                    return redirect()->back()->with('success', 'Experience Details Deleted Successfully');
                }

                if ($objData->Code == 400) {
                    if ($mobile == 1) {
                        return 500;
                    }
                    return redirect(route('workexp_index'))->with('fail', 'Experience Details Already Exists');
                }
            } else {
                if ($mobile == 1) {
                    return 500;
                }
                $objData = json_decode($this->decryptData($response1->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }


        //
    }
    public function destroyedu(Request $request, $type)
    {

        try {
            $this->WriteFileLog($type);

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }
            $method = 'Method => UamModulesController => store';
            $user_details = $request->user_details;

            $data['user_id'] = $user_id;
            $data['type'] = $type;
            $data['graduation'] = $request->graduation;
            $graduation_type_message = $data['graduation'];
            if ($type == "ug") {
                $data['table'] = 'user_education_ug_details';
                $graduation_type = 'Under Graduation';
            }
            if ($type == "pg") {
                $data['table'] = 'user_education_pg_details';
                $graduation_type = 'Post Graduation';
            }
            if ($type == "dip") {
                $data['table'] = 'user_education_dip_details';
                $graduation_type = 'Diplomo';
            }

            $this->WriteFileLog($data);
            $encryptArray = $data;
            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/user_general/deleteedu';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    if ($mobile == 1) {
                        return ['code' => $objData->Code, 'message' => $graduation_type_message . ' Details Deleted Successfully'];
                    }

                    return redirect(route('education_index'))->with('success', 'Education Details Deleted Successfully');
                }

                if ($objData->Code == 400) {
                    if ($mobile == 1) {
                        return ['code' => $objData->Code, 'message' => 'Education Details Already Exists'];
                    }
                    return redirect(route('education_index'))->with('fail', 'Education Details Already Exists');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($mobile == 1) {
                    return ['code' => $objData->Code, 'message' => 'Something Went Wrong'];
                }
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {
            if ($mobile == 1) {
                return ['code' => $objData->Code, 'message' => $exc->getMessage()];
            }

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }


        //
    }
    public function nrustore(Request $request)
    {
        try {
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => RegistrationController => store';
            $data['wrq'] = $request->wrq;
            $data['experience'] = $request->experience;
            $countc = $request->attachment_countc;
            for ($i = 0; $i < $countc; $i++) {
                $data['cert'][$i] = $request['cert'][$i];
                $storagepath_reugcc = public_path() . '/userdocuments/registration/workexp/wc/' . $user_id;
                $storagepath_reugcc1 = '/userdocuments/registration/workexp/wc/' . $user_id;
                if (!File::exists($storagepath_reugcc)) {
                    File::makeDirectory($storagepath_reugcc);
                }
                $storagepath_reugcc = public_path() . '/userdocuments/registration/workexp/wc/' . $user_id . '/' . $i;
                $storagepath_reugcc1 = '/userdocuments/registration/workexp/wc/' . $user_id . '/' . $i;
                // dd($storagepath_reugcc1);
                if (!File::exists($storagepath_reugcc)) {
                    File::makeDirectory($storagepath_reugcc);
                }
                if ($request['cert'][$i]['nopb'] != "") {
                    $data['cert'][$i]['certfp'] = $storagepath_reugcc1;
                    $documentsf =  $request['cert'][$i]['certd'];
                    $files = $documentsf->getClientOriginalName();

                    $findspace = array(' ', '&');
                    $replacewith = array('-', '-');
                    $proposal_files = str_replace($findspace, $replacewith, $files);
                    $documentsf->move($storagepath_reugcc, $proposal_files);
                    $data['cert'][$i]['certfn'] = $proposal_files;
                    $data['cert'][$i]['table'] = 'user_exp_cert_details';
                    $data['cert'][$i]['user_id'] = $user_id;
                }
            }
            $data['user_id'] = "";
            $data['is_experiences'] = $request->wrqch;
            $encryptArray = $data;
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/user_exp/nrustore';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);


            $response1 = json_decode($response);


            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    return redirect(route('nruworkexp_index'))->with('success', 'NRU Work Experience Details Stored Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('nruworkexp_index'))->with('fail', 'Email Name Already Exists');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 401) {
                    return redirect(url('/'))->with('danger', 'User session Exipired');
                }
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }


    public function gddistrict_list(Request $request)
    {



        $method = 'Method => RegistrationController => gddistrict_list';
        try {

            $id = $request->session()->get("userID");
            if ($id == null) {
                return view('auth.login');
            }


            $gatewayURL = config('setting.api_gateway_url') . '/gd/district_list';
            $response = $this->serviceRequest($gatewayURL, 'GET',  '', $method);
            $response = json_decode($response);

            $objData = json_decode($this->decryptData($response->Data));

            $code = $objData->Code;
            $rows = json_decode(json_encode($objData->Data), true);


            // if ($code == "401") {

            //     return redirect()->route('unauthenticated')->send();
            // }

            // $menus = $this->FillMenu();

            // if ($menus == "401") {
            //     return redirect(url('/'))->with('danger', 'User session Exipired');
            // }
            // $screens = $menus['screens'];
            // $modules = $menus['modules'];
            return $rows;
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }


    public function gdconstituency_list(Request $request)
    {

        $method = 'Method => RegistrationController => constituency_list';
        try {

            $id = $request->session()->get("userID");
            if ($id == null) {
                return view('auth.login');
            }
            $data = array();

            $data['district_id'] = $request->id;


            $this->WriteFileLog($data);
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;



            $gatewayURL = config('setting.api_gateway_url') . '/gd/constituency_list';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
            $response = json_decode($response);

            $objData = json_decode($this->decryptData($response->Data));

            $code = $objData->Code;
            $rows = json_decode(json_encode($objData->Data), true);


            // if ($code == "401") {

            //     return redirect()->route('unauthenticated')->send();
            // }

            // $menus = $this->FillMenu();

            // if ($menus == "401") {
            //     return redirect(url('/'))->with('danger', 'User session Exipired');
            // }
            // $screens = $menus['screens'];
            // $modules = $menus['modules'];
            return $rows;
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }


    public function gdvillage_list(Request $request)
    {

        $method = 'Method => RegistrationController => constituency_list';
        try {

            $id = $request->session()->get("userID");
            if ($id == null) {
                return view('auth.login');
            }
            $data = array();

            $data['constituency_id'] = $request->id;

            $this->WriteFileLog($data);
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;



            $gatewayURL = config('setting.api_gateway_url') . '/gd/village_list';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
            $response = json_decode($response);

            $objData = json_decode($this->decryptData($response->Data));

            $code = $objData->Code;
            $rows = json_decode(json_encode($objData->Data), true);


            // if ($code == "401") {

            //     return redirect()->route('unauthenticated')->send();
            // }

            // $menus = $this->FillMenu();

            // if ($menus == "401") {
            //     return redirect(url('/'))->with('danger', 'User session Exipired');
            // }
            // $screens = $menus['screens'];
            // $modules = $menus['modules'];
            return $rows;
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    public function district_edit(Request $request)
    {


        $method = 'Method => RegistrationController => district_edit';
        try {

            $id = $request->session()->get("userID");
            if ($id == null) {
                return view('auth.login');
            }


            $gatewayURL = config('setting.api_gateway_url') . '/general/district_edit';
            $response = $this->serviceRequest($gatewayURL, 'POST',  '', $method);
            $response = json_decode($response);

            $objData = json_decode($this->decryptData($response->Data));

            $code = $objData->Code;
            $rows = json_decode(json_encode($objData->Data), true);


            // if ($code == "401") {

            //     return redirect()->route('unauthenticated')->send();
            // }

            // $menus = $this->FillMenu();

            // if ($menus == "401") {
            //     return redirect(url('/'))->with('danger', 'User session Exipired');
            // }
            // $screens = $menus['screens'];
            // $modules = $menus['modules'];
            return $rows;
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }

    public function education_edit(Request $request)
    {


        $method = 'Method => RegistrationController => education_edit';
        try {

            $id = $request->session()->get("userID");
            if ($id == null) {
                return view('auth.login');
            }


            $gatewayURL = config('setting.api_gateway_url') . '/education/education_edit';
            $response = $this->serviceRequest($gatewayURL, 'POST',  '', $method);
            $response = json_decode($response);

            $objData = json_decode($this->decryptData($response->Data));

            $code = $objData->Code;
            $rows = json_decode(json_encode($objData->Data), true);


            // if ($code == "401") {

            //     return redirect()->route('unauthenticated')->send();
            // }

            // $menus = $this->FillMenu();

            // if ($menus == "401") {
            //     return redirect(url('/'))->with('danger', 'User session Exipired');
            // }
            // $screens = $menus['screens'];
            // $modules = $menus['modules'];
            return $rows;
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }
}
