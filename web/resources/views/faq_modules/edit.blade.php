@extends('layouts.adminnav')

@section('content')
<div class="row">
    <div class="main-content">

        <!-- Main Content -->
        <section class="section">
    
        {{ Breadcrumbs::render('faq_modules.edit',$rows[0]['id']) }}

            <div class="section-body mt-1">
                <h5  class="heading_align"  style="color:darkblue"> FAQ Module Edit</h5>
                <div class="row">

                    <div class="col-12">

                        <div class="card">
                            <div class="card-body">
                            <form class="form-horizontal" method="post" name ="uam_modules"  action="{{ route('FAQ_modules.update_data') }}">
                 
                 @csrf 
                     <div class="row">
                       
 
                         <div class="col-md-6">
                             <div class="form-group">
                                 <label class="control-label">FAQ Module Name <span style="color: red;font-size: 16px;">*</span></label>
                                 <input class="form-control" type="text"  id="module_name" name="module_name"  placeholder="Enter Module Name" value="{{ $rows[0]['module_name'] }}">
                             </div>
                             @error('module_name')
                            <div class="error">{{ $message }}</div>
                            @enderror
                         </div>
                         
                        
                           <input class="form-control" type="hidden"  id="id" name="id"  placeholder="Enter Module Name" value="{{ $rows[0]['id'] }}">
                     </div>
                     
                     <div class="row text-center">
                         <div class="col-md-12">
                             <button class="btn btn-success" type="submit">Update</button>&nbsp;
                               <button class="btn btn-primary" type="reset"><i class="fa fa-undo"></i> Reset </button>&nbsp;
                              <a class="btn btn-danger footer_btn_cancel" href="{{ route('faq_modules.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Cancel </a>
                         </div>                
                     </div>
                 </form>
                 
                 </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
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

$("#module_name").keypress(function(event){
        var inputValue = event.charCode;
        if(!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0)){
            event.preventDefault();
        }
    });

// Wait for the DOM to be ready
$(function() {
  // Initialize form validation on the registration form.
  // It has the name attribute "registration"
  $("form[name='uam_modules']").validate({
    // Specify validation rules
    rules: {

      module_name: {
        required: true,
      },
     
    },
    // Specify validation error messages
    messages: {

      module_name: {
        required: "Please provide a module name",
      },
      
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      form.submit();
    }
  });
});

</script>

@endsection


