@extends('layouts.adminnav')

@section('content')
<div class="row">   
   <div class="main-content module_space">
  
<!-- Main Content -->
 <section class="section">

 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

@if(session('fail'))

              <input type="hidden" name="session_data" id="session_data1" class="session_data"
                value="{{ session('error') }}">
              <script type="text/javascript">
                window.onload = function() {
                  var message = $('#session_data1').val();
                  swal({
                    title: "Info",
                    text: "{{ session('fail') }}",
                    type: "info",
                  });

                }
              </script>
              @endif
        <div class="section-body mt-1">
        <h5 class="heading_align"  style="color:darkblue">Modules Edit</h5>
          <div class="row">
          {{ Breadcrumbs::render('uam_modules.edit',$one_row[0]['module_id']) }} 
            <div class="col-12">
        
              <div class="card" >
                <div class="card-body" >      
                 
               <form  name="edit_form" action="{{ route('uam_modules.update',$one_row[0]['module_id']) }}" method="POST" id="edit_module_form{{$one_row[0]['module_id']}}">
            {{ csrf_field() }}
            @method('PUT') 
                    <div class="row">
                       <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Parent Module Name</label>
                                 <select class="form-control" name="parent_module_id" >
                                    <option value="">--- Select Parent Module Name ---</option>
                             @foreach($rows as $key=>$row)
                                    <option value="{{ $row['module_id'] }}" {{ $row['module_id'] ==  $one_row[0]['parent_module_id'] ? 'selected':'' }}>{{ $row['module_name'] }}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Module Name <span style="color: red;font-size: 16px;">*</span></label>
                                <input class="form-control" type="text"  id="module_name" name="module_name"  placeholder="Enter Module Name" value="{{ $one_row[0]['module_name'] }}" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Display Order  </label>
                                <input class="form-control" type="text" id="display_order" name="display_order"  placeholder="Enter Display Order" value="{{ $one_row[0]['display_order'] }}" >
                            </div>
                        </div>
                        <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Icon Class Name <span style="color: red;font-size: 16px;">*</span></label>
                                            <input class="form-control" type="text" id="class_name" name="class_name" placeholder="Enter Class Name" value="{{$one_row[0]['class_name']}}" autocomplete="off">
                                        </div>
                                    </div>
                            <input class="form-control" type="hidden"  id="module_id" name="module_id"  placeholder="Enter Module Name" value="{{ $one_row[0]['module_id'] }}">
                    </div>
                    
                    <div class="row text-center">
                        <div class="col-md-12">
                             <button type="button" class="btn btn-success btn-space" onclick="editbuttonclick('{{$one_row[0]['module_id']}}')" >Update</button>
                            <a class="btn btn-danger" href="{{ route('uam_modules.index') }}">Back</a>&nbsp;
                            
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

      var module_name = $('#module_name').val();

      if (module_name == '') {
        swal("Please Enter Module Name ", "", "error");
        return false;
      }
      var class_name = $('#class_name').val();

    if (class_name == '') {
      swal("Please Enter Icon Name ", "", "error");
      return false;
    }

      

      document.getElementById('edit_module_form'+id).submit();
    }
  </script>


@endsection


