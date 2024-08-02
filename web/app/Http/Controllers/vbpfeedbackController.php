<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Psy\Readline\Hoa\Console;
use Illuminate\Support\Facades\Redirect;

class vbpfeedbackController extends BaseController
{

    public function index(Request $request)
    {
        $mobile = 0;
        if (isset($request->mobile)) {
            $mobile = 1;
        }

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => vbpfeedbackController => index';
        $request =  array();
        $request['mlhud_id'] = $user_id;
        $gatewayURL = config('setting.api_gateway_url') . '/insrtuction/index';

        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
        $response = json_decode($response);

        if ($response->Status == 200 && $response->Success) {
            $objData = json_decode($this->decryptData($response->Data));
            if ($objData->Code == 200) {
                $parant_data = json_decode(json_encode($objData->Data), true);
                $rows =  $parant_data;
                $alter_name = $this->get_user_role();
                $menus = $this->FillMenu();
                $screens = $menus['screens'];
                $modules = $menus['modules'];
                $permission = $this->FillScreensByUser();
                if ($mobile == 1) {
                    $mobile_response = [
                        'data' => $rows
                    ];
                    return $mobile_response;
                }
                return view('initiation.vpb_index', compact('user_id', 'rows', 'menus', 'screens', 'modules'));
            }
        }
    }



    public function create(Request $request)
    {


        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $mobile = 0;
        if (isset($request->mobile)) {
            $mobile = 1;
        }
        $user_id = $request->session()->get("userID");
        $method = 'Method => vbpfeedbackController => create';

        $gatewayURL = config('setting.api_gateway_url') . '/insrtuction/create';

        $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
        $response = json_decode($response);


        $objData = json_decode($this->decryptData($response->Data));
        $rows = json_decode(json_encode($objData->Data), true);
        $menus = $this->FillMenu();


        if ($menus == "401") {
            return redirect(url('/'))->with('danger', 'User session Exipired');
        }
        $screens = $menus['screens'];
        $modules = $menus['modules'];
        if ($mobile == 1) {
            $mobile_response = [
                'data' => $rows
            ];
            return $mobile_response;
        }
        return view('initiation.vpb_create', compact('rows', 'menus', 'screens', 'modules'));
    }
    public function master_store(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $mobile = 0;
        if (isset($request->mobile)) {
            $mobile = 1;
        }
        $method = 'Method => vbpfeedbackController => master_store';

        $data = array();
        $data['stakeholder_id'] = $user_id;
        $data['instruction_name'] = $request->Instruction_name;
        $data['description'] = $request->description;
        $encryptArray = $data;
        $request = array();
        $request['requestData'] = $encryptArray;
        $gatewayURL = config('setting.api_gateway_url') . '/stakeholder/storedata';

        $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
        $response1 = json_decode($response);
        if ($response1->Status == 200 && $response1->Success) {
            $objData = json_decode($this->decryptData($response1->Data));

            if ($objData->Code == 200) {
                if ($mobile == 1) {
                    return ['status_code' => '200', 'message' => 'Instruction details added successfully'];
                } else {
                    return redirect(route('initiation/create'))->with('success', 'Instruction details added successfully');
                }
            }

            if ($objData->Code == 400) {
                if ($mobile == 1) {
                    return ['status_code' => '400', 'message' => 'Initiation details already exists'];
                }
                return redirect(route('initiation.vpb_create'))->with('fail', 'Initiation details already exists');
            }
        } else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);
            exit;
        }
    }

    public function show(Request $request)
    {
        try {

            $method = 'Method => vbpfeedbackController => show';
            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }
            $data['id'] = $request->id;
            $encryptArray = $data;
            $request = array();
            $request['requestData'] = $encryptArray;

            // echo json_encode($id);exit;t
            $gatewayURL = config('setting.api_gateway_url') . '/stakeholder/show';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $response = json_decode($response);
            $this->WriteFileLog(json_encode($response));


            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows2 =  $parant_data['rows2'];
                    if ($mobile == 1) {
                        $mobile_response = [
                            'data' => $rows2
                        ];
                        return $mobile_response;
                    }
                    return $rows2;
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


    public function delete($id, Request $request)
    {
        try {
            $mobile = 0;
        if (isset($request->mobile)) {
            $mobile = 1;
        }
            $method = 'Method => vbpfeedbackController => update';

            $gatewayURL = config('setting.api_gateway_url') . '/stakeholder/delete/' . $this->encryptData($id);

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    if ($mobile == 1) {
                        return ['status_code' => '200', 'message' => 'Instruction has been Deleted Successfully'];
                      }
                    return redirect(route('initiation'))->with('success', 'Instruction has been Deleted Successfully');
                }
                if ($objData->Code == 400) {
                    if ($mobile == 1) {
                        return ['status_code' => '200', 'message' => 'instruction Name Already Exists'];
                      }
                    return Redirect::back()->with('fail', 'instruction Name Already Exists');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function index_data(Request $request)
    {
        $mobile = 0;
        if (isset($request->mobile)) {
            $mobile = 1;
        }
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => vbpfeedbackController => index';
        $request =  array();
        $request['mlhud_id'] = $user_id;
        $gatewayURL = config('setting.api_gateway_url') . '/insrtuction/index_data';

        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
        $response = json_decode($response);

        if ($response->Status == 200 && $response->Success) {
            $objData = json_decode($this->decryptData($response->Data));
            if ($objData->Code == 200) {
                $parant_data = json_decode(json_encode($objData->Data), true);
                $rows =  $parant_data;
                $alter_name = $this->get_user_role();
                $menus = $this->FillMenu();
                $screens = $menus['screens'];
                $modules = $menus['modules'];
                $permission = $this->FillScreensByUser();
                if ($mobile == 1) {
                    $mobile_response = [
                        'data' => $rows
                    ];
                    return $mobile_response;
                }
                if ($rows['role_name'] == "Guest Role") {
                    return view('instructionfirm.firm_instruction_index', compact('rows', 'user_id', 'menus', 'screens', 'modules'));
                } else {
                    return view('initiation.index_data', compact('rows', 'user_id', 'menus', 'screens', 'modules'));
                }
            }
        }
    }

    public function store(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $mobile = 0;
        if (isset($request->mobile)) {
            $mobile = 1;
        }
        $method = 'Method => vbpfeedbackController => master_store';

        $data = array();
        $data['task_name'] = $request->task_name;
        if ($request->process_type == 'government') {
            $data['cgv_id'] = $request->valuer_name;
        } else {
            $data['valuer_name'] = $request->valuer_name;
        }
        $data['stakeholder_id'] = $user_id;
        $data['totalid'] = $request->totalid;
        $data['description'] = $request->description;
        $data['type'] = $request->type;

        $apiUrl = $request->process_type == 'government' ? '/instruction/government/store' : '/instruction/store';
        $encryptArray = $data;
        $request = array();
        $request['requestData'] = $encryptArray;

        $gatewayURL = config('setting.api_gateway_url') . $apiUrl;

        $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
        $response1 = json_decode($response);

        if ($response1->Status == 200 && $response1->Success) {
            $objData = json_decode($this->decryptData($response1->Data));


            if ($objData->Code == 200) {
                if ($mobile == 1) {
                    return ["status_code" => "200", "Message" => "Initation Completed Successfully"];
                }
                return response()->json(['message' => 'Initation Completed Successfully'], 200);
                // return redirect(route('initiation/create'))->with('success', 'Initation Completed Successfully');
            }

            if ($objData->Code == 400) {
                if ($mobile == 1) {
                    return ["status_code" => "400", "Message" => "fail"];
                }
                return response()->json(['message' => 'fail'], 500);
                // return redirect(route('initiation.vpb_create'))->with('fail', 'Initiation Details Already Exists');
            }
        } else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);
            exit;
        }
    }

    public function reject_store(Request $request)
    {

        $this->WriteFileLog('web');
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => vbpfeedbackController => reject_store';

        $data = array();
        $data['task_name'] = $request->task_name;
        $data['valuer_name'] = $request->valuer_name;
        $data['stakeholder_id'] = $user_id;
        $data['totalid'] = $request->totalid;
        $data['description'] = $request->description;
        $data['previous_element'] = $request->previous_element;
        $data['type'] = $request->type;


        $encryptArray = $data;
        $request = array();
        $request['requestData'] = $encryptArray;

        $gatewayURL = config('setting.api_gateway_url') . '/instruction/reject/store';

        $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);

        $response1 = json_decode($response);

        if ($response1->Status == 200 && $response1->Success) {
            $objData = json_decode($this->decryptData($response1->Data));


            if ($objData->Code == 200) {
                return redirect(route('initiation/create'))->with('success', 'Initation Completed Successfully');
            }

            if ($objData->Code == 400) {
                return redirect(route('initiation.vpb_create'))->with('fail', 'Initiation Details Already Exists');
            }
        } else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);
            exit;
        }
    }

    public function create_data(Request $request, $id)
    {
        $mobile = 0;
        if (isset($request->mobile)) {
            $mobile = 1;
        }

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $user_id = $request->session()->get("userID");
        $method = 'Method => vbpfeedbackController => create';

        
            $gatewayURL = config('setting.api_gateway_url') . '/insrtuction/create_data/' . $id;
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data;
                    $alter_name = $this->get_user_role();
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    $permission = $this->FillScreensByUser();
                    if ($mobile == 1) {
                        $mobile_response = [
                            'data' => $rows
                        ];
                        return $mobile_response;
                    }
                return view('initiation.create_data', compact('rows', 'menus', 'screens', 'modules'));

                }
                if ($objData->Code == "401") {
                    return redirect(url('/'))->with('danger', 'User session Exipired');
                }
            }
            

            
        
    }

    public function approve(Request $request)
    {
        $mobile = 0;
        if (isset($request->mobile)) {
            $mobile = 1;
        }
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => vbpfeedbackController => approve';

        $data = array();
        $encryptArray = $data;
        $request = array();
        $request['requestData'] = $encryptArray;

        $gatewayURL = config('setting.api_gateway_url') . '/instruction/approve';

        $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
        $this->WriteFileLog($response);
        $response1 = json_decode($response);
        if ($response1->Status == 200 && $response1->Success) {
            $objData = json_decode($this->decryptData($response1->Data));
            if ($objData->Code == 200) {
                $parant_data = json_decode(json_encode($objData->Data), true);
                $rows =  $parant_data;
                $alter_name = $this->get_user_role();
                $menus = $this->FillMenu();
                $screens = $menus['screens'];
                $modules = $menus['modules'];
                $permission = $this->FillScreensByUser();
                if ($mobile == 1) {
                    $mobile_response = [
                        'data' => $rows
                    ];
                    return $mobile_response;
                }
                return redirect(route('initiation/create'))->with('success', 'Initation Accept Successfully');
            }
            if ($objData->Code == 400) {
                return redirect(route('initiation.vpb_create'))->with('fail', 'Initiation Details Already Exists');
            }
        }
        else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);
            exit;
        }
    }
    public function reject(Request $request)
    {

        $mobile = 0;
        if (isset($request->mobile)) {
            $mobile = 1;
        }
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => vbpfeedbackController => reject';

        $data = array();
        $data['id'] = $request->id;
        $data['action'] = $request->action;



        $encryptArray = $data;
        $request = array();
        $request['requestData'] = $encryptArray;

        $gatewayURL = config('setting.api_gateway_url') . '/instruction/reject';

        $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
        $this->WriteFileLog($response);
        $response1 = json_decode($response);

        if ($response1->Status == 200 && $response1->Success) {
            $objData = json_decode($this->decryptData($response1->Data));


            if ($objData->Code == 200) {
                if ($mobile == 1) {
                    return ['status_code' => '200', 'message' => 'Initation rejected Successfully'];
                  }
                return redirect(route('initiation'))->with('success', 'Initation rejected Successfully');
            }

            if ($objData->Code == 400) {
                if ($mobile == 1) {
                    return ['status_code' => '400', 'message' => 'Initiation Details Already Exists'];
                  }
                return redirect(route('initiation'))->with('fail', 'Initiation Details Already Exists');
            }
        } else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);
            exit;
        }
    }

    public function stakholder_reject(Request $request)
    {


        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => vbpfeedbackController => stakholder_reject';

        $data = array();

        $data['valuer_id'] = $request->valuer_id;
        $data['stakeholder_id'] = $request->stakeholder_id;
        $data['cgv_comment'] = $request->cgv_comment;


        $encryptArray = $data;
        $request = array();
        $request['requestData'] = $encryptArray;

        $gatewayURL = config('setting.api_gateway_url') . '/instruction/reject/stakeholder';

        $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
        $this->WriteFileLog($data);
        $response1 = json_decode($response);

        if ($response1->Status == 200 && $response1->Success) {
            $objData = json_decode($this->decryptData($response1->Data));


            if ($objData->Code == 200) {
                return redirect(route('initiation'))->with('success', 'Initation rejected Successfully');
            }

            if ($objData->Code == 400) {
                return redirect(route('initiation'))->with('fail', 'Initiation Details Already Exists');
            }
        } else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);
            exit;
        }
    }

    public function edit_store(Request $request)
    {

        $mobile = 0;
        if (isset($request->mobile)) {
            $mobile = 1;
        }
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => vbpfeedbackController => edit_store';

        $data = array();
        $data['task_id'] = $request->id;
        $data['instruction_id'] = $request->instruction_id;
        $data['stakeholder_comments'] = $request->stakeholder_comments;
        $data['file'] = $request->sample;
        $data['valuer_comments'] = $request->valuer_comments;
        $data['action'] = $request->action;
        $data['stakeholder_id'] = $request->stakeholder_id;
        $stakeholder_id = $request->stakeholder_id;


        $storagepath_instruction_file_old = public_path() . '/instruction_file/' . $user_id;

        $storagepath_instruction = '/instruction_file/' . $user_id;
        $data['file_path'] = $storagepath_instruction;
        if (!File::exists($storagepath_instruction_file_old)) {
            File::makeDirectory($storagepath_instruction_file_old);
        }

        // $data['instruction_file'] = implode(',', $request->file);
        // $file_array = explode(',', $data['instruction_file']);
        // print_r('file_array');


        $documentsb =  $request['sample'];

        foreach ($documentsb as $key => $row) {
            $files = $row->getClientOriginalName();
            $findspace = array(' ', '&', "'", '"');
            $replacewith = array('-', '-');
            $proposal_files = str_replace($findspace, $replacewith, $files);
            $maxFileSize = 2 * 1024 * 1024;
            if ($row->getSize() > $maxFileSize) {
                return redirect(route('instruction'))->with('error', 'File Size should be within 2mb');
            } else {
                $row->move($storagepath_instruction_file_old, $proposal_files);
                // $data['instruction_file'] = $proposal_files;
                $data['instruction_file'][$key] = $proposal_files;
                $pdf = $request->file('instruction_file');
            }
        }
        $encryptArray = $data;
        $request = array();
        $request['requestData'] = $encryptArray;
        $url = '/initiation/create_data/' . $stakeholder_id;

        $gatewayURL = config('setting.api_gateway_url') . '/instruction/edit/store';

        $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
        $response1 = json_decode($response);
        if ($response1->Status == 200 && $response1->Success) {
            $objData = json_decode($this->decryptData($response1->Data));


            if ($objData->Code == 200) {
                if ($mobile == 1) {
                    return ["status_code" => "200", "Message" => "Task Completed Successfully"];
                }
                return redirect(url($url))->with('success', 'Task Completed Successfully');
            }

            if ($objData->Code == 400) {
                if ($mobile == 1) {
                    return ["status_code" => "400", "Message" => "Task Details Already Exists"];
                }
                return redirect(route('instruction'))->with('fail', 'Task Details Already Exists');
            }
        } else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);
            exit;
        }
    }
    public function data_show(Request $request)
    {
        $user_id = $request->session()->get("userID");
        $mobile = 0;
                if (isset($request->mobile)) {
                $mobile = 1;
            }
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => vbpfeedbackController => data_show';
        $this->WriteFileLog($request);
        $data = array();

        $data['id'] = $request->id;
        $data['initiation_id'] = $request->initiation_id;


        $encryptArray = $data;
        $request = array();

        $request['requestData'] = $encryptArray;

        $gatewayURL = config('setting.api_gateway_url') . '/instruction/data/show';

        $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);

        $response1 = json_decode($response);

        if ($response1->Status == 200 && $response1->Success) {
            $objData = json_decode($this->decryptData($response1->Data));
            if ($mobile == 1){
                return $objData;
            }
            return $objData;
        } else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);
            exit;
        }
    }

    public function valuer_show($id,Request $request)
    {

        try {
            $mobile = 0;
                if (isset($request->mobile)) {
                $mobile = 1;
            }
            $method = 'Method => vbpfeedbackController => valuer_show';
            $gatewayURL = config('setting.api_gateway_url') . '/instruction/stakeholder/show/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);

                    $rows = $parant_data['rows'];
                    $firms = $parant_data['firms'];
                    $instruction = $parant_data['instruction'];
                    $role_id = $parant_data['role_id'];


                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    if ($mobile == 1) {
                        $mobile_response = [
                            'data' => $rows,
                            'firms' => $firms,
                            'instruction' =>$instruction,
                            'role_id' =>$role_id
                        ];
                        return $mobile_response;
                    }
                    return view('initiation.valuer_show', compact('rows', 'instruction', 'menus', 'screens', 'modules', 'role_id', 'firms'));
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

    public function stakeholder_approve(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => vbpfeedbackController => data_show';
        $this->WriteFileLog($request);
        $data = array();

        $data['valuer_id'] = $request->valuer_id;
        $data['cgv'] = $request->cgv;


        $encryptArray = $data;
        $request = array();

        $request['requestData'] = $encryptArray;

        $gatewayURL = config('setting.api_gateway_url') . '/instruction/stakeholder/approve';

        $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);


        $response1 = json_decode($response);

        if ($response1->Status == 200 && $response1->Success) {
            $objData = json_decode($this->decryptData($response1->Data));

            return redirect(route('initiation'))->with('success', 'Stakeholder Approved Successfully');
        } else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);
            exit;
        }
    }

    public function stakeholder_feedback(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => vbpfeedbackController => stakeholder_feedback';
        $this->WriteFileLog($request);
        $data = array();

        $data['stakeholder_feedback'] = $request->stakeholder_feedback;
        $data['valuer_id'] = $request->valuer_id;

        $encryptArray = $data;
        $request = array();

        $request['requestData'] = $encryptArray;

        $gatewayURL = config('setting.api_gateway_url') . '/instruction/stakeholder_feedback';

        $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

        $response1 = json_decode($response);

        if ($response1->Status == 200 && $response1->Success) {
            $objData = json_decode($this->decryptData($response1->Data));

            return redirect(route('initiation'))->with('success', 'Feedback submitted Successfully');
        } else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);
            exit;
        }
    }
    public function valuer_feedback(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => vbpfeedbackController => stakeholder_feedback';
        $this->WriteFileLog($request);
        $data = array();

        $data['valuer_feedback'] = $request->valuer_feedback;
        $data['valuer_id'] = $request->valuer_id;

        $encryptArray = $data;
        $request = array();

        $request['requestData'] = $encryptArray;

        $gatewayURL = config('setting.api_gateway_url') . '/instruction/valuer_feedback';

        $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

        $response1 = json_decode($response);

        if ($response1->Status == 200 && $response1->Success) {
            $objData = json_decode($this->decryptData($response1->Data));

            return redirect(route('instruction'))->with('success', 'Feedback submitted Successfully');
        } else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);
            exit;
        }
    }

    public function registar_feedback(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => vbpfeedbackController => registar_feedback';
        $this->WriteFileLog($request);
        $data = array();

        $data['registar_feedback'] = $request->registar_feedback;
        $data['valuer_id'] = $request->valuer_id;

        $encryptArray = $data;
        $request = array();

        $request['requestData'] = $encryptArray;

        $gatewayURL = config('setting.api_gateway_url') . '/instruction/registar_feedback';

        $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

        $response1 = json_decode($response);

        if ($response1->Status == 200 && $response1->Success) {
            $objData = json_decode($this->decryptData($response1->Data));

            return redirect(route('registar_index'))->with('success', 'Feedback submitted Successfully');
        } else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);
            exit;
        }
    }

    public function registar_index(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => vbpfeedbackController => index';
        $request =  array();
        $request['mlhud_id'] = $user_id;
        $gatewayURL = config('setting.api_gateway_url') . '/insrtuction/registar_index';

        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
        $response = json_decode($response);

        $objData = json_decode($this->decryptData($response->Data));

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

        return view('initiation.registar_index', compact('rows', 'user_id', 'menus', 'screens', 'modules'));
    }

    public function registar_show($id)
    {
        try {

            $method = 'Method => vbpfeedbackController => valuer_show';


            $gatewayURL = config('setting.api_gateway_url') . '/instruction/registar/show/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);



            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);

                    $rows = $parant_data['rows'];
                    $instruction = $parant_data['instruction'];

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view('initiation.registar_show', compact('rows', 'instruction', 'menus', 'screens', 'modules'));
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

    public function cgv_index(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => vbpfeedbackController => index';
        $request =  array();
        $request['mlhud_id'] = $user_id;
        $gatewayURL = config('setting.api_gateway_url') . '/instruction/cgv/approve';

        $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
        $response = json_decode($response);

        $objData = json_decode($this->decryptData($response->Data));

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

        return view('initiation.cgv_index', compact('rows', 'user_id', 'menus', 'screens', 'modules'));
    }

    public function cgv_approve($id)
    {
        try {

            $method = 'Method => vbpfeedbackController => valuer_show';


            $gatewayURL = config('setting.api_gateway_url') . '/instruction/cgv/approve/valuer/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);



            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);

                    $rows = $parant_data['rows'];
                    $instruction = $parant_data['instruction'];
                    $cgv = $parant_data['cgv'];
                    $firms = $parant_data['firms'];



                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view('initiation.cgv_approval', compact('cgv', 'rows', 'instruction', 'menus', 'screens', 'modules', 'firms'));
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

    public function approve_cgv(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => vbpfeedbackController => approve_cgv';
        $this->WriteFileLog($request);
        $data = array();

        $data['valuer_id'] = $request->valuer_id;


        $encryptArray = $data;
        $request = array();

        $request['requestData'] = $encryptArray;

        $gatewayURL = config('setting.api_gateway_url') . '/instruction/approve/cgv';

        $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);

        $response1 = json_decode($response);

        if ($response1->Status == 200 && $response1->Success) {
            $objData = json_decode($this->decryptData($response1->Data));

            return redirect(route('cgv_index'))->with('success', 'CGV Approved Successfully');
        } else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);
            exit;
        }
    }

    public function data_delete($id)
    {
        try {
            $method = 'Method => vbpfeedbackController => update';

            $gatewayURL = config('setting.api_gateway_url') . '/stakeholder/delete/' . $this->encryptData($id);

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    return redirect(route('initiation'))->with('success', 'Instruction Data Deleted  Successfully');
                }
                if ($objData->Code == 400) {
                    return Redirect::back()->with('fail', 'instruction Name Already Exists');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function reject_edit(Request $request, $id)
    {

        try {


            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => vbpfeedbackController => reject_edit';


            $gatewayURL = config('setting.api_gateway_url') . '/instruction/edit/reject/' . $this->encryptData($id);

            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);

                    $rows = $parant_data['rows'];
                    $instruction = $parant_data['instruction'];
                    $valuer_1 = $parant_data['valuer_1'];
                    $valuer_2 = $parant_data['valuer_2'];
                    $firm_reject = $parant_data['firm_reject'];

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view('initiation.reject_createdata', compact('valuer_1', 'valuer_2', 'rows', 'firm_reject', 'instruction', 'menus', 'screens', 'modules'));
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                return view('errors.errors');
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    // firm_instruction //(Deepika)





    public function instruct_create(Request $request, $id)
    {


        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $user_id = $request->session()->get("userID");
        $method = 'Method => vbpfeedbackController => create';
        $urd = "exp";
        if ($urd == "exp") {
            $gatewayURL = config('setting.api_gateway_url') . '/instruct/instruct_create/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows = json_decode(json_encode($objData->Data), true);



                    $firm_partners = $parant_data['firm_partners'];
                    $instruction = $parant_data['instruction'];

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view('instructionfirm.firm_instruction_create', compact('rows', 'menus', 'screens', 'modules', 'firm_partners', 'instruction'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                echo json_encode($objData->Code);
                exit;
            }
        }
    }
    public function update(Request $request)
    {
        try {
            $method = 'Method => vbpfeedbackController => update';
            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }
            $data = array();
            $data['instruction_name'] = $request->Instruction_name;
            $data['description'] = $request->description;
            $data['instruction_id'] = $request->instruction_id;

            $encryptArray = $this->encryptData($data);

            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/stakeholder/update';

            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    if ($mobile == 1) {
                        return ['status_code' => '200', 'message' => 'instruction Updated Successfully'];
                    }
                    return redirect(route('initiation/create'))->with('success', 'instruction Updated Successfully');
                }
                if ($objData->Code == 400) {
                    if ($mobile == 1) {
                        return ['status_code' => '400', 'message' => 'Instruction Name Already Exists'];
                    }
                    return Redirect::back()->with('fail', 'Instruction Name Already Exists');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function firm_update(Request $request)
    {

        try {
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => vbpfeedbackController => update';

            $data = array();
            $data['task_name'] = $request->task_name;
            $data['valuer_name'] = $request->valuer_name;
            $data['stakeholder_id'] = $request->stakeholder_id;
            $data['totalid'] = $request->totalid;
            $data['description'] = $request->description;
            $data['type'] = $request->type;


            $encryptArray = $data;
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/stakeholder/firm_update';

            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                return;
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }



    public function instruct_show($id, $type)
    {

        try {

            $method = 'Method => vbpfeedbackController => instruct_show';

            $gatewayURL = config('setting.api_gateway_url') . '/instruct/show/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);


            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));

                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);

                    $rows = $parant_data['rows'];

                    $firms = $parant_data['firms'];
                    $instruction = $parant_data['instruction'];
                    $role_id = $parant_data['role_id'];


                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view('instructionfirm.firm_instruction_show', compact('rows', 'instruction', 'menus', 'screens', 'modules', 'role_id', 'firms', 'type'));
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



    public function firm_submit(Request $request)
    {


        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => vbpfeedbackController => form_submit';

        $data = array();



        $encryptArray = $data;
        $request = array();
        $request['requestData'] = $encryptArray;

        $gatewayURL = config('setting.api_gateway_url') . '/instruct/firm_submit';

        $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
        $this->WriteFileLog($response);
        $response1 = json_decode($response);

        if ($response1->Status == 200 && $response1->Success) {
            $objData = json_decode($this->decryptData($response1->Data));


            if ($objData->Code == 200) {
                return redirect(route('instruction'))->with('success', 'Instruction Submitted  Successfully');
            }

            if ($objData->Code == 400) {
                return redirect(route('initiation.vpb_create'))->with('fail', 'Initiation Details Already Exists');
            }
        } else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);
            exit;
        }
    }


    public function firmreject_edit(Request $request, $id)
    {

        try {


            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => vbpfeedbackController => firmreject_edit';


            $gatewayURL = config('setting.api_gateway_url') . '/instruct/edit/firmreject/' . $this->encryptData($id);

            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);

                    $rows = $parant_data['rows'];
                    $instruction = $parant_data['instruction'];
                    $valuer_1 = $parant_data['valuer_1'];
                    $valuer_2 = $parant_data['valuer_2'];
                    $firm = $parant_data['firm'];

                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view('instructionfirm.firm_instruction_reject', compact('valuer_1', 'valuer_2', 'rows', 'instruction', 'menus', 'screens', 'modules', 'firm'));
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                return view('auth.login')->with('fail', 's');

                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    public function firmreject_store(Request $request)
    {

        $this->WriteFileLog('web');
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => vbpfeedbackController => reject_store';

        $data = array();
        $data['task_name'] = $request->task_name;
        $data['valuer_name'] = $request->valuer_name;
        $data['stakeholder_id'] = $user_id;
        $data['totalid'] = $request->totalid;
        $data['process_type'] = $request->process_type;

        $data['description'] = $request->description;
        $data['previous_element'] = $request->previous_element;


        $encryptArray = $data;
        $request = array();
        $request['requestData'] = $encryptArray;

        $gatewayURL = config('setting.api_gateway_url') . '/instruct/firmreject/store';

        $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);

        $response1 = json_decode($response);

        if ($response1->Status == 200 && $response1->Success) {
            $objData = json_decode($this->decryptData($response1->Data));


            if ($objData->Code == 200) {
                return redirect(route('initiation/create'))->with('success', 'Initation Completed Successfully');
            }

            if ($objData->Code == 400) {
                return redirect(route('initiation.vpb_create'))->with('fail', 'Initiation Details Already Exists');
            }
        } else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);
            exit;
        }
    }
}
