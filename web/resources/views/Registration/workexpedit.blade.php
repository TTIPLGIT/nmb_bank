@extends('layouts.adminnav')

@section('content')
<style>
    .row {
        display: -ms-flexbox;
        display: -webkit-box;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        width: 100%;
        align-items: baseline;
    }

    .input-box::before {
        content: "";
        display: block;
        border-top: 1px solid #000;
        margin-bottom: 10px;
    }


    .input-box::before {
        content: "";
        display: block;
        border-top: 1px solid #000;
        margin-bottom: 10px;
    }


    #tabs {
        overflow: hidden;
        width: 100%;
        margin: 0;

        padding: 0;
        list-style: none;
        font-size: 16px !important;

    }

    #tabs li {
        float: left;
        margin: 0 .5em 0 0;

    }

    #tabs a {
        color: #000000 !important;
        position: relative;
        background: #d8ddd3;
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
        background: #a9cadb;
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
        background: inherit;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        box-shadow: 2px 2px 2px rgba(0, 0, 0, .4);
        transform: skew(10deg);
        border-radius: 0 5px 0 0;
    }

    #tabs #addition-tab::after {
        content: '';
        position: absolute;
        z-index: 1;
        top: 0;
        right: -.5em;
        bottom: 0;
        width: 1em;
        background: inherit;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        box-shadow: 2px 2px 2px rgba(0, 0, 0, .4);
        transform: skew(10deg);
        border-radius: 0 5px 0 0;
    }

    #tabs #current a,
    #tabs #current a::after {
        background: #265077;
        z-index: 3;
        color: white !important;

    }

    body,
    .main-footer {
        background: white !important;
    }

    #content {
        background: #ffffff;
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


    .ui-datepicker-trigger {
        position: absolute !important;
        right: 0px;
        top: 54%;
        left: 74%;
        transform: translateY(-51%);
        height: 23px !important;
    }

    .note {
        color: red !important;
        font-size: 15px;
    }
</style>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>

<div class="main-content">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12">
            <div class="" style="height:100%; padding: 15px">



                <form action="{{ route('Registration.update',$user_id) }}" method="POST" id="eduedit_form" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <input type="hidden" class="form-control" required id="user_details" name="user_details" value="exp">

                    <div class="tile" id="tile-1" style="margin-top:10px !important;">

                        <!-- Nav tabs -->

                        <ul class="nav nav-tabs nav-justified " id="tabs" role="tablist" style="background-image: none">

                            <li class="nav-items navv active" class="active" style="flex-basis: 1 !important;">
                                <a class="nav-link active" id="home-tab" name="tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-home"></i><b> Work Experience</b> <input type="checkbox" class="checkg" id="profile" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                    <div class="check"></div>
                                </a>

                            </li>
                            <li class="nav-items navv" id="certification" class="" style="flex-basis: 1 !important;">
                                <a class="nav-link" id="addition-tab" name="tab2" data-toggle="tab" role="tab" aria-controls="addition" aria-selected="false"><i class="fas fa-map-signs"></i> <b>Certification</b> <input type="checkbox" class="checkg" id="adddetails" name="nationality" value="0" onchange="submitval(this)" style="background-color:solid green !important; color:green !important; visibility:hidden !important; "></a>

                            </li>



                        </ul>
                    </div>
                    <!-- Tab panes -->
                    @if($rows['Experience']['index'][0]['exp']==0)
                    <div id="content">
                        <div id="tab1">

                            <section class="section">
                                <div class="section-body mt-1">
                                    <div class="" id="qv1">
                                        <div class="row flex">
                                            <div class="col-5">
                                                <div class="form-group">
                                                    <label class="control-label">Experience in years<span class="error-star" style="color:red;">*</span></label>
                                                    <input class="form-control default  wrq" min="1" placeholder=" Enter the Experience" type="number" id="experience" name="" autocomplete="off" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="attachment_counter" id="attachment_counter" value="1">
                                        <div id="dynamic_addc" style="margin-left:16px ;">
                                            <button type="button" name="addcompany" id="addcompanynew" class="btn btn-primary" style="background-color: #67c8e2 !important">Add Experience</button>

                                        </div>
                                    </div>

                                    <div class="" id="qv2" style="display:none;">
                                        <input type="hidden" name="attachment_counte" id="attachment_counte" accept=".pdf,.png," value="1">
                                        <div id="dynamic_fielde"></div>
                                        <button type="button" name="adde" id="adde" class="btn btn-primary d-none" style="background-color: #67c8e2 !important">Add Experience</button>
                                    </div>

                                </div>
                            </section>
                            <div style="display:flex; justify-content:center; width:100%">

                                <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab2');" title="next" style="background: #4d94ff !important; border-color:#4d94ff !important; color:white !important">
                                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-right"></i></span>Next</a>
                            </div>
                        </div>
                        @if($rows['Experience']['cert'][0]['id'] !=null)
                        <div id="tab2">
                            <section class="section">


                                <div class="section-body mt-0">
                                    @foreach($rows['Experience']['cert'] as $data)


                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Name of the Professional Body:<span class="error-star" style="color:red;">*</span></label>
                                                <input class="form-control default cert" placeholder="Enter the Professional body" type="text" id="nopb" name="cert[{{$loop->iteration - 1}}][nopb]" value="{{$data['nopb']}}" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Certificate Issued By:<span class="error-star" style="color:red;">*</span></label>
                                                <input class="form-control default" placeholder="Enter the Certificate issued by" type="text" id="certib" name="cert[{{$loop->iteration - 1}}][ib]" value="{{$data['certib']}}" autocomplete="off">
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Certification Documents:<span class="error-star" style="color:red;">*</span></label>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>{{$data['certfn']}}</label>
                                                            <input type="hidden" name="cert[{{$loop->iteration - 1}}][certfn_old]" value="{{$data['certfn']}}">
                                                            <input type="hidden" name="cert[{{$loop->iteration - 1}}][certfp_old]" value="{{$data['certfp']}}">
                                                            <a type="button" class="btn btn-success " title="Download Documents" href="{{$data['certfp']}}/{{$data['certfn']}}" download><i class="fa fa-download" style="color:white!important"></i></a>
                                                            <a class="btn btn-primary" title="view Document" data-toggle="modal" data-target="#templates" onClick="getproposaldocument('{{$data['certfp']}}/{{$data['certfn']}}')"><i class="fa fa-eye" style="color:white!important"></i></a>

                                                        </div>
                                                    </div>



                                                </div>


                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <button type="button" class="btn btn-info" data-id = "{{$loop->iteration}}" id="wrk1" title="change Documents" value="1" onclick="changefile1(this)"><i class="fa fa-exchange" id="workexp1" style="color:white!important">Change file</i></button>
                                                <input type="hidden" id="work1" name="wrk1" value="1">
                                            </div>
                                            <div class="col-md-6" id="expf{{$loop->iteration}}" style="display:none;">
                                                <input class="form-control " type="file" accept=".pdf,.png," id="certd" name="cert[{{$loop->iteration - 1}}][certd]" value="" autocomplete="off">
                                                <strong style="color: red;">Following files could be uploaded pdf,png</strong>
                                            </div>
                                        </div>


                                    </div>
                                    @endforeach
                                    <div class="row" style="padding-top: 20px;">
                                        <input type="hidden" name="attachment_countc" id="attachment_countc" value="1">
                                        <button type="button" name="addc" id="addc" class="btn btn-primary" style="background-color: #67c8e2 !important">Add Certification</button>
                                        <div class="col-md-12" id="dynamic_fieldc"></div>
                                    </div>

                                </div>

                            </section>


                        </div>
                        @else

                        <div id="tab2">
                            <section class="section">
                                <div class="section-body mt-0">
                                    <div class="row">
                                        <!-- <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Name of the Professional Body:<span class="error-star" style="color:red;">*</span></label>
                                                <input class="form-control default" placeholder="Enter the Professional body" type="text" id="nopb" name="cert[0][nopb]" autocomplete="off" value="">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Certificate Issued By:<span class="error-star" style="color:red;">*</span></label>
                                                <input class="form-control default" placeholder="Enter the Certificate issued by" type="text" id="certib" name="cert[0][ib]" value="" autocomplete="off">
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Certification Documents:<span class="error-star" style="color:red;">*</span></label>
                                                <input class="form-control " type="file" id="certd" name="cert[0][certd]" value="" accept=".pdf,.png," autocomplete="off">
                                                <strong style="color: red;">Following files could be uploaded pdf,png</strong>
                                            </div>

                                        </div> -->
                                        <input type="hidden" name="attachment_countc" id="attachment_countc" value="1">
                                        <div id="dynamic_fieldc"></div>
                                        <button type="button" name="addc" id="addc" class="btn btn-primary" style="background-color: #67c8e2 !important">Add Certification</button>
                                    </div>
                                </div>
                            </section>
                        </div>
                        @endif

                    </div>
                    @else
                    @php
                    $exp = 0;
                    @endphp
                    @foreach($rows['Experience']['index'] as $data)
                    @php $exp += $data['exp']; @endphp
                    @endforeach
                    <div id="content">
                        <div id="tab1">

                            <section class="section">
                                <div class="section-body mt-1">

                                    <div class="" id="qv1">
                                        <div class="row flex">
                                            <div class="col-5">
                                                <div class="form-group">
                                                    <label class="control-label">Experience in years<span class="error-star" style="color:red;">*</span></label>
                                                    <input class="form-control default  wrq" min="1" placeholder=" Enter the Experience" type="number" id="experience" name="wrq[0][experience]" value="{{$exp}}" autocomplete="off" readonly>
                                                </div>
                                            </div>

                                        </div>
                                        @foreach($rows['Experience']['index'] as $data)
                                        <div class="row flex">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Company Name<span class="error-star" style="color:red;">*</span></label>
                                                    <input class="form-control default  wrq C_name" placeholder="Enter the Company name" type="text" id="C_name" name="wrq[{{$loop->iteration - 1}}][c_name]" autocomplete="off" value="{{$data['c_name']}}">

                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Designation<span class="error-star" style="color:red;">*</span></label>
                                                    <input class="form-control default wrq" placeholder="Enter the Designation" type="text" id="designation_valuation" name="wrq[{{$loop->iteration - 1}}][designation]" value="{{$data['designation']}}" autocomplete="off">

                                                </div>
                                            </div>

                                            <div class="col-md-2 date_pic">
                                                <div class="form-group">
                                                    <label class="control-label">From Date:<span class="error-star" style="color:red;">*</span></label>
                                                    <input class="form-control default fde wrq dob fde_{{$loop->iteration - 1}} startdate" type="text" onchange="yearcount(event)" oninput="input(this)" title="fde" id="fde{{$loop->iteration - 1}}" name="wrq[{{$loop->iteration - 1}}][fde_yes]" value="{{$data['fde']}}" placeholder="DD-MM-YYYY" autocomplete="off">

                                                </div>
                                            </div>
                                            <div class="col-md-2 date_pic">
                                                <div class="form-group">
                                                    <label class="control-label">To Date:<span class="error-star" style="color:red;">*</span></label>
                                                    <input class="form-control default tde wrq dob tde_{{$loop->iteration - 1}}" min="{{$data['fde']}}" type="text" onchange="yearcount(event)" oninput="input(this)" id="tde{{$loop->iteration - 1}}" name="wrq[{{$loop->iteration - 1}}][tde_yes]" value="{{$data['tde']}}" placeholder="DD-MM-YYYY" autocomplete="off">

                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label"><span id="item_label"></span>Scope & Responsibilities:</label>
                                                    <textarea rows="10" columns="10" placeholder="Scope & Responsibilities" class="form-control default wre" type="text" id="scoope" name="wrq[{{$loop->iteration - 1}}][scope]" value="{{$data['scope']}}" autocomplete="off">{{$data['scope']}}</textarea>

                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="attachment_counter" id="attachment_counter" value="1">

                                        @endforeach
                                        <button type="button" name="addcompany" id="addcompany" class="btn btn-primary mt-2" style="background-color: #67c8e2 !important">Add Experience</button>
                                        <div id="dynamic_addc" style="margin-left:16px ;">
                                            <!-- <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Cost, price, value and worth,:<span class="error-star" style="color:red; font-size:10px">*</span></label>
                                                        <input class="form-control default  wrq" type="text" id="cpvw" name="wrq[cpvw]" autocomplete="off">

                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Value – types, elements, ingredients, characteristics:<span class="error-star" style="color:red;">*</span></label>
                                                        <input class="form-control default  wrq" type="text" id="teic" name="wrq[teic]" autocomplete="off">

                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label class="conrol-label">Annuities – capitalisation – rate of capitalisation – redemption of capital:</label>
                                                        <input class="form-control default  wrq" type="text" id="acrr" name="wrq[acrr]" autocomplete="off">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label"><span id="item_label"></span>Three approaches to value viz., Income, Market and Cost:<span class="error-star" style="color:red;">*</span></label>
                                                        <input class="form-control default  wrq" type="text" id="imc" name="wrq[imc]" autocomplete="off">

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label"><span id="item_no_label"></span>Laws applicable to agricultural land:<span class="error-star" style="color:red;">*</span></label>
                                                        <input class="form-control default wrq" type="text" id="laal" name="wrq[laal]" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>-->
                                        </div>

                                    </div>

                                    <div class="" id="qv2" style="display:none;">
                                        <div class="row" style="display:none;">
                                            <div class=" col-md-2 " id="s11">
                                                <div class="form-group">
                                                    <label class="control-label"><span id="item_no_label1"></span>Designation:<span class="error-star" style="color:red;">*</span></label>
                                                    <input class="form-control default wre " type="text" id="des1" name="" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class=" col-md-2" id="s21">
                                                <div class="form-group">
                                                    <label class="control-label"><span id="item_no_label2"></span>Exp in the relevant valuation:<span class="error-star" style="color:red;">*</span></label>
                                                    <input class="form-control default wre " type="text" id="rel1" name="" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="attachment_counte" id="attachment_counte" accept=".pdf,.png," value="1">
                                        <div id="dynamic_fielde"></div>
                                        <button type="button" name="adde" id="adde" class="btn btn-primary d-none" style="background-color: #67c8e2 !important">Add Experience</button>


                                    </div>

                                </div>
                            </section>
                            <div style="display:flex; justify-content:center; width:100%">

                                <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab2');" title="next" style="background: #4d94ff !important; border-color:#4d94ff !important; color:white !important">
                                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-right"></i></span>Next</a>
                            </div>
                        </div>

                        @if($rows['Experience']['cert'][0]['id'] !=null)


                        <div id="tab2">
                            <section class="section">


                                <div class="section-body mt-0">

                                    @foreach($rows['Experience']['cert'] as $data)

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Name of the Professional Body:<span class="error-star" style="color:red;">*</span></label>
                                                <input class="form-control default cert" placeholder="Enter the Professional body" type="text" id="nopb" name="cert[{{$loop->iteration - 1}}][nopb]" value="{{$data['nopb']}}" autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Certificate Issued By:<span class="error-star" style="color:red;">*</span></label>
                                                <input class="form-control default" placeholder="Enter the Certificate issued by" type="text" id="certib" name="cert[{{$loop->iteration - 1}}][ib]" value="{{$data['certib']}}" autocomplete="off">
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Certification Documents:<span class="error-star" style="color:red;">*</span></label>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>{{$data['certfn']}}</label>
                                                            <input type="hidden" name="cert[{{$loop->iteration - 1}}][certfn_old]" value="{{$data['certfn']}}">
                                                            <input type="hidden" name="cert[{{$loop->iteration - 1}}][certfp_old]" value="{{$data['certfp']}}">
                                                            <a type="button" class="btn btn-success " title="Download Documents" href="{{$data['certfp']}}/{{$data['certfn']}}" download><i class="fa fa-download" style="color:white!important"></i></a>
                                                            <a class="btn btn-primary" title="view Document" data-toggle="modal" data-target="#templates" onClick="getproposaldocument('{{$data['certfp']}}/{{$data['certfn']}}')"><i class="fa fa-eye" style="color:white!important"></i></a>

                                                        </div>
                                                    </div>



                                                </div>


                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <button type="button" class="btn btn-info " id="wrk1" title="change Documents" value="1" onclick="changefile1(this)"><i class="fa fa-exchange" id="workexp1" style="color:white!important">Change file</i></button>
                                                <input type="hidden" id="work1" name="wrk1" value="1">
                                            </div>
                                            <div class="col-md-6" id="expf1" style="display:none;">
                                                <input class="form-control " type="file" accept=".pdf,.png," id="certd" name="cert[{{$loop->iteration - 1}}][certd]" value="" autocomplete="off">
                                                <strong style="color: red;">Following files could be uploaded pdf,png</strong>
                                            </div>
                                        </div>

                                        <div class="row" style="padding-top: 19px;">
                                            <input type="hidden" name="attachment_countc" id="attachment_countc" value="1">
                                            <div class="col-md-12" id="dynamic_fieldc"></div>
                                            <button type="button" name="addc" id="addc" class="btn btn-primary" style="background-color: #67c8e2 !important">Add Certification</button>
                                        </div>
                                    </div>
                                    @endforeach
                                    <div class="row" style="padding-top: 20px;">
                                        <input type="hidden" name="attachment_countc" id="attachment_countc" value="1">
                                        <button type="button" name="addc" id="addc" class="btn btn-primary" style="background-color: #67c8e2 !important">Add Certification</button>

                                        <div class="col-md-12" id="dynamic_fieldc"></div>
                                        <!-- <button type="button" name="addc" id="addc" class="btn btn-primary" style="background-color: #67c8e2 !important">Add Certification</button> -->
                                    </div>

                                </div>

                            </section>


                        </div>

                        @else


                        <div id="tab2">
                            <section class="section">


                                <div class="section-body mt-0">


                                    <div class="row">
                                        <!-- <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Name of the Professional Body:<span class="error-star" style="color:red;">*</span></label>
                                                <input class="form-control default" placeholder="Enter the Professional body" type="text" id="nopb" name="cert[0][nopb]" autocomplete="off" value="">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Certificate Issued By:<span class="error-star" style="color:red;">*</span></label>
                                                <input class="form-control default" placeholder="Enter the Certificate issued by" type="text" id="certib" name="cert[0][ib]" value="" autocomplete="off">
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="control-label">Certification Documents:<span class="error-star" style="color:red;">*</span></label>
                                                <input class="form-control " type="file" id="certd" name="cert[0][certd]" value="" accept=".pdf,.png," autocomplete="off">
                                                <strong style="color: red;">Following files could be uploaded pdf,png</strong>
                                            </div>

                                        </div> -->
                                        <input type="hidden" name="attachment_countc" id="attachment_countc" value="1">
                                        <div id="dynamic_fieldc"></div>
                                        <button type="button" name="addc" id="addc" class="btn btn-primary" style="background-color: #67c8e2 !important">Add Certification</button>


                                    </div>

                                </div>

                            </section>


                        </div>
                        @endif


                    </div>

                    @endif
                    <div style="display:flex; justify-content:center; width:100%">
                        <a type="button" class="btn btn-labeled btn-info" href="{{url('workexp_index')}}" title="next" style="background: red !important; border-color:red !important; color:white !important; margin-top:15px !important;">
                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>
                        <a type="submit" onclick="expcre()" id="registerbutton" class="btn btn-labeled btn-info" title="Submit" style="background: green !important; border-color:green !important; color:white !important;  margin-top:15px !important; margin-left:15px !important;">
                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Update</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>


<script type="application/javascript">
    function calculateYearDifference(dateString1, dateString2) {
        if (dateString1 == "") {
            return 0;
        }
        const parts1 = dateString1.split('-');
        const parts2 = dateString2.split('-');

        const date1 = new Date(parts1[2], parts1[1] - 1, parts1[0]);
        const date2 = new Date(parts2[2], parts2[1] - 1, parts2[0]);

        if (isNaN(date1.getTime()) || isNaN(date2.getTime())) {
            return 0;
        }

        const yearDifference = date2.getFullYear() - date1.getFullYear();

        return yearDifference;
    }

    function date_picker() {
        var $j = jQuery.noConflict();

        // Initialize datepickers with class selectors
        $j(".fde").datepicker({
            dateFormat: "dd-mm-yy",
            maxDate: 0,
            changeYear: true,
            onSelect: function(selectedDate) {
                const parts = selectedDate.split('-');
                const day = parseInt(parts[0], 10);
                const month = parseInt(parts[1], 10) - 1;
                const year = parseInt(parts[2], 10);

                const selected = new Date(year, month, day);
                selected.setDate(selected.getDate() + 1);

                // Find the corresponding tde input within the same group
                const $tde = $(this).closest(".date_pic").next().find(".tde");
                $tde.prop("disabled", false);
                $tde.datepicker("option", "minDate", selected);
            }
        });

        $j(".tde").datepicker({
            dateFormat: "dd-mm-yy",
            maxDate: 0,
            changeYear: true,
            beforeShowDay: function(date) {
                const $group = $j(this).closest(".date_pic").prev();
                const fromDate = $group.find(".fde").datepicker("getDate");
                if (fromDate) {
                    return [date.getTime() >= fromDate.getTime()];
                }
                return [true];
            }
        });
    }

    function calculateYears(startDate, endDate) {
        var startParts = startDate.split("-");
        var endParts = endDate.split("-");

        // Extract day, month, and year from the date parts
        var startDay = parseInt(startParts[0], 10);
        var startMonth = parseInt(startParts[1], 10) - 1; // Month is zero-based
        var startYear = parseInt(startParts[2], 10);

        var endDay = parseInt(endParts[0], 10);
        var endMonth = parseInt(endParts[1], 10) - 1; // Month is zero-based
        var endYear = parseInt(endParts[2], 10);

        var start = new Date(startYear, startMonth, startDay);
        var end = new Date(endYear, endMonth, endDay);

        var years = end.getFullYear() - start.getFullYear();

        // Check if the end date's month and day is less than the start date's month and day
        if (
            end.getMonth() < start.getMonth() ||
            (end.getMonth() === start.getMonth() && end.getDate() < start.getDate())
        ) {
            years--;
        }

        return years;
    }

    function yearcount(e) {
        date_picker();
        // fde = e.target.classList[4];
        // fde_class = fde.split('_')[1];
        // var newClassName = 'fde_' + fde_class;

        // var element = document.querySelector(`.${newClassName}`);
        // var value = element.value;

        // if (value == '') {

        // } else {

        //     var years = calculateYears(value, e.target.value);

        // }

        const tde_fde_all = document.querySelectorAll('.wrq.dob');

        var date_count = (tde_fde_all.length) / 2;
        if (date_count == 1) {
            date_count = 2;
        }
        var years = 0;
        for (let index = 0; index < date_count; index++) {
            var fde_value = $(`.fde_${index}`).val();
            var tde_value = $(`.tde_${index}`).val();
            if (fde_value) {
                var current_years = calculateYears(fde_value, tde_value);
                years += current_years;

            }

        }
        $('#experience').val(years);
    }
    $(document).on('click', '.btn_remove_company', function(e) {
        var id = e.target.id;
        const date1 = $(`.fde_${id}`).val();
        const date2 = $(`.tde_${id}`).val();
        const difference = calculateYearDifference(date1, date2);
        const experience = $('#experience').val();
        const newExperience = experience - difference;
        $('#experience').val(newExperience);

        e.target.closest('.input-box').remove();


        // var button_id = $(this).attr("id");
        // $('#row' + button_id + '').remove();
        // $("#attachment_counte").val(j);
    });
    $(document).ready(function() {
        document.getElementById('qv2').style.display = "none";
        // document.getElementById('s11').style.display = "none";
        // document.getElementById('s21').style.display = "none";
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
        date_picker();
    });

    function DoAction(id) {

        $("#content").find("[id^='tab']").hide(); // Hide all content
        $("#tabs li").removeClass("active"); //Reset id's
        $("#tabs a").removeClass("active"); //Reset id's
        $("a[name='" + id + "']").parent().addClass("active");
        $('#' + (id)).fadeIn(); // Show content for the current tab

    }

    function radchange(a) {

        var a = a.value;
        if (a == "yes") {
            document.getElementById('qv2').style.display = "none";
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

    function workchanges(a, b) {
        var a = a.value;

        if (a == "employee") {
            document.getElementById('s2' + b).style.display = "none";
            document.getElementById('rel' + b).removeAttribute('required', 'required');
            document.getElementById('s1' + b).style.display = "inline-block";
            document.getElementById('des' + b).setAttribute('required', 'required');
        } else {
            document.getElementById('s1' + b).style.display = "none";
            document.getElementById('des' + b).removeAttribute('required', 'required');
            document.getElementById('s2' + b).style.display = "inline-block";
            document.getElementById('rel' + b).setAttribute('required', 'required');

        }
    }

    var j = 1;
    $("#adde").click(function() {
        var q = j + 1;
        // $('#dynamic_field').append('<div id="row'+i+'"><div class=""><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list"/></td><td><input type="text" name="email[]" placeholder="Enter your Email" class="form-control name_email"/></td><td></div>');  
        $('#dynamic_fielde').append('<section class="input-box" id="row' + j + '"><div class="row clear remove_other' + j + ' "> <div class="col-md-2"> <div class="form-group"> <label class="control-label">From Date:<span class="error-star" style="color:red;">*</span></label> <input class="form-control default  wre" value=" " type="text" onchange="yearcount(event)" placeholder="DD-MM-YYYY" oninput="input(this)" id="fde' + j + '" name="wrq[' + j + '][fde]"  autocomplete="off" > </div> </div> <div class="col-md-2"> <div class="form-group"> <label class="control-label">To Date:<span class="error-star" style="color:red;">*</span></label> <input class="form-control default  wre" type="text" value=" " onchange="yearcount(event) oninput="input(this)" placeholder="DD-MM-YYYY" id="tde' + j + '" name="wre[' + j + '][tde]"  autocomplete="off" > </div> </div> <div class="col-md-2"> <div class="form-group"> <label class="control-label"><span id="item_no_label"></span>Area of work:<span class="error-star" style="color:red;">*</span></label> <input class="form-control default wre" type="text" id="aow" name="wre[' + j + '][aow]" required autocomplete="off"> </div> </div> <div class="col-md-3"> <div class="form-group"> <label class="control-label"><span id="item_label"></span>Employment/Practice:<span class="error-star" style="color:red;">*</span></label> <div class="switch-field" style="padding-left:12px"> <input type="radio" class="wre" id="radio-one' + j + '" name="wre[' + j + '][ep]" value="employee" required onchange="workchanges(this,' + q + ')" /> <label for="radio-one' + j + '">Employment</label> <input type="radio" class="wre" id="radio-two' + j + '" name="wre[' + j + '][ep]" value="practice" required onchange="workchanges(this,' + q + ')" /> <label for="radio-two' + j + '">Practice</label> </div> </div> </div> <div class="col-md-2" id="s1' + q + '" style="display:none"> <div class="form-group "> <label class="control-label"><span id="item_no_label1"></span>Designation:<span class="error-star" style="color:red;">*</span></label> <input class="form-control default  wre" type="text" id="des' + q + '" name="wre[' + j + '][des]" required autocomplete="off"> </div> </div> <div class=" col-md-2" id="s2' + q + '" style="display:none"> <div class="form-group"> <label class="control-label"><span id="item_no_label2"></span>Exp in the relvt valuation:<span class="error-star" style="color:red;">*</span></label> <input class="form-control default wre" type="text" id="rel' + q + '" name="wre[' + j + '][rel]" required autocomplete="off"> </div> </div></div><div class="col-md-3"><div class="form-group"><label class="control-label"><span id="item_label"></span>Scope & Responsibilities:</label><textarea rows="10" columns="10" placeholder="Scope & Responsibilities" class="form-control default wre" type="text" id="scoope" name="wre[' + i + '][scope]" autocomplete="off"></textarea></div><div><button style="margin-top:30px" type="button" name="remove" id="' + j + '" class="btn btn-danger btn_remove">X</button></div></div></section>');
        j++;

        $("#attachment_counte").val(j);

    });

    $(document).on('click', '.btn_remove', function() {
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
        $("#attachment_counte").val(j);
    });


    $("#addc").click(function() {
        var i = $('.cert').length;
        var q = j + 1;
        // $('#dynamic_field').append('<div id="row'+i+'"><div class=""><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list"/></td><td><input type="text" name="email[]" placeholder="Enter your Email" class="form-control name_email"/></td><td></div>');  
        $('#dynamic_fieldc').append('<section class="input-box" id="row flex' + j + '"><div class="row clear remove_other' + j + ' "><div class="col-md-4"> <div class="form-group"> <label class="control-label">Name of the Professional Body:<span class="error-star" style="color:red;">*</span></label> <input class="form-control default" type="text" id="nopb" name="cert[' + i + '][nopb]" autocomplete="off" required value="" > </div> </div> <div class="col-md-3"> <div class="form-group"> <label class="control-label">Certificate issued by:<span class="error-star" style="color:red;">*</span></label> <input class="form-control default" type="text" id="certib" name="cert[' + i + '][ib]" required value="" autocomplete="off">  </div> </div> <div class="col-md-3"> <div class="form-group"> <label class="control-label">Certification Documents:<span class="error-star" style="color:red;">*</span></label> <input class="form-control" type="file" id="certd" name="cert[' + i + '][certd]" required value="" autocomplete="off"> 	<strong style="color: red;">Following files could be uploaded pdf,png</strong> </div> </div> <div><button style="margin-top:30px" type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></div></div></section>');
        i++;

        $("#attachment_countc").val(i);

    });
    var i = $('.C_name').length;

    $("#addcompany").click(function() {
        const company_all = document.querySelectorAll('#C_name');
        for (const comp of company_all) {
            if (comp.value == '') {
                swal.fire("Please Enter All the Company Fields", "", "error");

                return false;
            }
        }


        const designation_all = document.querySelectorAll('#designation_valuation');
        for (const desig of designation_all) {
            if (desig.value == '') {
                swal.fire("Please Enter All the Designation", "", "error");

                return false;
            }
        }


        const fdate_all = document.querySelectorAll('#qv1 .fde');
        for (const fde of fdate_all) {
            if (fde.value == '') {
                swal.fire("Please Enter All the From Date", "", "error");

                return false;
            }
        }


        const tdate_all = document.querySelectorAll('#qv1 .tde');
        for (const tde of tdate_all) {
            if (tde.value == '') {
                swal.fire("Please Enter All the To Date", "", "error");

                return false;
            }
        }


        // const scoope_all = document.querySelectorAll('#scoope');
        // for (const scope of scoope_all) {
        //     if (scope.value == '') {
        //         swal.fire("Please Enter the Scope & Responsibilities", "", "error");

        //         return false;
        //     }
        // }

        // $('#dynamic_field').append('<div id="row'+i+'"><div class=""><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list"/></td><td><input type="text" name="email[]" placeholder="Enter your Email" class="form-control name_email"/></td><td></div>');    
        $('#dynamic_addc').append('<section class="input-box" id="row' + j + '"><div class="row clear remove_other' + j + '"><div class="row"><div class="form-group"><label class="control-label">Company Name<span class="error-star" style="color:red;">*</span></label><input class="form-control default  wrq" placeholder="Enter the Company name" type="text" id="C_name" name="wrq[' + i + '][c_name]" autocomplete="off" required value=""></div>  <div class="col-md-3"><div class="form-group"><label class="control-label">Designation<span class="error-star" style="color:red;">*</span></label><input class="form-control default wrq" type="text" placeholder="Enter the designation" id="designation_valuation" name="wrq[' + i + '][designation]" value="" autocomplete="off"></div></div><div class="col-md-2"> <div class="form-group"> <label class="control-label">From Date:<span class="error-star" style="color:red;">*</span></label><input class="form-control default  wrq dob" value=" " type="text" oninput="input(this)" id="fde" name="wrq[' + i + '][fde]"  placeholder="DD-MM-YYYY" autocomplete="off"></div></div><div class="col-md-2"><div class="form-group"><label class="control-label">To Date:</label><input class="form-control default  wrq dob" type="text" oninput="input(this)" id="tde" value="" name="wrq[' + i + '][tde]" required autocomplete="off"></div></div><div class="col-md-3"><div class="form-group"><label class="control-label"><span id="item_label"></span>Scope & Responsibilities:</label><div class="d-flex"><textarea rows="10" columns="10" placeholder="Scope & Responsibilities" class="form-control default wre" type="text" id="aow" name="wrq[' + i + '][scope]" autocomplete="off"></textarea><button style="margin-top:30px" type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></div></div></div></section>');
        i++;

        $("#attachment_counter").val(i);

    });


    $(document).on('click', '.btn_remove', function() {
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
        $("#attachment_countc").val(i);
    });


    function changefile1(a) {


        var a = a.value;
        if (a == "1") {
            document.getElementById('expf1').style.display = "inline-block";
            $('#wrk1').val('0');
            document.getElementById('workexp1').innerText = " Stay The Same";
        } else {
            document.getElementById('expf1').style.display = "none";
            $('#wrk1').val('1');


            document.getElementById('workexp1').innerText = " Change File";
        }
    };
</script>



<!-- Deepika -->

<!-- Work Experience validation -->

<script>
    function expcre() {


        // var yes = document.getElementById('radio-one12');
        // var no = document.getElementById('radio-two12');
        // if (yes.checked == false && no.checked == false) {
        //     swal.fire("Please Enter YES or NO", "", "error");
        //     event.preventDefault();
        //     return false;
        // }

        // var yes = document.getElementById('radio-one12');
        // var no = document.getElementById('radio_two12');

        // if (yes.checked == true) {
        //     var experience = $("#experience").val();
        //     if (experience == '') {
        //         swal.fire("Please Enter the experience", "", "error");
        //         event.preventDefault();
        //         return false();
        //     }
        //     var comp = $("#C_name").val();
        //     if (comp == '') {
        //         swal.fire("Please Enter the Company Name", "", "error");
        //         event.preventDefault();
        //         return false();
        //     }
        //     var proo = $("#designation_valuation").val();
        //     if (proo == '') {
        //         swal.fire("Please Enter the Designation", "", "error");
        //         event.preventDefault();
        //         return false();
        //     }


        //     var fdate = $("#fde").val();

        //     if (fdate == '') {
        //         swal.fire("Please Enter the From Date", "", "error");
        //         event.preventDefault();
        //         return false();
        //     }

        //     var tdate = $("#tde").val();
        //     if (tdate == '') {
        //         swal.fire("Please Enter the To Date", "", "error");
        //         event.preventDefault();
        //         return false();
        //     }


        //     var scope = $("#scoope").val();
        //     if (scope == '') {
        //         swal.fire("Please Enter the Scope & Responsibilities", "", "error");
        //         event.preventDefault();
        //         return false();
        //     }



        //     event.preventDefault();
        //     Swal.fire({

        //         title: "Are you want to submit?",
        //         text: "Please click yes,If you want to save the details or No, to Fill Certification Details.",
        //         icon: "warning",
        //         customClass: 'swalalerttext',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         confirmButtonText: "Yes",
        //         cancelButtonText: "No",
        //         closeOnConfirm: false,
        //         closeOnCancel: true,
        //         showLoaderOnConfirm: true,
        //         width: '550px',
        //     }).then((result) => {
        //         if (result.value) {


        //             document.getElementById('educreate_form').submit();

        //         } else {
        //             $("#content").find("[id^='tab']").hide(); // Hide all content
        //             $("#tabs li").removeClass("active"); //Reset id's
        //             $("#certification").addClass("active"); // Activate this

        //             document.getElementById("tab2").style.display = "block";

        //         }
        //     })
        // } else {

        //     var nopb = document.getElementById('nopb');
        //     if (nopb.value == '') {
        //         event.preventDefault();
        //         Swal.fire({

        //             title: "Are you want to submit?",
        //             text: "Please click yes,If you want to save the details or No, to Fill Certification Details.",
        //             icon: "warning",
        //             customClass: 'swalalerttext',
        //             showCancelButton: true,
        //             confirmButtonColor: '#3085d6',
        //             confirmButtonText: "Yes",
        //             cancelButtonText: "No",
        //             closeOnConfirm: false,
        //             closeOnCancel: true,
        //             showLoaderOnConfirm: true,
        //             width: '550px',
        //         }).then((result) => {
        //             if (result.value) {


        //                 document.getElementById('educreate_form').submit();

        //             } else {
        //                 $("#content").find("[id^='tab']").hide(); // Hide all content
        //                 $("#tabs li").removeClass("active"); //Reset id's
        //                 $("#certification").addClass("active"); // Activate this

        //                 document.getElementById("tab2").style.display = "block";

        //             }
        //         })
        //     } else {

        //         var cert = $("#nopb").val();
        //         if (cert == '') {
        //             swal.fire("Please Enter the Name of the Professional Body", "", "error");
        //             event.preventDefault();
        //             return false;
        //         }
        //     }


        //     const designation_all = document.querySelectorAll('#designation_valuation');
        //     for (const desig of designation_all) {
        //         if (desig.value == '') {
        //             swal.fire("Please Enter All the Designation", "", "error");

        //             return false;
        //         }
        //     }


        //     const fdate_all = document.querySelectorAll('#qv1 .fde');
        //     for (const fde of fdate_all) {
        //         if (fde.value == '') {
        //             swal.fire("Please Enter All the From Date", "", "error");

        //             return false;
        //         }
        //     }


        //     const tdate_all = document.querySelectorAll('#qv1 .tde');
        //     for (const tde of tdate_all) {
        //         if (tde.value == '') {
        //             swal.fire("Please Enter All the To Date", "", "error");

        //             return false;
        //         }
        //     }


            // const scoope_all = document.querySelectorAll('#scoope');
            // for (const scope of scoope_all) {
            //     if (scope.value == '') {
            //         swal.fire("Please Enter the Scope & Responsibilities", "", "error");

            //         return false;
            //     }
            // }

        // }

        // if (certificate.hasClass('active')) {
        //     const cert_all = document.querySelectorAll('#nopb');
        //     for (const nopb of cert_all) {
        //         if (nopb.value == '') {
        //             swal.fire("Please Enter the Name of the Professional Body", "", "error");
        //             return false;
        //         }
        //     }


        //     const certissue_all = document.querySelectorAll('#certib');
        //     for (const certib of certissue_all) {
        //         if (certib.value == '') {
        //             swal.fire("Please Enter the Certificate issued by", "", "error");
        //             return false;
        //         }
        //     }
        //     const certd_all = document.querySelectorAll('#certd');
        //     for (const certd of certd_all) {
        //         if (certd.parentElement.style.display == "inline-block") {
        //             if (certd.value == '') {
        //                 swal.fire("Please Upload the Certification Documents", "", "error");
        //                 return false;
        //             }

        //         }

        //     }
        // }

        $('#eduedit_form').submit();


    }
</script>



<script>
    function calculateYears(startDate, endDate) {
        var startParts = startDate.split("-");
        var endParts = endDate.split("-");

        // Extract day, month, and year from the date parts
        var startDay = parseInt(startParts[0], 10);
        var startMonth = parseInt(startParts[1], 10) - 1; // Month is zero-based
        var startYear = parseInt(startParts[2], 10);

        var endDay = parseInt(endParts[0], 10);
        var endMonth = parseInt(endParts[1], 10) - 1; // Month is zero-based
        var endYear = parseInt(endParts[2], 10);

        var start = new Date(startYear, startMonth, startDay);
        var end = new Date(endYear, endMonth, endDay);

        var years = end.getFullYear() - start.getFullYear();

        // Check if the end date's month and day is less than the start date's month and day
        if (
            end.getMonth() < start.getMonth() ||
            (end.getMonth() === start.getMonth() && end.getDate() < start.getDate())
        ) {
            years--;
        }

        return years;
    }

    function yearcount(e) {
        // alert("hdjs");
        // fde = e.target.classList[4];
        // fde_class = fde.split('_')[1];
        // var newClassName = 'fde_' + fde_class;

        // var element = document.querySelector(`.${newClassName}`);
        // var value = element.value;

        // if (value == '') {

        // } else {

        //     var years = calculateYears(value, e.target.value);

        // }

        const tde_fde_all = document.querySelectorAll('.wrq.dob');

        var date_count = (tde_fde_all.length) / 2;
        if (date_count == 1) {
            date_count = 2;
        }
        var years = 0;
        for (let index = 0; index < date_count; index++) {
            var fde_value = $(`.fde_${index}`).val();
            var tde_value = $(`.tde_${index}`).val();
            if (fde_value) {
                var current_years = calculateYears(fde_value, tde_value);
                years = years + current_years;

            }

        }

        $('#experience_years').val(years);
    }
</script>






<script>
    function getproposaldocument(id) {
        var id = (id);

        $.ajax({
            url: "{{url('view_proposal_documents')}}",
            type: 'post',
            data: {
                id: id,
                _token: '{{csrf_token()}}'
            },
            error: function() {},
            success: function(data) {
                if (data.length > 0) {
                    $("#loading_gif").hide();
                    var proposaldocuments = "<div class='removeclass' style=' height:100%'><iframe src='" + data + "' class='document_ifarme_view' style='width:100%; height:100%'></iframe></div>";
                    $('.removeclass').remove();
                    var document = $('#template').append(proposaldocuments);

                }
            }
        });
    };
</script>

<script>
    function getproposaldocument(id) {

        var data = (id);
        $('#modalviewdiv').html('');
        $("#loading_gif").show();

        $("#loading_gif").hide();
        var proposaldocuments = "<div class='removeclass' id='modalviewdiv' style=' height:100%'><iframe src='" + data + "' class='document_ifarme_view' style='width:100%; height:100%'></iframe></div>";
        $('.removeclass').remove();
        var document = $('#template').append(proposaldocuments);

    };
</script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

@include('Registration.formmodal')

@endsection