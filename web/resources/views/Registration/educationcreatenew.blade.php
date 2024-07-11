@extends('layouts.adminnav')

@section('content')
<style>
    .form-control.default::-webkit-inner-spin-button,
    .form-control.default::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .no-arrows::-webkit-inner-spin-button,
    .no-arrows::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    i {
        pointer-events: none;
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
        /* color: white !important; */
        position: relative;
        background: #d8ddd3;
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

    .ad {
        background-color: #2725a4 !important;
    }
</style>


<div class="main-content">
    <div class="row justify-content-center">
        @if (session('success'))
        <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
        <script type="text/javascript">
            window.onload = function() {
                var message = $('#session_data').val();
                Swal.fire({
                    title: "Success",
                    text: message,
                    icon: "success",
                });


            }
        </script>
        @elseif(session('error'))
        <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
        <script type="text/javascript">
            window.onload = function() {
                var message = $('#session_data1').val();
                Swal.fire({
                    title: "info",
                    text: message,
                    icon: "info",
                });


            }
        </script>
        @endif
        <div class="col-lg-12 col-md-12">
            <div class="" style="height:100%; padding: 15px">


                <form action="{{ route('Registration.store') }}" method="POST" id="educreate_form" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" class="form-control" required id="user_details" name="user_details" value="educate">
                    <div class="tile" id="tile-1" style="margin-top:10px !important;">

                        <!-- Nav tabs -->

                        <ul class="nav nav-tabs nav-justified " id="tabs" role="tablist" style="background-image: none;">
                            <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                                <a class="nav-link  " id="home-tab" name="tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-home"></i><b> Education Details</b> <input type="checkbox" class="checkg" id="profile" name="nationality" value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
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

                                    <div id="dynamic_fielddip">
                                        <section class="input-box dip" id="rowdip">
                                            <div class="educationdip">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Course Type:<span class="error-star" style="color:red;">*</span></label>
                                                            <select class="form-control crsdip" id="course_typedip" name="course_typedip">
                                                                <option value="0">Select Course Type</option>
                                                                <option class="course_type" id="dip" value="Diploma">Diploma</option>
                                                                <option class="course_type" id="ug" value="Undergraduate">Undergraduate</option>
                                                                <option class="course_type" id="pg" value="Postgraduate">Postgraduate</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Institution Name:<span class="error-star" style="color:red;">*</span></label>
                                                            <input type="text" class="form-control unidip" id="university_namedip" placeholder="Enter Institution" name="university_name">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Course Name:<span class="error-star" style="color:red;">*</span></label>
                                                            <select class="form-control crsdip" id="course_namedip" name="course_name">
                                                                <option value="0">Select Course</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Completion Year<span class="error-star" style="color:red;">*</span></label>
                                                            <input type="month" class="form-control ypdip month_date"  maxlength="5" id="yopdip" name="yop" max="2023-06">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>CGPA</label>
                                                            <input type="number" min="1" max="5" class="form-control mkdip validate no-arrows" placeholder="Enter CGPA" id="m_percentagedip" name="m_percentage" step="0.01">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Graduation Certificate:
                                                                <span class="error-star" style="color:red;">*</span></label>
                                                            <input type="file" accept=".pdf,.png," class="form-control ccdip mb-0" id="consolidate_markdip" name="graduationcertifipath"><strong style="color: red;">Following files could be uploaded pdf,png</strong>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Other Documents:</label>
                                                            <input type="file" accept=".pdf,.png," class="form-control gcdip mb-0" id="garduation_certificatedip" name="otherdocuments"><strong style="color: red;">Following files could be uploaded pdf,png</strong>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </section>



                                    </div>
                                </div>
                                <!-- <div style="display:flex; justify-content:center; width:100%">

                                    <a type="button" class="btn btn-labeled btn-info" onclick="DoActions('tab2');" title="next" style="background: #4d94ff !important; border-color:#4d94ff !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-right"></i></span>Next</a>

                                </div> -->

                            </section>

                        </div>

                    </div>
                    <div style="display:flex; justify-content:center; width:100%">

                        <a type="button" class="btn btn-labeled btn-info" href="{{url('education_index')}}" title="next" style="background: red !important; border-color:red !important; color:white !important; margin-top:15px !important;">
                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>
                        <button onclick="educre()" id="registerbutton" class="btn btn-labeled btn-info form_submit_handle" title="Submit" style="background: green !important; border-color:green !important; color:white !important; margin-top:15px !important; margin-left: 15px;">
                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Submit</button>


                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script type="application/javascript">
    function file_validate() {
        $('input[type="file"]').change(function(event) {
            var inputFile = $(event.target);
            console.log(inputFile);
            validateFileSize(inputFile);
        })
    }

    function month_validator() {
        const monthPickers = document.querySelectorAll('.month_date');

        for (const monthPicker of monthPickers) {
            const currentDate = new Date();
            const currentYear = currentDate.getFullYear();
            const currentMonth = currentDate.getMonth() + 1; // Adding 1 because months are zero-indexed

            // Create a string with the maximum allowed year and month
            const maxDate = `${currentYear}-${currentMonth.toString().padStart(2, '0')}`;

            // Set the max attribute of the input field
            monthPicker.setAttribute('max', maxDate);

        }

        // Get the current year and month

    }

    function handleInput(event) {

        const inputElementValue = event.target.value;
        const regex = /^\d\.\d$/;
        if (inputElementValue > 5) {
            const allowedKeysafter5 = ["5", "0", "Backspace"];
            if (!allowedKeysafter5.includes(inputElementValue)) {
                event.target.value = inputElementValue.toString().slice(0, -2);


                event.preventDefault();
            }


        }
        if (inputElementValue.length > 1) {
            const regex2 = /^\d\$/;


            if (!regex.test(inputElementValue)) {
                event.target.value = inputElementValue.slice(0, -1);
                event.preventDefault();
            }

        } else {
            const allowedKeys = ["1", "2", "3", "4", "5", ".", "Backspace"];
            if (!allowedKeys.includes(inputElementValue)) {
                event.target.value = inputElementValue.slice(0, -1);
                event.preventDefault();
            }
        }

    }
    $(document).ready(function() {

        const inputElements = document.querySelectorAll("[type='number'].validate");
        for (const inputElement of inputElements) {
            inputElement.addEventListener("input", function(e) {
                const inputElementValue = e.target.value;
                const regex = /^\d+(\.\d{0,2})?$/;
                if (inputElementValue > 5) {
                    const allowedKeysafter5 = ["5", "0", "Backspace"];
                    if (!allowedKeysafter5.includes(inputElementValue)) {
                        e.target.value = inputElementValue.toString().slice(0, -2);


                        e.preventDefault();
                    }


                }
                if (inputElementValue.length > 1) {
                    const regex2 = /^\d\$/;


                    if (!regex.test(inputElementValue)) {
                        event.target.value = inputElementValue.slice(0, -1);
                        event.preventDefault();
                    }

                } else {
                    const allowedKeys = ["1", "2", "3", "4", "5", ".", "Backspace"];
                    if (!allowedKeys.includes(inputElementValue)) {
                        event.target.value = inputElementValue.slice(0, -1);
                        event.preventDefault();
                    }
                }

            });
        }
        $("#content").find("[id^='tab']").hide(); // Hide all content
        $("#tabs li:first").addClass("active"); // Activate the first tab
        $("#tab1    ").fadeIn(); // Show first tab's content

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


    function DoActions(id) {

        $("#content").find("[id^='tab']").hide(); // Hide all content
        $("#tabs li").removeClass("active"); //Reset id's
        $("#tabs a").removeClass("active"); //Reset id's
        $("a[name='" + id + "']").parent().addClass("active");
        $('#' + (id)).fadeIn(); // Show content for the current tab

    }

    function submit() {

        document.getElementById('educreate_form').submit();
    }
    var user_id = "<?php echo $user_id; ?>"
    document.getElementById('user_id').value = user_id;
    var i = 0;
    var j = 0;
    var k = 0;
    var l = 0;
    $("#addug").click(function(e) {
        e.target.style.display = "none";

        $('#dynamic_fieldug').append(
            '<section class="input-box ug" name="a" id="rowug">' +
            '<div class="educationug">' +
            '<div class="row">' +
            '<div class="col-md-4">' +
            '<div class="form-group">' +
            '<label>Graduation:<span class="error-star" style="color:red;">*</span></label>' +
            '<input type="text" class="form-control gradug" id="graduationug" name="ug[' + i + '][graduation]" value="Under Graduate" readonly>' +
            '</div>' +
            '</div>' +
            '<div class="col-md-4">' +
            '<div class="form-group">' +
            '<label>Institution Name:<span class="error-star" style="color:red;">*</span></label>' +
            '<input type="text" class="form-control uniug" requird id="university_nameug" name="ug[' + i + '][university_name]">' +
            '</div>' +
            '</div>' +
            '<div class="col-md-4">' +
            '<div class="form-group">' +
            '<label> Course Name:<span class="error-star" style="color:red;">*</span></label>' +
            '<select class="form-control crsug" id="course_nameug" name="ug[' + i + '][course_name]"> <option value="0">Select-Course</option> <option value="civil">civil</option> <option value="architect">architect</option> <option value="townplanning">townplanning</option> </select>' +
            '</div>' +
            '</div>' +
            '<div class="col-md-4">' +
            '<div class="form-group">' +
            '<label>Completion Year <span class="error-star" style="color:red;">*</span></label>' +
            '<input type="month" class="form-control ypug month_date" maxlength="5" id="yopug" name="ug[' + i + '][yop]">' +
            '</div>' +
            '</div>' +
            '<div class="col-md-4">' +
            '<div class="form-group">' +
            '<label>CGPA</label>' +
            '<input type="number" min="1" max="5" class="form-control mkug" id="m_percentageug" name="ug[' + i + '][m_percentage]">' +
            '</div>' +
            '</div>' +

            '<div class="col-md-4">' +
            '<div class="form-group">' +
            '<label>Graduation Certificate: <span class="error-star" style="color:red;">*</span></label>' +
            '<input type="file" accept=".pdf, .png," class="form-control ccug mb-0" id="consolidate_markug" name="ug[' + i + '][consolidate_mark]">' +
            '<strong style="color: red;">Following files could be uploaded pdf,png</strong>' +
            '</div>' +
            '</div>' +
            '<div class="col-md-4">' +
            '<div class="form-group">' +
            '<label>Other Documents:</label>' +
            '<input type="file" accept=".pdf, .png," class="form-control gcug mb-0" id="garduation_certificateug" name="ug[' + i + '][garduation_certificate]">' +
            '<strong style="color: red;">Following files could be uploaded pdf,png</strong>' +
            '</div>' +
            '</div>' +
            '<div>' +
            '<button style="margin-top:30px" type="button" name="remove" id="ug" value=' + i + ' class="btn btn-danger btn_removeug btn_create">X</button>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</section>'
        );

        i++;
        $("#attachment_countug").val(i);
        const inputElements = document.querySelectorAll("[type='number']");
        for (const inputElement of inputElements) {
            inputElement.addEventListener("input", handleInput);
        }
        month_validator();
        file_validate();
    });

    $("#addpg").click(function(e) {
        e.target.style.display = "none";

        // $('#dynamic_field').append('<div id="rowpg"><div class=""><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list"/></td><td><input type="text" name="email[]" placeholder="Enter your Email" class="form-control name_email"/></td><td></div>');  
        $('#dynamic_fieldpg').empty(); // Clear the existing content

        $('#dynamic_fieldpg').append(
            '<section class="input-box pg" id="rowpg">' + '<div class="educationpg">' + '<div class="row">' + '<div class="col-md-4">' + '<div class="form-group">' + '<label>Graduation:<span class="error-star" style="color:red;">*</span></label>' + '<input type="text" class="form-control gradpg" id="graduationpg" name="pg[' + j + '][graduation]" value="Post Graduation" readonly>' + '</div>' +
            '</div>' +
            '<div class="col-md-4">' +
            '<div class="form-group">' +
            '<label>Institution Name:<span class="error-star" style="color:red;">*</span></label>' +
            '<input type="text" class="form-control unipg" id="university_namepg" name="pg[' + j + '][university_name]">' +
            '</div>' +
            '</div>' +

            '<div class="col-md-4">' +
            '<div class="form-group">' +
            '<label>Course Name:<span class="error-star" style="color:red;">*</span></label>' +
            '<select class="form-control crspg" id="course_namepg" name="pg[' + j + '][course_name]">' +
            '<option value="0">Select Course</option>' +
            '<option value="civil">Civil</option>' +
            '<option value="architect">Architect</option>' +
            '<option value="townplanning">Town Planning</option>' +
            '</select>' +
            '</div>' +
            '</div>' +
            '<div class="col-md-4">' +
            '<div class="form-group">' +
            '<label>Completion Year<span class="error-star" style="color:red;">*</span></label>' +
            '<input type="month" class="form-control yppg month_date" maxlength="5" id="yoppg" name="pg[' + j + '][yop]">' +
            '</div>' +
            '</div>' +
            '<div class="col-md-4">' +
            '<div class="form-group">' +
            '<label>CGPA</label>' +
            '<input type="number" min="1" max="5" class="form-control mkpg" id="m_percentagepg" name="pg[' + j + '][m_percentage]">' +
            '</div>' +
            '</div>' +
            '<div class="col-md-4">' +
            '<div class="form-group">' +
            '<label>Graduation Certificate:<span class="error-star" style="color:red;">*</span></label>' +
            '<input type="file" accept=".pdf, .png," class="form-control ccpg mb-0" id="consolidate_markpg" name="pg[' + j + '][consolidate_mark]">' +
            '<strong style="color: red;">Following files could be uploaded pdf,png</strong>' +
            '</div>' +
            '</div>' +
            '<div class="col-md-4">' +
            '<div class="form-group">' +
            '<label>Other Documents:</label>' +
            '<input type="file" accept=".pdf, .png," class="form-control gcpg mb-0" id="garduation_certificatepg" name="pg[' + i + '][garduation_certificate]">' +
            '<strong style="color: red;">Following files could be uploaded pdf,png</strong>' +
            '</div>' +
            '</div>' +
            '<button style="margin-top:30px" type="button" name="remove" id="ug" value=' + i + ' class="btn btn-danger btn_removeug btn_create">X</button>' +
            '</div>' +
            '</div>' +
            '</section>'
        );
        j++;
        $("#attachment_countpg").val(j);
        const inputElements = document.querySelectorAll("[type='number']");
        for (const inputElement of inputElements) {

            inputElement.addEventListener("input", handleInput);

        }
        month_validator();
        file_validate();

    });
    $("#adddip").click(function(e) {
        e.target.style.display = "none";
        // $('#dynamic_field').append('<div id="rowdip"><div class=""><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list"/></td><td><input type="text" name="email[]" placeholder="Enter your Email" class="form-control name_email"/></td><td></div>');  
        $('#dynamic_fielddip').empty(); // Clear the existing content

        $('#dynamic_fielddip').append(
            '<section class="input-box dip" id="rowdip">' +
            '<div class="educationdip">' +
            '<div class="row">' +
            '<div class="col-md-4">' +
            '<div class="form-group">' +
            '<label>Course Type:<span class="error-star" style="color:red;">*</span></label>' +
            '<input type="text" class="form-control graddip" id="graduationdip" name="dip[' + k + '][graduation]" value="Diploma" readonly>' +
            '</div>' +
            '</div>' +
            '<div class="col-md-4">' +
            '<div class="form-group">' +
            '<label>Institution Name:<span class="error-star" style="color:red;">*</span></label>' +
            '<input type="text" class="form-control unidip" id="university_namedip" name="dip[' + k + '][university_name]">' +
            '</div>' +
            '</div>' +
            '<div class="col-md-4">' +
            '<div class="form-group">' +
            '<label>Course Name:<span class="error-star" style="color:red;">*</span></label>' +
            '<select class="form-control crsdip" id="course_namedip" name="dip[' + k + '][course_name]">' +
            '<option value="0">Select Course</option>' +
            '<option value="civil">Civil</option>' +
            '<option value="architect">Architect</option>' +
            '<option value="townplanning">Town Planning</option>' +
            '</select>' +
            '</div>' +
            '</div>' +
            '<div class="col-md-4">' +
            '<div class="form-group">' +
            '<label>Completion Year<span class="error-star" style="color:red;">*</span></label>' +
            '<input type="month" class="form-control ypdip month_date" maxlength="5" id="yopdip" name="dip[' + k + '][yop]">' +
            '</div>' +
            '</div>' +
            '<div class="col-md-4">' +
            '<div class="form-group">' +
            '<label>CGPA</label>' +
            '<input type="number" min="1" max="5" class="form-control mkdip" id="m_percentagedip" name="dip[' + k + '][m_percentage]">' +
            '</div>' +
            '</div>' +
            '<div class="col-md-4">' +
            '<div class="form-group">' +
            '<label>Graduation Certificate:<span class="error-star" style="color:red;">*</span></label>' +
            '<input type="file" accept=".pdf, .png," class="form-control ccdip mb-0" id="consolidate_markdip" name="dip[' + k + '][consolidate_mark]">' +
            '<strong style="color: red;">Following files could be uploaded pdf,png</strong>' +
            '</div>' +
            '</div>' +
            '<div class="col-md-4">' +
            '<div class="form-group">' +
            '<label>Other Documents:</label>' +
            '<input type="file" accept=".pdf, .png," class="form-control gcdip mb-0" id="garduation_certificatedip" name="dip[' + k + '][garduation_certificate]">' +
            '<strong style="color: red;">Following files could be uploaded pdf,png</strong>' +
            '</div>' +
            '</div>' +
            '<div>' +
            '<button style="margin-top:30px" type="button" name="remove" id="dip" value=' + k + ' class="btn btn-danger btn_removedip btn_create">X</button>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</section>'
        );
        k++;
        $("#attachment_countdip").val(k);



        const inputElements = document.querySelectorAll("[type='number']");
        for (const inputElement of inputElements) {

            inputElement.addEventListener("input", handleInput);

        }
        month_validator();
        file_validate();

    });
    $("#addphd").click(function(e) {
        e.target.style.display = "none";
        // $('#dynamic_field').append('<div id="rowphd"><div class=""><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list"/></td><td><input type="text" name="email[]" placeholder="Enter your Email" class="form-control name_email"/></td><td></div>');  
        $('#dynamic_fieldphd').append('<section class="input-box phd" id="rowphd"><div class="educationphd"> <div class="row"> <div class="col-md-4"><div class="form-group"><label>Graduation:<span class="error-star" style="color:red;">*</span></label><input type="text" class="form-control gradphd"  id="graduationphd" name="phd[' + l + '][graduation]" value="Ph.D" readonly> </div></div> <div class="col-md-4"> <div class="form-group"> <label>Institution Name:<span class="error-star" style="color:red;">*</span></label> <input type="text" class="form-control uniphd"  id="university_namephd" name="phd[' + l + ']university_name"> </div> </div> </div> <div class="row"> <div class="col-md-4"> <div class="form-group"> <label> Course Name:<span class="error-star" style="color:red;">*</span></label> <select class="form-control crsphd"  id="course_namephd" name="phd[' + l + '][course_name]"> <option value="0">Select-Course</option> <option value="civil">civil</option> <option value="architect">architect</option> <option value="townplanning">townplanning</option> </select> </div> </div> <!-- </div> <div class="row"> --> <div class="col-md-4"> <div class="form-group"> <label> Completion Year  <span class="error-star" style="color:red;">*</span></label> <input type="month" class="form-control ypphd month_date" maxlength="5"  id="yopphd" name="phd[' + l + '][yop]"> </div> </div> <div class="col-md-4"> <div class="form-group"> <label>CGPA</label> <input type="number" min="1" max="5" class="form-control mkphd"  id="m_percentagephd" name="phd[' + l + '][m_percentage]"> </div> </div> </div> <div class="row"> <div class="col-md-4"> <div class="form-group"> <label> Graduation Certificate: <span class="error-star" style="color:red;">*</span></label><input type="file" accept=".pdf, .png," class="form-control ccphd"  id="consolidate_markphd" name="phd[' + l + '][consolidate_mark]"><strong style="color: red;">Can select only pdf,png</strong></div> </div> <!-- </div> <div class="row"> --> <div class="col-md-4"> <div class="form-group"> <label> Other Documents:</label> <input type="file" accept=".pdf, .png," class="form-control gcphd mb-0"  id="garduation_certificatephd" name="phd[' + l + '][garduation_certificate]"><strong style="color: red;">Following files could be uploaded pdf,png</strong></div> </div> <div><button style="margin-top:30px" type="button" name="remove" id="phd" value=' + l + ' class="btn btn-danger btn_removephd btn_create">X</button></div> </div></div></section>');
        l++;
        $("#attachment_countphd").val(l);
        month_validator();
        file_validate();

    });

    $(document).on('click', '.btn_removeug', function() {
        $('#addug').show();
        $('#adddug').children().show();
        var button_id = $(this).attr("id");
        i = $('#attachment_count' + button_id + '').val();
        $('#row' + button_id + '').remove();
        --i;
        $('#attachment_count' + button_id + '').val;
        var a = document.getElementsByClassName('ug');
        for (var z = 0; z < a.length; z++) {
            document.getElementsByClassName('gradug')[z].setAttribute('name', "ug[" + z + "][graduation]");
            document.getElementsByClassName('clgug')[z].setAttribute('name', "ug[" + z + "][college_name]");
            document.getElementsByClassName('uniug')[z].setAttribute('name', "ug[" + z + "][university_name]");
            document.getElementsByClassName('crsug')[z].setAttribute('name', "ug[" + z + "][course_name]");
            document.getElementsByClassName('ypug')[z].setAttribute('name', "ug[" + z + "][yop]");
            document.getElementsByClassName('mkug')[z].setAttribute('name', "ug[" + z + "][m_percentage]");
            document.getElementsByClassName('gcug')[z].setAttribute('name', "ug[" + z + "][consolidate_mark]");
            document.getElementsByClassName('ccug')[z].setAttribute('name', "ug[" + z + "][garduation_certificate]");
        }
    });
    $(document).on('click', '.btn_removepg', function() {
        $('#addpg').show();
        $('#adddpg').children().show();
        var button_id = $(this).attr("id");
        j = $('#attachment_count' + button_id + '').val();
        $('#row' + button_id + '').remove();
        --j;
        $('#attachment_count' + button_id + '').val(j);
        var a = document.getElementsByClassName('pg');
        for (var z = 0; z < a.length; z++) {
            document.getElementsByClassName('gradpg')[z].setAttribute('name', "pg[" + z + "][graduation]");
            document.getElementsByClassName('clgpg')[z].setAttribute('name', "pg[" + z + "][college_name]");
            document.getElementsByClassName('unipg')[z].setAttribute('name', "pg[" + z + "][university_name]");
            document.getElementsByClassName('crspg')[z].setAttribute('name', "pg[" + z + "][course_name]");
            document.getElementsByClassName('yppg')[z].setAttribute('name', "pg[" + z + "][yop]");
            document.getElementsByClassName('mkpg')[z].setAttribute('name', "pg[" + z + "][m_percentage]");
            document.getElementsByClassName('gcpg')[z].setAttribute('name', "pg[" + z + "][consolidate_mark]");
            document.getElementsByClassName('ccpg')[z].setAttribute('name', "pg[" + z + "][garduation_certificate]");
        }
    });
    $(document).on('click', '.btn_removedip', function() {
        $('#adddip').show();
        $('#adddip').children().show();
        var button_id = $(this).attr("id");
        k = $('#attachment_count' + button_id + '').val();
        $('#row' + button_id + '').remove();
        --k;
        $('#attachment_count' + button_id + '').val(k);
        var a = document.getElementsByClassName('dip');
        for (var z = 0; z < a.length; z++) {
            document.getElementsByClassName('graddip')[z].setAttribute('name', "dip[" + z + "][graduation]");
            document.getElementsByClassName('clgdip')[z].setAttribute('name', "dip[" + z + "][college_name]");
            document.getElementsByClassName('unidip')[z].setAttribute('name', "dip[" + z + "][university_name]");
            document.getElementsByClassName('crsdip')[z].setAttribute('name', "dip[" + z + "][course_name]");
            document.getElementsByClassName('ypdip')[z].setAttribute('name', "dip[" + z + "][yop]");
            document.getElementsByClassName('mkdip')[z].setAttribute('name', "dip[" + z + "][m_percentage]");
            document.getElementsByClassName('gcdip')[z].setAttribute('name', "dip[" + z + "][consolidate_mark]");
            document.getElementsByClassName('ccdip')[z].setAttribute('name', "dip[" + z + "][garduation_certificate]");
        }
    });
    $(document).on('click', '.btn_removephd', function() {
        var button_id = $(this).attr("id");
        l = $('#attachment_count' + button_id + '').val();
        $('#row' + button_id + '').remove();
        --l;
        $('#attachment_count' + button_id + '').val(l);
        var a = document.getElementsByClassName('ug');
        for (var z = 0; z < a.length; z++) {
            document.getElementsByClassName('gradphd')[z].setAttribute('name', "phd[" + z + "][graduation]");
            document.getElementsByClassName('clgphd')[z].setAttribute('name', "phd[" + z + "][college_name]");
            document.getElementsByClassName('uniphd')[z].setAttribute('name', "phd[" + z + "][university_name]");
            document.getElementsByClassName('crsphd')[z].setAttribute('name', "phd[" + z + "][course_name]");
            document.getElementsByClassName('ypphd')[z].setAttribute('name', "phd[" + z + "][yop]");
            document.getElementsByClassName('mkphd')[z].setAttribute('name', "phd[" + z + "][m_percentage]");
            document.getElementsByClassName('gcphd')[z].setAttribute('name', "phd[" + z + "][consolidate_mark]");
            document.getElementsByClassName('ccphd')[z].setAttribute('name', "phd[" + z + "][garduation_certificate]");
        }
    });
</script>

<!-- Deepika -->

<script>
    // Diploma Course choosing Validation //

    function educre() {
       
        // var coll = $("#college_namedip").val();
        // if (coll == '') {
        //     swal.fire("Please Enter the College Name", "", "error");
        //     event.preventDefault();
        //     return false;
        // }

        var cour = $("#course_typedip").val();
        if (cour == '') {
            swal.fire("Please Select the Course Type", "", "error");
            event.preventDefault();
            return false;
        }

        var uni = $("#university_namedip").val();
        if (uni == '') {
            swal.fire("Please Enter the Institution Name", "", "error");
            event.preventDefault();
            return false;
        }

        var cou = $("#course_namedip").val();
        if (cou == '0') {
            swal.fire("Please Select the Course Name", "", "error");
            event.preventDefault();
            return false;
        }

        var year = $("#yopdip").val();
        if (year == '') {
            swal.fire("Please Select the Completion Year ", "", "error");
            event.preventDefault();
            return false;
        }

        // var percent = $("#m_percentagedip").val();
        // if (percent == '') {
        //     swal.fire("Please Enter the CGPA", "", "error");
        //     event.preventDefault();
        //     return false;
        // }

        var marks = $("#consolidate_markdip").val();

        if (marks == '') {
            swal.fire("Please Upload the Graduation Certificate", "", "error");
            event.preventDefault();
            return false;
        }

        // var grad = $("#garduation_certificatedip").val();
        // if (grad == '') {
        //     swal.fire("Please Upload the Other Documents ", "", "error");
        //     event.preventDefault();
        //     return false;
        // }


        //   Undergraduated Course Choosing Validation //

        // var coll = $("#college_nameug").val();
        // if (coll == '') {
        //     swal.fire("Please Enter the College Name", "", "error");
        //     event.preventDefault();
        //     return false;
        // }


        var uni = $("#university_nameug").val();
        if (uni == '') {
            swal.fire("Please Enter the University Name", "", "error");
            event.preventDefault();
            return false;
        }

        var cou = $("#course_nameug").val();
        if (cou == '0') {
            swal.fire("Please Select the Course Name", "", "error");
            event.preventDefault();
            return false;
        }

        var year = $("#yopug").val();
        if (year == '') {
            swal.fire("Please Select the Completion Year ", "", "error");
            event.preventDefault();
            return false;
        }

        // var percent = $("#m_percentageug").val();
        // if (percent == '') {
        //     swal.fire("Please Enter the CGPA", "", "error");
        //     event.preventDefault();
        //     return false;
        // }

        var marks = $("#consolidate_markug").val();

        if (marks == '') {
            swal.fire("Please Upload the Graduation Certificate", "", "error");
            event.preventDefault();
            return false;
        }

        // var grad = $("#garduation_certificateug").val();
        // if (grad == '') {
        //     swal.fire("Please Upload the Other Documents ", "", "error");
        //     event.preventDefault();
        //     return false;
        // }

        //   Post Graduation Course choosing Validation //

        // var coll = $("#college_namepg").val();
        // if (coll == '') {
        //     swal.fire("Please Enter the College Name", "", "error");
        //     event.preventDefault();
        //     return false;
        // }

        var uni = $("#university_namepg").val();
        if (uni == '') {
            swal.fire("Please Enter the University Name", "", "error");
            event.preventDefault();
            return false;
        }

        var cou = $("#course_namepg").val();
        if (cou == '0') {
            swal.fire("Please Select the Course Name", "", "error");
            event.preventDefault();
            return false;
        }

        var year = $("#yoppg").val();
        if (year == '') {
            swal.fire("Please Select the Completion Year ", "", "error");
            event.preventDefault();
            return false;
        }

        // var percent = $("#m_percentagepg").val();
        // if (percent == '') {
        //     swal.fire("Please Enter the CGPA", "", "error");
        //     event.preventDefault();
        //     return false;
        // }

        var marks = $("#consolidate_markpg").val();

        if (marks == '') {
            swal.fire("Please Upload the Graduation Certificate", "", "error");
            event.preventDefault();
            return false;
        }

        // var grad = $("#garduation_certificatepg").val();
        // if (grad == '') {
        //     swal.fire("Please Upload the Other Documents", "", "error");
        //     event.preventDefault();
        //     return false;
        // }
            preventSubmitButton('form_submit_handle');
            document.getElementById("educreate_form").submit();



    }
</script>


<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ url('educationcourse_list') }}",
            type: 'GET',
            data: {
                _token: '{{csrf_token()}}'
            },

            success: function(data) {
                $('#course_namedip option:first').nextAll().remove(); // Remove options after the first option

                for (const rows of data['data']) {
                    const single_option = `<option value="${rows.course_name}">${rows.course_name}</option>`
                    $('#course_namedip option:first').after(single_option);
                }

                $('.course_type').removeClass('d-none');
                if (data['dip'] == 1) {
                    $('#dip').addClass('d-none');
                }
                if (data['ug'] == 1) {
                    $('#ug').addClass('d-none');
                }
                if (data['pg'] == 1) {
                    $('#pg').addClass('d-none');
                }
            }
        });
    });
</script>


<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ url('educationcourse_list') }}",
            type: 'GET',
            data: {
                _token: '{{csrf_token()}}'
            },

            success: function(data) {
                $('#course_namedip option:first').nextAll().remove(); // Remove options after the first option

                for (const rows of data['data']) {
                    const single_option = `<option value="${rows.course_name}">${rows.course_name}</option>`
                    $('#course_namedip option:first').after(single_option);
                }

               
            }
        });
    });
</script>

@endsection