<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Mockery\Undefined;
use PHPUnit\Framework\Constraint\Count;
use SebastianBergmann\CodeCoverage\Driver\Selector;
use Session;
use UnderflowException;
use Illuminate\Support\Facades\Mail;
use App\Mail\FirmSendMail;
use App\Mail\FirmregistrationMail;
use Illuminate\Support\Facades\Auth;
use App\Mail\FirmapprovalMail;


class firmregistrationController extends BaseController
{


	/**
	 * Author: Anbukani
	 * Date: 04/06/2021
	 * Description: Get the user token based on email and password.
	 **/
	public function registerscreenap()
	{
		$serviceResponse = array();
		// $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.not_found'), false);
		return $serviceResponse;
	}

	public function firm_index(Request $request)
	{


		$logMethod = 'Method => firmregistrationController => User';
		try {
			$userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];

			$rows['payment'] = DB::select("SELECT * from user_payment_details inner join users on user_payment_details.user_id=users.id where user_payment_details.user_id='$userID';");
			// $rows['firm_registration'] = DB::select("SELECT * from firm_registration  where user_id='$userID';");
			$rows['firm_registration'] = DB::table('firm_registration as fr')
				->select('fr.id', 'fr.firm_name', 'fr.description', 'fr.certificate_name', 'fr.certificate_path', 'fr.location_proof', 'fr.location_proofpath', 'fr.comments', 'fr.status')
				->Where('fr.user_id', $userID)
				->first();
				$rows['firmname'] = DB::select("SELECT name FROM users WHERE id=$userID"); 
			$this->WriteFileLog($rows);
			

			// foreach ($rows['firm_registration'] as &$registration) {
			// 	$registration->partners = null;
			// }

			// if (!empty($rows['firm_registration'])) {
			// 	$firm_id = $rows['firm_registration'][0]->id;
			// 	$firmRelatedPartners = DB::select("SELECT u.id,fp.validpractisingcertificate_name,fp.validpractisingcertificate_path,fp.particulardirectorscertificate_name,fp.particulardirectorscertificate_path,fp.status FROM firm_partners as fp inner join users as u on u.id = fp.partner_id where fp.firm_id =$firm_id");
			// 	$this->WriteFileLog($firmRelatedPartners);
			// 	$rows['firm_resgistration'][0]->partners = $firmRelatedPartners[0];
			// } else {
			// 	$firmRelatedPartners = [];
			// }
			if ($rows['firm_registration']) {
				$firm_id = $rows['firm_registration']->id; 	 
				// Create a new object for firm_registration
				$parterns = DB::select("SELECT u.id,fp.validpractisingcertificate_name,fp.validpractisingcertificate_path,fp.particulardirectorscertificate_name,fp.particulardirectorscertificate_path,fp.status FROM firm_partners as fp inner join users as u on u.id = fp.partner_id where fp.firm_id = $firm_id ");
				$firmRegistrationObject[] = (object)[
					'id' => $rows['firm_registration']->id,
					'firm_name' => $rows['firm_registration']->firm_name,
					'description' => $rows['firm_registration']->description,
					'certificate_name' => $rows['firm_registration']->certificate_name,
					'certificate_path' => $rows['firm_registration']->certificate_path,
					'location_proof' => $rows['firm_registration']->location_proof,
					'location_proofpath' => $rows['firm_registration']->location_proofpath,
					'comments' => $rows['firm_registration']->comments,
					'status' => $rows['firm_registration']->status,
					'partners' => (object)[
						'partner_name' => $parterns
					]
				];

				$rows['firm_registration'] = $firmRegistrationObject;
			} else {
				$rows['firm_registration'] = [];
			}

			$rows['firm_partners'] = DB::select("SELECT users. * from users inner join uam_user_roles on users.id=user_id INNER JOIN professional_member_licence AS pl ON pl.user_id = users.id  where role_id='34';");




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



	public function firm_reg(Request $request)
	{



		try {
			$logMethod = 'Method => firmregistrationController => User';
			$inputArray = $request->requestData;
			$inputArray = $this->decryptData($inputArray);
			$user_id = (auth()->check()) ? auth()->user()->id : $request['user_id'];
			$input = [
				'user_id' => $inputArray['user_id'],
				'firm_name' => $inputArray['firm_name'],
				'description' => $inputArray['description'],
				'partner_name' => $inputArray['partner_name'],
				'certificate_name' => $inputArray['ursbn'],
				'certificate_path' => $inputArray['ursbp'],
				'locationproofn' => $inputArray['locationproofn'],
				'locationproofp' => $inputArray['locationproofp'],
				'validpractisingcertificaten' => $inputArray['validpractisingcertificaten'],
				'validpractisingcertificatep' => $inputArray['validpractisingcertificatep'],
				'particularsdirectorsn' => $inputArray['particularsdirectorsn'],
				'particularsdirectorsp' => $inputArray['particularsdirectorsp'],
				'description' => $inputArray['description'],
				'user_id' => $user_id,

			];

			if ($input) {

				DB::transaction(function () use ($input) {
					$firm_id = DB::table('firm_registration')
						->insertGetId([
							'user_id' => $input['user_id'],
							'firm_name' => $input['firm_name'],
							'description' => $input['description'],
							'certificate_name' => $input['certificate_name'],
							'certificate_path' => $input['certificate_path'],
							'location_proof' => $input['locationproofn'],
							'location_proofpath' => $input['locationproofp'],
							'status' => '0',
							'created_at' => NOW(),


						]);
					for ($i = 0; $i < Count($input['partner_name']); $i++) {
						$update_id =  DB::table('firm_partners')
							->insertGetId([
								'partner_id' => $input['partner_name'][$i],
								'firm_id' => $firm_id,
								'validpractisingcertificate_name' => $input['validpractisingcertificaten'][$i],
								'validpractisingcertificate_path' => $input['validpractisingcertificatep'],
								'particulardirectorscertificate_name' => $input['particularsdirectorsn'][$i],
								'particulardirectorscertificate_path' => $input['particularsdirectorsp'],
								'active_flag' => 0,
								'created_at' => NOW(),
							]);
$this->WriteFileLog($update_id);

					}

					$response = [
						'update_id' => $update_id,

					];

					$notifications = DB::table('notifications')->insertGetId([
						'user_id' => auth()->user()->id,
						'notification_status' => 'Firm Registration ',
						'notification_url' => 'firm_index',
						'megcontent' => "Firm has been Registered Successfully and Waiting for the CGV Approval.",
						'alert_meg' => "Firm has been Registered Successfully and Waiting for the CGV Approval.",
						'created_by' => auth()->user()->id,
						'created_at' => NOW()
					]);

					$user_id = $input['user_id'];
					$base_url = config('setting.base_url');
					$email = $this->getusermail($user_id);
					$name = $this->getusername($user_id);

					$data = array(
						'name' => $name,
						'email' => $email,
						'base_url' => $base_url

					);

					Mail::to($data['email'])->send(new FirmregistrationMail($data));


					$notifications = DB::table('notifications')->insertGetId([
						'notification_status' => 'Firm is waiting for your Approval.',
						'notification_url' => 'Firm_approval_index',
						'megcontent' => "Firm is waiting for your Approval.",
						'alert_meg' => "Firm is waiting for your Approval.",
						'created_by' => auth()->user()->id,
						'created_at' => NOW(),
						'role_id' => '23'
					]);

					$role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
					$role_name_fetch = $role_name[0]->role_name;
					$this->auditLog('firm_registration', $update_id, 'Create', 'Firm Registratin Created Successfully.', $input['user_id'], NOW(), $role_name_fetch);
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



	public function firmregisterstore(Request $request)
	{


		try {
			$method = 'Method => UamRolesController => storedata';
			$inputArray = $this->decryptData($request->requestData);
			$data['firmname'] = $request->firmname;
			$data['email'] = $request->email;
			$data['password'] = bcrypt($request->password);
			$data['password_confirmation'] = $request->password_confirmation;
			$base_url = config('setting.base_url');


			//   $data['dor'] = $request->dor;

			$input = [
				'firmname' => $inputArray['firmname'],
				'email' => $inputArray['email'],
				'password' => $inputArray['password'],
				'base_url' => $base_url


			];


			$email = $input['email'];

			$otp_check = DB::select("select * from user_otp where email = '$email' and status='verified'");
			if (json_encode($otp_check) == '[]') {




				$email_check = DB::select("select * from users where email = '$email' and active_flag='0'");

				if (json_encode($email_check) == '[]') {



					DB::transaction(function () use ($input) {
						$user_id = DB::table('users')
							->insertGetId([
								'name' => $input['firmname'],
								'firmname' => $input['firmname'],
								'email' => $input['email'],
								'password' => $input['password'],
								'designation_id' => 2,
								'active_flag' => 0,
								'created_at' => NOW(),


							]);


						//   defind role_id
						$stringuser_id = 33;
						$update_id =  DB::table('users')
							->where('id', $user_id)
							->update([
								'array_roles' => $stringuser_id,
							]);
						$user_id  =  $user_id;
						$uam_screen_id = DB::table('uam_user_roles')->insertGetId([
							'user_id' => $user_id,
							'role_id' => $stringuser_id,
							'active_flag' => 0,
							'created_by' => $user_id,
							'created_date' => NOW()

						]);



						$role_id = 33;
						$parentrow =  DB::select("select a.screen_id,a.module_screen_id,a.module_id from uam_role_screens as a where a.role_id = $role_id");
						$parentidcounting = count($parentrow);

						if ($parentrow != []) {
							for ($j = 0; $j < $parentidcounting; $j++) {
								$module_id = $parentrow[$j]->module_id;
								$screen_id = $parentrow[$j]->screen_id;
								$x = 0;
								$modulesrows =  DB::select("select * from uam_modules where module_id = $module_id");
								if ($modulesrows != []) {
									$parent_module_id = $modulesrows[$x]->parent_module_id;
									$module_name = $modulesrows[$x]->module_name;
								}

								$screenrows =  DB::select("select * from uam_screens where screen_id = $screen_id");
								if ($screenrows != []) {
									$screen_name = $screenrows[$x]->screen_name;
									$screen_url = $screenrows[$x]->screen_url;
									$route_url = $screenrows[$x]->route_url;
									$class_name = $screenrows[$x]->class_name;
									$display_order = $screenrows[$x]->display_order;
								}

								$check = DB::select("select * from uam_user_screens where module_id = $module_id and user_id = $user_id and screen_id = $screen_id ");
								$checkcount = count($check);

								if ($checkcount == '0') {
									$screen_permission_id = DB::table('uam_user_screens')->insertGetId([
										'screen_id' => $screen_id,
										'module_id' => $module_id,
										'parent_module_id' => $parent_module_id,
										'module_name' => $module_name,
										'screen_name' => $screen_name,
										'screen_url' => $screen_url,
										'route_url' => $route_url,
										'class_name' => $class_name,
										'display_order' => $display_order,
										'user_id' => $user_id,
										'active_flag' => 0,
										'created_by' => $user_id,
										'created_date' => NOW()
									]);
								} else {
								}
							};
						};



						$checking = DB::select("select a.user_screen_id,a.screen_id,a.module_id from uam_user_screens as a where  a.user_id = $user_id ");
						$checkcounting = count($checking);
						if ($checking != []) {
							for ($k = 0; $k < $checkcounting; $k++) {
								$screen_id = $checking[$k]->screen_id;
								$user_screen_id = $checking[$k]->user_screen_id;

								$permissioncheck = DB::select("select a.*,b.array_permission from uam_screen_permissions as a
								inner join uam_role_screen_permissions as b on b.screen_permission_id = a.screen_permission_id
								where a.screen_id  = '$screen_id' and b.role_id = '$role_id'");

								$permissioncheckcount = count($permissioncheck);
								for ($m = 0; $m < $permissioncheckcount; $m++) {
									$screen_permission_id = $permissioncheck[$m]->screen_permission_id;
									$permission_name = $permissioncheck[$m]->permission;
									$description = $permissioncheck[$m]->description;
									$active_flag = $permissioncheck[$m]->active_flag;
									$array_permission = $permissioncheck[$m]->array_permission;
									$role_screen_permissions_id = DB::table('uam_user_screen_permissions')->insertGetId([
										'user_screen_id' =>  $user_screen_id,
										'screen_permission_id' =>  $screen_permission_id,
										'permission' => $permission_name,
										'description' => $description,
										'active_flag' => $active_flag,
										'array_permission' => $array_permission,
										'user_id' => $user_id,
										'created_by' => $user_id,
										'created_date' => NOW()
									]);
								};
							};
						};
					});

					$base_url = config('setting.base_url');
					$email = $input['email'];
					$data = array(
						'name' => $input['firmname'],
						'email' => $input['email'],
						'base_url' => $base_url
					);
					Mail::to($input['email'])->send(new FirmSendMail($data));




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
			} else {
				$serviceResponse = array();
				$serviceResponse['Code'] = 408;
				$serviceResponse['Message'] = config('setting.status_message.Not_Verified');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.Not_Verified'), true);
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



	public function firm_approval_index(Request $request)
	{


		$logMethod = 'Method => firmregistrationController => User';
		try {
			$userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];

			$rows['firm_approval'] = DB::select("SELECT * from firm_registration where  NOT firm_registration.status = 2 order by created_at DESC");

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



	public function firm_show(Request $request)
	{

		$method = 'Method => firmregistrationController => User';
		try {

			$userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
			$id = $request->id;
			$data = DB::select("SELECT a.id as id,a.firm_name as firm_name,a.description as description,a.certificate_name as certificate_name,a.location_proof as location_proof,a.location_proofpath as location_proofpath,a.comments as comments,a.certificate_path as certificate_path,a.status as status from firm_registration as a where id='$id' ");
			$rows = DB::select("SELECT *  from firm_partners inner join firm_registration on firm_partners.firm_id = firm_registration.id inner join users on users.id=firm_partners.partner_id where firm_registration.id='$id'");


			$response = [
				'data' => $data,
				'data2' => $rows
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



	public function firm_approveupdate(Request $request)
	{

		try {

			$userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];

			$method = 'Method => firmregistrationController => storedata';
			$inputArray = $request->requestData;
			$inputArray = $this->decryptData($inputArray);


			$input = [
				'id' => $inputArray['id'],
				'messages' => $inputArray['messages']
			];


			$id = $input['id'];
			DB::transaction(function () use ($input) {
				$update_id =  DB::table('firm_registration')
					->where([['id', $input['id']]])
					->update([
						'status' => 1,
						'comments' => $input['messages']

					]);
			});

			$rows = DB::select("select * from firm_registration where id = $id");
			$gt_id = $rows[0]->user_id;
			$email = $this->getusermail($gt_id);
			$name = $this->getusername($gt_id);
			$base_url = config('setting.base_url');

			$data = array(
				'name' => $name,
				'email' => $email,
				'base_url' => $base_url
			);



			Mail::to($data['email'])->send(new FirmapprovalMail($data));



			// // sigle user
			// $this->notifications(null,auth()->user()->id,"general details","registrati","filled","filled");
			// // role base 
			// $this->notifications(27,null,"general details","registrati","filled","filled");
			// // multyiple roles

			// foreach ($rows as $key => $value) {
			// 	$this->notifications($value['user_id'],null,"general details","registrati","filled","filled");

			// 	# code...
			// }



			$users = DB::select("SELECT users.id,users.name FROM users inner join firm_registration on firm_registration.user_id = users.id where firm_registration.id= $id");
			$user_name = $users[0]->name;

			$id = $users[0]->id;



			// notification for CGV Approval for Firm to notified by firm.
			$notifications = DB::table('notifications')->insertGetId([

				'user_id' => $id,
				'notification_status' => 'Firm Registration ',
				'notification_url' => 'firm_index',
				'megcontent' => "Congratulations! Your firm Registration has been approved successfully by CGV.",
				'alert_meg' => "Congratulations! Your firm registration has been approved successfully by CGV.",
				'created_by' => auth()->user()->id,
				'created_at' => NOW(),
			]);


			$id = $input['id'];
			$users = DB::select("SELECT users.id,firm_registration.firm_name,users.name FROM users inner join firm_registration on firm_registration.user_id = users.id where firm_registration.id= $id");

			$user_name = $users[0]->firm_name;
			$id = $users[0]->id;
			$name = $user_name;

			// notification for CGV Approval for Firm to notified by cgv.
			$notifications = DB::table('notifications')->insertGetId([
				'user_id' => Auth::id(),
				'notification_status' => 'Firm Registration',
				'notification_url' => 'Firm_approval_index',
				'megcontent' => "Registration Approved Successfully For $name.",
				'alert_meg' => "Registration Approved Successfully For $name.",
				'created_by' => auth()->user()->userID,
				'created_at' => NOW(),
			]);



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




	public function firm_rejectupdate(Request $request)
	{


		try {

			$userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
			$method = 'Method => firmregistrationController => storedata';
			$inputArray = $request->requestData;
			$inputArray = $this->decryptData($inputArray);


			$input = [
				'id' => $inputArray['id'],
				'messages' => $inputArray['messages']
			];

			DB::transaction(function () use ($input) {
				$update_id =  DB::table('firm_registration')
					->where([['id', $input['id']]])
					->update([
						'status' => 2,
						'comments' => $input['messages']

					]);
			});


			$id = $input['id'];
			$users = DB::select("SELECT users.id,name FROM users inner join firm_registration on firm_registration.user_id = users.id where firm_registration.id= '$id';");
			$user_name = $users[0]->name;
			$id = $users[0]->id;

			// notication for CGV Approval for Firm.
			$notifications = DB::table('notifications')->insertGetId([
				'role_id' => config('setting.roles.Guest Role'),
				'user_id' => $id,
				'notification_status' => 'Firm Registration ',
				'notification_url' => 'firm_index',
				'megcontent' => "We regret to inform you that your firm registration has been rejected by CGV. Please refer to the rejection reason provided and make necessary amendments before resubmitting the application.",
				'alert_meg' => "We regret to inform you that your firm registration has been rejected by CGV. Please refer to the rejection reason provided and make necessary amendments before resubmitting the application.",
				'created_by' => auth()->user()->id,
				'created_at' => NOW()
			]);


			$id = $input['id'];
			$users = DB::select("SELECT users.id,firm_registration.firm_name,users.name FROM users inner join firm_registration on firm_registration.user_id = users.id where firm_registration.id= $id");

			$user_name = $users[0]->firm_name;
			$id = $users[0]->id;
			$name = $user_name . ' Firm';

			// notification for CGV Approval for Firm to notified by cgv.
			$notifications = DB::table('notifications')->insertGetId([
				'user_id' => Auth::id(),
				'notification_status' => 'Firm Registration',
				'notification_url' => 'Firm_approval_index',
				'megcontent' => "Registration Rejected Successfully For $name.",
				'alert_meg' => "Registration Rejected Successfully For $name.",
				'created_by' => auth()->user()->userID,
				'created_at' => NOW(),
			]);

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



	public function firm_registershow(Request $request)
	{
		$logMethod = 'Method => firmregistrationController => firm_registershow';

		try {

			$userID = auth()->user()->id;



			$rows['firmregister_show'] = DB::select("SELECT *  from firm_partners inner join firm_registration on firm_partners.firm_id = firm_registration.id inner join users on users.id=firm_partners.partner_id where firm_registration.user_id ='$userID';");


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

















	public function firm_registerupdate(Request $request)
	{

		try {
			$method = 'Method => firm_registation => storedata';
			$inputArray = $request->requestData;
			$userID = (auth()->check()) ? auth()->user()->id : $inputArray['user_id'];
			//not giving updated file for ursbn
			if (!isset($inputArray['ursbn'])) {

				$firm_update = DB::select("SELECT certificate_name FROM firm_registration  WHERE user_id=" . auth()->user()->id);
				$urbsn = $firm_update[0]->certificate_name;
				$inputArray['ursbn'] = $urbsn;
			}

			//not giving updated file for location_proof
			if (!isset($inputArray['locationproofn'])) {

				$firm_update = DB::select("SELECT location_proof FROM firm_registration  WHERE user_id=" . auth()->user()->id);
				$locationproofn = $firm_update[0]->location_proof;
				$inputArray['locationproofn'] = $locationproofn;
			}


			$input = [
				'firm_name' => $inputArray['firm_name'],
				'description' => $inputArray['description'],
				'partner_name' => $inputArray['partner_name'],
				'certificate_name' => $inputArray['ursbn'],
				'locationproofn' => $inputArray['locationproofn'],
				'user_id' => $inputArray['user_id']

			];


			if ($input) {

				DB::transaction(function () use ($input) {
					$firm_id = DB::table('firm_registration')
						->where([['user_id',  $input['user_id']]])
						->update([
							'user_id' => $input['user_id'],
							'firm_name' => $input['firm_name'],
							'description' => $input['description'],
							'certificate_name' => $input['certificate_name'],
							'location_proof' => $input['locationproofn'],
							'status' => '0',
							'created_at' => NOW(),


						]);


					// $update_id =  DB::table('firm_partners')
					//     ->where([['user_id',  $input['user_id']] ])
					// 	->update([
					// 		'partner_name' => $input['partner_name'],
					// 		'firm_id' => $firm_id,
					// 		'validpractisingcertificate_name' => $input['validpractisingcertificaten'],
					// 		'validpractisingcertificate_path' => $input['validpractisingcertificatep'],
					// 		'particulardirectorscertificate_name' => $input['particularsdirectorsn'],
					// 		'particulardirectorscertificate_path' => $input['particularsdirectorsp'],
					// 		'active_flag' => 0,
					// 		'created_at' => NOW(),
					// 	]);


					$response = [
						'update_id' => $firm_id,

					];


					$notifications = DB::table('notifications')->insertGetId([
						'user_id' => auth()->user()->id,
						'notification_status' => 'Firm Details Updated',
						'notification_url' => 'firm_index',
						'megcontent' => "Firm Details Updated Successfully.",
						'alert_meg' => "Firm Details Updated Successfully.",
						'created_by' => auth()->user()->id,
						'created_at' => NOW()
					]);


					$role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
					$role_name_fetch = $role_name[0]->role_name;
					$this->auditLog('firm_registration', $firm_id, 'Update', 'Update Firmregistration details', $input['user_id'], NOW(), $role_name_fetch);
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




	/**
	 * Author: Anbukani
	 * Date: 04/06/2021
	 * Description: Get the user token based on email and password.
	 **/
	public function NotFound()
	{
		$serviceResponse = array();
		$serviceResponse['Code'] = config('setting.status_code.not_found');
		$serviceResponse['Message'] = config('setting.status_message.not_found');
		$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
		$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.not_found'), false);
		return $sendServiceResponse;
	}

	/**
	 * Author: Anbukani
	 * Date: 04/06/2021
	 * Description: Testing the server status.
	 **/
	public function ServerTest()
	{
		$serviceResponse = array();
		$serviceResponse['Code'] = 200;
		$serviceResponse['Message'] = 'Server is up and running.';
		$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
		$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
		return $sendServiceResponse;
	}

	/**
	 * Author: Anbukani
	 * Date: 04/06/2021
	 * Description: Unauthenticated user.
	 **/
	public function Unauthenticated()
	{

		$serviceResponse = array();
		$serviceResponse['Code'] = config('setting.status_code.unauthenticated');
		$serviceResponse['Message'] = config('setting.status_message.unauthenticated');
		$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
		$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.unauthenticated'), false);
		return $sendServiceResponse;
	}

	//KD
	public function logout()
	{
		$userID = auth()->user()->id;
		$get_data = DB::select("SELECT  audit_id FROM login_audit WHERE user_id=" . $userID . " ORDER BY login_time DESC LIMIT 1");

		$last_id = $get_data[0]->audit_id;

		DB::table('login_audit')

			->where([['user_id', '=', auth()->user()->id], ['audit_id', '=', $last_id]])
			->update([
				'status1' => 'logout'

			]);

		$serviceResponse = array();
		$serviceResponse['Code'] = config('setting.status_code.unauthenticated');
		$serviceResponse['Message'] = config('setting.status_message.unauthenticated');
		$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
		$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
		return $sendServiceResponse;
	}
	public function user_unauthenticate(Request $request)
	{
		$inputArray = $this->decryptData($request->requestData);
		// $userID =auth()->user()->id;
		$input = [
			'user_id' => $inputArray['user_id'],

		];

		$userID = $input['user_id'];



		$get_data = DB::select("SELECT  audit_id FROM login_audit WHERE user_id=" . $userID . " ORDER BY login_time DESC LIMIT 1");

		$last_id = $get_data[0]->audit_id;



		DB::table('login_audit')

			->where([['user_id', '=', $userID], ['audit_id', '=', $last_id]])
			->update(['status1' => 'logout']);

		$serviceResponse = array();
		$serviceResponse['Code'] = config('setting.status_code.unauthenticated');
		$serviceResponse['Message'] = config('setting.status_message.unauthenticated');
		$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
		$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
		return $sendServiceResponse;
	}
	public function require_captcha(Request $request)
	{
		$inputArray = $this->decryptData($request->requestData);

		$input = [
			'email' => $inputArray['email'],
			'password' => $inputArray['password'],
		];





		// $login_audit=DB::table('mismatch_attempt_audit')
		// ->insertGetId([

		// 	'status' => 'Captcha Required',
		// 	'email'=>$input['email'],
		// 	'password'=>$input['password'],



		// ]);

		$serviceResponse = array();
		$serviceResponse['Code'] = config('setting.status_code.require_captcha');
		$serviceResponse['Message'] = config('setting.status_message.require_captcha');
		$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
		$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
		return $sendServiceResponse;
	}
	//KD



}
