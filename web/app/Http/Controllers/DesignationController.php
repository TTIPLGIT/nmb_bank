<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Redirect;
use Validator;

class DesignationController extends BaseController
{


    public function index(Request $request)
    {

        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];

        // else if(strpos($screen_permission['permissions'], 'View') !== false){
        try {
            $method = 'Method => DesignationController => index';
            $serviceResponse = array();

            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $gatewayURL = config('setting.api_gateway_url') . '/designation/get_data';
            $response = $this->serviceRequest($gatewayURL, 'GET', $serviceResponse, $method);

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
                    return view('designation.index', compact('rows', 'screens', 'modules', 'screen_permission'));
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
        // }
        // else{
        //    return redirect()->route('not_allow');
        // }
    }


    public function create()
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Create') !== false) {
            try {
                $method = 'Method => DesignationController => create';
                $gatewayURL = config('setting.api_gateway_url') . '/designation/get_designation';
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
                $response = json_decode($response);

                if ($response->Status == 200 && $response->Success) {

                    $objData = json_decode($this->decryptData($response->Data));

                    if ($objData->Code == 200) {
                        $parant_data = json_decode(json_encode($objData->Data), true);
                        $roles =  $parant_data['roles'];
                        $menus = $this->FillMenu();
                        $screens = $menus['screens'];
                        $modules = $menus['modules'];
                        return view('designation.create', compact('roles', 'modules', 'screens'));
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
            $method = 'Method => DesignationController => store';
            $rules = [
                'designation_name' => 'required',



            ];

            $messages = [
                'designation_name.required' => 'Designation is required',



            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator);
            } else {
                $data = array();
                $data['designation_name'] = $request->designation_name;
                $data['notes'] = $request->designation_description;
                $data['role_id'] = $request->role_id;
                $encryptArray = $this->encryptData($data);
                $request = array();
                $request['requestData'] = $encryptArray;
                $gatewayURL = config('setting.api_gateway_url') . '/designation/storedata';
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
                $response1 = json_decode($response);
            }

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));

                if ($objData->Code == 200) {
                    return redirect(route('designation.index'))->with('success', 'Designation Created Successfully');
                }


                if ($objData->Code == 400) {
                    return Redirect::back()->with('fail', 'Designation Already Exists');
                    //return redirect(route('designation.create'))->with('fail', 'Designation Already Exists');
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
                $method = 'Method => DesignationController => edit';
                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/designation/data_edit/' . $this->encryptData($id);
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
                $response = json_decode($response);
                if ($response->Status == 200 && $response->Success) {
                    $objData = json_decode($this->decryptData($response->Data));
                    if ($objData->Code == 200) {
                        $parant_data = json_decode(json_encode($objData->Data), true);
                        $designation =  $parant_data['rows'];
                        $roles =  $parant_data['roles'];
                        $menus = $this->FillMenu();
                        $screens = $menus['screens'];
                        $modules = $menus['modules'];
                        return view('designation.edit', compact('designation', 'modules', 'screens', 'roles'));
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
                $method = 'Method => DesignationController => show';
                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/designation/data_edit/' . $this->encryptData($id);
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
                $response = json_decode($response);
                if ($response->Status == 200 && $response->Success) {
                    $objData = json_decode($this->decryptData($response->Data));
                    if ($objData->Code == 200) {
                        $parant_data = json_decode(json_encode($objData->Data), true);
                        $designation =  $parant_data['rows'];
                          $roles =  $parant_data['roles'];
                        $menus = $this->FillMenu();
                        $screens = $menus['screens'];
                        $modules = $menus['modules'];
                        return view('designation.show', compact('designation', 'modules', 'screens','roles'));
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
            $method = 'Method => DesignationController => update_data';
            $data = array();
            $rules = [
                'designation_name' => 'required',
                'role_id' => 'required',



            ];

            $messages = [
                'designation_name.required' => 'Designation is required',
                'role_id.required' => 'Role is required',


            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator);
            } else {
               
                $data['designation_name'] = $request->designation_name;
                $data['notes'] = $request->notes;
                $data['id'] = $request->id;
                $data['role_id'] = $request->role_id;
               
                $encryptArray = $this->encryptData($data);
                $request = array();
                $request['requestData'] = $encryptArray;
                $gatewayURL = config('setting.api_gateway_url') . '/designation/updatedata';
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
                $response1 = json_decode($response);
            }
             
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
            }
          
            if ($objData->Code == 200) {
                return redirect(route('designation.index'))->with('success', 'Designation Updated Successfully');
            }

            if ($objData->Code == 400) {
                return Redirect::back()->with('fail', 'Designation Already Exists');
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

                $method = 'Method => DesignationController => delete';
                $id = $this->decryptData($id);

                $gatewayURL = config('setting.api_gateway_url') . '/FAQ_modules/data_delete/' . $this->encryptData($id);
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);



                $response1 = json_decode($response);
                if ($response1->Status == 200 && $response1->Success) {
                    $objData = json_decode($this->decryptData($response1->Data));
                    if ($objData->Code == 200) {
                        return redirect(route('FAQ_modules.index'))->with('success', 'FAQ Modules Deleted Successfully.');
                    }
                    if ($objData->Code == 400) {
                        return redirect(route('FAQ_modules.index'))->with('fail', 'This Module Allocated One FAQ Question');
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









    // bulk upload


    public function bulkdummyupload(Request $request)
    {


        try {
            $method = 'Method => DesignationController => bulkdummyupload';
            $data = array();
            $data['jsonObject'] = $request->jsonObject;



            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/document_category/bulkdummyupload';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {
                    $users =  "Success";


                    echo json_encode($users);
                    exit;
                }
            }
        } catch (\Exception $exc) {
            echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }






    public function checking_data(Request $request)
    {
        //return $request;

        try {
            $method = 'Method => DesignationController => checking_data';


            // role checking
            if ($request->checking == 1) {
                $data = array();
                $data['screen_role_id'] = $request->screen_role_id;
                $data['checking'] = $request->checking;

                $encryptArray = $this->encryptData($data);
                $request = array();
                $request['requestData'] = $encryptArray;
                $gatewayURL = config('setting.api_gateway_url') . '/document_category/checking_data';
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
                $response1 = json_decode($response);
                if ($response1->Status == 200 && $response1->Success) {
                    $objData = json_decode($this->decryptData($response1->Data));
                    if ($objData->Code == 200) {
                        $users =  "Success";


                        echo json_encode($users);
                        exit;
                    }

                    if ($objData->Code == 400) {
                        $users =  "Failure";


                        echo json_encode($users);
                        exit;
                    }
                }
            }

            // project role checking

            if ($request->checking == 2) {
                $data = array();
                $data['project_role_id'] = $request->project_role_id;
                $data['checking'] = $request->checking;

                $encryptArray = $this->encryptData($data);
                $request = array();
                $request['requestData'] = $encryptArray;
                $gatewayURL = config('setting.api_gateway_url') . '/document_category/checking_data';
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
                $response1 = json_decode($response);
                if ($response1->Status == 200 && $response1->Success) {
                    $objData = json_decode($this->decryptData($response1->Data));
                    if ($objData->Code == 200) {
                        $users =  "Success";


                        echo json_encode($users);
                        exit;
                    }

                    if ($objData->Code == 400) {
                        $users =  "Failure";


                        echo json_encode($users);
                        exit;
                    }
                }
            }

            if ($request->checking == 3) {
                $data = array();
                $data['designation_id'] = $request->designation_id;
                $data['checking'] = $request->checking;

                $encryptArray = $this->encryptData($data);
                $request = array();
                $request['requestData'] = $encryptArray;
                $gatewayURL = config('setting.api_gateway_url') . '/document_category/checking_data';
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
                $response1 = json_decode($response);
                if ($response1->Status == 200 && $response1->Success) {
                    $objData = json_decode($this->decryptData($response1->Data));
                    if ($objData->Code == 200) {
                        $users =  "Success";


                        echo json_encode($users);
                        exit;
                    }

                    if ($objData->Code == 400) {
                        $users =  "Failure";


                        echo json_encode($users);
                        exit;
                    }
                }
            }


            if ($request->checking == 4) {
                $data = array();
                $data['department_id'] = $request->department_id;
                $data['checking'] = $request->checking;

                $encryptArray = $this->encryptData($data);
                $request = array();
                $request['requestData'] = $encryptArray;
                $gatewayURL = config('setting.api_gateway_url') . '/document_category/checking_data';
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
                $response1 = json_decode($response);
                if ($response1->Status == 200 && $response1->Success) {
                    $objData = json_decode($this->decryptData($response1->Data));
                    if ($objData->Code == 200) {
                        $users =  "Success";


                        echo json_encode($users);
                        exit;
                    }

                    if ($objData->Code == 400) {
                        $users =  "Failure";


                        echo json_encode($users);
                        exit;
                    }
                }
            }



            if ($request->checking == 5) {
                $data = array();
                $data['email'] = $request->email;
                $data['checking'] = $request->checking;

                $encryptArray = $this->encryptData($data);
                $request = array();
                $request['requestData'] = $encryptArray;
                $gatewayURL = config('setting.api_gateway_url') . '/document_category/checking_data';
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
                $response1 = json_decode($response);
                if ($response1->Status == 200 && $response1->Success) {
                    $objData = json_decode($this->decryptData($response1->Data));
                    if ($objData->Code == 200) {
                        $users =  "Success";


                        echo json_encode($users);
                        exit;
                    }

                    if ($objData->Code == 400) {
                        $users =  "Failure";


                        echo json_encode($users);
                        exit;
                    }
                }
            }



            if ($request->checking == 6) {
                $data = array();
                $data['email'] = $request->email;
                $data['checking'] = $request->checking;

                $encryptArray = $this->encryptData($data);
                $request = array();
                $request['requestData'] = $encryptArray;
                $gatewayURL = config('setting.api_gateway_url') . '/document_category/checking_data';
                $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
                $response1 = json_decode($response);
                if ($response1->Status == 200 && $response1->Success) {
                    $objData = json_decode($this->decryptData($response1->Data));
                    if ($objData->Code == 200) {
                        $users =  "Success";


                        echo json_encode($users);
                        exit;
                    }

                    if ($objData->Code == 400) {
                        $users =  "Failure";


                        echo json_encode($users);
                        exit;
                    }
                }
            }
        } catch (\Exception $exc) {
            echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
}
