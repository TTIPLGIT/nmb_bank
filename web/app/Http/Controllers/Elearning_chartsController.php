<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Elearning_chartsController extends BaseController
{
    public function index(Request $request)
    {
        $user_id = $request->session()->get("userID");
        if ($user_id == null) {
            return view('auth.login');
        }

        $menus = $this->FillMenu();
        if ($menus == "401") {
            return redirect(url('/'))->with('danger', 'User session Expired');
        }

        $screens = $menus['screens'];
        $modules = $menus['modules'];

        // $gatewayURL = config('setting.api_gateway_url') . '/attendance_tracking';


        // $response = json_decode(
        //     $this->serviceRequest($gatewayURL, 'GET', null, 'GET')
        // );

        // $rows = [];
        // if ($response && $response->Status == 200 && $response->Success) {
        //     $objData = json_decode($this->decryptData($response->Data));
        //     $parant_data = json_decode(json_encode($objData->Data), true);
        //     $rows = $parant_data['rows'];
        // }


        return view("elearning_charts.charts", compact('screens', 'modules'));
        // return view("elearning_charts.charts");
    }

    // public function showAllTables()
    // {
    //     $tables = DB::select('SHOW TABLES');
    //     $tableKey = "Tables_in_ttipl_lms";
    //     $allData = [];
    //     // dd($tables );

    //     return response()->json($tables);
    // }
    //       public function showAllTables()
    //     {
    //         $tables = DB::select('SHOW TABLES');
    //         $tableKey = "Tables_in_ttipl_lms";
    //         $allData = [];
    // dd($tables );
    //         foreach ($tables as $table) {
    //             $tableName = $table->$tableKey;
    //             $rows = DB::table($tableName)->get();
    //             $allData[$tableName] = $rows;
    //         }

    //         return response()->json($allData);
    //     }
}
