@extends('layouts.adminnav')

@section('content')
<style>
  a:hover,
  a:focus {
    text-decoration: none;
    outline: none;
  }

  .danger {
    background-color: #ffdddd;
    border-left: 6px solid #f44336;
  }

  #align {
    border-collapse: collapse !important;
  }

  table.dataTable.no-footer {
    border-bottom: .5px solid #002266 !important;
  }

  thead th {
    height: 5px;
    border-bottom: solid 1px #ddd;
    font-weight: bold;
  }
</style>
<div class="main-content">
  <section class="section">
  {{ Breadcrumbs::render('faq_modules.index')}}

    <div class="section-body mt-2">
   
      
    @if(strpos($screen_permission['permissions'], 'Create') !== false)
        <a type="button" style="font-size:15px;    margin: 0 0px 5px 15px;" class="btn btn-success btn-lg" href="{{ route('faq_modules.create') }}">Create</a>
        @endif
        <div class="row">

          <div class="col-12">
           
            <div class="card">

              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12 text-center">
                    <h4 style="color:darkblue;">FAQ Modules List</h4>
                  </div>

                </div>
                @if (session('success'))

                <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
                <script type="text/javascript">
                  window.onload = function() {
                    var message = $('#session_data').val();
                    swal({
                      title: "Success",
                      text: message,
                      type: "success",
                    });

                  }
                </script>
                @elseif(session('error'))

                <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
                <script type="text/javascript">
                  window.onload = function() {
                    var message = $('#session_data1').val();
                    swal({
                      title: "Info",
                      text: message,
                      type: "info",
                    });

                  }
                </script>
                @endif



                <div class="table-wrapper">
                  <div class="table-responsive">
                    <table class="table table-bordered" id="align">
                      <thead>
                        <tr>
                          <th width="50px">Sl. No.</th>
                         
                          <th>Module Name</th>                            
                            
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                  @foreach($rows as $key=>$row)
                        <tr>
                            <td>{{ ++$key }}</td>
 
                            <td>{{ $row['module_name'] }}</td>
                            
                            
                            <td class="text-center">
                            @if(strpos($screen_permission['permissions'], 'Show') !== false)
                                 <a class="btn btn-info" href="{{ route('faq_modules.show', \Crypt::encrypt($row['id'])) }}">{{ __('Show') }}<span></span></a>
                            @endif
                                 @if(strpos($screen_permission['permissions'], 'Edit') !== false)
                                <a class="btn btn-warning"  href="{{ route('faq_modules.edit', \Crypt::encrypt($row['id'])) }}">{{ __('Edit') }}<span></span></a>
                                 @endif

                                 @if(strpos($screen_permission['permissions'], 'Delete') !== false)

                                 <input type="hidden" name="delete_id" id="<?php echo $row['id']; ?>" value="{{ route('faq_modules.delete', \Crypt::encrypt($row['id'])) }}">

                          <a class="btn btn-danger"  style="cursor: pointer; color:aliceblue !important;"  onclick="return myFunction(<?php echo $row['id']; ?>);" >{{ __('Delete') }}<span></span></a> 
                                
                                
                                  @endif                           
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
         

                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


  </section>






</div>











</div>


<script>
  function myFunction(id) { 
    swal({
                html:true,
                title: "Are you want to delete This Module ?",
                type: "warning",
                customClass: 'swalalerttext',
                showCancelButton: true,
                confirmButtonColor: '#00a2ed',
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                reverseButtons: true,
                closeOnConfirm: false,
                closeOnCancel: false,
                showLoaderOnConfirm: true,
                width: '20px'  
            },
            function(isConfirm) {

                if (isConfirm) {
                  var url = $('#'+id).val();
                  window.location.href = url
                    // swal("Success", "Successfully Registered", "success");
                    return;
                    
                } else {
                    swal.close();
                }
                
            });
           
    

  }
  
</script>



@endsection