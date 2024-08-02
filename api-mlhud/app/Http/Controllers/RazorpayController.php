<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\For_;
use PhpParser\Node\Stmt\If_;
use Illuminate\Support\Facades\Mail;
use App\Mail\paymentMail;
use App\Mail\firmpaymentMail;
use App\Mail\CoursePaymentMail;
use App\Mail\paymentrenewalMail;

class RazorpayController extends BaseController

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function payment(Request $request)
    {
        try {
            $method = 'Method => RazorpayController =>payment';
            $inputArray = $request->requestData;
            $inputArray = $this->decryptData($inputArray);
            $base_url = config('setting.base_url');


            $data = [
                'name' => $inputArray['name'],
                'email' => $inputArray['email'],
                'amount' => $inputArray['amt'],
                'bank_transaction_id' => $inputArray['bank_transaction_id'],
                'time' => $inputArray['amount_on'],
                'method' => $inputArray['Payment Method'],
                'base_url' => $base_url,


            ];



            Mail::to($data['email'])->send(new firmpaymentMail($data));

            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => auth()->user()->id,
                'notification_status' => 'Payment Details',
                'notification_url' => 'firm_index',
                'megcontent' => "Your payment has been successfully received..",
                'alert_meg' => "Your payment has been successfully received..",
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



    public function licensepayment(Request $request)
    {
        $this->WriteFileLog($request);
        try {

            $method = 'Method => RazorpayController => licensepayment';
            $inputArray = $request->requestData;
            $inputArray = $this->decryptData($inputArray);
            $userID = Auth::id();
            $base_url = config('setting.base_url');

            $renewal_date = date('d-m-y', strtotime('+12 months'));

            $valuer_id = auth()->user()->id;

            $licenseNumber = licenseapprovalController::generateLicenseNumber($valuer_id);
            $current_date = date('d-m-y');
            $firm = DB::select("SELECT firm_id FROM firm_partners WHERE partner_id=$userID");
            if ($firm == []) {

                $firm_id = null;
            } else {
                $firm_id = $firm[0]->firm_id;
            }
            $data = [
                'name' => $inputArray['name'],
                'email' => $inputArray['email'],
                'amount' => $inputArray['amt'],
                'bank_transaction_id' => $inputArray['bank_transaction_id'],
                'time' => $inputArray['amount_on'],
                'method' => $inputArray['Payment Method'],
                'base_url' => $base_url,
                'renewal_date' => $renewal_date,
                'licence_number' => $licenseNumber,
                'firm_id' => $firm_id,
                'user_id' => $userID,
                'valuerType' => $inputArray['valuerType']

            ];
            $is_update = DB::select("SELECT * FROM professional_member_licence WHERE user_id= $userID AND status=1");
            $this->WriteFileLog($is_update);
            if ($is_update == []) {
                DB::transaction(function () use ($data) {
                    $role_id = DB::table('professional_member_licence')
                        ->insertGetId([
                            'bank_transaction_id' => $data['bank_transaction_id'],
                            'amount' => $data['amount'],
                            'method' => $data['method'],
                            'user_id' => $data['user_id'],
                            'amount_paid_on' => $data['time'],
                            'license_number' => $data['licence_number'],
                            'renewal_date' => $data['renewal_date'],
                            'firm_names' => $data['firm_id'],
                            'valuer_type' => $data['valuerType'],
                            'status' => "0",
                            'created_at' => Now()
                        ]);
                        $valuerType = ($data['valuerType'] == "Government Valuer") ? "GV" : "PV";
                        $user_ID = $data['user_id'];
                        $designation_update = DB::table('users')
                        ->where('id', $user_ID)
                        ->update(['role_designation' => $valuerType]);

                    //  $this->auditLog('user_general_details', $role_id, 'Create', 'Create Valuer general details', $input['user_id'], NOW(), '');
                });


                Mail::to($data['email'])->send(new paymentMail($data));

                $notifications = DB::table('notifications')->insertGetId([
                    'user_id' => auth()->user()->id,
                    'notification_status' => 'Payment Details',
                    'notification_url' => 'Licensepay',
                    'megcontent' => "Payment Successful on Licence",
                    'alert_meg' => "Payment Successful on Licence",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);
            } else {
                DB::transaction(function () use ($data) {
                    DB::table('professional_member_licence')
                        ->where('user_id', $data['user_id'])
                        ->update([
                            'bank_transaction_id' => $data['bank_transaction_id'],
                            'amount' => $data['amount'],
                            'method' => $data['method'],
                            'amount_paid_on' => $data['time'],
                            'renewal_date' => $data['renewal_date'],
                            'firm_names' => $data['firm_id'],
                            'status' => "0",
                            'updated_at' => Now()
                        ]);

                    // $this->auditLog('user_general_details', $data['user_id'], 'Update', 'Update Valuer general details', $data['user_id'], NOW(), '');
                });

                Mail::to($data['email'])->send(new paymentrenewalMail($data));


                $notifications = DB::table('notifications')->insertGetId([
                    'user_id' => auth()->user()->id,
                    'notification_status' => 'Payment Details',
                    'notification_url' => 'Licensepay',
                    'megcontent' => "Your License has been renewal.",
                    'alert_meg' => "Your License has been renewal.",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);
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

    public function licensepaymentmobile(Request $request)
    {
        $this->WriteFileLog($request);
        try {

            $method = 'Method => RazorpayController => licensepayment';
            $inputArray = $request->requestData;
            $inputArray = $this->decryptData($inputArray);
            $userID = Auth::id();
            $base_url = config('setting.base_url');

            $renewal_date = date('d-m-y', strtotime('+12 months'));

            $valuer_id = auth()->user()->id;

            $licenseNumber = licenseapprovalController::generateLicenseNumber($valuer_id);
            $current_date = date('d-m-y');
            $firm = DB::select("SELECT firm_id FROM firm_partners WHERE partner_id=$userID");
            if ($firm == []) {

                $firm_id = null;
            } else {
                $firm_id = $firm[0]->firm_id;
            }
            $data = [
                'name' => $inputArray['name'],
                'email' => $inputArray['email'],
                'amount' => $inputArray['amt'],
                'bank_transaction_id' => $inputArray['bank_transaction_id'],
                'time' => $inputArray['amount_on'],
                'method' => $inputArray['Payment Method'],
                'base_url' => $base_url,
                'renewal_date' => $renewal_date,
                'licence_number' => $licenseNumber,
                'firm_id' => $firm_id,
                'user_id' => $userID

            ];
            $is_update = DB::select("SELECT * FROM professional_member_licence WHERE user_id= $userID AND status=1");
            $this->WriteFileLog($is_update);
            if ($is_update == []) {
                DB::transaction(function () use ($data) {
                    $role_id = DB::table('professional_member_licence')
                        ->insertGetId([

                            'bank_transaction_id' => $data['bank_transaction_id'],
                            'amount' => $data['amount'],
                            'method' => $data['method'],
                            'user_id' => $data['user_id'],
                            'amount_paid_on' => $data['time'],
                            'license_number' => $data['licence_number'],
                            'renewal_date' => $data['renewal_date'],
                            'firm_names' => $data['firm_id'],
                            'status' => "0",
                            'created_at' => Now()

                        ]);



                    //  $this->auditLog('user_general_details', $role_id, 'Create', 'Create Valuer general details', $input['user_id'], NOW(), '');
                });


                Mail::to($data['email'])->send(new paymentMail($data));

                $notifications = DB::table('notifications')->insertGetId([
                    'user_id' => auth()->user()->id,
                    'notification_status' => 'Payment Details',
                    'notification_url' => 'Licensepay',
                    'megcontent' => "Payment Successful on Licence",
                    'alert_meg' => "Payment Successful on Licence",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);
            } else {
                DB::transaction(function () use ($data) {
                    DB::table('professional_member_licence')
                        ->where('user_id', $data['user_id'])
                        ->update([
                            'bank_transaction_id' => $data['bank_transaction_id'],
                            'amount' => $data['amount'],
                            'method' => $data['method'],
                            'amount_paid_on' => $data['time'],
                            'renewal_date' => $data['renewal_date'],
                            'firm_names' => $data['firm_id'],
                            'status' => "0",
                            'updated_at' => Now()
                        ]);

                    // $this->auditLog('user_general_details', $data['user_id'], 'Update', 'Update Valuer general details', $data['user_id'], NOW(), '');
                });

                Mail::to($data['email'])->send(new paymentrenewalMail($data));


                $notifications = DB::table('notifications')->insertGetId([
                    'user_id' => auth()->user()->id,
                    'notification_status' => 'Payment Details',
                    'notification_url' => 'Licensepay',
                    'megcontent' => "Your License has been renewal.",
                    'alert_meg' => "Your License has been renewal.",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);
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
    public function summarypayment(Request $request)
    {
        try {

            $method = 'Method => RazorpayController => summarypayment';
            $inputArray = $request->requestData;
            $inputArray = $this->decryptData($inputArray);
            $base_url = config('setting.base_url');
            $data = [
                'name' => $inputArray['name'],
                'email' => $inputArray['email'],
                'amount' => $inputArray['amount'],
                'bank_transaction_id' => $inputArray['bank_transaction_id'],
                'paid_on' => $inputArray['paid_on'],
                'course_id' => $inputArray['course_id'],
                'method' => $inputArray['method'],
                'base_url' => $base_url

            ];
            $id = $inputArray['course_id'];
            $encryptArray = $this->encryptData($id);
            $request = array();
            $request['requestData'] = $encryptArray;

            Mail::to($data['email'])->send(new CoursePaymentMail($data));

            $this->notifications_insert(null, auth()->user()->id, "Course Payment Details", "/elearningCourse/" . $encryptArray);
            $role_name = DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=" . auth()->user()->id);
            $role_name_fetch = $role_name[0]->role_name;
            $this->auditLog('Course Payment', $data, 'Paid Courses', 'Course Payment Successfully', auth()->user()->id, NOW(), $role_name_fetch);

            // $notifications = DB::table('notifications')->insertGetId([
            //     'user_id' => auth()->user()->id,
            //     'notification_status' => 'Payment Details',
            //     'notification_url' => 'Licensepay',
            //     'megcontent' => "Payment Successful on Licence, You can now Apply for it.",
            //     'alert_meg' => "Payment Successful on Licence, You can now Apply for it.",
            //     'created_by' => auth()->user()->id,
            //     'created_at' => NOW()
            // ]);
            // Mail::to($data['email'])->send(new paymentMail($data));

            // $notifications = DB::table('notifications')->insertGetId([
            //     'user_id' => auth()->user()->id,
            //     'notification_status' => 'Payment Details',
            //     'notification_url' => 'Licensepay',
            //     'megcontent' => "Payment Successful on Licence, You can now Apply for it.",
            //     'alert_meg' => "Payment Successful on Licence, You can now Apply for it.",
            //     'created_by' => auth()->user()->id,
            //     'created_at' => NOW()
            // ]);

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
