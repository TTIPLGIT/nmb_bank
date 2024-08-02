<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Log;
use Redirect;
use PHPJasper\PHPJasper;

class FAQController extends BaseController
{  

public function index()
{
    
try{ 
   
$method = 'Method => FAQquestionController => index'; 
$gatewayURL = config('setting.api_gateway_url').'/FAQ_questions_ans/get_faq_data';
$response = $this->serviceRequest($gatewayURL, 'GET', '', $method); 
$response = json_decode($response);
if($response->Status == 200 && $response->Success){
$objData = json_decode($this->decryptData($response->Data));
if ($objData->Code == 200) {
$parant_data = json_decode(json_encode($objData->Data), true);
$rows =  $parant_data['rows'];
$one_row =  $parant_data['one_rows'];

$gatewayURL = config('setting.api_gateway_url').'/login/background';
$response = $this->serviceRequest($gatewayURL, 'GET', '', $method);
$response = json_decode($response);
if($response->Status == 200 && $response->Success){
$objData = json_decode($this->decryptData($response->Data)); 
if ($objData->Code == 200) {
$parant_data = json_decode(json_encode($objData->Data), true);
$rows1 =  $parant_data['rows'];
// echo json_encode($one_row);exit;

 
return view('main_faq', compact('rows','one_row','rows1'));
}}}
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
public function main_index()
{
try{ 
$method = 'Method => FAQquestionController => index'; 
$gatewayURL = config('setting.api_gateway_url').'/FAQ_questions_ans/get_faq_data';
$response = $this->serviceRequest($gatewayURL, 'GET', '', $method); 
$response = json_decode($response);
if($response->Status == 200 && $response->Success){
$objData = json_decode($this->decryptData($response->Data));
if ($objData->Code == 200) {
$parant_data = json_decode(json_encode($objData->Data), true);
$rows =  $parant_data['rows'];
$one_row =  $parant_data['one_rows'];
$menus = $this->FillMenu();
$screens = $menus['screens'];
$modules = $menus['modules'];
// echo json_encode($one_row);exit;


return view('profile_faq', compact('rows','one_row','screens','modules'));
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

public function que_search(Request $request)
{
    
try {


$method = 'Method => FAQmodulesController => que_search';
$data = array();
$data['module_name'] = $request->module_name;

$encryptArray = $this->encryptData($data);
$request = array();
$request['requestData'] = $encryptArray;

$gatewayURL = config('setting.api_gateway_url').'/FAQ_questions_ans/get_search_ques';
$response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
$response1 = json_decode($response);



if($response1->Status == 200 && $response1->Success){
$objData = json_decode($this->decryptData($response1->Data));
echo $this->decryptData($response1->Data);
}
else {
$objData = json_decode($this->decryptData($response->Data));
echo json_encode($objData->Code);exit;                            
}
} catch(\Exception $exc){ 
echo $exc;           
return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
}
}
public function ans_search(Request $request)
{
try {
$method = 'Method => FAQmodulesController => ans_search';
$data = array();
$data['mod_id'] = $request->mod_id;

$encryptArray = $this->encryptData($data);
$request = array();
$request['requestData'] = $encryptArray;
$gatewayURL = config('setting.api_gateway_url').'/FAQ_questions_ans/get_search_ans';
$response = $this->serviceRequest($gatewayURL, 'POST', json_encode($request), $method);
$response1 = json_decode($response);


if($response1->Status == 200 && $response1->Success){
$objData = json_decode($this->decryptData($response1->Data));
echo $this->decryptData($response1->Data);
}
else {
$objData = json_decode($this->decryptData($response->Data));
echo json_encode($objData->Code);exit;                            
}
} catch(\Exception $exc){ 
echo $exc;           
return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
}
}

}