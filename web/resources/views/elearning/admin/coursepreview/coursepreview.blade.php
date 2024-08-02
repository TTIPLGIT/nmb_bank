@extends('layouts.adminnav')

@section('content')
<style>
    input[type=checkbox] {
        display: inline-block;
    }

    div#align1_filter {
        float: right;
    }

    div#align1_length {
        position: relative;
        top: 15px;
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
        padding-left: 5px !important;
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


    /* div#chartContainer {
    
    display: flex;
    justify-content: flex-start;

} */

    .canvasjs-chart-container {

        position: relative;
        text-align: center;
        cursor: auto;
        direction: ltr;

    }

    .modal-body {
        padding-top: 15px;
        height: 439px;
    }

    .canvasjs-chart-container {

        position: relative;
        text-align: left;
        cursor: auto;
        direction: ltr;
        display: flex;
        justify-content: center;
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
    <section>
    <div class="row justify-content-center">

        <div class="col-lg-12 col-md-12">
            <div class="" style="height:100%; ">{{ Breadcrumbs::render('Coursepreview') }}</a>

                <form method="POST" id="registration_form" enctype="multipart/form-data" onsubmit="return false">
                    @csrf

                    <div class="tile registration_tab" id="tile-1" style="margin-top:10px !important; margin-bottom:10px !important;">


                    </div>
                    <!-- Tab panes -->

                    <div id="content">
                        <section class="section">
                            <div class="section-body mt-0">

                                
                                <div class="col-md-12">
                                    <h2 style="margin-top:10px;">Course Preview:</h2>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-wrapper">
                                                <div class="table-responsive">
                                                    <table class="table  table-bordered table-striped" id="align1">
                                                        <thead>
                                                            <tr>
                                                                <th>S.No</th>
                                                                <th>Course Name</th>
                                                                <th>Enrolled List Count</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($rows['elearning_courses'] as $data)
                                                            <tr>
                                                                <td>{{$loop->iteration}}</td>
                                                                <td><a style="font-size:15px;" class="listcount" title="Create" href="" data-toggle="modal" data-target="#addModalquiz"> {{$data['course_name']}}</a></td>
                                                                <td>{{$data['total_student']}}</td>
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
                        </section>
                    </div>
                </form>
            </div>

        </div>

    </div>
    </section>
</div>
<div class="modal fade" id="addModalquiz">
    <div class="modal-dialog modal-lg">

        <div class="modal-content modalchart">

           

            <div class="modal-header mh">
                <h4 class="modal-title">Course-Status</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" style="background-color: #f8fffb !important;">
                <div class=" col-md-12 modal-chart">
                    <html>
                    <div id="chartContainer">
                    </div>

                    <script type="text/javascript">
                        window.onload = function() {
                            var chart = new CanvasJS.Chart("chartContainer", {

                                title: {
                                    text: "Course-Status"
                                },
                                data: [{
                                    type: "line",

                                    dataPoints: [{
                                            x: new Date(2012, 00, 1),
                                            y: 450
                                        },
                                        {
                                            x: new Date(2012, 01, 1),
                                            y: 414
                                        },
                                        {
                                            x: new Date(2012, 02, 1),
                                            y: 520
                                        },
                                        {
                                            x: new Date(2012, 03, 1),
                                            y: 460
                                        },
                                        {
                                            x: new Date(2012, 04, 1),
                                            y: 450
                                        },
                                        {
                                            x: new Date(2012, 05, 1),
                                            y: 500
                                        },
                                        {
                                            x: new Date(2012, 06, 1),
                                            y: 480
                                        },
                                        {
                                            x: new Date(2012, 07, 1),
                                            y: 480
                                        },
                                        {
                                            x: new Date(2012, 08, 1),
                                            y: 410
                                        },
                                        {
                                            x: new Date(2012, 09, 1),
                                            y: 500
                                        },
                                        {
                                            x: new Date(2012, 10, 1),
                                            y: 480
                                        },
                                        {
                                            x: new Date(2012, 11, 1),
                                            y: 510
                                        }
                                    ]
                                }]
                            });

                            chart.render();
                        }
                    </script>

                    </html>
                </div>
            </div>

          
        </div>




    </div>

</div>


<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>

<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

@endsection