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
        background: #d8d4d4;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        padding: .4em 1.5em;
        float: left;
        text-decoration: none;
        color: #444;
        text-shadow: 0 1px 0 rgba(255, 255, 255, .8);
        border-radius: 5px 0 0 0;
        box-shadow: 0 2px 2px rgba(0, 0, 0, .4);
    }

    #tabs a.nav-link:hover,
    #tabs a.nav-link:hover::after,
    #tabs a.nav-link:focus,
    #tabs a.nav-link:focus::after {
        background: #ffffff !important;
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


                <form action="{{ route('nrustore') }}" method="POST" id="nrueducreate_form" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" class="form-control" required id="user_details" name="user_details" value="exp">

                    <div class="tile" id="tile-1" style="margin-top:10px !important;">

                        <!-- Nav tabs -->

                        <ul class="nav nav-tabs nav-justified " id="tabs" role="tablist" style="background-image: none">

                            <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                                <a class="nav-link  " id="home-tab" name="tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-home"></i><b> Work Experience</b> <input type="checkbox" class="checkg" id="profile" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                    <div class="check"></div>
                                </a>

                            </li>
                            <li class="nav-items navv" id="certification" class="" style="flex-basis: 1 !important;">
                                <a class="nav-link" id="addition-tab" name="tab2" data-toggle="tab" role="tab" aria-controls="addition" aria-selected="false"><i class="fas fa-map-signs"></i> <b>Certification</b> <input type="checkbox" class="checkg" id="adddetails" name="nationality" value="0" onchange="submitval(this)" style="background-color:solid green !important; color:green !important; visibility:hidden !important; "></a>

                            </li>



                        </ul>
                    </div>
                    <!-- Tab panes -->

                    <div id="content">
                        <div id="tab1">

                            <section class="section">
                                <div class="section-body mt-1">

                                    <div class="" id="qv1">
                                        <div class="row flex">
                                            <div class="col-5">
                                                <div class="form-group">
                                                    <label class="control-label">Experience in years<span class="error-star" style="color:red;">*</span></label>
                                                    <input class="form-control default  wrq" min="1" placeholder=" Enter the Experience" type="number" id="experience" name="experience" readonly autocomplete="off">
                                                    <span style="color: red; font-weight:bold;"><strong>NOTE:</strong> Experience in Years wil be calculated based on the from date and to date only.</span>


                                                </div>
                                            </div>
                                        </div>
                                        <div class="row flex">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Company Name<span class="error-star" style="color:red;">*</span></label>
                                                    <input class="form-control default  wrq" placeholder="Enter the Company name" type="text" id="C_name" name="wrq[0][C_name]" autocomplete="off">

                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label">Designation<span class="error-star" style="color:red;">*</span></label>
                                                    <input class="form-control default wrq" placeholder="Enter the Designation" type="text" id="designation_valuation" name="wrq[0][designation_valuation]" value="" autocomplete="off">

                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">From Date:<span class="error-star" style="color:red;">*</span></label>
                                                    <input class="form-control default wrq dob fde_0" type="text" oninput="input(this)" onchange="yearcount(event)" title="fde" id="fde" name="wrq[0][fde_yes]" placeholder="DD-MM-YYYY" autocomplete="off">

                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">To Date:<span class="error-star" style="color:red;">*</span></label>
                                                    <input class="form-control default  wrq dob tde_0" type="text" oninput="input(this)"  onchange="yearcount(event)" id="tde" name="wrq[0][tde_yes]" placeholder="DD-MM-YYYY" autocomplete="off">

                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label"><span id="item_label"></span>Scope & Responsibilities:<span class="error-star" style="color:red;">*</span></label>
                                                    <textarea rows="10" columns="10" placeholder="Scope & Responsibilities" class="form-control default wre" type="text" id="scoope" name="wrq[0][scope]" autocomplete="off"></textarea>

                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="attachment_counter" id="attachment_counter" value="1">
                                        <div id="dynamic_addc" style="margin-left:16px ;">
                                            <button type="button" name="addcompany" id="addcompany" class="btn btn-primary" style="background-color: #67c8e2 !important">Add Experience</button>

                                        </div>
                                    </div>

                                    <div class="" id="qv2" style="display:none;">
                                        <div class="row" style="display:none;">

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">From Date:<span class="error-star" style="color:red;">*</span></label>
                                                    <input class="form-control default  wrq fde_wre dob" value=" " type="text" oninput="input(this)" id="fde" name="wre[0][fde]" placeholder="DD-MM-YYYY" autocomplete="off">

                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">To Date:<span class="error-star" style="color:red;">*</span></label>
                                                    <input class="form-control default  wrq tde_wre dob" type="text" value="" oninput="input(this)" id="tde" name="wre[0][tde]" autocomplete="off">

                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label"><span id="item_no_label"></span>Area of work:<span class="error-star" style="color:red;">*</span></label>
                                                    <input placeholder="Area of Work" class="form-control default wre" type="text" id="aow" name="wre[0][aow]" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label"><span id="item_label"></span>Designation:<span class="error-star" style="color:red;">*</span></label>
                                                    <input placeholder="Enter the designation" class="form-control default wre" type="text" id="aow" name="wre[0][designation]" autocomplete="off">

                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label"><span id="item_label"></span>Scope & Responsibilities:<span class="error-star" style="color:red;">*</span></label>
                                                    <textarea placeholder="Scope & Responsibilities" class="form-control default wre" type="text" id="aow" name="wre[0][scope]" autocomplete="off"></textarea>

                                                </div>
                                            </div>

                                            <div class=" col-md-2 " id="s11">
                                                <div class="form-group">
                                                    <label class="control-label"><span id="item_no_label1"></span>Designation:<span class="error-star" style="color:red;">*</span></label>
                                                    <input class="form-control default wre " type="text" id="des1" name="wre[0][des]" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class=" col-md-2" id="s21">
                                                <div class="form-group">
                                                    <label class="control-label"><span id="item_no_label2"></span>Exp in the relevant valuation:<span class="error-star" style="color:red;">*</span></label>
                                                    <input class="form-control default wre " type="text" id="rel1" name="wre[0][rel]" autocomplete="off">
                                                </div>
                                            </div>


                                        </div>
                                        <input type="hidden" name="attachment_counte" id="attachment_counte" accept=".pdf, .doc, .png," value="1">
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

                        <div id="tab2">
                            <section class="section">


                                <div class="section-body mt-0">


                                    <div class="row">
                                        <div class="col-md-4">
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
                                                <input class="form-control mb-0" type="file" id="certd" name="cert[0][certd]" value="" accept=".pdf, .doc, .png," autocomplete="off">
                                                <strong style="color: red;">Following files could be uploaded pdf,doc,png</strong>                                            </div>

                                        </div>
                                        <input type="hidden" name="attachment_countc" id="attachment_countc" value="1">
                                        <div id="dynamic_fieldc"></div>
                                        <button type="button" name="addc" id="addc" class="btn btn-primary" style="background-color: #67c8e2 !important">Add Certification</button>



                                    </div>

                                </div>

                            </section>


                        </div>

                    </div>
                    <div style="display:flex; justify-content:center; width:100%">
                        <a type="button" class="btn btn-labeled btn-info" href="{{url('workexp_index')}}" title="next" style="background: red !important; border-color:red !important; color:white !important; margin-top:15px !important;">
                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>
                        <button onclick="nruexpcre()" id="registerbutton" class="btn btn-labeled btn-info" title="Submit" style="background: green !important; border-color:green !important; color:white !important;  margin-top:15px !important; margin-left:15px !important;">
                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Submit</a></button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="application/javascript">
    function date_picker() {

        var $j = jQuery.noConflict();
        $j(function() {
            $j('.dob').datepicker({
                dateFormat: 'dd-mm-yy',
                showButtonPanel: true,
                changeMonth: true,
                changeYear: true,
                yearRange: '1999:2030',
                showOn: "button",
                buttonImage: "/images/calendar.png",
                class: "dateimage",
                buttonImageOnly: true,
                maxDate: 0,
                inline: true
            });



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

        var date_count=(tde_fde_all.length)/2;
        if(date_count==1){
            date_count=2;
        }
        var years=0;
        for (let index = 0; index < date_count; index++) {
            var fde_value=$(`.fde_${index}`).val();
            var tde_value=$(`.tde_${index}`).val();
            if(fde_value){
                var current_years=calculateYears(fde_value,tde_value);
            years = years + current_years;

            }
           


            
        }

        $('#experience').val(years);
    }






    $(document).ready(function() {
        date_picker();
        document.getElementById('qv2').style.display = "none";
        document.getElementById('qv1').style.display = "block";
        document.getElementById('s11').style.display = "none";
        document.getElementById('s21').style.display = "none";
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
        $('#dynamic_fielde').append('<section class="input-box" id="row' + j + '"><div class="row clear remove_other' + j + ' "> <div class="col-md-2"> <div class="form-group"> <label class="control-label">From Date:<span class="error-star" style="color:red;">*</span></label> <input class="form-control default  wre" value=" " type="text" placeholder="DD-MM-YYYY" oninput="input(this)" id="fde" name="wre[' + j + '][fde]"  autocomplete="off" > </div> </div> <div class="col-md-2"> <div class="form-group"> <label class="control-label">To Date:</label> <input class="form-control default  wre" type="text" value=" " oninput="input(this)" placeholder="DD-MM-YYYY" id="tde" name="wre[' + j + '][tde_yes]"  autocomplete="off" > </div> </div> <div class="col-md-2"> <div class="form-group"> <label class="control-label"><span id="item_no_label"></span>Area of work:<span class="error-star" style="color:red;">*</span></label> <input class="form-control default wre" type="text" id="aow" name="wre[' + j + '][aow]" required autocomplete="off"> </div> </div> <div class="col-md-3"> <div class="form-group"> <label class="control-label"><span id="item_label"></span>Employment/Practice:<span class="error-star" style="color:red;">*</span></label> <div class="switch-field" style="padding-left:12px"> <input type="radio" class="wre" id="radio-one' + j + '" name="wre[' + j + '][ep]" value="employee" required onchange="workchanges(this,' + q + ')" /> <label for="radio-one' + j + '">Employment</label> <input type="radio" class="wre" id="radio-two' + j + '" name="wre[' + j + '][ep]" value="practice" required onchange="workchanges(this,' + q + ')" /> <label for="radio-two' + j + '">Practice</label> </div> </div> </div> <div class="col-md-2" id="s1' + q + '" style="display:none"> <div class="form-group "> <label class="control-label"><span id="item_no_label1"></span>Designation:<span class="error-star" style="color:red;">*</span></label> <input class="form-control default  wre" type="text" id="des' + q + '" name="wre[' + j + '][des]" required autocomplete="off"> </div> </div> <div class=" col-md-2" id="s2' + q + '" style="display:none"> <div class="form-group"> <label class="control-label"><span id="item_no_label2"></span>Exp in the relvt valuation:<span class="error-star" style="color:red;">*</span></label> <input class="form-control default wre" type="text" id="rel' + q + '" name="wre[' + j + '][rel]" required autocomplete="off"> </div> </div></div><div class="col-md-3"><div class="form-group"><label class="control-label"><span id="item_label"></span>Scope & Responsibilities:<span class="error-star" style="color:red;">*</span></label><textarea rows="10" columns="10" placeholder="Scope & Responsibilities" class="form-control default wre" type="text" id="aow" name="wre[' + i + '][scope]" autocomplete="off"></textarea></div><div><button style="margin-top:30px" type="button" name="remove" id="' + j + '" class="btn btn-danger btn_remove">X</button></div></div></section>');
        j++;

        $("#attachment_counte").val(j);

    });

    $(document).on('click', '.btn_remove', function(e) {

        e.target.parentElement.parentElement.parentElement.remove()

        // alert("jhd11");
        // var button_id = $(this).attr("id");
        // $('#row' + button_id + '').remove();
        // $("#attachment_counte").val(j);
    });

    $(document).on('click', '.btn_remove_company', function(e) {

        e.target.parentElement.parentElement.parentElement.parentElement.parentElement.remove()

        // alert("jhd11");
        // var button_id = $(this).attr("id");
        // $('#row' + button_id + '').remove();
        // $("#attachment_counte").val(j);
    });

    var i = 1;

    $("#addc").click(function() {
        var q = j + 1;
        // $('#dynamic_field').append('<div id="row'+i+'"><div class=""><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list"/></td><td><input type="text" name="email[]" placeholder="Enter your Email" class="form-control name_email"/></td><td></div>');  
        $('#dynamic_fieldc').append('<section class="input-box" id="row' + j + '"><div class="row clear remove_other' + j + ' "><div class="col-md-4"> <div class="form-group"> <label class="control-label">Name of the Professional Body:<span class="error-star" style="color:red;">*</span></label> <input class="form-control default" type="text" id="nopb" name="cert[' + i + '][nopb]" autocomplete="off" required value="" > </div> </div> <div class="col-md-3"> <div class="form-group"> <label class="control-label">Certificate issued by:<span class="error-star" style="color:red;">*</span></label> <input class="form-control default" type="text" id="certib" name="cert[' + i + '][ib]" required value="" autocomplete="off">  </div> </div> <div class="col-md-3"> <div class="form-group"> <label class="control-label">Certification Documents:<span class="error-star" style="color:red;">*</span></label> <input class="form-control mb-0" type="file" id="certd" name="cert[' + i + '][certd]" required value="" autocomplete="off"><span style="color: red;">pdf,doc,png</span> </div> </div> <div><button style="margin-top:30px" type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></div></div></section>');
        i++;

        $("#attachment_countc").val(i);

    });
    var i = 1;

    $("#addcompany").click(function() {
        // $('#dynamic_field').append('<div id="row'+i+'"><div class=""><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list"/></td><td><input type="text" name="email[]" placeholder="Enter your Email" class="form-control name_email"/></td><td></div>');    
        $('#dynamic_addc').append('<section class="input-box" id="row' + j + '"><div class="row clear remove_other' + j + '"><div class="row"><div class="form-group"><label class="control-label">Company Name<span class="error-star" style="color:red;">*</span></label><input class="form-control default  wrq" placeholder="Enter the Company name" type="text" id="C_name" name="wrq[' + i + '][C_name]" autocomplete="off" required value=""></div>  <div class="col-md-3"><div class="form-group"><label class="control-label">Designation<span class="error-star" style="color:red;">*</span></label><input class="form-control default wrq" type="text" placeholder="Enter the designation" id="designation_valuation" name="wrq[' + i + '][designation_valuation]" value="" autocomplete="off"></div></div><div class="col-md-2"> <div class="form-group"> <label class="control-label">From Date:<span class="error-star" style="color:red;">*</span></label><input class="form-control default  wrq dob fde_' + i + '" type="text" oninput="input(this)" id="fde' + i + '" name="wrq[' + i + '][fde_yes]"  placeholder="DD-MM-YYYY" autocomplete="off"></div></div><div class="col-md-2"><div class="form-group"><label class="control-label">To Date:</label><input class="form-control default  wrq dob tde_' + i + '" type="text" oninput="input(this)" id="tde' + i + '"  name="wrq[' + i + '][tde_yes]" placeholder="DD-MM-YYYY" autocomplete="off"></div></div><div class="col-md-3"><div class="form-group"><label class="control-label"><span id="item_label"></span>Scope & Responsibilities:<span class="error-star" style="color:red;">*</span></label><div class="d-flex"><textarea rows="10" columns="10" placeholder="Scope & Responsibilities" class="form-control default wre" type="text" id="scoope" name="wre[' + i + '][scope]" autocomplete="off"></textarea><button style="margin-top:30px" type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove_company">X</button></div></div></div></section>');
        i++;

        $("#attachment_counter").val(i);
        date_picker();

    });
</script>



<!-- Deepika -->

<!-- Work Experience validation -->

<script>


    function nruexpcre() {

        event.preventDefault();
        //yes
            
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


            const fdate_all = document.querySelectorAll('#qv1 #fde');
            for (const fde of fdate_all) {
                if (fde.value == '') {
                    swal.fire("Please Enter All the From Date", "", "error");

                    return false;
                }
            }


            const tdate_all = document.querySelectorAll('#qv1 #tde');
            for (const tde of tdate_all) {
                if (tde.value == '') {
                    swal.fire("Please Enter All the To Date", "", "error");

                    return false;
                }
            }


            const scoope_all = document.querySelectorAll('#scoope');
            for (const scope of scoope_all) {
                if (scope.value == '') {
                    swal.fire("Please Enter the Scope & Responsibilities", "", "error");
                    return false;
                }
            }


            if ($('#certification').attr('class') == 'nav-items navv active') {
                const cert_all = document.querySelectorAll('#nopb');
                for (const nopb of cert_all) {
                    if (nopb.value == '') {
                        swal.fire("Please Enter the Name of the Professional Body", "", "error");
                        return false;
                    }
                }


                const certissue_all = document.querySelectorAll('#certib');
                for (const certib of certissue_all) {
                    if (certib.value == '') {
                        swal.fire("Please Enter the Certificate issued by", "", "error");
                        return false;
                    }
                }

                const certd_all = document.querySelectorAll('#certd');
                for (const certd of certd_all) {
                    if (certd.value == '') {
                        swal.fire("Please Upload the Certification Documents", "", "error");
                        return false;
                    }
                }


                var customtext = "Are you sure want to Save the Details";
            } else {
                var customtext = "Please click yes,If you want to save the details or No, to Fill Certification Details";
            }

            Swal.fire({

                title: "Are you want to submit?",
                text: customtext,
                icon: "warning",
                customClass: 'swalalerttext',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: true,
                showLoaderOnConfirm: true,
                width: '550px',
            }).then((result) => {
                if (result.value) {
                    if (customtext == "Are you sure want to Save the Details") {


                        var cert = $("#nopb").val();
                        if (cert == '') {
                            swal.fire("Please Enter the Name of the Professional Body", "", "error");
                            event.preventDefault();
                            return false;
                        }

                        var cer = $("#certib").val();
                        if (cer == '') {
                            swal.fire("Please Enter the Certificate issued by", "", "error");
                            event.preventDefault();
                            return false;
                        }

                        var certifi = $("#certd").val();
                        if (certifi == '') {
                            swal.fire("Please Upload the Certification Documents", "", "error");
                            event.preventDefault();
                            return false;
                        }
                        document.getElementById('nrueducreate_form').submit();

                    }
                     else {
                        document.getElementById('nrueducreate_form').submit();
                    }


                } else {
                    $("#content").find("[id^='tab']").hide(); // Hide all content
                    $("#tabs li").removeClass("active"); //Reset id's
                    $("#certification").addClass("active"); // Activate this

                    document.getElementById("tab2").style.display = "block";

                }
            })




    }
</script>


<script>
    window.onload = function() {

        document.querySelector(".startdate").addEventListener("keypress", function(evt) {
            var charCode = evt.which || evt.keyCode;
            var charStr = String.fromCharCode(charCode);

            if (/[\d\.,\/;:`]/.test(charStr)) {
                evt.preventDefault(); // Prevent entering the character
            }
        });
    }
</script>


<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>










@endsection