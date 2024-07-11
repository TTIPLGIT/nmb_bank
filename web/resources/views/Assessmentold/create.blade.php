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
        background: #25867d;
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
        background: #e9fffc;
        padding: 2em;
        position: relative;
        z-index: 1;
        border-radius: 0 5px 5px 5px;
        /* box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.15);
        border-style: outset; */
        box-shadow: -4px 4px 4px rgb(0 0 0 / 50%), inset 1px 0px 0px rgb(255 255 255 / 40%);

    }

    .content {
        background: #e9fffc;
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
    .switch-field input:checked+label[for=radio-one12] {
        background-color: #a5dc86;
        box-shadow: none;
        color: white;
    }

    .switch-field input:checked+label[for=radio-two12] {
        background-color: #dc8686;
        box-shadow: none;
        color: white;
    }

    .switch-field input:checked+label[for=radio-one13] {
        background-color: #a5dc86;
        box-shadow: none;
        color: white;
    }

    .switch-field input:checked+label[for=radio-two13] {
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
</style>
<div class="main-content">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12">
            <div class="" style="height:100%; padding: 15px">
                {{ Breadcrumbs::render('Assessment.create') }}
                <form action="{{ route('Registration.update',1) }}" method="POST" id="generalupdate_form" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <input type="hidden" class="form-control" required id="user_details" name="user_details" value="general">
                    <div class="tile" id="tile-1" style="margin-top:10px !important;">

                        <!-- Nav tabs -->

                        <ul class="nav nav-tabs nav-justified tabs" id="tab" role="tablist">

                            <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                                <a class="nav-link  " id="home-tab" name="tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-user"></i><b> Asset Owner Details</b> <input type="checkbox" class="checkg" id="profile" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
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

                                    <input type="hidden" class="form-control" required id="user_id" name="user_id" value="">
                                    <input type="hidden" class="form-control" required id="user_details" name="user_details" value="general">

                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Asset's Owner Name:<span class="error-star" style="color:red;">*</span></label>
                                                <input type="text" class="form-control default" required id="asset_name" name="asset_name" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Father Name:<span class="error-star" style="color:red;">*</span></label>
                                                <input type="text" class="form-control default" required id="asset_name" name="asset_name" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Date of Birth:<span class="error-star" style="color:red;">*</span></label>
                                                <input type="Date" class="form-control default" required id="asset_name" name="asset_name" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-3">
                                            <div class="form-group">

                                                <label>Address Line:<span class="error-star" style="color:red;">*</span></label>
                                                <input type="text" class="form-control default" required id="Address_line1" name="Address_line1" value="">
                                            </div>
                                        </div>
                                        <!-- </div>
                                                        
                                                            <div class="row"> -->
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>District:<span class="error-star" style="color:red;">*</span></label>
                                                <select class="form-control default" required id="district" name="district">
                                                    <option value="0">Select-District</option>
                                                    <option value="Amolator">Amolator</option>
                                                    <option value="Kamweng">Kamweng</option>
                                                    <option value="Kira">Kira</option>
                                                    <option value="Kitgum">Kitgum</option>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>County: <span class="error-star" style="color:red;">*</span></label>
                                                <select class="form-control default" required id="County" name="County">
                                                    <option value="0">Select-County</option>
                                                    <option value="Bukanga County">Bukanga County</option>
                                                    <option value="Labwor County">Labwor County</option>
                                                    <option value="Mazuri County">Mazuri County</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Parish: <span class="error-star" style="color:red;">*</span></label>
                                                <select class="form-control default" required id="Parish" name="Parish">
                                                    <option value="0">Select-Parish</option>
                                                    <option value="Bukanga County">Bukanga County</option>
                                                    <option value="Labwor County">Labwor County</option>
                                                    <option value="Mazuri County">Mazuri County</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">

                                                <label>Village: <span class="error-star" style="color:red;">*</span></label>
                                                <select class="form-control default" required id="village" name="village">
                                                    <option value="0">Select-Village</option>
                                                    <option value="Amolator">kampala</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>NIN (National Identification Number):<span class="error-star" style="color:red;">*</span></label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control default" maxlength="12" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required id="nin" name="nin">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input class="form-control " type="file" id="ninf" name="ninf" value="" required autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- </div>

							<div class="row"> -->


                                    </div>

                                </div>

                            </section>

                        </div>

                    </div>



                    <div class="tile" id="tile-1" style="margin-top:10px !important;">

                        <!-- Nav tabs -->

                        <ul class="nav nav-tabs nav-justified tabs" id="tab" role="tablist">

                            <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                                <a class="nav-link  " id="home-tab" name="" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><img src="{{asset('assets/images/specific1.svg')}}" style=" filter: invert(1) contrast(4.5);" alt="" width="35" height="36"><b> Valution Specification Details</b> <input type="checkbox" class="checkg" id="profile" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                    <div class="check"></div>
                                </a>

                            </li>



                        </ul>
                    </div>
                    <!-- Tab panes -->


                    <div class="content">
                        <div>
                            <section class="section">
                                <div class="section-body mt-1">

                                    <input type="hidden" class="form-control" required id="user_id" name="user_id" value="">
                                    <input type="hidden" class="form-control" required id="user_details" name="user_details" value="general">

                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Asset Name:<span class="error-star" style="color:red;">*</span></label>
                                                <input type="text" class="form-control default" required id="asset_name" name="asset_name" value="">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Asset Type:<span class="error-star" style="color:red;">*</span></label>
                                                <select class="form-control default" required id="Purpose_of_valuation" name="Purpose_of_valuation">
                                                    <option value="0">Select-Purpose</option>
                                                    <option value="Land">Land</option>
                                                    <option value="Developments, Real property">Developments, Real property</option>
                                                    <option value="Plant and Machinery">Plant and Machinery </option>
                                                    <option value="Motor Vehicles">Motor Vehicles</option>
                                                    <option value="tax assessment-rating, stamp duty and probate">Natural Reseources, stamp duty and probate</option>
                                                    <option value="Chattels-furniture, fixtures">Chattels-furniture, fixtures</option>
                                                    <option value="Financial Instruments-shares, bonds, stocks">Financial Instruments-shares, bonds, stocks</option>
                                                    <option value="Intellectual property-patents, copyrights">Intellectual property-patents, copyrights</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Purpose of Valuation:<span class="error-star" style="color:red;">*</span></label>
                                                <textarea class="form-control default" required id="Purpose_of_valuation" name="Purpose_of_valuation">

                                                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <h style="color:#34395e"><b>Asset Physical Location:</b></h>
                                    <div class="row">

                                        <div class="col-md-3">
                                            <div class="form-group">

                                                <label>Address Line:<span class="error-star" style="color:red;">*</span></label>
                                                <input type="text" class="form-control default" required id="Address_line1" name="Address_line1" value="">
                                            </div>
                                        </div>
                                        <!-- </div>
                                                                        
                                                                            <div class="row"> -->
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>District:<span class="error-star" style="color:red;">*</span></label>
                                                <select class="form-control default" required id="district" name="district">
                                                    <option value="0">Select-District</option>
                                                    <option value="Amolator">Amolator</option>
                                                    <option value="Kamweng">Kamweng</option>
                                                    <option value="Kira">Kira</option>
                                                    <option value="Kitgum">Kitgum</option>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>County: <span class="error-star" style="color:red;">*</span></label>
                                                <select class="form-control default" required id="County" name="County">
                                                    <option value="0">Select-County</option>
                                                    <option value="Bukanga County">Bukanga County</option>
                                                    <option value="Labwor County">Labwor County</option>
                                                    <option value="Mazuri County">Mazuri County</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">

                                                <label>Parish: <span class="error-star" style="color:red;">*</span></label>
                                                <select class="form-control default" required id="Parish" name="Parish">
                                                    <option value="0">Select-Parish</option>
                                                    <option value="Amolator">kampala</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">

                                                <label>Village: <span class="error-star" style="color:red;">*</span></label>
                                                <select class="form-control default" required id="village" name="village">
                                                    <option value="0">Select-Village</option>
                                                    <option value="Amolator">kampala</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="egc" style="display: flex;  align-items: center;">
                                                    <div class="dq"><span class="questions">An understanding of the market within which this Asset is Traded:</span></div>

                                                    <div class="switch-field" style="padding-left:12px">
                                                        <input type="radio" id="radio-one12" name="wrqch" value="yes" required Checked />
                                                        <label for="radio-one12">Yes</label>
                                                        <input type="radio" id="radio-two12" name="wrqch" value="no" required />
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
                                <a class="nav-link  " id="home-tab" name="tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><img src="{{asset('assets/images/assetn.svg')}}" style=" filter: invert(1) contrast(4.5);" alt="" width="20" height="26"><b> Asset Details</b> <input type="checkbox" class="checkg" id="profile" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                    <div class="check"></div>
                                </a>

                            </li>
                            <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                                <a class="nav-link  " id="home-tab" name="tab2" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fas fa-balance-scale"></i><b> Legal Existence and Ownership Details</b> <input type="checkbox" class="checkg" id="profile" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                    <div class="check"></div>
                                </a>

                            </li>
                            <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                                <a class="nav-link  " id="home-tab" name="tab3" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-file-text-o"></i><b> Asset documents</b> <input type="checkbox" class="checkg" id="profile" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
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

                                    <input type="hidden" class="form-control" required id="user_id" name="user_id" value="">
                                    <input type="hidden" class="form-control" required id="user_details" name="user_details" value="general">

                                    <div class="row">

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label> Survey Number:<span class="error-star" style="color:red;">*</span></label>
                                                <input type="text" class="form-control default" required id="asset_name" name="asset_name" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label> Extend Of Land:<span class="error-star" style="color:red;">*</span></label>
                                                <input type="text" class="form-control default" required id="asset_name" name="asset_name" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Land Classification:<span class="error-star" style="color:red;">*</span></label>
                                                <select class="form-control default" required id="Purpose_of_valuation" name="Purpose_of_valuation">
                                                    <option value="0">Select-LandClassification</option>
                                                    <option value="Agricultire">Agricultire</option>
                                                    <option value="Plantation">Plantation</option>
                                                    <option value="Real Estate">Real Estate</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Land units(Acres):<span class="error-star" style="color:red;">*</span></label>
                                                <input type="text" class="form-control default" required id="asset_name" name="asset_name" value="">

                                            </div>
                                        </div>

                                    </div>
                                    <input type="hidden" name="attachment_countc" id="attachment_countc" value="1">
                                    <div id="dynamic_fieldc"></div>
                                    <button type="button" name="addc" id="addc" class="btn btn-primary" style="background-color: #1d90cb !important">Add </button>






                                </div>

                            </section>

                        </div>
                        <div id="tab2">
                            <section class="section">
                                <div class="section-body mt-1">

                                    <input type="hidden" class="form-control" required id="user_id" name="user_id" value="">
                                    <input type="hidden" class="form-control" required id="user_details" name="user_details" value="general">

                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Land Owned Date:<span class="error-star" style="color:red;">*</span></label>
                                                <input type="date" class="form-control default" required id="asset_name" name="asset_name" value="">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="egc" style="display: flex;  align-items: center;">
                                                    <div class="dq"><span class="questions">If He/She had Other Ownership to Land:</span></div>

                                                    <div class="switch-field" style="padding-left:12px">
                                                        <input type="radio" id="radio-one13" name="ownership" value="yes" required onchange="radchange(this)" checked />
                                                        <label for="radio-one13">Yes</label>
                                                        <input type="radio" id="radio-two13" name="ownership" value="no" required onchange="radchange(this)" />
                                                        <label for="radio-two13">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="otherowner">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label> Name:<span class="error-star" style="color:red;">*</span></label>
                                                <input type="text" class="form-control default" required id="asset_name" name="asset_name" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Relation to the Asset's Owner :<span class="error-star" style="color:red;">*</span></label>
                                                <input type="text" class="form-control default" required id="asset_name" name="asset_name" value="">
                                            </div>
                                        </div>
                                        <!-- </div>
                                                        
                                                            <div class="row"> -->
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Date of Birth :<span class="error-star" style="color:red;">*</span></label>
                                                <input type="date" class="form-control default" required id="asset_name" name="asset_name" value="">
                                            </div>
                                        </div>

                                    </div>
                                    <input type="hidden" name="attachment_counte" id="attachment_counte" value="1">
                                    <div id="dynamic_fielde"></div>
                                    <button type="button" name="adde" id="adde" class="btn btn-primary" style="background-color: #1d90cb !important">Add </button>




                                </div>

                            </section>

                        </div>

                        <div id="tab3">
                            <section class="section">
                                <div class="section-body mt-1">

                                    <input type="hidden" class="form-control" required id="user_id" name="user_id" value="">
                                    <input type="hidden" class="form-control" required id="user_details" name="user_details" value="general">







                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Lease Deed or Purchase Deed of the Property:<span class="error-star" style="color:red;">*</span></label>
                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <input class="form-control " type="file" id="ninf" name="ninf" value="" required autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- </div>

                                    <div class="row"> -->

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Latest Electricity Bill:<span class="error-star" style="color:red;">*</span></label>
                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <input class="form-control " type="file" id="ppf" name="ppf" required value="" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Latest Property Tax Receipt:<span class="error-star" style="color:red;">*</span></label>
                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <input class="form-control " type="file" id="ninf" name="ninf" value="" required autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- </div>

                                    <div class="row"> -->

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Factory Inspector's Approval, if applicable:<span class="error-star" style="color:red;">*</span></label>
                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <input class="form-control " type="file" id="ppf" name="ppf" required value="" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Insurance Policies of Properties:<span class="error-star" style="color:red;">*</span></label>
                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <input class="form-control " type="file" id="ninf" name="ninf" value="" required autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- </div>

                                    <div class="row"> -->

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Latest 7/12 Extract for free hold property:<span class="error-star" style="color:red;">*</span></label>
                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <input class="form-control " type="file" id="ppf" name="ppf" required value="" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Competent Authority along with letter of Approval:<span class="error-star" style="color:red;">*</span></label>
                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <input class="form-control " type="file" id="ninf" name="ninf" value="" required autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- </div>

                                    <div class="row"> -->

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Building Completion Certificate:<span class="error-star" style="color:red;">*</span></label>
                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <input class="form-control " type="file" id="ppf" name="ppf" required value="" autocomplete="off">
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

                       
                    </div>
                    <!-- Tab panes -->


                    <div id="" class="content">
                        <div id="">
                            <section class="section">
                                <div class="section-body mt-1">

                                    <input type="hidden" class="form-control" required id="user_id" name="user_id" value="">
                                    <input type="hidden" class="form-control" required id="user_details" name="user_details" value="general">


                                    <h style="color:#34395e"><b> Status of Valuation:</b></h>
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">

                                                <label>From:<span class="error-star" style="color:red;">*</span></label>
                                                <input type="text" class="form-control default" required id="Address_line1" name="Address_line1" value="">
                                            </div>
                                        </div>
                                        <!-- </div>
                                                        
                                                            <div class="row"> -->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Status:<span class="error-star" style="color:red;">*</span></label>
                                                <select class="form-control default" required id="district" name="district">
                                                    <option value="0">Select-Status</option>
                                                    <option value="Amolator">Approve</option>
                                                    <option value="Kamweng">Reject</option>

                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">

                                                <label>Notes:<span class="error-star" style="color:red;">*</span></label>
                                                <textarea class="form-control default" required id="Purpose_of_valuation" name="Purpose_of_valuation">   </textarea>
                                            </div>
                                        </div>


                                    </div>





                                </div>

                            </section>

                        </div>

                    </div>

                    <div style="display:flex; justify-content:center; width:100%">

                        <a type="button" class="btn btn-labeled btn-info" href="{{url()->previous()}}" title="next" style="background: red !important; border-color:red !important; color:white !important; margin-top:15px !important;">
                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>
                        <button type="submit" id="updatebutton" class="btn btn-labeled btn-info" title="Update" style="background: green !important; border-color:green !important; color:white !important; margin-top:15px !important; margin-left: 15px;">
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
    $("#addc").click(function() {
        var q = j + 1;
        // $('#dynamic_field').append('<div id="row'+i+'"><div class=""><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list"/></td><td><input type="text" name="email[]" placeholder="Enter your Email" class="form-control name_email"/></td><td></div>');  
        $('#dynamic_fieldc').append('<section class="input-box" id="row' + j + '"><div class="row clear remove_other' + j + ' "><div class="col-md-2"> <div class="form-group"> <label> Survey Number:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control default" required id="asset_name" name="asset_name" value=""> </div> </div> <div class="col-md-3"> <div class="form-group"> <label> Extend Of Land:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control default" required id="asset_name" name="asset_name" value=""> </div> </div> <div class="col-md-3"> <div class="form-group"> <label>Land Classification:<span class="error-star" style="color:red;">*</span></label> <select class="form-control default" required id="Purpose_of_valuation" name="Purpose_of_valuation"> <option value="0">Select-LandClassification</option> <option value="Agricultire">Agricultire</option> <option value="Plantation">Plantation</option> <option value="Real Estate">Real Estate</option> </select> </div> </div> <div class="col-md-3"> <div class="form-group"> <label>Land units(Acres):<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control default" required id="asset_name" name="asset_name" value=""> </div> </div><div><button style="margin-top:30px" type="button" name="remove" id="' + j + '" class="btn btn-danger btn_remove">X</button></div></div></section>');
        j++;

        $("#attachment_countc").val(j);

    });

    var i = 1;
    $("#adde").click(function() {
        var q = i + 1;
        // $('#dynamic_field').append('<div id="row'+i+'"><div class=""><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list"/></td><td><input type="text" name="email[]" placeholder="Enter your Email" class="form-control name_email"/></td><td></div>');  
        $('#dynamic_fielde').append('<section class="input-box" id="row' + i + '"><div class="row clear remove_other' + i + ' "> <div class="col-md-4"> <div class="form-group"> <label> Name:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control default" required id="asset_name" name="asset_name" value=""> </div> </div> <div class="col-md-4"> <div class="form-group"> <label>Relation to the Asset Owner :<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control default" required id="asset_name" name="asset_name" value=""> </div> </div> <!-- </div> <div class="row"> --> <div class="col-md-3"> <div class="form-group"> <label>Date of Birth :<span class="error-star" style="color:red;">*</span></label> <input type="date" class="form-control default" required id="asset_name" name="asset_name" value=""> </div> </div><div><button style="margin-top:30px" type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></div></div></section>');
        i++;

        $("#attachment_counte").val(i);

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
</script>



@include('Registration.formmodal')
@endsection