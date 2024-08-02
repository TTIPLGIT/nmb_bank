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
use App\Mail\SendMail;
use App\Mail\UsersendMail;

class AuthController extends BaseController
{
	/**
	 * Author: Anbukani
	 * Date: 04/06/2021
	 * Description: Get the user token based on email and password.
	 **/
	public function register()
	{
		$method = 'Method => AuthController => register';
		try {
			$serviceResponse = array();
			// $sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.not_found'), false);
			$rows['country'] = DB::select("SELECT * FROM country WHERE drop_country='0';");
			$serviceResponse = array();
			$serviceResponse['Code'] = config('setting.status_code.success');
			$serviceResponse['Message'] = config('setting.status_message.success');
			$serviceResponse['Data'] = $rows;
			$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
			$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
			return $sendServiceResponse;
			//code...
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

	public function registerstore(Request $request)
	{

		try {
			$method = 'Method => UamRolesController => storedata';
			$inputArray = $this->decryptData($request->requestData);
			$data['name'] = $request->name;
			$data['surname'] = $request->surname;
			$data['othername'] = $request->othername;
			$data['dob'] = $request->dob;
			$data['gender_value'] = $request->gender_value;
			$data['interest'] = $request->interest;
			$data['email'] = $request->email;
			$data['country'] = $request->country;
			$data['status'] = $request->status;
			$data['Mobile_no'] = $request->Mobile_no;
			$data['password'] = bcrypt($request->password);
			$data['password_confirmation'] = $request->password_confirmation;

			//   $data['dor'] = $request->dor;

			$input = [
				'name' => $inputArray['name'],
				'surname' => $inputArray['surname'],
				'othername' => $inputArray['othername'],
				'email' => $inputArray['email'],
				'dob' => $inputArray['dob'],
				'country' => $inputArray['country'],
				'Mobile_no' => $inputArray['Mobile_no'],
				'password' => $inputArray['password'],
				'interest' => $inputArray['interest'],
				'gender_value' => $inputArray['gender_value'],

				//   'dor' => $inputArray['dor'],

			];

			$email = $input['email'];




			$otp_check = DB::select("select * from user_otp where email = '$email' and status='verified'");
			if (json_encode($otp_check) == '[]') {

				$email_check = DB::select("select * from users where email = '$email' and active_flag='0'");

				if (json_encode($email_check) == '[]') {


					DB::transaction(function () use ($input) {
						$user_id = DB::table('users')
							->insertGetId([
								'name' => $input['name'],
								'surname' => $input['surname'],
								'othername' => $input['othername'],
								'email' => $input['email'],
								'dob' => $input['dob'],
								'gender' => $input['gender_value'],
								'country' => $input['country'],
								'Mobile_no' => $input['Mobile_no'],
								'password' => $input['password'],

								'dor' => today(),
								'project_role_id' => 1,
								'array_dashboard_list' => 1,
								'designation_id' => 1,
								'role' => '1',
								'active_flag' => 0,
								'created_at' => NOW(),

							]);


						//   defind role_id
						$stringuser_id = 27;
						$update_id =  DB::table('users')
							->where('id', $user_id)
							->update([
								'array_roles' => $stringuser_id,
							]);
						$user_id  =  $user_id;
						$uam_screen_id = DB::table('uam_user_roles')->insertGetId([
							'user_id' => $user_id,
							'role_id' => $stringuser_id,
							'active_flag' => 1,
							'created_by' => $user_id,
							'created_date' => NOW()

						]);



						$user = DB::table('gt')
							->insertGetId([
								'user_id' => $user_id,
								'interest' => $input['interest'],
								'active_flag' => 2,
								'status' => 'Pending'

							]);





						$role_id = 27;
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



						$base_url = config('setting.base_url');
						$email = $input['email'];
						$data = array(
							'name' => $input['name'],
							'email' => $input['email'],
							'base_url' => $base_url
						);

						Mail::to($input['email'])->send(new SendMail($data));



						//   $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
						//       INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

						//   $role_name_fetch=$role_name[0]->role_name;
						//   $this->auditLog('email', $input['email'] , 'Create', 'Create uam role', auth()->user()->id, NOW(),'');


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


	public function registermemberstore(Request $request)
	{


		try {
			$method = 'Method => UamRolesController => storedata';
			$inputArray = $this->decryptData($request->requestData);
			$data['name'] = $request->name;
			$data['surname'] = $request->surname;
			$data['othername'] = $request->othername;
			$data['dob'] = $request->dob;
			$data['gender_value'] = $request->gender_value;
			$data['email'] = $request->email;
			$data['country'] = $request->country;
			$data['status'] = $request->status;
			$data['Mobile_no'] = $request->Mobile_no;
			$data['password'] = bcrypt($request->password);
			$data['password_confirmation'] = $request->password_confirmation;



			$input = [
				'name' => $inputArray['name'],
				'surname' => $inputArray['surname'],
				'othername' => $inputArray['othername'],
				'email' => $inputArray['email'],
				'dob' => $inputArray['dob'],
				'gender_value' => $inputArray['gender_value'],
				'country' => $inputArray['country'],
				'Mobile_no' => $inputArray['Mobile_no'],
				'password' => $inputArray['password'],

			];

			$email = $input['email'];

			$otp_check = DB::select("select * from user_otp where email = '$email' and status='verified'");
			if (json_encode($otp_check) == '[]') {




				$email_check = DB::select("select * from users where email = '$email' and active_flag='0'");

				if (json_encode($email_check) == '[]') {

					DB::transaction(function () use ($input) {
						$user_id = DB::table('users')
							->insertGetId([
								'name' => $input['name'],
								'surname' => $input['surname'],
								'othername' => $input['othername'],
								'email' => $input['email'],
								'dob' => $input['dob'],
								'gender' => $input['gender_value'],
								'country' => $input['country'],
								'Mobile_no' => $input['Mobile_no'],
								'password' => $input['password'],

								'dor' => today(),
								'project_role_id' => 1,
								'array_dashboard_list' => 1,
								'designation_id' => 2,
								'role' => '1',
								'active_flag' => 0,
								'created_at' => NOW(),

							]);


						//   defind role_id
						$stringuser_id = 35;
						$update_id =  DB::table('users')
							->where('id', $user_id)
							->update([
								'array_roles' => $stringuser_id,
							]);
						$user_id  =  $user_id;
						$uam_screen_id = DB::table('uam_user_roles')->insertGetId([
							'user_id' => $user_id,
							'role_id' => $stringuser_id,
							'active_flag' => 1,
							'created_by' => $user_id,
							'created_date' => NOW()

						]);


						$user = DB::table('gt')
							->insertGetId([
								'user_id' => $user_id,
								'active_flag' => 2,
								'status' => 'Pending'

							]);


						$role_id = 35;
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

						$base_url = config('setting.base_url');
						$email = $input['email'];
						$data = array(
							'name' => $input['name'],
							'email' => $input['email'],
							'base_url' => $base_url
						);
						Mail::to($input['email'])->send(new UsersendMail($data));




						//   $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
						//       INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

						//   $role_name_fetch=$role_name[0]->role_name;
						//   $this->auditLog('email', $input['email'] , 'Create', 'Create uam role', auth()->user()->id, NOW(),'');



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











	public function otpsend(Request $request)
	{

		try {
			$method = 'Method => UamRolesController => storedata';
			$inputArray = $this->decryptData($request->requestData);
			$data['email'] = $request->email;
			$data['otp1'] = $request->otp1;
			$data['otp2'] = $request->otp2;
			$data['otp3'] = $request->otp3;
			$data['otp4'] = $request->otp4;
			$data['otp5'] = $request->otp5;
			$data['otp6'] = $request->otp6;
			$input = [
				'email' => $inputArray['email'],
				'otp1' => $inputArray['otp1'],
				'otp2' => $inputArray['otp2'],
				'otp3' => $inputArray['otp3'],
				'otp4' => $inputArray['otp4'],
				'otp5' => $inputArray['otp5'],
				'otp6' => $inputArray['otp6'],
			];
			$email = $input['email'];
			$email_check = DB::select("select * from user_otp where email = '$email' ");
			if (json_encode($email_check) == '[]') {
				DB::transaction(function () use ($input) {
					$user_id = DB::table('user_otp')
						->insertGetId([

							'email' => $input['email'],
							'otp1' => $input['otp1'],
							'otp2' => $input['otp2'],
							'otp3' => $input['otp3'],
							'otp4' => $input['otp4'],
							'otp5' => $input['otp5'],
							'otp6' => $input['otp6'],
							'status' => "new",
							'created_time' => now(),
							'active_flag' => '0',

						]);
				});
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {
				DB::transaction(function () use ($input) {
					$user_id = DB::table('user_otp')
						->where('email', $input['email'])
						->update([
							'email' => $input['email'],
							'otp1' => $input['otp1'],
							'otp2' => $input['otp2'],
							'otp3' => $input['otp3'],
							'otp4' => $input['otp4'],
							'otp5' => $input['otp5'],
							'otp6' => $input['otp6'],
							'status' => "new",
							'created_time' => now(),
							'active_flag' => '0',
						]);
				});
				$serviceResponse = array();
				$serviceResponse['Code'] =  config('setting.status_code.success');
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
	public function otpverify(Request $request)
	{

		try {
			$method = 'Method => UamRolesController => storedata';
			$inputArray = $this->decryptData($request->requestData);
			$data['email'] = $request->email;

			$data['otp1'] = $request->otp1;
			$data['otp2'] = $request->otp2;
			$data['otp3'] = $request->otp3;
			$data['otp4'] = $request->otp4;
			$data['otp5'] = $request->otp5;
			$data['otp6'] = $request->otp6;
			$input = [

				'email' => $inputArray['email'],
				'otp1' => $inputArray['otp1'],
				'otp2' => $inputArray['otp2'],
				'otp3' => $inputArray['otp3'],
				'otp4' => $inputArray['otp4'],
				'otp5' => $inputArray['otp5'],
				'otp6' => $inputArray['otp6'],

			];

			$email = $input['email'];
			$otp1 = $input['otp1'];
			$otp2 = $input['otp2'];
			$otp3 = $input['otp3'];
			$otp4 = $input['otp4'];
			$otp5 = $input['otp5'];
			$otp6 = $input['otp6'];
			$email_check = DB::select("select * from user_otp where email = '$email' and otp1='$otp1' and otp2='$otp2' and otp3='$otp3' and otp4='$otp4' and otp5='$otp5' and otp6='$otp6' ");
			if (json_encode($email_check) != '[]') {



				DB::transaction(function () use ($input) {


					$stringuser_id = 3;
					$update_id =  DB::table('user_otp')
						->where('email', $input['email'])
						->update([
							'status' => 'verified',
						]);




					//   $role_name=DB::select("SELECT role_name FROM uam_roles AS ur
					//       INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);

					//   $role_name_fetch=$role_name[0]->role_name;
					//   $this->auditLog('email', $input['email'] , 'Create', 'Create uam role', auth()->user()->id, NOW(),'');

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
			$serviceResponse = array();
			$serviceResponse['Code'] = config('setting.status_code.exception');
			$serviceResponse['Message'] = $exc->getMessage();
			$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
			$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
			return $sendServiceResponse;
		}
	}
	public function Login(Request $request)
	{
		$user_id = (auth()->check()) ? auth()->user()->id : $request['user_id'];

		$logMethod = 'AuthController => Login';
		try {
			$input = [
				'email' => $request->email,
				'password' => $request->password,
			];

			$rules = [
				'email' => 'required|email',
				'password' => 'required',
			];

			$messages = [
				'email.required' => 'Email ID is required',
			];

			$validator = Validator::make($input, $rules, $messages);

			$email = $request->email;
			$password = $request->password;
			$this->WriteFileLog($email);
			$this->WriteFileLog($password);

			if ($validator->fails()) {
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.validation');
				$serviceResponse['Message'] = $validator->errors()->first();
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.validation'), false);
				return $sendServiceResponse;
			}
			$credentials = $request->only('email', 'password', 'active_flag');

			if (!$token = auth()->attempt(['email' => $email, 'password' => $password, 'delete_status' => '0'])) {
				// $login_audit=DB::table('mismatch_attempt_audit')
				// ->insertGetId([
				// 	'status' => 'Mismatch_Credential',
				// 	'email'=>$request->email,
				// 	'password'=>$request->password,
				// ]); 
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.unauthenticated');
				$serviceResponse['Message'] = config('setting.status_message.unauthenticated');
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.unauthenticated'), false);
				return $sendServiceResponse;
			}


			if (auth()->attempt(['email' => $email, 'password' => $password, 'active_flag' => '0'])) {
				$user = auth()->user();
				$serviceResponse = array();
				$serviceResponse['access_token'] = $token;
				$serviceResponse['token_type'] = 'Bearer';
				$serviceResponse['expires_in'] = auth()->factory()->getTTL() * 60;
				$serviceResponse['user'] = auth()->user();
			} else {

				$serviceResponse = array();
				$serviceResponse['Code'] = 500;
				$serviceResponse['Message'] = 'Not activated';
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, 500, false);
				return $sendServiceResponse;
			}



			$login_audit = DB::table('login_audit')
				->insertGetId([

					'status' => 'Login',
					'user_id' => auth()->user()->id,

				]);




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
