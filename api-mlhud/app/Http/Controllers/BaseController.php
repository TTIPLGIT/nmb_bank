<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use PDO;

class BaseController extends Controller
{
    /**
     * Author: Anbukani
     * Date: 05/06/2021
     * Description: Return encrypted data for success.
     **/
    public function SendServiceResponse($rows, $statusCode, $status)
    {
        try {

            $encryptedData = Crypt::encrypt($rows);
            $serviceResponse = [
                'Success' => $status,
                'Data' => $encryptedData,
                'Status' => $statusCode
            ];

            return response()->json($serviceResponse, 200);
        } catch (\Exception $exc) {
            Log::error('Method => BaseController => SendServiceResponse: [' . $exc->getCode() . '] ' . $exc->getMessage());
            $exceptionResponse = array();
            $exceptionResponse['Code'] = 500;
            $exceptionResponse['Message'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $serviceResponse = [
                'Success' => false,
                'Data' => Crypt::encrypt($exceptionResponse),
                'Status' => 509
            ];

            return response()->json($serviceResponse, 200);
        }
    }


    public function sendnewResponse($id, $stage, $user, $settings, $datacheked, $initiatestage)
    {
        try {
            $response = [
                'Success' => true,
                'id'    => $id,
                'stage' => $stage,
                'user' => $user,
                'settings' => $settings,
                'datacheked' => $datacheked,
                'initiatestage' => $initiatestage,
                'Status' => 200
            ];

            return response()->json($response, 200);
        } catch (\Exception $exc) {
            Log::error('Method => sendResponse: [' . $exc->getCode() . '] "' . $exc->getMessage() . '" on line ' . $exc->getTrace()[0]['line'] . ' of file ' . $exc->getTrace()[0]['file']);
            return $this->sendErrorResponse('Method => BaseController => sendResponse: ' . $exc->getMessage(), 400);
        }
    }



    /**
     * Schema: -
     * Table Name: -
     * Author: Anbukani
     * Date: 24/09/2019
     * Description: Decrypt data.
     */
    public function DecryptData($data)
    {
        try {
            return Crypt::decrypt($data);
        } catch (\Exception $exc) {
            Log::error('Method => BaseController => DecryptData => Decrypt data error =>: [' . $exc->getCode() . '] ' . $exc->getMessage());
            return 'Failure';
        }
    }
    // TALENTRA TEAM

    public function getusermail($id)
    {
        try {
            $users = DB::SELECT("SELECT name,email from users where id=$id");
            $email = $users[0]->email;
            return $email;
        } catch (\Exception $exc) {
            Log::error('Method => BaseController => DecryptData => Decrypt data error =>: [' . $exc->getCode() . '] ' . $exc->getMessage());
            return 'Failure';
        }
    }

    public function getusername($id)
    {
        try {
            $users = DB::SELECT("SELECT name,email from users where id=$id");
            $name = $users[0]->name;
            return $name;
        } catch (\Exception $exc) {
            Log::error('Method => BaseController => DecryptData => Decrypt data error =>: [' . $exc->getCode() . '] ' . $exc->getMessage());
            return 'Failure';
        }
    }


    public function get_userson_roles($id)
    {
        try {
            $users = DB::SELECT("SELECT u.name,email from users as u inner join uam_user_roles as ur on ur.user_id = u.id  where role_id=$id");

            return $users;
        } catch (\Exception $exc) {
            Log::error('Method => BaseController => DecryptData => Decrypt data error =>: [' . $exc->getCode() . '] ' . $exc->getMessage());
            return 'Failure';
        }
    }






    /**
     * Author: Anbukani
     * Date: 16/09/2019
     * Description: Encrypt data.
     */
    public function EncryptData($data)
    {
        try {
            return Crypt::encrypt($data);
        } catch (\Exception $exc) {
            Log::error('Method => BaseController => EncryptData => Encrypt data error =>: [' . $exc->getCode() . '] ' . $exc->getMessage());
            return 'Failure';
        }
    }

    /**
     * Author: Anbukani
     * Date: 04/06/2021
     * Description: Write error in text file.
     **/
    public function WriteFileLog($request, $comment = null, $exit = null)
    {
        try {
            if ($comment != null) {
                Log::error($comment);
            }
            Log::error($request);
            if ($exit != null) {
                exit;
            }
        } catch (\Exception $exc) {
            Log::error('Method => BaseController => WriteFileLog => Write log file error =>: [' . $exc->getCode() . '] ' . $exc->getMessage());
        }
    }


    /**
     * Schema: -
     * Table Name: audit_logs
     * Author: Anbukani
     * Date: 24/09/2019
     * Description: Audit log for database table record changes.
     */
    public function AuditLog($tableName, $key, $action, $description, $user, $time, $role_name)
    {

        try {
            DB::table('audit_logs')->insert([
                'audit_table_name' => $tableName,
                'audit_table_id' => $key,
                'audit_action' => $action,
                'description' => $description,
                'user_id' => $user,
                'action_date_time' => $time,
                'role_name' => $role_name
            ]);
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = 'Method => BaseController => AuditLog';
            $exceptionResponse['Exception'] = $exc->getMessage();
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            $this->WriteFileLog($exceptionResponse);
            //return 'Failure';
        }
    }

    public function notifications_insert($role_id, $user_id, $notification_status, $notification_url)
    {
        try {
            $notifications = DB::table('notifications')->insertGetId([
                'role_id' => $role_id,
                'user_id' => $user_id,
                'notification_status' => $notification_status,
                'notification_url' => $notification_url,
                'megcontent' => $notification_status,
                'alert_meg' => $notification_status,
                'created_by' => $user_id,
                'created_at' => NOW()
            ]);
            return $notifications;
            //code...
        } catch (\Exception $exc) {
            $exceptionResponse = array();
            $exceptionResponse['ServiceMethod'] = 'Method => BaseController => AuditLog';
            $exceptionResponse['Exception'] = $exc->getMessage();
            $this->WriteFileLog($exceptionResponse);
            $exceptionResponse = json_encode($exceptionResponse, JSON_FORCE_OBJECT);
            return 'Failure';
        }
    }
    public function GetEndUserData($id)
    {
        try {
            $rows['general'] = DB::table('user_general_details')
                ->join('users', 'users.id', '=', 'user_general_details.user_id')
                ->where('user_general_details.user_id', $id)
                ->where('user_general_details.active_flag', '0')
                ->get();

            $rows['education'] = DB::table('user_education_dip_details')
                ->join('users', 'users.id', '=', 'user_education_dip_details.user_id')
                ->where('user_education_dip_details.user_id', $id)
                ->where('user_education_dip_details.active_flag', '0')
                ->get();

            $rows['work_experience'] = DB::table('user_exp_wrq_details')
                ->join('users', 'users.id', '=', 'user_exp_wrq_details.user_id')
                ->where('user_exp_wrq_details.user_id', $id)
                ->where('user_exp_wrq_details.active_flag', '0')
                ->get();

            $rows['certification'] = DB::table('user_exp_cert_details')
                ->join('users', 'users.id', '=', 'user_exp_cert_details.user_id')
                ->where('user_exp_cert_details.user_id', $id)
                ->where('user_exp_cert_details.active_flag', '0')
                ->get();

            $rows['supervision'] = DB::table('gt_approve_process')
                ->join('users', 'users.id', '=', 'gt_approve_process.user_id')
                ->where('gt_approve_process.user_id', $id)
                ->get();
            $rows['messages'] = DB::select("SELECT * FROM messages AS m INNER JOIN users ON m.gt_approval_persons_id=users.id inner join uam_user_roles as ur on ur.user_id= m.gt_approval_persons_id  WHERE gt_id=$id");

            return $rows;
        } catch (\Exception $exc) {
            Log::error('Method => BaseController => GetEndUserData => GetEndUserData data error =>: [' . $exc->getCode() . '] ' . $exc->getMessage());
            return 'Failure';
        }
    }
    public function GetUserOnRole($alter_name)
    {
        try {
            $rows = DB::table('users as u')
                ->select('u.id', 'u.name')
                ->join('uam_user_roles as ur', 'ur.user_id', '=', 'u.id')
                ->join('uam_roles as r', 'r.role_id', '=', 'ur.role_id')
                ->where('u.active_flag', 0)
                ->where('r.alter_name', $alter_name)
                ->get();
            return $rows;
        } catch (\Exception $exc) {
            Log::error('Method => BaseController => GetEndUserData => GetEndUserData data error =>: [' . $exc->getCode() . '] ' . $exc->getMessage());
            return 'Failure';
        }
    }
    public function get_user_role()
    {
        try {
            $user_id = Auth::user()->id;
            $alter_name = DB::table('uam_user_roles')
                ->join('uam_roles', 'uam_roles.role_id', '=', 'uam_user_roles.role_id')
                ->join('users', 'users.id', '=', 'uam_user_roles.user_id')
                ->where('uam_user_roles.user_id', $user_id)
                ->where('users.active_flag', 0)
                ->select('uam_roles.alter_name', 'users.role_designation')
                ->first();
            return $alter_name;
        } catch (\Exception $exc) {
            return ($exc);
            Log::error('Method => BaseController => get_user_role => get_user_role data error =>: [' . $exc->getCode() . '] ' . $exc->getMessage());
            return 'Failure';
        }
    }
    public function GetUserOnDesignation($designation)
    {
        try {
            $rows = DB::table('users as u')
                ->select('u.id', 'u.name')
                ->join('uam_user_roles as ur', 'ur.user_id', '=', 'u.id')
                ->join('uam_roles as r', 'r.role_id', '=', 'ur.role_id')
                ->where('u.active_flag', 0)
                ->where('u.role_designation', $designation)
                ->get();
            return $rows;
        } catch (\Exception $exc) {
            Log::error('Method => BaseController => GetEndUserData => GetEndUserData data error =>: [' . $exc->getCode() . '] ' . $exc->getMessage());
            return 'Failure';
        }
    }
    public function get_user_role_on_ID($user_id)
    {
        try {
            $alter_name = DB::table('uam_user_roles')
                ->join('uam_roles', 'uam_roles.role_id', '=', 'uam_user_roles.role_id')
                ->join('users', 'users.id', '=', 'uam_user_roles.user_id')
                ->where('uam_user_roles.user_id', $user_id)
                ->where('users.active_flag', 0)
                ->select('uam_roles.alter_name', 'users.role_designation')
                ->first();
            return $alter_name;
        } catch (\Exception $exc) {
            return ($exc);
            Log::error('Method => BaseController => get_user_role => get_user_role data error =>: [' . $exc->getCode() . '] ' . $exc->getMessage());
            return 'Failure';
        }
    }
}
