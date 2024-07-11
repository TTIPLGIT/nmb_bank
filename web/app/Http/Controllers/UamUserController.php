<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;

class UamUserController extends BaseController
{
    public function index()
    {
        try {
            $method = 'Method => UamUserController => index';

            $rows = DB::select("select * from users where usertype='1'");
            $permission = $this->ScreensPermissionUser();
            return view('uam.user.index', compact('rows', 'permission'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function create()
    {
        try {
            $method = 'Method => UamUserController => get_user_data';
            $rows = DB::table('uam_roles')
                ->select('*')
                ->where('active_flag', 0)
                ->get();
            $designation = DB::select('select * from designation  where active_flag=1;');
            $dashboard = DB::select('select * from user_dashboard_list');
            $parent_folder = DB::select("select a.id as document_folder_structure_id,a.document_folder_id,a.folder_name,a.folder_title,a.folder_description,a.parent_document_folder_structure_id
            from document_folder_structures as a where a.parent_document_folder_structure_id = 0");
            $directorate = DB::table('document_folder_structures')
                ->select('*')
                ->where('parent_document_folder_structure_id', 1)
                ->get();

            $department = DB::table('document_folder_structures')
                ->select('*')
                ->where('active_flag', 1)
                ->get();
            $sub_department = DB::table('document_folder_structures')
                ->select('*')
                ->where('active_flag', 1)
                ->get();

            $subordinate_department = DB::table('document_folder_structures')
                ->select('*')
                ->where('active_flag', 1)
                ->get();

            $document = DB::select("select  * from document_folder_structures where parent_document_folder_structure_id = 1");
            $document_folder_structure_id = $document[0]->id;


            return view('uam.user.create', compact('rows', 'dashboard', 'designation', 'parent_folder', 'directorate', 'department', 'sub_department', 'document_folder_structure_id', 'subordinate_department'));
        } catch (\Exception $exc) {
            return $this->sendLog($method, $exc->getCode(), $exc->getMessage(), $exc->getTrace()[0]['line'], $exc->getTrace()[0]['file']);
        }
    }

    public function store(Request $request)
    {
        $logMethod = 'Method => UserController => user_register';
        try {
            $department_id = auth()->user()->id;
            $email =  $request->email;
            $rowsemail =  DB::select("select * from users where email ='$email'");

            if (!empty($rowsemail)) {
                return redirect()->route('user.index')->with('error', 'Email Already Found');
            } else {

                $crypt_pwd = bcrypt($request->password);

                $user_id = DB::table('users')
                    ->insertGetId([
                        'name' => $request->name,
                        'email' => $email,
                        'password' => $crypt_pwd,
                        'usertype' => '1',
                        'role_id' => $request->roles_id
                    ]);

                $displayItems2_department =  explode("-", $request->displayItems2);
                $unique = array_values($displayItems2_department);
                $screenidcount = count($unique);

                for ($i = 0; $i < $screenidcount; $i++) {

                    $iparr = explode(":", $unique[$i]);
                    $user_departments_id = DB::table('user_departments')->insertGetId([
                        'user_id' => $user_id,
                        'parent_node_id' => $request->parent_node_id,
                        'directorate_id' => $iparr[0],
                        'department_id' => $iparr[1],
                        //'designation_id' => $designation,
                    ]);
                };

                $screen_array_department = explode(":", $request->directorate_department); //id="node1-37-38-39"
                $unique_array_department = array_values($screen_array_department);
                $screenunique_array_department = count($unique_array_department);

                for ($i = 0; $i < $screenunique_array_department; $i++) {
                    $iparr = explode("-", $unique_array_department[$i]);
                    $user_departments_id = DB::table('users_document_categories')->insertGetId([
                        'user_id' => $user_id,
                        'directorate_id' => $iparr[1], // Directorate Id
                        'department_id' => $iparr[2], //Department Id
                        'document_category_id' => $iparr[3], //Document Id
                        'array_department' => $unique_array_department[$i]
                    ]);
                };

                $uam_screen_id = DB::table('uam_user_roles')->insert(
                    array(
                        'user_id' => $user_id,
                        'role_id' => $request->roles_id,
                        'active_flag' => 0,
                        'created_by' => $department_id,
                        'created_date' => NOW()
                    )
                );

                // $roles_data_id = $request->roles_id;
                // $stringuser_id = $request->roles_id;
                // $update_id =  DB::table('users')
                // ->where('id', $user_id)
                // ->update([
                //     'array_roles' => $stringuser_id,
                // ]);

                $role_id = $request->roles_id;
                $parentrow =  DB::select("select a.screen_id,a.module_screen_id,a.module_id from uam_role_screens as a where a.role_id = $role_id");
                $parentidcounting = count($parentrow);
                if ($parentrow != []) {
                    for ($j = 0; $j < $parentidcounting; $j++) {
                        $module_id = $parentrow[$j]->module_id;
                        $screen_id = $parentrow[$j]->screen_id;
                        $x = 0;
                        $modulesrows =  DB::select("select * from uam_module where module_id = $module_id");
                        if ($modulesrows != []) {
                            $parent_module_id = $modulesrows[$x]->parent_module_id;
                            $module_name = $modulesrows[$x]->module_name;
                        }

                        $screenrows =  DB::select("select * from uam_screens where id = $screen_id");
                        if ($screenrows != []) {
                            $screen_name = $screenrows[$x]->screen_name;
                            $screen_url = $screenrows[$x]->screen_url;
                            $route_url = $screenrows[$x]->route_url;
                            $class_name = $screenrows[$x]->class_name;
                            $display_order = $screenrows[$x]->display_order;
                        }

                        $check = DB::select("select * from uam_user_screens where module_id = $module_id and user_id = $user_id and screen_id = $screen_id ");
                        $checkcount = count($check);
                        if ($checkcount == '') {
                            $screen_permission_id = DB::table('uam_user_screens')->insert([
                                'screen_id' => $screen_id,
                                'module_id' => $module_id,
                                'parent_module_id' => $parent_module_id,
                                'module_name' => $module_name,
                                'screen_name' => $screen_name,
                                'screen_url' => $screen_url,
                                'route_url' => $route_url,
                                'class_name' => $class_name,
                                'display_order' => $display_order,
                                'user_id' => $user_id,
                                'active_flag' => 0,
                                'created_by' => auth()->user()->id,
                                'created_date' => NOW()
                            ]);
                        } else {
                        }
                    };
                };

                $checking = DB::select("select a.id,a.screen_id,a.module_id from uam_user_screens as a where  a.user_id = $user_id ");

                $checkcounting = count($checking);
                if ($checking != []) {
                    for ($k = 0; $k < $checkcounting; $k++) {
                        $screen_id = $checking[$k]->screen_id;
                        $user_screen_id = $checking[$k]->id;

                        $permissioncheck = DB::select("select a.*,b.array_permission from uam_screen_permissions as a
                        inner join uam_role_screen_permissions as b on b.screen_permission_id = a.id
                        where a.screen_id  = '$screen_id' and b.role_id = '$role_id'");

                        $permissioncheckcount = count($permissioncheck);

                        for ($m = 0; $m < $permissioncheckcount; $m++) {
                            $screen_permission_id = $permissioncheck[$m]->id;
                            $permission_name = $permissioncheck[$m]->permission;
                            $description = $permissioncheck[$m]->description;
                            $active_flag = $permissioncheck[$m]->active_flag;
                            $array_permission = $permissioncheck[$m]->array_permission;

                            $role_screen_permissions_id = DB::table('uam_user_screen_permissions')->insert(
                                array(
                                    'user_screen_id' =>  $user_screen_id,
                                    'screen_permission_id' =>  $screen_permission_id,
                                    'permission' => $permission_name,
                                    'description' => $description,
                                    'active_flag' => $active_flag,
                                    'array_permission' => $array_permission,
                                    'user_id' => $user_id,
                                    'created_by' => auth()->user()->id,
                                    'created_date' => NOW()
                                )
                            );
                        };
                    };
                };

                $notifications = DB::table('notifications')->insertGetId([
                    'user_id' => $user_id,
                    'notification_type' => 'New User',
                    'notification_status' => 'User Created',
                    'notification_url' => 'user',
                    'megcontent' => "User " . $request->name . " created Successfully and mail sent.",
                    'alert_meg' => "User " . $request->name . " created Successfully and mail sent.",
                    'created_by' => auth()->user()->id,
                    'created_at' => NOW()
                ]);


                return redirect()->route('user.index')->with('Success', 'User Created Successfully');
            }
        } catch (Exception $exc) {
            Log::error('[Method => UAM Controller =>  Error Code:' . $exc . '::' . auth()->user()->id . ']');
        }
    }

    public function edit($id)
    {
        $id = $this->decryptData($id);

        $rows_data = DB::table('uam_roles')
            ->select('*')
            ->where('active_flag', 0)
            ->get();
        $designation = DB::select('select * from designation  where active_flag=1;');
        $dashboard = DB::select('select * from user_dashboard_list');
        $parent_folder = DB::select("select a.id as document_folder_structure_id,a.document_folder_id,a.folder_name,a.folder_title,a.folder_description,a.parent_document_folder_structure_id
            from document_folder_structures as a where a.parent_document_folder_structure_id = 0");
        $directorate = DB::table('document_folder_structures')
            ->select('*')
            ->where('parent_document_folder_structure_id', 1)
            ->get();

        $department = DB::table('document_folder_structures')
            ->select('*')
            ->where('active_flag', 1)
            ->get();
        $sub_department = DB::table('document_folder_structures')
            ->select('*')
            ->where('active_flag', 1)
            ->get();

        $subordinate_department = DB::table('document_folder_structures')
            ->select('*')
            ->where('active_flag', 1)
            ->get();

        $document = DB::select("select  * from document_folder_structures where parent_document_folder_structure_id = 1");
        $document_folder_structure_id = $document[0]->id;
        $one_row = DB::select("select a.id as user_id,a.*,b.*,c.array_department from users as a 
        inner join user_departments as b on b.user_id = a.id 
        inner join users_document_categories as c on c.user_id = a.id
        where b.active_flag=1 and a.id = $id ");
        //echo json_encode($one_row);exit;

        return view('uam.user.edit', compact('rows_data', 'document_folder_structure_id', 'parent_folder', 'directorate', 'department', 'sub_department', 'designation', 'dashboard', 'one_row'));
    }

    public function update_user_data(Request $request)
    {

        $logMethod = 'Method => UserController => user_register';
        try {

            $id  = $request->user_id;
		
            $email =  $request->email;
		    $rowsemail =  DB::select("select * from users where not id  = '$id' and email ='$email'"); 
            if (!empty($rowsemail)) {
                return redirect()->route('user.index')->with('error', 'Email Found with Other Account');
            }else {
            $user_id = DB::table('users')
                ->where('id', $request->user_id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'role_id' => $request->roles_id
                ]);

            DB::select("delete from uam_user_screens WHERE user_id='$request->user_id'");
            DB::select("delete from user_departments WHERE user_id='$request->user_id'");
            DB::select("delete from users_document_categories WHERE user_id='$request->user_id'");

            $displayItems2_department =  explode("-", $request->displayItems2);
            $unique = array_values($displayItems2_department);
            $screenidcount = count($unique);

            for ($i = 0; $i < $screenidcount; $i++) {

                $iparr = explode(":", $unique[$i]);
                $user_departments_id = DB::table('user_departments')->insertGetId([
                    'user_id' => $request->user_id,
                    'parent_node_id' => $request->parent_node_id,
                    'directorate_id' => $iparr[0],
                    'department_id' => $iparr[1],
                    'last_modified_date' => now(),
                    'last_modified_by' => auth()->user()->id
                ]);
            };

            $screen_array_department = explode(":", $request->directorate_department);
            $unique_array_department = array_values($screen_array_department);
            $screenunique_array_department = count($unique_array_department);

            for ($i = 0; $i < $screenunique_array_department; $i++) {
                $iparr = explode("-", $unique_array_department[$i]);
                $user_departments_id = DB::table('users_document_categories')->insertGetId([
                    'user_id' => $request->user_id,
                    'directorate_id' => $iparr[1], // Directorate Id
                    'department_id' => $iparr[2], //Department Id
                    'document_category_id' => $iparr[3], //Document Id
                    'array_department' => $unique_array_department[$i]
                ]);
            };

            $uam_screen_id = DB::table('uam_user_roles')
                ->where('user_id', $request->user_id)
                ->update([
                    'role_id' => $request->roles_id,
                    'active_flag' => 0,
                    'last_modified_by' => auth()->user()->id,
                    'last_modified_date' => NOW()
                ]);

            // $roles_data_id = $request->roles_id;
            // $stringuser_id = $request->roles_id;
            // $update_id =  DB::table('users')
            // ->where('id', $user_id)
            // ->update([
            //     'array_roles' => $stringuser_id,
            // ]);

            $role_id = $request->roles_id;
            $parentrow =  DB::select("select a.screen_id,a.module_screen_id,a.module_id from uam_role_screens as a where a.role_id = $role_id");
            $parentidcounting = count($parentrow);
            if ($parentrow != []) {
                for ($j = 0; $j < $parentidcounting; $j++) {
                    $module_id = $parentrow[$j]->module_id;
                    $screen_id = $parentrow[$j]->screen_id;
                    $x = 0;
                    $modulesrows =  DB::select("select * from uam_module where module_id = $module_id");
                    if ($modulesrows != []) {
                        $parent_module_id = $modulesrows[$x]->parent_module_id;
                        $module_name = $modulesrows[$x]->module_name;
                    }

                    $screenrows =  DB::select("select * from uam_screens where id = $screen_id");
                    if ($screenrows != []) {
                        $screen_name = $screenrows[$x]->screen_name;
                        $screen_url = $screenrows[$x]->screen_url;
                        $route_url = $screenrows[$x]->route_url;
                        $class_name = $screenrows[$x]->class_name;
                        $display_order = $screenrows[$x]->display_order;
                    }

                    $check = DB::select("select * from uam_user_screens where module_id = $module_id and user_id = $user_id and screen_id = $screen_id ");
                    $checkcount = count($check);
                    if ($checkcount == '') {
                        $screen_permission_id = DB::table('uam_user_screens')->insert([
                            'screen_id' => $screen_id,
                            'module_id' => $module_id,
                            'parent_module_id' => $parent_module_id,
                            'module_name' => $module_name,
                            'screen_name' => $screen_name,
                            'screen_url' => $screen_url,
                            'route_url' => $route_url,
                            'class_name' => $class_name,
                            'display_order' => $display_order,
                            'user_id' => $request->user_id,
                            'active_flag' => 0,
                            'created_by' => auth()->user()->id,
                            'created_date' => NOW()
                        ]);
                    } else {
                    }
                };
            };

            $checking = DB::select("select a.id,a.screen_id,a.module_id from uam_user_screens as a where  a.user_id = $user_id ");

            $checkcounting = count($checking);
            if ($checking != []) {
                for ($k = 0; $k < $checkcounting; $k++) {
                    $screen_id = $checking[$k]->screen_id;
                    $user_screen_id = $checking[$k]->id;

                    $permissioncheck = DB::select("select a.*,b.array_permission from uam_screen_permissions as a
                    inner join uam_role_screen_permissions as b on b.screen_permission_id = a.id
                    where a.screen_id  = '$screen_id' and b.role_id = '$role_id'");

                    $permissioncheckcount = count($permissioncheck);

                    for ($m = 0; $m < $permissioncheckcount; $m++) {
                        $screen_permission_id = $permissioncheck[$m]->id;
                        $permission_name = $permissioncheck[$m]->permission;
                        $description = $permissioncheck[$m]->description;
                        $active_flag = $permissioncheck[$m]->active_flag;
                        $array_permission = $permissioncheck[$m]->array_permission;

                        $role_screen_permissions_id = DB::table('uam_user_screen_permissions')->insert(
                            array(
                                'user_screen_id' =>  $user_screen_id,
                                'screen_permission_id' =>  $screen_permission_id,
                                'permission' => $permission_name,
                                'description' => $description,
                                'active_flag' => $active_flag,
                                'array_permission' => $array_permission,
                                'user_id' => $user_id,
                                'created_by' => auth()->user()->id,
                                'created_date' => NOW()
                            )
                        );
                    };
                };
            };

            $notifications = DB::table('notifications')->insertGetId([
                'user_id' => $user_id,
                'notification_type' => 'New User',
                'notification_status' => 'User Created',
                'notification_url' => 'user',
                'megcontent' => "User " . $request->name . " updated Successfully.",
                'alert_meg' => "User " . $request->name . " updated Successfully.",
                'created_by' => auth()->user()->id,
                'created_at' => NOW()
            ]);

            return redirect()->route('user.index')->with('Success', 'User Created Successfully');
            }
        } catch (Exception $exc) {
            Log::error('[Method => UAM Controller =>  Error Code:' . $exc . '::' .']');
        }
    }

} 
