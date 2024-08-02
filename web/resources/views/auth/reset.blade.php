@extends('layouts.app')

@section('content')
<div class="container_fluid ">
    <div class="justify-content-center">
        <div clas="col-10">
            <h1 class="text-center fwcolor">
                <a type="button" href="{{url('/')}}" class="btn btn-primary bg-243c92 font-weight-bold rounded-halfpill ml-3"><i class="fa fa-arrow-circle-left" aria-hidden="true" style="    font-size: 1.4rem; display: flex;align-items: center;"></i> </a>
                <span class="mx-auto">VALUATION PROFESSIONAL PORTAL</span>

            </h1>
        </div>
    </div>
</div>


<div class="container-fluid mt-lg-4">
    <div class="row justify-content-start">
        <div class="col-10 offset-1 col-sm-7 col-md-6 col-lg-4 col-xl-3 col-xxl-3 col-2560">
            <div class="card border border-4 border-243c92 rounded-3">
                <div class="row justify-content-center">
                    <img class="col-6 m-3 col-sm-6 col-md-6 col-lg-4 col-xl-5 col-xxl-5" src="{{asset('assets/images/MLHUD-IMG (1).png')}}" alt="logo">
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

                @if ($errors->any())
                <div class="alert alert-danger">

                    @foreach ($errors->all() as $error)
                    {{ $error }}
                    @endforeach

                </div>
                @endif


                <div class="card-body">
                    <form method="POST" action="{{ route('reset_password') }}" class="form-signin">
                        @csrf
                        <div class="row mb-3">

                            <!-- <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label> -->

                            <div class="input-group form-label-group col-12">
                                <input id="email" type="email" class="form-control border border-2 border-243c92 rounded-halfpillleftside @error('email') is-invalid @enderror" name="email" value="{{$email}}" placeholder="Email"  required autocomplete="off" autofocus readonly>

                                <!-- <input id="email" type="email" class="form-control border border-2 border-243c92 rounded-halfpillleftside @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="off" autofocus disabled> -->
                                <div class="input-group-append">
                                        <span class="input-group-text rounded-halfpillrightside" id="basic-addon1" style="background: transparent;">
                                            <i class="bi bi-person-fill" style="color:black !important"></i>
                                        </span>
                                    </div>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label> -->

                            <div class="input-group form-label-group col-12">
                                <input id="password" type="password" class="form-control border border-2 border-243c92 rounded-halfpillleftside login_pass @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="off">
                                <div class="input-group-append">
                                    <span class="input-group-text rounded-halfpillrightside" id="basic-addon1" style="background: transparent;">
                                        <i class="fa fa-lock login_pass_icon" id="toggle" onclick="passlock_show();"></i>

                                    </span>
                                </div>
                                <sapn class="caplock-indicator invalid-warning" style="display: none;">WARNING! Caps lock is ON.</sapn>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror




                        <div class="form-label-group">

                            <input type="password" id="c_password" name="c_password" class="form-control" placeholder="Confirm New Password">

                        </div>

                        @error('c_password')
                        <div class="error">{{ $message }}</div><br>
                        @enderror


                        <div class="centerclass">
                            <button class="btn btn-primary bg-243c92 mt-3 font-weight-bold rounded-halfpill" type="submit">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- <script type="application/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script> -->
<script>
    $(document).ready(function() {

        var remember = $.cookie('remember');
        if (remember == 'true') {
            var email = $.cookie('email');

            // autofill the fields
            $('#email').val(email);

        }



    });
</script>
<script>
    function passlock_show() {
        const pass = document.getElementById('password');
        const toggle = document.getElementById('toggle');
        if (pass.getAttribute('type') == "password") {
            pass.setAttribute('type', 'text');
            toggle.classList.remove('fa-lock');
            toggle.classList.add('fa-unlock');

        } else {
            pass.setAttribute('type', 'password');
            toggle.classList.remove('fa-unlock');
            toggle.classList.add('fa-lock');


        }
    }
</script>
@endsection