<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ValuerController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $logMethod = 'Method => ValuerController => User';
        try {
            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $role = DB::select("select role_id from uam_user_roles where user_id=$userID");
            $role = $role[0]->role_id;
            if ($role == "1") {

                $rows = array();
                $rows['details'] = DB::table('user_payment_details')
                    ->select('*')
                    ->join('user_general_details', 'user_payment_details.user_id', '=', 'user_general_details.user_id')
                    ->join('valuer_list', 'user_payment_details.user_id', '=', 'valuer_list.user_id')
                    ->join('uam_user_roles', 'user_payment_details.user_id', '=', 'uam_user_roles.user_id')
                    ->orderBy('valuer_id', 'asc')
                    ->where('valuer_list.active_flag', '0')
                    ->where('user_general_details.active_flag', '0')
                    ->get();
            } else if ($role == "19") {

                $rows = array();
                $rows['details'] =  DB::table('users')
                    ->select('*')
                    // ->join('user_general_details','users.a_user_id','=','user_general_details.user_id')
                    ->join('valuer_list', 'users.id', '=', 'valuer_list.assigned_to_id')
                    ->join('user_general_details', 'user_general_details.user_id', '=', 'valuer_list.user_id')
                    ->join('uam_user_roles', 'users.id', '=', 'uam_user_roles.user_id')


                    ->where('valuer_list.assigned_to_id', $userID)
                    ->where('user_general_details.active_flag', '0')
                    ->get();
            }
           



            // DB::table('valuer_list')
            //         ->select('*')
            //         // ->join('user_general_details','users.a_user_id','=','user_general_details.user_id')
            //         ->join('user_general_details','user_general_details.id','=','valuer_list.user_id')
            //         ->join('uam_user_roles','uam_user_roles.user_id','=','valuer_list.user_id')
            //         ->join('messages','messages.valuer_id','=','valuer_list.valuer_id')
            //         ->where('valuer_list.assigned_to_id', $userID)   
            //         ->get();



            else {

                $rows = array();
                $rows['details'] = DB::table('user_payment_details')
                    ->select('*')
                    ->join('user_general_details', 'user_payment_details.user_id', '=', 'user_general_details.user_id')
                    ->join('valuer_list', 'user_payment_details.user_id', '=', 'valuer_list.user_id')
                    ->where('user_payment_details.user_id', $userID)
                    ->get();
            }

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $rows;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $logMethod;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function certificate_issue(Request $request)
    {
        $logMethod = 'Method => ValuerController => User';
        try {
            $v_user_id = $request['user_id'];

            $valuer_id = DB::select("select valuer_id from valuer_list where user_id=$v_user_id");
            $valuer_id = $valuer_id[0]->valuer_id;
            $rows['rows'] = DB::select("SELECT  * from uam_user_roles INNER JOIN users on uam_user_roles.user_id=users.id where uam_user_roles.role_id=19;");
            $rows['general'] = DB::select("SELECT * from user_general_details inner join valuer_list on user_general_details.user_id=valuer_list.user_id where user_general_details.user_id=$v_user_id;");
            $rows['education'] = DB::select("SELECT * FROM user_education_dip_details where user_id=$v_user_id UNION ALL SELECT * FROM user_education_ug_details where user_id=$v_user_id UNION ALL SELECT * FROM user_education_pg_details where user_id=$v_user_id ;");
            $rows['messages'] = DB::select("select * from messages where  valuer_id=$valuer_id;");
            $rows['certification'] = DB::select("select * from user_exp_cert_details where user_id=$v_user_id;");
            $work_exp = DB::select("select wrqch from user_exp_details where user_id=$v_user_id;");
            $wrqch = $work_exp[0]->wrqch;
            if ($wrqch == "yes") {
                $rows['work_experience'] = DB::select("select * from user_exp_wrq_details where user_id=$v_user_id;");
            } else {
                $rows['work_experience'] = DB::select("select * from user_exp_wre_details where user_id=$v_user_id;");
            }
            $rows['wrqch'] = $wrqch;
            
            



            // DB::table('valuer_list')
            //         ->select('*')
            //         // ->join('user_general_details','users.a_user_id','=','user_general_details.user_id')
            //         ->join('user_general_details','user_general_details.id','=','valuer_list.user_id')
            //         ->join('uam_user_roles','uam_user_roles.user_id','=','valuer_list.user_id')
            //         ->join('messages','messages.valuer_id','=','valuer_list.valuer_id')
            //         ->where('valuer_list.assigned_to_id', $userID)   
            //         ->get();





            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $rows;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $logMethod;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $method = 'Method => UamModulesController => data_edit';
            $id = $this->decryptData($id);
            $stake_holder = DB::select("SELECT assigned_to_id FROM valuer_list WHERE user_id=$id;");
            $stake_holder_id = $stake_holder[0]->assigned_to_id;
            $rows['rows'] = DB::select("SELECT  * from uam_user_roles INNER JOIN users on uam_user_roles.user_id=users.id where uam_user_roles.role_id=19;");
            $rows['general'] = DB::select("SELECT * from user_general_details inner join valuer_list on user_general_details.user_id=valuer_list.user_id where user_general_details.user_id=$id and user_general_details.active_flag='0';");
            $rows['education'] = DB::select("SELECT * FROM user_education_dip_details where user_id=$id UNION ALL SELECT  * FROM user_education_ug_details where user_id=$id UNION ALL SELECT * FROM user_education_pg_details where user_id=$id ;");
            $rows['messages'] = DB::select("select * from messages where valuer_id=$id;");
            $rows['certification'] = DB::select("select * from user_exp_cert_details where user_id=$id;");
            $response = [
                'rows' => $rows,
            ];

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $response;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function storedata(Request $request)
    {
        try {
            $method = 'Method => General_registation => storedata';
            $inputArray = $request->requestData;
            $user_id = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];
            $valuer_code = json_encode(DB::select("select valuer_code from valuer_list"));

            if ($valuer_code == '[]') {
                $valuer_code = "VR/L/001";
            } else {
                $valuer_code = (DB::table('valuer_list')->orderBy('valuer_id', 'desc')->first());
                $valuer_code_new = $valuer_code->valuer_code;
                $valuer_code = ++$valuer_code_new;
            }
            $status = "Pending";
            $input = [
                'user_id' => $user_id,
                'valuer_code' => $valuer_code,
                'status' => $status,

            ];



            DB::transaction(function () use ($input) {
                $role_id = DB::table('valuer_list')
                    ->insertGetId([
                        'user_id' => $input['user_id'],
                        'valuer_code' => $input['valuer_code'],
                        'v_status' => $input['status'],
                        'created_at' => NOW(),

                    ]);
            });

            DB::table('user_payment_details')
                ->where('user_id', $input['user_id'])
                ->update(['requested_at' => now()]);



            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = 1;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }
    public function user_certify(Request $request)
    {
        try {
            $method = 'Method => General_registation => storedata';
            $inputArray = $request->requestData;
            $v_user_id = $inputArray['v_user_id'];
            $valuer_id = $inputArray['valuer_id'];
            $input = [
                'v_user_id' => $v_user_id,
                'valuer_id' => $valuer_id,
                'status' => "Certified",

            ];

            DB::table('valuer_list')
                ->where('user_id', $input['v_user_id'])
                ->update(['v_status' => $input['status']]);


            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = 1;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }
    public function approved_valuers(Request $request)
    {
        $logMethod = 'Method => ValuerController => User';
        try {
            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $rows = array();
            $rows['approved_valuers'] = DB::table('valuer_list')
                ->select('*')
                ->join('user_general_details', 'valuer_list.user_id', '=', 'user_general_details.user_id')
                ->join('user_payment_details', 'user_payment_details.user_id', '=', 'valuer_list.user_id')
                ->where('valuer_list.active_flag', '1')
                ->orderBy('valuer_list.v_status', 'ASC')
                ->get();


            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $rows;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $logMethod;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }
    public function approve_index(Request $request)
    {

        try {

            $userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $status = $request->status;
            
            //for valuer approve (valers list)
            if ($status != "certificate_index") {
                $user_id = $request->user_id;
                $valuer_id = $request->valuer_id;
                $v_user_id = $request->v_user_id;
                $method = 'Method => ajaxController => index';
                $role = DB::select("SELECT role_id FROM uam_user_roles where user_id=$user_id;");
                $role = $role[0]->role_id;
             
                if ($role == "19") {
                    $val = DB::select("SELECT user_id FROM valuer_list WHERE valuer_id = $valuer_id;");                 
                    $val = $val[0]->user_id;
                    $rows['general'] = DB::select("SELECT * FROM user_general_details inner join valuer_list on user_general_details.user_id=valuer_list.user_id where valuer_list.valuer_id=$valuer_id;");
                    $rows['messages'] = DB::select("SELECT * FROM messages where stakeholder_id=$user_id and valuer_id=$valuer_id;");
                    $work_exp = DB::select("select wrqch from user_exp_details where user_id=$val;");
                    $wrqch = $work_exp[0]->wrqch;
                    if ($wrqch == "yes") {              
                        $rows['work_experience'] = DB::select("select * from user_exp_wrq_details where user_id=$val;");
                    } else {
                        $rows['work_experience'] = DB::select("select * from user_exp_wre_details where user_id=$val;");
                    }
                    $rows['wrqch'] = $wrqch;

                } else {
                    $valuer_id = $request->valuer_id;
                    $v_user_id = $request->v_user_id;
                   
                   

                    $rows['rows'] = DB::select("SELECT  * from uam_user_roles INNER JOIN users on uam_user_roles.user_id=users.id where uam_user_roles.role_id=19;");
                    $rows['general'] = DB::select("SELECT * from user_general_details inner join valuer_list on user_general_details.user_id=valuer_list.user_id where user_general_details.user_id=$v_user_id and user_general_details.active_flag='0';");
                    $rows['education'] = DB::select("SELECT * FROM user_education_dip_details where user_id=$v_user_id UNION ALL SELECT  * FROM user_education_ug_details where user_id=$v_user_id UNION ALL SELECT * FROM user_education_pg_details where user_id=$v_user_id ;");
                    $rows['messages'] = DB::select("select * from messages where mlhud_id=$user_id and valuer_id=$valuer_id;");
                    $rows['certification'] = DB::select("select * from user_exp_cert_details where user_id=$v_user_id;");
                    $work_exp = DB::select("select wrqch from user_exp_details where user_id=$v_user_id;");
                    $wrqch = $work_exp[0]->wrqch;
                    if ($wrqch == "yes") {
                      
                        $rows['work_experience'] = DB::select("select * from user_exp_wrq_details where user_id=$v_user_id;");
                    } else {
                        $rows['work_experience'] = DB::select("select * from user_exp_wre_details where user_id=$v_user_id;");
                    }
                    $rows['wrqch'] = $wrqch;
                }
            }
            //for certficate index page (registration certificate) 
            else {
                
                $user_id = $request->user_id;
                $rows['general'] = DB::select("SELECT * FROM users as u INNER JOIN valuer_list as v on u.id=v.user_id where v.user_id=$user_id;");
            }

            // $response = [
            //     'rows' => $users,
            //     'general' => $generaldetails
            // ];

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $rows;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }


    public function get_stake_data(Request $request)
    {
        try {

            $id = $request->dynamiclist;
            $method = 'Method => ajaxController => index';
            $users = DB::select("SELECT email from users where id=$id");
            $response = [
                'rows' => $users

            ];
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $response;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }
    public function rating_index(Request $request)
    {
        try {
            $method = 'Method => ajaxController => index';
            $user_id = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $role = DB::select("SELECT role_id FROM uam_user_roles where user_id=$user_id;");
            $role = $role[0]->role_id;
            if ($role != "3") {
                $rows['rating_question'] = DB::select("select * from ratings_question;");

                $rows['rows1'] = DB::select("SELECT count('qans') as 'count',valuer_code,name,valuer_id,Address_line1 from valuer_list inner join users on users.id=valuer_list.user_id inner join user_rattings_qa_details on user_rattings_qa_details.user_id =valuer_list.user_id inner join user_general_details on user_general_details.user_id=valuer_list.user_id WHERE qans='yes' GROUP BY qans,name,valuer_code,valuer_id,Address_line1 ORDER BY COUNT(qans) DESC    ;");
                $rows['rows'] = DB::select("select * from users inner join valuer_list on users.id=valuer_list.user_id;");
            } else {
                $rows['rating_question'] = DB::select("select * from ratings_question;");

                $rows['rows1'] = DB::select("SELECT count('qans') as 'count',valuer_code,name,valuer_id,Address_line1 from valuer_list inner join users on users.id=valuer_list.user_id inner join user_rattings_qa_details on user_rattings_qa_details.user_id =valuer_list.user_id inner join user_general_details on user_general_details.user_id=valuer_list.user_id WHERE qans='yes' and valuer_list.user_id=$user_id GROUP BY qans,name,valuer_code,valuer_id,Address_line1;");
                $rows['rows'] = DB::select("select * from users inner join valuer_list on users.id=valuer_list.user_id where users.id=$user_id;");
            }


            // $response = [
            //     'rows' => $users,
            //     'general' => $generaldetails
            // ];

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = $rows;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }
    public function ratings_create(Request $request)
    {
        try {

            $method = 'Method => ajaxController => index';
            $user_id = (auth()->check()) ? auth()->user()->id : $request['user_id'];
            $inputArray = $request['requestData'];
            // $userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];
            $count = array();
            $count['q'] = count($inputArray['q']);
            $count['user_id'] = $inputArray['user_id'];
            $userID = $inputArray['user_id'];


            $input = [
                'q' => $inputArray['q'],
            ];

            foreach ($input as $data) {
                DB::transaction(function () use ($data) {
                    $count = count($data);
                    for ($i = 0; $i < $count; $i++) {

                        $user_id =  $data[0]['user_id'];

                        $role_id = DB::table($data[$i]['table'])
                            ->insertGetId([


                                'qid' => $data[$i]['qid'],
                                'qans' => $data[$i]['qans'],
                                'user_id' => $data[$i]['user_id'],
                                'active_flag' => 0,
                                'created_at' => NOW(),
                            ]);
                    }


                    $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
                    $role_name_fetch = $role_name[0]->role_name;
                    $this->auditLog('user_ratings_qa_details', $role_id, 'Create', 'Valuer has been Rated.', $user_id, NOW(), $role_name_fetch);
                });
            }

            //admin
            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'Valuer Rated',
                'notification_url' => 'Valuer_rating',
                'megcontent' => "Valuer has been Rated Successfully.",
                'alert_meg' => "Valuer has been Rated Successfully.",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);
            //valuer
            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => $userID,
                'notification_status' => 'Valuer Rated',
                'notification_url' => 'Valuer_rating',
                'megcontent' => "Valuer has been Rated Successfully.",
                'alert_meg' => "Valuer has been Rated Successfully.",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);







            // $response = [
            //     'rows' => $users,
            //     'general' => $generaldetails
            // ];

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = 1;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }

    public function allocation(Request $request)
    {
        try {
            $mlhud_id = (auth()->check()) ? auth()->user()->id : $request['user_id'];

            $method = 'Method => General_registation => storedata';



            $inputArray = $request->requestData;
            $stake_status = $inputArray['stake_status'];
            if ($stake_status == null) {
                $name = DB::select("select name from users where id=$mlhud_id;");
                $name = $name[0]->name;
                $user_id = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];
                $status_mlhud = "allocated";
                $status_stake_holder = "Pending";
                $input = [
                    'message' => $inputArray['message'],
                    'valuer_id' => $inputArray['valuer_id'],
                    'status_mlhud' => $status_mlhud,
                    'status_stake_holder' => $status_stake_holder,
                    'assigned_to_id' => $inputArray['stake_holder_id'],
                    'mlhud_id' => $inputArray['mlhud_id_new'],
                    'name' => 'Mlhud Staff' . '-' . $name
                ];

                DB::table('valuer_list')
                    ->where('valuer_id', $input['valuer_id'])
                    ->update(['assigned_to_id' => $input['assigned_to_id'], 'v_status' => $status_mlhud, 's_status' => $status_stake_holder]);


                DB::transaction(function () use ($input) {
                    $role_id = DB::table('messages')
                        ->insertGetId([
                            'stakeholder_id' => $input['assigned_to_id'],
                            'message' => $input['message'],
                            'created_at' => date('Y-m-d H:i:s'),
                            'valuer_id' => $input['valuer_id'],
                            'mlhud_id' => $input['mlhud_id'],
                            'name' => $input['name']

                        ]);
                });
                $notifications = DB::table('notifications')->insertGetId([
                    'user_id' => auth()->user()->id,
                    'role_id' => '19',
                    'notification_status' => 'Valuer has been allocated',
                    'notification_url' => 'valuerlist',
                    'megcontent' => "Valuer has been allocated .",
                    'alert_meg' => "Valuer has been allocated .",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);

                $notifications = DB::table('notifications')->insertGetId([
                    'user_id' => auth()->user()->id,
                    'role_id' => '1',
                    'notification_status' => 'Valuer has been allocated',
                    'notification_url' => 'valuerlist',
                    'megcontent' => "Valuer has been allocated successfully .",
                    'alert_meg' => "Valuer has been allocated successfully .",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);

                $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
                $role_name_fetch = $role_name[0]->role_name;
                $this->auditLog('valuer_list', $input['valuer_id'], 'Allocated', 'Valuer allocated Details', $user_id, NOW(), $role_name_fetch);
            } else {

                $user_id = (auth()->check()) ? auth()->user()->id : $request['user_id'];

                $name = DB::select("select name from users where id=$user_id;");
                $name = $name[0]->name;
                $stake_status = $inputArray['stake_status'];

                if ($stake_status == "mlhud") {
                    $status_mlhud = "allocated";
                    $status_stake_holder = "allocated";
                    $input = [
                        'message' => $inputArray['message'],
                        'valuer_id' => $inputArray['valuer_id'],
                        'status_mlhud' => $status_mlhud,
                        'status_stake_holder' => $status_stake_holder,
                        'name' => 'Mlhud Staff' . '-' . $name,
                        'user_id' => $user_id
                    ];

                    $valuer_id = $input['valuer_id'];
                    $mlhud_id = $input['user_id'];
                    $assigned_to_id = DB::select("SELECT stakeholder_id FROM messages WHERE MLHUD_id=$mlhud_id AND valuer_id=$valuer_id;");

                    $input['stake_holder_id'] = $assigned_to_id[0]->stakeholder_id;


                    DB::transaction(function () use ($input) {
                        $role_id = DB::table('messages')
                            ->insertGetId([
                                'stakeholder_id' => $input['stake_holder_id'],
                                'message' => $input['message'],
                                'created_at' => date('Y-m-d H:i:s'),
                                'valuer_id' => $input['valuer_id'],
                                'mlhud_id' => $input['user_id'],
                                'name' => $input['name']

                            ]);
                    });
                    DB::table('valuer_list')
                        ->where('valuer_id', $input['valuer_id'])
                        ->update(['assigned_to_id' => $input['stake_holder_id'], 'v_status' => $status_mlhud, 's_status' => $status_stake_holder]);
                } else {
                    $status_mlhud = "Reviewed";
                    $status_stake_holder = "Reviewed";
                    $input = [
                        'message' => $inputArray['message'],
                        'status_mlhud' => $status_mlhud,
                        'status_stake_holder' => $status_stake_holder,
                        'stake_doc_path' => $inputArray['stake_doc_path'],
                        'stake_doc_name' => $inputArray['stake_doc_name'],
                        'name' => 'Stake Holder' . '-' . $name,
                        'stakeholder_id' => $inputArray['stake_holder_id'],
                        'valuer_id' => $inputArray['valuer_id']
                    ];

                    $valuer_id = $input['valuer_id'];
                    $stake_holder_id = $input['stakeholder_id'];
                    $mlhud_id = DB::select("SELECT mlhud_id FROM messages WHERE stakeholder_id=$stake_holder_id AND valuer_id=$valuer_id;");
                    $input['mlhud_id'] = $mlhud_id[0]->mlhud_id;
                    DB::transaction(function () use ($input) {
                        $role_id = DB::table('messages')
                            ->insertGetId([
                                'stakeholder_id' => $input['stakeholder_id'],
                                'message' => $input['message'],
                                'created_at' => date('Y-m-d H:i:s'),
                                'valuer_id' => $input['valuer_id'],
                                'mlhud_id' => $input['mlhud_id'],
                                'name' => $input['name'],
                                'approval_doc_name' => $input['stake_doc_name'],
                                'approval_doc_path' => $input['stake_doc_path']

                            ]);
                    });
                    DB::table('valuer_list')
                        ->where('valuer_id', $input['valuer_id'])
                        ->update(['assigned_to_id' => $input['stakeholder_id'], 'v_status' => $status_mlhud, 's_status' => $status_stake_holder]);
                }
            }
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = 1;
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
            return $sendServiceResponse;
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $method;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.exception');
            $serviceResponse['Message'] = $exc->getMessage();
            $serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
            $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
            return $sendServiceResponse;
        }
    }
}
