<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class ElearningEventController extends BaseController
{
    // Noticeboard Start //


    public function event_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($validator->fails()) {
            // Validation failed
            return redirect()->back()->with('error', 'Files should be image');
        }
        try {

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => ElearningEventController => event_store';

            $data = array();
            $data['user_category'] = $request->user_category;
            $data['event_name'] = $request->event_name;
            $data['event_description'] = $request->event_description;
            $data['event_date'] = $request->event_date;



            $encryptArray = $data;

            $storagepath_ursb_old = public_path() . '/uploads/notice/' . $user_id; //system_store_pdf
            $storagepath_ursb = '/uploads/notice/' . $user_id; //database_location
            if (!File::exists($storagepath_ursb_old)) {
                File::makeDirectory($storagepath_ursb_old); //folder_creation_when_folder_doesn't_esist
            }
            $data['event_path'] = $storagepath_ursb;
            $documentsb =  $request['event_image'];
            $files = $documentsb->getClientOriginalName();
            $findspace = array(' ', '&', "'", '"');
            $replacewith = array('-', '-');
            $proposal_files = str_replace($findspace, $replacewith, $files); //proper_file_name-database field
            $documentsb->move($storagepath_ursb_old, $proposal_files); //storing the file in the system
            $data['event_image'] = $proposal_files;

            $encryptArray = $data;
            $request = array();
            $request['requestData'] = $encryptArray;

            //dd($data);


            $gatewayURL = config('setting.api_gateway_url') . '/event_store';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {

                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {

                    return redirect(route('elearning.adminevent'))->with('success', 'Events Created Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('elearning.adminevent'))->with('fail', 'Events Failed To Create');
                }
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function adminevent_list(Request $request)
    {

        // dd($request);
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => ElearningEventController => adminevent_list';
        try {
            $request =  array();
            $request['mlhud_id'] = $user_id;
            $gatewayURL = config('setting.api_gateway_url') . '/adminevent_list';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
            $response = json_decode($response);


            $objData = json_decode($this->decryptData($response->Data));
            //dd($objData);
            $code = $objData->Code;

            if ($code == "401") {

                return redirect()->route('unauthenticated')->send();
            }

            $rows = json_decode(json_encode($objData->Data), true);

            return $rows;
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function adminevent(Request $request)
    {

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => ElearningEventController => adminevent';
        try {

            $menus = $this->FillMenu();

            $screens = $menus['screens'];
            $modules = $menus['modules'];

            $rows['elearning_noticeboard'] = [];
            // dd($rows);
            $rows = ElearningEventController::adminevent_list($request);
            //dd($rows);
            return view('elearning_events.index', compact('modules', 'screens', 'rows', 'user_id'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    public function event_delete(Request $request)

    {
        try {
            $this->WriteFileLog("fefeef");
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => ElearningEventController => event_delete';

            $user_details = $request->user_details;


            $data['user_id'] = $user_id;
            $data['event_id'] = $request->event_id;
            $data['q'][0]['table'] = 'elearning_events';
            $encryptArray = $data;
            $request = array();
            $request['requestData'] = $encryptArray;
            $this->WriteFileLog($request);

            $gatewayURL = config('setting.api_gateway_url') . '/event/event_delete';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    return redirect(route('elearning.adminevent'))->with('success', 'Events Deleted Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('elearning.adminevent'))->with('fail', 'Events Details Already Exists');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {
            echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }


        //
    }


    public function event_show($id)
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Show') !== false) {
            try {
                $method = 'Method => ElearningEventController => event_show';
                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/event/show' . $this->encryptData($id);
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
                        return view('elearning_events.index', compact('rows', 'modules', 'screens'));
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
    public function event_edit($id)
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Edit') !== false) {
            try {
                $method = 'Method => ElearningEventController => event_edit';
                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/event/edit' . $this->encryptData($id);
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
                        return view('elearning_events.index', compact('rows', 'modules', 'screens'));
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
    public function event_update(Request $request, $id)
    {
        // dd($request);
        try {

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => ElearningEventController => event_update';
            $validator = Validator::make($request->all(), [
                'event_imageedit' => 'required|image|mimes:jpeg,png,jpg,gif',
            ]);

            $data = array();
            $data['user_category'] = $request->user_category;

            $data['event_name'] = $request->event_nameedit;
            $data['event_description'] = $request->event_descriptionedit;
            $data['event_date'] = $request->event_dateedit;


            if (isset($request['event_imageedit'])) {

                if ($validator->fails()) {
                    // Validation failed
                    return redirect()->back()->with('error', 'Files should be image');
                }
                $storagepath_ursb_old = public_path() . '/uploads/notice/' . $user_id; //system_store_pdf
                $storagepath_ursb = '/uploads/notice/' . $user_id; //database_location
                if (!File::exists($storagepath_ursb_old)) {
                    File::makeDirectory($storagepath_ursb_old); //folder_creation_when_folder_doesn't_esist
                }
                $data['event_path'] = $storagepath_ursb;
                $documentsb =  $request['event_imageedit'];
                $files = $documentsb->getClientOriginalName();
                $findspace = array(' ', '&', "'", '"');
                $replacewith = array('-', '-');
                $proposal_files = str_replace($findspace, $replacewith, $files); //proper_file_name-database field
                $documentsb->move($storagepath_ursb_old, $proposal_files); //storing the file in the system

                $data['event_image'] = $proposal_files;
            } else {
                //dd("bjj");
                $data['event_image'] = 0;
                $data['event_path'] = 0;
            }
            $data['eid'] = $request->eid;
            $encryptArray = $data;

            // dd($data);

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/event/update/' . $this->encryptData($id);

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            //dd($response);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                return redirect(route('elearning.adminevent'))->with('success', 'Events Updated Successfully');
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
        $this->WriteFileLog($request);

        try {
            $this->WriteFileLog("feef");
            $method = 'Method => ElearningEventController => fetch';
            // $user_id = $request->session()->get("userID");
            // if ($user_id == null) {
            //     return view('auth.login');
            // }
            $data['id'] = $request->id;
            $this->WriteFileLog($data);
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;


            $gatewayURL = config('setting.api_gateway_url') . '/event/fetch';
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
}
