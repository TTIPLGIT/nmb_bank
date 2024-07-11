@extends('layouts.adminnav')

@section('content')
<div class="main-content">
  <!-- Main Content -->
  <section class="section">
  {{ Breadcrumbs::render('FAQ_question.create')}}
    <div class="section-body mt-1">
      <h5 class="text-center" style="color:darkblue">Manage FAQ Module and Question Mapping</h5>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
            <form class="form-horizontal" name ="faq_question" method="POST" action="{{ route('FAQ_question.store') }}">
                @csrf
                    <div class="row">
                       <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">FAQ Module Name<span style="color: red;font-size: 16px;">*</span></label>
                                 <select class="form-control" name="module_id">
                                    <option value="">--- Select FAQ Module Name ---</option>
                             @foreach($rows as $key=>$row)
                                    <option value="{{ $row['id'] }}">{{ $row['module_name'] }}</option>
                                  @endforeach
                                </select>
                                @error('module_id')
                           <div class="error">{{ $message }}</div>
                           @enderror
                            </div>
                            
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Question <span style="color: red;font-size: 16px;">*</span></label>
                                <input class="form-control" type="text"  id="question" name="question"  placeholder="Enter Question">
                            </div>
                            @error('question')
                           <div class="error">{{ $message }}</div>
                           @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Answer<span style="color: red;font-size: 16px;">*</span></label>
                              
                                <textarea class="form-control" type="text" id="answer" name="answer"  placeholder="Enter Answer"></textarea>
                            </div>
                            @error('answer')
                           <div class="error">{{ $message }}</div>
                           @enderror
                        </div>
                       
                        				
                    </div>
                    
                     <div class="row text-center">
                        <div class="col-md-12">
                             <button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Submit</button>&nbsp;
                              <button class="btn btn-primary" type="reset"><i class="fa fa-undo"></i> Reset </button>&nbsp;
                             <a class="btn btn-danger" href="{{ route('FAQ_question.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Cancel </a>
                           
                           
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
  function typeChange() {
    var module_type = $('#module_type').val();

    if (module_type == 02) {
      $('#sub_module').show();
      $('#module').hide();
    } else {
      $('#sub_module').hide();
      $('#module').show();
    }

  }

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
  function save() {

    var module_type = $('#module_type').val();

    if (module_type == 02) {
      var parent_module = $("select[name='sub_module_id']").val();
      if (parent_module == '') {
        swal("Please Select Parent Module ", "", "error");
        return false;
      }
    } else {
      var parent_module = $("select[name='parent_module_id']").val();
      if (parent_module == '') {
        swal("Please Select Parent Module ", "", "error");
        return false;
      }
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