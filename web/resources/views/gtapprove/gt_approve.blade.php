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
  {{ Breadcrumbs::render('gtapprove') }}





  <section class="section">

    <div class="col-lg-12 text-center">
      <h4 style="color:darkblue;">List of Graduation Trainee</h4>
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
                  swal.fire({
                    title: "Success",
                    text: message,
                    icon: "success",
                  });

                }
              </script>
              @elseif(session('error'))

              <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
              <script type="text/javascript">
                window.onload = function() {
                  var message = $('#session_data1').val();
                  swal.fire({
                    title: "Info",
                    text: message,
                    icon: "info",
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
                        <th>Name</th>
                        <!-- <th>Interest</th> -->
                        <th>Country</th>
                        <th>Status</th>
                        <th>Action</th>


                      </tr>
                    </thead>

                    <tbody>

                      @foreach($rows['rows'] as $data)

                      <div>
                        <!-- for other users -->
                      </div>


                      <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$data['name']}}</td>
                        <!-- <td>{{$data['interest']}}</td> -->
                        <td>{{$data['country']}}</td>
                        @if($data['approval_status']=="Approved")
                        <td style="color:white;"><span class="badge2 success rounded-pill text-bg-success">Approved</span></td>

                        @elseif($data['approval_status']=="Pending")
                        <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending</span></td>                    
                        @elseif($data['approval_status']=="Rejected")
                        <td style="color:white;"><span class="badge2 danger rounded-pill text-bg-warning">Rejected</span></td>

                        @endif

                        <form action="{{route('approve')}}" method="GET">
                          @csrf
                          <td>
                            @if($data['approval_status']=="Approved")
                            <a class="btn btn-link" title="show" href=""><i class="fas fa-eye" style="color:blue"></i></a>
                            @elseif($data['approval_status']=="Pending")
                            <button type="submit" title="Approve or Allocate" class="btn btn-link"><img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30"></button>
                            @endif
                          </td>
                          <input type="hidden" name="gt_id" id="gt_id" value="{{$data['user_id']}}">
                          <input type="hidden" name="approval_persons_id" id="approval_persons_id" value="{{$data['approval_persons_id']}}">
                          <input type="hidden" name="user_id" id="user_id" value="">
                        </form>
                      </tr>
                      <!-- for stake holders -->

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

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
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