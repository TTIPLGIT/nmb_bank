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
  {{ Breadcrumbs::render('registar_index') }}
  <section class="section">


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
              <div class="col-lg-12 text-center">
                <h4>List of Instruction</h4>
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
                        <th>Valuer Name</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>

                    <tbody>
                      @php $last_task="";$iteration=1; @endphp

                      @foreach($rows['listview'] as $data)
                      @if($data['task_name'] !=$last_task)

                      <tr>
                        <td>{{$iteration}}</td>
                        <td>{{$data['task_name']}} </td>
                        <td>{{$data['name']}}</td>
                        @if($data['status'] == 0)
                        <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending</span></td>
                        @elseif($data['status'] == 1)
                        <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">In Progress</span></td>

                        @elseif($data['status'] == 3)
                        <td style="color:white;"><span class="badge2 success rounded-pill text-bg-danger">Completed</span></td>
                        @else
                        <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">In Review</span></td>



                        @endif

                        <td>
                          @if($data['status'] == 0 || $data['status'] == 1 || $data['status'] == 2)
                          <a title="Show" href="{{route('registar_show', $data['id'])}}" class="btn btn-link"><i class="fas fa-eye" style="color:green"></i></a>
                          @endif
                          <!-- <button type="submit" title="Approve or Allocate" class="btn btn-link"><img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30"></button> -->
                          @if($data['status'] == 3 && $data['registar_comment'] == null)
                          <a href="{{route('registar_show', $data['id'])}}" class="btn btn-link">
                            <img src="{{asset('assets/images/volume-svgrepo-com.svg')}}" alt="" width="20" height="30"> </a>

                          @endif
                          @if($data['status'] == 3 && $data['registar_comment'] != null)
                          <a href="{{route('registar_show', $data['id'])}}" class="btn btn-link">
                            <i class="fas fa-eye" style="color:green"></i>
                          </a>

                          @endif
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