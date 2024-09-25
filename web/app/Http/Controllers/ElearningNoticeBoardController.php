<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class ElearningNoticeBoardController extends BaseController
{
    // Noticeboard Start //


    public function notice_store(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'notice_banner' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($validator->fails()) {
            // Validation failed
            return redirect()->back()->with('error', 'Files should be image');
        }

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => ElearningNoticeBoardController => notice_store';
        try {
            $data = array();
            $data['user_category'] = $request->user_category;
            $data['notice_name'] = $request->notice_name;
            $data['notice_description'] = $request->notice_description;
            $data['notice_author'] = $request->notice_author;
            $data['notice_date'] = $request->notice_date;

           
            $encryptArray = $data;

            $storagepath_ursb_old = public_path() . '/uploads/notice/' . $user_id; //system_store_pdf
            $storagepath_ursb = '/uploads/notice/' . $user_id; //database_location
            if (!File::exists($storagepath_ursb_old)) {
                File::makeDirectory($storagepath_ursb_old); //folder_creation_when_folder_doesn't_esist
            }
            $data['notice_path'] = $storagepath_ursb;
            
            $documentsb =  $request['notice_banner'];
            $files = $documentsb->getClientOriginalName();
            $findspace = array(' ', '&', "'", '"');
            $replacewith = array('-', '-');
            $proposal_files = str_replace($findspace, $replacewith, $files); //proper_file_name-database field
            $documentsb->move($storagepath_ursb_old, $proposal_files); //storing the file in the system
            $data['notice_banner'] = $proposal_files;

            $encryptArray = $data;
            $request = array();
            $request['requestData'] = $encryptArray;



            $gatewayURL = config('setting.api_gateway_url') . '/elearning/notice/notice_store';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {

                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {

                    return redirect(route('elearning.adminnoticeboard'))->with('success', 'Notice Board Created Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('elearning.adminnoticeboard'))->with('fail', 'Notice Board Failed To Create');
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

    public function notice_list(Request $request)
    {

        // dd($request);
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => ElearningNoticeBoardController => notice_list';
        try {
            $request =  array();
            $request['mlhud_id'] = $user_id;
            $gatewayURL = config('setting.api_gateway_url') . '/notice/notice_list';
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


    public function notice_delete(Request $request)

    {
        try {
            $this->WriteFileLog("fefeef");
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => ElearningNoticeBoardController => notice_delete';
            $user_details = $request->user_details;


            $data['user_id'] = $user_id;
            $data['notice_id'] = $request->notice_id;
            $data['q'][0]['table'] = 'elearning_noticeboard';
            $encryptArray = $data;
            $request = array();
            $request['requestData'] = $encryptArray;
            $this->WriteFileLog($request);

            $gatewayURL = config('setting.api_gateway_url') . '/notice/notice_delete';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    return redirect(route('elearning.adminnoticeboard'))->with('success', 'Notice Deleted Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('elearning.adminnoticeboard'))->with('fail', 'Notice Details Already Exists');
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

    public function adminnoticeboard(Request $request)
    {
        $method = 'Method => ElearningNoticeBoardController => adminnoticeboard';
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        try {

            $menus = $this->FillMenu();

            $screens = $menus['screens'];
            $modules = $menus['modules'];

            $rows['elearning_noticeboard'] = [];
            // dd($rows);
            $rows = ElearningNoticeBoardController::notice_list($request);
            //dd($rows);
            return view('elearning_noticeboard.index', compact('modules', 'screens', 'rows', 'user_id'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function notice_show($id)
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Show') !== false) {
            try {
                $method = 'Method => ElearningNoticeBoardController => notice_show';
                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/notice/notice_show' . $this->encryptData($id);
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
                        return view('elearning_noticeboard.index', compact('rows', 'modules', 'screens'));
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
    public function notice_edit($id)
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Edit') !== false) {
            try {
                $method = 'Method => ElearningNoticeBoardController => edit';
                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/notice/notice_edit' . $this->encryptData($id);
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
                        return view('elearning_noticeboard.index', compact('rows', 'modules', 'screens'));
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
    public function notice_update(Request $request, $id)
    {

        try {

            $validator = Validator::make($request->all(), [
                'notice_banneredit' => 'required|image|mimes:jpeg,png,jpg,gif',
            ]);


            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => ElearningNoticeBoardController => update';

            $data = array();
            $data['user_category'] = $request->user_category;
            $data['notice_name'] = $request->notice_nameedit;
            $data['notice_description'] = $request->notice_descriptionedit;

            $data['notice_author'] = $request->notice_authoredit;
            $data['notice_date'] = $request->notice_dateedit;

            if (isset($request['notice_banneredit'])) {
                if ($validator->fails()) {
                    // Validation failed
                    return redirect()->back()->with('error', 'Files should be image');
                }
                $storagepath_ursb_old = public_path() . '/uploads/notice/' . $user_id; //system_store_pdf
                $storagepath_ursb = '/uploads/notice/' . $user_id; //database_location
                if (!File::exists($storagepath_ursb_old)) {
                    File::makeDirectory($storagepath_ursb_old); //folder_creation_when_folder_doesn't_esist
                }
                $data['notice_path'] = $storagepath_ursb;
                $documentsb =  $request['notice_banneredit'];
                $files = $documentsb->getClientOriginalName();
                $findspace = array(' ', '&', "'", '"');
                $replacewith = array('-', '-');
                $proposal_files = str_replace($findspace, $replacewith, $files); //proper_file_name-database field
                $documentsb->move($storagepath_ursb_old, $proposal_files); //storing the file in the system
                $data['notice_banner'] = $proposal_files;
            } else {
                //dd("bjj");
                $data['notice_banner'] = 0;
                $data['notice_path'] = 0;
            }
            $data['eid'] = $request->eid;
            $encryptArray = $data;

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/notice/notice_update';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            //dd($response);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                return redirect(route('elearning.adminnoticeboard'))->with('success', 'Notice Board Updated Successfully');
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
            $method = 'Method => ElearningNoticeBoardController => fetch';
            // $user_id = $request->session()->get("userID");
            // if ($user_id == null) {
            //     return view('auth.login');
            // }
            $data['id'] = $request->id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;


            $gatewayURL = config('setting.api_gateway_url') . '/notice/notice_fetch';
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
