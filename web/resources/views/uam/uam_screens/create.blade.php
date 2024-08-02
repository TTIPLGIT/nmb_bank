<style type="text/css">
  .form-control {
    text-transform: lowercase !important;



  }

  body.light.dark-sidebar.theme-white {
    height: 10px;
  }
</style>



@extends('layouts.adminnav')

@section('content')
<div class="main-content module_space">

  <!-- Main Content -->
  <section class="section">


    <div class="section-body mt-1">
      <h5 class="heading_align" style="color:darkblue">Screens Create</h5>

      {{ Breadcrumbs::render('uam_screens.create') }}

      <div class="row">

        <div class="col-12">

          <div class="card">
            <div class="card-body">
              <form name="uam_screens_submit" id="uam_screens_submit" method="POST" action="{{ route('uam_screens.store') }}">

                @csrf
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Screen Name <span style="color: red;font-size: 16px;">*</span></label>
                      <input class="form-control" type="text" id="screen_name" name="screen_name" placeholder="Enter Screen Name" autocomplete="off">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Screen URL <span style="color: red;font-size: 16px;">*</span></label>
                      <input class="form-control" type="text" id="screen_url" name="screen_url" placeholder="Enter Screen URL" autocomplete="off">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Route URL <span style="color: red;font-size: 16px;">*</span></label>
                      <input class="form-control" type="text" id="route_url" name="route_url" placeholder="Enter Route URL" autocomplete="off">
                    </div>
                  </div>



                  <!-- <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">Icon Class Name <span style="color: red;font-size: 16px;">*</span></label>
                <input class="form-control" type="text"  id="class_name" name="class_name"  placeholder="Enter Class Name" autocomplete="off">
              </div>
            </div> -->


                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Display Order </label>
                      <input class="form-control" type="text" id="display_order" name="display_order" placeholder="Enter Display Order" autocomplete="off">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label class="control-label">Screen Permission <span style="color: red;font-size: 16px;">*</span> </label>
                    <div class="row">
                      @foreach($permissions as $key=>$permission)

                      <div class="col-md-3">
                        <div class="form-group">




                          <input type="checkbox" id="{{ $permission }}" name="screen_permission[]" class="screen_permission" value="{{ $permission }}">
                          <label for="{{ $permission }}"> {{ $permission }}</label>

                        </div>
                      </div>
                      @endforeach
                    </div>
                  </div>



                </div>
                <div class="row text-center">
                  <div class="col-md-12">
                    <button type="button" class="btn btn-success btn-space" onclick="save_screen()" id="savebutton">Save</button>
                    <button class="btn btn-primary" type="reset"><i class="fa fa-undo"></i> Undo </button>&nbsp;
                    <a class="btn btn-danger footer_btn_cancel" href="{{ route('uam_screens.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Cancel </a>


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
<script type="text/javascript">
  function setInputFilter(textbox, inputFilter) {
    ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
      textbox.addEventListener(event, function() {
        if (inputFilter(this.value)) {
          this.oldValue = this.value;
          this.oldSelectionStart = this.selectionStart;
          this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
          this.value = this.oldValue;
          this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        } else {
          this.value = "";
        }
      });
    });
  }

  setInputFilter(document.getElementById("display_order"), function(value) {
    return /^\d*\.?\d*$/.test(value); // Allow digits and '.' only, using a RegExp
  });

  $("#module_name").keypress(function(event) {
    var inputValue = event.charCode;
    if (!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0)) {
      event.preventDefault();
    }
  });
</script>
@if (session('fail'))
<input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('fail') }}">
<script type="text/javascript">
  window.onload = function() {
    var message = $('#session_data').val();

    bootbox.alert({
      title: "Error",
      centerVertical: true,
      message: message
    });
  }
</script>

@endif
<script>
  function save_screen() {

    var screen_name = $('#screen_name').val();

    if (screen_name == '') {
      swal("Please Enter Screen Name ", "", "error");
      return false;
    }

    var screen_url = $('#screen_url').val();

    if (screen_url == '') {
      swal("Please Enter Screen URL ", "", "error");
      return false;
    }

    var route_url = $('#route_url').val();

    if (route_url == '') {
      swal("Please Enter Route URL ", "", "error");
      return false;
    }

    var class_name = $('#class_name').val();

    // if (class_name == '') {
    //   swal("Please Enter class Name ", "", "error");
    //   return false;
    // }
    var checkedCount = $("input[type=checkbox][name^=screen_permission]:checked").length;

    if (checkedCount == 0) {
      swal("Please Enter Screen permission ", "", "error");
      return false;
    }





    document.getElementById('uam_screens_submit').submit();
  }
</script>




@endsection