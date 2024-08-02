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
        margin-left: 14px !important;
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
</style>


<style>
    #counselorerroredit {
        color: red;
    }

    #supervisorerroredit {
        color: red;
    }

    .ui-datepicker-trigger {
        position: absolute;
        right: 0px;
        top: 51%;
        left: 77%;
        transform: translateY(-50%);
        height: 34%;
    }

    .breadcrumb {
        display: inline-block !important;
        overflow: hidden !important;
        border-radius: 5px !important;
        counter-reset: flag !important;
        width: 258px;
        margin-left: 16px;
    }

    .ellipsis,
    .ellipsis p {
        overflow: hidden !important;
        white-space: nowrap !important;
        text-overflow: ellipsis !important;
        max-width: 100px !important;
        /* Adjust the value to fit your desired width */
    }
</style>






<div class="main-content main_contentspace">
    <div class="row">
        {{ Breadcrumbs::render('elearning.admineventlist') }}
        <div class=" col-md-12">

            <section class="section5">
                <div class="section-body mt-2">
                    <a type="button" style="font-size:15px;margin: 0 0px 5px 15px;" class="btn btn-success btn-lg question" title="Create" href="" data-toggle="modal" data-target="#addModal">Add Events<span><i class="fa fa-plus" aria-hidden="true"></i></span></a>
                    @if (session('success'))

                    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
                    <script type="text/javascript">
                        window.onload = function() {
                            var message = $('#session_data').val();
                            // alert(message);
                            console.log(message);
                            swal.fire({
                                title: "Success",
                                text: message,
                                icon: "success",
                                type: "success",
                            });

                        }
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
                                type: "info",
                            });

                        }
                    </script>
                    @endif



                    <div class="row">
                        <div class="col-12">
                            <!-- <h3 style="margin-top:10px;text-align:center;">Notice List</h3> -->
                            <div class="card mt-0">
                                <div class="card-body">
                                    <div class="col-lg-12 text-center">
                                        <h4>Event List View</h4>
                                    </div>


                                    <div class="table-wrapper">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="align1">
                                                <thead>
                                                    <tr>
                                                        <th>SI.No</th>
                                                        <th>Category</th>
                                                        <th>Event Name</th>
                                                        <th>Event Image</th>
                                                        <th>Event Date</th>

                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="background-color: #cfe0e8;">

                                                    @foreach($rows['rows']['quiz_list'] as $data)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        @if($data['user_category']=="27")
                                                        <td>Graduate Trainee</td>
                                                        @elseif($data['user_category']=="34")
                                                        <td>Professional Member</td>

                                                        @else
                                                        <td>All</td>

                                                        @endif
                                                        <td class="ellipsis">{{$data['event_name']}}</td>
                                                        <td><img src="uploads/notice/126/{{$data['event_image']}}" width="50px" height="50px" alt="Image" /></td>
                                                        <td>{{$data['event_date']}}</td>



                                                        <td>

                                                            <a class="" title="Edit" id="gcb" data-toggle="modal" data-target="#addModal4" onclick="fetch_update({{$data['event_id']}},'edit')"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>
                                                            <a class="btn btn-link" title="show" data-toggle="modal" data-target="#addModal5" onclick="fetch_update({{$data['event_id']}},'show')"><i class="fas fa-eye" style="color:green"></i></a>


                                                            <a type="button" title="Delete" onclick="event_delete(<?php echo $data['event_id'] ?>)" class="btn btn-link"><i class="far fa-trash-alt" style="color:red"></i></a>


                                                        </td>

                                                    </tr>
                                                    @endforeach
                                                    <input type="hidden" class="ceduid" id="eduid" value="0">

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
        </div>

    </div>
</div>

<script>
    function event_delete(event_id) {
        //alert(id);
        Swal.fire({
            title: "Are you sure, you want to delete the Event?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Delete",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('elearning.event_delete') }}",
                    type: 'POST',
                    data: {
                        event_id: event_id,

                        _token: '{{csrf_token()}}'
                    },
                    error: function() {
                        alert('Something is wrong');
                    },
                    success: function(data) {


                        if (result.value) {
                            Swal.fire("Success!", "Event Deleted Successfully!", "success").then((result) => {

                                location.replace(`/adminevent`);

                            })
                        }

                    }
                });
            }
        })
    }
    $(document).ready(function() {
        $(document).on('hidden.bs.modal', function() {

            const form_count = document.querySelectorAll('form.reset');
            for (let index = 0; index < form_count.length; index++) {
                $('.reset')[index].reset();
                $('#result').val("");
                calcQuestionType("result");
            }

        })

    })
</script>



<!-- addquestion function -->


<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="POST" id="event_form" action="{{ route('elearning.event_store')}}" name="add_event" enctype="multipart/form-data" class="reset">

                @csrf

                <div class="modal-header mh">
                    <h4 class="modal-title">Add Event</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <!-- Add Notice -->

                <div class="card longquestion" id="">
                    <h4 class="modal-title long">Add Event</h4>

                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="control-label required">Category:<span class="error-star" style="color:red;">*</span></label>
                                <select class="form-control" name="user_category" id="user_category">
                                    <option value="">Select User Category</option>

                                    @foreach($rows['rows']['user_category'] as $key=>$row)

                                    <option value="{{ $row }}">{{ $key }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="form-group">
                                <label>Event Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="event_name" name="event_name" autocomplete="off" placeholder="Please Enter the Event Name">
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Event Image:<span class="error-star" style="color:red;">*</span></label>
                                <input type="file" class="form-control default" id="event_image" name="event_image" accept="image/*" autocomplete="off">
                                <span style="color:red !important"><strong>Following files could be uploaded such as jpeg,png,jpg,gif</strong></span>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="">Description<span class="error-star" style="color:red;">*</span></label>
                                <textarea class="form-control event_description" id="event_description" name="event_description" rows="8" columns="10" autocomplete="off" required></textarea>
                            </div>
                        </div>
                    </div>


                    <!-- <h style="color:black"><b>Address:</b></h> -->
                    <div class="row">

                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Event Date:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default startdate" id="event_date" name="event_date" autocomplete="off" placeholder="Please Select the Event Date">
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <a class="btn btn-success btn-space savebutton" onclick="gencre(1)" type="submit" id="savebutton">Submit</a>
                            <input type="submit" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>

                    </div>
                </div>
            </form>
        </div>


    </div>
</div>

<div class="modal fade" id="addModal5">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="" action="" id="show_form" enctype="multipart/form-data">

                @csrf
                <input type="hidden" name="eid_show" class="eid_show" id="eid_show">

                <div class="modal-header mh">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>


                <div class=" container edit  longquestion">
                    <h4 class="modal-title long">Show Events</h4>


                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="control-label required">Category:<span class="error-star" style="color:red;">*</span></label>
                                <select class="form-control" name="user_category" id="user_categoryshow"style="background-color: #e9ecef !important;">
                                    <option value="">Select User Category</option>

                                    @foreach($rows['rows']['user_category'] as $key=>$row)

                                    <option value="{{ $row }}">{{ $key }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label>Event Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="event_nameshow" name="event_nameshow" autocomplete="off" style="background-color: #e9ecef !important;">
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Event Image:<span class="error-star" style="color:red;">*</span></label>
                            </div>
                            <iframe id="event_imageshow" class="img-fluidshow" alt="Image" title="" width="400" height="200" style="background-color: #e9ecef !important;width:100% !important;"></iframe>
                            <!-- <img id="noticebanner_show"   title=""> -->
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="">Description<span class="error-star" style="color:red;">*</span></label>
                                <textarea class="form-control " id="event_descriptionshow" name="event_descriptionshow" rows="8" columns="10" required style="background-color: #e9ecef !important;"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- <h style="color:black"><b>Address:</b></h> -->
                    <div class="row">

                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Event Date:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="event_dateshow" name="event_dateshow" autocomplete="off" style="background-color: #e9ecef !important;">
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


<style>
    .course_period {
        font-size: 18px;
        float: right;
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
        top: 10px;
    }

    div#align1_filter {
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

    .action_container {}

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
</style>

<script>
    function create_tr(table_id) {
        let table_body = document.getElementById(table_id),
            first_tr = table_body.firstElementChild
        tr_clone = first_tr.cloneNode(true);

        table_body.append(tr_clone);

        clean_first_tr(table_body.firstElementChild);
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
        $(document).on('hidden.bs.modal', function() {

            const form_count = document.querySelectorAll('form.reset');
            for (let index = 0; index < form_count.length; index++) {
                $('.reset')[index].reset();
                $('#result').val("");
                calcQuestionType("result");
            }

        })

    })
</script>

<link rel="stylesheet" href="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>


<!-- <script>
    function gencre(id) {
        // alert(id);

        if (id == "1") {
            var c_name = $("#user_category").val();

            if (c_name == '') {
                swal.fire("Please Select User Category", "", "error");
                return false;
            }
            var event_name = $("#event_name").val();
            if (event_name == '') {
                swal.fire("Please Enter the Event Name", "", "error");
                return false;
            }

            var event_image = $("#event_image").val();
            if (event_image == '') {
                swal.fire("Please Upload The Event Image", "", "error");
                return false;
            }
            var event_description = $("#notice_description").val();
            if (notice_description == '') {
                swal.fire("Please Enter the Notice Description", "", "error");
                return false;
            }

            var notice_date = $("#notice_date").val();
            if (notice_date == '') {
                swal.fire("Please Select the Noticeboard Date", "", "error")
                return false;
            }
            var notice_author = $("#notice_author").val();
            if (notice_author == '') {
                swal.fire("Please Enter the Notice Author Name", "", "error");
                return false;
            } else {
                document.getElementById('notice_form').submit();
            }
        } else if (id == "edit") {
            var c_nameedit = $("#user_categoryedit").val();

            if (c_nameedit == '') {
                swal.fire("Please Select User Category", "", "error");
                return false;
            }
            var notice_nameedit = $("#notice_nameedit").val();
            if (notice_nameedit == '') {
                swal.fire("Please Enter the Notice Name", "", "error");
                return false;
            }

            var notice_banneredit = $("#notice_banneredit").val();
            if (notice_banneredit == '') {
                swal.fire("Please Upload The Noticeboard Image", "", "error");
                return false;
            }
            var notice_descriptionedit = $("#notice_descriptionedit").val();
            if (notice_descriptionedit == '') {
                swal.fire("Please Enter the Notice Description", "", "error");
                return false;
            }

            var notice_dateedit = $("#notice_dateedit").val();
            if (notice_dateedit == '') {
                swal.fire("Please Select the Noticeboard Date", "", "error")
                return false;
            }
            var notice_authoredit = $("#notice_authoredit").val();
            if (notice_authoredit == '') {
                swal.fire("Please Enter the Notice Author Name", "", "error");
                return false;
            } else {
                document.getElementById('edit_form').submit();
            }

        }


    }
</script> -->


<script>
    function create_tr(table_id) {
        let table_body1 = document.getElementById(table_id),
            first_tr = table_body1.firstElementChild
        tr_clone = first_tr.cloneNode(true);

        table_body1.append(tr_clone);

        clean_first_tr(table_body1.firstElementChild);
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
    function create_tr(table_id) {
        let table_body3 = document.getElementById(table_id),
            first_tr = table_body3.firstElementChild
        tr_clone = first_tr.cloneNode(true);

        table_body3.append(tr_clone);

        clean_first_tr(table_body3.firstElementChild);
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
    function create_tr(table_id) {
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
    $('#result').on('change', function() {
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

<!-- Deepika -->

<!-- end create -->
<!-- addquiz function -->








<!-- end create -->
<!-- edit function -->

<!-- edit -->

<div class="modal fade" id="addModal4">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="POST" action="{{route('elearning.event_update',1)}}" id="edit_form" enctype="multipart/form-data">

                @csrf
                <input type="hidden" name="eid" class="eid" id="eid">

                <div class="modal-header mh">
                    <h4 class="modal-title">Edit Event</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>


                <div class=" container edit  longquestion">
                    <h4 class="modal-title long">Edit Event</h4>


                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="control-label required">Category:<span class="error-star" style="color:red;">*</span></label>
                                <select class="form-control" name="user_category" id="user_categoryedit">
                                    <option value="">Select User Category</option>
                                    @foreach($rows['rows']['user_category'] as $key=>$row)

                                    <option value="{{ $row }}">{{ $key }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="form-group">
                                <label>Event Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="event_nameedit" name="event_nameedit" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Event Image:<span class="error-star" style="color:red;">*</span></label>
                                <div class="col-md-10" style="display: flex;justify-content: space-between;margin-bottom: 15px;">
                                    <a class="btn btn-link btn-warning" onclick="changeimage(event);" id="change_banner">Change Image</a>
                                    <a class="btn btn-link btn-warning" onclick="changeimage(event);" id="change_cancel" style="display:none;">Cancel</a>
                                </div>
                                <span style="color:red !important"><strong>Following files could be uploaded such as jpeg,png,jpg,gif</strong></span>

                                <input type="file" class="form-control default" id="event_imageedit" name="event_imageedit" style="display:none;" accept="image/*" autocomplete="off">
                                
                                <img class="img-fluid" alt="Event Image" title="">
                            </div>
                            <span style="color:red !important"><strong>Following files could be uploaded such as jpeg,png,jpg,gif</strong></span>

                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="">Description<span class="error-star" style="color:red;">*</span></label>
                                <textarea class="form-control event_description" id="event_descriptionedit" name="event_descriptionedit" rows="8" columns="10" required></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- <h style="color:black"><b>Address:</b></h> -->
                    <div class="row">

                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Event Date:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default startdate" id="event_dateedit" name="event_dateedit" autocomplete="off">
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <button class="btn btn-success btn-space" type="button" onclick="gencre('edit')" id="savebutton">Submit</button>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </div>
            </form>
        </div>


    </div>
</div>

<!-- end -->
<script>
    $(document).ready(function() {
        // Initialize the Datepicker
        $(".startdate").datepicker({
            minDate: 0, // Restrict to present and future dates
            dateFormat: "dd-mm-yy", // Date format
        });
    });
</script>
<!-- <script>
    window.onload = function() {
        document.querySelector('.ui-datepicker-trigger').title = 'meeting date';

    }
</script> -->

<script>
    var base_url = window.location.origin;
    $(function() {
        $('.startdate').datepicker({
            dateFormat: 'dd-mm-yy',
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true,
            // yearRange: '2023:2024',
            showOn: "button",
            buttonImage: `${base_url}/images/calendar.png`,
            buttonImageOnly: true,
            minDate: 0,
            maxDate: '+30Y',
            inline: true
        })
    });
    document.querySelector(".startdate").addEventListener("keypress", function(evt) {
        var charCode = evt.which || evt.keyCode;
        var charStr = String.fromCharCode(charCode);

        if (/[\d\.,\/;:`]/.test(charStr)) {
            evt.preventDefault(); // Prevent entering the character
        }
    });

    function changeimage(e) {
        if (e.target.id == "change_banner") {
            document.querySelector('#event_imageedit').style.display = "block";
            document.querySelector('#change_cancel').style.display = "block";
            document.querySelector('#change_banner').style.display = "none";
        } else if (e.target.id == "change_cancel") {
            document.querySelector('#change_cancel').style.display = "none";
            document.querySelector('#event_imageedit').style.display = "none";
            document.querySelector('#change_banner').style.display = "block";


        } else {
            document.querySelector('#event_imageedit').style.display = "none";
            document.querySelector('#change_cancel').style.display = "none";
            document.querySelector('#change_banner').style.display = "block";

        }

    }
</script>
<script>
    function gencre(id) {
        // alert(id);

        if (id == "1") {
            var c_name = $("#user_category").val();

            if (c_name == '') {
                swal.fire("Please Select User Category", "", "error");
                return false;
            }
            var event_name = $("#event_name").val();
            if (event_name == '') {
                swal.fire("Please Enter the Event Name", "", "error");
                return false;
            }

            var event_image = $("#event_image").val();
            if (event_image == '') {
                swal.fire("Please Upload The Event Image", "", "error");
                return false;
            }
            var editor = tinymce.get(document.querySelector('#event_description').id);
            // Check if the editor instance and its content exist
            if (editor && editor.getContent().trim() === '') {
                swal.fire("Please Enter the Event Description", "", "error");
                return false;
            }
            // var event_description = $("#event_description").val();
            // if (event_description == '') {
            //     swal.fire("Please Enter the Event Description", "", "error");
            //     return false;
            // }

            var event_date = $("#event_date").val();
            if (event_date == '') {
                swal.fire("Please Select the Event Date", "", "error")
                return false;
            } else {
                $('#savebutton').css('pointer-events', 'none');
                document.getElementById('event_form').submit();
            }
        } else if (id == "edit") {
            var c_nameedit = $("#user_categoryedit").val();

            if (c_nameedit == '') {
                swal.fire("Please Select User Category", "", "error");
                return false;
            }
            var event_nameedit = $("#event_nameedit").val();
            if (event_nameedit == '') {
                swal.fire("Please Enter the Event Name", "", "error");
                return false;
            }

            // var event_imageedit = $("#event_imageedit").val();
            // if (event_imageedit == '') {
            //     swal.fire("Please Upload The Event Image", "", "error");
            //     return false;
            // }
            // var event_descriptionedit = $("#event_descriptionedit").val();
            // if (event_descriptionedit == '') {
            //     swal.fire("Please Enter the Event Description", "", "error");
            //     return false;
            // }
            var editor = tinymce.get(document.querySelector('#event_descriptionedit').id);
            // Check if the editor instance and its content exist
            if (editor && editor.getContent().trim() === '') {
                swal.fire("Please Enter the Event Description", "", "error");
                return false;
            }

            var event_dateedit = $("#event_dateedit").val();
            if (event_dateedit == '') {
                swal.fire("Please Select the Event Date", "", "error")
                return false;
            } else {
                document.getElementById('edit_form').submit();
            }

        }


    }
</script>
<script>
    $(document).ready(function() {

        tinymce.init({
            selector: 'textarea.event_description',
            height: 180,
            menubar: 'table',
            branding: false,
            plugins: 'table textcolor',
            toolbar: 'undo redo | formatselect | ' +
                'bold italic forecolor backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help' + 'table tabledelete | tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
        // event.preventDefault()
        var show = tinymce.init({
            selector: 'textarea#event_descriptionshow',
            height: 180,
            menubar: 'table',
            branding: false,
            plugins: 'table textcolor',
            readonly: true,
            toolbar: 'undo redo | formatselect | ' +
                'bold italic forecolor backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help' + 'table tabledelete | tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
    });
</script>


<script>
    function fetch_update(id, type) {

        // alert(id);


        $.ajax({
            url: "{{ url('/event/fetch') }}",
            type: 'GET',
            data: {
                'id': id,
                _token: '{{csrf_token()}}'

            },

            success: function(data) {
                console.log(data);
                if (type == "edit") {
                    var editor = tinymce.get();
                    editor[1].setContent('');
                    editor[1].insertContent(data.rows[0]['event_description']);
                    $('#user_categoryedit').val(data.rows[0]['user_category']);
                    $('#event_nameedit').val(data.rows[0]['event_name']);
                    $('#event_imageedit').text(data.rows[0]['event_image']);
                    $('#event_descriptionedit').val(data.rows[0]['event_description']);

                    $('#event_dateedit').val(data.rows[0]['event_date']);
                    $('.img-fluid').attr('src', data.rows[0]['full_event_path']);
                    $('.img-fluid').attr('title', data.rows[0]['event_image']);
                    $('#eid').val(data.rows[0]['event_id']);

                } else {
                    var editor = tinymce.get();
                    editor[2].setContent('');
                    editor[2].insertContent(data.rows[0]['event_description']);
                    $('#user_categoryshow').val(data.rows[0]['user_category']);
                    $('#event_nameshow').val(data.rows[0]['event_name']);
                    $('#event_descriptionshow').val(data.rows[0]['event_description']);

                    $('#event_dateshow').val(data.rows[0]['event_date']);
                    $('.img-fluidshow').attr('src', data.rows[0]['full_event_path']);
                    $('.img-fluidshow').attr('title', data.rows[0]['event_image']);
                    $('#eid_show').val(data.rows[0]['notice_id']);

                    $('#user_categoryshow').prop('disabled', true);
                    $('#event_nameshow').prop('disabled', true);
                    $('#event_descriptionshow').prop('disabled', true);
                    $('#event_dateshow').prop('disabled', true);
                    $('#eid_show').attr('Action', '');


                }


            }
        });

    }
    document.querySelector(".startdate").addEventListener("keypress", function(evt) {
        var charCode = evt.which || evt.keyCode;
        var charStr = String.fromCharCode(charCode);

        if (/[\d\.,\/;:`]/.test(charStr)) {
            evt.preventDefault(); // Prevent entering the character
        }
    });
    // $('.savebutton').prop('disabled', true);
</script>


@endsection