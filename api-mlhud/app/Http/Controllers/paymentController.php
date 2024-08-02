<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class paymentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        try {
			$method = 'Method => General_registation => storedata';
			$inputArray = $request->requestData;
            $user_id = $request->user_id;
            

			$input = [
				'price' => $inputArray['price'],
				'plan' => $inputArray['plan'],
				'user_id' => $inputArray['user_id'],
                'ren_date'=>$inputArray['ren_date'],
			];
            
			if($input) {

               
				DB::transaction(function () use ($input) {
					$role_id = DB::table('user_payment_details')
						->insertGetId([
							'amount_paid' => $input['price'],
							'plan_name' => $input['plan'],
							'user_id' => $input['user_id'],
							'paid_on' => NOW(),
                            'status' =>"successful",    

						]);


					//  $this->auditLog('user_general_details', $role_id, 'Create', 'Create Valuer general details', $input['user_id'], NOW(), '');
				});
                //submit proccess
                $valuer_code=json_encode(DB::select("select valuer_code from valuer_list"));
            
                if($valuer_code=='[]'){
                    $valuer_code="VR/L/001";
                }
                else{
                    $valuer_code=(DB::table('valuer_list')->orderBy('valuer_id', 'desc')->first());
                    $valuer_code_new=$valuer_code->valuer_code;
                    $valuer_code=++$valuer_code_new;
                }
                $status="Pending";
                $input2 =[
                    'user_id' => $input['user_id'],
                    'valuer_code'=>$valuer_code,
                    'status'=>$status,
                    
                ];
                DB::transaction(function () use ($input2) {
                    $role_id = DB::table('valuer_list')
                        ->insertGetId([
                            'user_id' => $input2['user_id'],
                            'valuer_code' => $input2['valuer_code'],
                            'v_status' => $input2['status'],
                            'created_at' => NOW(),
    
                        ]);

                       
                        $notifications = DB::table('notifications')->insertGetId([
                            'user_id' => auth()->user()->id,
                            'notification_status' => 'Payment Paid',
                            'notification_url' => 'Registration',
                            'megcontent' => "Payment Paid Successfully.",
                            'alert_meg' => "Payment Paid Successfully.",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                        $role_name=DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);
                        $role_name_fetch=$role_name[0]->role_name;
                        $this->auditLog('user_payment_details', $input2['user_id'], 'Payment', 'Valuer Payment Details', auth()->user()->id, NOW(), $role_name_fetch);


                        $notifications_valuer = DB::table('notifications')->insertGetId([
                            'user_id' => auth()->user()->id,
                            'role_id'=>'1',
                            'notification_status' => 'valuer registered',
                            'notification_url' => 'valuerlist',
                            'megcontent' => "Valuer has been Registerd In The Portal.",
                            'alert_meg' => "Valuer has been Registerd In The Portal.",
                            'created_by' => auth()->user()->id,
                            'created_at' => NOW()
                        ]);
                        $role_name=DB::select("SELECT role_name FROM uam_roles AS ur INNER JOIN users us ON (us.array_roles=ur.role_id) WHERE us.id=".auth()->user()->id);
                        $role_name_fetch=$role_name[0]->role_name;
                        $this->auditLog('valuer_list', $input2['user_id'], 'Registered', 'Valuer Registerd in the portal', auth()->user()->id, NOW(), $role_name_fetch);


                    });
                DB::table('user_payment_details')
                    ->where('user_id', $input2['user_id'])
                    ->update(['requested_at' =>now()]);

                DB::table('user_general_details')
                    ->where('user_id', $input2['user_id'])
                    ->update(['g_status' =>'Submitted']);    
                   
                
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
