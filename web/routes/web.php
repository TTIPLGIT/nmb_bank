<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\BaseController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UamModulesController;
use App\Http\Controllers\UamScreensController;
use App\Http\Controllers\UamModulesScreensController;
use App\Http\Controllers\AlertController;

use App\Http\Controllers\UamDataController;
use App\Http\Controllers\questionmastercontroller;

use App\Http\Controllers\UamRolesController;
use App\Http\Controllers\UamUserController;

use App\Http\Controllers\uamsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\auditlogcontroller;
use App\Http\Controllers\RoleassignController;
use App\Http\Controllers\ReportsController;
//Assessment
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\activeoperationController;
use App\Http\Controllers\FaqController;
// elearning
use App\Http\Controllers\elearningController;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\ValuerController;

// FAQ_MODULE
use App\Http\Controllers\FAQmodulesController;
use App\Http\Controllers\FAQquestionController;

// Firm_Registration //
use App\Http\Controllers\gtapproveController;
use App\Http\Controllers\firmregistrationController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\vbpfeedbackController;
use App\Http\Controllers\licenseapprovalController;
use App\Http\Controllers\CronjobController;

use Illuminate\Support\Facades\Artisan;

// Education Course
use App\Http\Controllers\EducationMastersController;

// Firm_Administration //

use App\Http\Controllers\firmadministrationController;

//Ethic Test
use App\Http\Controllers\elearningEthnicTestController;
//Local Adoptation
use App\Http\Controllers\LocalAdoptationTestController;
//Elearning Question
use App\Http\Controllers\ElearningQuestionController;
//Elearning Exam
use App\Http\Controllers\elearningExamController;
// Question Q&A
use App\Http\Controllers\elearningCourseqaController;
// NRV ugandian //
use App\Http\Controllers\nrvController;
use App\Http\Controllers\elearningmainController;

use App\Http\Controllers\tryController;

// General Details Masters
use App\Http\Controllers\generaldetailsMastersController;
use Illuminate\Http\Request;
use App\Http\Controllers\FileuploadController;
use App\Http\Controllers\governmentInstructionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/check-openssl', function () {
    if (extension_loaded('openssl')) {
        return 'OpenSSL is loaded.';
    } else {
        return 'OpenSSL is not loaded.';
    }
});
Route::get('/', function () {
    return view('auth.login');
});

Route::get('/token', function (Request $request) {
    $token = $request->session()->token();

    $token = csrf_token();
    return $token;
});
Route::get('/member_listDrupal', [App\Http\Controllers\webportalController::class, 'member_listDrupal'])->name('member_listDrupal');


Route::post('login', [App\Http\Controllers\LoginController::class, 'login'])->name('login');
Route::get('/profilepage', [\App\Http\Controllers\LoginController::class, 'profilepage'])->name('profilepage');
Route::post('/profile_update', [\App\Http\Controllers\LoginController::class, 'profile_update'])->name('user.profile_update');

// deepika
Route::get('policypage', [\App\Http\Controllers\UserController::class, 'policypage'])->name('policypage');
Route::get('/FAQ', [\App\Http\Controllers\FAQController::class, 'index'])->name('FAQ');
// 


Route::post('/que_search', [\App\Http\Controllers\FAQController::class, 'que_search'])->name('que_search');
Route::post('/ans_search', [\App\Http\Controllers\FAQController::class, 'ans_search'])->name('ans_search');

// Nan Resident ugandian
Route::get('register_member', [App\Http\Controllers\LoginController::class, 'register_member'])->name('register_member');
Route::post('register_memberstore', [App\Http\Controllers\LoginController::class, 'register_memberstore'])->name('register_memberstore');

// for cache clearnig
Route::get('/clear-all', function () {
    $exitcode = Artisan::call('cache:clear');
    dump('cache cleard successfully.(' . $exitcode . ')');
    $exitcode = Artisan::call('route:clear');
    dump('route cache cleard successfully.(' . $exitcode . ')');
    $exitcode = Artisan::call('view:clear');
    dump('view cache cleard successfully.(' . $exitcode . ')');
    if (url()->previous() != url()->current()) {
        return redirect(url()->previous());
    }
})->name('clear-all');

// GT
Route::get('register', [App\Http\Controllers\LoginController::class, 'register'])->name('register');
Route::post('registerstore', [App\Http\Controllers\LoginController::class, 'registerstore'])->name('registerstore');
Route::post('otpsend', [App\Http\Controllers\LoginController::class, 'otpsend'])->name('otpsend');
Route::post('otpverify', [App\Http\Controllers\LoginController::class, 'otpverify'])->name('otpverify');
Route::get('/forgot', [\App\Http\Controllers\LoginController::class, 'forgot'])->name('forgot');
Route::post('/forgot_password', [\App\Http\Controllers\LoginController::class, 'forgot_password'])->name('forgot_password');
Route::get('/reset/{id}', [\App\Http\Controllers\LoginController::class, 'reset'])->name('reset');
Route::post('/reset_password', [\App\Http\Controllers\LoginController::class, 'reset_password'])->name('reset_password');
Route::get('/tokenexpire', [\App\Http\Controllers\AlertController::class, 'tokenexpire'])->name('tokenexpire');


// Education Course Routes //
Route::get('education_course', [App\Http\Controllers\EducationMastersController::class, 'educationcourse_index'])->name('educationcourse_index');
Route::post('educationcourse_store', [App\Http\Controllers\EducationMastersController::class, 'educationcourse_store'])->name('educationcourse_store');
Route::get('/educationcourse/edit', [App\Http\Controllers\EducationMastersController::class, 'educationcourse_edit'])->name('educationcourse_edit');
Route::post('/educationcourse/update', [App\Http\Controllers\EducationMastersController::class, 'educationcourse_update'])->name('educationcourse_update');
Route::post('/educationcourse/delete', [App\Http\Controllers\EducationMastersController::class, 'educationcourse_delete'])->name('educationcourse_delete');

// General Details Masters Route //
Route::get('general_masters', [App\Http\Controllers\generaldetailsMastersController::class, 'gdmasters_index'])->name('gdmasters_index');
Route::post('generalmasters_store', [App\Http\Controllers\generaldetailsMastersController::class, 'gdmastersconstituency_store'])->name('gdmastersconstituency_store');
Route::post('gddistrict_store', [App\Http\Controllers\generaldetailsMastersController::class, 'gdmastersdistrict_store'])->name('gdmastersdistrict_store');
Route::post('gdvillagestore', [App\Http\Controllers\generaldetailsMastersController::class, 'gdmastersvillage_store'])->name('gdmastersvillage_store');

Route::get('district_list', [App\Http\Controllers\RegistrationController::class, 'gddistrict_list'])->name('gddistrict_list');
Route::get('constituency_list', [App\Http\Controllers\RegistrationController::class, 'gdconstituency_list'])->name('constituency_list');
Route::get('village_list', [App\Http\Controllers\RegistrationController::class, 'gdvillage_list'])->name('gdvillage_list');

Route::get('educationcourse_list', [App\Http\Controllers\RegistrationController::class, 'coursename_list'])->name('coursename_list');
Route::post('education_edit', [RegistrationController::class, 'education_edit'])->name('education_edit');


Route::get('/district/fetch', [generaldetailsMastersController::class, 'district_fetch'])->name('district_fetch');
Route::post('/district/update', [generaldetailsMastersController::class, 'district_update'])->name('district_update');

Route::post('/district/edit', [RegistrationController::class, 'district_edit'])->name('district_edit');
Route::get('/gd_district_delete', [App\Http\Controllers\generaldetailsMastersController::class, 'district_delete'])->name('district_delete');

Route::get('/constituency/fetch', [generaldetailsMastersController::class, 'constituency_fetch'])->name('constituency_fetch');


Route::resource('Registration', RegistrationController::class);
Route::resource('payment_new', paymentController::class);
Route::get('education_index', [RegistrationController::class, 'education_index'])->name('education_index');
Route::get('workexp_index', [RegistrationController::class, 'workexp_index'])->name('workexp_index');
Route::get('nruworkexp_index', [RegistrationController::class, 'nruworkexp_index'])->name('nruworkexp_index');
Route::get('nru_expcreate', [RegistrationController::class, 'nruworkexp_create'])->name('nruworkexp_create');
Route::post('nru_store', [RegistrationController::class, 'nrustore'])->name('nrustore');

Route::get('approvalprocess_index', [RegistrationController::class, 'approvalprocess_index'])->name('approvalprocess_index');
Route::get('Committee_index', [RegistrationController::class, 'Committee_index'])->name('Committee_index');

// NRV Routes //

Route::get('approve_nrv', [RegistrationController::class, 'approvenrv_index'])->name('approvenrv_index');
Route::post('approvenrv_store', [RegistrationController::class, 'approvenrv_store'])->name('approvenrv_store');

Route::resource('nrv_approval', nrvController::class);
Route::get('/approve_screen/{id}', [\App\Http\Controllers\nrvController::class, 'approve_screen'])->name('approve_screen');
Route::post('/approve/screen_update', [\App\Http\Controllers\nrvController::class, 'approvescreen_update'])->name('approvescreen_update');
Route::get('/approve/update', [RegistrationController::class, 'approvenrv_edit'])->name('approvenrv_edit');

Route::post('/update/store', [RegistrationController::class, 'update_store'])->name('update_store');

Route::get('educreate', [RegistrationController::class, 'educreate'])->name('educreate');
Route::get('eduedit/{id}', [RegistrationController::class, 'eduedit'])->name('eduedit');
Route::get('expedit/{id}', [RegistrationController::class, 'expedit'])->name('expedit');
Route::get('edushow/{id}', [RegistrationController::class, 'edushow'])->name('edushow');
Route::get('expshow/{id}', [RegistrationController::class, 'expshow'])->name('expshow');
Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

Route::resource('qmaster', questionmastercontroller::class);
Route::resource('/uam_modules', UamModulesController::class);
Route::post('view_proposal_documents', [RegistrationController::class, 'view_proposal_documents'])->name('view_proposal_documents');
Route::post('destroygen', [RegistrationController::class, 'destroygen'])->name('destroygen');
Route::put('destroyexp/{id}', [RegistrationController::class, 'destroyexp'])->name('destroyexp');
Route::put('destroyedu/{id}', [RegistrationController::class, 'destroyedu'])->name('destroyedu');

Route::resource('uam_screens', UamScreensController::class);

Route::post('getscreenpermission', [UamScreensController::class, 'getscreenpermission'])->name('getscreenpermission');

Route::resource('uam_modules_screens', UamModulesScreensController::class);

Route::post('uam_modules_screens/screen_data_get', [UamModulesScreensController::class, 'screen_data_get'])->name('screen_data_get');

Route::post('/uam_modules_screens/get_modules_screen', [UamModulesScreensController::class, 'get_modules_screen']);


Route::resource('uam_roles', UamRolesController::class);

Route::resource('user', UserController::class);

Route::get('list_index', [UamUserController::class, 'list_index'])->name('list_index');

Route::get('/user/delete/{id}', [\App\Http\Controllers\UserController::class, 'delete'])->name('user.delete');

Route::post('update_user_data', [App\Http\Controllers\UserController::class, 'update_user_data'])->name('update_user_data');

Route::get('/reset_token_expire_method', [\App\Http\Controllers\UserController::class, 'reset_token_expire_method'])->name('user.reset_token_expire_method');
Route::post('/user/token_expire_data_update', [\App\Http\Controllers\UserController::class, 'token_expire_data_update'])->name('user.token_expire_data_update');


Route::get('/project_roles_list', [\App\Http\Controllers\UserController::class, 'project_roles_list'])->name('user.project_roles_list');

Route::get('/bulk_upload', [\App\Http\Controllers\UserController::class, 'bulk_upload'])->name('user.bulk_upload');
Route::get('/dummy_bulk_upload', [\App\Http\Controllers\UserController::class, 'dummy_bulk_upload'])->name('user.dummy_bulk_upload');

Route::post('/user/update_toggle', [\App\Http\Controllers\UserController::class, 'update_toggle'])->name('user.update_toggle');

Route::get('/user/edit_permission/{id}', [\App\Http\Controllers\UserController::class, 'edit_permission'])->name('user.edit_permission');

Route::post('/user/update_data_permission', [\App\Http\Controllers\UserController::class, 'update_data_permission'])->name('user.update_data_permission');
Route::get('/unauthenticated', [\App\Http\Controllers\AlertController::class, 'unauthenticated'])->name('unauthenticated');
Route::resource('/uam_data', UamDataController::class);
Route::resource('/faq', FaqController::class);
Route::post('/user_certify', [\App\Http\Controllers\ValuerController::class, 'user_certify'])->name('user_certify');
Route::get('/Certificate_index', [\App\Http\Controllers\ValuerController::class, 'Certificate_index'])->name('Certificate_index');
Route::get('/certificate_issue', [\App\Http\Controllers\ValuerController::class, 'certificate_issue'])->name('certificate_issue');
Route::get('/approvedvaluers', [\App\Http\Controllers\ValuerController::class, 'approvedvaluers'])->name('approvedvaluers');
Route::Post('/approve/valuer', [\App\Http\Controllers\ValuerController::class, 'approve_valuer'])->name('approve_valuer');
Route::get('/approve', [\App\Http\Controllers\ValuerController::class, 'approve'])->name('approve');
Route::get('/approve_for_stake', [\App\Http\Controllers\ValuerController::class, 'approve_for_stake'])->name('approve_for_stake');
Route::post('/allocate_stake_holder', [\App\Http\Controllers\ValuerController::class, 'allocate_stake_holder'])->name('allocate_stake_holder');
Route::post('/ajax_data/get_stake_data', [\App\Http\Controllers\ValuerController::class, 'stakeholder_data'])->name('stakeholder_data');
Route::get('/change_password_admin/{id}', [\App\Http\Controllers\UserController::class, 'change_password_admin'])->name('user.change_password_admin');

Route::post('/designation/bulkdummyupload', [\App\Http\Controllers\DesignationController::class, 'bulkdummyupload'])->name('designation.bulkdummyupload');
Route::post('/dummydesignation/bulkdummyupload', [\App\Http\Controllers\DesignationController::class, 'dummybulkdummyupload'])->name('dummydesignation.bulkdummyupload');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/designation/checking_data', [\App\Http\Controllers\DesignationController::class, 'checking_data'])->name('designation.checking_data');
Route::post('/dummy/designation/checking_data', [\App\Http\Controllers\DesignationController::class, 'dummy_checking_data'])->name('dummydesignation.checking_data');
Route::post('/designation/bulkdemodummyupload', [\App\Http\Controllers\DesignationController::class, 'bulkdemodummyupload'])->name('designation.bulkdemodummyupload');

Route::get('/not_allow', [\App\Http\Controllers\AlertController::class, 'not_allow'])->name('not_allow');
Route::post('/uam_modules_screens/update_data', [\App\Http\Controllers\UamModulesScreensController::class, 'update_data'])->name('uam_modules_screens.update_data');

//auditlog
Route::get('/auditlog', [auditlogController::class, 'login_index'])->name('login_index')->name('auditlog.view');
Route::post('/auditlog/login', [\App\Http\Controllers\auditlogController::class, 'login_search'])->name('auditlog.login');
Route::get('uamlog', [auditlogcontroller::class, 'uamlog'])->name('uamlog');
Route::get('vreglog', [auditlogcontroller::class, 'vreglog'])->name('vreglog');

// DEEPIKA//
// active/operation details
Route::get('/Activeoperation', [activeoperationController::class, 'active_index'])->name('active_index');
Route::post('/Activeoperation/login', [\App\Http\Controllers\activeoperationController::class, 'login_search'])->name('activeoperation.login');

// Firm_Administration
Route::get('/firm_admin', [\App\Http\Controllers\firmadministrationController::class, 'firm_admin_index'])->name('firm_admin_index');
Route::post('/firm_admin_activeupdate', [\App\Http\Controllers\firmadministrationController::class, 'active_edit'])->name('active_update');
Route::post('/firm_admin_permissionupdate', [\App\Http\Controllers\firmadministrationController::class, 'permission_edit'])->name('permission_edit');
Route::post('/firm_admin_permissionstore', [\App\Http\Controllers\firmadministrationController::class, 'permission_store'])->name('permission_store');
Route::get('/firm_admin/fetch', [\App\Http\Controllers\firmadministrationController::class, 'firmadmin_fetch'])->name('firmadmin_fetch');
Route::get('/firm_admin/leave', [\App\Http\Controllers\firmadministrationController::class, 'firmadmin_leave'])->name('firmadmin_leave');


//Iyyappan//

Route::get('/Coursepreview', [App\Http\Controllers\tryController::class, 'Coursepreview'])->name('Coursepreview');
Route::get('/admindashboard', [App\Http\Controllers\tryController::class, 'admindashboard'])->name('admindashboard');
Route::get('/admindashboardevents/fetch', [App\Http\Controllers\tryController::class, 'events_fetch'])->name('admindashboardevents.fetch');
Route::get('/dashboardevents/fetch', [App\Http\Controllers\elearningdashboardgtController::class, 'events_fetch'])->name('dashboardevents.fetch');

Route::get('/admincourse', [App\Http\Controllers\tryController::class, 'admincourse'])->name('admincourse');
//  Route::get('/adminquiz', [App\Http\Controllers\tryController::class, 'adminquiz'])->name('adminquiz');

Route::post('/class_store', [App\Http\Controllers\tryController::class, 'class_store'])->name('class_store');
Route::post('/add_class', [App\Http\Controllers\tryController::class, 'addclass_index'])->name('addclass_index');
Route::get('/class_index', [App\Http\Controllers\tryController::class, 'class_index'])->name('class_index');
Route::post('class_delete', [App\Http\Controllers\tryController::class, 'class_delete'])->name('class_delete');
Route::get('class_edit', [App\Http\Controllers\tryController::class, 'class_edit2'])->name('class_edit');



//  Route::post('/quiz_store', [App\Http\Controllers\tryController::class, 'quiz_store'])->name('quiz_store');
//  Route::get('/quiz_list', [App\Http\Controllers\tryController::class, 'quiz_list'])->name('quiz_list');

Route::get('/coursepreview', [App\Http\Controllers\tryController::class, 'coursepreview'])->name('coursepreview');

Route::post('/course_store', [App\Http\Controllers\tryController::class, 'course_store'])->name('course_store');
Route::get('/course_list', [App\Http\Controllers\tryController::class, 'course_list'])->name('course_list');
Route::post('/course_delete', [App\Http\Controllers\tryController::class, 'course_delete'])->name('course_delete');


Route::post('/event_store', [App\Http\Controllers\tryController::class, 'event_store'])->name('event_store');
Route::get('/event_list', [App\Http\Controllers\tryController::class, 'event_list'])->name('event_list');
Route::post('event_delete', [App\Http\Controllers\tryController::class, 'event_delete'])->name('event_delete');



//  Route::get('/elearningethnictest', [App\Http\Controllers\tryController::class, 'ethnic'])->name('elearningethnictest');

//assessment
//  Route::resource('faq',[App\Http\Controllers\FaqController::class]);
Route::resource('valuerlist', ValuerController::class);
Route::resource('Assessment', AssessmentController::class);
Route::get('/completedasmnt', [App\Http\Controllers\AssessmentController::class, 'completedasmnt'])->name('completedasmnt');
Route::get('/Approved1', [App\Http\Controllers\AssessmentController::class, 'Approved1'])->name('Approved1');
Route::get('/Approved2', [App\Http\Controllers\AssessmentController::class, 'Approved2'])->name('Approved2');
Route::get('/completeddecision', [App\Http\Controllers\AssessmentController::class, 'completeddecision'])->name('completeddecision');
Route::get('/Approved1decision', [App\Http\Controllers\AssessmentController::class, 'Approved1decision'])->name('Approved1decision');
Route::get('/Approved2decision', [App\Http\Controllers\AssessmentController::class, 'Approved2decision'])->name('Approved2decision');

Route::get('duediligence', [App\Http\Controllers\AssessmentController::class, 'duediligence'])->name('duediligence');
Route::get('vrallocation', [App\Http\Controllers\AssessmentController::class, 'vrallocation'])->name('vrallocation');
//valuersfeedback
Route::get('/Valuer_rating', [App\Http\Controllers\ValuerController::class, 'Valuer_rating'])->name('Valuer_rating');
Route::post('ratings_create', [App\Http\Controllers\ValuerController::class, 'ratings_create'])->name('ratings_create');
Route::get('evaluate', [App\Http\Controllers\AssessmentController::class, 'evaluate'])->name('evaluate');
Route::get('inspect', [App\Http\Controllers\AssessmentController::class, 'inspect'])->name('inspect');
Route::get('ValuationReport', [App\Http\Controllers\AssessmentController::class, 'ValuationReport'])->name('ValuationReport');
Route::get('/submittedrequestindex', [App\Http\Controllers\AssessmentController::class, 'submittedrequestindex'])->name('submittedrequestindex');
Route::get('/pendingvaluationindex', [App\Http\Controllers\AssessmentController::class, 'pendingvaluationindex'])->name('pendingvaluationindex');
Route::get('/rejectedrequestindex', [App\Http\Controllers\AssessmentController::class, 'rejectedrequestindex'])->name('rejectedrequestindex');
Route::get('/duediligenceindex', [App\Http\Controllers\AssessmentController::class, 'duediligenceindex'])->name('duediligenceindex');
Route::get('/Inspectionindex', [App\Http\Controllers\AssessmentController::class, 'Inspectionindex'])->name('Inspectionindex');
Route::get('/Evaluationindex', [App\Http\Capproveontrollers\AssessmentController::class, 'Evaluationindex'])->name('Evaluationindex');
Route::get('/valuationreportindex', [App\Http\Controllers\AssessmentController::class, 'valuationreportindex'])->name('valuationreportindex');
Route::get('/gt_interview_delete', [App\Http\Controllers\AssessmentController::class, 'interview_delete'])->name('interview_delete');


Route::post('/user/notifications', [\App\Http\Controllers\UserController::class, 'notifications'])->name('user.notifications');
Route::post('/user/notified', [\App\Http\Controllers\UserController::class, 'notified'])->name('user.notified');

// DEEPIKA//

Route::get('/faq_modules/delete/{id}', [\App\Http\Controllers\FAQmodulesController::class, 'delete'])->name('faq_modules.delete');
Route::resource('/faq_modules', FAQmodulesController::class);
Route::post('/FAQ_modules/update_data', [\App\Http\Controllers\FAQmodulesController::class, 'update_data'])->name('FAQ_modules.update_data');
Route::resource('/FAQ_question', FAQquestionController::class);
Route::get('/FAQ_main', [\App\Http\Controllers\FAQController::class, 'main_index'])->name('main_index');
Route::get('/FAQ_question/delete/{id}', [\App\Http\Controllers\FAQquestionController::class, 'delete'])->name('FAQ_question.delete');
Route::post('/FAQ_question/update_data', [\App\Http\Controllers\FAQquestionController::class, 'update_data'])->name('FAQ_question.update_data');
Route::post('/FAQ_question/update_toggle', [\App\Http\Controllers\FAQquestionController::class, 'update_toggle'])->name('FAQ_question.update_toggle');
Route::get('/valuer/show/{id}', [\App\Http\Controllers\ValuerController::class, 'show'])->name('valuer.show');

//elearning

// Route::get('/elearningAllCourses', [App\Http\Controllers\elearningmainController::class, 'allCourses'])->name('elearningAllCourses');

// Route::get('/elearningAllCourses/sort', [App\Http\Controllers\elearningmainController::class, 'sortedCourses'])->name('elearningAllCourses/sort');

// Route::get('/elearningAllCourses/filter', [App\Http\Controllers\elearningmainController::class, 'filteredCourses'])->name('elearningAllCourses/filter');


Route::get('/elearningWishlist', [App\Http\Controllers\elearningmainController::class, 'wishlist'])->name('elearningWishlist');

// Route::get('/elearningCart', [App\Http\Controllers\elearningmainController::class, 'cart'])->name('elearningCart');

Route::get('/elearningResult', [App\Http\Controllers\elearningmainController::class, 'result'])->name('elearningResult');

Route::get('/elearningAllCourses', [App\Http\Controllers\elearningEthnicTestController::class, 'allCourses'])->name('elearningAllCourses');

Route::get('/elearningCourse/{id}', [App\Http\Controllers\elearningEthnicTestController::class, 'courseOverview'])->name('elearningCourse');

Route::get('/elearningCourse/class/{id}', [App\Http\Controllers\elearningEthnicTestController::class, 'takeCourse'])->name('elearningCourse/class');

Route::get('/Course/bookmark', [App\Http\Controllers\elearningEthnicTestController::class, 'bookmark'])->name('bookmark');

Route::get('/status/update', [App\Http\Controllers\elearningEthnicTestController::class, 'status_update'])->name('statusupdate');

Route::get('/certificatestore', [App\Http\Controllers\elearningEthnicTestController::class, 'certificate_store'])->name('certificate_store');
Route::get('/generatepdf/{id}', [App\Http\Controllers\elearningEthnicTestController::class, 'generatePDF'])->name('generatePDF');
Route::get('/ratings/store', [App\Http\Controllers\elearningEthnicTestController::class, 'ratings_store'])->name('ratings.store');


Route::get('/drupalApi', [App\Http\Controllers\DrupalBaseController::class, 'result'])->name('drupalApi');

Route::get('/importCourses', [App\Http\Controllers\elearningmainController::class, 'elearningsync'])->name('importCourses');

Route::get('/addToCart', [App\Http\Controllers\elearningmainController::class, 'addToCart'])->name('addToCart');

Route::get('/elearningQuiz', [App\Http\Controllers\elearningmainController::class, 'quiz'])->name('elearningQuiz');

Route::get('/elearningAssessment', [App\Http\Controllers\elearningmainController::class, 'assessmentQuiz'])->name('elearningAssessment');

Route::get('/elearningAssessmentSubmit', [App\Http\Controllers\elearningmainController::class, 'assessmentSubmit'])->name('elearningAssessmentSubmit');

Route::get('/elearningQuizResults', [App\Http\Controllers\elearningmainController::class, 'quizresult'])->name('elearningQuizResults');

Route::get('/addWishList', [App\Http\Controllers\elearningmainController::class, 'addWishList'])->name('addWishList');

Route::get('/addQuestion/{id}', [App\Http\Controllers\elearningEthnicTestController::class, 'addQuestion'])->name('addQuestion');

Route::get('/addNote', [App\Http\Controllers\elearningEthnicTestController::class, 'addNewNote'])->name('addNote');

Route::get('/viewNote', [App\Http\Controllers\elearningEthnicTestController::class, 'viewNotes'])->name('viewNote');
Route::get('/updateNote', [App\Http\Controllers\elearningEthnicTestController::class, 'updateNote'])->name('updateNote');
Route::get('/deleteNote', [App\Http\Controllers\elearningEthnicTestController::class, 'deleteNote'])->name('deleteNote');

Route::get('/addreply', [App\Http\Controllers\elearningEthnicTestController::class, 'addreply'])->name('addreply');
Route::get('/replystore', [App\Http\Controllers\elearningEthnicTestController::class, 'replystore'])->name('replystore');
Route::get('/followstore', [App\Http\Controllers\elearningEthnicTestController::class, 'followstore'])->name('followstore');
Route::get('/applyfilter', [App\Http\Controllers\elearningEthnicTestController::class, 'applyfilter'])->name('applyfilter');
Route::get('/class/quiz/{course_id}/{class_id}', [App\Http\Controllers\elearningEthnicTestController::class, 'class_quiz'])->name('class.class_quiz');
Route::post('/class/quiz/store', [App\Http\Controllers\elearningEthnicTestController::class, 'quiz_store'])->name('class.quizstore');
Route::get('/course/exam/{course_id}/{class_id}', [App\Http\Controllers\elearningEthnicTestController::class, 'course_exam'])->name('course.exam');
Route::post('/course/exam/store', [App\Http\Controllers\elearningEthnicTestController::class, 'exam_store'])->name('course.examstore');
Route::get('/elearningCart/{id}', [App\Http\Controllers\elearningEthnicTestController::class, 'cart_index'])->name('elearningCart');
Route::post('/elearningCart/store', [App\Http\Controllers\elearningEthnicTestController::class, 'cart_store'])->name('cart.store');
Route::get('/ElearningRemove/delete', [App\Http\Controllers\elearningEthnicTestController::class, 'cart_delete'])->name('cart.delete');
Route::get('/Elearningmovecart', [App\Http\Controllers\elearningEthnicTestController::class, 'move_cart'])->name('cart.move_cart');




Route::resource('gtapprove', gtapproveController::class);
Route::get('/approve', [\App\Http\Controllers\gtapproveController::class, 'approve'])->name('approve');
Route::post('/approveupdate', [\App\Http\Controllers\gtapproveController::class, 'approveupdate'])->name('approveupdate');
Route::post('/requestupdate', [\App\Http\Controllers\gtapproveController::class, 'requestupdate'])->name('requestupdate');

Route::post('/rejectupdate', [\App\Http\Controllers\gtapproveController::class, 'rejectupdate'])->name('rejectupdate');
Route::post('/approvereject', [\App\Http\Controllers\gtapproveController::class, 'approvereject'])->name('approvereject');
Route::post('/rejecter', [\App\Http\Controllers\gtapproveController::class, 'rejecter'])->name('rejecter');

Route::get('/profession_license', [App\Http\Controllers\UserController::class, 'professional_license'])->name('professional_license');

Route::post('/changereject', [\App\Http\Controllers\gtapproveController::class, 'changereject'])->name('changereject');
Route::get('/request_gt', [\App\Http\Controllers\gtapproveController::class, 'index_gtrequest'])->name('index_gtrequest');


//vpbfeedback
Route::get('/initiation', [\App\Http\Controllers\vbpfeedbackController::class, 'index'])->name('initiation');
Route::get('/initiation/create', [\App\Http\Controllers\vbpfeedbackController::class, 'create'])->name('initiation/create');
Route::post('/stakeholder/storedata', [\App\Http\Controllers\vbpfeedbackController::class, 'master_store'])->name('stakeholder.store');

Route::get('/stakeholder/show', [\App\Http\Controllers\vbpfeedbackController::class, 'show'])->name('stakeholder.show');
Route::get('/Instruction/Process', [\App\Http\Controllers\vbpfeedbackController::class, 'index_data'])->name('instruction');
Route::get('/stakeholder/update', [\App\Http\Controllers\vbpfeedbackController::class, 'update'])->name('stakeholder.update');
Route::get('/stakeholder/delete/{id}', [\App\Http\Controllers\vbpfeedbackController::class, 'delete'])->name('stakeholder.delete');
Route::get('/instruction/store', [\App\Http\Controllers\vbpfeedbackController::class, 'store'])->name('instruction.store');
Route::get('/instruction/reject/store', [\App\Http\Controllers\vbpfeedbackController::class, 'reject'])->name('instrucion_reject');

//instruction_initiate
Route::get('/initiation/create_data/{id}', [\App\Http\Controllers\vbpfeedbackController::class, 'create_data'])->name('initiation.create_data');
Route::get('/instruction/approve', [\App\Http\Controllers\vbpfeedbackController::class, 'approve'])->name('instruction.approve');
Route::post('/instruction/store/edit', [\App\Http\Controllers\vbpfeedbackController::class, 'edit_store'])->name('instrucion.edit');
Route::get('/instruction/data/show', [\App\Http\Controllers\vbpfeedbackController::class, 'data_show'])->name('instruction.data_show');
Route::get('/instruction/stakeholder/show/{id}', [\App\Http\Controllers\vbpfeedbackController::class, 'valuer_show'])->name('valuer_show');
Route::post('/instruction/stakeholder/approve', [\App\Http\Controllers\vbpfeedbackController::class, 'stakeholder_approve'])->name('stakeholder_approve');
Route::post('/instruction/stakeholder_feedback', [\App\Http\Controllers\vbpfeedbackController::class, 'stakeholder_feedback'])->name('stakeholder_feedback');
Route::post('/instruction/valuer_feedback', [\App\Http\Controllers\vbpfeedbackController::class, 'valuer_feedback'])->name('valuer_feedback');
Route::get('/instruction/register', [\App\Http\Controllers\vbpfeedbackController::class, 'registar_index'])->name('registar_index');
Route::get('/instruction/registar/show/{id}', [\App\Http\Controllers\vbpfeedbackController::class, 'registar_show'])->name('registar_show');
Route::post('/instruction/registar_feedback', [\App\Http\Controllers\vbpfeedbackController::class, 'registar_feedback'])->name('registar_feedback');
Route::get('/cgv/approve', [\App\Http\Controllers\vbpfeedbackController::class, 'cgv_index'])->name('cgv_index');
Route::get('/cgv/approve/valuer/{id}', [\App\Http\Controllers\vbpfeedbackController::class, 'cgv_approve'])->name('cgv_approve');
Route::get('/instruction/approve/cgv', [\App\Http\Controllers\vbpfeedbackController::class, 'approve_cgv'])->name('approve_cgv');
Route::get('/instruction/edit/reject/{id}', [\App\Http\Controllers\vbpfeedbackController::class, 'reject_edit'])->name('reject_edit');
Route::get('/reject/store', [\App\Http\Controllers\vbpfeedbackController::class, 'reject_store'])->name('reject_store');
Route::get('/stakeholder/reject/store', [\App\Http\Controllers\vbpfeedbackController::class, 'stakholder_reject'])->name('stakholder_reject');
Route::post('/firm_submit', [\App\Http\Controllers\vbpfeedbackController::class, 'firm_submit'])->name('firm_submit');
Route::get('/instruct/edit/firmreject/{id}', [\App\Http\Controllers\vbpfeedbackController::class, 'firmreject_edit'])->name('firmreject_edit');
Route::get('/firmreject/store', [\App\Http\Controllers\vbpfeedbackController::class, 'firmreject_store'])->name('firmreject_store');





// Firm Registration


Route::get('/firm', [\App\Http\Controllers\firmregistrationController::class, 'firm'])->name('firm');
Route::post('firmregisterstore', [App\Http\Controllers\firmregistrationController::class, 'firmregisterstore'])->name('firmregisterstore');
Route::get('/firm_index', [\App\Http\Controllers\firmregistrationController::class, 'firm_index'])->name('firm_index');
Route::post('/firm_reg', [\App\Http\Controllers\firmregistrationController::class, 'firm_reg'])->name('firm_reg');
Route::get('/Firm_approval_index', [\App\Http\Controllers\firmregistrationController::class, 'firm_approval_index'])->name('Firm_approval_index');
Route::get('/firm_show', [\App\Http\Controllers\firmregistrationController::class, 'firm_show'])->name('firm_show');
Route::post('/firm_approveupdate', [\App\Http\Controllers\firmregistrationController::class, 'firm_approveupdate'])->name('firm_approveupdate');
Route::post('/firm_rejectupdate', [\App\Http\Controllers\firmregistrationController::class, 'firm_rejectupdate'])->name('firm_rejectupdate');
Route::get('firmregistration_show', [firmregistrationController::class, 'firmregistration_show'])->name('firmregistration_show');
Route::get('firmregistration_edit', [firmregistrationController::class, 'firmregistration_edit'])->name('firmregistration_edit');
Route::post('firmregistration_update', [firmregistrationController::class, 'firmregistration_update'])->name('firmregistration_update');
Route::get('/instruct/create/{id}', [\App\Http\Controllers\vbpfeedbackController::class, 'instruct_create'])->name('instruct/create');
Route::get('/instruct', [\App\Http\Controllers\vbpfeedbackController::class, 'instruct_index'])->name('instruct');
Route::get('/firm_update', [vbpfeedbackController::class, 'firm_update'])->name('firm_update');
Route::get('/instruct/show/{id}/{type}', [\App\Http\Controllers\vbpfeedbackController::class, 'instruct_show'])->name('instruct_show');



Route::get('razorpay', [RazorpayController::class, 'razorpay'])->name('razorpay');
Route::post('razorpaypayment', [RazorpayController::class, 'payment'])->name('payment');
Route::get('razorpaylicensepayment', [RazorpayController::class, 'razorpaylicensepayment'])->name('razorpaylicensepayment');
Route::post('/razorpaylicense', [RazorpayController::class, 'licensepayment'])->name('licensepayment');
// ****
Route::get('razorpaycourse', [RazorpayController::class, 'razorpaycourse'])->name('razorpaycourse');
Route::post('razorpaycoursepurchase', [RazorpayController::class, 'razorpaycoursepurchase'])->name('razorpaycoursepurchase');

//
Route::get('razorsummary', [RazorpayController::class, 'summary'])->name('course.summary');
Route::post('razorsummarypayment', [RazorpayController::class, 'summary_payment'])->name('course_summary.payment');


Route::get('Licensepay', [\App\Http\Controllers\licenseapprovalController::class, 'license_payment'])->name('license_payment');
Route::post('/license_reg', [\App\Http\Controllers\licenseapprovalController::class, 'license_register'])->name('license_reg');

Route::get('Professional/Competence', [App\Http\Controllers\AssessmentController::class, 'professional'])->name('professional');
Route::get('Critical/Report', [App\Http\Controllers\AssessmentController::class, 'Critical_Report'])->name('Critical_Report');
Route::post('critical/file_edit', [App\Http\Controllers\AssessmentController::class, 'criticalfile_edit'])->name('criticalfile_edit');

Route::get('/level/Competence/{id}', [AssessmentController::class, 'level'])->name('level.competence');
Route::post('/level/store', [AssessmentController::class, 'level_store'])->name('level_store');
Route::get('/competency/fetch', [AssessmentController::class, 'competency_fetch'])->name('competency_fetch');
Route::get('/competency/store', [AssessmentController::class, 'competency_store'])->name('competency_store');
Route::get('/critical/analysis', [AssessmentController::class, 'critical_analysis'])->name('critical_analysis');
Route::post('/critical/store', [AssessmentController::class, 'critical_store'])->name('critical_store');
Route::get('/critical/approve', [AssessmentController::class, 'critical_approve'])->name('critical_approve');
Route::get('/critial/decision', [AssessmentController::class, 'critical_decision'])->name('critical_decision');
Route::post('/critical/approvegt', [AssessmentController::class, 'approvegt'])->name('approvegt');
Route::get('/interview/process', [AssessmentController::class, 'interview_process'])->name('interview_process');
Route::post('/interview/store', [AssessmentController::class, 'interview_store'])->name('interview_store');

Route::get('/interview/fetch', [AssessmentController::class, 'interview_fetch'])->name('interview_fetch');
Route::post('/interview/update', [AssessmentController::class, 'interview_update'])->name('interview_update');
Route::get('/interview/show', [AssessmentController::class, 'interview_show'])->name('interview_show');

Route::get('/final/assessment', [AssessmentController::class, 'final_assesment'])->name('final_assesment');
Route::get('/interview/update_new', [AssessmentController::class, 'interview_updatenew'])->name('interview_updatenew');

Route::get('/final/approve/{id}', [AssessmentController::class, 'final_approve'])->name('final_approve');
Route::get('/professional_show', [AssessmentController::class, 'professional_show'])->name('professional_show');


//Ethic Test

Route::resource('ethictest', elearningEthnicTestController::class);
//  Route::get('/elearning/ethnictest',[\App\Http\Controllers\elearningEthnicTestController::class, 'index'])->name('elearning-ethnictest');
Route::get('/ethic/fetch', [elearningEthnicTestController::class, 'fetch'])->name('ethictest.fetch');
Route::get('/ethic/delete', [elearningEthnicTestController::class, 'ethnic_delete'])->name('ethictest.delete');
//User side View
Route::get('/ethic/quiz/list', [App\Http\Controllers\elearningEthnicTestController::class, 'list'])->name('ethictest.list');

Route::get('/ethic/quiz', [App\Http\Controllers\elearningEthnicTestController::class, 'quiz'])->name('ethictest.quiz');
Route::post('/ethic/quiz/store', [App\Http\Controllers\elearningEthnicTestController::class, 'quizstore'])->name('ethictest.quizstore');
Route::get('/elearning/allCourses', [App\Http\Controllers\elearningEthnicTestController::class, 'allCourses'])->name('elearning.allCourses');
Route::get('/elearning/wishlist', [App\Http\Controllers\elearningEthnicTestController::class, 'wishlist'])->name('elearning.wishlist');

Route::get('/elearning/cpd', [App\Http\Controllers\elearningEthnicTestController::class, 'cpt_index'])->name('elearning.cpt_index');

//Local Adoptation

//Ethic Test

Route::resource('localadaptationtest', LocalAdoptationTestController::class);
//  Route::get('/elearning/ethnictest',[\App\Http\Controllers\elearningEthnicTestController::class, 'index'])->name('elearning-ethnictest');
Route::get('/localadaptation/fetch', [LocalAdoptationTestController::class, 'fetch'])->name('localadaptation.fetch');
Route::get('/localadaptation/delete', [LocalAdoptationTestController::class, 'ethnic_delete'])->name('localadaptation.delete');
//User side View
Route::get('/localadaptation/quiz/list', [App\Http\Controllers\LocalAdoptationTestController::class, 'list'])->name('localadaptation.list');

Route::get('/localadaptation/quiz', [App\Http\Controllers\LocalAdoptationTestController::class, 'quiz'])->name('localadaptation.quiz');
Route::post('/localadaptation/quiz/store', [App\Http\Controllers\LocalAdoptationTestController::class, 'quizstore'])->name('localadaptation.quizstore');

//Admin quiz
Route::resource('elearningquestion', ElearningQuestionController::class);
Route::post('/elearning/question_long/store', [App\Http\Controllers\ElearningQuestionController::class, 'long_store'])->name('elearningquestion.long_store');
Route::get('/elearning/question_long/show/{id}', [App\Http\Controllers\ElearningQuestionController::class, 'long_show'])->name('elearningquestion.long_show');

Route::get('/elearning/question_long/edit/{id}', [App\Http\Controllers\ElearningQuestionController::class, 'long_edit'])->name('elearningquestion.long_edit');
Route::post('/elearning/question_long/update/{id}', [App\Http\Controllers\ElearningQuestionController::class, 'long_update'])->name('elearningquestion.long_update');
Route::get('/elearning/question_long/fetch', [App\Http\Controllers\ElearningQuestionController::class, 'long_fetch'])->name('elearningquestion.long_fetch');
Route::get('/elearning/question_long/delete', [App\Http\Controllers\ElearningQuestionController::class, 'long_delete'])->name('elearningquestion.long_delete');

//Short
Route::post('/elearning/question_short/store', [App\Http\Controllers\ElearningQuestionController::class, 'short_store'])->name('elearningquestion.short_store');
Route::get('/elearning/question_short/show/{id}', [App\Http\Controllers\ElearningQuestionController::class, 'short_show'])->name('elearningquestion.short_show');
Route::get('/elearning/question_short/edit/{id}', [App\Http\Controllers\ElearningQuestionController::class, 'short_edit'])->name('elearningquestion.short_edit');
Route::post('/elearning/question_short/update/{id}', [App\Http\Controllers\ElearningQuestionController::class, 'short_update'])->name('elearningquestion.short_update');
//mcq
Route::post('/elearning/question_mcq/store', [App\Http\Controllers\ElearningQuestionController::class, 'mcq_store'])->name('elearningquestion.mcq_store');
Route::get('/elearning/question_mcq/show/{id}', [App\Http\Controllers\ElearningQuestionController::class, 'mcq_show'])->name('elearningquestion.mcq_show');
Route::get('/elearning/question_mcq/edit/{id}', [App\Http\Controllers\ElearningQuestionController::class, 'mcq_edit'])->name('elearningquestion.mcq_edit');
Route::post('/elearning/question_mcq/update/{id}', [App\Http\Controllers\ElearningQuestionController::class, 'mcq_update'])->name('elearningquestion.mcq_update');


//true/false
Route::post('/elearning/question_true/store', [App\Http\Controllers\ElearningQuestionController::class, 'true_store'])->name('elearningquestion.true_store');
Route::get('/elearning/question_true/show/{id}', [App\Http\Controllers\ElearningQuestionController::class, 'true_show'])->name('elearningquestion.true_show');
Route::get('/elearning/question_true/edit/{id}', [App\Http\Controllers\ElearningQuestionController::class, 'true_edit'])->name('elearningquestion.true_edit');
Route::post('/elearning/question_true/update/{id}', [App\Http\Controllers\ElearningQuestionController::class, 'true_update'])->name('elearningquestion.true_update');


//quiz create
Route::post('/elearning/question_quiz/store', [App\Http\Controllers\ElearningQuestionController::class, 'quiz_store'])->name('elearning.quiz_store');
Route::get('/elearning/question_quiz/edit/{id}', [App\Http\Controllers\ElearningQuestionController::class, 'quiz_edit'])->name('elearning.quiz_edit');
Route::post('/elearning/question_quiz/update/{id}', [App\Http\Controllers\ElearningQuestionController::class, 'quiz_update'])->name('elearning.quiz_update');
Route::get('/elearning/question_quiz/show/{id}', [App\Http\Controllers\ElearningQuestionController::class, 'quiz_show'])->name('elearning.quiz_show');

//quiz ajax
Route::get('/elearning/question_quiz/get_points', [\App\Http\Controllers\ElearningQuestionController::class, 'get_points'])->name('elearning.get_points');

//User quiz
Route::get('/elearning/quiz/view', [App\Http\Controllers\ElearningQuestionController::class, 'quiz'])->name('elearning.userquiz');
Route::get('/elearning/quiz/results', [App\Http\Controllers\ElearningQuestionController::class, 'quizresult'])->name('elearning.quizresult');


//Route::get('/adminquestion', [App\Http\Controllers\ElearningQuestionController::class, 'adminquestion'])->name('adminquestion');

//Notice Board

Route::post('/notice_store', [App\Http\Controllers\ElearningNoticeBoardController::class, 'notice_store'])->name('elearning.notice_store');
Route::post('/notice_list', [App\Http\Controllers\ElearningNoticeBoardController::class, 'notice_list'])->name('elearning.notice_list');
Route::post('notice_delete', [App\Http\Controllers\ElearningNoticeBoardController::class, 'notice_delete'])->name('elearning.notice_delete');
Route::get('/adminnoticeboard', [App\Http\Controllers\ElearningNoticeBoardController::class, 'adminnoticeboard'])->name('elearning.adminnoticeboard');

Route::get('/notice/show/{id}', [App\Http\Controllers\ElearningNoticeBoardController::class, 'notice_show'])->name('elearning.notice_show');
Route::get('/notice/edit/{id}', [App\Http\Controllers\ElearningNoticeBoardController::class, 'notice_edit'])->name('elearning.notice_edit');
Route::post('/notice/update/{id}', [App\Http\Controllers\ElearningNoticeBoardController::class, 'notice_update'])->name('elearning.notice_update');
Route::get('/notice/fetch', [App\Http\Controllers\ElearningNoticeBoardController::class, 'fetch'])->name('elearning.notice_fetch');
// Route::get('/notice/admindashboard',[App\Http\Controllers\ElearningNoticeBoardController::class, 'admindashboard'])->name('elearning.admindashboard');

Route::get('/elearningDashboard', [App\Http\Controllers\elearningdashboardgtController::class, 'dashboard'])->name('elearningDashboard');


//Event

Route::get('/adminevent_list', [App\Http\Controllers\ElearningEventController::class, 'adminevent_list'])->name('elearning.admineventlist');
Route::post('/event_store', [App\Http\Controllers\ElearningEventController::class, 'event_store'])->name('elearning.event_store');
Route::post('/event_delete', [App\Http\Controllers\ElearningEventController::class, 'event_delete'])->name('elearning.event_delete');
Route::get('/adminevent', [App\Http\Controllers\ElearningEventController::class, 'adminevent'])->name('elearning.adminevent');
Route::get('/event/show/{id}', [App\Http\Controllers\ElearningEventController::class, 'event_show'])->name('elearning.event_show');
Route::get('/event/edit/{id}', [App\Http\Controllers\ElearningEventController::class, 'event_edit'])->name('elearning.event_edit');
Route::post('/event/update/{id}', [App\Http\Controllers\ElearningEventController::class, 'event_update'])->name('elearning.event_update');
Route::get('/event/fetch', [App\Http\Controllers\ElearningEventController::class, 'fetch'])->name('elearning.event_fetch');

//Exam Test

Route::resource('elearningexam', elearningExamController::class);
Route::get('/exam/fetch', [elearningExamController::class, 'fetch'])->name('exam.fetch');
Route::get('/exam/delete', [elearningExamController::class, 'exam_delete'])->name('exam.delete');
//User side View
Route::get('/exam/quiz/list', [App\Http\Controllers\elearningExamController::class, 'list'])->name('exam.list');

Route::get('/exam/quiz', [App\Http\Controllers\elearningExamController::class, 'quiz'])->name('exam.quiz');
Route::post('/exam/quiz/store', [App\Http\Controllers\elearningExamController::class, 'quizstore'])->name('exam.quizstore');
Route::get('class_show', [App\Http\Controllers\tryController::class, 'class_show'])->name('class_show');
Route::get('/class/fetch', [App\Http\Controllers\tryController::class, 'class_fetch'])->name('class.fetch');
Route::get('/class/edit/{class_id}', [App\Http\Controllers\tryController::class, 'class_edit'])->name('elearning.class_edit');
Route::post('/class/update/{class_id}', [App\Http\Controllers\tryController::class, 'class_update'])->name('elearning.class_update');

//Q&A admin
Route::resource('elearningadminqa', elearningCourseqaController::class);
Route::get('/adminqa/delete', [App\Http\Controllers\elearningCourseqaController::class, 'question_delete'])->name('adminquestion.delete');
Route::get('/adminqa/fetch', [App\Http\Controllers\elearningCourseqaController::class, 'fetch'])->name('adminquestion.fetch');
Route::get('/reply/index/{id}', [App\Http\Controllers\elearningCourseqaController::class, 'reply_index'])->name('adminquestion.reply_index');
Route::get('/reply/fetch', [App\Http\Controllers\elearningCourseqaController::class, 'reply_fetch'])->name('adminquestion.reply_fetch');
Route::post('/reply/store', [App\Http\Controllers\elearningCourseqaController::class, 'store'])->name('adminquestion.store');
Route::get('/reply/delete', [App\Http\Controllers\elearningCourseqaController::class, 'reply_delete'])->name('adminreply.delete');

//Cron Job

Route::get('/cronjob/schedular', [App\Http\Controllers\CronjobController::class, 'job_schedular'])->name('cronjob');
Route::get('/schedular/endperiod', [App\Http\Controllers\CronjobController::class, 'schedular_endperiod'])->name('jobcourse.endperiod');

Route::get('/elearning/course/edit/{course_id}', [App\Http\Controllers\tryController::class, 'course_edit'])->name('elearning.course_edit');
Route::post('/elearning/course/update/{course_id}', [App\Http\Controllers\tryController::class, 'course_update'])->name('elearning.course_update');
Route::get('/elearning/course/fetch', [App\Http\Controllers\tryController::class, 'course_fetch'])->name('elearning.course_fetch');
Route::get('course_show', [App\Http\Controllers\tryController::class, 'course_show'])->name('course_show');
Route::get('/rating/admin/index', [App\Http\Controllers\elearningEthnicTestController::class, 'rating_index'])->name('rating_index');


Route::get('/member_list', [App\Http\Controllers\webportalController::class, 'member_list'])->name('member_list');
Route::post('/memberlist_store', [App\Http\Controllers\webportalController::class, 'memberlist_store'])->name('memberlist_store');
Route::post('/member_delete', [App\Http\Controllers\webportalController::class, 'member_delete'])->name('member_delete');
Route::get('member_show', [App\Http\Controllers\webportalController::class, 'member_show'])->name('member_show');
Route::get('/member/fetch', [App\Http\Controllers\webportalController::class, 'member_fetch'])->name('member.fetch');
Route::get('/member/edit/{id}', [App\Http\Controllers\webportalController::class, 'member_edit'])->name('elearning.member_edit');
Route::post('/member/update/{id}', [App\Http\Controllers\webportalController::class, 'member_update'])->name('elearning.member_update');
Route::post('/memberbulk_store', [App\Http\Controllers\webportalController::class, 'memberbulk_store'])->name('memberbulk_store');


// Masters //

Route::get('file_upload', [App\Http\Controllers\FileuploadController::class, 'fileupload_index'])->name('fileupload_index');
Route::post('fileupload_store', [App\Http\Controllers\FileuploadController::class, 'fileupload_store'])->name('fileupload_store');
Route::post('/fileupload/delete', [App\Http\Controllers\FileuploadController::class, 'fileupload_delete'])->name('fileupload_delete');
Route::get('/fileupload/edit', [App\Http\Controllers\FileuploadController::class, 'fileupload_edit'])->name('fileupload_edit');
Route::post('/fileupload/update', [App\Http\Controllers\FileuploadController::class, 'fileupload_update'])->name('fileupload_update');

Route::get('/request/approve', [\App\Http\Controllers\gtapproveController::class, 'specialApprove'])->name('specialApprove');

Route::get('/instruction', [governmentInstructionController::class, 'index'])->name('instruction.index');
Route::get('/instruction/appointment/{id}/{type}', [governmentInstructionController::class, 'appointment'])->name('instruction.appointment');
Route::post('/instruction/storeappointment', [governmentInstructionController::class, 'storeAppointment'])->name('instruction.storeAppointment');
Route::get('/instruction/task/{id}/{type}', [governmentInstructionController::class, 'taskSubmission'])->name('instruction.taskSubmission');
Route::get('/instruction/getData', [governmentInstructionController::class, 'getData'])->name("instruction.getData");
Route::post('/instruction/task/store', [governmentInstructionController::class, 'instructionStore'])->name("instruction.task.store");
Route::post('instruction/task/submit', [governmentInstructionController::class, 'instructionSubmit'])->name("instruction.submit");
Route::post('/instruction/upwardapproval', [governmentInstructionController::class, 'upwardapproval'])->name("instruction.upwardapproval");
Route::post('/instruction/cgvApproval', [governmentInstructionController::class, 'cgvApproval'])->name("instruction.cgvapproval");
Route::post('/instruction/stakeholderApproval', [governmentInstructionController::class, 'stakeholderApproval'])->name("instruction.stakeholderApproval");
Route::post('/instruction/rejectprocess', [governmentInstructionController::class, 'rejectprocess'])->name("instruction.rejectprocess");

//roleassign
Route::get('/Role/Assign', [RoleassignController::class, 'index'])->name('role.assign');
Route::get('/role/update', [RoleassignController::class, 'store'])->name('role.update');
Route::POST('/designation/remove', [RoleassignController::class, 'remove'])->name('update.remove');

//reports
Route::get('/report', [ReportsController::class, 'index'])->name('reports');
Route::get('/report_fetch', [ReportsController::class, 'report_fetch'])->name('report_fetch');
