<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendResetMail;
use App\Mail\SendUserCreateMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth;
use Illuminate\Support\Facades\Hash;
use Mockery\Undefined;
use PhpParser\Node\Stmt\Foreach_;
use App\Mail\counselorsendMail;
use Carbon\Carbon;
use DateTime;

class RegistrationController extends BaseController
{



	public function expcreate()
	{
		$logMethod = 'Method => UserController => User';

		try {
			$userID = (auth()->check()) ? auth()->user()->id : 's';

			$serviceResponse = array();
			$serviceResponse['Code'] = config('setting.status_code.success');
			$serviceResponse['Message'] = config('setting.status_message.success');
			$serviceResponse['Data'] = $userID;
			$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
			$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
			return $sendServiceResponse;
			//return $this->SuccessResponse($rows);
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

	public function educreate()
	{
		$logMethod = 'Method => UserController => User';

		try {
			$userID = (auth()->check()) ? auth()->user()->id : 's';

			$serviceResponse = array();
			$serviceResponse['Code'] = config('setting.status_code.success');
			$serviceResponse['Message'] = config('setting.status_message.success');
			$serviceResponse['Data'] = $userID;
			$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
			$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
			return $sendServiceResponse;
			//return $this->SuccessResponse($rows);
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
	public function registerapl(Request $request)
	{


		$logMethod = 'Method => UserController => User';

		try {
			$userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
			if ($request['exist']) {
				$allow_or_not = DB::select("SELECT COUNT('id') AS count FROM gt_approve_process WHERE user_id=$userID;");
				if ($allow_or_not[0]->count == 0) {
					$genral = DB::select("SELECT COUNT('id') AS count FROM user_general_details WHERE user_id=$userID;");
					if ($genral[0]->count == 0) {
						$serviceResponse = array();
						$serviceResponse['Code'] = 400;
						$serviceResponse['Message'] = config('setting.status_message.success');
						$serviceResponse['Data'] = 'Registration.index';
						$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
						$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
						return $sendServiceResponse;
					}
					$edut = DB::select("SELECT COUNT('id') AS count FROM user_education_dip_details WHERE user_id=$userID;");
					if ($edut[0]->count == 0) {
						$serviceResponse = array();
						$serviceResponse['Code'] = 400;
						$serviceResponse['Message'] = config('setting.status_message.success');
						$serviceResponse['Data'] = 'education_index';
						$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
						$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
						return $sendServiceResponse;
					}
					$wrk = DB::select("SELECT COUNT('id') AS count FROM user_exp_wrq_details WHERE user_id=$userID;");
					if ($wrk[0]->count == 0) {
						$serviceResponse = array();
						$serviceResponse['Code'] = 400;
						$serviceResponse['Message'] = config('setting.status_message.success');
						$serviceResponse['Data'] = 'workexp_index';
						$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
						$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
						return $sendServiceResponse;
					}
				}
			}
			// $id = $this->DecryptData($request->id);
			$currentDate = Carbon::now();

			// Calculate the date 7 days ago
			$sevenDaysFromNow = $currentDate->copy()->subDays(7);
			// $userID = Auth::user();
			$rows = array();
			$rows['general'] = DB::table('user_general_details')
				->select('*')
				->where([['user_id', $userID], ['active_flag', "0"]])
				->get();

			$rows['general'] = DB::select("SELECT ugd.*,d.district_name,c.constituency_name,v.village_name from user_general_details as ugd inner join gd_district as d on ugd.district=d.id LEFT join gd_constituency as c on ugd.constituency=c.id LEFT join gd_village as v on v.id = ugd.village where active_flag=0 and user_id=$userID");

			$rows['educationstate'] = DB::table('user_education_details')
				->select('*')
				->where('user_id', $userID)
				->get();

			$rows['education_edit'] = DB::table('user_education_dip_details')
				->select('*')
				->where('user_id', $userID)
				->get();
			$rows['education']['ug'] = DB::table('user_education_details')
				->select('user_education_ug_details.*')
				->leftJoin('user_education_ug_details', 'user_education_ug_details.uedid', '=', 'user_education_details.id')
				->where('user_education_details.user_id', $userID)
				->get();
			$rows['is_change_request'] =DB::table('gt')
			->where('user_id', $userID)
			->where('active_flag', 1)
			->where('updated_at', '<=', $sevenDaysFromNow)
			->get(); 
			$rows['education']['pg'] = DB::table('user_education_details')
				->select('user_education_pg_details.*')
				->leftJoin('user_education_pg_details', 'user_education_pg_details.uedid', '=', 'user_education_details.id')
				->where('user_education_details.user_id', $userID)
				->get();

			$rows['education']['dip'] = DB::table('user_education_details')
				->select('user_education_dip_details.*')
				->leftJoin('user_education_dip_details', 'user_education_dip_details.uedid', '=', 'user_education_details.id')
				->where('user_education_details.user_id', $userID)
				->get();

			$rows['education_details_new'] = DB::select("select * From user_education_dip_details where user_id=$userID");

			$rows['Experience']['index'] = DB::table('user_exp_wrq_details')
				->select('*')
				->where('user_id', $userID,)
				->get();

			$rows['check'] = DB::table('user_exp_details')
				->select('wrqch')
				->where('user_id', $userID)
				->get();

			// supervisor counselor approval

			$rows['counselor'] = DB::table('users')
				->select('users.*')
				->Join('uam_user_roles', 'users.id', '=', 'uam_user_roles.user_id')
				->Join('professional_member_licence as pl', 'pl.user_id', '=', 'users.id')
				->where('uam_user_roles.role_id', 34)
				->where('users.active_flag', 0)
				->get();


			$rows['supervisor'] = DB::table('users')
				->select('users.*')
				->Join('uam_user_roles', 'users.id', '=', 'uam_user_roles.user_id')
				->Join('professional_member_licence as pl', 'pl.user_id', '=', 'users.id')
				->where('uam_user_roles.role_id', '34')
				->where('users.active_flag', 0)
				->get();

			$rows['counselor_edit'] = DB::select("SELECT * FROM gt_approve_process inner join users on users.id = gt_approve_process.approval_persons_id WHERE user_id=$userID AND role_id='34' and gt_approve_process.is_supervisor =2 and NOT gt_approve_process.approval_status ='Rejected' and NOT gt_approve_process.approval_status ='No Response'");
			$rows['supervisor_edit'] = DB::select("SELECT * FROM gt_approve_process inner join users on users.id = gt_approve_process.approval_persons_id WHERE user_id=$userID AND role_id='34' and gt_approve_process.is_supervisor =1 and NOT gt_approve_process.approval_status ='Rejected' and NOT gt_approve_process.approval_status ='No Response'");
			// $rows['notresponding_edit'] = DB::select("SELECT * FROM gt_approve_process inner join users on users.id = gt_approve_process.approval_persons_id WHERE user_id=$userID AND role_id='34' and is_supervisor =3 and NOT gt_approve_process.approval_status ='No Response'");



			// $rows['data2'] = DB::table('users')
			// 	->select('*')
			// 	->Join('gt_approve_process', 'users.id', '=', 'gt_approve_process.approval_persons_id')
			// 	->Join('uam_roles', 'uam_roles.role_id', '=', 'gt_approve_process.role_id')
			// 	->where('gt_approve_process.user_id', $userID)
			// 	->get();
			$rows['data2'] = DB::table('users AS u')
			->select('u.id', 'u.name', 'u.email', 'u.user_type', 'u.role_designation', 'u.gender', 'u.array_roles', 'u.created_at', 'u.designation_id', 'u.active_flag', 'u.total_cptpoints', 'gap.id', 'gap.user_id', 'gap.approval_persons_id', 'gap.approval_status', 'gap.status', 'gap.active_flag', 'gap.role_id', 'gap.is_supervisor', 'ur.role_id AS ur_role_id', 'ur.role_name')
			->join('gt_approve_process AS gap', 'u.id', '=', 'gap.approval_persons_id')
			->join('uam_roles AS ur', 'ur.role_id', '=', 'gap.role_id')
			->where('gap.user_id', '=',  $userID)
			->get();
			$rows['approve'] = DB::select("SELECT COUNT(id) FROM gt_approve_process WHERE gt_approve_process.user_id =$userID and  approval_status = 'Approved'");
			$rows['pending'] = DB::select("SELECT COUNT(id) FROM gt_approve_process WHERE gt_approve_process.user_id =$userID and  approval_status = 'Pending'");

			$rows['reject'] = DB::select("SELECT COUNT(id) FROM gt_approve_process WHERE gt_approve_process.user_id =$userID and  approval_status = 'Rejected'");
			$rows['no_response'] = DB::select("SELECT COUNT(id) FROM gt_approve_process WHERE gt_approve_process.user_id =$userID and  approval_status = 'No Response'");
			$rows['approved'] = DB::select("SELECT COUNT(id) FROM gt_approve_process WHERE gt_approve_process.user_id =$userID and  approval_status = 'approved'");

			$rows['committe'] = DB::select("SELECT COUNT(id) FROM gt WHERE gt.user_id =$userID and  status = 'Approved'");
			$rows['data3'] = DB::table('users')
				->select('users.name', 'users.email', 'users.id', 'users.profile_image', 'users.profile_path', 'uam_user_roles.active_flag')
				->join('uam_user_roles', 'uam_user_roles.user_id', '=', 'users.id')
				->where('users.id', $userID)
				->get();

			$check = json_decode($rows['check']);


			$checkyn = ($check != []) ? $check[0]->wrqch : null;



			if ($checkyn == "yes") {
				$rows['Experience']['wrq'] = DB::table('user_exp_details')
					->select('user_exp_wrq_details.*')
					->leftJoin('user_exp_wrq_details', 'user_exp_wrq_details.uexid', '=', 'user_exp_details.id')
					->where('user_exp_details.user_id', $userID)
					->get();
			} else {
				$rows['Experience']['wre'] = DB::table('user_exp_details')
					->select('user_exp_wre_details.*')
					->leftJoin('user_exp_wre_details', 'user_exp_wre_details.uexid', '=', 'user_exp_details.id')
					->where('user_exp_details.user_id', $userID)
					->get();
			}

			$rows['Experience']['cert'] = DB::table('user_exp_wrq_details')
				->select('user_exp_cert_details.*')
				->leftJoin('user_exp_cert_details', 'user_exp_cert_details.user_id', '=', 'user_exp_wrq_details.user_id')
				->where('user_exp_wrq_details.user_id', $userID)
				->get();

			$rows['Experience']['cert_count'] = DB::table('user_exp_cert_details')
				->where('user_exp_cert_details.user_id', $userID)
				->whereNotNull('user_exp_cert_details.user_id')->count();


			$rows['specialRequest'] = DB::table('supervisor_requests')
				->where('user_id', $userID)
				->get();




			$serviceResponse = array();
			$serviceResponse['Code'] = config('setting.status_code.success');
			$serviceResponse['Message'] = config('setting.status_message.success');
			$serviceResponse['Data'] = $rows;
			$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
			$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
			return $sendServiceResponse;
			//return $this->SuccessResponse($rows);
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
	public function generalstore(Request $request)
	{

		try {
			$this->WriteFileLog($request);
			$method = 'Method => General_registation => storedata';
			$inputArray = $request->requestData;
			$inputArray = $this->decryptData($inputArray);
			$this->WriteFileLog($inputArray);
			$user_id = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];

			$ninfn_extension = explode(".", $inputArray['ninfn']);
			$ninfn_extension = $ninfn_extension[1];

			$input = [
				'Address_line1' => $inputArray['Address_line1'],
				'district' => $inputArray['district'],
				'constituency' => $inputArray['constituency'],
				'village' => $inputArray['village'],
				'ninfn_format' => $ninfn_extension,
				'nin' => $inputArray['nin'],
				'ninfp' => $inputArray['ninfp'],
				'ninfn' => $inputArray['ninfn'],
				'document_type' => $inputArray['document_type'],
				'user_id' => $inputArray['user_id'],
			];
			$nin = $input['nin'];
			$nin_check = DB::select("select * from user_general_details where nin = '$nin' and active_flag = '0'");
			if (json_encode($nin_check) == '[]') {
				DB::transaction(function () use ($input) {
					$role_id = DB::table('user_general_details')
						->insertGetId([
							'Address_line1' => $input['Address_line1'],
							'district' => $input['district'],
							'constituency' => $input['constituency'],
							'village' => $input['village'],
							'ninfn_format' => $input['ninfn_format'],
							'nin' => $input['nin'],
							'user_id' => $input['user_id'],
							'ninfp' => $input['ninfp'],
							'ninfn' => $input['ninfn'],
							'document_type' => $input['document_type'],
							'active_flag' => 0,
							'created_at' => NOW(),

							]

						);



					$notifications = DB::table('notifications')->insertGetId([
						'user_id' => auth()->user()->id,
						'notification_status' => 'General Details Created',
						'notification_url' => 'Registration',
						'megcontent' => "General Details Submitted Successfully.",
						'alert_meg' => "General Details Submitted Successfully.",
						'created_by' => auth()->user()->id,
						'created_at' => NOW()
					]);

					$role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
					$role_name_fetch = $role_name[0]->role_name;
					$this->auditLog('user_general_details', $role_id, 'Create', 'Create Graduate Trainee general details', $input['user_id'], NOW(), $role_name_fetch);
				});
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');

				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {
				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			}
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
	public function generalupdate(Request $request)
	{

		try {
			$method = 'Method => General_registation => storedata';
			$inputArray = $request->requestData;

			$userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];
			$user_id = auth()->user()->id;
			$input = [
				// 'fname' => $inputArray['fname'],
				// 'lname' => $inputArray['lname'],
				// 'gender' => $inputArray['gender'],
				'Address_line1' => $inputArray['Address_line1'],
				'district' => $inputArray['district'],
				'constituency' => $inputArray['constituency'],
				'village' => $inputArray['village'],
				// 'passport' => $inputArray['passport'],
				'nin' => $inputArray['nin'],
				// 'lvc' => $inputArray['lvc'],
				'document_type' => $inputArray['document_type'],
				'ninfp' => $inputArray['ninfp'],
				'ninfn' => $inputArray['ninfn'],
				// 'ppfp' => $inputArray['ppfp'],
				// 'ppfn' => $inputArray['ppfn'],
				'user_id' => $user_id,
			];
			$email = $input['nin'];
			$email_check = DB::select("select * from user_general_details where nin = '$email' and active_flag = '0'");
			if ($email_check == [] || $email_check != []) {
				DB::transaction(function () use ($input) {
					$update_id =  DB::table('user_general_details')
						->where([['user_id',  $input['user_id'],], ['active_flag',  0,]])
						->update([
							'Address_line1' => $input['Address_line1'],
							'district' => $input['district'],
							'constituency' => $input['constituency'],
							'village' => $input['village'],
							'nin' => $input['nin'],
							'document_type' => $input['document_type'],
							'user_id' => $input['user_id'],
							'ninfp' => $input['ninfp'],
							'ninfn' => $input['ninfn'],
							'active_flag' => 0,
							'updated_at' => NOW(),
						]);

					$notifications = DB::table('notifications')->insertGetId([
						'user_id' => auth()->user()->id,
						'notification_status' => 'General Details Updated',
						'notification_url' => 'Registration',
						'megcontent' => "General Details Updated Successfully.",
						'alert_meg' => "General Details Updated Successfully.",
						'created_by' => auth()->user()->id,
						'created_at' => NOW()
					]);


					$role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
					$role_name_fetch = $role_name[0]->role_name;
					$this->auditLog('user_general_details', $update_id, 'Update', 'Updated Valuer General details', $input['user_id'], NOW(), $role_name_fetch);
				});
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {
				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			}
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
	public function storedynamic(Request $request)
	{
		try {
			$method = 'Method => General_registation => storedata';

			$inputArray = $request->requestData;
			$inputArray = $this->decryptData($inputArray);

			$user_id = (auth()->check()) ? auth()->user()->id : $request['user_id'];

			$input = [
				'graduation' => $inputArray['graduation'],
				'm_percentage' => $inputArray['m_percentage'],
				'yop' => $inputArray['yop'],
				'course_name' => $inputArray['course_name'],
				'university_name' => $inputArray['university_name'],
				'otherdocuments_name' => $inputArray['otherdocuments_name'],
				'otherdocuments_path' => $inputArray['otherdocuments_path'],
				'graduationcertifipath' => $inputArray['graduationcertifipath'],
				'graduationcertifiname' => $inputArray['graduationcertifiname'],

			];
			$graduation = $input['graduation'];
			$create_Update = DB::select("SELECT * from user_education_dip_details where active_flag=0 and user_id=$user_id and graduation='$graduation'");
			if ($create_Update == []) {
				DB::transaction(function () use ($input) {
					$settings_id = DB::table('user_education_dip_details')
						->insertGetId([
							'graduation' => $input['graduation'],
							'm_percentage' => $input['m_percentage'],
							'yop' => $input['yop'],
							'course_name' => $input['course_name'],
							'university_name' => $input['university_name'],
							'otherdocuments_name' => $input['otherdocuments_name'],
							'otherdocuments_path' => $input['otherdocuments_path'],
							'graduationcertifipath' => $input['graduationcertifipath'],
							'graduationcertifiname' => $input['graduationcertifiname'],
							'active_flag' => '0',
							'user_id' => auth()->user()->id,
							'created_by' => auth()->user()->id,
							'created_at' => NOW()
						]);
				});

				$notifications = DB::table('notifications')->insertGetId([
					'user_id' => auth()->user()->id,
					'notification_status' => 'Educational Details Created',
					'notification_url' => 'education_index',
					'megcontent' => "Educational Details Submitted Successfully.",
					'alert_meg' => "Educational Details Submitted Successfully.",
					'created_by' => auth()->user()->id,
					'created_at' => NOW()
				]);
				$message = "Education Details Submitted Successfully";
			} else {
				$id = $create_Update[0]->id;
				if ($input['graduationcertifipath'] != "") {
					DB::transaction(function () use ($input, $id) {
						DB::table('user_education_dip_details')
							->where('id', $id)
							->update([

								'graduationcertifipath' => $input['graduationcertifipath'],
								'graduationcertifiname' => $input['graduationcertifiname'],
							]);
					});
				}

				if ($input['otherdocuments_path'] != "") {
					DB::transaction(function () use ($input, $id) {
						DB::table('user_education_dip_details')
							->where('id', $id)
							->update([

								'otherdocuments_name' => $input['otherdocuments_name'],
								'otherdocuments_path' => $input['otherdocuments_path'],
							]);
					});
				}
				DB::transaction(function () use ($input, $id) {
					DB::table('user_education_dip_details')
						->where('id', $id)
						->update([
							'm_percentage' => $input['m_percentage'],
							'yop' => $input['yop'],
							'course_name' => $input['course_name'],
							'university_name' => $input['university_name']
						]);
				});

				$notifications = DB::table('notifications')->insertGetId([
					'user_id' => auth()->user()->id,
					'notification_status' => 'Educational Details Updated',
					'notification_url' => 'education_index',
					'megcontent' => "Educational Details Updated Successfully.",
					'alert_meg' => "Educational Details Updated Successfully.",
					'created_by' => auth()->user()->id,
					'created_at' => NOW()
				]);
				$message = "Education Details Updated Successfully";
			}



			$role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
			$role_name_fetch = $role_name[0]->role_name;
			$this->auditLog('user_eduaction_details', '', 'Create', 'Created Valuer Educational Details', $user_id, NOW(), $role_name_fetch);

			$serviceResponse = array();
			$serviceResponse['Code'] = config('setting.status_code.success');
			$serviceResponse['Message'] = config('setting.status_message.success');
			$serviceResponse['custom_message'] = $message;
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
	public function updatedynamic(Request $request)
	{

		try {

			$method = 'Method => General_registation => storedata';
			$inputArray = $request['requestData'];
			$userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];
			$count = array();
			$count['ug'] = ($inputArray['ug'] !== null) ? count($inputArray['ug']) : "0";
			$count['pg'] = ($inputArray['pg'] !== null) ? count($inputArray['pg']) : "0";
			$count['dip'] = ($inputArray['dip'] !== null) ? count($inputArray['dip']) : "0";
			$count['user_id'] = $inputArray['user_id'];
			$input1 = array();
			$input1['gen'][0]['table']  = 'user_education_details';
			$input1['ug'][0]['table']  = 'user_education_ug_details';
			$input1['pg'][0]['table']  = 'user_education_pg_details';
			$input1['dip'][0]['table'] = 'user_education_dip_details';
			$input1['gen'][0]['user_id']  = $inputArray['user_id'];
			$input1['ug'][0]['user_id']  = $inputArray['user_id'];
			$input1['pg'][0]['user_id']  = $inputArray['user_id'];
			$input1['dip'][0]['user_id'] = $inputArray['user_id'];
			foreach ($input1 as $data) {
				DB::transaction(function () use ($data) {
					$count = count($data);
					for ($i = 0; $i < $count; $i++) {

						$role_id = DB::table($data[$i]['table'])
							->where('user_id', $data[$i]['user_id'])
							->delete();
					}
				});
			}

			$email_check = DB::select("select * from user_education_details where user_id = '$userID' ");
			if (json_encode($email_check) == '[]') {
				$uedid = DB::table('user_education_details')
					->insertGetId([
						'ugc' => $count['ug'],
						'pgc' => $count['pg'],
						'dipc' => $count['dip'],
						'status' => 'New',
						'user_id' => $count['user_id'],
						'active_flag' => 0,
						'created_at' => NOW(),
					]);


				if ($inputArray['ug'] !== null) {

					$inputArray['ug'][0]['uedid'] = $uedid;
				}

				if ($inputArray['pg'] !== null) {
					$inputArray['pg'][0]['uedid'] = $uedid;
				}

				if ($inputArray['dip'] !== null) {
					$inputArray['dip'][0]['uedid'] = $uedid;
				}

				$input = [
					'ug' => $inputArray['ug'],
					'pg' => $inputArray['pg'],
					'dip' => $inputArray['dip'],

				];
				foreach ($input as $data) {
					DB::transaction(function () use ($data) {
						if ($count = ($data !== null) ?  count($data) : "0")
							for ($i = 0; $i < $count; $i++) {
								$uedid =  $data[0]['uedid'];
								$user_id =  $data[0]['user_id'];
								if ($data[$i]['graduation'] == U_UNDEFINED_VARIABLE) {
								}


								$role_id = DB::table($data[$i]['table'])
									->insertGetId([

										'graduation' => $data[$i]['graduation'],
										'college_name' => $data[$i]['college_name'],
										'university_name' => $data[$i]['university_name'],
										'course_name' => $data[$i]['course_name'],
										'yop' => $data[$i]['yop'],
										'm_percentage' => $data[$i]['m_percentage'],
										'cfp' => $data[$i]['cfp'],
										'cfn' => $data[$i]['cfn'],
										'gfp' => $data[$i]['gfp'],
										'gfn' => $data[$i]['gfn'],
										'user_id' => $data[$i]['user_id'],
										'uedid' => $uedid,
										'active_flag' => 0,
										'created_at' => NOW(),
									]);
								$update_id = $role_id;
							}
					});
				}

				$notifications = DB::table('notifications')->insertGetId([
					'user_id' => auth()->user()->id,
					'notification_status' => 'Educational Details Updated',
					'notification_url' => 'education_index',
					'megcontent' => "Educational Details Updated Successfully.",
					'alert_meg' => "Educational Details Updated Successfully.",
					'created_by' => auth()->user()->id,
					'created_at' => NOW()
				]);
				$role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
				$role_name_fetch = $role_name[0]->role_name;
				$this->auditLog('user_eduaction_details', $uedid, 'Update', 'Update Valuer Educational Details', $userID, NOW(), $role_name_fetch);

				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {
				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			}
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
	public function storedynamic1(Request $request)
	{

		try {

			$method = 'Method => General_registration => storedynamic1';
			$inputArray = $request['requestData'];
			$this->WriteFileLog($inputArray);
			$this->WriteFileLog(isset($input1['cert'][0]['nopb']) == 0);


			$userID = auth()->user()->id;
			$count = array();
			$count['is_experiences'] = $inputArray['is_experiences'];
			// fresher thing.
			if ($count['is_experiences'] == 0) {
				$input1 = [
					'experience' => $inputArray['experience'],
					'wrq' => $inputArray['wrq'],
					'user_id' => $userID,
					'cert' => $inputArray['cert']

				];



				$role_id = DB::table('user_exp_wrq_details')
					->insertGetId([
						'c_name' => null,
						'exp' => '0',
						'tde' => null,
						'fde' => null,
						'user_id' => $input1['user_id'],
						'designation' => null,
						'scope' =>  null,
						'active_flag' => 0,
						'created_at' => NOW(),
					]);


				if (isset($input1['cert'][0]['nopb'])) {
					if ($input1['cert'][0]['nopb'] != null) {
						foreach ($input1['cert'] as $data) {
							DB::transaction(function () use ($data) {
								$count = count($data);

								$role_id = DB::table('user_exp_cert_details')
									->insertGetId([
										'nopb' => $data['nopb'],
										'certib' => $data['ib'],
										'certfp' => $data['certfp'],
										'certfn' => $data['certfn'],
										'user_id' => $data['user_id'],
										'active_flag' => 0,
										'created_at' => NOW(),
									]);


								//   $this->auditLog('email', $input['email'] , 'Create', 'Create uam role', auth()->user()->id, NOW(),'');

							});
						}
					}
				}
				$notifications = DB::table('notifications')->insertGetId([
					'user_id' => auth()->user()->id,
					'notification_status' => 'Work Experience Details Created',
					'notification_url' => 'workexp_index',
					'megcontent' => "Work Experience Details Submitted Successfully.",
					'alert_meg' => "Work Experience Details Submitted Successfully.",
					'created_by' => auth()->user()->id,
					'created_at' => NOW()
				]);
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			}
			$this->WriteFileLog("iun");
			if ($count['is_experiences'] == "yes") {
				$count['cert'] = isset($inputArray['cert']) ? $inputArray['cert'] : null;
				$count['experience'] = $inputArray['experience'];
				$count['user_id'] = $userID;
				$count['wrq'] = $inputArray['wrq'];
			}
			$this->WriteFileLog("out");


			$notifications = DB::table('notifications')->insertGetId([
				'user_id' => auth()->user()->id,
				'notification_status' => 'Work Experience Details Created',
				'notification_url' => 'workexp_index',
				'megcontent' => "Work Experience Details Submitted Successfully.",
				'alert_meg' => "Work Experience Details Submitted Successfully.",
				'created_by' => auth()->user()->id,
				'created_at' => NOW()
			]);
			$email_check = DB::select("select * from user_exp_details where user_id = '$userID' and active_flag=0");
			if (json_encode($email_check) == '[]') {
				if ($count['is_experiences'] == "yes") {

					$input1 = [
						'experience' => $inputArray['experience'],
						'wrq' => $inputArray['wrq'],
						'user_id' => $userID,
						'cert' => isset($inputArray['cert']) ? $inputArray['cert'] : null,

					];


					foreach ($input1['wrq'] as $key => $data) {
						$this->WriteFileLog($data);
						$tde = date('d-m-Y', strtotime($data['tde_yes']));
						$fde = date('d-m-Y', strtotime($data['fde_yes']));
						$tde_date = new DateTime($data['tde_yes']);
						$fde_date = new DateTime($data['fde_yes']);
						$interval = $tde_date->diff($fde_date);
						$years_of_experience = $interval->y;
						$role_id = DB::table('user_exp_wrq_details')
							->insertGetId([
								'c_name' => $data['C_name'],
								'exp' => $years_of_experience,
								'tde' => $tde,
								'fde' => $fde,
								'user_id' => $input1['user_id'],
								'designation' => $data['designation_valuation'],
								'scope' =>  $data['scope'],
								'active_flag' => 0,
								'created_at' => NOW(),
							]);
						# code...
					}
					$this->WriteFileLog($input1['cert']);
					if (isset($input1['cert'][0]['nopb'])) {
						$this->WriteFileLog("in if");

						if ($count['cert'][0]['nopb'] != null) {
							$this->WriteFileLog("in if2");


							foreach ($input1['cert'] as $data) {
								DB::transaction(function () use ($data) {
									$count = count($data);

									$role_id = DB::table('user_exp_cert_details')
										->insertGetId([
											'nopb' => $data['nopb'],
											'certib' => $data['ib'],
											'certfp' => $data['certfp'],
											'certfn' => $data['certfn'],
											'user_id' => $data['user_id'],
											'active_flag' => 0,
											'created_at' => NOW(),
										]);


									//   $this->auditLog('email', $input['email'] , 'Create', 'Create uam role', auth()->user()->id, NOW(),'');

								});
							}
						}
					}
				}


				$user_id = "90";


				$role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
				$role_name_fetch = $role_name[0]->role_name;
				$this->auditLog('user_Experience_details', $role_id, 'Create', 'Create Valuer Experience Details', $user_id, NOW(), $role_name_fetch);


				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {
				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			}
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
	public function updatedynamicdata1(Request $request)
	{

		try {

			$method = 'Method => Experience_registation => updatedata';
			$inputArray = $request->requestData;
			$inputArray = $this->decryptData($inputArray);
			$userID = auth()->user()->id;
			$inputArray = $request->requestData;
			$inputArray = $this->decryptData($inputArray);
			$this->WriteFileLog($inputArray);
			$userID = auth()->user()->id;

			$input_wrq = $inputArray['wrq'];
			$input_certificate = $inputArray['cert'];
			$exp_id = 0;
			// Delete the Previous Data in the exp table
			DB::transaction(function () use ($userID, $input_wrq, $input_certificate) {
				if (!empty($input_wrq)) {
					DB::table('user_exp_wrq_details')
						->where('user_id', $userID)
						->delete();

					foreach ($input_wrq as $key => $data) {
						$tde = date('d-m-Y', strtotime($data['tde_yes']));
						$fde = date('d-m-Y', strtotime($data['fde_yes']));
						$tde_date = new DateTime($data['tde_yes']);
						$fde_date = new DateTime($data['fde_yes']);
						$interval = $tde_date->diff($fde_date);
						$years_of_experience = $interval->y;
						$exp_id = DB::table('user_exp_wrq_details')
							->insertGetId([
								'c_name' => $data['c_name'],
								'exp' => $years_of_experience,
								'designation' => $data['designation'],
								'tde' => $tde,
								'fde' => $fde,
								'user_id' => $userID,
								'scope' =>  $data['scope'],
								'active_flag' => 0,
								'created_at' => NOW(),
							]);
					}
				}
				if(!empty($input_certificate)){
					DB::table('user_exp_cert_details')
					->where('user_id', $userID)
					->delete();

				foreach ($input_certificate as $key => $data) {
					$exp_id = DB::table('user_exp_cert_details')
						->insertGetId([
							'nopb' => $data['nopb'],
							'certib' => $data['ib'],
							'certfp' => $data['certfp'],
							'certfn' => $data['certfn'],
							'user_id' => $userID,
							'active_flag' => 0,
							'created_at' => NOW(),
						]);
				}

				}
				$this->auditLog('user_exp_wrq_details', $exp_id, 'Update', 'Updated Graduate Trainee Experience Details', $userID, NOW(), 'GT');
				$this->notifications_insert(null, $userID, "Work Experience Details Updated Successfully", "workexp_index");
			});

			$serviceResponse = array();
			$serviceResponse['Code'] = 400;
			$serviceResponse['Message'] = config('setting.status_message.success');
			$serviceResponse['Data'] = 1;
			$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
			$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
			return $sendServiceResponse;








			$input_wrq = [
				'wrq' => $inputArray['wrq_data'],
			];
			$input_cert = $inputArray['cert'];
			$remove_previous = array();
			$remove_previous['wrq'][0]['table']  = 'user_exp_wrq_details';
			$remove_previous['wrq'][0]['user_id']  = $userID;
			$remove_previous['cert'][0]['table'] = 'user_exp_cert_details';
			$remove_previous['cert'][0]['user_id'] = $userID;
			foreach ($remove_previous as $data) {
				DB::transaction(function () use ($data) {
					$count = count($data);
					for ($i = 0; $i < $count; $i++) {


						$role_id = DB::table($data[$i]['table'])
							->where('user_id', $data[$i]['user_id'])
							->delete();
					}
				});
			}
			$email_check = DB::select("select * from user_exp_wrq_details where user_id = '$userID' ");
			if (json_encode($email_check) == '[]') {
				foreach ($input_wrq['wrq'] as $key => $count) {



					$uedid = DB::table('user_exp_wrq_details')
						->insertGetId([

							'exp' => '2',
							'c_name' => $count['c_name'],
							'designation' => $count['designation'],
							'scope' => $count['scope'],
							'fde' => $count['fde'],
							'tde' => $count['tde'],
							'user_id' => $userID,
							'active_flag' => 0,
							'created_at' => NOW(),
						]);
				}

				if ($input_cert[0]['ib'] != null) {
					foreach ($input_cert as $data) {
						DB::transaction(function () use ($data, $userID) {
							$uedid = 0;
							if (!isset($data['certfp'])) {
								$data['certfp'] = null;
							}
							if (!isset($data['certfn'])) {
								$data['certfn'] = null;
							}


							$role_id = DB::table('user_exp_cert_details')
								->insertGetId([

									'nopb' => $data['nopb'],
									'certib' => $data['ib'],
									'certfp' => $data['certfp'],
									'certfn' => $data['certfn'],
									'user_id' => $userID,
									'uexid' => $uedid,
									'active_flag' => 0,
									'created_at' => NOW(),
								]);

							//   $this->auditLog('email', $input['email'] , 'Create', 'Create uam role', auth()->user()->id, NOW(),'');

						});
					}
				}


				$notifications = DB::table('notifications')->insertGetId([
					'user_id' => auth()->user()->id,
					'notification_status' => 'Work Experience Details Updated',
					'notification_url' => 'expedit',
					'megcontent' => "Work Experience Details Updated Successfully.",
					'alert_meg' => "Work Experience Details Updated Successfully.",
					'created_by' => auth()->user()->id,
					'created_at' => NOW()
				]);
				$this->auditLog('user_Experience_details', '3', 'Update', 'Update Graduate Trainee Experience Details', $userID, NOW(), '');

				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {
				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			}
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
	public function storeeqans(Request $request)
	{


		try {
			$method = 'Method => Approve_process => storedata';
			$inputArray = $request->requestData;

			$userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];
			$input = [
				'user_id' => $inputArray['user_id'],
				'approval_persons_id' => $inputArray['approval_persons_id'],
				'approval_status' => "Pending",
				'status' => $inputArray['status'],
				'created_at' => NOW(),


			];
			$array_length = count($input['approval_persons_id']);

			$data = array();
			$role_id = array();
			for ($i = 0; $i < $array_length; $i++) {

				$id = $input['approval_persons_id'][$i];
				$role = DB::select("SELECT uam_roles.role_id from uam_user_roles inner join uam_roles on uam_user_roles.role_id = uam_roles.role_id where uam_user_roles.user_id = $id");
				$role_id = $role[0]->role_id;
				$data['approval_persons_id'][$i] = $input['approval_persons_id'][$i];
				$data['user_id'][$i] = $input['user_id'];
				$data['status'][$i] = $input['status'];
				$data['role_id'][$i] = $role_id;
				$data['approval_staus'][$i] = $input['approval_status'];
			}

			for ($i = 0; $i < 2; $i++) {
				$this->WriteFileLog('saranya');
				$update_id =  DB::table('gt_approve_process')
				
					->insertGetId([
						'approval_persons_id' => $data['approval_persons_id'][$i],
						'user_id' => $data['user_id'][$i],
						'approval_status' => "Pending",
						'is_supervisor' => $i==0?2:1,
						'status' => $data['status'][$i],
						'role_id' => $data['role_id'][$i],
						'active_flag' => 0,
						'created_at' => NOW(),
					]);
				$this->WriteFileLog($update_id);
				$approve_supervisor_id = $data['approval_persons_id'][$i];

				$userID = $data['user_id'][$i];
				$users = DB::select("SELECT name FROM users where id= '$userID';");
				$user_name = $users[0]->name;
				$name = $user_name . '(GT)';
				$this->WriteFileLog($name);

				$approval_persons_id = $data['approval_persons_id'][$i];
				$this->WriteFileLog($approval_persons_id);

				$notifications = DB::table('notifications')->insertGetId([

					'user_id' => $approval_persons_id,
					'notification_status' => 'Counselor/Supervisor Selected ',
					'notification_url' => 'gtapprove',
					'megcontent' => "$name is awaiting for your approval",
					'alert_meg' => "$name is awaiting for your approval",
					'created_by' => auth()->user()->id,
					'created_at' => NOW()
				]);
			}

			$userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];
			$users = DB::select("SELECT name FROM users where id= '$userID';");
			$user_name = $users[0]->name;
			$name = $user_name . '(GT)';

			$notifications = DB::table('notifications')->insertGetId([

				'user_id' => $userID,
				'notification_status' => 'Counselor/Supervisor Selected ',
				'notification_url' => 'approvalprocess_index',
				'megcontent' => "Dear $name you has been selected the Counsellor/supervisor successfully.",
				'alert_meg' => "Dear $name you has been selected the Counsellor/supervisor successfully.",
				'created_by' => auth()->user()->id,
				'created_at' => NOW()
			]);


			$role_name = DB::select("SELECT role_name,ur.role_id as role_id FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);

			$role_name_fetch = $role_name[0]->role_name;
			$role_id_fetch = $role_name[0]->role_id;
			$this->auditLog('gt_approve_process', $role_id_fetch, 'Create', 'Create Counselor/Supervisor Details', $input['user_id'], NOW(), $role_name_fetch);

			$array_length = count($input['approval_persons_id']);

			$users_GT = DB::SELECT("SELECT name,email from users where id=$userID");
			$gt_name = $users_GT[0]->name;
			for ($i = 0; $i < $array_length; $i++) {
				$user_id = $input['approval_persons_id'][$i];
				$users = DB::SELECT("SELECT name,email from users where id=$user_id");
				$email = $users[0]->email;
				$name = $users[0]->name;
				$base_url = config('setting.base_url') . '?exlink="/gtapprove"';
				$data = array(
					'name' => $name,
					'email' => $email,
					'user_name' => $gt_name,
					'base_url' => $base_url
				);

				Mail::to($email)->send(new counselorsendMail($data));

				# code...
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
			$this->WriteFileLog($exceptionResponse);
			$serviceResponse = array();
			$serviceResponse['Code'] = config('setting.status_code.exception');
			$serviceResponse['Message'] = $exc->getMessage();
			$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
			$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
			return $sendServiceResponse;
		}
	}
	public function updateeqans(Request $request)
	{
		try {

			$method = 'Method => General_registation => storedata';
			$inputArray = $request['requestData'];
			$userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];

			$count = array();
			$count['q'] = count($inputArray['q']);
			$count['user_id'] = $inputArray['user_id'];
			$email_check = DB::select("select * from user_eligible_details where user_id = '$userID' and active_flag='1' ");
			if (json_encode($email_check) == '[]') {
				$uelid = DB::table('user_eligible_details')
					->where('user_id', $userID)
					->update([
						'qc' => $count['q'],
						'status' => 'New',
						'user_id' => $userID,

						'created_at' => NOW(),
					]);
				$inputArray['q'][0]['user_id'] = $userID;

				$input = [
					'q' => $inputArray['q'],
				];

				foreach ($input as $data) {
					DB::transaction(function () use ($data) {
						$count = count($data);
						for ($i = 0; $i < $count; $i++) {
							$user_id =  $data[0]['user_id'];

							$update_id =  DB::table($data[$i]['table'])
								->where([['user_id', $user_id], ['qid', $data[$i]['qid']]])
								->update([
									'qans' => $data[$i]['qans'],
									'updated_at' => NOW(),
								]);
						}


						$notifications = DB::table('notifications')->insertGetId([
							'user_id' => auth()->user()->id,
							'notification_status' => 'Eligibility Criteria Updated',
							'notification_url' => 'Registration',
							'megcontent' => "Eligibility Criteria Updated Successfully.",
							'alert_meg' => "Eligibility Criteria Updated Successfully.",
							'created_by' => auth()->user()->id,
							'created_at' => NOW()
						]);

						$role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
						$role_name_fetch = $role_name[0]->role_name;
						$this->auditLog('user_eligible_qa_details', $update_id, 'Update', 'Update Valuer Eligible criteria Details', $user_id, NOW(), $role_name_fetch);
					});
				}
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {
				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			}
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
	public function deleteeqans(Request $request)
	{

		try {

			$method = 'Method => General_registation => deletedata';
			$inputArray = $request['requestData'];
			$userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];


			$count['user_id'] = $inputArray['user_id'];
			$email_check = DB::select("select * from user_eligible_details where user_id = '$userID' and active_flag='0' ");
			if (json_encode($email_check) != '[]') {
				$uelid = DB::table('user_eligible_details')
					->where('user_id', $userID)
					->update([
						'active_flag' => '1',
						'updated_at' => NOW(),
					]);
				$inputArray['q'][0]['user_id'] = $userID;

				$input = [
					'q' => $inputArray['q'],
				];

				foreach ($input as $data) {
					DB::transaction(function () use ($data) {
						$count = count($data);
						for ($i = 0; $i < $count; $i++) {
							$user_id =  $data[0]['user_id'];
							$update_id =  DB::table($data[$i]['table'])
								->where('user_id', $user_id)
								->update([
									'active_flag' => "1",
									'updated_at' => NOW(),
								]);


							$notifications = DB::table('notifications')->insertGetId([
								'user_id' => auth()->user()->id,
								'notification_status' => 'Eligibility Criteria Deleted',
								'notification_url' => 'Registration',
								'megcontent' => "Eligibility Criteria deleted Successfully.",
								'alert_meg' => "Eligibility Criteria deleted Successfully.",
								'created_by' => auth()->user()->id,
								'created_at' => NOW()

							]);
						}

						$role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
						$role_name_fetch = $role_name[0]->role_name;
						$this->auditLog('user_eligible_qa_details', $user_id, 'Delete', 'Delete Valuer Eligiblity Criteria Details', ['user_id'], NOW(), $role_name_fetch);


						//   $this->auditLog('email', $input['email'] , 'Create', 'Create uam role', auth()->user()->id, NOW(),'');

					});
				}
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {
				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			}
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
	public function deletegen(Request $request)
	{


		try {

			$method = 'Method => General_registation => storedata';
			$inputArray = $request['requestData'];
			$userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];


			$count['user_id'] = $inputArray['user_id'];
			$email_check = DB::select("select * from user_general_details where user_id = '$userID' and active_flag='0' ");
			if (json_encode($email_check) != '[]') {
				$uelid = DB::table('user_general_details')
					->where('user_id', $userID)
					->update([
						'active_flag' => '1',
						'updated_at' => NOW(),
					]);



				$notifications = DB::table('notifications')->insertGetId([
					'user_id' => auth()->user()->id,
					'notification_status' => 'General Details Deleted',
					'notification_url' => 'Registration',
					'megcontent' => "General details Deleted Successfully .",
					'alert_meg' => "General details Deleted Successfully .",
					'created_by' => auth()->user()->id,
					'created_at' => NOW()
				]);

				$role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
				$role_name_fetch = $role_name[0]->role_name;
				$this->auditLog('user_general_details', $userID, 'Delete', 'Delete Graduation Trainee general details', $inputArray['user_id'], NOW(), $role_name_fetch);


				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {
				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			}
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
	public function deleteexp(Request $request)
	{

		try {

			$method = 'Method => General_registation => storedata';
			$inputArray = $request['requestData'];
			$userID = auth()->user()->id;


			$count['id'] = $inputArray['id'];
			$email_check = DB::select("SELECT * from user_exp_wrq_details where user_id = '$userID' and active_flag='0' ");
			if (json_encode($email_check) != '[]') {
				$uelid = DB::table('user_exp_details')
					->where('id', $count['id'])
					->delete();
				$uelid = DB::table('user_exp_wrq_details')
					->where('id', $count['id'])
					->delete();
				$notifications = DB::table('notifications')->insertGetId([
					'user_id' => auth()->user()->id,
					'notification_status' => 'Work experience Deleted',
					'notification_url' => 'workexp_index',
					'megcontent' => "Work experience Details Deleted Successfully .",
					'alert_meg' => "Work experience Details Deleted Successfully .",
					'created_by' => auth()->user()->id,
					'created_at' => NOW()
				]);
				$role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
				$role_name_fetch = $role_name[0]->role_name;
				$this->auditLog('user_Experience_details', $userID, 'Delete', 'Delete Valuer Experience Details', $userID, NOW(), $role_name_fetch);


				$inputArray['we']['cert'][0]['user_id'] = $userID;
				$inputArray['we']['wrq'][0]['user_id'] = $userID;

				$input = [
					'cert' => $inputArray['we']['cert'],
					'wrq' => $inputArray['we']['wrq'],
				];

				foreach ($input as $data) {
					DB::transaction(function () use ($data) {
						$count = count($data);
						for ($i = 0; $i < $count; $i++) {
							$user_id =  $data[0]['user_id'];
							$update_id =  DB::table($data[$i]['table'])
								->where('user_id', $user_id)
								->delete();
						}
					});
				}
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {
				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			}
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
	public function deleteedu(Request $request)
	{
		try {


			$method = 'Method => General_registation => storedata';
			$inputArray = $request['requestData'];
			$userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];

			$count['user_id'] = $inputArray['user_id'];
			// $email_check = DB::select("select * from user_education_details where user_id = '$userID' and active_flag='0' ");

			// if (json_encode($email_check) != '[]') {


			$input = [
				'table' => $inputArray['table'],
				'graduation' => $inputArray['graduation'],
				'user_id' => $userID
			];




			$notifications = DB::table('notifications')->insertGetId([
				'user_id' => auth()->user()->id,
				'notification_status' => 'Education Details Deleted',
				'notification_url' => 'education_index',
				'megcontent' => "Educational details Deleted Successfully .",
				'alert_meg' => "Educational detais Deleted Successfully .",
				'created_by' => auth()->user()->id,
				'created_at' => NOW()
			]);

			DB::transaction(function () use ($input) {
				$update_id =  DB::table($input['table'])
					->where('user_id', $input['user_id'])
					->where('graduation', $input['graduation'])
					->delete();
			});

			$role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
			$role_name_fetch = $role_name[0]->role_name;
			$this->auditLog('user_eduaction_details', $userID, 'Delete', 'Delete Valuer Educational Details', ['user_id'], NOW(), $role_name_fetch);

			$serviceResponse = array();
			$serviceResponse['Code'] = config('setting.status_code.success');
			$serviceResponse['Message'] = config('setting.status_message.success');
			$serviceResponse['Data'] = 1;
			$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
			$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
			return $sendServiceResponse;
			// }
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

	public function approvenrvstore(Request $request)
	{



		try {
			$logMethod = 'Method => RegistrationController => approvenrvstore';
			$inputArray = $request->requestData;
			$inputArray = $this->decryptData($inputArray);

			$user_id = auth()->user()->id;


			$input = [
				'user_id' => $user_id,
				'file_name' => $inputArray['approvedcertificateproofn'],
				'file_path' => $inputArray['approvedcertificateproofp'],

			];

			if ($input) {

				DB::transaction(function () use ($input) {
					$firm_id = DB::table('approved_certificate')
						->insertGetId([
							'user_id' => $input['user_id'],
							'file_name' => $input['file_name'],
							'file_path' => $input['file_path'],
							'active_flag' => '0',
							'created_at' => NOW(),


						]);



					$notifications = DB::table('notifications')->insertGetId([
						'user_id' => auth()->user()->id,
						'notification_status' => 'approve_nrv ',
						'notification_url' => 'approve_nrv',
						'megcontent' => "Approved file submitted Successfully.",
						'alert_meg' => " Approved file submitted Successfully.",
						'created_by' => auth()->user()->id,
						'created_at' => NOW()
					]);

					$userID = (auth()->check()) ? auth()->user()->id : ['user_id'];
					$users = DB::select("SELECT name FROM users where id= '$userID';");
					$user_name = $users[0]->name;
					$name = $user_name . '(NRV)';

					$notifications = DB::table('notifications')->insertGetId([
						'role_id' => config('setting.roles.registrar'),
						'notification_status' => 'NRV Approve',
						'notification_url' => 'nrv_approval',
						'megcontent' => "$name Waiting for your Approval.",
						'alert_meg' => "$name Waiting for your Approval.",
						'created_by' => auth()->user()->id,
						'created_at' => NOW()
					]);

					//  $this->auditLog('user_general_details', $role_id, 'Create', 'Create Valuer general details', $input['user_id'], NOW(), '');
				});


				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			}
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

	public function approvenrv_index(Request $request)

	{


		$logMethod = 'Method => RegistrationController => Index';
		try {
			$userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];

			$rows['approved_certificate'] = DB::select("SELECT user_id,file_name,status,comments,file_path from approved_certificate where user_id = $userID");



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

	public function approvenrv_update(Request $request)
	{

		try {
			$method = 'Method => RegistrationController => approvenrv_update';
			$id = $request->id;


			$rows = DB::select("select * from approved_certificate where user_id = '$id' ");


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

	public function update_store(Request $request)
	{

		try {
			$method = 'Method => RegistrationController => update_store';
			$inputArray = $request->requestData;
			$inputArray = $this->decryptData($inputArray);



			$userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];


			$input = [
				'user_id' => $userID,
				'file_name' => $inputArray['approvedcertificateproofn'],
				'file_path' => $inputArray['approvedcertificateproofp'],

			];
			DB::transaction(function () use ($input) {
				DB::table('approved_certificate')
					->where('user_id', $input['user_id'])
					->update([
						'file_name' => $input['file_name'],
						'file_path' => $input['file_path'],
						'active_flag' => '1',
						'status' => '0',
						'updated_at' => NOW()
					]);
			});




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

	public function nrustore(Request $request)
	{
		$this->WriteFileLog($request);
		try {

			$method = 'Method => General_registration => storedynamic1';
			$inputArray = $request['requestData'];
			$userID = auth()->user()->id;
			$count = array();
			$count['cert'] = $inputArray['cert'];
			$count['experience'] = $inputArray['experience'];
			$count['user_id'] = $userID;
			$count['wrq'] = $inputArray['wrq'];


			$email_check = DB::select("select * from user_exp_details where user_id = '$userID' ");
			if (json_encode($email_check) == '[]') {

				$input1 = [
					'experience' => $inputArray['experience'],
					'wrq' => $inputArray['wrq'],
					'user_id' => $userID,
					'cert' => $inputArray['cert'],

				];


				foreach ($input1['wrq'] as $key => $data) {
					$tde = date('Y-m-d', strtotime($data['tde_yes']));
					$fde = date('Y-m-d', strtotime($data['fde_yes']));
					$role_id = DB::table('user_exp_wrq_details')
						->insertGetId([
							'c_name' => $data['C_name'],
							'exp' => $input1['experience'],
							'tde' => $tde,
							'fde' => $fde,
							'user_id' => $input1['user_id'],
							'designation' => $data['designation_valuation'],
							'scope' =>  $data['scope'],
							'active_flag' => 0,
							'created_at' => NOW(),
						]);
					# code...
				}
				if ($count['cert'][0]['nopb'] != null) {

					foreach ($input1['cert'] as $data) {
						DB::transaction(function () use ($data) {
							$count = count($data);

							$role_id = DB::table($data['table'])
								->insertGetId([
									'nopb' => $data['nopb'],
									'certib' => $data['ib'],
									'certfp' => $data['certfp'],
									'certfn' => $data['certfn'],
									'user_id' => $data['user_id'],
									'active_flag' => 0,
									'created_at' => NOW(),
								]);


							//   $this->auditLog('email', $input['email'] , 'Create', 'Create uam role', auth()->user()->id, NOW(),'');

						});
					}
				}

				$notifications = DB::table('notifications')->insertGetId([
					'user_id' => auth()->user()->id,
					'notification_status' => 'NRU Work Experience Details Created',
					'notification_url' => 'workexp_index',
					'megcontent' => "NRU Work Experience Details Saved Successfully.",
					'alert_meg' => "NRU Work Experience Details Saved Successfully.",
					'created_by' => auth()->user()->id,
					'created_at' => NOW()
				]);
				$user_id = "90";


				$role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
				$role_name_fetch = $role_name[0]->role_name;
				$this->auditLog('user_Experience_details', $role_name_fetch, 'Create', 'Create Valuer Experience Details', $user_id, NOW(), $role_name_fetch);


				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {
				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			}
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

	public function gddistrict_list(Request $request)
	{


		try {
			$logMethod = 'Method => RegistrationController => gddistrict_list';

			$user_id = (auth()->check()) ? auth()->user()->id : $request['user_id'];

			$rows = DB::select("SELECT * From gd_district where district_status=0");



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

	public function gdconstituency_list(Request $request)
	{


		try {
			$logMethod = 'Method => RegistrationController => gdconstituency_list';

			$user_id = (auth()->check()) ? auth()->user()->id : $request['user_id'];
			$inputArray = $this->decryptData($request->requestData);


			$input = [
				'district_id' => $inputArray['district_id'],

			];
			$district_id = $input['district_id'];

			$rows = DB::select("SELECT * FROM gd_constituency WHERE constituency_status = 0 AND district_id = $district_id");

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

	public function gdvillage_list(Request $request)
	{


		try {
			$logMethod = 'Method => RegistrationController => gdconstituency_list';

			$user_id = (auth()->check()) ? auth()->user()->id : $request['user_id'];
			$inputArray = $this->decryptData($request->requestData);


			$input = [
				'constituency_id' => $inputArray['constituency_id'],

			];
			$constituency_id = $input['constituency_id'];


			$rows = DB::select("SELECT * FROM gd_village WHERE village_status = 0 AND constituency_id = $constituency_id");

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


	public function coursename_list(Request $request)
	{


		try {
			$logMethod = 'Method => RegistrationController => course_list';

			$user_id = (auth()->check()) ? auth()->user()->id : $request['user_id'];

			$educations = DB::select("SELECT * FROM user_education_dip_details where user_id = $user_id");

			$dip = 0;
			$ug = 0;
			$pg = 0;

			foreach ($educations as $row) {
				if ($row->graduation == "Diploma") {
					$dip = 1;
				}
				if ($row->graduation == "Under Graduation") {
					$ug = 1;
				}
				if ($row->graduation == "Post Graduation") {
					$pg = 1;
				}
			}
			$rows['ug'] = $ug;
			$rows['dip'] = $dip;
			$rows['pg'] = $pg;

			$rows['data'] = DB::select("SELECT * From education_course_masters where active_flag=0");


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

	public function district_edit(Request $request)
	{


		try {
			$logMethod = 'Method => RegistrationController => district_edit';

			$user_id = (auth()->check()) ? auth()->user()->id : $request['user_id'];

			$rows = DB::select("SELECT * From gd_district where district_status=0");

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


	public function education_edit(Request $request)
	{


		try {
			$logMethod = 'Method => RegistrationController => education_edit';

			$user_id = (auth()->check()) ? auth()->user()->id : $request['user_id'];

			$rows['education_edit'] = DB::select("SELECT * FROM user_education_dip_details where user_id = $user_id");
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
}
