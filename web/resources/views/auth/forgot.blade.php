@extends('layouts.app')

<style>
.loginname {
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    color: white;
    font-size: 18px;
    font-weight: 700;
    padding: 10px;
}

.forgot-card {
    border-radius: 20px;
    width: 76%;
    z-index: 1;
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

    {{-- Background --}}
    <div style="position:absolute">
        <img src="{{ asset('assets/images/login-image.PNG') }}" style="width:100%">
    </div>

    {{-- Layout --}}
    <div class="row" style="display:flex;justify-content:flex-end;padding:6rem 9rem 0 0;">

        <div class="col-12 col-sm-7 col-md-6 col-lg-4 col-xl-5 d-flex justify-content-center">

            <div class="card forgot-card shadow">

                {{-- Header --}}
                <div class="login-head">
                    <h4 class="loginname">Forgot Password</h4>
                </div>

                {{-- Logo --}}
                <div class="text-center mt-3">
                    <img src="{{asset('asset/image/Talentra-1.svg')}}" style="width:60%">
                </div>

                {{-- Alerts --}}
                @if (session('success'))
                <div class="alert alert-success m-2">
                    {{ session('success') }}
                </div>
                @endif

                @if (session('loginfail'))
                <div class="alert alert-danger m-2">
                    {{ session('loginfail') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger m-2">
                    @foreach ($errors->all() as $error)
                    {{ $error }}
                    @endforeach
                </div>
                @endif

                {{-- Form --}}
                <div class="card-body">

                    <form method="POST" action="{{ route('forgot_password') }}">
                        @csrf

                        {{-- Email --}}
                        <div class="mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" placeholder="Enter your Email" value="{{ old('email') }}" required
                                style="border-radius:15px;background-color:white">

                            @error('email')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        {{-- Button --}}
                        <div class="text-center">
                            <button class="btn btn-primary font-weight-bold">
                                Send Reset Link
                            </button>
                        </div>

                        {{-- Back --}}
                        <div class="text-center mt-3">
                            <a href="{{ url('/') }}" class="btn btn-link">
                                ← Back to Login
                            </a>
                        </div>

                    </form>

                </div>
            </div>

            {{-- Overlay Image --}}
            <div class="overlay-img">
                <img src="{{ asset('assets/images/login_man.PNG') }}">
            </div>

        </div>
    </div>
</div>

@endsection