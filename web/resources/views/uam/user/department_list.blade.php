@extends('layouts.app')

@section('content')
<div class="row my-2">   
    <div class="col-md-6 ">
       <h3 class="tile-title">Department List</h3>
    </div>

   
</div>


<div class="row">
    <div class="col-md-12 content-bottom-position">
        <div class="tile title-padding">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-custom-list" id="listDataTable">
                    <thead>
                        <tr>
                        <th width="50px">Sl. No.</th>
                        <th>Department Id</th>
                       
                            <th>Department Name</th>
                            
                        </tr>
                    </thead>
                    <tbody>

                  @foreach($rows as $key=>$row)
                        <tr>
                            <td>{{ ++$key }}</td>
                           <td>{{ $row['document_folder_structure_id'] }}</td>
                            <td>{{ $row['folder_name'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@if (session('success'))


<input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
<script type="text/javascript">
    window.onload = function(){
         var message = $('#session_data').val();

         bootbox.alert({
        title: "Success",
        centerVertical: true,
        message: message
      });
    }
</script>
@endif


@if (session('failed'))
<input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('failed') }}">
<script type="text/javascript">
    window.onload = function(){
         var message = $('#session_data').val();

         bootbox.alert({
        title: "Success",
        centerVertical: true,
        message: message
      });
    }
</script>
@endif

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