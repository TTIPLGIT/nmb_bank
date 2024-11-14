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

  .userrolecontainer {
    display: inline-block !important;
    padding-right: 21px;
  }
</style>
<div class="main-content">


  {{ Breadcrumbs::render('user.index') }}


  <section class="section">


    <div class="section-body mt-2">



      <div class="d-flex flex-row justify-content-between user_space">
        <a type="button" style="font-size:15px;" class="btn btn-success btn-lg user_create customesize mb-2"
          href="{{ route('user.create') }}">Create</a>
        <div class="userrolecontainer">
          @if(strpos($screen_permission['permissions'], 'Create') !== false)
        <!-- <a href="{{ route('user.project_roles_list') }}" class="btn btn-warning customesize">Project Role list</a> -->

        <!-- <a href="{{ route('user.reset_token_expire_method') }}" class="btn btn-red">Reset Password Exprire</a> -->

        <a href="{{ route('user.bulk_upload') }}" class="btn btn-success customesize">Bulk Creation</a>
      @endif
        </div>


      </div>
      <style>
        .section {
          margin-top: 20px;
        }
      </style>



      <div class="row">

        <div class="col-12">

          <div class="card">

            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 text-center">
                  <h4>Users List</h4>
                </div>

              </div>
              @if (session('success'))

          <input type="hidden" name="session_data" id="session_data" class="session_data"
          value="{{ session('success') }}">
          <script type="text/javascript">
          window.onload = function () {
            var message = $('#session_data').val();
            swal({
            title: "Success",
            text: message,
            icon: "success",
            });


          }
          </script>
        @elseif(session('error'))

        <input type="hidden" name="session_data" id="session_data1" class="session_data"
        value="{{ session('error') }}">
        <script type="text/javascript">
        window.onload = function () {
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
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Designation</th>
                        <th>Action</th>
                        <th>Active Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($rows as $key => $row)
              <tr>
              <td>{{ ++$key }}</td>
              <td>{{$row['name'] }}</td>
              <td>{{ $row['email'] }}</td>
              <td>{{ $row['role_designation'] }}</td>
              <td class="text-center">

                @if(strpos($screen_permission['permissions'], 'Edit') !== false)
          <a class="btn btn-link"
          href="{{ route('user.edit_permission', \Crypt::encrypt($row['id'])) }}"
          data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Permission"><i
            class="fa fa-lock" aria-hidden="true"></i><span></span></a>
        @endif

                @if(strpos($screen_permission['permissions'], 'Edit') !== false)
          <a class="btn btn-link" href="{{ route('user.edit', \Crypt::encrypt($row['id'])) }}"
          data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="fa fa-edit"
            aria-hidden="true"></i><span></span></a>
          <!-- <a class="btn btn-link" href="{{ route('user.change_password_admin', \Crypt::encrypt($row['id'])) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Change Password"><i class="fa fa-key" aria-hidden="true"></i><span></span></a> -->

        @endif

                @if(strpos($screen_permission['permissions'], 'Show') !== false)
          <a class="btn btn-link" href="{{ route('user.show', \Crypt::encrypt($row['id'])) }}"
          data-bs-toggle="tooltip" data-bs-placement="top" title="Show"><i class="fa fa-eye"
            aria-hidden="true"></i><span></span></a>
        @endif
                @if(strpos($screen_permission['permissions'], 'Edit') !== false)
          <input type="hidden" name="delete_id" id="<?php    echo $row['id']; ?>"
          value="{{ route('user.delete', \Crypt::encrypt($row['id'])) }}">
          <a class="btn btn-link" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"
          style="cursor: pointer;" onclick="return myFunction(<?php    echo $row['id']; ?>);"><i
            class="fa fa-trash" aria-hidden="true"></i><span></span></a>
        @endif


              </td>
              <td style="text-align: center;">

                <label class="switch " data-bs-toggle="tooltip" data-bs-placement="top"
                title="Enable / Disable">
                <input type="hidden" name="toggle_id" value="{{$row['id']}}">

                <input type="checkbox" class="toggle_status" onclick="functiontoggle('{{$row['id']}}')"
                  id="is_active{{$row['id']}}" name="is_active" @if($row['active_flag'] == '0') checked
          @endif>
                <span class="slider round"></span>
                </label>

              </td>
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
    </div>
  </section>
</div>
</div>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
  function myFunction(id) {

    swal({
      title: "Confirmation For Delete ?",
      text: "Are You Sure to delete this data",
      icon: "warning",
      buttons: [
        'No, cancel it!',
        'Yes, I am sure!'
      ],
      dangerMode: true,
    }).then(function (isConfirm) {
      if (isConfirm) {
        var url = $('#' + id).val();
        // alert(url);
        window.location.href = url;
      }
    });

  }
</script>
<script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  function functiontoggle(id) {
    // alert(id);
    if ($('#is_active' + id).prop('checked')) {
      var is_active = '0';
    } else {
      var is_active = '1';
    }


    var f_id = id;





    $.ajax({
      url: "{{ route('user.update_toggle') }}",
      type: 'POST',
      data: {
        is_active: is_active,
        f_id: f_id,
        _token: '{{csrf_token()}}'
      },
      error: function () {
        alert('Something is wrong');
      },
      success: function (data) {

        var data_convert = $.parseJSON(data);

        console.log(data_convert.Data);
        if (data_convert.Data == 1) {
          swal({
            title: "Success",
            text: "User Deactivated",
            type: "success"
          },);
        } else {
          swal({
            title: "Success",
            text: "User Activated",
            type: "success"
          },);
        }

      }


    });
  }
</script>

@endsection