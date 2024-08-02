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
        color: white !important;
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
        color: white !important;
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

    .tabs a:hover,
    .tabs a:hover::after,
    .tabs a:focus,
    .tabs a:focus::after {
        background: #25867d !important;
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
        background: #25867d;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
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
        background: #e9f8ff;
        padding: 2em;
        position: relative;
        z-index: 1;
        border-radius: 0 5px 5px 5px;
        /* box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.15);
        border-style: outset; */
        box-shadow: -4px 4px 4px rgb(0 0 0 / 50%), inset 1px 0px 0px rgb(255 255 255 / 40%);
    }

    .content {
        background: #e9f8ff;
        padding: 2em;
        position: relative;
        z-index: 1;
        border-radius: 0 5px 5px 5px;
        /* box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.15);
        border-style: outset; */
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

    /* .switch-field input:checked + label {
    background-color: #dc8686;
    box-shadow: none;
    color: white;
} */
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

    /* .switch-field input:checked + label {
	background-color: #a5dc86;
	box-shadow: none;
} */
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

    /* endcheckboxcss */
</style>
<!-- modal pop up  -->
<style>
    .row.subscribtion {
        display: flex;
        justify-content: space-evenly;
        align-items: baseline;
    }
</style>



<div class="modal fade" id="allocate">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form action="{{route('allocate_stake_holder')}}" method="POST">
                @csrf
                <input name="stake_status" type="hidden" valuer="">
                <div class="modal-header mh">
                    <h4 class="modal-title">Allocation Process</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" style=" background-color: #f8fffb;">
                    @foreach($rows['general'] as $key=>$data)

                    <input type="hidden" class="form-control" required id="user_id" name="mlhud_id" value="{{$data['user_id']}}">
                    <input type="hidden" class="form-control" required id="user_id" name="valuer_id" value="{{$data['valuer_id']}}">
                    @endforeach
                    <div class="row" style="margin-bottom:10px">
                        <label class="col-sm-5" style="font-size: 16px !important; color:DarkSlateBlue;">Stakeholder Name<span class="error-star" style="color:red;">*</span></label>
                        <select onchange="data();" id="Stake_holder_name" class="custom-select custom-select" aria-label="Default select example" name="stake_holder_name">
                            <option value=''>select a stakeholder</option>
                            @foreach($rows['rows'] as $key=>$data)
                            <option value="{{$data['id']}}">{{$data['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row" style="margin-bottom:10px">
                        <label class="col-sm-5" style="font-size: 16px !important; color:DarkSlateBlue;">Stakeholder Mail<span class="error-star" style="color:red;">*</span></label>
                        <select id="stake_holder_email" class="custom-select custom-select" aria-label="Default select example" name="stake_holder_email"></select>
                    </div>
                    <!-- <div class="row" style="margin-bottom:10px">
                        <label class="col-sm-7" style="font-size: 16px !important; color:DarkSlateBlue;">Temporary Password<span class="error-star" style="color:red;">*</span></label>
                        <input class="form-control default input_custom" type="textarea" aria-label="Default input example" id="t_password"  required name="t_password" autocomplete="off">
                    </div>
                    <div class="row" style="margin-bottom:10px">
                        <label class="col-sm-7" style="font-size: 16px !important; color:DarkSlateBlue;">Expiration Date(From Today)<span class="error-star" style="color:red;">*</span></label>
                        <input class="form-control default input_custom" type="date" aria-label="Default input example" id="t_password"  required name="r_date" autocomplete="off">
                    </div> -->
                    <div class="row">
                        <label class="col-sm-5" style="font-size: 16px !important; color:DarkSlateBlue;">Messagae<span class="error-star" style="color:red;">*</span></label>
                        <input style="margin-bottom:10px;" class="form-control default input_custom2" type="textarea" aria-label="Default input example" id="message" value="Kindly Check This Valuer Profile and Give a Review" required name="message" autocomplete="off">
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <input type="hidden" class="form-control col-sm-8" style="font-size: 16px !important; color:DarkSlateBlue;" name="ren_date" id="ren_date" readonly>
                            <button type="submit" class="btn btn-success btn-space" id="savebutton">allocate</button>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- end modal pop up -->

<div class="main-content" style="position:absolute !important; z-index:-2!important">

    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12">
            <div class="" style="height:100%; padding: 15px">
                {{ Breadcrumbs::render('valuerallocate') }}

                <input type="hidden" class="form-control" required id="user_details" name="user_details" readonly value="general">
                <div class="tile" id="tile-1" style="margin-top:10px !important;">

                    <!-- Nav tabs -->

                    <ul class="nav nav-tabs nav-justified tabs" id="tab" role="tablist">

                        <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                            <a class="nav-link" id="home-tab" name="tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-user"></i><b> Valuer General Details</b> <input type="checkbox" class="checkg" id="profile" name="nationality" readonly value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
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
                                                    <th style="width: 15%">Valuer name</th>
                                                    <th style="width: 10%">Valuer Code</th>
                                                    <th style="width: 20%">NIN Number</th>
                                                    <th style="width: 20%"> Attachments</th>
                                                    <th style="width: 10%">View</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach($rows['general'] as $key=>$data)
                                                <tr class="trc">
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$data['fname']}}</td>
                                                    <td>{{$data['valuer_code']}}</td>
                                                    <td>{{$data['nin']}}</td>
                                                    <input type="hidden" id="approve_valuer_id" value="{{$data['valuer_id']}}">
                                                    <td>
                                                        <img style="width: 26px;" src="https://fia-uganda-edrms.com/images/pdf.png">
                                                        <a href="{{$data['ninfp']}}/{{$data['ninfn']}}" download>{{$data['ninfn']}}</a>
                                                    </td>
                                                    <input type="hidden" name="status" value="{{$data['v_status']}}">
                                                    <td style="word-break: break-all;"><a class="btn btn-primary" title="view Document" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('{{$data['ninfp']}}/{{$data['ninfn']}}')" style="margin-inline:5px"><input type="hidden" class="cert" id="ocfn1" name="cert[0][ocfn]" value="notes-in-13-06-2022.txt"><input type="hidden" class="cert id=" ougcfp1"="" name="cert[0][ocfp]" value="/userdocuments/registration/workexp/wc/1/0"><i class="fa fa-eye" style="color:white!important"></i></a> </td>


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

                        <ul class="nav nav-tabs nav-justified tabs" id="tab" role="tablist">

                            <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                                <a class="nav-link  " id="home-tab" name="" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><img src="{{asset('assets/images/user-graduate-solid.svg')}}" style=" filter: invert(1) contrast(4.5);" alt="" width="20" height="30"><b> Valuer Education Details</b> <input type="checkbox" class="checkg" id="profile" name="nationality" readonly value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
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
                                                <th style="width: 13%">Course Type</th>
                                                <th style="width: 12%">Course Name</th>
                                                <th style="width: 15%">Institute Name</th>
                                                <th style="width: 13%">Percentage</th>
                                                <th style="width: 20%"> Attachments</th>
                                                <th style="width: 20%"> Passed out on</th>
                                                <th style="width: 10%">View</th>
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

                                                <td><img style="width: 26px;" src="https://fia-uganda-edrms.com/images/pdf.png">
                                                    <a href="{{$data['gfp']}}/{{$data['gfn']}}" download>{{$data['gfn']}}</a>
                                                </td>
                                                <td>{{$data['yop']}}</td>






                                                <td style="word-break: break-all;"><a class="btn btn-primary" title="view Document" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('{{$data['gfp']}}/{{$data['gfn']}}')" style="margin-inline:5px"><input type="hidden" class="cert" id="ocfn1" name="cert[0][ocfn]" value="notes-in-13-06-2022.txt"><input type="hidden" class="cert id=" ougcfp1"="" name="cert[0][ocfp]" value="/userdocuments/registration/workexp/wc/1/0"><i class="fa fa-eye" style="color:white!important"></i></a> </td>


                                            </tr>

                                        </tbody>
                                        @endforeach
                                    </div>
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

                            </section>

                        </div>

                    </div>



                    <div class="tile" id="tile-1" style="margin-top:10px !important;">

                        <!-- Nav tabs -->

                        <ul class="nav nav-tabs nav-justified " id="tabs" role="tablist">

                            <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                                <a class="nav-link  " id="home-tab" name="tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-briefcase" style="margin-right:5px"></i><b>Work Experience</b> <input type="checkbox" class="checkg" id="profile" name="nationality" readonly value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                    <div class="check"></div>
                                </a>

                            </li>
                            <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                                <a class="nav-link  " id="home-tab" name="tab2" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-certificate"></i><b> Certification Courses</b> <input type="checkbox" class="checkg" id="profile" name="nationality" readonly value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                    <div class="check"></div>
                                </a>

                            </li>
                            <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                                <a class="nav-link  " id="home-tab" name="tab3" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><b><i class="fa fa-money" style="margin-right:5px"></i></b><b>Payment Details</b> <input type="checkbox" class="checkg" id="profile" name="nationality" readonly value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                    <div class="check"></div>
                                </a>

                            </li>

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
                                            <tr>
                                                <th style="width: 10%">Sl.No</th>
                                                <th style="width: 23%">Financial Company Name</th>
                                                <th style="width: 16%">Designation</th>
                                                <th style="width: 10%">No of Years </th>
                                                <th style="width: 20%">Id Proof</th>
                                                <th style="width: 10%">View</th>

                                            </tr>
                                        </thead>
                                        <tbody>


                                            <tr class="trc">
                                                <td>1</td>
                                                <td style="word-break: break-all;">Cairo International Bank</td>
                                                <td style="word-break: break-all;">Valuer</td>
                                                <td style="word-break: break-all;">1 </td>
                                                <td>
                                                    <img style="width: 26px;" src="https://fia-uganda-edrms.com/images/pdf.png">
                                                    <a href="/userdocuments/registration/education/dip/cc/1/0/form-Details-(6).pdf" download="">Form1-3-05-1.pdf</a>


                                                </td>
                                                <td style="word-break: break-all;"><a class="btn btn-primary" title="view Document" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('/userdocuments/registration/education/dip/cc/1/0/form-Details-(6).pdf')" style="margin-inline:5px"><input type="hidden" class="cert" id="ocfn1" name="cert[0][ocfn]" value="notes-in-13-06-2022.txt"><input type="hidden" class="cert id=" ougcfp1"="" name="cert[0][ocfp]" value="/userdocuments/registration/workexp/wc/1/0"><i class="fa fa-eye" style="color:white!important"></i></a> </td>
                                            </tr>
                                            <tr class="trc">
                                                <td>2</td>
                                                <td style="word-break: break-all;">MNC</td>
                                                <td style="word-break: break-all;">Management Lead</td>
                                                <td style="word-break: break-all;">2years</td>
                                                <td>
                                                    <img style="width: 26px;" src="https://fia-uganda-edrms.com/images/pdf.png">
                                                    <a href="/userdocuments/registration/education/dip/cc/1/0/form-Details-(6).pdf" download="">Form1-3-05-1.pdf</a>


                                                </td>
                                                <td style="word-break: break-all;"><a class="btn btn-primary" title="view Document" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('/userdocuments/registration/education/dip/cc/1/0/form-Details-(6).pdf')" style="margin-inline:5px"><input type="hidden" class="cert" id="ocfn1" name="cert[0][ocfn]" value="notes-in-13-06-2022.txt"><input type="hidden" class="cert id=" ougcfp1"="" name="cert[0][ocfp]" value="/userdocuments/registration/workexp/wc/1/0"><i class="fa fa-eye" style="color:white!important"></i></a> </td>
                                            </tr>

                                        </tbody>
                                        </div>
                                    </table>
                                </div>

                            </section>

                        </div>
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
                                                    <th style="width: 10%">View</th>



                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach($rows['certification'] as $key=>$data)
                                                <tr class="trc">
                                                    <th style="width: 10%">{{$loop->iteration}}</th>
                                                    <th style="width: 20%">{{$data['nopb']}}</th>
                                                    <th style="width: 20%">{{$data['certib']}}</th>
                                                    <td>
                                                        <img style="width: 26px;" src="https://fia-uganda-edrms.com/images/pdf.png">
                                                        <a href="{{$data['certfp']}}/{{$data['certfn']}}" download>{{$data['certfn']}}</a>
                                                    </td>
                                                    <td style="word-break: break-all;"><a class="btn btn-primary" title="view Document" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('/userdocuments/registration/education/dip/cc/1/0/form-Details-(6).pdf')" style="margin-inline:5px"><input type="hidden" class="cert" id="ocfn1" name="cert[0][ocfn]" value="notes-in-13-06-2022.txt"><input type="hidden" class="cert id=" ougcfp1"="" name="cert[0][ocfp]" value="/userdocuments/registration/workexp/wc/1/0"><i class="fa fa-eye" style="color:white!important"></i></a> </td>
                                                </tr>

                                            </tbody>
                                    </div>
                                        </table>

                                        @endforeach

                                    </div>

                            </section>

                        </div>

                        <div id="tab3">
                            <section class="section">
                                <div class="section-body mt-1">
                                    <input type="hidden" class="form-control" required id="user_details" name="user_details" readonly value="general">
                                    <div class="table-responsive">
                                    <table class="table table-bordered" style="text-align:center;table-layout: fixed;">
                                        <thead>
                                            <tr>
                                                <th style="width: 20%">Bank Name</th>
                                                <th style="width: 45%">Subscription Plan</th>
                                                <th style="width: 35%">Payment Type</th>
                                                <th style="width: 35%">Transaction id</th>
                                                <th style="width: 35%">Payment Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="trc">
                                                <td>Bank Of Africa</td>
                                                <td style="word-break: break-all;">12 Months</td>
                                                <td style="word-break: break-all;">Credit/Debit Card</td>
                                                <td style="word-break: break-all;">9989846482999THF</td>
                                                <td style="word-break: break-all;">12/09/2022</td>
                                            </tr>
                                        </tbody>
                                    </div>
                                    </table>
                                </div>

                            </section>

                        </div>
                    </div>
                    <!-- Tab panes -->
                </div>
                @foreach($rows['general'] as $key=>$data)



                <div class="col-md-8">
                    <form method="POST" action="allocate_stake_holder" id="generalupdate_form" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <div id="previousnotes" style="margin: 20px;">
                                <div id="editor"></div>
                                <div class="form-group scroll_flow_class">
                                    @foreach($rows['messages'] as $key=>$data)

                                    <span> {{$data['name']}} </span> <br>

                                    <span>{{$data['created_at']}} {{$data['message']}}</span> <br><br>
                                    @endforeach
                                    @foreach($rows['general'] as $key=>$data)
                                    @if($data['approval_doc_path']!=null)
                                    <a type="button" class="btn btn-success " title="Download Documents" href="{{$data['approval_doc_path']}}/{{$data['approval_doc_name']}}" download><i class="fa fa-download" style="color:white!important"></i>{{$data['approval_doc_name']}}</a>
                                    @endif
                                    @endforeach
                                    <div class="form-outline">
                                        @foreach($rows['general'] as $key=>$data)

                                        @if($data['v_status']=='Reviewed')
                                        <label class="form-label" for="textAreaExample">your Message</label>
                                        <textarea name="message_stake" style="color:white" required class="form-control" id="textAreaExample1" rows="4"></textarea>
                                        @endif
                                        @endforeach
                                    </div>

                                </div>

                            </div>
                        </div>

                    </form>


                    <div style="display :flex; justify-content:center; align-items:baseline; width:100%">
                        <a type="button" class="btn btn-labeled btn-info" href="{{ url()->previous() }}" title="next" style="background: red !important; border-color:red !important; color:white !important; margin-top:15px !important;">
                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>

                    </div>



                    @endforeach

                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>

    <script type="text/javascript">
        function data() {
            var id = $("select[name='stake_holder_name']").val();
            $.ajax({
                url: "{{ url('/ajax_data/get_stake_data') }}",
                type: 'POST',
                data: {
                    'id': id,
                    _token: '{{csrf_token()}}'

                },
                success: function(data) {
                    var user_select = data;
                    var shoptionsdata = "";
                    for (var i = 0; i < user_select.length; i++) {
                        var email = user_select[i]['email'];
                        var sh_op = '<option value="">Selecting Email</option>';
                        shoptionsdata += "<option value=" + email + " >" + email + "</option>";
                    }
                    var stageoption = sh_op.concat(shoptionsdata);
                    $('#stake_holder_email').html(stageoption);

                }
            })

        }

        function approve() {

            var id = document.getElementById("approve_valuer_id").value;
            let result = confirm('Are you sure you want to Approve?');
            if (result == false) {
                return false;
            } else {
                $.ajax({
                    url: "{{ url('/approve/valuer') }}",
                    type: 'POST',
                    data: {
                        'id': id,
                        _token: '{{csrf_token()}}'

                    },
                    success: function(data) {
                        // window.location.replace("{{ URL::to('valuerlist.index') }}");
                        const message = "Valuer List Approved Successfully";
                        location.replace(`/valuerlist?message="${message}"`);
                    }
                })
            }

        }

        let select_input = document.getElementById('Stake_holder_name');
        select_input.addEventListener("onchange", function(e) {
            let id = document.getElementById('Stake_holder_name').value;
            document.getElementById(id).style.display = "inline-block";
        });
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
        const element = document.getElementById('updatebutton');
        element.addEventListener("click", function(e) {

            confirm("BackGround Check Was Not Done, You Want To Proceed ?");
            element.preventDefault();


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


        var j = 1;
        $("#addc").click(function() {
            var q = j + 1;
            // $('#dynamic_field').append('<div id="row'+i+'"><div class=""><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list"/></td><td><input type="text" name="email[]" placeholder="Enter your Email" class="form-control name_email"/></td><td></div>');  
            $('#dynamic_fieldc').append('<section class="input-box" id="row' + j + '"><div class="row clear remove_other' + j + ' "><div class="col-md-2"> <div class="form-group"> <label> Survey Number:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control default" required id="asset_name" name="asset_name" readonly  value=""> </div> </div> <div class="col-md-3"> <div class="form-group"> <label> Extend Of Land:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control default" required id="asset_name" name="asset_name" readonly  value=""> </div> </div> <div class="col-md-3"> <div class="form-group"> <label>Land Classification:<span class="error-star" style="color:red;">*</span></label> <select class="form-control default" disabled required id="Purpose_of_valuation" name="Purpose_of_valuation"> <option readonly  value="0">Select-LandClassification</option> <option readonly  value="Agricultire">Agricultire</option> <option readonly  value="Plantation">Plantation</option> <option readonly  value="Real Estate">Real Estate</option> </select> </div> </div> <div class="col-md-3"> <div class="form-group"> <label>Land units(Acres):<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control default" required id="asset_name" name="asset_name" readonly  value=""> </div> </div><div><button style="margin-top:30px" type="button" name="remove" id="' + j + '" class="btn btn-danger btn_remove">X</button></div></div></section>');
            j++;

            $("#attachment_countc").val(j);

        });

        var i = 1;
        $("#adde").click(function() {
            var q = i + 1;
            // $('#dynamic_field').append('<div id="row'+i+'"><div class=""><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list"/></td><td><input type="text" name="email[]" placeholder="Enter your Email" class="form-control name_email"/></td><td></div>');  
            $('#dynamic_fielde').append('<section class="input-box" id="row' + i + '"><div class="row clear remove_other' + i + ' "> <div class="col-md-4"> <div class="form-group"> <label> Name:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control default" required id="asset_name" name="asset_name" readonly  value=""> </div> </div> <div class="col-md-4"> <div class="form-group"> <label>Relation to the Asset Owner :<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control default" required id="asset_name" name="asset_name" readonly  value=""> </div> </div> <!-- </div> <div class="row"> --> <div class="col-md-3"> <div class="form-group"> <label>Date of Birth :<span class="error-star" style="color:red;">*</span></label> <input type="date" class="form-control default" required id="asset_name" name="asset_name" readonly  value=""> </div> </div><div><button style="margin-top:30px" type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></div></div></section>');
            i++;

            $("#attachment_counte").val(i);

        });

        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            button_ide = '#row' + button_id + '';
            $(button_ide).remove();
            --j;
            $("#attachment_counte").val(j);
            var a = document.getElementsByClassName('expc');
            for (var z = 0; z < a.length; z++) {

                document.getElementsByClassName('expf')[z].setAttribute('name', "[wre][" + z + "][fde]");
                document.getElementsByClassName('expt')[z].setAttribute('name', "[wre][" + z + "][tde]");
                document.getElementsByClassName('expa')[z].setAttribute('name', "[wre][" + z + "][aow]");
                document.getElementsByClassName('expep')[z].setAttribute('name', "[wre][" + z + "][ep]");
                document.getElementsByClassName('expd')[z].setAttribute('name', "[wre][" + z + "][des]");
                document.getElementsByClassName('expr')[z].setAttribute('name', "[wre][" + z + "][rel]");


            }
        });

        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            button_idc = '#row' + button_id + ''
            $(button_idc).remove();
            var i = $("#attachment_countc").val();
            --i;
            $("#attachment_countc").val(i);
            var a = document.getElementsByClassName('certc');
            for (var z = 0; z < a.length; z++) {

                document.getElementsByClassName('certnopb')[z].setAttribute('name', "[cert][" + z + "][nopb]");
                document.getElementsByClassName('certib')[z].setAttribute('name', "[cert][" + z + "][ib]");
                document.getElementsByClassName('certd')[z].setAttribute('name', "[cert][" + z + "][certd]");
                document.getElementsByClassName('certf')[z].setAttribute('name', "[f" + z + "]");

            }
        });

        function radchange(a) {
            var a = a.value;
            if (a == "yes") {
                document.getElementById('ownerchange').style.display = "none";
                document.getElementById('qv1').style.display = "block";
                var a = document.getElementsByClassName('wrq');
                for (var z = 0; z < a.length; z++) {
                    document.getElementsByClassName('wrq')[z].setAttribute('required', 'required');

                }
                var b = document.getElementsByClassName('wre');
                for (var y = 0; y < b.length; y++) {
                    document.getElementsByClassName('wre')[y].removeAttribute('required');
                }
            } else {
                document.getElementById('qv1').style.display = "none";
                document.getElementById('qv2').style.display = "block";
                var a = document.getElementsByClassName('wrq');
                for (var z = 0; z < a.length; z++) {
                    document.getElementsByClassName('wrq')[z].removeAttribute('required');

                }
                var b = document.getElementsByClassName('wre');
                for (var y = 0; y < b.length; y++) {
                    document.getElementsByClassName('wre')[y].setAttribute('required', 'required');
                }
            }
        }

        function changefile1(a) {

            var a = a.value;
            if (a == "1") {
                document.getElementById('ninf').setAttribute('required', 'required');
                document.getElementById('dninf1').style.display = "inline-block";
                document.getElementById('f1').value = "0";
                document.getElementById('i1').value = "0";
                document.getElementById('fi1').innerText = " Stay The Same";
            } else {
                document.getElementById('ninf').removeAttribute('required');
                document.getElementById('dninf1').style.display = "none";
                document.getElementById('f1').value = "1";
                document.getElementById('i1').value = "1";
                document.getElementById('fi1').innerText = " Change File";
            }
        };

        function changefile2(a) {

            var a = a.value;
            if (a == "1") {
                document.getElementById('ppf').setAttribute('required', 'required');
                document.getElementById('dninf2').style.display = "inline-block";
                document.getElementById('f2').value = "0";
                document.getElementById('i2').value = "0";

                document.getElementById('fi2').innerText = " Stay The Same";
            } else {
                document.getElementById('ppf').removeAttribute('required');
                document.getElementById('dninf2').style.display = "none";
                document.getElementById('f2').value = "1";
                document.getElementById('i2').value = "1";
                document.getElementById('fi2').innerText = " Change File";
            }
        };

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



    @include('Registration.formmodal')


    @endsection
    <!-- modalfor approve -->