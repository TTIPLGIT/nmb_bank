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

    <div class="col-lg-12 text-center">
      <h4 style="color:darkblue;">List of Valuation Request</h4>
    </div>
    <div class="section-body mt-2">
     
      
        <style>
          .section {
            margin-top: 20px;
          }
        </style>
      

        <div class="row">

          <div class="col-12">

            <div class="mt-0">

              <div class="card-body" id="card_header">
                <div class="row">
             

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
                            <th>Sl. No.</th>
                          <th>Asset Owner Name</th>
                            <th>Valuation Request No</th>
                            <th>Asset Type</th>
                            <th>Status</th>
                            <th>Action</th>

                          </tr>
                        </thead>
                        <tbody>
          
                        
                            <td>1</td>
                            <td>Rahul</td>
                            <td>VR/L/001</td>
                            <td>Land</td>
                            <td>Completed</td>
                            <td>
                              <form action="" method="POST">
                              @csrf
                                  @method('DELETE')
                              <a class="btn btn-link" href="{{ route('Assessment.show','1') }}" title="show"  style="color:darkblue"><i class="fas fa-eye"></i></a>

                              <a class="btn btn-link" href="{{ route('completeddecision','1') }}" title="Edit" style="color:darkblue"><i class="fas fa-pencil-alt"></i></a>

                                  <button type="submit" title="Delete" onclick="return confirm('Are you sure you want to delete this Currency ?');" class="btn btn-link" style="color:red"><i class="far fa-trash-alt"></i></button>
                                  
                              </form>
                            </td>

                          </tr>
                        






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

@endsection