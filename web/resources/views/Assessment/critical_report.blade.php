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

  .proff_head {
    text-align: center !important;

    height: 50px;
    background: #3f9a9d;
  }


  .proff_head h4 {
    font-size: 18px;
    padding: 14px;
    color: #fff;
  }

  .proff-body {
    height: 100px;

  }

  .form-control111 {
    font-size: 20px;
    color: #000;
    display: block !important;
  }

  .form-control123 {
    font-size: 22px;
    color: #000;
    display: block !important;
    margin-top: 10px;
  }

  .dispaly_row {
    display: flex !important;
    align-items: baseline !important;
  }
</style>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.3/xlsx.full.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>


<div class="main-content">


  @php $exist=$exist; @endphp

  <div class="container-fluid">

    @if($exist ==0)
    <div class="row">

      <div class="col-md-3"></div>
      <div class="col-md-6">
        <div class="card" style="width:100%">
          <div class=" proff_head">
            <h4>Criteria Needs to Apply For Professional Member</h4>
          </div>
          <div class="card-body">
            <div class="content proff-body">
              <div class="row dispaly_row">
                <div class="col-md-2"></div>
                <div class="col-md-4">

                  <label class="form-control111">Ethic Test : </label>
                </div>
                <div class="col-md-4">
                  <input type="checkbox" disabled name="" style="transform: scale(1.5);" class="form-control123">
                </div>
                <div class="col d-flex justify-content-center">
                  <a type="button" class="btn btn-labeled btn-info" href="{{ url()->previous() }}" title="next" style="background: red !important; border-color:red !important; color:white !important; margin-top:15px !important;">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>
                </div>

              </div>




            </div>

          </div>

        </div>
      </div>
      <div class="col-md-3"></div>
    </div>
  </div>
  @else


  {{ Breadcrumbs::render('critical_approve') }}
  <section class="section">
    <div class="section-body">
      <section class="section">
        <div class="section-body">
          <div class="col-lg-12 text-center">
            <h4 style="color:darkblue;">Critical Analysis List</h4>
          </div>
          <div class="d-flex flex-row justify-content-between user_space">
            @if($rows==[])
            <a type="button" style="font-size:12px !important;" data-toggle="modal" data-target="#uploadModal" class="btn btn-success btn-lg user_create customesize mb-3" }}">Upload Critical Analysis</a>
            @endif
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
                      swal.fire({
                        title: "Success",
                        text: message,
                        icon: "success", // Set the icon to "success" to display a success icon
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
                        icon: "info", // Set the icon to "info" to display an info icon
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
                            <th>File Name</th>
                            <th>Comments</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($rows as $row)
                          <td>{{ $loop->iteration }}</td>
                          <td>{{$row['file_name']}}</td>
                          <td>{{$row['comments']}}-</td>
                          @if($row['status']==0)
                          <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending</span></td>
                          @elseif($row['status']==1)
                          <td style="color:white;"><span class="badge2 success rounded-pill text-bg-success">Approved</span></td>
                          @elseif($row['status']==3)
                          <td style="color:white;"><span class="badge2 success rounded-pill text-bg-success">Approved</span></td>
                          @else
                          <td style="color:white;"><span class="badge2 danger rounded-pill text-bg-warning">Rejected</span></td>
                          @endif
                          @if($row['status']==1 || $row['status']==0)
                          <td>
                            <a class="btn btn-link" href="{{$row['file_path']}}" title="Download"><i class="fa fa-download" style="color: blue !important"></i></a>
                          </td>
                          @else
                          <td> <a class="btn btn-link" title="Edit"><i class="fas fa-pencil-alt" data-toggle="modal" data-target="#editModal" style="color: blue !important; cursor:pointer;"></i></a>
                            <a class="btn btn-link" href="{{$row['file_path']}}" title="Download"><i class="fa fa-download" style="color: blue !important"></i></a>
                          </td>
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

        </div>
    </div>
  </section>
  @endif







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


<!-- Edit Crtitical Report -->


<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="{{route('criticalfile_edit')}}" method="POST" enctype="multipart/form-data" id="file_uploadedit">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Critical Analysis</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label class="mb-3">Upload Critical Analysis<span style="color: red">*</span></label> <a class="btn btn-info" href="/VALUATION-SURVEYORS-LOG-BOOK_2023 (1) (2).docx">Download Template</a>
            <input type="file" id="fileUpload_name" name="fileUpload_name" class="form-control" style="margin: 0px;padding: 5px" accept=".docx, .doc" required="">
            <input type="hidden" name="excel_row" id="excel_row12" class="">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Update</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
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
          <button type="submit" onclick="val_cri()" class="btn btn-success">Submit</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </form>
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

  $('#fileUpload').on('change', function(e) {
    let file = e.target.files[0];
    console.log(file);
    fileName = file.name;
    fileExtension = fileName.split('.');
    console.log(fileExtension[1]);
    if (fileExtension[1] != "docx" && fileExtension[1] != "doc") {
      e.target.value = "";
      swal.fire("Only Word files can be Uploaded please re-upload", "", "error");

      return false;

    }
  })
</script>



<script type="text/javascript">
  $('#upload').click(function(e) {
    e.preventDefault();

    var fileUpload = $('#fileUpload').val();

    if (fileUpload == '') {
      swal.fire("Please Upload a File", "", "error");

      return false;
    }
  });
</script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>
<script>
  $(document).ready(function() {
    $('#editModal').on('hidden.bs.modal', function()

      {
        $(this).find('form')[0].reset();
      });
  });
</script>

<script type="text/javascript">
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
      swal.fire({
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

    swal.fire({
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
  $(document).ready(function() {
    $('#uploadModal').on('hidden.bs.modal', function()

      {
        $(this).find('form')[0].reset();
      });
  });


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
                swal.fire({
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
                swal.fire({
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
                swal.fire({
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
                  swal.fire({
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
                  swal.fire({
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
                  swal.fire({
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
                  swal.fire({
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
                    swal.fire({
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
                  swal.fire({
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
                    swal.fire({
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
                  swal.fire({
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
                    swal.fire({
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
                swal.fire({
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
                    swal.fire({
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
                swal.fire({
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
                    swal.fire({
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

                  swal.fire({
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
  function val_cri() {
    var uploadfile = $("#fileUpload").val();
    if (uploadfile == '') {
      swal.fire("Please Upload the Critical Analysis File", "", "error")
      return false;
    } else {
      document.getElementById('#uploadModal').submit();
    }
  }
</script>



@endsection