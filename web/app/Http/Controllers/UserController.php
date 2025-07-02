<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\DB;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {


        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        // $dynamiclistdata = $this->FillDyanamiclist();
        // // echo json_encode($dynamiclistdata);exit;
        //   if(empty($dynamiclistdata) && empty($request['dynamictype'])){
        //          return redirect()->route('not_allow');
        //        }
        if (strpos($screen_permission['permissions'], 'View') !== false) {
            try {
                $method = 'Method => UserController => index';
                $gatewayURL = config('setting.api_gateway_url') . '/user/get_user_list';
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
                        $permission = $this->FillScreensByUser();
                        $screen_permission = $permission[0];
                        //    if($request['dynamictype']=='dynamiclist')
                        //    {

                        //      return $rows;
                        //    }
                        //    else{
                        return view('uam.user.index', compact('rows', 'screens', 'modules', 'screen_permission'));
                        //  }
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

    public function policypage()
    {

        try {
            $method = 'Method => UserController => policypage';
            $gatewayURL = config('setting.api_gateway_url') . '/user/policypage';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
           
            $response = json_decode($response);
            
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data['rows'];

                    return view('privacy.policypage', compact('rows'));
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






    public function bulk_upload()
    {
        try {

            $method = 'Method => UserController => reset_token_expire_method';


            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];

            return view('uam.user.bulk_upload', compact('modules', 'screens'));
        } catch (\Exception $exc) {
            echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    public function dummy_bulk_upload(Request $request)
    {
        try {
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => UserController => reset_token_expire_method';


            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];

            return view('uam.user.dummy_bulk_upload', compact('modules', 'screens'));
        } catch (\Exception $exc) {
            echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    // else{
    //     return redirect()->route('not_allow');
    // }

    // }






    public function reset_token_expire_method()
    {
        //     $permission_data = $this->FillScreensByUser();
        // $screen_permission = $permission_data[0];
        // if(strpos($screen_permission['permissions'], 'View') !== false){
        try {
            $method = 'Method => UserController => reset_token_expire_method';
            $gatewayURL = config('setting.api_gateway_url') . '/user/reset_expire_data_get';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $row =  $parant_data['rows'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];


                    // echo json_encode($rows);exit;

                    $permission = $this->FillScreensByUser();
                    $screen_permission = $permission[0];
                    return view('uam.user.token_expire', compact('row', 'screens', 'modules', 'screen_permission'));
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









    //    else{
    //        return redirect()->route('not_allow');
    //    }

    //    }

    public function department_list()
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'View') !== false) {
            try {
                $method = 'Method => UserController => department_list';
                $gatewayURL = config('setting.api_gateway_url') . '/user/department_list';
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

                        // echo json_encode($rows);exit;

                        $permission = $this->FillScreensByUser();
                        $screen_permission = $permission[0];
                        return view('uam.user.department_list', compact('rows', 'modules', 'screens'));
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
    }



    public function project_roles_list()
    {
        //return "sfgsg";

        try {
            $method = 'Method => UserController => project_roles_list';
            $gatewayURL = config('setting.api_gateway_url') . '/user/project_roles_list';
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

                    // echo json_encode($rows);exit;

                    $permission = $this->FillScreensByUser();
                    $screen_permission = $permission[0];
                    return view('uam.user.project_roles_list', compact('rows', 'modules', 'screens'));
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



    public function token_expire_data_update(Request $request)
    {

        //return $request;

        try {
            $method = 'Method => UserController => token_expire_data_update';
            $data = array();
            $data['settings_time'] = $request->settings_time;
            $data['settings_id'] = $request->settings_id;
            $data['settings_movement'] = $request->settings_movement;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/user/token_expire_data_update';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {

                    return redirect(route('home'))->with('success', 'Token Expire Settings Changed Successfully');
                }

                if ($objData->Code == 400) {
                    return Redirect::back()->with('fail', 'Token Expire Not Update');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }




    public function create()
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Create') !== false) {
            try {
                $method = 'method => UserController => create';
                $gatewayURL =  config('setting.api_gateway_url') . '/user/get_roles_list';
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
                $response = json_decode($response);
                if ($response->Status == 200 && $response->Success) {
                    $objData = json_decode($this->decryptData($response->Data));
                    if ($objData->Code == 200) {
                        $parant_data = json_decode(json_encode($objData->Data), true);
                        $rows =  $parant_data['rows'];


                        //    $directorate =  $parant_data['directorate'];
                        $designation =  $parant_data['designation'];
                        //    $document_folder_structure_id =  $parant_data['document_folder_structure_id'];
                        $dashboard =  $parant_data['dashboard'];
                        //    $parent_folder =  $parant_data['parent_folder'];
                        //    $department =  $parant_data['department'];
                        //    $sub_department = $parant_data['sub_department'];
                        //    $document_category = $parant_data['document_category'];
                        $project_roles =  $parant_data['project_roles'];
                        $menus = $this->FillMenu();
                        $screens = $menus['screens'];
                        $modules = $menus['modules'];
                        return view('uam.user.create', compact('rows', 'designation', 'dashboard', 'project_roles', 'screens', 'modules'));
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



    public function store(Request $request)

    {

        try {
            $method = 'Method => UserController => store';

            $rules = [
                'name' => 'required',
                'email' => 'required',
                'roles_id' => 'required',

                'password' => 'required|string|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
                'confirm_password' => 'required|same:password',
                // 'directorate_department' => 'required',
                'dashboard_list_id' => 'required',
                'designation' => 'required',
            ];

            $messages = [
                'name.required' => 'User name is required',
                'email.required' => 'Email is required',
                'roles_id.required' => 'Roles id is required',
                'password.required' => 'Password is required',
                'confirm_password.required' => 'Please enter same password',
                // 'directorate_department.required' => 'Directorate Department is required',
                'dashboard_list_id.required' => 'Dashboard list is required ',
                'designation.required' => 'Designation is required',

            ];

            // $validator = Validator::make($request->all(), $rules, $messages);


            {

                $gatewayURL = config('setting.api_gateway_url') . '/user/user_register';

                // $this->WriteFileLog($gatewayURL);
                // $directorate = $request->directorate_department;

                // $directorate_department =  explode("-", $directorate); 

                // $displayItems2 = $request->displayItems2;

                // $displayItems2_department =  explode(":", $displayItems2); 

                $userRow = array();
                $userRow['name'] = $request->name;
                $userRow['email'] = $request->email;
                $userRow['roles_id'] = $request->roles_id;
                // Professionalmemaber 
                $userRow['gender'] = $request->gender;
                $userRow['country'] = $request->country;
                $userRow['mobile_no'] = $request->Mobile_no;
                $userRow['license_number'] = $request->license;
                $userRow['method'] = $request->payment;
                $userRow['bank_name'] = $request->bank_name;
                $userRow['bank_transaction_id'] = $request->bank_transaction_id;
                $userRow['amount'] = $request->amount;
                $userRow['amount_paid_on'] = $request->amount_paid_on;
                $userRow['renewal_date'] = $request->renewal_date;
                $userRow['valuertype'] = $request->valuertype;

                // $userRow['project_role_id'] = $request->project_role_id;
                $userRow['password'] = $request->password;
                $userRow['c_password'] = $request->confirm_password;
                $userRow['user_type'] = $request->user_type;
                // $userRow['directorate_department'] = $directorate_department;
                $userRow['dashboard_list_id'] = $request->dashboard_list_id;
                $userRow['designation'] = $request->designation_id;
                // $userRow['parent_node_id'] = $request->parent_node_id;
                // $userRow['directorate'] = $directorate;
                // $userRow['array_department'] = $displayItems2_department;
                $encryptArray = $this->encryptData($userRow);
                $request1 = array();
                $request1['requestData'] = $encryptArray;

                // echo json_encode($userRow);exit;
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request1), $method);
                $response1 = json_decode($response);
                /// echo json_encode($response1);exit;

                if ($response1->Status == 200 && $response1->Success) {
                    $objData = json_decode($this->decryptData($response1->Data));
                    if ($objData->Code == 200) {

                        $parant_data = json_decode(json_encode($objData->Data), true);
                        // $user_id =  $parant_data['user_id'];
                        //echo json_encode($user_id);exit;


                        $userRow = array();
                        $userRow['userID'] = $parant_data;
                        $userRow['firstName'] = $request->name;
                        $userRow['lastName'] = "A";
                        $userRow['emailID'] = $request->email;

                        //    $encryptArray = $this->encryptData($userRow);
                        //    $request = array();
                        //    $request['requestData'] = $encryptArray;
                        //    $gatewayURL = config('setting.api_gateway_url').'/document/site/user/create';

                        //    $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
                        //    $response1 = json_decode($response);

                        return redirect(route('user.index'))->with('success', 'User created successfully and mail sent
                ');
                    }

                    if ($objData->Code == 400) {
                        return redirect(route('user.create'))->with('success', 'Email already found.Please change email id');
                    }
                } else {
                    $objData = json_decode($this->decryptData($response1->Data));
                    echo json_encode($objData->Code);
                    exit;
                }
            }
        } catch (\Exception $exc) {
            echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    public function change_password_admin($id)
    {

        // return "adfadfds";exit;
        $id = $this->decryptData($id);



        // return $id;


        try {
            $method = 'Method => HomeController => change_password_admin';


            // $gatewayURL = config('setting.api_gateway_url').'/site/dashboard';
            // $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            // $response = json_decode($response);

            // if($response->Status == 200 && $response->Success){
            //     $data = json_decode($this->decryptData($response->Data));
            //     $row = $data->Data;
            //     // echo json_encode($row->screen_dashboard);exit;
            //     $menus = $this->FillMenu();
            //     $screens = $menus['screens'];
            //    $modules = $menus['modules'];
            //     return view('home', compact('row','modules','screens'));
            // }

            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];

            return view('uam.user.change_password_admin', compact('modules', 'screens', 'id'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }



    public function edit($id)
    {

        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Edit') !== false) {

            try {
                $method = 'Method => UserController => edit';

                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/user/data_edit/' . $this->encryptData($id);
                $response1 = $this->serviceRequest($gatewayURL, 'GET', '', $method);
                $response = json_decode($response1);
                if ($response->Status == 200 && $response->Success) {
                    $objData = json_decode($this->decryptData($response->Data));

                    if ($objData->Code == 200) {
                        $parant_data = json_decode(json_encode($objData->Data), true);
                        $one_row =  $parant_data['one_row'];



                        $rows_data =  $parant_data['rows_data'];
                        //    $directorate =  $parant_data['directorate'];
                        //    $parent_folder =  $parant_data['parent_folder'];
                        //    $department =  $parant_data['department'];
                        //    $sub_department = $parant_data['sub_department'];
                        $dashboard =  $parant_data['dashboard'];

                        $designation =  $parant_data['designation'];
                        //    $document_category = $parant_data['document_category'];
                        $project_roles =  $parant_data['project_roles'];
                        //    $document_folder_structure_id =  $parant_data['document_folder_structure_id'];

                        $menus = $this->FillMenu();
                        $screens = $menus['screens'];
                        $modules = $menus['modules'];

                        return view('uam.user.edit', compact('designation', 'dashboard', 'one_row', 'rows_data', 'project_roles', 'screens', 'modules'));
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
                $method = 'Method => UserController => show';
                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/user/data_edit/' . $this->encryptData($id);
                $response1 = $this->serviceRequest($gatewayURL, 'GET', '', $method);
                $response = json_decode($response1);
                if ($response->Status == 200 && $response->Success) {
                    $objData = json_decode($this->decryptData($response->Data));
                    if ($objData->Code == 200) {
                        $parant_data = json_decode(json_encode($objData->Data), true);
                        $one_row =  $parant_data['one_row'];
                        $rows_data =  $parant_data['rows_data'];
                        //    $directorate =  $parant_data['directorate'];
                        //    $parent_folder =  $parant_data['parent_folder'];
                        //    $department =  $parant_data['department'];
                        //    $sub_department = $parant_data['sub_department'];
                        $dashboard =  $parant_data['dashboard'];
                        $designation =  $parant_data['designation'];
                        //    $document_category = $parant_data['document_category'];
                        $project_roles =  $parant_data['project_roles'];
                        //    $document_folder_structure_id =  $parant_data['document_folder_structure_id'];
                        $menus = $this->FillMenu();
                        $screens = $menus['screens'];
                        $modules = $menus['modules'];
                        return view('uam.user.show', compact('rows_data', 'one_row', 'designation', 'dashboard', 'project_roles', 'screens', 'modules'));
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


    public function update_user_data(Request $request)

    {
        try {
            $method = 'Method => UserController => update_data';

            $rules = [
                'name' => 'required',
                'email' => 'required',
                'roles_id' => 'required',
                // 'project_role_id'=> 'required',
                // 'directorate_department' => 'required',
                // 'dashboard_list_id' => 'required',
                 'designation_id' => 'required',
            ];
            $messages = [
                'name.required' => 'User name is required',
                'email.required' => 'Email is required',
                'roles_id.required' => 'Roles id is required',
                //  'project_role_id.required' => 'Project role id is required',
                // 'directorate_department.required' => 'Directorate Department is required',
                // 'dashboard_list_id.required' => 'Dashboard list is required ',
                 'designation_id.required' => 'Designation is required',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
             
                return Redirect::back()->withErrors($validator);
            } else {

                // $directorate = $request->directorate_department;

                // $directorate_department =  explode("-", $directorate); 

                // $displayItems2 = $request->displayItems2;

                // $displayItems2_department =  explode(":", $displayItems2); 


                $data = array();

                $data['name'] = $request->name;
                $data['user_id'] = $request->user_id;
                $data['roles_id'] = $request->roles_id;
                $data['project_role_id'] = $request->project_role_id;
                $data['email'] = $request->email;
                // $data['directorate_department'] = $directorate_department;
                $data['dashboard_list_id'] = $request->dashboard_list_id;
                $data['designation_id'] = $request->designation_id;
                $data['parent_node_id'] = $request->parent_node_id;
                // $data['directorate'] = $directorate;
                // $data['array_department'] = $displayItems2_department;


                $encryptArray = $this->encryptData($data);
                $request = array();
                $request['requestData'] = $encryptArray;
                $gatewayURL = config('setting.api_gateway_url') . '/user/updatedata';
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
                $response1 = json_decode($response);
             
                if ($response1->Status == 200 && $response1->Success) {
                    $objData = json_decode($this->decryptData($response1->Data));
                  
                    if ($objData->Code == 200) {
                        return redirect(route('user.index'))->with('success', 'UAM user updated successfully');
                    }
                    if ($objData->Code == 400) {
                        return redirect(route('user.edit'))->with('success', 'Email already found.Please change email id');
                    }
                } else {
                    $objData = json_decode($this->decryptData($response1->Data));
                    echo json_encode($objData->Code);
                    exit;
                }
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }



    public function get_department_list(Request $request)
    {
        try {
            $method = 'Method => UserController => get_department_list';

            $data = array();
            $data['directorate'] = $request->directorate;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            //echo json_encode($request);exit;
            $gatewayURL = config('setting.api_gateway_url') . '/user/get_department_list';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $department =  $parant_data['department'];
                    echo json_encode($department);
                    exit;
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


    // /**
    // * Remove the specified resource from storage.
    // *
    // * @param  int  $id
    // * @return \Illuminate\Http\Response
    // */
    // public function update($update,$id)
    // {
    // //echo "sdf";exit;
    // //
    // }
    // public function destroy($id)
    // {
    // //echo "sdf";exit;
    // //
    // }
    public function delete($id)
    {

        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Delete') !== false) {
            try {
                //  dd("hjh");
                $method = 'Method => UserController => delete';
                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/user/delete/' . $this->encryptData($id);
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
                $response1 = json_decode($response);
                if ($response1->Status == 200 && $response1->Success) {
                    $objData = json_decode($this->decryptData($response1->Data));

                    if ($objData->Code == 200) {
                        return redirect(route('user.index'))->with('success', 'UAM user deleted successfully');
                    }

                    if ($objData->Code == 400) {
                        return redirect(route('user.index'))->with('fail', 'This user allocated one work flow');
                    }

                    if ($objData->Code == 800) {
                        return redirect(route('user.index'))->with('fail', 'This user allocated to transactions');
                    }


                    if ($objData->Code == 1000) {
                        return redirect(route('user.index'))->with('fail', 'Your not do this operation');
                    }
                }
            } catch (\Exception $exc) {
                return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
            }
        } else {
            return redirect()->route('not_allow');
        }
    }

    public function edit_permission($id)

    {

        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Edit') !== false) {
            try {
                $method = 'Method => UserController => edit_permission';

                $id = $this->decryptData($id);

                $gatewayURL = config('setting.api_gateway_url') . '/user/edit_permission/' . $this->encryptData($id);

                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
                $response = json_decode($response);

                if ($response->Status == 200 && $response->Success) {
                    $objData = json_decode($this->decryptData($response->Data));
                    if ($objData->Code == 200) {
                        $parant_data = json_decode(json_encode($objData->Data), true);

                        $module_data =  $parant_data['module_data'];
                        $screens_data =  $parant_data['screen_data'];
                        $permissions_data =  $parant_data['permission_data'];


                        $user_id =  $parant_data['user_id'];
                        $rows =   $parant_data['rows'];
                        $role_name =   $parant_data['role_name'];


                        //echo json_encode($rows);exit;

                        $menus = $this->FillMenu();
                        $screens = $menus['screens'];
                        $modules = $menus['modules'];

                        return view('uam.user.edit_permission', compact('screens_data', 'modules', 'screens', 'module_data', 'permissions_data', 'user_id', 'rows', 'role_name'));
                    }
                }
            } catch (\Exception $exc) {
                return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
            }
        } else {
            return redirect()->route('not_allow');
        }
    }

    public function update_data_permission(Request $request)
    {
        try {
            $method = 'Method => UserController => update_data_permission';
            $rules = [
                'screen_id' => 'required',
            ];
            $messages = [
                'screen_id.required' => 'Screen is required',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator);
            } else {
                $directorate = $request->screen_id;
                $screen_id =  explode("-", $directorate);
                $directorate1 = $request->permission_id;
                $permission_id =  explode(":", $directorate1);
                $data = array();
                $data['screen_id'] = $screen_id;
                $data['user_id'] = $request->user_id;
                $data['permission_id'] = $permission_id;
                $encryptArray = $this->encryptData($data);
                $request = array();
                $request['requestData'] = $encryptArray;
                $gatewayURL = config('setting.api_gateway_url') . '/user/updatedatapermission';
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
                $response1 = json_decode($response);
                if ($response1->Status == 200 && $response1->Success) {
                    $objData = json_decode($this->decryptData($response1->Data));
                    if ($objData->Code == 200) {
                        return redirect(route('user.index'))->with('success', 'UAM User Permission Updated Successfully');
                    }
                    if ($objData->Code == 400) {
                        return redirect(route('user.edit'))->with('fail', 'UAM User Permission Not Updated');
                    }
                }
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    public function notifications(Request $request)
    {

        try {
            $method = 'Method => UserController => notifications';
            $user_id = $request->session()->get("userID");

            $data = array();
            $data['id'] = $user_id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/user/notifications';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    return $parant_data;
                }
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    public function notified(Request $request)
    {

        try {
            $method = 'Method => UserController => notified';
            $notification_id = $request->id;
            $data = array();
            $data['id'] = $notification_id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/user/notified';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    return $parant_data;
                }
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    public function notification_alert(Request $request)
    {

        try {
            $method = 'Method => UserController => notification_alert';
            $data = array();
            $data['notification_id'] = $request->notification_id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/user/notification_alert';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    return $parant_data;
                }
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function update_toggle(Request $request)
    {
        try {
            $method = 'Method => UserController => update_toggle';
            $data = array();
            $data['is_active'] = $request->is_active;
            $data['f_id'] = $request->f_id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/user/update_toggle';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);


            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                echo $this->decryptData($response1->Data);
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }






    public function professional_license(Request $request)
    {

        $method = 'Method => UserController => professional_license';
        try {
            $user_id = $request->session()->get("userID");

            if ($user_id == null) {
                return redirect(url('/'));
            }


            $country = $request->country;
            $mobile = $request->mobile_no;
            $gender = $request->gender;
            $license_number = $request->license_number;
            $method = $request->method;
            $bank_name = $request->bank_name;
            $bank_transaction_id = $request->bank_transaction_id;
            $amount = $request->amount;
            $amount_paid_on = $request->amount_paid_on;



            $rows = DB::table('users')
                ->insert([
                    'country' => $country,
                    'mobile_no' => $mobile,
                    'gender' => $gender,
                    'user_id' =>  $user_id,
                    'active_flag' => '0',
                    'created_by' => $user_id,
                    'created_at' => NOW()
                ]);

            $rows = DB::table('professional_member_licence')
                ->insert([
                    'license_number' => $license_number,
                    'method' => $method,
                    'bank_name' => $bank_name,
                    'bank_transaction_id' => $bank_transaction_id,
                    'amount' => $amount,
                    'amount_paid_on' => $amount_paid_on,
                    'user_id' =>  $user_id,
                    'active_flag' => '0',
                    'created_by' => $user_id,
                    'created_at' => NOW()
                ]);
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
}
