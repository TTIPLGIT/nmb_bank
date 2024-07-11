<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Psy\Readline\Hoa\Console;
use Illuminate\Support\Facades\Redirect;
use App\Models\course;

class elearningExamController extends BaseController
{
    public function index(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => elearningExamController => index';
        try {
            $request =  array();
            $request['mlhud_id'] = $user_id;
            $gatewayURL = config('setting.api_gateway_url') . '/examtest';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
            $response = json_decode($response);
            //dd($response);

            $objData = json_decode($this->decryptData($response->Data));
            //dd($objData);
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

            return view('elearningexam.index', compact('user_id', 'rows', 'menus', 'screens', 'modules'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => elearningExamController => store';
        try {
            $data = array();
            $data['user_category'] = $request->user_category;
            $data['exam_name'] = $request->exam_name;
            $data['quiz_id'] = $request->quiz_id;


            $encryptArray = $this->encryptData($data);
            $request = array();

            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/examtest/store';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    return redirect(route('elearningexam.index'))->with('success', 'Exam Created Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('elearningexam.index'))->with('fail', 'Exam Failed');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Show') !== false) {
            try {
                $method = 'Method => elearningExamController => show';
                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/examtest/show' . $this->encryptData($id);
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
                $response = json_decode($response);
                if ($response->Status == 200 && $response->Success) {
                    $objData = json_decode($this->decryptData($response->Data));
                    if ($objData->Code == 200) {
                        $parant_data = json_decode(json_encode($objData->Data), true);
                        $rows =  $parant_data['rows'];
                        // $one_row =  $parant_data['one_rows'];
                        $menus = $this->FillMenu();
                        $screens = $menus['screens'];
                        $modules = $menus['modules'];
                        return view('elearningexam.index', compact('rows', 'modules', 'screens'));
                    }
                } else {
                    $objData = json_decode($this->decryptData($response->Data));
                    return view('errors.errors');
                    exit;
                }
            } catch (\Exception $exc) {
                return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
            }
        } else {
            return redirect()->route('not_allow');
        }
    }





    /**
     * Show the form for editing tphe specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Edit') !== false) {
            try {
                $method = 'Method => elearningExamController => edit';
                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/examtest/edit' . $this->encryptData($id);
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
                $response = json_decode($response);
                if ($response->Status == 200 && $response->Success) {
                    $objData = json_decode($this->decryptData($response->Data));
                    if ($objData->Code == 200) {
                        $parant_data = json_decode(json_encode($objData->Data), true);
                        $rows =  $parant_data['rows'];
                        // $one_row =  $parant_data['one_rows'];
                        $menus = $this->FillMenu();
                        $screens = $menus['screens'];
                        $modules = $menus['modules'];
                        return view('elearningexam.index', compact('rows', 'modules', 'screens'));
                    }
                } else {
                    $objData = json_decode($this->decryptData($response->Data));
                    return view('errors.errors');
                    exit;
                }
            } catch (\Exception $exc) {
                return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
            }
        } else {
            return redirect()->route('not_allow');
        }
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

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => elearningExamController => update';

            $data = array();
            $data['user_category'] = $request->user_category;
            $data['exam_name'] = $request->exam_name;
            $data['quiz_id'] = $request->quiz_id;
            $data['eid'] = $request->eid;

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/examtest/update';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            //dd($response);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                return redirect(route('elearningexam.index'))->with('success', 'Exam Updated Successfully');
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function fetch(Request $request)
    {

        try {
            $this->WriteFileLog("feef");
            $method = 'Method => elearningExamController => fetch';
            // $user_id = $request->session()->get("userID");
            // if ($user_id == null) {
            //     return view('auth.login');
            // }
            $data['id'] = $request->id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;


            $gatewayURL = config('setting.api_gateway_url') . '/exam/fetch';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $this->WriteFileLog($response);
            $response1 = json_decode($response);
            $objData = json_decode($this->decryptData($response1->Data));
            $rows = json_decode(json_encode($objData->Data), true);
            return $rows;
        } catch (\Exception $exc) {
            echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */




    public function exam_delete(Request $request)
    {
        try {
            $this->WriteFileLog($request);
            $method = 'Method => elearningExamController => fetch';
            // $user_id = $request->session()->get("userID");
            // if ($user_id == null) {
            //     return view('auth.login');
            // }
            $data['id'] = $request->id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;


            $gatewayURL = config('setting.api_gateway_url') . '/examtest/delete';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $this->WriteFileLog($response);
            $response1 = json_decode($response);
            $objData = json_decode($this->decryptData($response1->Data));
            $rows = json_decode(json_encode($objData->Data), true);
            return $rows;
        } catch (\Exception $exc) {
            echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function list(Request $request)

    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => elearningExamController => list';
        // $request =  array();
        // $request['mlhud_id'] = $user_id;
        try {
            $gatewayURL = config('setting.api_gateway_url') . '/exam/quiz/list';
            $response = $this->serviceRequest($gatewayURL, 'GET', "", $method);
            $response = json_decode($response);

            $objData = json_decode($this->decryptData($response->Data));
            $code = $objData->Code;

            if ($code == "401") {

                return redirect()->route('unauthenticated')->send();
            }
            $rows = json_decode(json_encode($objData->Data), true);
            if($rows==0){
                return redirect()->back()->with('error', 'No Exam Available Please Come Back Later');
            }

            $menus = $this->FillMenu();

            if ($menus == "401") {
                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
            $screens = $menus['screens'];
            $modules = $menus['modules'];

            return view('elearningexam.userindex', compact('rows', 'menus', 'screens', 'modules'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }






    public function quiz(Request $request)
    {
        // dd($request);
        try {
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => elearningExamController => quiz';
            $request =  array();
            $request['mlhud_id'] = $user_id;
            $gatewayURL = config('setting.api_gateway_url') . '/exam/quiz';
            $response = $this->serviceRequest($gatewayURL, 'GET', "", $method);
            $response = json_decode($response);
            //dd($response);


            $objData = json_decode($this->decryptData($response->Data));

            $parant_data = $objData->Data;
            $quizId = $parant_data->quizId;
            $quizName = $parant_data->quizName;
            $questionDetails = $parant_data->questionDetails;
            //dd($questionDetails);
            $qIds = $parant_data->qIds;

            // dd($quizId);

            // $quizId=$objData['quizId'];
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
            return view('elearningexam.userview', compact('quizId', 'quizName', 'questionDetails', 'qIds', 'user_id', 'menus', 'screens', 'modules'));

            //code...
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function quizstore(Request $request)
    {

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => elearningExamController => store';
        try {
            $data = array();

            $data['quizId'] = $request->quizId;
            $data['attempt'] = $request->attempt;
            $data['score'] = $request->score;
            $data['pass_mark'] = $request->pass_mark;

            $data['total_scores'] = $request->total_scores;


            $encryptArray = $this->encryptData($data);
            $request = array();

            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/exam/quiz/store';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);


            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    return redirect(route('exam.list'))->with('success', 'Thankyou for Attending the Exam');
                }

                if ($objData->Code == 400) {
                    return redirect(route('exam.list'))->with('fail', 'Exam Failed');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
}
