<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class AlertController extends BaseController
{
    /**
     * Author: Anbukani
     * Date: 20/09/2019
     * Description: Alert meessage.
     */
    public function index($id)
    {
		$logMethod = 'Method => AlertController => index';
        try {            
            $response = $this->decryptData($id);
            $objResponse = json_decode($response);
            $redirect = $objResponse->redirect;
            $message = $objResponse->message;
            $alertTitle = $objResponse->title;            
			$menus = $this->FillMenu();
			$screens = $menus['screens'];
			$modules = $menus['modules'];
            return view('alert.index', compact('redirect', 'message', 'alertTitle', 'modules', 'screens'));
        } catch(\Exception $exc){            
            $exceptionResponse = array();
			$exceptionResponse['ServiceMethod'] = $logMethod;
			$exceptionResponse['Exception'] = $exc->getMessage();
			$exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
			$this->WriteFileLog($exceptionResponse);
        }
    }

    public function book()
    {		
        return view('claim.invoice.processing.bookajax', compact('modules', 'screens'));
    }



    public function not_allow(){
        
          $logMethod = 'Method => AlertController => not_allow';
        try {                       
            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            return view('alert.notallowed', compact('modules', 'screens'));
        } catch(\Exception $exc){            
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $logMethod;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
        }

    }

     public function not_allow_loose_minute(){

          $logMethod = 'Method => AlertController => not_allow_loose_minute';
        try {                       
            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            return view('alert.not_allow_loose_minute', compact('modules', 'screens'));
        } catch(\Exception $exc){            
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $logMethod;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
        }

    }


     public function not_allow_document_receipt(){

          $logMethod = 'Method => AlertController => not_allow_document_receipt';
        try {                       
            $menus = $this->FillMenu();
            $screens = $menus['screens'];
            $modules = $menus['modules'];
            return view('alert.not_allow_document_receipt', compact('modules', 'screens'));
        } catch(\Exception $exc){            
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = $logMethod;
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
        }

    }




	// public function unauthenticated(Request $request) 
	// {
 //        // $user_id=json_encode(Session::get('userID'));
 //        // // echo $user_id;exit;
 //        // $data = array(); 
 //        // $data['user_id'] = $user_id;
 //        // $encryptArray = $this->encryptData($data);
 //        // $request = array();
 //        // $request['requestData'] = $encryptArray;

 //        //   $gatewayURL = config('setting.api_gateway_url').'/user/unauthenticated';
 //        //   $method = 'Method => AlertController => index';
 //        // $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);


 //        //        $response = json_decode($response);

               
	// 	$request->session()->flush();

	// 	$modules = '';
	// 	$screens = '';
	// 	return view('alert.unauthenticated', compact('modules', 'screens'));                      		
	// }

     public function unauthenticated(Request $request)
{
  // echo "cjvh";exit;

try{ 
$method = 'Method => LoginController => login_screen';

$gatewayURL = config('setting.api_gateway_url').'/login/background';
$response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
$response = json_decode($response);
if($response->Status == 200 && $response->Success){
$objData = json_decode($this->decryptData($response->Data)); 
if ($objData->Code == 200) {
$parant_data = json_decode(json_encode($objData->Data), true);
$rows =  $parant_data['rows'];
$modules['bg_images']=$rows;
$request->session()->flush();

        $modules['data'] = '';
        $screens = '';
        return view('alert.unauthenticated', compact('modules', 'screens','rows'));  


  

}
} 
else {
$objData = json_decode($this->decryptData($response->Data));
echo json_encode($objData->Code);exit;                            
}
}
catch(\Exception $exc){  
echo $exc;          
return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
}

  
}

    

    public function tokenexpire(Request $request) 
    {
        // $user_id=json_encode(Session::get('userID'));
        // // echo $user_id;exit;
        // $data = array();
        // $data['user_id'] = $user_id;
        // $encryptArray = $this->encryptData($data);
        // $request = array();
        // $request['requestData'] = $encryptArray;

        //   $gatewayURL = config('setting.api_gateway_url').'/user/unauthenticated';
        //   $method = 'Method => AlertController => index';
        // $response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);


        //        $response = json_decode($response);

               
        $request->session()->flush();
        $modules = '';
        $screens = '';
        return view('alert.tokenexpire', compact('modules', 'screens'));                            
    }








}
