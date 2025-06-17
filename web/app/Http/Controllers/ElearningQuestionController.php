<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;


class ElearningQuestionController extends BaseController
{

    // Quiz Start

    public function index(Request $request)
    {

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => ElearningQuestionController => index';
        try {
            $request =  array();
            $request['mlhud_id'] = $user_id;
            $gatewayURL = config('setting.api_gateway_url') . '/elearningquestion';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
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
            //$rows['elearning_practice_quiz'] = [];


            return view('elearning_quizquestion.index', compact('modules', 'screens', 'rows'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function long_store(Request $request)
    {

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => ElearningQuestionController => long_store';
        try {
            $data = array();
            $data['question_name'] = $request->long_qname;
            $data['question'] = $request->long_quistion;
            $data['keywords'] = $request->keyword_long;
            $data['points'] = $request->long_points;



            $encryptArray = $this->encryptData($data);

            $request = array();


            $request['requestData'] = $encryptArray;


            $gatewayURL = config('setting.api_gateway_url') . '/elearning/question_long/store';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);



            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    return redirect(route('elearningquestion.index'))
                    ->with([
                        'success' => 'Question Created Successfully',
                        'type' => 'LongQuestionlist'
                    ]);
                   // with('success', 'Question Created Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('elearningquestion.index'))->with('fail', 'Question Test Failed');
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
    public function long_show($id)
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Show') !== false) {
            try {
                $method = 'Method => ElearningQuestionController => long_show';
                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/elearning/question_long/show/' . $this->encryptData($id);
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
                        return view('elearning_quizquestion.index', compact('rows', 'modules', 'screens'));
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

    public function long_edit($id)
    {

        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Edit') !== false) {
            try {
                $method = 'Method => ElearningQuestionController => long_edit';
                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/elearning/question_long/edit' . $this->encryptData($id);
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
                        return view('elearning_quizquestion.index', compact('rows', 'modules', 'screens'));
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
    public function long_update(Request $request, $id)
    {

        try {

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => ElearningQuestionController => long_update';

            $data = array();
            $data['question_name'] = $request->long_qnameedit;
            $data['question'] = $request->long_quistionedit;
            $data['keywords'] = $request->keyword_longedit;
            $data['points'] = $request->long_pointsedit;
            $data['eid'] = $request->eid;

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/elearning/question_long/update';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                return redirect(route('elearningquestion.index'))->with('success', 'Question  Updated Successfully');
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function long_fetch(Request $request)
    {

        $this->WriteFileLog($request);
        try {
            $this->WriteFileLog("feef");
            $method = 'Method => ElearningQuestionController => long_fetch';
            // $user_id = $request->session()->get("userID");
            // if ($user_id == null) {
            //     return view('auth.login');
            // }
            $data['id'] = $request->id;
            $data['type'] = $request->type;

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;


            $gatewayURL = config('setting.api_gateway_url') . '/elearning/question_long/fetch';
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
    public function long_delete(Request $request)
    {
        try {
            $this->WriteFileLog($request);
            $method = 'Method => ElearningQuestionController => long_delete';
            // $user_id = $request->session()->get("userID");
            // if ($user_id == null) {
            //     return view('auth.login');
            // }
            $data['id'] = $request->id;
            $data['tabletype'] = $request->tabletype;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;


            $gatewayURL = config('setting.api_gateway_url') . '/elearning/question_long/delete';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $this->WriteFileLog($response);
            $response1 = json_decode($response);
            $objData = json_decode($this->decryptData($response1->Data));
            $rows['data'] = json_decode(json_encode($objData->Data), true);
            $rows['message_cus'] = json_decode(json_encode($objData->response_message), true);
            return $rows;
        } catch (\Exception $exc) {
            //echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function short_store(Request $request)
    {

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => ElearningQuestionController => short_store';
        try {
            $data = array();
            $data['question_name'] = $request->short_qname;
            $data['question'] = $request->short_quistion;
            $data['keywords'] = $request->keyword_short;
            $data['points'] = $request->short_points;



            $encryptArray = $this->encryptData($data);

            $request = array();


            $request['requestData'] = $encryptArray;


            $gatewayURL = config('setting.api_gateway_url') . '/elearning/question_short/store';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);



            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    return redirect(route('elearningquestion.index'))->with('success', 'Question Created Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('elearningquestion.index'))->with('fail', 'Question Test Failed');
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
    public function short_show($id)
    {

        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Show') !== false) {
            try {
                $method = 'Method => ElearningQuestionController => short_show';
                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/elearning/question_short/show/' . $this->encryptData($id);
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
                        return view('elearning_quizquestion.index', compact('rows', 'modules', 'screens'));
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
    public function short_edit($id)
    {

        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Edit') !== false) {
            try {
                $method = 'Method => ElearningQuestionController => short_edit';
                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/elearning/question_short/edit' . $this->encryptData($id);
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
                        return view('elearning_quizquestion.index', compact('rows', 'modules', 'screens'));
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
    public function short_update(Request $request, $id)
    {

        try {

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => ElearningQuestionController => short_update';

            $data = array();
            $data['question_name'] = $request->short_qnameedit;
            $data['question'] = $request->short_quistionedit;
            $data['keywords'] = $request->keyword_shortedit;
            $data['points'] = $request->short_pointsedit;
            $data['short_edit'] = $request->short_edit;

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/elearning/question_short/update';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);


            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                return redirect(route('elearningquestion.index'))->with('success', 'Question  Updated Successfully');
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function mcq_store(Request $request)
    {

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => ElearningQuestionController => mcq_store';
        try {
            $data = array();
            $data['question_name'] = $request->mcq_qname;
            $data['question'] = $request->mcq_quistion;
            $data['keywords_choices'] = $request->keyword_mcq;
            $data['correct_choices'] = $request->mcq_correct_choices;
            $data['points'] = $request->mcq_points;



            $encryptArray = $this->encryptData($data);

            $request = array();



            $request['requestData'] = $encryptArray;


            $gatewayURL = config('setting.api_gateway_url') . '/elearning/question_mcq/store';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);


            $response1 = json_decode($response);



            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    return redirect(route('elearningquestion.index'))->with('success', 'Question Created Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('elearningquestion.index'))->with('fail', 'Question Test Failed');
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
    public function mcq_show($id)
    {

        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Show') !== false) {
            try {
                $method = 'Method => ElearningQuestionController => mcq_show';
                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/elearning/question_short/show/' . $this->encryptData($id);
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
                        return view('elearning_quizquestion.index', compact('rows', 'modules', 'screens'));
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
    public function mcq_edit($id)
    {

        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Edit') !== false) {
            try {
                $method = 'Method => ElearningQuestionController => mcq_edit';
                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/elearning/question_short/edit' . $this->encryptData($id);
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
                        return view('elearning_quizquestion.index', compact('rows', 'modules', 'screens'));
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
    public function mcq_update(Request $request, $id)
    {

        try {

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => ElearningQuestionController => mcq_update';

            $data = array();
            $data['question_name'] = $request->mcq_qnameedit;
            $data['question'] = $request->mcq_quistionedit;
            $data['choices'] = $request->keyword_mcqedit;
            $data['correct_choices'] = $request->mcq_correct_choicesedit;
            $data['points'] = $request->mcq_pointsedit;
            $data['mcq_edit'] = $request->mcq_edit;

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/elearning/question_mcq/update';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);


            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                return redirect(route('elearningquestion.index'))->with('success', 'Question  Updated Successfully');
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function true_store(Request $request)
    {

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => ElearningQuestionController => true_store';
        try {
            $data = array();
            $data['question_name'] = $request->true_qname;
            $data['question'] = $request->true_quistion;
            $data['answer'] = $request->answer;
            $data['points'] = $request->true_points;



            $encryptArray = $this->encryptData($data);

            $request = array();


            $request['requestData'] = $encryptArray;


            $gatewayURL = config('setting.api_gateway_url') . '/elearning/question_true/store';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);



            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    return redirect(route('elearningquestion.index'))->with('success', 'Question Created Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('elearningquestion.index'))->with('fail', 'Question Test Failed');
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
    public function true_show($id)
    {

        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Show') !== false) {
            try {
                $method = 'Method => ElearningQuestionController => short_show';
                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/elearning/question_true/show/' . $this->encryptData($id);
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
                        return view('elearning_quizquestion.index', compact('rows', 'modules', 'screens'));
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
    public function true_edit($id)
    {

        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Edit') !== false) {
            try {
                $method = 'Method => ElearningQuestionController => true_edit';
                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/elearning/question_true/edit' . $this->encryptData($id);
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
                        return view('elearning_quizquestion.index', compact('rows', 'modules', 'screens'));
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
    public function true_update(Request $request, $id)
    {

        try {

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => ElearningQuestionController => true_update';

            $data = array();
            $data['question_name'] = $request->true_qnameedit;
            $data['question'] = $request->true_quistionedit;
            $data['answer'] = $request->answer_edit;
            $data['points'] = $request->true_pointsedit;
            $data['true_edit'] = $request->true_edit;

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/elearning/question_true/update';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);


            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                return redirect(route('elearningquestion.index'))->with('success', 'Question  Updated Successfully');
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function get_points(Request $request)
    {

        $this->WriteFileLog($request);
        try {

            $method = 'Method => ElearningQuestionController => get_points';
            // $user_id = $request->session()->get("userID");
            // if ($user_id == null) {
            //     return view('auth.login');
            // }
            $data['id'] = $request->id;

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;


            $gatewayURL = config('setting.api_gateway_url') . '/elearning/question_quiz/get_points';
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
    public function quiz_store(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => ElearningQuestionController => quiz_store';
        try {
            $data = array();
            $data['quiz_name'] = $request->q_name;
            $data['quiz_questions'] = $request->quiz_question;
            $data['points'] = $request->q_points;


            $encryptArray = $this->encryptData($data);

            $request = array();

            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/elearning/question_quiz/store';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);


            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    return redirect(route('elearningquestion.index'))->with('success', ' Quiz Created Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('elearningquestion.index'))->with('fail', 'Quiz Creation Failed');
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
    public function quiz_show($id)
    {

        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Show') !== false) {
            try {
                $method = 'Method => ElearningQuestionController => short_show';
                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/elearning/question_quiz/show/' . $this->encryptData($id);
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
                        return view('elearning_quizquestion.index', compact('rows', 'modules', 'screens'));
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
    public function quiz_edit($id)
    {

        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Edit') !== false) {
            try {
                $method = 'Method => ElearningQuestionController => true_edit';
                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/elearning/question_quiz/edit/' . $this->encryptData($id);
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
                        return view('elearning_quizquestion.index', compact('rows', 'modules', 'screens'));
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
    public function quiz_update(Request $request, $id)
    {

        try {

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => ElearningQuestionController => true_update';

            $data = array();
            $data['quiz_name'] = $request->q_nameedit;
            $data['quiz_questions'] = $request->quiz_questionedit;
            $data['points'] = $request->q_pointsedit;
            $data['quiz_edit'] = $request->quiz_edit;

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/elearning/question_quiz/update';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);


            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                return redirect(route('elearningquestion.index'))->with('success', 'Quiz Updated Successfully');
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function quiz(Request $request)
    {

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => ElearningQuestionController => quiz';
        try {


            $gatewayURL = config('setting.api_gateway_url') . '/elearning/quiz/view';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
            $response = json_decode($response);


            $objData = json_decode($this->decryptData($response->Data));


            $code = $objData->Code;
            if ($code == "401") {

                return redirect()->route('unauthenticated')->send();
            }
            if ($code == "400") {

                return redirect()->back()->with('error', 'No Quiz Available Please Come Back Later');
            }
            $data = $objData->Data;

            $quizId = $data->quizId;

            $quizName = $data->quizName;
            $questionDetails = $data->questionDetails;
            $qIds = $data->qIds;
            $rows = json_decode(json_encode($objData->Data), true);

            $menus = $this->FillMenu();

            $screens = $menus['screens'];
            $modules = $menus['modules'];
            //$rows['elearning_practice_quiz'] = [];
            return view('elearning_quizquestion.userquiz', compact('quizId', 'quizName', 'questionDetails', 'qIds', 'modules', 'screens', 'rows', 'menus'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function quizresult(Request $request)
    {

        $this->WriteFileLog($request);
        try {

            $method = 'Method => ElearningQuestionController => quizresult';
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $data = array();
            $data['id'] = $request->id;
            $data['answers'] = $request->answers;
            $this->WriteFileLog($data);
            $this->WriteFileLog("answers");
          
            // $encryptArray = $this->encryptData($data);
            //$request = array();
            // $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/elearning/quiz/results';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($data), $method);
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
}
