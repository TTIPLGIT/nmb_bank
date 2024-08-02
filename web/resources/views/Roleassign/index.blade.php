@extends('layouts.adminnav')

@section('content')


<div class="main-content main_contentspace">
    <div class="row justify-content-center">
        @if (session('success'))
        <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
        <script type="text/javascript">
            window.onload = function() {
                var message = $('#session_data').val();
                swal.fire({
                    title: "success",
                    text: message,
                    icon: "success", // Add this line to set the success icon
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
                    icon: "success", // Add this line to set the success icon
                });


            }
        </script>
        @endif
        <div class="col-lg-12 col-md-12">
            <div class="" style="height:100%; padding: 15px">{{ Breadcrumbs::render('role.assign') }}

                <form method="POST" id="role_allocation" enctype="multipart/form-data">
                    @csrf

                    <section class="section">
                        <div class="section-body mt-0">
                            <div class="row">
                                <div class="col-12">
                                    <a type="button" style="font-size:15px;" class="btn btn-success btn-lg mb-2 mr-2" title="Create" id="" href="" data-toggle="modal" data-target="#roleassignmodal">Add Designation<i class="fa fa-plus" aria-hidden="true"></i></a>
                                    <div class="card mt-0">
                                        <div class="card-body">
                                            <div class="table-wrapper">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="align7">
                                                        <thead>
                                                            <tr>
                                                                <th>Sl.No</th>
                                                                <th>User Name</th>
                                                                <th>Designation</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($role_assign as $data)
                                                            <tr>
                                                                <td>{{$loop->iteration}}</td>
                                                                <td>{{$data->name}}</td>
                                                                <td>{{$data->role_designation}}</td>
                                                                <td>
                                                                    <a onclick="removeDesignation('{{$data->id}}')" class="btn btn-link" title="Remove"><i class="fas fa-trash" style="color: blue !important; pointer-events:none;"></i>Remove</a>
                                                                    <!-- <a class="btn btn-link" title="Show" href=""><i class="fas fa-eye" style="color: blue !important"></i></a> -->
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
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="roleassignmodal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" method="POST" id="create_form" class="" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="modal-header mh">
                    <h4 class="modal-title">Add Designtion</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">

                    <div class="row" id="proff_cont">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="proff_label" id="">Name:</label><span class="error-star" style="color:red;font-weight:800">*</span>
                                <select name="user_name" id="role_name" class="form-control">
                                    <option value="">Select Role</option>
                                    @foreach($role_designation as $row)

                                    <option id="{{ $row->id}}" value="{{ $row->id}}">{{ $row->name}}</option>

                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="proff_label" id="">Role Designation:</label><span class="error-star" style="color:red;font-weight:800">*</span>
                                <select name="role_designation" id="role_designation" class="form-control">
                                    <option value="">Select Role</option>
                                    <option value="CGV">Chief Government Valuer</option>
                                    <option value="AC">Assistant Commissioner</option>
                                    <option value="PGV">Principal Government Valuer</option>
                                    <option value="SGV">Senior Government Valuer</option>
                                    <option value="GV">Government Valuer</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <a typr="button" class="btn btn-success btn-space Designationassign" type="button" id="savebutton">Submit</a>
                        <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>


<script>
    $(document).on('click', '.Designationassign', function(e) {
        const role_name = $('#role_name').val();
        const role_designation = $('#role_designation').val();
        $.ajax({
            url: "{{ url('/role/update')}}",
            type: "GET",
            dataType: "json",
            async: false,
            data: {
                role_name: role_name,
                role_designation: role_designation,
            },
            success: function(data) {
                swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "Role Assigned Successfully",
                    type: "success",
                }).then(function() {    
                    location.reload();
                });

            },
            error: function(data) {
                swal.fire({
                    icon: "info",
                    title: "Info",
                    text: "This Role already Assigned",
                    type: "success",
                }).then(function() {
                    location.reload();
                });
            }
        });

    });
    const removeDesignation = (userID) => {
        swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to remove this designation',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('/designation/remove')}}",
                    type: "POST",
                    dataType: "json",
                    async: false,
                    data: {
                        userID: userID,
                    },
                    success: function(data) {
                        swal.fire({
                            icon: "success",
                            title: "Success",
                            text: "Designation has been Removed Successfully",
                        }).then(function() {
                            location.reload();
                        });
                    },
                    error: function(data) {
                        swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "Something went wrong",
                        });
                    }
                });
            }
        });
    };
</script>


@endsection