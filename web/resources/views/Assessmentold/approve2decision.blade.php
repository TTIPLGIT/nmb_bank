@extends('layouts.adminnav')

@section('content')
<style>
    #tabs {
        overflow: hidden;
        width: 100%;
        margin: 0;

        padding: 0;
        list-style: none;
        font-size: 16px !important;

    }
    .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
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
</style>
<div class="main-content">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12">
            <div class="" style="height:100%; padding: 15px">

                <form action="{{ route('Registration.update',1) }}" method="POST" id="generalupdate_form" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <input type="hidden" class="form-control" required id="user_details" name="user_details" readonly value="general">
                    <div class="tile" id="tile-1" style="margin-top:10px !important;">

                        <!-- Nav tabs -->

                        <ul class="nav nav-tabs nav-justified tabs" id="tab" role="tablist">

                            <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                                <a class="nav-link" id="home-tab" name="tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-user"></i><b> Asset Owner Details</b> <input type="checkbox" class="checkg" id="profile" name="nationality" readonly value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
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

                                    <!--  -->
                                    <div class="table-wrapper">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" style="text-align:center;table-layout: fixed;" >
                                                <thead>
                                                    <tr>
                                                        <th style="width: 7%">S.No</th>
                                                        <th style="width: 15%">Asset Owner Name</th>
                                                        <th style="width: 15%">Valuation Request Number</th>                                      
                                                        <!-- <td style="word-break: break-all;">VR-001</td> -->
                                                        <th style="width: 15%">Date-of-Birth</th>
                                                        <th style="width: 30%">Address</th>
                                                        <th style="width: 20%">NIN Number</th>
                                                        <th style="width: 20%"> Attachments</th>
                                                        <th style="width: 10%">View</th>
                                                    </tr>
                                                </thead>
                                                <tbody>


                                                    <tr class="trc">
                                                        <td>1</td>
                                                        <td style="word-break: break-all;">Rahul</td>
                                                        <td style="word-break: break-all;">VR-001</td>
                                                        <td style="word-break: break-all;">11-12-1976 </td>
                                                        <td style="word-break: break-all;">No 40 MacKinnon Road, Amolator, Bukanga County, Nububya, Bugoba

                                                        <td style="word-break: break-all;">67854898975</td>
                                                        </td>
                                                        <td>
                                                            <img style="width: 26px;" src="https://fia-uganda-edrms.com/images/pdf.png">







                                                            <a href="/userdocuments/registration/education/dip/cc/1/0/form-Details-(6).pdf" download="">Form1-3-05-1.pdf</a>


                                                        </td>

                                                        <td style="word-break: break-all;"><a class="btn btn-primary" title="view Document" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('/userdocuments/registration/education/dip/cc/1/0/form-Details-(6).pdf')" style="margin-inline:5px"><input type="hidden" class="cert" id="ocfn1" name="cert[0][ocfn]" value="notes-in-13-06-2022.txt"><input type="hidden" class="cert id=" ougcfp1"="" name="cert[0][ocfp]" value="/userdocuments/registration/workexp/wc/1/0"><i class="fa fa-eye" style="color:white!important"></i></a> </td>


                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!--  -->
                                    <input type="hidden" class="form-control" required id="user_id" name="user_id" readonly value="">
                                    <input type="hidden" class="form-control" required id="user_details" name="user_details" readonly value="general">



                                </div>

                            </section>

                        </div>

                    </div>



                    <div class="tile" id="tile-1" style="margin-top:10px !important;">

                        <!-- Nav tabs -->

                        <ul class="nav nav-tabs nav-justified tabs" id="tab" role="tablist">

                            <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                                <a class="nav-link  " id="home-tab" name="" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><img src="{{asset('assets/images/specific1.svg')}}" style=" filter: invert(1) contrast(4.5);" alt="" width="35" height="36"><b> valuation Specification Details</b> <input type="checkbox" class="checkg" id="profile" name="nationality" readonly value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
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

                                    <input type="hidden" class="form-control" required id="user_id" name="user_id" readonly value="">
                                    <input type="hidden" class="form-control" required id="user_details" name="user_details" readonly value="general">

                                    <table class="table table-bordered" style="text-align:center;table-layout: fixed;">
                                        <thead>
                                            <tr>
                                                <th style="width: 7%">S.No</th>
                                                <th style="width: 15%">Asset Name</th>
                                                <th style="width: 10%">Asset Type</th>
                                                <th style="width: 15%">Purpose of valuation</th>
                                                <th style="width: 30%">Address</th>
                                                <th style="width: 20%"> Attachments</th>
                                                <th style="width: 10%">View</th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                            <tr class="trc">
                                                <td>1</td>
                                                <td style="word-break: break-all;">Land</td>
                                                <td style="word-break: break-all;">Land</td>
                                                <td style="word-break: break-all;">To Sell The Land</td>
                                                <td style="word-break: break-all;">No 40 MacKinnon Road, Amolator, Bukanga County, Nububya, Bugoba</td>
                                                <td>
                                                    <img style="width: 26px;" src="https://fia-uganda-edrms.com/images/pdf.png">
                                                    <a href="/userdocuments/registration/education/dip/cc/1/0/form-Details-(6).pdf" download="">Form1-3-05-1.pdf</a>


                                                </td>

                                                <td style="word-break: break-all;"><a class="btn btn-primary" title="view Document" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('/userdocuments/registration/education/dip/cc/1/0/form-Details-(6).pdf')" style="margin-inline:5px"><input type="hidden" class="cert" id="ocfn1" name="cert[0][ocfn]" value="notes-in-13-06-2022.txt"><input type="hidden" class="cert id=" ougcfp1"="" name="cert[0][ocfp]" value="/userdocuments/registration/workexp/wc/1/0"><i class="fa fa-eye" style="color:white!important"></i></a> </td>


                                            </tr>

                                        </tbody>
                                    </table>




                                    <div class="row">
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
                                    </div>

                                </div>

                            </section>

                        </div>

                    </div>



                    <div class="tile" id="tile-1" style="margin-top:10px !important;">

                        <!-- Nav tabs -->

                        <ul class="nav nav-tabs nav-justified " id="tabs" role="tablist">

                            <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                                <a class="nav-link  " id="home-tab" name="tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><img src="{{asset('assets/images/assetn.svg')}}" style=" filter: invert(1) contrast(4.5);" alt="" width="20" height="26"><b> Asset Details</b> <input type="checkbox" class="checkg" id="profile" name="nationality" readonly value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                    <div class="check"></div>
                                </a>

                            </li>
                            <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                                <a class="nav-link  " id="home-tab" name="tab2" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fas fa-balance-scale"></i><b> Legal Existence and Ownership Details</b> <input type="checkbox" class="checkg" id="profile" name="nationality" readonly value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                    <div class="check"></div>
                                </a>

                            </li>
                            <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                                <a class="nav-link  " id="home-tab" name="tab3" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><b><img src="{{asset('assets/images/assect_document_img1.svg')}}" style=" filter: invert(1) contrast(4.5);" alt="" width="35" height="26"></b><b> Asset documents</b> <input type="checkbox" class="checkg" id="profile" name="nationality" readonly value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
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

                                    <input type="hidden" class="form-control" required id="user_id" name="user_id" readonly value="">
                                    <input type="hidden" class="form-control" required id="user_details" name="user_details" readonly value="general">
                                    <table class="table table-bordered" style="text-align:center;table-layout: fixed;">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%">Sl.No</th>
                                                <th style="width: 20%">Survey Number</th>
                                                <th style="width: 20%"> Extend Of Land</th>
                                                <th style="width: 30%">Land Classification</th>
                                                <th style="width: 20%">Land units(Acres)</th>

                                            </tr>
                                        </thead>
                                        <tbody>


                                            <tr class="trc">
                                                <td>1</td>
                                                <td style="word-break: break-all;">Ls123</td>
                                                <td style="word-break: break-all;">20 Meter</td>
                                                <td style="word-break: break-all;">Real Estate</td>
                                                <td style="word-break: break-all;">4</td>
                                            </tr>
                                            <tr class="trc">
                                                <td>2</td>
                                                <td style="word-break: break-all;">Ls125</td>
                                                <td style="word-break: break-all;">23 Meter</td>
                                                <td style="word-break: break-all;">Agirculture</td>
                                                <td style="word-break: break-all;">7</td>
                                            </tr>

                                        </tbody>
                                    </table>





                                </div>

                            </section>

                        </div>
                        <div id="tab2">
                            <section class="section">
                                <div class="section-body mt-1">

                                    <input type="hidden" class="form-control" required id="user_id" name="user_id" readonly value="">
                                    <input type="hidden" class="form-control" required id="user_details" name="user_details" readonly value="general">

                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Land Owned Date:<span class="error-star" style="color:red;">*</span></label>
                                                <input type="date" class="form-control default" required id="asset_name" name="asset_name" readonly value="2000-12-02">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="egc" style="display: flex;  align-items: center;">
                                                    <div class="dq"><span class="questions">If He/She had Other Ownership to Land:</span></div>

                                                    <div class="switch-field" style="padding-left:12px">
                                                        <input type="radio" id="radio-one13" name="first" readonly value="yes" required onchange="radchange(this)" Checked />
                                                        <label for="radio-one13">Yes</label>
                                                        <input type="radio" id="radio-two13" name="first" readonly value="no" required onchange="radchange(this)" />
                                                        <label for="radio-two13">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <table class="table table-bordered" style="text-align:center;table-layout: fixed;">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%">Sl.No</th>
                                                <th style="width: 20%">Name</th>
                                                <th style="width: 20%"> Relation to the Asset's Owner</th>
                                                <th style="width: 30%">Date of Birth</th>


                                            </tr>
                                        </thead>
                                        <tbody>


                                            <tr class="trc">
                                                <td>1</td>
                                                <td style="word-break: break-all;">Raju</td>
                                                <td style="word-break: break-all;">Son</td>
                                                <td style="word-break: break-all;">08-01-1998</td>

                                            </tr>
                                            <tr class="trc">
                                                <td>2</td>
                                                <td style="word-break: break-all;">Roshini</td>
                                                <td style="word-break: break-all;">Daughter</td>
                                                <td style="word-break: break-all;">08-01-1995</td>

                                            </tr>

                                        </tbody>
                                    </table>



                                </div>

                            </section>

                        </div>

                        <div id="tab3">
                            <section class="section">
                                <div class="section-body mt-1">

                                    <input type="hidden" class="form-control" required id="user_id" name="user_id" readonly value="">
                                    <input type="hidden" class="form-control" required id="user_details" name="user_details" readonly value="general">




                                    <table class="table table-bordered" style="text-align:center;table-layout: fixed;">
                                        <thead>
                                            <tr >
                                                <th style="width: 10%">S.No</th>
                                                <th style="width: 45%">Document Type</th>
                                                <th style="width: 35%">Attachment</th>

                                                <th style="width: 10%">View</th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                            <tr class="trc">
                                                <td>1</td>
                                                <td style="word-break: break-all;">Lease Deed or Purchase Deed of the Property</td>
                                                <td> <img style="width: 26px;" src="https://fia-uganda-edrms.com/images/pdf.png">
                                                    <a href="/userdocuments/registration/education/dip/cc/1/0/form-Details-(6).pdf" download="">Form1-3-05-1.pdf</a>
                                                </td>

                                                <td style="word-break: break-all;"><a class="btn btn-primary" title="view Document" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('/userdocuments/registration/education/dip/cc/1/0/form-Details-(6).pdf')" style="margin-inline:5px"><input type="hidden" class="cert" id="ocfn1" name="cert[0][ocfn]" value="notes-in-13-06-2022.txt"><input type="hidden" class="cert id=" ougcfp1"="" name="cert[0][ocfp]" value="/userdocuments/registration/workexp/wc/1/0"><i class="fa fa-eye" style="color:white!important"></i></a> </td>
                                            </tr>
                                            <tr class="trc">
                                                <td>2</td>
                                                <td style="word-break: break-all;">Latest Electricity Bill</td>
                                                <td> <img style="width: 26px;" src="https://fia-uganda-edrms.com/images/pdf.png">
                                                    <a href="/userdocuments/registration/education/dip/cc/1/0/form-Details-(6).pdf" download="">Form1-3-05-1.pdf</a>
                                                </td>

                                                <td style="word-break: break-all;"><a class="btn btn-primary" title="view Document" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('/userdocuments/registration/education/dip/cc/1/0/form-Details-(6).pdf')" style="margin-inline:5px"><input type="hidden" class="cert" id="ocfn1" name="cert[0][ocfn]" value="notes-in-13-06-2022.txt"><input type="hidden" class="cert id=" ougcfp1"="" name="cert[0][ocfp]" value="/userdocuments/registration/workexp/wc/1/0"><i class="fa fa-eye" style="color:white!important"></i></a> </td>
                                            </tr>
                                            <tr class="trc">
                                                <td>3</td>
                                                <td style="word-break: break-all;">Latest Property Tax Receipt</td>
                                                <td> <img style="width: 26px;" src="https://fia-uganda-edrms.com/images/pdf.png">
                                                    <a href="/userdocuments/registration/education/dip/cc/1/0/form-Details-(6).pdf" download="">Form1-3-05-1.pdf</a>
                                                </td>

                                                <td style="word-break: break-all;"><a class="btn btn-primary" title="view Document" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('/userdocuments/registration/education/dip/cc/1/0/form-Details-(6).pdf')" style="margin-inline:5px"><input type="hidden" class="cert" id="ocfn1" name="cert[0][ocfn]" value="notes-in-13-06-2022.txt"><input type="hidden" class="cert id=" ougcfp1"="" name="cert[0][ocfp]" value="/userdocuments/registration/workexp/wc/1/0"><i class="fa fa-eye" style="color:white!important"></i></a> </td>
                                            </tr>
                                            <tr class="trc">
                                                <td>4</td>
                                                <td style="word-break: break-all;">Factory Inspector's Approval, if applicable</td>
                                                <td> <img style="width: 26px;" src="https://fia-uganda-edrms.com/images/pdf.png">
                                                    <a href="/userdocuments/registration/education/dip/cc/1/0/form-Details-(6).pdf" download="">Form1-3-05-1.pdf</a>
                                                </td>

                                                <td style="word-break: break-all;"><a class="btn btn-primary" title="view Document" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('/userdocuments/registration/education/dip/cc/1/0/form-Details-(6).pdf')" style="margin-inline:5px"><input type="hidden" class="cert" id="ocfn1" name="cert[0][ocfn]" value="notes-in-13-06-2022.txt"><input type="hidden" class="cert id=" ougcfp1"="" name="cert[0][ocfp]" value="/userdocuments/registration/workexp/wc/1/0"><i class="fa fa-eye" style="color:white!important"></i></a> </td>
                                            </tr>
                                            <tr class="trc">
                                                <td>5</td>
                                                <td style="word-break: break-all;">Insurance Policies of Properties</td>
                                                <td> <img style="width: 26px;" src="https://fia-uganda-edrms.com/images/pdf.png">
                                                    <a href="/userdocuments/registration/education/dip/cc/1/0/form-Details-(6).pdf" download="">Form1-3-05-1.pdf</a>
                                                </td>

                                                <td style="word-break: break-all;"><a class="btn btn-primary" title="view Document" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('/userdocuments/registration/education/dip/cc/1/0/form-Details-(6).pdf')" style="margin-inline:5px"><input type="hidden" class="cert" id="ocfn1" name="cert[0][ocfn]" value="notes-in-13-06-2022.txt"><input type="hidden" class="cert id=" ougcfp1"="" name="cert[0][ocfp]" value="/userdocuments/registration/workexp/wc/1/0"><i class="fa fa-eye" style="color:white!important"></i></a> </td>
                                            </tr>
                                            <tr class="trc">
                                                <td>6</td>
                                                <td style="word-break: break-all;">Latest 7/12 Extract for free hold property</td>
                                                <td> <img style="width: 26px;" src="https://fia-uganda-edrms.com/images/pdf.png">
                                                    <a href="/userdocuments/registration/education/dip/cc/1/0/form-Details-(6).pdf" download="">Form1-3-05-1.pdf</a>
                                                </td>

                                                <td style="word-break: break-all;"><a class="btn btn-primary" title="view Document" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('/userdocuments/registration/education/dip/cc/1/0/form-Details-(6).pdf')" style="margin-inline:5px"><input type="hidden" class="cert" id="ocfn1" name="cert[0][ocfn]" value="notes-in-13-06-2022.txt"><input type="hidden" class="cert id=" ougcfp1"="" name="cert[0][ocfp]" value="/userdocuments/registration/workexp/wc/1/0"><i class="fa fa-eye" style="color:white!important"></i></a> </td>
                                            </tr>
                                            <tr class="trc">
                                                <td>7</td>
                                                <td style="word-break: break-all;">Competent Authority along with letter of Approval</td>
                                                <td> <img style="width: 26px;" src="https://fia-uganda-edrms.com/images/pdf.png">
                                                    <a href="/userdocuments/registration/education/dip/cc/1/0/form-Details-(6).pdf" download="">Form1-3-05-1.pdf</a>
                                                </td>

                                                <td style="word-break: break-all;"><a class="btn btn-primary" title="view Document" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('/userdocuments/registration/education/dip/cc/1/0/form-Details-(6).pdf')" style="margin-inline:5px"><input type="hidden" class="cert" id="ocfn1" name="cert[0][ocfn]" value="notes-in-13-06-2022.txt"><input type="hidden" class="cert id=" ougcfp1"="" name="cert[0][ocfp]" value="/userdocuments/registration/workexp/wc/1/0"><i class="fa fa-eye" style="color:white!important"></i></a> </td>
                                            </tr>
                                            <tr class="trc">
                                                <td>8</td>
                                                <td style="word-break: break-all;">Building Completion Certificate</td>
                                                <td> <img style="width: 26px;" src="https://fia-uganda-edrms.com/images/pdf.png">
                                                    <a href="/userdocuments/registration/education/dip/cc/1/0/form-Details-(6).pdf" download="">Form1-3-05-1.pdf</a>
                                                </td>

                                                <td style="word-break: break-all;"><a class="btn btn-primary" title="view Document" data-toggle="modal" data-target="#templates" onclick="getproposaldocument('/userdocuments/registration/education/dip/cc/1/0/form-Details-(6).pdf')" style="margin-inline:5px"><input type="hidden" class="cert" id="ocfn1" name="cert[0][ocfn]" value="notes-in-13-06-2022.txt"><input type="hidden" class="cert id=" ougcfp1"="" name="cert[0][ocfp]" value="/userdocuments/registration/workexp/wc/1/0"><i class="fa fa-eye" style="color:white!important"></i></a> </td>
                                            </tr>

                                            <!-- <tr>
        <td>2</td>
        <td style="word-break: break-all;">Completing form</td>
        <td style="word-break: break-all;">Foreign Request for Information</td>
        <td style="word-break: break-all;">Robert - 15/03/2022 15:40:00 </td>
        <td style="word-break: break-all;">
<img style="width: 26px;" src="https://fia-uganda-edrms.com/images/pdf.png">
    


     



    <a href="https://fia-uganda-edrms.com:8443/alfresco/api/-default-/public/alfresco/versions/1/nodes/d8844e8d-b77a-497c-b6e8-64e36190a38b/content?a=true&amp;alf_ticket=TICKET_5403e57eb5c9b49f2a48636983dd352ef2462565">Form1-3-05-2.pdf</a>

    </td><td>
           
                     <p>N/A</p>

                     
       </td>



       
      </tr> -->
                                        </tbody>
                                    </table>



                                    <!-- </div>

                    <div class="row"> -->




                                </div>

                            </section>

                        </div>
                    </div>


                    <div class="tile" id="tile-1" style="margin-top:10px !important;">

                        <!-- Nav tabs -->

                        <ul class="nav nav-tabs nav-justified tabs" id="tab" role="tablist">

                            <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                                <a class="nav-link  " id="home-tab" name="tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><img src="{{asset('assets/images/state.svg')}}" style=" filter: invert(1) contrast(4.5);" alt="" width="35" height="36"><b> Status</b> <input type="checkbox" class="checkg" id="profile" name="nationality" readonly value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
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

                                    <input type="hidden" class="form-control" required id="user_id" name="user_id" readonly value="">
                                    <input type="hidden" class="form-control" required id="user_details" name="user_details" readonly value="general">


                                    <h style="color:#34395e"><b> Status of valuation:</b></h>
                                    <div class="row">

                                        
                                        <div class="col-md-8">
                                            <div class="form-group">

                                                <label>Previous Notes:<span class="error-star" style="color:red;">*</span></label>
                                                <div class="form-group scroll_flow_class">



                                                    <span> User (Rajesh) - initiated </span> <br>

                                                    <span>15/03/2022 15:17:07 - Submitted</span> <br><br>




                                                    <span> TALENTRA Staff (Mark) - Reviewed </span> <br>

                                                    <span>15/03/2022 15:29:25 - Accepted</span> <br>
                                                    <span> Notes - Reviewed all Details</span> <br><br>




                                                    <span> COG (Richard) - Reviewed </span> <br>

                                                    <span>15/03/2022 15:40:17 - Rejected </span> <br>
                                                    <span> Notes - Documents weren't clear Please upload with good clarity</span> <br><br>





                                                </div>
                                            </div>
                                        </div>


                                    </div>





                                </div>

                            </section>

                        </div>

                    </div>

                                <div style="display:flex; justify-content:center; width:100%">

                                                    <a type="button" class="btn btn-labeled btn-info" href="{{ url()->previous() }}" title="next" style="background: red !important; border-color:red !important; color:white !important; margin-top:15px !important;">
                                                                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>
                                                                    <button type="submit"  id="updatebutton"  class="btn btn-labeled btn-info" title="Update" style="background: green !important; border-color:green !important; color:white !important; margin-top:15px !important; margin-left: 15px;">
                                                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Save</button>

                                </div>
                               
                    </form>
                               
                
                  
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>

<script type="text/javascript">
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
    function submit() {

document.getElementById('generalupdate_form').submit();
}


var j = 1;
 $("#addc").click(function(){
        var q = j + 1;
      // $('#dynamic_field').append('<div id="row'+i+'"><div class=""><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list"/></td><td><input type="text" name="email[]" placeholder="Enter your Email" class="form-control name_email"/></td><td></div>');  
      $('#dynamic_fieldc').append('<section class="input-box" id="row'+j+'"><div class="row clear remove_other'+j+' "><div class="col-md-2"> <div class="form-group"> <label> Survey Number:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control default" required id="asset_name" name="asset_name" value=""> </div> </div> <div class="col-md-3"> <div class="form-group"> <label> Extend Of Land:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control default" required id="asset_name" name="asset_name" value=""> </div> </div> <div class="col-md-3"> <div class="form-group"> <label>Land Classification:<span class="error-star" style="color:red;">*</span></label> <select class="form-control default" required id="Purpose_of_valuation" name="Purpose_of_valuation"> <option value="0">Select-LandClassification</option> <option value="Agricultire">Agricultire</option> <option value="Plantation">Plantation</option> <option value="Real Estate">Real Estate</option> </select> </div> </div> <div class="col-md-3"> <div class="form-group"> <label>Land units(Acres):<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control default" required id="asset_name" name="asset_name" value=""> </div> </div><div><button style="margin-top:30px" type="button" name="remove" id="'+j+'" class="btn btn-danger btn_remove">X</button></div></div></section>'); 
      j++;
    
 $("#attachment_countc").val(j);

    });

    var i = 1;
 $("#adde").click(function(){
        var q = i + 1;
      // $('#dynamic_field').append('<div id="row'+i+'"><div class=""><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list"/></td><td><input type="text" name="email[]" placeholder="Enter your Email" class="form-control name_email"/></td><td></div>');  
      $('#dynamic_fielde').append('<section class="input-box" id="row'+i+'"><div class="row clear remove_other'+i+' "> <div class="col-md-4"> <div class="form-group"> <label> Name:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control default" required id="asset_name" name="asset_name" value=""> </div> </div> <div class="col-md-4"> <div class="form-group"> <label>Relation to the Asset Owner :<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control default" required id="asset_name" name="asset_name" value=""> </div> </div> <!-- </div> <div class="row"> --> <div class="col-md-3"> <div class="form-group"> <label>Date of Birth :<span class="error-star" style="color:red;">*</span></label> <input type="date" class="form-control default" required id="asset_name" name="asset_name" value=""> </div> </div><div><button style="margin-top:30px" type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></div></div></section>'); 
      i++;
    
 $("#attachment_counte").val(i);

    });

function radchange(a){
            var a = a.value;
            if(a=="yes"){
                document.getElementById('ownerchange').style.display = "none" ;
                document.getElementById('qv1').style.display = "block" ;
                var a = document.getElementsByClassName('wrq');
        for(var z=0; z < a.length; z++){
                document.getElementsByClassName('wrq')[z].setAttribute('required','required');
       
        }
        var b = document.getElementsByClassName('wre');
        for(var y=0; y < b.length; y++){
        document.getElementsByClassName('wre')[y].removeAttribute('required');
             }
            }
            else{
                document.getElementById('qv1').style.display = "none" ;
                document.getElementById('qv2').style.display = "block" ;
                var a = document.getElementsByClassName('wrq');
        for(var z=0; z < a.length; z++){
                document.getElementsByClassName('wrq')[z].removeAttribute('required');
       
        }
        var b = document.getElementsByClassName('wre');
        for(var y=0; y < b.length; y++){
                document.getElementsByClassName('wre')[y].setAttribute('required','required');
             }
            }
        }
function changefile1(a) {

var a = a.value;
if(a == "1"){
document.getElementById('ninf').setAttribute('required','required');
document.getElementById('dninf1').style.display = "inline-block";
document.getElementById('f1').value = "0";
document.getElementById('i1').value = "0";
document.getElementById('fi1').innerText = " Stay The Same";
}
else{
    document.getElementById('ninf').removeAttribute('required');
document.getElementById('dninf1').style.display = "none";
document.getElementById('f1').value = "1";
document.getElementById('i1').value = "1";
document.getElementById('fi1').innerText = " Change File";
}
};
function changefile2(a) {

var a = a.value;
if(a == "1"){
document.getElementById('ppf').setAttribute('required','required');
document.getElementById('dninf2').style.display = "inline-block";
document.getElementById('f2').value = "0";
document.getElementById('i2').value = "0";

document.getElementById('fi2').innerText = " Stay The Same";
}
else{
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
</script>



@include('Registration.formmodal')
@endsection
 