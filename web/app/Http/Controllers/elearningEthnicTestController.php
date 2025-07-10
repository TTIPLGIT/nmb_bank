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
use App\Models\coursepagination;
use Illuminate\Support\Facades\Crypt;
use DateTime;
use PDF;



class elearningEthnicTestController extends BaseController
{
    public function index(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => elearningEthnicTestController => index';
        try {
            $request = array();
            $request['mlhud_id'] = $user_id;
            $gatewayURL = config('setting.api_gateway_url') . '/ethictest';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
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
            return view('elearningethnictest.index', compact('user_id', 'rows', 'menus', 'screens', 'modules'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id) {}

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
        $method = 'Method => elearningEthnicTestController => store';
        try {
            $data = array();
            $data['user_category'] = $request->user_category;
            $data['ethnictest_name'] = $request->ethnictest_name;
            $data['quiz_id'] = $request->quiz_id;
            $data['pass_percentage'] = $request->pass_percentage;


            $encryptArray = $this->encryptData($data);
            $request = array();

            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/ethictest/store';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    return redirect(route('ethictest.index'))->with('success', 'Ethic Test Created Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('ethictest.index'))->with('fail', 'Ethic Test Failed');
                }
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        // else {
        //     $objData = json_decode($this->decryptData($response1->Data));
        //     return view('errors.errors');
        //     exit;
        // }
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
                $method = 'Method => elearningEthnicTestController => show';
                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/ethictest/show' . $this->encryptData($id);
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
                $response = json_decode($response);
                if ($response->Status == 200 && $response->Success) {
                    $objData = json_decode($this->decryptData($response->Data));
                    if ($objData->Code == 200) {
                        $parant_data = json_decode(json_encode($objData->Data), true);
                        $rows = $parant_data['rows'];
                        // $one_row =  $parant_data['one_rows'];
                        $menus = $this->FillMenu();
                        $screens = $menus['screens'];
                        $modules = $menus['modules'];
                        return view('elearningethnictest.index', compact('rows', 'modules', 'screens'));
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
                $method = 'Method => elearningEthnicTestController => edit';
                $id = $this->decryptData($id);
                $gatewayURL = config('setting.api_gateway_url') . '/ethictest/edit' . $this->encryptData($id);
                $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
                $response = json_decode($response);
                if ($response->Status == 200 && $response->Success) {
                    $objData = json_decode($this->decryptData($response->Data));
                    if ($objData->Code == 200) {
                        $parant_data = json_decode(json_encode($objData->Data), true);
                        $rows = $parant_data['rows'];
                        // $one_row =  $parant_data['one_rows'];
                        $menus = $this->FillMenu();
                        $screens = $menus['screens'];
                        $modules = $menus['modules'];
                        return view('elearningethnictest.index', compact('rows', 'modules', 'screens'));
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
            $method = 'Method => elearningEthnicTestController => update';

            $data = array();
            $data['user_category'] = $request->user_category;
            $data['ethnictest_name'] = $request->ethnictest_name;
            $data['quiz_id'] = $request->quiz_id;
            $data['pass_percentage'] = $request->pass_percentage;
            $data['eid'] = $request->eid;
            //dd($data);
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/ethictest/update';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            //dd($response);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                return redirect(route('ethictest.index'))->with('success', 'Ethic Test Updated Successfully');
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
            $method = 'Method => elearningEthnicTestController => fetch';
            // $user_id = $request->session()->get("userID");
            // if ($user_id == null) {
            //     return view('auth.login');
            // }
            $data['id'] = $request->id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;


            $gatewayURL = config('setting.api_gateway_url') . '/ethic/fetch';
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */




    public function ethnic_delete(Request $request)
    {
        try {
            $this->WriteFileLog($request);
            $method = 'Method => elearningEthnicTestController => fetch';
            // $user_id = $request->session()->get("userID");
            // if ($user_id == null) {
            //     return view('auth.login');
            // }
            $data['id'] = $request->id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/ethictest/delete';
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
    public function list(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => elearningEthnicTestController => list';
        // $request =  array();
        // $request['mlhud_id'] = $user_id;
        try {
            $gatewayURL = config('setting.api_gateway_url') . '/ethic/quiz/list';
            $response = $this->serviceRequest($gatewayURL, 'GET', "", $method);
            $response = json_decode($response);
            $objData = json_decode($this->decryptData($response->Data));
            $code = $objData->Code;

            if ($code == "401") {

                return redirect()->route('unauthenticated')->send();
            }
            $rows = json_decode(json_encode($objData->Data), true);
            // dd($rows);

            if ($rows == 0) {
                return redirect()->back()->with('error', 'No Ethic Test Available Please Come Back Later');
            }
            $menus = $this->FillMenu();

            if ($menus == "401") {
                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
            $screens = $menus['screens'];
            $modules = $menus['modules'];

            return view('elearningethnictest.userindex', compact('rows', 'menus', 'screens', 'modules'));
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
            $method = 'Method => elearningEthnicTestController => quiz';
            $request = array();
            $request['mlhud_id'] = $user_id;
            $gatewayURL = config('setting.api_gateway_url') . '/ethic/quiz';
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
            $role = "42";

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
            return view('elearningethnictest.userview', compact('quizId', 'role', 'quizName', 'questionDetails', 'qIds', 'user_id', 'menus', 'screens', 'modules'));

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
        $method = 'Method => elearningEthnicTestController => store';
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

            $gatewayURL = config('setting.api_gateway_url') . '/ethic/quiz/store';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    return redirect(route('ethictest.list'))->with('success', 'Thankyou for Attending the Ethic Test');
                }

                if ($objData->Code == 400) {
                    return redirect(route('ethictest.list'))->with('fail', 'Ethic Test Failed');
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
    public function allCourses(Request $request)
    {
        // Authentication

        $method = 'Method => elearningEthnicTestController => allCourses';


        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return redirect(url('/'));
        }
        try {
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

            // $Courses = DB::select("
            //             SELECT elearning_courses.* 
            //                         FROM elearning_courses 
            //                         INNER JOIN users ON users.id = elearning_courses.user_ids
            //                         INNER JOIN uam_roles ON uam_roles.role_id = users.role_id
            //                         INNER JOIN designation ON designation.designation_id = users.designation_id
            //                         WHERE elearning_courses.drop_course = 0 
            //                         AND uam_roles.role_id = elearning_courses.role_id
            //                         AND designation.designation_id = elearning_courses.designation_id
            //         ");


           


           
            $Courses = DB::table('elearning_courses')
                ->where('drop_course', 0)
                ->whereRaw("FIND_IN_SET(?, user_ids)", [$user_id ])
                ->get();


            // $Courses = DB::select("SELECT * FROM elearning_courses WHERE drop_course=0");


            // dd($Courses);

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
                $availableCourses = course::whereIn('course_id', $availableCourseIds)
                    ->orderBy('course_id', 'desc')
                    ->paginate(8);

                $sorted = "Recently Added";
            }
            if ($sort == "Recently Enrolled" && $searched == true && $tagFilter == "false") {
                // $availableCourses = course::whereIn('course_id', $availableCourseIds)
                //     ->where('course_name', 'LIKE', "%{$search}%")
                //     ->orwhere('course_instructor', 'LIKE', "%{$search}%")
                //     ->orwhere('course_tags', 'LIKE', "%{$search}%")
                //     ->paginate(8);
                $availableCourses = DB::table('user_course_relation as uc')
                    ->select('*')
                    ->join('elearning_courses as c', 'uc.course_id', '=', 'c.course_id')
                    ->where('uc.course_status', 'Enrolled')
                    ->where('c.drop_course', 0)
                    ->where('c.course_name', 'LIKE', "%{$search}%")
                    ->orwhere('c.course_instructor', 'LIKE', "%{$search}%")
                    ->orwhere('c.course_tags', 'LIKE', "%{$search}%")
                    ->paginate(8);
                $sorted = "Recently Enrolled";
            } elseif ($sort == "Recently Enrolled" && $searched == false && $tagFilter == "false") {
                // $availableCourses = course::whereIn('course_id', $availableCourseIds)
                //     ->orderBy('course_id', 'desc')
                //     ->paginate(8);
                $availableCourses = DB::table('user_course_relation as uc')
                    ->select('*')
                    ->join('elearning_courses as c', 'uc.course_id', '=', 'c.course_id')
                    ->where('uc.course_status', 'Enrolled')
                    ->where('c.drop_course', 0)
                    ->where('c.course_name', 'LIKE', "%{$search}%")
                    ->orwhere('c.course_instructor', 'LIKE', "%{$search}%")
                    ->orwhere('c.course_tags', 'LIKE', "%{$search}%")
                    ->orderBy('uc.course_id', 'desc')
                    ->paginate(8);
                $sorted = "Recently Enrolled";
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
                    ->orderBy('course_id', 'desc')
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
                // dd('ef');
                $availableCourses = course::whereIn('course_id', $availableCourseIds)
                    ->where('course_tags', 'LIKE', "%{$tagFilter}%")
                    ->orderBy('course_id', 'desc')
                    ->paginate(8);
                $sorted = "Recently Added";
            }

            if ($sort == "Recently Added" && $progressFilter == "Completed" && $searched == false && $tagFilter == "false") {
                $availableCourses = DB::table('user_course_relation as uc')
                    ->select('*')
                    ->join('elearning_courses as c', 'uc.course_id', '=', 'c.course_id')
                    ->where('uc.course_status', 'Completed')
                    ->where('c.drop_course', 0)
                    ->orderBy('uc.course_id', 'desc')
                    ->paginate(8);
                $progressFilter = "Completed";
            } else if ($sort == "Recently Added" && $progressFilter == "Completed" && $searched != false && $tagFilter == "false") {
                $availableCourses = DB::table('user_course_relation as uc')
                    ->select('*')
                    ->join('elearning_courses as c', 'uc.course_id', '=', 'c.course_id')
                    ->where('uc.course_status', 'Completed')
                    ->where('c.drop_course', 0)
                    ->where(function ($query) use ($search, $tagFilter) {
                        $query->where('c.course_name', 'LIKE', "%{$search}%")
                            ->orWhere('course_tags', 'LIKE', "%{$tagFilter}%")
                            ->orWhere('c.course_instructor', 'LIKE', "%{$search}%")
                            ->orWhere('c.course_tags', 'LIKE', "%{$search}%");
                    })
                    ->orderBy('uc.course_id', 'desc')
                    ->paginate(8);
                $progressFilter = "Completed";
            } else if ($sort == "Recently Added" && $progressFilter == "In Progress" && $searched == false && $tagFilter != "false") {

                $availableCourses = DB::table('user_class_relation as uc')
                    ->select('*')
                    ->join('elearning_courses as c', 'uc.course_id', '=', 'c.course_id')
                    ->where('uc.course_status', 'Enrolled')
                    ->where('c.drop_course', 0)
                    ->where(function ($query) use ($search, $tagFilter) {
                        $query->where('c.course_name', 'LIKE', "%{$search}%")
                            ->orWhere('course_tags', 'LIKE', "%{$tagFilter}%")
                            ->orWhere('c.course_instructor', 'LIKE', "%{$search}%")
                            ->orWhere('c.course_tags', 'LIKE', "%{$search}%");
                    })
                    ->orderBy('uc.course_id', 'desc')
                    ->paginate(8);
                $progressFilter = "Completed";
            }

            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            // Instantiate the Course model

            // Call the getCourseprogressbar() method
            $courseProgress = course::getCourseprogressbar($user_id);
            $wishlistedCourseIds = DB::table('elearning_wishlist')
                ->where('active_flag', 0)
                ->where('user_id', $user_id)
                ->pluck('course_id')
                ->toArray();

            return view('elearning.allCourses', compact('Courses', 'availableCourses', 'availableTags', 'search', 'sort', 'tagFilter', 'progressFilter', 'modules', 'screens', 'menus', 'courseProgress', 'wishlistedCourseIds'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function wishlist(Request $request)
    {

        $method = 'Method => elearningEthnicTestController => wishlist';
        try {
            $user_id = $request->session()->get("userID");
            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            //$id = '15';
            $wishlistCourses = DB::select("SELECT * FROM elearning_wishlist as ew inner join elearning_courses as ec on ec.course_id = ew.course_id where ew.active_flag=0");
            //dd($wishlistCourses);
            // $wishlistCourses = course::paginate(4);


            $perPage = 8;

            $wishlistCourses = DB::table('elearning_wishlist')

                ->join('elearning_courses', 'elearning_wishlist.course_id', '=', 'elearning_courses.course_id')
                ->where('elearning_wishlist.active_flag', 0)
                ->where('elearning_wishlist.user_id', $user_id)
                ->select(
                    'elearning_wishlist.course_id',
                    'elearning_courses.course_name',
                    'elearning_courses.course_banner',
                    'elearning_courses.course_instructor',
                    'elearning_courses.course_price',
                    'elearning_courses.course_pay',
                    'elearning_courses.course_classes'
                )

                ->paginate($perPage);
            foreach ($wishlistCourses as $key => $value) {
                # code...
                $courseId = $value->course_id;
                $wishlistCourses[$key]->ratings = DB::select("Select * from elearning_ratings where course_id= $courseId");
                $total_starcount = DB::Select("SELECT COUNT(*) as star_count FROM elearning_ratings where course_id=$courseId");
                if ($total_starcount[0]->star_count > 0) {
                    $total_star = DB::select("SELECT SUM(rating_point) AS sum_rating FROM elearning_ratings WHERE course_id = $courseId");
                    $wishlistCourses[$key]->average_rating = number_format(floatval($total_star[0]->sum_rating / $total_starcount[0]->star_count), 1);
                } else {
                    $wishlistCourses[$key]->average_rating = 0;
                }
            }
            // $courseId = $wishlistCourses[0]->course_id;

            // $ratings = DB::select("SELECT r.*,u.name from elearning_ratings as r inner join users as u on u.id=r.user_id where r.course_id=$courseId");

            // $total_starcount = DB::Select("SELECT COUNT(*) as star_count FROM elearning_ratings where course_id=$courseId");

            // if ($total_starcount[0]->star_count > 0) {
            //     $total_star = DB::select("SELECT SUM(rating_point) AS sum_rating FROM elearning_ratings WHERE course_id = $courseId");
            //     $average_ratting['total_countstar'] = number_format(floatval($total_star[0]->sum_rating / $total_starcount[0]->star_count), 1);
            // } else {
            //     $average_ratting['total_countstar'] = 0;
            // }

            return view('elearning.wishlist', compact('modules', 'screens', 'menus', 'wishlistCourses'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


    public function cart_index(Request $request, $id)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => elearningEthnicTestController => cart_index';
        try {
            $request = array();
            $request['mlhud_id'] = $user_id;
            $request['id'] = $id;
            // $id = $this->decryptData($id);
            $gatewayURL = config('setting.api_gateway_url') . '/elearningCart';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
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

            return view('elearning.cart', compact('user_id', 'rows', 'menus', 'screens', 'modules'));
        } catch (\Exception $exc) {

            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function cart_store(Request $request)
    {

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => elearningEthnicTestController => cart_store';
        try {
            $data = array();
            $data['course_id'] = $request->course_id;
            $data['user_id'] = $user_id;
            $encryptArray = $this->encryptData($data);
            $request = array();

            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/elearningCart/store';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    return redirect(route('elearningCart'))->with('success', 'Cart Added Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('elearningCart'))->with('fail', 'Cart Not Added');
                }
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        // else {
        //     $objData = json_decode($this->decryptData($response1->Data));
        //     return view('errors.errors');
        //     exit;
        // }
    }


    public function courseOverview(Request $request, $id)
    {
        
        $method = 'Method => elearningEthnicTestController => courseOverview';
        try {
            $user_id = $request->session()->get("userID");
            $this->WriteFileLog($user_id);
            if ($user_id == null) {
                return redirect(url('/'));
            }
            $id = Crypt::decrypt($id);
            $this->WriteFileLog($id);
            $courseDetails = DB::select("SELECT * FROM elearning_courses WHERE drop_course=0 AND course_id=$id");
            $courseDetailslist = DB::select("SELECT * FROM elearning_courses WHERE drop_course=0 AND course_id=$id");

            foreach ($courseDetails as $courseDetail) {
                $classOrder = $courseDetail->course_classes;
            }
            $this->WriteFileLog($courseDetails);
            $isEnrolled = DB::select("SELECT * FROM user_class_relation WHERE user_id=$user_id AND class_id=$id");
            if (empty($isEnrolled)) {
                $enrolled = "False";
                $this->WriteFileLog($enrolled);
            } else {
                $enrolled = "True";
                $this->WriteFileLog($enrolled);
            }
            $this->WriteFileLog("1");

            $isEnrolled = DB::select("SELECT * FROM user_course_relation WHERE user_id=$user_id AND course_id=$id");
            // dd( $isEnrolled);
            $this->WriteFileLog($isEnrolled);


            if (empty($isEnrolled)) {

                $enrolled = "False";
                $this->WriteFileLog($enrolled);
            } else {
                $enrolled = "True";
                $this->WriteFileLog($enrolled);
            }


            $courseresorces = DB::select("SELECT ecl.* FROM elearning_classes as ecl inner join elearning_courses as ec on ec.course_classes = ecl.class_id WHERE ec.drop_course=0 AND ec.course_id=$id");
            $this->WriteFileLog($courseresorces);

            $class_array = explode(',', $courseDetails[0]->course_classes);

            $this->WriteFileLog("2");

            $valueToCount = 'value_to_count';

            $counts = count($class_array);

            $audio_exist = 0;
            $video_exist = 0;
            $pdf_exist = 0;
            $img_exist = 0;
            foreach ($class_array as $key => $row) {

                $class_details = DB::select("SELECT * FROM elearning_classes where class_id = $row");

                if (isset($class_details[0]->class_format) && $class_details[0]->class_format == 'mp3') {
                    $audio_exist = 1;
                }
                if (isset($class_details[0]->class_format) && $class_details[0]->class_format == 'mp4') {
                    $video_exist = 1;
                }
                if (isset($class_details[0]->class_format) && $class_details[0]->class_format == 'pdf') {
                    $pdf_exist = 1;
                } else {
                    $img_exist = 1;
                }
                # code...
            }


            $courseContents = DB::select("SELECT * FROM elearning_classes WHERE drop_class=0  ORDER BY FIELD(class_id,$classOrder)");
            $this->WriteFileLog("3");
            $ratings = DB::select("SELECT r.*,u.name from elearning_ratings as r inner join users as u on u.id=r.user_id where r.course_id=$id");

            $total_starcount = DB::Select("SELECT COUNT(*) as star_count FROM elearning_ratings where course_id=$id");

            if ($total_starcount[0]->star_count > 0) {
                $total_star = DB::select("SELECT SUM(rating_point) AS sum_rating FROM elearning_ratings WHERE course_id = $id");
                $average_ratting['total_countstar'] = number_format(floatval($total_star[0]->sum_rating / $total_starcount[0]->star_count), 1);
            } else {
                $average_ratting['total_countstar'] = 0;
            }
            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            $courseProgress = course::getCourseprogressbar($user_id);
            //dd($courseProgress);
            $payment_details = DB::select("SELECT * FROM elearning_payment_details where  course_id = $id and user_id=$user_id");


            return view('elearning.courseOverview', compact('courseDetails', 'courseContents', 'courseresorces', 'classOrder', 'enrolled', 'modules', 'screens', 'menus', 'user_id', 'video_exist', 'audio_exist', 'pdf_exist', 'counts', 'courseProgress', 'isEnrolled', 'average_ratting', 'ratings', 'payment_details'));
        } catch (\Exception $exc) {
            $this->WriteFileLog($exc);
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function takeCourse(Request $request, $id)
    {
        //dd($request);
        $method = 'Method => elearningEthnicTestController => takeCourse';
        try {
            $user_id = $request->session()->get("userID");
            // dd($user_id);
            if ($user_id == null) {
                return redirect(url('/'));
            }
            $id = Crypt::decrypt($id);
            //dd($id);
            $courseDetails = DB::select("SELECT * FROM elearning_courses WHERE drop_course=0 AND course_id=$id");
            foreach ($courseDetails as $courseDetail) {
                $classOrder = $courseDetail->course_classes;
            }

            $isEnrolled = DB::select("SELECT * FROM user_course_relation WHERE user_id=$user_id AND course_id=$id");
            // dd($isEnrolled);
            if (empty($isEnrolled)) {
                $userDetails = DB::select("SELECT * FROM users WHERE id=$user_id")[0];
                $userName = $userDetails->name;
                $userMail = $userDetails->email;
                $userMobile = ($userDetails->mobile_no) == null ? 0 : $userDetails->mobile_no;
                // dd($userMobile);
                $courseId = $courseDetails[0]->course_id;
                $courseName = $courseDetails[0]->course_name;

                // $courseBonus = $courseDetails[0]->course_bonus;
                $courseStatus = "Enrolled";
                $courseEnrollDate = date("Y-m-d H:i:s", time());
                //$course_statuslist=$course_status+1;
                $courseProgress = "0";
                $userPointsEarned = "0";
                $userRatingsGiven = "0";
                $mobileRemainder = "0";
                $mailRemainder = "0";
                DB::table('user_course_relation')
                    ->insert([
                        'user_id' => "$user_id",
                        'user_name' => "$userName",
                        'user_email' => "$userMail",
                        'user_mobile' => "$userMobile",
                        'course_id' => "$courseId",
                        'course_name' => "$courseName",
                        // 'course_bonus' => "$courseBonus",

                        'course_status' => "$courseStatus",
                        'status' => 1,
                        'course_enroll_date' => "$courseEnrollDate",
                        'course_progress' => "$courseProgress",
                        'user_points_earned' => "$userPointsEarned",
                        'user_rating_given' => "$userRatingsGiven",
                        'mobile_remainder' => "$mobileRemainder",
                        'mail_remainder' => "$mailRemainder",
                    ]);


                $classDetails = DB::select("SELECT * FROM elearning_classes WHERE drop_class=0 AND class_id=$id");
                $usercourseDetails = DB::select("SELECT * FROM user_course_relation WHERE user_id=$user_id AND course_id=$id");

                //$isEnrolled = DB::select("SELECT * FROM user_class_relation WHERE user_id=$user_id AND class_id=$id");
                //dd($isEnrolled);

                $userDetails = DB::select("SELECT * FROM users WHERE id=$user_id")[0];
                $userName = $userDetails->name;
                $userMail = $userDetails->email;
                $this->WriteFileLog($courseDetails);
                $courseId = $courseDetails[0]->course_id;
                $course_classes = $courseDetails[0]->course_classes;
                $courserelationId = $usercourseDetails[0]->id;
                $classStatus = "Enrolled";
                $classEnrollDate = date("Y-m-d H:i:s", time());
                $course_classes = explode(',', $course_classes);

                foreach ($course_classes as $key => $row) {

                    DB::table('user_class_relation')
                        ->insert([
                            'user_id' => "$user_id",
                            'user_name' => "$userName",
                            'user_email' => "$userMail",
                            'course_id' => "$courseId",
                            'class_id' => "$row",
                            'course_relation_id' => "$courserelationId",
                            'class_status' => "$classStatus",
                            'class_enroll_date' => "$classEnrollDate",
                            'created_at' => NOW()

                        ]);

                    # code...
                }
                //dd($courseId);
                // $is_pending = DB::table('user_class_relation')
                //     ->where('course_id', $courseId)
                //     ->where('status', 1)
                //     ->where('user_id', $user_id);
                $is_pending = DB::select("SELECT cr.* from user_class_relation as cr where cr.course_id=$courseId and cr.status=1 and cr.user_id=$user_id");
                if ($is_pending == []) {
                    DB::statement("UPDATE user_class_relation SET status = 1 WHERE user_id = $user_id AND status NOT IN (2) AND course_id = $courseId ORDER BY id ASC LIMIT 1");
                }



                // dd('completed');
                $id = Crypt::encrypt($courseId);

                //dd($id );

                $courseContents = DB::select("SELECT * FROM elearning_classes WHERE drop_class=0  ORDER BY FIELD(class_id,$classOrder)");
                $this->WriteFileLog($courseContents);

                $this->notifications_insert(null, $user_id, "$courseName-Course Enrolled Successfully", "/elearningCourse/class/" . $id);
                //dd('notify2');
                return redirect(route('elearningCourse', $id))->with('success', 'Course Enrolled Successfully');
                //return view('elearning.courseOverview', compact('courseDetails', 'courseContents', 'classOrder', 'isEnrolled'));

            } else {
                // 
            }
            //dd($id);
            $isForum = "False";
            $questionAdded = "False";
            $perPage = 4;
            // $askedQuestions = DB::select("SELECT * FROM elearning_forum WHERE course_id=$id");
            // $askedQuestions = DB::select("SELECT f.*,u.name,u.profile_path,course_id,Null as is_yours FROM elearning_forum AS f inner join users as u ON f.user_id =u.id WHERE course_id=$id and f.active_flag=0");
            $askedQuestions = DB::table('elearning_forum as f')
                ->select('f.*', 'u.name', 'u.profile_path', 'course_id', DB::raw('NULL as is_yours'))
                ->join('users as u', 'f.user_id', '=', 'u.id')
                ->where('course_id', $id)
                ->where('f.active_flag', 0)
                ->paginate($perPage);
            //dd($askedQuestions);


            foreach ($askedQuestions as $askedQuestions_key => $row) {
                $question_id = $row->question_id;
                // dd($question_id);
                $is_yours = 0;
                $follow_up = DB::select("SELECT * FROM elearning_followup WHERE question_id= $question_id");
                foreach ($follow_up as $follow_up_key2 => $row2) {
                    if (intval($row2->user_id) == intval($user_id)) {
                        $is_yours = 1;
                    }
                }
                $askedQuestions[$askedQuestions_key]->is_yours = $is_yours;
            }
            //dd($askedQuestions);
            $noQuestionsYet = empty($askedQuestions) ? true : false;
            // dd(empty($askedQuestions));
            // dd($noQuestionsYet);
            //dd($courseDetails);

            // $courseContents['courseContents'] = DB::select("SELECT * from elearning_courses inner join elearning_classes on elearning_courses.course_classes=elearning_classes.class_id where drop_course = 0;");

            $course_certificate = DB::select("SELECT e.exam_name,c.pass_percentage,c.exam_date,c.course_exam,c.course_certificate,uc.status,uc.course_id,uc.get_certified,uc.user_id,uc.course_progress,uc.course_status,uc.exam_status FROM elearning_courses as c inner join user_course_relation as uc on c.course_id=uc.course_id left join elearning_exam as e on c.exam_id=e.id where c.course_id= $id and c.drop_course=0 and e.active_flag=0 and uc.user_id=$user_id");

            // $exam_list=DB::select("SELECT * from user_course_relation as c inner join of elearning_exam as e on c.exam_id=e.id where ");
            $courseContents = DB::select("SELECT * FROM elearning_classes WHERE drop_class=0  ORDER BY FIELD(class_id,$classOrder)");
            //dd($courseContents);
            $classContents = DB::select("SELECT * FROM elearning_courses where course_id= $id and drop_course=0 ");
            //dd($classContents);

            $class_array = explode(',', $classContents[0]->course_classes);
            //dd( $class_array);
            $selected_class = [];
            $quiz_results = [];
            $QizDetails = DB::select("SELECT * from elearning_coursequiz where course_id= $id and user_id = $user_id");
            // dd($classContents);
            foreach ($QizDetails as $key => $row) {
                // dd($classContents);
                $quiz_results[$row->quiz_id] = $QizDetails[$key];
            }


            $quiz_results[] = $classContents[0];
            foreach ($class_array as $key => $value) {
                $classContents = DB::select("SELECT c.*,uc.course_id,uc.quiz_status,uc.user_id,uc.status as class_status,uc.bookmark FROM elearning_classes as c inner join user_class_relation as uc  where c.class_id= $value and c.drop_class=0 and c.class_id=uc.class_id and uc.user_id=$user_id and uc.course_id=$id ");
                // dd($classContents);
                $selected_class[$key] = $classContents[0];


                # code...
            }
            //dd($id);

            $quizes = DB::select("SELECT * FROM elearning_practice_quiz where drop_quiz=0");
            // dd($quizes);
            $quizzesWithKey = [];
            foreach ($quizes as $quiz) {
                $quizzesWithKey[$quiz->quiz_id] = $quiz;
            }
            // dd( $courseDetails,$classContents,$selected_class,$courseContents,$classOrder,$isForum,$questionAdded,$askedQuestions,$noQuestionsYet);
            $courseresorces = DB::select("SELECT ecl.* FROM elearning_classes as ecl inner join elearning_courses as ec on ec.course_classes = ecl.class_id WHERE ec.drop_course=0 AND ec.course_id=$id and ecl.drop_class=0 ");
            //dd( $courseresorces);
            $class_array = explode(',', $courseDetails[0]->course_classes);

            $valueToCount = 'value_to_count';

            $counts = count($class_array);

            $audio_exist = 0;
            $video_exist = 0;
            $pdf_exist = 0;

            $ratings = DB::select("SELECT r.*,u.name from elearning_ratings as r inner join users as u on u.id=r.user_id where r.course_id=$id");

            foreach ($ratings as $key => $rate) {
                $ratings[$key]->fullname = $rate->name;
                $ratings[$key]->name = $firstTwoLetters = strtoupper(substr($rate->name, 0, 2));
                $dateString = $ratings[$key]->created_at;
                $date = new DateTime($dateString);
                $now = new DateTime();
                $interval = $now->diff($date);

                if ($interval->y > 0) {
                    $formattedDate = $interval->format('%y year' . ($interval->y > 1 ? 's' : '') . ' ago');
                } elseif ($interval->m > 0) {
                    $formattedDate = $interval->format('%m month' . ($interval->m > 1 ? 's' : '') . ' ago');
                } elseif ($interval->d > 6) {
                    $weeks = floor($interval->d / 7);
                    $formattedDate = $weeks . ' week' . ($weeks > 1 ? 's' : '') . ' ago';
                } elseif ($interval->d > 0) {
                    $formattedDate = $interval->format('%d day' . ($interval->d > 1 ? 's' : '') . ' ago');
                } elseif ($interval->h > 0) {
                    $formattedDate = $interval->format('%h hour' . ($interval->h > 1 ? 's' : '') . ' ago');
                } elseif ($interval->i > 0) {
                    $formattedDate = $interval->format('%i minute' . ($interval->i > 1 ? 's' : '') . ' ago');
                } else {
                    $formattedDate = 'Just now';
                }
                $ratings[$key]->created_at = $formattedDate;
            }
            $total_starcount = DB::Select("SELECT COUNT(*) as star_count FROM elearning_ratings where course_id=$id");

            $fivestar = DB::Select("SELECT COUNT(*) as fivestar_count FROM elearning_ratings where course_id=$id and rating_point>=4.5");
            // $five_star = (int) $fivestar[0]->fivestar_count;
            //dd($fivestar);
            if ($fivestar[0]->fivestar_count != 0) {
                $average_ratting['five_star'] = (int) ($fivestar[0]->fivestar_count) / ($total_starcount[0]->star_count) * 100;
            } else {
                $average_ratting['five_star'] = 0;
            }
            // dd($five_star);
            $fourstar = DB::Select("SELECT COUNT(*) as fourstar_count FROM elearning_ratings where course_id=$id and (rating_point >= 3.5 AND rating_point <= 4.4)");
            // $five_star = (int) $fivestar[0]->fivestar_count;
            // dd($fivestar);
            if ($fourstar[0]->fourstar_count != 0) {
                $average_ratting['four_star'] = (int) ($fourstar[0]->fourstar_count) / ($total_starcount[0]->star_count) * 100;
            } else {
                $average_ratting['four_star'] = 0;
            }
            $threestar = DB::Select("SELECT COUNT(*) as threestar_count FROM elearning_ratings where course_id=$id and (rating_point >= 2.5 AND rating_point <= 3.4)");
            // $five_star = (int) $fivestar[0]->fivestar_count;
            // dd($fivestar);
            if ($threestar[0]->threestar_count != 0) {
                $average_ratting['three_star'] = (int) ($threestar[0]->threestar_count) / ($total_starcount[0]->star_count) * 100;
            } else {
                $average_ratting['three_star'] = 0;
            }

            $twostar = DB::Select("SELECT COUNT(*) as twostar_count FROM elearning_ratings where course_id=$id and (rating_point >= 1.5 AND rating_point <= 2.4)");
            // $five_star = (int) $fivestar[0]->fivestar_count;
            // dd($fivestar);
            if ($twostar[0]->twostar_count != 0) {
                $average_ratting['two_star'] = (int) ($twostar[0]->twostar_count) / ($total_starcount[0]->star_count) * 100;
            } else {
                $average_ratting['two_star'] = 0;
            }
            $onestar = DB::Select("SELECT COUNT(*) as onestar_count FROM elearning_ratings where course_id=$id and (rating_point >= 0.5 AND rating_point <= 1.4)");
            // $five_star = (int) $fivestar[0]->fivestar_count;
            // dd($fivestar);
            if ($onestar[0]->onestar_count != 0) {
                $average_ratting['one_star'] = (int) ($onestar[0]->onestar_count) / ($total_starcount[0]->star_count) * 100;
            } else {
                $average_ratting['one_star'] = 0;
            }

            // $total_star = DB::Select("SELECT SUM(rating_point) as sum_rating FROM elearning_ratings where course_id=$id");
            // //dd($total_star);
            // $average_ratting['total_countstar'] = number_format(floatval($total_star[0]->sum_rating / $total_starcount[0]->star_count), 1);


            if ($total_starcount[0]->star_count > 0) {
                $total_star = DB::select("SELECT SUM(rating_point) AS sum_rating FROM elearning_ratings WHERE course_id = $id");
                $average_ratting['total_countstar'] = number_format(floatval($total_star[0]->sum_rating / $total_starcount[0]->star_count), 1);
            } else {
                $average_ratting['total_countstar'] = 0;
            }

            // dd($formattedDate);









            foreach ($class_array as $key => $row) {

                $class_details = DB::select("SELECT * FROM elearning_classes where class_id = $row and drop_class=0 ");

                if (isset($class_details[0]->class_format) && $class_details[0]->class_format == 'mp3') {
                    $audio_exist = 1;
                }
                if (isset($class_details[0]->class_format) && $class_details[0]->class_format == 'mp4') {
                    $video_exist = 1;
                }
                if (isset($class_details[0]->class_format) && $class_details[0]->class_format == 'pdf') {
                    $pdf_exist = 1;
                } else {
                    $img_exist = 1;
                }
                // if ($class_details[0]->class_format == 'mp3') {
                //     $audio_exist = 1;
                // }
                // if ($class_details[0]->class_format == 'mp4') {
                //     $video_exist = 1;
                // }
                // if ($class_details[0]->class_format == 'pdf') {
                //     $pdf_exist = 1;
                // }

                # code...
            }


            $menus = $this->FillMenu();
            // dd($courseDetails);

            $screens = $menus['screens'];
            $modules = $menus['modules'];

            return view('elearning.class', compact('courseDetails', 'classContents', 'selected_class', 'courseContents', 'classOrder', 'isForum', 'questionAdded', 'askedQuestions', 'noQuestionsYet', 'modules', 'screens', 'menus', 'user_id', 'courseresorces', 'counts', 'audio_exist', 'video_exist', 'pdf_exist', 'course_certificate', 'quizzesWithKey', 'quiz_results', 'ratings', 'average_ratting'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function addQuestion(Request $request, $id)
    {
        // dd("casjna");
        $method = 'Method => elearningEthnicTestController => addQuestion';
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return redirect(url('/'));
        }
        try {
            $isForum = "True";
            $id = Crypt::decrypt($id);
            $courseDetails = DB::select("SELECT * FROM elearning_courses WHERE drop_course=0 AND course_id=$id");
            foreach ($courseDetails as $courseDetail) {
                $classOrder = $courseDetail->course_classes;
            }
            $isEnrolled = DB::select("SELECT * FROM user_course_relation WHERE user_id=$user_id AND course_id=$id");
            if (empty($isEnrolled)) {
                return view('elearning.dashboard');
            } else {
                // 
            }

            $questionHeading = $request->Question_heading;
            $questionDescription = $request->Question_description;

            $questionDate = date("Y-m-d H:i:s", time());
            // dd($questionImage);
            // DB::select("SELECT * FROM users where id=$user_id");
            DB::table('elearning_forum')
                ->insert([
                    'course_id' => "$id",
                    'class_id' => "0",
                    'user_id' => "$user_id",
                    'question_date' => "$questionDate",
                    'question_header' => "$questionHeading",
                    'question_description' => "$questionDescription",
                    'number_of_follows' => 0,
                    'follow_details' => "",
                    'active_flag' => 0,
                    'created_by' => $user_id,
                    'created_at' => NOW()

                ]);
            $askedQuestions = DB::select("SELECT f.*,u.name,u.profile_path,course_id FROM elearning_forum AS f inner join users as u ON f.user_id =u.id WHERE course_id=$id and f.active_flag=0 ");

            // $askedQuestions = DB::select("SELECT * FROM elearning_forum WHERE course_id=$id");
            // $forumQuestions = empty($askedQuestions)? $askedQuestions[0]="No Questions has been asked in this course yet": $askedQuestions;
            // dd($forumQuestions);
            $courseContents = DB::select("SELECT * FROM elearning_classes WHERE drop_class=0 AND class_in=$id ORDER BY FIELD(class_id,$classOrder)");
            // dd($courseContents);
            $questionAdded = "True";
            $noQuestionsYet = empty($askedQuestions) ? true : false;

            $courseContents = DB::select("SELECT * FROM elearning_classes WHERE drop_class=0  ORDER BY FIELD(class_id,$classOrder)");
            //dd($courseContents);
            $classContents = DB::select("SELECT * FROM elearning_courses where course_id= $id and drop_course=0 ");
            // dd($classContents);

            $class_array = explode(',', $classContents[0]->course_classes);
            $selected_class = [];
            foreach ($class_array as $key => $value) {
                $classContents = DB::select("SELECT * FROM elearning_classes where class_id= $value and drop_class=0");
                //dd($classContents);
                $selected_class[$key] = $classContents[0];

                # code...
            }
            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            return redirect()->back();
            // return view('elearning.class', compact('courseDetails', 'courseContents', 'classOrder', 'isForum', 'askedQuestions', 'noQuestionsYet', 'modules', 'screens', 'menus', 'user_id', 'selected_class'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function addreply(Request $request)
    {
        $this->WriteFileLog("addreply");
        $method = 'Method => elearningEthnicTestController => addreply';
        try {
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return redirect(url('/'));
            }
            $question_id = $request->question_id;
            $qa_user_id = $request->user_id;
            // $course_id = $request->course_id;
            $questionDescription = $request->Question_description;


            $this->WriteFileLog($question_id);
            $this->WriteFileLog($qa_user_id);

            $replylist = DB::select("SELECT f.*,u.name,u.profile_path FROM elearning_forum AS f inner join users as u ON f.user_id =u.id  where f.question_id=$question_id AND f.user_id=$qa_user_id and f.active_flag=0 ");
            $this->WriteFileLog($replylist);

            $replylist2 = DB::select("SELECT f.*,u.name,u.profile_path,u.profile_image FROM elearningallcourses_reply AS f inner join users as u ON f.user_id =u.id  where f.question_id=$question_id and f.active_flag=0 ");
            $isEmpty = empty($replylist2) ? true : false;
            $replylist_admin = [];
            $replylist_index = 0;
            foreach ($replylist2 as $key => $row) {
                $course_reply_id = $row->id;
                $admin_reply = DB::select("SELECT er.* from elearningcoursesadmin_reply as er where er.course_reply_id=$course_reply_id and er.active_flag=0");
                if ($admin_reply != []) {
                    $replylist_admin[$replylist_index] = $admin_reply[0];
                    $replylist_index++;
                }
                # code...
            }
            $data = [
                'replylist' => $replylist,
                'isEmpty' => $isEmpty,
                'replylist2' => $replylist2,
                'replylist_admin' => $replylist_admin
            ];
            $this->WriteFileLog($data);
            return $data;
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function replystore(Request $request)
    {
        $this->WriteFileLog("replystore");
        $method = 'Method => elearningEthnicTestController => replystore';
        try {
            $user_id = $request->session()->get("userID");

            if ($user_id == null) {
                return redirect(url('/'));
            }


            $question_id = $request->question_id;
            $course_id = $request->course_id;
            // $questionDescription = $request->Question_description;
            $reply_details = $request->reply_details;

            $data = DB::table('elearningallcourses_reply')
                ->insert([
                    'question_id' => $question_id,
                    'user_id' => $user_id,
                    'course_id' => $course_id,
                    'reply_details' => $reply_details,
                    'active_flag' => '0',
                    'created_by' => $user_id,
                    'created_at' => NOW()
                ]);
            if ($data) {
                return $data;
            } else {
                return 0;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function followstore(Request $request)
    {
        $this->WriteFileLog("followstore");
        $method = 'Method => elearningEthnicTestController => followstore';
        try {
            $user_id = $request->session()->get("userID");
            $this->WriteFileLog($user_id);

            if ($user_id == null) {
                return redirect(url('/'));
            }


            $question_id = $request->question_id;
            $course_id = $request->course_id;
            // $follow_details=$request->follow_details;
            $nooffollows = DB::select("SELECT number_of_follows FROM elearning_forum WHERE question_id=$question_id and active_flag=0 ");

            // $questionDescription = $request->Question_description;
            $count_follows = DB::Select("SELECT count('question_id') as question_count from elearning_followup where question_id=$question_id and user_id= $user_id");
            if ($count_follows[0]->question_count == 0) {
                $nooffollows = $nooffollows[0]->number_of_follows;
                $data = DB::table('elearning_followup')
                    ->insert([
                        'question_id' => $question_id,
                        'user_id' => $user_id,
                        'course_id' => $course_id,
                        'created_by' => $user_id,
                        'created_at' => NOW()

                    ]);

                $data = DB::table('elearning_forum')
                    ->where('question_id', $question_id)
                    ->update([
                        'number_of_follows' => $nooffollows + 1

                    ]);
                return $data;
            } else {
                $data = DB::table('elearning_followup')
                    ->where('question_id', $question_id)
                    ->where('user_id', $user_id)
                    ->delete();


                $nooffollows = $nooffollows[0]->number_of_follows;
                $data = DB::table('elearning_forum')
                    ->where('question_id', $question_id)
                    ->update([
                        'number_of_follows' => $nooffollows - 1

                    ]);

                return 0;
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function applyfilter(Request $request)
    {
        $this->WriteFileLog("applyfilter");
        $this->WriteFileLog($request);
        $method = 'Method => elearningEthnicTestController => applyfilter';
        try {
            $user_id = $request->session()->get("userID");
            $this->WriteFileLog($user_id);

            if ($user_id == null) {
                return redirect(url('/'));
            }
            $question_id = $request->question_id;
            $course_id = $request->course_id;
            // $questionDescription = $request->Question_description;
            $number_of_follows = $request->number_of_follows;
            $this->WriteFileLog($number_of_follows);

            $questions = $request->questions;
            $questionSearch = $request->questionSearch;
            $most_recent_where = $number_of_follows == "Most Recent" ? " ORDER BY question_id DESC" : ($number_of_follows == "Most Followeds" ? " ORDER BY number_of_follows DESC" : "");
            $all_option_where = $questions == "myquestions" ? "AND user_id=$user_id" : " ";
            // if($number_of_follows == "Most Recent"){
            //     $question_filter = $questions=="allquestions" ? '' : 'AND user_id=$user_id';
            //     $where="Where (ef.question_header LIKE  '$questionSearch%') and course_id=$course_id $question_filter ORDER BY question_id DESC";
            // }
            // else{
            //     $question_filter = $questions=="allquestions" ? '' : 'AND user_id=$user_id';
            //     $where="Where (ef.question_header LIKE  '$questionSearch%') and course_id=$course_id $question_filter ORDER BY number_of_follows DESC";

            // }
            $nooffollows = DB::select("SELECT ef.*,u.name,u.profile_path FROM elearning_forum as ef inner join users as u ON ef.user_id =u.id Where (ef.question_header LIKE  '$questionSearch%') and ef.active_flag=0 and course_id=$course_id " . $all_option_where . $most_recent_where);
            $this->WriteFileLog($nooffollows);

            // if ($number_of_follows == "Most Recent") {
            //     $nooffollows = DB::select("SELECT ef.*,u.name,u.profile_path FROM elearning_forum as ef inner join users as u ON ef.user_id =u.id Where (ef.question_header LIKE  '$questionSearch%') and course_id=$course_id ORDER BY question_id DESC");
            //     $this->WriteFileLog($nooffollows);
            // } else if ($number_of_follows == "Most Recent" && $questions == "allquestions") {
            //     $nooffollows = DB::select("SELECT ef.*,u.name,u.profile_path FROM elearning_forum  as ef inner join users as u ON ef.user_id =u.id where (ef.question_header like  '$questionSearch%') and  course_id= $course_id ORDER BY question_id DESC");
            // } else if ($number_of_follows == "Most Recent" && $questions == "myquestions") {
            //     $nooffollows = DB::select("SELECT ef.*,u.name,u.profile_path FROM elearning_forum  as ef inner join users as u ON ef.user_id =u.id Where (ef.question_header LIKE  '$questionSearch%') AND user_id=$user_id and course_id= $course_id ORDER BY question_id DESC");
            // } else if ($number_of_follows == "Most Followeds") {
            //     $nooffollows = DB::select("SELECT ef.*,u.name,u.profile_path FROM elearning_forum as ef inner join users as u ON ef.user_id =u.id Where (ef.question_header LIKE  '$questionSearch%') AND course_id=$course_id ORDER BY number_of_follows DESC");
            // } else if ($number_of_follows == "Most Followeds" && $questions == "myquestions") {
            //     $nooffollows = DB::select("SELECT ef.*,u.name,u.profile_path FROM elearning_forum  as ef inner join users as u ON ef.user_id =u.id Where (ef.question_header LIKE  '$questionSearch%') AND user_id=$user_id  ORDER BY number_of_follows DESC");
            // } else if ($number_of_follows == "Most Followeds" && $questions == "allquestions") {
            //     $nooffollows = DB::select("SELECT ef.*,u.name,u.profile_path FROM elearning_forum  as ef inner join users as u ON ef.user_id =u.id Where (ef.question_header LIKE  '$questionSearch%') AND user_id=$user_id and course_id= $course_id  ORDER BY number_of_follows DESC");
            // } else if ($questionSearch = "" || $number_of_follows == "" || $questions == "") {
            //     $nooffollows = "No Result Found";
            // }
            if ($nooffollows != "No Result Found") {
                foreach ($nooffollows as $askedQuestions_key => $row) {
                    $question_id = $row->question_id;
                    $is_yours = 0;
                    $follow_up = DB::select("SELECT * FROM elearning_followup WHERE question_id= $question_id");
                    foreach ($follow_up as $follow_up_key2 => $row2) {
                        if (intval($row2->user_id) == intval($user_id)) {
                            $is_yours = 1;
                        }
                    }
                    $nooffollows[$askedQuestions_key]->is_yours = $is_yours;
                }
            }

            // } else {
            //     $nooffollows = DB::select("SELECT ef.*,u.name,u.profile_path FROM elearning_forum  as ef inner join users as u ON ef.user_id =u.id Where ef.question_header LIKE  '$questionSearch%'");
            // }
            $this->WriteFileLog($nooffollows);


            // $data = DB::table('elearningallcourses_reply')
            //     ->insert([
            //         'question_id' => "$question_id",
            //         'user_id' =>  $user_id,
            //         'course_id' => $course_id,
            //         // 'reply_details' => "$reply_details",
            //         'active_flag' => '0',
            //         'created_by' => $user_id,
            //         'created_at' => NOW()
            //     ]);
            return $nooffollows;
            // if ($nooffollows) {
            //     return  $nooffollows;
            // } else {
            //     return 0;
            // }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function addNewNote(Request $request)
    {
        $this->WriteFileLog($request);
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return redirect(url('/'));
        }
        $method = 'Method => elearningEthnicTestController => addNewNote';

        $course_id = $request->courseId;
        $class_id = $request->classId;
        $note_date = date("Y-m-d H:i:s", time());
        $note = $request->note;
        try {
            DB::table('elearning_notes')
                ->insert([
                    'course_id' => "$course_id",
                    'class_id' => "$class_id",
                    'user_id' => "$user_id",
                    'notes_date' => "$note_date",
                    'note' => "$note",
                    'active_note' => '0',
                    'created_at' => NOW()

                ]);
            return "Success";
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function viewNotes(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return redirect(url('/'));
        }
        $method = 'Method => elearningEthnicTestController => viewNotes';

        $course_id = $request->courseId;
        try {
            $notes = DB::select("SELECT * FROM elearning_notes WHERE active_note=0 AND course_id=$course_id AND user_id=$user_id");
            $isEmpty = empty($notes) ? true : false;
            $data = [
                'notes' => $notes,
                'isEmpty' => $isEmpty,
            ];
            return $data;
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function updateNote(Request $request)
    {
        //dd("bjsx");
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return redirect(url('/'));
        }
        $method = 'Method => elearningEthnicTestController => updateNote';

        $note_id = $request->noteId;
        $updatedNote = $request->updatedNote;
        try {
            // $notes = DB::select("SELECT * FROM elearning_notes WHERE active_note=0 AND course_id=$course_id AND user_id=$user_id");
            $data = DB::table('elearning_notes')
                ->where('note_id', $note_id)
                ->update([
                    'note' => $updatedNote,
                    'updated_by' => $user_id,
                    'updated_at' => NOW(),
                ]);
            // $data = [
            //     'notes' => $notes,
            //     'isEmpty' => $isEmpty,
            // ];
            //dd($data);
            return $data;
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function deleteNote(Request $request)
    {
        //dd("bjsx");
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return redirect(url('/'));
        }
        $method = 'Method => elearningEthnicTestController => deleteNote';

        $note_id = $request->note_id;

        try {
            // $notes = DB::select("SELECT * FROM elearning_notes WHERE active_note=0 AND course_id=$course_id AND user_id=$user_id");
            $data = DB::table('elearning_notes')
                ->where('note_id', $note_id)
                ->update([
                    'active_note' => '1',
                ]);

            return $data;
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function bookmark(Request $request)
    {
        $this->WriteFileLog("snkas");
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return redirect(url('/'));
        }
        $method = 'Method => elearningEthnicTestController => bookmark';

        $currentTime = $request->sec;
        $course_id = $request->course_id;
        $class_id = $request->class_id;
        try {
            DB::table('user_class_relation')
                ->where('course_id', $course_id)
                ->where('class_id', $class_id)
                ->update([
                    'bookmark' => $currentTime,
                ]);
            return "Success";
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function status_update(Request $request)
    {
        //$this->WriteFileLog("fwef");
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return redirect(url('/'));
        }
        $method = 'Method => elearningEthnicTestController => status_update';
        $course_id = $request->course_id;
        $class_id = $request->class_id;
        try {
            DB::table('user_class_relation')
                ->where('course_id', $course_id)
                ->where('class_id', $class_id)
                ->where('user_id', $user_id)
                ->update([
                    'status' => 2,
                ]);

            $class_quiz = DB::select("SELECT * from elearning_classes where class_id=$class_id and drop_class=0");
            if ($class_quiz[0]->class_quiz != "yes") {
                $is_pending = DB::select("SELECT cr.* from user_class_relation as cr where cr.course_id=$course_id and cr.status=1 and cr.user_id=$user_id");
                if ($is_pending == []) {
                    DB::statement("UPDATE user_class_relation SET status = 1 WHERE user_id = $user_id AND status NOT IN (2) AND course_id =$course_id ORDER BY id ASC LIMIT 1");
                }
                $this->WriteFileLog($is_pending);
            }

            $is_completed = Db::select("SELECT * from user_class_relation where (status=1 or status=0) and course_id=$course_id and user_id=$user_id");
            $this->WriteFileLog($is_completed);
            if ($is_completed == []) {
                $is_examthere = DB::select("SELECT * from elearning_courses where (course_exam=1) and course_id=$course_id and drop_course=0");

                if ($is_examthere == []) {
                    DB::table('user_course_relation')
                        ->where('course_id', $course_id)
                        ->where('user_id', $user_id)
                        ->update([
                            'course_status' => "Completed",
                            'status' => 2,
                            'course_progress' => 100,
                        ]);


                    $coursecpt_points = DB::select("SELECT course_cpt_points from elearning_courses where course_id=$course_id and drop_course=0");

                    $cpt_points = $coursecpt_points[0]->course_cpt_points;

                    DB::table('user_cpt_points')
                        ->insert([
                            'course_id' => $course_id,
                            'user_id' => $user_id,
                            'cpt_points' => $cpt_points,
                            'status' => '0',
                            'created_by' => $user_id,
                            'created_at' => NOW()

                        ]);


                    $userstable = DB::select("SELECT  total_cptpoints from users where id=$user_id and active_flag=0");
                    $totalcpt_points = $userstable[0]->total_cptpoints;

                    $sumofcpt = $totalcpt_points + $cpt_points;

                    DB::table('users')
                        ->where('id', $user_id)
                        ->update([
                            'total_cptpoints' => $sumofcpt,
                        ]);
                    $data['course_id'] = $course_id;
                    $encryptArray = $this->encryptData($data);
                    $request = array();

                    $request['requestData'] = $encryptArray;

                    $gatewayURL = config('setting.api_gateway_url') . '/cpt/mail';

                    $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);

                    $response1 = json_decode($response);
                    if ($response1->Status == 200 && $response1->Success) {
                        $objData = json_decode($this->decryptData($response1->Data));


                        if ($objData->Code == 200) {
                            return "Success";
                        }

                        if ($objData->Code == 400) {
                            return "failed";
                        }
                    }
                }
            } else {
                $total_classes = DB::select("SELECT COUNT(*) as total_classes FROM user_class_relation where course_id=$course_id and user_id=$user_id");
                $totalClasses = (int) $total_classes[0]->total_classes;
                $total_classes_completed = DB::select("SELECT COUNT(*) AS total_classes
            FROM user_class_relation AS cr
            INNER JOIN elearning_classes AS c ON c.class_id = cr.class_id
            WHERE cr.status = 2
              AND cr.course_id = $course_id
              AND cr.user_id = $user_id
              AND (CASE WHEN c.class_quiz = 'yes' THEN cr.quiz_status = 1 ELSE 1 END)");
                $this->WriteFileLog($total_classes_completed);
                $totalClassesCount = (int) $total_classes_completed[0]->total_classes;
                $this->WriteFileLog($totalClassesCount);
                $progressPercentage = ($totalClassesCount / $totalClasses) * 100;
                //dd($progressPercentage);
                $progress = round($progressPercentage);
                if ($progress == 100) {

                    $progress = $progress - 20;
                }
                $coursecpt_points = DB::select("SELECT course_cpt_points from elearning_courses where course_id=$course_id and drop_course=0");

                $cpt_points = $coursecpt_points[0]->course_cpt_points;
                DB::table('user_cpt_points')
                    ->insert([
                        'course_id' => $course_id,
                        'user_id' => $user_id,
                        'cpt_points' => $cpt_points,
                        'status' => '0',
                        'created_by' => $user_id,
                        'created_at' => NOW()

                    ]);

                $userstable = DB::select("SELECT  total_cptpoints from users where id=$user_id and active_flag=0");
                $totalcpt_points = $userstable[0]->total_cptpoints;

                $sumofcpt = $totalcpt_points + $cpt_points;

                DB::table('users')
                    ->where('id', $user_id)
                    ->update([
                        'total_cptpoints' => $sumofcpt,
                    ]);
                //dd($cpt_points);


                DB::table('user_course_relation')
                    ->where('course_id', $course_id)
                    ->where('user_id', $user_id)
                    ->update([
                        'course_progress' => $progress,
                    ]);
            }
            // }
            $data['course_id'] = $course_id;
            $encryptArray = $this->encryptData($data);
            $request = array();

            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/cpt/mail';

            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);

            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    return "Success";
                }

                if ($objData->Code == 400) {
                    return "failed";
                }
            }

            // return "Success";
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function generatePDF(Request $request, $id)
    {
        // dd($id);
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return redirect(url('/'));
        }
        $method = 'Method => elearningEthnicTestController => generatePDF';
        $id = Crypt::decrypt($id);

        try {
            $course_details = DB::select("SELECT c.*  from elearning_courses as c  where c.course_id =$id and c.drop_course=0");

            $course_name = $course_details[0]->course_name;

            $date = $course_details[0]->course_end_period;

            $course_id = $course_details[0]->course_id;

            $name = $this->getusername($user_id);


            DB::table('user_course_relation')
                ->where('course_id', $id)
                ->where('user_id', $user_id)
                ->update([
                    'get_certified' => "1",

                ]);
            $certificate_template_id = $course_details[0]->cetificate_template;
          
            $signatories  = DB::table('certificate_template_signatories')
             ->where('certificate_template_id', $certificate_template_id)
                 ->orderBy('sort_order', 'asc')
                ->get();
            $get_template  = DB::table('certificate_templates')
             ->where('certificate_templates_id', $certificate_template_id)
            ->first();

             
            $data = [
                 'date' => Carbon::today()->format('d-m-Y'),
                'course_name' => $course_name,
                'name' => $name,
                'signatories' => $signatories,
                'course_id' => $course_id,

            ];

           


             
           $pdf = PDF::loadView("certificate_template.{$get_template->template_name}.index", [
    'data' => $data
]);



          

            $storagepath_user = public_path() . '/userdocuments/certificate/' . $user_id;
            if (!File::exists($storagepath_user)) {
                File::makeDirectory($storagepath_user);
            }
            $storagepath_ninf = public_path() . '/userdocuments/certificate/' . $user_id . '/' . $id;
            if (!File::exists($storagepath_ninf)) {
                File::makeDirectory($storagepath_ninf);
            }

            // Save the PDF file in the user's folder
            $filename = 'certificate.pdf';

            $output = $storagepath_ninf . '/' . $filename;

            $pdf->save($output);

            $data = [
                'date' => $date,
                'course_name' => $course_name,
                'name' => $name,
                'attach' => $output,

            ];

            $encryptArray = $this->encryptData($data);
            $request = array();

            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/generatepdf/' . $id;

            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);

            $response1 = json_decode($response);

            if ($pdf->download('certificate.pdf')) {
                return redirect()->back()->with('success', 'Your Certificate has been Issued Successfully');
            } else {
                return redirect()->back()->with('error', 'Something went wrong');
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    // public function certificate_store(Request $request)
    // {
    //     $this->WriteFileLog("fwef");
    //     $user_id = $request->session()->get("userID");
    //     if ($user_id == null) {
    //         return redirect(url('/'));
    //     }
    //     $method = 'Method => elearningEthnicTestController => certificate_store';
    //     $course_id = $request->course_id;
    //     $class_id = $request->class_id;
    //     try {

    //         DB::table('elearning_notes')
    //             ->insert([
    //                 'course_id' => "$course_id",
    //                 'class_id' => "$class_id",
    //                 'user_id' => "$user_id",
    //                 'active_note' => '0',
    //                 'created_at' => NOW()

    //             ]);
    //     } catch (\Exception $exc) {
    //         return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
    //     }
    // }
    public function class_quiz(Request $request, $course_id, $class_id)
    {
        //dd($course_id);
        $method = 'Method => elearningEthnicTestController => class_quiz';

        try {
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $request = array();
            $request['course_id'] = $course_id;
            $request['class_id'] = $class_id;
            $request['mlhud_id'] = $user_id;

            //dd($request);
            $encryptArray = $this->encryptData($request);
            $request = array();

            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/class/quiz';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $response = json_decode($response);
            //dd($response);


            $objData = json_decode($this->decryptData($response->Data));

            $parant_data = $objData->Data;
            $quizId = $parant_data->quizId;
            $quizName = $parant_data->quizName;
            $questionDetails = $parant_data->questionDetails;
            //dd($questionDetails);
            $qIds = $parant_data->qIds;

            $course_id = $parant_data->course_id;

            $class_id = $parant_data->class_id;

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
            return view('elearning.userview', compact('quizId', 'quizName', 'questionDetails', 'qIds', 'user_id', 'menus', 'screens', 'modules', 'course_id', 'class_id'));

            //code...
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
        $method = 'Method => elearningEthnicTestController => quiz_store';
        try {
            $data = array();

            $data['quizId'] = $request->quizId;
            $data['attempt'] = $request->attempt;
            $data['score'] = $request->score;
            $data['pass_mark'] = $request->pass_mark;

            $data['total_scores'] = $request->total_scores;
            $data['course_id'] = $request->course_id;
            $data['class_id'] = $request->class_id;
            $course_id = $request->course_id;

            $encryptArray = $this->encryptData($data);
            $request = array();

            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/class/quiz/store';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);


            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                //dd($objData);

                $id = Crypt::encrypt($course_id);
                if ($objData->Code == 200) {
                    return redirect(route('elearningCourse/class', $id))->with('success', 'Thankyou for Attending the Quiz');
                }

                if ($objData->Code == 400) {
                    return redirect(route('elearningCourse/class', $id))->with('fail', 'Quiz Failed');
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
    public function course_exam(Request $request, $course_id, $class_id)
    {
        //dd($course_id);
        $method = 'Method => elearningEthnicTestController => course_exam';

        try {
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $request = array();
            $request['course_id'] = $course_id;
            $request['class_id'] = $class_id;
            $request['mlhud_id'] = $user_id;

            $encryptArray = $this->encryptData($request);
            $request = array();

            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/course/exam';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
            $response = json_decode($response);


            $objData = json_decode($this->decryptData($response->Data));

            $parant_data = $objData->Data;
            $quizId = $parant_data->quizId;
            $quizName = $parant_data->quizName;
            $questionDetails = $parant_data->questionDetails;
            //dd($questionDetails);
            $qIds = $parant_data->qIds;

            $course_id = $parant_data->course_id;

            $class_id = $parant_data->class_id;

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
            return view('elearning.examview', compact('quizId', 'quizName', 'questionDetails', 'qIds', 'user_id', 'menus', 'screens', 'modules', 'course_id', 'class_id'));

            //code...
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function exam_store(Request $request)
    {

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => elearningEthnicTestController => exam_store';
        try {
            $data = array();

            $data['quizId'] = $request->quizId;

            $data['score'] = $request->score;


            $data['total_scores'] = $request->total_scores;
            $data['course_id'] = $request->course_id;
            $data['class_id'] = $request->class_id;
            $course_id = $request->course_id;

            $encryptArray = $this->encryptData($data);
            $request = array();

            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/course/exam/store';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);

            $response1 = json_decode($response);


            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));
                //dd($objData);

                $id = Crypt::encrypt($course_id);
                if ($objData->Code == 200) {
                    return redirect(route('elearningCourse/class', $id))->with('success', 'Thankyou for Attending the Exam');
                }

                if ($objData->Code == 400) {
                    return redirect(route('elearningCourse/class', $id))->with('fail', 'Exam not Attended properly');
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
    public function cpt_index(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => elearningEthnicTestController => cpt_index';
        try {
            $request = array();
            $request['mlhud_id'] = $user_id;
            $gatewayURL = config('setting.api_gateway_url') . '/elearning/cpd';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
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
            return view('layouts.cptindex', compact('user_id', 'rows', 'menus', 'screens', 'modules'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function ratings_store(Request $request)
    {

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => elearningEthnicTestController => ratings_store';
        try {
            $data = array();
            $data['course_id'] = $request->course_id;
            $data['review'] = $request->review;
            $data['rating_point'] = $request->rating_point;
            $data['user_id'] = $user_id;

            $encryptArray = $this->encryptData($data);
            $request = array();

            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/ratings/store';

            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);

            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    return redirect(route('ethictest.index'))->with('success', 'Ethic Test Created Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('ethictest.index'))->with('fail', 'Ethic Test Failed');
                }
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function rating_index(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => elearningEthnicTestController => rating_index';
        try {
            $request = array();
            $request['mlhud_id'] = $user_id;
            $gatewayURL = config('setting.api_gateway_url') . '/rating/admin/index';
            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);
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
            return view('layouts.ratingsadmin', compact('user_id', 'rows', 'menus', 'screens', 'modules'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function cart_delete(Request $request)
    {
        $this->WriteFileLog("web hitted");
        try {
            //dd('feef');
            $method = 'Method => elearningEthnicTestController => cart_delete';
            // $user_id = $request->session()->get("userID");
            // if ($user_id == null) {
            //     return view('auth.login');
            // }
            $data['id'] = $request->id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/elearningCart/remove';
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
    public function move_cart(Request $request)
    {

        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }
        $method = 'Method => elearningEthnicTestController => move_cart';
        try {
            $data = array();
            $data['course_id'] = $request->course_id;
            $data['user_id'] = $user_id;

            $encryptArray = $this->encryptData($data);
            $request = array();

            $request['requestData'] = $encryptArray;

            $gatewayURL = config('setting.api_gateway_url') . '/Elearningmovecart';

            $response = $this->serviceRequest($gatewayURL, 'GET', json_encode($request), $method);

            $response1 = json_decode($response);

            if ($response1->Status == 200 && $response1->Success) {
                $objData = json_decode($this->decryptData($response1->Data));


                if ($objData->Code == 200) {
                    return redirect(route('elearningCart'))->with('success', 'Cart Added Successfully');
                }

                if ($objData->Code == 400) {
                    return redirect(route('elearningCart'))->with('fail', 'Cart Not Added');
                }
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
}
