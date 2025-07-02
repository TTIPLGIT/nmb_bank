<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as ControllersBaseController;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Filesystem;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class BaseController extends Controller
{
    /**
     * Author: Anbukani
     * Date: 16/09/2019
     * Description: API service request.
     */

     
    public function serviceRequest($gatewayURL, $action, $body, $method)
    {
        // echo json_encode($body);exit; 
        try {
            $client = new Client();
            $authorization = 'Bearer ' . session('accessToken');
            //  echo json_encode($authorization);exit;

              // Debug logs
  

            $serviceResponse = $client->request($action, $gatewayURL, [
                'headers' => [
                    'Authorization' => $authorization,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Cache-Control' => 'no-cache'
                ],
                'body' => $body
            ])->getBody()->getContents();
            $objServiceResponse = json_decode($serviceResponse);

            if ($objServiceResponse->Status == 401) {
                // echo "fjhg";exit;
                return redirect()->route('unauthenticated')->send();
                return $serviceResponse;
            } else {
                return $serviceResponse;
            }
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = 'Method => BaseController => serviceRequest';
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            return 'Failure';
        }
    }

    /**
     * Author: Anbukani
     * Date: 16/09/2019
     * Description: API token request based on username and password.
     */
    public function tokenRequest($userName, $password)
    {
        try {

            $client = new Client();
            // dd($client);
            $serviceURL = Config::get('setting.api_gateway_url') . '/service/token';

            //echo $serviceURL;exit;


            $serviceRequest = array();
            $serviceRequest['email'] = $userName;
            $serviceRequest['password'] = $password;
            $serviceRequest = json_encode($serviceRequest, JSON_FORCE_OBJECT);
            // dd($serviceURL);
            $serviceResponse = $client->request('POST', $serviceURL, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Cache-Control' => 'no-cache',
                    'Accept' => 'application/json'
                ],
                'body' => $serviceRequest
            ])->getBody()->getContents();


            //return $response->getBody()->getContents();
            return $serviceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = 'Method => BaseController => tokenRequest';
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            return 'Failure';
        }
    }
    public function AuditLog($tableName, $key, $action, $description, $user, $time, $role_name)
    {

        // $this->login()
        try {
            DB::table('audit_logs')->insert([
                'audit_table_name' => $tableName,
                'audit_table_id' => $key,
                'audit_action' => $action,
                'description' => $description,
                'user_id' => $user,
                'action_date_time' => $time,
                'role_name' => $role_name
            ]);
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = 'Method => BaseController => AuditLog';
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            //return 'Failure';
        }
    }

    /**
     * Author: Anbukani
     * Date: 16/09/2019
     * Description: Save token and refresh token into session variable for testing purpose only.
     */
    public function setToken($user, $password)
    {
        try {

            $serviceResponse = $this->tokenRequest($user, $password);
            $objServiceResponse = json_decode($serviceResponse);

            // echo json_encode($objServiceResponse);exit;

            if ($objServiceResponse->Status == 200 && $objServiceResponse->Success) {
                $tokenResponse = $this->decryptData($objServiceResponse->Data);
                $objTokenResponse = json_decode($tokenResponse);
                $tokenType = $objTokenResponse->token_type;
                $accessToken = $objTokenResponse->access_token; //echo $accessToken;exit;
                session(['accessToken' => $accessToken]);
                return 'Success';
            } else if ($objServiceResponse->Status == 500) {

                return 'Disabled';
            } else {
                return  'Failure';
            }

            $tokenResponse = $this->decryptData($objServiceResponse->Data);
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = 'Method => BaseController => setToken';
            $exceptionResponse['Message'] = $tokenResponse;
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            if ($objServiceResponse->Status == 401) {
                //echo "dgdgdfg";exit;


                //return redirect()->route('unauthenticated')->send();
            }
            return 'Failure';
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = 'Method => BaseController => setToken';
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            return 'Failure';
        }
    }

    /**
     * Author: Anbukani
     * Date: 16/09/2019
     * Description: Encrypt data.
     */
    public function encryptData($data)
    {
        try {
            $d = Crypt::encrypt($data);
            return $d;
        } catch (\Exception $exc) {
            Log::error('Method => BaseController => encryptData => Encrypt data error =>: [' . $exc->getCode() . '] ' . $exc->getMessage());
            return 'Failure';
        }
    }

    /**
     * Author: Anbukani
     * Date: 16/09/2019
     * Description: Decrypt data.
     */
    public function decryptData($data)
    {
      
        try {
             
            return Crypt::decrypt($data);
        } catch (\Exception $exc) {
            Log::error('Method => BaseController => decryptData => Decrypt data error =>: [' . $exc->getCode() . '] ' . $exc->getMessage());
            return 'Failure';
        }
    }

    /**
     * Author: Anbukani
     * Date: 04/06/2021
     * Description: Write error in text file.
     **/
    public function WriteFileLog($request)
    {
        try {
            Log::error($request);
        } catch (\Exception $exc) {
            Log::error('Method => BaseController => WriteFileLog => Write log file error =>: [' . $exc->getCode() . '] ' . $exc->getMessage());
        }
    }

    /**
     * Author: Anbukani
     * Date: 16/09/2019
     * Description: Write log file.
     */
    public function sendLog($method, $code, $message, $line, $file)
    {
        try {
            Log::error($method . ': [' . $code . '] "' . $message . '" on line ' . $line . ' of file ' . $file);
            return view('errors.errors');
        } catch (\Exception $exc) {
            Log::error('[Decrypt data error => ' . $exc->getCode() . '] "' . $exc->getMessage() . '" on line ' . $exc->getTrace()[0]['line'] . ' of file ' . $exc->getTrace()[0]['file']);
            return view('errors.errors');
        }
    }

    /**
     * Author: Anbukani
     * Date: 18/08/2021
     * Description: Date display format.
     */
    public function getFormat($df)
    {
        $str = '';
        $str .= ($df->invert == 1) ? ' - ' : '';
        if ($df->y > 0) {
            // years
            $str .= ($df->y > 1) ? $df->y . ' Years ' : $df->y . ' Year ';
        }
        if ($df->m > 0) {
            // month
            $str .= ($df->m > 1) ? $df->m . ' Months ' : $df->m . ' Month ';
        }
        if ($df->d > 0) {
            // days
            $str .= ($df->d > 1) ? $df->d . ' Days ' : $df->d . ' Day ';
        }
        if ($df->h > 0) {
            // hours
            $str .= ($df->h > 1) ? $df->h . ' Hours ' : $df->h . ' Hour ';
        }
        if ($df->i > 0) {
            // minutes
            $str .= ($df->i > 1) ? $df->i . ' Minutes ' : $df->i . ' Minute ';
        }
        if ($df->s > 0) {
            // seconds
            $str .= ($df->s > 1) ? $df->s . ' Seconds ' : $df->s . ' Second ';
        }

        return $str;
    }

    /**
     * Author: Anbukani
     * Date: 16/09/2019
     * Description: Send error message.
     */
    public function sendError($error, $errorMessages = [], $code = 400)
    {
        $response = [
            'Success' => false,
            'Message' => $error,
            'Status' => 400
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }


    public function FillMenu()
    {
        $method = 'uam => BaseController => FillMenu';
        try {
            $gatewayURL = config('setting.api_gateway_url') . '/uam_data/menu_data';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            // dd($response);


            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $menu_data = json_decode(json_encode($objData->Data), true);
                    return $menu_data;
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {
            echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    public function FillScreensByUser()
    {

        $url =  request()->segment(1);

        $method = 'Method => BaseController => FillScreensByUser';

        try {
            $screenurl = $this->encryptData($url);


            $gatewayURL = config('setting.api_gateway_url') . '/uam_data/fillscreensbasedonuser/' . $screenurl;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);


            $response = json_decode($response);
            if ($response->Status == 401) {

                return redirect()->route('unauthenticated')->send();
            }
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $menu_data = json_decode(json_encode($objData->Data), true);
                    $screen_permission = $menu_data['screen_permission'];
                    return $screen_permission;
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {
            echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function FillDyanamiclist()
    {
        $url =  request()->segment(1);
        $method = 'Method => BaseController => FillScreensByUser';
        try {
            $screenurl = $this->encryptData($url);
            $gatewayURL = config('setting.api_gateway_url') . '/uam_data/filldynamiclist/' . $screenurl;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $menu_data = json_decode(json_encode($objData->Data), true);

                    return $menu_data;
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {
            echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function FillDyanamiclistdocument()
    {
        $seg1 = request()->segment(1);
        $seg2 = request()->segment(2);
        // $seg3 = request()->segment(3);

        $url = $seg1 . '/' . $seg2;

        // $this->WriteFileLog($url);
        $method = 'Method => BaseController => FillScreensByUser';
        try {
            $screenurl = $this->encryptData($url);
            $gatewayURL = config('setting.api_gateway_url') . '/uam_data/filldynamiclist/' . $screenurl;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $menu_data = json_decode(json_encode($objData->Data), true);

                    return $menu_data;
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {
            echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }




    public function FillScreensByDash()
    {
        $url =  request()->segment(1);
        $method = 'Method => BaseController => FillScreensByDash';
        try {
            $screenurl = $this->encryptData($url);
            $gatewayURL = config('setting.api_gateway_url') . '/uam_data/fillscreensbasedondash/' . $screenurl;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $menu_data = json_decode(json_encode($objData->Data), true);
                    $screen_permission = $menu_data['screen_permission'];
                    return $screen_permission;
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {
            echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }



    public function FillScreensByUserScreen()
    {
        $method = 'Method => BaseController => FillScreensByUserScreen';
        $seg1 = request()->segment(1);
        $seg2 = request()->segment(2);
        // $seg3 = request()->segment(3);

        $url = $seg1 . '/' . $seg2;


        //$url =  request()->segment(1);
        try {
            $screenurl = $this->encryptData($url);
            $gatewayURL = config('setting.api_gateway_url') . '/uam_data/fillscreensbasedonuser/' . $screenurl;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $menu_data = json_decode(json_encode($objData->Data), true);
                    $screen_permission = $menu_data['screen_permission'];
                    return $screen_permission;
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {
            echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }



    public function FillScreensByDocument()
    {

        $seg1 = request()->segment(1);
        $seg2 = request()->segment(2);
        $seg3 = request()->segment(3);

        $url = $seg1 . '/' . $seg2 . '/' . $seg3;
        $method = 'Method => BaseController => FillScreensByDocument';


        //$url =  request()->segment(1);
        try {
            $screenurl = $this->encryptData($url);
            $gatewayURL = config('setting.api_gateway_url') . '/uam_data/fillscreensbasedondocument/' . $screenurl;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $menu_data = json_decode(json_encode($objData->Data), true);
                    $screen_permission = $menu_data['screen_permission'];
                    return $screen_permission;
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {
            echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    public function FillScreensByDocument_file()
    {

        // $seg1 = request()->segment(1);
        // $seg2 = request()->segment(2);
        // $seg3 = request()->segment(3);

        $url = "folder/file/index";

        $method = 'Method => BaseController => FillScreensByDocument';
        //$url =  request()->segment(1);
        try {
            $screenurl = $this->encryptData($url);
            $gatewayURL = config('setting.api_gateway_url') . '/uam_data/fillscreensbasedondocument/' . $screenurl;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $menu_data = json_decode(json_encode($objData->Data), true);
                    $screen_permission = $menu_data['screen_permission'];
                    return $screen_permission;
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

    // TALENTRA TEAM

    public function getusermail($id)
    {
        try {
            $users = DB::SELECT("SELECT name,email from users where id=$id");
            $email = $users[0]->email;
            return $email;
        } catch (\Exception $exc) {
            Log::error('Method => BaseController => DecryptData => Decrypt data error =>: [' . $exc->getCode() . '] ' . $exc->getMessage());
            return 'Failure';
        }
    }

    public static function getusername($id)
    {
        try {

            $users = DB::SELECT("SELECT name,email from users where id=$id");
            $name = $users[0]->name;
            return $name;
        } catch (\Exception $exc) {
            Log::error('Method => BaseController => getusername => getusername data error =>: [' . $exc->getCode() . '] ' . $exc->getMessage());
            return 'Failure';
        }
    }
    public function notifications_insert($role_id, $user_id, $notification_status, $notification_url)
    {
        $notifications = DB::table('notifications')->insertGetId([
            'role_id' => $role_id,
            'user_id' => $user_id,
            'notification_status' => $notification_status,
            'notification_url' => $notification_url,
            'megcontent' => $notification_status,
            'alert_meg' => $notification_status,
            'created_by' => $user_id,
            'created_at' => NOW()
        ]);
        return $notifications;
    }
    public function get_user_role()
    {
        try {
            $user_id = session()->get("userID");
            $alter_name = DB::table('uam_user_roles')
                ->join('uam_roles', 'uam_roles.role_id', '=', 'uam_user_roles.role_id')
                ->join('users', 'users.id', '=', 'uam_user_roles.user_id')
                ->where('uam_user_roles.user_id', $user_id)
                ->select('uam_roles.alter_name', 'users.role_designation')
                ->first();
            return $alter_name;
        } catch (\Exception $exc) {
            return ($exc);
            Log::error('Method => BaseController => get_user_role => get_user_role data error =>: [' . $exc->getCode() . '] ' . $exc->getMessage());
            return 'Failure';
        }
    }
    public function apiCall($method, $opearation, $url, $request = null)
    {
        try {
            $requestData = $request != null ? json_encode($request) : '';
            $gatewayURL = config('setting.api_gateway_url') . $url;
            $response = $this->serviceRequest($gatewayURL, $opearation, $requestData, $method);
            return json_decode($response);
        } catch (\Exception $exc) {
            Log::error('Method => BaseController => get_user_role => get_user_role data error =>: [' . $exc->getCode() . '] ' . $exc->getMessage());
            return 'Failure';
        }
    }
    public function documentNameFilter($name)
    {
        try {
            $findspace = array(' ', '&');
            $replacewith = array('-', '-');
            $filteredName = str_replace($findspace, $replacewith, $name);
            return $filteredName;
        } catch (\Exception $exc) {
            return ($exc);
            Log::error('Method => BaseController => documentNameFilter => documentNameFilter data error =>: [' . $exc->getCode() . '] ' . $exc->getMessage());
            return 'Failure';
        }
    }
}
