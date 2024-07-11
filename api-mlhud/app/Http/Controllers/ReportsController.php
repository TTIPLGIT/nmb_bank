<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DateTime;
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
use Illuminate\Support\Facades\Auth;

class ReportsController extends BaseController
{
	public function user_reports($status_by, $role_by, $from_date, $to_date)
	{
		$Where = '';

		if (!isset($status_by) && empty($role_by) && empty($from_date) && empty($to_date)) {
			$rows = DB::select("SELECT u.name,u.email,COALESCE(u.role_designation, ur.role_name) AS imaginary_column,DATE(u.created_at),u.active_flag 
			FROM users AS u INNER JOIN uam_user_roles AS uur ON u.id = uur.user_id INNER JOIN uam_roles AS ur ON ur.role_id = uur.role_id");
		} else {
			if (isset($status_by)) {
				$Where = empty($Where) ? 'u.active_flag=' . $status_by : $Where . ' and u.active_flag=' . $status_by;
			}
			if (!empty($role_by)) {
				$Where = empty($Where) ? 'COALESCE(u.role_designation, ur.role_name)="' . $role_by . '"' : $Where . ' and COALESCE(u.role_designation, ur.role_name)="' . $role_by . '"';
			}
			if (!empty($from_date) && !empty($to_date)) {
				$Where = empty($Where) ? "DATE(u.created_at) BETWEEN '" . $from_date . "' AND '" . $to_date . "'" : $Where . " and DATE(u.created_at) BETWEEN '" . $from_date . "' AND '" . $to_date . "'";
			} else {
				if (!empty($from_date)) {
					$Where = empty($Where) ? 'DATE(u.created_at)="' . $from_date . '"' : $Where . ' and DATE(u.created_at)="' . $from_date . '"';
				}
				if (!empty($to_date)) {
					$Where = empty($Where) ? 'DATE(u.created_at)="' . $to_date . '"' : $Where . ' and DATE(u.created_at)="' . $to_date . '"';
				}
			}
			
			$rows = DB::select("SELECT u.name,u.email,COALESCE(u.role_designation, ur.role_name) AS imaginary_column,DATE(u.created_at),u.active_flag 
			FROM users AS u INNER JOIN uam_user_roles AS uur ON u.id = uur.user_id INNER JOIN uam_roles AS ur ON ur.role_id = uur.role_id Where " . $Where);
		}

		return $rows;
	}
	public function firm_reports($licence_by, $from_date, $to_date)
	{
		$Where = '';
		if (empty($licence_by) && empty($from_date) && empty($to_date)) {
			$rows = DB::select("SELECT fr.firm_name,GROUP_CONCAT(u.name) as uid,DATE(fr.created_at),
			CASE 
			WHEN fr.status = 0 THEN 'Pending'
			ELSE 'Active'
			END AS status 
			FROM firm_registration AS fr 
			INNER JOIN firm_partners AS fp ON fr.id=fp.firm_id
			INNER JOIN users AS u on u.id=fp.partner_id 
			GROUP BY fr.firm_name,DATE(fr.created_at),fr.status");
			
		} else {
			if (!empty($licence_by)) {
				$Where = empty($Where) ? 'fr.status=' . $licence_by : $Where . ' and fr.status=' . $licence_by;
			}
			if (!empty($from_date) && !empty($to_date)) {
				$Where = empty($Where) ? "DATE(fr.created_at) BETWEEN '" . $from_date . "' AND '" . $to_date . "'" : $Where . " and DATE(fr.created_at) BETWEEN '" . $from_date . "' AND '" . $to_date . "'";
			} else {
				if (!empty($from_date)) {
					$Where = empty($Where) ? "DATE(fr.created_at)='" . $from_date . "'" : $Where . " and DATE(fr.created_at)='" . $from_date . "'";
				}
				if (!empty($to_date)) {
					$Where = empty($Where) ? "DATE(fr.created_at)='" . $to_date . "'" : $Where . " and DATE(fr.created_at)='" . $to_date . "'";
				}
			}
			$rows = DB::select("SELECT fr.firm_name,GROUP_CONCAT(u.name) as uid,DATE(fr.created_at),
			CASE WHEN fr.status = 0 THEN 'Pending'ELSE 'Active'END AS status 
			FROM firm_registration AS fr INNER JOIN firm_partners AS fp ON fr.id=fp.firm_id
			INNER JOIN users AS u on u.id=fp.partner_id where " . $Where . "
			GROUP BY fr.firm_name,DATE(fr.created_at),fr.status");
		}

		return $rows;
	}
	public function Licensed_reports($license_status, $from_date, $to_date)
	{
		$Where = '';
		if (!isset($license_status) && empty($from_date) && empty($to_date)) {
			$rows = DB::select("SELECT u.name,pml.license_number,DATE(pml.created_at),pml.renewal_date,pml.status FROM users AS u
			LEFT JOIN professional_member_licence AS pml ON u.id = pml.user_id INNER JOIN uam_user_roles AS uur ON uur.user_id=u.id WHERE role_id ='34'");
		} else {
			if (isset($license_status)) {
				$Where = empty($Where) ? 'pml.status=' . $license_status : $Where . ' and pml.status=' . $license_status;
				if ($license_status == "0" || $license_status == "1") {
					$Where = empty($Where) ? 'pml.license_number IS not NULL' : $Where . ' and pml.license_number IS not NULL';
				} else {
					$Where = empty($Where) ? 'pml.license_number IS NULL' : $Where . ' and pml.license_number IS NULL';
				}
			}
			if (!empty($license_status) && !empty($from_date) && !empty($to_date)) {
				$Where = empty($Where) ? "DATE(pml.created_at) BETWEEN '" . $from_date . "' AND '" . $to_date . "'" : $Where . " and DATE(pml.created_at) BETWEEN '" . $from_date . "' AND '" . $to_date . "'";
			} else {
				if (!empty($from_date)) {
					$Where = empty($Where) ? "DATE(pml.created_at)='" . $from_date . "'" : $Where . " and DATE(pml.created_at)='" . $from_date . "'";
				}
				if (!empty($to_date)) {
					$Where = empty($Where) ? "DATE(pml.created_at)='" . $to_date . "'" : $Where . " and DATE(pml.created_at)='" . $to_date . "'";
				}
			}
			
			$rows = DB::select("SELECT u.name,pml.license_number,DATE(pml.created_at),pml.renewal_date,pml.status FROM users AS u
			LEFT JOIN professional_member_licence AS pml ON u.id = pml.user_id INNER JOIN uam_user_roles AS uur ON uur.user_id=u.id WHERE role_id ='34' and " . $Where);
		}
		return $rows;
	}
	public function gt_reports($gtstatus, $from_date, $to_date)
	{
		$Where = '';
		if (empty($gtstatus) && empty($from_date) && empty($to_date)) {
			$this->WriteFileLog($gtstatus);
			$rows = DB::select("SELECT 
			u1.name AS GTname,
			SUBSTRING_INDEX(GROUP_CONCAT(u.name), ',', 1) AS councelor,
			SUBSTRING_INDEX(GROUP_CONCAT(gp.approval_status), ',', 1) AS councelor_status,
			SUBSTRING_INDEX(GROUP_CONCAT(u.name), ',', -1) AS supervisor,
			SUBSTRING_INDEX(GROUP_CONCAT(gp.approval_status), ',', -1) AS supervisor_status,g.status  
		FROM gt_approve_process AS gp
		INNER JOIN users AS u ON u.id = gp.approval_persons_id
		INNER JOIN users AS u1 ON u1.id = gp.user_id
		INNER JOIN gt AS g ON g.user_id = gp.user_id
		GROUP BY gp.user_id,g.status;");
		} else {
			if (!empty($gtstatus)) {
				$Where = empty($Where) ? "g.status='" . $gtstatus ."'" : $Where . " and g.status='" . $gtstatus. "'";
			}
			if (!empty($from_date) && !empty($to_date)) {
				$Where = empty($Where) ? "DATE(gp.created_at) BETWEEN '" . $from_date . "' AND '" . $to_date . "'" : $Where . " and DATE(gp.created_at) BETWEEN '" . $from_date . "' AND '" . $to_date . "'";
			} else {
				if (!empty($from_date)) {
					$Where = empty($Where) ? "DATE(gp.created_at)='" . $from_date . "'" : $Where . " and DATE(gp.created_at)='" . $from_date . "'";
				}
				if (!empty($to_date)) {
					$Where = empty($Where) ? "DATE(gp.created_at)='" . $to_date . "'" : $Where . " and DATE(gp.created_at)='" . $to_date . "'";
				}
			}
			
			$rows = DB::select("SELECT 
			u1.name AS GTname,
			SUBSTRING_INDEX(GROUP_CONCAT(u.name), ',', 1) AS councelor,
			SUBSTRING_INDEX(GROUP_CONCAT(gp.approval_status), ',', 1) AS councelor_status,
			SUBSTRING_INDEX(GROUP_CONCAT(u.name), ',', -1) AS supervisor,
			SUBSTRING_INDEX(GROUP_CONCAT(gp.approval_status), ',', -1) AS supervisor_status,g.status   
			FROM gt_approve_process AS gp
			INNER JOIN users AS u ON u.id = gp.approval_persons_id
			INNER JOIN users AS u1 ON u1.id = gp.user_id
			INNER JOIN gt AS g ON g.user_id = gp.user_id where " . $Where . " GROUP BY gp.user_id,g.status;");
		}


		return $rows;
	}
	public function instruction_reports($valuer_type, $valuer_status, $from_date, $to_date)
	{
		$Where = '';
		if (empty($valuer_type) && !isset($valuer_status) && empty($from_date) && empty($to_date)) {
			$rows = DB::select("SELECT id.task_name,u.name AS value_name,u1.name AS stakholder_name,
			CASE 
			WHEN id.status = 0 THEN 'Pending'
			WHEN id.status = 2 THEN 'In-Review'
			WHEN id.status = 3 THEN 'Received'
			ELSE 'Rejected'
			END AS status
			FROM instruction_details as id
			INNER JOIN users AS u ON u.id = id.valuer_id
			INNER JOIN users AS u1 ON u1.id = id.stakeholder_id");
		} else {
			if (!empty($valuer_type)) {
				$Where = empty($Where) ? 'id.type=' . $valuer_type : $Where . ' and id.type=' . $valuer_type;
			}
			if (isset($valuer_status)) {
				$Where = empty($Where) ? 'id.status=' . $valuer_status : $Where . ' and id.status=' . $valuer_status;
			}
			if (!empty($from_date) && !empty($to_date)) {
				$Where = empty($Where) ? "DATE(id.created_at) BETWEEN '" . $from_date . "' AND '" . $to_date . "'" : $Where . " and DATE(id.created_at) BETWEEN '" . $from_date . "' AND '" . $to_date . "'";
			} else {
				if (!empty($from_date)) {
					$Where = empty($Where) ? "DATE(id.created_at)='" . $from_date . "'" : $Where . " and DATE(id.created_at)='" . $from_date . "'";
				}
				if (!empty($to_date)) {
					$Where = empty($Where) ? "DATE(id.created_at)='" . $to_date . "'" : $Where . " and DATE(id.created_at)='" . $to_date . "'";
				}
			}
			
			$rows = DB::select("SELECT id.task_name,u.name AS value_name,u1.name AS stakholder_name,
			CASE 
			WHEN id.status = 0 THEN 'Pending'
			WHEN id.status = 2 THEN 'In-Review'
			WHEN id.status = 3 THEN 'Received'
			ELSE 'Rejected'
			END AS status
			FROM instruction_details as id
			INNER JOIN users AS u ON u.id = id.valuer_id
			INNER JOIN users AS u1 ON u1.id = id.stakeholder_id where " . $Where);
		}

		return $rows;
	}
	public function financial_reports($payment_type, $from_date, $to_date)
	{

		$Where = '';
		if ($from_date) {
			$fdate = Carbon::createFromFormat('Y-m-d', $from_date);
			$from_date = $fdate->format('d-m-y');
		}
		if ($to_date) {
			$tdate = Carbon::createFromFormat('Y-m-d', $to_date);
			$to_date = $tdate->format('d-m-y');
		}


		if (empty($payment_type) && empty($from_date) && empty($to_date)) {
			$rows = DB::select("SELECT u.name,p.bank_transaction_id,p.amount,CASE WHEN p.amount_paid_on IS NOT NULL THEN 'license payment' ELSE 'firm payment' END AS type,p.amount_paid_on AS paymentDate FROM professional_member_licence AS p INNER JOIN users as u ON p.user_id = u.id UNION 
			SELECT u1.name,up.bank_transaction_id,up.amount,
			CASE WHEN up.paid_on IS NOT NULL THEN 'firm payment' ELSE 'license payment' END AS type,up.paid_on AS paymentDate
			FROM user_payment_details AS up
			INNER JOIN users as u1 ON up.user_id = u1.id");
		} else {
			if (!empty($payment_type)) {
				$Where = empty($Where) ? 'combined_data.type=' . "'$payment_type'" : $Where . ' and combined_data.type=' . "'$payment_type'";
			}
			if (!empty($from_date) && !empty($to_date)) {
				$Where = empty($Where) ? "combined_data.paymentDate BETWEEN '" . $from_date . "' AND '" . $to_date . "'" : $Where . " and combined_data.paymentDate= BETWEEN '" . $from_date . "' AND '" . $to_date . "'";
			} else {
				if (!empty($from_date)) {
					$Where = empty($Where) ? "combined_data.paymentDate='" . $from_date . "'" : $Where . " and combined_data.paymentDate='" . $from_date . "'";
				}
				if (!empty($to_date)) {
					$Where = empty($Where) ? "combined_data.paymentDate='" . $to_date . "'" : $Where . " and combined_data.paymentDate='" . $to_date . "'";
				}
			}

			$this->WriteFileLog("SELECT * FROM (SELECT u.name,p.bank_transaction_id,p.amount,CASE WHEN p.amount_paid_on IS NOT NULL THEN 'license payment' ELSE 'firm payment' END AS type,p.amount_paid_on AS paymentDate FROM professional_member_licence AS p INNER JOIN users as u ON p.user_id = u.id UNION 
			SELECT u1.name,up.bank_transaction_id,up.amount,
			CASE WHEN up.paid_on IS NOT NULL THEN 'firm payment' ELSE 'license payment' END AS type,up.paid_on AS paymentDate
			FROM user_payment_details AS up
			INNER JOIN users as u1 ON up.user_id = u1.id)AS combined_data where " . $Where);
			$rows = DB::select("SELECT * FROM (SELECT u.name,p.bank_transaction_id,p.amount,CASE WHEN p.amount_paid_on IS NOT NULL THEN 'license payment' ELSE 'firm payment' END AS type,p.amount_paid_on AS paymentDate FROM professional_member_licence AS p INNER JOIN users as u ON p.user_id = u.id UNION 
			SELECT u1.name,up.bank_transaction_id,up.amount,
			CASE WHEN up.paid_on IS NOT NULL THEN 'firm payment' ELSE 'license payment' END AS type,up.paid_on AS paymentDate
			FROM user_payment_details AS up
			INNER JOIN users as u1 ON up.user_id = u1.id)AS combined_data where " . $Where);
		}
		return $rows;
	}
	public function Elearning_reports($course_details,$courselist, $from_date, $to_date)
	{
		$Where = '';

		if ($course_details == "2") {
			if (!empty($course_details) && empty($from_date) && empty($to_date)) {
				$rows = DB::select("SELECT event_name,event_description,event_date FROM elearning_events WHERE event_status='0'");
			} else {
				if (!empty($from_date) && !empty($to_date)) {
					$from_date = new DateTime($from_date);
					$from_date_format = $from_date->format('d-m-Y');
					$to_date = new DateTime($to_date);
					$to_date_format = $to_date->format('d-m-Y');
					$Where = empty($Where) ? "event_date BETWEEN '" . $from_date_format . "' AND '" . $to_date_format . "'" : $Where . " and event_date BETWEEN '" . $from_date_format . "' AND '" . $to_date_format . "'";
				} else {
					if (!empty($from_date)) {
						$from_date = new DateTime($from_date);
						$from_date_format = $from_date->format('d-m-Y');
						$Where = empty($Where) ? 'event_date="' . $from_date_format . '"' : $Where . ' and event_date="' . $from_date_format . '"';
					}
					if (!empty($to_date)) {
						$to_date = new DateTime($to_date);
					    $to_date_format = $to_date->format('d-m-Y');
						$Where = empty($Where) ? 'event_date="' . $to_date_format . '"' : $Where . ' and event_date="' . $to_date_format . '"';
					}
				}
					$this->WriteFileLog("SELECT event_name,event_description,event_date FROM elearning_events WHERE event_status='0' and " . $Where);
					$rows = DB::select("SELECT event_name,event_description,event_date FROM elearning_events WHERE event_status='0' and " . $Where);
			}
		}
		else if($course_details == "3"){
			if (!empty($course_details) && empty($from_date) && empty($to_date)) {
				$rows = DB::select("SELECT notice_name,notice_description,notice_author,notice_date FROM elearning_noticeboard");
			} else {
				if (!empty($from_date) && !empty($to_date)) {
					$from_date = new DateTime($from_date);
					$from_date_format = $from_date->format('d-m-Y');
					$to_date = new DateTime($to_date);
					$to_date_format = $to_date->format('d-m-Y');
					$Where = empty($Where) ? "notice_date BETWEEN '" . $from_date_format . "' AND '" . $to_date_format . "'" : $Where . " and notice_date BETWEEN '" . $from_date_format . "' AND '" . $to_date_format . "'";
				} else {
					if (!empty($from_date)) {
						$from_date = new DateTime($from_date);
						$from_date_format = $from_date->format('d-m-Y');
						$Where = empty($Where) ? 'notice_date="' . $from_date_format . '"' : $Where . ' and notice_date="' . $from_date_format . '"';
					}
					if (!empty($to_date)) {
						$to_date = new DateTime($to_date);
					    $to_date_format = $to_date->format('d-m-Y');
						$Where = empty($Where) ? 'notice_date="' . $to_date_format . '"' : $Where . ' and notice_date="' . $to_date_format . '"';
					}
				}
				$rows = DB::select("SELECT notice_name,notice_description,notice_author,notice_date FROM elearning_noticeboard WHERE " . $Where);
			}
		}
		else if($course_details == "1"){
			if (!empty($course_details) && empty($courselist) && empty($from_date) && empty($to_date)) {
				$rows = DB::select("SELECT user_name,course_name,get_certified,DATE(course_enroll_date),Date(course_completion_date),course_status FROM user_course_relation");
			} else {
				if (!empty($courselist)) {
					$Where = empty($Where) ? 'course_id=' . $courselist : $Where . ' and course_id=' . $courselist;
				}
				if (!empty($from_date) && !empty($to_date)) {
					$Where = empty($Where) ? "DATE(course_enroll_date) BETWEEN '" . $from_date . "' AND '" . $to_date . "'" : $Where . " and DATE(course_enroll_date) BETWEEN '" . $from_date . "' AND '" . $to_date . "'";
				} else {
					if (!empty($from_date)) {
						$Where = empty($Where) ? 'DATE(course_enroll_date)="' . $from_date . '"' : $Where . ' and DATE(course_enroll_date)="' . $from_date . '"';
					}
					if (!empty($to_date)) {
						$Where = empty($Where) ? 'DATE(course_enroll_date)="' . $to_date . '"' : $Where . ' and DATE(course_enroll_date)="' . $to_date . '"';
					}
				}
				$rows = DB::select("SELECT user_name,course_name,get_certified,DATE(course_enroll_date),Date(course_completion_date),course_status FROM user_course_relation WHERE " . $Where);
			}
		}

		return $rows;

	}
	public function report_fetch(Request $request)
	{
		try {
			$logMethod = 'Method => RegistrationController => report_fetch';

			$user_id = (auth()->check()) ? auth()->user()->id : $request['user_id'];

			$inputArray = $this->decryptData($request->requestData);
			$data['module_name'] = $inputArray['module_name'];
			$data['process_name'] = $inputArray['process_name'];
			$data['status_by'] = $inputArray['status_by'];
			$data['from_date'] = $inputArray['from_date'];
			$data['to_date'] = $inputArray['to_date'];
			$data['role_by'] = $inputArray['role_by'];
			$data['license_by'] = $inputArray['license_by'];
			$data['license_status'] = $inputArray['license_status'];
			$data['gtstatus'] = $inputArray['gtstatus'];
			$data['valuer_type'] = $inputArray['valuer_type'];
			$data['valuer_status'] = $inputArray['valuer_status'];
			$data['payment_type'] = $inputArray['payment_type'];
			$data['course_details'] = $inputArray['course_details'];
			$data['courselist'] = $inputArray['courselist'];
			$this->WriteFileLog($data['status_by'] = $inputArray['status_by']);
			if ($data['process_name'] == '1') {
				$user_report = $this->user_reports($data['status_by'], $data['role_by'], $data['from_date'], $data['to_date']);
			} elseif ($data['process_name'] == '2') {
				$user_report = $this->firm_reports($data['license_by'], $data['from_date'], $data['to_date']);
			} elseif ($data['process_name'] == '3') {
				$user_report = $this->Licensed_reports($data['license_status'], $data['from_date'], $data['to_date']);
			} elseif ($data['process_name'] == '4') {
				$user_report = $this->gt_reports($data['gtstatus'], $data['from_date'], $data['to_date']);
			} elseif ($data['process_name'] == '5') {
				$user_report = $this->instruction_reports($data['valuer_type'], $data['valuer_status'], $data['from_date'], $data['to_date']);
			} elseif ($data['process_name'] == '8') {
				$user_report = $this->financial_reports($data['payment_type'], $data['from_date'], $data['to_date']);
			} elseif ($data['process_name'] == '6') {
				$user_report = $this->Elearning_reports($data['course_details'],$data['courselist'], $data['from_date'], $data['to_date']);
			} else {
				$this->WriteFileLog("saranya MCA");
			}

			

			$serviceResponse = array();
			$serviceResponse['Code'] = config('setting.status_code.success');
			$serviceResponse['Message'] = config('setting.status_message.success');
			$serviceResponse['Data'] = $user_report;
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
