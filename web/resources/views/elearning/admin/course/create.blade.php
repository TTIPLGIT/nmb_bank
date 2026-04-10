{{-- create.blade.php --}}
@extends('layouts.adminnav')

@section('content')
<style>
input[type=checkbox] {
    display: inline-block;
}

.no-arrow {
    -moz-appearance: textfield;
}

.no-arrow::-webkit-inner-spin-button {
    display: none;
}

.no-arrow::-webkit-outer-spin-button,
.no-arrow::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

:root {
    --borderWidth: 5px;
    --height: 24px;
    --width: 12px;
    --borderColor: #78b13f;
}

.gender {
    display: flex;
    align-items: center;
    justify-content: space-evenly;
}

.egc {
    display: flex;
    border: 1px solid #350756;
    padding: 8px 25px 8px 8px;
    align-items: center;
    justify-content: space-between;
}

.dq {
    font-size: 16px;
    width: 80%;
    font-weight: 600;
}

.answer {
    width: 15%;
    display: flex;
    color: #04092e !important;
    justify-content: space-around;
}

.questions {
    color: #000c62 !important
}

input[type='radio']:checked:after {
    background-color: #34395e !important;
}

input[type='radio']:after {
    background-color: #34395e !important;
}

/* radiocss */
.switch-field {
    display: flex;
}

.switch-field input {
    position: absolute !important;
    clip: rect(0, 0, 0, 0);
    height: 1px;
    width: 1px;
    border: 0;
    overflow: hidden;
}

.switch-field label {
    background-color: #e4e4e4;
    color: rgba(0, 0, 0, 0.6);
    font-size: 14px;
    line-height: 1;
    text-align: center;
    padding: 8px 16px;
    margin-right: -1px;
    border: 1px solid rgba(0, 0, 0, 0.2);
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
    transition: all 0.1s ease-in-out;
}

.switch-field label:hover {
    cursor: pointer;
}

.switch-field input:checked+label {
    background-color: #a5dc86;
    box-shadow: none;
}

.switch-field label:first-of-type {
    border-radius: 4px 0 0 4px;
}

.switch-field label:last-of-type {
    border-radius: 0 4px 4px 0;
}

.vl {
    border-left: 1px solid #350756;
    height: 40px;
}

.close {
    color: red;
    opacity: 1;
}

.close:hover {
    color: red;
}

.note {
    background-image: linear-gradient(to right, #3f9a9d, #3f9a9d, #3f9a9d, #3f9a9d, #3f9a9d);
}

.card.longquestion {
    padding: 15px;
}

.wordquestion {
    display: flex;
}

h4.modal-title.long {
    text-align: center;
    padding: 20px;
    font-size: 25px;
}

.container.edit.longquestion {
    padding: 17px;
}

.btn>i {
    /* background-color: darkolivegreen; */
}

@media only screen and (max-width: 425px) {
    .col-sm-2.addquizmodal {
        margin-bottom: 12px;
    }

    textarea#quistion {
        width: 100%;
    }

    textarea#quistions2 {
        width: 100%;
    }

    textarea#quistion11 {
        width: 100%;
    }
}

@media only screen and (max-width: 1024px) {
    .btn.btn-lg {
        padding: 10px 9px;
        font-size: 12px;
    }
}

.btn.btn-lg {
    padding: 10px 10px;
    font-size: 12px;
}

.form-control.default::-webkit-inner-spin-button,
.form-control.default::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.select2-container {
    width: 100% !important;
}

.select2-container--default .select2-search--inline .select2-search__field {
    width: 300px !important;
}

.select2-results__option {
    padding-right: 20px;
    vertical-align: middle;
}

.select2-results__option:before {
    content: "";
    display: inline-block;
    position: relative;
    height: 25px;
    width: 20px;
    border: 2px solid #e9e9e9;
    border-radius: 4px;
    background-color: #fff;
    margin-right: 20px;
    vertical-align: middle;
}

.select2-results__option[aria-selected=true]:before {
    font-family: fontAwesome;
    content: "\f00c";
    color: #fff;
    background-color: #f77750;
    border: 0;
    display: inline-block;
    padding-left: 3px;
}

.select2-container--default .select2-results__option[aria-selected=true] {
    background-color: #fff;
}

.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #78f1f1;
    color: #272727;
    font-weight: bold;
}

.select2-results__option[aria-selected] {
    cursor: pointer;
    color: #060606 !important;
    font-weight: bold;
}

.select2-container--default .select2-selection--multiple {
    margin-bottom: 10px;
}

.select2-container--default.select2-container--open.select2-container--below .select2-selection--multiple {
    border-radius: 4px;
}

.select2-container--default.select2-container--focus .select2-selection--multiple {
    border-color: #f77750;
    border-width: 2px;
}

.select2-container--default .select2-selection--multiple {
    border-width: 2px;
}

.select2-container--open .select2-dropdown--below {
    border-radius: 6px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
}

._table {
    width: 100%;
    border-collapse: collapse;
}

.action_container>* {
    border: none;
    outline: none;
    color: #fff;
    text-decoration: none;
    display: inline-block;
    padding: 8px 14px;
    cursor: pointer;
    transition: 0.3s ease-in-out;
}

.success {
    background-color: #24b96f !important;
}

.danger {
    background-color: #ff5722 !important;
}

.course_period {
    font-size: 18px;
    margin-top: 30px;
    font-weight: bold;
}

tr:first-child .danger {
    display: none;
}

.preview-image {
    max-width: 150px;
    margin-top: 10px;
    border-radius: 5px;
    border: 1px solid #ddd;
    padding: 5px;
}

/* Required field star */
.error-star {
    color: red;
}

/* Datepicker trigger */
.ui-datepicker-trigger {
    position: absolute;
    right: 0px;
    top: 53%;
    left: 80%;
    transform: translateY(-50%);
    height: 25%;
}
</style>
<style>
.select2-container .select2-selection--single {
    height: 39px !important;
}

.select2-selection__choice {
    background-color: #680EDA !important;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: red !important;
}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<!-- Session Messages -->
@if (session('success'))
<input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
<script>
window.onload = function() {
    var message = $('#session_data').val();
    Swal.fire({
        title: "Success",
        text: message,
        icon: "success",
    });
}
</script>
@elseif(session('error'))
<input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
<script>
window.onload = function() {
    var message = $('#session_data1').val();
    Swal.fire({
        title: "Info",
        text: message,
        icon: "info",
    });
}
</script>
@endif

<div class="main-content main_contentspace">
    {{ Breadcrumbs::render('create_course') }}
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12">
            <div class="card">

                <div class="card-body">
                    <div class="card longquestion" style="padding: 0;">
                        <h4 class="modal-title long">Add Course</h4>
                        <form method="post" name="add_course" action="{{ route('course_store') }}"
                            enctype="multipart/form-data" id="course_form" class="reset">
                            @csrf

                            @php
                            $expiredCourseId = request()->get('expired_course_id');
                            $expiredCourseData = null;

                            @endphp

                            @if($expiredCourseId)
                            <input type="hidden" name="is_copied_from_expired" value="1">
                            <input type="hidden" name="expired_course_id" value="{{ $expiredCourseId }}">
                            @endif

                            <!-- Category -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Category<span class="error-star" style="color:red;">*</span></label>
                                        <select class="form-control" name="course_category_id" id="course_category_id">
                                            <option value="">---Select Category---</option>
                                            @foreach($rows['course_catagory_name'] as $data)
                                            <option value="{{$data->catagory_id}}">{{$data->catagory_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Role <span class="error-star" style="color:red;">*</span></label>
                                        <select class="form-control" name="role_id" id="role_id"
                                            onchange="filterDesignations()">
                                            <option value="">---Select Role---</option>
                                            @foreach($roles as $values)
                                            <option value="{{ $values->role_id }}">{{ $values->role_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Designation <span class="error-star" style="color:red;">*</span></label>
                                        <select class="form-control" name="designation_id" id="designation_id"
                                            onchange="filterNames()">
                                            <option value="">Please Select Designation</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Role & Designation & Users -->
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>User Name <span class="text-danger">*</span></label>
                                        <select class="form-control select2" multiple name="user_ids[]" id="user_ids">
                                            @foreach($rows['users'] as $data)
                                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Course Name:<span class="error-star" style="color:red;">*</span></label>
                                        <input type="text" class="form-control default" id="course_name"
                                            name="course_name" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Course Description:<span class="error-star"
                                                style="color:red;">*</span></label><br>
                                        <textarea id="course_description" name="course_description" rows="3"
                                            class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Course Name & Description -->
                            <div class="row">

                            </div>

                            <!-- Course Certificate & Exam -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Course Certificate: <span class="error-star"
                                                style="color:red;">*</span></label><br>
                                        <input type="radio" class="btn-check certificate_radio"
                                            name="course_certificate" value="1" id="course_certificate_yes"
                                            autocomplete="off">
                                        <label class="btn btn-outline-primary" for="course_certificate_yes">Yes</label>
                                        <input type="radio" class="btn-check certificate_radio"
                                            name="course_certificate" value="2" id="course_certificate_no"
                                            autocomplete="off" checked>
                                        <label class="btn btn-outline-primary" for="course_certificate_no">No</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Course Exam:<span class="error-star"
                                                style="color:red;">*</span></label><br>
                                        <input type="radio" class="btn-check course_exam_radio" name="course_exam"
                                            value="1" id="course_examyes" autocomplete="off">
                                        <label class="btn btn-outline-primary" for="course_examyes">Yes</label>
                                        <input type="radio" class="btn-check course_exam_radio" name="course_exam"
                                            value="2" id="course_examno" autocomplete="off" checked>
                                        <label class="btn btn-outline-primary" for="course_examno">No</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Has Course start Date and End Date?<span class="error-star"
                                                style="color:red;">*</span></label><br>
                                        <input type="radio" class="btn-check period_radio" name="course_noperiod"
                                            value="1" id="course_noperiodyes" autocomplete="off">
                                        <label class="btn btn-outline-primary" for="course_noperiodyes">Yes</label>
                                        <input type="radio" class="btn-check period_radio" name="course_noperiod"
                                            value="2" id="course_noperiodno" autocomplete="off" checked>
                                        <label class="btn btn-outline-primary" for="course_noperiodno">No</label>
                                    </div>
                                </div>

                            </div>
                            <!-- Certificate Fields (shows when certificate is Yes) -->
                            <div class="row mt-3" id="certificateFields" style="display: none;">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Certificate Template:<span class="error-star"
                                                style="color:red;">*</span></label>
                                        <select class="form-control" name="cetificate_template"
                                            id="cetificate_template">
                                            <option value="">---Select Certificate Template---</option>
                                            @foreach($rows1['certificate_templates'] as $row)
                                            <option value="{{ $row->certificate_templates_id }}">
                                                {{ $row->template_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Certificate Expiry:<span class="error-star"
                                                style="color:red;">*</span></label><br>
                                        <input type="radio" class="btn-check expiry_radio" name="certificate_expiry"
                                            value="1" id="certificate_expiryyes" autocomplete="off">
                                        <label class="btn btn-outline-primary" for="certificate_expiryyes">Yes</label>
                                        <input type="radio" class="btn-check expiry_radio" name="certificate_expiry"
                                            value="2" id="certificate_expiryno" autocomplete="off" checked>
                                        <label class="btn btn-outline-primary" for="certificate_expiryno">No</label>
                                    </div>
                                </div>
                                <div class="col-md-4" id="expiryDateField" style="display: none;">
                                    <div class="form-group">
                                        <label>Expiry Date:<span class="error-star" style="color:red;">*</span></label>
                                        <input type='date' class="form-control default" id='course_expiry_period'
                                            name="course_expiry_period" placeholder="dd-mm-yy" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <!-- Exam Fields (shows when exam is Yes) -->
                            <div class="row examname" style="display:none;">


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label required">Exam Name:<span class="error-star"
                                                style="color:red;">*</span></label>
                                        <select class="form-control" name="exam_name" id="exam_name">
                                            <option value="">Select Exam Name</option>
                                            @foreach($rows1['exam_list'] as $key => $row)
                                            <option value="{{ $row->id }}">{{ $row->exam_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Exam Date:<span class="error-star" style="color:red;">*</span></label>
                                        <input type='date' class="form-control default exam_date" id="exam_date"
                                            name="exam_date" title="Course Exam Date" autocomplete="off">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Pass Percentage:<span class="error-star"
                                                style="color:red;">*</span></label>
                                        <div style="display:flex;align-items: baseline;">
                                            <input type="number" class="form-control default" id="pass_percentage"
                                                name="pass_percentage" autocomplete="off" max='100' min='0'>
                                            <span class="col-md-6" style="color:red;"><strong>(in percentage
                                                    only)</strong></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Course Period Dates -->
                            <div class="row" id="periodFields" style="display: none;">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Course Start Date:<span class="error-star"
                                                style="color:red;">*</span></label>
                                        <input type='date' class="form-control default startdate"
                                            id='course_start_period' name="course_start_period"
                                            title="Course Start Date" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>CourseEnd Date:<span class="error-star"
                                                style="color:red;">*</span></label>
                                        <input type='date' class="form-control default enddate" id='course_end_period'
                                            name="course_end_period" title="Course End Date" autocomplete="off">
                                    </div>
                                </div>
                            </div>



                            <!-- Course Introduction & Banner -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Course Introduction:<span class="error-star"
                                                style="color:red;">*</span></label>
                                        <input type="file" class="form-control default" id="course_introduction"
                                            name="course_introduction" accept=".mp4,.mp3,.png,.jpg,.jpeg" required>
                                        <span style="color:red !important"><strong>Following files could be uploaded
                                                as
                                                mp4,mp3,png,jpg</strong></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Course Banner:<span class="error-star"
                                                style="color:red;">*</span></label>
                                        <input type="file" class="form-control default" id="course_banner"
                                            name="course_banner" accept="image/*" autocomplete="off" required>
                                        <span style="color:red !important"><strong>Following files could be uploaded
                                                as
                                                jpeg,png,jpg</strong></span>
                                        <img id="bannerPreview" class="preview-image" style="display:none;">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Course Type:<span class="error-star" style="color:red;">*</span></label>
                                        <select class="form-control" name="course_pay" id="course_pay">
                                            <option value="">---Select Course Type---</option>
                                            <option value="free" selected>Free Course</option>
                                            <!-- <option value="paid">Paid Course</option> -->
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Course Type -->
                            <div class="row">

                            </div>

                            <!-- Price Field (for paid courses) -->
                            <div class="row" id="paid" style="display:none;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Course Price:<span class="error-star" style="color:red;">*</span></label>
                                        <input type="number" class="form-control default" id="course_price"
                                            placeholder="Enter the Money(UGX)" name="course_price" autocomplete="off">
                                    </div>
                                </div>
                            </div>






                            <!-- Course Instructor -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Course Instructor:<span class="error-star"
                                                style="color:red;">*</span></label>
                                        <input type="text" class="form-control default" id="course_instructor"
                                            name="course_instructor" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Course Tags:<span class="error-star" style="color:red;">*</span></label>
                                        <div class="wordquestion">
                                            <table class="_table">
                                                <tbody id="table_body">
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control default"
                                                                name="course_tags[]" autocomplete="off"
                                                                placeholder="Enter tags with comma separation">
                                                        </td>
                                                        <!-- <td>
                                                            <div class="action_container">
                                                                <button class="danger" type="button"
                                                                    onclick="remove_tr(this)">
                                                                    <i class="fa fa-close"></i>
                                                                </button>
                                                            </div>
                                                            <div class="action_container" width="50px">
                                                                <button class="success" type="button"
                                                                    onclick="create_tr('table_body')">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                            </div>
                                                        </td> -->
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Skill Required:<span class="error-star"
                                                style="color:red;">*</span></label>
                                        <div class="wordquestion">
                                            <table class="_table">
                                                <tbody id="table_body1">
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control default"
                                                                name="course_skills_required[]" autocomplete="off"
                                                                placeholder="Enter skills with comma separation">
                                                        </td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Course Tags (Dynamic) -->
                            <div class="row">

                            </div>

                            <!-- Skills Required (Dynamic) -->
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Gain Skill:<span class="error-star" style="color:red;">*</span></label>
                                        <div class="wordquestion">
                                            <table class="_table">
                                                <tbody id="table_body3">
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control default"
                                                                name="course_gain_skills[]" autocomplete="off"
                                                                placeholder="Enter skills with comma separation">
                                                        </td>
                                                        <!-- <td>
                                                            <div class="action_container">
                                                                <button class="danger" type="button"
                                                                    onclick="remove_tr(this)">
                                                                    <i class="fa fa-close"></i>
                                                                </button>
                                                            </div>
                                                            <div class="action_container" width="50px">
                                                                <button class="success" type="button"
                                                                    onclick="create_tr3('table_body3')">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                            </div>
                                                        </td> -->
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>CPD Points: <span class="error-star" style="color:red;">*</span></label>
                                        <input type="number" class="form-control default" id="course_cpt_points"
                                            name="course_cpt_points" autocomplete="off" step="0.5">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Classes:<span class="error-star" style="color:red;">*</span></label>
                                        <br>
                                        <select class="form-control select2" name="course_classes[]" id="course_classes"
                                            multiple style="width:100% !important;">

                                            @foreach($rows['elearning_classes'] as $data)
                                            <option value="{{$data->class_id}}">{{$data->class_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- CPD Points & Classes -->
                            <div class="row">

                            </div>

                            <!-- Restricted Access -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Restricted Course Access:<span class="error-star"
                                                style="color:red;">*</span></label><br>
                                        <input type="radio" class="btn-check" name="restricted_access" value="1"
                                            id="restricted_yes" autocomplete="off">
                                        <label class="btn btn-outline-primary" for="restricted_yes">Yes</label>
                                        <input type="radio" class="btn-check" name="restricted_access" value="0"
                                            id="restricted_no" autocomplete="off" checked>
                                        <label class="btn btn-outline-primary" for="restricted_no">No</label>
                                    </div>
                                </div>
                                <div class="col-md-4" id="pinField" style="display:none;">
                                    <div class="form-group">
                                        <label>Access PIN:<span class="error-star" style="color:red;">*</span></label>
                                        <input type="text" class="form-control default" name="course_pin"
                                            id="course_pin" placeholder="Enter 4-6 digit PIN" autocomplete="off"
                                            maxlength="6">
                                        <small class="text-muted">4-6 digit numeric PIN</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <button type="button" class="btn btn-success btn-space savebutton"
                                        onclick="gencre1()" id="savebutton" style="color:white">Submit</button>
                                    <a href="{{ route('admin.courses.index') }}" class="btn btn-danger">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {

    $('.js-select5').select2({
        width: '100%',
        placeholder: "Select Class Name",
        closeOnSelect: false,
        allowClear: true
    });

});
$(".select2").select2({
    closeOnSelect: false,
    placeholder: "Select User Name",
    allowHtml: true,
    allowClear: true,
    tags: true
});
</script>
<script>
$(document).ready(function() {




    // Banner preview
    $('#course_banner').change(function(e) {
        var file = e.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#bannerPreview').attr('src', e.target.result).show();
            };
            reader.readAsDataURL(file);
        }
    });

    // Course type toggle
    $('#course_pay').change(function() {
        if ($(this).val() === 'paid') {
            $('#paid').show();
        } else {
            $('#paid').hide();
            $('#course_price').val('');
        }
    });

    // Certificate toggle - make fields mandatory when Yes
    $('.certificate_radio').change(function() {
        if ($(this).val() == '1') {
            $('#certificateFields').show();
            $('#cetificate_template').prop('required', true);
            $('.expiry_radio').prop('required', true);
        } else {
            $('#certificateFields').hide();
            $('#expiryDateField').hide();
            $('#cetificate_template').prop('required', false);
            $('.expiry_radio').prop('required', false);
            $('#course_expiry_period').prop('required', false);
            $('#course_expiry_period').val('');
        }
    });

    // Certificate expiry toggle
    $('.expiry_radio').change(function() {
        if ($(this).val() == '1') {
            $('#expiryDateField').show();
            $('#course_expiry_period').prop('required', true);
        } else {
            $('#expiryDateField').hide();
            $('#course_expiry_period').prop('required', false);
            $('#course_expiry_period').val('');
        }
    });

    // Course period toggle
    $('.period_radio').change(function() {
        if ($(this).val() == '1') {
            $('#periodFields').show();
            $('#course_start_period').prop('required', true);
            $('#course_end_period').prop('required', true);
        } else {
            $('#periodFields').hide();
            $('#course_start_period').prop('required', false);
            $('#course_end_period').prop('required', false);
            $('#course_start_period').val('');
            $('#course_end_period').val('');
        }
    });

    // Course exam toggle - make fields mandatory when Yes
    $('.course_exam_radio').change(function() {
        if ($(this).val() == '1') {
            $('.examname').show();
            $('#exam_name').prop('required', true);
            $('#exam_date').prop('required', true);
            $('#pass_percentage').prop('required', true);
        } else {
            $('.examname').hide();
            $('#exam_name').prop('required', false);
            $('#exam_date').prop('required', false);
            $('#pass_percentage').prop('required', false);
            $('#exam_name').val('');
            $('#exam_date').val('');
            $('#pass_percentage').val('');
        }
    });

    // Restricted access toggle
    $('input[name="restricted_access"]').change(function() {
        if ($(this).val() == '1') {
            $('#pinField').show();
        } else {
            $('#pinField').hide();
            $('#course_pin').val('');
        }
    });
});

// Designation filtering
var allDesignations = @json($rows['designation']);
var allUsers = @json($rows['users']);

function filterDesignations() {
    const roleId = document.getElementById('role_id').value;
    const designationSelect = document.getElementById('designation_id');
    const userSelect = document.getElementById('user_ids');

    designationSelect.innerHTML = '<option value="">Please Select Designation</option>';

    // Clear and reinitialize select2 for users
    $(userSelect).val(null).trigger('change');

    if (roleId) {
        const filteredDesignations = allDesignations.filter(d => d.role_id == roleId);
        filteredDesignations.forEach(d => {
            const opt = document.createElement('option');
            opt.value = d.designation_id;
            opt.textContent = d.designation_name;
            designationSelect.appendChild(opt);
        });
    }
}

function filterNames() {
    const roleId = document.getElementById('role_id').value;
    const designationId = document.getElementById('designation_id').value;
    const userSelect = document.getElementById('user_ids');

    // Clear existing selections
    $(userSelect).val(null).trigger('change');

    // Clear all existing options except keep a reference
    const currentOptions = $(userSelect).find('option');

    if (designationId && roleId) {
        // Show/hide options based on designation and role
        currentOptions.each(function() {
            const userId = $(this).val();
            const user = allUsers.find(u => u.id == userId);
            if (user && user.designation_id == designationId && user.array_roles == roleId) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    } else {
        // If no designation selected, hide all options
        currentOptions.each(function() {
            $(this).hide();
        });
    }

    // Refresh select2 to reflect changes
    $(userSelect).select2({
        closeOnSelect: false,
        placeholder: "Select User Name",
        allowHtml: true,
        allowClear: true,
        width: '100%'
    });
}

// Dynamic row functions
function create_tr(table_id) {
    const tableBody = document.getElementById(table_id);
    const rows = tableBody.querySelectorAll('tr');
    let isValid = true;
    let emptyFields = [];

    // Validate all existing input fields
    rows.forEach((row, index) => {
        const input = row.querySelector('input');
        if (input && input.value.trim() === '') {
            isValid = false;
            emptyFields.push(`Row ${index + 1}`);
            input.style.borderColor = 'red';
        } else if (input) {
            input.style.borderColor = '';
        }
    });

    if (!isValid) {
        Swal.fire({
            title: "Validation Error",
            text: `Please fill all existing fields before adding a new row. Empty fields in: ${emptyFields.join(', ')}`,
            icon: "error"
        });
        return;
    }

    const firstRow = tableBody.firstElementChild;
    const newRow = firstRow.cloneNode(true);

    const newInput = newRow.querySelector('input');
    if (newInput) {
        newInput.value = '';
        newInput.style.borderColor = '';
    }

    const removeBtn = newRow.querySelector('.danger');
    if (removeBtn) {
        removeBtn.style.display = 'inline-block';
    }

    tableBody.appendChild(newRow);
}

function create_tr1(table_id) {
    const tableBody = document.getElementById(table_id);
    const rows = tableBody.querySelectorAll('tr');
    let isValid = true;
    let emptyFields = [];

    rows.forEach((row, index) => {
        const input = row.querySelector('input');
        if (input && input.value.trim() === '') {
            isValid = false;
            emptyFields.push(`Row ${index + 1}`);
            input.style.borderColor = 'red';
        } else if (input) {
            input.style.borderColor = '';
        }
    });

    if (!isValid) {
        Swal.fire({
            title: "Validation Error",
            text: `Please fill all existing fields before adding a new row. Empty fields in: ${emptyFields.join(', ')}`,
            icon: "error"
        });
        return;
    }

    const firstRow = tableBody.firstElementChild;
    const newRow = firstRow.cloneNode(true);

    const newInput = newRow.querySelector('input');
    if (newInput) {
        newInput.value = '';
        newInput.style.borderColor = '';
    }

    const removeBtn = newRow.querySelector('.danger');
    if (removeBtn) {
        removeBtn.style.display = 'inline-block';
    }

    tableBody.appendChild(newRow);
}

function create_tr3(table_id) {
    const tableBody = document.getElementById(table_id);
    const rows = tableBody.querySelectorAll('tr');
    let isValid = true;
    let emptyFields = [];

    rows.forEach((row, index) => {
        const input = row.querySelector('input');
        if (input && input.value.trim() === '') {
            isValid = false;
            emptyFields.push(`Row ${index + 1}`);
            input.style.borderColor = 'red';
        } else if (input) {
            input.style.borderColor = '';
        }
    });

    if (!isValid) {
        Swal.fire({
            title: "Validation Error",
            text: `Please fill all existing fields before adding a new row. Empty fields in: ${emptyFields.join(', ')}`,
            icon: "error"
        });
        return;
    }

    const firstRow = tableBody.firstElementChild;
    const newRow = firstRow.cloneNode(true);

    const newInput = newRow.querySelector('input');
    if (newInput) {
        newInput.value = '';
        newInput.style.borderColor = '';
    }

    const removeBtn = newRow.querySelector('.danger');
    if (removeBtn) {
        removeBtn.style.display = 'inline-block';
    }

    tableBody.appendChild(newRow);
}

function remove_tr(element) {
    const tbody = element.closest('tbody');
    if (tbody.childElementCount == 1) {
        Swal.fire("Warning", "You cannot delete the last row", "warning");
    } else {
        element.closest('tr').remove();
    }
}

// Collect all dynamic field values
function collectDynamicValues() {
    let tags = [];
    $('#table_body input').each(function() {
        if ($(this).val().trim() !== '') {
            tags.push($(this).val().trim());
        }
    });

    let skillsRequired = [];
    $('#table_body1 input').each(function() {
        if ($(this).val().trim() !== '') {
            skillsRequired.push($(this).val().trim());
        }
    });

    let skillsGained = [];
    $('#table_body3 input').each(function() {
        if ($(this).val().trim() !== '') {
            skillsGained.push($(this).val().trim());
        }
    });

    return {
        tags,
        skillsRequired,
        skillsGained
    };
}

// Form validation and submission
function gencre1() {
    // Basic validations
    var course_category = $("#course_category_id").val();
    if (course_category == '') {
        Swal.fire("Error", "Please Select the Course Category", "error");
        return false;
    }

    var role_id = $("#role_id").val();
    if (role_id == '') {
        Swal.fire("Error", "Please Select the Role", "error");
        return false;
    }

    var designation_id = $("#designation_id").val();
    if (designation_id == '') {
        Swal.fire("Error", "Please Select the Designation", "error");
        return false;
    }

    var user_id = $("#user_ids").val();
    if (user_id == '' || user_id === null || user_id.length === 0) {
        Swal.fire("Error", "Please Select the Users", "error");
        return false;
    }

    var course_name = $("#course_name").val();
    if (course_name == '') {
        Swal.fire("Error", "Please Enter the Course Name", "error");
        return false;
    }

    var course_description = $("#course_description").val();
    if (course_description == '') {
        Swal.fire("Error", "Please Enter the Course Description", "error");
        return false;
    }

    // Course Certificate validation
    var certificateSelected = $('input[name="course_certificate"]:checked').val();
    if (!certificateSelected) {
        Swal.fire("Error", "Please Select the Course Certificate", "error");
        return false;
    }

    // If certificate is Yes, validate certificate fields
    if (certificateSelected == '1') {
        var certificateTemplate = $("#cetificate_template").val();
        if (certificateTemplate == '') {
            Swal.fire("Error", "Please Select the Certificate Template", "error");
            return false;
        }

        var expirySelected = $('input[name="certificate_expiry"]:checked').val();
        if (!expirySelected) {
            Swal.fire("Error", "Please Select Certificate Expiry Option", "error");
            return false;
        }

        if (expirySelected == '1') {
            var expiryDate = $("#course_expiry_period").val();
            if (expiryDate == '') {
                Swal.fire("Error", "Please Select the Certificate Expiry Date", "error");
                return false;
            }
        }
    }

    // Course Exam validation
    var examSelected = $('input[name="course_exam"]:checked').val();
    if (!examSelected) {
        Swal.fire("Error", "Please Select the Course Exam Option", "error");
        return false;
    }

    // If exam is Yes, validate exam fields
    if (examSelected == '1') {
        var examName = $("#exam_name").val();
        if (examName == '') {
            Swal.fire("Error", "Please Select the Exam Name", "error");
            return false;
        }

        var examDate = $("#exam_date").val();
        if (examDate == '') {
            Swal.fire("Error", "Please Select the Exam Date", "error");
            return false;
        }

        var passPercentage = $("#pass_percentage").val();
        if (passPercentage == '') {
            Swal.fire("Error", "Please Enter the Pass Percentage", "error");
            return false;
        }

        if (passPercentage < 1 || passPercentage > 100) {
            Swal.fire("Error", "Pass Percentage must be between 1 and 100", "error");
            return false;
        }
    }

    // File validations
    var course_introduction = $("#course_introduction").val();
    if (course_introduction == '') {
        Swal.fire("Error", "Please Upload the Course Introduction", "error");
        return false;
    }

    var course_banner = $("#course_banner").val();
    if (course_banner == '') {
        Swal.fire("Error", "Please Upload the Course Banner", "error");
        return false;
    }

    // Course type validation
    var course_pay = $("#course_pay").val();
    if (course_pay == '') {
        Swal.fire("Error", "Please Select the Course Type", "error");
        return false;
    }

    if (course_pay == 'paid') {
        var course_price = $("#course_price").val();
        if (course_price == '' || parseFloat(course_price) <= 0) {
            Swal.fire("Error", "Please Enter a Valid Course Price", "error");
            return false;
        }
    }

    // Course Period validation
    var periodSelected = $('input[name="course_noperiod"]:checked').val();
    if (periodSelected == '1') {
        var startDate = $("#course_start_period").val();
        var endDate = $("#course_end_period").val();

        if (startDate == '') {
            Swal.fire("Error", "Please Select the Course Start Date", "error");
            return false;
        }
        if (endDate == '') {
            Swal.fire("Error", "Please Select the Course End Date", "error");
            return false;
        }
        if (new Date(endDate) <= new Date(startDate)) {
            Swal.fire("Error", "End Date must be after Start Date", "error");
            return false;
        }
    }

    // Instructor validation
    var course_instructor = $("#course_instructor").val();
    if (course_instructor == '') {
        Swal.fire("Error", "Please Enter the Course Instructor", "error");
        return false;
    }

    // Dynamic fields validation
    var dynamicValues = collectDynamicValues();

    if (dynamicValues.tags.length === 0) {
        Swal.fire("Error", "Please Add  Course Tag", "error");
        return false;
    }

    if (dynamicValues.skillsRequired.length === 0) {
        Swal.fire("Error", "Please Add Required Skill", "error");
        return false;
    }

    if (dynamicValues.skillsGained.length === 0) {
        Swal.fire("Error", "Please Add Gained Skill", "error");
        return false;
    }

    // CPD Points validation
    var course_cpt_points = $("#course_cpt_points").val();
    if (course_cpt_points == '' || parseFloat(course_cpt_points) < 0) {
        Swal.fire("Error", "Please Enter Valid CPD Points", "error");
        return false;
    }

    // Classes validation
    var course_classes = $("#course_classes").val();
    if (course_classes == '' || course_classes === null || course_classes.length === 0) {
        Swal.fire("Error", "Please Select at Least One Class", "error");
        return false;
    }

    // If restricted access is yes and PIN is empty, generate one
    if ($('input[name="restricted_access"]:checked').val() == '1') {
        var pin = $("#course_pin").val();
        if (pin == '') {
            Swal.fire("Error", "Please Add Pin", "error");
            return false;
            // $("#course_pin").val(Math.floor(100000 + Math.random() * 900000));
        } else if (!/^\d{4,6}$/.test(pin)) {
            Swal.fire("Error", "PIN must be 4-6 digits", "error");
            return false;
        }
    }

    // Remove any existing hidden fields to avoid duplicates
    $('#course_form input[type="hidden"][name="course_tags_hidden"]').remove();
    $('#course_form input[type="hidden"][name="course_skills_required_hidden"]').remove();
    $('#course_form input[type="hidden"][name="course_gain_skills_hidden"]').remove();

    // Set hidden fields with comma-separated values
    $('<input>').attr({
        type: 'hidden',
        name: 'course_tags_hidden',
        value: dynamicValues.tags.join(',')
    }).appendTo('#course_form');

    $('<input>').attr({
        type: 'hidden',
        name: 'course_skills_required_hidden',
        value: dynamicValues.skillsRequired.join(',')
    }).appendTo('#course_form');

    $('<input>').attr({
        type: 'hidden',
        name: 'course_gain_skills_hidden',
        value: dynamicValues.skillsGained.join(',')
    }).appendTo('#course_form');

    // Disable submit button to prevent double submission
    $('#savebutton').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Submitting...');

    // Submit the form
    document.getElementById('course_form').submit();
}
</script>
@endsection