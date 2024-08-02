@extends('layouts.adminnav')

@section('content')
<div class="row">   
   <div class="main-content module_space">
  
<!-- Main Content -->
 <section class="section">
 {{ Breadcrumbs::render('uam_modules_screens.show',$rows[0]['module_id']) }} 

        <div class="section-body mt-1">
        <h5 class="heading_align"  style="color:darkblue">Screens Show</h5>
          <div class="row">
        
            <div class="col-12">

              <div class="card" >
                <div class="card-body" >      
                 
                <form class="form-horizontal" method="post" name ="uam_modules_screens"  action="{{ route('uam_modules_screens.update_data') }}">
                  <div class="row">
                    <div class="col-md-4">
                  
                      <div class="form-group">

                        <label class="control-label">Module Name <span style="color: red;font-size: 16px;">*</span></label>
                        <input class="form-control" type="text"  id="module_name" name="module_name" disabled="" placeholder="Enter Module Name" value="{{ $rows[0]['module_name'] }}" disabled="">


                        <input class="form-control" type="hidden"  id="module_id" name="module_id"  placeholder="Enter Module Name" value="{{ $rows[0]['module_id'] }}" >
                      </div>

                    </div>


            <div class="col-md-8 ">
              <label class="control-label">Screens Name <span style="color: red;font-size: 16px;">*</span> </label>
              <div class="row scroll_class">
                <div class="col-md-12 ">
                  
               @foreach($screensdata as $key=>$screen)

               
                <div class="form-group">

                 <input type="checkbox" id="{{ $screen['screen_id'] }}" name="screen_id[]" value="{{ $screen['screen_id'] }}" disabled="">
                 <label for="{{ $screen['screen_name'] }}" > {{ $screen['screen_name'] }}</label> <span style="float: right;">( {{ $screen['permissions'] }} )</span>

               </div>
              
             @endforeach
             </div>    
           </div>  
         </div>

   
      </div>
                    
                    <div class="row text-center">
                        <div class="col-md-12">
                            
                            <a class="btn btn-danger" href="{{ route('uam_modules_screens.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Cancel </a>&nbsp;
                            
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
</div>


<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<script type="text/javascript">


$("#module_name").keypress(function(event){
        var inputValue = event.charCode;
        if(!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0)){
            event.preventDefault();
        }
    });



</script>
<script>
    function editbuttonclick(id) {

      var module_name = $('#module_name'+id).val();

      if (module_name == '') {
        swal("Please Enter Module Name ", "", "error");
        return false;
      }

      

      document.getElementById('edit_module_form'+id).submit();
    }
  </script>
  <script type="text/javascript">
    
  $(document).ready(function(){
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $module_id = $("#module_id").val();


$.ajax({
  url: '{{ url('/uam_modules_screens/get_modules_screen') }}', 
  type:"POST",
  dataType:"json",
  data: {module_id : $module_id, _token: '{{csrf_token()}}' },
  success:function(data){
    
    if (data.length == 0) {


    }else{
      for(i = 0 ; i < data.length; i++){
        
         document.getElementById(data[i].screen_id).checked = true;
      }
    }
  },
  error:function(data){
    console.log(data);
  }
});


});
</script>



@endsection


