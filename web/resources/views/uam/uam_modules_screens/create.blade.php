<style type="text/css">
  .scroll_class{
   padding: 1rem!important;
    border: none;
    /* margin: 20px 0; */
    -webkit-transition: .5s all ease;
    -moz-transition: .5s all ease;
    transition: .5s all ease;
    box-shadow: -1px 1px 4px 2px #f3f0f0; 
    overflow-y: scroll;
    height: 328px!important;
  }
  body.light.dark-sidebar.theme-white {
    width: 0px;
}
</style>



@extends('layouts.adminnav')
 
@section('content')
<div class="main-content module_space">
  
<!-- Main Content -->
 <section class="section">


        <div class="section-body mt-1">
        <h5 class="text-center" style="color:darkblue">Module Screen Mapping Creation</h5>
      
        {{ Breadcrumbs::render('uam_modules_screens.create') }}
            
<div class="row">
        
            <div class="col-12">
        
              <div class="card" >
                <div class="card-body" >
               <form  name ="uam_modules_screens_submit" id="uam_modules_screens_submit"  method="POST" action="{{ route('uam_modules_screens.store') }}">

                @csrf
                  <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label class="control-label">Module Name <span style="color: red;font-size: 16px;">*</span></label>
                <select name="module_id" class="form-control"  id="module_id"  onChange="moduleChange()" >
                  <option value=""> Select Module Name </option>
                  @foreach($modulesdata as $key=>$module)

                  <option value="{{ $module['module_id'] }}">{{ $module['module_name']}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="col-md-8">


              <label class="control-label">Screens Name <span style="color: red;font-size: 16px;">*</span> </label>
             <div class="row scroll_class">
              <div class="col-md-12 ">
              <div class="metadata"></d iv>
               </div>
           </div> 

         </div>

       </div> 
                    <div class="row text-center">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-success btn-space" onclick="save_screens()" id="savebutton">Save</button>
                              <button class="btn btn-primary" type="reset"><i class="fa fa-undo"></i> Undo </button>&nbsp;
                             <a class="btn btn-danger footer_btn_cancel" href="{{ route('uam_modules_screens.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Cancel </a>
                           
                           
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
<script type="text/javascript">
  
  function moduleChange(){

     var module_id = $('#module_id').val();

    if(module_id != ""){
      $.ajax({
        url: "{{ url('/uam_modules_screens/screen_data_get') }}", 
        type:"POST",
        dataType:"json",
        data: {module_id : module_id,_token: '{{csrf_token()}}' },
        success:function(data){

         console.log(data);
          if (data != '[]') {
            var user_select = data;
            // var count = data['count'];
            // $('#count_data').val(count[0]['count_data']);

    // var user_select = data;
    var optionsdata = "";
    for(var i = 0 ; i < user_select.length; i++){
      var x = i+1;
      var screen_name = user_select[i]['screen_name'];
      var screen_id = user_select[i]['screen_id'];
      var permissions = user_select[i]['permissions'];
      var ddd = '<option value="">Select Document Category</option>';
optionsdata += "<div class='metadata_new'> <input type='checkbox' id="+screen_id+" name='screen_id[]' value="+screen_id+"> <label for="+screen_id+">"+screen_name+"  </label> <span class='screens_view' style='float: right;'>(  "+permissions+" )</span></div><br>";

    }
    var demonew =  $('.metadata').html(optionsdata);

    
}
else{
       
   var stageoption = "No Data Found";
  var demonew =  $('.metadata').html(stageoption);
    }
    

  }
});


    }
else{
       
   var stageoption = "No Data Found";
  var demonew =  $('.metadata').html(stageoption);
    }


  }
</script>
<script>
    function save_screens() {

      var module_id = $('#module_id').val();

      if (module_id == '') {
        swal("Please Select Module ", "", "error");
        return false;
      }
       var checkedCount = $("input[type=checkbox][name^=screen_id]:checked").length;

      if(checkedCount == 0) {
        swal("Please Select Screen ", "", "error");
        return false;
      }

       
    

      

      document.getElementById('uam_modules_screens_submit').submit();
    }
  </script>




@endsection


