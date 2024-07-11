@extends('layouts.adminnav')
<!-- @section('title', 'Role')
@section('formTitleClass', 'fa fa-dashboard')
@section('formTitle', 'Role')
@section('formDescription', 'New Role Creation')
@section('breadcrumbs')
	
  @endsection -->
@section('content')
<style type="text/css">
  .dt-buttons.btn-group {
    display: none !important;
  }

  .mystyle {
    border: 2px solid red;
  }
</style>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.3/xlsx.full.min.js"></script>
<div class="main-content">
  <section class="section">
    <div class="section-body">
      <section class="section">
        <div class="section-body">{{ Breadcrumbs::render('critical_approve') }}
          <div class="col-lg-12 text-center">
            <h4 style="color:darkblue;">Critical Analysis</h4>
          </div>
          <div class="d-flex flex-row justify-content-between user_space">

            <div class="userrolecontainer">

              <!-- <a href="{{ route('user.reset_token_expire_method') }}" class="btn btn-red">Reset Password Exprire</a> -->

            </div>


          </div>
          <div class="row">

            <div class="col-12">

              <div class="card">

                <div class="card-body">
                  <div class="row">
                    <!-- <div class="col-lg-12 text-center">
          <h4 style="color:darkblue;">Folder List</h4>
        </div> -->

                  </div>
                  @if (session('success'))

                  <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
                  <script type="text/javascript">
                    window.onload = function() {
                      var message = $('#session_data').val();
                      swal({
                        title: "Success",
                        text: message,
                        icon: "question",
                      });

                    }
                  </script>
                  @elseif(session('error'))

                  <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
                  <script type="text/javascript">
                    window.onload = function() {
                      var message = $('#session_data').val();
                      swal({
                        title: "Success",
                        text: message,
                        icon: "question",
                      });

                    }
                  </script>
                  @endif



                  <div class="table-wrapper">
                    <div class="table-responsive">
                      <table class="table table-bordered" id="align">
                        <thead>
                          <tr>
                            <th width="50px">Sl. No.</th>
                            <th>Graduate Trainee Name</th>
                            <th>File Name</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($rows as $row)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row['name'] }}</td>
                            <td>{{ $row['file_name'] }}</td>
                            @if($row['active_status']==Null)
                            <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending</span></td>
                            @elseif($row['status']==1)
                            <td style="color:white;"><span class="badge2 success rounded-pill text-bg-success">Approved</span></td>
                            @else
                            <td style="color:white;"><span class="badge2 danger rounded-pill text-bg-warning">Rejected</span></td>
                            @endif
                            @if($row['status']==2)
                            <td><a type="button" onclick="professional_view({{$row['user_id']}}, 'show')" style="font-size:15px;" class="btn btn btn btn-link" title="View Comments" id="eligview" data-toggle="modal" data-target="#professionalshowwmodal"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                            @else
                            @php $url=config('setting.base_url').'uploads/critical/'. $row['user_id'] .'/'. $row['file_name'] @endphp
                            <td>
                              <a class="btn btn-link" onclick="downloadFile('{{ $url }}')" title="Download" download><i class="fa fa-download" style="color: blue !important"></i></a>
                              <!-- <a class="btn btn-primary" title="view Document" href="{{'/uploads/critical/'.$row['user_id']}}" data-toggle="modal" data-target="#templates" onclick="getproposaldocument()"><i class="fa fa-eye" style="color:white!important"></i></a> -->
                              @if($row['active_status']==Null)
                              <a onclick="submit_functionality(event);" data-id="{{$row['id']}}" data_type='1' title="Approve" class="btn btn-link"><img src="{{asset('assets/images/stamp-solid.svg')}}" style="pointer-events: none;" alt="" width="20" height="30"></a>
                              <a onclick="submit_functionality(event);" data-id="{{$row['id']}}" data_type='2' style="color:red;" title="Reject" class="btn btn-link"><b style="pointer-events:none;">X</b></a>
                              @elseif($row['status']==1)
                              <a onclick="submit_functionality(event);" data-id="{{$row['id']}}" data_type='1' title="Approve" class="btn btn-link d-none"><img src="{{asset('assets/images/stamp-solid.svg')}}" style="pointer-events: none;" alt="" width="20" height="30"></a>
                              <a onclick="submit_functionality(event);" data-id="{{$row['id']}}" data_type='2' style="color:red;" title="Reject" class="btn btn-link d-none"><b style="pointer-events:none;">X</b></a>
                              @endif
                            </td>
                            @endif

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
    </div>
  </section>

  <div id="dvExcel"></div>

  <div class="row" id="table-edit" style="display: none">

    <div class="col-md-12 content-bottom-position">
      <div class="card p-3">
        <div class="tile title-padding">
          <div style="text-align: center;">

          </div>
          <div class="table-responsive" style="overflow-x:auto;">
            <table class="custom-responsive-table table table-hover table-bordered table-custom-list" id="datatable" style="width: 100%;">
              <thead>
                <tr>
                  <th style="width: 20%">User Name</th>
                  <th style="width: 20%">Email</th>
                  <th style="width: 13%">Screen Role Id</th>
                  <th style="width: 13">Project Role Id</th>
                  <th style="width: 17%">Designation Id</th>
                </tr>
              </thead>
              <tbody id="boxavail">

              </tbody>
            </table>
            <div class="text-center">
              <button type="button" class="btn btn-success" id="uploadExcel">Submit</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</section>
</div>
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="{{ route('critical_store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="uploadModalLabel">Critical Analysis</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="mb-3">Upload Critical Analysis<span style="color: red">*</span></label> <a class="btn btn-info" href="/VALUATION-SURVEYORS-LOG-BOOK_2023 (1) (2).docx">Download Template</a>
            <input type="file" id="fileUpload" name="fileUpload" class="form-control" style="margin: 0px;padding: 5px" required="">
            <input type="hidden" name="excel_row" id="excel_row12" class="">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Submit</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- download file -->

<script>
  function downloadFile(url) {
        // Create a temporary anchor element
        var tempLink = document.createElement('a');
        tempLink.href = url;
        tempLink.setAttribute('download', ''); // This attribute will trigger a download
        tempLink.click(); // Simulate a click event to trigger the download
    }
</script>

<!-- Show Module -->
<div class="modal fade" id="professionalshowwmodal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      {{ csrf_field() }}
      <div class="modal-header mh">
        <h4 class="modal-title">View Comments</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body" style="background-color: #f8fffb !important;">
        <form action="" method="post">
          <input name="show" type="hidden" id="show" value="">
          <input type="hidden" class="form-control" id="user_details" name="user_details" value="general">
          <div class="row">

            @csrf
            <div class="col">
              <div class="form-group">
                <label>Comments View</label>
                <textarea id="comments_show" name="comments_show" class="form-control" disabled></textarea>
              </div>

            </div>


          </div>
          <div class="row">
            <div class="col-lg-12 text-center">
              <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="formModal"
aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header bg-yellow">
      <h5 class="modal-title" id="formModal">Instructions</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body md">
      <ul class="arrow">
       <li>Do not add / delete/ modify any columns</li>
       <li>Do not rename the excel file</li>
       <li>Do not attach any image files</li>
       <li>No macros & Pivot tables are allowed</li>
     </ul>
   </div>
   <div class="text-center">
    <a href="{{ asset('images/user_creation_bulk.xlsx') }}"  class="btn btn-warning" id="exampleModalclose"> <span class="icon-name" style="position: relative; bottom: 4px;">OK</span></a>
  </div>
  <br>
</div>
</div>
</div> -->



<script type="text/javascript">
  $("#exampleModalclose").click(function() {
    $('#exampleModal').modal('toggle');
    $("#exampleModal").hide();
  });
</script>



<script type="text/javascript">
  $('#upload').click(function(e) {
    e.preventDefault();

    var fileUpload = $('#fileUpload').val();

    if (fileUpload == '') {
      swal("Please Upload a File", "", "error");

      return false;
    }
  });
</script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>



<script>
  function professional_view(user_id, type) {
    $.ajax({
      url: "{{ url('/professional_show') }}",
      type: 'GET',
      data: {
        'user_id': user_id,
        'type': type,
        _token: '{{csrf_token()}}'

      },
      beforeSend: function() {
        showLoader();
      },

      success: function(data) {
        hideLoader();
        if (type == "show") {
          $('#comments_show').val(data.rows[0]['comments']);
          $('#show').val(data.rows[0]['id']);
          $('#comments_show').prop('disabled', true);

        }

      }
    });

  }
</script>

<script type="text/javascript">
  function submit_functionality(e) {
    var id = e.target.getAttribute('data-id');
    var status = e.target.getAttribute('data_type');
    var comment = null;
    if (status == 2) {
      Swal.fire({
        title: "Are you sure you want to reject?",
        text: "Please enter your comments",
        input: "textarea",
        inputPlaceholder: "Type your comments here...",
        inputAttributes: {
          required: true
        },
        showCancelButton: true,
        confirmButtonText: "Reject",
        confirmButtonClass: "btn btn-danger",
        cancelButtonText: "Cancel",
        cancelButtonClass: "btn btn-secondary"
      }).then((result) => {
        if (result.value) {
          comment = result.value;
          $.ajax({
            url: "{{ url('/critial/decision') }}",
            type: 'GET',
            data: {
              'id': id,
              'status': status,
              'comment': comment,
              _token: '{{csrf_token()}}'

            },
            beforeSend: function() {
              showLoader();
            },

            success: function(data) {
              hideLoader();
              if (status == 1) {
                var message = "Critical Analysis Approved Successfully.";
              } else {
                message = "Critical Analysis Rejected Successfully.";

              }
              Swal.fire({
                icon: 'success',
                title: 'success',
                text: message,
                confirmButtonText: 'OK'
              }).then(function() {
                location.reload();
              })

            },


          })

          // Perform approve action here
          // Perform reject action here using the comment variable
        }
      });

    } else {
      Swal.fire({
        title: "Are you sure you want to approve?",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Approve",
        icon: "question",
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "{{ url('/critial/decision') }}",
            type: 'GET',
            data: {
              'id': id,
              'status': status,
              'comment': comment,
              _token: '{{csrf_token()}}'

            },
            beforeSend: function() {
              showLoader();
            },

            success: function(data) {
              hideLoader();
              if (status == 1) {
                var message = "Critical Analysis Approved Successfully.";
              } else {
                message = "Critical Analysis Rejected Successfully.";

              }
              Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: message,
                confirmButtonText: 'OK'
              })
              setTimeout(function() {
                location.reload();
              }, 500);

            },


          })

          // Perform approve action here
        }
      });
    }






  }

  function Upload() {
    var fileUpload = document.getElementById("fileUpload");
    var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx)$/;
    var file = fileUpload.files[0];
    var filename = file.name;
    if (filename == "user_creation_bulk.xlsx") {
      if (regex.test(fileUpload.value.toLowerCase())) {
        if (typeof(FileReader) != "undefined") {
          var reader = new FileReader();
          if (reader.readAsBinaryString) {
            reader.onload = function(e) {
              ProcessExcel(e.target.result);
            };
            reader.readAsBinaryString(fileUpload.files[0]);
          } else {
            reader.onload = function(e) {
              var data = "";
              var bytes = new Uint8Array(e.target.result);
              for (var i = 0; i < bytes.byteLength; i++) {
                data += String.fromCharCode(bytes[i]);
              }
              ProcessExcel(data);
            };
            reader.readAsArrayBuffer(fileUpload.files[0]);
          }
        } else {
          alert("This browser does not support HTML5.");
        }
      } else {
        alert("Please upload a valid Excel file.");
      }
    } else {
      swal({
        title: "Error",
        text: "Please Upload Valid File!",
        type: "error",
        confirmButtonText: "OK"
      });
    }
  };

  function ProcessExcel(data) {
    var workbook = XLSX.read(data, {
      type: 'binary'
    });
    var firstSheet = workbook.SheetNames[0];
    var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[firstSheet]);

    $("#excel_row12").val(excelRows.length);
    var newcount = excelRows.length;
    $("#table-edit").show();
    $("#texthide").hide();
    $("#fileUpload").prop("disabled", true);
    for (var i = 0; i < newcount; i++) {

      var user_name = excelRows[i].user_name;
      if (user_name == undefined) {
        user_name = '';

      }
      var email = excelRows[i].email;
      if (email == undefined) {
        email = '';

      }

      var screen_role_id = excelRows[i].screen_role_id;
      if (screen_role_id == undefined) {
        screen_role_id = '';

      }

      var project_role_id = excelRows[i].project_role_id;
      if (project_role_id == undefined) {
        project_role_id = '';

      }

      var designation_id = excelRows[i].designation_id;
      if (designation_id == undefined) {
        designation_id = '';

      }


      $('#datatable').DataTable().row.add([
        '<input type="text" name="user_name[]" id="user_name' + i + '" class="form-control vendor1" value ="' + user_name + '">', '<input type="text" name="email[]" id="email' + i + '" class="form-control" value ="' + email + '">', '<input type="text" name="screen_role_id[]" id="screen_role_id' + i + '" class="form-control" value ="' + screen_role_id + '">', '<input type="text" name="project_role_id[]" id="project_role_id' + i + '" class="form-control" value ="' + project_role_id + '">', '<input type="text" name="designation_id[]" id="designation_id' + i + '" class="form-control vendor1" value ="' + designation_id + '">'
      ]).draw();
    }
  };

  $("#savebtn").click(function(e) {
    e.preventDefault();

    swal({
        title: "Success",
        text: "Data Inserted Successfully",
        type: "success"
      },
      function() {

      }
    );


  });
</script>




<script>
  // function getproposaldocument(id) {
  //   var id = (id);

  //   $.ajax({
  //     url: "{{url('view_proposal_documents')}}",
  //     type: 'post',
  //     data: {
  //       id: id,
  //       _token: '{{csrf_token()}}'
  //     },
  //     error: function() {
  //       alert('Something is wrong');
  //     },
  //     success: function(data) {
  //       console.log(data.length);
  //       if (data.length > 0) {
  //         $("#loading_gif").hide();
  //         var proposaldocuments = "<div class='removeclass' style=' height:100%'><iframe src='" + data + "' class='document_ifarme_view' style='width:100%; height:100%'></iframe></div>";
  //         $('.removeclass').remove();
  //         var document = $('#template').append(proposaldocuments);

  //       }
  //     }
  //   });
  // };
  $(document).ready(function() {
    $('#datatable').DataTable({
      "scrollY": "500px",
      "scrollCollapse": true,
      "paging": false,
      "filter": false,
      "bSort": false,
    });
  });

  var selectedFile;
  document
    .getElementById("fileUpload")
    .addEventListener("change", function(event) {
      selectedFile = event.target.files[0];
    });
  document
    .getElementById("uploadExcel")
    .addEventListener("click", function() {

      $('#uploadExcel').prop('disabled', true);

      if (selectedFile) {
        console.log("Hi...");
        var fileReader = new FileReader();
        fileReader.onload = function(event) {
          var data = event.target.result;

          var workbook = XLSX.read(data, {
            type: "binary"
          });
          workbook.SheetNames.forEach(sheet => {
            let rowObject = XLSX.utils.sheet_to_row_object_array(
              workbook.Sheets[sheet]
            );
            let jsonObject = JSON.stringify(rowObject);

            console.log(jsonObject);

            var newcount = $("#excel_row12").val();





            var i = 0;
            for (i; i < newcount; i++) {



              var user_name = document.getElementById("user_name" + i).value;
              var user_name1 = document.getElementById("user_name" + i);
              // alert(screen_role_id);
              if (user_name == "") {


                user_name1.classList.add("mystyle");
                swal({
                    title: "Alert",
                    text: "Please Enter User Name",
                    type: "error",
                    confirmButtonText: "OK"
                  },
                  function(isConfirm) {
                    if (isConfirm) {
                      window.location.href = '{{ route("user.bulk_upload") }}';

                    } else {

                    }
                  });
                return false;
              } else {
                user_name1.classList.remove("mystyle");
              }

              var email = document.getElementById("email" + i).value;
              var email1 = document.getElementById("email" + i);
              // alert(screen_role_id);
              if (email == "") {


                email1.classList.add("mystyle");
                swal({
                    title: "Alert",
                    text: "Please Enter Email",
                    type: "error",
                    confirmButtonText: "OK"
                  },
                  function(isConfirm) {
                    if (isConfirm) {
                      window.location.href = '{{ route("user.bulk_upload") }}';

                    } else {

                    }
                  });
                return false;
              } else {
                email1.classList.remove("mystyle");
              }

              var email_id = document.getElementById("email" + i).value;
              var emailfilter = /^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
              var email = document.getElementById("email" + i)
              console.log(email_id);
              email.classList.remove("mystyle");
              var email1 = emailfilter.test(email.value);
              if (email1 == false) {
                email.classList.add("mystyle");
                swal({
                    title: "Error",
                    text: "Please Fill Valid Email Address!",
                    type: "error",
                    confirmButtonText: "OK"
                  },
                  function(isConfirm) {
                    if (isConfirm) {
                      window.location.href = '{{ route("user.bulk_upload") }}';

                    } else {

                    }
                  });


                return false;
              }




              var screen_role_id = document.getElementById("screen_role_id" + i).value;
              var screen_role_id1 = document.getElementById("screen_role_id" + i);
              // alert(screen_role_id);
              if (screen_role_id != "") {

                if (!/^[0-9]+$/.test(screen_role_id)) {
                  screen_role_id1.classList.add("mystyle");
                  swal({
                      title: "Alert",
                      text: "Please Enter Screen Role Id!",
                      type: "error",
                      confirmButtonText: "OK"
                    },
                    function(isConfirm) {
                      if (isConfirm) {
                        window.location.href = '{{ route("user.bulk_upload") }}';

                      } else {

                      }
                    });
                  return false;
                } else {
                  screen_role_id1.classList.remove("mystyle");
                }

              } else {
                screen_role_id1.classList.remove("mystyle");
              }






              var project_role_id = document.getElementById("project_role_id" + i).value;
              var project_role_id1 = document.getElementById("project_role_id" + i);
              // alert(screen_role_id);
              if (project_role_id != "") {

                if (!/^[0-9]+$/.test(project_role_id)) {
                  project_role_id1.classList.add("mystyle");
                  swal({
                      title: "Alert",
                      text: "Please Enter Project Role Id!",
                      type: "error",
                      confirmButtonText: "OK"
                    },
                    function(isConfirm) {
                      if (isConfirm) {
                        window.location.href = '{{ route("user.bulk_upload") }}';

                      } else {

                      }
                    });
                  return false;
                } else {
                  project_role_id1.classList.remove("mystyle");
                }

              } else {
                project_role_id1.classList.remove("mystyle");
              }






              var designation_id = document.getElementById("designation_id" + i).value;
              var designation_id1 = document.getElementById("designation_id" + i);

              if (designation_id1 != "") {

                if (!/^[0-9]+$/.test(designation_id)) {
                  designation_id1.classList.add("mystyle");
                  swal({
                      title: "Alert",
                      text: "Please Enter Designation Id!",
                      type: "error",
                      confirmButtonText: "OK"
                    },
                    function(isConfirm) {
                      if (isConfirm) {
                        window.location.href = '{{ route("user.bulk_upload") }}';

                      } else {

                      }
                    });
                  return false;
                } else {
                  designation_id1.classList.remove("mystyle");
                }

              } else {
                designation_id1.classList.remove("mystyle");
              }



            }

            // screen_role_checking

            var newcount = $("#excel_row12").val();
            var i = 0;
            for (i; i < newcount; i++) {


              var screen_role_id = document.getElementById("screen_role_id" + i).value;
              var screen_role_id1 = document.getElementById("screen_role_id" + i);
              // alert(screen_role_id);
              if (screen_role_id != "") {

                if (!/^[0-9]+$/.test(screen_role_id)) {
                  screen_role_id1.classList.add("mystyle");
                  swal({
                    title: "Alert",
                    text: "Please Enter Screen Role Id!",
                    type: "error",
                    confirmButtonText: "OK"
                  });
                  return false;
                } else {
                  screen_role_id1.classList.remove("mystyle");
                }

              } else {
                screen_role_id1.classList.remove("mystyle");
              }

              $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });

              var Success = "";
              var token = $('input[name="_token"]').val();

              var checking = 1;


              $.ajax({

                url: '{{ url("/designation/checking_data") }}',
                type: "POST",
                dataType: "json",
                async: false,
                data: {
                  screen_role_id: screen_role_id,
                  checking: checking,
                  token: token
                },
                success: function(data) {

                  if (data == "Failure") {
                    Success = "Failure";
                    var screen_role_id1 = document.getElementById("screen_role_id" + i);
                    screen_role_id1.classList.add("mystyle");
                    swal({
                        title: "Alert",
                        text: "Screen role id not found.Please change and upload",
                        type: "error",
                        confirmButtonColor: '#e73131',
                        confirmButtonText: 'OK',
                      },
                      function(isConfirm) {
                        if (isConfirm) {
                          window.location.href = '{{ route("user.bulk_upload") }}';

                        } else {

                        }
                      });
                    return false;

                  }

                }

              }, 5000);

              if (Success == "Failure") {
                return false;
              } else {

              }

            }




            // Project Role Id Checking

            var newcount = $("#excel_row12").val();
            var i = 0;
            for (i; i < newcount; i++) {


              var project_role_id = document.getElementById("project_role_id" + i).value;
              var project_role_id1 = document.getElementById("project_role_id" + i);
              // alert(screen_role_id);
              if (project_role_id != "") {

                if (!/^[0-9]+$/.test(project_role_id)) {
                  project_role_id1.classList.add("mystyle");
                  swal({
                    title: "Alert",
                    text: "Please Enter Project Role Id!",
                    type: "error",
                    confirmButtonText: "OK"
                  });
                  return false;
                } else {
                  project_role_id1.classList.remove("mystyle");
                }

              } else {
                project_role_id1.classList.remove("mystyle");
              }




              $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });

              var Success = "";
              var token = $('input[name="_token"]').val();

              var checking = 2;


              $.ajax({

                url: '{{ url("/designation/checking_data") }}',
                type: "POST",
                dataType: "json",
                async: false,
                data: {
                  project_role_id: project_role_id,
                  checking: checking,
                  token: token
                },
                success: function(data) {

                  if (data == "Failure") {
                    var project_role_id1 = document.getElementById("project_role_id" + i);
                    project_role_id1.classList.add("mystyle");
                    Success = "Failure";
                    swal({
                        title: "Alert",
                        text: "Project role id not found.Please change and upload",
                        type: "error",
                        confirmButtonColor: '#e73131',
                        confirmButtonText: 'OK',
                      },
                      function(isConfirm) {
                        if (isConfirm) {
                          window.location.href = '{{ route("user.bulk_upload") }}';

                        } else {

                        }
                      });
                    return false;

                  }

                }

              }, 5000);

              if (Success == "Failure") {
                return false;
              } else {

              }

            }



            // designation checking



            var newcount = $("#excel_row12").val();
            var i = 0;
            for (i; i < newcount; i++) {


              var designation_id = document.getElementById("designation_id" + i).value;
              var designation_id1 = document.getElementById("designation_id" + i);

              if (designation_id1 != "") {

                if (!/^[0-9]+$/.test(designation_id)) {
                  designation_id1.classList.add("mystyle");
                  swal({
                    title: "Alert",
                    text: "Please Enter Designation Id!",
                    type: "error",
                    confirmButtonText: "OK"
                  });
                  return false;
                } else {
                  designation_id1.classList.remove("mystyle");
                }

              } else {
                designation_id1.classList.remove("mystyle");
              }



              $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });

              var Success = "";
              var token = $('input[name="_token"]').val();

              var checking = 3;


              $.ajax({

                url: '{{ url("/designation/checking_data") }}',
                type: "POST",
                dataType: "json",
                async: false,
                data: {
                  designation_id: designation_id,
                  checking: checking,
                  token: token
                },
                success: function(data) {

                  if (data == "Failure") {
                    var designation_id1 = document.getElementById("designation_id" + i);
                    designation_id1.classList.add("mystyle");
                    Success = "Failure";
                    swal({
                        title: "Alert",
                        text: "Designation id not found.Please change and upload",
                        type: "error",
                        confirmButtonColor: '#e73131',
                        confirmButtonText: 'OK',
                      },
                      function(isConfirm) {
                        if (isConfirm) {
                          window.location.href = '{{ route("user.bulk_upload") }}';

                        } else {

                        }
                      });
                    return false;

                  }

                }

              }, 5000);

              if (Success == "Failure") {
                return false;
              } else {

              }

            }





            // department checking






            //user email checking


            var newcount = $("#excel_row12").val();
            var i = 0;
            for (i; i < newcount; i++) {


              var email = document.getElementById("email" + i).value;
              var email1 = document.getElementById("email" + i);
              // alert(screen_role_id);
              if (email == "") {


                email1.classList.add("mystyle");
                swal({
                  title: "Alert",
                  text: "Please Enter Email",
                  type: "error",
                  confirmButtonText: "OK"
                });
                return false;
              } else {
                email1.classList.remove("mystyle");
              }




              $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });

              var Success = "";
              var token = $('input[name="_token"]').val();

              var checking = 5;


              $.ajax({

                url: '{{ url("/designation/checking_data") }}',
                type: "POST",
                dataType: "json",
                async: false,
                data: {
                  email: email,
                  checking: checking,
                  token: token
                },
                success: function(data) {

                  if (data == "Failure") {


                    var email1 = document.getElementById("email" + i);
                    email1.classList.add("mystyle");
                    Success = "Failure";
                    swal({
                        title: "Alert",
                        text: "Email already exists.Please change and upload",
                        type: "error",
                        confirmButtonColor: '#e73131',
                        confirmButtonText: 'OK',
                      },
                      function(isConfirm) {
                        if (isConfirm) {

                          window.location.href = '{{ route("user.bulk_upload") }}';

                        } else {

                        }
                      });
                    return false;

                  }

                }

              }, 5000);

              if (Success == "Failure") {
                return false;
              } else {

              }

            }





            // dummy insert

            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });

            var Success = "";
            var token = $('input[name="_token"]').val();

            $.ajax({

              url: '{{ url("/designation/bulkdemodummyupload") }}',
              type: "POST",
              dataType: "json",
              async: false,
              data: {
                jsonObject,
                token: token
              },
              success: function(data) {

              }

            }, 5000);

            if (Success == "false") {
              return false;
            } else {

            }







            //dummy table email checking



            var newcount = $("#excel_row12").val();
            var i = 0;
            for (i; i < newcount; i++) {


              var email = document.getElementById("email" + i).value;
              var email1 = document.getElementById("email" + i);
              // alert(screen_role_id);
              if (email == "") {


                email1.classList.add("mystyle");
                swal({
                  title: "Alert",
                  text: "Please Enter Email",
                  type: "error",
                  confirmButtonText: "OK"
                });
                return false;
              } else {
                email1.classList.remove("mystyle");
              }




              $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });

              var Success = "";
              var token = $('input[name="_token"]').val();

              var checking = 6;


              $.ajax({

                url: '{{ url("/designation/checking_data") }}',
                type: "POST",
                dataType: "json",
                async: false,
                data: {
                  email: email,
                  checking: checking,
                  token: token
                },
                success: function(data) {

                  if (data == "Failure") {

                    var email1 = document.getElementById("email" + i);
                    email1.classList.add("mystyle");
                    Success = "Failure";
                    swal({
                        title: "Alert",
                        text: "Email already exists.Please change and upload",
                        type: "error",
                        confirmButtonColor: '#e73131',
                        confirmButtonText: 'OK',
                      },
                      function(isConfirm) {
                        if (isConfirm) {
                          window.location.href = '{{ route("user.bulk_upload") }}';

                        } else {

                        }
                      });
                    return false;

                  }

                }

              }, 5000);

              if (Success == "Failure") {
                return false;
              } else {

              }

            }






            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });

            var Success = "";
            var token = $('input[name="_token"]').val();
            $.ajax({

              url: '{{ url("/designation/bulkdummyupload")}}',
              type: "POST",
              dataType: "json",
              async: false,
              data: {
                jsonObject,
                token: token
              },
              success: function(data) {

                if (data == "Success") {

                  swal({
                      title: "Alert",
                      text: "Users inserted successfully",
                      type: "success",
                      confirmButtonColor: '#e73131',
                      confirmButtonText: 'OK',
                    },
                    function() {
                      window.location.href = '{{ route("user.index") }}';
                    }
                  );

                }

              }

            }, 5000);

          });
        };
        fileReader.readAsBinaryString(selectedFile);
      }
    });
</script>

<script>
  function getproposaldocument(id) {
    var id = (id);

    $.ajax({
      url: "{{url('view_proposal_documents')}}",
      type: 'post',
      data: {
        id: id,
        _token: '{{csrf_token()}}'
      },
      error: function() {},
      success: function(data) {
        console.log(data.length);
        if (data.length > 0) {
          $("#loading_gif").hide();
          var proposaldocuments = "<div class='removeclass' style=' height:100%'><iframe src='" + data + "' class='document_ifarme_view' style='width:100%; height:100%'></iframe></div>";
          $('.removeclass').remove();
          var document = $('#template').append(proposaldocuments);

        }
      }
    });
  };
</script>

<script>
  function getproposaldocument(id) {

    var data = (id);
    $('#modalviewdiv').html('');
    $("#loading_gif").show();
    console.log(id);

    $("#loading_gif").hide();
    var proposaldocuments = "<div class='removeclass' id='modalviewdiv' style=' height:100%'><iframe src='" + data + "' class='document_ifarme_view' style='width:100%; height:100%'></iframe></div>";
    $('.removeclass').remove();
    var document = $('#template').append(proposaldocuments);

  };
</script>

@include('Registration.formmodal')
@endsection