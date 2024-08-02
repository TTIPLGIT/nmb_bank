@extends('layouts.adminnav')

@section('content')
<style>
    .input_custom {
        box-shadow: none !important;
        border-style: solid !important;
    }

    .input_custom2 {
        box-shadow: none !important;
        border-style: solid !important;
    }

    #tabs li a.nav-link {
        gap: 10px;
        display: flex;
        align-items: center;
    }

    #tabs {
        overflow: hidden;
        width: 100%;
        margin: 0;
        padding: 0;
        list-style: none;
        font-size: 16px !important;
    }

    .nav-tabs .nav-item.show .nav-link,
    .nav-tabs .nav-link.active {
        background: #25867d !important;
    }

    #tabs li {
        float: left;
        margin: 0 .5em 0 0;
    }

    .questions {
        color: #34395e !important;
        font-weight: 700;
        font-size: 20px;
    }

    #tabs a {
        position: relative;
        background: #25867d;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        padding: .4em 1.5em;
        float: left;
        text-decoration: none;
        color: #444;
        text-shadow: 0 1px 0 rgba(255, 255, 255, .8);
        border-radius: 5px 0 0 0;
        box-shadow: 0 2px 2px rgba(0, 0, 0, .4);
    }

    .nav-tabs .nav-link {
        border-color: #e9ecef #e9ecef #dee2e6 !important;

    }

    #tabs a:hover,
    #tabs a:hover::after,
    #tabs a:focus,
    #tabs a:focus::after {
        background: #25867d;
    }

    #tabs a:focus {
        outline: 0;
    }

    #tabs a::after {
        content: '';
        position: absolute;
        z-index: 1;
        top: 0;
        right: -.5em;
        bottom: 0;
        width: 1em;
        background: #25867d;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        box-shadow: 2px 2px 2px rgba(0, 0, 0, .4);
        transform: skew(10deg);
        border-radius: 0 5px 0 0;
    }

    .nav-justified {
        background-image: none;
    }

    #tabs #addition-tab::after {
        content: '';
        position: absolute;
        z-index: 1;
        top: 0;
        right: -.5em;
        bottom: 0;
        width: 1em;
        background: #25867d;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        box-shadow: 2px 2px 2px rgba(0, 0, 0, .4);
        transform: skew(10deg);
        border-radius: 0 5px 0 0;
    }

    #tabs #current a,
    #tabs #current a::after {
        background: #25867d;
        z-index: 3;
        color: white !important;
    }

    .tabs {
        overflow: hidden;
        width: 100%;
        margin: 0;
        padding: 0;
        list-style: none;
        font-size: 16px !important;
    }

    .tabs li {
        float: left;
        margin: 0 .5em 0 0;
    }

    .questions {
        color: #34395e !important;
        font-weight: 700;
        font-size: 20px;
    }

    .tabs a {
        color: #000000 !important;
        position: relative;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        padding: .4em 1.5em;
        float: left;
        text-decoration: none;
        color: #444;
        text-shadow: 0 1px 0 rgba(255, 255, 255, .8);
        border-radius: 5px 0 0 0;
        box-shadow: 0 2px 2px rgba(0, 0, 0, .4);
    }



    .tabs a:focus {
        outline: 0;
    }

    .tabs a::after {
        content: '';
        position: absolute;
        z-index: 1;
        top: 0;
        right: -.5em;
        bottom: 0;
        width: 1em;
        box-shadow: 2px 2px 2px rgba(0, 0, 0, .4);
        transform: skew(10deg);
        border-radius: 0 5px 0 0;
    }

    .nav-justified {
        background-image: none;
    }

    .tabs #addition-tab::after {
        content: '';
        position: absolute;
        z-index: 1;
        top: 0;
        right: -.5em;
        bottom: 0;
        width: 1em;
        background: #25867d;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        box-shadow: 2px 2px 2px rgba(0, 0, 0, .4);
        transform: skew(10deg);
        border-radius: 0 5px 0 0;
    }

    .tabs #current a,
    .tabs #current a::after {
        background: #25867d;
        z-index: 3;
        color: white !important;
    }

    body,
    .main-footer {
        background: white !important;
    }

    #content {
        padding: 2em;
        position: relative;
        z-index: 1;
        border-radius: 0 5px 5px 5px;
        /* box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.15);
        border-style: outset; */
        box-shadow: -4px 4px 4px rgb(0 0 0 / 50%), inset 1px 0px 0px rgb(255 255 255 / 40%);
    }

    .content {
        padding: 2em;
        position: relative;
        z-index: 1;
        border-radius: 0 5px 5px 5px;
        box-shadow: -4px 4px 4px rgb(0 0 0 / 50%), inset 1px 0px 0px rgb(255 255 255 / 40%);
    }

    .navv {
        -ms-flex-preferred-size: 0;
        flex-basis: none !important;
        -ms-flex-positive: 1;
        -webkit-box-flex: 1;
        flex-grow: 0 !important;
    }

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


    .switch-field input[id=radio-one12]:checked+label[for=radio-one12] {
        background-color: #a5dc86;
        box-shadow: none;
        color: white;
    }

    .switch-field input[id=radio-two12]:checked+label[for=radio-two12] {
        background-color: #dc8686;
        box-shadow: none;
        color: white;
    }

    .switch-field input[id=radio-one13]:checked+label[for=radio-one13] {
        background-color: #a5dc86;
        box-shadow: none;
        color: white;
    }

    .switch-field input[id=radio-two13]:checked+label[for=radio-two13] {
        background-color: #dc8686;
        box-shadow: none;
        color: white;
    }


    .switch-field label:first-of-type {
        border-radius: 4px 0 0 4px;
    }

    .switch-field label:last-of-type {
        border-radius: 0 4px 4px 0;
    }

    .ad {
        background-color: #2725a4 !important;
    }

    .gender {
        display: flex;
        justify-content: space-evenly;
    }

    #adde {
        background-color: #1d90cb !important;
        margin-inline: 1rem !important;
    }

    #addc {
        background-color: #1d90cb !important;
        margin-inline: 1rem !important;
    }

    .scroll_flow_class {
        padding: 1rem !important;
        box-shadow: 0 2px 3px 3px rgb(0 0 0 / 14%), 0 1px 5px 0 rgb(0 0 0 / 12%), 0 3px 1px -2px rgb(0 0 0 / 20%);
        background-color: white;
        -webkit-transition: .5s all ease;
        -moz-transition: .5s all ease;
        transition: .5s all ease;
        overflow-y: scroll;
        height: 200px !important;
    }

    #hide,
    #assetshow {
        display: none;
    }

    .shbutton {
        display: flex;
        justify-content: end;
    }

    /* checkboxcss */
    * {
        -webkit-tap-highlight-color: transparent;
        outline: none;
    }

    ._checkbox {
        display: none;
    }

    .chl {
        /* position: absolute; */
        top: 50%;
        /* bottom: 15px; */
        right: 0;
        left: 0;
        width: 35px;
        height: 30px;
        margin: 0 auto;
        background-color: #1d70b8;
        transform: translateY(0%);
        border-radius: 6px;
        cursor: pointer;
        transition: 0.2s ease transform, 0.2s ease background-color, 0.2s ease box-shadow;
        overflow: hidden;
        z-index: 1;
    }

    .chl:before {
        content: "";
        position: absolute;
        top: 50%;
        right: 0;
        left: 0;
        width: 15px;
        height: 15px;
        margin: 0 auto;
        background-color: #fff;
        transform: translateY(-50%);
        border-radius: 15px;
        transition: 0.2s ease width, 0.2s ease height;
    }

    .chl:active {
        transform: translateY(-50%) scale(0.9);
    }

    .tick_mark {
        position: absolute;
        top: -25px;
        right: 0;
        left: 0;
        width: 60px;
        height: 60px;
        margin: 0 auto;
        margin-left: 6px;
        transform: rotateZ(-40deg);
    }

    .tick_mark:before,
    .tick_mark:after {
        content: "";
        position: absolute;
        background-color: #fff;
        border-radius: 2px;
        opacity: 0;
        transition: 0.2s ease transform, 0.2s ease opacity;
    }

    .tick_mark:before {
        left: 0;
        bottom: 30px;
        width: 5px;
        height: 14px;
        box-shadow: -2px 0 5px rgb(0 0 0 / 23%);
        transform: translateY(-68px);
    }

    .tick_mark:after {
        left: 0;
        bottom: 30px;
        width: 39%;
        height: 5px;
        box-shadow: 0 3px 5px rgb(0 0 0 / 23%);
        transform: translateX(78px);
    }

    ._checkbox:checked+.chl {
        background-color: #18b71a;

    }

    ._checkbox:checked+.chl:before {
        width: 0;
        height: 0;
    }

    ._checkbox:checked+.chl .tick_mark:before,
    ._checkbox:checked+.chl .tick_mark:after {
        transform: translate(0);
        opacity: 1;
    }

    .check {
        background-image: linear-gradient(to right, #3f9a9d, #3f9a9d, #3f9a9d, #3f9a9d, #3f9a9d);
    }
</style>
<!-- modal pop up  -->
<style>
    .row.subscribtion {
        display: flex;
        justify-content: space-evenly;
        align-items: baseline;
    }
</style>



<!-- end modal pop up -->
<div class="main-content main_contentspace" style="position:absolute !important; z-index:-2!important; min-height:100%">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12">
            <div class="main-content" style="height:100%; padding: 15px">
                {{ Breadcrumbs::render('gt_index') }}

                <input type="hidden" class="form-control" required id="user_details" name="user_details" readonly value="general">
                <div class="tile" id="tile-1" style="margin-top:10px !important;">

                    <!-- Nav tabs -->

                    <ul class="nav nav-tabs nav-justified tabs" id="tabs" role="tablist">

                        <li class="nav-items navv active" style="flex-basis: 1 !important;">
                            <a class="nav-link" id="home-tab" name="tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-user"></i><b>Graduate Trainee General Details</b> <input type="checkbox" class="checkg" id="profile" name="nationality" readonly value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                <div class="check"></div>
                            </a>

                        </li>



                    </ul>
                </div>
                <!-- Tab panes -->


                <div id="" class="content">
                    <div id="">
                        <section class="section">
                            <div class="section-body mt-1">
                                <div class="form-group shbutton">
                                    <a id="show" class=" btn btn-labeled btn-info show" onclick="hideshow('show')" style="color:white !important; ">View All</a>
                                    <a id="hide" class=" btn btn-labeled btn-info hide" onclick="hideshow('hide')" style="color:white !important; ">Show Less</a>
                                </div>
                                <!--  -->
                                <div class="table-wrapper">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" style="text-align:center;table-layout: fixed;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 7%">S.No</th>
                                                    <th style="width: 15%">Name</th>
                                                    <!-- <th style="width: 10%">Interest</th> -->
                                                    <th style="width: 20%">NIN Number</th>
                                                    <th data-orderable="false" style="width: 20%">Attachments</th>

                                                </tr>
                                            </thead>
                                            <tbody>


                                                @foreach($rows['general'] as $key=>$data)
                                                <tr class="trc">
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$data['name']}}</td>
                                                    <td>{{$data['nin']}}</td>

                                                    <?php if ($data['ninfn_format'] == 'pdf') { ?>

                                                        <td>
                                                            <img style="width: 30px;" src="{{asset('asset/image/pdf.png')}}">
                                                            <a href="{{$data['ninfp']}}/{{$data['ninfn']}}" download>{{$data['ninfn']}}</a>
                                                        </td>

                                                    <?php } else if ($data['ninfn_format']  == 'png' ||  $data['ninfn_format']  == 'jpg') { ?>

                                                        <td>
                                                            <img style="width: 30px;" src="{{asset('asset/image/gallery.png')}}">
                                                            <a href="{{$data['ninfp']}}/{{$data['ninfn']}}" download>{{$data['ninfn']}}</a>
                                                        </td>
                                                    <?php } else if ($data['ninfn_format']  == 'docx') { ?>
                                                        <td>
                                                            <img style="width: 30px;" src="{{asset('asset/image/doc.png')}}">
                                                            <a href="{{$data['ninfp']}}/{{$data['ninfn']}}" download>{{$data['ninfn']}}</a>
                                                        </td>
                                                    <?php } ?>

                                                </tr>
                                                @endforeach

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>

                        </section>

                    </div>

                </div>

                <div id="assetshow">

                    <div class="tile" id="tile-1" style="margin-top:10px !important;">

                        <!-- Nav tabs -->

                        <ul class="nav nav-tabs nav-justified tabs" id="tabs" role="tablist">

                            <li class="nav-items navv active" style="flex-basis: 1 !important;">
                                <a class="nav-link  " id="home-tab" name="" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-graduation-cap" aria-hidden="true"></i><b> Graduate Trainee Education Details</b> <input type="checkbox" class="checkg" id="profile" name="nationality" readonly value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                    <div class="check"></div>
                                </a>

                            </li>



                        </ul>
                    </div>
                    <!-- Tab panes -->


                    <div id="" class="content">
                        <div id="">
                            <section class="section">
                                <div class="section-body mt-1">

                                    <!-- <input type="hidden" class="form-control" required id="user_id" name="user_id" readonly value=""> -->
                                    <input type="hidden" class="form-control" required id="user_details" name="user_details" readonly value="general">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" style="text-align:center;table-layout: fixed;">
                                            <thead>

                                                <tr>
                                                    <th style="width: 7%">S.No</th>
                                                    <th style="width: 11%">Course Type</th>
                                                    <th style="width: 12%">Course Name</th>
                                                    <th style="width: 11%">Institution</th>
                                                    <th style="width: 13%">Grade Point</th>

                                                    <th style="width: 15%"> Completion Year</th>

                                                </tr>

                                            </thead>
                                            <tbody>
                                                @foreach($rows['education'] as $key=>$data)
                                                <tr class="trc">


                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$data['graduation']}}</td>
                                                    <td>{{$data['course_name']}}</td>
                                                    <td>{{$data['university_name']}}</td>
                                                    <td>{{$data['m_percentage']}}</td>


                                                    <td>{{$data['yop']}}</td>

                                                </tr>

                                            </tbody>
                                            @endforeach
                                        </table>





                                        <!-- <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="egc" style="display: flex;  align-items: center;">
                                                        <div class="dq"><span class="questions">An understanding of the market within which this Asset is Traded:</span></div>

                                                        <div class="switch-field" style="padding-left:12px">
                                                            <input type="radio" id="radio-one12" name="second" readonly value="yes" required Checked />
                                                            <label for="radio-one12">Yes</label>
                                                            <input type="radio" id="radio-two12" name="second" readonly value="no" required />
                                                            <label for="radio-two12">No</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->

                                    </div>
                                </div>
                            </section>

                        </div>

                    </div>



                    <div class="tile" id="tile-1" style="margin-top:10px !important;">

                        <!-- Nav tabs -->

                        <ul class="nav nav-tabs nav-justified " id="tabs" role="tablist">

                            <li class="nav-items navv active" style="flex-basis: 1 !important;">
                                <a class="nav-link  " disabled id="home-tab" name="tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-briefcase" style="margin-right:5px"></i><b>Work Experience</b> <input type="checkbox" class="checkg" id="profile" name="nationality" readonly value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                    <div class="check"></div>
                                </a>

                            </li>
                            @if($rows['certification'] !=[])
                            <li class="nav-items navv active" style="flex-basis: 1 !important;">
                                <a class="nav-link  " id="home-tab" name="tab2" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-certificate"></i><b> Certification Courses</b> <input type="checkbox" class="checkg" id="profile" name="nationality" readonly value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                    <div class="check"></div>
                                </a>

                            </li>
                            @endif




                        </ul>
                    </div>
                    <!-- Tab panes -->

                    <div id="content">
                        <div id="tab1">
                            <section class="section">
                                <div class="section-body mt-1">

                                    <!-- <input type="hidden" class="form-control" required id="user_id" name="user_id" readonly value=""> -->
                                    <input type="hidden" class="form-control" required id="user_details" name="user_details" readonly value="general">




                                    <div class="table-responsive">
                                        <table class="table table-bordered" style="text-align:center;table-layout: fixed;">
                                            <thead>
                                                <!-- No Table -->
                                                <tr>
                                                    <th style="width: 10%">Sl.No</th>
                                                    <th style="width: 23%">From Date</th>
                                                    <th style="width: 16%">To Date</th>

                                                    <th style="width: 20%">Designation</th>
                                                    <th style="width: 20%">Exp in years</th>



                                                </tr>
                                            </thead>
                                            <tbody>


                                                @foreach($rows['work_experience'] as $key=>$data)
                                                <tr class="trc">
                                                    @if($data['exp'] == '0')
                                                    <td colspan="5">Fresher</td>
                                                    @else
                                                    <th style="width: 10%">{{$loop->iteration}}</th>
                                                    <th style="width: 23%">{{date('d-m-Y', strtotime($data['fde']))}}</td>
                                                    <th style="width: 16%">{{date('d-m-Y', strtotime($data['tde']))}}</th>
                                                    <th style="width: 15%">{{$data['designation']}}</th>

                                                    <th style="width: 20%">{{$data['exp']}}</th>
                                                    @endif



                                                </tr>

                                                @endforeach
                                            </tbody>
                                        </table>


                                        <!-- Yes Table -->


                                    </div>



                                </div>

                            </section>

                        </div>

                        @if($rows['certification'] != [])


                        <div id="tab2">
                            <section class="section">
                                <div class="section-body mt-1">

                                    <!-- <input type="hidden" class="form-control" required id="user_id" name="user_id" readonly value=""> -->
                                    <input type="hidden" class="form-control" required id="user_details" name="user_details" readonly value="general">

                                    <div class="row">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" style="text-align:center;table-layout: fixed;">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10%">Sl.No</th>
                                                        <th style="width: 20%">Institute Name/Website Name</th>
                                                        <th style="width: 20%">Course Name</th>
                                                        <th style="width: 30%">Attachments</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach($rows['certification'] as $key=>$data)
                                                    <tr class="trc">
                                                        <th style="width: 10%">{{$loop->iteration}}</th>
                                                        <th style="width: 20%">{{$data['nopb']}}</th>
                                                        <th style="width: 20%">{{$data['certib']}}</th>
                                                        <td>
                                                            <?php
                                                            $filePath = app_path('Http/Controllers/basicfunctionController.php');
                                                            include_once $filePath;
                                                            $obj = new common_function;
                                                            $file_type = $obj->file_type($data['certfn']);
                                                            ?>
                                                            <img style="width: 26px;" src="{{ asset('asset/image/' . $file_type . '.png')}}">
                                                            <a href="{{$data['certfp']}}/{{$data['certfn']}}" download>{{$data['certfn']}}</a>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>

                                        @endforeach

                                    </div>

                            </section>

                        </div>

                        @endif



                        <!-- Tab panes -->
                    </div>






                    <div id="show">

                        <div class="tile" id="tile-1" style="margin-top:10px !important;">

                            <!-- Nav tabs -->

                            <ul class="nav nav-tabs nav-justified tabs" id="tab" role="tablist">

                                <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                                    <a class="nav-link  " id="home-tab" name="" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><img src="{{asset('assets/images/user-graduate-solid.svg')}}" style=" filter: invert(1) contrast(4.5);" alt="" width="20" height="30"><b> Approved By</b> <input type="checkbox" class="checkg" id="profile" name="nationality" readonly value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                        <div class="check"></div>
                                    </a>

                                </li>



                            </ul>
                        </div>
                        <!-- Tab panes -->


                        <div id="" class="content">
                            <div id="">
                                <section class="section">
                                    <div class="section-body mt-1">

                                        <!-- <input type="hidden" class="form-control" required id="user_id" name="user_id" readonly value=""> -->
                                        <input type="hidden" class="form-control" required id="user_details" name="user_details" readonly value="general">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" style="text-align:center;table-layout: fixed;">
                                                <thead>

                                                    <tr>
                                                        <th style="width: 7%">S.no</th>
                                                        <th style="width: 11%">designation</th>
                                                        <th style="width: 12%">name</th>
                                                        <th style="width: 11%">Approved On</th>

                                                    </tr>

                                                </thead>
                                                <tbody>

                                                    @foreach($rows['supervision'] as $key=>$data)
                                                    <tr class="trc">
                                                        <th style="width: 10%">{{$loop->iteration}}</th>
                                                        <th style="width: 20%"></th>
                                                        <th style="width: 20%">{{$data['name']}}</th>
                                                        <th style="width: 20%">{{date('d-m-Y', strtotime($data['created_at']))}}</th>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>


                                    </div>
                                </section>

                            </div>

                        </div>
                        <div class="col-md-12">
                            <div class="card mt-4">
                                <div class="card-header">
                                    <label class="form-label" for="textAreaExample" style="font-size: 23px;">Supervisor's Comments</label>
                                </div>
                                <div class="card-body p-0">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <div id="previousnotes" style="margin: 20px;">
                                                <div id="editor"></div>
                                                <div class="form-group scroll_flow_class">
                                                    @foreach($rows['messages'] as $key=>$data)

                                                    <span> <b>{{$data['name']}}</b> </span>
                                                    @if($data['role_id'] == '28')
                                                    <span>-Supervisor</span>
                                                    @else
                                                    <span>-Counselor</span>
                                                    @endif
                                                    <br>
                                                    <span>{!! $data['message'] !!}</span> <br><br>




                                                    @endforeach
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="card mt-4">
                        <div class="card-header">
                            <label class="form-label" for="textAreaExample" style="font-size: 23px;">Reasons for Supervisor's Change</label>
                        </div>
                        <div class="card-body p-0">
                            <div class="form-group">
                                <div class="form-group">
                                    <div id="previousnotes" style="margin: 20px;">
                                        <div id="editor"></div>
                                        <div class="form-group scroll_flow_class">
                                            @php
                                            $messageArray = explode('|', trim($rows['general'][0]['messages'], '"'));
                                            @endphp @foreach($messageArray as $key=>$data)

                                            <span class="d-flex align-items-center" style="gap:10px">{{$loop->iteration}}. {!! $data !!}</span> <br><br>




                                            @endforeach
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>






                    <div class="form-group">
                        <div id="previousnotes" style="margin: 20px;">
                            <div id="editor"></div>
                            <div class="form-group scroll_flow_class" style="display: contents;">

                                <div class="form-outline">
                                    <div class="card-header">
                                        <label class="form-label" for="textAreaExample" style="font-size: 23px;">Comments</label>
                                        <textarea name="messages" style="color:white" class="form-control" id="graduate_trainee" name="graduate_trainee" rows="6"></textarea>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>




                    <div style="display:flex; justify-content:center; align-items:baseline; width:100%">
                        <form action="{{route('requestupdate')}}" id="special_request" method="post">
                            @csrf
                            <input type="hidden" name="is_approve" id="is_approve" value="">
                            <input type="hidden" name="gt_id" id="gt_id" value="{{$rows['general'][0]['user_id']}}">
                            <a type="button" class="btn btn-labeled btn-info" href="{{ url()->previous() }}" title="next" style="background: red !important; border-color:red !important; color:white !important; margin-top:15px !important;">
                                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>

                            <a type="button" class="btn btn-labeled btn-info" onclick="form_update(1)" ; title="Update" style="background: green !important; border-color:green !important; color:white !important; margin-top:15px !important; margin-left: 15px;">
                                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-up"></i></span>Approve</a>

                            <a type="button" id="update" onclick="form_update(2);" class="btn btn-labeled btn-info" title="next" style="background: blue !important; border-color:blue !important; color:white !important; margin-top:15px !important; margin-left: 15px;">
                                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-times"></i></i></span>Reject</a>
                        </form>

                    </div>




                    <br>




                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>

    <script type="text/javascript">
        const form_update = (status) => {
            $('#is_approve').val(status);
            $('#special_request').submit();
        }

        $(document).ready(function() {

            $("#content").find("[id^='tab']").hide(); // Hide all content
            $("#tabs li:first").addClass("active"); // Activate the first tab
            $("#tab1").fadeIn(); // Show first tab's content



            $('#tabs a').click(function(e) {
                e.preventDefault();
                if ($(this).closest("li").attr("id") == "current") { //detection for current tab
                    return;
                } else {
                    $("#content").find("[id^='tab']").hide(); // Hide all content
                    $("#tabs li").removeClass("active"); //Reset id's
                    $(this).parent().addClass("active"); // Activate this
                    $('#' + $(this).attr('name')).fadeIn(); // Show content for the current tab


                }
            });


        });

        function DoAction(id) {

            $("#content").find("[id^='tab']").hide(); // Hide all content
            $("#tabs li").removeClass("active"); //Reset id's
            $("#tabs a").removeClass("active"); //Reset id's
            $("a[name='" + id + "']").parent().addClass("active");
            $('#' + (id)).fadeIn(); // Show content for the current tab

        }





        $(function() {

            var specialElementHandlers = {
                '#editor': function(element, renderer) {
                    return true;
                }
            };
            $('#documentdiv').click(function() {
                var doc = new jsPDF();
                doc.fromHTML(
                    $('#previousnotes').html(), 15, 15, {
                        'width': 170,
                        'elementHandlers': specialElementHandlers
                    },
                    function() {
                        doc.save('sample-file.pdf');
                    }
                );

            });
        });

        function getproposaldocument(id) {
            var id = (id);


            $.ajax({
                url: "{{url('view_proposal_documents')}}",
                type: 'post',
                data: {
                    id: id,
                    _token: '{{csrf_token()}}'
                },
                error: function() {
                    alert('Something is wrong');
                },
                success: function(data) {
                    console.log(data.length);
                    if (data.length > 0) {
                        $("#loading_gif").hide();
                        var proposaldocuments = "<div class='removeclass' style=' height:100%'><iframe src='" + data + "' class='document_ifarme_view' style='width:100%; height:100%'></iframe></div>";
                        $('.removeclass').remove();
                        var document = $('#template').append(proposaldocuments);

                    }
                }
            });
        };

        $('#Show').click(function() {
            $('#assetshow').show(500);
            $('#Show').hide(0);
            $('#Hide').show(0);
        });
        $('#Hide').click(function() {
            $('#assetshow').hide(500);
            $('#Show').show(0);
            $('#Hide').hide(0);
        });
        $('.toggle').click(function() {
            $('#assetshow').toggle('slow');
        });


        function hideshow(a) {


            if (a == "show") {
                $('#assetshow').show(500);
                document.getElementById('hide').style.display = "inline-block";
                document.getElementById('show').style.display = "none";


            } else {
                document.getElementById('hide').style.display = "none";
                document.getElementById('show').style.display = "inline-block";
                $('#assetshow').hide(500);

            }
        };
    </script>

    <script>
        $(document).ready(function() {

            tinymce.init({
                selector: 'textarea#graduate_trainee',
                height: 180,
                menubar: 'table',
                branding: false,
                // plugins: 'table',
                // toolbar: 'undo redo | formatselect | ' +
                //   'bold italic backcolor | alignleft aligncenter ' +
                //   'alignright alignjustify | bullist numlist outdent indent | ' +
                //   'removeformat | help' + 'table tabledelete | tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol',
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
            });
            // event.preventDefault()
        });
    </script>

    @include('Registration.formmodal')


    @endsection
    <!-- modalfor approve -->