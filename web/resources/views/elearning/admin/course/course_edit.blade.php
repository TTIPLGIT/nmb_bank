@extends('layouts.adminnav')

@section('content')

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

.preview-image {
    max-width: 150px;
    margin-top: 10px;
    border-radius: 5px;
    border: 1px solid #ddd;
    padding: 5px;
}
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<div class="main-content main_contentspace">
    {{ Breadcrumbs::render('edit_course') }}
    @php
    $course = $rows1['elearning_courses']->first();
    $userIds = explode(',', $course->user_ids ?? '');
    $classIds = explode(',', $course->course_classes ?? '');
    $tags = explode(',', $course->course_tags ?? '');
    $skillsRequired = explode(',', $course->course_skills_required ?? '');
    $gainSkills = explode(',', $course->course_gain_skills ?? '');
    @endphp
    <form method="POST" action="{{ route('elearning.course_update', \Crypt::encrypt($course->course_id)) }}"
        enctype="multipart/form-data" id="course_form">

        @csrf

        <div class="card">
            <div class="card-body">

                <h4 style="text-align:center">Edit Course</h4>
                <input type="hidden" name="course_edit" value="{{ $course->course_id }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Category<span class="error-star" style="color:red;">*</span></label>

                            <select class="form-control" name="course_categoryedit" id="course_category_id">
                                <option value="">---Select Category---</option>
                                @foreach($rows['course_catagory_name'] as $data)
                                <option value="{{$data->catagory_id}}"
                                    {{ $course->course_category == $data->catagory_id ? 'selected' : '' }}>
                                    {{$data->catagory_name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Role Selection -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Role <span class="error-star" style="color:red;">*</span></label>
                            <select class="form-control" name="role_id" id="role_id">
                                <option value="">---Select Role---</option>
                                @foreach($roles as $values)
                                <option value="{{ $values->role_id }}"
                                    {{ $course->role_id == $values->role_id ? 'selected' : '' }}>
                                    {{ $values->role_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Designation Selection -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Designation <span class="error-star" style="color:red;">*</span></label>
                            <select class="form-control" name="designation_id" id="designation_id">
                                @foreach($rows['designation'] as $values)
                                <option value="{{ $values->designation_id }}"
                                    {{ $course->designation_id == $values->designation_id ? 'selected' : '' }}>
                                    {{ $values->designation_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>User Name <span class="text-danger">*</span></label>
                            <select class="form-control select2" multiple name="user_ids[]" id="user_ids">
                                @foreach($rows['users'] as $userId)
                                <option value="{{$userId->id}}" {{ in_array($userId->id,$userIds) ? 'selected' : '' }}>
                                    {{$userId->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- COURSE NAME --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Course Name:<span class="error-star" style="color:red;">*</span></label>
                            <input type="text" name="course_nameedit" id="course_name" class="form-control"
                                value="{{ $course->course_name }}">
                        </div>
                    </div>


                    {{-- COURSE DESCRIPTION --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Course Description:<span class="error-star" style="color:red;">*</span></label>
                            <textarea name="course_descriptionedit" id="course_description"
                                class="form-control">{{ $course->course_description }}</textarea>
                        </div>
                    </div>


                    {{-- COURSE CERTIFICATE --}}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Course Certificate:<span class="error-star"
                                        style="color:red;">*</span></label><br>

                                <input type="radio" name="course_certificateedit" value="1"
                                    class="course_certificate certificate_radio"
                                    {{ $course->course_certificate == 1 ? 'checked' : '' }} id="course_certificate_yes">
                                <label class="btn btn-outline-primary" for="course_certificate_yes">Yes</label>

                                <input type="radio" name="course_certificateedit" value="2"
                                    class="course_certificate certificate_radio"
                                    {{ $course->course_certificate == 2 ? 'checked' : '' }} id="course_certificate_no">
                                <label class="btn btn-outline-primary" for="course_certificate_no">No</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Course Exam:<span class="error-star" style="color:red;">*</span></label><br>
                                <input type="radio" class="btn-check exam_show_on course_exam_radio"
                                    name="course_examedit" value="1" id="course_examyes" autocomplete="off"
                                    {{ $course->course_exam == 1 ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary exam_show_on1" for="course_examyes">Yes</label>

                                <input type="radio" class="btn-check exam_show_off course_exam_radio"
                                    name="course_examedit" value="2" id="course_examno" autocomplete="off"
                                    {{ $course->course_exam == 2 ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary exam_show_off1" for="course_examno">No</label>


                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Has Course start Date and End Date?<span class="error-star"
                                        style="color:red;">*</span></label><br>
                                <input type="radio" class="btn-check period_radio" name="course_noperiod" value="1"
                                    id="course_noperiodyes" autocomplete="off"
                                    {{ $course->course_start_period && $course->course_end_period ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="course_noperiodyes">Yes</label>
                                <input type="radio" class="btn-check period_radio" name="course_noperiod" value="2"
                                    id="course_noperiodno" autocomplete="off"
                                    {{ !$course->course_start_period && !$course->course_end_period ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="course_noperiodno">No</label>
                            </div>
                        </div>

                    </div>


                    {{-- CERTIFICATE SECTION --}}


                    <div class="row" id="certificateFields"
                        style="{{ $course->course_certificate == 1 ? '' : 'display: none;' }}">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Certificate Template:<span class="error-star" style="color:red;">*</span></label>

                                <select name="cetificate_template" id="cetificate_template" class="form-control">
                                    <option value="">Select</option>

                                    @foreach($rows1['certificate_templates'] as $row)
                                    <option value="{{$row->certificate_templates_id}}"
                                        {{ $course->cetificate_template == $row->certificate_templates_id ? 'selected':'' }}>
                                        {{$row->template_name}}
                                    </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Certificate Expiry:<span class="error-star"
                                        style="color:red;">*</span></label><br>

                                <input type="radio" name="certificate_expiry" value="1" class="btn-check expiry_radio"
                                    id="certificate_expiryyes" {{ $course->certificate_expiry == 1 ? 'checked':'' }}>
                                <label class="btn btn-outline-primary" for="certificate_expiryyes">Yes</label>

                                <input type="radio" name="certificate_expiry" value="2" class="btn-check expiry_radio"
                                    id="certificate_expiryno" {{ $course->certificate_expiry == 2 ? 'checked':'' }}>
                                <label class="btn btn-outline-primary" for="certificate_expiryno">No</label>
                            </div>

                        </div>


                        <div class="col-md-4" id="expiryDateField"
                            style="{{ $course->certificate_expiry == 1 ? '' : 'display: none;' }}">
                            <div class="form-group">
                                <label>Expiry Date:<span class="error-star" style="color:red;">*</span></label>

                                <input type="date" name="course_expiry_period" id="course_expiry_period"
                                    class="form-control" value="{{ $course->course_expiry_period }}">
                            </div>
                        </div>

                    </div>


                    {{-- EXAM SECTION --}}


                    <div class="row examname" id="examSection"
                        style="{{ $course->course_exam == 1 ? '' : 'display: none;' }}">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Exam Name:<span class="error-star" style="color:red;">*</span></label>

                                <select name="exam_nameshow" id="exam_name" class="form-control">

                                    <option value="">Select Exam</option>

                                    @foreach($rows1['exam_list'] as $exam)
                                    <option value="{{$exam->id}}" {{ $course->exam_id == $exam->id ? 'selected':'' }}>
                                        {{$exam->exam_name}}
                                    </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Exam Date:<span class="error-star" style="color:red;">*</span></label>

                                <input type="date" name="exam_dateshow" id="exam_date" class="form-control"
                                    value="{{ $course->exam_date }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Pass Percentage:<span class="error-star" style="color:red;">*</span></label>
                                <div style="display:flex;align-items: baseline;">
                                    <input type="number" class="form-control default" id="pass_percentage"
                                        name="pass_percentageshow" value="{{ $course->pass_percentage ?? '' }}" min="1"
                                        max="100"><span class="col-md-6" style="color:red;"><strong>(in
                                            percentage only)</strong></span>
                                </div>
                            </div>
                        </div>

                    </div>



                    {{-- START PERIOD --}}



                    <div class="col-md-6 period_fields" id="periodFields"
                        style="{{ $course->course_start_period && $course->course_end_period ? '' : 'display: none;' }}">
                        <div class="form-group">
                            <label>Course Start Date:<span class="error-star" style="color:red;">*</span></label>

                            <input type="date" name="course_start_periodedit" id="course_start_period"
                                class="form-control" value="{{ $course->course_start_period }}">
                        </div>
                    </div>


                    <div class="col-md-6 period_fields" id="periodFieldsEnd"
                        style="{{ $course->course_start_period && $course->course_end_period ? '' : 'display: none;' }}">
                        <div class="form-group">
                            <label>Course End Date:<span class="error-star" style="color:red;">*</span></label>

                            <input type="date" name="course_end_periodedit" id="course_end_period" class="form-control"
                                value="{{ $course->course_end_period }}">
                        </div>
                    </div>


                    <div class="row">
                        {{-- COURSE INTRODUCTION --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Course Introduction:<span class="error-star"
                                        style="color:red;">*</span></label><br>


                                <input type="file" class="form-control default" id="course_introduction"
                                    name="course_introductionedit" accept="image/*,video/*" autocomplete="off">

                                <br><br>
                                @if($course->course_introduction)
                                @php
                                $introPath =
                                config('setting.profile_url').$course->introduction_path.'/'.$course->course_introduction;
                                $introExt = pathinfo($course->course_introduction, PATHINFO_EXTENSION);
                                @endphp
                                @if(in_array(strtolower($introExt), ['jpg', 'jpeg', 'png', 'gif']))
                                <img width="200" src="{{ $introPath }}">
                                @else
                                <video width="250" controls>
                                    <source src="{{ $introPath }}">
                                </video>
                                @endif
                                @endif
                            </div>
                        </div>


                        {{-- COURSE BANNER --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Course Banner:<span class="error-star" style="color:red;">*</span></label>


                                <input type="file" class="form-control default" id="course_banner"
                                    name="course_banneredit" accept="image/*" autocomplete="off">

                                <br><br>
                                @if($course->course_banner)
                                <img id="bannerPreview" width="200"
                                    src="{{ config('setting.profile_url').$course->banner_path.'/'.$course->course_banner }}">
                                @else
                                <img id="bannerPreview" class="preview-image" style="display:none;">
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4">


                            <div class="form-group">
                                <label> Course Type:<span class="error-star" style="color:red;">*</span></label>

                                <select class="form-control" name="course_payedit" id="course_pay">
                                    <option value="free" {{ $course->course_pay=='free' ? 'selected' : '' }}>Free
                                    </option>
                                </select>

                            </div>
                        </div>
                    </div>

                    <!-- Price Field (hidden since only free) -->
                    <div class="row" id="paid" style="display:none;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Price:<span class="error-star" style="color:red;">*</span></label>
                                <input type="number" class="form-control default" id="course_price"
                                    placeholder="Enter the Money(UGX)" name="course_price" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Course Instructor:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="course_instructor"
                                    name="course_instructoredit" value="{{ $course->course_instructor ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Course tags:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="course_tagsedit"
                                    name="course_tagsedit" value="{{ $course->course_tags ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>skills required:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="course_skills_requirededit"
                                    name="course_skills_requirededit"
                                    value="{{ $course->course_skills_required ?? '' }}">
                            </div>
                        </div>


                    </div>



                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Gain Skills:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="course_gain_skillsedit"
                                    name="course_gain_skillsedit" value="{{ $course->course_gain_skills ?? '' }}">
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label>CPD Points: <span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="course_cpt_points"
                                    name="course_cpt_pointsedit" value="{{ $course->course_cpt_points ?? ''}}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Classes:<span class="error-star" style="color:red;">*</span></label>

                                <br>
                                <select class="js-select5 select2 course_classesshow" id="course_classes"
                                    multiple="multiple" name="course_classesedit[]">

                                    @foreach($rows['elearning_classes'] as $data)
                                    <option value="{{ $data->class_id }}"
                                        {{ in_array($data->class_id,$classIds) ? 'selected' : '' }}>
                                        {{ $data->class_name }}
                                    </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Restricted Course Access:<span class="error-star"
                                        style="color:red;">*</span></label><br>

                                <input type="radio" class="btn-check" name="restricted_access" value="1"
                                    id="restricted_yes" autocomplete="off"
                                    {{ $course->restricted_access == 1 ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="restricted_yes">Yes</label>

                                <input type="radio" class="btn-check" name="restricted_access" value="0"
                                    id="restricted_no" autocomplete="off"
                                    {{ $course->restricted_access != 1 ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="restricted_no">No</label>
                            </div>
                        </div>
                        <div class="col-md-4" id="pinField"
                            style="{{ $course->restricted_access == 1 ? '' : 'display: none;' }}">
                            <div class="form-group">
                                <label>Access PIN:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" name="course_pin" id="course_pin"
                                    placeholder="Enter 4-6 digit PIN" autocomplete="off" maxlength="6"
                                    value="{{ $course->course_pin ?? '' }}">
                                <small class="text-muted">4-6 digit numeric PIN (auto-generated if left empty)</small>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="old_course_banner" value="{{ $course->course_banner }}">
                    <input type="hidden" name="old_course_introduction" value="{{ $course->course_introduction  }}">
                    <input type="hidden" name="old_course_summary" value="{{ $course->course_summary  }}">

                    <div class="col-md-12 text-center mt-4">

                        <button type="button" class="btn btn-success" onclick="gencre1()"
                            id="savebutton">Update</button>
                        <a href="{{ route('admin.courses.index') }}" class="btn btn-danger">Cancel</a>
                    </div>

                </div>
            </div>
        </div>

    </form>
</div>

<script>
$(document).ready(function() {

    $('.js-select5').select2({
        width: '100%',
        placeholder: "Select Class Name",
        closeOnSelect: false,
        allowClear: true
    });

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

    function toggleCertificate() {
        if ($("input[name='course_certificateedit']:checked").val() == 1) {
            $("#certificateFields").show();
            $('#cetificate_template').prop('required', true);
            $('.expiry_radio').prop('required', true);
        } else {
            $("#certificateFields").hide();
            $("#expiryDateField").hide();
            $('#cetificate_template').prop('required', false);
            $('.expiry_radio').prop('required', false);
            $('#course_expiry_period').prop('required', false);
        }
    }

    function toggleExpiry() {
        if ($("input[name='certificate_expiry']:checked").val() == 1) {
            $("#expiryDateField").show();
            $('#course_expiry_period').prop('required', true);
        } else {
            $("#expiryDateField").hide();
            $('#course_expiry_period').prop('required', false);
            $('#course_expiry_period').val('');
        }
    }

    function toggleExam() {
        if ($("input[name='course_examedit']:checked").val() == 1) {
            $("#examSection").show();
            $('#exam_name').prop('required', true);
            $('#exam_date').prop('required', true);
            $('#pass_percentage').prop('required', true);
        } else {
            $("#examSection").hide();
            $('#exam_name').prop('required', false);
            $('#exam_date').prop('required', false);
            $('#pass_percentage').prop('required', false);
        }
    }

    function togglePeriod() {
        if ($("input[name='course_noperiod']:checked").val() == 1) {
            $("#periodFields, #periodFieldsEnd").show();
            $('#course_start_period').prop('required', true);
            $('#course_end_period').prop('required', true);
        } else {
            $("#periodFields, #periodFieldsEnd").hide();
            $('#course_start_period').prop('required', false);
            $('#course_end_period').prop('required', false);
            $('#course_start_period').val('');
            $('#course_end_period').val('');
        }
    }

    function toggleRestricted() {
        if ($("input[name='restricted_access']:checked").val() == 1) {
            $("#pinField").show();
        } else {
            $("#pinField").hide();
            $('#course_pin').val('');
        }
    }

    toggleCertificate();
    toggleExpiry();
    toggleExam();
    togglePeriod();
    toggleRestricted();

    $("input[name='course_certificateedit']").change(toggleCertificate);
    $("input[name='certificate_expiry']").change(toggleExpiry);
    $("input[name='course_examedit']").change(toggleExam);
    $("input[name='course_noperiod']").change(togglePeriod);
    $("input[name='restricted_access']").change(toggleRestricted);

});

// Dynamic row functions
function create_tr(table_id) {
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

    // Hide plus button in new row
    const plusBtn = newRow.querySelector('.success');
    if (plusBtn) {
        plusBtn.style.display = 'none';
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

    const plusBtn = newRow.querySelector('.success');
    if (plusBtn) {
        plusBtn.style.display = 'none';
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

    const plusBtn = newRow.querySelector('.success');
    if (plusBtn) {
        plusBtn.style.display = 'none';
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

function remove_tr1(element) {
    const tbody = element.closest('tbody');
    if (tbody.childElementCount == 1) {
        Swal.fire("Warning", "You cannot delete the last row", "warning");
    } else {
        element.closest('tr').remove();
    }
}

function remove_tr3(element) {
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
    var certificateSelected = $('input[name="course_certificateedit"]:checked').val();
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
    var examSelected = $('input[name="course_examedit"]:checked').val();
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


    var course_tagsedit = $("#course_tagsedit").val();
    if (course_tagsedit == '') {
        Swal.fire("Error", "Please Add Required Skill", "error");
        return false;
    }
    var course_skills_requirededit = $("#course_skills_requirededit").val();
    if (course_skills_requirededit == '') {
        Swal.fire("Error", "Please Add Required Skill", "error");
        return false;
    }
    var course_gain_skillsedit = $("#course_gain_skillsedit").val();
    if (course_gain_skillsedit == '') {
        Swal.fire("Error", "Please Add Gained Skill", "error");
        return false;
    }

    // Dynamic fields validation
    // var dynamicValues = collectDynamicValues();

    // if (dynamicValues.tags.length === 0) {
    //     Swal.fire("Error", "Please Add Course Tag", "error");
    //     return false;
    // }

    // if (dynamicValues.skillsRequired.length === 0) {
    //     Swal.fire("Error", "Please Add Required Skill", "error");
    //     return false;
    // }

    // if (dynamicValues.skillsGained.length === 0) {
    //     Swal.fire("Error", "Please Add Gained Skill", "error");
    //     return false;
    // }

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
            $("#course_pin").val(Math.floor(100000 + Math.random() * 900000));
        } else if (!/^\d{4,6}$/.test(pin)) {
            Swal.fire("Error", "PIN must be 4-6 digits", "error");
            return false;
        }
    }

    // Remove any existing hidden fields to avoid duplicates
    $('#course_form input[type="hidden"][name="course_tags_hidden"]').remove();
    $('#course_form input[type="hidden"][name="course_skills_required_hidden"]').remove();
    $('#course_form input[type="hidden"][name="course_gain_skills_hidden"]').remove();

    // // Set hidden fields with comma-separated values
    // $('<input>').attr({
    //     type: 'hidden',
    //     name: 'course_tags_hidden',
    //     value: dynamicValues.tags.join(',')
    // }).appendTo('#course_form');

    // $('<input>').attr({
    //     type: 'hidden',
    //     name: 'course_skills_required_hidden',
    //     value: dynamicValues.skillsRequired.join(',')
    // }).appendTo('#course_form');

    // $('<input>').attr({
    //     type: 'hidden',
    //     name: 'course_gain_skills_hidden',
    //     value: dynamicValues.skillsGained.join(',')
    // }).appendTo('#course_form');

    // Disable submit button to prevent double submission
    $('#savebutton').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Updating...');

    // Submit the form
    document.getElementById('course_form').submit();
}
</script>
@endsection