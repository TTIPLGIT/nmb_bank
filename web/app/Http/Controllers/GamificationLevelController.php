<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class GamificationLevelController extends BaseController
{
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
        $gatewayURL = config('setting.api_gateway_url') . '/level/getAll';

        $response = json_decode($this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method));
        if ($response->Status == 200 && $response->Success) {
            $objData = json_decode($this->decryptData($response->Data));
            $parant_data = json_decode(json_encode($objData->Data), true);
            $levels = $parant_data['levels'];
            // dd($levels);
        }
        return view("Gamifications.levels", compact('screens', 'modules','levels'));
    }

    public function createpage(Request $request)
    {

        $menus = $this->FillMenu();

        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view("Gamifications.createlevels", compact('screens', 'modules'));
    }
    public function store(Request $request)
    {


        try {
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }

            $menus = $this->FillMenu();
            $method = 'Method =>GamificationLevelController => store';

            if ($menus == "401") {
                return redirect(url('/'))->with('danger', 'User session expired');
            }
            $data = [
                'level_number' => $request->level_number,
                'level_name' => $request->level_name,
                'min_point' => $request->min_points,
                'max_point' => $request->max_points,
            ];
            

            $encryptArray = $this->encryptData($data);
            $requestPayload = ['requestData' => $encryptArray];

            $gatewayURL = config('setting.api_gateway_url') . '/level_create_store';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($requestPayload), $method);

            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    return redirect()->route('level_master_page')->with('success', 'Level created successfully.');
                }

                return back()->with('fail', 'Not added: ' . ($objData->Message ?? 'Unknown error'));
            }

            return redirect()->route('level_master_page');
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
}
