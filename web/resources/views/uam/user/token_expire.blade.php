@extends('layouts.adminnav')

@section('content')
<div class="main-content">

  <!-- Main Content -->
  <section class="section">


    <div class="section-body mt-1">

<div class="row">   
    <div class="col-md-12 col-lg-12 mlr-auto">
        <div class="tile my-4">
            <h3 class="tile-title">Reset Password Token Expire Settings</h3>
            <div class="tile-body">
                <form class="form-horizontal" method="post" onsubmit="return validateForm()" name ="token_expire_data_update" id="token_expire_data_update"  action="{{ route('user.token_expire_data_update') }}">

                    @csrf
                    <div class="row">

                          <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Time (Hours / Days) <span style="color: red;font-size: 16px;">*</span></label>
                            <input class="form-control" type="number" min="1" max="24"  id="settings_time" name="settings_time"  placeholder="Enter Time (Hours / Days) " value="{{ $row[0]['settings_time'] }}" autocomplete="off">
                        </div>
                    </div>
              
                           <input class="form-control" type="hidden" id="settings_id" name="settings_id"  placeholder="Enter Display Order" value="{{ $row[0]['settings_id'] }}" autocomplete="off">
                       

             



                     <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Time Method<span style="color: red;font-size: 16px;">*</span></label>
                            <select class="form-control" name="settings_movement" >
                               
                                <option value="1" {{ $row[0]['settings_movement'] == 1 ? 'selected':'' }}>Hours</option>
                                <option value="2" {{ $row[0]['settings_movement'] == 2 ? 'selected':'' }}>Days</option>



                            </select>
                        </div>
                    </div>


   </div>
                  
                <div class="row text-center">
                    <div class="col-md-12">
                        <button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Submit</button>&nbsp;
                        <button class="btn btn-primary" type="reset"><i class="fa fa-undo"></i> Undo </button>&nbsp;
                        <a class="btn btn-danger" href="{{ route('uam_modules.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Cancel </a>
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

$("#module_name").keypress(function(event){
    var inputValue = event.charCode;
    if(!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0)){
        event.preventDefault();
    }
});

                function validateForm() {

 let settings_time = document.forms["token_expire_data_update"]["settings_time"].value;
 if (settings_time == "") {
  bootbox.alert({
   title: "Reset Password Token Expire Settings",
   centerVertical: true,
   message: "Please enter time",
});
  return false;
}


//  if (settings_time < 24) {
//   bootbox.alert({
//    title: "Reset Password Token Expire Settings",
//    centerVertical: true,
//    message: "Please enter time bellow 24",
// });
//   return false;
// }




}



</script>

@if (session('fail'))
<input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('fail') }}">
<script type="text/javascript">
    window.onload = function(){
         var message = $('#session_data').val();

         bootbox.alert({
        title: "Error",
        centerVertical: true,
        message: message
      });
    }
</script>
@endif

@endsection


