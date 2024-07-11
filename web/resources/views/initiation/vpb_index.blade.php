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
  {{ Breadcrumbs::render('vpb_index') }}
  <section class="section">
    <div class="row">
      <div class="col-md-3">
        <a type="button" href="{{ url('initiation/create') }}" value="" class="btn btn-labeled btn-success" title="Initiate" style="border-color:#a9ca !important; color:white !important;margin: 0 0 2px 15px;">
          <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">Initiation</span></a>
      </div>
      <div class="col-md-6"></div>

      <div class="col-md-3">
        <select class="form-control default sort-select" id="sort-select" name="sort-select">

          <option value="1" data-target="all">All</option>
          <option value="0" data-target="0">Pending</option>
          <option value="2" data-target="2">InReview</option>
          <option value="4" data-target="4">Rejected</option>
          <option value="3" data-target="3">Received</option>

        </select>
      </div>
    </div>


    <div class="section-body mt-2">

      <div class="row">

        <div class="col-12">

          <div class="mt-0">

            <div class="card-body" id="card_header">
              <div class="col-lg-12 text-center">
                <h4>Instruction List view</h4>
              </div>

              @if (session('success'))

              <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
              <script type="text/javascript">
                window.onload = function() {
                  var message = $('#session_data').val();
                  swal.fire({
                    title: "Success",
                    text: message,
                    icon: "success",
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
                    title: "Success",
                    text: message,
                    icon: "success",
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

                      @foreach($rows['listview'] as $data)
                      @if($data['task_name'] !=$last_task)
                      <tr>
                        <td>{{$iteration}}</td>
                        <td>{{$data['task_name']}} </td>
                        <td>{{$data['name']}}</td>
                        @if($data['status'] == 0)
                        <td style="color:white;"><span class="sort-box 0 badge2 warning rounded-pill text-bg-danger">Pending</span></td>

                        @elseif($data['status'] == 1)
                        <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">In Progress</span></td>

                        @elseif($data['status'] == 3 && $data['cgv_approval']==0)
                        <td class="status-3" style="color:white;"><span class="badge2 success rounded-pill text-bg-danger">Received</span></td>
                        @elseif($data['status'] == 3 && $data['cgv_approval']==1)
                        <td class="status-0" style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending(CGV )</span></td>

                        @elseif($data['status'] == 3 && $data['cgv_approval']==2)
                        <td class="status-3" style="color:white;"><span class="sort-box 3 badge2 success rounded-pill text-bg-danger">Received</span></td>

                        @elseif($data['status'] == 4)
                        <td class="status-4" style="color:white;"><span class="sort-box 4 badge2 danger rounded-pill text-bg-warning">Rejected</span></td>
                        @else
                        <td class="status-2" style="color:white;"><span class="sort-box 2 badge2 warning rounded-pill text-bg-danger">In Review</span></td>
                        @endif
                        <td>


                          @if($data['status'] == 0 || $data['status'] == 1 )

                          <a title="Show" href="{{route('valuer_show', $data['id'])}}" class="btn btn-link"><i class="fas fa-eye" style="color:green"></i></a>
                          <!-- @if($rows['role'] == 23 ||$rows['role'] == 32||$rows['role'] == 31)
                          <a type="submit" href="{{route('valuer_show', $data['id'])}}" title="Approve or Allocate" class="btn btn-link"><img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30"></a>

                          @endif -->
                          @endif


                          @if($data['status'] == 2 && $data['type'] == 1)

                          <a title="Show" href="{{route('valuer_show', $data['id'])}}" class="btn btn-link"><i class="fas fa-eye" style="color:green"></i></a>
                          @if($rows['role'] == 23 ||$rows['role'] == 32||$rows['role'] == 31)
                          <a type="submit" href="{{route('valuer_show', $data['id'])}}" title="Approve or Allocate" class="btn btn-link"><img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30"></a>

                          @endif
                          @endif

                          @if($data['status'] == 2 && $data['type'] == 2 && $data['cgv_approval']!=2)
                          <a title="Show" href="{{route('valuer_show', $data['id'])}}" class="btn btn-link"><i class="fas fa-eye" style="color:green"></i></a>
                          @if($rows['role'] == 23 && $data['status']==5 ||$rows['role'] == 32 && $data['status']==5||$rows['role'] == 31 && $data['status']==5)
                          <a type="submit" href="{{route('valuer_show', $data['id'])}}" title="Approve or Allocate" class="btn btn-link"><img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30"></a>

                          @endif
                          @endif
                          @if($data['status'] == 2 && $data['type'] == 2 && $data['cgv_approval']==2)

                          <a title="Show" href="{{route('valuer_show', $data['id'])}}" class="btn btn-link"><i class="fas fa-eye" style="color:green"></i></a>
                          @if($rows['role'] == 23 && $data['stakeholder_comment']==null||$rows['role'] == 32 && $data['stakeholder_comment']==null||$rows['role'] == 31 &&$data['stakeholder_comment']==null)
                          <a href="{{route('valuer_show', $data['id'])}}" class="btn btn-primary" style="margin-inline:5px;background-color:cornsilk; border-color:transparent !important;color:#fff">
                            <img src="{{asset('assets/images/volume-svgrepo-com.svg')}}" alt="" width="20" height="30">
                          </a>

                          @endif
                          @endif


                          <!-- <button type="submit" title="Approve or Allocate" class="btn btn-link"><img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30"></button> -->
                          @if($data['status'] == 3 && $data['stakeholder_comment'] ==null && $data['cgv_approval'] ==0)
                          <a href="{{route('valuer_show', $data['id'])}}" class="btn btn-primary" style="margin-inline:5px;background-color:cornsilk; border-color:transparent !important;color:#fff">
                            <img src="{{asset('assets/images/volume-svgrepo-com.svg')}}" alt="" width="20" height="30">
                          </a>
                          @elseif($data['status'] == 3 && $data['stakeholder_comment'] ==null && $data['cgv_approval'] ==1)
                          <a title="Show" href="{{route('valuer_show', $data['id'])}}" class="btn btn-link"><i class="fas fa-eye" style="color:green"></i></a>
                          @elseif($data['status'] == 3 && $data['stakeholder_comment'] ==null && $data['cgv_approval'] ==2)
                          <a title="Show" href="{{route('valuer_show', $data['id'])}}" class="btn btn-link"><i class="fas fa-eye" style="color:green"></i></a>
                          <a href="{{route('valuer_show', $data['id'])}}" class="btn btn-primary" style="margin-inline:5px;background-color:cornsilk; border-color:transparent !important;color:#fff">
                            <img src="{{asset('assets/images/volume-svgrepo-com.svg')}}" alt="" width="20" height="30">
                          </a>
                          @elseif($data['status'] == 3 && $data['stakeholder_comment'] !=null)
                          <a title="Show" href="{{route('valuer_show', $data['id'])}}" class="btn btn-link"><i class="fas fa-eye" style="color:green"></i></a>
                          @elseif($data['status'] == 4 && $data['type']==1)
                          <a type="btn" title="Re-send" href="{{route('reject_edit', $data['id'])}}" class="btn btn-warning">Re-send</a>
                          <!-- <button>Re-send</button> -->
                          @elseif($data['status'] == 4 && $data['type']==2)
                          <a type="btn" title="Re-send" href="{{route('firmreject_edit', $data['id'])}}" class="btn btn-warning">Re-send</a>
                          <!-- <button>Re-send</button> -->
                          @endif
                          @if($data['status'] == 5 )
                          <a href="{{ route('valuer_show', $data['id'])}}" class="btn" style="margin-inline:5px;background-color:cornsilk; border-color:transparent !important;color:#fff">
                            <img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30">
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
     $(document).ready(function() {
      $("#sort-select").on("change", function() {
        var selectedValue = $(this).val();

        if (selectedValue === "all") {
          // Show all rows if "All" is selected
          $("tbody tr").show();
        } else {
          // Hide all rows and then show the selected ones
          $("tbody tr").hide();
          $("tbody .status-" + selectedValue).closest('tr').show();
        }
        $('#align').DataTable({


"lengthMenu": [
  [10, 50, 100, 250, -1],
  [10, 50, 100, 250, "All"]
], // page length options

dom: 'lBfrtip',
destroy: true,


});
      });
    });
  </script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>

<script>
  $(document).ready(function() {


    let url = new URL(window.location.href)
    let message = url.searchParams.get("message");
    if (message != null) {
      window.history.pushState("object or string", "Title", "/gtapprove");

      swal.fire({
        title: "Success",
        text: "Rejected Successfully",
        icon: "success",
      });
    }

  })

 
</script>

@endsection