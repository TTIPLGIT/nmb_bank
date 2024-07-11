<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Redirect;
use Validator;

class FAQquestionController extends BaseController
{


    public function index(Request $request)
    {   
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'View') !== false) {
            try {
                $method = 'Method => FAQquestionController => index';
                
                $gatewayURL = config('setting.api_gateway_url') . '/FAQ_question/get_data';
                $serviceResponse = array();
                $serviceResponse['rows'] = $request['rows'];
               
                $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
                $response = $this->serviceRequest($gatewayURL, 'GET', $serviceResponse, $method);
                
                $response = json_decode($response);
                if ($response->Status == 200 && $response->Success) {
                    $objData = json_decode($this->decryptData($response->Data));
                    if ($objData->Code == 200) {
                        $parant_data = json_decode(json_encode($objData->Data), true);
                        $rows =  $parant_data['rows'];                      
                        $permission = $this->FillScreensByUser();
                        $screen_permission = $permission[0];
                        $menus = $this->FillMenu();
                        $screens = $menus['screens'];
                        $modules = $menus['modules'];
                        return view('faq_question.index', compact('rows','screen_permission','modules','screens',));
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
        } else {
            return redirect()->route('not_allow');
        }
    }


    public function create()
    {
       
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        
        if (strpos($screen_permission['permissions'], 'Create') !== false) {
            try {
                $method = 'Method => FAQquestionController => create';
                $gatewayURL = config('setting.api_gateway_url') . '/FAQ_question/get_FAQ_question';              
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
                $response = json_decode($response);
                
                if ($response->Status == 200 && $response->Success) {
                    $objData = json_decode($this->decryptData($response->Data));
                    if ($objData->Code == 200) {
                        $parant_data = json_decode(json_encode($objData->Data), true);
                        $rows =  $parant_data['rows'];
                        $menus = $this->FillMenu();
                        $screens = $menus['screens'];
                        $modules = $menus['modules'];
                        return view('FAQ_question.create', compact('rows', 'modules', 'screens'));
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
        } else {
            return redirect()->route('not_allow');
        }
    }


    public function update_toggle(Request $request)
    {
        try {
            $method = 'Method => FAQquestionController => update_toggle';
            $data = array();
            $data['is_active'] = $request->is_active;
            $data['f_id'] = $request->f_id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/FAQ_questions/update_toggle';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);


            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                echo $this->decryptData($response1->Data);
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

    public function store(Request $request)
    {
       
        try {

            $method = 'Method => FAQquestionController => store';

            $data = array();
            $rules = [
                'module_id' => 'required',
                'question' => 'required',
                'answer' => 'required',

            ];

            $messages = [
                'module_id.required' => 'Module name is required',
                'question.required' => 'Question is required',
                'answer.required' => 'Answer is required',


            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator);
            } else {
                $data['module_id'] = $request->module_id;
                $data['question'] = $request->question;
                $data['answer'] = $request->answer;
                $encryptArray = $this->encryptData($data);
                $request = array();
                $request['requestData'] = $encryptArray;
                $gatewayURL = config('setting.api_gateway_url') . '/FAQ_question/storedata';
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
                $response1 = json_decode($response);
                
            }

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    return redirect(route('FAQ_question.index'))->with('success', 'Manage FAQ Created Successfully');
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

    public function edit($id)
    {

        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Edit') !== false) {
            try {
                $method = 'Method => FAQquestionController => edit';
                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/FAQ_question/data_edit/' . $this->encryptData($id);
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
                $response = json_decode($response);
                if ($response->Status == 200 && $response->Success) {
                    $objData = json_decode($this->decryptData($response->Data));
                    if ($objData->Code == 200) {
                        $parant_data = json_decode(json_encode($objData->Data), true);
                        $rows =  $parant_data['rows'];
                        $one_row =  $parant_data['one_rows'];
                        $menus = $this->FillMenu();
                        $screens = $menus['screens'];
                        $modules = $menus['modules'];
                        return view('FAQ_question.edit', compact('rows', 'modules', 'screens', 'one_row'));
                    }
                } else {
                    $objData = json_decode($this->decryptData($response->Data));
                    echo json_encode($objData->Code);
                    exit;
                }
            } catch (\Exception $exc) {
                return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
            }
        } else {
            return redirect()->route('not_allow');
        }
    }


    public function show($id)
    {
       
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
       
        if (strpos($screen_permission['permissions'], 'Show') !== false) {
            try {
                $method = 'Method => FAQquestionController => show';
                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/FAQ_question/data_edit/' . $this->encryptData($id);               
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
                $response = json_decode($response);              
                if ($response->Status == 200 && $response->Success) {
                    $objData = json_decode($this->decryptData($response->Data));
                    if ($objData->Code == 200) {
                        $parant_data = json_decode(json_encode($objData->Data), true);
                        $rows =  $parant_data['rows'];
                        $one_row =  $parant_data['one_rows'];
                        $menus = $this->FillMenu();
                        $screens = $menus['screens'];
                        $modules = $menus['modules'];
                        return view('FAQ_question.show', compact('rows', 'modules', 'screens', 'one_row'));
                    }
                } else {
                    $objData = json_decode($this->decryptData($response->Data));
                    echo json_encode($objData->Code);
                    exit;
                }
            } catch (\Exception $exc) {
                return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
            }
        } else {
            return redirect()->route('not_allow');
        }
    }



    public function update_data(Request $request)
    {
        try {
            $method = 'Method => FAQquestionController => update_data';
            $data = array();
            $rules = [
                'module_id' => 'required',
                'question' => 'required',
                'answer' => 'required',

            ];

            $messages = [
                'module_id.required' => 'Module name is required',
                'question.required' => 'Question is required',
                'answer.required' => 'Answer is required',


            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator);
            } else {
                $data['module_id'] = $request->module_id;
                $data['que_id'] = $request->que_id;
                $data['question'] = $request->question;
                $data['answer'] = $request->answer;
                $encryptArray = $this->encryptData($data);
                $request = array();
                $request['requestData'] = $encryptArray;
                $gatewayURL = config('setting.api_gateway_url') . '/FAQ_question/updatedata';
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
                $response1 = json_decode($response);
            }
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    return redirect(route('FAQ_question.index'))->with('success', 'Manage FAQ Updated Successfully');
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

    public function delete($id)
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Delete') !== false) {
            try {

                $method = 'Method => FAQquestionController => delete';
                $id = $this->decryptData($id);

                $gatewayURL = config('setting.api_gateway_url') . '/FAQ_question/data_delete/' . $this->encryptData($id);
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);



                $response1 = json_decode($response);
                if ($response1->Status == 200 && $response1->Success) {
                    $objData = json_decode($this->decryptData($response1->Data));
                    if ($objData->Code == 200) {
                        return redirect(route('FAQ_question.index'))->with('success', 'Manage FAQ Deleted Successfully.');
                    }
                    if ($objData->Code == 400) {
                        return redirect(route('FAQ_question.index'))->with('fail', 'This Module Allocated One Module Screen Mapping');
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
        } else {
            return redirect()->route('not_allow');
        }
    }
}
