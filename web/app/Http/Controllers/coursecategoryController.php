<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class coursecategoryController extends BaseController
{

    // Quiz Start

    public function index(Request $request)
    {

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $menus = $this->FillMenu();

        if ($menus == "401") {
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        $method = "GET";
        $gatewayURL = config('setting.api_gateway_url') . '/categories/getAll';

        $response = json_decode($this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method));
        if ($response->Status == 200 && $response->Success) {
            $objData = json_decode($this->decryptData($response->Data));
            $parant_data = json_decode(json_encode($objData->Data), true);
            $categories = $parant_data['categories'];
        }
        return view("coursecategory.coursecategory", compact('screens', 'modules', 'categories'));
        //
    }

    public function createpage(Request $request)
    {

        $menus = $this->FillMenu();

        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view("coursecategory.coursecategorycreate", compact('screens', 'modules'));
    }



    public function store(Request $request)
    {


        try {
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }

            $menus = $this->FillMenu();
            $method = 'Method => coursecategoryController => store';

            if ($menus == "401") {
                return redirect(url('/'))->with('danger', 'User session expired');
            }
            $data = [
                'catagory_name' => $request->catagory_name,
                'sub_catagory' => $request->sub_catagory,
                'description' => $request->description,
                'badge' => $request->badge,
                'badge_name' => $request->badge_name,
                'badge_count' => $request->badge_count,
                'badge_icon' => $request->badge_icon,
                'streak_challenge' => $request->streak_challenge,
                'streak_name' => $request->streak_name,
                'number_course_for_streak' => $request->number_course_for_streak,
                'bonus_point' => $request->bonus_point,
                'complete_within' => $request->complete_within,
                'complete_within_type' => $request->complete_within_type,
                'streak_icon' => $request->streak_icon,
                'course_locked' => $request->course_locked,
                'points_to_unlock' => $request->points_to_unlock,
            ];


            $encryptArray = $this->encryptData($data);
            $requestPayload = ['requestData' => $encryptArray];

            $gatewayURL = config('setting.api_gateway_url') . '/catagory_create';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($requestPayload), $method);

            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    return redirect()->route('catagory_list')->with('success', 'Category created successfully.');
                }

                return back()->with('fail', 'Not added: ' . ($objData->Message ?? 'Unknown error'));
            }

            return redirect()->route('catagory_list');
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function update(Request $request)
    {

        try {
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }

            $menus = $this->FillMenu();
            $method = 'Method => coursecategoryController => update';

            if ($menus == "401") {
                return redirect(url('/'))->with('danger', 'User session expired');
            }
            $data = [
                'catagory_name' => $request->catagory_name,
                'sub_catagory' => $request->sub_catagory,
                'description' => $request->description,
                'catagory_id' => $request->catagory_id,
                'badge' => $request->badge,
                'badge_name' => $request->badge_name,
                'badge_count' => $request->badge_count,
                'badge_icon' => $request->badge_icon,
                'streak_challenge' => $request->streak_challenge,
                'streak_name' => $request->streak_name,
                'number_course_for_streak' => $request->number_course_for_streak,
                'bonus_point' => $request->bonus_point,
                'complete_within' => $request->complete_within,
                'complete_within_type' => $request->complete_within_type,
                'streak_icon' => $request->streak_icon,
                'course_locked' => $request->course_locked,
                'points_to_unlock' => $request->points_to_unlock,
            ];
         




            $encryptArray = $this->encryptData($data);
            $requestPayload = ['requestData' => $encryptArray];

            $gatewayURL = config('setting.api_gateway_url') . '/catagory_update';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($requestPayload), $method);

            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    return redirect()->route('catagory_list')->with('success', 'Category Updated successfully.');
                }

                return back()->with('fail', 'Not added: ' . ($objData->Message ?? 'Unknown error'));
            }

            return redirect()->route('catagory_list');
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        return redirect()->route('catagory_list');
    }

    public function course_catagory_fetch(Request $request)
    {

        $this->WriteFileLog($request);
        try {
            $this->WriteFileLog("feef");
            $method = 'Method => coursecategoryController => course_catagory_fetch';

            $data['catagory_id'] = $request->catagory_id;

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $this->WriteFileLog($data);
            $gatewayURL = config('setting.api_gateway_url') . '/course/catagory_fetch';
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
    public function course_catagory_delete(Request $request)

    { {

            try {
                $user_id = $request->session()->get("userID");
                if ($user_id == null) {
                    return view('auth.login');
                }

                $menus = $this->FillMenu();
                $method = 'Method => coursecategoryController => course_catagoryupdate';

                if ($menus == "401") {
                    return redirect(url('/'))->with('danger', 'User session expired');
                }
                $data = [
                    'catagory_name' => $request->catagory_name,
                    'sub_catagory' => $request->sub_catagory,
                    'description' => $request->description,
                    'catagory_id' => $request->catagory_id
                ];




                $encryptArray = $this->encryptData($data);
                $requestPayload = ['requestData' => $encryptArray];

                $gatewayURL = config('setting.api_gateway_url') . '/course_catagory_delete';

                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($requestPayload), $method);

                $response1 = json_decode($response);

                if ($response1->Status == 200 && $response1->Success) {
                    $objData = json_decode($this->decryptData($response1->Data));

                    if ($objData->Code == 200) {
                        return redirect()->route('catagory_list')->with('success', 'Category created successfully.');
                    }

                    return back()->with('fail', 'Not added: ' . ($objData->Message ?? 'Unknown error'));
                }

                return redirect()->route('catagory_list');
            } catch (\Exception $exc) {
                return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
            }
            return redirect()->route('catagory_list');
        }
    }
}
