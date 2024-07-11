<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class paymentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {  
        $user_id=$request->session()->get("userID");
        if($user_id==null){
            return view('auth.login');
        }
        $user_id=$request->session()->get("userID");
        
        return view('Registration.payment', compact('user_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        
        $user_id=$request->session()->get("userID");
        
        {
            $data = array();
            $data['price'] = $request->p_name;
            $data['plan'] = $request->exampleRadios;
            $data['user_id'] = $user_id;
            $data['ren_date']=$request->ren_date;
            $method = 'Method => Questionmaster => store';
            $encryptArray = $data;
            $request = array();
            $request['requestData'] = $encryptArray;
            $gatewayURL = config('setting.api_gateway_url').'/payment/store';
        
            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response1 = json_decode($response);
            if($response1->Status == 200 && $response1->Success){
            $objData = json_decode($this->decryptData($response1->Data));
                    if ($objData->Code == 200) {
                        return redirect(route('Registration.index'))->with('success', 'Payment Successfull');
                    }
        
                if ($objData->Code == 400) {    
                    return redirect(url('qmaster'))->with('fail', 'Question Already Exists');
                    }
            }
    
    
            else {
            $objData = json_decode($this->decryptData($response1->Data));
            echo json_encode($objData->Code);exit;                            
            }
        }
            //
    }
    
        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
    

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
