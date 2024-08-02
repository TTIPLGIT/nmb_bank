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
<div class="main-content">{{ Breadcrumbs::render('valuerindex') }}





  <section class="section">

    <div class="col-lg-12 text-center">
      <h4 style="color:darkblue;">List of Valuers</h4>
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
                        <th>Valuator ID</th>
                        <th>Valuator Name</th>
                        <th>Status</th>
                        <th>Action</th>

                      </tr>
                    </thead>

                    <tbody>


                      @foreach($rows['details'] as $data)

                      <div>
                        <!-- for other users -->
                      </div>

                      @if($data['role_id']!="19")
                      <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$data['valuer_code']}}</td>
                        <td>{{$data['fname']}}</td>
                        <td>{{$data['v_status']}}</td>
                        <input type="hidden" class="celigqa" id="payment_c" value="$data['plan_name']">
                        <input type="hidden" class="celigqa" id="requested_at" value="$data['requested_at']">
                        @php $id = Crypt::encrypt($data['user_id']); @endphp

                        <td>
                          <form action="{{route('approve')}}" method="GET">
                            @csrf
                            @php $id =($data['user_id']); @endphp
                            <input type="hidden" name="valuer_id" class="celigqa" id="valuer_id" value="{{$data['valuer_id']}}">
                            <input type="hidden" name="v_user_id" class="celigqa" id="v_user_id" value="{{$data['user_id']}}">
                            <input type="hidden" name="user_id" class="celigqa" id="user_id" value="{{$user_id}}">
                            <!-- <a class="btn btn-link" title="Edit" href="{{route('Registration.edit','') }}" data-toggle="modal" data-target="#editeligeModal"><i class="fas fa-pencil-alt" style="color:darkblue"></i></a> -->
                            <a class="btn btn-link" title="show" href="{{route('Registration.show','') }}" data-toggle="modal" data-target="#showeligeModal"><i class="fas fa-eye" style="color:blue"></i></a>

                            <button type="submit" title="Approve or Allocate" class="btn btn-link"><img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30"></button>
                          </form>
                        </td>
                      </tr>
                      <!-- for stake holders -->
                      @else
                      <tr>

                        <td>{{$loop->iteration}}</td>
                        <td>{{$data['fname']}}</td>
                        <td>{{$data['valuer_code']}}</td>
                        <td>{{$data['s_status']}}</td>
                        <td>

                          <form action="{{route('approve_for_stake')}}" method="GET">
                            @csrf
                            @php $id =($data['user_id']); @endphp
                            <input type="hidden" name="valuer_id" class="celigqa" id="valuer_id" value="{{$data['valuer_id']}}">
                            <input type="hidden" name="v_user_id" class="celigqa" id="v_user_id" value="{{$data['user_id']}}">
                            <input type="hidden" name="user_id" class="celigqa" id="user_id" value="{{$user_id}}">
                            <!-- <a class="btn btn-link" title="Edit" href="{{route('Registration.edit','') }}" data-toggle="modal" data-target="#editeligeModal"><i class="fas fa-pencil-alt" style="color:darkblue"></i></a> -->
                            <a class="btn btn-link" title="show" href="{{route('Registration.show','') }}" data-toggle="modal" data-target="#showeligeModal"><i class="fas fa-eye" style="color:blue"></i></a>
                            <button type="submit" title="Approve or Allocate" class="btn btn-link"><img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30"></button>
                          </form>
                        </td>
                      </tr>
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
  let url = new URL(window.location.href)
  let message = url.searchParams.get("message");
  if (message != null) {
    swal({
      title: "Success",
      text: "valuer approved Successfully",
      type: "success",
    });
  }
</script>

@endsection