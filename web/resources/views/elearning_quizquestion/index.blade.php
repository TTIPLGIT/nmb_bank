@extends('layouts.adminnav')

@section('content')
<style>
    input[type=checkbox] {
        display: inline-block;
    }

    /* div#align1_length {
        position: relative;
        top: 35px;
    }

    div#align1_filter {
        float: right;
    }

    div#align3_length {
        position: relative;
        top: 35px;
    }

    div#align3_filter {
        float: right;
    }

    div#align4_length {
        position: relative;
        top: 35px;
    } */

    .js-select2 {
        min-width: 258px !important;
        /* Adjust the width value as needed */
    }

    .js-select1 {
        min-width: 258px !important;
        /* Adjust the width value as needed */
    }

    .select2-search__field {
        width: initial !important;
    }

    div#align4_filter {
        float: right;
    }

    div#align_length {
        position: relative;
        top: 30px;
    }

    div#align_filter {
        float: right;
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

    .form-control.default::-webkit-inner-spin-button,
    .form-control.default::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .form-control.default {
        -moz-appearance: textfield;
    }
</style>


<style>
    #counselorerroredit {
        color: red;
    }

    #supervisorerroredit {
        color: red;
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

    .long_quistion {
        width: 240px !important;
        border: 1px solid black !important;
    }

    .long_quistionedit {
        width: 240px !important;
        border: 1px solid black !important;

    }

    .short_quistionedit {
        width: 240px !important;
        border: 1px solid black !important;
    }

    .mcq_quistionedit {
        width: 240px !important;
        border: 1px solid black !important;
    }

    .mcq_quistionshow {
        width: 240px !important;
        border: 1px solid black !important;
    }

    .short_quistion {
        width: 240px !important;
        border: 1px solid black !important;
    }

    .true_quistion {
        width: 240px !important;
        border: 1px solid black !important;
    }

    .true_quistionshow {
        width: 240px !important;
        border: 1px solid black !important;
    }

    .mcq_quistion {
        width: 240px !important;
        border: 1px solid black !important;
    }


    @media (min-width: 576px) {
        .true_quistion {
            width: 240px !important;
            border: 1px solid black !important;
        }

        .long_quistion {
            width: 240px !important;
            border: 1px solid black !important;
        }

        .long_quistionedit {
            width: 240px !important;
            border: 1px solid black !important;

        }

        .short_quistionedit {
            width: 240px !important;
            border: 1px solid black !important;
        }

        .true_quistionedit {
            width: 240px !important;
            border: 1px solid black !important;
        }

        .mcq_quistion {
            width: 240px !important;
            border: 1px solid black !important;
        }

        .mcq_quistionedit {
            width: 240px !important;
            border: 1px solid black !important;
        }

        .true_quistionshow {
            width: 240px !important;
            border: 1px solid black !important;
        }

        .mcq_quistionshow {
            width: 240px !important;
            border: 1px solid black !important;
        }

        .short_quistion {
            width: 240px !important;
            border: 1px solid black !important;
        }

        .short_quistionshow {
            width: 240px !important;
            border: 1px solid black !important;
        }
    }

    @media (min-width: 768px) {
        .true_quistion {
            width: 357px !important;
            height: 76px !important;
            border: 1px solid black !important;
        }

        .true_quistionedit {
            width: 357px !important;
            height: 76px !important;
            border: 1px solid black !important;
        }

        .true_quistionshow {
            width: 357px !important;
            height: 76px !important;
            border: 1px solid black !important;
        }

        .long_quistion {
            width: 357px !important;
            height: 76px !important;
            border: 1px solid black !important;
        }

        .long_quistionedit {
            width: 357px !important;
            height: 76px !important;
            border: 1px solid black !important;
        }

        .short_quistionedit {
            width: 357px !important;
            height: 76px !important;
            border: 1px solid black !important;
        }

        .mcq_quistion {
            width: 357px !important;
            height: 76px !important;
            border: 1px solid black !important;
        }

        .mcq_quistionedit {
            width: 357px !important;
            height: 76px !important;
            border: 1px solid black !important;
        }

        .mcq_quistionshow {
            width: 357px !important;
            height: 76px !important;
            border: 1px solid black !important;
        }

        .short_quistion {
            width: 357px !important;
            height: 76px !important;
            border: 1px solid black !important;
        }

        .short_quistionshow {
            width: 357px !important;
            height: 76px !important;
            border: 1px solid black !important;
        }

    }



    @media (min-width: 992px) {
        .true_quistion {
            width: 610px !important;
            height: 80px;
            border: 1px solid black !important;
        }

        .true_quistionshow {
            width: 610px !important;
            height: 80px;
            border: 1px solid black !important;
        }

        .long_quistion {
            width: 610px !important;
            height: 80px;
            border: 1px solid black !important;
        }

        .long_quistionedit {
            width: 610px !important;
            height: 80px;
            border: 1px solid black !important;
        }

        .true_quistionedit {
            width: 610px !important;
            height: 80px;
            border: 1px solid black !important;
        }

        .short_quistionedit {
            width: 610px !important;
            height: 80px;
            border: 1px solid black !important;
        }

        .mcq_quistion {
            width: 610px !important;
            height: 80px;
            border: 1px solid black !important;
        }

        .mcq_quistionedit {
            width: 610px !important;
            height: 80px;
            border: 1px solid black !important;
        }

        .mcq_quistionshow {
            width: 610px !important;
            height: 80px;
            border: 1px solid black !important;
        }

        .short_quistion {
            width: 610px !important;
            height: 80px;
            border: 1px solid black !important;
        }

        .short_quistionshow {
            width: 610px !important;
            height: 80px;
            border: 1px solid black !important;
        }

    }

    @media (min-width: 1200px) {
        .true_quistion {
            height: 119px !important;
            width: 605px !important;
            border: 1px solid black !important;
        }

        .true_quistionshow {
            height: 119px !important;
            width: 605px !important;
            border: 1px solid black !important;
        }


        .long_quistion {
            height: 119px !important;
            width: 605px !important;
            border: 1px solid black !important;
        }

        .long_quistionedit {
            height: 119px !important;
            width: 605px !important;
            border: 1px solid black !important;
        }

        .true_quistionedit {
            height: 119px !important;
            width: 605px !important;
            border: 1px solid black !important;
        }

        .short_quistionshow {
            height: 119px !important;
            width: 605px !important;
            border: 1px solid black !important;
        }

        .long_quistionshow {
            height: 119px !important;
            width: 605px !important;
            border: 1px solid black !important;
        }

        #mcq_quistion {
            height: 119px !important;
            width: 605px !important;
            border: 1px solid black !important;
        }

        .mcq_quistionedit {
            height: 119px !important;
            width: 605px !important;
            border: 1px solid black !important;
        }

        .mcq_quistionshow {
            height: 119px !important;
            width: 605px !important;
            border: 1px solid black !important;
        }

        .short_quistion {
            height: 119px !important;
            width: 605px !important;
            border: 1px solid black !important;
        }

        .short_quistionedit {
            height: 119px !important;
            width: 605px !important;
            border: 1px solid black !important;
        }

        .true_quistionedit {
            height: 119px !important;
            width: 605px !important;
            border: 1px solid black !important;
        }

    }
</style>



<div class="main-content main_contentspace">
    <div class="row justify-content-center">

        <div class="col-lg-12 col-md-12">
            {{ Breadcrumbs::render('elearningquestion.index') }}

            <form method="POST" id="" enctype="multipart/form-data" onsubmit="return false">
                @csrf

                <section class="section5">
                    <div class="section-body mt-1">
                        <div class="row">
                            <div class="col-sm-2 addquizmodal">
                                <a type="button" style="font-size:15px;margin: 0px 0px 7px 0px;"
                                    class="btn btn-success btn-lg" title="Create" id="gcb" href="" data-toggle="modal"
                                    data-target="#addModal1">Add Quiz <span><i class="fa fa-plus"
                                            aria-hidden="true"></i></span></a>
                            </div>
                            <div class="col-12" id="quizlist">

                                <div class="card mt-0">
                                    <div class="card-body">
                                        <h3 style="text-align:center;">Quiz View</h3>

                                        <!-- @if ($message = Session::get('success'))
                                        <div class="alert alert-success alert-block">
                                            <button type="button" class="close" data-dismiss="alert">�</button>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @endif

                                        @if ($message = Session::get('error'))
                                        <div class="alert alert-success alert-block">
                                            <button type="button" class="close" data-dismiss="alert">�</button>
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @endif -->
                                        <div class="table-wrapper">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="align1">
                                                    <thead>
                                                        <tr>
                                                            <th>S.No</th>
                                                            <th>quiz Name</th>
                                                            <th class="ellipsis">quiz Questions</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody style="background-color: #cfe0e8;">
                                                        @foreach($rows['rows']['quiz'] as $data)
                                                            <tr>
                                                                <td>{{$loop->iteration}}</td>
                                                                <td>{{$data['quiz_name']}}</td>
                                                                <td>
                                                                    @foreach($rows['rows']['quiz_question'] as $row)
                                                                        @foreach($data['quiz_questions'] as $key => $new_row)
                                                                            @if($new_row == $row['question_id'])
                                                                                @if($key == 0)
                                                                                    {{$row['name']}}
                                                                                @else
                                                                                    ,{{$row['name']}}
                                                                                @endif



                                                                            @endif
                                                                        @endforeach
                                                                    @endforeach
                                                                </td>



                                                                <td style="">
                                                                    <a class="btn btn-link" title="Edit" id="gcb" href=""
                                                                        data-toggle="modal" data-target="#addModaleditquiz"
                                                                        onclick="fetch_update({{$data['quiz_id']}},'quizedit')"
                                                                        style="margin-top: 0px !important;"><i
                                                                            class="fas fa-pencil-alt"
                                                                            style="color: blue !important"></i></a>

                                                                    <a class="btn btn-link" title="show" data-toggle="modal"
                                                                        data-target="#addModalshowquiz"
                                                                        onclick="fetch_update({{$data['quiz_id']}},'quizshow')"><i
                                                                            class="fas fa-eye" style="color:green"></i></a>

                                                                    @csrf

                                                                    <button type="submit" title="Delete"
                                                                        onclick="delete1({{$data['quiz_id']}},'5')"
                                                                        class="btn btn-link"><i class="far fa-trash-alt"
                                                                            style="color:red"></i></button>


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
            <br>

            <div class="row" style="display: flex;justify-content: space-between;">
                <div class="col-sm-3" style="margin-bottom: 9px !important;">
                    <a type="button" style="font-size:15px;margin: 0px 0px 0px 0px;"
                        class="btn btn-success btn-lg question" title="Create" href="" data-toggle="modal"
                        data-target="#addModal">Add Question <span><i class="fa fa-plus"
                                aria-hidden="true"></i></span></a>
                </div>
                <div class="col-sm-3" style="margin-bottom: 6px !important;">
                    <select class="form-control default" id="result1" name="result1">
                        <!-- <option value="" >Question Type</option> -->
                        <option value="LongQuestionlist">Long Question</option>
                        <option value="MCQlist">Multiple Choice Question(MCQ)</option>
                        <option value="ShortAnswerlist">Short Question</option>
                        <option value="True/Falselist" selected>True/False</option>
                    </select>
                </div>
            </div>

            <section class="section" id="longquestionlist" style="display:none">


                <div class="section-body mt-0">
                    @if (session('type'))
                        <input type="hidden" name="session_data" id="session_data" class="session_data"
                            value="{{ session('type') }}">

                        <script type="text/javascript">
                            window.onload = function () {

                                var value = $('#session_data').val();
                                $('#result1').val(value).change()
                            }
                        </script>

                    @endif
                    @if (session('success'))

                        <input type="hidden" name="session_data" id="session_data" class="session_data"
                            value="{{ session('success') }}">
                        <script type="text/javascript">
                            window.onload = function () {
                                var message = $('#session_data').val();
                                // alert(message);
                                swal.fire({
                                    title: "Success",
                                    text: message,
                                    icon: "success",
                                    type: "success",
                                });
                                if (message == 'Quiz Created Successfully') {
                                    setTimeout(function () {
                                        document.getElementById('quizlist').scrollIntoView({
                                            behavior: 'smooth'
                                        });
                                    }, 500);
                                } else if (message == 'Quiz Updated Successfully') {
                                    setTimeout(function () {
                                        document.getElementById('quizlist').scrollIntoView({
                                            behavior: 'smooth'
                                        });
                                    }, 500);
                                } else {
                                    // alert("ASdae");
                                    setTimeout(function () {
                                        document.getElementById('truelist').scrollIntoView({
                                            behavior: 'smooth'
                                        });
                                    }, 500);
                                }


                            }
                        </script>
                    @elseif(session('error'))

                        <input type="hidden" name="session_data" id="session_data1" class="session_data"
                            value="{{ session('error') }}">
                        <script type="text/javascript">
                            window.onload = function () {
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
                        <div class="col-md-12">

                            <div class="card">
                                <div class="card-body">
                                    <h2 style="text-align:center;">Long Question View</h2>
                                    <div class="table-wrapper">
                                        <div class="table-responsive">
                                            <table class="table  table-bordered table-striped" id="tableExport">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>question Tag</th>
                                                        <th class="ellipsis">questions</th>
                                                        <th>Points</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach($rows['rows']['long'] as $data)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$data['question_name']}}</td>
                                                            <td>{{$data['question']}}</td>
                                                            <td>{{$data['points']}}</td>

                                                            <td style="">



                                                                <a class="btn btn-link" title="Edit" id="gcb" href=""
                                                                    onclick="fetch_update({{$data['id']}},'longedit')"
                                                                    data-toggle="modal" data-target="#addModal3"
                                                                    style="margin-top:0px;"><i class="fas fa-pencil-alt"
                                                                        style="color: blue !important"></i></a>
                                                                <a class="btn btn-link" title="show" id="gcb" href=""
                                                                    onclick="fetch_update({{$data['id']}},'longshow')"
                                                                    data-toggle="modal" data-target="#addModal4"><i
                                                                        class="fas fa-eye" style="color:green"></i></a>

                                                                @csrf

                                                                <!-- <button type="submit" title="Delete" onclick="delete1({{$data['id']}},'1')" class="btn btn-link"><i class="far fa-trash-alt" style="color:red"></i></button> -->
                                                            </td>

                                                        </tr>


                                                        <input type="hidden" class="cfn" id="fn" value="0">
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
            <section class="section" id="mcqlist" style="display:none">


                <div class="section-body mt-0">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="card">
                                <div class="card-body">
                                    <h2 style="text-align:center;">MCQ Question View</h2>
                                    <div class="table-wrapper">
                                        <div class="table-responsive">
                                            <table class="table  table-bordered table-striped" id="align2">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Question Tag</th>
                                                        <th class="ellipsis">Questions</th>
                                                        <th>Points</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($rows['rows']['mcq'] as $data)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$data['question_name']}}</td>
                                                            <td>{{$data['question']}}</td>

                                                            <td>{{$data['points']}}</td>

                                                            <td style="">

                                                                <a class="btn btn-link" title="Edit" id="gcb" href=""
                                                                    onclick="fetch_update({{$data['id']}},'mcqedit')"
                                                                    data-toggle="modal" data-target="#addModalmcqedit"
                                                                    style="margin-top:0px;"><i class="fas fa-pencil-alt"
                                                                        style="color: blue !important"></i></a>
                                                                <a class="btn btn-link" title="show" id="gcb" href=""
                                                                    onclick="fetch_update({{$data['id']}},'mcqshow')"
                                                                    data-toggle="modal" data-target="#addModalmcqshow"><i
                                                                        class="fas fa-eye" style="color:green"></i></a>

                                                                @csrf

                                                                <!-- <button type="submit" title="Delete" onclick="delete1({{$data['id']}},'3')" class="btn btn-link"><i class="far fa-trash-alt" style="color:red"></i></button> -->

                                                            </td>

                                                        </tr>


                                                        <input type="hidden" class="cfn" id="fn" value="0">
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
            <section class="section" id="shortanswerlist" style="display:none">


                <div class="section-body mt-0">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="card">
                                <div class="card-body">
                                    <h2 style="text-align:center;">Short Question View</h2>
                                    <div class="table-wrapper">
                                        <div class="table-responsive">
                                            <table class="table  table-bordered table-striped" id="align3">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>Question Tag</th>
                                                        <th class="ellipsis">Questions</th>
                                                        <th>Points</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($rows['rows']['short'] as $data)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$data['question_name']}}</td>
                                                            <td>{{$data['question']}}</td>
                                                            <td>{{$data['points']}}</td>
                                                            <td style="">
                                                                <a class="btn btn-link" title="Edit" id="gcb" href=""
                                                                    onclick="fetch_update({{$data['id']}},'shortedit')"
                                                                    data-toggle="modal" data-target="#addModalshortedit"
                                                                    style="margin-top:0px;"><i class="fas fa-pencil-alt"
                                                                        style="color: blue !important"></i></a>
                                                                <a class="btn btn-link" title="show" id="gcb" href=""
                                                                    onclick="fetch_update({{$data['id']}},'shortshow')"
                                                                    data-toggle="modal" data-target="#addModalshortshow"><i
                                                                        class="fas fa-eye" style="color:green"></i></a>

                                                                @csrf

                                                                <!-- <button type="submit" title="Delete" onclick="delete1({{$data['id']}},'2')" class="btn btn-link"><i class="far fa-trash-alt" style="color:red"></i></button> -->

                                                            </td>

                                                        </tr>


                                                        <input type="hidden" class="cfn" id="fn" value="0">
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
            <section class="section" id="truelist">


                <div class="section-body mt-0">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="card">
                                <div class="card-body">
                                    <h2 style="text-align:center;">True/False Question View</h2>
                                    <div class="table-wrapper">
                                        <div class="table-responsive">
                                            <table class="table  table-bordered table-striped" id="align4">
                                                <thead>
                                                    <tr>
                                                        <th>S.No</th>
                                                        <th>question Tag</th>
                                                        <th class="ellipsis">questions</th>
                                                        <th>Points</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($rows['rows']['true'] as $data)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$data['question_name']}}</td>
                                                            <td>{{$data['question']}}</td>
                                                            <td>{{$data['points']}}</td>
                                                            <td style="">
                                                                <a class="btn btn-link" title="Edit" id="gcb" href=""
                                                                    data-toggle="modal"
                                                                    onclick="fetch_update({{$data['id']}},'trueedit')"
                                                                    data-target="#addModaltrueedit"><i
                                                                        class="fas fa-pencil-alt"
                                                                        style="color: blue !important"></i></a>
                                                                <a class="btn btn-link" title="show" data-toggle="modal"
                                                                    onclick="fetch_update({{$data['id']}},'trueshow')"
                                                                    data-target="#addModaltrueshow"><i class="fas fa-eye"
                                                                        style="color:green"></i></a>

                                                                @csrf

                                                                <!-- <button type="submit" title="Delete" onclick="delete1({{$data['id']}},'4')" class="btn btn-link"><i class="far fa-trash-alt" style="color:red"></i></button> -->

                                                            </td>

                                                        </tr>


                                                        <input type="hidden" class="cfn" id="fn" value="0">
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

<div class="modal fade" id="addModal1">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="POST" id="quizcreate_form" action="{{route('elearning.quiz_store')}}"
                enctype="multipart/form-data" class="reset">
                {{ csrf_field() }}

                <div class="modal-header mh">
                    <h4 class="modal-title">Add Quiz</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" style="background-color: #f8fffb !important;">
                    <input type="hidden" class="form-control" id="user_id" name="user_id" value="">
                    <input type="hidden" class="form-control" id="user_details" name="user_details" value="general">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Quiz Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default comma" id="q_name" name="q_name"
                                    autocomplete="off" placeholder="Enter the Quiz Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Quiz Question:<span class="error-star" style="color:red;">*</span></label>
                                <select class="js-select1" id="quiz_question" name="quiz_question[]" multiple="multiple"
                                    onchange="data();" placeholder="Select Quiz Question">

                                    @foreach($rows['rows']['quiz_question'] as $key => $row)

                                        <option value="{{ $row['question_id'] }}">{{ $row['name'] }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 quizpoints" style="display:none;">
                            <div class="form-group">
                                <label>Total Points:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="q_points" name="q_points"
                                    autocomplete="off">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <button class="btn btn-success btn-space" type="button" onclick="gencre(5)"
                                id="savebutton">Submit</button>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel"
                                onclick="resetSelect2()">
                        </div>
                    </div>
                </div>

            </form>
        </div>




    </div>

</div>

<!-- addquestion function -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="POST" id="create_form" onsubmit="return validateForm()" enctype="multipart/form-data"
                class="reset">
                {{ csrf_field() }}

                <div class="modal-header mh">
                    <h4 class="modal-title">Add Question</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" style="background-color: #f8fffb !important;">
                    <div class="row">

                        <div class="col-md-12" style="display: flex;justify-content: center;">
                            <div class="form-group">
                                <!-- <label>District:<span class="error-star" style="color:red;">*</span></label> -->
                                <select class="form-control default" id="result" name="result">
                                    <option value="">Question Type</option>
                                    <option value="Long Question">Long Question</option>
                                    <option value="MCQ">Multiple Choice Question(MCQ)</option>
                                    <option value="ShortAnswer">Short Question</option>
                                    <option value="True/False">True/False</option>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>



                </div>

            </form>

            <!-- Long question -->
            <div id="question-row"></div>
            <div class="card longquestion" id="longquestion" style="display:none">
                <h4 class="modal-title long">Long Question:</h4>
                <form method="post" action="{{route('elearningquestion.long_store')}}" id="longcreateform"
                    enctype="multipart/form-data" class="reset">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Question Tag:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default comma" id="long_qname" name="long_qname"
                                    autocomplete="off" placeholder="Enter the Long Question Tag">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Question:<span class="error-star" style="color:red;">*</span></label><br>
                                <textarea id="long_quistion" class="long_quistion" name="long_quistion"
                                    autocomplete="off" placeholder="Please Enter the Long Question name"></textarea>

                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <!-- <h style="color:black"><b>Address:</b></h> -->

                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Keywords:<span class="error-star" style="color:red;">*</span></label>
                                <div class="wordquestion">

                                    <table class="_table">

                                        <tbody id="table_body">
                                            <tr>

                                                <td>
                                                    <input type="text" class="form-control default" id="keyword_long"
                                                        name="keyword_long[]" autocomplete="off">

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

                        <div class="col-md-1"></div>

                    </div>

                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Points: <span class="error-star" style="color:red;">*</span></label>
                                <input type="number" class="form-control default" id="long_points" name="long_points"
                                    autocomplete="off" placeholder="Enter The Points">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <input type="hidden" name="question_type" class="question_type" id="question_type">

                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <button class="btn btn-success btn-space" type="button" onclick="gencre(1)"
                                id="savebutton">Submit</button>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel"
                                onclick="resetSelect2()">
                        </div>
                    </div>
                </form>
            </div>

            <!-- end -->
            <!-- Mcq -->

            <div class="card mcqquestion" id="mcq" style="display:none">
                <h4 class="modal-title mcq">Multiple Choice Question(MCQ):</h4>
                <form method="post" action="{{route('elearningquestion.mcq_store')}}" id="mcqcreateform"
                    enctype="multipart/form-data" class="reset">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Question Tag:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default comma" id="mcq_qname" name="mcq_qname"
                                    autocomplete="off" placeholder="Enter the Question Tag">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">


                            <div class="form-group">
                                <label>Question:<span class="error-star" style="color:red;">*</span></label><br>
                                <textarea id="mcq_quistion" class="mcq_quistion" name="mcq_quistion" rows="4" cols="81"
                                    autocomplete="off" placeholder="Please Enter the Mcq Question name"></textarea>

                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <!-- <h style="color:black"><b>Address:</b></h> -->
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Choices:<span class="error-star" style="color:red;">*</span></label>
                                <div class="wordquestion">
                                    <table class="_table">

                                        <tbody id="mcq_body">
                                            <tr>

                                                <td>
                                                    <input type="text" class="form-control default" id="keyword_mcq"
                                                        name="keyword_mcq[]" autocomplete="off">
                                                </td>

                                                <td>
                                                    <div class="action_container">
                                                        <button class="danger" onclick="remove_tr(this)">
                                                            <i class="fa fa-close"></i>
                                                        </button>
                                                    </div>
                                                    <div class="action_container3">
                                                        <button class="success" type="button"
                                                            onclick="create_tr('mcq_body')">
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
                        <div class="col-md-1"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Correct Choices:<span class="error-star" style="color:red;">*</span></label>
                                <br>
                                <select class="js-select2" id="mcq_correct_choices" name="mcq_correct_choices[]"
                                    multiple="multiple">
                                    <option value="" data-badge="">Select Correct Choices</option>




                                </select>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Points: <span class="error-star" style="color:red;">*</span></label>
                                <input type="number" class="form-control default" id="mcq_points" name="mcq_points"
                                    autocomplete="off" placeholder="Enter the Points">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <button class="btn btn-success btn-space" type="button" onclick="gencre(3)"
                                id="savebutton">Submit</button>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel"
                                onclick="resetSelect2()">
                        </div>
                    </div>
                </form>
            </div>
            <!-- end -->
            <!-- Short answer -->

            <div class="card shortquestion" id="shortanswer" style="display:none">
                <h4 class="modal-title short">Short Question:</h4>
                <form method="post" action="{{route('elearningquestion.short_store')}}" id="shortcreateform"
                    enctype="multipart/form-data" class="reset">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Question Tag:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default comma" id="short_qname"
                                    name="short_qname" autocomplete="off" placeholder="Enter the Short Question Tag">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Question:<span class="error-star" style="color:red;">*</span></label><br>
                                <textarea id="short_quistion" class="short_quistion" name="short_quistion" rows="4"
                                    cols="81" autocomplete="off"
                                    placeholder="Please Enter the Short Question name"></textarea>

                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <!-- <h style="color:black"><b>Address:</b></h> -->
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Keywords:<span class="error-star" style="color:red;">*</span></label>
                                <div class="wordquestion">
                                    <table class="_table">

                                        <tbody id="short_body">
                                            <tr>

                                                <td>
                                                    <input type="text" class="form-control default" id="keyword_short"
                                                        name="keyword_short[]" autocomplete="off">

                                                </td>


                                                <td>
                                                    <div class="action_container">
                                                        <button class="danger" onclick="remove_tr(this)">
                                                            <i class="fa fa-close"></i>
                                                        </button>
                                                    </div>
                                                    <div class="action_container">
                                                        <button class="success" type="button"
                                                            onclick="create_tr('short_body')">
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
                        <div class="col-md-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Points: <span class="error-star" style="color:red;">*</span></label>
                                <input type="number" class="form-control default" id="short_points" name="short_points"
                                    autocomplete="off" placeholder="Enter the Points">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <button class="btn btn-success btn-space" type="button" onclick="gencre(2)"
                                id="savebutton">Submit</button>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel"
                                onclick="resetSelect2()">
                        </div>
                    </div>
                </form>
            </div>

            <!-- end -->
            <!-- true/false -->

            <div class="card truequestion" id="true" style="display:none">
                <h4 class="modal-title true">True/false:</h4>
                <form method="post" action="{{route('elearningquestion.true_store')}}" id="truecreateform"
                    enctype="multipart/form-data" class="reset">
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Question Tag:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default comma" id="true_qname" name="true_qname"
                                    autocomplete="off" placeholder="Enter the Question Tag">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Question:<span class="error-star" style="color:red;">*</span></label><br>
                                <textarea id="true_quistion" class="true_quistion" name="true_quistion" rows="4"
                                    cols="81" autocomplete="off"
                                    placeholder="Please Enter the T/F Question name"></textarea>

                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <!-- <h style="color:black"><b>Address:</b></h> -->
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Answer:<span class="error-star" style="color:red;">*</span></label>
                                <!-- <input type="text" class="form-control default" id="answer" name="answer"> -->
                                <input type="radio" id="answer" name="answer" value="on" required />
                                <label for="answer">True</label>
                                <input type="radio" id="answer" name="answer" value="off" required />
                                <label for="answer">False</label>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Points: <span class="error-star" style="color:red;">*</span></label>
                                <input type="number" class="form-control default" id="true_points" name="true_points"
                                    autocomplete="off" placeholder="Enter the Points">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <button class="btn btn-success btn-space" type="button" onclick="gencre(4)"
                                id="savebutton">Submit</button>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel"
                                onclick="resetSelect2()">
                        </div>
                    </div>
                </form>
            </div>

            <!-- end -->
        </div>
    </div>
</div>


<style>
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

    .action_container3 {
        /* float: right; */
        position: relative;
        /* left: 5px;
        top: 3px; */
        z-index: 999;
    }

    .action_container4 {
        float: right;
        position: relative;
        left: 5px;
        top: 3px;
        z-index: 999;

    }

    div .action_container3.custom {
        float: right;
        position: relative;
        left: -39px !important;
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

    .action_container4>* {
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

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
<script>
    document.querySelector("[type='number']").addEventListener("keypress", function (evt) {
        if ((evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57) || (evt.which === 46)) {
            evt.preventDefault();
        }
    });

    function choice_callback() {


        // $(`#${option}`).remove();
        var data = document.querySelectorAll("#keyword_mcq");
        // var clear = document.querySelector('.select2-selection__clear');
        // clear.click();
        $("#mcq_correct_choices").empty();
        // document.querySelector('#mcq_correct_choices').innerHTML = '<option value="" data-badge="">Select Correct Choices</option>';
        for (let iterator of data) {


            $('#mcq_correct_choices').append(`<option data-badge=""  id="${iterator.value}">${iterator.value}</option`);

        }

    }
    $(document).on('focusout', '#keyword_mcq', function (e) {
        choice_callback();
    });
    const correct_choices = [];

    function choice_callbackedit() {

        var keyword_edit = document.querySelectorAll("#keyword_mcqedit");
        //var keyword_correct = document.querySelectorAll(".correct_choicesedit");


        //     $("#mcq_correct_choices").empty();
        //     for (let iterator of correct_choices) {
        //         $('#mcq_correct_choicesedit').append(`<option data-badge="" selected id="${iterator}">${iterator}</option`);

        //     }

    }

    // $(document).on('focusout', '#keyword_mcqedit', function(e) {
    //     choice_callbackedit();
    // });


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



    // function remove_tr(This) {
    //     if (This.closest('tbody').childElementCount == 1) {
    //         alert("You Don't have Permission to Delete This ?");
    //     } else {
    //         This.closest('tr').remove();
    //     }
    // }
    function remove_tr(button) {
        const row = button.closest('tr');
        if (document.querySelectorAll('#table_body tr').length > 1) {
            row.remove();
        } else {
            swal.fire("At least one row must remain", "", "warning");
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
    function mcqeditremovechoice() {

        var keyword = document.querySelectorAll('keyword_mcqedit');

        $("#mcq_correct_choices").empty();
        for (let keywords of keyword) {
            $('#mcq_correct_choicesedit').append(`<option data-badge="">${keywords.value}</option`);

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


        if (table_id == "table_body") {

            var keyword_long = $("#keyword_long").val();
            if (keyword_long == '') {
                swal.fire("Please Enter the Question Keywords", "", "error");
                return false;
            } else {
                // let table_body2 = document.getElementById(table_id),
                //     first_tr = table_body2.firstElementChild
                // tr_clone = first_tr.cloneNode(true);

                // table_body2.append(tr_clone);

                // clean_first_tr(table_body2.firstElementChild);
                // const tableBody = document.getElementById(table_id);
                // const firstRow = tableBody.firstElementChild;
                // const newRow = firstRow.cloneNode(true);
                // // Remove the "Add" button from the cloned row
                // const addButton = newRow.querySelector('.success');
                // if (addButton) {
                //     addButton.remove();
                // }

                // // Clear the value of the input in the new row
                // newRow.querySelector('input').value = '';

                // tableBody.appendChild(newRow);
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
        } else if (table_id == "table_long_edit") {
            let table_body2 = document.getElementById(table_id),
                first_tr = table_body2.firstElementChild
            tr_clone = first_tr.cloneNode(true);

            table_body2.append(tr_clone);

            clean_first_tr(table_body2.firstElementChild);
            remove_tr(This);

        } else if (table_id == "short_body") {


            var keyword_short = $("#keyword_short").val();
            if (keyword_short == '') {
                swal.fire("Please Enter the Question Keywords", "", "error");
                return false;
            } else {
                // let table_body3 = document.getElementById(table_id),
                //     first_tr = table_body3.firstElementChild
                // tr_clone = first_tr.cloneNode(true);

                // table_body3.append(tr_clone);

                // clean_first_tr(table_body3.firstElementChild);
                // document.querySelector('#short_body').parentElement.previousElementSibling.classList.add('custom');

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
                clean_first_tr(table_body3.firstElementChild);
                document.querySelector('#short_body').parentElement.previousElementSibling.classList.add('custom');


            }
        } else if (table_id == "table_short_edit") {
            let table_body3 = document.getElementById(table_id),
                first_tr = table_body3.firstElementChild
            tr_clone = first_tr.cloneNode(true);

            table_body3.append(tr_clone);

            clean_first_tr(table_body3.firstElementChild);
            remove_tr(This);


        } else if (table_id == "mcq_body") {


            var keyword_mcq = $("#keyword_mcq").val();
            if (keyword_mcq == '') {
                swal.fire("Please Enter the Choices", "", "error");
                return false;
            } else {
                // let table_body3 = document.getElementById(table_id),
                //     first_tr = table_body3.firstElementChild
                // tr_clone = first_tr.cloneNode(true);
                // tr_clone.querySelector('input').setAttribute("readonly", "");
                // table_body3.append(tr_clone);

                // clean_first_tr(table_body3.firstElementChild);
                // document.querySelector('#mcq_body').parentElement.previousElementSibling.classList.add('custom');

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
                clean_first_tr(table_body3.firstElementChild);
                document.querySelector('#mcq_body').parentElement.previousElementSibling.classList.add('custom');

            }
        } else if (table_id == "table_mcq_edit") {


            var keyword_mcqedit = $("#keyword_mcqedit").val();
            if (keyword_mcqedit == '') {
                swal.fire("Please Enter the Choices", "", "error");
                return false;
            } else {
                let table_body3 = document.getElementById(table_id),

                    first_tr = table_body3.firstElementChild
                tr_clone = first_tr.cloneNode(true);
                tr_clone.querySelector('input').setAttribute("readonly", "");
                table_body3.append(tr_clone);


                clean_first_tr(table_body3.firstElementChild);
                remove_tr(This);



                // document.querySelector('#short_body').parentElement.previousElementSibling.classList.add('custom');

            }
        }

    }

    $(document).on('change', '#keyword_mcqedit', function () {
        var new_value = $('#keyword_mcqedit').val();
        var new_valuecount = document.querySelectorAll('#keyword_mcqedit').length;
        var new_correctcount = document.querySelector('#mcq_correct_choicesedit').children.length;

        if (new_valuecount == new_correctcount || new_value == "") {
            var parentelement = document.querySelector('#mcq_correct_choicesedit');
            var lastchild = parentelement.lastChild;
            parentelement.removeChild(lastchild);
        }

        const new_option = `<option value='${new_value}'>${new_value}</option>`;
        $('#mcq_correct_choicesedit').append(new_option);

    });

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
        //console.log(This.closest('input').value);

        if (This.closest('tbody').childElementCount == 1) {
            alert("You Don't have Permission to Delete This ?");
        } else {
            var remove_value = This.closest('tr').firstElementChild.firstElementChild.value;
            console.log(This.closest('tr'));
            const optionschoices = $('#mcq_correct_choices').children();
            console.log(optionschoices);
            // alert(remove_value);
            for (const optionschoice of optionschoices) {
                // alert($(option).text());
                // alert(remove_value);
                // alert($(option).text() == remove_value);
                if ($(optionschoice).text() == remove_value) {
                    $(optionschoice).remove();
                }

            }
            const options = $('#mcq_correct_choicesedit').children();
            console.log(options);


            for (const option of options) {
                // alert($(option).text());
                // alert(remove_value);
                // alert($(option).text() == remove_value);
                if ($(option).text() == remove_value) {
                    $(option).remove();
                }

            }
            This.closest('tr').remove();
        }

        // if (This.closest('tbody').childElementCount == 1) {

        //     alert("You Don't have Permission to Delete This ?");
        // } else {
        //     This.closest('tr').remove();
        //     mcqeditremovechoice();

        //     if (document.getElementById('mcq').style.display != "none") {
        //         choice_callback();
        //     }

        // }
    }
</script>


<script>
    function calcQuestionType(id) {
        if ($(`#${id}`).val() === 'Long Question') {
            $('#longquestion').css('display', 'block');
            $('#mcq').css('display', 'none');
            $('#shortanswer').css('display', 'none');
            $('#true').css('display', 'none');
        } else if ($(`#${id}`).val() === 'MCQ') {
            $('#mcq').css('display', 'block');
            $('#longquestion').css('display', 'none');
            $('#shortanswer').css('display', 'none');
            $('#true').css('display', 'none');

        } else if ($(`#${id}`).val() === 'ShortAnswer') {
            $('#shortanswer').css('display', 'block');
            $('#longquestion').css('display', 'none');
            $('#mcq').css('display', 'none');
            $('#true').css('display', 'none');
        } else if ($(`#${id}`).val() === 'True/False') {
            $('#true').css('display', 'block');
            $('#longquestion').css('display', 'none');
            $('#mcq').css('display', 'none');
            $('#shortanswer').css('display', 'none');
        } else {
            $('#longquestion').css('display', 'none');
            $('#mcq').css('display', 'none');
            $('#shortanswer').css('display', 'none');
            $('#true').css('display', 'none');
        }
    }
    $('#result').on('change', function (e) {
        calcQuestionType(e.target.id);
    });
</script>

<script>
    $('#result1').on('change', function () {

        // alert('asda');
        if ($(this).val() === 'LongQuestionlist') {
            $('#longquestionlist').css('display', 'block');
            $('#truelist').css('display', 'none');
            $('#mcqlist').css('display', 'none');
            $('#shortanswerlist').css('display', 'none');

        }
        if ($(this).val() === 'MCQlist') {
            $('#mcqlist').css('display', 'block');
            $('#truelist').css('display', 'none');
            $('#shortanswerlist').css('display', 'none');
            $('#longquestionlist').css('display', 'none');

        }
        if ($(this).val() === 'ShortAnswerlist') {
            $('#shortanswerlist').css('display', 'block');
            $('#truelist').css('display', 'none');
            $('#longquestionlist').css('display', 'none');
            $('#mcqlist').css('display', 'none');
        }
        if ($(this).val() === 'True/Falselist') {
            $('#truelist').css('display', 'block');
            $('#mcqlist').css('display', 'none');
            $('#shortanswerlist').css('display', 'none');
            $('#longquestionlist').css('display', 'none');

        }
    });
</script>

<!-- Deepika -->
<script>
    $(document).ready(function () {
        $(document).on('hidden.bs.modal', function () {
            // const form = this.querySelector('.reset');

            // form.reset();
            const form_count = document.querySelectorAll('form.reset');
            for (let index = 0; index < form_count.length; index++) {

                reinitializeSelect2(".js-select1");
                $("form.reset .js-select1").val('');
                $('.reset')[index].reset();
                $('#result').val("");
                calcQuestionType("result");

            }

        })

    })

    function gencre(id) {

        // event.preventDefault(); // Prevent default form action
        if (id == "1") {
            var long_qname = $("#long_qname").val();
            if (long_qname == '') {
                swal.fire("Please Enter the Question Name", "", "error");
                return false;
            }
            var long_quistion = $("#long_quistion").val();
            if (long_quistion == '') {
                swal.fire("Please Enter the Question Description", "", "error");
                return false;
            }
            var keyword_long = $("#keyword_long").val();
            if (keyword_long == '') {
                swal.fire("Please Enter the Question Keywords", "", "error");
                return false;
            }
            var long_points = $("#long_points").val();
            if (long_points == '') {
                swal.fire("Please Enter the Question Points", "", "error");
                return false;
            } else {
                //$('#savebutton').css('pointer-events', 'none');
                $('#savebutton').prop('disabled', true);
                document.getElementById('longcreateform').submit();
                document.getElementById('truelist').scrollIntoView({
                    behavior: 'smooth'
                }); // Scroll to the question-row

            }


        }
        if (id == "longedit") {


            var long_qnameedit = $("#long_qnameedit").val();
            if (long_qnameedit == '') {
                swal.fire("Please Enter the Question Name", "", "error");
                return false;
            }
            var long_quistionedit = $("#long_quistionedit").val();
            if (long_quistionedit == '') {
                swal.fire("Please Enter the Question Description", "", "error");
                return false;
            }
            var keyword_longedit = document.querySelectorAll('#keyword_longedit');
            var keyword_key = 0;
            for (const long_edit of keyword_longedit) {
                if (keyword_key != 0 && long_edit.value == '') {
                    swal.fire("Please Enter the Question Keywords", "", "error");
                    return false;
                }
                keyword_key++;

            }
            // if (keyword_longedit == '') {
            //     swal.fire("Please Enter the Question Keywords", "", "error");
            //     return false;
            // }
            var long_pointsedit = $("#long_pointsedit").val();
            if (long_pointsedit == '') {
                swal.fire("Please Enter the Question Points", "", "error");
                return false;
            } else {
                document.getElementById('longedit_form').submit();
            }
        }
        if (id == "2") {
            var short_qname = $("#short_qname").val();
            if (short_qname == '') {
                swal.fire("Please Enter the Question Name", "", "error");
                return false;
            }
            var short_quistion = $("#short_quistion").val();
            if (short_quistion == '') {
                swal.fire("Please Enter the Question Description", "", "error");
                return false;
            }
            var keyword_short = $("#keyword_short").val();
            if (keyword_short == '') {
                swal.fire("Please Enter the Question Keywords", "", "error");
                return false;
            }
            var short_points = $("#short_points").val();
            if (short_points == '') {
                swal.fire("Please Enter the Question Points", "", "error");
                return false;
            } else {
                // $('#savebutton').css('pointer-events', 'none');
                $('#savebutton').prop('disabled', true);

                document.getElementById('shortcreateform').submit();
            }
        }
        if (id == "shortedit") {
            var short_qnameedit = $("#short_qnameedit").val();
            if (short_qnameedit == '') {
                swal.fire("Please Enter the Question Name", "", "error");
                return false;
            }
            var short_quistionedit = $("#short_quistionedit").val();
            if (short_quistionedit == '') {
                swal.fire("Please Enter the Question Description", "", "error");
                return false;
            }
            var keyword_shortedit = document.querySelectorAll('#keyword_shortedit');
            var keyword_key = 0;
            for (const short_edit of keyword_shortedit) {
                if (keyword_key != 0 && short_edit.value == '') {
                    swal.fire("Please Enter the Question Keywords", "", "error");
                    return false;
                }
                keyword_key++;

            }
            // if (keyword_longedit == '') {
            //     swal.fire("Please Enter the Question Keywords", "", "error");
            //     return false;
            // }
            var short_pointsedit = $("#short_pointsedit").val();
            if (short_pointsedit == '') {
                swal.fire("Please Enter the Question Points", "", "error");
                return false;
            } else {
                document.getElementById('shortedit_form').submit();
            }

        }
        if (id == "3") {
            var mcq_qname = $("#mcq_qname").val();
            if (mcq_qname == '') {
                swal.fire("Please Enter the Question Name", "", "error");
                return false;
            }
            var mcq_quistion = $("#mcq_quistion").val();
            if (mcq_quistion == '') {
                swal.fire("Please Enter the Question Description", "", "error");
                return false;
            }
            var keyword_mcq = $("#keyword_mcq").val();
            if (keyword_mcq == '') {
                swal.fire("Please Enter the Choices", "", "error");
                return false;
            }
            var mcq_correct_choices = $("#mcq_correct_choices").val();
            if (mcq_correct_choices == '') {
                swal.fire("Please Select the Choices", "", "error");
                return false;
            }

            var mcq_points = $("#mcq_points").val();
            if (mcq_points == '') {
                swal.fire("Please Enter the Question Points", "", "error");
                return false;
            } else {
                //$('#savebutton').css('pointer-events', 'none');
                $('#savebutton').prop('disabled', true);

                document.getElementById('mcqcreateform').submit();
            }
        }
        if (id == "mcqedit") {
            var keyword_mcqedit = $("#keyword_mcqedit").val();
            if (keyword_mcqedit == '') {
                swal.fire("Please Enter the Choices", "", "error");
                return false;
            }
            document.getElementById('mcqedit_form').submit();
        }

        if (id == "4") {
            var true_qname = $("#true_qname").val();
            if (true_qname == '') {
                swal.fire("Please Enter the Question Name", "", "error");
                return false;
            }
            var true_quistion = $("#true_quistion").val();
            if (true_quistion == '') {
                swal.fire("Please Enter the Question Description", "", "error");
                return false;
            }
            const input_array = document.querySelectorAll('#answer');
            let AnswerSelected = false;
            for (let row of input_array) {
                if (row.checked === true) {
                    AnswerSelected = true;
                }
            }
            if (AnswerSelected === false) {

                swal.fire("Please Select the Answer", "", "error");
                return false;
            }
            var true_points = $("#true_points").val();
            if (true_points == '') {
                swal.fire("Please Enter the Question Points", "", "error");
                return false;
            } else {
                // $('#savebutton').css('pointer-events', 'none');
                $('#savebutton').prop('disabled', true);

                document.getElementById('truecreateform').submit();
            }
        }
        if (id == "truedit") {
            var true_qnameedit = $("#true_qnameedit").val();
            if (true_qnameedit == '') {
                swal.fire("Please Enter the Question Name", "", "error");
                return false;
            }
            var true_quistionedit = $("#true_quistionedit").val();
            if (true_quistionedit == '') {
                swal.fire("Please Enter the Question Description", "", "error");
                return false;
            }
            const input_array = document.querySelectorAll('#answer_edit');
            let AnswerSelected = false;
            for (let row of input_array) {
                if (row.checked === true) {
                    AnswerSelected = true;
                }
            }
            if (AnswerSelected === false) {

                swal.fire("Please Select the Answer", "", "error");
                return false;
            }
            var true_pointsedit = $("#true_pointsedit").val();
            if (true_pointsedit == '') {
                swal.fire("Please Enter the Question Name", "", "error");
                return false;
            } else {
                document.getElementById('trueedit_form').submit();
            }
        }
        if (id == "5") {

            var quiz_name = $("#q_name").val();
            if (quiz_name == '') {
                swal.fire("Please Enter the Quiz Name", "", "error");
                return false;
            }
            var quiz_question = $("#quiz_question").val();
            if (quiz_question == '') {
                swal.fire("Please Select the  Quiz Question", "", "error");
                return false;
            } else {
                //$('#savebutton').css('pointer-events', 'none');
                $('#savebutton').prop('disabled', true);

                document.getElementById('quizcreate_form').submit();
            }

        }
        if (id == "quizedit") {

            var q_nameedit = $("#q_nameedit").val();
            if (q_nameedit == '') {
                swal.fire("Please Enter the Quiz Name", "", "error");
                return false;
            }
            var quiz_questionedit = $("#quiz_questionedit").val();
            if (quiz_questionedit == '') {
                swal.fire("Please Select the Quiz Question", "", "error");
                return false;
            } else {
                document.getElementById('quizedit_form').submit();
            }
        }


    }
</script>
<!-- end create -->
<!-- addquiz function -->


<!-- end create -->
<!-- edit function of long -->
<div class="modal fade" id="addModal3">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="POST" id="longedit_form" action="{{route('elearningquestion.long_update', 1)}}"
                enctype="multipart/form-data" class="reset">
                @csrf

                <input type="hidden" name="eid" class="eid" id="eid">

                <div class="modal-header mh">
                    <h4 class="modal-title">Edit Long Question:</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <!-- Long question -->

                <div class=" container edit  longquestion">
                    <h4 class="modal-title long">Long Question:</h4>

                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Question Tag:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default comma" id="long_qnameedit"
                                    name="long_qnameedit" autocomplete="off">
                            </div>
                            <div class="col-md-1"></div>
                        </div>



                    </div>
                    <div class="col-md-1"></div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Question:<span class="error-star" style="color:red;">*</span></label>
                                <div class="col-md-10">
                                    <textarea id="long_quistionedit" class="long_quistionedit" name="long_quistionedit"
                                        autocomplete="off"></textarea>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>

                    <div class="check_tab">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label>Keywords:<span class="error-star" style="color:red;">*</span></label>

                                    <div class="wordquestion">

                                        <table class="_table">

                                            <tbody id="table_long_edit">
                                                <tr>

                                                    <td>
                                                        <input type="text" class="form-control default"
                                                            id="keyword_longedit" name="keyword_longedit[]"
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
                                                                onclick="create_tr('table_long_edit')">
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

                            <div class="col-md-1"></div>

                        </div>

                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Points: <span class="error-star" style="color:red;">*</span></label>
                                    <input type="text" class="form-control default" id="long_pointsedit"
                                        name="long_pointsedit" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <button class="btn btn-success btn-space" type="button" onclick="gencre('longedit')"
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
<!-- show function of long -->
<div class="modal fade" id="addModal4">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="" id="longshow" enctype="multipart/form-data">

                {{ csrf_field() }}

                <input type="hidden" name="eidshow" class="eidshow" id="eidshow">

                <div class="modal-header mh">
                    <h4 class="modal-title">Show Long Question</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <!-- <div class="modal-body" style="background-color: #f8fffb !important;">


                

                </div> -->

            </form>

            <!-- Long question -->

            <div class=" container show  longquestion">
                <h4 class="modal-title long">Long Question:</h4>
                <form method="POST" class="longqustionsform">

                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Question Tag:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default comma" id="long_qnameshow"
                                    name="long_qnameshow" style="background-color: #e9ecef !important;">
                            </div>
                            <div class="col-md-1"></div>
                        </div>



                    </div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Question:<span class="error-star" style="color:red;">*</span></label>
                                <div>
                                    <textarea id="long_quistionshow" class="long_quistionshow" name="long_quistionshow"
                                        style="background-color: #e9ecef !important;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="check_tab">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Keywords:<span class="error-star" style="color:red;">*</span></label>
                                    <div class="wordquestion">
                                        <textarea class="form-control default" id="keyword_longshow"
                                            name="keyword_longshow"
                                            style="background-color: #e9ecef !important;"></textarea>

                                    </div>
                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Points:<span class="error-star" style="color:red;">*</span></label>
                                    <input type="text" class="form-control default" id="long_pointsshow"
                                        name="long_pointsshow" style="background-color: #e9ecef !important;">
                                </div>
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
<!-- show function of short -->
<div class="modal fade" id="addModalshortshow">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="" id="shortshow" enctype="multipart/form-data">

                {{ csrf_field() }}

                <input type="hidden" name="short_show" class="short_show" id="short_show">

                <div class="modal-header mh">
                    <h4 class="modal-title">Show Short Question</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <!-- <div class="modal-body" style="background-color: #f8fffb !important;">


                

                </div> -->

            </form>

            <!-- Long question -->

            <div class=" container show  longquestion">
                <h4 class="modal-title long">Short Question:</h4>
                <form method="POST" class="longqustionsform">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Question Tag:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="short_qnameshow"
                                    name="short_qnameshow" style="background-color: #e9ecef !important;">
                            </div>
                        </div>



                    </div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Question:<span class="error-star" style="color:red;">*</span></label>
                                <div classs="col-md-10">
                                    <textarea id="short_quistionshow" class="short_quistionshow"
                                        name="short_quistionshow"
                                        style="background-color: #e9ecef !important;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>

                    <div class="check_tab">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Keywords:<span class="error-star" style="color:red;">*</span></label>
                                    <div class="wordquestion">
                                        <textarea class="form-control default" id="keyword_shortshow"
                                            name="keyword_shortshow"
                                            style="background-color: #e9ecef !important;"></textarea>


                                    </div>
                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Points:<span class="error-star" style="color:red;">*</span></label>
                                    <input type="text" class="form-control default" id="short_pointsshow"
                                        name="short_pointsshow" style="background-color: #e9ecef !important;">
                                </div>
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
<!-- edit -->
<!-- Edit quiz -->
<div class="modal fade" id="addModaleditquiz">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="POST" id="quizedit_form" action="{{route('elearning.quiz_update', 1)}}"
                enctype="multipart/form-data">
                {{ csrf_field() }}

                <input type="hidden" name="quiz_edit" class="quiz_edit" id="quiz_edit">

                <div class="modal-header mh">
                    <h4 class="modal-title">Edit Quiz</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" style="background-color: #f8fffb !important;">
                    <input type="hidden" class="form-control" id="user_id" name="user_id" value="">
                    <input type="hidden" class="form-control" id="user_details" name="user_details" value="general">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Quiz Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default comma" id="q_nameedit" name="q_nameedit">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Quiz Question:<span class="error-star" style="color:red;">*</span></label>
                                <select class="js-select1 quizq_edit quiz_questionedit" id="quiz_questionedit"
                                    name="quiz_questionedit[]" multiple="multiple" onchange="dataedit();">
                                    <option value="" data-badge="">Select Quiz Question</option>
                                    @foreach($rows['rows']['quiz_question'] as $key => $row)

                                        <option value="{{ $row['question_id'] }}">{{ $row['name'] }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 ">
                            <div class="form-group">
                                <label>Total Points:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="q_pointsedit" name="q_pointsedit"
                                    autocomplete="off">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <button class="btn btn-success btn-space" type="button" onclick="gencre('quizedit')"
                                id="savebutton">Update</button>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </div>

            </form>
        </div>




    </div>

</div>


<!-- end  -->
<!-- Show Quiz -->

<div class="modal fade" id="addModalshowquiz">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="" id="quizshow_form" enctype="multipart/form-data">
                {{ csrf_field() }}

                <input type="hidden" name="quiz_show" class="quiz_show" id="quiz_show">

                <div class="modal-header mh">
                    <h4 class="modal-title">Show Quiz</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" style="background-color: #f8fffb !important;">
                    <input type="hidden" class="form-control" id="user_id" name="user_id" value="">
                    <input type="hidden" class="form-control" id="user_details" name="user_details" value="general">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Quiz Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="q_nameshow" name="q_nameshow"
                                    style="background-color: #e9ecef !important;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Quiz Question:<span class="error-star" style="color:red;">*</span></label>
                                <select class="js-select1 quiz_questionshow" id="quiz_questionshow"
                                    name="quiz_questionshow[]" multiple="multiple"
                                    style="background-color: #e9ecef !important;">
                                    <option value="" data-badge="">Select Quiz Question</option>
                                    @foreach($rows['rows']['quiz_question'] as $key => $row)

                                        <option value="{{ $row['question_id'] }}">{{ $row['name'] }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Total Points:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="q_pointsshow" name="q_pointsshow"
                                    autocomplete="off" style="background-color: #e9ecef !important;">
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
<!-- end show quiz -->
<!-- editshort Answer -->
<div class="modal fade" id="addModalshortedit">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="POST" id="shortedit_form" action="{{route('elearningquestion.short_update', 1)}}"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="short_edit" class="short_edit" id="short_edit">

                <div class="modal-header mh">
                    <h4 class="modal-title">Edit Short Question</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>



                <!-- short answer -->
                <div class="card longquestion">
                    <h4 class="modal-title short">Short Question:</h4>

                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Question Tag:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default comma" id="short_qnameedit"
                                    name="short_qnameedit" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Question:<span class="error-star" style="color:red;">*</span></label>
                                <div class="col-md-10">
                                    <textarea id="short_quistionedit" class="short_quistionedit"
                                        name="short_quistionedit" autocomplete="off"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <!-- <h style="color:black"><b>Address:</b></h> -->
                    <div class="check_tab">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label>Keywords:<span class="error-star" style="color:red;">*</span></label>
                                    <div class="wordquestion">

                                        <table class="_table">

                                            <tbody id="table_short_edit">
                                                <tr>

                                                    <td>
                                                        <input type="text" class="form-control default"
                                                            id="keyword_shortedit" name="keyword_shortedit[]"
                                                            autocomplete="off">
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

                                        <div class="action_container">
                                            <button class="success" type="button"
                                                onclick="create_tr('table_short_edit')">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div class="col-md-1"></div>

                        </div>


                    </div>


                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Points:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="short_pointsedit"
                                    name="short_pointsedit" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <button class="btn btn-success btn-space" type="button" onclick="gencre('shortedit')"
                                id="savebutton">Update</button>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>

                </div>
            </form>
            <!-- end -->

        </div>
    </div>
</div>
<!-- edit end -->

<!-- edit for mcq -->
<div class="modal fade" id="addModalmcqedit">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="POST" id="mcqedit_form" action="{{route('elearningquestion.mcq_update', 1)}}"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="mcq_edit" class="mcq_edit" id="mcq_edit">


                <div class="modal-header mh">
                    <h4 class="modal-title">Edit MCQ</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>



                <!-- Mcq -->
                <div class="card longquestion">
                    <h4 class="modal-title mcq">Multiple Choice Question:</h4>


                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Question Tag:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default comma" id="mcq_qnameedit"
                                    name="mcq_qnameedit" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Question:<span class="error-star" style="color:red;">*</span></label>
                                <div class="col-md-10">
                                    <textarea id="mcq_quistionedit" class="mcq_quistionedit" name="mcq_quistionedit"
                                        autocomplete="off"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <!-- <h style="color:black"><b>Address:</b></h> -->
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Choices:<span class="error-star" style="color:red;">*</span></label>

                                <div class="wordquestion">

                                    <table class="_table">

                                        <tbody id="table_mcq_edit">
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control default" id="keyword_mcqedit"
                                                        name="keyword_mcqedit[]" autocomplete="off">

                                                </td>
                                                <td>
                                                    <div class="action_container">
                                                        <button class="danger" onclick="remove_tr(this)">
                                                            <i class="fa fa-close"></i>
                                                        </button>
                                                    </div>

                                                </td>

                                                <div class="action_container" width="50px">
                                                    <button class="success" type="button"
                                                        onclick="create_tr('table_mcq_edit')">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>

                                            </tr>

                                        </tbody>


                                    </table>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Correct Choices:<span class="error-star" style="color:red;">*</span></label>
                                <br>
                                <select class="js-select2 mcq_correct_choicesedit" id="mcq_correct_choicesedit"
                                    name="mcq_correct_choicesedit[]" multiple="multiple" autocomplete="off">

                                    <option value="" data-badge="">Select Correct Choices</option>
                                    <!-- <option value="Valuation always depends on the fact that who is valuing what" data-badge="">crt</option> -->




                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Points: <span class="error-star" style="color:red;">*</span></label>
                                <input type="number" class="form-control default" id="mcq_pointsedit"
                                    name="mcq_pointsedit" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <button class="btn btn-success btn-space" type="button" onclick="gencre('mcqedit')"
                                id="savebutton">Update</button>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
            </form>
        </div>
        <!-- end -->

    </div>
</div>
</div>

<!-- show for mcq -->
<div class="modal fade" id="addModalmcqshow">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="" id="mcqshow" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="mcq_show" class="mcq_show" id="mcq_show">


                <div class="modal-header mh">
                    <h4 class="modal-title">Show MCQ</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>


                <!-- Mcq -->
                <div class="card longquestion">
                    <h4 class="modal-title mcq">Multiple Choice Question:</h4>


                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Question Tag:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="mcq_qnameshow" name="mcq_qnameshow"
                                    autocomplete="off" style="background-color: #e9ecef !important;">
                            </div>
                        </div>
                        <div class="col-md-1"></div>

                    </div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Question:<span class="error-star" style="color:red;">*</span></label>
                                <div class="col-md-10">
                                    <textarea id="mcq_quistionshow" class="mcq_quistionshow" name="mcq_quistionshow"
                                        autocomplete="off" style="background-color: #e9ecef !important;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <!-- <h style="color:black"><b>Address:</b></h> -->
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Choices:<span class="error-star" style="color:red;">*</span></label>
                                <div class="wordquestion">
                                    <textarea class="form-control default" id="keyword_mcqshow" name="keyword_mcqshow"
                                        style="background-color: #e9ecef !important;"></textarea>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Correct Choices:<span class="error-star" style="color:red;">*</span></label>
                                <br>
                                <textarea type="text" class="form-control default mcq_correct_choicesshow"
                                    id="mcq_correct_choicesshow" name="mcq_correct_choicesshow"
                                    style="background-color: #e9ecef !important;"></textarea>

                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Points: <span class="error-star" style="color:red;">*</span></label>
                                <input type="number" class="form-control default" id="mcq_pointsshow"
                                    name="mcq_pointsshow" autocomplete="off"
                                    style="background-color: #e9ecef !important;">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- end -->

    </div>
</div>
</div>

<!-- Edit True/False -->
<div class="modal fade" id="addModaltrueedit">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">


            <form method="POST" id="trueedit_form" action="{{route('elearningquestion.true_update', 1)}}"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="true_edit" class="true_edit" id="true_edit">

                <div class="modal-header mh">
                    <h4 class="modal-title">Edit True/False</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>



                <!-- short answer -->
                <div class=" card longquestion">
                    <h4 class="modal-title true">True/false:</h4>


                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Question Tag:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default comma" id="true_qnameedit"
                                    name="true_qnameedit" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Question:<span class="error-star" style="color:red;">*</span></label>
                                <div class="col-md-10">
                                    <textarea id="true_quistionedit" class="true_quistionedit" name="true_quistionedit"
                                        autocomplete="off"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <!-- <h style="color:black"><b>Address:</b></h> -->
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Answer:<span class="error-star" style="color:red;">*</span></label>

                                <!-- <input type="text" class="form-control default" id="answer" name="answer"> -->
                                <div>
                                    <input type="radio" class="answer_edit_on" id="answer_edit" value="on"
                                        name="answer_edit" required />
                                    <label for="answer">True</label>
                                </div>
                                <div>
                                    <input type="radio" class="answer_edit_off" id="answer_edit" value="off"
                                        name="answer_edit" required />
                                    <label for="answer">False</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Points: <span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="true_pointsedit"
                                    name="true_pointsedit" autocomplete="off">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <button class="btn btn-success btn-space" type="button" onclick="gencre('truedit')"
                                id="savebutton">Update</button>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
            </form>
        </div>
        <!-- end -->

    </div>
</div>
</div>
<!-- end -->
<!-- show for true/false -->
<div class="modal fade" id="addModaltrueshow">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">


            <form method="" id="trueshow_form" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="true_show" class="true_show" id="true_show">

                <div class="modal-header mh">
                    <h4 class="modal-title">Show True/False</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>



                <!-- short answer -->
                <div class=" card longquestion">
                    <h4 class="modal-title true">True/false:</h4>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Question Tag:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="true_qnameshow"
                                    name="true_qnameshow" style="background-color: #e9ecef !important;">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Question:<span class="error-star" style="color:red;">*</span></label>
                                <div class="col-md-10">
                                    <textarea id="true_quistionshow" class="true_quistionshow" name="true_quistionshow"
                                        style="background-color: #e9ecef !important;"></textarea>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- <h style="color:black"><b>Address:</b></h> -->
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Answer:<span class="error-star" style="color:red;">*</span></label>

                                <!-- <input type="text" class="form-control default" id="answer" name="answer"> -->
                                <div>
                                    <input type="radio" class="answer_show_on" id="answer_show" name="answer_show"
                                        required />
                                    <label for="answer">True</label>
                                </div>
                                <div>
                                    <input type="radio" class="answer_show_off" id="answer_show" name="answer_show"
                                        required />
                                    <label for="answer">False</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Points: <span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="true_pointsshow"
                                    name="true_pointsshow" style="background-color: #e9ecef !important;">
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
        <!-- end -->

    </div>
</div>


<!-- edit quiz -->

<!-- end -->

<script>
    function fetch_update(id, type) {



        $.ajax({
            url: "{{ url('/elearning/question_long/fetch') }}",
            type: 'GET',
            data: {
                'id': id,
                'type': type,
                _token: '{{csrf_token()}}'

            },

            success: function (data) {
                // correct_choices = data.rows[0]['correct_choices'].split(',');

                console.log(data.rows);

                if (type == "longedit") {
                    $('#table_long_edit tr:not(:first)').remove();
                    $('#long_qnameedit').val(data.rows[0]['question_name']);
                    $('#long_quistionedit').val(data.rows[0]['question']);
                    const keyarray = data.rows[0]['keywords'].split(',');
                    console.log(keyarray, "actual_data");
                    for (const keyobject of keyarray) {
                        let table_body2 = document.getElementById('table_long_edit');
                        first_tr = table_body2.firstElementChild
                        tr_clone = first_tr.cloneNode(true);
                        tr_clone.firstElementChild.firstElementChild.value = keyobject;
                        tr_clone.querySelector('input').setAttribute("readonly", "");
                        table_body2.append(tr_clone);

                        clean_first_tr(table_body2.firstElementChild);
                    }

                    $('#long_pointsedit').val(data.rows[0]['points']);
                    $('#eid').val(data.rows[0]['question_id']);

                } else if (type == "longshow") {
                    $('#long_qnameshow').val(data.rows[0]['question_name']);
                    $('#long_quistionshow').val(data.rows[0]['question']);
                    // $('#keyword_longshow').val(data.rows[0]['keywords']);
                    let choices = data.rows[0]['keywords'];
                    const pieces = choices.split(',');
                    const result = pieces.join(', \n ');
                    $('#keyword_longshow').html(result);
                    $('#long_pointsshow').val(data.rows[0]['points']);
                    $('#eidshow').val(data.rows[0]['id']);

                    $('#long_qnameshow').prop('disabled', true);
                    $('#long_quistionshow').prop('disabled', true);
                    $('#keyword_longshow').prop('disabled', true);
                    $('#long_pointsshow').prop('disabled', true);

                    $('#eidshow').attr('Action', '');


                } else if (type == "shortedit") {
                    $('#table_short_edit tr:not(:first)').remove();
                    $('#short_qnameedit').val(data.rows[0]['question_name']);
                    $('#short_quistionedit').val(data.rows[0]['question']);
                    const keyarray = data.rows[0]['keywords'].split(',');
                    console.log(keyarray, "actual_data");
                    for (const keyobject of keyarray) {
                        let table_body2 = document.getElementById('table_short_edit');
                        first_tr = table_body2.firstElementChild
                        tr_clone = first_tr.cloneNode(true);
                        tr_clone.firstElementChild.firstElementChild.value = keyobject;
                        tr_clone.querySelector('input').setAttribute("readonly", "");
                        table_body2.append(tr_clone);

                        clean_first_tr(table_body2.firstElementChild);
                    }

                    $('#short_pointsedit').val(data.rows[0]['points']);
                    $('#short_edit').val(data.rows[0]['question_id']);

                } else if (type == "shortshow") {

                    $('#short_qnameshow').val(data.rows[0]['question_name']);
                    $('#short_quistionshow').val(data.rows[0]['question']);
                    // $('#keyword_shortshow').val(data.rows[0]['keywords']);
                    let choices = data.rows[0]['keywords'];
                    const pieces = choices.split(',');
                    const result = pieces.join(', \n ');
                    $('#keyword_shortshow').html(result);
                    $('#short_pointsshow').val(data.rows[0]['points']);
                    $('#short_show').val(data.rows[0]['id']);

                    $('#short_qnameshow').prop('disabled', true);
                    $('#short_quistionshow').prop('disabled', true);
                    $('#keyword_shortshow').prop('disabled', true);
                    $('#short_pointsshow').prop('disabled', true);

                    $('#short_show').attr('Action', '');


                } else if (type == "mcqedit") {
                    $('#table_mcq_edit tr:not(:first)').remove();
                    $('#mcq_qnameedit').val(data.rows[0]['question_name']);
                    $('#mcq_quistionedit').val(data.rows[0]['question']);
                    const keyarray = data.rows[0]['choices'].split(',');
                    console.log(keyarray, "actual_data");
                    for (const keyobject of keyarray) {
                        let table_body2 = document.getElementById('table_mcq_edit');
                        first_tr = table_body2.firstElementChild
                        tr_clone = first_tr.cloneNode(true);
                        tr_clone.firstElementChild.firstElementChild.value = keyobject;

                        tr_clone.querySelector('input').setAttribute("readonly", "");
                        table_body2.append(tr_clone);

                        clean_first_tr(table_body2.firstElementChild);
                    }

                    const correctChoices = data.rows[0]['correct_choices'].split(',');

                    $('#mcq_correct_choicesedit').children().remove();
                    // Append the correct choices to the dropdown
                    const all_options = data.rows[0]['choices'].split(',');
                    for (const all_option of all_options) {
                        const isSelected = correctChoices.includes(all_option) ? 'selected' : '';
                        const option = `<option value="${all_option}" ${isSelected}>${all_option}</option>`;
                        // const option1 = `<option value="${keyobject}">${keyobject}</option>`;
                        $('#mcq_correct_choicesedit').append(option);
                        // $('#mcq_correct_choicesedit').append(option1);

                    }
                    // Trigger change event to update Select2
                    $('.mcq_correct_choicesedit').trigger('change');
                    console.log(data.rows[0]['correct_choices'].split(','));
                    setTimeout(() => {

                        $('.mcq_correct_choicesedit').val(data.rows[0]['correct_choices'].split(',')).trigger("change");

                    }, 300);


                    $('#mcq_pointsedit').val(data.rows[0]['points']);

                    $('#mcq_edit').val(data.rows[0]['question_id']);

                } else if (type == "mcqshow") {

                    $('#mcq_qnameshow').val(data.rows[0]['question_name']);
                    $('#mcq_quistionshow').val(data.rows[0]['question']);

                    //$('#keyword_mcqshow').val(data.rows[0]['choices']);  
                    let choices = data.rows[0]['choices'];
                    const pieces = choices.split(',');
                    const result = pieces.join(', \n ');
                    $('#keyword_mcqshow').html(result);


                    // $('.mcq_correct_choicesshow').val(data.rows[0]['correct_choices']);
                    let crtchoices = data.rows[0]['correct_choices'];
                    const crtpieces = crtchoices.split(',');
                    const crtresult = crtpieces.join(', \n ');
                    $('.mcq_correct_choicesshow').html(crtresult);

                    $('#mcq_pointsshow').val(data.rows[0]['points']);
                    $('#mcq_show').val(data.rows[0]['id']);

                    $('#mcq_qnameshow').prop('disabled', true);
                    $('#mcq_quistionshow').prop('disabled', true);
                    $('#keyword_mcqshow').prop('disabled', true);
                    $('.mcq_correct_choicesshow').prop('disabled', true);
                    $('#mcq_pointsshow').prop('disabled', true);

                    $('#mcq_show').attr('Action', '');


                } else if (type == "trueedit") {

                    $('#true_qnameedit').val(data.rows[0]['question_name']);
                    $('#true_quistionedit').val(data.rows[0]['question']);
                    if (data.rows[0]['answer'] == "on") {
                        $('.answer_edit_on').prop('checked', true)

                    } else {
                        $('.answer_edit_off').prop('checked', true)

                    }
                    $('#answer_edit').val(data.rows[0]['answer']);
                    $('#true_pointsedit').val(data.rows[0]['points']);
                    $('#true_edit').val(data.rows[0]['question_id']);
                } else if (type == "trueshow") {
                    $('#true_qnameshow').val(data.rows[0]['question_name']);
                    $('#true_quistionshow').val(data.rows[0]['question']);
                    if (data.rows[0]['answer'] == "on") {
                        $('.answer_show_on').prop('checked', true)

                    } else {
                        $('.answer_show_off').prop('checked', true)

                    }
                    $('#answer_show').val(data.rows[0]['answer']);
                    $('#true_pointsshow').val(data.rows[0]['points']);
                    $('#true_show').val(data.rows[0]['id']);

                    $('#true_qnameshow').prop('disabled', true);
                    $('#true_quistionshow').prop('disabled', true);
                    $('#answer_show').prop('disabled', true);
                    $('#true_pointsshow').prop('disabled', true);

                    $('#true_show').attr('Action', '');

                } else if (type == "quizedit") {
                    //alert("cbjds");

                    $('#q_nameedit').val(data.rows[0]['quiz_name']);

                    $('.quiz_questionedit').val(data.rows[0]['quiz_questions'].split(','));
                    $('#q_pointsedit').val(data.rows[0]['points']);
                    $('#quiz_edit').val(data.rows[0]['quiz_id']);
                    reinitializeSelect2(".js-select1");

                    // $('.quiz_questionedit').val('1-long');

                    $('#q_pointsedit').prop('readonly', true);
                } else if (type == "quizshow") {


                    $('#q_nameshow').val(data.rows[0]['quiz_name']);

                    $('.quiz_questionshow').val(data.rows[0]['quiz_questions'].split(','));
                    // let choices = data.rows[0]['quiz_questions'];
                    // const pieces = choices.split(',');
                    // const result = pieces.join(', \n ');
                    // $('.quiz_questionshow').html(result);
                    $('#q_pointsshow').val(data.rows[0]['points']);
                    $('#quiz_show').val(data.rows[0]['quiz_id']);


                    $('#q_nameshow').prop('disabled', true);
                    $('#quiz_questionshow').prop('disabled', true);
                    $('#q_pointsshow').prop('disabled', true);
                    $('#quiz_show').attr('Action', '');
                    reinitializeSelect2(".js-select1");




                }
            }
        });



    }
</script>

<script>
    function delete1(id, tabletype) {

        Swal.fire({
            title: "Are you Sure,you want to Delete the Quiz?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Delete",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('/elearning/question_long/delete') }}",
                    type: 'GET',
                    data: {
                        'id': id,
                        'tabletype': tabletype,
                        _token: '{{csrf_token()}}'

                    },


                    success: function (data) {
                        console.log(data);
                        //exit();
                        if (data['data'] == 0) {
                            Swal.fire("Info!", data['message_cus'], "info", data['message_cus'])
                            return false
                        }

                        if (result.value) {
                            Swal.fire("Success!", data['message_cus'], "success").then((result) => {

                                location.replace(`/elearningquestion`);
                                setTimeout(function () {
                                    document.getElementById('quizlist').scrollIntoView({
                                        behavior: 'smooth'
                                    });
                                }, 500); // Delay before scrolling

                            })
                        }

                        // $('#long_qnameedit').val(data.rows[0]['question_name']);
                        // $('#long_quistionedit').val(data.rows[0]['question']);
                        // $('#keyword_longedit').val(data.rows[0]['keywords']);
                        // $('#long_pointsedit').val(data.rows[0]['points']);
                        // $('#eid').val(data.rows[0]['question_id']);






                    }
                });
            }
        })




    }
    // 
</script>
<style>
    .select2-container {
        min-width: 300px !important;
        display: unset !important;

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
        /* display: inline-block; */
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
        float: right;
        margin-top: 30px;
        font-weight: bold;

    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
<script>
    $(".js-select2").select2({
        closeOnSelect: false,
        placeholder: "Select Correct Choices",
        // allowHtml: true,
        allowClear: true,
        tags: true, // создает новые опции на лету
        language: {
            noResults: function () {
                return "No Choices Added";
            }
        }
    });
</script>
<script>
    function reinitializeSelect2(element) {
        if ($(element).data('select2')) {

            $(element).select2('destroy');
        }


        $(element).select2({
            closeOnSelect: false,
            placeholder: "Select Quiz Question",
            allowClear: true,
            tags: true,
            language: {
                noResults: function () {
                    return "No Question Added";
                }
            }
        });
    }


    $(document).ready(function () {
        // Call the reinitialization function after the select2 library is loaded
        $.getScript("https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js", function () {
            reinitializeSelect2(".js-select1");
        });
    });




    // document.querySelector("[type='number']").addEventListener("keypress", function(evt) {
    //     if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57 ||(evt.which === 46)) {
    //         //Math.trunc(evt);
    //         evt.preventDefault();

    //     }
    // });
</script>
<script>
    function data() {

        var id = $("select[id='quiz_question']").val();
        console.log(id);
        $.ajax({
            url: "{{ url('/elearning/question_quiz/get_points') }}",
            type: 'GET',
            data: {
                'id': id,
                _token: '{{csrf_token()}}'

            },
            success: function (data) {
                console.log(data);
                if (id == "") {
                    $('.quizpoints').css('display', 'none');

                } else {

                    $('.quizpoints').css('display', 'block');

                    $('#q_points').val(data);
                    $('#q_points').prop('readonly', true);



                }



            }

        })
        $('.select2-selection__clear').on('click', function () {
            $('.quizpoints').css('display', 'none');

        });



    }

    function dataedit() {

        var id = $("select[id='quiz_questionedit']").val();
        console.log(id);
        $.ajax({
            url: "{{ url('/elearning/question_quiz/get_points') }}",
            type: 'GET',
            data: {
                'id': id,
                _token: '{{csrf_token()}}'

            },
            success: function (data) {
                console.log(data);

                $('#q_pointsedit').val(data);




            }

        })
        $('.select2-selection__clear').on('click', function () {
            $('.quizpoints').css('display', 'none');

        });



    }
</script>

<script>
    function resetSelect2() {
        // Get the Select2 element by its ID
        // $(".js-select1").empty();
        $(".js-select2").empty();


    }
    $('.close').on('click', function () {
        resetSelect2();
    });
</script>

<script>
    document.querySelector("[name='short_points']").addEventListener("keypress", function (evt) {
        if ((evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57) || (evt.which === 46)) {
            evt.preventDefault();
        }
    });
    document.querySelector("[name='short_pointsedit']").addEventListener("keypress", function (evt) {
        if ((evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57) || (evt.which === 46)) {
            evt.preventDefault();
        }
    });


    document.querySelector("[name='long_points']").addEventListener("keypress", function (evt) {
        if ((evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)) {
            evt.preventDefault();
        }
    });
    document.querySelector("[name='long_pointsedit']").addEventListener("keypress", function (evt) {
        if ((evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57)) {
            evt.preventDefault();
        }
    });

    document.querySelector("[name='true_points']").addEventListener("keypress", function (evt) {
        if ((evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57) || (evt.which === 46)) {
            evt.preventDefault();
        }
    });
    document.querySelector("[name='true_pointsedit']").addEventListener("keypress", function (evt) {
        if ((evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57) || (evt.which === 46)) {
            evt.preventDefault();
        }
    });

    document.querySelector("[name='mcq_points']").addEventListener("keypress", function (evt) {
        if ((evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57) || (evt.which === 46)) {
            evt.preventDefault();
        }
    });
    document.querySelector("[name='mcq_pointsedit']").addEventListener("keypress", function (evt) {
        if ((evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57) || (evt.which === 46)) {
            evt.preventDefault();
        }
    });
    document.querySelector(".comma").addEventListener("keypress", function (evt) {
        var charCode = evt.which || evt.keyCode;
        var charStr = String.fromCharCode(charCode);

        if (/[\.,\/;:`]/.test(charStr)) {
            evt.preventDefault(); // Prevent entering the character
        }
    });
</script>




@endsection