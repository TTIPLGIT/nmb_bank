<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\course;
use App\Models\courseCart;
use phpDocumentor\Reflection\Types\Null_;
use Illuminate\Support\Facades\Auth;

class CronjobController extends BaseController
{

    public function job_schedular(Request $request)
    {
        $this->WriteFileLog($request);
        $this->WriteFileLog("hxas");
        $method = 'Method => CronjobController => job_schedular';
        try {
            $gatewayURL = config('setting.api_gateway_url') . '/cronjob/schedular';
            $response = $this->serviceRequest($gatewayURL, 'GET',"", $method);
            $this->WriteFileLog($response);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    return 1;
                } else {
                  return "error";
                }
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
    public function schedular_endperiod(Request $request)
    {

       
        $method = 'Method => CronjobController => job_schedular';
        try {
            $gatewayURL = config('setting.api_gateway_url') . '/schedular/endperiod';
            $response = $this->serviceRequest($gatewayURL, 'GET',"", $method);
            $response = json_decode($response);
            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    return 1;
                } else {
                  return "error";
                }
            }
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }
}
