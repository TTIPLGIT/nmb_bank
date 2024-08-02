<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Redirect;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\paymentMail;
use Illuminate\Support\Arr;

class RazorpayController extends BaseController
{
    public function razorpay()
    {


        return view('Firm_Registration.index');
    }

    public function payment(Request $request)
    {

        try {

            $method = 'Method => RazorpayController =>payment';
            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }
            $input = $request->all();

            if ($mobile == 0) {
                $api = new Api(config('setting.RAZORPAY_KEY'), config('setting.RAZORPAY_SECRET'));
                $payment = $api->payment->fetch($input['razorpay_payment_id']);
                $tranction_id = isset($payment['acquirer_data']['bank_transaction_id']) ? $payment['acquirer_data']['bank_transaction_id'] : null;
                $payment_rupees = $payment['amount'] / 100;
                $payment_method = $payment['method'];
                $payment_bank = $payment['bank'];
            } else {
                $tranction_id = mt_rand(100000, 999999);
                $payment_rupees = '2000';
                $payment_method = 'Online';
                $payment_bank = 'ICICI';
            }
            // dd($input);
            // $api = new Api(config('setting.RAZORPAY_KEY'), config('setting.RAZORPAY_SECRET'));
            // $payment = $api->payment->fetch($input['razorpay_payment_id']);
            $user_id = $request->session()->get("userID");
            $date = Carbon::now()->format('d-m-y');
            $time = Carbon::now()->format('d-m-y');
            // $payment_rupees = $payment['amount'] / 100;
            // if (!isset($payment['acquirer_data']['bank_transaction_id'])) {
            //     // \Session::put('error', 'Method not included yet please try net banking');
            //     return redirect()->back()->with('error', 'Method not included yet please try net banking');
            // }
            $input = [
                'bank_transaction_id' => $tranction_id,
                'bank' => $payment_bank,
                'user_id' => $user_id,
                'amount' => $payment_rupees,
                'method' => $payment_method,
                'date' => $date,
                'time' => $time

            ];

            DB::transaction(function () use ($input) {
                $role_id = DB::table('user_payment_details')
                    ->insertGetId([

                        'bank_transaction_id' => $input['bank_transaction_id'],
                        'bank_name' => $input['bank'],
                        'amount' => $input['amount'],
                        'method' => $input['method'],
                        'user_id' => $input['user_id'],
                        'paid_on' => $input['date'],
                        'status' => "successful",
                        'created_at' => Now()

                    ]);


                //  $this->auditLog('user_general_details', $role_id, 'Create', 'Create Valuer general details', $input['user_id'], NOW(), '');
            });
            $data['name'] = $this->getusername($user_id);
            $data['email'] = $this->getusermail($user_id);
            $data['amt'] = $input['amount'];
            $data['bank_transaction_id'] = $input['bank_transaction_id'];
            $data['amount_on'] = $input['time'];
            $data['Payment Method'] = $input['method'];
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/razorpay_firmpayment';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), '');
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                if (count($input)  && !empty($input['razorpay_payment_id'])) {
                    try {
                        $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount' => $payment['amount']));
                    } catch (\Exception $e) {
                        return  $e->getMessage();
                        Session::put('error', $e->getMessage());
                        return redirect()->back();
                    }
                }
                $message = "Payment successful and confirmation mail sent successfully";
                if ($mobile == 1) {
                    $mobile_response = [
                        'code' => 200,
                        'message' => $message
                    ];
                    return $mobile_response;
                }
                // \Session::put('success', 'Payment successful.');
                return redirect()->back()->with('success', $message);
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //throw $th;

    }

    public function razorpaylicensepayment()
    {


        return view('License.license_index');
    }

    public function licensepayment(Request $request)
    {
        try {
            $method = 'Method => RazorpayController => licensepayment';
            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }
            $input = $request->all();
            // for web
            if ($mobile == 0) {
                $api = new Api(config('setting.RAZORPAY_KEY'), config('setting.RAZORPAY_SECRET'));
                $payment = $api->payment->fetch($input['razorpay_payment_id']);
                $tranction_id = isset($payment['acquirer_data']['bank_transaction_id']) ? $payment['acquirer_data']['bank_transaction_id'] : null;
                $payment_rupees = $payment['amount'] / 100;
                $valuerType = $input['valuerType'];
                $payment_method = $payment['method'];
            } else {
                $tranction_id = mt_rand(100000, 999999);
                $payment_rupees = '2000';
                $payment_method = 'Online';
                $valuerType = $input['valuerType'];
            }
            // for mobile
            $user_id = $request->session()->get("userID");
            $time = Carbon::now()->format('d-m-y');
            if ($tranction_id == null) {
                // \Session::put('error', 'Method not included yet please try net banking');
                return redirect()->back()->with('error', 'Method not included yet please try net banking');
            }
            $input = [
                'bank_transaction_id' => $tranction_id,
                'user_id' => $user_id,
                'amount' => $payment_rupees,
                'valuerType' => $valuerType,
                'method' => $payment_method,
                'time' => $time
            ];

            $data['name'] = $this->getusername($user_id);
            $data['email'] = $this->getusermail($user_id);
            $data['amt'] = $input['amount'];
            $data['bank_transaction_id'] = $input['bank_transaction_id'];
            $data['amount_on'] = $input['time'];
            $data['Payment Method'] = $input['method'];
            $data['valuerType'] = $input['valuerType'];






            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/razorpay_payment';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), '');
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                if (count($input)  && !empty($input['razorpay_payment_id'])) {
                    try {
                        $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount' => $payment['amount']));
                    } catch (\Exception $e) {
                        return  $e->getMessage();
                        Session::put('error', $e->getMessage());
                        return redirect()->back();
                    }
                }

                $message = "Payment successful and confirmation mail sent successfully";
                if ($mobile == 1) {
                    $mobile_response = [
                        'code' => 200,
                        'message' => $message
                    ];
                    return $mobile_response;
                }
                // \Session::put('success', 'Payment successful.');
                return redirect()->back()->with('success', $message);
            } else {
                $message = "Something went Wrong";
                if ($mobile == 1) {
                    $mobile_response = [
                        'code' => 500,
                        'message' => $message
                    ];
                    return $mobile_response;
                }
                return redirect()->back()->with('error', $message);
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function razorpaycourse()
    {


        return view('elearning.courseOverview.');
    }

    public function razorpaycoursepurchase(Request $request)
    {
        // dd($request);

        $input = $request->all();
        //dd($input);
        $api = new Api(config('setting.RAZORPAY_KEY'), config('setting.RAZORPAY_SECRET'));

        $payment = $api->payment->fetch($input['razorpay_payment_id']);




        $user_id = $request->session()->get("userID");
        $date = Carbon::now()->format('d-m-y');
        $data = array();
        $data['course_id'] = $request->course_id;
        $input = [
            'bank_transaction_id' => $payment['acquirer_data']['bank_transaction_id'],
            'bank' => $payment['bank'],
            'user_id' => $user_id,
            'amount' => $payment['amount'],
            'method' => $payment['method'],
            'date' => $date,
            'course_id' => $data['course_id'],
        ];



        DB::transaction(function () use ($input) {
            $role_id = DB::table('elearning_payment_details')
                ->insertGetId([

                    'bank_transaction_id' => $input['bank_transaction_id'],
                    'course_id' => $input['course_id'],
                    'bank_name' => $input['bank'],
                    'amount' => $input['amount'],
                    'method' => $input['method'],
                    'user_id' => $input['user_id'],
                    'paid_on' => $input['date'],
                    'status' => "successful",
                    'created_at' => Now()

                ]);
        });

        DB::table('elearning_cart')
            ->where('course_id', $input['course_id'])
            ->where('user_id', $user_id)
            ->delete();


        if (count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount' => $payment['amount']));
            } catch (\Exception $e) {
                return  $e->getMessage();
                Session::put('error', $e->getMessage());
                return redirect()->back();
            }
        }

        Session::put('success', 'Payment successful.');
        return redirect()->back();
    }
    public function summary()
    {
        return view('elearning.cart');
    }
    public function summary_payment(Request $request)
    {
        try {

            $method = 'Method => RazorpayController => summary_payment';
            // dd($request);

            $input = $request->all();

            $api = new Api(config('setting.RAZORPAY_KEY'), config('setting.RAZORPAY_SECRET'));

            $payment = $api->payment->fetch($input['razorpay_payment_id']);
            //dd($payment);



            $user_id = $request->session()->get("userID");

            $date = Carbon::now()->format('d-m-y');
            $data = array();
            $data['course_id'] = $request->course_id;
            //dd($data);
            $input = [
                'bank_transaction_id' => $payment['acquirer_data']['bank_transaction_id'],
                'bank' => $payment['bank'],
                'user_id' => $user_id,
                'amount' => $payment['amount'],
                'method' => $payment['method'],
                'date' => $date,
                'course_id' => $data['course_id'],
            ];

            //dd($input);

            DB::transaction(function () use ($input) {
                $role_id = DB::table('elearning_payment_details')
                    ->insertGetId([

                        'bank_transaction_id' => $input['bank_transaction_id'],
                        'course_id' => $input['course_id'],
                        'bank_name' => $input['bank'],
                        'amount' => $input['amount'],
                        'method' => $input['method'],
                        'user_id' => $input['user_id'],
                        'paid_on' => $input['date'],
                        'status' => "successful",
                        'created_at' => Now()

                    ]);
            });

            $data = DB::table('elearning_cart')
                ->where('user_id', $input['user_id'])
                ->delete();
            $data = array();

            $data['name'] = $this->getusername($user_id);
            $data['email'] = $this->getusermail($user_id);
            $data['amount'] = $input['amount'];

            $data['bank_transaction_id'] = $input['bank_transaction_id'];
            $data['paid_on'] = $input['date'];
            $data['course_id'] = $input['course_id'];
            $data['method'] = $input['method'];

            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url') . '/razorsummarypayment';
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), '');
            $response1 = json_decode($response);
            if ($response1->Status == 200 && $response1->Success) {
                if (count($input)  && !empty($input['razorpay_payment_id'])) {
                    try {
                        $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount' => $payment['amount']));
                    } catch (\Exception $e) {
                        return  $e->getMessage();
                        Session::put('error', $e->getMessage());
                        return redirect()->back();
                    }
                }

                // \Session::put('success', 'Payment successful.');
                return redirect()->back()->with('success', 'Payment successful and confirmation mail sent successfully');
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
}
