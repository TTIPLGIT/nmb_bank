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

  @media(min-width:320px) {
    h5.profile_align {
      margin-left: 15px !important;
    }
  }
</style>
<div class="main-content">
  <!-- Main Content -->
  <section class="section">
    <div class="section-body mt-1">
      <h5 class="profile_align" style="color:darkblue">Profile Settings</h5>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <form class="form-horizontal" method="post" name="profile" id="upload-image-form"
                enctype="multipart/form-data" autocomplete="off">

                @csrf
                <div class="row">


                  <input class="form-control" type="hidden" id="user_id" name="user_id" placeholder="Enter Module Name"
                    value="{{ $one_row[0]['id'] }}">


                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">User Name <span style="color: red;font-size: 16px;"></span></label>
                      <input class="form-control" type="text" id="name" name="name" placeholder="Enter User Name"
                        value="{{ $one_row[0]['name'] }}" disabled="">
                      @error('name')
              <div class="error">{{ $message }}</div>
            @enderror
                    </div>
                  </div>


                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Email <span style="color: red;font-size: 16px;"></span></label>
                      <input class="form-control" type="email" id="email" name="email" placeholder="Enter Email"
                        value="{{ $one_row[0]['email'] }}" disabled="">
                      @error('email')
              <div class="error">{{ $message }}</div>
            @enderror
                    </div>
                  </div>

                  @if($one_row[0]['phone_number'] != "")
            <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">Phone Number <span
                style="color: red;font-size: 16px;"></span></label>
              <input class="form-control" type="text" id="phone_number" name="phone_number"
              placeholder="Enter Phone Number" value="{{ $one_row[0]['phone_number'] }}" autocomplete="off">
              @error('phone_number')
          <div class="error">{{ $message }}</div>
        @enderror

            </div>
        @else
      <div class="col-md-6">
        <div class="form-group">
        <label class="control-label">Phone Number <span
          style="color: red;font-size: 16px;"></span></label>
        <input class="form-control" type="text" id="phone_number" name="phone_number"
          placeholder="Enter Phone Number" value="{{ $one_row[0]['phone_number'] }}" autocomplete="off">
        @error('phone_number')
      <div class="error">{{ $message }}</div>
    @enderror

        </div>
      @endif



                      <label style="color:#f30202!important">Notes</label>
                      <p> Validation Format -7872348272</p>


                      <div id="phone_error" class="error hidden">Please enter a valid phone number</div>

                    </div>


                    <div class="col-md-6">




                      <div class="row">
                        <div class="small-12 medium-2 large-2 columns">
                          <div class="circle11">
                            <img class="profile-pic" value="" src="{{ $one_row[0]['profile_image'] }}">

                          </div>
                          <div class="p-image">
                            <i class="fa fa-camera upload-button"></i>


                            <input class="file-upload" type="file" id="signature_attachment" name="signature_attachment"
                              placeholder="Enter Signature Attachment" accept="image/*"
                              style="padding: 3px 6px;margin: 0px;">

                            <input type="hidden" name="signature" id="signature"
                              value="{{ $one_row[0]['profile_image'] }}">
                          </div>
                        </div>
                      </div>


                      <div class="form-group">



                        <br>


                        @error('profile_image')
              <div class="error">{{ $message }}</div>
            @enderror
                      </div>
                    </div>
                    <input class="form-control" type="hidden" id="user_type" name="user_type"
                      placeholder="Enter Password" value="AD">


                  </div>

                  <div class="row text-center">
                    <div class="col-md-12">

                      <button onclick="update_validation()" class="btn btn-success" id="update_button" disabled
                        type="submit"><i class="fa fa-check"></i> Update </button>&nbsp;
                      <button class="btn btn-primary" type="reset"><i class="fa fa-undo"></i> Undo </button>&nbsp;
                      <a class="btn btn-danger footer_btn_cancel footer_btn_top"
                        href="{{ route('elearningDashboard') }}"><i class="fa fa-times" aria-hidden="true"></i> Cancel
                      </a>&nbsp;
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
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<script>
  $('#phone_number').change(function (e) {
    document.getElementById('update_button').disabled = false;
  });
  var _URL = window.URL || window.webkitURL;
  $("#signature_attachment").change(function (e) {




    if ((file = this.files[0])) {

      if (file) {

        var img_url = URL.createObjectURL(file);
        // $('#blah').attr('src',img_url);
        // document.getElementById("blah").style.backgroundImage = "url('"+img_url+"')";
      }
      var file, img;
      img = new Image();


      img.onload = function () {

        if ((this.width >= '425') && (this.width <= '625')) {

          $('#color5').addClass("preview_eye fa fa-check-circle");
          document.getElementById('color5').style.color = "green"
        } else {
          $('#color5').removeClass("preview_eye fa fa-check-circle");
          $('#color5').addClass("fa fa-times-circle");
          document.getElementById('color5').style.color = "red"
        }
        if ((this.height >= '425') && (this.height <= '625')) {

          $('#color6').addClass("preview_eye fa fa-check-circle");
          document.getElementById('color6').style.color = "green"
        } else {
          $('#color6').removeClass("preview_eye fa fa-check-circle");
          $('#color6').addClass("fa fa-times-circle");
          document.getElementById('color6').style.color = "red"
        }
        const fileType = file['type'];
        const validImageTypes = ['image/gif', 'image/jpeg', 'image/png'];
        if (!validImageTypes.includes(fileType)) {
          $('#color8').removeClass(" preview_eye fa fa-check-circle");
          $('#color8').addClass("fa fa-times-circle");
          document.getElementById('color8').style.color = "red"
        } else {

          $('#color8').addClass(" preview_eye fa fa-check-circle");
          document.getElementById('color8').style.color = "green"
        }
        fileupload_size = file.size / 1024;
        var fileupload1 = fileupload_size;


        if (fileupload1 <= '20480') {
          $('#color7').addClass("preview_eye fa fa-check-circle");
          document.getElementById('color7').style.color = "green"
        } else {
          $('#color7').removeClass("preview_eye fa fa-check-circle");
          $('#color7').addClass("fa fa-times-circle");
          document.getElementById('color7').style.color = "red"
        }
        var pr_len = $(".preview_eye").length;
        if (pr_len == '4') {
          document.getElementById('update_button').disabled = false;
        } else {
          document.getElementById('update_button').disabled = true;
          swal({
            title: 'Warning',
            text: "Please Upload a Valid Profile Image!",
            icon: 'warning',

          });
        }


      };
    }
    img.src = _URL.createObjectURL(file);

  });


  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $('#upload-image-form').submit(function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    console.log(formData);
    var confilter = /^\d{10}$/i;
    var con = confilter.test(document.profile.phone_number.value);
    var ph_no = document.getElementById('phone_number').value;
    if (ph_no != []) {
      if (con == false) {
        swal({
          title: 'Warning',
          text: "Please Enter a Valid Phone Number!",
          icon: 'warning',

        });
        document.profile.phone_number.focus();
        return false;
      }
    }
    var signature = $('#signature').val();
    var signature_attachment = $('#signature_attachment').val();
    $.ajax({
      type: 'POST',
      url: '/profile_update',
      data: formData,
      contentType: false,
      processData: false,
      success: (response) => {
        if (response) {
          Swal.fire({
            title: "Profile Settings Uploaded Successfully",
            html: "<h5><b>Please click 'Ok' and Your profile has been updated successfully.</b></h5>",
            icon: "success",
            customClass: 'swalalerttext',
            showCancelButton: false,
            confirmButtonColor: '#00a2ed',
            confirmButtonText: "Ok",
            cancelButtonText: "No",
            reverseButtons: true,
            closeOnConfirm: true,
            closeOnCancel: true,
            showLoaderOnConfirm: true,
            width: '850px'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = '/admindashboard';
            }
          });
        }
      },
      error: (response) => {
        if (response.responseJSON && response.responseJSON.errors && response.responseJSON.errors.file) {
          $('#image-input-error').text(response.responseJSON.errors.file);
        } else {
          $('#image-input-error').text("An error occurred. Please try again.");
        }
      }
    });

  });
</script>

<style>
  .profile-pic {
    width: 200px;
    height: 130px;
    background: #f1ecec;
    display: inline-block;
  }

  .file-upload {
    display: none;
  }

  .circle11 {
    border-radius: 100% !important;
    overflow: hidden;
    width: 128px;
    height: 128px;
    border: 2px solid rgba(255, 255, 255, 0.2);
    position: absolute;
    top: 10px;
  }

  img {
    max-width: 100%;
    height: auto;
  }

  .p-image {
    position: absolute;
    top: 110px;
    left: 25%;
    color: #666666;
    transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
  }

  .p-image:hover {
    transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
  }

  .upload-button {
    font-size: 1.2em;
  }

  .upload-button:hover {
    transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
    color: #999;
  }
</style>
<script>
  $(document).ready(function () {


    var readURL = function (input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        document.getElementById('update_button').disabled = false;
        reader.onload = function (e) {
          $('.profile-pic').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
      }
    }


    $(".file-upload").on('change', function () {
      readURL(this);
    });

    $(".upload-button").on('click', function () {
      $(".file-upload").click();
    });
  });
</script>

<!-- <script type="text/javascript">
    $("#phone_number").keydown(function(event) {
  k = event.which;
  if ((k >= 96 && k <= 105) || k == 8) {
    if ($(this).val().length == 10) {
      if (k == 8) {
        return true;
      } else {
        event.preventDefault();
        return false;

      }
    }
  } else {
    event.preventDefault();
    return false;
  }

});
</script> -->
@endsection