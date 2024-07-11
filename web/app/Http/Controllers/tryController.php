<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\course;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class tryController extends BaseController
{
    public function admindashboard(Request $request)
    {

        try {
            $method = 'Method => tryController => admindashboard';

            $gatewayURL = config('setting.api_gateway_url') . '/notice/admindashboard';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
            $response = json_decode($response);

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    //dd($parant_data);
                    $rows = $parant_data['rows'];

                    // foreach ($rows as $key => $row) {
                    //     # code...
                    //     $htmlval = $row['notice_description'];
                    //     $dom = new DOMDocument('1.0');
                    //     $style = $dom->createElement('style', $row['notice_description']);
                    //     $row['notice_description'] = $htmlval->render();
                    // }
                    $count = $parant_data['dasboardCount'];
                    $recommended = $parant_data['recomment_courses'];
                    //dd($recommended);

                    // $one_row =  $parant_data['one_rows'];
                    $menus = $this->FillMenu();
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];

                    return view('elearning.admin.admindashboard', compact('rows', 'modules', 'screens', 'count', 'recommended'));
                }
            } else {
                $objData = json_decode($this->decryptData($response->Data));
                return view('errors.errors');
            }
        } catch (\Exception $exc) {
            //dd("bhj");
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function events_fetch(Request $request)
    {

        try {
            $this->WriteFileLog($request);
            $this->WriteFileLog('request');

            $method = 'Method => tryController => events_fetch';
            // $user_id = $request->session()->get("userID");
            // if ($user_id == null) {
            //     return view('auth.login');
            // }
            $data['event_date'] = $request->event_date;
            $this->WriteFileLog($request->event_date);

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;

            //dd( $request);
            $gatewayURL = config('setting.api_gateway_url') . '/admindashboardevents/fetch';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $response1 = json_decode($response);
            $objData = json_decode($this->decryptData($response1->Data));
            $rows = json_decode(json_encode($objData->Data), true);
            $this->WriteFileLog($rows['rows']);
            $this->WriteFileLog('$rows');


            foreach ($rows['rows'] as $key => $row) {
                $filePath = $row['event_path'] . '/' . $row['event_image'];
                // $this->WriteFileLog($filePath);

                $filePath = substr($filePath, 1);
                // $this->WriteFileLog('$rows');
                //     $this->WriteFileLog('uploads/notice/126/Screenshot-(4).png');
                if (file_exists($filePath)) {
                } else {
                    $this->WriteFileLog('$false');
                    $rows['rows'][$key]['event_image'] =  '/empty.jpg';
                }
                //  $this->WriteFileLog("grfdtgh", file_exists(substr($filePath, 1)));
            }
            return $rows;
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    // $menus = $this->FillMenu();
    // // dd($menus);
    // $screens = $menus['screens'];
    // $modules = $menus['modules'];
    // return view('elearning.admin.admindashboard', compact('modules', 'screens'));

    // ******* Course Start */

    public function admincourse(Request $request)
    {
        //dd('iuyiii');
        $method = 'Method => tryController => admincourse';
        $user_id = $request->session()->get("userID");
        try {
            $menus = $this->FillMenu();
            $rows = array();
            $rows['elearning_classes'] = DB::table('elearning_classes')
                ->select('*')
                ->where('elearning_classes.drop_class', '0')
                ->get();

            $rows1 = array();
            $rows1['elearning_courses'] = DB::table('elearning_courses')
                ->select('*')
                ->where('elearning_courses.drop_course', '0')
                ->get();
            $rows1['exam_list'] = DB::table('elearning_exam')
                ->select('*')
                ->where('elearning_exam.active_flag', '0')
                ->get();

            $rows1['quiz_dropdown'] = DB::select('SELECT e.* from elearning_practice_quiz  AS e left join elearning_localadaptation AS l ON e.quiz_id=l.quiz_id left join elearning_ethnictest AS et ON e.quiz_id=et.quiz_id left join elearning_exam AS el ON e.quiz_id=el.quiz_id WHERE l.quiz_id IS NULL AND et.quiz_id IS NULL and el.quiz_id IS NULL AND e.drop_quiz=0');

            $screens = $menus['screens'];
            $modules = $menus['modules'];
            $category = tryController::course_list($request);
            $rows2['course_category'] = $category['rows2']['course_category'];;
            return view('elearning.admin.course.admincourse', compact('modules', 'screens', 'rows', 'user_id', 'rows1', 'rows2'));
        } catch (\Exception $exc) {
            //dd("bhj");
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function admincoursecreate(Request $request)
    {
        $user_id = $request->session()->get("userID");
        $method = 'Method => tryController => admincoursecreate';
        if ($user_id == null) {
            return view('auth.login');
        }
        try {
            $menus = $this->FillMenu();

            $screens = $menus['screens'];
            $modules = $menus['modules'];
            return view('elearning.admin.course.admincoursecreate', compact('modules', 'screens'));
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    // ****** Class Start // 


    public function class_index(Request $request)
    {
        $method = 'Method => tryController => class_index';

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => tryController => classindex_screen';
        try {
            $request =  array();
            $gatewayURL = config('setting.api_gateway_url') . '/class/index';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
            //dd($response);
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

            return view('elearning.admin.course.admincourse', compact('user_id', 'rows', 'menus', 'screens', 'modules'));
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    public function class_delete(Request $request)

    {
        $method = 'Method => tryController => classindex_screen';
        try {
            $this->WriteFileLog("fefeef");
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => tryController => class_delete';
            $user_details = $request->user_details;


            $data['user_id'] = $user_id;
            $data['class_id'] = $request->class_id;
            $data['q'][0]['table'] = 'elearning_classess';
            $encryptArray = $data;
            $request = array();
            $request['requestData'] = $encryptArray;
            $this->WriteFileLog($request);

            $gatewayURL = config('setting.api_gateway_url') . '/class/class_delete';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);

            $objData = json_decode($this->decryptData($response1->Data));
            $rows['data'] = json_decode(json_encode($objData->Data), true);
            $rows['message_cus'] = json_decode(json_encode($objData->response_message), true);
            return $rows;
        } catch (\Exception $exc) {
            //echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }


        //
    }


    public function class_store(Request $request)
    {

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => vbpfeedbackController => class_store';
        try {
            $validator = Validator::make($request->all(), [
                'resource_name' => 'required|file|mimetypes:application/pdf,audio/mpeg,video/mp4',
            ]);
            if ($validator->fails()) {
                // Validation failed
                return redirect()->back()->with('error', 'Files not applicable');
            }

            $data = array();
            $data['class_name'] = $request->class_name;
            $data['class_format'] = $request->class_format;
            $data['class_duration'] = $request->class_duration;
            $data['class_description'] = $request->class_description;
            $data['quiz_id'] = $request->quiz_id;
            $data['class_quiz'] = $request->class_quiz;


            $encryptArray = $data;

            $storagepath_ursb_old = public_path() . '/uploads/class/' . $user_id; //system_store_pdf
            $storagepath_ursb = '/uploads/class/' . $user_id; //database_location
            if (!File::exists($storagepath_ursb_old)) {
                File::makeDirectory($storagepath_ursb_old); //folder_creation_when_folder_doesn't_esist
            }
            $data['resource_path'] = $storagepath_ursb;
            $documentsb =  $request['resource_name'];
            $files = $documentsb->getClientOriginalName();
            $findspace = array(' ', '&', "'", '"');
            $replacewith = array('-', '-');
            $proposal_files = str_replace($findspace, $replacewith, $files); //proper_file_name-database field
            $documentsb->move($storagepath_ursb_old, $proposal_files); //storing the file in the system
            $data['resource_name'] = $proposal_files;

            $encryptArray = $data;
            $request = array();
            $request['requestData'] = $encryptArray;


            $gatewayURL = config('setting.api_gateway_url') . '/elearning/class/store';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $menus = $this->FillMenu();

            $screens = $menus['screens'];
            $modules = $menus['modules'];

            $response1 = json_decode($response);
            // // dd($response1);
            // if ($response1->Status == 200 && $response1->Success) {
            //     $objData = json_decode($this->decryptData($response1->Data));
            // } else {
            //     $objData = json_decode($this->decryptData($response1->Data));
            //     return view('errors.errors');
            //     exit;
            // }
            // $rows = json_decode(json_encode($objData->Data), true);

            // // dd('222');
            // return redirect(route('admincourse'))->with('danger', 'User session Exipired');

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    return redirect(route('admincourse'))->with('success', 'Class Created Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('admincourse'))->with('fail', 'Class Failed');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {
            //echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }



    public function class_show($class_id)
    {
        //dd($class_id);
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Show') !== false) {
            try {
                $method = 'Method => tryController => class_show';
                $class_id = $this->decryptData($class_id);
                $gatewayURL = config('setting.api_gateway_url') . '/elearning/class/class_show/' . $this->encryptData($class_id);
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
                        return view('elearning.admin.course.admincourse', compact('user_id', 'rows', 'menus', 'screens', 'modules'));
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

    public function class_fetch(Request $request)
    {

        $this->WriteFileLog($request);
        try {
            $this->WriteFileLog("feef");
            $method = 'Method => tryController => class_fetch';

            $data['class_id'] = $request->class_id;

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $this->WriteFileLog($data);
            $gatewayURL = config('setting.api_gateway_url') . '/class/class_fetch';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $this->WriteFileLog($response);
            $response1 = json_decode($response);
            $objData = json_decode($this->decryptData($response1->Data));
            $rows = json_decode(json_encode($objData->Data), true);
            return $rows;
        } catch (\Exception $exc) {
            //echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    public function class_edit($class_id)
    {
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Edit') !== false) {
            try {
                $method = 'Method => tryController => edit';
                $class_id = $this->decryptData($class_id);
                $gatewayURL = config('setting.api_gateway_url') . '/class/class_edit' . $this->encryptData($class_id);
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
                        return view('elearning.admincourse', compact('rows', 'modules', 'screens'));
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
    public function class_update(Request $request, $class_id)
    {

        try {

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => tryController => update';
            $validator = Validator::make($request->all(), [
                'resource_nameedit' => 'required|file|mimetypes:application/pdf,audio/mpeg,video/mp4',
            ]);



            $data = array();

            $data['class_name'] = $request->class_nameedit;
            $data['class_description'] = $request->class_descriptionedit;
            $data['resource_name'] = $request->resource_nameedit;
            $data['class_duration'] = $request->class_durationedit;
            $data['class_quiz'] = $request->class_quizedit;
            $data['quiz_id'] = $request->quiz_idedit;

            if (isset($request['resource_nameedit'])) {
                if ($validator->fails()) {
                    // Validation failed
                    return redirect()->back()->with('error', 'Files not applicable');
                }
                $storagepath_ursb_old = public_path() . '/uploads/class/' . $user_id; //system_store_pdf
                $storagepath_ursb = '/uploads/class/' . $user_id; //database_location
                if (!File::exists($storagepath_ursb_old)) {
                    File::makeDirectory($storagepath_ursb_old); //folder_creation_when_folder_doesn't_esist
                }
                $data['resourse_path'] = $storagepath_ursb;
                $documentsb =  $request['resource_nameedit'];
                $files = $documentsb->getClientOriginalName();
                $findspace = array(' ', '&', "'", '"');
                $replacewith = array('-', '-');
                $proposal_files = str_replace($findspace, $replacewith, $files); //proper_file_name-database field
                $documentsb->move($storagepath_ursb_old, $proposal_files); //storing the file in the system
                $data['resource_name'] = $proposal_files;
            } else {
                $data['resource_name'] = 0;
                $data['resourse_path'] = 0;
            }
            $data['eid'] = $request->eid;
            $encryptArray = $data;

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/class/class_update';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            //dd($response);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                return redirect(route('admincourse'))->with('success', 'Class Updated Successfully');
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    // Events Start//

    public function adminevent(Request $request)
    {
        $method = 'Method => tryController => adminevent';
        try {
            $menus = $this->FillMenu();

            $screens = $menus['screens'];
            $modules = $menus['modules'];
            $rows['elearning_events'] = [];
            $rows = tryController::event_list($request);

            return view('elearning.admin.events.adminevent', compact('modules', 'screens', 'rows'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    public function event_store(Request $request)
    {

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => tryController => event_store';
        try {
            $data = array();
            $data['event_name'] = $request->event_name;
            //$data['resource_name'] = $request->resource_name;
            $data['event_date'] = $request->event_date;


            $encryptArray = $data;

            $storagepath_ursb_old = public_path() . '/uploads/events/' . $user_id; //system_store_pdf
            $storagepath_ursb = '/uploads/events/' . $user_id; //database_location
            if (!File::exists($storagepath_ursb_old)) {
                File::makeDirectory($storagepath_ursb_old); //folder_creation_when_folder_doesn't_esist
            }
            $data['event_image'] = $storagepath_ursb;
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


            $gatewayURL = config('setting.api_gateway_url') . '/elearning/event/store';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $menus = $this->FillMenu();

            $screens = $menus['screens'];
            $modules = $menus['modules'];

            $response1 = json_decode($response);
            // dd($response1);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                return view('errors.errors');
                exit;
            }
            $rows = json_decode(json_encode($objData->Data), true);

            // dd('222');
            return redirect(route('adminevent'))->with('danger', 'User session Exipired');
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    public function event_list(Request $request)
    {


        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => tryController => event_list';
        try {
            $request =  array();
            $gatewayURL = config('setting.api_gateway_url') . '/event/event_list';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
            $response = json_decode($response);


            $objData = json_decode($this->decryptData($response->Data));

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


    public function event_delete(Request $request)

    {
        try {
            $this->WriteFileLog("fefeef");
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => tryController => event_delete';
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
                    return redirect(route('adminevent'))->with('success', 'Event Deleted Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('adminevent'))->with('fail', 'Event Details Already Exists');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {
            // echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }


        //
    }

    // Quiz Start

    public function adminquiz(Request $request)
    {
        $method = 'Method => tryController => adminquiz';
        try {
            $menus = $this->FillMenu();

            $screens = $menus['screens'];
            $modules = $menus['modules'];
            $rows['elearning_practice_quiz'] = [];
            $rows = tryController::quiz_list($request);

            return view('elearning.admin.quiz.adminquiz', compact('modules', 'screens', 'rows'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    public function quiz_store(Request $request)
    {

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => tryController => quiz_store';
        try {
            $data = array();
            $data['quiz_name'] = $request->quiz_name;
            $data['quiz_questions'] = $request->quiz_questions;

            $encryptArray = $data;
            $request = array();
            $request['requestData'] = $encryptArray;


            $gatewayURL = config('setting.api_gateway_url') . '/elearning/quiz/store';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $menus = $this->FillMenu();

            $screens = $menus['screens'];
            $modules = $menus['modules'];

            $response1 = json_decode($response);
            // dd($response1);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                return view('errors.errors');
                exit;
            }
            $rows = json_decode(json_encode($objData->Data), true);
            return redirect(route('adminquiz'))->with('danger', 'User session Exipired');
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    public function quiz_list(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => tryController => quiz_list';
        try {
            $request =  array();
            $gatewayURL = config('setting.api_gateway_url') . '/quiz/quiz_list';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
            $response = json_decode($response);


            $objData = json_decode($this->decryptData($response->Data));

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


    //******* Course Start */

    public function course_store(Request $request)
    {
        //dd($request);

        $validator = Validator::make($request->all(), [
            'course_banner' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($validator->fails()) {
            // Validation failed
            return redirect()->back()->with('error', 'Files should be image');
        }

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => tryController => course_store';
        try {
            $data = array();

            $data['course_name'] = $request->course_name;
            $data['course_instructor'] = $request->course_instructor;
            $data['course_start_period'] = $request->course_start_period;

            $data['course_end_period'] = $request->course_end_period;
            $data['course_pay'] = $request->course_pay;
            $data['course_price'] = $request->course_price;
            $data['course_description'] = $request->course_description;
            $data['course_certificate'] = $request->course_certificate;
            $data['course_exam'] = $request->course_exam;
            $data['course_noperiod'] = $request->course_noperiod;

            $data['course_tags'] = $request->course_tags;
            $data['course_skills_required'] = $request->course_skills_required;
            $data['course_gain_skills'] = $request->course_gain_skills;

            $data['course_classes'] = $request->course_classes;
            $data['course_cpt_points'] = $request->course_cpt_points;
            $data['course_category'] = $request->course_category;
            $data['examname'] = $request->exam_name;
            $data['exam_date'] = $request->exam_date;


            $data['pass_percentage'] = $request->pass_percentage;
            //dd($data);

            $encryptArray = $data;
            $storagepath_ursb_old = public_path() . '/uploads/course/' . $user_id; //system_store_pdf
            $storagepath_ursb = '/uploads/course/' . $user_id; //database_location
            if (!File::exists($storagepath_ursb_old)) {
                File::makeDirectory($storagepath_ursb_old); //folder_creation_when_folder_doesn't_esist
            }
            $data['introduction_path'] = $storagepath_ursb;
            $documentsb =  $request['course_introduction'];
            $files = $documentsb->getClientOriginalName();
            $findspace = array(' ', '&', "'", '"');
            $replacewith = array('-', '-');
            $proposal_files = str_replace($findspace, $replacewith, $files); //proper_file_name-database field
            $documentsb->move($storagepath_ursb_old, $proposal_files); //storing the file in the system
            $data['course_introduction'] = $proposal_files;

            $storagepath_ursb_old1 = public_path() . '/uploads/course/' . $user_id; //system_store_pdf
            $storagepath_ursb = '/uploads/course/' . $user_id; //database_location
            if (!File::exists($storagepath_ursb_old1)) {
                File::makeDirectory($storagepath_ursb_old1); //folder_creation_when_folder_doesn't_esist
            }
            $data['banner_path'] = $storagepath_ursb;
            $documentsb =  $request['course_banner'];
            $files = $documentsb->getClientOriginalName();
            $findspace = array(' ', '&', "'", '"');
            $replacewith = array('-', '-');
            $proposal_files = str_replace($findspace, $replacewith, $files); //proper_file_name-database field
            $documentsb->move($storagepath_ursb_old1, $proposal_files); //storing the file in the system
            $data['course_banner'] = $proposal_files;
            //dd($data);

            $encryptArray = $data;
            $request = array();
            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/elearning/course/store';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $menus = $this->FillMenu();

            $screens = $menus['screens'];
            $modules = $menus['modules'];

            $response1 = json_decode($response);
            // dd($response1);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                if ($objData->Code == 200) {

                    return redirect(route('admincourse'))->with('success', 'Course Created Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('admincourse'))->with('fail', 'Course Failed To Create');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                return view('errors.errors');
                exit;
            }
            $rows = json_decode(json_encode($objData->Data), true);

            //dd($response);
            // return redirect(route('admincourse'))->with('danger', 'User session Exipired');
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }



    public function course_list(Request $request)
    {


        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => tryController => course_list';
        try {
            $request =  array();
            $gatewayURL = config('setting.api_gateway_url') . '/course/course_list';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
            $response = json_decode($response);


            $objData = json_decode($this->decryptData($response->Data));

            $code = $objData->Code;

            if ($code == "401") {

                return redirect()->route('unauthenticated')->send();
            }
            $rows2 = json_decode(json_encode($objData->Data), true);



            return $rows2;
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    public function course_delete(Request $request)

    {
        try {
            $this->WriteFileLog("fefeef");
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => tryController => course_delete';
            $user_details = $request->user_details;


            $data['user_id'] = $user_id;
            $data['course_id'] = $request->course_id;
            $data['q'][0]['table'] = 'elearning_courses';
            $encryptArray = $data;
            $request = array();
            $request['requestData'] = $encryptArray;
            $this->WriteFileLog($request);

            $gatewayURL = config('setting.api_gateway_url') . '/course/course_delete';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);

            $objData = json_decode($this->decryptData($response1->Data));
            $rows['data'] = json_decode(json_encode($objData->Data), true);
            $rows['message_cus'] = json_decode(json_encode($objData->response_message), true);
            return $rows;
            // if ($response1->Status == 200 && $response1->Success) {
            //     $objData = json_decode($this->decryptData($response1->Data));


            //     if ($objData->Code == 200) {
            //         return redirect(route('admincourse'))->with('success', 'Course Deleted Successfully');
            //     }

            //     if ($objData->Code == 400) {
            //         return redirect(route('admincourse'))->with('fail', 'Course Details Already Exists');
            //     }
            // } else {
            //     $objData = json_decode($this->decryptData($response1->Data));
            //     return view('errors.errors');
            //     exit;
            // }
        } catch (\Exception $exc) {
            // echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }


        //
    }

    public function course_show($course_id)
    {
        //dd($class_id);
        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Show') !== false) {
            try {
                $method = 'Method => tryController => course_show';
                $course_id = $this->decryptData($course_id);
                $gatewayURL = config('setting.api_gateway_url') . '/elearning/course/course_show/' . $this->encryptData($course_id);
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
                        return view('elearning.admin.course.admincourse', compact('user_id', 'rows', 'menus', 'screens', 'modules'));
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

    public function course_fetch(Request $request)
    {

        $this->WriteFileLog($request);
        try {
            $this->WriteFileLog("feef");
            $method = 'Method => tryController => course_fetch';
            // $user_id = $request->session()->get("userID");
            // if ($user_id == null) {
            //     return view('auth.login');
            // }
            $data['course_id'] = $request->course_id;
            $data['type'] = $request->type;

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;


            $gatewayURL = config('setting.api_gateway_url') . '/elearning/course/course_fetch';
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
    public function course_edit($course_id)
    {

        $permission_data = $this->FillScreensByUser();
        $screen_permission = $permission_data[0];
        if (strpos($screen_permission['permissions'], 'Edit') !== false) {
            try {
                $method = 'Method => tryController => course_edit';
                $course_id = $this->decryptData($course_id);
                $gatewayURL = config('setting.api_gateway_url') . '/elearning/course/course_edit' . $this->encryptData($course_id);
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
                        return view('elearning.admincourse', compact('rows', 'modules', 'screens', 'menus'));
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
    public function  course_update(Request $request, $course_id)
    {

        try {

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $method = 'Method => tryController => course_update';

            $data = array();
            $data['course_category'] = $request->course_categoryedit;
            $data['course_banner'] = $request->course_banneredit;
            $data['course_certificate'] = $request->course_certificateedit;
            $data['course_name'] = $request->course_nameedit;
            $data['course_instructor'] = $request->course_instructoredit;
            $data['course_start_period'] = $request->course_start_periodedit;
            $data['course_end_period'] = $request->course_end_periodedit;
            $data['course_pay'] = $request->course_payedit;
            $data['course_price'] = $request->course_priceedit;
            $data['course_description'] = $request->course_descriptionedit;
            //$data['course_introduction'] = $request->course_introductionedit;
            $data['course_tags'] = $request->course_tagsedit;
            $data['course_skills_required'] = $request->course_skills_requirededit;
            $data['course_gain_skills'] = $request->course_gain_skillsedit;
            $data['course_classes'] = $request->course_classesedit;
            $data['course_cpt_points'] = $request->course_cpt_pointsedit;
            $data['course_edit'] = $request->course_edit;


            $storagepath_ursb_old = public_path() . '/uploads/course/' . $user_id; //system_store_pdf
            $storagepath_ursb = '/uploads/course/' . $user_id; //database_location
            if (!File::exists($storagepath_ursb_old)) {
                File::makeDirectory($storagepath_ursb_old); //folder_creation_when_folder_doesn't_esist
            }
            $data['banner_path'] = $storagepath_ursb;
            $documentsb =  $request['course_banneredit'];
            $files = $documentsb->getClientOriginalName();
            $findspace = array(' ', '&', "'", '"');
            $replacewith = array('-', '-');
            $proposal_files = str_replace($findspace, $replacewith, $files); //proper_file_name-database field
            $documentsb->move($storagepath_ursb_old, $proposal_files); //storing the file in the system
            $data['course_banner'] = $proposal_files;
            $data['course_edit'] = $request->course_edit;
            $encryptArray = $data;

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;

            $storagepath_ursb_old = public_path() . '/uploads/course/' . $user_id; //system_store_pdf
            $storagepath_ursb = '/uploads/course/' . $user_id; //database_location
            if (!File::exists($storagepath_ursb_old)) {
                File::makeDirectory($storagepath_ursb_old); //folder_creation_when_folder_doesn't_esist
            }
            $data['introduction_path'] = $storagepath_ursb;
            $documentsb =  $request['course_introductionedit'];
            $files = $documentsb->getClientOriginalName();
            $findspace = array(' ', '&', "'", '"');
            $replacewith = array('-', '-');
            $proposal_files = str_replace($findspace, $replacewith, $files); //proper_file_name-database field
            $documentsb->move($storagepath_ursb_old, $proposal_files); //storing the file in the system
            $data['course_introduction'] = $proposal_files;


            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;


            $gatewayURL = config('setting.api_gateway_url') . '/elearning/course/course_update';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);


            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                return redirect(route('elearning.admincourse'))->with('success', 'Question  Updated Successfully');
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                echo json_encode($objData->Code);
                exit;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }



    //*********** END */

    public function addclass_index(Request $request)
    {

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => tryController => addclass_index';
        try {
            $request =  array();
            $request['user_id'] = $user_id;

            $gatewayURL = config('setting.api_gateway_url') . '/addclass/classlist';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
            $response = json_decode($response);


            $objData = json_decode($this->decryptData($response->Data));
            $code = $objData->Code;

            if ($code == "401") {

                return redirect(url('/'))->with('danger', 'User session Exipired');
            }

            $rows = json_decode(json_encode($objData->Data), true);

            $gd_status = $rows['data3'][0]['active_flag'];
            $menus = $this->FillMenu();
            if ($menus == "401") {
                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
            $screens = $menus['screens'];
            $modules = $menus['modules'];

            return view('Registration.index', compact('user_id', 'rows', 'menus', 'screens', 'modules', 'gd_status'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }


    // Noticeboard Start //


    public function notice_store(Request $request)
    {

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => tryController => notice_store';
        try {
            $data = array();
            $data['notice_name'] = $request->notice_name;

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

            $menus = $this->FillMenu();

            $screens = $menus['screens'];
            $modules = $menus['modules'];

            $response1 = json_decode($response);
            // dd($response1);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                return view('errors.errors');
                exit;
            }
            $rows = json_decode(json_encode($objData->Data), true);

            // dd('222');
            return redirect(route('adminnoticeboard'))->with('danger', 'User session Exipired');
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function notice_list(Request $request)
    {


        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => tryController => notice_list';
        try {
            $request =  array();
            $gatewayURL = config('setting.api_gateway_url') . '/notice/notice_list';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
            $response = json_decode($response);


            $objData = json_decode($this->decryptData($response->Data));

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
            $method = 'Method => tryController => notice_delete';

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
                    return redirect(route('adminnoticeboard'))->with('success', 'Notice Deleted Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('adminnoticeboard'))->with('fail', 'Notice Details Already Exists');
                }
            } else {
                $objData = json_decode($this->decryptData($response1->Data));
                return view('errors.errors');
                exit;
            }
        } catch (\Exception $exc) {
            // echo $exc;
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }


        //
    }

    public function coursepreview(Request $request)
    {


        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => tryController => coursepreview';
        try {
            $request =  array();
            $gatewayURL = config('setting.api_gateway_url') . '/coursepreview/coursepreview_list';
            $response = $this->serviceRequest($gatewayURL, 'GET',  json_encode($request), $method);
            $response = json_decode($response);


            $objData = json_decode($this->decryptData($response->Data));

            $code = $objData->Code;

            if ($code == "401") {

                return redirect()->route('unauthenticated')->send();
            }
            $rows = json_decode(json_encode($objData->Data), true);

            // return $rows;
            $menus = $this->FillMenu();

            $screens = $menus['screens'];
            $modules = $menus['modules'];
            return view('elearning.admin.coursepreview.coursepreview', compact('menus', 'modules', 'screens', 'rows'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    // public function coursepreview(Request $request)
    // {
    //     $user_id = $request->session()->get("userID");
    //     if ($user_id == null) {
    //         return view('auth.login');
    //     }
    //     $menus = $this->FillMenu();

    //     $screens = $menus['screens'];
    //     $modules = $menus['modules'];
    //     return view('elearning.admin.coursepreview.coursepreview', compact('modules', 'screens'));


    // }


    public function admineventcreate(Request $request)
    {
        $method = 'Method => tryController => admineventcreate';
        try {
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $menus = $this->FillMenu();

            $screens = $menus['screens'];
            $modules = $menus['modules'];
            return view('elearning.admin.events.admineventcreate', compact('modules', 'screens'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }

        //
    }

    // all course //


    public function allCourses(Request $request)
    {
        // Authentication
        $method = 'Method => tryController => allCourses';
        try {

            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return redirect(url('/'));
            }

            // Sort and Filter Checking and Assignment
            if (!isset($_GET['sorted']) || !isset($_GET['tag']) || !isset($_GET['progress']) || !isset($_GET['q'])) {
                return view('elearning.dashboard');
            } else {
                $sort = $_GET['sorted'];
                $tagFilter = $_GET['tag'];
                $progressFilter = $_GET['progress'];
                $search = $_GET['q'];
            }
            $searched = false;
            $sorted = "Recently Added";
            // Getting Non-Destroyed Courses
            $Courses = DB::select("SELECT * FROM elearning_courses WHERE drop_course=0");

            // Getting Currently Available Courses
            $availableCourseIds = [];
            $time = time();
            $currentTime = date("Y-m-d H:i:s", $time);
            foreach ($Courses as $course) {
                if ($course->course_start_period == "" || $course->course_end_period == "") {
                    array_splice($availableCourseIds, 1, 0, $course->course_id);
                } else {
                    $courseStartPeriod = date("Y-m-d H:i:s", strtotime($course->course_start_period));
                    $courseEndPeriod = date("Y-m-d H:i:s", strtotime($course->course_end_period));
                    if ($currentTime >= $courseStartPeriod && $currentTime <= $courseEndPeriod) {
                        array_splice($availableCourseIds, 1, 0, $course->course_id);
                    }
                }
            }

            // Getting Currently Available Tags
            $tags1 = [];
            // getting tag column values into an array;
            foreach ($Courses as $course) {
                array_splice($tags1, 1, 0, $course->course_tags);
            }
            // converting array to string to avoid two tags in single array index
            $tags2 = implode(", ", $tags1);
            // converting back to array with single values and without duplications
            $tags3 = array_unique(explode(", ", $tags2));
            // sorting array indices properly
            $availableTags = array_values($tags3);
            // dd($search);
            // Search
            if ($search == "false") {
                $availableCourses = course::whereIn('course_id', $availableCourseIds)->paginate(8);
                $searched = false;
            } else {
                $availableCourses = course::whereIn('course_id', $availableCourseIds)
                    ->where('course_name', 'LIKE', "%{$search}%")
                    ->orwhere('course_instructor', 'LIKE', "%{$search}%")
                    ->orwhere('course_tags', 'LIKE', "%{$search}%")
                    ->paginate(8);
                $searched = true;
            }

            //Sort and filter
            if ($sort == "A to Z" && $searched == true && $tagFilter == "false") {
                $availableCourses = course::whereIn('course_id', $availableCourseIds)
                    ->where('course_name', 'LIKE', "%{$search}%")
                    ->orwhere('course_instructor', 'LIKE', "%{$search}%")
                    ->orwhere('course_tags', 'LIKE', "%{$search}%")
                    ->orderBy("course_name")
                    ->paginate(8);
                $sorted = "A to Z";
            } elseif ($sort == "A to Z" && $searched == false && $tagFilter == "false") {
                $availableCourses = course::whereIn('course_id', $availableCourseIds)
                    ->orderBy("course_name")
                    ->paginate(8);
                $sorted = "A to Z";
            }
            if ($sort == "Z to A" && $searched == true && $tagFilter == "false") {
                $availableCourses = course::whereIn('course_id', $availableCourseIds)
                    ->where('course_name', 'LIKE', "%{$search}%")
                    ->orwhere('course_instructor', 'LIKE', "%{$search}%")
                    ->orwhere('course_tags', 'LIKE', "%{$search}%")
                    ->orderBy("course_name", "desc")
                    ->paginate(8);
                $sorted = "Z to A";
            } elseif ($sort == "Z to A" && $searched == false && $tagFilter == "false") {
                $availableCourses = course::whereIn('course_id', $availableCourseIds)
                    ->orderBy("course_name", "desc")
                    ->paginate(8);
                $sorted = "Z to A";
            }
            if ($sort == "Recently Added" && $searched == true && $tagFilter == "false") {
                $availableCourses = course::whereIn('course_id', $availableCourseIds)
                    ->where('course_name', 'LIKE', "%{$search}%")
                    ->orwhere('course_instructor', 'LIKE', "%{$search}%")
                    ->orwhere('course_tags', 'LIKE', "%{$search}%")
                    ->paginate(8);
                $sorted = "Recently Added";
            } elseif ($sort == "Recently Added" && $searched == false && $tagFilter == "false") {
                $availableCourses = course::whereIn('course_id', $availableCourseIds)->paginate(8);
                $sorted = "Recently Added";
            }
            // Recently Enrolled Sorting is pending


            if ($sort == "A to Z" && $searched == true && $tagFilter != "false") {
                $availableCourses = course::whereIn('course_id', $availableCourseIds)
                    ->where('course_tags', 'LIKE', "%{$tagFilter}%")
                    ->where('course_name', 'LIKE', "%{$search}%")
                    ->orwhere('course_instructor', 'LIKE', "%{$search}%")
                    ->orwhere('course_tags', 'LIKE', "%{$search}%")
                    ->orderBy("course_name")
                    ->paginate(8);
                $sorted = "A to Z";
            } elseif ($sort == "Z to A" && $searched == true && $tagFilter != "false") {
                $availableCourses = course::whereIn('course_id', $availableCourseIds)
                    ->where('course_tags', 'LIKE', "%{$tagFilter}%")
                    ->where('course_name', 'LIKE', "%{$search}%")
                    ->orwhere('course_instructor', 'LIKE', "%{$search}%")
                    ->orwhere('course_tags', 'LIKE', "%{$search}%")
                    ->orderBy("course_name", "desc")
                    ->paginate(8);
                $sorted = "Z to A";
            } elseif ($sort == "Recently Added" && $searched == true && $tagFilter != "false") {
                $availableCourses = course::whereIn('course_id', $availableCourseIds)
                    ->where('course_tags', 'LIKE', "%{$tagFilter}%")
                    ->where('course_name', 'LIKE', "%{$search}%")
                    ->orwhere('course_instructor', 'LIKE', "%{$search}%")
                    ->orwhere('course_tags', 'LIKE', "%{$search}%")
                    ->paginate(8);
                $sorted = "Recently Added";
            } elseif ($sort == "A to Z" && $searched == false && $tagFilter != "false") {
                $availableCourses = course::whereIn('course_id', $availableCourseIds)
                    ->where('course_tags', 'LIKE', "%{$tagFilter}%")
                    ->orderBy("course_name")
                    ->paginate(8);
                $sorted = "A to Z";
            } elseif ($sort == "Z to A" && $searched == false && $tagFilter != "false") {
                $availableCourses = course::whereIn('course_id', $availableCourseIds)
                    ->where('course_tags', 'LIKE', "%{$tagFilter}%")
                    ->orderBy("course_name", "desc")
                    ->paginate(8);
                $sorted = "Z to A";
            } elseif ($sort == "Recently Added" && $searched == false && $tagFilter != "false") {
                $availableCourses = course::whereIn('course_id', $availableCourseIds)
                    ->where('course_tags', 'LIKE', "%{$tagFilter}%")
                    ->paginate(8);
                $sorted = "Recently Added";
            }
            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];


            return view('elearning.allCourses', compact('availableCourses', 'availableTags', 'search', 'sort', 'tagFilter', 'progressFilter', 'modules', 'screens', 'menus'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function adminnoticeboard(Request $request)
    {
        $method = 'Method => tryController => adminnoticeboard';
        try {
            $menus = $this->FillMenu();

            $screens = $menus['screens'];
            $modules = $menus['modules'];

            $rows['elearning_noticeboard'] = [];
            $rows = tryController::notice_list($request);

            return view('elearning.admin.noticeboard.adminnoticeboard', compact('modules', 'screens', 'rows'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function ethnic()
    {
        $method = 'Method => tryController => ethnic';
        try {
            return view('elearning.ethnictest');
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function adminnoticeboardcreate(Request $request)
    {
        $method = 'Method => tryController => adminnoticeboardcreate';
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        try {
            $menus = $this->FillMenu();

            $screens = $menus['screens'];
            $modules = $menus['modules'];
            return view('elearning.admin.noticeboard.adminnoticeboardcreate', compact('modules', 'screens'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }

        //
    }
}
