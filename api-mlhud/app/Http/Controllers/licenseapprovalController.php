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

class licenseapprovalController extends BaseController
{


	/**
	 * Author: Anbukani
	 * Date: 04/06/2021
	 * Description: Get the user token based on email and password.
	 **/


	public function license_index(Request $request)
	{



		$logMethod = 'Method => licenseapprovalController => User';
		try {
			$userID = (auth()->check()) ? auth()->user()->id : $request['user_id'];
			$id = (auth()->check()) ? auth()->user()->id : $request['id'];
			$data_rows = DB::select("SELECT id  from users where id = $userID and total_cptpoints >= 20 and active_flag='0'");

			if (empty($data_rows)) {

				$serviceResponse = array();
				$serviceResponse['Code'] = config('setting.status_code.not_found');
				$serviceResponse['Message'] = config('setting.status_message.not_found');
				$serviceResponse['Data'] = 404;
				$serviceResponse = json_encode($serviceResponse, JSON_FORCE_OBJECT);
				$sendServiceResponse = $this->SendServiceResponse($serviceResponse, config('setting.status_code.success'), true);
				return $sendServiceResponse;
			}

			$rows['payment_license'] = DB::select("SELECT professional_member_licence.license_number,professional_member_licence.status,users.name,professional_member_licence.amount_paid_on,professional_member_licence.amount,professional_member_licence.bank_transaction_id,professional_member_licence.method,professional_member_licence.renewal_date,professional_member_licence.valuer_type  from professional_member_licence inner join users on professional_member_licence.user_id=users.id where professional_member_licence.user_id='$userID';");
			$rows['firm_license'] = DB::select("SELECT firm_name,firm_partners.partner_id FROM firm_partners inner join firm_registration ON firm_partners.firm_id = firm_registration.id INNER JOIN professional_member_licence ON professional_member_licence.user_id = firm_partners.partner_id WHERE professional_member_licence.user_id ='$id';");



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

	public static function generateLicenseNumber($id)
	{
		$prefix = "VAL/";
		$suffix = rand(1000, 9999); // Generate a random 4-digit number
		$currentYear = date("Y");
		$licenseNumber = $prefix . $currentYear . '/' . $suffix . '/' . $id; // Concatenate the prefix, current year, and suffix

		return $licenseNumber;
	}

	public function license_reg(Request $request)
	{

		try {
			$logMethod = 'Method => licenseapprovalController => license_reg';
			$inputArray = $request->requestData;
			$inputArray = $this->decryptData($inputArray);
			$user_id = (auth()->check()) ? auth()->user()->id : $request['user_id'];

			$valuer_id = (auth()->check()) ? auth()->user()->id : $request['valuer_id'];

			$licenseNumber = licenseapprovalController::generateLicenseNumber($valuer_id);
			$current_date = date('d-m-y');

			// Get the renewal date
			$renewal_date = date('d-m-y', strtotime('+12 months'));
			$input = [
				'user_id' => $inputArray['user_id'],
				'firm_names' => $inputArray['firm_names'],
				// 'annualcpd_name' => $inputArray['annualcpdn'],
				// 'annualcpd_path' => $inputArray['annualcpdp'],
				'valuer_id' => $valuer_id,
				'licence_number' => $licenseNumber,
				'renewal_date' => $renewal_date



			];


			if ($input) {


				DB::transaction(function () use ($input) {
					$update_id =  DB::table('professional_member_licence')
						->where([['user_id', $input['valuer_id']]])
						->update([
							'firm_names' => $input['firm_names'],
							// 'annualcpd_name' => $input['annualcpd_name'],
							// 'annualcpd_path' => $input['annualcpd_path'],
							'license_number' => $input['licence_number'],
							'renewal_date' => $input['renewal_date'],
							'status' => '0'

						]);
				});

				$renewal_date = $input['renewal_date'];
				$licence_number = $input['licence_number'];

				$email = $this->getusermail($input['valuer_id']);
				$name = $this->getusername($input['valuer_id']);
				$base_url = config('setting.base_url');
				$data = array(
					'name' => $name,
					'email' => $email,
					'renewal_date' => $renewal_date,
					'licence_number' => $licence_number,
					'base_url' => $base_url,
				);
				Mail::to($data['email'])->send(new licenseMail($data));
			}


			$notifications = DB::table('notifications')->insertGetId([
				'user_id' => auth()->user()->id,
				'notification_status' => 'License Registration ',
				'notification_url' => 'Licensepay',
				'megcontent' => "License Registration Successfully Completed, Your Licence Number-$licenseNumber",
				'alert_meg' => "License Registration Successfully Completed, Your Licence Number-$licenseNumber.",
				'created_by' => auth()->user()->id,
				'created_at' => NOW()
			]);


			//  $this->auditLog('user_general_details', $role_id, 'Create', 'Create Valuer general details', $input['user_id'], NOW(), '');




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
}
