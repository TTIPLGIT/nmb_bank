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
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<div class="main-content main_contentspace">
    @php
    $course = $rows1['elearning_courses']->first();
    $userIds = explode(',', $course->user_ids ?? '');
    $classIds = explode(',', $course->course_classes ?? '');
    @endphp
    <form method="POST"
        action="{{ route('elearning.course_update', \Crypt::encrypt($course->course_id)) }}"
        enctype="multipart/form-data">

        @csrf

        <div class="card">
            <div class="card-body">

                <h4 style="text-align:center">Edit Course</h4>
<input type="hidden" name="course_edit" value="$course->course_id">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Catagory<span class="error-star" style="color:red;">*</span></label>

                            <select class="form-control" name="course_categoryedit">
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
                            <select class="form-control" name="role_id">
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
                            <select class="form-control" name="designation_id">
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
                            <select class="form-control select2" multiple name="user_ids[]">
                                @foreach($rows['users'] as $userId)
                                <option value="{{$userId->id}}"
                                    {{ in_array($userId->id,$userIds) ? 'selected' : '' }}>
                                    {{$userId->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- COURSE NAME --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Course Name</label>
                            <input type="text"
                                name="course_nameedit"
                                class="form-control"
                                value="{{ $course->course_name }}">
                        </div>
                    </div>


                    {{-- COURSE DESCRIPTION --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Course Description</label>
                            <textarea name="course_descriptionedit"
                                class="form-control">{{ $course->course_description }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-4">


                        <div class="form-group">
                            <label> Course Type:<span class="error-star" style="color:red;">*</span></label>

                            <select class="form-control" name="course_payedit">
                                <option value="free" {{ $course->course_pay=='free' ? 'selected' : '' }}>Free</option>
                            </select>

                        </div>
                    </div>

                    {{-- COURSE CERTIFICATE --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label >Course Certificate</label><br>

                            <input type="radio"
                                name="course_certificateedit"
                                value="1"
                                class="course_certificate"
                                {{ $course->course_certificate == 1 ? 'checked' : '' }}> 
                                <label class="btn btn-outline-primary" for="certificate_expiryno_show">Yes</label>

                            <input type="radio"
                                name="course_certificateedit"
                                value="2"
                                class="course_certificate"
                                {{ $course->course_certificate == 2 ? 'checked' : '' }}> 
                                <label class="btn btn-outline-primary" for="certificate_expiryno_show">No</label>
                        </div>
                    </div>


                    {{-- CERTIFICATE SECTION --}}
                    <div class="col-md-12" id="certificate_section">

                        <div class="row">

                            <div class="col-md-4">
                                <label>Certificate Template</label>

                                <select name="cetificate_template" class="form-control">
                                    <option value="">Select</option>

                                    @foreach($rows1['certificate_templates'] as $row)
                                    <option value="{{$row->certificate_templates_id}}"
                                        {{ $course->cetificate_template == $row->certificate_templates_id ? 'selected':'' }}>
                                        {{$row->template_name}}
                                    </option>
                                    @endforeach

                                </select>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                <label>Certificate Expiry</label><br>

                                <input type="radio"
                                    name="certificate_expiry"
                                    value="1"
                                    class="btn-check certificate_expiry"
                                    {{ $course->certificate_expiry == 1 ? 'checked':'' }}> 
                                    <label class="btn btn-outline-primary" for="certificate_expiryno_show">Yes</label>

                                <input type="radio"
                                    name="certificate_expiry"
                                    value="2"
                                    class="btn-check certificate_expiry"
                                    {{ $course->certificate_expiry == 2 ? 'checked':'' }}>
                                   <label class="btn btn-outline-primary" for="certificate_expiryno_show">No</label>
                                </div>

                            </div>


                            <div class="col-md-4" id="expiry_date_field">

                                <label>Expiry Date</label>

                                <input type="date"
                                    name="course_expiry_period"
                                    class="form-control"
                                    value="{{ $course->course_expiry_period }}">

                            </div>

                        </div>
                    </div>


                    {{-- COURSE EXAM --}}
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Course Exam:<span class="error-star" style="color:red;">*</span></label><br>
                            <input type="radio" class="btn-check exam_show_on course_examshow" name="course_examedit" value="1" id="course_examedit" autocomplete="off" {{ $course->course_exam == 1 ? 'checked' : '' }}>
                            <label class="btn btn-outline-primary exam_show_on1" for="btnradio1">Yes</label>

                            <input type="radio" class="btn-check exam_show_off course_examshow" name="course_examedit" value="2" id="course_examedit" autocomplete="off" {{ $course->course_exam == 2 ? 'checked' : '' }}>
                            <label class="btn btn-outline-primary exam_show_off1" for="btnradio2">No</label>


                        </div>
                    </div>


                    {{-- EXAM SECTION --}}
                    <div class="col-md-12" id="exam_section">
                        <div class="form-group">
                            <div class="row">

                                <div class="col-md-4">

                                    <label>Exam Name</label>

                                    <select name="exam_nameshow" class="form-control">

                                        <option value="">Select Exam</option>

                                        @foreach($rows1['exam_list'] as $exam)
                                        <option value="{{$exam->id}}"
                                            {{ $course->exam_id == $exam->id ? 'selected':'' }}>
                                            {{$exam->exam_name}}
                                        </option>
                                        @endforeach

                                    </select>

                                </div>


                                <div class="col-md-4">

                                    <label>Exam Date</label>

                                    <input type="date"
                                        name="exam_dateshow"
                                        class="form-control"
                                        value="{{ $course->exam_date }}">

                                </div>

                            </div>
                        </div>
                    </div>


                    {{-- START PERIOD --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Course Period</label><br>

                            <input type="radio"
                                name="course_noperiod"
                                value="1"
                                class="course_period"
                                {{ $course->course_noperiod == 1 ? 'checked':'' }}> Yes

                            <input type="radio"
                                name="course_noperiod"
                                value="2"
                                class="course_period"
                                {{ $course->course_noperiod == 2 ? 'checked':'' }}> No
                        </div>
                    </div>


                    <div class="col-md-4 period_fields">

                        <label>Start Date</label>

                        <input type="date"
                            name="course_start_periodedit"
                            class="form-control"
                            value="{{ $course->course_start_period }}">

                    </div>


                    <div class="col-md-4 period_fields">

                        <label>End Date</label>

                        <input type="date"
                            name="course_end_periodedit"
                            class="form-control"
                            value="{{ $course->course_end_period }}">

                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Pass Percentage:<span class="error-star" style="color:red;">*</span></label>
                            <div style="display:flex;align-items: baseline;">
                                <input type="number" class="form-control default" id="pass_percentageshow"
                                    name="pass_percentageshow" value="{{ $course->pass_percentage ?? '' }}" min="1"><span class="col-md-6"
                                    style="color:red;"><strong>(in
                                        percentage only)</strong></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Course Instructor:<span class="error-star" style="color:red;">*</span></label>
                            <input type="text" class="form-control default" id="course_instructorshow"
                                name="course_instructoredit" value="{{ $course->course_instructor ?? '' }}">
                        </div>
                    </div>
                    <div class="col-md-4">

                        <div class="form-group">
                            <label>Course Tags:<span class="error-star" style="color:red;">*</span></label>
                            <div class="wordquestion">
                                <textarea class="form-control default" id="course_tagsshow" name="course_tagsedit">{{ $course->course_tags ?? ''}}</textarea>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Skill Required:<span class="error-star" style="color:red;">*</span></label>
                            <div class="wordquestion">
                                <textarea class="form-control default" id="course_skills_requirededit"
                                    name="course_skills_requirededit"> {{ $course->course_skills_required ?? '' }} </textarea>

                            </div>
                        </div>

                    </div>
                    <div class="col-md-4">

                        <div class="form-group">
                            <label>Gain Skill:<span class="error-star" style="color:red;">*</span></label>
                            <div class="wordquestion">
                                <textarea class="form-control default" id="course_gain_skillsedit"
                                    name="course_gain_skillsedit"> {{ $course->course_gain_skills ?? '' }} </textarea>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>CPD Points: <span class="error-star" style="color:red;">*</span></label>
                            <input type="text" class="form-control default" id="course_cpt_pointsedit"
                                name="course_cpt_pointsedit" value="{{ $course->course_cpt_points ?? ''}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Classes:<span class="error-star" style="color:red;">*</span></label>

                            <br>
                            <select class="js-select5 select2 course_classesshow"
                                id="course_classesshow"
                                multiple="multiple"
                                style="pointer-events:none;" name="course_classesedit[]">

                                @foreach($rows['elearning_classes'] as $data)
                                <option value="{{ $data->class_id }}"
                                    {{ in_array($data->class_id,$classIds) ? 'selected' : '' }}>
                                    {{ $data->class_name }}
                                </option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                    {{-- COURSE INTRODUCTION --}}
                    <div class="col-md-4">

                        <label>Course Introduction</label><br>

                        <input type="file" name="course_introductionedit">

                        <br><br>

                        <iframe width="250"
                            src="{{ config('setting.profile_url').$course->introduction_path.'/'.$course->course_introduction }}">
                        </iframe>

                    </div>


                    {{-- COURSE BANNER --}}
                    <div class="col-md-4">
                        <label>Course Banner</label>

                        <input type="file" name="course_banneredit">

                        <br><br>

                        <img width="200"
                            src="{{ config('setting.profile_url').$course->banner_path.'/'.$course->course_banner }}">

                    </div>


                    {{-- SUMMARY --}}
                    <div class="col-md-4">

                        <label>Course Summary</label>

                        <input type="file" name="course_summaryedit">

                        <br><br>

                        <iframe width="250"
                            src="{{ config('setting.profile_url').$course->summary_path.'/'.$course->course_summary }}">
                        </iframe>

                    </div>
                    <div class="col-md-6">
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
                    <input type="hidden" name="old_course_banner" value="{{ $course->course_banner }}">
                    <input type="hidden" name="old_course_introduction" value="{{ $course->course_introduction  }}">
                    <input type="hidden" name="old_course_summary" value="{{ $course->course_summary  }}">

                    <div class="col-md-12 text-center mt-4">

                        <button type="submit" class="btn btn-success">Update</button>

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
                $("#certificate_section").show();
            } else {
                $("#certificate_section").hide();
            }
        }

        function toggleExpiry() {
            if ($("input[name='certificate_expiry']:checked").val() == 1) {
                $("#expiry_date_field").show();
            } else {
                $("#expiry_date_field").hide();
            }
        }

        function toggleExam() {
            if ($("input[name='course_examedit']:checked").val() == 1) {
                $("#exam_section").show();
            } else {
                $("#exam_section").hide();
            }
        }

        function togglePeriod() {
            if ($("input[name='course_noperiod']:checked").val() == 1) {
                $(".period_fields").show();
            } else {
                $(".period_fields").hide();
            }
        }

        toggleCertificate();
        toggleExpiry();
        toggleExam();
        togglePeriod();

        $("input[name='course_certificateedit']").change(toggleCertificate);
        $("input[name='certificate_expiry']").change(toggleExpiry);
        $("input[name='course_examedit']").change(toggleExam);
        $("input[name='course_noperiod']").change(togglePeriod);

    });
</script>
@endsection