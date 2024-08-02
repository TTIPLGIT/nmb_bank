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
    border-left: 1px solid #f44336;
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

  .comments_view>p:before {
    content: "\2022";
    /* Unicode character for a bullet point */
    display: inline-block;
    width: 1em;
    margin-left: -1em;
  }

  .comments_view>p {
    text-transform: capitalize;
  }
</style>



<div class="main-content">
  {{ Breadcrumbs::render('nrv_approval') }}





  <section class="section">

    <div class="col-lg-12 text-center">
      <h4 style="color:darkblue;">List of NRU</h4>
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
                        <th>Country</th>
                        <th>Comments</th>
                        <th>Status</th>
                        <th>Action</th>


                      </tr>
                    </thead>

                    <tbody>

                      @foreach($rows['rows'] as $data)

                      <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$data['name']}}</td>
                        <td>{{$data['country']}}</td>
                        @if($data['comments']==null)
                        <td>-</td>
                        @else
                        <td> <a type="button" style="font-size:15px;" class="btn btn-success btn-lg" title="Create" id="eligcb" data-toggle="modal" data-target="#Approve_nrv_comments">Comment</a></td>
                        @endif


                        @if($data['status']==0)
                        <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending</span></td>
                        @elseif($data['status']==1)
                        <td style="color:white;"><span class="badge2 success rounded-pill text-bg-success">Approved</span></td>
                        @elseif($data['status']==2)
                        <td style="color:white;"><span class="badge2 danger rounded-pill text-bg-warning">Rejected</span></td>
                        @endif



                        <form action="" method="GET">
                          @csrf

                          <!-- <td><a class="btn btn-link" title="show" href="{{route('Registration.show','') }}" data-toggle="modal" data-target="#showeligeModal"><i class="fas fa-eye" style="color:blue"></i></a>
 -->
                          <td>
                            <!-- <button type="submit" title="Approve or Allocate" class="btn btn-link"><img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30"></button> -->
                            @if($data['status']==0)
                            <a type='submit' title="Approve" class="btn btn-link" href="{{route('approve_screen', $data['user_id'])}}"><img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30"></a>
                            @endif
                            @if($data['status']==1 || ($data['status']==2))
                            <a class="btn btn-link" title="show" href="{{route('approve_screen', $data['user_id'])}}"><i class="fas fa-eye" style="color:green"></i></a>
                            @endif
                          </td>


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
@if(isset($rows['rows'][0]))
<div class="modal fade" id="Approve_nrv_comments">
  <div class="modal-dialog modal-md ">
    <div class="modal-content">

      <div class="modal-header mh ">
        <h4 class="modal-title">Comments</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>

      <div class="modal-body" style="background-color: #f8fffb !important; padding:18px !important">
        <form action="{{route('update_store')}}" method="post" id="update_store" enctype="multipart/form-data">
          <input type="hidden" class="form-control" id="user_id" name="user_id" value="">
          <input type="hidden" class="form-control" id="user_details" name="user_details" value="general">
          <div class="col comments_view" style="line-height:0;">

            @csrf



            {!! $rows['rows'][0]['comments'] !!}


          </div>

      </div>

    </div>


  </div>

  </form>
</div>
@endif

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