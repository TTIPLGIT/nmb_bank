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

class EducationMastersController extends BaseController
{


	/**
	 * Author: Anbukani
	 * Date: 04/06/2021
	 * Description: Get the user token based on email and password.
	 **/


	public function educationcourse_index(Request $request)
	{

		$logMethod = 'Method => EducationMastersController => User';
		try {
			$userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];


			// $rows['payment_license'] = DB::select("SELECT professional_member_licence.license_number,professional_member_licence.status,users.name,professional_member_licence.amount_paid_on,professional_member_licence.amount,professional_member_licence.bank_transaction_id,professional_member_licence.method,professional_member_licence.renewal_date  from professional_member_licence inner join users on professional_member_licence.user_id=users.id where professional_member_licence.user_id='$userID';");
			// $rows['firm_license'] = DB::select("SELECT firm_name,firm_partners.partner_id FROM firm_partners inner join firm_registration ON firm_partners.firm_id = firm_registration.id INNER JOIN professional_member_licence ON professional_member_licence.user_id = firm_partners.partner_id WHERE professional_member_licence.user_id ='$id';");
			$rows = DB::select("SELECT * FROM education_course_masters WHERE active_flag=0");


			$response = [
				'rows' => $rows
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


	public function educationcourse_store(Request $request)
	{

		try {
			$logMethod = 'Method => EducationMastersController => educationcourse_store';
			$inputArray = $request->requestData;
			$inputArray = $this->decryptData($inputArray);

			$user_id = (auth()->check()) ? auth()->user()->id : $request['user_id'];

			$input = [
				'course_name' => $inputArray['course_name'],

			];
			DB::transaction(function () use ($input) {
				$settings_id = DB::table('education_course_masters')
					->insertGetId([
						'course_name' => $input['course_name'],
						'active_flag' => '0',
						'created_by' => auth()->user()->id,
						'created_at' => NOW()
					]);
			});

			$task = $input['course_name'] . " Course has been added to the Masters Successfully";

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

	public function educationcourse_edit(Request $request)
	{
		try {
			$method = 'Method => EducationMastersController =>educationcourse_edit';
			$inputArray = $request->requestData;
			$inputArray = $this->decryptData($inputArray);
			$id = $inputArray['id'];
			$row = DB::table('education_course_masters')
				->select('course_name', 'id')
				->where('id', $id)
				->get();

			$response = [
				'rows' => $row,
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
			$this->WriteFileLog($exceptionResponse);
			$serviceResponse = array();
			$serviceResponse['Code'] = config('setting.status_code.exception');
			$serviceResponse['Message'] = $exc->getMessage();
			$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
			$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
			return $sendServiceResponse;
		}
	}



	public function educationcourse_update(Request $request)
	{


		try {
			$method = 'Method => EducationMastersController => educationcourse_update';
			$inputArray = $this->decryptData($request->requestData);
			$input = [
				'course_name' => $inputArray['course_name'],
				'id' => $inputArray['id'],
			];


			DB::table('education_course_masters')
				->where('id', $input['id'])
				->update([
					'course_name' => $input['course_name'],
					'updated_by' => auth()->user()->id,
					'updated_at' => NOW()

				]);

				$notifications = DB::table('notifications')->insertGetId([
					'user_id' => auth()->user()->id,
					'notification_status' => 'CourseName Details Updated',
					'notification_url' => '/education_course',
					'megcontent' => "Course Name Updated Successfully .",
					'alert_meg' => "Course Name Updated Successfully .",
					'created_by' => auth()->user()->id,
					'created_at' => NOW()
				]);

			$this->notifications_insert(null, auth()->user()->id, "Course Name Updated Successfully", "/education_course");

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


	public function educationcourse_delete(Request $request)
	{
		$method = 'Method => EducationMastersController => education_delete';
		try {
		
			
			$inputArray = $this->decryptData($request->requestData);
			//$inputArray = $request['requestData'];
			$userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];


			$input = [
                'id' => $inputArray['id'],
            ];

			$uelid = DB::table('education_course_masters')
				->where('id', $input['id'])
				->update([
					'active_flag' => '1',

				]);


			$notifications = DB::table('notifications')->insertGetId([
				'user_id' => auth()->user()->id,
				'notification_status' => 'CourseName Details Deleted',
				'notification_url' => '/education_course',
				'megcontent' => "Course Name Deleted Successfully .",
				'alert_meg' => "Course Name Deleted Successfully .",
				'created_by' => auth()->user()->id,
				'created_at' => NOW()
			]);

			$role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
			$role_name_fetch = $role_name[0]->role_name;
			$this->auditLog('education course', $userID, 'Delete', 'Course Name Deleted Successfully', $inputArray['user_id'], NOW(), $role_name_fetch);


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
}
