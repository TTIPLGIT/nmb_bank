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
      <h4>Instruction Approval Screen</h4>
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
                        <th>Task Name</th>
                        <th>Valuer Name/Firm Name</th>
                        <th>Status</th>
                        <th>Action</th>


                      </tr>
                    </thead>

                    <tbody>
                    @php $last_task="";$iteration=1; @endphp

                      @foreach($rows['cgv'] as $data)
                    @if($data['task_name'] !=$last_task)

                      <tr>
                        <td>{{$iteration}}</td>
                        <td>{{$data['task_name']}} </td>
                        <td>{{$data['name']}}</td>
                        @if($data['cgv_approval'] == 0)
                        
                            <td>Not require CGV approval</td>
                          @elseif($data['cgv_approval'] == 1)
                          <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending</span></td>
                            @else
                            <td style="color:white;"><span class="badge2 danger rounded-pill text-bg-warning">Rejected</span></td>
                          @endif

                        <td>
                        
                          <a type="btn" title="Approve CGV" href="{{route('cgv_approve', $data['id'])}}" class="btn btn-link"><img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30"></button>
                        
                        </td>
                        

                      </tr>
                      @php $last_task=$data['task_name'];$iteration=++$iteration @endphp
                      @endif
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
<script>
  $(document).ready(function() {

    let url = new URL(window.location.href)
    let message = url.searchParams.get("message");
    if (message != null) {
      window.history.pushState("object or string", "Title", "/gtapprove");

      swal({
        title: "Success",
        text: "Rejected Successfully",
        type: "success",
      });
    }

  })
</script>

@endsection