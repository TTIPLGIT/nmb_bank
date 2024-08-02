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

<style>
  .section {
    margin-top: 20px;
  }
</style>



<div class="main-content">
  {{ Breadcrumbs::render('index_data') }}
  <section class="section">
    <!-- <a type="button" href="{{ url('initiation/create') }}" value="" class="btn btn-labeled btn-info" title="Initiate" style="background: #268f7f !important; border-color:#a9ca !important; color:white !important;margin: 0 0 2px 15px;">
      <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Initiation</span></a> -->

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
                      <th>Description</th>
                      <th>Status</th>
                      <th>Action</th>


                    </tr>
                  </thead>

                  <tbody>
                    @if(!empty($row))
                    <input type="hidden" name="stakeholder_id" value="{{$rows['rows'][0]['stakeholder_id']}}">
                    @endif
                    @php $last_taskvalue=''; @endphp
                    @foreach($rows['rows'] as $data)

                    @if($last_taskvalue!= $data['task_name'])
                    <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$data['task_name']}}</td>
                      <td>{{$data['inst_description']}}</td>

                      @if($data['status'] == 0)
                      <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending</span></td>
                      @elseif($data['status'] == 1)
                      <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-warning">In Progress</span></td>

                      @elseif($data['status'] == 2)
                      <td style="color:white;"><span class="badge2 success rounded-pill text-bg-danger">Submitted</span></td>

                      @elseif($data['status'] == 5)
                      <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-warning">In Review</span></td>

                      @else
                      <td style="color:white;"><span class="badge2 success rounded-pill text-bg-danger">Completed</span></td>


                      @endif

                      @if($data['status'] == 0)
                      <td>

                        <a type="button" href="{{ route('initiation.create_data', $data['stakeholder_id']) }}" title="Approve" class="btn btn-link" style="background-color:green; text-decoration:none; color:white">Accept/Reject</a>
                      </td>

                      <!-- for firm while stakehloder giving task -->
                      @elseif($data['status'] == 1 &&$data['type'] == 2 )
                      <td>
                        @if($data ['instruction_count'] != 0)
                        <a type="button" href="{{ route('instruct/create', $rows['rows'][0]['stakeholder_id']) }}" title="Task allocation" class="btn btn-link" style="background-color:blue; text-decoration:none; color:white">Give Task</a>
                        @endif
                        @php $type=1; @endphp
                        <a class="btn btn-link" title="show" href="{{route('instruct_show', ['id' => $data['firm_id'], 'type' => $type])}}"><i class="fas fa-eye" style="color:green"></i></a>
                      </td>

                      @endif

                      @if($data['status'] == 2 && $data['stakeholder_comment'] == null && $data['cgv_approval'] == 0 || $data['status'] == 3 && $data['stakeholder_comment'] == null && $data['cgv_approval'] == 0 )
                      <td>
                        @php $type=1; @endphp
                        @php $type2=2; @endphp

                        <a type="button" href="{{ route('instruct_show', ['id' => $data['firm_id'], 'type' => $type]) }}" title="show" class="btn btn-link" style="text-decoration:none;"><i class="fas fa-eye" style="color:green"></i></a>
                        <a type="button" href="{{ route('instruct_show', ['id' => $data['firm_id'], 'type' => $type2]) }}" title="Approve or Allocate" class="btn btn-link"><img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30"></a>
                      </td>
                      @endif
                      @if($data['status'] == 2 && $data['stakeholder_comment'] == null && $data['cgv_approval'] == 1 || $data['status'] == 3 && $data['stakeholder_comment'] == null && $data['cgv_approval'] == 1 )
                      <td>
                        @php $type=1; @endphp

                        <a type="button" href="{{ route('instruct_show', ['id' => $data['firm_id'], 'type' => $type]) }}" title="show" class="btn btn-link" style="text-decoration:none; color:white; "><i class="fas fa-eye" style="color:green"></i></a>
                      </td>
                      @endif
                      @if($data['status'] == 2 && $data['stakeholder_comment'] == null && $data['cgv_approval'] == 2 || $data['status'] == 3 && $data['stakeholder_comment'] == null && $data['cgv_approval'] ==2)
                      <td>
                        @php $type=1; @endphp

                        <a type="button" href="{{ route('instruct_show', ['id' => $data['firm_id'], 'type' => $type]) }}" title="show" class="btn btn-link" style="text-decoration:none; color:white; "><i class="fas fa-eye" style="color:green"></i></a>
                      </td>
                      @endif


                      @if($data['status'] == 3 && $data['stakeholder_comment'] != null && $data['valuer_comment'] == null)
                      <td>
                        @php $type=1; @endphp
                        <a href="{{ route('instruct_show', ['id' => $data['firm_id'], 'type' => $type]) }}" class="btn btn-link">
                          <img src="{{asset('assets/images/volume-svgrepo-com.svg')}}" alt="" width="20" height="30">
                        </a>
                      </td>
                      @endif
                      @if($data['status'] == 2 && $data['cgv_approval'] == 2 && $data['stakeholder_comment'] != null && $data['valuer_comment'] == null)
                      <td>
                        @php $type=1; @endphp
                        <a href="{{ route('instruct_show', ['id' => $data['firm_id'], 'type' => $type]) }}" class="btn btn-link">
                          <img src="{{asset('assets/images/volume-svgrepo-com.svg')}}" alt="" width="20" height="30">
                        </a>
                      </td>
                      @endif
                      @if($data['status'] == 3 && $data['stakeholder_comment'] != null && $data['valuer_comment'] != null)
                      <td>
                        @php $type=1; @endphp
                        <a href="{{ route('instruct_show', ['id' => $data['firm_id'], 'type' => $type]) }}" class="btn btn-link">
                          <i class="fas fa-eye" style="color:green"></i>
                        </a>
                      </td>
                      @endif
                      @if($data['status'] == 2 && $data['stakeholder_comment'] != null && $data['valuer_comment'] != null && $data['cgv_approval'] == 2)
                      <td>
                        @php $type=1; @endphp
                        <a href="{{ route('instruct_show', ['id' => $data['firm_id'], 'type' => $type]) }}" class="btn btn-link">
                          <i class="fas fa-eye" style="color:green"></i>
                        </a>
                      </td>
                      @endif
                      @if($data['status']==5)
                      @php $type=1; @endphp
                      <td>
                        <a type="button" href="{{ route('instruct_show', ['id' => $data['firm_id'], 'type' => $type]) }}" title="show" class="btn btn-link" style="text-decoration:none; color:white"><i class="fa fa-eye" style="color:green"></i></a>
                      </td>
                      @endif


                    </tr>
                    @endif
                    @php
                    $last_taskvalue=$data['task_name'];
                    @endphp
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