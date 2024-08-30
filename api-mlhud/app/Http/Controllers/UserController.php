<?php

namespace App\Http\Controllers;

use App\Mail\newUserMail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendResetMail;
use App\Mail\SendUserCreateMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Mockery\Undefined;

class UserController extends BaseController
{

	public function dummy_checking_data(Request $request)
	{

		try {
			$method = 'Method => DesignationController => checking_data';
			$inputArray = $this->decryptData($request->requestData);

			// role checking

			if ($inputArray['checking'] == 1) {

				$role_id = $inputArray['screen_role_id'];

				$role_check =  DB::select("select * from uam_roles where role_id = $role_id and active_flag = 0");

				if ($role_check != []) {
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
			}

			// project role checking



			if ($inputArray['checking'] == 2) {

				$project_role_id = $inputArray['project_role_id'];

				$role_check =  DB::select("select * from project_roles where project_role_id = $project_role_id and active_flag = 1");

				if ($role_check != []) {
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
			}



			// designation checking


			if ($inputArray['checking'] == 3) {

				$designation_id = $inputArray['designation_id'];

				$role_check =  DB::select("select * from designation where designation_id = $designation_id and active_flag = 0");

				if ($role_check != []) {
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
			}

			// department checking

			if ($inputArray['checking'] == 4) {

				$parent_department = config('setting.parent_department');

				$role_check =  DB::select("SELECT * FROM document_folder_structures WHERE parent_document_folder_structure_id Not IN  ($parent_department) AND active_flag = 1
				 AND  document_folder_structure_id =  $department_id");




				if ($role_check != []) {
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
			}


			if ($inputArray['checking'] == 5) {

				$email = $inputArray['email'];

				$role_check =  DB::select("SELECT * FROM users WHERE email = '$email' ");

				if ($role_check == []) {
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
			}


			if ($inputArray['checking'] == 6) {

				$email = $inputArray['email'];

				$role_check =  DB::select("SELECT * FROM users_dummy WHERE email = '$email' ");
				$checkcounting = count($role_check);
				if ($checkcounting > 1) {

					$serviceResponse = array();
					$serviceResponse['Code'] = 400;
					$serviceResponse['Message'] = config('setting.status_message.success');
					$serviceResponse['Data'] = 1;
					$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
					$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
					return $sendServiceResponse;
				} else {
					$serviceResponse = array();
					$serviceResponse['Code'] = config('setting.status_code.success');
					$serviceResponse['Message'] = config('setting.status_message.success');
					$serviceResponse['Data'] = 1;
					$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
					$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
					return $sendServiceResponse;
				}
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


	public function register(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'email' => 'required|email',
			'password' => 'required',
			'c_password' => 'required|same:password',
			'user_type' => 'required'
		]);
		if ($validator->fails()) {
			return response()->json(['error' => $validator->errors()], 401);
		}
		$input = $request->all();
		$input['password'] = bcrypt($input['password']);
		$user = User::create($input);
		$success['token'] =  $user->createToken('MyApp')->accessToken;
		$success['name'] =  $user->name;
		return response()->json(['success' => $success]);
	}

	public function User()
	{
		$logMethod = 'Method => UserController => User';

		try {
			$userID = auth()->user()->id;
			$role_data = DB::table('uam_user_roles')->select('uam_user_roles.role_id', 'uam_user_roles.active_flag', 'uam_roles.alter_name')
				->join('uam_roles', 'uam_roles.role_id', '=', 'uam_user_roles.role_id')
				->where('uam_user_roles.user_id', $userID)
				->get();

			$role = $role_data[0]->role_id;
			$active = $role_data[0]->active_flag;
			$gd_status = $role_data[0]->active_flag;
			$alter_name = $role_data[0]->alter_name;




			$rows = DB::table('users')
				->select('id', 'name', 'email', 'user_type')
				->where('id', $userID)
				->get();



			$serviceResponse = array();
			$serviceResponse['Code'] = config('setting.status_code.success');
			$serviceResponse['Message'] = config('setting.status_message.success');
			$serviceResponse['Data'] = $rows;
			$serviceResponse['Role'] = $role;
			$serviceResponse['active'] = $active;
			$serviceResponse['gd_status'] = $gd_status;
			$serviceResponse['alter_name'] = $alter_name;


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

	public function get_user_list()
	{
		$logMethod = 'Method => UserController => get_user_list';

		try {

			$rows = DB::select('select a.name,a.id,a.email,c.designation_name,a.active_flag,a.role_designation from users as a 
			inner join designation as c on c.designation_id =  a.designation_id where a.delete_status = 0');

			$response = [
				'rows' => $rows
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





	public function department_list()
	{
		$logMethod = 'Method => UserController => department_list';
		try {
			$parent_department = config('setting.parent_department');
			$rows = DB::select("SELECT * FROM document_folder_structures WHERE parent_document_folder_structure_id Not IN  ($parent_department) AND active_flag =1 ");

			$response = [
				'rows' => $rows
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



	public function project_roles_list()
	{
		$logMethod = 'Method => UserController => project_roles_list';
		try {

			$rows = DB::select('select * from project_roles where active_flag = 1');

			$response = [
				'rows' => $rows
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





	public function get_roles_list()
	{
		$logMethod = 'Method => UserController => get_roles_list';

		try {

			$rows = DB::table('uam_roles')
				->select('*')
				// ->whereIn('alter_name', ['admin', 'professional_member', 'registrar', 'pristake', 'gtstake'])
				->where('active_flag', 0)
				->get();

			$project_roles = DB::table('project_roles')
				->select('*')
				->where('active_flag', 1)
				->get();



			// $document = DB::select("select  * from document_folder_structures where parent_document_folder_structure_id = 1");   
			// $document_folder_structure_id = $document[0]->document_folder_structure_id;

			// $parent_folder = DB::select("select a.document_folder_structure_id,a.document_folder_id,a.folder_name,a.folder_title,a.folder_description,a.parent_document_folder_structure_id
			// 	from document_folder_structures as a where a.parent_document_folder_structure_id = 0");

			// $directorate = DB::table('document_folder_structures')
			// ->select('*')
			// ->where('document_folder_structure_id',2)
			// ->get();

			// $department = DB::table('document_folder_structures')
			// ->select('*')
			// ->where('active_flag',1)
			// ->get();


			// $sub_department = DB::table('document_folder_structures')
			// ->select('*')
			// ->where('active_flag',1)
			// ->get();

			$designation = DB::table('designation')
				->select('*')
				->where('active_flag', 0)
				->get();

			$dashboard = DB::table('user_dashboard_list')
				->select('*')
				->where('default_status', 0)
				->get();

			// $document_category = DB::select("select * from document_categories where active_flag = 1");

			$response = [
				'rows' => $rows,
				// 'directorate' => $directorate,
				'designation' => $designation,
				// 'document_folder_structure_id' => $document_folder_structure_id,
				'dashboard' => $dashboard,
				// 'parent_folder' => $parent_folder,
				// 'department' => $department,
				// 'sub_department' => $sub_department,
				// 'document_category' => $document_category,
				'project_roles' => $project_roles,
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



	public function get_department_list(Request $request)
	{
		$logMethod = 'Method => UserController => get_department_list';
		try {
			$input = $this->decryptData($request->requestData);
			$directorate_id  = $input['directorate'];
			// $directorate_id =implode(",",$directorate);
			// echo "select * from document_folder_structures where parent_document_folder_structure_id  IN ($directorate_id)";
			// exit;
			// echo json_encode($directorate_id);exit;
			$department = DB::select("select * from document_folder_structures where parent_document_folder_structure_id='$directorate_id'");
			//echo json_encode($department);exit;
			$response = [
				'department' => $department,
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


	public function user_register(Request $request)
	{
		$logMethod = 'Method => UserController => user_register';

		try {
			$input = $this->decryptData($request->requestData);
			$name  = $input['name'];
			$email =  $input['email'];
			$rowsemail =  DB::select("select * from users where email ='$email'");
			if (json_encode($rowsemail) != '[]') {
				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {

				$user_inser_id = DB::transaction(function () use ($input) {
					$user_password = $input['password'];
					// $dashboard_list_id = $input['dashboard_list_id'];
					// $stringdashboard_list_id = implode(",", $dashboard_list_id);
					// $directorate = $input['directorate'];
					$input['password'] = bcrypt($input['password']);
					$user_id = DB::table('users')
						->insertGetId([
							'name' => $input['name'],
							'email' => $input['email'],
							'user_type' => $input['user_type'],
							'password' => $input['password'],
							// 'array_dashboard_list' => $stringdashboard_list_id,
							'designation_id' => $input['designation'],
						]);

$this->WriteFileLog($input);
					$user_id  =  $user_id;
					$input['user_id'] = $user_id;

					$designation = $input['designation'];
					// $screen_unique = array_unique($input['directorate_department']);

					// $unique = array_values($screen_unique);

					// $screenidcount = count($unique);


					// $screen_array_department = array_unique($input['array_department']);
					// $unique_array_department = array_values($screen_array_department);
					// $screenunique_array_department = count($unique_array_department);
					// for ($i=0; $i < $screenidcount; $i++) { 
					// 	$iparr = explode(":", $unique[$i]); 
					// 	$user_departments_id = DB::table('user_departments')->insertGetId([
					// 		'user_id' => $user_id,
					// 		'parent_node_id' => $input['parent_node_id'],
					// 		'directorate_id' => $iparr[0],
					// 		'department_id' => $iparr[1],
					// 		'designation_id' => $designation,
					// 		'array_department' => $unique_array_department[$i]
					// 	]);
					// };

					// $screen_array_department = array_unique($input['array_department']);
					// $unique_array_department = array_values($screen_array_department);
					// $screenunique_array_department = count($unique_array_department);

					// for ($i=0; $i < $screenunique_array_department; $i++) { 
					// 	$iparr = explode("-", $unique_array_department[$i]); 
					// 	$user_departments_id = DB::table('users_document_categories')->insertGetId([
					// 		'user_id' => $user_id,
					// 		'document_category_id' => $iparr[3],
					// 		'directorate_id' => $iparr[1],
					// 		'department_id' => $iparr[2],
					// 		'array_department' => $unique_array_department[$i]
					// 	]);
					// };





					// $screenidcount = count($input['dashboard_list_id']);
					// for ($i = 0; $i < $screenidcount; $i++) {
					// 	$user_selected_dashboard_list = DB::table('user_selected_dashboard_list')->insertGetId([
					// 		'user_id' => $user_id,
					// 		'user_dashboard_list_id' => $input['dashboard_list_id'][$i],
					// 		'active_flag' => 0,
					// 		'created_by' => $user_id,
					// 	]);
					// };



					$roles_data_id = $input['roles_id'];
					$stringuser_id = $input['roles_id'];
					$update_id =  DB::table('users')
						->where('id', $user_id)
						->update([
							'array_roles' => $stringuser_id,
						]);

					//KD
					$role_change_id = DB::table('userrole_audit')
						->insertGetId([
							'current_role_id' => $stringuser_id,
							'user_id' => $user_id,
							'created_by' => auth()->user()->id,
							'audit_status' => "Newly Added"
						]);

					//KD
					$data = [
						'name' => $input['name'],
						'email' => $input['email'],
						'password' => $user_password,
					];
					// Mail::to($input['email'])->send(new SendUserCreateMail($data));

					$notifications = DB::table('notifications')->insertGetId([
						'user_id' => auth()->user()->id,
						'notification_status' => 'User Created',
						'notification_url' => 'user',
						'megcontent' => "User " . $input['name'] . " created Successfully and mail sent.",
						'alert_meg' => "User " . $input['name'] . " created Successfully and mail sent.",
						'created_by' => auth()->user()->id,
						'created_at' => NOW()
					]);



					$uam_screen_id = DB::table('uam_user_roles')->insertGetId([
						'user_id' => $user_id,
						'role_id' => $input['roles_id'],
						'active_flag' => 0,
						'created_by' => auth()->user()->id,
						'created_date' => NOW()
					]);


					$role_id = $input['roles_id'];
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
							if ($checkcount == 0) {
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
									'created_by' => auth()->user()->id,
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
									'created_by' => auth()->user()->id,
									'created_date' => NOW()
								]);
							};
						};
					};

					// deepika
					$role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
					$role_name_fetch = $role_name[0]->role_name;
					$this->auditLog('uam_user_roles', $uam_screen_id, 'Create', 'Create new uam role', $user_id, NOW(), $role_name_fetch);
					return $user_id;
				});


				// update in the users table()
				$role_id = $input['roles_id'];
				if ($role_id == '34') {
					$this->WriteFileLog("IN THE IF");
					$this->WriteFileLog($input);
					DB::transaction(function () use ($input) {
						$email = $input['email'];
						$userID = DB::select("SELECT id from users where email = '$email'");
						$this->WriteFileLog($userID);
						DB::table('users')
							->where('id', $userID[0]->id)
							->update([
								'gender' => $input['gender'],
								'country' => $input['country'],
								'mobile_no' => $input['mobile_no'],
								'updated_at' => NOW(),
								'total_cptpoints' => 20
							]);
					});

					if ($input['license_number'] != null) {
						DB::transaction(function () use ($input) {
							$email = $input['email'];
							$userID = DB::select("SELECT id from users where email = '$email'");
							$user_id = DB::table('professional_member_licence')
								->insertGetId([
									'license_number' => $input['license_number'],
									'user_id' => $userID[0]->id,
									'method' => $input['method'],
									'bank_name' => $input['bank_name'],
									'bank_transaction_id' => $input['bank_transaction_id'],
									'amount' => $input['amount'],
									'amount_paid_on' => $input['amount_paid_on'],
									'renewal_date' => $input['renewal_date'],
									'status' => '0',
									'created_at' => NOW(),
									'valuer_type' => $input['valuertype']
								]);
						});
					}

					$userID = DB::select("SELECT id from users where email = '$email'");
					$createdUserId = $userID[0]->id;
					$users = DB::SELECT("SELECT name,email from users where id=$createdUserId");
					$email = $users[0]->email;
					$name = $users[0]->name;
					$base_url = config('setting.base_url');
					$user_password = $input['password'];
					$data = array(
						'name' => $name,
						'email' => $email,
						'base_url' => $base_url,
						'password' => $user_password
					);

					Mail::to($email)->send(new newUserMail($data));
				}


				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = $user_inser_id;
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

	public function data_edit($id)
	{
		$method = 'Method => UserController => data_edit';
		/// echo json_encode($id);exit;
		try {
			$id = $this->decryptData($id);


			// $one_row = DB::select("select a.*,b.*,c.array_department as array_category from users as a inner join user_departments as b on b.user_id = a.id inner join users_document_categories as c on c.user_id = a.id where a.id = $id ");
			$one_row = DB::select("select * from users where id = $id ");
			$rows_data = DB::table('uam_roles')
				->select('*')
				->where('active_flag', 0)
				->get();
			// $document = DB::select("select  * from document_folder_structures where parent_document_folder_structure_id = 1");   
			// $document_folder_structure_id = $document[0]->document_folder_structure_id;

			// $parent_folder = DB::select("select a.document_folder_structure_id,a.document_folder_id,a.folder_name,a.folder_title,a.folder_description,a.parent_document_folder_structure_id
			// 	from document_folder_structures as a where a.parent_document_folder_structure_id = 0");

			// $directorate = DB::table('document_folder_structures')
			// ->select('*')
			// ->where('document_folder_structure_id',2)
			// ->get();

			// $department = DB::table('document_folder_structures')
			// ->select('*')
			// ->where('active_flag',1)
			// ->get();

			// $sub_department = DB::table('document_folder_structures')
			// ->select('*')
			// ->where('active_flag',1)
			// ->get();


			$designation = DB::table('designation')
				->select('*')
				->where('active_flag', 0)
				->get();

			$dashboard = DB::table('user_dashboard_list')
				->select('*')
				->where('default_status', 0)
				->get();

			// $document_category = DB::select("select * from document_categories where active_flag = 1");
			$project_roles = DB::table('project_roles')
				->select('*')
				->where('active_flag', 1)
				->get();

			$response = [
				'one_row' => $one_row,
				'rows_data' => $rows_data,
				// 'parent_folder' => $parent_folder,
				// 'directorate' => $directorate,
				// 'department' => $department, 
				// 'sub_department' => $sub_department,
				'designation' => $designation,
				// 'document_folder_structure_id' => $document_folder_structure_id,
				'dashboard' => $dashboard,
				// 'document_category' => $document_category,
				'project_roles' => $project_roles
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



	public function updatedata(Request $request)
	{
		$method = 'Method => UserController => updatedata';
		try {
			$input = $this->decryptData($request->requestData);
			$id  = $input['user_id'];
			$email =  $input['email'];
			$rowsemail =  DB::select("select * from users where not id  = '$id' and email ='$email'");
			if (json_encode($rowsemail) != '[]') {
				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {
				DB::transaction(function () use ($input) {
					$user_id  = $input['user_id'];
					$roles_data_id = $input['roles_id'];
					$stringuser_id = $input['roles_id'];

					// $dashboard_list_id = $input['dashboard_list_id'];
					// $stringdashboard_list_id = implode(",", $dashboard_list_id);


					// $directorate = $input['directorate'];


					//KD

					// $find_user = DB::select("SELECT * from users where id=" . $user_id . "");
					// $previous_role = $find_user[0]->array_roles;


					// if ($previous_role != $stringuser_id) {


					// 	$get_data = DB::select("SELECT  current_role_id FROM userrole_audit WHERE user_id=" . $user_id . " ORDER BY action_date DESC LIMIT 1");



					// 	$previous_id = $get_data[0]->current_role_id;

					// 	$role_change_id = DB::table('userrole_audit')
					// 		->insertGetId([


					// 			'current_role_id' => $stringuser_id,
					// 			'previous_role_id' => $previous_id,
					// 			'user_id' => $user_id,
					// 			'created_by' => auth()->user()->id,
					// 			'audit_status' => "Updated"



					// 		]);
					// }
					//KD


					DB::table('users')
						->where('id', $user_id)
						->update([

							'array_roles' => $stringuser_id,
							'name' => $input['name'],
							'email' => $input['email'],
							'array_dashboard_list' => NULL,
							'designation_id' => 1,
							'project_role_id' => 1,

						]);



					// $delete_user_department_id  = DB::table('user_departments')->where('user_id', $user_id)->delete();


					// $designation = $input['designation'];
					// $screen_unique = array_unique($input['directorate_department']);
					// $unique = array_values($screen_unique);
					// $screenidcount = count($unique);


					// $screen_array_department = array_unique($input['array_department']);
					// $unique_array_department = array_values($screen_array_department);
					// $screenunique_array_department = count($unique_array_department);


					// for ($i = 0; $i < $screenidcount; $i++) {
					// 	$iparr = explode(":", $unique[$i]);
					// 	$user_departments_id = DB::table('user_departments')->insertGetId([
					// 		'user_id' => $user_id,
					// 		'parent_node_id' => $input['parent_node_id'],
					// 		'directorate_id' => $iparr[0],
					// 		'department_id' => $iparr[1],
					// 		'designation_id' => $designation,
					// 		//'array_department' => $unique_array_department[$i]
					// 	]);
					// };
					// $delete_user_categories  = DB::table('users_document_categories')->where('user_id', $user_id)->delete();



					// $screen_array_department = array_unique($input['array_department']);
					// $unique_array_department = array_values($screen_array_department);
					// $screenunique_array_department = count($unique_array_department);

					// for ($i = 0; $i < $screenunique_array_department; $i++) {
					// 	$iparr = explode("-", $unique_array_department[$i]);
					// 	$user_departments_id = DB::table('users_document_categories')->insertGetId([
					// 		'user_id' => $user_id,
					// 		'document_category_id' => $iparr[3],
					// 		'directorate_id' => $iparr[1],
					// 		'department_id' => $iparr[2],
					// 		'array_department' => $unique_array_department[$i]
					// 	]);
					// };



					// $delete_dashboard_list_id  = DB::table('user_selected_dashboard_list')->where('user_id', $user_id)->delete();

					// $screenidcount = count($input['dashboard_list_id']);
					// for ($i = 0; $i < $screenidcount; $i++) {
					// 	$user_selected_dashboard_list = DB::table('user_selected_dashboard_list')->insertGetId([
					// 		'user_id' => $user_id,
					// 		'user_dashboard_list_id' => $input['dashboard_list_id'][$i],
					// 		'active_flag' => 0,
					// 		'created_by' => $user_id,
					// 	]);
					// };



					$user_screen_id1 = DB::select("select * from uam_user_screens where user_id = '$user_id'");
					$screenidcount1 = count($user_screen_id1);
					for ($w = 0; $w < $screenidcount1; $w++) {
						$uam_user_screen_permissions_id  =  $user_screen_id1[$w]->user_screen_id;
						$delete_role_screen_id  = DB::table('uam_user_screen_permissions')->where('user_screen_id', $uam_user_screen_permissions_id)->delete();
					}
					$uam_modules_id =  DB::table('uam_user_roles')
						->where('user_id', $user_id)
						->delete();
					$uam_user_screens =  DB::table('uam_user_screens')
						->where('user_id', $user_id)
						->delete();

					$uam_screen_id = DB::table('uam_user_roles')->insertGetId([
						'user_id' => $user_id,
						'role_id' => $input['roles_id'],
						'active_flag' => 0,
						'created_by' => auth()->user()->id,
						'created_date' => NOW()
					]);


					$role_id = $input['roles_id'];
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
							if ($checkcount == '') {
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
									'created_by' => auth()->user()->id,
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
									'created_by' => auth()->user()->id,
									'created_date' => NOW()
								]);
							};
						};
					};




					$role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
					$role_name_fetch = $role_name[0]->role_name;
					$this->auditLog('uam_user_roles', $uam_screen_id, 'Create', 'Create new uam role', $user_id, NOW(), '');
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

	// public function user()
	// {
	//   try {
	//     $rows = DB::table('users')
	//     ->select('name', 'email', 'user_type','id')
	//     ->where('id', auth()->user()->id)
	//     ->get();
	//     return $this->sendDataResponse($rows);
	// } catch(\Exception $exc){
	//     return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
	// }
	// }
	// public function get_user_list()
	// {
	//   try {
	//     $rows = DB::table('users')
	//     ->select('*')
	//     ->get();
	//     return $this->sendDataResponse($rows);
	// } catch(\Exception $exc){
	//     return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
	// }
	// }
	// public function get_roles_list()
	// {
	//   try {
	//     $rows = DB::table('uam_roles')
	//     ->select('*')
	//     ->get();
	//     return $this->sendDataResponse($rows);
	// } catch(\Exception $exc){
	//     return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
	// }
	// }


	public function reset_expire_data_get()
	{

		$method = 'Method => UserController => reset_expire_data_get';

		try {

			$rows =  DB::select('SELECT * FROM reset_password_token_time_settings');


			$response = [
				'rows' => $rows
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


	public function token_expire_data_update(Request $request)
	{

		$method = 'Method => UserController => reset_expire_data_get';

		try {
			$input = $this->decryptData($request->requestData);
			$settings_time = $input['settings_time'];
			$settings_id = $input['settings_id'];
			$settings_movement = $input['settings_movement'];


			if ($settings_movement == 2) {

				$user_inser_id = DB::transaction(function () use ($input) {

					$settings_time = $input['settings_time'];
					$settings_id = $input['settings_id'];
					$settings_movement = $input['settings_movement'];

					DB::table('reset_password_token_time_settings')
						->where('settings_id', $settings_id)
						->update([
							'settings_time' => $settings_time,
							'settings_movement' => $settings_movement,
							'updated_by' => auth()->user()->id,
						]);


					$ew1 = DB::unprepared("DROP EVENT IF EXISTS `et_update_your_trigger_name` ");

					$ew2 =  DB::unprepared("CREATE EVENT `et_update_your_trigger_name`  ON SCHEDULE EVERY $settings_time DAY 

					DO 

					Delete from forget_password_token_list WHERE expire_time < now() - interval $settings_time DAY ");


					$ew3 = DB::unprepared("ALTER EVENT `et_update_your_trigger_name` ON  COMPLETION PRESERVE ENABLE");
				});

				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			}

			if ($settings_movement == 1) {
				$user_inser_id = DB::transaction(function () use ($input) {

					$settings_time = $input['settings_time'];
					$settings_id = $input['settings_id'];
					$settings_movement = $input['settings_movement'];

					DB::table('reset_password_token_time_settings')
						->where('settings_id', $settings_id)
						->update([
							'settings_time' => $settings_time,
							'settings_movement' => $settings_movement,
							'updated_by' => auth()->user()->id,
						]);


					$ew1 = DB::unprepared("DROP EVENT IF EXISTS `et_update_your_trigger_name` ");

					$ew2 =  DB::unprepared("CREATE EVENT `et_update_your_trigger_name`  ON SCHEDULE EVERY $settings_time HOUR 

					DO 

					Delete from forget_password_token_list WHERE expire_time < now() - interval $settings_time HOUR ");


					$ew3 = DB::unprepared("ALTER EVENT `et_update_your_trigger_name` ON  COMPLETION PRESERVE ENABLE");
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




	public function forget_password(Request $request)
	{

		$method = 'Method => UserController => forget_password';
		try {
			$inputArray = $this->decryptData($request->requestData);
			$input = [
				'email' => $inputArray['email'],
			];
			$id = $input['email'];
			//echo json_encode($id);exit;
			$rows =  DB::select("select * from users where email ='$id'");
			if (json_encode($rows) == '[]') {
				$response_status = 300;
				$response = [
					'response_status' => $response_status
				];
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = $response;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {
				$id1 = $rows[0]->id;
				$email = $rows[0]->email;

				$token = $this->encryptData($email);
				//$token = bin2hex($token);


				$data = [
					'id' => $this->encryptData($id1),
					'name' => $rows[0]->name,
					'email' => $this->encryptData($email),
					'token' => $token,
				];

				$this->WriteFileLog($data);
				Mail::to($rows[0]->email)->send(new SendResetMail($data));
				$response_status = 200;
				$email_encrypt = $this->encryptData($email);
				$response = [
					'response_status' => $response_status
				];
				$this->WriteFileLog($response);

				//KD
				$remember_ps_audit = DB::table('remember_ps_audit')
					->insertGetId([
						'status' => 'Reset Link Sent',
						'user_id' => $id1,
						'url' => '/reset/' . $token,
						'encrypt' => $token

					]);

				$token_send = DB::table('forget_password_token_list')
					->insertGetId([
						'status' => 'Reset Link Sent',
						'user_id' => $id1,
						'url' => '/reset/' . $token,
						'token' => $token

					]);


				// KD

				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = $response;
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







	public function reset($id)
	{

		$method = 'Method => UserController => reset';
		try {
			$rows =  DB::select("select * from forget_password_token_list where token = '$id' ");

			if ($rows == []) {
				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {

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















	public function reset_password(Request $request)
	{
		$method = 'Method => UserController => reset_password';
		try {

			$input = $this->decryptData($request->requestData);


			$password = bcrypt($input['password']);
			$email = $input['email'];

			$pass = $input['password'];


			$user_pass  = DB::select("select * from users where email = '$email' ");

			$user_password =  $user_pass[0]->password;

			if (Hash::check($pass, $user_password)) {


				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {

				$rows =  DB::select("select a.id from users as a  where a.email = '$email' ");
				DB::transaction(function () use ($password, $rows) {
					DB::table('users')
						->where('id', json_encode($rows[0]->id))
						->update([
							'password' => $password,
						]);
				});
				//KD
				$userID = json_encode($rows[0]->id);

				$forget_password_table  = DB::table('forget_password_token_list')->where('user_id', $userID)->delete();

				$get_data = DB::select("SELECT  audit_id FROM remember_ps_audit WHERE user_id=" . $userID . " ORDER BY linksent_time DESC LIMIT 1");

				$last_id = $get_data[0]->audit_id;

				DB::table('remember_ps_audit')

					->where([['user_id', '=', $userID], ['audit_id', '=', $last_id]])
					->update(['status1' => 'Password Reset Successfully', 'active' => 1]);
				// KD

				$response_status = 200;
				$response = [
					'response_status' => $response_status
				];
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = $response;
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



	public function change_password_save(Request $request)
	{
		$method = 'Method => UserController => change_password_save';
		try {
			$input = $this->decryptData($request->requestData);

			$password = bcrypt($input['new_password']);

			$pass = $input['new_password'];

			$user_id = $input['user_id'];



			$user_pass  = DB::select("select * from users where id = '$user_id' ");

			$user_password =  $user_pass[0]->password;

			if (Hash::check($pass, $user_password)) {


				$serviceResponse = array();
				$serviceResponse['Code'] = 400;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			} else {


				DB::transaction(function () use ($password, $user_id) {
					DB::table('users')
						->where('id', $user_id)
						->update([
							'password' => $password,
						]);
				});

				$response_status = 200;
				$response = [
					'response_status' => $response_status
				];
				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.success');
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = $response;
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










	public function delete($id)
	{

		//return $id;
		try {

			$method = 'Method => UserController => delete';
			$id = $this->decryptData($id);
			// $document_process_check = DB::select("select * from document_processes where created_by = '$id'");
			// if ($document_process_check != [] ) {
			// 	$serviceResponse = array();
			// 	$serviceResponse['Code'] = 800;
			// 	$serviceResponse['Message'] = config('setting.status_message.success');
			// 	$serviceResponse['Data'] = 1;
			// 	$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
			// 	$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
			// 	return $sendServiceResponse;

			// }


			// $work_flow_check = DB::select("select * from tasks_common_all_list where created_by = '$id' or allocated_user_id = '$id'");
			// if ($work_flow_check != [] ) {
			// 	$serviceResponse = array();
			// 	$serviceResponse['Code'] = 800;
			// 	$serviceResponse['Message'] = config('setting.status_message.success');
			// 	$serviceResponse['Data'] = 1;
			// 	$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
			// 	$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
			// 	return $sendServiceResponse;
			// }

			$auth_user_id = auth()->user()->id;


			if ($id  ==  $auth_user_id) {

				$serviceResponse = array();
				$serviceResponse['Code'] = 1000;
				$serviceResponse['Message'] = config('setting.status_message.success');
				$serviceResponse['Data'] = 1;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			}




			// $user_check = DB::select("select * from work_flow_level_user where user_id = '$id'");
			// if ($user_check == []) { 
			$user_check = DB::select("select * from users where id ='$id' AND active_flag=0 AND delete_status = 0");

			if ($user_check != []) {


				DB::transaction(function () use ($id) {
					DB::table('users')
						->where('id', $id)
						->update([
							'active_flag' => 1,
							'delete_status' => 1,
						]);
				});



				// $user_screen_id = DB::select("select * from uam_user_screens where user_id = '$id'");
				// $screenidcount = count($user_screen_id);
				// for ($j=0; $j< $screenidcount; $j++) { 
				// 	$uam_user_screen_permissions_id  =  $user_screen_id[$j]->user_screen_id;
				// 	$delete_role_screen_id  = DB::table('uam_user_screen_permissions')->where('user_screen_id', $uam_user_screen_permissions_id)->delete();
				// }
				// DB::transaction(function() use($id){
				// 	$uam_modules_id =  DB::table('uam_user_roles')
				// 	->where('user_id', $id)
				// 	->delete();                  
				// });

				// DB::transaction(function() use($id){
				// 	$uam_user_screens =  DB::table('uam_user_screens')
				// 	->where('user_id', $id)
				// 	->delete();                  
				// });
				// DB::transaction(function() use($id){
				// 	$user_departments =  DB::table('user_departments')
				// 	->where('user_id', $id)
				// 	->delete();                  
				// });
				// DB::transaction(function() use($id){
				// 	$users =  DB::table('users')
				// 	->where('id', $id)
				// 	->delete();                  
				// });


				// Deepika

				$user_name = DB::select("select * from users where id=$id");
				$name = $user_name[0]->name;
				$notifications = DB::table('notifications')->insertGetId([
					'user_id' => auth()->user()->id,
					'notification_status' => 'User Deleted',
					'notification_url' => 'user',
					'megcontent' => "User " . $name . " deleted Successfully .",
					'alert_meg' => "User " . $name . " deleted Successfully .",
					'created_by' => auth()->user()->id,
					'created_at' => NOW()
				]);
				$role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
				$role_name_fetch = $role_name[0]->role_name;
				$this->auditLog('uam_users', $id, 'Delete', 'Deleted the User', auth()->user()->id, NOW(), $role_name_fetch);

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
	public function edit_permission($id)
	{
		$method = 'Method => UserController => edit_permission';

		try {
			$id = $this->decryptData($id);

			$modulesrows =  DB::select("select * from uam_user_roles where user_id = $id");
			$role_id = $modulesrows[0]->role_id;


			$role_name_check = DB::select("select role_name from uam_roles 
			where role_id = $role_id ");
			$role_name = $role_name_check[0]->role_name;



			$module_data =  DB::select("select distinct a.module_id,c.module_name from uam_role_screens as a 
			inner join uam_modules as c on c.module_id = a.module_id
			where a.role_id = '$role_id'");


			$screen_data = DB::select("select a.module_id,a.screen_id,b.screen_name,a.role_screen_id from uam_role_screens as a inner join uam_screens as b on b.screen_id = a.screen_id
			where a.role_id = '$role_id' ");


			// $permission_data = DB::select("select a.module_id,a.screen_id,a.role_screen_id,b.array_permission,b.screen_permission_id,c.permission from uam_role_screens as a 
			// 	inner join uam_role_screen_permissions as b on b.role_screen_id = a.role_screen_id
			// 	inner join uam_screen_permissions as c on c.screen_permission_id = b.screen_permission_id
			// 	where a.role_id = '$role_id' ");

			$permission_data = DB::table('uam_screen_permissions')
				->select('*')
				->get();



			$rows = DB::select("select array_permission from uam_user_screen_permissions 
			where user_id = $id ");


			$response = [
				'module_data' => $module_data,
				'screen_data' => $screen_data,
				'permission_data' => $permission_data,
				'user_id' => $id,
				'rows' => $rows,
				'role_name' => $role_name
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
	public function updatedatapermission(Request $request)
	{
		try {
			$method = 'Method => UserController => updatedatapermission';
			$inputArray = $this->decryptData($request->requestData);
			$input = [
				'user_id' => $inputArray['user_id'],
				'screen_id' => $inputArray['screen_id'],
				'permission_id' => $inputArray['permission_id'],
			];
			$rows1 = DB::table('uam_user_screens')->where('user_id', $input['user_id'])->delete();
			$rows2 = DB::table('uam_user_screen_permissions')->where('user_id', $input['user_id'])->delete();


			DB::transaction(function () use ($input) {
				$screen_unique = array_unique($input['screen_id']);
				$unique = array_values($screen_unique);
				$screenidcount = count($unique);
				for ($i = 0; $i < $screenidcount; $i++) {
					$iparr = explode(":", $unique[$i]);
					$screen_id = $iparr[1];
					$module_id = $iparr[0];
					$screenrows =  DB::select("select * from uam_screens where screen_id = $screen_id");
					$modulesrows =  DB::select("select * from uam_modules where module_id = $module_id");

					$parent_module_id = $modulesrows[0]->parent_module_id;
					$module_name = $modulesrows[0]->module_name;
					$module_name = $modulesrows[0]->module_name;
					$screen_name = $screenrows[0]->screen_name;
					$screen_url = $screenrows[0]->screen_url;
					$route_url = $screenrows[0]->route_url;
					$class_name = $screenrows[0]->class_name;
					$display_order = $screenrows[0]->display_order;
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
						'user_id' => $input['user_id'],
						'active_flag' => 0,
						'created_by' => auth()->user()->id,
						'created_date' => NOW()
					]);
				}
				$permissioncount = count($input['permission_id']);
				for ($j = 0; $j < $permissioncount; $j++) {
					$permission =  $input['permission_id'][$j];
					$permissiondata = substr($permission, 6);
					$iparr = explode("-", $permissiondata);
					$user_id = $input['user_id'];
					$module_id = $iparr[1];
					$screen_id = $iparr[2];
					$permission_id = $iparr[0];
					$rows =  DB::select("select a.user_screen_id from uam_user_screens as a where a.module_id = $module_id and a.user_id = $user_id  and a.screen_id = $screen_id ");
					$permissionrows =  DB::select("select a.permission,a.description,a.active_flag from uam_screen_permissions as a where a.screen_permission_id = $permission_id ");
					$user_screen_id = $rows[0]->user_screen_id;
					$permission_name = $permissionrows[0]->permission;
					$description = $permissionrows[0]->description;
					$active_flag = $permissionrows[0]->active_flag;
					$user_id = $input['user_id'];
					$role_screen_permissions_id = DB::table('uam_user_screen_permissions')->insertGetId([
						'user_screen_id' =>  $user_screen_id,
						'screen_permission_id' =>  $permission_id,
						'permission' => $permission_name,
						'user_id' => $user_id,
						'array_permission' => $permission,
						'description' => $description,
						'active_flag' => $active_flag,
						'created_by' => auth()->user()->id,
						'created_date' => NOW()
					]);
				}
				// $role_name=DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);
				// $role_name_fetch=$role_name[0]->role_name;
				// $this->auditLog('uam_user', $input['user_id'] , 'Update', 'Update uam screen', auth()->user()->id, NOW(), ' ');
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

	// Deepika //
	public function notifications(Request $request)
	{
		$method = 'Method => UserController => notifications';

		try {
			$inputArray = $this->decryptData($request->requestData);

			$id = Auth::id();
			$role = DB::select("SELECT role_id FROM uam_user_roles where user_id=$id;");
			$role = $role[0]->role_id;

			$count_data = DB::select("select count(a.notification_id) as countflow from notifications as a	where a.user_id =$id and a.active_flag = 0");
			$registration_count = DB::select(
				"SELECT COUNT(notification_url) AS countflow
			FROM notifications
			WHERE (notification_url LIKE 'registration%'
					OR notification_url LIKE 'education_index%'
					OR notification_url LIKE 'workexp_index%'	
					OR notification_url LIKE 'approvalprocess_index%'
					OR notification_url LIKE 'gtapprove%'
					OR notification_url LIKE 'approve_nrv%'
					OR notification_url LIKE 'nrv_approval%'
					OR notification_url LIKE 'Licensepay%')
				AND (user_id = $id OR role_id = $role) 
				AND active = '0'"
			);
			$registration_data = DB::select("SELECT *
			FROM notifications
			WHERE (notification_url LIKE 'registration%'
					OR notification_url LIKE 'education_index%'
					OR notification_url LIKE 'workexp_index%'		
					OR notification_url LIKE 'approvalprocess_index%'
					OR notification_url LIKE 'gtapprove%'
					OR notification_url LIKE 'approve_nrv%'
					OR notification_url LIKE 'nrv_approval%'
					OR notification_url LIKE 'Licensepay%')
				AND (user_id = $id OR role_id = $role) 
				AND active = '0'
			ORDER BY notification_id DESC;");

			$General_notifications_data = DB::select("select * from notifications where (notification_url LIKE 'Firm_approval_index%' or notification_url LIKE '/initiation/create%' or notification_url LIKE 'initiation%' or notification_url LIKE '/Instruction/Process%' or notification_url LIKE '/instruction/register%' or notification_url LIKE '/cgv/approve%' or notification_url LIKE 'firm_index%' or notification_url LIKE '/education_course%' or notification_url LIKE 'firm_admin%' or notification_url LIKE '/district/update%' or notification_url LIKE 'general_masters%' or notification_url LIKE '/Critical/Report%' or notification_url LIKE '/critical/approve%' or notification_url LIKE '/Professional/Competence%' or notification_url LIKE '/final/assessment%' or notification_url LIKE '/interview/process%'or notification_url LIKE '/instruction/register%'or notification_url LIKE 'instruction%' or notification_url LIKE 'file_upload%') and active ='0'and  user_id =$id order by notification_id DESC;");
			$General_notifications_count = DB::select("select count(notification_url) as countflow from notifications WHERE (notification_url LIKE 'Firm_approval_index%' or notification_url LIKE '/initiation/create%' or notification_url LIKE 'initiation%' or notification_url LIKE '/Instruction/Process%' or notification_url LIKE '/instruction/register%' or notification_url LIKE '/cgv/approve%'or notification_url LIKE 'firm_index%'  or notification_url LIKE 'firm_admin%' or notification_url LIKE '/education_course%' or notification_url LIKE '/district/update%' or notification_url LIKE 'general_masters%' or notification_url LIKE '/Critical/Report%' or notification_url LIKE '/critical/approve%' or notification_url LIKE '/Professional/Competence%' or notification_url LIKE '/final/assessment%' or notification_url LIKE '/interview/process%'or notification_url LIKE '/instruction/register%'or notification_url LIKE 'instruction%'or notification_url LIKE 'file_upload%') and active = '0'  and  user_id =$id;");
			$approval_nrv_count   = DB::select("select count(notification_url) as countflow from notifications where (notification_url LIKE 'nrv_approval%') and role_id=$role and active = '0' ;");
			$approval_nrv_data = DB::select("select * from notifications where (notification_url LIKE 'nrv_approval%') and role_id =$role and active = '0' order by notification_id DESC;");

			$Elearning_notifications_data = DB::select("select * from notifications where (notification_url LIKE '/elearningquestion%' or notification_url LIKE '/adminevent%' or notification_url LIKE '/adminnoticeboard%' or notification_url LIKE '/examtest%' or notification_url LIKE '/ethictest%' or notification_url LIKE '/localadaptationtest%' or notification_url LIKE '/elearningadminqa%' or notification_url LIKE '%/reply/index%' or notification_url LIKE '/admincourse%')and active ='0' and  user_id =$id order by notification_id DESC;");
			$Elearning_notifications_count = DB::select("select count(notification_url) as countflow from notifications WHERE (notification_url LIKE '/elearningquestion%' or notification_url LIKE '/adminevent%' or notification_url LIKE '/adminnoticeboard%' or notification_url LIKE '/examtest%' or notification_url LIKE '/ethictest%' or notification_url LIKE '/localadaptationtest%' or notification_url LIKE '/elearningadminqa%' or notification_url LIKE '%/reply/index%' or notification_url LIKE '/admincourse%') and active ='0'  and  user_id =$id;");

			$Elearning_usernotifications_data = DB::select("select * from notifications where (notification_url LIKE '/elearning/quiz/view%'or notification_url LIKE '/ethic/quiz/list%' or notification_url LIKE '/exam/quiz/list%' or notification_url LIKE '/localadaptation/quiz/list%' or notification_url LIKE '/elearningCourse/class%' or notification_url LIKE '/elearningCourse%' or notification_url LIKE '/elearningCourse/class%' ) and active='0'and  user_id =$id order by notification_id DESC;");
			$Elearning_usernotifications_count = DB::select("select count(notification_url) as countflow from notifications WHERE (notification_url LIKE '/elearning/quiz/view%' or notification_url LIKE '/ethic/quiz/list%' or notification_url LIKE '/exam/quiz/list%' or notification_url LIKE '/localadaptation/quiz/list%' or notification_url LIKE '/elearningCourse/class%' or notification_url LIKE '/elearningCourse%'  or notification_url LIKE '/elearningCourse/class%') and active='0'  and  user_id =$id;");


			$response = [

				'registration_count' => $registration_count,
				'registration_data'  => $registration_data,
				'General_notifications_data'  => $General_notifications_data,
				'General_notifications_count' => $General_notifications_count,
				'approval_nrv_count' => $approval_nrv_count,
				'approval_nrv_data' => $approval_nrv_data,
				'Elearning_notifications_data' => $Elearning_notifications_data,
				'Elearning_notifications_count' => $Elearning_notifications_count,
				'Elearning_usernotifications_data' => $Elearning_usernotifications_data,
				'Elearning_usernotifications_count' => $Elearning_usernotifications_count,
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

	// Deepika
	public function notified(Request $request)
	{

		$method = 'Method => UserController => notified';
		try {

			$inputArray = $this->decryptData($request->requestData);
			$input = [
				'id' => $inputArray['id'],

			];
			$id = $input['id'];
			DB::table('notifications')
				->where('notification_id', $id)
				->update([
					'active' => 1,
				]);
			$notify_link = DB::select("select * from notifications notification_url where notification_id=$id ;");
			$response = [

				'notify_link' => $notify_link,

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

	// Deepika
	public function policypage()
	{


		$method = 'Method => UserController => policypage';
		try {


			$policy_link = DB::select("select * from privacy_policy policycontent");

			$response = [

				'rows' => $policy_link,
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









	public function notification_alert(Request $request)
	{
		$method = 'Method => UserController => notification_alert';
		try {
			$inputArray = $this->decryptData($request->requestData);

			$input = [
				'notification_id' => $inputArray['notification_id'],
			];

			$notification_id =  $input['notification_id'];


			DB::transaction(function () use ($notification_id) {
				DB::table('notifications')
					->where('notification_id', $notification_id)
					->update([
						'active_flag' => 1,
					]);
			});




			// $work_flow_data =  DB::select("select a.notification_id,a.user_id,a.notification_type,a.work_flow_id,a.notification_type_id,a.notification_url,
			//     a.document_receipt_id,a.alert_meg,a.notification_status,b.work_flow_name from notifications as a
			//     inner join work_flow as b on b.work_flow_id = a.work_flow_id
			//     where a.notification_id = '$notification_id' ");

			$work_flow_data =  DB::select("select a.notification_id,a.user_id,a.notification_type,a.work_flow_id,a.notification_type_id,a.notification_url,
			a.document_receipt_id,a.alert_meg,a.notification_status from notifications as a
			where a.notification_id = '$notification_id' ");





			$user_data =  DB::select("SELECT *
			from notifications 

			where notification_status='User Created' and notification_id =" . $notification_id);

			$form_data =  DB::select("SELECT *
			from notifications 

			where notification_type='Document Process' and notification_id =" . $notification_id);

			$response = [
				'work_flow_data' => $work_flow_data,
				'user_data' => $user_data,
				'form_data' => $form_data
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
	public function profilepage(Request $request)
	{
		$method = 'Method => UserController => profilepage';
		try {
			$id = auth()->user()->id;
			$user = DB::select("select * from users where id = $id");
			$response = [
				'user' => $user
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
	public function profile_update(Request $request)
	{
		$method = 'Method => UserController => profile_update';
		try {
			$input = $this->decryptData($request->requestData);
			$id  = $input['user_id'];
			$phone_number =  $input['phone_number'];
			$signature_attachment =  $input['signature_attachment'];
			$profile_path = $input['profile_path'];
			if ($profile_path != " " && $phone_number != " ") {
				DB::transaction(function () use ($input) {
					DB::table('users')
						->where('id', $input['user_id'])
						->update([
							'phone_number' =>  $input['phone_number'],
							'profile_image' => $input['signature_attachment'],
							'profile_path' => $input['profile_path']
						]);
				});
			} else if ($profile_path == " " && $phone_number != " ") {
				DB::transaction(function () use ($input) {
					DB::table('users')
						->where('id', $input['user_id'])
						->update([
							'phone_number' =>  $input['phone_number'],

						]);
				});
			} else {
				DB::transaction(function () use ($input) {
					DB::table('users')
						->where('id', $input['user_id'])
						->update([
							'profile_image' => $input['signature_attachment'],
							'profile_path' => $input['profile_path']

						]);
				});
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
	public function update_toggle(Request $request)
	{
		try {

			$method = 'Method => FAQquestionsController => update_toggle';
			$inputArray = $this->decryptData($request->requestData);
			$input = [
				'is_active' => $inputArray['is_active'],
				'f_id' => $inputArray['f_id'],

			];


			DB::table('users')

				->where([['id', '=', $input['f_id']]])
				->update(['active_flag' => $input['is_active']]);




			$serviceResponse = array();
			$serviceResponse['Code'] = config('setting.status_code.success');
			$serviceResponse['Message'] = config('setting.status_message.success');
			$serviceResponse['Data'] = $input['is_active'];
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



	public function bulkdummyupload(Request $request)
	{

		try {
			$method = 'Method => DesignationController => bulkdummyupload';
			$inputArray = $this->decryptData($request->requestData);

			$workoutdetails = json_decode($inputArray['jsonObject'], true);

			foreach ($workoutdetails as $key => $value) {

				DB::transaction(function () use ($value) {

					$password  = "Login@123";

					$user_id = DB::table('users')->insertGetId([
						'name' => $value['user_name'],
						'email' => $value['email'],
						'password' => bcrypt($password),
						'array_roles' => $value['screen_role_id'],
						'project_role_id' => $value['project_role_id'],
						'array_dashboard_list' => 1,
						'designation_id' => $value['designation_id'],
						'created_at' => NOW()
					]);

					$user_selected_dashboard_list = DB::table('user_selected_dashboard_list')->insertGetId([
						'user_id' => $user_id,
						'user_dashboard_list_id' => 1,
						'active_flag' => 0,
						'created_by' => $user_id,
					]);

					$role_change_id = DB::table('userrole_audit')
						->insertGetId([
							'current_role_id' => $value['screen_role_id'],
							'user_id' => $user_id,
							'created_by' => auth()->user()->id,
							'audit_status' => "Newly Added"
						]);

					$notifications = DB::table('notifications')->insertGetId([
						'user_id' => auth()->user()->id,
						'notification_status' => 'User Created',
						'notification_url' => 'user',
						'megcontent' => "User " . $value['user_name'] . " created Successfully and mail sent.",
						'alert_meg' => "User " . $value['user_name'] . " created Successfully and mail sent.",
						'created_by' => auth()->user()->id,
						'created_at' => NOW()
					]);


					$uam_screen_id = DB::table('uam_user_roles')->insertGetId([
						'user_id' => $user_id,
						'role_id' => $value['screen_role_id'],
						'active_flag' => 0,
						'created_by' => auth()->user()->id,
						'created_date' => NOW()
					]);

					$role_id = $value['screen_role_id'];

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
							if ($checkcount == '') {
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
									'created_by' => auth()->user()->id,
									'created_date' => NOW()
								]);
							} else {
							}
						};
					};

					$role_id = $value['screen_role_id'];

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
									'created_by' => auth()->user()->id,
									'created_date' => NOW()
								]);
							};
						};
					};

					$last_name =  "A";
					$user_name  = $value['user_name'];
					$email =  $value['email'];
				});
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


	public function dummybulkdummyupload(Request $request)
	{

		try {
			$method = 'Method => DesignationController => bulkdummyupload';
			$inputArray = $this->decryptData($request->requestData);

			$workoutdetails = json_decode($inputArray['jsonObject'], true);

			foreach ($workoutdetails as $key => $value) {

				DB::transaction(function () use ($value) {

					$password  = "Login@123";

					$user_id = DB::table('mlhud_existing_users')->insertGetId([
						'reg_no' => $value['reg_no'],
						'name' => $value['name'],
						'email_address' => $value['email_address'],
						'location' => $value['location'],
						'qualification' => $value['qualification'],
						'chapter' => $value['chapter'],
						'isu_membership_number' => $value['isu_membership_number'],
						'contact_address' => $value['contact_address'],
						'tele_no' => $value['tele_no'],
						'gender' => $value['gender'],

					]);
					//          

				});
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

	public function checking_data(Request $request)
	{

		try {
			$method = 'Method => DesignationController => checking_data';
			$inputArray = $this->decryptData($request->requestData);

			// role checking

			if ($inputArray['checking'] == 1) {

				$role_id = $inputArray['screen_role_id'];

				$role_check =  DB::select("select * from uam_roles where role_id = $role_id and active_flag = 0");

				if ($role_check != []) {
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
			}

			// project role checking



			if ($inputArray['checking'] == 2) {

				$project_role_id = $inputArray['project_role_id'];

				$role_check =  DB::select("select * from project_roles where project_role_id = $project_role_id and active_flag = 1");

				if ($role_check != []) {
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
			}



			// designation checking


			if ($inputArray['checking'] == 3) {

				$designation_id = $inputArray['designation_id'];

				$role_check =  DB::select("select * from designation where designation_id = $designation_id and active_flag = 0");

				if ($role_check != []) {
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
			}

			// department checking

			if ($inputArray['checking'] == 4) {

				$parent_department = config('setting.parent_department');

				$role_check =  DB::select("SELECT * FROM document_folder_structures WHERE parent_document_folder_structure_id Not IN  ($parent_department) AND active_flag = 1
 AND  document_folder_structure_id =  $department_id");




				if ($role_check != []) {
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
			}


			if ($inputArray['checking'] == 5) {

				$email = $inputArray['email'];

				$role_check =  DB::select("SELECT * FROM users WHERE email = '$email' ");

				if ($role_check == []) {
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
			}


			if ($inputArray['checking'] == 6) {

				$email = $inputArray['email'];

				$role_check =  DB::select("SELECT * FROM users_dummy WHERE email = '$email' ");
				$checkcounting = count($role_check);
				if ($checkcounting > 1) {

					$serviceResponse = array();
					$serviceResponse['Code'] = 400;
					$serviceResponse['Message'] = config('setting.status_message.success');
					$serviceResponse['Data'] = 1;
					$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
					$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
					return $sendServiceResponse;
				} else {
					$serviceResponse = array();
					$serviceResponse['Code'] = config('setting.status_code.success');
					$serviceResponse['Message'] = config('setting.status_message.success');
					$serviceResponse['Data'] = 1;
					$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
					$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
					return $sendServiceResponse;
				}
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
}
