@extends('layouts.app')

@section('content')

<div class="container_fluid ">
    @if (session('success'))

    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data').val();
            swal.fire({
                title: "Success",
                text: message,
                type: "success",
                icon: 'success',
            });

        }
    </script>
    @elseif(session('error'))

    <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data1').val();
            swal.fire({
                title: "Info",
                text: message,
                type: "info",
                icon: 'errotr',

            });

        }
    </script>
    @endif

    <!-- <div class="justify-content-center">
        <div clas="col-10">
            <h1 class="text-center fwcolor">
                <a type="button" href="{{url('http://mlhud-uganda-portal.com/')}}" class="btn btn-primary bg-243c92 font-weight-bold rounded-halfpill ml-3"><i class="fa fa-arrow-circle-left" aria-hidden="true" style="    font-size: 1.4rem; display: flex;align-items: center;"></i> </a>
                <span class="mx-auto Title">VALUATION PROFESSIONAL PORTAL</span>

            </h1>
        </div>
    </div> -->



    
        <div class="bg-image">
            <!-- <div class="image-size" style="position:absolute">
                <img class="image-size" src="{{asset('assets/images/login-image.PNG')}}" alt="">
            </div> -->

            <div class="row login_card image-size" style="display:flex;justify-content: flex-end;padding:6rem 9rem 0rem 0rem">
                <div class="col-12 col-sm-7 col-md-6 col-lg-4 col-xl-5 col-xxl-3 col-2560 d-flex justify-content-center">
                    <div class="card" style="position:relative;border-radius:20px;width:76%;z-index:1">
                        <div class="login-head">
                            <!-- <img class="col-6 m-3 col-sm-6 col-md-6 col-lg-4 col-xl-5 col-xxl-5" src="images\MLHUD-IMG (1).png" alt="logo"> -->
                            <h4 style="text-align:center"><i class="fa fa-lock" style="color:white;"></i></h4>
                        </div>

                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif

                        @if (session('loginfail'))
                        <div class="alert alert-danger">
                            {{ session('loginfail') }}
                        </div>
                        @endif
                        @if (session('danger'))
                        <div class="alert alert-danger">
                            {{ session('loginfail') }}
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
                            <form method="POST" action="{{ route('login') }}" id="login">
                                @csrf
                                <input type="hidden" name="exid" class="exid" id="exid" value="0">

                                <div class="row mb-3">
                                    <!-- <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label> -->

                                    <div class="input-group form-label-group col-12">

                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="" required autocomplete="off" autofocus style="border-radius:15px;background-color:white">
                                        <!-- <div class="input-group-append">
                                            <span class="input-group-text rounded-halfpillrightside" id="basic-addon1" style="background: transparent;">
                                                <i class="bi bi-person-fill" style="color:black !important"></i>
                                            </span>
                                        </div> -->
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <!-- <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label> -->
                                    <!-- <div class="form-group" style="text-align:left">
                                        <label class="control-label required" style="color:white">Password :</label>
                                        <input class="form-control" type="password" name="password" id="exampleInputPassword1" class="form-control" placeholder="Password">
                                        <i class="fa fa-lock toggle-password" id="toggle" onclick="passlock_show();"></i>
                                    </div> -->
                                    <div class="form-group col-12">
                                        <!-- <label class="control-label required">Password :</label> -->
                                        <input id="password" type="password" class="form-control login_pass @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="off" style="border-radius:15px;background-color:white">
                                        
                                        <!-- <div class="input-group-append">
                                            <span class="input-group-text rounded-halfpillrightside" id="basic-addon1" style="background: transparent;">
                                                <i class="fa fa-lock login_pass_icon" id="toggle" onclick="passlock_show();"></i>
                                            </span> 
                                        </div> -->
                                        <sapn class="caplock-indicator invalid-warning" style="display: none;">WARNING! Caps lock is ON.</sapn><br>
                                        <input type="checkbox" id="toggle" onclick="passlock_show();" style="margin-left:8px"> Show Password

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- <div class="centerclass">
                                    <script src="https://www.google.com/recaptcha/api.js?hl=en" async="" defer=""></script>
                                    <div class="g-recaptcha" theme="light" id="buzzNoCaptchaId_ecc25929768a8fb68da3971cca1856bb" data-sitekey="6LciGbgUAAAAABgVCIIPTXeBoQgLwvqzFgH5VbdG">
                                        <div style="width: 304px; height: 78px;">
                                            <div>
                                                <iframe title="reCAPTCHA" src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6LciGbgUAAAAABgVCIIPTXeBoQgLwvqzFgH5VbdG&amp;co=aHR0cHM6Ly9maWEtdWdhbmRhLWVkcm1zLmNvbTo0NDM.&amp;hl=en&amp;v=6pQzWaE1NP-gB4FrqRViKjM-&amp;size=normal&amp;cb=ihf9syplcbz9" width="304" height="78" role="presentation" name="a-j99yfj3ezpzu" frameborder="0" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox"></iframe>
                                            </div>
                                            <textarea id="g-recaptcha-response" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea>
                                        </div>
                                        <iframe style="display: none;"></iframe>
                                    </div>
                                </div> -->
                                <div class="row mb-0 justify-content-center" style="margin-top:15%">
                                    <div class="col text-center">
                                    <a class="btn btn-outline-secondary font-weight-bold" onclick="gt_user()">
                                            New User?
                                        </a>
                                        <button type="submit" class="btn btn-primary font-weight-bold">
                                            {{ __('SIGN IN') }}
                                        </button>

                                        

                                    </div>
                                </div>


                                <div class="row" style="margin-top:7%">
                                    <div class="col-6">
                                        <div class="form-check text-center font-weight-bold">
                                            <input class="form-check-input border border-2 border-243c92" type="checkbox" name="remember" id="remember" checked {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember" style="font-size:13px; margin-bottom:40px;">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <span class=""><a href="{{ route('forgot') }}" class="btn btn-link p-1 m-0 text-info font-weight-bold" style="color:#eb1b22; font-weight: 500;font-size:12px; margin-top:-3px!important; position:relative;">Forgot Password?</a></span>
                                    </div>
                                </div>

                                
                                <!-- <div class="mt-2 d-flex justify-content-center">
                                    <a type="" href="{{route('firm')}}" class="firm">Firm Signup</a>
                                </div> -->


                                <!-- <div class="row mb-0 justify-content-center"> -->
                                    <div class="col text-center footer">
                                        <a class="btn p-1 m-0 font-weight-bold" href="{{ route('policypage')}}">
                                            Privacy Policy
                                        </a>|
                                        <a class="btn p-1 m-0 font-weight-bold" href="{{ route('FAQ') }}">
                                            FAQ
                                        </a>
                                    </div>
                                <!-- </div> -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
                <div class="" style="position:absolute;top: 13%;left: 77%;z-index: 1;">
                    <img class="" src="{{asset('assets/images/login_man.PNG')}}" alt="" style="width:80%;">
                </div>
        </div>
  
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- <script type="application/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script> -->

    <script>
        function gt_user() {
            Swal.fire({
                title: "Choose a Option?",
                icon: "warning",
                customClass: 'swalalerttext',
                showCancelButton: true,
                confirmButtonColor: '#243c92',
                cancelButtonColor: '#243c92',
                confirmButtonText: "Professional Member (Non-Uganda Resident)",
                cancelButtonText: "Graduate Trainee",
                closeOnConfirm: false,
                closeOnCancel: true,
                showLoaderOnConfirm: true,
                width: '500px',
            }).then((result) => {

                if (result.value) {
                    //PF

                    window.location.replace('/register_member');


                } else {
                    //GT
                    window.location.replace('/register');


                }
            })
        }
    </script>




    <script>
        $(document).ready(function() {

            var remember = $.cookie('remember');
            if (remember == 'true') {
                var email = $.cookie('email');
                var password = $.cookie('password');
                // autofill the fields
                $('#email').val(email);
                $('#password').val(password);
            }


            $("#login").submit(function() {

                if ($('#remember').is(':checked')) {

                    var email = $('#email').val();
                    var password = $('#password').val();

                    // set cookies to expire in 14 days
                    $.cookie('email', email, {
                        expires: 14
                    });
                    $.cookie('password', password, {
                        expires: 14
                    });
                    $.cookie('remember', true, {
                        expires: 14
                    });
                } else {
                    $.removeCookie('email');
                    $.removeCookie('password');
                    $.removeCookie('remember');
                }
            });
        });
    </script>


    <script>
        function passlock_show() {
            const pass = document.getElementById('password');
            const toggle = document.getElementById('toggle');
            if (pass.getAttribute('type') == "password") {
                pass.setAttribute('type', 'text');
                // toggle.classList.remove('fa-lock');
                // toggle.classList.add('fa-unlock');

            } else {
                pass.setAttribute('type', 'password');
                // toggle.classList.remove('fa-unlock');
                // toggle.classList.add('fa-lock');


            }
        }
    </script>

    <script>
        $(document).ready(function() {
            var password = document.querySelector('#password');
            password.addEventListener("keyup", function(event) {
                if (event.getModifierState("CapsLock")) {
                    $('.caplock-indicator').fadeIn();
                } else {
                    $('.caplock-indicator').fadeOut();
                }

            })
            // Get the current URL
            var url = window.location.href;

            // Create a URL object from the URL
            var urlObject = new URL(url);

            // Access the value of a specific parameter
            var paramValue = urlObject.searchParams.get('exlink');

            document.getElementById('exid').value = paramValue;

            // Remove the desired parameter
            urlObject.searchParams.delete('exlink');

            // Generate the updated URL without the parameter
            var updatedUrl = urlObject.href;

            // Update the browser's history without redirecting
            history.pushState({
                path: updatedUrl
            }, '', updatedUrl);

            // Use the parameter value as needed
            console.log(paramValue); // Example: Print the parameter value to the console
        });
    </script>
    <script>

    </script>



    @endsection