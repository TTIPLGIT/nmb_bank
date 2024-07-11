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
<!-- <script>
$(document).ready(function() {
    $('#align2').DataTable();
});
</script> -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>

<div class="main-content main_contentspace">
    <div class="row justify-content-center">
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

        <div class="col-lg-12 col-md-12">

            <div class="row" style="display: flex;justify-content: space-between;">
                <div class="col-sm-3 mb-2">
                    <a type="button" style="font-size:15px;margin: 0px 0px 0px 0px;" class="btn btn-success btn-lg question" title="Create" onclick="file_view()">Add<span><i class="fa fa-plus" aria-hidden="true"></i></span></a>
                </div>
            </div>

            <section class="section" id="file_master" style="display:none">


                <div class="section-body mt-0">
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
                            swal.fire({
                                title: "Info",
                                text: message,
                                icon: "info",
                                type: "info",
                            });

                        }
                    </script>
                    @endif


                </div>
            </section>

            <section class="section" id="file_list">
                <div class="section-body mt-0">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="card">
                                <div class="card-body">
                                    <h2 style="text-align:center;">File Uploads</h2>
                                    <div class="table-wrapper">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="align">
                                                <thead>
                                                    <tr>
                                                        <th>Sl. No.</th>
                                                        <th>File Type</th>
                                                        <th>File Size</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach($rows['rows'] as $data)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$data['file_type']}}</td>
                                                        <td>{{$data['file_size']}}</td>
                                                        <td>

                                                            <form action="" id="file_des" method="POST">

                                                                <a class="" title="Edit" id="file_edit" data-toggle="modal" data-target="#editfileuploadModal" onclick="fileupload_fetch({{$data['id']}},'edit')"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>
                                                                <a class="btn btn-link" title="show" data-toggle="modal" data-target="#editfileuploadModal" onclick="fileupload_fetch({{$data['id']}},'show')"><i class="fas fa-eye" style="color:green"></i></a>
                                                                @method('put')
                                                                @csrf

                                                                <a title="Delete" onclick="fileupload_delete(<?php echo $data['id'] ?>)" class="btn btn-link"><i class="far fa-trash-alt" style="color:red"></i></a>
                                                            </form>
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

</div>

<!-- Add File Uploads -->

<div class="modal fade" id="addfileuploadModal">
    <div class="modal-dialog modal-lg">


        <div class="modal-content" style="margin-left:10%; margin-top:10%">

            <div class="modal-header mh">
                <h4 class="modal-title">Add File Upload Size</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <form action="{{route('fileupload_store')}}" method="post" id="file_uploadmaster" class="reset">
                {{ csrf_field() }}
                <input name="stakeholder_id" type="hidden" value="">
                <div class="section-body mt-1">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">File Type<span style="color: red;font-size: 16px;">*</span></label>
                                <input class="form-control" type="text" id="file_type" name="file_type" placeholder="Enter File Name" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">File Size<span style="color: red;font-size: 16px;">*</span></label>
                                <input class="form-control" type="text" id="file_size" name="file_size" placeholder="Enter File Size" autocomplete="off">
                            </div>
                        </div>


                    </div>
                    <div class="col-md-12" style="text-align:center;margin-bottom:2%">
                        <a class="btn btn-success btn-space" type="button" onclick="fileupload_valid()" id="savedetails">Submit</a>
                        <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">

                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- End Add Files -->

<!-- edit function -->
<div class="modal fade" id="editfileuploadModal">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <form method="POST" action="{{route('fileupload_update')}}" id="edit_fileform" enctype="multipart/form-data">

                @csrf
                <input type="hidden" name="id" class="id" id="editfileuploadid">

                <div class="modal-header mh">
                    <h4 class="modal-title">Edit File Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>


                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">File Type<span style="color: red;font-size: 16px;">*</span></label>
                            <input class="form-control" type="text" id="editfile_type" name="editfile_type" placeholder="Enter File Name" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">File Size<span style="color: red;font-size: 16px;">*</span></label>
                            <input class="form-control" type="text" id="editfile_size" name="editfile_size" placeholder="Enter File Size" autocomplete="off">
                        </div>
                    </div>


                </div>

                <div class="row">
                    <div class="col-lg-12 text-center">
                        <button class="btn btn-success btn-space" type="submit" id="savebutton">Update</button>
                        <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                    </div>
                </div>

            </form>
        </div>


    </div>
</div>

<!-- --edit end-- -->

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>


<script>
    function fileupload_valid() {
        var file = $("#file_type").val();
        if (file == '') {
            swal.fire("Please Enter the File Type", "", "error");
            return false;
        }
        var size_file = $("#file_size").val();
        if (size_file == '') {
            swal.fire("Please Enter the File Size", "", "error");
            return false;
        }
        document.getElementById('file_uploadmaster').submit();

    }
</script>

<script>
    $(document).ready(function() {
        $('#addfileuploadModal').on('hidden.bs.modal', function()

            {
                $(this).find('form')[0].reset();
            });
    });

    function file_view() {
        var result = document.querySelector('#file_list').value;
        if (result == "file_upload") {
            $("#addfileuploadModal").modal("show");
        } else {
            $("#addfileuploadModal").modal("show");

        }
    }

    function fileupload_delete(id) {
        Swal.fire({
            title: "Are you sure, you want to delete the File details?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Delete",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('fileupload_delete') }}",
                    type: 'POST',
                    data: {
                        id: id,

                        _token: '{{csrf_token()}}'
                    },
                    success: function(data) {

                        if (result.value) {
                            Swal.fire("Success!", "File Details Deleted Successfully!", "success").then((result) => {

                                location.replace(`file_upload`);

                            })
                        }

                    }
                });
            }
        })
    } 
</script>

<script>
       function fileupload_fetch(id, type) {

$.ajax({
    url: "{{ url('/fileupload/edit') }}",
    type: 'GET',
    data: {
        'id': id,
        _token: '{{csrf_token()}}'

    },

    success: function(data) {
        console.log(data);
        $('#editfileuploadid').val(data[0]['id']);
        if (type == "edit") {
            $('#editfileuploadModal.modal-title').text('Edit File Details')
            $('#savebutton').show();
            $('#editfile_type').val(data[0]['file_type']).prop('disabled', false);
            $('#editfile_size').val(data[0]['file_size']).prop('disabled', false);


        } else {
            // show course  

            $('#editfileuploadModal.modal-title').text('Show File Details')
            $('#editfile_type').val(data[0]['file_type']).prop('disabled', true);
            $('#editfile_size').val(data[0]['file_size']).prop('disabled', true);
            $('#savebutton').hide();


        }

    }
});

}
</script>



@endsection