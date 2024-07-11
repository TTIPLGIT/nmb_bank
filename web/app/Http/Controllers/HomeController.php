<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use session;

class HomeController extends BaseController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)

    {
        try {



            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }
            $mobile = 0;
            if (isset($request->mobile)) {
                $mobile = 1;
            }


            $method = 'Method => HomeController => index';
            $gatewayURL = config('setting.api_gateway_url') . '/home/index';
            $response = $this->serviceRequest($gatewayURL, 'GET', '', $method);

            $response = json_decode($response);
            $userRole = $this->get_user_role();

            $overViewCount['Pending'] = 0;
            $overViewCount['Approved'] = 0;
            $overViewCount['Rejected'] = 0;

            $gt_approve['pending'] = 0;
            $gt_approve['approved'] = 0;
            $gt_approve['rejected'] = 0;

            $instruction_professional['pending'] = 0;
            $instruction_professional['inprogress'] = 0;
            $instruction_professional['approved'] = 0;

            $gt_process['Pending'] = 0;
            $gt_process['approved'] = 0;
            $gt_process['rejected'] = 0;

            // admin dashboard
            
            $admin['licenceCount'] = DB::table('professional_member_licence')
                            ->whereNotNull('license_number')
                            ->where('status', 0)
                            ->count();
            $admin['expiredLicenceCount'] = DB::table('professional_member_licence')
                            ->whereNotNull('license_number')
                            ->where('status', 1)
                            ->count();
            $admin['firmCount'] = DB::table('firm_registration')
                            ->where('status', 1)->count();
            $admin['expiredFirmCount'] = DB::table('firm_registration')
                            ->where('status', 3)->count();    

            $admin['registervaluer'] =DB::table('professional_member_licence')                                
                            ->whereNotNull('license_number')->count();
            $admin['graduatetrainee'] =DB::table('gt')                                
                             ->where('active_flag', 0)->count();
            $admin['registertrainee'] =DB::table('firm_registration')
                              ->count();
            $admin['tabledata']=DB::table('users as u')
            ->select('u.name', 'u.role_designation', 'u.created_at','uam.role_name')
            ->join('uam_user_roles as ur', 'ur.user_id', '=', 'u.id')
            ->join('uam_roles as uam', 'uam.role_id', '=', 'ur.role_id')
            ->where('ur.role_id', '=', '30')
            ->orWhereIn('u.role_designation', ['CGV', 'AC', 'PGV', 'SGV'])
            ->get();  

            if ($userRole->alter_name == config('setting.ROLE_NAME.professional_member')) {

                $overViewCount['Pending'] = DB::table('government_task_tracker as gt')
                    ->select('gt.government_task_id', 'gd.task_name', 'gd.stakeholder_id', 'gt.status as task_status', 'gt.Status')
                    ->join('government_task_details as gd', 'gd.id', '=', 'gt.government_task_id')
                    ->join('government_instruction_details as gid', 'gid.government_task_id', '=', 'gt.government_task_id')
                    ->groupBy('gid.government_task_id', 'gt.government_task_id', 'gd.task_name', 'gd.stakeholder_id', 'gt.status', 'gt.Status')
                    ->where([['gt.user_id', $user_id], ['gt.Status', 1], ['gt.Status', 5]])
                    ->count();
                $overViewCount['Approved'] = DB::table('government_task_tracker as gt')
                    ->select('gt.government_task_id', 'gd.task_name', 'gd.stakeholder_id', 'gt.status as task_status', 'gt.Status')
                    ->join('government_task_details as gd', 'gd.id', '=', 'gt.government_task_id')
                    ->join('government_instruction_details as gid', 'gid.government_task_id', '=', 'gt.government_task_id')
                    ->groupBy('gid.government_task_id', 'gt.government_task_id', 'gd.task_name', 'gd.stakeholder_id', 'gt.status', 'gt.Status')
                    ->where([['gt.user_id', $user_id], ['gt.Status', 4]])
                    ->count();
                $overViewCount['Rejected'] = 0;
                $gt_process['pending'] = DB::table('gt_approve_process')
                    ->select('*')
                    ->join('users', 'users.id', '=', 'gt_approve_process.user_id')
                    ->join('gt', 'gt.user_id', '=', 'gt_approve_process.user_id')
                    ->where('gt_approve_process.approval_persons_id', $user_id)
                    ->where('approval_status', 'Pending')
                    ->where('gt_approve_process.active_flag', 0)
                    ->count();
                $gt_process['approved'] = DB::table('gt_approve_process')
                    ->select('*')
                    ->join('users', 'users.id', '=', 'gt_approve_process.user_id')
                    ->join('gt', 'gt.user_id', '=', 'gt_approve_process.user_id')
                    ->where('gt_approve_process.approval_persons_id', $user_id)
                    ->where('approval_status', 'approved')
                    ->where('gt_approve_process.active_flag', 0)
                    ->count();
                $instruction_professional['pending'] = DB::table('government_task_tracker as gt')
                    ->select('gt.government_task_id', 'gd.task_name', 'gd.stakeholder_id', 'gt.status as task_status', 'gt.Status')
                    ->join('government_task_details as gd', 'gd.id', '=', 'gt.government_task_id')
                    ->join('government_instruction_details as gid', 'gid.government_task_id', '=', 'gt.government_task_id')
                    ->groupBy('gid.government_task_id', 'gt.government_task_id', 'gd.task_name', 'gd.stakeholder_id', 'gt.status', 'gt.Status')
                    ->where('gt.user_id', $user_id)
                    ->where('gt.Status', 1)
                    ->count();
                $instruction_professional['inprogress'] = DB::table('government_task_tracker as gt')
                    ->select('gt.government_task_id', 'gd.task_name', 'gd.stakeholder_id', 'gt.status as task_status', 'gt.Status')
                    ->join('government_task_details as gd', 'gd.id', '=', 'gt.government_task_id')
                    ->join('government_instruction_details as gid', 'gid.government_task_id', '=', 'gt.government_task_id')
                    ->groupBy('gid.government_task_id', 'gt.government_task_id', 'gd.task_name', 'gd.stakeholder_id', 'gt.status', 'gt.Status')
                    ->where('gt.user_id', $user_id)
                    ->where('gt.Status', 2)
                    ->count();
                $instruction_professional['approved'] = DB::table('government_task_tracker as gt')
                    ->select('gt.government_task_id', 'gd.task_name', 'gd.stakeholder_id', 'gt.status as task_status', 'gt.Status')
                    ->join('government_task_details as gd', 'gd.id', '=', 'gt.government_task_id')
                    ->join('government_instruction_details as gid', 'gid.government_task_id', '=', 'gt.government_task_id')
                    ->groupBy('gid.government_task_id', 'gt.government_task_id', 'gd.task_name', 'gd.stakeholder_id', 'gt.status', 'gt.Status')
                    ->where('gt.user_id', $user_id)
                    ->where('gt.Status', 4)
                    ->count();
                // dd($instruction_professional['inprogress']);
            } else {

                $overViewCount['Pending'] =  DB::table('government_task_tracker as gt')
                    ->select('gt.government_task_id', 'gd.task_name', 'gd.stakeholder_id', 'gt.status as task_status', 'gt.Status', 'gt.id', 'gd.created_at', 'gd.status')
                    ->join('government_task_details as gd', 'gd.id', '=', 'gt.government_task_id')
                    ->join('government_instruction_details as gid', 'gid.government_task_id', '=', 'gt.government_task_id')
                    ->groupBy('gid.government_task_id', 'gt.government_task_id', 'gd.task_name', 'gd.stakeholder_id', 'gt.status', 'gt.Status', 'gt.id', 'gd.created_at', 'gd.status')
                    ->where([['gt.created_by', $user_id], ['gd.status', 'Active']])
                    ->count();
                $overViewCount['Approved'] =  DB::table('government_task_tracker as gt')
                    ->select('gt.government_task_id', 'gd.task_name', 'gd.stakeholder_id', 'gt.status as task_status', 'gt.Status', 'gt.id', 'gd.created_at', 'gd.status')
                    ->join('government_task_details as gd', 'gd.id', '=', 'gt.government_task_id')
                    ->join('government_instruction_details as gid', 'gid.government_task_id', '=', 'gt.government_task_id')
                    ->groupBy('gid.government_task_id', 'gt.government_task_id', 'gd.task_name', 'gd.stakeholder_id', 'gt.status', 'gt.Status', 'gt.id', 'gd.created_at', 'gd.status')
                    ->where([['gt.created_by', $user_id], ['gd.status', 'Approved']])
                    ->count();
                $overViewCount['Rejected'] = 0;
            }
            // dd($userRole->role_designation == config('setting.DESIGNATION.GovernmentValuer'));
            if ($userRole->role_designation == config('setting.DESIGNATION.GovernmentValuer')) {
                $instruction_professional['pending'] = DB::table('government_task_details as gd')
                    ->join('government_instruction_details as gid', 'gid.government_task_id', '=', 'gd.id')
                    ->where('gid.user_id', $user_id)
                    ->groupBy('gd.id', 'gid.government_task_id') // Add both columns to the GROUP BY
                    ->select(
                        'gd.id',
                        'gd.task_name',
                        'gid.government_task_id',
                        DB::raw('MAX(gid.status) as task_status'), // Use MAX for non-aggregated column
                        DB::raw('MAX(gid.updated_by) as assigned_by'), // Use MAX for non-aggregated column
                        DB::raw('MAX(gd.status) as status') // Use MAX for non-aggregated column
                    )
                    ->where('gid.status', 1)
                    ->count();

                $instruction_professional['inprogress'] = DB::table('government_task_details as gd')
                    ->join('government_instruction_details as gid', 'gid.government_task_id', '=', 'gd.id')
                    ->where('gid.user_id', $user_id)
                    ->groupBy('gd.id', 'gid.government_task_id') // Add both columns to the GROUP BY
                    ->select(
                        'gd.id',
                        'gd.task_name',
                        'gid.government_task_id',
                        DB::raw('MAX(gid.status) as task_status'), // Use MAX for non-aggregated column
                        DB::raw('MAX(gid.updated_by) as assigned_by'), // Use MAX for non-aggregated column
                        DB::raw('MAX(gd.status) as status') // Use MAX for non-aggregated column
                    )
                    ->where('gid.status', 2)
                    ->count();

                $instruction_professional['approved'] = DB::table('government_task_details as gd')
                    ->join('government_instruction_details as gid', 'gid.government_task_id', '=', 'gd.id')
                    ->where('gid.user_id', $user_id)
                    ->groupBy('gd.id', 'gid.government_task_id') // Add both columns to the GROUP BY
                    ->select(
                        'gd.id',
                        'gd.task_name',
                        'gid.government_task_id',
                        DB::raw('MAX(gid.status) as task_status'), // Use MAX for non-aggregated column
                        DB::raw('MAX(gid.updated_by) as assigned_by'), // Use MAX for non-aggregated column
                        DB::raw('MAX(gd.status) as status') // Use MAX for non-aggregated column
                    )
                    ->where('gid.status', 3)
                    ->count();
            }

            // dd($inst_professional_gv['pending'],$inst_professional_gv['inprogress'],$inst_professional_gv['approved']);
            // dd($inst_professional_gv['inprogress']);
            // dd($inst_professional_gv);

            if ($userRole->alter_name == config('setting.ROLE_NAME.professional_member')) {
                $gt_process['Pending'] = DB::table('gt_approve_process')
                    ->select('*')
                    ->join('users', 'users.id', '=', 'gt_approve_process.user_id')
                    ->join('gt', 'gt.user_id', '=', 'gt_approve_process.user_id')
                    ->where('gt_approve_process.approval_persons_id', $user_id)
                    ->where('approval_status', 'Pending')
                    ->where('gt_approve_process.active_flag', 0)
                    ->orderByDesc('gt_approve_process.created_at')
                    ->get();
            }
            // dd($licenceCount); 

            if ($response->Status == 200 && $response->Success) {
                $objData = json_decode($this->decryptData($response->Data));
                if ($objData->Code == 200) {
                    $parant_data = json_decode(json_encode($objData->Data), true);
                    $rows =  $parant_data;

                    $request =  array();
                    $request['user_id'] = $user_id;
                    $menus = $this->FillMenu($request);
                    if ($menus == "401") {
                        return redirect(url('/'))->with('errors', 'User session Exipired');
                    }
                    $screens = $menus['screens'];
                    $modules = $menus['modules'];
                    if ($mobile == 1) {
                        $mobile_response = [
                            'data' => $rows
                        ];
                        return $mobile_response;
                    }
                    if ($mobile == 1) {

                        return ["Data" => $rows, 'StatusCode' => 200];
                    }


                    return view('home', compact('screens', 'modules', 'rows', 'overViewCount', 'gt_process', 'instruction_professional','admin'));
                }
            } elseif ($response->Status == 401) {

                return redirect(url('/'))->with('errors', 'User session Exipired');
            } else {


                if ($mobile == 1) {
                    return ["message" => 'something went wrong', 'StatusCode' => 500];
                }
                return view('errors.errors');
            }

            //code...
        } catch (\Exception $exc) {
            return view('errors.errors');
        }
    }
}
