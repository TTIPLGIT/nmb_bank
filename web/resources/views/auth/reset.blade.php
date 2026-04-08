@extends('layouts.app')

<style>
.loginname {
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center !important;
    color: white !important;
    font-size: 19px !important;
    font-weight: 800 !important;
    padding-top: 5px;
}

.login-card {
    position: relative;
    border-radius: 20px;
    width: 76%;
    z-index: 1;
}

.man-overlay {
    position: absolute;
    top: 0;
    margin-top: 165px;
    right: -70px;
    z-index: 2;
}

.man-overlay img {
    width: 200px;
}
</style>

@section('content')

<div class="container_fluid">

    {{-- Sweet Alert --}}
    @if (session('success'))
    <script>
    window.onload = function() {
        Swal.fire("Success", "{{ session('success') }}", "success");
    }
    </script>
    @elseif(session('error'))
    <script>
    window.onload = function() {
        Swal.fire("Error", "{{ session('error') }}", "error");
    }
    </script>
    @endif

    {{-- Background Image --}}
    <div style="position:absolute">
        <img src="{{asset('assets/images/login-image.PNG')}}" style="width:100%">
    </div>

    <div class="row login-card" style="display:flex;justify-content:flex-end;padding:6rem 9rem 0 0;">

        <div class="col-12 col-sm-7 col-md-6 col-lg-4 col-xl-5 col-xxl-3 d-flex justify-content-center">

            <div class="card" style="border-radius:20px;width:76%;z-index:1">

                <div class="login-head">
                    <h4 class="loginname">Reset Password</h4>
                </div>

                {{-- Errors --}}
                @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                    {{ $error }}
                    @endforeach
                </div>
                @endif

                <div class="card-body">

                    <form method="POST" action="{{ route('reset_password') }}">
                        @csrf

                        {{-- Email (Readonly) --}}
                        <div class="mb-3">
                            <input type="email" name="email" value="{{ $email }}" class="form-control" readonly
                                style="border-radius:15px;background-color:white">
                        </div>

                        {{-- New Password --}}
                        <div class="mb-3">
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="New Password" required style="border-radius:15px;background-color:white">
                        </div>

                        {{-- Confirm Password --}}
                        <div class="mb-3">
                            <input type="password" name="c_password" class="form-control" placeholder="Confirm Password"
                                required style="border-radius:15px;background-color:white">
                        </div>

                        {{-- Show Password --}}
                        <!-- <div class="mb-3 text-center">
                            <input type="checkbox" id="showPassword"> Show Password
                        </div> -->

                        {{-- Submit --}}
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary font-weight-bold">
                                Change Password
                            </button>
                        </div>

                    </form>
                </div>
            </div>

            {{-- Overlay Image --}}
            <div class="man-overlay">
                <img src="{{ asset('assets/images/login_man.PNG') }}">
            </div>

        </div>
    </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById("showPassword").addEventListener("change", function() {
    let pass = document.getElementById("password");

    pass.type = this.checked ? "text" : "password";
});
</script>

@endsection