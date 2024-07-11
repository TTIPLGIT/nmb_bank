@extends('layouts.adminnav')

@section('content')
<style type="text/css">
  .buttons-html5 {
    background-color: #1bcd6b !important;
    padding: 10px;
    border: 1px;
    color: white;
  }

  #uam_actions,
  #registration,
  #valuers_management,
  #valuers_ratings {
    display: none;
  }
</style>

<div class="main-content">
  {{ Breadcrumbs::render('activeoperation') }}

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
      <h4 style="color:darkblue;">Active/Operation Details</h4>
    </div>
    <br>
    <form class="form-horizontal" action="{{ route('activeoperation.login') }}" method="POST">
      @csrf
      <div class="row" style="display:flex; align-items: self-end;">
        <div class="col-md-4">
          <div class="form-group">
            <label class="control-label">Users</label>
            <select name="user_id" id="user_id" class="form-control">
              <option value="">---Select User---</option>

              @foreach($rows['rows1'] as $key=>$row)

              <option value="{{ $row['id'] }}" {{ $row['id']  ==$user_id ? 'selected':''}}>{{$row['name']}}</option>

              @endforeach
            </select>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label class="control-label">From Date</label>
            <input class="form-control" type="date" id="from_date" name="from_date" placeholder="Enter receipt #" value="{{ $from_date}}">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label class="control-label">To Date</label>
            <input class="form-control" type="date" id="to_date" name="to_date" placeholder="Enter received for" value="{{ $to_date}}">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Process Type</label>
            <select name="process_type" id="process_type" onchange="uam()"class="form-control">
              <option value="">---Select Process Type---</option>
              <option>UAM</option>
              <option value="user">Registration</option>
              <option value=" valuer_list">Valuers Management</option>  
              <option value="user_ratings_qa_details">Valuers Ratings</option>
            </select>
          </div>
        </div>

        <div class="col-md-4" id="uam_actions">
          <div class="form-group">
            <label>UAM Actions</label>
            <select name="uam actions" id="" class="form-control">
              <option value="">---Select Actions---</option>
              <option>Create</option>
              <option>Update</option>
              <option>Delete</option>
            </select>
          </div>
        </div>


        <div class="col-md-4" id="registration">
          <div class="form-group">
            <label>Registration Actions</label>
            <select name="registration" id="" class="form-control">
              <option value="">---Select Actions---</option>
              <option>Create</option>
              <option>Update</option>
              <option>Delete</option>
            </select>
          </div>
        </div>

        <div class="col-md-4" id="valuers_management">
          <div class="form-group">
            <label>Valuers Management Actions</label>
            <select name="valuers management" id="" class="form-control">
              <option value="">---Select Actions---</option>
              <option>Create</option>
              <option>Update</option>
              <option>Delete</option>
            </select>
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

    <br>


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
                        <th>Module Name</th>
                        <th>Action Date and Time</th>
                        <th>Description</th>
                        <th>User Name</th>
                        <th>Role Name</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($rows['rows'] as $key=>$row)

                      <tr>
                        <td>{{ ++$key }}</td>
                        <td>Audit#00{{ $key }}</td>
                        <td>{{ $row['audit_table_name'] }}</td>
                        <td>{{ $row['action_date_time'] }}</td>
                        <td>{{$row['description']}}</td>
                        <td>{{ $row['name'] }}</td>
                        <td>{{$row['role_name']}}</td>
                      </tr>
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

<script>
  function uam() {
    let val = document.getElementById("process_type").value;
    if (val == "UAM") {
      document.getElementById('valuers_management').style.display = "none";
      document.getElementById('registration').style.display = "none";
      document.getElementById('uam_actions').style.display = "block";
    }
    if (val == "user") {
      document.getElementById('valuers_management').style.display = "none";
      document.getElementById('uam_actions').style.display = "none";
      document.getElementById('registration').style.display = "block";
    }
    if (val == "valuer_list") {
      document.getElementById('uam_actions').style.display = "none";
      document.getElementById('registration').style.display = "none";
      document.getElementById('valuers_management').style.display = "block";
    }
    if (val == "Valuers Ratings") {
      document.getElementById('uam_actions').style.display = "none";
      document.getElementById('registration').style.display = "none";
      document.getElementById('valuers_management').style.display = "none";

    }

  }
</script>






@endsection