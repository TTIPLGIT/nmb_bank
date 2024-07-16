<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>    -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('css/Bootstrap v(5_1_3).css') }}" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.10/clipboard.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <!-- <script type="text/javascript" async="" src="https://www.gstatic.com/recaptcha/releases/6pQzWaE1NP-gB4FrqRViKjM-/recaptcha__en.js" crossorigin="anonymous" integrity="sha384-NhK24afP2ps2kR47SpbjdlSWZpU+9az+xsX7PjdZR0ZdVmpAbm1ugPMJoAg10oa+"></script> -->
    <!-- passwordstrength -->
    <link href="{{ asset('assets/css/mediaquery.css') }}" rel="stylesheet" type="text/css" />
    <!-- <link rel="stylesheet" href="css/jquery.passwordRequirements.css" /> -->
    <!-- <script src="/path/to/cdn/jquery.min.js"></script> -->
    <!-- <script src="js/jquery.passwordRequirements.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>


    <style>
        .login-head {

            border-bottom-style: none;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            background-color: #4F42FF;
            padding: 12px
        }

        .rounded-halfpillleftside {
            border-top-left-radius: 0.75rem;
            border-bottom-left-radius: 0.75rem;
        }

        .rounded-halfpillrightside {
            border-top-right-radius: 0.75rem;
            border-bottom-right-radius: 0.75rem;
        }

        .account_text {
            color: #2f2f81 !important;
        }

        .login {
            color: #3490dc !important;
        }

        .agreecolor {
            color: #4cc34c;
        }

        .custom_label {
            margin-bottom: 0px !important;
            color: black;
            font-weight: bold;
        }

        .error_message {

            font-size: 12px !important;
            color: red !important;
        }

        .error_text {

            font-size: 11px !important;
            color: red !important;
        }

        .span_message {

            font-size: 14px !important;
            color: red !important;
        }

        .message_error {
            font-size: 15px !important;
            color: red !important;
            margin-left: 31px;
        }

        .image-size {
            width: 100%;
        }

        @media (min-width:319.96px) {
            body {
                /* background-image: url("{{asset('assets/images/login-image.PNG')}}"); */
                background-size: 63rem !important;
                background-repeat: no-repeat;
                background-position: center;
                min-height: 100vh !important;
            }
        }

        @media (min-width:767.96px) {
            body {
                /* background-image: url("{{asset('assets/images/login-image.PNG')}}"); */
                background-size: 56rem !important;
                background-repeat: no-repeat;
                background-position: center;
            }
        }

        @media (min-width:893.96px) {
            body {
                /* background-image: url("{{asset('assets/images/login-image.PNG')}}"); */
                background-size: cover !important;
                background-repeat: no-repeat;
                background-position: center;
            }
        }

        @media (min-width:2559.96px) {
            .col-2560 {
                flex: 0 0 auto;
                width: 16.66666667%;
            }
        }

        .login_email_icon {
            float: right;
            position: absolute;
            right: 1.5rem;
            font-size: 1.5rem;
            color: #000000;
            font-weight: 900 !important;
        }

        .login_pass_icon {
            float: right;
            /* position: absolute; */
            right: 1.5rem;
            /* font-size: 1.4rem; */
            x
            /* font-weight: 900 !important; */
            /* top: 0.4rem; */
        }

        .border-243c92 {
            border-color: #243c92 !important;
        }

        .rounded-halfpill {
            border-radius: 0.75rem !important;
        }

        .bg-243c92 {
            background-color: #243c92;
        }

        .fwcolor {
            font-weight: 900 !important;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 75px;
            background-color: white;
        }

        #email::placeholder {
            color: #001d85 !important;
            font-weight: bolder !important;
        }

        #password::placeholder {
            color: #001d85 !important;
            font-weight: bolder !important;
        }

        #name::placeholder {
            color: #001d85 !important;
            font-weight: bolder !important;
        }

        #password-confirm::placeholder {
            color: #001d85 !important;
            font-weight: bolder !important;
        }

        #mobile_no::placeholder {
            color: #001d85 !important;
            font-weight: bolder !important;
        }

        #dor::placeholder {
            color: #001d85 !important;
            font-weight: bolder !important;
        }

        #dor::placeholder {
            color: #001d85 !important;
            font-weight: bolder !important;
        }

        #ISU_Membership_Number::placeholder {
            color: #001d85 !important;
            font-weight: bolder !important;
        }

        .centerclass {
            display: flex !important;
            justify-content: center !important;
            width: 100% !important;
        }

        input[type="date"]:focus:before,

        input[type="date"]::placeholder {
            content: none !important;


        }

        .form-control:disabled,
        .form-control[readonly] {
            background-color: #fff;
            opacity: 1;
        }



        .dor {
            display: flex;
            flex-direction: row-reverse;
        }

        .sweet-alert p {
            color: #797979;
            font-size: 16px;
            text-align: center;
            font-weight: 600 !important;
            position: relative;
            margin: 0;
            line-height: normal;
        }

        .sweet-alert p {
            color: #cf3140 !important;
            font-size: 18px !important;
        }

        .sweet-alert button {
            background-color: rgb(58 172 224 / 91%) !important;
        }

        .sweet-alert {
            border-radius: 5px;
            border: 2px solid #00aaff !important;
        }

        .sweet-alert .icon.error {
            border-color: #cf3140 !important;
        }

        .sweet-alert .icon.error .line {
            background-color: #cf3140 !important;

        }

        .sweet-alert .icon.success .placeholder {
            border: 4px solid #1c91378f !important;
        }


        .sweet-alert .icon.info {
            border-color: #14a6e3 !important;
        }

        .sweet-alert .icon.info .line {
            background-color: #14a6e3 !important;

        }

        .logo-center {
            position: absolute;
            top: 193px;
            right: 109px;
            width: 53%;
            pointer-events: none;
            z-index: 10;
            opacity: 17%;
        }

        .footer_direction {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .logo_design {
            position: absolute;
            top: 90px;
            right: 88px;
            width: 53%;
            pointer-events: none;
            z-index: 10;
            opacity: 17%;
        }


        .firm {
            font-size: 17px;
            font-weight: bold;
            color: #243c92 !important;
            margin-bottom: 20px;
        }

        .logfirm {
            padding: 5px 15px 5px 13px;
            margin: 10px;
            font-size: 18px;
            font-weight: bold;
        }

        /* passwordstrength */
    </style>

</head>

<body class="">
    <div id="app">
        <!-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    
                    <ul class="navbar-nav me-auto">

                    </ul>

                    
                    <ul class="navbar-nav ms-auto">
                        
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav> -->

        <main class="">
            @yield('content')
        </main>
    </div>
</body>

</html>