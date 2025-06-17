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
</style>



<div class="main-content main_contentspace">
    <div class="row justify-content-center">

        <div class="col-lg-12 col-md-12">
            <div class="" style="">{{ Breadcrumbs::render('adminevent') }}

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

                            <div class="col-md-10"></div>

                            <div class="col-md-2">
                                <a type="button" style="font-size:15px;" class="btn btn-success btn-lg question"
                                    title="Create" href="" data-toggle="modal" data-target="#addModal">Add Event
                                    <span><i class="fa fa-plus" aria-hidden="true"></i></span></a>
                            </div>
                        </div>

                    </div>
                </section>

            </div>




            <section class="section5" id="classlist">
                <div class="section-body mt-1">
                    <div class="row">
                        <div class="col-12">
                            <h3 style="margin-top:10px;text-align:center;">Event List</h3>
                            <div class="card mt-0">
                                <div class="card-body">

                                    <div class="table-wrapper">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped" id="align1">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Event Name</th>
                                                        <th>Event Image</th>
                                                        <th>Event Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="background-color: #cfe0e8;">
                                                    @foreach($rows['rows'] as $data)

                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$data['event_name']}}</td>
                                                            <td> <img src="uploads/events/126/{{$data['event_image']}}"
                                                                    width="50px" height="50px" alt="Image" /></td>
                                                            <td>{{$data['event_date']}}</td>
                                                            <td>




                                                                <a class="btn btn-link" title="Edit" id="gcb"
                                                                    data-toggle="modal" data-target="#addModal4"><i
                                                                        class="fas fa-pencil-alt"
                                                                        style="color: blue !important"></i></a>
                                                                <a class="btn btn-link" title="show"><i class="fas fa-eye"
                                                                        style="color:green"></i></a>


                                                                <a type="button" title="Delete"
                                                                    onclick="event_delete(<?php    echo $data['event_id'] ?>)"
                                                                    class="btn btn-link"><i class="far fa-trash-alt"
                                                                        style="color:red"></i></a>


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



            </form>
        </div>

    </div>

</div>
</div>

<script>
    function event_delete(event_id) {
        //alert(id);
        $.ajax({
            url: "{{ route('event_delete') }}",
            type: 'POST',
            data: {
                event_id: event_id,

                _token: '{{csrf_token()}}'
            },
            error: function () {
                alert('Something is wrong');
            },
            success: function (data) {

                swal({
                    title: "Success",
                    text: "Event Deleted Successfully",
                    type: "success"
                },
                    function () {

                        window.location.href = "{{ url('adminevent') }}";

                    }
                );
            }
        });

    }
</script>

<script>
    $(function () {
        var dtToday = new Date();

        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if (month < 10)
            month = '0' + month.toString();
        if (day < 10)
            day = '0' + day.toString();

        var minDate = year + '-' + month + '-' + day;

        $('#txtDate').attr('min', minDate);
    });
</script>
<!-- addquestion function -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">



            <div class="modal-header mh">
                <h4 class="modal-title">Add Event</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>




            <!-- Long question -->

            <div class="card longquestion" id="">
                <h4 class="modal-title long">Add Event</h4>
                <form method="POST" id="event_form" action="{{ route('event_store')}}" name="add_event"
                    enctype="multipart/form-data" class="reset">
                    @csrf

                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Event Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="event_name" name="event_name">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>


                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Event Image:<span class="error-star" style="color:red;">*</span></label>
                                <input type="file" class="form-control default" id="event_image" name="event_image">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>

                    <!-- <h style="color:black"><b>Address:</b></h> -->
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Event Date:<span class="error-star" style="color:red;">*</span></label>
                                <input type="date" class="form-control" id="event_date" name="event_date">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <a class="btn btn-success btn-space" type="submit" onclick="gencre()" id="">Submit</a>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
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

    $(document).ready(function () {
        $(document).on('hidden.bs.modal', function () {

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
<script>
    function gencre() {

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

        var event_date = $("#event_date").val();
        if (event_date == '') {
            swal.fire("Please Select the Event Date", "", "error")
            return false;
        } else {
            document.getElementById('event_form').submit();
        }

    }
</script>


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
    $('#result').on('change', function () {
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
<div class="modal fade" id="addModal4">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="POST" id="create_form" onsubmit="return validateForm()" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="modal-header mh">
                    <h4 class="modal-title">Edit Event</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <!-- <div class="modal-body" style="background-color: #f8fffb !important;">


                

                </div> -->

            </form>

            <!-- Long question -->

            <div class=" container edit  longquestion">
                <h4 class="modal-title long">Edit Event</h4>
                <form method="post" action="" enctype="multipart/form-data">

                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Event Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="qname" name="qname">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>


                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Event Image:<span class="error-star" style="color:red;">*</span></label>
                                <input type="file" class="form-control default" id="qname" name="qname">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>

                    <!-- <h style="color:black"><b>Address:</b></h> -->
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Event Date:<span class="error-star" style="color:red;">*</span></label>
                                <input type="date" class="form-control default" id="qname" name="qname">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <button class="btn btn-success btn-space" type="button" onclick="gencre()"
                                id="savebutton">Submit</button>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </form>
            </div>

            <!-- end long-->
        </div>
    </div>
</div>
<!-- edit -->
<!-- Edit mcq -->

<!-- end -->


<!-- edit quiz -->

<!-- end -->





@endsection