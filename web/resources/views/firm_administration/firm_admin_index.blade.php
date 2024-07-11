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

    .firm_admin {
        padding-bottom: 7px;
        padding: 0px;
        margin-bottom: 10px;
    }

    .button_design {

        accent-color: red !important;


    }

    .button_toggle {
        gap: 3px;
        display: flex;
        justify-content: flex-end;
    }
</style>


<style>
    .section {
        margin-top: 20px;
    }

    .color-fa i {
        color: red !important;
    }

    input[type="checkbox"]:disabled+.slider {
        background-color: lightgrey !important;
        color: #aaac !important;
    }

    .editpoint i {
        pointer-events: none !important;
    }
</style>

<div class="main-content">


    {{ Breadcrumbs::render('firm_admin_index') }}


    <section class="section">


        <div class="section-body mt-2">
            <div class="row">
                <div class="col-12">
                    <div class="row d-flex justify-content-end">
                        @if($modules['user_role'] == "professional member" && $rows['firm_admin'] !=[])

                        <a class="btn btn-danger mb-2" title="next" onclick="firm_leave()" id="leave_firm" style="color:white !important; margin-right: 90%;">Leave Firm</a>

                        @endif

                    </div>

                    @if($rows['firm_admin'] !=[])
                    <div class="row">
                        <div class="col-12 firm_admin">
                            <div class="card">

                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Firm Name</label>
                                                <input type="text" id="firm_name" name="firm_name" value="{{$rows['firm_admin'][0]['firm_name']}}" class="form-control" disabled autocomplete="off">
                                            </div>
                                        </div>


                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Firm Created at</label>
                                                <input type="text" id="create" name="create" value="{{$rows['firm_admin'][0]['created_at']}}" class="form-control" disabled autocomplete="off">
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea id="descript" name="descript" class="form-control" disabled autocomplete="off">{{$rows['firm_admin'][0]['description']}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endif



                    <div class="card">


                        <div class="card-body">

                            @if (session('success'))

                            <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
                            <script type="text/javascript">
                                window.onload = function() {
                                    var message = $('#session_data').val();
                                    swal.fire({
                                        title: "Success",
                                        text: message,
                                        type: "info",
                                        icon: "success"
                                    });

                                }
                            </script>
                            @elseif(session('error'))

                            <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
                            <script type="text/javascript">
                                window.onload = function() {
                                    var message = $('#session_data1').val();
                                    swal.fire({
                                        title: "Success",
                                        text: message,
                                        type: "info",
                                        icon: "success"
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
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Action</th>
                                                <th>Active Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                            @foreach($rows['firm_admin'] as $key=>$data)
                                            <tr>

                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$data['name']}}</td>
                                                <td>{{$data['email']}}</td>

                                                <td class="text-center">

                                                    @if(!isset($rows['firm_permission']))
                                                    <a class="btn btn-white editpoint" title="Edit Permission" onclick="function_firm(event);" data-toggle="modal" data-firmid="{{$data['firm_id']}}" data-partnerid="{{$data['partner_id']}}" data-target="#firm_admin_modal"><i class="fa fa-lock" aria-hidden="true"></i></a>
                                                    @else
                                                    @if($rows['firm_permission']==[])
                                                    <a class="btn btn-white editpoint" title="Edit Permission" onclick="permission_denied(event);" data-target="#firm_admin_modal"><i class="fa fa-lock" aria-hidden="true"></i></a>
                                                    @else
                                                    @foreach($rows['firm_permission'] as $row)
                                                    @if($row['give_permission'] =="on")
                                                    <a class="btn btn-white editpoint" title="Edit Permission" onclick="function_firm(event);" data-toggle="modal" data-firmid="{{$data['firm_id']}}" data-partnerid="{{$data['partner_id']}}" data-target="#firm_admin_modal"><i class="fa fa-lock" aria-hidden="true"></i></a>
                                                    @else
                                                    <a class="btn btn-white" title="Edit Permission" onclick="permission_denied(event);" data-firmid="{{$data['firm_id']}}" data-partnerid="{{$data['partner_id']}}" data-target="#firm_admin_modal"><i class="fa fa-lock" aria-hidden="true"></i></a>
                                                    @endif
                                                    @endforeach
                                                    @endif
                                                    @endif



                                                    @if(!isset($rows['firm_permission']))
                                                    <a class="btn btn-white color-fa" tittle="Delete" data-toggle="modal" onclick="functiontoggle(event);" data-toggle="modal" data-target=""><i class="fa fa-trash color-fa" aria-hidden="true"></i></a>

                                                    @else

                                                    @if($rows['firm_permission']==[])
                                                    <a class="btn btn-white color-fa" tittle="Delete" data-toggle="modal" onclick="permission_denied(event);" data-target=""><i class="fa fa-trash" aria-hidden="true"></i></a>

                                                    @else
                                                    @foreach($rows['firm_permission'] as $row)
                                                    @if($row['delete_permission'] =="on")
                                                    <a class="btn btn-white color-fa" tittle="Delete" data-toggle="modal" onclick="functiontoggle(event);" data-toggle="modal" data-target=""><i class="fa fa-trash color-fa" aria-hidden="true"></i></a>




                                                    @else
                                                    <a class="btn btn-white color-fa" tittle="Delete" data-toggle="modal" onclick="permission_denied(event);" data-target=""><i class="fa fa-trash" aria-hidden="true"></i></a>

                                                    @endif
                                                    @endforeach
                                                    @endif
                                                    @endif






                                                </td>


                                                <td style="text-align: center;">
                                                    @if(!isset($rows['firm_permission']))
                                                    <label class="switch " data-bs-toggle="tooltip" data-toggle="modal" data-bs-placement="top" title="Enable / Disable">
                                                        <input type="hidden" name="toggle_id" value="">
                                                        <input type="checkbox" onclick="functiontoggle(event);" id="{{$data['user_id']}}" class="toggle_status" <?php echo $data['active_flag'] == 0 ? 'checked' : ''; ?> name="is_active">
                                                        <span class="slider round"></span>

                                                    </label>
                                                    @else

                                                    @if($rows['firm_permission']==[])
                                                    <label class="switch " onclick="permission_denied(event)" data-toggle="modal" id="permission" data-bs-toggle="tooltip" data-bs-placement="top" title="Enable / Disable">
                                                        <input type="hidden" name="toggle_id" value="">
                                                        <input type="checkbox" disabled id="{{$data['user_id']}}" class="toggle_status" <?php echo $data['active_flag'] == 0 ? 'checked' : ''; ?> name="is_active">
                                                        <span class="slider round"></span>

                                                    </label>
                                                    @else
                                                    @foreach($rows['firm_permission'] as $row)
                                                    @if($row['active_permission'] =="on")
                                                    <label class="switch" data-bs-toggle="tooltip" data-toggle="modal" data-bs-placement="top" title="Enable / Disable">
                                                        <input type="hidden" name="toggle_id" value="">
                                                        <input type="checkbox" onclick="functiontoggle(event);" id="{{$data['user_id']}}" class="toggle_status" <?php echo $data['active_flag'] == 0 ? 'checked' : ''; ?> name="is_active">
                                                        <span class="slider round"></span>

                                                    </label>
                                                    @else
                                                    <label class="switch " onclick="permission_denied(event)" id="permission" data-bs-toggle="tooltip" data-bs-placement="top" title="Enable / Disable">
                                                        <input type="hidden" name="toggle_id" value="">
                                                        <input type="checkbox" disabled id="{{$data['user_id']}}" class="toggle_status" <?php echo $data['active_flag'] == 0 ? 'checked' : ''; ?> name="is_active">
                                                        <span class="slider round"></span>

                                                    </label>

                                                    @endif
                                                    @endforeach
                                                    @endif
                                                    @endif

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


<div class="modal fade" id="firm_admin_modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header mh">
                <h4 class="modal-title">User Permission</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body" style="background-color: #f8fffb !important;">
                <form action="{{route('permission_store')}}" method="post" enctype="multipart/form-data" id="firmedit">
                    <input type="hidden" id="permission_update_firm_id" name="firm_id">
                    <input type="hidden" id="permission_update_partner_id" name="partner_id">

                    <div class="row">

                        @csrf

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>User can Enable/Disable the Partners</label>
                            </div>
                        </div>

                        <div class="col-md-6 form-group button_toggle">

                            <label for="yes_third">No</label>

                            <label class="switch " data-bs-toggle="tooltip" data-bs-placement="top" title="Enable / Disable">
                                <input type="hidden" name="toggle_id" value="">

                                <input type="checkbox" id="active_permission" class="toggle_status toggle_permission" name="active_permission" value="off">
                                <span class="slider round"></span>
                            </label>

                            <label>Yes</label>
                        </div>
                    </div>




                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="yes">User Can Give Permission to the other Partners</label>
                            </div>
                        </div>
                        <div class="col-md-6 form-group button_toggle">

                            <label for="yes_second">No</label>

                            <label class="switch " data-bs-toggle="tooltip" data-bs-placement="top" title="Enable / Disable">
                                <input type="hidden" name="toggle_id" value="">

                                <input type="checkbox" id="give_permission" class="toggle_status toggle_permission" name="give_permission" value="off">
                                <span class="slider round"></span>
                            </label>


                            <label>Yes</label>
                        </div>
                    </div>


                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="yes">User Can Delete the Partners</label>
                            </div>
                        </div>
                        <div class="col-md-6 form-group button_toggle">

                            <label for="yes_third">No</label>

                            <label class="switch " data-bs-toggle="tooltip" data-bs-placement="top" title="Enable / Disable">
                                <input type="hidden" name="toggle_id" value="">

                                <input type="checkbox" id="delete_permission" class="toggle_status toggle_permission" name="delete_permission" value="off">
                                <span class="slider round"></span>
                            </label>

                            <label>Yes</label>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <button class="btn btn-success btn-space" type="submit" id="savebutton">Update</button>
                        </div>
                    </div>


            </div>
        </div>

        </form>
    </div>
</div>
</div>
</div>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>

<script>
    function myFunction(id) {

        swal.fire({
            title: "Confirmation For Delete ?",
            text: "Are You Sure to delete this data",
            icon: "warning",
            buttons: [
                'No, cancel it!',
                'Yes, I am sure!'
            ],
            dangerMode: true,
        }).then(function(isConfirm) {
            if (isConfirm) {
                var url = $('#' + id).val();
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
    $(document).on('click', '.toggle_permission', function(e) {
        if ($(e.target).prop('checked') == true) {
            e.target.value = "on";

        } else {
            e.target.value = "off";


        }


    })


    function permission_denied(e) {
        swal.fire("You don't have permission to do this operation! Kindly contact the admin", "", "warning");
    }

    function functiontoggle(e) {


        var id = e.target.id;
        if (e.target.checked == true) {
            var active_flag = 0;
        } else {
            var active_flag = 1;
        }



        $.ajax({
            url: "{{ route('active_update') }}",
            type: 'POST',
            data: {
                id: id,
                active_flag: active_flag,
                _token: '{{csrf_token()}}'
            },
            error: function() {
                alert('Something is wrong');
            },
            success: function(data) {
                console.log(data);
                var data_convert = $.parseJSON(data);

                console.log(data_convert.Data);
                if (data_convert.Data == 1) {
                    swal.fire({
                        icon: 'success',
                        title: "Success",
                        text: "User Deactivated",
                        type: "success"
                    }, );
                } else {
                    swal.fire({
                        icon: 'success',
                        title: "Success",
                        text: "User Activated",
                        type: "success"
                    }, );
                }

            }


        });
    }

    function function_firm(e) {
        $('#permission_update_firm_id').val($(e.target).data("firmid"));
        $('#permission_update_partner_id').val($(e.target).data("partnerid"));

        var id = $(e.target).data("partnerid");

        $.ajax({
            url: "{{ url('/firm_admin/fetch') }}",
            type: 'GET',
            data: {
                'id': id,
                _token: '{{csrf_token()}}'

            },

            success: function(data) {
                ('eegef');
                $('#firmedit')[0].reset();
                console.log('data');

                console.log(data);
                if (data.rows[0].active_permission == "on") {
                    $('#active_permission').trigger("click");
                }
                if (data.rows[0].give_permission == "on") {
                    $('#give_permission').trigger("click");
                }
                if (data.rows[0].delete_permission == "on") {
                    $('#delete_permission').trigger("click");
                }
                // console.log(data.rows[0]['']);
                // $('#gt_id_updated').val(data.rows[0]['user_id']);
                // $('#gt_id_updated2').val(data.rows[0]['user_id']);
                // $('#gt_id_updated').prop('disabled', true);
                // $('#date_updated').val(data.rows[0]['scheduled_date']);
                // $('#address_updated').val(data.rows[0]['address']);

            }
        });

    }


    function firm_leave() {


        Swal.fire({

            title: "Are you want to Leave the Firm",
            text: "Please click yes,If you want to Leave the Firm.",
            icon: "warning",
            customClass: 'swalalerttext',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: true,
            showLoaderOnConfirm: true,
            width: '550px',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({

                    url: "{{ url('/firm_admin/leave') }}",
                    type: 'GET',
                    data: {
                        _token: '{{csrf_token()}}'

                    },
                    success: function(data) {

                        Swal.fire("success!", "Relieved from the Firm Successfully!", "success"

                        ).then((result) => {
                            location.reload();



                        })
                    }

                })


            }





        });


    }
</script>




@endsection