<?php

use App\Http\Controllers\governmentInstructionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Controllers;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'Login']);
Route::get('/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::get('/Register/member', [\App\Http\Controllers\AuthController::class, 'register']);
Route::get('/user/policypage', [\App\Http\Controllers\UserController::class, 'policypage']);
Route::post('/user/reset_password', [\App\Http\Controllers\UserController::class, 'reset_password']);

Route::get('/user/reset/{id}', [\App\Http\Controllers\UserController::class, 'reset']);

Route::post('/user/forget_password', [\App\Http\Controllers\UserController::class, 'forget_password']);

Route::post('/user/change_password_save', [\App\Http\Controllers\UserController::class, 'change_password_save']);


// deepika
Route::get('/FAQ_questions_ans/get_faq_data', [\App\Http\Controllers\FAQmodulesController::class, 'get_faq_data']);
Route::post('/FAQ_questions_ans/get_search_ques', [\App\Http\Controllers\FAQmodulesController::class, 'get_search_ques']);
Route::post('/FAQ_questions_ans/get_search_ans', [\App\Http\Controllers\FAQmodulesController::class, 'get_search_ans']);
Route::get('/privacy/policy_screen', [\App\Http\Controllers\PrivacyPolicyController::class, 'policy_screen']);
Route::get('/privacy/update/{id}', [\App\Http\Controllers\PrivacyPolicyController::class, 'index']);

//

Route::get('/login/background', [\App\Http\Controllers\PrivacyPolicyController::class, 'login_bg']);
Route::post('/register/store', [\App\Http\Controllers\AuthController::class, 'registerstore']);
Route::post('/registermember/store', [\App\Http\Controllers\AuthController::class, 'registermemberstore']);
Route::post('/firmRegister/store', [\App\Http\Controllers\firmregistrationController::class, 'firmregisterstore']);


Route::post('/register/otpsend', [\App\Http\Controllers\AuthController::class, 'otpsend']);
Route::post('/register/otpverify', [\App\Http\Controllers\AuthController::class, 'otpverify']);
Route::get('/login/background', [\App\Http\Controllers\PrivacyPolicyController::class, 'login_bg']);
Route::get('/elearningDashboard', [App\Http\Controllers\elearningController::class, 'dashboard'])->name('elearningDashboard');
Route::get('/dashboardevents/fetch', [App\Http\Controllers\elearningController::class, 'events_fetch'])->name('dashboardevents.fetch');


Route::middleware('auth:api')->group(function () {
  Route::get('/Register/screenapl', [\App\Http\Controllers\RegistrationController::class, 'registerapl']);
  Route::get('/approvenrv/screenedit', [\App\Http\Controllers\RegistrationController::class, 'approvenrv_update']);

  Route::get('/Register/expcreate', [\App\Http\Controllers\RegistrationController::class, 'expcreate']);
  Route::get('/Register/nrvexpcreate', [\App\Http\Controllers\RegistrationController::class, 'nrvworkexp_create']);

  Route::get('/Register/educreate', [\App\Http\Controllers\RegistrationController::class, 'educreate']);
  Route::post('/master/storequestion', [\App\Http\Controllers\questionmastercontroller::class, 'store']);
  Route::get('/Questionmaster/index', [\App\Http\Controllers\questionmastercontroller::class, 'index']);
  Route::get('/valuer/show/{id}', [\App\Http\Controllers\ValuerController::class, 'show']);
  Route::get('/valuer/screen', [\App\Http\Controllers\gtapproveController::class, 'index']);
  Route::get('/valuer/approve', [\App\Http\Controllers\gtapproveController::class, 'approve_index']);
  Route::get('/valuer/certification/screen', [\App\Http\Controllers\ValuerController::class, 'certificate_issue']);
  Route::get('/valuer/approved/screen', [\App\Http\Controllers\ValuerController::class, 'approved_valuers']);
  // Route::get('/valuer/approve', [\App\Http\Controllers\ValuerController::class, 'approve_index'])->name('approve_index');
  Route::post('/stakeholder/allocation', [\App\Http\Controllers\ValuerController::class, 'allocation']);
  Route::post('/stakeholder/user_certify', [\App\Http\Controllers\ValuerController::class, 'user_certify']);
  Route::post('/valuerlist/storedata', [\App\Http\Controllers\ValuerController::class, 'storedata']);
  Route::post('/valuerlist/user_certify', [\App\Http\Controllers\ValuerController::class, 'user_certify']);
  Route::post('/ajax_data/get_stake_data', [\App\Http\Controllers\ValuerController::class, 'get_stake_data']);
  Route::post('/user_general/storedata', [\App\Http\Controllers\RegistrationController::class, 'generalstore']);
  Route::post('/user_general/store', [\App\Http\Controllers\RegistrationController::class, 'generalstore']);
  Route::post('/user_general/updatedata', [\App\Http\Controllers\RegistrationController::class, 'generalupdate']);
  Route::post('/user_general/updatedynamicdata', [\App\Http\Controllers\RegistrationController::class, 'updatedynamic']);
  Route::post('/user_general/updatedynamicdata1', [\App\Http\Controllers\RegistrationController::class, 'updatedynamicdata1']);
  Route::post('/payment/store', [\App\Http\Controllers\paymentController::class, 'store']);

  Route::post('/user_general/storedynamic', [\App\Http\Controllers\RegistrationController::class, 'storedynamic']);
  Route::post('/user_general/storedynamic1', [\App\Http\Controllers\RegistrationController::class, 'storedynamic1']);
  Route::post('/user_general/storeeqans', [\App\Http\Controllers\RegistrationController::class, 'storeeqans']);
  Route::post('/user_general/updateeqans', [\App\Http\Controllers\RegistrationController::class, 'updateeqans']);
  Route::post('/user_general/deleteeqans', [\App\Http\Controllers\RegistrationController::class, 'deleteeqans']);
  Route::post('/user_general/deletegen', [\App\Http\Controllers\RegistrationController::class, 'deletegen']);
  Route::post('/user_general/deleteexp', [\App\Http\Controllers\RegistrationController::class, 'deleteexp']);
  Route::post('/user_general/deleteedu', [\App\Http\Controllers\RegistrationController::class, 'deleteedu']);

  Route::get('/login/user', [\App\Http\Controllers\UserController::class, 'User']);
  //auditlog

  Route::get('/auditlog/uam', [\App\Http\Controllers\auditlog_controller::class, 'uam']);
  Route::get('/auditlog/vreg', [\App\Http\Controllers\auditlog_controller::class, 'vreg']);





  // uam_modules

  Route::get('/uam_modules/get_data', [\App\Http\Controllers\UamModulesController::class, 'get_data']);
  Route::get('/uam_modules/get_uam_modules', [\App\Http\Controllers\UamModulesController::class, 'get_uam_modules']);
  Route::get('/uam_modules/data_delete/{id}', [\App\Http\Controllers\UamModulesController::class, 'data_delete']);
  Route::get('/uam_modules/data_edit/{id}', [\App\Http\Controllers\UamModulesController::class, 'data_edit']);
  Route::post('/uam_modules/storedata', [\App\Http\Controllers\UamModulesController::class, 'storedata']);
  Route::post('/uam_modules/updatedata', [\App\Http\Controllers\UamModulesController::class, 'updatedata']);

  // uam_screens

  Route::get('/uam_screens/get_data', [\App\Http\Controllers\UamScreensController::class, 'get_data']);
  Route::get('/uam_screens/getscreenpermission/{id}', [\App\Http\Controllers\UamScreensController::class, 'getscreenpermission']);
  Route::get('/uam_screens/get_work_flow_data', [\App\Http\Controllers\UamScreensController::class, 'get_work_flow_data']);
  Route::get('/uam_screens/data_delete/{id}', [\App\Http\Controllers\UamScreensController::class, 'data_delete']);
  Route::get('/uam_screens/data_edit/{id}', [\App\Http\Controllers\UamScreensController::class, 'data_edit']);
  Route::post('/uam_screens/storedata', [\App\Http\Controllers\UamScreensController::class, 'storedata']);
  Route::post('/uam_screens/updatedata', [\App\Http\Controllers\UamScreensController::class, 'updatedata']);

  // uam_modules_screens

  Route::get('/uam_modules_screens/get_data', [\App\Http\Controllers\UamModulesScreensController::class, 'get_data']);
  Route::get('/uam_modules_screens/get_modules_screen/{id}', [\App\Http\Controllers\UamModulesScreensController::class, 'get_modules_screen']);
  Route::get('/uam_modules_screens/getmodulesandscreens', [\App\Http\Controllers\UamModulesScreensController::class, 'getmodulesandscreens']);
  Route::get('/uam_modules_screens/data_delete/{id}', [\App\Http\Controllers\UamModulesScreensController::class, 'data_delete']);
  Route::get('/uam_modules_screens/data_edit/{id}', [\App\Http\Controllers\UamModulesScreensController::class, 'data_edit']);
  Route::post('/uam_modules_screens/storedata', [\App\Http\Controllers\UamModulesScreensController::class, 'storedata']);
  Route::post('/uam_modules_screens/updatedata', [\App\Http\Controllers\UamModulesScreensController::class, 'updatedata']);
  //rating
  Route::get('/valuer/rating_index', [\App\Http\Controllers\ValuerController::class, 'rating_index']);
  Route::post('/valuer/ratings_create', [\App\Http\Controllers\ValuerController::class, 'ratings_create']);
  Route::post('/uam_modules_screens/screen_data_get', [\App\Http\Controllers\UamModulesScreensController::class, 'screen_data_get']);

  // Education Course

  Route::get('/education/course_index', [App\Http\Controllers\EducationMastersController::class, 'educationcourse_index'])->name('educationcourse_index');
  Route::post('/master/educationcourse_store', [\App\Http\Controllers\EducationMastersController::class, 'educationcourse_store'])->name('educationcourse_store');
  Route::get('/education/educationcourse_edit', [App\Http\Controllers\EducationMastersController::class, 'educationcourse_edit'])->name('educationcourse_edit');
  Route::post('/education/educationcourse_update', [App\Http\Controllers\EducationMastersController::class, 'educationcourse_update'])->name('educationcourse_update');
  Route::post('/education/education_delete', [App\Http\Controllers\EducationMastersController::class, 'educationcourse_delete'])->name('educationcourse_delete');

  // General Details Masters

  Route::get('/generaldetails/gdmasters_index', [App\Http\Controllers\GeneraldetailsMastersController::class, 'gdmasters_index'])->name('gdmasters_index');
  Route::post('/master/gdconstituency_store', [App\Http\Controllers\GeneraldetailsMastersController::class, 'gdmastersconstituency_store'])->name('gdmastersconstituency_store');
  Route::post('/master/gddistrict_store', [App\Http\Controllers\GeneraldetailsMastersController::class, 'gdmastersdistrict_store'])->name('gdmastersdistrict_store');
  Route::post('/master/gdvillage_store', [App\Http\Controllers\GeneraldetailsMastersController::class, 'gdmastersvillage_store'])->name('gdmastersvillage_store');


  Route::get('/gd/district_list', [App\Http\Controllers\RegistrationController::class, 'gddistrict_list'])->name('gddistrict_list');
  Route::get('/gd/constituency_list', [App\Http\Controllers\RegistrationController::class, 'gdconstituency_list'])->name('gdconstituency_list');
  Route::get('/gd/village_list', [App\Http\Controllers\RegistrationController::class, 'gdvillage_list'])->name('gdvillage_list');
  Route::get('/education/coursename_list', [App\Http\Controllers\RegistrationController::class, 'coursename_list'])->name('coursename_list');

  Route::get('/district/fetch', [\App\Http\Controllers\GeneraldetailsMastersController::class, 'district_fetch'])->name('district_fetch');
  Route::post('/district/update', [App\Http\Controllers\GeneraldetailsMastersController::class, 'district_update'])->name('district_update');


  Route::post('/education/education_edit', [App\Http\Controllers\RegistrationController::class, 'education_edit'])->name('education_edit');
  Route::get('/gt_district/delete', [App\Http\Controllers\GeneraldetailsMastersController::class, 'district_delete'])->name('district_delete');

  Route::get('/constituency/fetch', [\App\Http\Controllers\GeneraldetailsMastersController::class, 'constituency_fetch'])->name('constituency_fetch');



  // FirmRegistration//

  Route::get('/firm/firm_index', [\App\Http\Controllers\firmregistrationController::class, 'firm_index']);
  Route::post('/firm/firm_reg', [\App\Http\Controllers\firmregistrationController::class, 'firm_reg']);


  // FirmAdministration//

  Route::get('/firm_admin/screen', [\App\Http\Controllers\firmadministrationController::class, 'firm_admin_index']);

  Route::post('/firm/active_update', [\App\Http\Controllers\firmadministrationController::class, 'active_update']);

  Route::post('/firm/permission_update', [\App\Http\Controllers\firmadministrationController::class, 'permission_update']);

  Route::post('/firm/permission_store', [\App\Http\Controllers\firmadministrationController::class, 'permission_store']);

  Route::get('/firm_admin/fetch', [\App\Http\Controllers\firmadministrationController::class, 'firmadmin_fetch']);

  Route::get('/firm_admin/leave', [\App\Http\Controllers\firmadministrationController::class, 'firmadmin_leave']);



  //dynamiclist

  Route::get('/dynamic_list/getallscreens', [\App\Http\Controllers\DynamicController::class, 'getallscreens']);
  Route::post('/dynamicfieldallocation/storedata', [\App\Http\Controllers\DynamicController::class, 'storedata']);
  Route::get('/dynamiclist/get_data', [\App\Http\Controllers\DynamicController::class, 'get_data']);
  Route::get('/dynamiclist/data_edit/{id1}', [\App\Http\Controllers\DynamicController::class, 'data_edit']);
  Route::post('/dynamiclist/update_data', [\App\Http\Controllers\DynamicController::class, 'update_data']);
  Route::get('/dynamic_list_allocation/getallscreens', [\App\Http\Controllers\DynamicListController::class, 'getallscreens']);
  Route::post('/dynamicallocationlist/storedata', [\App\Http\Controllers\DynamicListController::class, 'storedata']);
  Route::get('/getalldynamicfield', [\App\Http\Controllers\DynamicListController::class, 'getalldynamicfield']);
  Route::get('/dynamiclistallocation/get_data', [\App\Http\Controllers\DynamicListController::class, 'get_data']);
  Route::get('/dynamiclistallocation/data_edit/{id1}/{id2}', [\App\Http\Controllers\DynamicListController::class, 'data_edit']);
  Route::get('/dynamiclistallocation/data_delete/{id1}/{id2}', [\App\Http\Controllers\DynamicListController::class, 'data_delete']);
  Route::post('/dynamiclistallocation/update_data', [\App\Http\Controllers\DynamicListController::class, 'update_data']);
  Route::get('/dynamiclist/data_delete/{id}', [\App\Http\Controllers\DynamicController::class, 'data_delete']);
  Route::get('/get/module', [\App\Http\Controllers\DynamicListController::class, 'getmodule']);


  // uam_roles

  Route::get('/home/index', [\App\Http\Controllers\HomeController::class, 'index']);
  Route::get('/uam_roles/get_data', [\App\Http\Controllers\UamRolesController::class, 'get_data']);
  Route::get('/uam_roles/get_roles_screen/{id}', [\App\Http\Controllers\UamRolesController::class, 'get_roles_screen']);
  Route::get('/uam_roles/getmodulesandscreens', [\App\Http\Controllers\UamRolesController::class, 'getmodulesandscreens']);
  Route::get('/uam_roles/data_delete/{id}', [\App\Http\Controllers\UamRolesController::class, 'data_delete']);
  Route::get('/uam_roles/data_edit/{id}', [\App\Http\Controllers\UamRolesController::class, 'data_edit']);
  Route::post('/uam_roles/storedata', [\App\Http\Controllers\UamRolesController::class, 'storedata']);
  Route::post('/uam_roles/updatedata', [\App\Http\Controllers\UamRolesController::class, 'updatedata']);


  // user

  Route::get('/user/get_user_list', [\App\Http\Controllers\UserController::class, 'get_user_list']);
  Route::get('/user/reset_expire_data_get', [\App\Http\Controllers\UserController::class, 'reset_expire_data_get']);

  Route::get('/user/department_list', [\App\Http\Controllers\UserController::class, 'department_list']);

  Route::get('/user/project_roles_list', [\App\Http\Controllers\UserController::class, 'project_roles_list']);

  Route::post('/user/token_expire_data_update', [\App\Http\Controllers\UserController::class, 'token_expire_data_update']);

  Route::post('/user/update_toggle', [\App\Http\Controllers\UserController::class, 'update_toggle']);

  Route::post('/user/get_department_list', [\App\Http\Controllers\UserController::class, 'get_department_list']);
  Route::get('/user/get_roles_list', [\App\Http\Controllers\UserController::class, 'get_roles_list']);
  Route::post('/user/user_register', [\App\Http\Controllers\UserController::class, 'user_register']);
  Route::get('/user/data_edit/{id}', [\App\Http\Controllers\UserController::class, 'data_edit']);
  Route::get('/user/delete/{id}', [\App\Http\Controllers\UserController::class, 'delete']);
  Route::post('/user/updatedata', [\App\Http\Controllers\UserController::class, 'updatedata']);
  Route::post('/user/updatedatapermission', [\App\Http\Controllers\UserController::class, 'updatedatapermission']);
  Route::get('/user/edit_permission/{id}', [\App\Http\Controllers\UserController::class, 'edit_permission']);


  Route::post('/user/notifications', [\App\Http\Controllers\UserController::class, 'notifications']);

  Route::post('/user/notification_alert', [\App\Http\Controllers\UserController::class, 'notification_alert']);

  Route::post('/user/profilepage', [\App\Http\Controllers\UserController::class, 'profilepage']);

  Route::post('/user/profile_update', [\App\Http\Controllers\UserController::class, 'profile_update']);


  Route::post('/dummy/document_category/checking_data', [\App\Http\Controllers\UserController::class, 'dummy_checking_data']);


  // work_flow_stage

  Route::get('/work_flow_stage/get_data', [\App\Http\Controllers\WorkFlowStageController::class, 'get_data']);
  Route::post('/work_flow_stage/storedata', [\App\Http\Controllers\WorkFlowStageController::class, 'storedata']);
  Route::get('/work_flow_stage/data_delete/{id}', [\App\Http\Controllers\WorkFlowStageController::class, 'data_delete']);
  Route::get('/work_flow_stage/data_edit/{id}', [\App\Http\Controllers\WorkFlowStageController::class, 'data_edit']);
  Route::post('/work_flow_stage/updatedata', [\App\Http\Controllers\WorkFlowStageController::class, 'updatedata']);


  // work_flow_settings


  Route::get('/work_flow_settings/get_data', [\App\Http\Controllers\WorkFlowSettingsController::class, 'get_data']);
  Route::post('/work_flow_settings/storedata', [\App\Http\Controllers\WorkFlowSettingsController::class, 'storedata']);
  Route::get('/work_flow_settings/data_delete/{id}', [\App\Http\Controllers\WorkFlowSettingsController::class, 'data_delete']);
  Route::get('/work_flow_settings/data_edit/{id}', [\App\Http\Controllers\WorkFlowSettingsController::class, 'data_edit']);
  Route::post('/work_flow_settings/updatedata', [\App\Http\Controllers\WorkFlowSettingsController::class, 'updatedata']);



  Route::get('/work_flow/work_flow_data', [\App\Http\Controllers\WorkFlowController::class, 'work_flow_data']);
  Route::get('/work_flow/data_edit/{id}', [\App\Http\Controllers\WorkFlowController::class, 'data_edit']);
  Route::get('/work_flow/data_delete/{id}', [\App\Http\Controllers\WorkFlowController::class, 'data_delete']);
  Route::get('/work_flow/get_stage_user_settings', [\App\Http\Controllers\WorkFlowController::class, 'get_stage_user_settings']);
  Route::post('/work_flow/onestoredata', [\App\Http\Controllers\WorkFlowController::class, 'onestoredata']);
  Route::post('/work_flow/oneupdatedata', [\App\Http\Controllers\WorkFlowController::class, 'oneupdatedata']);
  Route::post('/work_flow/datacheck', [\App\Http\Controllers\WorkFlowController::class, 'datacheck']);
  Route::post('/work_flow/updatedata', [\App\Http\Controllers\WorkFlowController::class, 'updatedata']);
  Route::post('/work_flow/storedata', [\App\Http\Controllers\WorkFlowController::class, 'storedata']);


  Route::get('/auditlog/search', [\App\Http\Controllers\AuditlogController::class, 'get_data']);

  Route::post('/auditlog/user_id', [\App\Http\Controllers\AuditlogController::class, 'user_id']);

  Route::post('/auditlog/search', [\App\Http\Controllers\AuditlogController::class, 'Search']);

  Route::get('/auditlog/login', [\App\Http\Controllers\AuditlogController::class, 'get_login']);

  Route::post('/auditlog/login', [\App\Http\Controllers\AuditlogController::class, 'login_search']);

  Route::get('/uam_data/menu_data', [\App\Http\Controllers\UamDataController::class, 'menu_data']);

  // faq_modules
  // deepika

  Route::get('/FAQ_modules/get_data', [\App\Http\Controllers\FAQmodulesController::class, 'get_data']);
  Route::get('/FAQ_modules/get_FAQ_modules', [\App\Http\Controllers\FAQmodulesController::class, 'get_FAQ_modules']);
  Route::get('/FAQ_modules/data_delete/{id}', [\App\Http\Controllers\FAQmodulesController::class, 'data_delete']);
  Route::get('/FAQ_modules/data_edit/{id}', [\App\Http\Controllers\FAQmodulesController::class, 'data_edit']);
  Route::post('/FAQ_modules/storedata', [\App\Http\Controllers\FAQmodulesController::class, 'storedata']);
  Route::post('/FAQ_modules/updatedata', [\App\Http\Controllers\FAQmodulesController::class, 'updatedata']);



  // FAQ_question
  // deepika

  Route::get('/FAQ_question/get_data', [\App\Http\Controllers\FAQquestionController::class, 'get_data']);
  Route::get('/FAQ_question/get_FAQ_question', [\App\Http\Controllers\FAQquestionController::class, 'get_FAQ_question']);
  Route::get('/FAQ_question/data_delete/{id}', [\App\Http\Controllers\FAQquestionController::class, 'data_delete']);
  Route::get('/FAQ_question/data_edit/{id}', [\App\Http\Controllers\FAQquestionController::class, 'data_edit']);
  Route::post('/FAQ_question/storedata', [\App\Http\Controllers\FAQquestionController::class, 'storedata']);
  Route::post('/FAQ_question/updatedata', [\App\Http\Controllers\FAQquestionController::class, 'updatedata']);
  Route::post('/FAQ_question/update_toggle', [\App\Http\Controllers\FAQquestionController::class, 'update_toggle']);

  Route::post('/course_list', [\App\Http\Controllers\coursecategoryController::class, 'index']);




  // designation

  Route::get('/designation/get_data', [\App\Http\Controllers\DesignationController::class, 'get_data']);
  Route::get('/designation/get_designation', [\App\Http\Controllers\DesignationController::class, 'get_designation']);
  Route::get('/designation/data_delete/{id}', [\App\Http\Controllers\DesignationController::class, 'data_delete']);
  Route::get('/designation/data_edit/{id}', [\App\Http\Controllers\DesignationController::class, 'data_edit']);
  Route::post('/designation/storedata', [\App\Http\Controllers\DesignationController::class, 'storedata']);
  Route::post('/designation/updatedata', [\App\Http\Controllers\DesignationController::class, 'updatedata']);
  

  //iyyappan //

  Route::get('/certificate_template/get_data', [\App\Http\Controllers\CertificateTemplateController::class, 'get_data']);
  Route::get('/certificate_template/data_edit/{id}', [\App\Http\Controllers\CertificateTemplateController::class, 'data_edit']);
  Route::get('/certificate_template/data_edit_details/{id}', [\App\Http\Controllers\CertificateTemplateController::class, 'data_edit_details']);
  Route::post('/certificate-template/store', [\App\Http\Controllers\CertificateTemplateController::class, 'storedata']);


  Route::post('/elearning/class/store', [\App\Http\Controllers\tryController::class, 'class_store']);
  Route::get('/class/index', [\App\Http\Controllers\tryController::class, 'class_index']);
  Route::post('/class/class_delete', [\App\Http\Controllers\tryController::class, 'class_delete']);
  Route::post('/class/class_edit', [\App\Http\Controllers\tryController::class, 'class_edit']);
  Route::get('/class/class_edit2', [\App\Http\Controllers\tryController::class, 'class_edit2']);

  Route::post('/elearning/event/store', [\App\Http\Controllers\tryController::class, 'event_store']);
  Route::get('/event/event_list', [\App\Http\Controllers\tryController::class, 'event_list']);
  Route::post('/event/event_delete', [\App\Http\Controllers\tryController::class, 'event_delete']);

  // Route::post('/elearning/notice/notice_store', [\App\Http\Controllers\tryController::class, 'notice_store']);
  // Route::get('/notice/notice_list', [\App\Http\Controllers\tryController::class, 'notice_list']);
  // Route::post('/notice/notice_delete', [\App\Http\Controllers\tryController::class, 'notice_delete']);


  Route::post('/elearning/course/store', [\App\Http\Controllers\tryController::class, 'course_store']);
  Route::get('/course/course_list', [\App\Http\Controllers\tryController::class, 'course_list']);
  Route::post('/course/course_delete', [\App\Http\Controllers\tryController::class, 'course_delete']);
   Route::post('/course/course_delete', [\App\Http\Controllers\tryController::class, 'course_delete']);
     Route::post('/course/course_copy', [\App\Http\Controllers\tryController::class, 'course_copy']);

  // Route::post('/elearning/quiz/store', [\App\Http\Controllers\tryController::class, 'quiz_store']);
  // Route::get('/quiz/quiz_list', [\App\Http\Controllers\tryController::class, 'quiz_list']);


  //bulk_upload

  Route::post('/dummydocument_category/bulkdummyupload', [\App\Http\Controllers\UserController::class, 'dummybulkdummyupload']);

  Route::post('/document_category/bulkdummyupload', [\App\Http\Controllers\UserController::class, 'bulkdummyupload']);
  Route::post('/document_category/checking_data', [\App\Http\Controllers\UserController::class, 'checking_data']);


  //profile

  Route::get('/privacy/update/{id}', [\App\Http\Controllers\PrivacyPolicyController::class, 'index']);

  Route::post('/privacy/publish', [\App\Http\Controllers\PrivacyPolicyController::class, 'publish']);

  Route::get('/image/upload/{id}', [\App\Http\Controllers\PrivacyPolicyController::class, 'upload']);

  Route::post('/image/publish', [\App\Http\Controllers\PrivacyPolicyController::class, 'imagepublish']);

  Route::post('/background/image', [\App\Http\Controllers\PrivacyPolicyController::class, 'backgroundimage']);


  // Payment

  Route::post('/razorpay_payment', [\App\Http\Controllers\RazorpayController::class, 'licensepayment']);
  Route::post('/razorpay_firmpayment', [\App\Http\Controllers\RazorpayController::class, 'payment']);

  Route::post('/razorsummarypayment', [\App\Http\Controllers\RazorpayController::class, 'summarypayment']);

  //Reports

  Route::get('/auditlog/activity', [\App\Http\Controllers\ReportController::class, 'get_data']);

  Route::post('/auditlog/activity', [\App\Http\Controllers\ReportController::class, 'Search']);

  Route::get('/auditlog/login_report', [\App\Http\Controllers\ReportController::class, 'get_login']);

  Route::post('/auditlog/login_report', [\App\Http\Controllers\ReportController::class, 'login_search']);

  Route::get('/reports/userrole', [\App\Http\Controllers\ReportController::class, 'get_userrole']);

  Route::post('/reports/userrole', [\App\Http\Controllers\ReportController::class, 'userrole_search']);

  Route::get('/reports/processflow', [\App\Http\Controllers\ReportController::class, 'get_process']);

  Route::post('/reports/processflow', [\App\Http\Controllers\ReportController::class, 'process_search']);

  Route::get('/reports/added_doc', [\App\Http\Controllers\ReportController::class, 'get_newdoc']);

  Route::post('/reports/added_doc', [\App\Http\Controllers\ReportController::class, 'newdoc_search']);

  Route::get('/reports/deleted_doc', [\App\Http\Controllers\ReportController::class, 'get_deletedoc']);

  Route::post('/reports/deleted_doc', [\App\Http\Controllers\ReportController::class, 'deletedoc_search']);

  Route::get('/reports/archive_doc', [\App\Http\Controllers\ReportController::class, 'get_archivedoc']);

  Route::post('/reports/archive_doc', [\App\Http\Controllers\ReportController::class, 'archivedoc_search']);

  Route::get('/reports/process_doc', [\App\Http\Controllers\ReportController::class, 'get_processedoc']);

  Route::post('/reports/process_doc', [\App\Http\Controllers\ReportController::class, 'processdoc_search']);

  Route::get('/reports/grouped_count', [\App\Http\Controllers\ReportController::class, 'get_grouped']);

  Route::post('/reports/grouped_count', [\App\Http\Controllers\ReportController::class, 'grouped_search']);

  Route::get('/reports/awaiting_auth', [\App\Http\Controllers\ReportController::class, 'get_awaiting_auth']);

  Route::post('/reports/awaiting_auth', [\App\Http\Controllers\ReportController::class, 'awaiting_auth_search']);



  //
  Route::get('/uam_data/fillscreensbasedonuser/{id}', [\App\Http\Controllers\UamDataController::class, 'fillscreensbasedonuser']);

  Route::get('/uam_data/filldynamiclist/{id}', [\App\Http\Controllers\UamDataController::class, 'filldynamiclist']);

  Route::get('/uam_data/fillscreensbasedondash/{id}', [\App\Http\Controllers\UamDataController::class, 'fillscreensbasedondash']);

  Route::get('/uam_data/fillscreensbasedondocument/{id}', [\App\Http\Controllers\UamDataController::class, 'fillscreensbasedondocument']);



  //Elearning Ethnic Test

  // Route::resource('ethnictest', elearningEthnicTestController::class);
  Route::get('/ethictest', [\App\Http\Controllers\elearningEthnicTestController::class, 'index'])->name('elearning-ethictest');
  Route::post('/ethictest/store', [\App\Http\Controllers\elearningEthnicTestController::class, 'store'])->name('ethictest.store');
  Route::get('/ethictest/show/{id}', [\App\Http\Controllers\elearningEthnicTestController::class, 'show'])->name('ethictest.show');

  Route::get('/ethictest/edit/{id}', [\App\Http\Controllers\elearningEthnicTestController::class, 'edit'])->name('ethictest.edit');
  Route::post('/ethictest/update', [\App\Http\Controllers\elearningEthnicTestController::class, 'update'])->name('ethictest.update');
  Route::get('/ethic/fetch', [\App\Http\Controllers\elearningEthnicTestController::class, 'fetch'])->name('ethictest.fetch');


  Route::get('/ethictest/delete', [\App\Http\Controllers\elearningEthnicTestController::class, 'delete'])->name('ethictest.delete');
  //User side View
  Route::get('/ethic/quiz/list', [App\Http\Controllers\elearningEthnicTestController::class, 'list'])->name('ethictest.list');

  Route::get('/ethic/quiz', [App\Http\Controllers\elearningEthnicTestController::class, 'quiz'])->name('ethictest.quiz');

  Route::post('/ethic/quiz/store', [App\Http\Controllers\elearningEthnicTestController::class, 'quizstore'])->name('ethictest.quizstore');

  Route::get('/elearningCart', [App\Http\Controllers\elearningEthnicTestController::class, 'cart_index'])->name('elearningCart');
  Route::post('/elearningCart/store', [App\Http\Controllers\elearningEthnicTestController::class, 'cart_store'])->name('cart.store');
  Route::get('/elearningCart/remove', [App\Http\Controllers\elearningEthnicTestController::class, 'cart_delete'])->name('cart.delete');
  Route::get('/Elearningmovecart', [App\Http\Controllers\elearningEthnicTestController::class, 'move_cart'])->name('cart.move_cart');

  //Local Adoptation

  // Route::resource('ethnictest', elearningEthnicTestController::class);
  Route::get('/localadaptationtest', [\App\Http\Controllers\LocalAdoptationTestController::class, 'index'])->name('elearning-localadaptation');
  Route::post('/localadaptationtest/store', [\App\Http\Controllers\LocalAdoptationTestController::class, 'store'])->name('localadaptation.store');
  Route::get('/localadaptationtest/show/{id}', [\App\Http\Controllers\LocalAdoptationTestController::class, 'show'])->name('localadaptation.show');

  Route::get('/localadaptationtest/edit/{id}', [\App\Http\Controllers\LocalAdoptationTestController::class, 'edit'])->name('localadaptation.edit');
  Route::post('/localadaptationtest/update', [\App\Http\Controllers\LocalAdoptationTestController::class, 'update'])->name('localadaptation.update');
  Route::get('/localadaptation/fetch', [\App\Http\Controllers\LocalAdoptationTestController::class, 'fetch'])->name('localadaptation.fetch');


  Route::get('/localadaptationtest/delete', [\App\Http\Controllers\LocalAdoptationTestController::class, 'delete'])->name('localadaptation.delete');
  //User side View
  Route::get('/localadaptation/quiz/list', [App\Http\Controllers\LocalAdoptationTestController::class, 'list'])->name('localadaptation.list');

  Route::get('/localadaptation/quiz', [App\Http\Controllers\LocalAdoptationTestController::class, 'quiz'])->name('localadaptation.quiz');

  Route::post('/localadaptation/quiz/store', [App\Http\Controllers\LocalAdoptationTestController::class, 'quizstore'])->name('localadaptation.quizstore');


  //Question Admin

  Route::get('/elearningquestion', [\App\Http\Controllers\ElearningQuestionController::class, 'index'])->name('elearningquestion.index');
  Route::post('/elearning/question_long/store', [\App\Http\Controllers\ElearningQuestionController::class, 'long_store'])->name('elearningquestion.long_store');
  Route::get('/elearning/question_long/show/{id}', [App\Http\Controllers\ElearningQuestionController::class, 'long_show'])->name('elearningquestion.long_show');

  Route::get('/elearning/question_long/edit/{id}', [App\Http\Controllers\ElearningQuestionController::class, 'long_edit'])->name('elearningquestion.long_edit');
  Route::post('/elearning/question_long/update', [App\Http\Controllers\ElearningQuestionController::class, 'long_update'])->name('elearningquestion.long_update');
  Route::get('/elearning/question_long/fetch', [App\Http\Controllers\ElearningQuestionController::class, 'long_fetch'])->name('elearningquestion.long_fetch');
  Route::get('/elearning/question_long/delete', [App\Http\Controllers\ElearningQuestionController::class, 'long_delete'])->name('elearningquestion.long_delete');

  // Route::get('/quiz/quiz_list', [\App\Http\Controllers\ElearningQuestionController::class, 'quiz_list']);

  Route::get('/coursepreview/coursepreview_list', [\App\Http\Controllers\tryController::class, 'coursepreview']);

  //Short
  Route::post('/elearning/question_short/store', [App\Http\Controllers\ElearningQuestionController::class, 'short_store'])->name('elearningquestion.short_store');
  Route::get('/elearning/question_short/show/{id}', [App\Http\Controllers\ElearningQuestionController::class, 'short_show'])->name('elearningquestion.short_show');
  Route::get('/elearning/question_short/edit/{id}', [App\Http\Controllers\ElearningQuestionController::class, 'short_edit'])->name('elearningquestion.short_edit');
  Route::post('/elearning/question_short/update', [App\Http\Controllers\ElearningQuestionController::class, 'short_update'])->name('elearningquestion.short_update');
  //mcq
  Route::post('/elearning/question_mcq/store', [App\Http\Controllers\ElearningQuestionController::class, 'mcq_store'])->name('elearningquestion.mcq_store');
  Route::get('/elearning/question_mcq/show/{id}', [App\Http\Controllers\ElearningQuestionController::class, 'mcq_show'])->name('elearningquestion.mcq_show');
  Route::get('/elearning/question_mcq/edit/{id}', [App\Http\Controllers\ElearningQuestionController::class, 'mcq_edit'])->name('elearningquestion.mcq_edit');
  Route::post('/elearning/question_mcq/update', [App\Http\Controllers\ElearningQuestionController::class, 'mcq_update'])->name('elearningquestion.mcq_update');

  //true/false
  Route::post('/elearning/question_true/store', [App\Http\Controllers\ElearningQuestionController::class, 'true_store'])->name('elearningquestion.true_store');
  Route::get('/elearning/question_true/show/{id}', [App\Http\Controllers\ElearningQuestionController::class, 'true_show'])->name('elearningquestion.true_show');
  Route::get('/elearning/question_true/edit/{id}', [App\Http\Controllers\ElearningQuestionController::class, 'true_edit'])->name('elearningquestion.true_edit');
  Route::post('/elearning/question_true/update', [App\Http\Controllers\ElearningQuestionController::class, 'true_update'])->name('elearningquestion.true_update');

  //quiz create
  Route::post('/elearning/question_quiz/store', [App\Http\Controllers\ElearningQuestionController::class, 'quiz_store'])->name('elearning.quiz_store');
  Route::get('/elearning/question_quiz/edit/{id}', [App\Http\Controllers\ElearningQuestionController::class, 'quiz_edit'])->name('elearning.quiz_edit');
  Route::post('/elearning/question_quiz/update', [App\Http\Controllers\ElearningQuestionController::class, 'quiz_update'])->name('elearning.quiz_update');
  Route::get('/elearning/question_quiz/show/{id}', [App\Http\Controllers\ElearningQuestionController::class, 'quiz_show'])->name('elearning.quiz_show');

  //quiz ajax
  Route::get('/elearning/question_quiz/get_points', [\App\Http\Controllers\ElearningQuestionController::class, 'get_points'])->name('elearning.get_points');
  //User quiz
  Route::get('/elearning/quiz/view', [App\Http\Controllers\ElearningQuestionController::class, 'quiz'])->name('elearning.userquiz');
  Route::get('/elearning/quiz/results', [App\Http\Controllers\ElearningQuestionController::class, 'quizresult'])->name('elearning.quizresult');


  //Noticeboard
  //Notice Board



  Route::post('/elearning/notice/notice_store', [App\Http\Controllers\ElearningNoticeBoardController::class, 'notice_store'])->name('elearning.notice_store');
  Route::get('/notice/notice_list', [App\Http\Controllers\ElearningNoticeBoardController::class, 'notice_list'])->name('elearning.notice_list');
  Route::post('/notice/notice_delete', [App\Http\Controllers\ElearningNoticeBoardController::class, 'notice_delete'])->name('elearning.notice_delete');
  // Route::get('/adminnoticeboard', [App\Http\Controllers\ElearningNoticeBoardController::class, 'adminnoticeboard'])->name('elearning.adminnoticeboard');
  Route::get('/notice/notice_show/{id}', [App\Http\Controllers\ElearningQuestionController::class, 'notice_show'])->name('elearning.notice_show');

  Route::get('/notice/notice_edit/{id}', [\App\Http\Controllers\ElearningNoticeBoardController::class, 'notice_edit'])->name('elearning.notice_edit');
  Route::post('/notice/notice_update', [\App\Http\Controllers\ElearningNoticeBoardController::class, 'notice_update'])->name('elearning.notice_update');
  Route::get('/notice/notice_fetch', [\App\Http\Controllers\ElearningNoticeBoardController::class, 'notice_fetch'])->name('elearning.notice_fetch');
  // Route::get('/notice/admindashboard', [App\Http\Controllers\tryController::class, 'admindashboard'])->name('elearning.admindashboard');
  Route::get('/admindashboardevents/fetch', [App\Http\Controllers\tryController::class, 'events_fetch'])->name('admindashboardevents.fetch');

  //Event

  Route::get('/adminevent_list', [App\Http\Controllers\ElearningEventController::class, 'adminevent_list'])->name('elearning.admineventlist');
  Route::post('/event_store', [App\Http\Controllers\ElearningEventController::class, 'event_store'])->name('elearning.event_store');
  Route::post('/event_delete', [App\Http\Controllers\ElearningEventController::class, 'event_delete'])->name('elearning.event_delete');
  Route::get('/adminevent', [App\Http\Controllers\ElearningEventController::class, 'adminevent'])->name('elearning.adminevent');
  Route::get('/event/show/{id}', [App\Http\Controllers\ElearningEventController::class, 'event_show'])->name('elearning.event_show');
  Route::get('/event/edit/{id}', [App\Http\Controllers\ElearningEventController::class, 'event_edit'])->name('elearning.event_edit');
  Route::post('/event/update/{id}', [App\Http\Controllers\ElearningEventController::class, 'event_update'])->name('elearning.event_update');
  Route::get('/event/fetch', [App\Http\Controllers\ElearningEventController::class, 'event_fetch'])->name('elearning.event_fetch');

  //Quiz class

  Route::get('/class/quiz', [App\Http\Controllers\elearningEthnicTestController::class, 'class_quiz'])->name('class.class_quiz');
  Route::post('/class/quiz/store', [App\Http\Controllers\elearningEthnicTestController::class, 'quiz_store'])->name('class.quizstore');

  //Exam courses

  Route::get('/course/exam', [App\Http\Controllers\elearningEthnicTestController::class, 'course_exam'])->name('course.exam');
  Route::post('/course/exam/store', [App\Http\Controllers\elearningEthnicTestController::class, 'exam_store'])->name('course.examstore');

  Route::get('/elearning/cpd', [App\Http\Controllers\elearningEthnicTestController::class, 'cpt_index'])->name('elearning.cpt_index');
  Route::get('/cpt/mail', [App\Http\Controllers\elearningEthnicTestController::class, 'cpt_mail'])->name('elearning.cpt_mail');

  //Elearning Ethnic Test

  Route::post('/elearning/notice/notice_store', [App\Http\Controllers\ElearningNoticeBoardController::class, 'notice_store'])->name('elearning.notice_store');
  Route::get('/notice/notice_list', [App\Http\Controllers\ElearningNoticeBoardController::class, 'notice_list'])->name('elearning.notice_list');
  Route::post('/notice/notice_delete', [App\Http\Controllers\ElearningNoticeBoardController::class, 'notice_delete'])->name('elearning.notice_delete');
  // Route::get('/adminnoticeboard', [App\Http\Controllers\ElearningNoticeBoardController::class, 'adminnoticeboard'])->name('elearning.adminnoticeboard');
  Route::get('/notice/notice_show/{id}', [App\Http\Controllers\ElearningQuestionController::class, 'notice_show'])->name('elearning.notice_show');

  Route::get('/notice/notice_edit/{id}', [\App\Http\Controllers\ElearningNoticeBoardController::class, 'notice_edit'])->name('elearning.notice_edit');
  Route::post('/notice/notice_update', [\App\Http\Controllers\ElearningNoticeBoardController::class, 'notice_update'])->name('elearning.notice_update');
  Route::get('/notice/notice_fetch', [\App\Http\Controllers\ElearningNoticeBoardController::class, 'notice_fetch'])->name('elearning.notice_fetch');
  Route::get('/notice/admindashboard', [App\Http\Controllers\tryController::class, 'admindashboard'])->name('elearning.admindashboard');

  // Route::resource('ethnictest', elearningEthnicTestController::class);
  Route::get('/examtest', [\App\Http\Controllers\elearningExamController::class, 'index'])->name('elearning-examtest');
  Route::post('/examtest/store', [\App\Http\Controllers\elearningExamController::class, 'store'])->name('examtest.store');
  Route::get('/examtest/show/{id}', [\App\Http\Controllers\elearningExamController::class, 'show'])->name('examtest.show');

  Route::get('/examtest/edit/{id}', [\App\Http\Controllers\elearningExamController::class, 'edit'])->name('examtest.edit');
  Route::post('/examtest/update', [\App\Http\Controllers\elearningExamController::class, 'update'])->name('examtest.update');
  Route::get('/exam/fetch', [\App\Http\Controllers\elearningExamController::class, 'fetch'])->name('examtest.fetch');

  Route::get('/examtest/delete', [\App\Http\Controllers\elearningExamController::class, 'delete'])->name('examtest.delete');
  //User side View
  Route::get('/exam/quiz/list', [App\Http\Controllers\elearningExamController::class, 'list'])->name('examtest.list');

  Route::get('/exam/quiz', [App\Http\Controllers\elearningExamController::class, 'quiz'])->name('examtest.quiz');

  Route::post('/exam/quiz/store', [App\Http\Controllers\elearningExamController::class, 'quizstore'])->name('examtest.quizstore');

  Route::post('/elearning/notice/notice_store', [App\Http\Controllers\ElearningNoticeBoardController::class, 'notice_store'])->name('elearning.notice_store');
  Route::get('/notice/notice_list', [App\Http\Controllers\ElearningNoticeBoardController::class, 'notice_list'])->name('elearning.notice_list');
  Route::post('/notice/notice_delete', [App\Http\Controllers\ElearningNoticeBoardController::class, 'notice_delete'])->name('elearning.notice_delete');
  Route::get('/adminnoticeboard', [App\Http\Controllers\ElearningNoticeBoardController::class, 'adminnoticeboard'])->name('elearning.adminnoticeboard');
  Route::get('/notice/notice_show/{id}', [App\Http\Controllers\ElearningQuestionController::class, 'notice_show'])->name('elearning.notice_show');

  Route::get('/notice/notice_edit/{id}', [\App\Http\Controllers\ElearningNoticeBoardController::class, 'notice_edit'])->name('elearning.notice_edit');
  Route::post('/notice/notice_update', [\App\Http\Controllers\ElearningNoticeBoardController::class, 'notice_update'])->name('elearning.notice_update');
  Route::get('/notice/notice_fetch', [\App\Http\Controllers\ElearningNoticeBoardController::class, 'notice_fetch'])->name('elearning.notice_fetch');
  Route::get('/notice/admindashboard', [App\Http\Controllers\tryController::class, 'admindashboard'])->name('elearning.admindashboard');

  Route::get('/class/class_edit/{class_id}', [\App\Http\Controllers\tryController::class, 'class_edit'])->name('elearning.class_edit');
  Route::post('/class/class_update', [\App\Http\Controllers\tryController::class, 'class_update'])->name('elearning.class_update');
  Route::get('/class/class_show', [\App\Http\Controllers\tryController::class, 'class_show']);
  Route::get('/class/class_fetch', [\App\Http\Controllers\tryController::class, 'class_fetch'])->name('class.fetch');

  //Admin Q&A
  Route::get('/elearningadminqa', [\App\Http\Controllers\elearningCourseqaController::class, 'index'])->name('elearning-adminqa');
  Route::get('/adminqa/delete', [\App\Http\Controllers\elearningCourseqaController::class, 'question_delete'])->name('adminquestion.delete');
  Route::get('/adminqa/fetch', [App\Http\Controllers\elearningCourseqaController::class, 'fetch'])->name('adminquestion.fetch');
  Route::get('/adminqa/show/{id}', [\App\Http\Controllers\elearningCourseqaController::class, 'show'])->name('adminquestion.show');
  Route::get('/reply/index', [App\Http\Controllers\elearningCourseqaController::class, 'reply_index'])->name('adminquestion.reply_index');
  Route::get('/reply/fetch', [App\Http\Controllers\elearningCourseqaController::class, 'reply_fetch'])->name('adminquestion.reply_fetch');
  Route::post('/reply/store', [App\Http\Controllers\elearningCourseqaController::class, 'store'])->name('adminquestion.store');
  Route::get('/reply/delete', [App\Http\Controllers\elearningCourseqaController::class, 'reply_delete'])->name('adminreply.delete');






  Route::get('/Activeoperation/login', [\App\Http\Controllers\ActiveoperationController::class, 'get_login']);

  Route::post('/Activeoperation/login', [\App\Http\Controllers\ActiveoperationController::class, 'login_search']);

  // Route::get('/uam_data/menu_data', [\App\Http\Controllers\UamDataController::class, 'menu_data']);

  Route::post('/user_approve/updatedata', [\App\Http\Controllers\gtapproveController::class, 'approveupdate']);

  Route::post('/user_reject/updatedata', [\App\Http\Controllers\gtapproveController::class, 'rejectupdate']);

  Route::post('/user_changereject', [\App\Http\Controllers\gtapproveController::class, 'changereject']);

  Route::post('/user_approvereject', [\App\Http\Controllers\gtapproveController::class, 'approvereject']);

  Route::post('/user_rejecter', [\App\Http\Controllers\gtapproveController::class, 'rejecter']);

  Route::get('/firm_register/screen', [\App\Http\Controllers\firmregistrationController::class, 'registerscreenap']);


  Route::get('/firmapproval_index', [\App\Http\Controllers\firmregistrationController::class, 'firm_approval_index']);

  Route::get('/firm_show', [\App\Http\Controllers\firmregistrationController::class, 'firm_show']);

  Route::post('/firm_approve/updatedata', [\App\Http\Controllers\firmregistrationController::class, 'firm_approveupdate']);

  Route::post('/firm_reject/updatedata', [\App\Http\Controllers\firmregistrationController::class, 'firm_rejectupdate']);

  Route::get('/firm/register_show', [\App\Http\Controllers\firmregistrationController::class, 'firm_registershow']);

  Route::post('/firm/register_update', [\App\Http\Controllers\firmregistrationController::class, 'firm_registerupdate']);



  Route::get('/instruct/instruct_index', [\App\Http\Controllers\vbpfeedbackController::class, 'instruct_index']);
  Route::get('/instruct/instruct_create/{id}', [\App\Http\Controllers\vbpfeedbackController::class, 'instruct_create']);
  Route::get('/stakeholder/firm_update', [\App\Http\Controllers\vbpfeedbackController::class, 'firm_updatedata']);
  Route::get('/instruct/show/{id}', [\App\Http\Controllers\vbpfeedbackController::class, 'instruct_show']);
  Route::post('/instruct/firm_submit', [\App\Http\Controllers\vbpfeedbackController::class, 'firm_submit']);
  Route::get('/instruct/edit/firmreject/{id}', [\App\Http\Controllers\vbpfeedbackController::class, 'firmreject_edit']);
  Route::get('/instruct/firmreject/store', [\App\Http\Controllers\vbpfeedbackController::class, 'firm_reject_storedata']);


  //vbpfeedback
  Route::get('/insrtuction/index', [\App\Http\Controllers\vbpfeedbackController::class, 'index']);
  Route::get('/insrtuction/create', [\App\Http\Controllers\vbpfeedbackController::class, 'create']);
  Route::post('/stakeholder/storedata', [\App\Http\Controllers\vbpfeedbackController::class, 'storedata']);
  Route::get('/stakeholder/show', [\App\Http\Controllers\vbpfeedbackController::class, 'data_edit']);
  Route::get('/insrtuction/index_data', [\App\Http\Controllers\vbpfeedbackController::class, 'index_data']);
  Route::get('/stakeholder/update', [\App\Http\Controllers\vbpfeedbackController::class, 'updatedata']);
  Route::get('/stakeholder/delete/{id}', [\App\Http\Controllers\vbpfeedbackController::class, 'delete']);
  // Route::get('/insrtuct/firmindex_data', [\App\Http\Controllers\vbpfeedbackController::class, 'firmindex_data']);
  //instuction_initate
  Route::get('/instruction/store', [\App\Http\Controllers\vbpfeedbackController::class, 'Instruction_storedata']);


  // 
  Route::get('/license/license_index', [\App\Http\Controllers\licenseapprovalController::class, 'license_index']);
  Route::post('/license/license_reg', [\App\Http\Controllers\licenseapprovalController::class, 'license_reg']);
  Route::get('/insrtuction/create_data/{id}', [\App\Http\Controllers\vbpfeedbackController::class, 'create_data']);
  Route::get('/instruction/approve', [\App\Http\Controllers\vbpfeedbackController::class, 'approve_storedata']);
  Route::get('/instruction/reject', [\App\Http\Controllers\vbpfeedbackController::class, 'reject_storedata']);
  Route::post('/instruction/edit/store', [\App\Http\Controllers\vbpfeedbackController::class, 'edit_storedata']);
  Route::get('/instruction/data/show', [\App\Http\Controllers\vbpfeedbackController::class, 'data_show']);
  Route::get('/instruction/stakeholder/show/{id}', [\App\Http\Controllers\vbpfeedbackController::class, 'valuer_show']);
  Route::post('/instruction/stakeholder/approve', [\App\Http\Controllers\vbpfeedbackController::class, 'stakholder_approve']);
  Route::post('/instruction/stakeholder_feedback', [\App\Http\Controllers\vbpfeedbackController::class, 'stakeholder_feedback']);
  Route::post('/instruction/valuer_feedback', [\App\Http\Controllers\vbpfeedbackController::class, 'valuer_feedback']);
  Route::get('/insrtuction/registar_index', [\App\Http\Controllers\vbpfeedbackController::class, 'registar_index']);
  Route::get('/instruction/registar/show/{id}', [\App\Http\Controllers\vbpfeedbackController::class, 'registar_show']);
  Route::post('/instruction/registar_feedback', [\App\Http\Controllers\vbpfeedbackController::class, 'registar_feedback']);
  Route::get('/instruction/cgv/approve', [\App\Http\Controllers\vbpfeedbackController::class, 'cgv_index']);
  Route::get('/instruction/cgv/approve/valuer/{id}', [\App\Http\Controllers\vbpfeedbackController::class, 'cgv_approve']);
  Route::get('/instruction/approve/cgv', [\App\Http\Controllers\vbpfeedbackController::class, 'approve_cgv']);
  Route::get('/instruction/edit/reject/{id}', [\App\Http\Controllers\vbpfeedbackController::class, 'reject_edit']);
  Route::get('/instruction/reject/store', [\App\Http\Controllers\vbpfeedbackController::class, 'instruction_reject_storedata']);
  Route::get('/instruction/reject/stakeholder', [\App\Http\Controllers\vbpfeedbackController::class, 'stakeholder_reject_storedata']);

  Route::get('/Professional/Competence', [\App\Http\Controllers\AssessmentController::class, 'professional']);
  Route::get('/level/Competence/{id}', [\App\Http\Controllers\AssessmentController::class, 'level']);
  Route::get('/critical/report', [\App\Http\Controllers\AssessmentController::class, 'critical_report']);
  Route::post('/level/store', [\App\Http\Controllers\AssessmentController::class, 'level_store']);
  Route::get('/competency/fetch', [\App\Http\Controllers\AssessmentController::class, 'competency_fetch']);
  Route::post('/critical/file_update', [\App\Http\Controllers\AssessmentController::class, 'criticalfile_update']);
  Route::get('/competency/store', [\App\Http\Controllers\AssessmentController::class, 'competency_store']);

  Route::get('/critical/analysis', [\App\Http\Controllers\AssessmentController::class, 'critical_analysis']);
  Route::get('/critical/criticalapprove', [\App\Http\Controllers\AssessmentController::class, 'criticalapprove']);
  Route::get('/critial/decision', [\App\Http\Controllers\AssessmentController::class, 'critical_decision']);

  Route::post('/critical/store', [\App\Http\Controllers\AssessmentController::class, 'critical_store']);
  Route::get('/final/assessment', [\App\Http\Controllers\AssessmentController::class, 'final_assesment']);
  Route::get('/final/approve', [\App\Http\Controllers\AssessmentController::class, 'final_approve']);
  Route::post('/critical/approvegt', [\App\Http\Controllers\AssessmentController::class, 'approvegt']);
  Route::get('/interview/process', [\App\Http\Controllers\AssessmentController::class, 'interview_process']);
  Route::post('/interview/store', [\App\Http\Controllers\AssessmentController::class, 'interview_store']);
  Route::get('/interview/fetch', [\App\Http\Controllers\AssessmentController::class, 'interview_fetch']);
  Route::post('/interview/update', [\App\Http\Controllers\AssessmentController::class, 'interview_update']);
  Route::post('/interview/updatenew', [\App\Http\Controllers\AssessmentController::class, 'interview_updatenew']);
  Route::get('/gt_interview/delete', [App\Http\Controllers\AssessmentController::class, 'interview_delete'])->name('interview_delete');
  Route::get('/professional_show', [App\Http\Controllers\AssessmentController::class, 'professional_show'])->name('professional_show');



  //NRU

  Route::post('/Register/approvenrvstore', [\App\Http\Controllers\RegistrationController::class, 'approvenrvstore']);
  Route::post('/user_exp/nrustore', [\App\Http\Controllers\RegistrationController::class, 'nrustore']);


  Route::get('/Register/approvenrv_index', [\App\Http\Controllers\RegistrationController::class, 'approvenrv_index']);

  Route::get('/nrv/screen', [\App\Http\Controllers\nrvController::class, 'index']);
  Route::get('/nrv/approve', [\App\Http\Controllers\nrvController::class, 'approve_screen']);

  Route::post('/approvescreen/update', [\App\Http\Controllers\nrvController::class, 'approvescreen_update']);
  Route::post('/approve/update_store', [\App\Http\Controllers\RegistrationController::class, 'update_store']);
  Route::get('/request_gt', [\App\Http\Controllers\gtapproveController::class, 'request_gt']);
  Route::get('/valuer/specialRequest', [\App\Http\Controllers\gtapproveController::class, 'specialRequest']);
  Route::Post('/request/update', [\App\Http\Controllers\gtapproveController::class, 'requestUpdate']);
  Route::get('/instruction/government/store', [\App\Http\Controllers\vbpfeedbackController::class, 'InstructionGovernment_storedata']);
  Route::get('/instruction/index', [governmentInstructionController::class, 'index']);
  Route::get('/instruction/appointment', [governmentInstructionController::class, 'appointment']);
  Route::post('/instruction/storeAppointment', [governmentInstructionController::class, 'storeAppointment']);
  Route::get('/instruction/tasksubmission', [governmentInstructionController::class, 'taskSubmission']);
  Route::get('/instruction/getData', [governmentInstructionController::class, 'getData']);
  Route::post('/instruction/task/store', [governmentInstructionController::class, 'instructionStore']);
  Route::Post('/instruction/task/submit', [governmentInstructionController::class, 'instructionSubmit']);
  Route::Post('/instruction/upwardapproval', [governmentInstructionController::class, 'upwardapproval']);
  Route::Post('/instruction/cgvApproval', [governmentInstructionController::class, 'cgvApproval']);
  Route::Post('/instruction/stakeholderApproval', [governmentInstructionController::class, 'stakeholderApproval']);
});

Route::fallback(function () {
  return redirect()->route('not.found');
});



Route::get('unauthenticated', [\App\Http\Controllers\AuthController::class, 'Unauthenticated'])->name('unauthenticated');

Route::get('user/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::POST('/user/unauthenticated', [\App\Http\Controllers\AuthController::class, 'user_unauthenticate']);
Route::POST('/user/require_captcha', [\App\Http\Controllers\AuthController::class, 'require_captcha']);
Route::get('not/found', [\App\Http\Controllers\AuthController::class, 'NotFound'])->name('not.found');
Route::get('/server/test', [\App\Http\Controllers\AuthController::class, 'ServerTest']);

// uam_modules

//question_master

Route::get('Questionmaster/index', [\App\Http\Controllers\questionmastercontroller::class, 'index']);

Route::get('/master/data_delete/{id}', [\App\Http\Controllers\questionmastercontroller::class, 'data_delete']);

Route::get('/Questionmaster/data_edit/{id}', [\App\Http\Controllers\questionmastercontroller::class, 'data_edit']);



Route::post('/Questionmaster/updatedata', [\App\Http\Controllers\questionmastercontroller::class, 'updatedata']);


Route::post('/user/notifications', [\App\Http\Controllers\UserController::class, 'notifications']);
Route::post('/user/notified', [\App\Http\Controllers\UserController::class, 'notified']);




// Active operation

//  Route::get('/auditlog/search',[\App\Http\Controllers\AuditlogController::class, 'get_data']);

// Route::post('/auditlog/user_id',[\App\Http\Controllers\AuditlogController::class, 'user_id']);

// Route::post('/auditlog/search', [\App\Http\Controllers\AuditlogController::class, 'Search']);

Route::get('/cronjob/schedular', [App\Http\Controllers\CronjobController::class, 'job_schedular'])->name('cronjob');
Route::get('/schedular/endperiod', [App\Http\Controllers\CronjobController::class, 'schedular_endperiod'])->name('jobcourse.endperiod');

Route::get('/generatepdf/{id}', [App\Http\Controllers\elearningEthnicTestController::class, 'generatePDF'])->name('generatePDF');
Route::get('/course/course_edit/{course_id}', [\App\Http\Controllers\tryController::class, 'course_edit'])->name('elearning.course_edit');
Route::post('/elearning/course/course_update', [\App\Http\Controllers\tryController::class, 'course_update'])->name('elearning.course_update');
Route::get('/elearning/course/course_fetch', [\App\Http\Controllers\tryController::class, 'course_fetch'])->name('course.fetch');
Route::get('/course/course_show', [\App\Http\Controllers\tryController::class, 'course_show']);

Route::get('/ratings/store', [App\Http\Controllers\elearningEthnicTestController::class, 'ratings_store'])->name('ratings.store');
Route::get('/rating/admin/index', [App\Http\Controllers\elearningEthnicTestController::class, 'rating_index'])->name('rating_index');


Route::get('/member/member_listDrupal', [App\Http\Controllers\webportalController::class, 'member_listDrupal'])->name('member_listDrupal');
Route::get('/member/member_list', [\App\Http\Controllers\webportalController::class, 'member_list']);
Route::post('/member/member_delete', [\App\Http\Controllers\webportalController::class, 'member_delete']);
Route::post('/webportal/member/store', [\App\Http\Controllers\webportalController::class, 'memberlist_store']);
Route::get('/member/member_fetch', [\App\Http\Controllers\webportalController::class, 'member_fetch'])->name('member.fetch');
Route::get('/member/member_edit/{id}', [\App\Http\Controllers\webportalController::class, 'member_edit'])->name('elearning.member_edit');
Route::post('/member/member_update', [\App\Http\Controllers\webportalController::class, 'member_update'])->name('elearning.member_update');
Route::post('/webportal/member_bulk/store', [\App\Http\Controllers\webportalController::class, 'memberbulk_store']);

// Masters //

Route::get('/fileupload/fileupload_index', [App\Http\Controllers\FileuploadController::class, 'fileupload_index'])->name('fileupload_index');
Route::post('/master/fileupload_store', [\App\Http\Controllers\FileuploadController::class, 'fileupload_store'])->name('fileupload_store');
Route::post('/master/fileupload_delete', [App\Http\Controllers\FileuploadController::class, 'fileupload_delete'])->name('fileupload_delete');
Route::get('/master/fileupload_edit', [App\Http\Controllers\FileuploadController::class, 'fileupload_edit'])->name('fileupload_edit');
Route::post('/master/fileupload_update', [App\Http\Controllers\FileuploadController::class, 'fileupload_update'])->name('fileupload_update');


// reports
Route::get('/report/fetch', [App\Http\Controllers\ReportsController::class, 'report_fetch'])->name('report_fetch');



//  Course Categories

Route::get('/categories/getAll', [App\Http\Controllers\coursecategoryController::class, 'getAll'])->name('getAll');
Route::get('/course/catagory_fetch', [App\Http\Controllers\coursecategoryController::class, 'course_catagory_fetch'])->name('course_atagory_fetch');
Route::post('/catagory_create', [App\Http\Controllers\coursecategoryController::class, 'store'])->name('catagory_create');
Route::post('/catagory_update', [App\Http\Controllers\coursecategoryController::class, 'update'])->name('catagory_update');
Route::post('/course_catagory_delete', [App\Http\Controllers\coursecategoryController::class, 'delete'])->name('course_catagory_delete');


///Gamification levels

Route::get('/level/getAll', [App\Http\Controllers\GamificationLevelController::class, 'getAll'])->name('getAll');
Route::post('/level_create_store', [App\Http\Controllers\GamificationLevelController::class, 'store'])->name('level_create_store');
Route::get('/level_show', [App\Http\Controllers\GamificationLevelController::class, 'show'])->name('level_show');
Route::post('/level_update', [ App\Http\Controllers\GamificationLevelController::class,'update'])->name('level_update');

Route::post('/level_delete',  [App\Http\Controllers\GamificationLevelController::class, 'delete'])->name('level_delete');

Route::get('/yourAchievements', [App\Http\Controllers\elearningController::class, 'yourAchievements'])->name('yourAchievements');