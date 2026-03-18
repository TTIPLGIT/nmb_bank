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
    @if (session('success'))


    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">

    <script type="text/javascript">
        $(document).ready(function() {

            var message = $('#session_data').val();
            // alert(message);
            console.log(message);
            swal.fire({
                title: "Success",
                text: message,
                icon: "success",
            });

        })
    </script>
    @elseif(session('error'))

    <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data1').val();
            swal.fire({
                title: "Info",
                text: message,
                icon: "info",
            });

        }
    </script>
    @endif

    @php
    $course = $rows1['elearning_courses']->first();
    $userIds = explode(',', $course->user_ids ?? '');
    $classIds = explode(',', $course->course_classes ?? '');
    @endphp

    <div class="card longquestion" id="">
        <input type="hidden" name="course_editshow" class="course_edit" id="course_editshow">
        <div class="card">
            <div class="card-body">
                <h4 style="text-align:center">Show Course:</h4>

                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Catagory<span class="error-star" style="color:red;">*</span></label>

                            <select class="form-control" disabled>
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
                            <select class="form-control" disabled>
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
                            <select class="form-control" disabled>
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
                            <select class="form-control select2" multiple disabled>
                                @foreach($rows['users'] as $userId)
                                <option value="{{$userId->id}}"
                                    {{ in_array($userId->id,$userIds) ? 'selected' : '' }}>
                                    {{$userId->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Course Name:<span class="error-star" style="color:red;">*</span></label>
                            <input type="text" class="form-control default" id="course_nameshow" name="course_name" value="{{ $course->course_name ?? ''}} " disabled>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Course Description:<span class="error-star"
                                    style="color:red;">*</span></label><br>
                            <textarea id="course_descriptionshow" name="course_description" rows="3"
                                class="form-control" disabled>{{ $course->course_description }}</textarea>

                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Course Certificate:</label><br>
                            <input type="radio" class="btn-check" name="course_certificate" value="1" id="course_certificate_yes" {{ $course->course_certificate == 1 ? 'checked' : '' }} disabled>
                            <label class="btn btn-outline-primary" for="course_certificate_yes"> Yes</label>
                            <input type="radio" class="btn-check" name="course_certificate" value="2" id="course_certificate_no" {{ $course->course_certificate == 2 ? 'checked' : '' }} disabled>
                            <label class="btn btn-outline-primary" for="course_certificate_no"> No</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Course Exam:<span class="error-star" style="color:red;">*</span></label><br>
                            <input type="radio" class="btn-check exam_show_on course_examshow" name="course_exam" value="1" id="course_examshow" autocomplete="off" {{ $course->course_exam == 1 ? 'checked' : '' }} disabled>
                            <label class="btn btn-outline-primary exam_show_on1" for="btnradio1">Yes</label>

                            <input type="radio" class="btn-check exam_show_off course_examshow" name="course_exam" value="2" id="course_examshow" autocomplete="off" {{ $course->course_exam == 2 ? 'checked' : '' }} disabled>
                            <label class="btn btn-outline-primary exam_show_off1" for="btnradio2">No</label>


                        </div>
                    </div>

                    <div class="col-md-4">


                        <div class="form-group">
                            <label> Course Type:<span class="error-star" style="color:red;">*</span></label>

                            <select class="form-control" disabled>
                                <option value="paid" {{ $course->course_pay=='paid' ? 'selected' : '' }}>Paid</option>
                                <option value="free" {{ $course->course_pay=='free' ? 'selected' : '' }}>Free</option>
                            </select>

                        </div>
                    </div>
                    <div class="col-md-4 form-group"
                        style="justify-content: space-evenly;align-items: center;"><label>This Course
                            has Start and End Period<span class="error-star" style="color:red;">*</span></label></br>
                        <div class="col-md-6 form-group">
                            <input type="radio" class="btn-check answer_show_on course_noperiodshow" name="course_noperiod" value="1" id="course_noperiodshow" autocomplete="off" {{ $course->course_noperiod== 1 ? 'checked' : '' }} disabled>
                            <label class="btn btn-outline-primary answer_show_on1" for="course_noperiodyes">Yes</label>

                            <input type="radio" class="btn-check answer_show_off course_noperiodshow" name="course_noperiod" value="2" id="course_noperiodshow" autocomplete="off" {{ $course->course_noperiod== 2 ? 'checked' : '' }} disabled>
                            <label class="btn btn-outline-primary answer_show_off1" for="course_noperiodno">No</label>
                        </div>
                    </div>
                    @if($course->course_noperiod== 1)

                    <div class="col-md-4">

                        <div class="form-group">
                            <label>Start Date:<span class="error-star" style="color:red;">*</span></label>
                            <input type='text' class="form-control default" id='course_start_periodshow' disabled
                                name="course_start_period" title="Meeting Start Date" placeholder="dd-mm-yy"
                                onchange="autodateupdate(this)" required autocomplete="off" value="{{ $course->course_start_period ?? ''}} ">
                        </div>

                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>End Date:<span class="error-star" style="color:red;">*</span></label>
                            <input type='text' class="form-control default" id='course_end_periodshow' disabled
                                name="course_end_period" title="Meeting Start Date" placeholder="dd-mm-yy"
                                onchange="autodateupdate(this)" required autocomplete="off" value="{{ $course->course_end_period  ?? ''}}">
                        </div>
                    </div>
                    @endif
                    @if($course->course_exam == 1)
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label required">Exam Name:<span class="error-star"
                                    style="color:red;">*</span></label>
                            <select class="form-control" name="exam_nameshow" id="exam_nameshow" disabled>
                                <option value="">Select Exam Name</option>
                                @foreach($rows1['exam_list'] as $exam)
                                @if(is_object($exam))
                                <option value="{{ $exam->id }}"
                                    {{ $course->exam_id == $exam->id ? 'selected' : '' }}>
                                    {{ $exam->exam_name }}
                                </option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">

                        <div class="form-group">
                            <label>Exam Date:<span class="error-star" style="color:red;">*</span></label>
                            <input type='text' class="form-control default exam_dateshow" id='exam_dateshow'
                                name="exam_dateshow" title="Course Exam Date" autocomplete="off" value="{{ $course->exam_date  ?? ''}}" disabled>
                        </div>

                    </div>
                    @endif

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Pass Percentage:<span class="error-star" style="color:red;">*</span></label>
                            <div style="display:flex;align-items: baseline;">
                                <input type="text" class="form-control default" id="pass_percentageshow"
                                    name="pass_percentageshow" value="{{ $course->pass_percentage ?? '' }}" disabled><span class="col-md-6"
                                    style="color:red;"><strong>(in
                                        percentage only)</strong></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Course Instructor:<span class="error-star" style="color:red;">*</span></label>
                            <input type="text" class="form-control default" id="course_instructorshow"
                                name="course_instructor" value="{{ $course->course_instructor ?? '' }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-4">

                        <div class="form-group">
                            <label>Course Tags:<span class="error-star" style="color:red;">*</span></label>
                            <div class="wordquestion">
                                <textarea class="form-control default" id="course_tagsshow" name="course_tags"
                                    style="background-color: #e9ecef !important;">{{ $course->course_tags ?? ''}}</textarea>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Skill Required:<span class="error-star" style="color:red;">*</span></label>
                            <div class="wordquestion">
                                <textarea class="form-control default" id="course_skills_requiredshow"
                                    name="course_skills_required"
                                    style="background-color: #e9ecef !important;"> {{ $course->course_skills_required ?? '' }} </textarea>

                            </div>
                        </div>

                    </div>
                    <div class="col-md-4">

                        <div class="form-group">
                            <label>Gain Skill:<span class="error-star" style="color:red;">*</span></label>
                            <div class="wordquestion">
                                <textarea class="form-control default" id="course_gain_skillsshow"
                                    name="course_gain_skills"
                                    style="background-color: #e9ecef !important;"> {{ $course->course_gain_skills ?? '' }} </textarea>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>CPD Points: <span class="error-star" style="color:red;">*</span></label>
                            <input type="text" class="form-control default" id="course_cpt_pointsshow"
                                name="course_cpt_points" value="{{ $course->course_cpt_points ?? ''}}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Classes:<span class="error-star" style="color:red;">*</span></label>

                            <br>
                            <select class="js-select5 select2 course_classesshow"
                                id="course_classesshow"
                                multiple="multiple"
                                style="pointer-events:none;">

                                @foreach($rows['elearning_classes'] as $data)
                                <option value="{{ $data->class_id }}"
                                    {{ in_array($data->class_id,$classIds) ? 'selected' : '' }}>
                                    {{ $data->class_name }}
                                </option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Course Introduction:<span class="error-star" style="color:red;">*</span></label>
                            <!-- <div class="col-md-10"
                                style="display: flex;justify-content: space-between;margin-bottom: 15px;">
                                <a class="btn btn-link btn-warning" onclick="changeimage1(event);"
                                    id="change_banner1">Change Introduction</a>
                                <a class="btn btn-link btn-warning" onclick="changeimage1(event);"
                                    id="change_cancel1" style="display:none;">Cancel</a>
                            </div> -->
                            <input type="file" class="form-control default" id="course_introductionedit"
                                name="course_introductionedit" style="display:none;" autocomplete="off">

                            <iframe src="{{ config('setting.profile_url').$course->introduction_path.'/'.$course->course_introduction }}" id="course_introductionedit" class="img-fluid1" alt="Banner Image" width="300"
                                height="150"></iframe>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Course Banner:<span class="error-star" style="color:red;">*</span></label>
                            <!-- <div class="col-md-10"
                                style="display: flex;justify-content: space-between;margin-bottom: 15px;">
                                <a class="btn btn-link btn-warning" onclick="changeimage2(event);"
                                    id="change_banner2">Change Banner</a>
                                <a class="btn btn-link btn-warning" onclick="changeimage2(event);"
                                    id="change_cancel2" style="display:none;">Cancel</a>
                            </div> -->
                            @if(!empty($course->course_banner))
                            <img class="img-fluid2"
                                src="{{ config('setting.profile_url').$course->banner_path.'/'.$course->course_banner }}"
                                width="200"
                                height="200">
                            @else
                            <img src="{{config('setting.profile_url')}}uploads/class/126/empty.jpg"
                                width="200"
                                height="200">
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Course Summary for chatbot:<span class="error-star"
                                    style="color:red;">*</span></label>

                            <@if(!empty($course->course_summary))
                            <iframe
                                src="{{ config('setting.profile_url').$course->summary_path.'/'.$course->course_summary }}"
                                width="300"
                                height="150">
                            </iframe>
                            @endif
                        </div>
                    </div>



                    @if($course->course_certificate == 1)

                    <div class=" col md-6" id="certificateFields_show">
                        <!-- <div class="col-md"> -->
                        <div class="form-group">
                            <label> Certificate Template:<span class="error-star"
                                    style="color:red;">*</span></label>
                            <select class="form-control" name="cetificate_template" id="cetificate_template_show" disabled>
                                <option value="">---Select Certificate Template---</option>
                                @foreach($rows1['certificate_templates'] as $row)
                                <option value="{{ $row->certificate_templates_id }}" {{ $course->cetificate_template == $row->certificate_templates_id ? 'selected' : '' }}>{{ $row->template_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Certificate Expiry:<span class="error-star"
                                        style="color:red;">*</span></label><br>
                                <input type="radio" class="btn-check certificate_expiry" name="certificate_expiry"
                                    value="1" id="certificate_expiryyes_show" autocomplete="off" {{ $course->certificate_expiry==1 ? 'checked' : '' }} disabled>
                                <label class="btn btn-outline-primary" for="certificate_expiryyes_show">Yes</label>

                                <input type="radio" class="btn-check certificate_expiry" name="certificate_expiry"
                                    value="2" id="certificate_expiryno_show" autocomplete="off" {{ $course->certificate_expiry==2 ? 'checked' : '' }} disabled>
                                <label class="btn btn-outline-primary" for="certificate_expiryno_show">No</label>
                            </div>
                        </div>
                        @if($course->course_certificate == 1)

                        <div class="col-md-6" id="expiryDateField_show">
                            <div class="form-group">
                                <label>Expiry Date:<span class="error-star" style="color:red;">*</span></label>
                                <input type='date' class="form-control default hasDatepicker"
                                    id='course_expiry_period_show' name="course_expiry_period"
                                    placeholder="dd-mm-yy" autocomplete="off" value="{{ $course->course_expiry_period ?? ''}}" disabled>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif
                    <div class="col-lg-12 text-center">
                        <a type="button" class="btn btn-danger" href="{{route('admincourse')}}">Back</a>
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
    function changeimage1(e) {
        if (e.target.id == "change_banner1") {
            document.querySelector('#course_introductionedit').style.display = "block";
            document.querySelector('#change_cancel1').style.display = "block";
            document.querySelector('#change_banner1').style.display = "none";
        } else if (e.target.id == "change_cancel1") {
            document.querySelector('#change_cancel1').style.display = "none";
            document.querySelector('#course_introductionedit').style.display = "none";
            document.querySelector('#change_banner1').style.display = "block";


        } else {
            document.querySelector('#course_introductionedit').style.display = "none";
            document.querySelector('#change_cancel1').style.display = "none";
            document.querySelector('#change_banner1').style.display = "block";

        }

    }
</script>







@endsection