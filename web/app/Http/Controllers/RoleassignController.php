<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Attribute;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use League\CommonMark\Extension\Attributes\Node\Attributes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RoleassignController extends BaseController
{

    public function index(Request $request)
    {
        try {
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }

            $method = 'Method => RoleassignController => index';
            // $Role_name = $request->role_name;
            // $Role_designation = $request->role_designation;
            $role_assign = DB::select("SELECT u.name, u.role_designation,ur.alter_name,u.id
            FROM users AS u
            JOIN uam_roles AS ur ON u.array_roles = ur.role_id
            WHERE u.role_designation  != ''");

            $role_designation = DB::select("SELECT u.id,u.name, u.role_designation,ur.alter_name,ur.role_id,ur.role_name
            FROM users AS u
            JOIN uam_roles AS ur ON u.array_roles = ur.role_id
            JOIN professional_member_licence AS pl ON pl.user_id = u.id  
            where ur.role_id='34' and
            u.role_designation IS NULL");

            $designation = config('setting.DESIGNATION');



            $menus = $this->FillMenu();
            if ($menus == "401") {
                return redirect(url('/'))->with('danger', 'User session Exipired');
            }
            $screens = $menus['screens'];
            $modules = $menus['modules'];

            return view('Roleassign.index', compact('menus', 'screens', 'modules', 'role_assign', 'role_designation', 'designation'));
        } catch (\Exception $exc) {
            return view('errors.errors');
        }
    }

    public function store(Request $request)
    {
        try {
            $user_id = $request->session()->get("userID");
            if ($user_id == null) {
                return view('auth.login');
            }

            $method = 'Method => RoleassignController => store';
            $Role_name = $request->role_name;
            $Role_designation = $request->role_designation;
            $isCgv = DB::table('users as u')
                ->where('u.role_designation', $Role_designation)
                ->count();
            $this->WriteFileLog($isCgv);
            if ($isCgv > 0 && $Role_designation == 'CGV') {
                return false;
            }
            $update = DB::table('users')
                ->where('id', $Role_name)
                ->update([
                    'role_designation' => $Role_designation,
                    'updated_at' => now() // 'NOW()' is changed to 'now()' in Laravel
                ]);

            return true;
        } catch (\Exception $exc) {
            return false;
        }
    }
    public function remove(Request $request)
    {
        try {
            $method = 'Method => RoleassignController => remove';
            $userID = $request->userID;

            $udpate = DB::table('users as u')
                ->where('u.id', $userID)
                ->update(['u.role_designation' => '']);

            return true;
        } catch (\Exception $exc) {
            return false;
        }
    }
}
