<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UamDataController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 

        public function parent_data(Request $request)
    {
         try {
            $method = 'Method => UamDataController => parent_data';     
            $data = array();
            $data['user_id'] = $request->user_id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
              //  echo json_encode($request);exit;

            $gatewayURL = env('API_GATEWAY_URL').'/uam_data/parent_data';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response = json_decode($response);
            if($response->Status == 200 && $response->Success){
                 $rows = $this->decryptData($response->Data);
                 return $rows;
            }
        } catch(\Exception $exc){            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }



        public function screen_data(Request $request)
    {
         try {
            $method = 'Method => UamDataController => screen_data';     
            $data = array();
            $data['user_id'] = $request->user_id;
             $data['module_id'] = $request->module_id;
            $encryptArray = $this->encryptData($data);
            $request = array();
            $request['requestData'] = $encryptArray;
              //  echo json_encode($request);exit;

            $gatewayURL = env('API_GATEWAY_URL').'/uam_data/screen_data';

            $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
            $response = json_decode($response);
            if($response->Status == 200 && $response->Success){
                 $rows = $this->decryptData($response->Data);
                 return $rows;
            }
        } catch(\Exception $exc){            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }



// public function get_modules(Request $request)
//     {

//         //return $request;
//          try {
//             $method = 'Method => UamUserController => get_modules';
                   
//             $data = array();

//             $data['role_id'] = $request->role_id;
            
           
//             $encryptArray = $this->encryptData($data);
//             $request = array();
//             $request['requestData'] = $encryptArray;
//          //echo json_encode($request);exit;
//             $gatewayURL = env('API_GATEWAY_URL').'/uam_user/get_modules';

//             //echo $gatewayURL;exit;
//             $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
//             $response = json_decode($response);

//            //echo json_encode($response);exit;

//             if($response->Status == 200 && $response->Success){

//                  $rows = $this->decryptData($response->Data);
               
//                 return $rows;
//             }
//         } catch(\Exception $exc){            
//             return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
//         }
//     }




// public function get_screens(Request $request)
//     {

//         //return $request;
//          try {
//             $method = 'Method => UamUserController => get_screens';
                   
//             $data = array();

//             $data['role_id'] = $request->role_id;
//             $data['module_id'] = $request->module_id;
            
           
//             $encryptArray = $this->encryptData($data);
//             $request = array();
//             $request['requestData'] = $encryptArray;
//          //echo json_encode($request);exit;
//             $gatewayURL = env('API_GATEWAY_URL').'/uam_user/get_screens';

//             //echo $gatewayURL;exit;
//             $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
//             $response = json_decode($response);

//            //echo json_encode($response);exit;

//             if($response->Status == 200 && $response->Success){

//                  $rows = $this->decryptData($response->Data);
               
//                 return $rows;
//             }
//         } catch(\Exception $exc){            
//             return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
//         }
//     }


//     public function get_permissions(Request $request)
//     {

//         //return $request;
//          try {
//             $method = 'Method => UamUserController => get_permissions';
                   
//             $data = array();

//             $data['role_id'] = $request->role_id;
//             $data['module_id'] = $request->module_id;
//             $data['screen_id'] = $request->screen_id;
            
           
//             $encryptArray = $this->encryptData($data);
//             $request = array();
//             $request['requestData'] = $encryptArray;
//          //echo json_encode($request);exit;
//             $gatewayURL = env('API_GATEWAY_URL').'/uam_user/get_permissions';

//             //echo $gatewayURL;exit;
//             $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
//             $response = json_decode($response);

//            //echo json_encode($response);exit;

//             if($response->Status == 200 && $response->Success){

//                  $rows = $this->decryptData($response->Data);
               
//                 return $rows;
//             }
//         } catch(\Exception $exc){            
//             return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
//         }
//     }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         try {
            $method = 'Method => UamUserController => store';
                   
           //  $data = array();

           //  $data['role_id'] = $request->role_id;
           //  $data['user_id'] = $request->user_id;
            
           
           //  $encryptArray = $this->encryptData($data);
           //  $request = array();
           //  $request['requestData'] = $encryptArray;
           //  //echo json_encode($request);exit;
           //  $gatewayURL = env('API_GATEWAY_URL').'/uam_user_roles/storedata';

           //  //echo $gatewayURL;exit;
           //  $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
           //  $response = json_decode($response);

           // // echo json_encode($response);exit;

           //  if($response->Status == 200 && $response->Success){
               
                //return redirect(route('uam_user_roles.index'))->with('success', 'Uam user roles created successfully');
            // }
        } catch(\Exception $exc){            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }


//     public function storedata(Request $request)
//     {
//         //return $request;

//        try {
//         $method = 'Method => UamUserController => storedata';

//         $data = array();

//         $data['user_id'] = $request->user_id;
//         $data['screen_id'] = $request->screen_id;
//         $data['permission_id'] = $request->permission_id;



//         $encryptArray = $this->encryptData($data);
//         $request = array();
//         $request['requestData'] = $encryptArray;
//             echo json_encode($request);exit;
//         $gatewayURL = env('API_GATEWAY_URL').'/uam_user/storedata';

//             //echo $gatewayURL;exit;
//         $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
//         $response = json_decode($response);

//             echo json_encode($response);exit;

       
//     } catch(\Exception $exc){            
//         return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
//     }
// }




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
        try {
            $method = 'Method => UamDataController => edit';

       //      $id = $this->decryptData($id);

       //      $gatewayURL = env('API_GATEWAY_URL').'/uam_user_roles/data_edit/'.$this->encryptData($id);

       //      $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

       //       $response = json_decode($response);


       // $get_user_data =  env('API_GATEWAY_URL').'/uam_user_roles/get_user_data';

       //  $get_user = $this->serviceRequest($get_user_data, 'GET', '', $method);  

       //  $get_user = json_decode($get_user);
       //  //echo json_encode($wurfees);exit;

       //  $get_roles_data =  env('API_GATEWAY_URL').'/uam_user_roles/get_roles_data';

       //  $get_roles = $this->serviceRequest($get_roles_data, 'GET', '', $method);  

       //  $get_roles = json_decode($get_roles);  



       //  //echo json_encode($response);exit;
       //  if($response->Status == 200 && $response->Success){
       //      $rows = $this->decryptData($response->Data);

       //      $get_roles = $this->decryptData($get_roles->Data);
       //      $get_user = $this->decryptData($get_user->Data);


       return view('uam.uam_user.edit');
// }

        } catch(\Exception $exc){            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_data(Request $request)
    {
      //  echo "sdfs";exit;
//return $request;

        try {
            $method = 'Method => UamDataController => update_data';
                   
//             $data = array();

//           $data['user_id'] = $request->user_id;
//             $data['role_id'] = $request->role_id;
//             $data['user_role_id'] = $request->user_role_id;
   
// //echo $id;exit;
           
//             $encryptArray = $this->encryptData($data);
//             $request = array();
//             $request['requestData'] = $encryptArray;
//             //echo json_encode($request);exit;
//             $gatewayURL = env('API_GATEWAY_URL').'/uam_user_roles/updatedata';

//             //echo $gatewayURL;exit;

//             $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
//             $response = json_decode($response);

//           // echo json_encode($response);exit;

//             if($response->Status == 200 && $response->Success){
               
//                 return redirect(route('uam_user_roles.index'))->with('success', 'Uam user roles updated successfully');
//             }
        } catch(\Exception $exc){            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function update($update,$id)
    {
        //echo "sdf";exit;
        //
    }


    public function destroy($id)
    {
        //echo "sdf";exit;
        //
    }

    public function delete($id)
    {
       // echo "sdf";exit;
      try {
            $method = 'Method => UamDataController => delete';

            // $id = $this->decryptData($id);

            // $gatewayURL = env('API_GATEWAY_URL').'/uam_user_roles/data_delete/'.$this->encryptData($id);

            // //echo $gatewayURL;exit;

            // $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            // //echo json_encode($response);exit;

            // if(json_decode($response)->Status == 200){

            //     return redirect(route('uam_user_roles.index'))->with('success', 'Uam user roles deleted successfully.');
            // }else{
            //     return redirect(route('uam_user_roles.index'))->with('error', 'Uam user roles deletion error.');
            // }


        } catch(\Exception $exc){            
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }

    }


}
