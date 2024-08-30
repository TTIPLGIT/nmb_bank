@extends('layouts.app')

@section('content')
<style>
    .mh {
        background-image: linear-gradient(to right, #179f6c, #2daa87, #47b59f, #63bfb4, #81c8c6);
    }

    .custom {
        height: 20% !important;
        width: 50% !important;
    }

    * {
        margin: 0px !important;
        padding: 0px !important;
    }

    .custom_label {
        margin-bottom: 0px !important;
    }

    .color {
        color: black;
    }


    .ui-datepicker-trigger {
        position: absolute !important;
        right: 0px;
        top: 69%;
        left: 87%;
        transform: translateY(-51%);
        height: 29px !important;
    }

    .form-control.default::-webkit-inner-spin-button,
    .form-control.default::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }




    .col-8 {
        flex: 0 0 66.6666666667%;
        max-width: none !important;
    }

    .form-control.default {
        -moz-appearance: textfield;
    }
</style>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- <script type="application/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script> -->

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<div class="container_fluid ">
    <div class="justify-content-center">
        <div clas="col-10">


            <h1 class="text-center fwcolor">
                <a type="button" href="{{ config('setting.base_url') }}" src="{{asset('asset/image/Talentra-1.svg')}}" class="btn btn-primary bg-243c92 font-weight-bold rounded-halfpill ml-3"><i class="fa fa-arrow-circle-left" aria-hidden="true" style="    font-size: 2rem; display: flex;align-items: center;"></i></a>
                <span class="mx-auto">TTIPL - Learning Management System</span>



            </h1>
        </div>
    </div>
</div>

@if (session('success'))

<input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
<script type="text/javascript">
    window.onload = function() {
        var message = $('#session_data').val();
        swal({
            title: "Success",
            text: message,
            type: "success",
        });

    }
</script>
@elseif(session('error'))

<input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
<script type="text/javascript">
    window.onload = function() {
        var message = $('#session_data1').val();
        swal({
            title: "Info",
            text: message,
            type: "info",
        });


    }
</script>
@endif
<div class="container-fluid mt-lg-4">
    <div class="row justify-content-center">
        <div class=" col-sm-7 col-md-6 col-lg-4 col-xl-4 col-xxl-3 col-2560">
            <div class=" custom card border border-4 border-243c92 rounded-3 mb-4">
                <img class="logo-center" src="images\TALENTRA-IMG (1).png">
                <div class="row justify-content-center mt-2" style="display: flex; flex-wrap: wrap;  flex-direction: column; align-content:center; ">
                    <!-- <img class="col-4 mi-3 mt-3 col-sm-5 col-md-4 col-lg-4 col-xl-4 col-xxl-4" src="images\TALENTRA-IMG (1).png" alt="logo"> -->
                    <h4 class="color" style="align-self:center;">Create an Account</h4>
                    <h6 class="account_text">Already have an Account?<a href="{{ config('setting.base_url') }}"><b class="login">Login here </b></a></h6>
                </div>
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger">

                    @foreach ($errors->all() as $error)
                    {{ $error }}
                    @endforeach

                </div>
                @endif



                <div class="card-body">
                    <form action="{{ route('registerstore') }}" encrypt="multipart/form-data" method="POST" id="register">
                        @csrf
                        <input type="hidden" name="gender_value" id="gender_value" value="">
                        <div class="row">
                            <div class="col-6">
                                <label class="custom_label" for="Surname">Surname</label>
                                <span class="error-star" id="spanname" style="color:red;position: absolute;top: 1px;left: 78px;">*</span>
                                <input type="text" id="surname" name="surname" value="" placeholder="Enter Surname" class="form-control">
                                <div class="row d-flex justify-content-center">
                                    <span class="error_message" id="surnameerror"></span>
                                </div>

                            </div>
                            <div class="col-6">
                                <label class="custom_label" for="givenname">Given name</label>
                                <span class="error-star" id="spanname" style="color:red;     position: absolute;top: 1px;left: 96px;">*</span>
                                <input type="text" id="givenname" name="name" value="" placeholder="Enter Given Name" class="form-control">
                                <div class="row d-flex justify-content-center">
                                    <span class="error_text" id="givennameerror"></span>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label class="custom_label" for="Other name(s)">Other name(s)</label>
                                <input type="text" id="othername" name="othername" placeholder="Enter Other Name" value="" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mt-1 date_picker">
                                <label class="custom_label" for="dob">DOB</label>
                                <span class="error-star" id="spanname" style="color:red; position: absolute;top: 1px;left: 54px;">*</span>
                                <!-- <input type="date" id="dob" name="dob" value="" class="form-control"> -->
                                <input type="text" id="cleave_date" name="dob" value="" placeholder='Enter DOB' class="form-control dob startdate">
                                <span class="span_message" id="doberror"></span>
                            </div>
                        </div>




                        <div class="row">
                            <div class="col mt-3">
                                <label class="custom_label" for="Email">Email</label>
                                <span class="error-star" id="spanname" style="color:red; position: absolute;top: 1px;left: 54px;">*</span>
                                <input type="text" id="email" name="email" autocomplete="off" placeholder="Enter Email" value="" class="form-control">
                                <span class="span_message" id="emailerror"></span>
                            </div>
                        </div>


                        <!-- <div class="row mt-1">
                            <div class="col d-flex justify-content-between">
                                <label class="custom_label" for="cpwd">Interest</label>
                                <div>
                                    <input type="radio" id="interest" name="interest" value="trainee" class="type_of_role" checked>
                                    <label class="fw-light label_type_of_role" for="trainee">Trainee</label>

                                </div>
                                <div>
                                    <input type="radio" id="financial" name="interest" value="financial" class="type_of_role">
                                    <label for="financial">Financial</label>

                                </div>
                                <div>
                                    <input type="radio" id='institution' name="interest" value="institution" class="type_of_role">
                                    <label for="institution">Institution</label>

                                </div>
                            </div>
                        </div> -->


                        <div class="row mt-1 gener">
                            <div class="col d-flex justify-content-between">
                                <label class="custom_label" for="newreval">Gender</label>
                                <div class="col-12 d-flex align-items-baseline ml-4" style="gap:10px">
                                    <input type="radio" id="male" name="gender" value="male" class="gender">
                                    <label class="fw-light" for="male">Male</label>
                                    <input type="radio" id="female" name="gender" value="female" class="gender">
                                    <label for="female">Female</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <span class="span_message" id="gendererror"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label class="custom_label" for="">Country</label>
                                <select class="form-control" id="country" name="country" placeholder="Select Country">
                                    <option value="">Select the Country</option>

                                    <option value="uganda" selected>Uganda</option>

                                </select>
                                <span class="span_message" id="countryerror"></span>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col">
                                <label class="custom_label" for="Mobile Number">Mobile Number</label>
                                <span class="error-star" id="spanname" style="color:red; position: absolute;top: 1px;left: 118px;">*</span>
                                <input type="tel" id="mobile" name="Mobile_no" value="" placeholder="Enter Mobile Number" class="form-control default" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                <span class="span_message" id="mobileerror"></span>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col">
                                <label class="custom_label" for="pwd">Password</label>
                                <span class="error-star" id="spanname" style="color:red;     position: absolute;left: 83px;">*</span>
                                <input type="password" id="password" name="password" placeholder="Enter Password" value="" class="form-control">
                                <span class="span_message" id="passworderror"></span>
                                <i class="far fa-eye-slash" title="view" id="togglePassword" onclick="pass_view();" style="position:absolute; top:36px; right:20px; cursor:pointer;"></i>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label class="custom_label" for="cpwd">Confirm Password</label>
                                <span class="error-star" id="spanname" style="color:red;     position: absolute;top: 1px;left: 136px;">*</span>
                                <input type="password" id="confirmpassword" aria-autocomplete="none" autocomplete="off" name="password_confirmation" placeholder="Re-enter Password Again" value="" class="form-control">
                                <span class="span_message" id="confirmpassworderror"></span>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col agreecolor">
                                <input type="checkbox" value="check" id="check"> <label for="check">I Agree that the information provided is correct</label>
                                <span class="message_error" id="checkederror"></span>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-3">
                                <button type="submit" class="btn btn-primary form_submit_handle" onclick="validate(event)">Submit</button>
                            </div>
                        </div>
                </div>


                </form>

            </div>
        </div>
    </div>
</div>
</div>

<script>
    $(document).on("click", ".type_of_role", function(e) {
        const check_values = $('.type_of_role');
        for (const check_value of check_values) {
            if (check_value.checked == true) {
                if (check_value.value != "trainee") {
                    $('.gener').hide();
                } else {
                    $('.gener').show();

                }

            }

        }


    });
    var letters = /^[A-Za-z ]+$/;
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var number = /^\d{10}$/;
    var passw = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/;
    var birth = /^\d{4}-\d{2}-\d{2}$/;

    function getAge(dateString) {
        var today = new Date();
        var birthDate = new Date(dateString);
        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }

        return age;
    }

    function validate(e)

    {

        const surname = document.getElementById("surname");
        const givenname = document.getElementById("givenname");
        const email = document.getElementById("email");
        const mobile = document.getElementById("mobile");
        const password = document.getElementById("password");
        const confirmpassword = document.getElementById("confirmpassword");
        const cleave_date = document.getElementById("cleave_date");
        const country = document.getElementById("country");
        const genders = document.querySelectorAll(".gender");



        //     function validate(e) {
        //     var e = document.getElementById("country");
        //     var optionSelIndex = e.options[e.selectedIndex].value;
        //     var optionSelectedText = e.options[e.selectedIndex].text;
        //     if (country == 0) {
        //         alert("Please select a Country");
        //     }
        //     else {
        //         alert("Success !! You have selected Country : " + optionSelectedText); ;
        //     }
        // }

        e.preventDefault();


        if (surname.value == "") {
            $('#surname').addClass('is-invalid');
            document.getElementById("surnameerror").innerHTML =
                "**Please Enter the Surname**";

        } else if (!surname.value.match(letters)) {
            $('#surname').addClass('is-invalid');
            document.getElementById("surnameerror").innerHTML =
                "**Please enter a valid Surname**";

        } else {
            document.getElementById("surnameerror").innerText = "";
            $('#surname').removeClass('is-invalid');
        }






        if (givenname.value == "") {
            $('#givenname').addClass('is-invalid');
            document.getElementById("givennameerror").innerHTML =
                "**Please Enter the Given Name**";

        } else if (!givenname.value.match(letters)) {
            $('#givenname').addClass('is-invalid');
            document.getElementById("givennameerror").innerHTML =
                "**Please enter a valid Givenname**";

        } else {
            $('#givenname').removeClass('is-invalid');
            document.getElementById("givennameerror").innerText = "";
        }



        if (email.value == "") {
            $('#email').addClass('is-invalid');
            document.getElementById("emailerror").innerHTML =
                "**Please Enter the Email**";

        } else if (!filter.test(email.value)) {
            $('#email').addClass('is-invalid');
            document.getElementById("emailerror").innerHTML =
                "**Please Enter the Valid Email Id**";

        } else {
            $('#email').removeClass('is-invalid');
            document.getElementById("emailerror").innerText = "";
        }


        var exist = 0;

        if ($('.gener').attr('style') != "display: none;") {
            for (const gender of genders) {
                if (gender.checked == true) {
                    $('#gender_value').val(gender.value);
                    exist++;
                }

            }
            if (exist == 0) {
                $('#gendererror').addClass('is-invalid');
                document.getElementById("gendererror").innerHTML = "**Please select the Gender**";

            } else {
                $('#gendererror').removeClass('is-invalid');
                document.getElementById("gendererror").innerHTML = "";

            }
        }
        if (country.value == "") {
            $('#country').addClass('is-invalid');
            document.getElementById("countryerror").innerHTML = "**Please select the Country**";

        } else {
            $('#country').removeClass('is-invalid');

            document.getElementById("countryerror").innerText = "";
        }


        if (mobile.value == "") {
            $('#mobile').addClass('is-invalid');

            document.getElementById("mobileerror").innerHTML =
                "**Please Enter the Mobile Number**";

        } else if (!number.test(mobile.value)) {
            $('#mobile').addClass('is-invalid');
            document.getElementById("mobileerror").innerHTML =
                "**Please Enter the Valid Mobile Number**";

        } else {
            $('#mobile').removeClass('is-invalid');
            document.getElementById("mobileerror").innerText = "";
        }



        if (password.value == "") {
            document.getElementById("passworderror").innerHTML =
                "**Please Enter the Password**";

        } else if (!passw.test(password.value)) {
            document.getElementById("passworderror").innerHTML =
                "**Password must be atleast 8 characters long and alteast one lower and uppercase character and atleast one digit **";

        } else {
            document.getElementById("passworderror").innerText = "";
        }






        if (confirmpassword.value == "") {
            document.getElementById("confirmpassworderror").innerHTML =
                "**Please Enter the Confirm Password**";

        } else {
            document.getElementById("confirmpassworderror").innerText = "";
        }




        if (confirmpassword.value != (password.value)) {
            document.getElementById("confirmpassworderror").innerHTML =
                "**Password is not same**";

        } else {
            document.getElementById("confirmpassworderror").innerText = "";
        }


        if (cleave_date.value == "") {

            document.getElementById("doberror").innerHTML =
                "**Please Select the DOB**";
        } else if (getAge(cleave_date.value) < 18) {
            document.getElementById("doberror").innerHTML =
                "**User is not allowed to enter the site at this time, the user must be ablove 18.**";
            cleave_date.focus();
            return false;
        } else {
            document.getElementById("doberror").innerText = "";
        }


        if (check.checked == false) {
            document.getElementById("checkederror").innerHTML =
                "**Please Agree the Terms & Conditions**";
            return;
        } else {
            document.getElementById("checkederror").innerText = "";
        }


        //     if (way.value =="") {
        //     document.getElementById("wayerror").innerHTML ="**Please select the Country**";

        //   }

        //   else{
        //     document.getElementById("wayerror").innerText ="";
        //   }

        const validation_parameter = $('.is-invalid');
        if (validation_parameter.length == 0) {
            preventSubmitButton('form_submit_handle');
            $("#register").submit();
        }
    }
</script>


<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // $(document).ready(function() {

    //     var cd;
    //     var today = new Date();
    //     var dd = String(today.getDate()).padStart(2, '0');
    //     var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    //     var yyyy = today.getFullYear();
    //     var dor = "Date of Registration ";
    //     cd = dd + '/' + mm + '/' + yyyy;

    //     document.getElementById('dor').value = cd;



    // });

    function span(a, b, c) {
        var a = a.value;
        if (a == "") {
            document.getElementById(b).style.display = "block";

        } else {
            document.getElementById(b).style.display = "none";
        }
        if (c == "fnu") {
            let value = event.target.value || '';
            value = value.replace(/[^0-9+ ]/, '', );
            event.target.value = value;
        } else if (c == "fna") {
            let value = event.target.value || '';
            value = value.replace(/[^a-z A-Z ]/, '', );
            event.target.value = value;

        } else {

        }
    }


    function formatName(event) {
        let value = event.target.value || '';
        value = value.replace(/[^a-z A-Z ]/, '', );
        event.target.value = value;

    }





    function formatNumber(event, a) {
        let value = event.target.value || '';
        value = value.replace(/[^0-9]/, '', );
        event.target.value = value;
        if (value != null && value.replace(/[^0-9]/)) {
            // otp = "otp"+a+"";
            otp = `otp${a}`;
            document.getElementById(otp).focus();
        }

    }

    function sendotp() {

        var email = document.getElementById('email').value;
        let status = "Not Verified";
        $.cookie('status', status);
        $.cookie('emailverify', email);
        $("#resend").attr("disabled", true);
        setTimeout(function() {
            $("#resend").attr("disabled", false);
        }, 120000);
        let timerOn = true;

        function timer(remaining) {
            var m = Math.floor(remaining / 60);
            var s = remaining % 60;

            m = m < 10 ? '0' + m : m;
            s = s < 10 ? '0' + s : s;
            document.getElementById('resend').innerHTML = m + ':' + s;
            remaining -= 1;

            if (remaining >= 0 && timerOn) {
                setTimeout(function() {
                    timer(remaining);
                }, 1000);
                return;
            }

            if (!timerOn) {
                // Do validate stuff here
                return;
            }

            // Do timeout stuff here
            document.getElementById('resend').innerHTML = "Resend-Otp";
        }

        timer(120);

        $.ajax({
            url: "{{ route('otpsend') }}",
            type: 'POST',
            data: {
                email: email,

                _token: '{{csrf_token()}}'
            },
            error: function() {
                alert('Something is wrong');
            },
            success: function(data) {
                console.log(data);
                swal({
                        title: "Success",
                        text: "Otp Sent Successfully",
                        type: "success"
                    },

                );
                return true;
            }
        });

    }

    function verifyotp() {

        var email = document.getElementById('email').value;
        var otp1 = document.getElementById('otp1').value;
        var otp2 = document.getElementById('otp2').value;
        var otp3 = document.getElementById('otp3').value;
        var otp4 = document.getElementById('otp4').value;
        var otp5 = document.getElementById('otp5').value;
        var otp6 = document.getElementById('otp6').value;

        // try{


        if ((otp1 === "") || (otp2 === "") || (otp3 === "") || (otp4 === "") || (otp5 === "") || (otp6 === "")) {

            return false;
        }
        // if((otp1 === "") || (otp2 === "") || (otp3 === "") || (otp4 === "") || (otp5 === "") || (otp6 === "") ) throw "Invalid";

        // }
        // catch(err){
        //     document.getElementById('error').innerHTML = "OTP field is " + err;
        //     return false;
        // }
        $("#verifyotpbtn").attr("disabled", true);
        setTimeout(function() {
            $("#verifyotpbtn").attr("disabled", false);
        }, 10000);
        $.ajax({
            url: "{{ route('otpverify') }}",
            type: 'POST',
            data: {
                email: email,
                otp1: otp1,
                otp2: otp2,
                otp3: otp3,
                otp4: otp4,
                otp5: otp5,
                otp6: otp6,
                _token: '{{csrf_token()}}'
            },
            error: function() {
                swal({
                        title: "Failed",
                        text: "OTP Mismatched",
                        type: "fail"
                    },

                );
                return false;
            },
            success: function(response) {

                let fnstatus = response.success;

                if (fnstatus === "Success") {
                    swal({
                        title: "Success",
                        text: "Email Verified Successfully",
                        type: "success"
                    }, );
                    let status = "Verified";
                    $.cookie('status', status);
                    $.cookie('emailverify', email);
                    return true;
                } else {

                    swal({
                        title: "Warning",
                        text: "Incorrect OTP",
                        type: "warning"
                    }, );

                    return true;
                }
            }
        });

    }

    function getotp() {
        var a = document.getElementById('email').value;
        var verifyemail = $.cookie('emailverify');
        var status = $.cookie('status');
        if (a === verifyemail && status === "Verified") {
            var Verify = document.getElementById('Verify')
            $("#Verify").prop("disabled", true);
            document.getElementById('Verify').innerHTML = 'Verified <i class="fa fa-check" aria-hidden="true" style="color: lightgreen; font-size: 20px;"></i>'
            return false;
        }
        if (a !== "") {

            document.getElementById('vemail').value = a;
            document.getElementById('voemail').value = a;
            $('#addModal').modal('show');
        } else {
            swal({
                    title: "Warning",
                    text: "Please Enter Email",
                    type: "warning"
                },

            );
            return false;
        }

    }

    function setTooltip(message) {
        $('#Verify').tooltip('hide')
            .attr('data-original-title', message)
            .tooltip('show');
    }
</script>

<!-- <script>
    window.onload = function() {
        document.querySelector('.ui-datepicker-trigger').title = 'DOB';


        document.querySelector(".startdate").addEventListener("keypress", function(evt) {
            var charCode = evt.which || evt.keyCode;
            var charStr = String.fromCharCode(charCode);

            if (/[\d\.,\/;:`]/.test(charStr)) {
                evt.preventDefault(); // Prevent entering the character
            }
        });
    }
</script> -->




<script>
    function pass_view() {
        const pass = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');
        if (pass.getAttribute('type') == "password") {
            pass.setAttribute('type', 'text');
            togglePassword.classList.remove('fa-eye-slash');
            togglePassword.classList.add('fa-eye');

        } else {
            pass.setAttribute('type', 'password');
            togglePassword.classList.remove('fa-eye');
            togglePassword.classList.add('fa-eye-slash');
        }
    }
</script>


<script>
    function pass_view() {
        const pass = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');
        if (pass.getAttribute('type') == "password") {
            pass.setAttribute('type', 'text');
            togglePassword.classList.remove('fa-eye-slash');
            togglePassword.classList.add('fa-eye');

        } else {
            pass.setAttribute('type', 'password');
            togglePassword.classList.remove('fa-eye');
            togglePassword.classList.add('fa-eye-slash');
        }
    }
</script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    var $j = jQuery.noConflict();
    $j(function() {
        $j('.dob').datepicker({
            dateFormat: 'dd-mm-yy',
            showButtonPanel: true,
            dateonly: true,
            changeMonth: true,
            changeYear: true,
            yearRange: '1900:2030',
            showOn: "button",
            buttonImage: "/images/calendar.png",
            class: "dateimage",
            buttonImageOnly: true,
            maxDate: 0,
            inline: true
        });

        $j('.dob').prop('readonly', true);

        document.querySelector('.ui-datepicker-trigger').style.width = "5%";
        document.querySelector('.ui-datepicker-trigger').style.position = "absolute";
        document.querySelector('.ui-datepicker-trigger').style.top = "27px";
        document.querySelector('.ui-datepicker-trigger').style.right = "21px";


    });
</script>

<script>
    const preventSubmitButton = (cl) => {
        $(`.${cl}`).attr('disabled', true);
        $(`.${cl}`).text('Submitting...');

    }
</script>








@include('auth.verifyemail')
@include('footer')
@endsection