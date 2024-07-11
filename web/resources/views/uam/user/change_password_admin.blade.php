@extends('layouts.adminnav')
@section('content')

<style>
  .error {
    color: red;
    size: 80%
  }

  .hidden {
    display: none;
  }

  .toggle-password {
    float: right;
    cursor: pointer;
    margin-right: 10px;
    margin-top: -25px;
  }
</style>
<div class="main-content">

  <!-- Main Content -->
  <section class="section">


    <div class="section-body mt-1">
      <div class="row">
        <div class="col-md-12 col-lg-12 mlr-auto">
          <div class="tile my-4">
            <h3 class="tile-title">Change Password</h3>
            <div class="tile-body">


              <form class="form-horizontal" name="myForm" method="POST" action="{{ url('change_password_admin') }}" enctype="multipart/form-data">

                @csrf
                <div class="row">

                  <input class="form-control" type="hidden" id="user_id" name="user_id" placeholder="Enter Module Name" value="{{ $id }}">

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">New Password <span style="color: red;font-size: 16px;">*</span></label>

                      <input type="password" id="new_password" name="new_password" placeholder="Enter New Password" class="form-control">
                      <i class="toggle-password fa fa-fw fa-eye-slash"></i>
                    </div>



                    <label style="color:#f30202!important">Notes</label>
                    <p> Validation Format - at least 1 uppercase character (A-Z),
                      at least 1 lowercase character (a-z),
                      at least 1 digit (0-9),
                      at least 1 special character (punctuation)</p>
                    @error('new_password')
                    <div class="error">{{ $message }}</div>
                    @enderror

                  </div>


                  <div class="col-md-6">
                    <!-- <div class="form-group">
             <label class="control-label">Confirm Password<span style="color: red;font-size: 16px;">*</span></label>
              <input class="form-control" type="text"  id="confirm_password" name="confirm_password"  placeholder="Enter Confirm Password" value="" >
              @error('confirm_password')
              <div class="error">{{ $message }}</div>
              @enderror
            </div> -->


                    <div class="form-group">
                      <label class="control-label">Confirm Password<span style="color: red;font-size: 16px;"> *</span></label>
                      <input type="password" id="confirm_password" name="confirm_password" placeholder="Enter Confirm Password" class="form-control">
                      <i class="toggle-password fa fa-fw fa-eye-slash"></i>
                      @error('confirm_password')
                      <div class="error">{{ $message }}</div>
                      @enderror
                    </div>


                  </div>
                </div>

                <div class="row text-center">
                  <div class="col-md-12">
                    <button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Update </button>&nbsp;
                    <button class="btn btn-primary" type="reset"><i class="fa fa-undo"></i> Reset </button>&nbsp;
                    <a class="btn btn-danger footer_btn_cancel" href="{{ route('user.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Cancel </a>&nbsp;
                  </div>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script type="text/javascript">
  $(".toggle-password").click(function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    input = $(this).parent().find("input");
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });
</script>



<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
@if (session('fail'))


<input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('fail') }}">
<script type="text/javascript">
  window.onload = function() {
    var message = $('#session_data').val();

    bootbox.alert({
      title: "Alert",
      centerVertical: true,
      message: message
    });
  }
</script>


@endif
@endsection