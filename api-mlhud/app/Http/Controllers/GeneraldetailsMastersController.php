<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use SebastianBergmann\CodeCoverage\Driver\Selector;
use Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\licenseMail;

class GeneraldetailsMastersController extends BaseController

{


	/**
	 * Author: Anbukani
	 * Date: 04/06/2021
	 * Description: Get the user token based on email and password.
	 **/


	public function gdmasters_index(Request $request)
	{
		$logMethod = 'Method => GeneraldetailsMastersController => gdmasters_index';
		try {
			$userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];

			$row = DB::select("SELECT * FROM gd_district WHERE district_status =0");
			$rows = DB::select("SELECT d.district_name,d.id,C.constituency_name from gd_district as d inner join gd_constituency as c on d.id=c.district_id where constituency_status =0");
			$rows2= DB::select("SELECT c.constituency_name,c.id from gd_constituency as c  where constituency_status =0");
			$gd_village = DB::select("SELECT c.constituency_name,v.id,v.village_name from gd_constituency as c inner join gd_village as v on c.id=v.constituency_id where village_status =0");
			$gd_district = DB::select("SELECT id,district_name FROM gd_district WHERE district_status =0");
            $gd_constituency = DB::select("SELECT id,constituency_name FROM gd_constituency WHERE constituency_status =0");
			$response = [
				'rows' => $rows,
				'row' => $row,
				'gd_village' => $gd_village,
				'rows2' => $rows2,
				'gd_district' => $gd_district,
				'gd_constituency' => $gd_constituency
			];


			$serviceResponse = array();
			$serviceResponse['Code'] = config('setting.status_code.success');
			$serviceResponse['Message'] = config('setting.status_message.success');
			$serviceResponse['Data'] =  $response;
			$this->WriteFileLog($serviceResponse);
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


	public function gdmastersdistrict_store(Request $request)
	{

		try {
			$logMethod = 'Method => GeneraldetailsMastersController => gdmastersdistrict_store';
			$inputArray = $request->requestData;
			$inputArray = $this->decryptData($inputArray);

			$user_id = (auth()->check()) ? auth()->user()->id : $request['user_id'];

			$input = [
				'district_name' => $inputArray['district_name'],

			];
			DB::transaction(function () use ($input) {
				$settings_id = DB::table('gd_district')
					->insertGetId([
						'district_name' => $input['district_name'],
						'district_status' => '0',
						'created_by' => auth()->user()->id,
						'created_at' => NOW()
					]);
			});

			$task = $input['course_name'] . " district name has been added to the Masters Successfully";

			$this->notifications_insert(null, auth()->user()->id, $task, "/education_course");
			$serviceResponse = array();
			$serviceResponse['Code'] = config('setting.status_code.success');
			$serviceResponse['Message'] = config('setting.status_message.success');
			$serviceResponse['Data'] = 1;
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

	public function gdmastersconstituency_store(Request $request)
	{

		try {
			$logMethod = 'Method => GeneraldetailsMastersController => gdmasters_store';
			$inputArray = $request->requestData;
			$inputArray = $this->decryptData($inputArray);

			$user_id = (auth()->check()) ? auth()->user()->id : $request['user_id'];

			$input = [
				'constituency_name' => $inputArray['constituency_name'],
				'district_id' => $inputArray['district_id'],

			];
			DB::transaction(function () use ($input) {
				$settings_id = DB::table('gd_constituency')
					->insertGetId([
						'constituency_name' => $input['constituency_name'],
						'district_id' => $input['district_id'],
						'constituency_status' => '0',
						'created_by' => auth()->user()->id,
						'created_at' => NOW()
					]);
			});

			$task = $input['constituency_name'] . " constituency name has been added to the Masters Successfully";

			$this->notifications_insert(null, auth()->user()->id, $task, "/education_course");
			$serviceResponse = array();
			$serviceResponse['Code'] = config('setting.status_code.success');
			$serviceResponse['Message'] = config('setting.status_message.success');
			$serviceResponse['Data'] = 1;
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


	public function gdmastersvillage_store(Request $request)
	{

		try {
			$logMethod = 'Method => GeneraldetailsMastersController => gdmastersvillage_store';
			$inputArray = $request->requestData;
			$inputArray = $this->decryptData($inputArray);

			$user_id = (auth()->check()) ? auth()->user()->id : $request['user_id'];

			$input = [
				'village_name' => $inputArray['village_name'],
				'constituency_id' => $inputArray['constituency'],

			];
			DB::transaction(function () use ($input) {
				$settings_id = DB::table('gd_village')
					->insertGetId([
						'constituency_id' => $input['constituency_id'],
						'village_name' => $input['village_name'],
						'village_status' => '0',
						'created_by' => auth()->user()->id,
						'created_at' => NOW()
					]);
			});

			$task = $input['village_name'] . " village name has been added to the Masters Successfully";

			$this->notifications_insert(null, auth()->user()->id, $task, "/education_course");
			$serviceResponse = array();
			$serviceResponse['Code'] = config('setting.status_code.success');
			$serviceResponse['Message'] = config('setting.status_message.success');
			$serviceResponse['Data'] = 1;
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



	
	public function district_fetch(Request $request)
	{
        try {
            $method = 'Method => GeneraldetailsMastersController =>district_fetch';
            $userID = auth()->user()->id;
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'id' => $inputArray['id'],
                'type' => $inputArray['type'],
            ];
            $id = $input['id'];
            if ($input['type'] == "district_edit") {
                $rows = DB::select("SELECT *  from gd_district  where id =  $id");
            } else if ($input['type'] == "district_show") {
				$rows = DB::select("SELECT *  from gd_district  where id =  $id");
            } else if ($input['type'] == "shortedit") {
                $rows = DB::select("SELECT *  from elearning_questions_short_answer  where question_id =  $id");
            } else if ($input['type'] == "shortshow") {
                $rows = DB::select("SELECT *  from elearning_questions_short_answer  where question_id =  $id");
            } else if ($input['type'] == "trueedit") {
                $rows = DB::select("SELECT *  from elearning_questions_true_false  where question_id =  $id");
            } else if ($input['type'] == "trueshow") {
                $rows = DB::select("SELECT *  from elearning_questions_true_false  where question_id =  $id");
            } else if ($input['type'] == "mcqedit") {
                $rows = DB::select("SELECT *  from elearning_questions_mcq  where question_id =  $id");
            } else if ($input['type'] == "mcqshow") {
                $rows = DB::select("SELECT *  from elearning_questions_mcq  where question_id =  $id");
            } else if ($input['type'] == "quizedit") {
                $rows = DB::select("SELECT *  from elearning_practice_quiz  where quiz_id =  $id");
            } else if ($input['type'] == "quizshow") {
                $rows = DB::select("SELECT *  from elearning_practice_quiz  where quiz_id =  $id");
            }

            $response = [
                'rows' => $rows,
            ];

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] =  $response;
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

	public function district_update(Request $request)
    {

        try {
            $method = 'Method => GeneraldetailsMastersController => district_update';
            $inputArray = $this->decryptData($request->requestData);
           

            $input = [
                'district_name' => $inputArray['district_name_edit'],
                'eid' => $inputArray['eid'],

            ];

            DB::table('gd_district')
                ->where('id', $input['eid'])
                ->update([
                    'district_name' => $input['district_name'],
                    'district_status' => '0',
                    'updated_by' => auth()->user()->id,
                    'updated_at' => NOW()

                ]);

            $this->notifications_insert(null, auth()->user()->id, "District Name Updated Successfully", "/district/update");


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



	public function district_delete(Request $request)
    {
        try {
            $method = 'Method => LocalAdoptationTestController => update';
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'id' => $inputArray['id'],
                'constituency_id' => $inputArray['constituency_id'],
                'village_id' => $inputArray['village_id'],

                'tabletype' => $inputArray['tabletype'],
            ];
            $id = $input['id'];
            if ($input['tabletype'] == "district_delete") {
                DB::table('gd_district')
                    ->where('id', $input['id'])
                    ->update([

                        'district_status' => '1',

                    ]);
                $message = "District Deleted Successfully";

				$notifications = DB::table('notifications')->insertGetId([ 
					'user_id' =>  auth()->user()->id,
					'notification_status' => 'general masters',
					'notification_url' => 'general_masters',
					'megcontent' => "District Deleted Successfully",
					'alert_meg' =>  "District Deleted Successfully",
					'created_by' => auth()->user()->id,
					'created_at' => NOW()
				]);
            } else if ($input['tabletype'] == "constituency_delete") {

                DB::table('gd_constituency')
                    ->where('constituency_id', $input['constituency_id'])
                    ->update([
                        'constituency_status' => '1',
                    ]);
                $message = "Constituency Deleted Successfully";

				$notifications = DB::table('notifications')->insertGetId([ 
					'user_id' =>  auth()->user()->id,
					'notification_status' => 'general masters',
					'notification_url' => 'general_masters',
					'megcontent' => "Constituency Deleted Successfully",
					'alert_meg' =>  "Constituency Deleted Successfully",
					'created_by' => auth()->user()->id,
					'created_at' => NOW()
				]);

            }
			 else if ($input['tabletype'] == "village_delete") {

                DB::table('gd_village')
                    ->where('village_id', $input['id'])
                    ->update([
                        'village_status' => '1',
                    ]);
                $message = "Village Deleted Successfully";

				$notifications = DB::table('notifications')->insertGetId([ 
					'user_id' =>  auth()->user()->id,
					'notification_status' => 'general masters',
					'notification_url' => 'general_masters',
					'megcontent' => "Village Deleted Successfully",
					'alert_meg' =>  "Village Deleted Successfully",
					'created_by' => auth()->user()->id,
					'created_at' => NOW()
				]);
            } 
            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] = 1;
            $serviceResponse['response_message'] = $message;
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


	public function constituency_fetch(Request $request)
	{
        try {
            $method = 'Method => GeneraldetailsMastersController =>constituency_fetch';
            $userID = auth()->user()->id;
            $inputArray = $this->decryptData($request->requestData);
            $input = [
                'id' => $inputArray['id'],
                'type' => $inputArray['type'],
            ];
            $id = $input['id'];
            if ($input['type'] == "constituency_edit") {
                $rows = DB::select("SELECT gc.`*`,gd.district_name FROM gd_constituency AS gc INNER JOIN gd_district AS gd ON gc.district_id = gd.id where gc.id =  $id");
            } else if ($input['type'] == "") {
				$rows = DB::select("SELECT gc.`*`,gd.district_name FROM gd_constituency AS gc INNER JOIN gd_district AS gd ON gc.district_id = gd.id where gc.id =  $id");
            } 

            $response = [
                'rows' => $rows,
            ];

            $serviceResponse = array();
            $serviceResponse['Code'] = config('setting.status_code.success');
            $serviceResponse['Message'] = config('setting.status_message.success');
            $serviceResponse['Data'] =  $response;
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






	
}
