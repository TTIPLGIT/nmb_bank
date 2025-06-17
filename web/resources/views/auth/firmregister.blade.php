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

    .text_align {
        left: -65px !important;
    }

    /* .dob {
        width:10% !important;
    } */
    .ui-datepicker-trigger {
        position: absolute !important;
        right: 0px;
        top: 69%;
        left: 87%;
        transform: translateY(-51%);
        height: 29px !important;
    }
</style>
<div class="container_fluid ">
    <div class="justify-content-center">
        <div clas="col-10">


            <h1 class="text-center fwcolor">
                <a type="button" href="{{url('/')}}" class="btn btn-primary bg-243c92 font-weight-bold rounded-halfpill ml-3"><i class="fa fa-arrow-circle-left" aria-hidden="true" style="    font-size: 2rem; display: flex;align-items: center;"></i> </a>
                <span class="mx-auto mr-2">VALUATION PROFESSIONAL PORTAL</span>
                <a type="button" href="{{url('/')}}" class="btn btn-primary bg-243c92 logfirm">Login</a>

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
        <div class=" offset-1 col-sm-7 col-md-6 col-lg-4 col-xl-4 col-xxl-3 col-2560">
            <div class="custom card border border-4 border-243c92 rounded-3 mb-4" style="">
                <img class="logo_design" src="images\TALENTRA-IMG (1).png">
                <div class="row justify-content-center mt-2" style="display: flex; flex-wrap: wrap;  flex-direction: column;  text-align:center;">
                    <!-- <img class="col-4 mi-3 mt-3 col-sm-5 col-md-4 col-lg-4 col-xl-4 col-xxl-4" src="images\TALENTRA-IMG (1).png" alt="logo"> -->
                    <h4 class="color">Create an Guest Role</h4>
                    <h6 class="account_text">for firm Registraion<a href="/"><b class="login">Login here</b></a></h6>
                   
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
                    <form action="{{ route('firmregisterstore') }}" encrypt="multipart/form-data" method="POST" id="firmregister">
                        @csrf
                        <div class="row">
                            <div class="col mt-3">
                                <label class="custom_label" for="Email">Email</label>
                                <span class="error-star" id="spanname" style="color:red; position: absolute;top: 1px;left: 54px;">*</span>
                                <input type="text" id="email" name="email" value="" class="form-control">
                                <span class="span_message" id="emailerror"></span>
                            </div>
                        </div>

                       


                        <div class="row">
                            <div class="col mt-1">
                                <label class="custom_label" for="Other name(s)">Firm Name</label>
                                <span class="error-star" id="spanname" style="color:red; position: absolute;top: 1px;left: 87px;">*</span>
                                <input type="text" id="firmname" name="firmname" value="" class="form-control">
                                <span class="span_message" id="firmnameerror"></span>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col">
                                <label class="custom_label" for="pwd">Password</label>
                                <span class="error-star" id="spanname" style="color:red;     position: absolute;left: 83px;">*</span>
                                <input type="password" id="password" name="password" value="" class="form-control password">

                                <span class="span_message" id="passworderror"></span>
                                <i class="far fa-eye-slash" id="togglePassword" title="view" onclick="pass_show();" style="position:absolute; top:36px; right:20px; cursor:pointer;"></i>
                            </div>
                        </div>

                        <div class="row">
    <div class="col">
        <label class="custom_label" for="cpwd">Confirm Password</label>
        <span class="error-star" id="spanname" style="color:red; position: absolute;top: 1px;left: 136px;">*</span>
        <input type="password" id="confirmpassword" name="password_confirmation" value="" class="form-control">
        <span class="span_message" id="confirmpassworderror"></span>
        <i class="far fa-eye-slash" id="confirmtogglePassword" title="view" onclick="confirmpass_show();" style="position:absolute; top:36px; right:20px; cursor:pointer;"></i>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- <script type="application/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script> -->
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


    // $(function() {
    //     $(".pr-password").passwordRequirements();
    //     $(".pr-password").passwordRequirements({
    //         numCharacters: 8,
    //         useLowercase: true,
    //         useUppercase: true,
    //         useNumbers: true,
    //         useSpecial: true
    //     });
    //     $(".pr-password").passwordRequirements({
    //         style: "dark"
    //     });
    //     $(".pr-password").passwordRequirements({
    //         fadeTime: 500
    //     });
    // });


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









<script>
    var letters = /^[A-Za-z ]+$/;
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var passw = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/;
   


    function validate(e) {

        const email = document.getElementById("email");
        const password = document.getElementById("password");
        const confirmpassword = document.getElementById("confirmpassword");
        const datepicker = document.getElementById("datepicker");
        const firmname = document.getElementById("firmname");
        event.preventDefault();


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


        if (firmname.value == "") {
            $('#firmname').addClass('is-invalid');
            document.getElementById("firmnameerror").innerHTML =
                "**Please Enter the Firmname**";

        } else if (!firmname.value.match(letters)) {
            $('#firmname').addClass('is-invalid');
            document.getElementById("firmnameerror").innerHTML =
                "**Please enter a valid Firmname**";

        } else {
            document.getElementById("firmnameerror").innerText = "";
            $('#firmname').removeClass('is-invalid');
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
            $('#confirmpassword').addClass('is-invalid');

            document.getElementById("confirmpassworderror").innerHTML =
                "**Please Enter the Confirm Password**";

        } else {
            document.getElementById("confirmpassworderror").innerText = "";
            $('#confirmpassword').removeClass('is-invalid');
        }

        if (confirmpassword.value != (password.value)) {
            $('#confirmpassword').addClass('is-invalid');
            document.getElementById("confirmpassworderror").innerHTML =
                "**Password is not same**";

        } else {
            document.getElementById("confirmpassworderror").innerText = "";
            $('#confirmpassword').removeClass('is-invalid');
        }


        if (check.checked == false) {
            $('#check').addClass('is-invalid');

            document.getElementById("checkederror").innerHTML =
                "**Please Agree the Terms & Conditions**";
            return;
        } else {
            document.getElementById("checkederror").innerText = "";
            $('#check').removeClass('is-invalid');
        }

     

        const validation_parameter=$('.is-invalid');
            if(validation_parameter.length==0){
                preventSubmitButton('form_submit_handle');
                $("#firmregister").submit();
            }


    }
</script>
<script>
    const preventSubmitButton = (cl) => {
    $(`.${cl}`).attr('disabled',true);
    $(`.${cl}`).text('Submitting...');
    
  }
</script>

<script>
    window.onload = function() {
        document.querySelector('.ui-datepicker-trigger').title = 'dob';

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
            changeMonth: true,
            changeYear: true,
            yearRange: '1968:2030',
            showOn: "button",
            buttonImage: "images/calendar.gif",
            buttonImageOnly: true,
            maxDate: 0,
            inline: true
        });
    });
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
            changeMonth: true,
            changeYear: true,
            yearRange: '1999:2030',
            showOn: "button",
            buttonImage: "http://mlhud-uganda-portal.com:60159/images/calendar.png",
            class: "dateimage",
            buttonImageOnly: true,
            maxDate: 0,
            inline: true
        });
        document.querySelector('.ui-datepicker-trigger').style.width = "5%";
        document.querySelector('.ui-datepicker-trigger').style.position = "absolute";
        document.querySelector('.ui-datepicker-trigger').style.top = "27px";
        document.querySelector('.ui-datepicker-trigger').style.right = "21px";


    });
</script>

<script>
    function pass_show() {
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
    function confirmpass_show() {
        const pass = document.getElementById('confirmpassword');
        const togglePassword = document.getElementById('confirmtogglePassword');
        if (pass.getAttribute('type') === "password") {
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

@include('auth.verifyemail')

@endsection