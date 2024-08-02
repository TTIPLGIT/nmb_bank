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
  tr {
    
    background-color: #cfe0e8 !important;
}
</style>
<div class="main-content">





  <section class="section">

    <div class="col-lg-12 text-center">
      <h4 style="color:darkblue;">List of valuers Request</h4>
    </div>{{ Breadcrumbs::render('valuationreportindex') }}
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
                            <th>Valuation Request No</th>
                            <th>Asset Type</th>
                            <th>Status</th>
                            <th>Action</th>


                          </tr>
                        </thead>
                        <tbody>
          
                        
                            <td>1</td>
                            <td>VR/L/001</td>
                            <td>Land</td>
                            <td>Evaluated</td>
                            <td>
                              <form action="" method="POST">
                              @csrf
                                  @method('DELETE')
                              <a class="btn btn-link" href="{{ route('Assessment.show','1') }}" title="show" data-toggle="modal" data-target="#showModal" style="color:darkblue"><i class="fas fa-eye"></i></a>

                              <a class="btn  btn-warning" href="{{ route('ValuationReport','1') }}" title="Report Valuation" style="color:white">Report</i></a>
    
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