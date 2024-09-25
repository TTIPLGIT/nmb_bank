@extends('layouts.app')
<style>
    .forgot {
        display: flex;
        justify-content: center;
    }
</style>
@section('content')
<style>
</style>
<div class="col-md-12">
    <div class="container_fluid">
        <div class="justify-content-center">
            <div clas="col-10">
                <h1 class="text-center fwcolor">
                    <a type="button" href="{{url('/')}}" class="btn btn-primary bg-243c92 font-weight-bold rounded-halfpill ml-3"><i class="fa fa-arrow-circle-left" aria-hidden="true" style="font-size: 1.4rem; display: flex;align-items: center;"></i> </a>
                    <span class="mx-auto">TTIPL - Learning Management System</span>

                </h1>
            </div>
        </div>
    </div>
   


    <div class="container-fluid mt-lg-4">
        <div class="row justify-content-start">
            <div class="col-lg-12 forgot">
                <div class="card border border-4 border-243c92 rounded-3">
                    <br>
                    <div class="sidebar-brand" style="display:flex;align-items:center;text-align:center;justify-content:center;">
                        <img src="{{asset('asset/image/Talentra-1.svg')}}" class="logo" style="width: 70% !important;">
                        </a>
                    </div>
                    <br>
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
                        <form method="POST" action="{{ route('forgot_password') }}" class="form-signin">
                            @csrf

                            <div class="row mb-3">
                                <!-- <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label> -->
                                <div class="col-md-12">
                                    <div class="form-label-group col-md-12">
                                        <i class="bi bi-person-fill login_email_icon"></i>
                                        <input id="email" type="email" class="form-control border border-2 border-243c92 rounded-halfpill @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @error('email')
                            <div class="error">{{ $message }}</div><br>
                            @enderror

                            <div class="centerclass">
                                <button class="btn btn-primary bg-243c92 font-weight-bold rounded-halfpill" type="submit">Send Password Reset Link</button>
                            </div>

                        </form>
                    </div>
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
                // reset cookies
                $.cookie('email', null);
                $.cookie('password', null);
                $.cookie('remember', null);
            }
        });
    });
</script>
@endsection