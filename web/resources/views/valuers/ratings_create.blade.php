@extends('layouts.adminnav')

@section('content')
<style type="text/css">
  .buttons-html5 {
    background-color: #1bcd6b !important;
    padding: 10px;
    border: 1px;
    color: white;
  }
</style>

<div class="main-content">

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





  <section class="section">
    <div class="col-lg-12 text-center">
      <h4 style="color:darkblue;">Ratings</h4>
    </div>
    <form class="form-horizontal" action="{{ route('auditlog.login') }}" method="POST">
      @csrf
      <div class="row" style="display:flex; align-items: self-end;">
        <div class="col-md-4">
          <div class="form-group">
            <label class="control-label">Users</label>
            <select name="user_id" id="user_id" class="form-control">
              <option value="">Select User</option>



              <option></option>


            </select>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label class="control-label">From Date</label>
            <input class="form-control" type="date" id="from_date" name="from_date" placeholder="Enter receipt #" value="">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label class="control-label">To Date</label>
            <input class="form-control" type="date" id="to_date" name="to_date" placeholder="Enter received for" value="">
          </div>
        </div>

      </div>

      <div class="row text-center">
        <div class="col-md-12">

          <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-search"></i>&nbsp;&nbsp; Search Details</button>&nbsp;
          <!-- <input class="btn btn-primary" type="reset" value="Reset"> -->

        </div>
      </div>
    </form>


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
                        <th>Audit Id</th>
                        <th>Login Date and Time</th>
                        <th>Logout Date and Time</th>
                        <th>User Name</th>
                        <th>User Email</th>
                      </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div>
        <div>


          <div>

            <form action="{{ route('Registration.store') }}" method="POST" id="create_form" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="modal-header mh">
                <h4 class="modal-title">Add Eligible Criteria</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <div class="modal-body" style=" background-color: #f8fffb;">
                <input type="hidden" class="form-control" required id="user_id" name="user_id" value="">
                <input type="hidden" class="form-control" required id="user_details" name="user_details" value="eligibleq">
                <label style="font-size: 16px !important; color:DarkSlateBlue;">The Ratings are Based on The Answers you Give:<span class="error-star" style="color:red;">*</span></label>

                @foreach($rows['rating_question'] as $data)
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="egc">
                        <div class="dq"><span class="questions">{{$loop->iteration}}. {{$data['question']}}:</span></div>
                        <div class="vl"></div>
                        <div class="switch-field">
                          <input type="hidden" id="qid{{$loop->iteration}}" name="q[{{$loop->iteration}}][qid]" value="{{$data['id']}}">
                          <input type="radio" id="radio-one{{$loop->iteration}}" name="q[{{$loop->iteration}}][qans]" value="1">
                          <label for="radio-one{{$loop->iteration}}">Yes</label>
                          <input type="radio" id="radio-two{{$loop->iteration}}" name="q[{{$loop->iteration}}][qans]" value="0" checked />
                          <label for="radio-two{{$loop->iteration}}">No</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
                <div class="row" style="font-size:xx-large;">
                  <i id="star1" class="fa fa-star"></i>
                  <i id="star2" class="fa fa-star"></i>
                  <i id="star3" class="fa fa-star"></i>
                  <i id="star4" class="fa fa-star"></i>
                  <i id="star5" class="fa fa-star"></i>
                </div>
                <div class="row">
                  <div class="col-lg-12 text-center">

                    <button type="submit" class="btn btn-success btn-space" id="savebutton">Save</button>
                    <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">


                  </div>
                </div>
              </div>
            </form>

          </div>
        </div>
      </div>
  </section>
</div>







@if (session('success'))


<input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
<script type="text/javascript">
  window.onload = function() {
    var message = $('#session_data').val();

    bootbox.alert({
      title: "Success",
      centerVertical: true,
      message: message
    });
  }
</script>
@endif


@if (session('failed'))
<input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('failed') }}">
<script type="text/javascript">
  window.onload = function() {
    var message = $('#session_data').val();

    bootbox.alert({
      title: "Success",
      centerVertical: true,
      message: message
    });
  }
</script>
@endif


<script src="{{ asset('js/table2excel.js') }}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>


<script type="text/javascript">
  $(document).ready(function() {
    var currentDate = new Date();
    var day = currentDate.getDate();

    var month = String(currentDate.getMonth() + 1).padStart(2, '0');
    var year = currentDate.getFullYear();
    var d = day + "" + month + "" + year;
    $('#listDataTable1').DataTable({
      dom: 'Bfrtip',
      buttons: [{
          extend: 'excel',
          text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>Excel Export',
          title: 'Login List' + d
        }
        // 'copy', 'csv', 'excel', 'pdf', 'print'

      ]
    });
  });
</script>
<script>
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }
</script>

<script>
  $(document).on('change', '#from_date', function() {

    var startDate = document.getElementById("from_date").value;
    var endDate = document.getElementById("to_date").value;

    if (endDate == '') {

    } else {

      document.getElementById("to_date").value = "";


    }

  });
  $(document).on('change', '#to_date', function() {

    var startDate = document.getElementById("from_date").value;
    var endDate = document.getElementById("to_date").value;

    if (endDate == '') {

    } else {
      var start_date = new Date(startDate);
      var end_date = new Date(endDate);


      if (start_date >= end_date) {
        swal("Invalid End Date", "", "error");
        document.getElementById("to_date").value = "";
        return false;
      }
    }

  });
</script>

@endsection