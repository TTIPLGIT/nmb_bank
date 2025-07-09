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

.nav-tabs {
    background-color: #0068a7 !important;
    border-radius: 29px !important;
    padding: 1px !important;

}

.nav-item.active {
    background-image: linear-gradient(to right, #2a675a, #2a675a, #2a675a, #2a675a, #2a675a);
    border-radius: 31px !important;
    height: 100% !important;
}

.nav-link.active {
    background-image: linear-gradient(to right, #2a675a, #2a675a, #2a675a, #2a675a, #2a675a);
    border-radius: 31px !important;
    height: 100% !important;
}

:root {
    --borderWidth: 5px;
    --height: 24px;
    --width: 12px;
    --borderColor: #78b13f;
}




.nav-justified {
    display: flex !important;
    align-items: center !important;
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

/* endcss */
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

a.btn.btn-success.btn-lg.question {
    /* float: right; */
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

h4.modal-title.mcq {
    text-align: center;
    padding: 20px;
    font-size: 25px;
}

h4.modal-title.short {
    text-align: center;
    padding: 20px;
    font-size: 25px;
}

h4.modal-title.true {
    text-align: center;
    padding: 20px;
    font-size: 25px;
}

.container.edit.longquestion {
    padding: 17px;
}

form.longqustionsform {

    margin: 15px;
    margin-right: 0px;
    margin-left: 37px;
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

.no-arrow::-webkit-inner-spin-button {
    display: none;
}

.no-arrow::-webkit-outer-spin-button,
.no-arrow::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.form-control.default::-webkit-inner-spin-button,
.form-control.default::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
</style>


<style>
#counselorerroredit {
    color: red;
}

#supervisorerroredit {
    color: red;
}

.m-top {
    margin-top: 5%;
}
</style>
<style>
/* .select2-container {
        min-width: 300px !important;
    } */

.select2-container--default .select2-search--inline .select2-search__field {
    width: 300px !important;
}

.select2-results__option {
    padding-right: 20px;
    vertical-align: middle;
}
</style>


<div class="main-content main_contentspace">
    @if (session('success'))


    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
    <script>
    $('#user_id').on('select2:select', function(e) {
        alert("welcome")
        const selectedValue = e.params.data.id;


        if (selectedValue === 'all') {
            const allValues = [];

            // Get all option values except "all"
            $('#user_id option').each(function() {
                const val = $(this).val();
                if (val !== 'all') {
                    allValues.push(val);
                }
            });

            // Select all users (excluding 'all')
            $('#user_id').val(allValues).trigger('change.select2');
        }
    });

    // Optional: Clear all selections if user manually removes everything
    $('#user_id').on('select2:unselect', function(e) {
        if ($('#user_id').val() === null || $('#user_id').val().length === 0) {
            $('#user_id').val(null).trigger('change.select2');
        }
    });
    </script>
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



    <div class="row justify-content-center">

        <div class="col-lg-12 col-md-12">
            <div class="" style="">{{ Breadcrumbs::render('admincourse') }}

                <form method="POST" id="registration_form" enctype="multipart/form-data" onsubmit="return false">
                    @csrf

                    <div class="tile registration_tab" id="tile-1"
                        style="margin-top:10px !important; margin-bottom:10px !important;">


                    </div>
                    <!-- Tab panes -->



            </div>


            <div id="content">


                <section class="section">


                    <div class="section-body mt-0">

                        <!-- <div class="col-12"> -->
                        <div class="row">
                            <div class="col-md-2 ">
                                <select class="form-control default" id="result" name="result">

                                    <option selected value="classlist">Class List</option>
                                    <option value="courselist">Course List</option>

                                </select>
                            </div>
                            <div class="col-md-6"></div>

                            <div class="col-md-2 addquizmodal" id="addClassButton">
                                <a type="button" style="font-size:15px;margin-bottom: 15px;"
                                    class="btn btn-success btn-lg" title="Create" id="gcb" href="" data-toggle="modal"
                                    data-target="#addModal1">Add Class <span><i class="fa fa-plus"
                                            aria-hidden="true"></i></span></a>
                            </div>

                            <div class="col-md-2" id="addCourseButton">
                                <a type="button" style="font-size:15px;margin-bottom: 15px;"
                                    class="btn btn-success btn-lg" title="Create" href="" data-toggle="modal"
                                    data-target="#addModal">Add Course <span><i class="fa fa-plus"
                                            aria-hidden="true"></i></span></a>
                            </div>
                        </div>

                    </div>
                </section>

            </div>







            <section class="section" id="classlist">


                <div class="section-body mt-0">
                    <div class="row">
                        <div class="col-12">


                            <div class="card mt-0">
                                <div class="card-body">
                                    <h3 style="margin-top:10px;text-align:center;">Class List View</h3>
                                    <div class="table-wrapper">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="align3">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Class Name</th>
                                                        <th>Class Duration</th>
                                                        <th>Class Resource</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach($rows['elearning_classes'] as $data)

                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$data->class_name}}</td>
                                                        <td>{{$data->class_duration}} Mins</td>

                                                        <?php    if ($data->class_format == 'mp4') { ?>
                                                        <td> <img src="uploads/class/126/mp4.png" width="50px"
                                                                height="50px" alt="..."></td>
                                                        <?php    } elseif ($data->class_format == 'mp3') { ?>
                                                        <td> <img src="uploads/class/126/mp3.png" width="50px"
                                                                height="50px" alt="Image" /></td>
                                                        <?php    } elseif ($data->class_format == 'pdf') { ?>
                                                        <td> <img src="uploads/class/126/pdf.png" width="50px"
                                                                height="50px" alt="Image" /></td>
                                                        <?php    } elseif ($data->class_format == 'jpg' or 'png') { ?>
                                                        <td> <img src="uploads/class/126/empty.jpg" width="50px"
                                                                height="50px" alt="Image" /></td>

                                                        <?php    } else { ?>
                                                        <td> <img src="uploads/class/126/{{$data->resource_name}}"
                                                                width="50px" height="50px" alt="Image" /></td>
                                                        <?php    } ?>
                                                        <td>
                                                            <a class="btn btn-link" title="Edit" id="gcb"
                                                                data-toggle="modal" data-target="#addModal4"
                                                                onclick="fetch_update({{$data->class_id}},'edit')">
                                                                <i class="fas fa-pencil-alt"
                                                                    style="color: blue !important"></i></a>
                                                            <a class="btn btn-link"
                                                                onclick="fetch_update({{$data->class_id}},'class_show')"
                                                                title="Show" id="gcb" href="" data-toggle="modal"
                                                                data-target="#addModalquiz1"><i class="fas fa-eye"
                                                                    style="color:green"></i></a>


                                                            <a type="button" title="Delete"
                                                                onclick="class_delete(<?php    echo $data->class_id ?>)"
                                                                class="btn btn-link"><i class="far fa-trash-alt"
                                                                    style="color:red"></i></a>

                                                        </td>

                                                    </tr>
                                                    @endforeach


                                                    <input type="hidden" class="cfn" id="fn" value="0">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>





                    </div>
                </div>
            </section>

            <section class="section" id="courselist" style="display:none">


                <div class="section-body mt-0">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="card">
                                <div class="card-body">
                                    <h2 style="margin-top:10px;text-align:center;">Course List View</h2>
                                    <div class="table-wrapper">
                                        <div class="table-responsive">
                                            <table class="table  table-bordered table-striped" id="align1">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Course Name</th>
                                                        <th>Course Banner</th>
                                                        <th>Start Date</th>
                                                        <th>End Date</th>
                                                        <th>Price</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>


                                                <tbody>

                                                    @foreach(($rows1['elearning_courses']) as $data)





                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$data->course_name}}</td>

                                                        <!-- @if($data->course_category =="27")
                                                                        <td>Graduate Trainee</td>
                                                                        @elseif($data->course_category =="34")
                                                                        <td>Professional Member</td>

                                                                        @else
                                                                        <td>All</td>

                                                                        @endif -->

                                                        <?php    if (!empty($data->course_banner)) { ?>


                                                        <td><img src="uploads/course/126/{{$data->course_banner}}"
                                                                width="50px" height="50px" alt="Image" /></td>
                                                        <?php    } else { ?>
                                                        <td> <img src="uploads/class/126/empty.jpg" width="50px"
                                                                height="50px" alt="..."></td>
                                                        <?php    } ?>
                                                        <td>{{$data->course_start_period}}</td>
                                                        <td>{{$data->course_end_period}}</td>
                                                        @if(!empty($data->course_price))

                                                        <td>Rs. {{$data->course_price}}</td>
                                                        <td>Rs. {{$data->course_price}}</td>

                                                        @else
                                                        <td>Rs. 0</td>

                                                        @endif
                                                        <td>
                                                            @php
                                                            $showHandleButton = false;
                                                            $showReplacedMessage = false;
                                                            $replacementMessage = '';

                                                            $expiryDate = !empty($data->course_expiry_period) ?
                                                            \Carbon\Carbon::parse($data->course_expiry_period) : null;
                                                            $twoMonthsBefore = $expiryDate ?
                                                            $expiryDate->copy()->subMonths(2) : null;
                                                            $today = \Carbon\Carbon::today();


                                                            $courseIsReplaced =
                                                            collect(($rows1['elearning_courses']))->contains(function
                                                            ($c) use
                                                            ($data) {
                                                            return $c->expired_course_id == $data->course_id;
                                                            });

                                                            if ($data->certificate_expiry == 1) {
                                                            if ($courseIsReplaced) {
                                                            $showReplacedMessage = true;
                                                            $replacementMessage = 'This course has been replaced with a
                                                            new or copied course.';
                                                            } elseif (is_null($data->expired_course_id) && $expiryDate
                                                            && $today->gte($twoMonthsBefore)) {
                                                            $showHandleButton = true;
                                                            }
                                                            }
                                                            @endphp





                                                            <!-- <a class="" title="Edit" id="gcb" href="" data-toggle="modal" data-target="#addModal3" onclick="fetch_courseupdate_new({{$data->course_id}},'edit')"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a> -->
                                                            <a class="btn btn-link" title="show" data-toggle="modal"
                                                                data-target="#addModal5"
                                                                onclick="fetch_courseupdate_new({{$data->course_id}},'show')"><i
                                                                    class="fas fa-eye" style="color:green"></i></a>

                                                            <a type="button" title="Delete"
                                                                onclick="course_delete(<?php    echo $data->course_id ?>)"
                                                                class="btn btn-link"><i class="far fa-trash-alt"
                                                                    style="color:red"></i></a>
                                                            @if($showHandleButton)
                                                            <a class="btn btn-link" title="Handle Expired Course"
                                                                onclick="handleExpiredCourse({{ $data->course_id }})">
                                                                <i class="fas fa-exclamation-circle"
                                                                    style="color:orange"></i>
                                                            </a>
                                                            @elseif($showReplacedMessage)
                                                            <a class="btn btn-link" title="Course Replaced"
                                                                onclick="showReplacementMessage({{ $data->course_id }})">
                                                                <i class="fas fa-info-circle" style="color:gray"></i>
                                                            </a>
                                                            @endif



                                                        </td>

                                                    </tr>
                                                    @endforeach


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>





                    </div>
                </div>
            </section>







            </form>
        </div>

    </div>

</div>
</div>
<div class="modal fade" id="addModalquiz1">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="" id="show_class" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="modal-header mh">
                    <h4 class="modal-title">Show Class</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" style="background-color: #f8fffb !important;">
                    <input type="hidden" class="form-control" id="class_idshow" name="class_id">

                    <div class="row">


                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Class Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="class_nameshow"
                                    name="class_nameshow">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Class Description:<span class="error-star" style="color:red;">*</span></label>
                                <textarea class="form-control default" id="class_descriptionshow"
                                    name="class_descriptionshow"></textarea>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Class Resource:<span class="error-star" style="color:red;">*</span></label>
                                <iframe id="resource_nameshow" class="img-fluidshow" alt="Banner Image" title=""
                                    width="300" height="150" style="width:100% !important;"></iframe>


                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Class Duration:<span class="error-star" style="color:red;">*</span></label>
                                <input type="number" min="1" max="200" class="form-control default"
                                    id="class_durationshow" name="class_durationshow">
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Class Quiz:<span class="error-star" style="color:red;">*</span></label>
                                <input type="test" min="1" max="200" class="form-control default" id="class_quizshow"
                                    name="class_quizshow">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Quiz Name:<span class="error-star" style="color:red;">*</span></label>
                                <select class="form-control" name="quiz_id" id="quiz_idshow">
                                    <option value="">Select Quiz Name</option>
                                    @foreach($rows1['quiz_dropdown'] as $key => $row)

                                    <option value="{{ $row->quiz_id }}">{{ $row->quiz_name }}</option>
                                    @endforeach
                                </select>





                            </div>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </div>

            </form>
        </div>




    </div>

</div>



<script>
function class_delete(class_id) {
    //alert(class_id);

    Swal.fire({
        title: "Are you you want to delete the Class?",
        icon: "warning",

        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Delete",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('class_delete') }}",
                type: 'POST',
                data: {
                    class_id: class_id,

                    _token: '{{csrf_token()}}'
                },
                error: function() {
                    alert('Something is wrong');
                },
                success: function(data) {

                    if (data['data'] == 0) {
                        Swal.fire("Info!", data['message_cus'], "info", data['message_cus'])
                        return false
                    }

                    if (result.value) {
                        Swal.fire("Success!", "Class Deleted Successfully!", "success").then((
                            result) => {

                            location.replace(`/admincourse`);

                        })
                    }

                    // if (result.value) {
                    //     Swal.fire("Success!", "Class Deleted Successfully!", "success").then((result) => {

                    //         location.replace(`/admincourse`);

                    //     })
                    // }

                }

            });
        }
    })


}

function class_edit(class_id) {
    // alert(class_id);
    $.ajax({
        url: "{{ route('class_edit') }}",
        type: 'GET',
        data: {
            class_id: class_id,

            _token: '{{csrf_token()}}'
        },

        success: function(data) {

            //alert(data);
            console.log(data);
        }
    });

}


function course_delete(course_id) {
    //  alert(id);
    Swal.fire({
        title: "Are you sure want to delete the Course?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Delete",
    }).then((result) => {

        $.ajax({
            url: "{{ route('course_delete') }}",
            type: 'POST',
            data: {
                course_id: course_id,

                _token: '{{csrf_token()}}'
            },
            error: function() {
                alert('Something is wrong');
            },
            success: function(data) {
                if (data['data'] == 0) {
                    Swal.fire("Info!", data['message_cus'], "info", data['message_cus'])
                    return false
                }

                if (result.value) {
                    Swal.fire("Success!", "Course Deleted Successfully!", "success").then((
                        result) => {

                        location.replace(`/admincourse`);

                    })
                }
                // } else if (result.dismiss === Swal.DismissReason.cancel) {
                //     // Handle the cancel button click (optional)
                //     // For example, redirecting back to the previous page:
                //     window.history.back();
                // }


                // if (result.value) {
                //     Swal.fire("Success!", "Course Deleted Successfully!", "success").then((result) => {

                //         location.replace(`/admincourse`);

                //     })
                // }

            }

        });
    })

}
</script>


<script>
function fetch_update(class_id, type) {


    $.ajax({
        url: "{{ url('/class/fetch') }}",
        type: 'GET',
        data: {
            'class_id': class_id,
            _token: '{{csrf_token()}}'

        },

        success: function(data) {
            // correct_choices = data.rows[0]['correct_choices'].split(',');

            console.log(data);

            if (type == "edit") {

                $('#class_nameedit').val(data.rows[0]['class_name']);
                $('#class_descriptionedit').val(data.rows[0]['class_description']);
                $('#resource_nameedit').text(data.rows[0]['resource_name']);
                $('#class_durationedit').val(data.rows[0]['class_duration']);
                $('#class_quizedit').val(data.rows[0]['class_quiz']);
                if (data.rows[0]['class_quiz'] == 'yes') {
                    $('#yesedit').show();
                    $('#quiz_idedit').val(data.rows[0]['quiz_id']);
                } else {
                    $('#yesedit').hide();
                }

                $('.img-fluid').attr('src', data.rows[0]['full_notice_path']);
                $('.img-fluid').attr('title', data.rows[0]['resource_name']);
                $('#eid').val(data.rows[0]['class_id']);


            } else if (type == "class_show") {
                $('#class_nameshow').val(data.rows[0]['class_name']);
                $('#class_descriptionshow').val(data.rows[0]['class_description']);
                $('.img-fluidshow').attr('src', data.rows[0]['full_notice_path']);
                $('.img-fluidshow').attr('title', data.rows[0]['resource_name']);
                $('#class_durationshow').val(data.rows[0]['class_duration']);
                $('#class_quizshow').val(data.rows[0]['class_quiz']);
                $('#quiz_idshow').val(data.rows[0]['quiz_id']);

                $('#class_idshow').val(data.rows[0]['class_id']);

                $('#class_nameshow').prop('disabled', true);
                $('#class_descriptionshow').prop('disabled', true);
                $('#resource_nameshow').prop('disabled', true);
                $('#class_quizshow').prop('disabled', true);
                $('#quiz_idshow').prop('disabled', true);
                $('#class_durationshow').attr('class_duration', '');
                $('#class_idshow').attr('Action', '');
            }
        }
    });

}
</script>

<script>
function end_date() {
    //alert("nsj");
    var startDate = new Date($("#course_start_period").val());
    var endDatePicker = $("#course_end_period");

    // Set the minimum date for endDatePicker
    endDatePicker.datepicker("option", "minDate", startDate);
    //alert(endDatePicker);
    var examDateElement = $("#exam_date");
    var selectedEndDate = endDatePicker.val();
    examDateElement.val(selectedEndDate);
}
</script>
<!-- Designation mapping with the role  -->



<script>
var allDesignations = @json($rows['designation']);
var allUsers = @json($rows['users']);

function filterDesignations() {
    const roleId = document.getElementById('role_id').value;
    const designationSelect = document.getElementById('designation_id');
    const userSelect = document.getElementById('user_id');

    // Clear previous options
    designationSelect.innerHTML = '<option value="">Please Select Designation</option>';
    userSelect.innerHTML = '<option value="">Please Select User</option>';

    // Filter designations based on role
    const filteredDesignations = allDesignations.filter(d => d.role_id == roleId);

    filteredDesignations.forEach(d => {
        const opt = document.createElement('option');
        opt.value = d.designation_id;
        opt.textContent = d.designation_name;
        designationSelect.appendChild(opt);
    });


}

function filterNames() {
    const roleId = document.getElementById('role_id').value;
    const designationSelect = document.getElementById('designation_id').value;
    const userSelect = document.getElementById('user_id');
    console.log(allUsers);

    userSelect.innerHTML = '<option value="all">All</option>';

    const filteredNames = allUsers.filter(d =>
        d.designation_id == designationSelect && d.array_roles == roleId
    );

    filteredNames.forEach(a => {
        const opt1 = document.createElement('option');
        opt1.value = a.id;
        opt1.textContent = a.name;
        userSelect.appendChild(opt1);
    });
}



console.log(document.getElementById('user_id'));
</script>



<!-- addquestion function -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">



            <div class="modal-header mh">
                <h4 class="modal-title">Add Course</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>


            <!-- Long question -->

            <div class="card longquestion" id="">
                <h4 class="modal-title long">Add Course:</h4>
                <form method="post" name="add_course" action="{{ route('course_store')}}" enctype="multipart/form-data"
                    id="course_form" class="reset">
                    @csrf
                    <input type="hidden" id="expired_course_id" name="expired_course_id" value="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Catagory<span class="error-star" style="color:red;">*</span></label>

                                <select class="form-control" name="course_category_id" id="course_category_id">
                                    <option value="">---Select Category---</option>

                                    @foreach($rows['course_catagory_name'] as $data)
                                    <option value="{{$data->catagory_id}}" data-badge="">{{$data->catagory_name}}
                                    </option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <label>Sub Catagory<span class="error-star" style="color:red;">*</span></label>

                            <select class="form-control" name="course_category" id="course_category" onchange="fetch_show(this.value, 'edit')">
                                <option value="">---Select Category---</option>
                                @foreach($rows['course_catagory_name'] as $data)
                                <option value="{{ $data->catagory_id }}">{{ $data->sub_catagory }}</option>
                                @endforeach
                            </select>

                        </div> -->
                    </div>

                    <div class="row">
                        <!-- Role Selection -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Role <span class="error-star" style="color:red;">*</span></label>
                                <select class="form-control" name="role_id" id="role_id"
                                    onchange="filterDesignations()">
                                    <option value="">---Select Role---</option>
                                    @foreach($roles as $values)
                                    <option value="{{ $values->role_id }}">{{ $values->role_name }}</option>
                                    @endforeach
                                </select>
                                @error('role_id') {{-- corrected from roles_id --}}
                                <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Designation Selection -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Designation <span class="error-star" style="color:red;">*</span></label>
                                <select class="form-control" name="designation_id" id="designation_id"
                                    onchange="filterNames()">
                                    <option value="">Please Select Designation</option>
                                </select>
                                @error('designation_id')
                                <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>User Name <span class="text-danger">*</span></label>
                                <select class=" user_id_course form-control js-select2" name="user_ids[]" id="user_id"
                                    multiple="multiple">
                                    <option value="all">All</option>
                                    @foreach($rows['users'] as $data)
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>





                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="course_name" name="course_name"
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>


                    <div class="row">


                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Description:<span class="error-star"
                                        style="color:red;">*</span></label><br>
                                <textarea id="course_description" name="course_description" rows="3"
                                    class="form-control"></textarea>


                            </div>

                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Course Certificate:</label><br>

                                <input type="radio" class="btn-check" name="course_certificate" value="1"
                                    id="course_certificate_yes" autocomplete="off">
                                <label class="btn btn-outline-primary" for="course_certificate_yes">Yes</label>

                                <input type="radio" class="btn-check" name="course_certificate" value="2"
                                    id="course_certificate_no" autocomplete="off">
                                <label class="btn btn-outline-primary" for="course_certificate_no">No</label>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="form-group" onclick="course_exam()">

                                <label>Course Exam:<span class="error-star" style="color:red;">*</span></label><br>
                                <input type="radio" class="btn-check course_exam" name="course_exam" value="1"
                                    id="course_examyes" autocomplete="off">
                                <label class="btn btn-outline-primary" for="course_examyes">Yes</label>

                                <input type="radio" class="btn-check course_exam" name="course_exam" value="2"
                                    id="course_examno" autocomplete="off">
                                <label class="btn btn-outline-primary" for="course_examno">No</label>


                            </div>
                        </div>


                    </div>


                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Introduction:<span class="error-star" style="color:red;">*</span></label>
                                <input type="file" class="form-control default" id="course_introduction"
                                    name="course_introduction" required>
                                <span style="color:red !important"><strong>Following files could be uploaded as
                                        mp4,mp3,png,jpg</strong></span>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Banner:<span class="error-star" style="color:red;">*</span></label>
                                <input type="file" class="form-control default" id="course_banner" name="course_banner"
                                    accept="image/*" autocomplete="off" required>
                                <span style="color:red !important"><strong>Following files could be uploaded as
                                        jpeg,png,jpg</strong></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6">


                            <div class="form-group">
                                <label> Course Type:<span class="error-star" style="color:red;">*</span></label>

                                <select class="form-control " name="course_pay" id="course_pay">
                                    <option value="">---Select Course Type---</option>
                                    <option value="paid">Paid Course</option>
                                    <option value="free">Free Course</option>
                                </select>

                            </div>
                        </div>
                        <div class="row mt-3" id="certificateFields" style="display: none;">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> Certificate Template:<span class="error-star"
                                            style="color:red;">*</span></label>
                                    <select class="form-control" name="cetificate_template" id="cetificate_template">
                                        <option value="">---Select Certificate Template---</option>
                                        @foreach($rows1['certificate_templates'] as $row)
                                        <option value="{{ $row->certificate_templates_id }}">{{ $row->template_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Certificate Expiry:<span class="error-star"
                                            style="color:red;">*</span></label><br>
                                    <input type="radio" class="btn-check certificate_expiry" name="certificate_expiry"
                                        value="1" id="certificate_expiryyes" autocomplete="off">
                                    <label class="btn btn-outline-primary" for="certificate_expiryyes">Yes</label>

                                    <input type="radio" class="btn-check certificate_expiry" name="certificate_expiry"
                                        value="2" id="certificate_expiryno" autocomplete="off">
                                    <label class="btn btn-outline-primary" for="certificate_expiryno">No</label>
                                </div>
                            </div>

                            <div class="col-md-3" id="expiryDateField" style="display: none;">
                                <div class="form-group">
                                    <label>Expiry Date:<span class="error-star" style="color:red;">*</span></label>
                                    <input type='date' class="form-control default hasDatepicker"
                                        id='course_expiry_period' name="course_expiry_period" placeholder="dd-mm-yy"
                                        autocomplete="off">
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6" id="paid" style="display:none;">
                            <div class="form-group">
                                <label>Course Price:<span class="error-star" style="color:red;">*</span></label>
                                <input type="number" class="form-control default" id="course_price"
                                    placeholder="Enter the Money(UGX)" name="course_price" autocomplete="off">
                            </div>

                        </div>
                        <div class="col-md-6" id="free" style="display:none;">
                            <div class="form-group">
                                <label>Course Price:<span class="error-star" style="color:red;">*</span></label>
                                <input type="number" readonly class="form-control " id="" name="course_price"
                                    autocomplete="off">
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group"
                            style="display:flex;justify-content: space-evenly;align-items: center;"
                            onclick="no_period()"><label>This Course has Start and End Period<span class="error-star"
                                    style="color:red;">*</span></label>
                            <div class="form-group">
                                <input type="radio" class="btn-check answer_show_on course_noperiod"
                                    name="course_noperiod" value="1" id="course_noperiodyes" autocomplete="off">
                                <label class="btn btn-outline-primary answer_show_on1"
                                    for="course_noperiodyes">Yes</label>

                                <input type="radio" class="btn-check answer_show_off course_noperiod"
                                    name="course_noperiod" value="2" id="course_noperiodno" autocomplete="off" checked>
                                <label class="btn btn-outline-primary answer_show_off1"
                                    for="course_noperiodno">No</label>

                            </div>



                        </div>


                    </div>



                    <div class="row">
                        <div class="col-md-3"><label class="course_period">Course Period:<span class="error-star"
                                    style="color:red;">*</span></label></div>

                        <div class="col-md-4">

                            <div class="form-group">
                                <label>Start Date:<span class="error-star" style="color:red;">*</span></label>
                                <input type='text' class="form-control default startdate" id='course_start_period'
                                    readonly name="course_start_period" title="Course Start Date" placeholder="dd-mm-yy"
                                    autocomplete="off">
                            </div>

                        </div>

                        <div class="col-md-4">


                            <div class="form-group">
                                <label>End Date:<span class="error-star" style="color:red;">*</span></label>
                                <input type='text' class="form-control default enddate" id='course_end_period' readonly
                                    name="course_end_period" title="Course End Date" placeholder="dd-mm-yy"
                                    onchange="autodateupdate(this)" onclick="end_date();" autocomplete="off">
                            </div>
                        </div>

                    </div>






                    <div class="col-md-12 examname" style="display:none !important;">
                        <div class="row">
                            <div class="col-md-3 form-group"><label class="course_exam">Exam Details:<span
                                        class="error-star" style="color:red;">*</span></label></div>

                            <div class="col-md-5">

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
                                    <input type='text' class="form-control default exam_date" id="exam_date"
                                        name="exam_date" title="Course Exam Date" placeholder="dd-mm-yy"
                                        autocomplete="off">
                                </div>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Pass Percentage:<span class="error-star" style="color:red;">*</span></label>
                                <div style="display:flex;align-items: baseline;">
                                    <input type="number" class="form-control default" id="pass_percentage"
                                        name="pass_percentage" autocomplete="off"><span class="col-md-6"
                                        style="color:red;"><strong>(in percentage only)</strong></span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Instructor:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="course_instructor"
                                    name="course_instructor" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Course Tags:<span class="error-star" style="color:red;">*</span></label>
                                <div class="wordquestion">

                                    <table class="_table">

                                        <tbody id="table_body">
                                            <tr>

                                                <td>
                                                    <input type="text" class="form-control default" id="course_tags"
                                                        name="course_tags[]" autocomplete="off">
                                                </td>
                                                <td>
                                                    <div class="action_container">
                                                        <button class="danger" onclick="remove_tr(this)">
                                                            <i class="fa fa-close"></i>
                                                        </button>
                                                    </div>
                                                    <div class="action_container" width="50px">
                                                        <button class="success" type="button"
                                                            onclick="create_tr('table_body')">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>

                                                </td>


                                            </tr>

                                        </tbody>


                                    </table>



                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Skill Required:<span class="error-star" style="color:red;">*</span></label>
                                <div class="wordquestion">

                                    <table class="_table">

                                        <tbody id="table_body1">
                                            <tr>

                                                <td>
                                                    <input type="text" class="form-control default"
                                                        id="course_skills_required" name="course_skills_required[]"
                                                        autocomplete="off">
                                                </td>
                                                <td>
                                                    <div class="action_container">
                                                        <button class="danger" onclick="remove_tr(this)">
                                                            <i class="fa fa-close"></i>
                                                        </button>
                                                    </div>
                                                    <div class="action_container" width="50px">
                                                        <button class="success" type="button"
                                                            onclick="create_tr1('table_body1')">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>


                                                </td>


                                            </tr>

                                        </tbody>


                                    </table>


                                </div>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Gain Skill:<span class="error-star" style="color:red;">*</span></label>
                                <div class="wordquestion">

                                    <table class="_table">

                                        <tbody id="table_body3">
                                            <tr>

                                                <td>
                                                    <input type="text" class="form-control default"
                                                        id="course_gain_skills" name="course_gain_skills[]"
                                                        autocomplete="off">
                                                </td>
                                                <td>
                                                    <div class="action_container">
                                                        <button class="danger" onclick="remove_tr(this)">
                                                            <i class="fa fa-close"></i>
                                                        </button>
                                                    </div>
                                                    <div class="action_container" width="50px">
                                                        <button class="success" type="button"
                                                            onclick="create_tr3('table_body3')">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>

                                                </td>


                                            </tr>

                                        </tbody>


                                    </table>



                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>CPD Points: <span class="error-star" style="color:red;">*</span></label>
                                <input type="number" class="form-control default" id="course_cpt_points"
                                    name="course_cpt_points" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Classes:<span class="error-star" style="color:red;">*</span></label>

                                <br>
                                <select class="js-select2" name="course_classes[]" id="course_classes"
                                    multiple="multiple" style="width:220px !important;">


                                    @foreach($rows['elearning_classes'] as $data)
                                    <option value="{{$data->class_id}}" data-badge="">{{$data->class_name}}</option>
                                    @endforeach

                                </select>

                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <a class="btn btn-success btn-space savebutton" type="submit" onclick="gencre1(1)"
                                id="savebutton">Submit </a>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" onclick="resetSelect2()"
                                value="Cancel">
                        </div>
                    </div>
                </form>
            </div>

            <!-- end -->
            <!-- Mcq -->




            <!-- end -->
        </div>
    </div>
</div>


<style>
.select2-container {
    /* min-width: 268px !important; */
}

.select2-container--default .select2-selection--multiple .select2-selection__rendered li {
    list-style: none;
    color: #000 !important;
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

.select2-selection .select2-selection--multiple:after {
    content: 'hhghgh';
}

/* select with icons badges single*/
.select-icon .select2-selection__placeholder .badge {
    display: none;
}

.select-icon .placeholder {
    /* 	display: none; */
}

.select-icon .select2-results__option:before,
.select-icon .select2-results__option[aria-selected=true]:before {
    display: none !important;
    /* content: "" !important; */
}

.select-icon .select2-search--dropdown {
    display: none;
}

.course_period {
    font-size: 18px;

    margin-top: 30px;
    font-weight: bold;

}

tr:first-child .danger {
    display: none;
}

.container {
    max-width: 900px;
    width: 100%;
    background-color: #fff;
    margin: auto;
    padding: 15px;
    box-shadow: 0 2px 20px #0001, 0 1px 6px #0001;
    border-radius: 5px;
    overflow-x: auto;
}

.action_container1 {
    float: right;
    position: relative;
    left: 60px;
    top: 40px;
    z-index: 999;
}

.action_container2 {
    float: right;
    position: relative;
    left: 60px;
    top: 40px;
    z-index: 999;
}

div#align1_length {
    position: relative;
    top: 15px;
}

div#align1_filter {
    float: right;
}

div#align0_length {
    position: relative;
    top: 35px;
}

div#align0_filter {
    float: right;
}

.action_container3 {
    float: right;
    position: relative;
    left: 60px;
    top: 40px;
    z-index: 999;
}

._table {
    width: 100%;
    border-collapse: collapse;
}

._table :is(th, td) {}

/* form field design start */
.form_control {
    border: 1px solid #0002;
    background-color: transparent;
    outline: none;
    padding: 8px 12px;
    font-family: 1.2rem;
    width: 100%;
    color: #333;
    font-family: Arial, Helvetica, sans-serif;
    transition: 0.3s ease-in-out;
}

.form_control::placeholder {
    color: inherit;
    opacity: 0.5;
}

.form_control:is(:focus, :hover) {
    box-shadow: inset 0 1px 6px #0002;
}

/* form field design end */


.success {
    background-color: #24b96f !important;
}

.warning {
    background-color: #ebba33 !important;
}

.primary {
    background-color: #259dff !important;
}

.secondery {
    background-color: #00bcd4 !important;
}

.danger {
    background-color: #ff5722 !important;
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

.action_container1>* {
    border: none;
    outline: none;
    color: #fff;
    text-decoration: none;
    display: inline-block;
    padding: 8px 14px;
    cursor: pointer;
    transition: 0.3s ease-in-out;
}

.action_container2>* {
    border: none;
    outline: none;
    color: #fff;
    text-decoration: none;
    display: inline-block;
    padding: 8px 14px;
    cursor: pointer;
    transition: 0.3s ease-in-out;
}

.action_container3>* {
    border: none;
    outline: none;
    color: #fff;
    text-decoration: none;
    display: inline-block;
    padding: 8px 14px;
    cursor: pointer;
    transition: 0.3s ease-in-out;
}

.ui-datepicker-trigger {
    position: absolute;
    right: 0px;
    top: 53%;
    left: 80%;
    transform: translateY(-50%);
    height: 25%;
}
</style>

<script>
function reinitializeSelect2(element) {
    if ($(element).data('select2')) {

        $(element).select2('destroy');
    }


    $(element).select2({
        closeOnSelect: false,
        placeholder: "Select Claas Question",
        allowClear: true,
        tags: true,
        language: {
            noResults: function() {
                return "No Question Added";
            }
        }
    });
}


$(document).ready(function() {
    // Call the reinitialization function after the select2 library is loaded
    $.getScript("https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js", function() {
        reinitializeSelect2(".js-select5");
    });
});
</script>

<script>
function reinitializeSelect2(element) {
    if ($(element).data('select2')) {

        $(element).select2('destroy');
    }


    $(element).select2({
        closeOnSelect: false,
        placeholder: "Select Claas Question",
        allowClear: true,
        tags: true,
        language: {
            noResults: function() {
                return "No Question Added";
            }
        }
    });
}


$(document).ready(function() {
    // Call the reinitialization function after the select2 library is loaded
    $.getScript("https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js", function() {
        reinitializeSelect2(".js-select6");
    });
});
</script>

<style>
/* .select2-container {
        min-width: 300px !important;
    } */

.select2-container--default .select2-selection--multiple .select2-selection__rendered li {
    list-style: none;
    color: #000 !important;
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

.select2-selection .select2-selection--multiple:after {
    content: 'hhghgh';
}

/* select with icons badges single*/
.select-icon .select2-selection__placeholder .badge {
    display: none;
}



.select-icon .select2-results__option:before,
.select-icon .select2-results__option[aria-selected=true]:before {
    display: none !important;

}

.select-icon .select2-search--dropdown {
    display: none;
}

.course_period {
    font-size: 18px;

    margin-top: 30px;
    font-weight: bold;

}
</style>

<script>
var base_url = window.location.origin;

function enddatepicker() {
    $('.exam_date').datepicker({
        dateFormat: 'dd-mm-yy',
        showButtonPanel: true,
        changeMonth: true,
        changeYear: true,
        // yearRange: '2023:2024',
        showOn: "button",
        buttonImage: `${base_url}/asset/image/calendar.png`,
        buttonImageOnly: true,
        minDate: 0,
        maxDate: '+30Y',
        inline: true
    })
}

function start_end_date() {
    $('.startdate').datepicker({
        dateFormat: 'dd-mm-yy',
        showButtonPanel: true,
        changeMonth: true,
        changeYear: true,
        // yearRange: '2023:2024',
        showOn: "button",
        buttonImage: `${base_url}/asset/image/calendar.png`,
        buttonImageOnly: true,
        minDate: 0,
        maxDate: '+30Y',
        inline: true
    })
    $('.enddate').datepicker({
        dateFormat: 'dd-mm-yy',
        showButtonPanel: true,
        changeMonth: true,
        changeYear: true,
        // yearRange: '2023:2024',
        showOn: "button",
        buttonImage: `${base_url}/asset/image/calendar.png`,
        buttonImageOnly: true,
        minDate: 0,
        maxDate: '+30Y',
        inline: true,
        onSelect: function(selectedDate) {
            // alert(selectedDate);
            var examDateInput = $("#exam_date");
            examDateInput.val(selectedDate);

            examDateInput.prop("readonly", true);
        }
    })

}
$(function() {
    //start_end_date();
});




$('.savebutton').prop('disabled', true);
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
<script>
$(".js-select2").select2({
    closeOnSelect: false,
    placeholder: "Select Class Name",
    // allowHtml: true,
    allowClear: true,
    tags: true // создает новые опции на лету
});
</script>

<script>
$(".js-select2").select2({
    closeOnSelect: false,
    placeholder: "Select Class Name",
    // allowHtml: true,
    allowClear: true,
    tags: true // создает новые опции на лету
});


$('#user_id').on('select2:select', function(e) {

    const selectedValue = e.params.data.id;
    console.log(selectedValue)
    console.log(selectedValue === 'all')
    console.log(selectedValue == 'all')
    if (selectedValue === 'all') {
        const allValues = [];

        // Get all option values except "all"
        $('#user_id option').each(function() {
            const val = $(this).val();
            if (val !== 'all') {
                allValues.push(val);
            }
        });

        // Select all users (excluding 'all')
        $('#user_id').val(allValues).trigger('change.select2');
    }
});

// Optional: Clear all selections if user manually removes everything
$('#user_id').on('select2:unselect', function(e) {
    if ($('#user_id').val() === null || $('#user_id').val().length === 0) {
        $('#user_id').val(null).trigger('change.select2');
    }
});
</script>

<script>
function data(e) {
    // alert(e);
    if (e.target.id == "class_quizedit") {
        if (e.target.value == "yes") {

            $('#yesedit').css('display', 'block');

        } else {
            $('#yesedit').css('display', 'none');


        }



    } else if (e.target.id == "class_quiz") {
        if (e.target.value == "yes") {

            $('#yes').css('display', 'block');
            $('#no').css('display', 'none');
        } else {
            $('#yes').css('display', 'none');
            $('#no').css('display', 'block');

        }
    }

}
</script>
<script>
function create_tr(table_id) {

    if (table_id == "table_body") {


        var course_tags = $("#course_tags").val();
        if (course_tags == '') {
            swal.fire("Please Enter the Course Tags", "", "error");
            return false;
        } else {

            // let table_body = document.getElementById(table_id),
            //     first_tr = table_body.firstElementChild
            // tr_clone = first_tr.cloneNode(true);

            // table_body.append(tr_clone);

            // clean_first_tr(table_body.firstElementChild);
            const tableBody = document.getElementById(table_id);
            const rows = tableBody.querySelectorAll('tr');
            let isValid = true;

            // Validate all input fields in the table
            rows.forEach(row => {
                const input = row.querySelector('input');
                if (input && input.value.trim() === '') {
                    isValid = false;
                }
            });

            // If any input field is empty, show an error and do not add a new row
            if (!isValid) {
                swal.fire("Please fill in all fields before adding a new row.", "", "error");
                return;
            }

            // Proceed to add a new row if validation passes
            const firstRow = tableBody.firstElementChild;
            const newRow = firstRow.cloneNode(true);

            // Remove the "Add" button from the cloned row
            const addButton = newRow.querySelector('.success');
            if (addButton) {
                addButton.remove();
            }

            // Clear the value of the input in the new row
            newRow.querySelector('input').value = '';

            // Add the "Add" button back to the original row if needed
            const originalAddButton = tableBody.querySelector('.success');
            if (originalAddButton) {
                originalAddButton.style.display = 'inline';
            }

            // Append the new row to the table body
            tableBody.appendChild(newRow);
            //clean_first_tr(table_body.firstElementChild);


        }
    }
}

function clean_first_tr(firstTr) {
    let children = firstTr.children;

    children = Array.isArray(children) ? children : Object.values(children);
    children.forEach(x => {
        if (x !== firstTr.lastElementChild) {
            x.firstElementChild.value = '';
        }
    });
}



function remove_tr(This) {
    if (This.closest('tbody').childElementCount == 1) {
        alert("You Don't have Permission to Delete This ?");
    } else {
        This.closest('tr').remove();
    }
}


$(document).ready(function() {
    const cresource = document.getElementById('cresource');

    cresource.addEventListener('change', function() {
        const file = cresource.files[0];
        const video = document.createElement('video');

        video.preload = 'metadata';
        video.onloadedmetadata = function() {
            window.URL.revokeObjectURL(video.src); // Release the object URL
            const duration = video.duration;
            $('#cduration').val((duration / 60).toFixed(2));
            console.log('Video duration:', duration, 'seconds');
            // You can perform additional operations with the duration here
        };

        video.src = URL.createObjectURL(file);
    });
    $(document).on('hidden.bs.modal', function() {
        // const form = this.querySelector('.reset');
        //alert('ef');
        // form.reset();
        const form_count = document.querySelectorAll('form.reset');
        for (let index = 0; index < form_count.length; index++) {
            $('.reset')[index].reset();
            $('#result').val("");
            // calcQuestionType("result");
        }

    })

})
</script>

<script>
function create_tr1(table_id) {

    if (table_id == "table_body1") {

        var course_skills_required = $("#course_skills_required").val();
        if (course_skills_required == '') {
            swal.fire("Please Enter the Course Skills Required", "", "error");
            return false;
        } else {

            // let table_body1 = document.getElementById(table_id),
            //     first_tr = table_body1.firstElementChild
            // tr_clone = first_tr.cloneNode(true);

            // table_body1.append(tr_clone);

            // clean_first_tr(table_body1.firstElementChild);
            const tableBody = document.getElementById(table_id);
            const rows = tableBody.querySelectorAll('tr');
            let isValid = true;

            // Validate all input fields in the table
            rows.forEach(row => {
                const input = row.querySelector('input');
                if (input && input.value.trim() === '') {
                    isValid = false;
                }
            });

            // If any input field is empty, show an error and do not add a new row
            if (!isValid) {
                swal.fire("Please fill in all fields before adding a new row.", "", "error");
                return;
            }

            // Proceed to add a new row if validation passes
            const firstRow = tableBody.firstElementChild;
            const newRow = firstRow.cloneNode(true);

            // Remove the "Add" button from the cloned row
            const addButton = newRow.querySelector('.success');
            if (addButton) {
                addButton.remove();
            }

            // Clear the value of the input in the new row
            newRow.querySelector('input').value = '';

            // Add the "Add" button back to the original row if needed
            const originalAddButton = tableBody.querySelector('.success');
            if (originalAddButton) {
                originalAddButton.style.display = 'inline';
            }

            // Append the new row to the table body
            tableBody.appendChild(newRow);
        }
    }
}

function clean_first_tr(firstTr) {
    let children = firstTr.children;

    children = Array.isArray(children) ? children : Object.values(children);
    children.forEach(x => {
        if (x !== firstTr.lastElementChild) {
            x.firstElementChild.value = '';
        }
    });
}



function remove_tr(This) {
    if (This.closest('tbody').childElementCount == 1) {
        alert("You Don't have Permission to Delete This ?");
    } else {
        This.closest('tr').remove();
    }
}
</script>


<script>
function create_tr3(table_id) {

    if (table_id == "table_body3") {

        var course_gain_skills = $("#course_gain_skills").val();
        if (course_gain_skills == '') {
            swal.fire("Please Enter the Course Gain Skills", "", "error");
            return false;
        } else {


            // let table_body3 = document.getElementById(table_id),
            //     first_tr = table_body3.firstElementChild
            // tr_clone = first_tr.cloneNode(true);

            // table_body3.append(tr_clone);

            // clean_first_tr(table_body3.firstElementChild);
            const tableBody = document.getElementById(table_id);
            const rows = tableBody.querySelectorAll('tr');
            let isValid = true;

            // Validate all input fields in the table
            rows.forEach(row => {
                const input = row.querySelector('input');
                if (input && input.value.trim() === '') {
                    isValid = false;
                }
            });

            // If any input field is empty, show an error and do not add a new row
            if (!isValid) {
                swal.fire("Please fill in all fields before adding a new row.", "", "error");
                return;
            }

            // Proceed to add a new row if validation passes
            const firstRow = tableBody.firstElementChild;
            const newRow = firstRow.cloneNode(true);

            // Remove the "Add" button from the cloned row
            const addButton = newRow.querySelector('.success');
            if (addButton) {
                addButton.remove();
            }

            // Clear the value of the input in the new row
            newRow.querySelector('input').value = '';

            // Add the "Add" button back to the original row if needed
            const originalAddButton = tableBody.querySelector('.success');
            if (originalAddButton) {
                originalAddButton.style.display = 'inline';
            }

            // Append the new row to the table body
            tableBody.appendChild(newRow);
        }
    }
}

function clean_first_tr(firstTr) {
    let children = firstTr.children;

    children = Array.isArray(children) ? children : Object.values(children);
    children.forEach(x => {
        if (x !== firstTr.lastElementChild) {
            x.firstElementChild.value = '';
        }
    });
}



function remove_tr(This) {
    if (This.closest('tbody').childElementCount == 1) {
        alert("You Don't have Permission to Delete This ?");
    } else {
        This.closest('tr').remove();
    }
}
</script>


<script>
function create_tr2(table_id) {
    let table_body2 = document.getElementById(table_id),
        first_tr = table_body2.firstElementChild
    tr_clone = first_tr.cloneNode(true);

    table_body2.append(tr_clone);

    clean_first_tr(table_body2.firstElementChild);
}

function clean_first_tr(firstTr) {
    let children = firstTr.children;

    children = Array.isArray(children) ? children : Object.values(children);
    children.forEach(x => {
        if (x !== firstTr.lastElementChild) {
            x.firstElementChild.value = '';
        }
    });
}



function remove_tr(This) {
    if (This.closest('tbody').childElementCount == 1) {
        alert("You Don't have Permission to Delete This ?");
    } else {
        This.closest('tr').remove();
    }
}
</script>

<script>
function fetch_courseupdate_new(course_id, type) {


    $.ajax({
        url: "{{ url('/elearning/course/fetch') }}",
        type: 'GET',
        data: {
            'course_id': course_id,
            'type': type,
            _token: '{{csrf_token()}}'

        },

        success: function(data) {
            // correct_choices = data.rows[0]['correct_choices'].split(',');

            console.log(data);

            if (type == "edit") {

                $('#course_categoryedit').val(data.rows[0]['course_category']);
                $('#course_nameedit').val(data.rows[0]['course_name']);

                $('#course_descriptionedit').val(data.rows[0]['course_description']);

                //$('#course_certificateedit').val(data.rows[0]['course_certificate']);

                if (data.rows[0]['course_certificate'] == "1") {
                    $('.answer_edit_on').prop('checked', true)

                } else {
                    $('.answer_edit_off').prop('checked', true)

                }


                $('#course_certificateedit').val(data.rows[0]['course_certificate']);
                // $('#course_introductionedit').val(data.rows[0]['course_introduction']);

                $('.img-fluid1').attr('src', data.rows[0]['introduction_path1']);
                $('.img-fluid1').attr('title', data.rows[0]['course_introduction']);

                // $('#course_banneredit').val(data.rows[0]['course_banner']);
                $('.img-fluid2').attr('src', data.rows[0]['banner_path1']);
                $('.img-fluid2').attr('title', data.rows[0]['course_banner']);

                $('#course_payedit').val(data.rows[0]['course_pay']);
                var course_payedit = document.querySelector('#course_payedit').value;
                if (course_payedit == "paid") {
                    $('#paid1').css('display', 'block');
                    $('#free1').css('display', 'none');
                    $('#course_priceedit').val(data.rows[0]['course_price']);


                } else {
                    $('#paid1').css('display', 'none');
                    $('#free1').css('display', 'block');
                    $('#course_price').val(data.rows[0]['course_price']);
                }
                $('#course_start_periodedit').val(data.rows[0]['course_start_period']);
                $('#course_end_periodedit').val(data.rows[0]['course_end_period']);
                $('#course_instructoredit').val(data.rows[0]['course_instructor']);

                //$('#course_tags').val(data.rows[0]['course_tags']);
                const keyarray = data.rows[0]['course_tags'].split(',');
                console.log(keyarray, "actual_data");
                for (const keyobject of keyarray) {
                    let table_body2 = document.getElementById('table_bodyedit');
                    first_tr = table_body2.firstElementChild
                    tr_clone = first_tr.cloneNode(true);
                    tr_clone.firstElementChild.firstElementChild.value = keyobject;
                    tr_clone.querySelector('input').setAttribute("readonly", "");
                    table_body2.append(tr_clone);

                    clean_first_tr(table_body2.firstElementChild);
                }
                const keyarray1 = data.rows[0]['course_skills_required'].split(',');
                console.log(keyarray1, "actual_data");
                for (const keyobject of keyarray1) {
                    let table_body2 = document.getElementById('table_body1edit');
                    first_tr = table_body2.firstElementChild
                    tr_clone = first_tr.cloneNode(true);
                    tr_clone.firstElementChild.firstElementChild.value = keyobject;
                    tr_clone.querySelector('input').setAttribute("readonly", "");
                    table_body2.append(tr_clone);

                    clean_first_tr(table_body2.firstElementChild);
                }

                const keyarray2 = data.rows[0]['course_gain_skills'].split(',');
                console.log(keyarray2, "actual_data");
                for (const keyobject of keyarray2) {
                    let table_body2 = document.getElementById('table_body2edit');
                    first_tr = table_body2.firstElementChild
                    tr_clone = first_tr.cloneNode(true);
                    tr_clone.firstElementChild.firstElementChild.value = keyobject;
                    tr_clone.querySelector('input').setAttribute("readonly", "");
                    table_body2.append(tr_clone);

                    clean_first_tr(table_body2.firstElementChild);
                }
                $('#course_cpt_pointsedit').val(data.rows[0]['course_cpt_points']);
                // course_classesedit

                $('.course_classesedit').val(data.rows[0]['course_classes'].split(', '));
                reinitializeSelect2(".js-select6");
                $('#course_edit').val(data.rows[0]['course_id']);


            } else if (type == "show") {
                $('#course_categoryshow').val(data.rows[0]['course_category']);
                $('#course_nameshow').val(data.rows[0]['course_name']);

                $('#course_descriptionshow').val(data.rows[0]['course_description']);

                //$('#course_certificateedit').val(data.rows[0]['course_certificate']);

                if (data.rows[0]['course_certificate'] == "1") {
                    $('.answer_show_on').prop('checked', true)

                    $('.answer_show_on1').css('background-color', 'blue');
                } else {
                    $('.answer_show_off').prop('checked', true)
                    $('.answer_show_off1').css('background-color', 'red');
                }
                // Show/hide certificate section
                console.log(data.rows[0]['certificate_expiry']);
                if (data.rows[0]['course_certificate'] == "1") {

                    $('#certificateFields_edit').show();

                    // Handle certificate_expiry
                    if (data.rows[0]['certificate_expiry'] == "1") {
                        $('#certificate_expiryyes_show').prop('checked', true);
                        $('#expiryDateField_show').show();
                        $('#course_expiry_period_show').val(data.rows[0][
                            'course_expiry_period'
                        ]); // set expiry date
                    } else {
                        $('#certificate_expiryno_show').prop('checked', true);
                        $('#expiryDateField_show').hide();
                    }

                    // Set selected certificate template
                    $('#cetificate_template_show').val(data.rows[0]['cetificate_template']);
                } else {
                    $('#certificateFields_edit').hide();
                    $('#expiryDateField_show').hide();
                    $('#certificate_expiryyes_show').prop('checked', false);
                    $('#certificate_expiryno_show').prop('checked', false);
                    $('#cetificate_template_show').val('');
                }
                $('#course_certificateshow').val(data.rows[0]['course_certificate']);

                if (data.rows[0]['course_exam'] == "1") {
                    $('.exam_show_on').prop('checked', true)

                    $('.exam_show_on1').css('background-color', 'blue');

                    $('.examnameshow').css('display', 'block');


                } else {
                    $('.exam_show_off').prop('checked', true)
                    $('.exam_show_off1').css('background-color', 'red');
                    $('.examnameshow').css('display', 'none');
                }
                $('#course_examshow').val(data.rows[0]['course_exam']);

                $('.img-fluid1').attr('src', data.rows[0]['introduction_path1']);
                $('.img-fluid1').attr('title', data.rows[0]['course_introduction']);


                $('.img-fluid2').attr('src', data.rows[0]['banner_path1']);
                $('.img-fluid2').attr('title', data.rows[0]['course_banner']);

                $('#course_payshow').val(data.rows[0]['course_pay']);
                var course_payshow = document.querySelector('#course_payshow').value;
                if (course_payshow == "paid") {
                    $('#paid2').css('display', 'block');
                    $('#free2').css('display', 'none');
                    $('#course_priceshow').val(data.rows[0]['course_price']);


                } else {
                    $('#paid1').css('display', 'none');
                    $('#free1').css('display', 'block');
                    $('#course_price').val(data.rows[0]['course_price']);
                }
                $('#course_noperiodshow').val(data.rows[0]['course_noperiod']);
                $('#course_start_periodshow').val(data.rows[0]['course_start_period']);
                $('#course_end_periodshow').val(data.rows[0]['course_end_period']);
                $('#course_instructorshow').val(data.rows[0]['course_instructor']);

                //$('#course_tags').val(data.rows[0]['course_tags']);
                let choices = data.rows[0]['course_tags'];
                const pieces = choices.split(',');
                const result = pieces.join(', \n ');
                $('#course_tagsshow').html(result);

                let choices1 = data.rows[0]['course_skills_required'];
                const pieces1 = choices.split(',');
                const result1 = pieces.join(', \n ');
                $('#course_skills_requiredshow').html(result);


                let choices2 = data.rows[0]['course_gain_skills'];
                const pieces2 = choices.split(',');
                const result2 = pieces.join(', \n ');
                $('#course_gain_skillsshow').html(result);

                $('#course_cpt_pointsshow').val(data.rows[0]['course_cpt_points']);
                // course_classesedit
                $('.course_classesshow').val(data.rows[0]['course_classes'].split(', '));
                $('#exam_nameshow').val(data.rows[0]['exam_id']);
                $('#exam_dateshow').val(data.rows[0]['exam_date']);
                $('#pass_percentageshow').val(data.rows[0]['pass_percentage']);

                $('#course_categoryshow').prop('disabled', true);
                $('#course_nameshow').prop('disabled', true);
                $('#course_descriptionshow').prop('disabled', true);
                $('.course_certificateshow').prop('disabled', true);
                $('.course_examshow').prop('disabled', true);
                $('#course_payshow').prop('disabled', true);
                $('#course_priceshow').prop('disabled', true);
                $('#exam_nameshow').prop('disabled', true);
                $('#cetificate_template_show').prop('disabled', true);
                $('#certificate_expiryyes_show').prop('disabled', true);
                $('#certificate_expiryno_show').prop('disabled', true);
                $('#course_expiry_period_show').prop('disabled', true);
                $('#exam_dateshow').prop('disabled', true);
                $('#pass_percentageshow').prop('disabled', true);

                $('#course_start_periodshow').prop('disabled', true);
                $('#course_end_periodshow').prop('disabled', true);
                $('#course_instructorshow').prop('disabled', true);
                $('#course_tagsshow').prop('disabled', true);
                $('#course_skills_requiredshow').prop('disabled', true);

                $('#course_gain_skillsshow').prop('disabled', true);
                $('#course_cpt_pointsshow').prop('disabled', true);
                $('#course_classesshow').prop('disabled', true);
                $('.course_noperiodshow').prop('disabled', true);
                $('#course_show').attr('action', '');
                reinitializeSelect2(".js-select5");

            }
        }
    });

}
$('#result').on('change', function() {
    //fetch_courseupdate_new();
    $('#courselist').css('display', 'none');
    $('#classlist').css('display', 'none');


    if ($(this).val() === 'courselist') {
        $('#courselist').css('display', 'block');
    }
    if ($(this).val() === 'classlist') {
        $('#classlist').css('display', 'block');
    }

});
</script>

<script>
$('#course_pay').on('change', function() {
    $('#paid').css('display', 'none');
    $('#free').css('display', 'none');


    if ($(this).val() === 'paid') {
        $('#paid').css('display', 'block');
    }
    if ($(this).val() === 'free') {
        $('#free').css('display', 'block');
    }

});
</script>

<script>
$('#course_payedit').on('change', function() {
    $('#paid1').css('display', 'none');
    $('#free1').css('display', 'none');


    if ($(this).val() === 'paid') {
        $('#paid1').css('display', 'block');

    }
    if ($(this).val() === 'free') {
        $('#free1').css('display', 'block');
    }

});

$('#course_payshow').on('change', function() {
    $('#paid2').css('display', 'none');
    $('#free2').css('display', 'none');


    if ($(this).val() === 'paid') {
        $('#paid2').css('display', 'block');
    }
    if ($(this).val() === 'free') {
        $('#free2').css('display', 'block');
    }

});
$(document).ready(function() {
    // Handle the visibility of the paid/free sections and input values
    $('#course_pay').on('change', function() {
        $('#paid').css('display', 'none');
        $('#free').css('display', 'none');

        const selectedValue = $(this).val();

        if (selectedValue === 'paid') {
            $('#paid').css('display', 'block');
            $('#free').css('display', 'none');
            $('#course_price').val(''); // Clear the course_price input

        } else if (selectedValue === 'free') {
            $('#free').css('display', 'block');
            $('#paid').css('display', 'none');
            $('#course_price').val('0'); // Set course_price to 0
        }
    });

});

// $('#course_pay').on('change', function() {
//     $('#paid').css('display', 'none');
//     $('#free').css('display', 'none');


//     if ($(this).val() == 'paid') {
//         $('#paid').css('display', 'block');
//         $('#free').css('display', 'none');
//         $('#course_price').val('');
//     }
//     if ($(this).val() === 'free') {
//         $('#free').css('display', 'block');
//         $('#paid').css('display', 'none');
//         document.getElementById('course_price').value = "0";
//     }

// });
</script>



<!-- Deepika -->

<!-- end create -->
<!-- addquiz function -->
<div class="modal fade" id="addModal1">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header mh">
                <h4 class="modal-title">Add Class</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form method="POST" id="class_form" action="{{ route('class_store')}}" name="add_class"
                enctype="multipart/form-data" class="reset">
                @csrf



                <div class="modal-body" style="background-color: #f8fffb !important;">


                    <div class="row">


                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Class Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="cname" name="class_name">
                                <span class="input-Message" id="cnameerror" style="color:red;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Class Description:<span class="error-star" style="color:red;">*</span></label>
                                <textarea class="form-control default" id="cdescription"
                                    name="class_description"></textarea>
                                <span class="input-Message" id="cnameerror" style="color:red;">
                            </div>
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Class Resource:<span class="error-star" style="color:red;">*</span></label>
                                <input type="file" class="form-control default" id="cresource" required
                                    name="resource_name" accept=".pdf,.mp3,.mp4">
                                <span class="input-Message" id="resourceerror" style="color:red;"></span>
                                <span style="color:red !important"><strong>Following files could be uploaded as
                                        pdf,mp3,mp4</strong></span>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Class Duration:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" readonly class="form-control default" id="cduration" min="1"
                                    max="200" value="0.00" name="class_duration">
                                <span class="input-Message" id="durationerror" style="color:red;">
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Class Quiz:<span class="error-star" style="color:red;">*</span></label>

                                <select class="form-control" name="class_quiz" id="class_quiz" onchange="data(event);">
                                    <option value="">---Select Quiz Type---</option>
                                    <option value="yes">Yes </option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" id="yes" style="display:none;">
                            <div class="form-group">
                                <label>Quiz Name:<span class="error-star" style="color:red;">*</span></label>

                                <select class="form-control" name="quiz_id" id="quiz_id">
                                    <option value="">---Select Quiz Type---</option>
                                    @foreach($rows1['quiz_dropdown'] as $key => $row)
                                    <option value="{{ $row->quiz_id }}">{{ $row->quiz_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <a class="btn btn-success btn-space classsavebutton" type="submit" onclick="gencre()"
                                id="classsavebutton">Submit</a>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </div>

            </form>
        </div>




    </div>

</div>

<!-- edit quiz -->
<div class="modal fade" id="addModal4">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="POST" action="{{route('elearning.class_update', 1)}}" id="edit_form"
                enctype="multipart/form-data">

                @csrf
                <input type="hidden" name="eid" class="eid" id="eid">

                <div class="modal-header mh">
                    <h4 class="modal-title">Edit Class</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>


                <div class=" container edit  longquestion">
                    <h4 class="modal-title long">Edit Class</h4>


                    <div class="row">


                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Class Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="class_nameedit"
                                    name="class_nameedit" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="">Class Description<span class="error-star"
                                        style="color:red;">*</span></label>
                                <textarea class="form-control " id="class_descriptionedit" name="class_descriptionedit"
                                    rows="18" columns="10" required></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label>Class Resource:<span class="error-star" style="color:red;">*</span></label>
                                <div class="col-md-10"
                                    style="display: flex;justify-content: space-between;margin-bottom: 15px;">
                                    <a class="btn btn-link btn-warning" onclick="changeimage(event);"
                                        id="change_banner">Change Banner</a>
                                    <a class="btn btn-link btn-warning" onclick="changeimage(event);" id="change_cancel"
                                        style="display:none;">Cancel</a>

                                </div>
                                <input type="file" class="form-control default" id="resourse_nameedit"
                                    name="resource_nameedit" style="display:none;" autocomplete="off"
                                    accept=".pdf, .mp3,.mp4">

                                <iframe class="img-fluid" alt="Banner Image" title=""></iframe>



                            </div>
                            <span style="color:red !important"><strong>Following files could be uploaded as
                                    pdf,mp3,mp4</strong></span>

                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Class Duration:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="class_durationedit"
                                    name="class_durationedit" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Class Quiz:<span class="error-star" style="color:red;">*</span></label>

                                <select class="form-control" name="class_quizedit" id="class_quizedit"
                                    onchange="data(event);">
                                    <option value="">---Select Quiz Type---</option>
                                    <option value="yes">Yes </option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" id="yesedit">
                            <div class="form-group">
                                <label>Quiz Name:<span class="error-star" style="color:red;">*</span></label>

                                <select class="form-control" name="quiz_idedit" id="quiz_idedit">
                                    <option value="">---Select Quiz Type---</option>
                                    @foreach($rows1['quiz_dropdown'] as $key => $row)
                                    <option value="{{ $row->quiz_id }}">{{ $row->quiz_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>


                    </div>

                    <!-- <h style="color:black"><b>Address:</b></h> -->


                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <button class="btn btn-success btn-space savebutton" type="submit"
                                onclick="gencre11('edit')" id="savebutton">Update</button>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </div>
            </form>
        </div>


    </div>
</div>
<!-- end -->




<div class="modal fade" id="addModal3">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">



            <div class="modal-header mh">
                <h4 class="modal-title">Edit Course</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

            </div>




            <!-- Long question -->

            <div class="card longquestion" id="">
                <h4 class="modal-title long">Edit Course:</h4>
                <form method="POST" id="course_form_edit" action="{{url('/elearning/course/update/1')}}"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="course_edit" class="course_edit" id="course_edit">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label required">Course Category:<span class="error-star"
                                        style="color:red;">*</span></label>
                                <select class="form-control" name="course_category" id="course_categoryedit">
                                    <option value="">Select User Category</option>
                                    @foreach($rows2['course_category'] as $key => $row)

                                    <option value="{{ $row }}">{{ $key }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="course_nameedit" name="course_name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Description:<span class="error-star"
                                        style="color:red;">*</span></label><br>
                                <textarea id="course_descriptionedit" name="course_description" rows="3"
                                    class="form-control"></textarea>

                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Certificate:</label><br>
                                <input type="radio" class="btn-check answer_edit_on" name="course_certificate" value="1"
                                    id="course_certificateedit" autocomplete="off">
                                <label class="btn btn-outline-primary" for="btnradio1">Yes</label>

                                <input type="radio" class="btn-check answer_edit_off" name="course_certificate"
                                    value="2" id="course_certificateedit" autocomplete="off">
                                <label class="btn btn-outline-primary" for="btnradio2">No</label>


                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Course Introduction:<span class="error-star" style="color:red;">*</span></label>
                                <div class="col-md-10"
                                    style="display: flex;justify-content: space-between;margin-bottom: 15px;">
                                    <a class="btn btn-link btn-warning" onclick="changeimage1(event);"
                                        id="change_banner1">Change Introduction</a>
                                    <a class="btn btn-link btn-warning" onclick="changeimage1(event);"
                                        id="change_cancel1" style="display:none;">Cancel</a>
                                </div>
                                <input type="file" class="form-control default" id="course_introductionedit"
                                    name="course_introductionedit" style="display:none;" autocomplete="off">

                                <iframe id="course_introductionedit" class="img-fluid1" alt="Banner Image" width="300"
                                    height="150"></iframe>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Course Banner:<span class="error-star" style="color:red;">*</span></label>
                                <div class="col-md-10"
                                    style="display: flex;justify-content: space-between;margin-bottom: 15px;">
                                    <a class="btn btn-link btn-warning" onclick="changeimage2(event);"
                                        id="change_banner2">Change Banner</a>
                                    <a class="btn btn-link btn-warning" onclick="changeimage2(event);"
                                        id="change_cancel2" style="display:none;">Cancel</a>
                                </div>
                                <input type="file" class="form-control default" id="course_banneredit"
                                    name="course_banneredit" style="display:none;" accept="image/*" autocomplete="off">
                                <?php if (!empty($data->course_banner)) { ?>

                                <img class="img-fluid2" alt="Banner Image" title="">

                                <?php } else { ?>
                                <img class="" src="uploads/class/126/empty.jpg" alt="Banner Image" width="200px"
                                    height="200px" title="">

                                <?php } ?>





                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">


                            <div class="form-group">
                                <label> Course Type:<span class="error-star" style="color:red;">*</span></label>

                                <select class="form-control" name="course_pay" id="course_payedit">
                                    <option value="">---Select Course Type---</option>
                                    <option value="paid">Paid Course</option>
                                    <option value="free">Free Course</option>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-6" id="paid1" style="display:none;">
                            <div class="form-group">
                                <label>Course Price:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="course_priceedit"
                                    name="course_price">
                            </div>

                        </div>
                        <div class="col-md-6" id="free1" style="display:none;">
                            <div class="form-group">
                                <label>Course Price:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" readonly class="form-control default" value="0" id="course_price"
                                    name="course_price">
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3"><label class="course_period">Course Period:<span class="error-star"
                                    style="color:red;">*</span></label></div>

                        <div class="col-md-4">

                            <div class="form-group">
                                <label>Start Date:<span class="error-star" style="color:red;">*</span></label>
                                <input type='text' class="form-control default startdate" id='course_start_periodedit'
                                    disabled name="course_start_period" title="Meeting Start Date"
                                    placeholder="dd-mm-yy" onchange="autodateupdate(this)" required autocomplete="off">
                            </div>

                        </div>

                        <div class="col-md-4">


                            <div class="form-group">
                                <label>End Date:<span class="error-star" style="color:red;">*</span></label>
                                <input type='text' class="form-control default startdate" id='course_end_periodedit'
                                    disabled name="course_end_period" title="Meeting Start Date" placeholder="dd-mm-yy"
                                    onchange="autodateupdate(this)" required autocomplete="off">
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Instructor:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="course_instructoredit"
                                    name="course_instructor">
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Course Tags:<span class="error-star" style="color:red;">*</span></label>
                                <div class="wordquestion">

                                    <table class="_table">

                                        <tbody id="table_bodyedit">
                                            <tr>

                                                <td>
                                                    <input type="text" class="form-control default" id="course_tagsedit"
                                                        name="course_tags[]">
                                                </td>
                                                <td>
                                                    <div class="action_container">
                                                        <button class="danger" onclick="remove_tr(this)">
                                                            <i class="fa fa-close"></i>
                                                        </button>
                                                    </div>

                                                </td>


                                            </tr>

                                        </tbody>


                                    </table>

                                    <div class="action_container" width="50px">
                                        <button class="success" type="button" onclick="create_tr('table_bodyedit')">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <h style="color:black"><b>Address:</b></h> -->


                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Skill Required:<span class="error-star" style="color:red;">*</span></label>
                                <div class="wordquestion">

                                    <table class="_table">

                                        <tbody id="table_body1edit">
                                            <tr>

                                                <td>
                                                    <input type="text" class="form-control default"
                                                        id="course_skills_required[]" name="course_skills_required">
                                                </td>
                                                <td>
                                                    <div class="action_container">
                                                        <button class="danger" onclick="remove_tr(this)">
                                                            <i class="fa fa-close"></i>
                                                        </button>
                                                    </div>

                                                </td>


                                            </tr>

                                        </tbody>


                                    </table>

                                    <div class="action_container" width="50px">
                                        <button class="success" type="button" onclick="create_tr1('table_body1edit')">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Gain Skill:<span class="error-star" style="color:red;">*</span></label>
                                <div class="wordquestion">

                                    <table class="_table">

                                        <tbody id="table_body2edit">
                                            <tr>

                                                <td>
                                                    <input type="text" class="form-control default"
                                                        id="course_gain_skills" name="course_gain_skills">
                                                </td>
                                                <td>
                                                    <div class="action_container">
                                                        <button class="danger" onclick="remove_tr(this)">
                                                            <i class="fa fa-close"></i>
                                                        </button>
                                                    </div>

                                                </td>


                                            </tr>

                                        </tbody>


                                    </table>

                                    <div class="action_container" width="50px">
                                        <button class="success" type="button" onclick="create_tr('table_body2edit')">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>



                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>CPD Points: <span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="course_cpt_pointsedit"
                                    name="course_cpt_points">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Classes:<span class="error-star" style="color:red;">*</span></label>

                                <br>
                                <select class="js-select6 course_classesedit" name="course_classes[]"
                                    id="course_classesedit" multiple="multiple">


                                    @foreach($rows['elearning_classes'] as $data)
                                    <option value="{{$data->class_id}}" data-badge="">{{$data->class_name}}</option>
                                    @endforeach

                                </select>

                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <button class="btn btn-success btn-space" type="button" onclick="gencre1('edit');"
                                id="savebutton">Update</button>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </form>
            </div>

            <!-- end long-->
        </div>
    </div>
</div>

<!-- iyya -->

<div class="modal fade" id="addModal5">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">



            <div class="modal-header mh">
                <h4 class="modal-title">Show Course</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

            </div>




            <!-- Long question -->

            <div class="card longquestion" id="">
                <h4 class="modal-title long">Show Course:</h4>
                <form method="POST" id="course_form_show" action="{{url('/elearning/course/show/1')}}"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="course_editshow" class="course_edit" id="course_editshow">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label required">Course Category:<span class="error-star"
                                        style="color:red;">*</span></label>
                                <select class="form-control" name="course_category" id="course_categoryshow">
                                    <option value="">Select User Category</option>
                                    @foreach($rows2['course_category'] as $key => $row)

                                    <option value="{{ $row }}">{{ $key }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="course_nameshow" name="course_name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Description:<span class="error-star"
                                        style="color:red;">*</span></label><br>
                                <textarea id="course_descriptionshow" name="course_description" rows="3"
                                    class="form-control"></textarea>

                            </div>

                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Course Certificate:</label><br>
                                <input type="radio" class="btn-check answer_show_on course_certificateshow"
                                    name="course_certificate" value="1" id="course_certificateshow" autocomplete="off">
                                <label class="btn btn-outline-primary answer_show_on1" for="btnradio1">Yes</label>

                                <input type="radio" class="btn-check answer_show_off course_certificateshow"
                                    name="course_certificate" value="2" id="course_certificateshow" autocomplete="off">
                                <label class="btn btn-outline-primary answer_show_off1" for="btnradio2">No</label>


                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Course Exam:<span class="error-star" style="color:red;">*</span></label><br>
                                <input type="radio" class="btn-check exam_show_on course_examshow" name="course_exam"
                                    value="1" id="course_examshow" autocomplete="off">
                                <label class="btn btn-outline-primary exam_show_on1" for="btnradio1">Yes</label>

                                <input type="radio" class="btn-check exam_show_off course_examshow" name="course_exam"
                                    value="2" id="course_examshow" autocomplete="off">
                                <label class="btn btn-outline-primary exam_show_off1" for="btnradio2">No</label>


                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Course Introduction:<span class="error-star" style="color:red;">*</span></label>
                                <div class="col-md-10"
                                    style="display: flex;justify-content: space-between;margin-bottom: 15px;">
                                    <iframe id="course_introductionshow" class="img-fluid1" alt="Banner Image"
                                        width="300" height="150"></iframe>
                                    <input type="file" class="form-control default" id="course_introductionshow"
                                        name="course_introduction" style="display:none;" autocomplete="off">

                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Course Banner:<span class="error-star" style="color:red;">*</span></label>

                                <input type="file" class="form-control default" id="course_bannershow"
                                    name="course_banner" style="display:none;" accept="image/*" autocomplete="off">

                                <img class="img-fluid2" alt="Banner Image" title=""
                                    style="width:200px;height:300px !important;">







                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">


                            <div class="form-group">
                                <label> Course Type:<span class="error-star" style="color:red;">*</span></label>

                                <select class="form-control" name="course_pay" id="course_payshow">
                                    <option value="">---Select Course Type---</option>
                                    <option value="paid">Paid Course</option>
                                    <option value="free">Free Course</option>
                                </select>

                            </div>
                        </div>
                        <div class="row mt-3" id="certificateFields_edit" style="display: none;">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> Certificate Template:<span class="error-star"
                                            style="color:red;">*</span></label>
                                    <select class="form-control" name="cetificate_template"
                                        id="cetificate_template_show">
                                        <option value="">---Select Certificate Template---</option>
                                        @foreach($rows1['certificate_templates'] as $row)
                                        <option value="{{ $row->certificate_templates_id }}">{{ $row->template_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Certificate Expiry:<span class="error-star"
                                            style="color:red;">*</span></label><br>
                                    <input type="radio" class="btn-check certificate_expiry" name="certificate_expiry"
                                        value="1" id="certificate_expiryyes_show" autocomplete="off">
                                    <label class="btn btn-outline-primary" for="certificate_expiryyes_show">Yes</label>

                                    <input type="radio" class="btn-check certificate_expiry" name="certificate_expiry"
                                        value="2" id="certificate_expiryno_show" autocomplete="off">
                                    <label class="btn btn-outline-primary" for="certificate_expiryno_show">No</label>
                                </div>
                            </div>

                            <div class="col-md-3" id="expiryDateField_show" style="display: none;">
                                <div class="form-group">
                                    <label>Expiry Date:<span class="error-star" style="color:red;">*</span></label>
                                    <input type='date' class="form-control default hasDatepicker"
                                        id='course_expiry_period_show' name="course_expiry_period"
                                        placeholder="dd-mm-yy" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" id="paid2" style="display:none;">
                            <div class="form-group">
                                <label>Course Price:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="course_priceshow"
                                    name="course_price">
                            </div>

                        </div>
                        <div class="col-md-6" id="free2" style="display:none;">
                            <div class="form-group">
                                <label>Course Price:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" readonly class="form-control default" value="0" id="course_priceshow"
                                    name="course_price">
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 form-group"
                            style="display:flex;justify-content: space-evenly;align-items: center;"><label>This Course
                                has Start and End Period<span class="error-star" style="color:red;">*</span></label>
                            <div class="col-md-4 form-group">
                                <input type="radio" class="btn-check answer_show_on course_noperiodshow"
                                    name="course_noperiod" value="1" id="course_noperiodshow" autocomplete="off">
                                <label class="btn btn-outline-primary answer_show_on1"
                                    for="course_noperiodyes">Yes</label>

                                <input type="radio" class="btn-check answer_show_off course_noperiodshow"
                                    name="course_noperiod" value="2" id="course_noperiodshow" autocomplete="off">
                                <label class="btn btn-outline-primary answer_show_off1"
                                    for="course_noperiodno">No</label>

                            </div>



                        </div>


                    </div>


                    <div class="row">
                        <div class="col-md-3"><label class="course_period">Course Period:<span class="error-star"
                                    style="color:red;">*</span></label></div>

                        <div class="col-md-4">

                            <div class="form-group">
                                <label>Start Date:<span class="error-star" style="color:red;">*</span></label>
                                <input type='text' class="form-control default" id='course_start_periodshow' disabled
                                    name="course_start_period" title="Meeting Start Date" placeholder="dd-mm-yy"
                                    onchange="autodateupdate(this)" required autocomplete="off">
                            </div>

                        </div>

                        <div class="col-md-4">


                            <div class="form-group">
                                <label>End Date:<span class="error-star" style="color:red;">*</span></label>
                                <input type='text' class="form-control default" id='course_end_periodshow' disabled
                                    name="course_end_period" title="Meeting Start Date" placeholder="dd-mm-yy"
                                    onchange="autodateupdate(this)" required autocomplete="off">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12 examnameshow">
                        <div class="row">
                            <div class="col-md-3"><label class="course_period">Exam Details:<span class="error-star"
                                        style="color:red;">*</span></label></div>

                            <div class="col-md-5">

                                <div class="form-group">
                                    <label class="control-label required">Exam Name:<span class="error-star"
                                            style="color:red;">*</span></label>
                                    <select class="form-control" name="exam_nameshow" id="exam_nameshow">
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
                                    <input type='text' class="form-control default exam_dateshow" id='exam_dateshow'
                                        name="exam_dateshow" title="Course Exam Date" autocomplete="off">
                                </div>

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Pass Percentage:<span class="error-star" style="color:red;">*</span></label>
                                <div style="display:flex;align-items: baseline;">
                                    <input type="text" class="form-control default" id="pass_percentageshow"
                                        name="pass_percentageshow"><span class="col-md-6" style="color:red;"><strong>(in
                                            percentage only)</strong></span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Instructor:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="course_instructorshow"
                                    name="course_instructor">
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Course Tags:<span class="error-star" style="color:red;">*</span></label>
                                <div class="wordquestion">
                                    <textarea class="form-control default" id="course_tagsshow" name="course_tags"
                                        style="background-color: #e9ecef !important;"></textarea>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <h style="color:black"><b>Address:</b></h> -->


                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Skill Required:<span class="error-star" style="color:red;">*</span></label>
                                <div class="wordquestion">
                                    <textarea class="form-control default" id="course_skills_requiredshow"
                                        name="course_skills_required"
                                        style="background-color: #e9ecef !important;"></textarea>

                                </div>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Gain Skill:<span class="error-star" style="color:red;">*</span></label>
                                <div class="wordquestion">
                                    <textarea class="form-control default" id="course_gain_skillsshow"
                                        name="course_gain_skills"
                                        style="background-color: #e9ecef !important;"></textarea>

                                </div>
                            </div>
                        </div>

                    </div>



                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>CPD Points: <span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="course_cpt_pointsshow"
                                    name="course_cpt_points">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Classes:<span class="error-star" style="color:red;">*</span></label>

                                <br>
                                <select class="js-select5  course_classesshow" name="course_classes[]"
                                    id="course_classesshow" multiple="multiple" style="width:208px !important;">

                                    @foreach($rows['elearning_classes'] as $key => $data)
                                    <option value="{{$data->class_id}}" data-badge="">{{$data->class_name}}</option>
                                    @endforeach

                                </select>



                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </form>
            </div>

            <!-- end long-->
        </div>
    </div>
</div>



<script>
function handleExpiredCourse(course_id) {
    Swal.fire({
        title: 'Expired Certificate Course Detected',
        icon: 'warning',
        html: `
            <ul style="text-align: left;">
                <li>If content changes annually, <b>create a new course</b>.</li>
                <li>If the same content is reused, <b>Copy & reassign the existing course for maintaining existing data</b>.</li>
            </ul>
        `,
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Create New Course',
        denyButtonText: `Copy & Reassign Existing`,
        cancelButtonText: 'Close',
    }).then((result) => {
        if (result.isConfirmed) {
            // Trigger the "Add Course" modal
            $('#expired_course_id').val(course_id);
            $('#addModal').modal('show');
        } else if (result.isDenied) {
            // Redirect to reassign logic
            Swal.fire({
                title: "Copy Course Options",
                html: `
        <div style="text-align: left;">
            <label style="margin-bottom: 6px;">Certificate Expiry: <span style="color:red">*</span></label><br>

            <input type="radio" class="btn-check" name="certificate_expiry" value="1"
                id="certificate_expiryyes" autocomplete="off">
            <label class="btn btn-outline-primary mb-2" for="certificate_expiryyes">Yes</label>

            <input type="radio" class="btn-check" name="certificate_expiry" value="2"
                id="certificate_expiryno" autocomplete="off">
            <label class="btn btn-outline-primary mb-2" for="certificate_expiryno">No</label>

            <div id="expiry_date_container" style="display:none; margin-top:10px;">
                <label for="expiry_date">Expiry Date: <span style="color:red">*</span></label>
                <input type="date" id="expiry_date" class="swal2-input" />
            </div>
        </div>
    `,
                showCancelButton: true,
                confirmButtonText: 'Copy Course',
                cancelButtonText: 'Cancel',
                didOpen: () => {
                    const dateContainer = document.getElementById('expiry_date_container');

                    document.querySelectorAll('input[name="certificate_expiry"]').forEach((
                        radio) => {
                        radio.addEventListener('change', function() {
                            if (this.value === "1") {
                                dateContainer.style.display = 'block';
                            } else {
                                dateContainer.style.display = 'none';
                                document.getElementById('expiry_date').value = '';
                            }
                        });
                    });
                },
                preConfirm: () => {
                    const selected = document.querySelector(
                        'input[name="certificate_expiry"]:checked');
                    const expiryDate = document.getElementById('expiry_date').value;

                    if (!selected) {
                        Swal.showValidationMessage(
                            "Please select 'Yes' or 'No' for Certificate Expiry");
                        return false;
                    }

                    if (selected.value === "1" && !expiryDate) {
                        Swal.showValidationMessage(
                            "Please enter an expiry date when 'Yes' is selected");
                        return false;
                    }

                    return {
                        certificate_expiry: selected.value,
                        course_expiry_period: selected.value === "1" ? expiryDate : null
                    };
                }
            }).then((result) => {
                if (!result.isConfirmed) return;

                const formData = result.value;

                $.ajax({
                    url: "{{ route('course_copy') }}",
                    type: 'POST',
                    data: {
                        course_id: course_id,
                        certificate_expiry: formData.certificate_expiry,
                        course_expiry_period: formData.course_expiry_period,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if (data.data == 0) {
                            Swal.fire("Info", data.message_cus, "info");
                        } else {
                            Swal.fire("Success", "Course copied successfully!", "success")
                                .then(() => {
                                    location.href = `/admincourse`;
                                });
                        }
                    },
                    error: function() {
                        Swal.fire("Error", "Something went wrong", "error");
                    }
                });
            });


        }
    });
}

function showReplacementMessage(course_id) {
    Swal.fire({
        title: 'Course Already Replaced',
        icon: 'info',
        html: `
            <p>This course has already been <b>replaced</b> with a new or copied version.</p>
            <p>No further action is needed.</p>
        `,
        confirmButtonText: 'OK'
    });
}



function gencre() {

    var cname = $("#cname").val();
    if (cname == '') {
        swal.fire("Please Enter the Class Name", "", "error");
        return false;
    }
    var cdescription = $("#cdescription").val();
    if (cdescription == '') {
        swal.fire("Please Enter The Class Description", "", "error")
        return false;
    }
    var cresource = $("#cresource").val();
    if (cresource == '') {
        swal.fire("Please Enter The Resourse", "", "error");
        return false;
    }
    var class_quiz = $("#class_quiz").val();
    if (class_quiz == '') {
        swal.fire("Please Select the Class Quiz", "", "error");
        return false;

    }

    // if (class_quiz === 'yes') {
    //     var quiz_id = $("#quiz_id").val();
    //     if (quiz_id == '') {
    //         swal.fire("Please Select the Quiz Name", "", "error");
    //         return false;

    //     }


    // } 
    else {
        $('#classsavebutton').css('pointer-events', 'none');
        document.getElementById('class_form').submit();
    }

}
</script>
<link rel="stylesheet" href="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>

<script>
function resetSelect2() {
    // Get the Select2 element by its ID
    $(".js-select2").empty();

}
$('.close').on('click', function() {
    resetSelect2();
});
</script>
<script>
$(document).ready(function() {
    // Course Certificate toggle
    $('input[name="course_certificate"]').change(function() {
        if ($(this).val() == '1') {
            $('#certificateFields').slideDown();
        } else {
            $('#certificateFields').slideUp();
            $('#cetificate_template').val('');
            $('input[name="certificate_expiry"]').prop('checked', false);
            $('#course_expiry_period').val('');
            $('#expiryDateField').hide(); // Also hide date field
        }
    });

    // Certificate Expiry toggle
    $(document).on('change', 'input[name="certificate_expiry"]', function() {
        if ($(this).val() == '1') {
            $('#expiryDateField').slideDown();
        } else {
            $('#expiryDateField').slideUp();
            $('#course_expiry_period').val('');
        }
    });


});
</script>
<script>
$(document).ready(function() {
    // Course Certificate toggle
    $('input[name="course_certificate"]').change(function() {
        if ($(this).val() == '1') {
            $('#certificateFields').slideDown();
        } else {
            $('#certificateFields').slideUp();
            $('#cetificate_template').val('');
            $('input[name="certificate_expiry"]').prop('checked', false);
            $('#course_expiry_period').val('');
            $('#expiryDateField').hide(); // Also hide date field
        }
    });

    // Certificate Expiry toggle
    $(document).on('change', 'input[name="certificate_expiry"]', function() {
        if ($(this).val() == '1') {
            $('#expiryDateField').slideDown();
        } else {
            $('#expiryDateField').slideUp();
            $('#course_expiry_period').val('');
        }
    });


});
</script>

<script>
function gencre1(id) {



    if (id == "1") {
        var course_category = $("#course_category").val();

        if (course_category == '') {
            swal.fire("Please Select the Course Category", "", "error");
            return false;
        }

        var course_name = $("#course_name").val();
        if (course_name == '') {
            swal.fire("Please Enter the Course Name", "", "error");
            return false;
        }

        var course_description = $("#course_description").val();
        if (course_description == '') {
            swal.fire("Please Enter the Course Description", "", "error");
            return false;
        }


        const input_array = document.querySelectorAll('input[name="course_certificate"]');


        let AnswerSelected = false;
        for (let row of input_array) {
            if (row.checked === true) {
                AnswerSelected = true;
            }
        }
        if (AnswerSelected === false) {

            swal.fire("Please Select the Course Certificate", "", "error");
            return false;
        }


        const input_array2 = document.querySelectorAll('input[name="course_exam"]');

        let AnswerSelected2 = false;
        for (let row of input_array2) {
            if (row.checked === true) {
                AnswerSelected2 = true;
            }
        }
        if (AnswerSelected2 === false) {

            swal.fire("Please Select the Course Exam", "", "error");
            return false;
        }



        var course_introduction = $("#course_introduction").val();
        if (course_introduction == '') {
            swal.fire("Please Upload the Course Introduction", "", "error")
            return false;
        }

        var course_banner = $("#course_banner").val();
        if (course_banner == '') {
            swal.fire("Please Upload the Course Banner", "", "error")
            return false;
        }
        // var course = $("#course").val();
        // if (course == '') {
        //     swal.fire("Please Select the Course Type", "", "error")
        //     return false;
        // }

        var course_pay = $("#course_pay").val();
        if (course_pay == '') {
            swal.fire("Please Enter the Course Type", "", "error")
            return false;
        }

        var course_price = $("#course_price").val();
        if (course_pay == 'paid') {
            if (course_price == '') {
                swal.fire("Please Enter the Course Price", "", "error");
                return false;

            }
        }
        var course_noperiod = $(".course_noperiod").val();
        // if (course_noperiod == '2') {
        //     var course_start_period = $("#course_start_period").val();

        //     if (course_start_period == '') {
        //         swal.fire("Please Select the Course Start Period", "", "error")
        //         return false;
        //     }
        //     var course_end_period = $("#course_end_period").val();
        //     if (course_end_period == '') {
        //         swal.fire("Please Select the Course End Period", "", "error")
        //         return false;
        //     }
        //     var pass_percentage = $("#pass_percentage").val();
        //     if (pass_percentage == '') {
        //         swal.fire("Please Enter the Pass Percentage", "", "error")
        //         return false;
        //     }
        // }
        // if (course_noperiod == '1') {
        //     var exam_date = $("#exam_date").val();

        //     if (exam_date == '') {
        //         swal.fire("Please Select the Exam Date", "", "error")
        //         return false;
        //     }
        //     var exam_name = $("#exam_name").val();
        //     if (exam_name == '') {
        //         swal.fire("Please Select the Exam name", "", "error")
        //         return false;
        //     }
        //     var pass_percentage = $("#pass_percentage").val();
        //     if (pass_percentage == '') {
        //         swal.fire("Please Enter the Pass Percentage", "", "error")
        //         return false;
        //     }
        // }


        // const input_array1 = document.querySelectorAll('.course_exam');
        // let AnswerSelected1 = false;
        // for (let row of input_array1) {
        //     if (row.checked === true) {
        //         AnswerSelected1 = true;
        //         var exam_name = $("#exam_name").val();
        //         if (exam_name == '') {
        //             swal.fire("Please Select the Exam Name", "", "error")
        //             return false;
        //         }
        //         var exam_date = $("#exam_date").val();
        //         if (exam_date == '') {
        //             swal.fire("Please Select the Exam Date", "", "error")
        //             return false;
        //         }
        //         var pass_percentage = $("#pass_percentage").val();
        //         if (pass_percentage == '') {
        //             swal.fire("Please Enter the Pass Percentage", "", "error")
        //             return false;
        //         }

        //     }
        // }
        // if (AnswerSelected1 === false) {

        //     swal.fire("Please Select the Course Exam", "", "error");
        //     return false;
        // }
        var course_instructor = $("#course_instructor").val();
        if (course_instructor == '') {
            swal.fire("Please Enter the Course Instructor", "", "error")
            return false;
        }

        var course_tags = $("#course_tags").val();
        if (course_tags == '') {
            swal.fire("Please Enter the Course Tags", "", "error")
            return false;
        }

        var course_skills_required = $("#course_skills_required").val();
        if (course_skills_required == '') {
            swal.fire("Please Enter the Course Skills Required", "", "error")
            return false;
        }

        var course_gain_skills = $("#course_gain_skills").val();
        if (course_gain_skills == '') {
            swal.fire("Please Enter the Course Gain Skills", "", "error")
            return false;
        }
        var course_cpt_points = $("#course_cpt_points").val();
        if (course_cpt_points == '') {
            swal.fire("Please Enter the Course CPD Points", "", "error")
            return false;
        }

        var course_classes = $("#course_classes").val();
        if (course_classes == '') {
            swal.fire("Please Enter the Course Classes", "", "error")
            return false;
        } else {
            $('#savebutton').css('pointer-events', 'none');
            document.getElementById('course_form').submit();
        }
    }



    if (id == "edit") {
        var course_category = $("#course_categoryedit").val();
        if (course_category == '') {
            swal.fire("Please Select the Course Category", "", "error");
            return false;
        }

        var course_name = $("#course_nameedit").val();
        if (course_name == '') {
            swal.fire("Please Enter the Course Name", "", "error");
            return false;
        }

        var course_description = $("#course_descriptionedit").val();
        if (course_description == '') {
            swal.fire("Please Enter the Course Description", "", "error");
            return false;
        }


        const input_array = document.querySelectorAll('#course_certificateedit');
        let AnswerSelected = false;
        for (let row of input_array) {
            if (row.checked === true) {
                AnswerSelected = true;
            }
        }
        if (AnswerSelected === false) {

            swal.fire("Please Select the Course Certificate", "", "error");
            return false;
        }

        // var course_introduction = $("#course_introductionedit").val();
        // if (course_introduction == '') {
        //     swal.fire("Please Upload the Course Introduction", "", "error")
        //     return false;
        // }

        // var course_banner = $("#course_banneredit").val();
        // if (course_banner == '') {
        //     swal.fire("Please Upload the Course Banner", "", "error")
        //     return false;
        // }
        var course = $("#course_payedit").val();
        if (course == '') {
            swal.fire("Please Select the Course Type", "", "error")
            return false;
        }

        // var course = $("#course_price").val();
        // if (course == '') {
        //     swal.fire("Please Enter the Course Price", "", "error")
        //     return false;
        // }

        var course_start_period = $("#course_start_periodedit").val();
        if (course_start_period == '') {
            swal.fire("Please Select the Course Start Period", "", "error")
            return false;
        }

        var course_end_period = $("#course_end_periodedit").val();
        if (course_end_period == '') {
            swal.fire("Please Select the Course End Period", "", "error")
            return false;
        }

        var course_instructor = $("#course_instructoredit").val();
        if (course_instructor == '') {
            swal.fire("Please Enter the Course Instructor", "", "error")
            return false;
        }



        var course_tags = document.querySelectorAll('#course_tagsedit');
        var keyword_key = 0;
        for (const course_tagsedit of course_tags) {
            if (keyword_key != 0 && course_tagsedit.value == '') {
                swal.fire("Please Enter the Course Tags", "", "error");
                return false;
            }
            keyword_key++;

        }


        var course_skills_required1 = document.querySelectorAll('#course_skills_required');
        var keyword_key = 0;
        for (const course_skills_required of course_skills_required1) {
            if (keyword_key != 0 && course_skills_required.value == '') {
                swal.fire("Please Enter the Course Skills Required", "", "error");
                return false;
            }
            keyword_key++;

        }

        var course_gain_skills1 = document.querySelectorAll('#course_skills_required');
        var keyword_key = 0;
        for (const course_skills_required of course_gain_skills1) {
            if (keyword_key != 0 && course_skills_required.value == '') {
                swal.fire("Please Enter the Course Gain Skills", "", "error");
                return false;
            }
            keyword_key++;

        }

        var course_cpt_points = $("#course_cpt_pointsedit").val();
        if (course_cpt_points == '') {
            swal.fire("Please Enter the Course CPD Points", "", "error")
            return false;
        }

        var course_classes = $("#course_classesedit").val();
        if (course_classes == '') {
            swal.fire("Please Enter the Course Classes", "", "error")
            return false;
        } else {
            // $('#savebutton').css('pointer-events', 'none');
            document.getElementById('course_form_edit').submit();
        }
    }

}
</script>



<!-- end create -->
<!-- edit function -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
var $j = jQuery.noConflict();

$j(document).ready(function() {


    // Initialize Select2 plugin
    // $j('#exam_name').select2();
    // $j('#exam_name').removeAttr('multiple');

    //alert('egeg');

});
</script>




<script type="text/javascript">
var letters = /^[A-Za-z]+$/;
var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
var number = /^\(?(\d{0})\)?[- ]?(\d{0})[- ]?(\d{4})$/;
var number2 = /^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/;

function validate(e) {


    const cname = document.getElementById("cname");
    const resource = document.getElementById("resource");
    const duration = document.getElementById("duration");


    e.preventDefault();
    if (cname.value == "") {
        document.getElementById("cnameerror").innerHTML =
            "**Please Enter the Class Name**";
        return;
    } else {
        document.getElementById("cnameerror").innerText = "";
    }


    e.preventDefault();
    if (resource.value == "") {
        document.getElementById("resourceerror").innerHTML =
            "**Please Enter the Validate Resource **";
        return;
    } else {
        document.getElementById("resourceerror").innerText = "";
    }



    e.preventDefault();
    if (duration.value == "") {
        document.getElementById("durationerror").innerHTML =
            "**Please Enter the Valid Duration**";
        return;
    } else {
        document.getElementById("durationerror").innerText = "";
    }


    $("#validate").submit();


}


function changeimage(e) {
    if (e.target.id == "change_banner") {
        document.querySelector('#resourse_nameedit').style.display = "block";
        document.querySelector('#change_cancel').style.display = "block";
        document.querySelector('#change_banner').style.display = "none";
    } else if (e.target.id == "change_cancel") {
        document.querySelector('#change_cancel').style.display = "none";
        document.querySelector('#resourse_nameedit').style.display = "none";
        document.querySelector('#change_banner').style.display = "block";


    } else {
        document.querySelector('#resourse_nameedit').style.display = "none";
        document.querySelector('#change_cancel').style.display = "none";
        document.querySelector('#change_banner').style.display = "block";

    }

}



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

function changeimage2(e) {
    if (e.target.id == "change_banner2") {
        document.querySelector('#course_banneredit').style.display = "block";
        document.querySelector('#change_cancel2').style.display = "block";
        document.querySelector('#change_banner2').style.display = "none";
    } else if (e.target.id == "change_cancel2") {
        document.querySelector('#change_cancel2').style.display = "none";
        document.querySelector('#course_banneredit').style.display = "none";
        document.querySelector('#change_banner2').style.display = "block";


    } else {
        document.querySelector('#course_banneredit').style.display = "none";
        document.querySelector('#change_cancel2').style.display = "none";
        document.querySelector('#change_banner2').style.display = "block";

    }

}

function course_exam() {
    const course_exam = document.querySelector('.course_exam:checked');

    if (course_exam && course_exam.value === "1") {

        document.querySelector('.examname').style.display = "block";
        $('.exam_date').datepicker({
            dateFormat: 'dd-mm-yy',
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true,
            // yearRange: '2023:2024',
            showOn: "button",
            buttonImage: `${base_url}/asset/image/calendar.png`,
            buttonImageOnly: true,
            minDate: 0,
            maxDate: '+30Y',
            inline: true
        })
    } else {
        document.querySelector('.examname').style.display = "none";

    }
}
</script>
<script>
function updateEndDate() {
    const startDateInput = document.getElementById('course_start_period');
    const endDateInput = document.getElementById('course_end_period');

    const startDate = new Date(startDateInput.value);
    const endDate = new Date(startDate.getTime() + (10 * 24 * 60 * 60 *
        1000)); // Adding 10 days (10 * 24 * 60 * 60 * 1000 milliseconds)

    endDateInput.value = endDate.toISOString().split('T')[0]; // Setting the value of the end date input

    // Enable the end date input
    endDateInput.disabled = false;
}

function no_period() {
    const course_exam = document.querySelector('.course_noperiod:checked');
    //alert(course_exam);

    if (course_exam && course_exam.value === "1") {

        // document.querySelector('.examname').style.display = "block";
        $('.startdate').prop('disabled', false);
        $('.enddate').prop('disabled', false);
        // $('.startdate').datepicker();
        // $('.enddate').datepicker();
        start_end_date();
        $('#exam_date').prop('readonly', true);
        $('.exam_date').datepicker('destroy');
        $('.exam_date').css('background', 'grey !important');
        // Remove any associated event handlers or bindings
        $('.exam_date').off();
        $('.exam_date').removeClass('ui-datepicker-trigger');

        // Remove the gray background color
        $('.startdate').css('background', '');
        $('.enddate').css('background', '');
    } else {
        // alert("bj");
        $('.startdate').datepicker('destroy');
        $('.startdate').css('background', 'grey !important');
        // Remove any associated event handlers or bindings
        $('.startdate').off();
        $('.startdate').removeClass('ui-datepicker-trigger');

        // Disable the form control
        $('.startdate').prop('disabled', true);
        $('.startdate').val('');
        $('.enddate').val('');

        $('.enddate').datepicker('destroy');

        // Remove any associated event handlers or bindings
        $('.enddate').off();
        $('.enddate').removeClass('ui-datepicker-trigger');

        // Disable the form control
        $('.enddate').prop('disabled', true);
        $('#exam_date').prop('readonly', false);
        document.querySelector("#exam_date").addEventListener("keypress", function(evt) {
            var charCode = evt.which || evt.keyCode;
            var charStr = String.fromCharCode(charCode);

            if (/[\d\.,\/;:`]/.test(charStr)) {
                evt.preventDefault(); // Prevent entering the character
            }
        });

        enddatepicker();

    }
}
document.querySelector("[type='number']").addEventListener("keypress", function(evt) {
    if ((evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57) || (evt.which === 46)) {
        evt.preventDefault();
    }
});
</script>

<!-- saranya -->
<script>
function toggleButton() {
    var selectBox = document.getElementById("result");
    var button = document.getElementById("addClassButton");
    if (selectBox.value === "classlist") {
        button.style.display = "block";
    } else {
        button.style.display = "none";
    }
}
</script>




@endsection