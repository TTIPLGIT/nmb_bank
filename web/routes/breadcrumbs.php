<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
});

Breadcrumbs::for('Assessment.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Request List', route('Assessment.index'));
});
Breadcrumbs::for('Assessment.create', function (BreadcrumbTrail $trail) {
    $trail->parent('Assessment.index');
    $trail->push('Initiate Request', route('Assessment.create'));
});


Breadcrumbs::for('Assessment.edit', function ($trail, $id) {
    $trail->parent('Assessment.index');
    $trail->push("Edit", route('Assessment.edit', $id));
});
Breadcrumbs::for('Assessment.show', function ($trail, $id) {
    $trail->parent('Assessment.index');
    $trail->push('View', route('Assessment.show', $id));
});
Breadcrumbs::for('duediligenceindex', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Due Diligence List', route('duediligenceindex'));
});

Breadcrumbs::for('duediligence', function (BreadcrumbTrail $trail) {
    $trail->parent('duediligenceindex');
    $trail->push('Due Diligence', route('duediligence'));
});
Breadcrumbs::for('vrallocation', function (BreadcrumbTrail $trail) {
    $trail->parent('duediligenceindex');
    $trail->push('Request Allocation', route('vrallocation'));
});
Breadcrumbs::for('Inspectionindex', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Inspect List', route('Inspectionindex'));
});

Breadcrumbs::for('inspect', function (BreadcrumbTrail $trail) {
    $trail->parent('Inspectionindex');
    $trail->push('Inspect', route('inspect'));
});
Breadcrumbs::for('Evaluationindex', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Evaluation List', route('Evaluationindex'));
});
Breadcrumbs::for('valuerindex', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Valuers list', route('valuerlist.index'));
});
Breadcrumbs::for('valuerallocate', function (BreadcrumbTrail $trail) {
    $trail->parent('valuerindex');
    $trail->push('Valuers Approve', route('approve'));
});

Breadcrumbs::for('gt_index', function (BreadcrumbTrail $trail) {
    $trail->parent('gtapprove');
    $trail->push('GT Approve', route('gtapprove.index'));
});
Breadcrumbs::for('gtapprove', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('GT Approve List', route('gtapprove.index'));
});

Breadcrumbs::for('approvedvaluers', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Approved Valuers', route('approvedvaluers'));
});
Breadcrumbs::for('loginaudit', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Login Audit', route('auditlog.login'));
});
Breadcrumbs::for('activeoperation', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Active Operation', route('activeoperation.login'));
});

Breadcrumbs::for('evaluate', function (BreadcrumbTrail $trail) {
    $trail->parent('Evaluationindex');
    $trail->push('Evaluate', route('evaluate'));
});
Breadcrumbs::for('valuationreportindex', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Report List', route('valuationreportindex'));
});

Breadcrumbs::for('ValuationReport', function (BreadcrumbTrail $trail) {
    $trail->parent('valuationreportindex');
    $trail->push('Valuation Report', route('ValuationReport'));
});

Breadcrumbs::for('Registration.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Registration', route('Registration.index'));
});

Breadcrumbs::for('nrv_approval.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('NRV Approval Index', route('nrv_approval.index'));
});

Breadcrumbs::for('education_index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Education', route('education_index'));
});

Breadcrumbs::for('workexp_index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Work Experience Index', route('workexp_index'));
});

Breadcrumbs::for('Registration.edit', function ($trail, $id) {
    $trail->parent('Registration.index');
    $trail->push('Edit', route('Registration.edit', $id));
});
Breadcrumbs::for('Registration.show', function ($trail, $id) {
    $trail->parent('Registration.index');
    $trail->push('Show', route('Registration.show', $id));
});
Breadcrumbs::for('approved_list', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Approved List', route('approved_list'));
});
Breadcrumbs::for('submit_screen', function ($trail, $id) {
    $trail->parent('approved_list');
    $trail->push($id, route('submit_screen', $id));
});

Breadcrumbs::for('rejected_list', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Rejected List', route('rejected_list'));
});

Breadcrumbs::for('auditlogs', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Audit Logs', route('auditlogs'));
});
Breadcrumbs::for('auditlog', function (BreadcrumbTrail $trail) {
    $trail->parent('auditlogs');
    $trail->push('Field Logs', route('auditlog'));
});
Breadcrumbs::for('Usercreation', function (BreadcrumbTrail $trail) {
    $trail->parent('auditlogs');
    $trail->push('User Creation', route('Usercreation'));
});

Breadcrumbs::for('userslog', function (BreadcrumbTrail $trail) {
    $trail->parent('auditlogs');
    $trail->push('User login', route('userslog'));
});

Breadcrumbs::for('publicform.show', function ($trail, $id) {
    $trail->parent('publicform.index');
    $trail->push($id, route('publicform.show', $id));
});

Breadcrumbs::for('publicform.edit', function ($trail, $id) {
    $trail->parent('publicform.index');
    $trail->push($id, route('publicform.edit', $id));
});

Breadcrumbs::for('users.edit', function ($trail, $id) {
    $trail->parent('users.index');
    $trail->push($id, route('users.edit', $id));
});

Breadcrumbs::for('users.show', function ($trail, $id) {
    $trail->parent('users.index');
    $trail->push($id, route('users.show', $id));
});
Breadcrumbs::for('uam_screens.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Uam Screen', route('uam_screens.index'));
});
Breadcrumbs::for('uam_screens.show', function ($trail, $id) {
    $trail->parent('uam_screens.index');
    $trail->push('Show', route('uam_screens.show', $id));
});
Breadcrumbs::for('uam_screens.edit', function ($trail, $id) {
    $trail->parent('uam_screens.index');
    $trail->push('Edit', route('uam_screens.edit', $id));
});
Breadcrumbs::for('uam_modules.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Uam Module', route('uam_modules.index'));
});

Breadcrumbs::for('uam_modules_screens.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Uam Module Screens', route('uam_modules_screens.index'));
});

Breadcrumbs::for('uam_roles.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Uam Roles', route('uam_roles.index'));
});
Breadcrumbs::for('uam_roles.show', function ($trail, $id) {
    $trail->parent('uam_roles.index');
    $trail->push('Show', route('uam_roles.show', $id));
});
Breadcrumbs::for('uam_roles.edit', function ($trail, $id) {
    $trail->parent('uam_roles.index');
    $trail->push('Edit', route('uam_roles.edit', $id));
});

Breadcrumbs::for('designation.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Designation', route('designation.index'));
});
Breadcrumbs::for('designation.create', function (BreadcrumbTrail $trail) {
    $trail->parent('designation.index');
    $trail->push('Create', route('designation.create'));
});
Breadcrumbs::for('designation.edit', function ($trail, $id) {
    $trail->parent('designation.index');
    $trail->push('Edit', route('designation.edit', $id));
});
Breadcrumbs::for('designation.show', function ($trail, $id) {
    $trail->parent('designation.index');
    $trail->push('Show', route('designation.show', $id));
});

Breadcrumbs::for('certificate_template.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Certificate Template', route('certificate_template.index'));
});

Breadcrumbs::for('certificate_template.edit', function ($trail, $id) {
    $trail->parent('certificate_template.index');
    $trail->push('Details', route('certificate_template.edit', $id));
});

Breadcrumbs::for('certificate_template.show', function ($trail, $id) {
    $trail->parent('certificate_template.index');
    $trail->push('Preview', route('certificate_template.show', $id));
});


Breadcrumbs::for('user.index', function ($trail) {
    $trail->parent('home');
    $trail->push('User', route('user.index'));
});
Breadcrumbs::for('user.show', function ($trail, $id) {
    $trail->parent('user.index');
    $trail->push('Show', route('user.show', $id));
});
Breadcrumbs::for('user.edit', function ($trail, $id) {
    $trail->parent('user.index');
    $trail->push('Edit', route('user.edit', $id));
});
Breadcrumbs::for('uam_modules_screens.show', function ($trail, $id) {
    $trail->parent('uam_modules_screens.index');
    $trail->push('Show', route('uam_modules_screens.show', $id));
});
Breadcrumbs::for('uam_modules.show', function ($trail, $id) {
    $trail->parent('uam_modules.index');
    $trail->push('Show', route('uam_modules.show', $id));
});
Breadcrumbs::for('uam_modules.edit', function ($trail, $id) {
    $trail->parent('uam_modules.index');
    $trail->push('Edit', route('uam_modules.edit', $id));
});
Breadcrumbs::for('user.create', function (BreadcrumbTrail $trail) {
    $trail->parent('user.index');
    $trail->push('Create', route('user.create'));
});
Breadcrumbs::for('uam_modules_screens.create', function (BreadcrumbTrail $trail) {
    $trail->parent('uam_modules_screens.index');
    $trail->push('Create', route('uam_modules_screens.create'));
});
Breadcrumbs::for('uam_modules.create', function (BreadcrumbTrail $trail) {
    $trail->parent('uam_modules.index');
    $trail->push('Create', route('uam_modules.create'));
});
Breadcrumbs::for('uam_roles.create', function (BreadcrumbTrail $trail) {
    $trail->parent('uam_roles.index');
    $trail->push('Create', route('uam_roles.create'));
});
Breadcrumbs::for('uam_screens.create', function (BreadcrumbTrail $trail) {
    $trail->parent('uam_screens.index');
    $trail->push('Create', route('uam_screens.create'));
});
Breadcrumbs::for('faq_modules.create', function (BreadcrumbTrail $trail) {
    $trail->parent('faq_modules.index');
    $trail->push('Create', route('faq_modules.create'));
});
Breadcrumbs::for('faq_modules.index', function ($trail) {
    $trail->parent('home');
    $trail->push('FAQ Modules', route('faq_modules.index'));
});
Breadcrumbs::for('faq_modules.show', function ($trail, $id) {
    $trail->parent('faq_modules.index');
    $trail->push("Show", route('faq_modules.show', $id));
});
Breadcrumbs::for('faq_modules.edit', function ($trail, $id) {
    $trail->parent('faq_modules.index');
    $trail->push("Edit", route('faq_modules.edit', $id));
});
Breadcrumbs::for('FAQ_question.index', function ($trail) {
    $trail->parent('home');
    $trail->push("FAQ Questions", route('FAQ_question.index'));
});
Breadcrumbs::for('FAQ_question.create', function (BreadcrumbTrail $trail) {
    $trail->parent('FAQ_question.index');
    $trail->push('Create', route('FAQ_question.create'));
});
Breadcrumbs::for('FAQ_question.show', function ($trail, $id) {
    $trail->parent('FAQ_question.index');
    $trail->push("Show", route('FAQ_question.show', $id));
});
Breadcrumbs::for('FAQ_question.edit', function ($trail, $id) {
    $trail->parent('FAQ_question.index');
    $trail->push("Edit", route('FAQ_question.edit', $id));
});
Breadcrumbs::for('qmaster.index', function ($trail) {
    $trail->parent('home');
    $trail->push("List of Question", route('qmaster.index'));
});
Breadcrumbs::for('Registrationfirm_index', function ($trail) {
    $trail->parent('home');
    $trail->push('Firm Registration', route('firm_index'));
});

Breadcrumbs::for('Firm_approval_index', function ($trail) {
    $trail->parent('home');
    $trail->push('Firm Approval List', route('Firm_approval_index'));
});

Breadcrumbs::for('vpb_index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Initiation', route('initiation'));
});
Breadcrumbs::for('vpb_create', function (BreadcrumbTrail $trail) {
    $trail->parent('vpb_index');
    $trail->push('Instruction', route('initiation/create'));
});
Breadcrumbs::for('index_data', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('instruction List view', route('instruction'));
});
Breadcrumbs::for('accept/reject_data', function (BreadcrumbTrail $trail) {
    $trail->parent('index_data');
    $trail->push('Accept/Reject', route('instruction'));
});
Breadcrumbs::for('create_data', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('index_data');
    $trail->push('create', route('initiation.create_data', $id));
});
Breadcrumbs::for('registar_index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Registar', route('registar_index'));
});

Breadcrumbs::for('registar_show', function (BreadcrumbTrail $trail) {
    $trail->parent('registar_index');
    $trail->push('Registar_show', route('registar_show'));
});
Breadcrumbs::for('valuer_show', function ($trail, $id) {
    $trail->parent('vpb_index');
    $trail->push("Show", route('valuer_show', $id));
});

Breadcrumbs::for('firm_instruction_show', function ($trail, $id) {
    $trail->parent('index_data');
    $trail->push("Instruction Show", route('instruct/create', $id));
});

Breadcrumbs::for('license_index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('License', route('license_payment'));
});

Breadcrumbs::for('nrv_approval', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('NRU Approve List', route('nrv_approval.index'));
});

Breadcrumbs::for('role.assign', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Role Assign', route('role.assign'));
});

Breadcrumbs::for('firm_admin_index', function ($trail) {
    $trail->parent('home');
    $trail->push('Firm Administration', route('firm_admin_index'));
});
//critical report
Breadcrumbs::for('critical_approve', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Critical Approve List', route('critical_approve'));
});
Breadcrumbs::for('final_assesment', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Final Assessment List', route('final_assesment'));
});
Breadcrumbs::for('final_approve', function ($trail, $id) {
    $trail->parent('final_assesment');
    $trail->push("Registar Approve", route('final_approve', $id));
});
//interview
Breadcrumbs::for('interview_process', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Interview Process List', route('interview_process'));
});

//E-learning
Breadcrumbs::for('admincourse', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Course', route('admincourse'));
});


Breadcrumbs::for('Coursepreview', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Course Preview', route('Coursepreview'));
});
Breadcrumbs::for('adminevent', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Events', route('adminevent'));
});
Breadcrumbs::for('adminnoticeboard', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Notice Board', route('adminnoticeboard'));
});

//Ethic Test Admin
Breadcrumbs::for('ethictest.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Ethics Test', route('ethictest.index'));
});

//Ethic Test User
Breadcrumbs::for('ethictest.list', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Ethics Test', route('ethictest.list'));
});
Breadcrumbs::for('ethictest.quiz', function (BreadcrumbTrail $trail) {
    $trail->parent('ethictest.list');
    $trail->push('Take Test', route('ethictest.quiz'));
});

//Local Adaptation Test Admin
Breadcrumbs::for('localadaptationtest.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('AT', route('localadaptationtest.index'));
});

//Local Adaptation Test User
Breadcrumbs::for('localadaptation.list', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('AT', route('localadaptation.list'));
});
Breadcrumbs::for('localadaptation.quiz', function (BreadcrumbTrail $trail) {
    $trail->parent('localadaptation.list');
    $trail->push('Take Test', route('localadaptation.quiz'));
});
//Question 
Breadcrumbs::for('elearningquestion.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Quiz', route('elearningquestion.index'));
});

//Exam Test Admin
Breadcrumbs::for('elearningexam.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Exam', route('elearningexam.index'));
});

//Exam User
Breadcrumbs::for('exam.list', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Exam', route('exam.list'));
});
Breadcrumbs::for('exam.quiz', function (BreadcrumbTrail $trail) {
    $trail->parent('exam.list');
    $trail->push('Take Test', route('exam.quiz'));
});
//Noticeboard Admin
Breadcrumbs::for('elearning.notice_list', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Notice Board', route('elearning.notice_list'));
});
//Events Admin
Breadcrumbs::for('elearning.admineventlist', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Event', route('elearning.admineventlist'));
});

//Q&A Admin
Breadcrumbs::for('elearningadminqa.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Question', route('elearningadminqa.index'));
});
Breadcrumbs::for('adminquestion.reply_index', function ($trail, $id) {
    $trail->parent('elearningadminqa.index');
    $trail->push('Reply', route('adminquestion.reply_index', $id));
});

// Education Course
Breadcrumbs::for('educationcourse_index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Educationcourse index', route('educationcourse_index'));
});

Breadcrumbs::for('educreate', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Education creation', route('educreate'));
});

Breadcrumbs::for('elearningDashboard', function (BreadcrumbTrail $trail) {
    $trail->push('EDash', route('elearningDashboard'));
});

Breadcrumbs::for('elearning.cpt_index', function (BreadcrumbTrail $trail) {
    $trail->parent('elearningDashboard');
    $trail->push('CPD List', route('elearning.cpt_index'));
});

Breadcrumbs::for('elearning.userquiz', function (BreadcrumbTrail $trail) {
    $trail->parent('elearningDashboard');
    $trail->push('Quiz', route('elearning.userquiz'));
});

Breadcrumbs::for('rating_index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Ratings', route('rating_index'));
});
Breadcrumbs::for('member_list', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Member List', route('member_list'));
});
Breadcrumbs::for('RequestGt.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Special Request', route('index_gtrequest'));
});

Breadcrumbs::for('instruction.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Instruction', route('instruction.index'));
});

Breadcrumbs::for('instruction.appointment', function ($trail, $id) {
    $trail->parent('instruction.index');
    $trail->push("Appointment", route('valuer_show', $id));
});

//reports

Breadcrumbs::for('reports', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Reports', route('reports'));
});