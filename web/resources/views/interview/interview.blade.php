@extends('layouts.adminnav')

@section('content')
<style>
    input[type=checkbox] {
        display: inline-block;
    }

    .no-arrow {
        -moz-appearance: textfield;
    }

    .no-arrow::-webkit-inner-spin-button {
        display: none;
    }

    .no-arrow::-webkit-outer-spin-button,
    .no-arrow::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .nav-tabs {
        background-color: #0068a7 !important;
        border-radius: 29px !important;
        padding: 1px !important;

    }

    .nav-item.active {
        background-image: linear-gradient(to right, #2a675a, #2a675a, #2a675a, #2a675a, #2a675a);
        border-radius: 31px !important;
        height: 100% !important;
    }

    .nav-link.active {
        background-image: linear-gradient(to right, #2a675a, #2a675a, #2a675a, #2a675a, #2a675a);
        border-radius: 31px !important;
        height: 100% !important;
    }

    :root {
        --borderWidth: 5px;
        --height: 24px;
        --width: 12px;
        --borderColor: #78b13f;
    }




    .nav-justified {
        display: flex !important;
        align-items: center !important;
    }

    .gender {
        display: flex;
        align-items: center;
        justify-content: space-evenly;
    }

    .egc {
        display: flex;
        border: 1px solid #350756;
        padding: 8px 25px 8px 8px;
        align-items: center;

        justify-content: space-between;
    }

    .dq {
        font-size: 16px;
        width: 80%;
        font-weight: 600;
    }

    .answer {
        width: 15%;
        display: flex;
        color: #04092e !important;
        justify-content: space-around;
    }

    .questions {
        color: #000c62 !important
    }

    input[type='radio']:checked:after {
        background-color: #34395e !important;
    }

    input[type='radio']:after {
        background-color: #34395e !important;
    }

    /* radiocss */
    .switch-field {
        display: flex;


    }

    .switch-field input {
        position: absolute !important;
        clip: rect(0, 0, 0, 0);
        height: 1px;
        width: 1px;
        border: 0;
        overflow: hidden;
    }

    .switch-field label {
        background-color: #e4e4e4;
        color: rgba(0, 0, 0, 0.6);
        font-size: 14px;
        line-height: 1;
        text-align: center;
        padding: 8px 16px;
        margin-right: -1px;
        border: 1px solid rgba(0, 0, 0, 0.2);
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
        transition: all 0.1s ease-in-out;
    }

    .switch-field label:hover {
        cursor: pointer;
    }

    .switch-field input:checked+label {
        background-color: #a5dc86;
        box-shadow: none;
    }

    .switch-field label:first-of-type {
        border-radius: 4px 0 0 4px;
    }

    .switch-field label:last-of-type {
        border-radius: 0 4px 4px 0;
    }

    /* endcss */
    .vl {
        border-left: 1px solid #350756;
        height: 40px;
    }

    .close {
        color: red;
        opacity: 1;
    }

    .close:hover {

        color: red;

    }

    .note {
        background-image: linear-gradient(to right, #3f9a9d, #3f9a9d, #3f9a9d, #3f9a9d, #3f9a9d);
    }
</style>


<style>
    #counselorerroredit {
        color: red;
    }

    #supervisorerroredit {
        color: red;
    }
</style>
<div class="main-content main_contentspace">
    <div class="row justify-content-center">

        @if (session('success'))
        <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
        <script type="text/javascript">
            window.onload = function() {
                var message = $('#session_data').val();
                Swal.fire({
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
        {{ Breadcrumbs::render('interview_process') }}

            <form method="POST" id="interview_form" enctype="multipart/form-data" onsubmit="return false">
                @csrf
                <div id="interview">
                    <section class="section">
                        <div class="section-body mt-0">
                            <div class="row">
                                <div class="col-12">
                                    <a type="button" style="font-size:15px;" class="btn btn-success btn-lg mb-2" title="Create" id="eligcb" data-toggle="modal" data-target="#interviewmodal">Schedule interview<i class="fa fa-plus" aria-hidden="true"></i></a>
                                    <div class="card mt-0">
                                        <div class="card-body">
                                            <div class="table-wrapper">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="align">
                                                        <thead>
                                                            <tr>
                                                                <th>Sl.No</th>
                                                                <th>GT Name</th>
                                                                <th>Schedule date</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($rows as $row)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{$row['name']}}</td>
                                                                <td>{{$row['scheduled_date']}}</td>
                                                                @if($row['status']==0)
                                                                <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-warning waitingbadge">Scheduled</span></td>
                                                                @endif
                                                                @if($row['status']==1)
                                                                <td style="color:white;"><span class="badge2 success rounded-pill text-bg-success">Selected</span></td>
                                                                @endif
                                                                @if($row['status']==2)
                                                                <td style="color:white;"><span class="badge2 danger rounded-pill text-bg-warning">Rejected</span></td>
                                                                @endif
                                                                @if($row['status']==3)
                                                                <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-warning waitingbadge">Hold</span></td>
                                                                @endif
                                                                <td class="button_id">

                                                                    @if($row['scheduled_date'] == date('d-m-Y') && $row['status']==0 || $row['scheduled_date'] == date('d-m-Y') && $row['status']==3 )
                                                                    <a class="btn btn-info" title="Edit" onclick="approveorreject(event,{{$row['user_id']}})" value="{{$row['name']}}" gt_id="{{$row['user_id']}}">Approve/Reject</a>

                                                                    @endif
                                                                    @if($row['status'] !=0)
                                                                    <a type="button" onclick="fetch_update({{$row['user_id']}}, 'show')" style="font-size:15px;" class="btn btn btn btn-link" title="View Comments" id="eligview" data-toggle="modal" data-target="#interviewshowwmodal"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                                    @elseif($row['status'] ==0 || $row['status']==3)
                                                                    <a type="button" onclick="" style="font-size:15px;" class="btn btn btn btn-link d-none" title="View Comments" id="eligview" data-toggle="modal" data-target=""><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                                    <a type="button" onclick="fetch_update({{$row['user_id']}}, 'edit')" style="font-size:15px;" class="btn btn btn btn-link" title="Reshedule Interview" id="eligcb" data-toggle="modal" data-target="#intervieupdatewmodal"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                                    <a class="btn btn-link" title="Delete Interview" onclick="Deletedata({{$row['user_id']}})"><i class="fa fa-trash" style="color: red;" aria-hidden="true"></i></a>
                                                                    @elseif($row['status'] ==1 || $row['status'] ==2)
                                                                    <a type="button" onclick="" style="font-size:15px;" class="btn btn btn btn-link d-none" title="View Comments" id="eligview" data-toggle="modal" data-target=""><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                                    <a type="button" onclick="fetch_update({{$row['user_id']}}, 'edit')" style="font-size:15px;" class="btn btn btn btn-link d-none" title="Reshedule Interview" id="eligcb" data-toggle="modal" data-target="#intervieupdatewmodal"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                                    @endif
                                                                    <!-- <a type="button" onclick="fetch_update({{$row['user_id']}}, 'edit')" style="font-size:15px;" class="btn btn btn btn-link" title="Reshedule Interview" id="eligcb" data-toggle="modal" data-target="#intervieupdatewmodal"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                                    <a class="btn btn-link" title="Delete Interview" onclick="Deletedata({{$row['user_id']}})"><i class="fa fa-trash" style="color: red;" aria-hidden="true"></i></a> -->
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
            </form>
        </div>
    </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function() {
        $('#interview_form').on('hidden.bs.modal', function()

            {
                $(this).find('form')[0].reset();
            });
    });



    function fetch_update(id, type) {

        $.ajax({
            url: "{{ url('/interview/fetch') }}",
            type: 'GET',
            data: {
                'id': id,
                'type': type,
                _token: '{{csrf_token()}}'

            },

            success: function(data) {
                console.log(data);
                if (type == "edit") {
                    $('#gt_id_updated').val(data.rows[0]['user_id']);
                    $('#gt_id_updated2').val(data.rows[0]['user_id']);
                    $('#gt_id_updated').prop('disabled', true);
                    $('#date_updated').val(data.rows[0]['scheduled_date']);
                    $('#address_updated').val(data.rows[0]['address']);


                } else if (type == "show") {
                    $('#comments_show').val(data.rows[0]['comments']);

                    $('#show').val(data.rows[0]['id']);

                    $('#comments_show').prop('disabled', true);
                    $('#show').attr('Action', '');


                }

            }
        });

    }

    function approveorreject(e, id) {

        Swal.fire({
            title: 'Please make your selection',
            html: '<div class="row"><div class="col-12 mb-4 text-justify"><label for="gt_name" class="form-label">GT Name</label><input class="form-control" name="gt_name" id="gt_name" disabled></div><div class="col"><textarea class="form-control" style="height: 120px !Important;" id="comment" placeholder="Enter your comments here..." required></textarea></div></div>',
            showCancelButton: true,
            showConfirmButton: true,
            confirmButtonText: 'Select',
            confirmButtonClass: 'btn btn-success',
            cancelButtonText: 'Hold',
            cancelButtonClass: 'btn btn-warning',
            rejectButton: true,
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn mx-2',
                cancelButton: 'btn mx-2',
                rejectButton: 'btn mx-2 btn-danger'
            },
            focusConfirm: false,
            showCloseButton: true,
            preConfirm: () => {
                const comment = document.getElementById('comment').value.trim();
                if (!comment) {
                    Swal.showValidationMessage('Please enter a comment');
                }
                return {
                    comment: comment
                };
            },
        }).then((result) => {
            if (result.isConfirmed) {
                const data = result.value;
                var comments = document.getElementById('comment').value;
                updatedata(id, 1, comments)

            } else if (result.isDenied) {
                var comments = document.getElementById('comment').value;

                updatedata(id, 2, comments)


            } else if (result.dismiss === Swal.DismissReason.cancel) {
                var comments = document.getElementById('comment').value;

                updatedata(id, 3, comments)

            }
        });
        var gt_name = e.target.getAttribute('value');
        var gt_id = e.target.getAttribute('gt_id');
        var gt_comments = e.target.getAttribute('id');

        $('#gt_name').val(gt_name);
        $('#comment').val(gt_comments);

        // add custom reject button
        const rejectButton = Swal.getActions().appendChild(document.createElement('button'));
        rejectButton.setAttribute('type', 'button');
        rejectButton.setAttribute('aria-label', 'Reject');
        rejectButton.classList.add('rejectButton');
        rejectButton.classList.add('btn');
        rejectButton.classList.add('btn-danger');
        rejectButton.innerText = 'Reject';

        // handle reject button click
        rejectButton.addEventListener('click', () => {
            Swal.close({
                isDenied: true
            });
        });

    }

    function updatedata(id, status, comments) {
        $.ajax({

            url: "{{ url('/interview/update_new') }}",
            type: 'GET',
            data: {
                'id': id,
                'status': status,
                'comments': comments,
                _token: '{{csrf_token()}}'

            },

            success: function(data) {


                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: "Interview Details Updated Sucessfully.",
                    confirmButtonText: 'OK'
                }).then(function()

                    {
                        // document.getElementById('eligview').classList.remove('d-none');


                        location.reload();

                    })


            }
        });

    }
</script>
<!-- create module -->
<div class="modal fade" id="interviewmodal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {{ csrf_field() }}
            <div class="modal-header mh">
                <h4 class="modal-title">Add Schedule Name</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" style="background-color: #f8fffb !important;">
                <form action="{{route('interview_store')}}" method="post" id="interview_process">
                    <input type="hidden" class="form-control" id="user_id" name="user_id" value="">
                    <input type="hidden" class="form-control" id="user_details" name="user_details" value="general">
                    <div class="row">

                        @csrf
                        <div class="col-md-6">
                            <div class="form-group">
                                <label> Graduate Trainee Name<span class="error-star" style="color:red;">*</span></label>
                                <select class="form-control default" id="gt_id" name="gt_id">
                                    <option value="">--Select--</option>
                                    @foreach($rows2 as $row)
                                    <option value="{{$row['user_id']}}">{{$row['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group datepicker">
                                <label>Date<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default clear_text dob" id="date" name="date">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Address<span class="error-star" style="color:red;">*</span></label>
                                <textarea id="address" name="address" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <a class="btn btn-success btn-space form_submit_handle" type="submit" onclick="interview_validation()" id="savebutton">Submit</a>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- edit module -->
<div class="modal fade" id="intervieupdatewmodal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {{ csrf_field() }}
            <div class="modal-header mh">
                <h4 class="modal-title">Edit Schedule</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" style="background-color: #f8fffb !important;">
                <form action="{{route('interview_update')}}" method="post">
                    <input type="hidden" class="form-control" id="gt_id_updated2" name="gt_id_updated" value="">
                    <input type="hidden" class="form-control" id="user_details" name="user_details" value="general">
                    <div class="row">

                        @csrf
                        <div class="col-md-6">
                            <div class="form-group">
                                <label> Graduate Trainee Name</label>
                                <select class="form-control default" id="gt_id_updated" name="gt_id_updated" value="">
                                    <option value="">--Select--</option>
                                    @foreach($rows2 as $row)
                                    <option value="{{$row['user_id']}}">{{$row['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group datepicker">
                                <label>Date<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default clear_text dob" id="date_updated" name="date_updated">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Address<span class="error-star" style="color:red;">*</span></label>
                                <textarea id="address_updated" name="address_updated" class="form-control"></textarea>
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
</div>

<!-- Show module -->
<div class="modal fade" id="interviewshowwmodal">
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


<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    function interview_validation() {
        var date = $("#date").val();
        if (date == '') {
            swal.fire("Please Enter the Date", "", "error")
            return false;
        }

        var addr = $("#address").val();
        if (addr == '') {
            swal.fire("Please Enter the Address", "", "error")
            return false;
        } else {
            preventSubmitButton('form_submit_handle');
            document.getElementById('interview_process').submit();
        }
    }
</script>


<script>
    $(document).ready(function() {
        $('#interviewmodal').on('hidden.bs.modal', function()

            {
                $(this).find('form')[0].reset();
            });
    });


    var $j = jQuery.noConflict();
    $j(function() {
        $j('.dob').datepicker({
            dateFormat: 'dd-mm-yy',

            changeMonth: true,
            changeYear: true,
            yearRange: '2023:2040',
            showOn: "button",
            buttonImage: "/images/calendar.png",
            class: "dateimage",
            buttonImageOnly: true,
            maxDate: '+17Y',
            minDate: 0,
            inline: true
        });
        $('.ui-datepicker-trigger').css({
            'width': '5%',
            'position': 'absolute',
            'top': '39px',
            'right': '22px'
        });






    });
</script>

<script>
    function Deletedata(user_id) {

        Swal.fire({
            title: "Are you Sure,you want to Delete the Interview Schedule Data?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Delete",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('/gt_interview_delete') }}",
                    type: 'GET',
                    data: {
                        'user_id': user_id,
                        _token: '{{csrf_token()}}'

                    },


                    success: function(data) {
                        console.log(data);
                        //exit();
                        if (data['data'] == 0) {
                            Swal.fire("Info!", data['message_cus'], "info", data['message_cus'])
                            return false
                        }

                        if (result.value) {
                            Swal.fire("Success!", data['message_cus'], "success").then((result) => {

                                location.replace(``);

                            })
                        }



                    }
                });
            }
        })




    }
</script>




@endsection