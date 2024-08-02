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
    .mystyle{
      border:  2px solid red;
    }
  </style>
  <script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.3/xlsx.full.min.js"></script>
  <div class="main-content">
<section class="section my-5">
    <div class="section-body">
  <section class="section" style="margin-top: 100px">
    <div class="section-body">
    
      <div class="row">

        <div class="col-12 col-md-12 col-lg-12">
          <div class="card">
            <form>
              <div class="card-header">
               <div class="col-12">
                <h5 style="display: inline;">Bulk Users Creation</h5>
                <button type="button" style="float:right;font-size: 14px; margin-top: -10px; text-align: center;border-radius: 3px;" data-toggle="modal" data-target="#exampleModal" class="btn btn-warning"> Download Template </button>
              </div>
            </div>
            <div class="card-body" id="bom-card">
              <div class="row">
                <div class="col-lg-6 mx-auto">
                  <div class="form-group">
                    <label>Users Creation File<span style="color: red">*</span></label>
                    <input type="file" id="fileUpload" class="form-control" style="margin: 0px;padding: 5px" required="" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                    <input type="hidden" name="excel_row" id="excel_row12"  class="" >
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer text-center mt-2 pt-4">
              <button type="button" class="btn btn-success" id="upload" onclick="Upload(event)">Upload</button>
              <a href="{{ route('user.index') }}" class="btn btn-danger" style=";border-radius: 3px;"> Cancel</a>
              <br>
              <br>
            </div>
          </form>
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="formModal"
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
</div>



<script type="text/javascript">
  $("#exampleModalclose").click(function () {
   $('#exampleModal').modal('toggle');
   $("#exampleModal").hide();
 });
</script>



<script type="text/javascript">
  $('#upload').click(function (e) {
    e.preventDefault();

    var fileUpload = $('#fileUpload').val();

    if(fileUpload == '')
    {
      swal("Please Upload a File", "", "error");

      return false;
    }
  });
</script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>


<script type="text/javascript">
  function Upload() {
    var fileUpload = document.getElementById("fileUpload");
    var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx)$/;
    var file = fileUpload.files[0];  
    var filename = file.name;
    if (filename == "user_creation_bulk.xlsx") {
      if (regex.test(fileUpload.value.toLowerCase())) {
        if (typeof (FileReader) != "undefined") {
          var reader = new FileReader();
          if (reader.readAsBinaryString) {
            reader.onload = function (e) {
              ProcessExcel(e.target.result);
            };
            reader.readAsBinaryString(fileUpload.files[0]);
          } else { 
            reader.onload = function (e) {
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
    }
    else{
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
    var newcount  = excelRows.length;
    $("#table-edit").show();
    $("#texthide").hide();
    $("#fileUpload").prop("disabled", true);
    for (var i = 0; i < newcount; i++) {

        var user_name = excelRows[i].user_name;
            if (user_name == undefined) 
            {
                user_name = '';

            }
            var email = excelRows[i].email;
            if (email == undefined) 
            {
                email = '';

            }

            var screen_role_id = excelRows[i].screen_role_id;
            if (screen_role_id == undefined) 
            {
                screen_role_id = '';

            }

            var project_role_id = excelRows[i].project_role_id;
            if (project_role_id == undefined) 
            {
                project_role_id = '';

            }

            var designation_id = excelRows[i].designation_id;
            if (designation_id == undefined) 
            {
                designation_id = '';

            }


            $('#datatable').DataTable().row.add([
               '<input type="text" name="user_name[]" id="user_name'+i+'" class="form-control vendor1" value ="'+user_name+'">', '<input type="text" name="email[]" id="email'+i+'" class="form-control" value ="'+email+'">','<input type="text" name="screen_role_id[]" id="screen_role_id'+i+'" class="form-control" value ="'+screen_role_id+'">','<input type="text" name="project_role_id[]" id="project_role_id'+i+'" class="form-control" value ="'+project_role_id+'">','<input type="text" name="designation_id[]" id="designation_id'+i+'" class="form-control vendor1" value ="'+designation_id+'">'
               ]).draw();
   }
 };

 $("#savebtn").click(function(e) {
        e.preventDefault();

        swal({title: "Success", text: "Data Inserted Successfully", type: "success"},
            function(){ 

            }
            );


    });
    </script>


 

<script>
  $(document).ready(function() {
$('#datatable').DataTable( {
"scrollY": "500px",
"scrollCollapse": true,
"paging": false,
"filter": false,
"bSort": false,
} );
} );

    var selectedFile;
    document
    .getElementById("fileUpload")
    .addEventListener("change", function(event) {
        selectedFile = event.target.files[0];
    });
    document
    .getElementById("uploadExcel")
    .addEventListener("click", function() {

        $('#uploadExcel').prop('disabled',true);
        
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
for(i;  i < newcount; i++) {



   var user_name = document.getElementById("user_name"+i).value;
   var user_name1 = document.getElementById("user_name"+i);
   // alert(screen_role_id);
   if(user_name == ""){


    user_name1.classList.add("mystyle");
    swal({
        title: "Alert",
        text: "Please Enter User Name",
        type: "error",
        confirmButtonText: "OK"
      },
        function(isConfirm){
            if (isConfirm){
                window.location.href = '{{ route("user.bulk_upload") }}';

            } else {

            }
        }); 
    return false;
}else{
    user_name1.classList.remove("mystyle");
}

var email = document.getElementById("email"+i).value;
var email1 = document.getElementById("email"+i);
   // alert(screen_role_id);
   if(email == ""){


    email1.classList.add("mystyle");
    swal({
        title: "Alert",
        text: "Please Enter Email",
        type: "error",
        confirmButtonText: "OK"
      },
        function(isConfirm){
            if (isConfirm){
                window.location.href = '{{ route("user.bulk_upload") }}';

            } else {

            }
        }); 
    return false;
}else{
    email1.classList.remove("mystyle");
}

     var email_id = document.getElementById("email"+i).value;
     var emailfilter= /^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
     var email = document.getElementById("email"+i)
     console.log(email_id);
     email.classList.remove("mystyle");
     var email1 = emailfilter.test(email.value);
     if(email1 == false)
     {
       email.classList.add("mystyle");
       swal({
        title: "Error",
        text: "Please Fill Valid Email Address!",
        type: "error",
        confirmButtonText: "OK"
      },
        function(isConfirm){
            if (isConfirm){
                window.location.href = '{{ route("user.bulk_upload") }}';

            } else {

            }
        }); 


       return false;
     }




var screen_role_id = document.getElementById("screen_role_id"+i).value;
var screen_role_id1 = document.getElementById("screen_role_id"+i);
   // alert(screen_role_id);
   if(screen_role_id != ""){

    if(!/^[0-9]+$/.test(screen_role_id)){
        screen_role_id1.classList.add("mystyle");
        swal({
            title: "Alert",
            text: "Please Enter Screen Role Id!",
            type: "error",
            confirmButtonText: "OK"
         },
        function(isConfirm){
            if (isConfirm){
                window.location.href = '{{ route("user.bulk_upload") }}';

            } else {

            }
        }); 
        return false;
    }else{
        screen_role_id1.classList.remove("mystyle");
    }

}else{
    screen_role_id1.classList.remove("mystyle");
}






var project_role_id = document.getElementById("project_role_id"+i).value;
var project_role_id1 = document.getElementById("project_role_id"+i);
   // alert(screen_role_id);
   if(project_role_id != ""){

    if(!/^[0-9]+$/.test(project_role_id)){
        project_role_id1.classList.add("mystyle");
        swal({
            title: "Alert",
            text: "Please Enter Project Role Id!",
            type: "error",
            confirmButtonText: "OK"
          },
        function(isConfirm){
            if (isConfirm){
                window.location.href = '{{ route("user.bulk_upload") }}';

            } else {

            }
        }); 
        return false;
    }else{
        project_role_id1.classList.remove("mystyle");
    }

}else{
    project_role_id1.classList.remove("mystyle");
}






var designation_id = document.getElementById("designation_id"+i).value;
var designation_id1 = document.getElementById("designation_id"+i);

if(designation_id1 != ""){

    if(!/^[0-9]+$/.test(designation_id)){
        designation_id1.classList.add("mystyle");
        swal({
            title: "Alert",
            text: "Please Enter Designation Id!",
            type: "error",
            confirmButtonText: "OK"
        },
        function(isConfirm){
            if (isConfirm){
                window.location.href = '{{ route("user.bulk_upload") }}';

            } else {

            }
        }); 
        return false;
    }else{
        designation_id1.classList.remove("mystyle");
    }

}else{
    designation_id1.classList.remove("mystyle");
}



}

// screen_role_checking

var newcount = $("#excel_row12").val();
var i = 0;
for(i;  i < newcount; i++) {


    var screen_role_id = document.getElementById("screen_role_id"+i).value;
    var screen_role_id1 = document.getElementById("screen_role_id"+i);
   // alert(screen_role_id);
   if(screen_role_id != ""){

    if(!/^[0-9]+$/.test(screen_role_id)){
        screen_role_id1.classList.add("mystyle");
        swal({
            title: "Alert",
            text: "Please Enter Screen Role Id!",
            type: "error",
            confirmButtonText: "OK"
        });
        return false;
    }else{
        screen_role_id1.classList.remove("mystyle");
    }

}else{
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

    url:'{{ url("/designation/checking_data") }}',         
    type: "POST", 
    dataType:"json", 
    async: false,  
    data: {screen_role_id:screen_role_id,checking:checking,token:token}, 
    success: function (data) {

     if(data == "Failure" ){
        Success = "Failure";
         var screen_role_id1 = document.getElementById("screen_role_id"+i);
         screen_role_id1.classList.add("mystyle");
        swal({
            title: "Alert",
            text: "Screen role id not found.Please change and upload",
            type: "error",
            confirmButtonColor: '#e73131',
            confirmButtonText: 'OK',
        },
        function(isConfirm){
            if (isConfirm){
                window.location.href = '{{ route("user.bulk_upload") }}';

            } else {

            }
        }); 
        return false;

    } 

}

}, 5000
);

if (Success == "Failure") {
    return false;
}else{

}

}




// Project Role Id Checking

var newcount = $("#excel_row12").val();
var i = 0;
for(i;  i < newcount; i++) {


var project_role_id = document.getElementById("project_role_id"+i).value;
var project_role_id1 = document.getElementById("project_role_id"+i);
   // alert(screen_role_id);
   if(project_role_id != ""){

    if(!/^[0-9]+$/.test(project_role_id)){
        project_role_id1.classList.add("mystyle");
        swal({
            title: "Alert",
            text: "Please Enter Project Role Id!",
            type: "error",
            confirmButtonText: "OK"
        });
        return false;
    }else{
        project_role_id1.classList.remove("mystyle");
    }

}else{
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

    url:'{{ url("/designation/checking_data") }}',         
    type: "POST", 
    dataType:"json", 
    async: false,  
    data: {project_role_id:project_role_id,checking:checking,token:token}, 
    success: function (data) {

     if(data == "Failure" ){
        var project_role_id1 = document.getElementById("project_role_id"+i);
        project_role_id1.classList.add("mystyle");
        Success = "Failure";
        swal({
            title: "Alert",
            text: "Project role id not found.Please change and upload",
            type: "error",
            confirmButtonColor: '#e73131',
            confirmButtonText: 'OK',
        },
        function(isConfirm){
            if (isConfirm){
                window.location.href = '{{ route("user.bulk_upload") }}';

            } else {

            }
        }); 
        return false;

    } 

}

}, 5000
);

if (Success == "Failure") {
    return false;
}else{

}

}



// designation checking



var newcount = $("#excel_row12").val();
var i = 0;
for(i;  i < newcount; i++) {


var designation_id = document.getElementById("designation_id"+i).value;
var designation_id1 = document.getElementById("designation_id"+i);

if(designation_id1 != ""){

    if(!/^[0-9]+$/.test(designation_id)){
        designation_id1.classList.add("mystyle");
        swal({
            title: "Alert",
            text: "Please Enter Designation Id!",
            type: "error",
            confirmButtonText: "OK"
        });
        return false;
    }else{
        designation_id1.classList.remove("mystyle");
    }

}else{
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

    url:'{{ url("/designation/checking_data") }}',         
    type: "POST", 
    dataType:"json", 
    async: false,  
    data: {designation_id:designation_id,checking:checking,token:token}, 
    success: function (data) {

     if(data == "Failure" ){
        var designation_id1 = document.getElementById("designation_id"+i);
        designation_id1.classList.add("mystyle");
        Success = "Failure";
        swal({
            title: "Alert",
            text: "Designation id not found.Please change and upload",
            type: "error",
            confirmButtonColor: '#e73131',
            confirmButtonText: 'OK',
        },
        function(isConfirm){
            if (isConfirm){
                window.location.href = '{{ route("user.bulk_upload") }}';

            } else {

            }
        }); 
        return false;

    } 

}

}, 5000
);

if (Success == "Failure") {
    return false;
}else{

}

}





// department checking






//user email checking


var newcount = $("#excel_row12").val();
var i = 0;
for(i;  i < newcount; i++) {


var email = document.getElementById("email"+i).value;
var email1 = document.getElementById("email"+i);
   // alert(screen_role_id);
   if(email == ""){


    email1.classList.add("mystyle");
    swal({
        title: "Alert",
        text: "Please Enter Email",
        type: "error",
        confirmButtonText: "OK"
    });
    return false;
}else{
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

    url:'{{ url("/designation/checking_data") }}',         
    type: "POST", 
    dataType:"json", 
    async: false,  
    data: {email:email,checking:checking,token:token}, 
    success: function (data) {

     if(data == "Failure" ){
      
        var email1 = document.getElementById("email"+i);
        email1.classList.add("mystyle");
        Success = "Failure";
        swal({
            title: "Alert",
            text: "Email already exists.Please change and upload",
            type: "error",
            confirmButtonColor: '#e73131',
            confirmButtonText: 'OK',
        },
        function(isConfirm){
            if (isConfirm){
             
                window.location.href = '{{ route("user.bulk_upload") }}';

            } else {

            }
        }); 
        return false;

    } 

}

}, 5000
);

if (Success == "Failure") {
    return false;
}else{

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

    url:'{{ url("/designation/bulkdemodummyupload") }}',         
    type: "POST", 
    dataType:"json", 
    async: false,  
    data: {jsonObject,token:token}, 
    success: function (data) {

              }

          }, 5000
          );

if (Success == "false") {
    return false;
}else{

}







//dummy table email checking



var newcount = $("#excel_row12").val();
var i = 0;
for(i;  i < newcount; i++) {


var email = document.getElementById("email"+i).value;
var email1 = document.getElementById("email"+i);
   // alert(screen_role_id);
   if(email == ""){


    email1.classList.add("mystyle");
    swal({
        title: "Alert",
        text: "Please Enter Email",
        type: "error",
        confirmButtonText: "OK"
    });
    return false;
}else{
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

    url:'{{ url("/designation/checking_data") }}',         
    type: "POST", 
    dataType:"json", 
    async: false,  
    data: {email:email,checking:checking,token:token}, 
    success: function (data) {

     if(data == "Failure" ){
      
        var email1 = document.getElementById("email"+i);
        email1.classList.add("mystyle");
        Success = "Failure";
        swal({
            title: "Alert",
            text: "Email already exists.Please change and upload",
            type: "error",
            confirmButtonColor: '#e73131',
            confirmButtonText: 'OK',
        },
        function(isConfirm){
            if (isConfirm){
                window.location.href = '{{ route("user.bulk_upload") }}';

            } else {

            }
        }); 
        return false;

    } 

}

}, 5000
);

if (Success == "Failure") {
    return false;
}else{

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

   url:'{{ url("/designation/bulkdummyupload")}}',         
   type: "POST",  
   dataType:"json", 
   async: false,  
   data: {jsonObject,token:token},  
   success: function (data) {
    
    if(data == "Success" ){ 

      swal({
            title: "Alert",
            text: "Users inserted successfully",
            type: "success",
            confirmButtonColor: '#e73131',
            confirmButtonText: 'OK',
        },
function(){
window.location.href = '{{ route("user.index") }}';
}
);

}

   }

 }, 5000
 );

});
};
fileReader.readAsBinaryString(selectedFile);
}
});

</script>




@endsection