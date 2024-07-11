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
use Illuminate\Support\Facades\DB;

class ReportsController extends BaseController
{

    public function index(Request $request)
    {
        try {
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }   

            $method = 'Method => ReportsController => index';

            $course = DB::select("SELECT course_id,course_name FROM elearning_courses");
            $menus = $this->FillMenu();
            if ($menus == "401") {
                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
            $screens = $menus['screens'];
            $modules = $menus['modules'];

            return view('Reports.index', compact('menus', 'screens', 'modules','course'));
        } catch (\Exception $exc) {
            return view('errors.errors');
        }
    }

    public function report_fetch(Request $request)
    {
        try {
            $method = 'Method => ReportsController => report_fetch';
            $id = $request->session()->get("userID");
            if ($id == null) {
                return view('auth.login');
            }
            $data = array();
            $data['module_name'] = $request->module_name;
            $data['process_name'] = $request->process_name;
            $data['status_by'] = $request->status_by;
            $data['from_date'] = $request->from_date;
            $data['to_date'] = $request->to_date;
            $data['role_by'] = $request->role_by;
            $data['license_by'] = $request->license_by;
            $data['license_status'] = $request->license_status;
            $data['gtstatus'] = $request->gtstatus;
            $data['valuer_type'] = $request->valuer_type;
            $data['valuer_status'] = $request->valuer_status;
            $data['payment_type'] = $request->payment_type;
            $data['course_details'] = $request->course_details;
            $data['courselist'] = $request->courselist;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;

            

            $gatewayURL = config('setting.api_gateway_url') . '/report/fetch';

            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
            $response = json_decode($response);

            $objData = json_decode($this->decryptData($response->Data));
            $code = $objData->Code;
            $user_report = json_decode(json_encode($objData->Data), true);
            return $user_report;
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

}
