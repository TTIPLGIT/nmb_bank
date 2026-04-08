@extends('layouts.app')

<style>
.alert-card {
    border-radius: 20px;
    width: 100%;
}

.alert-title {
    text-align: center;
    font-weight: bold;
    font-size: 20px;
    color: white;
    background: #243c92;
    padding: 12px;
    border-radius: 20px 20px 0 0;
}

.alert-img {
    width: 120px;
    margin: 20px auto;
    display: block;
}

.alert-text {
    text-align: center;
    font-size: 14px;
    margin-bottom: 20px;
}

.overlay-img {
    position: absolute;
    right: -70px;
    top: 150px;
    z-index: 2;
}

.overlay-img img {
    width: 180px;
}
</style>

@section('content')

<div class="container_fluid">

    {{-- Background Image --}}
    <div style="position:absolute">
        <img src="{{ asset('assets/images/login-image.PNG') }}" style="width:100%">
    </div>

    <div class="row" style="display:flex;justify-content:flex-end;padding:6rem 9rem 0 0;">

        <div class="col-12 col-sm-7 col-md-6 col-lg-4 col-xl-5 d-flex justify-content-center">

            <div class="card alert-card shadow">

                {{-- Header --}}
                <div class="alert-title">
                    TALENTRA - Session Expired
                </div>

                {{-- Body --}}
                <div class="card-body">



                    <p class="alert-text">
                        Your reset password link session has expired.<br>
                        Please re-initiate your reset password request.
                    </p>

                    <div class="text-center">
                        <a href="{{ route('home') }}" class="btn btn-primary font-weight-bold">
                            Go to Home
                        </a>
                    </div>

                </div>
            </div>

            {{-- Optional Overlay Image --}}
            <div class="overlay-img">
                <img src="{{ asset('assets/images/login_man.PNG') }}">
            </div>

        </div>
    </div>
</div>

@endsection