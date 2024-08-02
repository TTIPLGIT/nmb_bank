<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class auditlogcontroller extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login_index(Request $request)
    {

        $from_date = "";
        $to_date = "";
        $user = $request->session()->get("userID");
        $user_id = "";
        if ($user == null) {
            return view('auth.login');
        }
        $method = 'Method => LoginController => Register_screen';
        $request =  array();
        $request['user_id'] = $user;
        $gatewayURL = config('setting.api_gateway_url') . '/auditlog/login';
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
        return view('audit_log.index', compact('to_date', 'from_date', 'rows', 'user_id', 'menus', 'screens', 'modules'));
    }
    public function login_search(Request $request)
    {
        $logMethod = 'Method => AuditlogController => login_search';
        try {

            $user_id = $request->user_id;



            $from_date = $request->from_date;
            // echo json_encode($receipt_no);exit;
            $to_date = $request->to_date;


            if (empty($user_id) && empty($from_date)  && empty($to_date)) {

                // echo "kjh";exit;

                return redirect(url('auditlog'))->with('error', 'No Input for Search');
            }
            $gatewayURL = config('setting.api_gateway_url') . '/auditlog/login';
            // echo $gatewayURL;exit;
            $data = array();
            $data['user_id'] = $user_id;
            $data['from_date'] = $from_date;
            $data['to_date'] = $to_date;


            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $logMethod);

            $response = json_decode($response);


            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $rows = json_decode(json_encode($objData->Data), true);

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    $permission = $this->FillScreensByUser();
                    $screen_permission = $permission[0];
                    return view('audit_log.index', compact('modules', 'screens', 'from_date', 'user_id', 'to_date', 'rows'));
                }
            }
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $logMethod;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
        }
    }
    public function index()
    {
        //

    }


    public function uamlog(Request $request)
    {
        //
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => LoginController => Register_screen';

        $request =  array();
        $request['user_id'] = $user_id;

        $gatewayURL = config('setting.api_gateway_url') . '/auditlog/uam';
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);

        $response = json_decode($response);

        $objData = json_decode($this->decryptData($response->Data));
        $rows = json_decode(json_encode($objData->Data), true);

        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('audit_log.uam_log', compact('user_id', 'modules', 'screens', 'rows'));
    }
    public function vreglog(Request $request)
    {
        //
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => LoginController => Register_screen';

        $request =  array();
        $request['user_id'] = $user_id;
        $gatewayURL = config('setting.api_gateway_url') . '/auditlog/vreg';
        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);

        $response = json_decode($response);

        $objData = json_decode($this->decryptData($response->Data));
        $rows = json_decode(json_encode($objData->Data), true);

        $menus = $this->FillMenu();
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        return view('audit_log.valuer_registrationlog', compact('user_id', 'modules', 'screens', 'rows'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
