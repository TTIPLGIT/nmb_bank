<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\For_;
use PhpParser\Node\Stmt\If_;
use Symfony\Component\Console\Input\Input;

class firmadministrationController extends BaseController
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function firm_admin_index(Request $request)
	{
		try {
			$logMethod = 'Method => firmadministrationController => admin_screen';

			$userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];

			$role = DB::select("select role_id from uam_user_roles where user_id=$userID");
			$role = $role[0]->role_id;
			$rows['role'] = $role;
			if ($role != intval(config('setting.roles.professional_member'))) {

				//firm admin	
				$rows['firm_admin'] = DB::select("SELECT u.name, u.email, fp.active_flag, u.id AS user_id, fr.firm_name, fr.created_at, fr.description, fp.firm_id, fp.partner_id FROM firm_partners AS fp INNER JOIN firm_registration AS fr ON fr.id = fp.firm_id INNER JOIN users AS u ON u.id = fp.partner_id WHERE fr.user_id = $userID and fp.active_flag !=2");
				# code...
			} else {


				//partner
				$firm_data = DB::select("SELECT fr.user_id FROM  firm_partners AS fp INNER JOIN firm_registration AS fr ON fp.firm_id=fr.id WHERE fp.partner_id=$userID and fp.active_flag !=2");
				$this->WriteFileLog($firm_data);
				if ($firm_data != []) {
					$firm_user_id = $firm_data[0]->user_id;

					$rows['firm_admin'] = DB::select("SELECT u.name, u.email, fp.active_flag, u.id AS user_id, fr.firm_name, fr.created_at, fr.description, fp.firm_id, fp.partner_id FROM firm_partners AS fp INNER JOIN firm_registration AS fr ON fr.id = fp.firm_id INNER JOIN users AS u ON u.id = fp.partner_id WHERE fr.user_id = $firm_user_id and fp.active_flag !=2");
					$rows['firm_permission'] = DB::select("SELECT firm_permissions.firm_id,firm_permissions.partner_id,firm_permissions.permission_type,firm_permissions.active_permission,firm_permissions.give_permission,firm_permissions.delete_permission,firm_permissions.status FROM firm_permissions where partner_id =$userID ");
				} else {
					$rows['firm_admin'] = [];
					$rows['firm_permission'] = [];
				}
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
			$this->WriteFileLog($exceptionResponse);
			$serviceResponse = array();
			$serviceResponse['Code'] = config('setting.status_code.exception');
			$serviceResponse['Message'] = $exc->getMessage();
			$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
			$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.exception'), false);
			return $sendServiceResponse;
		}
	}



	public function active_update(Request $request)
	{
		try {

			$method = 'Method => firmadministrationController => active_update';
			$inputArray = $request->requestData;
			$inputArray = $this->decryptData($inputArray);
			$input = [
				'id' => $inputArray['id'],
				'active_flag' => $inputArray['active_flag'],

			];
			$update_id =  DB::table('firm_partners')
				->where([['partner_id', $input['id']]])
				->update([

					'active_flag' => $input['active_flag']
				]);
			$id = $input['id'];
			$users = DB::select("SELECT name from users where id= $id");
			$partner_name = $users[0]->name;
			if ($input['active_flag'] == 1) {
				$message = `Partner $partner_name has been Deactivated from the Firm.`;
				$data = 1;
			} else {
				$message = `Partner $partner_name has been Activated from the Firm.`;
				$data = 2;
			}
			if ($update_id) {
				$notifications = DB::table('notifications')->insertGetId([
					'user_id' => auth()->user()->id,
					'notification_status' => 'Firm Administration',
					'notification_url' => 'firm_admin',
					'megcontent' => "Activated the Firm Partner Successfully",
					'alert_meg' => "Activated the Firm Partner Successfully",
					'created_by' => auth()->user()->id,
					'created_at' => NOW()
				]);
			}
			$role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
			$role_name_fetch = $role_name[0]->role_name;
			$this->auditLog('firm_partners', $update_id, 'Update', $message, $input['id'], NOW(), $role_name_fetch);

			$serviceResponse = array();
			$serviceResponse['Code'] = config('setting.status_code.success');
			$serviceResponse['Message'] = config('setting.status_message.success');
			$serviceResponse['Data'] = $data;
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


	public function permission_update(Request $request)
	{
		try {

			$method = 'Method => firmadministrationController => active_update';
			$inputArray = $request->requestData;
			$inputArray = $this->decryptData($inputArray);
			$input = [
				'id' => $inputArray['id'],
				'active_flag' => $inputArray['active_flag'],

			];
			$update_id =  DB::table('firm_partners')
				->where([['partner_id', $input['id']]])
				->update([

					'active_flag' => $input['active_flag']
				]);



			$notifications = DB::table('notifications')->insertGetId([
				'user_id' => auth()->user()->id,
				'notification_status' => 'Firm Administration',
				'notification_url' => 'firm_admin',
				'megcontent' => 'Partner Pemission Updated Successfully',
				'alert_meg' => 'Partner Pemission Updated Successfully',
				'created_by' => auth()->user()->id,
				'created_at' => NOW()
			]);

			$role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
			$role_name_fetch = $role_name[0]->role_name;
			$this->auditLog('firm_partners', $update_id, 'Update', 'Partner Permission Updated Successfully', $input['id'], NOW(), $role_name_fetch);



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


	public function permission_store(Request $request)
	{
		$this->WriteFileLog($request);
		try {

			$method = 'Method => firmadministrationController => permission_store';
			$inputArray = $request->requestData;
			$inputArray = $this->decryptData($inputArray);
			$input = [

				'partner_id' => $inputArray['partner_id'],
				'firm_id' => $inputArray['firm_id'],
				'active_permission' => $inputArray['active_permission'],
				'give_permission' => $inputArray['give_permission'],
				'delete_permission' => $inputArray['delete_permission']

			];
			$this->WriteFileLog($input);
			$partner_id = $input['partner_id'];

			$firm_data = DB::select("SELECT * FROM firm_permissions WHERE partner_id = $partner_id");
			$this->WriteFileLog(empty($firm_data));
			if (empty($firm_data)) {

				$firmpermission = DB::table('firm_permissions')
					->insertGetId([
						'partner_id' => $input['partner_id'],
						'firm_id' => $input['firm_id'],
						'active_permission' => 'off',
						'give_permission' => 'off',
						'delete_permission' => 'off',
						'created_by' => auth()->user()->id,
						'created_at' => NOW()
					]);
			}
			$firm_data = DB::select("SELECT * FROM firm_permissions WHERE partner_id = $partner_id");

			$users = DB::select("SELECT name FROM users where id= '$partner_id'");

			$user_name = $users[0]->name;
			$name = $user_name . '';
			$this->WriteFileLog('active_permission');
			$this->WriteFileLog($input['active_permission']);

			if ($input['active_permission'] != $firm_data[0]->active_permission) {
				$this->WriteFileLog("1");

				if ($input['active_permission'] == "on") {
					$this->WriteFileLog("2");

					$notifications = DB::table('notifications')->insertGetId([
						'user_id' => auth()->user()->id,
						'notification_status' => 'Firm Administration',
						'notification_url' => 'firm_admin',
						'megcontent' => "Enable/Disable Permission as been given to the user $name Successfully",
						'alert_meg' => "Enable/Disable Permission as been given to the user $name Successfully",
						'created_by' => auth()->user()->id,
						'created_at' => NOW()
					]);

					$notifications = DB::table('notifications')->insertGetId([
						'user_id' => $partner_id,
						'notification_status' => 'Firm Administration',
						'notification_url' => 'firm_admin',
						'megcontent' => "You have been allocated with Enable/Disable Permission in the Firm Successfully",
						'alert_meg' => "You have been allocated with Enable/Disable Permission in the Firm Successfully",
						'created_by' => auth()->user()->id,
						'created_at' => NOW()
					]);
				} else {

					$notifications = DB::table('notifications')->insertGetId([
						'user_id' => auth()->user()->id,
						'notification_status' => 'Firm Administration',
						'notification_url' => 'firm_admin',
						'megcontent' => "Enable/Disable Permission as been Removed for the user $name Successfully",
						'alert_meg' => "Enable/Disable Permission as been Removed for the user $name Successfully",
						'created_by' => auth()->user()->id,
						'created_at' => NOW()
					]);
					$notifications = DB::table('notifications')->insertGetId([
						'user_id' => $partner_id,
						'notification_status' => 'Firm Administration',
						'notification_url' => 'firm_admin',
						'megcontent' => "Enable/Disable Feature have been removed by the Firm Admin $name.",
						'alert_meg' => "Enable/Disable Feature have been removed by the Firm Admin $name.",
						'created_by' => auth()->user()->id,
						'created_at' => NOW()
					]);
				}
			}

			if ($input['give_permission'] != $firm_data[0]->give_permission) {

				if ($input['give_permission'] == "on") {
					$notifications = DB::table('notifications')->insertGetId([
						'user_id' => auth()->user()->id,
						'notification_status' => 'Firm Administration',
						'notification_url' => 'firm_admin',
						'megcontent' => "Allocating Permission as been given to the user $name Successfully",
						'alert_meg' => "Allocating Permission as been given to the user $name Successfully",
						'created_by' => auth()->user()->id,
						'created_at' => NOW()
					]);
					$notifications = DB::table('notifications')->insertGetId([
						'user_id' => $partner_id,
						'notification_status' => 'Firm Administration',
						'notification_url' => 'firm_admin',
						'megcontent' => "You have been Allocated with Enable/Disable Given Permission by the Firm user $name Successfully",
						'alert_meg' => "You have been Allocated with Enable/Disable Given Permission by the Firm user $name Successfully",
						'created_by' => auth()->user()->id,
						'created_at' => NOW()
					]);
				} else {
					$notifications = DB::table('notifications')->insertGetId([
						'user_id' => auth()->user()->id,
						'notification_status' => 'Firm Administration',
						'notification_url' => 'firm_admin',
						'megcontent' => "Allocation Permission as been Remove to the user $name Successfully",
						'alert_meg' => "Allocation Permission as been Remove to the user $name Successfully",
						'created_by' => auth()->user()->id,
						'created_at' => NOW()
					]);
					$notifications = DB::table('notifications')->insertGetId([
						'user_id' =>  $partner_id,
						'notification_status' => 'Firm Administration',
						'notification_url' => 'firm_admin',
						'megcontent' => "Enable/Disable Given Permission Feature have been removed by the Firm Admin $name Successfully.",
						'alert_meg' => "Enable/Disable Given Permission Feature have been removed by the Firm Admin $name Successfully",
						'created_by' => auth()->user()->id,
						'created_at' => NOW()
					]);
				}
			}

			if ($input['delete_permission'] != $firm_data[0]->delete_permission) {

				if ($input['delete_permission'] == "on") {
					$notifications = DB::table('notifications')->insertGetId([
						'user_id' => auth()->user()->id,
						'notification_status' => 'Firm Administration',
						'notification_url' => 'firm_admin',
						'megcontent' => "Deleting the Partners Permission as been given to the user $name Successfully",
						'alert_meg' => "Deleting the Partners Permission as been given to the user $name Successfully",
						'created_by' => auth()->user()->id,
						'created_at' => NOW()
					]);
					$notifications = DB::table('notifications')->insertGetId([
						'user_id' =>  $partner_id,
						'notification_status' => 'Firm Administration',
						'notification_url' => 'firm_admin',
						'megcontent' => "Enable/Disable Deleting Permission as been given to the Firm Admin Successfully",
						'alert_meg' => "Enable/Disable Deleting Permission as been given to the Firm Admin Successfully",
						'created_by' => auth()->user()->id,
						'created_at' => NOW()
					]);
				} else {
					$notifications = DB::table('notifications')->insertGetId([
						'user_id' => auth()->user()->id,
						'notification_status' => 'Firm Administration',
						'notification_url' => 'firm_admin',
						'megcontent' => "Deleting the Partners Permission as been Removed for the user $name Successfully",
						'alert_meg' =>  "Deleting the Partners Permission as been Removed for the user $name Successfully",
						'created_by' => auth()->user()->id,
						'created_at' => NOW()
					]);
					$notifications = DB::table('notifications')->insertGetId([
						'user_id' =>  $partner_id,
						'notification_status' => 'Firm Administration',
						'notification_url' => 'firm_admin',
						'megcontent' => "Enable/Disable Deleting Permission as been Removed for the Firm Admin $name Successfully",
						'alert_meg' =>  "Enable/Disable Deleting Permission as been Removed for the Firm Admin $name Successfully",
						'created_by' => auth()->user()->id,
						'created_at' => NOW()
					]);
				}
			}
			$firm_data = DB::select('SELECT COUNT(*) AS count FROM firm_permissions WHERE partner_id = :partner_id', [':partner_id' => $input['partner_id']]);
			$this->WriteFileLog($firm_data);
			if ($firm_data[0]->count == 0) {
				DB::transaction(function () use ($input) {
					$firmpermission = DB::table('firm_permissions')
						->insertGetId([
							'partner_id' => $input['partner_id'],
							'firm_id' => $input['firm_id'],
							'active_permission' => $input['active_permission'],
							'give_permission' => $input['give_permission'],
							'delete_permission' => $input['delete_permission'],
							'created_by' => auth()->user()->id,
							'created_at' => NOW()
						]);
				});
				# code...
			} else {
				DB::table('firm_permissions')
					->where('firm_id', $input['firm_id'])
					->where('partner_id', $input['partner_id'])
					->update([
						'active_permission' => $input['active_permission'],
						'give_permission' => $input['give_permission'],
						'delete_permission' => $input['delete_permission'],
						'updated_by' => auth()->user()->id,
						'updated_at' => NOW()
					]);
			}




			$role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
			$role_name_fetch = $role_name[0]->role_name;
			$this->auditLog('firm_partners', '', 'Update', '', auth()->user()->id, NOW(), $role_name_fetch);


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


	public function firmadmin_fetch(Request $request)
	{

		try {
			$method = 'Method => firmadministrationController => firmadmin_fetch';
			$userID = auth()->user()->id;
			$inputArray = $this->decryptData($request->requestData);
			$input = [
				'id' => $inputArray['id'],
			];
			$id = $input['id'];
			$rows = DB::select("SELECT * FROM firm_permissions where partner_id = $id");
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

	public function firmadmin_leave(Request $request)
	{


		try {
			$method = 'Method => firmadministrationController => firmadmin_leave';
			$userID = auth()->user()->id;
			// $inputArray = $this->decryptData($request->requestData);
			$input = [
				'id' => $userID,
			];
			$id = $input['id'];
			$update_id =  DB::table('firm_partners')
				->where([['partner_id', $input['id']]])
				->update([

					'active_flag' => 2
				]);


			$notifications = DB::table('notifications')->insertGetId([
				'user_id' => auth()->user()->id,
				'notification_status' => 'Firm Administration',
				'notification_url' => 'firm_admin',
				'megcontent' => 'Partner Leave the Firm Successfully',
				'alert_meg' => 'Partner Leave the Firm  Successfully',
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
