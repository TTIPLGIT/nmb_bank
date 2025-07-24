<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Psy\Readline\Hoa\Console;
use Illuminate\Support\Facades\Redirect;

class elearningdashboardgtController extends BaseController
{
    public function dashboard(Request $request)
    {
      
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => elearningController => dashboard';
        try {

            // dd($user_id);
            $request =  array();
            $request['mlhud_id'] = $user_id;


            $gatewayURL = config('setting.api_gateway_url') . '/elearningDashboard';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $response = json_decode($response);
           
            $objData = json_decode($this->decryptData($response->Data));
            $code = $objData->Code;
            if ($code == "401") {

                return redirect()->route('unauthenticated')->send();
            }

            $rows = json_decode(json_encode($objData->Data), true);

            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];

            
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows = $parant_data['rows'];
                    $count = $parant_data['dasboardCount'];
                   
                    $recommended = $parant_data['recomment_courses'];
                    return view('elearning.dashboard', compact('rows', 'menus', 'screens', 'modules', 'user_id', 'recommended', 'count'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {
            //dd("bhj");
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

     public function your_achievements(Request $request)
    {
      
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => elearningController => dashboard';
        try {

            // dd($user_id);
            $request =  array();
            $request['mlhud_id'] = $user_id;


            $gatewayURL = config('setting.api_gateway_url') . '/yourAchievements';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $response = json_decode($response);
           
            $objData = json_decode($this->decryptData($response->Data));
            $code = $objData->Code;
            if ($code == "401") {

                return redirect()->route('unauthenticated')->send();
            }

            $rows = json_decode(json_encode($objData->Data), true);

            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];

           
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $rawResults = json_decode(json_encode($objData->Data), true);
                   
                
                   
                   
                    return view('achievements.your_achievement', compact('menus', 'screens', 'modules', 'rawResults'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {
            //dd("bhj");
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function events_fetch(Request $request)
    {
        $method = 'Method => elearningController => events_fetch';

        try {
            // $user_id = $request->session()->get("userID");
            // if ($user_id == null) {
            //     return view('auth.login');
            // }
            $data['event_date'] = $request->event_date;
            $this->WriteFileLog($data);
            $encryptArray = $this->encryptData($data);

            $request = array();
            $request['requestData'] = $encryptArray;


            $gatewayURL = config('setting.api_gateway_url') . '/dashboardevents/fetch';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $this->WriteFileLog($response);
            $response1 = json_decode($response);
            $objData = json_decode($this->decryptData($response1->Data));
            $rows = json_decode(json_encode($objData->Data), true);
            foreach ($rows['rows'] as $key => $row) {
                $filePath = $row['event_path'] . '/' . $row['event_image'];
                // $this->WriteFileLog($filePath);

                $filePath = substr($filePath, 1);
                 $this->WriteFileLog('$rows');
                //     $this->WriteFileLog('uploads/notice/126/Screenshot-(4).png');
                if (file_exists($filePath)) {
                } else {
                    $this->WriteFileLog('$false');
                    $rows['rows'][$key]['event_image'] =  '/empty.jpg';
                }
                //  $this->WriteFileLog("grfdtgh", file_exists(substr($filePath, 1)));
            }
            $this->WriteFileLog('$rows');
            return $rows;
        } catch (\Exception $exc) {
            echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
}