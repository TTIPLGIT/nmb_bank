<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use DateTime;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Stmt\Return_;
use Psy\Readline\Hoa\Console;

class LoginController extends BaseController
{
  // public function index()
  // {
  //   return view('auth.login');
  // }


  public function index()
  {
    // echo "cjvh";exit;

    try {
      $method = 'Method => LoginController => login_screen';

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
      }
    } catch (\Exception $exc) {
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }


  public function register_member(Request $request)

  {
    $method = 'Method => LoginController => Registermember_screen';
    try {
      $gatewayURL = config('setting.api_gateway_url') . '/Register/member';
      $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);


      $response1 = json_decode($response);

      if ($response1->Status == 200 && $response1->Success) {
        $objData = json_decode($this->decryptData($response1->Data));
        $parant_data = json_decode(json_encode($objData->Data), true);
        $rows['country'] =  $parant_data['country'];

        if ($objData->Code == 200) {
          if (isset($request->mobile)) {
            return $data = $rows;
          }
          return view('auth.login_member', compact('rows'));
        }
      }

      //code...
    } catch (\Exception $exc) {
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }



  public function register_memberstore(Request $request)
  {
    try {
      $method = 'Method => LoginController => Registermember_screen';

      $data = array();

      $data['name'] = $request->name;
      $data['surname'] = $request->surname;
      $data['othername'] = $request->othername;
      $data['email'] = $request->email;
      $data['dob'] = $request->dob;
      $data['gender_value'] = $request->gender_value;
      $data['country'] = $request->country;
      $data['Mobile_no'] = $request->Mobile_no;
      $data['password'] = bcrypt($request->password);
      $data['password_confirmation'] = $request->password_confirmation;
      $mobile = 0;
      if (isset($request->mobile)) {
        $mobile = 1;
      }


      // $data['dor'] = $request->dor;
      // $data['isu_membership_number'] = $request->isu_membership_number;
      $encryptArray = $this->encryptData($data);
      $request = array();
      $request['requestData'] = $encryptArray;

      $gatewayURL = config('setting.api_gateway_url') . '/Registermember/store';


      $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);


      $response1 = json_decode($response);
      if ($response1->Status == 200 && $response1->Success) {
        $objData = json_decode($this->decryptData($response1->Data));
        if ($objData->Code == 200) {
          if ($mobile == 1) {
            return $objData->Code;
          }
          return redirect(url('/'))->with('success', 'Professional Member NRU Registered Successfully');
        }

        // if ($objData->Code == 400) {
        //   return Redirect::back()->with('error', 'Email-Id Already Exists');
        // }
        if ($objData->Code == 400) {
          if ($mobile == 1) {
            return ['code' => $objData->Code, 'Message' => "Email-Id Already Exists"];
          }
          return redirect()->back()->with('error', 'Email-Id Already Exists');
          // return Redirect::back()->with('error', 'Email-Id Already Exists'); 
        }
      }
      //  else {
      //     $objData = json_decode($this->decryptData($response1->Data));
      //     if ($objData->Code == 408) {
      //       return Redirect::back()->with('error', 'Email Not Verified');
      //       }
      //     echo json_encode($objData->Code);exit;                            
      // }
    } catch (\Exception $exc) {
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }


  public function register()
  {
    try {
      $method = 'Method => LoginController => Register_screen';
      $gatewayURL = config('setting.api_gateway_url') . '/Register/screen';
      $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

      return view('auth.register');
    } catch (\Exception $exc) {
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }
  public function registerstore(Request $request)
  {

    try {
      $method = 'Method => LoginController => Register_screen';

      $data = array();

      $data['name'] = $request->name;
      $data['surname'] = $request->surname;
      $data['othername'] = $request->othername;
      $data['email'] = $request->email;
      $data['dob'] = $request->dob;
      $data['gender_value'] = $request->gender;
      $data['interest'] = $request->interest;
      $data['country'] = $request->country;
      $data['Mobile_no'] = $request->Mobile_no;
      $data['password'] = bcrypt($request->password);
      $data['password_confirmation'] = $request->password_confirmation;

      $mobile = 0;
      if (isset($request->mobile)) {
        $mobile = 1;
      }

      // $data['dor'] = $request->dor;
      // $data['isu_membership_number'] = $request->isu_membership_number;
      $encryptArray = $this->encryptData($data);
      $request = array();
      $request['requestData'] = $encryptArray;

      $gatewayURL = config('setting.api_gateway_url') . '/Register/store';


      $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);


      $response1 = json_decode($response);
      if ($response1->Status == 200 && $response1->Success) {
        $objData = json_decode($this->decryptData($response1->Data));

        if ($objData->Code == 200) {
          if ($mobile == 1) {
            return $objData->Code;
          }
          return redirect(url('/'))->with('success', 'Graduate Trainee Registered Successfully');
        }

        if ($objData->Code == 400) {
          if ($mobile == 1) {
            return ['code' => $objData->Code, 'Message' => "Email-Id Already Exists"];
          }

          return redirect()->back()->with('error', 'Email-Id Already Exists');
          // return Redirect::back()->with('error', 'Email-Id Already Exists'); 
        }
        if ($objData->Code == 500) {
          if ($mobile == 1) {
            return ['code' => $objData->Code, 'Message' => "Something went wrong. Please try again later"];
          }

          return redirect()->back()->with('error', 'Something went wrong. Please try again later');
          // return Redirect::back()->with('error', 'Email-Id Already Exists'); 
        }
      }
      //  else {
      //     $objData = json_decode($this->decryptData($response1->Data));
      //     if ($objData->Code == 408) {
      //       return Redirect::back()->with('error', 'Email Not Verified');
      //       }
      //     echo json_encode($objData->Code);exit;                            
      // }

    } catch (\Exception $exc) {
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }


  public function otpsend(Request $request)
  {
    $method = 'Method => LoginController => OTP';

    $data = array();

    $data['email'] = $request->email;
    $email = $request->email;

    $otp1 =  rand(0, 9);
    $otp2 =  rand(0, 9);
    $otp3 =  rand(0, 9);
    $otp4 =  rand(0, 9);
    $otp5 =  rand(0, 9);
    $otp6 =  rand(0, 9);

    $data['otp1'] = $otp1;
    $data['otp2'] = $otp2;
    $data['otp3'] = $otp3;
    $data['otp4'] = $otp4;
    $data['otp5'] = $otp5;
    $data['otp6'] = $otp6;

    Mail::send('email.emailotpverify', ["data1" => $data], function ($message) use ($data, $email) {

      $message->to($email)
        ->subject('TALENTRA  -  Email Verfication');
    });

    $encryptArray = $this->encryptData($data);

    $request = array();
    $request['requestData'] = $encryptArray;

    $gatewayURL = config('setting.api_gateway_url') . '/register/otpsend';


    $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
    $response1 = json_decode($response);
    $this->WriteFileLog($response);
    $this->WriteFileLog($response1);
    if ($response1->Status == 200 && $response1->Success) {
      $objData = json_decode($this->decryptData($response1->Data));
      if ($objData->Code == 200) {
        return redirect(url('register'))->with('success', 'OTP Sent Successfully');
      }

      if ($objData->Code == 400) {
        return Redirect::back()->with('fail', 'Email-Id Already Sent');
      }
    } else {
      $objData = json_decode($this->decryptData($response1->Data));
      echo json_encode($objData->Code);
      exit;
    }
  }
  public function otpverify(Request $request)
  {
    $method = 'Method => LoginController => OTPVerify';

    $data = array();

    $data['email'] = $request->email;


    $data['otp1'] = $request->otp1;
    $data['otp2'] = $request->otp2;
    $data['otp3'] = $request->otp3;
    $data['otp4'] = $request->otp4;
    $data['otp5'] = $request->otp5;
    $data['otp6'] = $request->otp6;


    $encryptArray = $this->encryptData($data);

    $request = array();
    $request['requestData'] = $encryptArray;

    $gatewayURL = config('setting.api_gateway_url') . '/Register/otpverify';


    $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
    $response1 = json_decode($response);
    if ($response1->Status == 200 && $response1->Success) {
      $objData = json_decode($this->decryptData($response1->Data));
      if ($objData->Code == 200) {
        return response()->json(['success' => "Success"]);
      }

      if ($objData->Code == 400) {

        return response()->json(['success' => "Failure"]);
      }
    } else {
      $objData = json_decode($this->decryptData($response1->Data));
      echo json_encode($objData->Code);
      exit;
    }
  }

  public function forgot()
  {
    // echo "cjvh";exit;

    try {
      $method = 'Method => LoginController => login_screen';

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


          return view('auth.forgot', compact('rows'));
        }
      } else {
        $objData = json_decode($this->decryptData($response->Data));
        echo json_encode($objData->Code);
        exit;
      }
    } catch (\Exception $exc) {
      echo $exc;
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }

  //  public function forgot()
  //  {

  //   return view('auth.forgot'); 
  // }



  public function login(Request $request)

  {
    // $remember_me = $request->has('remember_me') ? true : false; 


    //  echo "hihui";exit;


    try {
      // $hashedPassword = Hash::make('A1C194DB21969CA899D4D8E2028D5BFC');
      // dd($hashedPassword);
      $method = 'Method => LoginController => login';
      $input = [
        'email' => $request->email,
        'password' => $request->password,
        //  'recaptcha' => $request->input('g-recaptcha-response')
      ];

      $rules = [
        'email' => 'required',
        'password' => 'required',
        // 'recaptcha' => 'required|captcha'
      ];

      $messages = [
        'email.required' => 'Email is required',
        'password.required' => 'Password is required',

      ];
      $remember_me = $request->has('remember_me') ? true : false;

      $validator = Validator::make($input, $rules, $messages);

      if ($validator->fails()) {
        $gatewayURL = config('setting.api_gateway_url') . '/user/require_captcha';

        $input = array();
        $input['email'] = $request->email;
        $input['password'] = $request->password;
        $input['remember_me'] = $request->has('remember_me');

        $encryptArray = $this->encryptData($input);
        $request = array();
        $request['requestData'] = $encryptArray;
        $method = 'Method => LoginController => index';
        $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);


        $response = json_decode($response);

        if ($response->Status == 200 && $response->Success) {

          $modules = '';
          $screens = '';
          echo $validator->errors();
        }

        return back()->withErrors(['recaptcha' => ['Captcha is required']]);
      } else {



        $tokenResponse = $this->setToken($input['email'], $input['password'],);
        if ($tokenResponse == 'Failure') {
          if (isset($request->mobile)) {
            return [
              'code' => 401,
              'Message' => "Invalid user name or password"
            ];
          }
          return back()->withErrors(['recaptcha' => ['Invalid user name or password']]);
        } else if ($tokenResponse == 'Disabled') {
          if (isset($request->mobile)) {
            return [
              'code' => 401,
              'Message' => "User disabled contact TALENTRA Administrator"
            ];
          }

          return back()->withErrors(['recaptcha' => ['User disabled contact TALENTRA Administrator']]);
        }

        $gatewayURL = config('setting.api_gateway_url') . '/login/user';
        $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

        $response = json_decode($response);



        if ($response->Status == 401) {
          if (isset($request->mobile)) {
            return [
              'code' => $response->Status,
              'Message' => "Invalid user name or password"
            ];
          }
          // echo "fjhg";exit;
          return back()->withErrors(['recaptcha' => ['Invalid user name or password']]);
        }



        //dd($response);
        if ($response->Status == 200 && $response->Success) {
          $objData = json_decode($this->decryptData($response->Data));

          if ($objData->Code == 200) {
            $objRows = $objData->Data;

            $role_id = $objData->Role;
            $active_flag = $objData->active;

            $gd_status = $objData->gd_status;
            $alter_name = $objData->alter_name;
            $row = json_decode(json_encode($objRows), true);
            session(['role_name' => $alter_name]);
            session(['userID' => $row[0]['id']]);
            session(['gd_status' => $gd_status]);
            session(['role_id' => $role_id]);
            // dd("sdaecsca");
            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            if (isset($request->mobile)) {
              $rows['role_id'] = $role_id;
              $rows['code'] = $objData->Code;
              $rows['user_id'] = $row[0]['id'];

              return $rows;
              exit;
              return "2";
            }
            if ($role_id == '1' && $role_id == '41') {
              return redirect(route('elearningDashboard'));
            } else {
              return redirect(route('elearningDashboard'));
            }

            // if ($role_id == '27') {
            //   if ($request->exid != 0) {

            //     return redirect(url('/' . $request->exid));
            //   }
            //   if ($active_flag == '0') {
            //     if ($request->exid != 0) {
            //       return redirect(url('/' . $request->exid));
            //     }
            //     return redirect(route('home'));
            //   } else {
            //     if ($request->exid != 0) {
            //       return redirect(url('/' . $request->exid));
            //     }
            //     return redirect(route('home'));
            //   }
            // } else if ($role_id == '33') {
            //   if ($request->exid != 0) {
            //     return redirect(url('/' . $request->exid));
            //   }
            //   if ($active_flag == '1') {
            //     if ($request->exid != 0) {
            //       return redirect(url('/' . $request->exid));
            //     }
            //     return redirect(route('home'));
            //   } else {
            //     return redirect(route('firm_index'));
            //   }
            // } else {
            //   if ($request->exid != 0) {
            //     return redirect(config('setting.base_url') . $request->exid);
            //   }
            //   return redirect(route('home'));
            // }
          }
        }
      }
    } catch (\Exception $exc) {
      echo $exc->getMessage();
      exit;
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }

  public function logout(Request $request)
  {
    try {
      $method = 'Method => LoginController => logout';


      $gatewayURL = config('setting.api_gateway_url') . '/user/logout';

      $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

      // echo json_encode($response);exit;
      $response = json_decode($response);



      $request->session()->invalidate();
      return redirect(url('/'));
    } catch (\Exception $exc) {
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }



  public function faqpage()
  {
    $menus = $this->FillMenu();
    $screens = $menus['screens'];
    $modules = $menus['modules'];

    return view('faq', compact('modules', 'screens'));
  }

  public function profilepage()
  {
    try {
      $method = 'Method => LoginController => profilepage';

      $userRow = array();
      $userRow['email'] = "sdsfs";

      $gatewayURL = config('setting.api_gateway_url') . '/user/profilepage';
      $encryptArray = $this->encryptData($userRow);
      $request = array();
      $request['requestData'] = $encryptArray;

      $response1 = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
      $response = json_decode($response1);
      if ($response->Status == 200 && $response->Success) {
        $objData = json_decode($this->decryptData($response->Data));
        if ($objData->Code == 200) {
          $parant_data = json_decode(json_encode($objData->Data), true);
          $one_row =  $parant_data['user'];

          //echo json_encode($one_row);exit;

          $menus = $this->FillMenu();
          $screens = $menus['screens'];
          $modules = $menus['modules'];
          return view('profilepage', compact('one_row', 'modules', 'screens'));
        }
      } else {
        $objData = json_decode($this->decryptData($response->Data));
        echo json_encode($objData->Code);
        exit;
      }
    } catch (\Exception $exc) {
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }


  public function settingspage()
  {
    $menus = $this->FillMenu();
    $screens = $menus['screens'];
    $modules = $menus['modules'];


    return view('faq', compact('modules', 'screens'));
  }

  public function privacypage()
  {

    try {
      $method = 'Method => PrivacyPolicyController => policy_screen';

      $gatewayURL = config('setting.api_gateway_url') . '/privacy/policy_screen';
      $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
      $response = json_decode($response);
      if ($response->Status == 200 && $response->Success) {
        $objData = json_decode($this->decryptData($response->Data));
        if ($objData->Code == 200) {
          $parant_data = json_decode(json_encode($objData->Data), true);
          $rows =  $parant_data['rows'];

          $gatewayURL = config('setting.api_gateway_url') . '/login/background';
          $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
          $response = json_decode($response);
          if ($response->Status == 200 && $response->Success) {
            $objData = json_decode($this->decryptData($response->Data));
            if ($objData->Code == 200) {
              $parant_data = json_decode(json_encode($objData->Data), true);
              $rows1 =  $parant_data['rows'];
              // $one_row =  $parant_data['one_rows'];


              return view('auth.privacy', compact('rows', 'rows1'));
            }
          }
        }
      } else {
        $objData = json_decode($this->decryptData($response->Data));
        echo json_encode($objData->Code);
        exit;
      }
    } catch (\Exception $exc) {
      echo $exc;
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }


  public function reset($id)
  {

    try {
      $method = 'Method => LoginController => reset';

      $gatewayURL = config('setting.api_gateway_url') . '/user/reset/' . $id;
      $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
      $response = json_decode($response);
      if ($response->Status == 200 && $response->Success) {
        $objData = json_decode($this->decryptData($response->Data));

        //echo json_encode($objData);exit;
        if ($objData->Code == 200) {
          // $parant_data = json_decode(json_encode($objData->Data), true);
          // $rows =  $parant_data['rows'];
          // $one_row =  $parant_data['one_rows'];
          // $menus = $this->FillMenu();
          // $screens = $menus['screens'];
          // $modules = $menus['modules'];
          // return view('uam.uam_modules.edit', compact('rows','one_row','modules','screens'));

          $email = $this->decryptData($id);
          return view('auth.reset', compact('email'));
        }

        if ($objData->Code == 400) {
          return redirect()->route('tokenexpire');
        }
      } else {
        $objData = json_decode($this->decryptData($response->Data));
        echo json_encode($objData->Code);
        exit;
      }
    } catch (\Exception $exc) {
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }

  public function reset_password(Request $request)
  {

    //return $request;

    try {
      $method = 'Method => LoginController => reset_password';
      $input = [
        'email' => $request->email,
        'password' => $request->password,
        'c_password' => $request->c_password,
      ];
      $rules = [
        'password' => 'required|string|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
        'c_password' => 'required|same:password',
      ];

      $messages = [
        'password.required' => 'Password is required',
        'c_password.required' => 'Please enter same password'
      ];

      $validator = Validator::make($request->all(), $rules, $messages);

      if ($validator->fails()) {
        return Redirect::back()->withErrors($validator);
      } else {

        $gatewayURL = config('setting.api_gateway_url') . '/user/reset_password';

        //echo $gatewayURL;exit;

        $userRow = array();
        $userRow['password'] = $request->password;
        $userRow['email'] = $request->email;
        $encryptArray = $this->encryptData($userRow);
        $request = array();
        $request['requestData'] = $encryptArray;

        ///  echo json_encode($request);exit;

        $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
        $response = json_decode($response);
        //  echo json_encode($response);exit;
        if ($response->Status == 200 && $response->Success) {

          $objData = json_decode($this->decryptData($response->Data));
          if ($objData->Code == 200) {
            return redirect(url('/'))->with('success', 'Password Changed Successfully');
          }

          if ($objData->Code == 400) {
            return Redirect::back()->with('fail', 'should not use the previous password');
          }
        }
      }
    } catch (\Exception $exc) {
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }

  public function forgot_password(Request $request)
  {
    $method = 'Method => LoginController => forgot_password';
   
    try {
      // Validate the request
      $validator = Validator::make($request->all(), [
        'email' => 'required|email'
      ], [
        'email.required' => 'Email is required',
        'email.email' => 'Email must be a valid email address',
      ]);

      if ($validator->fails()) {
        return Redirect::back()->withErrors($validator);
      }
     
      // Prepare data for API request
      $userRow['email'] = $request->email;
      $encryptArray = $this->encryptData($userRow);
      $request = array();
      $request['requestData'] = $encryptArray;
     
      $gatewayURL = config('setting.api_gateway_url') . '/user/forget_password';

      // Make API request
      $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
      $response = json_decode($response);

      
      if ($response->Status == 200 && $response->Success) {
        $objData = json_decode($this->decryptData($response->Data));
        dd($objData);
        if ($objData->Code == 200) {
          $parant_data = json_decode(json_encode($objData->Data), true);
          $response_status = $parant_data['response_status'];

          if ($response_status == "200") {
            return redirect(route('forgot'))->with('success', 'Reset password link sent to your email');
          }

          if ($response_status == "300") {
            return redirect(route('forgot'))->with('success', 'User email not found. Please check');
          }
        }
      }
    } catch (\Exception $exc) {
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }


  public function profile_update(Request $request)
  {
    try {
      $method = 'Method => LoginController => profile_update';


      if ($request->file('signature_attachment')) {

        $galleryId =  $request->user_id;
        $path = public_path() . '/user_signature/' . $galleryId;
        File::makeDirectory($path, $mode = 0777, true, true);
        $storagePath = $path;
        $imageFile = $request->file('signature_attachment');
        $imageName = base64_encode($request->file('signature_attachment')->getClientOriginalName()) . '.' . $request->file('signature_attachment')->extension();
        $imageNamecheck = str_replace(' ', '_', $imageName);
        $imageFile->move($storagePath, $imageNamecheck);
        $galleryId =  $request->user_id;
        $path1 = '/user_signature/' . $galleryId;
        $imageorgname = $path1 . '/' . $imageNamecheck;
        $userRow = array();
        $userRow['signature_attachment'] = $imageorgname;
        $userRow['profile_path'] = $storagePath;
      } else {
        $userRow['signature_attachment'] = " ";
        $userRow['signature'] = $request->signature;
        $userRow['profile_path'] = " ";
      }
      $userRow['phone_number'] = $request->phone_number;
      $userRow['user_id'] = $request->user_id;
      $gatewayURL = config('setting.api_gateway_url') . '/user/profile_update';
      $encryptArray = $this->encryptData($userRow);
      $request = array();
      $request['requestData'] = $encryptArray;
      $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
      $response = json_decode($response);
      if ($response->Status == 200 && $response->Success) {
        $objData = json_decode($this->decryptData($response->Data));
        if ($objData->Code == 200) {
          $parant_data = json_decode(json_encode($objData->Data), true);
          $response_status =  $parant_data['response_status'];
          echo json_encode($response_status);
        }
        if ($response_status == "300") {
          return redirect(route('forgot'))->with('success', 'User Mail id not found please check');
        }
      }





      // }

    } catch (\Exception $exc) {
      return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    }
  }
}
