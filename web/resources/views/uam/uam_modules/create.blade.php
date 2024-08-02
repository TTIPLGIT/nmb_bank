@extends('layouts.adminnav')

@section('content')
<!-- <style>
  @media(min-width:320px) {
    a.btn.btn-danger.footer_btn_cancel {
      margin-top: 5px !important;
    }
  }
</style> -->


  








<div class="main-content module_space">

  <!-- Main Content -->
  <section class="section">


    <div class="section-body mt-1">
      <h5 class="text-center" style="color:darkblue">Modules Create</h5>

      {{ Breadcrumbs::render('uam_modules.create') }}

      <div class="row">

        <div class="col-12">

          <div class="card">
            <div class="card-body">
              <form name="uam_modules" id="uam_modules" onsubmit="return validateForm()" method="POST" action="{{ route('uam_modules.store') }}">

                @csrf
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Parent Module Name</label>
                      <select class="form-control" name="parent_module_id">
                        <option value="">Select Parent Module Name</option>
                        @foreach($rows as $key=>$row)

                        <option value="{{ $row['module_id'] }}">{{ $row['module_name'] }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label"> Module Category <span style="color: red;font-size: 16px;">*</span></label>
                      <select class="form-control" name="module_type">
                        <option value="">Select Category</option>
                        <option value="01">Module</option>
                        <option value="02">Sub Module</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Module Name <span style="color: red;font-size: 16px;">*</span></label>
                      <input class="form-control" type="text" id="module_name" name="module_name" placeholder="Enter Module Name" autocomplete="off">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Icon Class Name <span style="color: red;font-size: 16px;">*</span></label>
                      <input class="form-control" type="text" id="class_name" name="class_name" placeholder="Enter Class Name" autocomplete="off">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Display Order </label>
                      <input class="form-control" type="text" id="display_order" name="display_order" placeholder="Enter Display Order" autocomplete="off">
                    </div>
                  </div>


                </div>

                <div class="row text-center">
                  <div class="col-md-12 btn_space">
                    <button type="button" class="btn btn-success btn-space" onclick="save()" id="savebutton">Save</button>
                    <button class="btn btn-primary" type="reset"><i class="fa fa-undo"></i> Undo </button>
                    <a class="btn btn-danger footer_btn_cancel" button href="{{ route('uam_modules.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Cancel </a>


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


  function validateForm() {

    let module_name = document.forms["uam_modules"]["module_name"].value;
    if (module_name == "") {
      bootbox.alert({
        title: "Uam Module Creation",
        centerVertical: true,
        message: "Please enter module name",
      });
      return false;
    }



  }
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
  function save() {

    var parent_module = $("select[name='parent_module_id']").val();
    if (parent_module == '') {
      swal("Please Select Parent Module ", "", "error");
      return false;
    }

    var parent_module = $("select[name='module_type']").val();
    if (parent_module == '') {
      swal("Please Select Module Category", "", "error");
      return false;
    }

    var module_name = $('#module_name').val();
    if (module_name == '') {
      swal("Please Enter Module Name ", "", "error");
      return false;
    }

    var class_name = $('#class_name').val();

    if (class_name == '') {
      swal("Please Enter class Name ", "", "error");
      return false;
    }


    document.getElementById('uam_modules').submit();
  }
</script>




@endsection