@extends('layouts.adminnav')
@section('content')
<div class="main-content">
    {{ Breadcrumbs::render('instruction.appointment', '1') }}
    <section class="section">
        <div class="col-lg-12 text-center">
            <h4>Instruction Appointment</h4>
        </div>
        <div class="card m-2">
            <div class="card-header h4 font-weight-bold">
                Task Header
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label"> Task Name </label>
                            <input class="form-control" type="text" id="taskName" name="taskName" value="{{$rows['instructionHeaders']['task_name']}}" Readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label"> Stakeholder</label>
                            <input class="form-control" type="text" id="taskDescription" name="taskDescription" value="{{$rows['instructionHeaders']['name']}}" Readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label"> Description </label>
                            <textarea class="form-control" type="text" id="taskDescription" name="taskDescription" Readonly>{{$rows['instructionHeaders']['task_description']}}</textarea>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="card m-2">
            <div class="card-header h4 font-weight-bold">
                Task Details
            </div>
            <div class="card-body">
                <div class="table-wrapper">
                    <div class="table-responsive">
                        @if(isset($rows['instructionDetails']) && $rows['instructionDetails'][0]['file_name'] =='')
                        <table class="table table-bordered" id="align">
                            <thead>
                                <tr>
                                    <th>S. No</th>
                                    <th>Instruction Name</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rows['instructionDetails'] as $row)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$row['instruction_name']}}</td>
                                    <td>{{$row['description']}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <table class="table table-bordered" id="align">
                            <thead>
                                <tr>
                                    <th>S. No</th>
                                    <th>Instruction Name</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rows['instructionDetails'] as $row)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$row['instruction_name']}}</td>
                                    <td>{{$row['description']}}</td>
                                    @if($row['status']=="1")
                                    <td class="text-white aligned-row"><span class="badge2 success rounded-pill text-bg-warning downward status_check">Pending<i class="fa fa-level-up" aria-hidden="true"></i></span></td>
                                    @elseif($row['status']=="0")
                                    <td sclass="text-white aligned-row"><span class="badge2 warning rounded-pill text-bg-success status_check">Saved</span></td>
                                    @elseif($row['status']=="2")
                                    <td sclass="text-white aligned-row"><span class="badge2 warning rounded-pill text-bg-success status_check">Submitted</span></td>
                                    @elseif($row['status']=="3")
                                    <td class="text-white aligned-row"><span class="badge2 danger rounded-pill text-bg-warning downward status_check">Approved<i class="fa fa-level-up" aria-hidden="true"></i></span></td>
                                    @elseif($row['status']=="4")
                                    <td class="text-white aligned-row"><span class="badge2 danger rounded-pill text-bg-warning downward status_check">Rejected<i class="fa fa-level-up" aria-hidden="true"></i></span></td>
                                    @endif
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center"><a type="button" data-id="{{$row['id']}}" class="taskDetailFetch" class="taskDetailFetch" title="View" class="btn btn-link"><i class="fas fa-eye pointer-events-none" style="color: blue !important"></i></a></div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="card m-2">
            <div class="card-header h4 font-weight-bold">
                Previous Reponses
            </div>
            <div class="card-body">
                <div class="table-wrapper">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="align1">
                            <thead>
                                <tr>
                                    <th>S. No</th>
                                    <th>Comments</th>
                                    <th>Given By</th>
                                    <th>Responded at</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rows['comments'] as $comment)
                                @php
                                $date = Carbon\Carbon::parse($comment['respondedAt']);
                                $formattedDate = $date->format('Y-m-d H:i:s');
                                @endphp
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$comment['comments']}}</td>
                                    <td>{{$comment['givenBy']}}</td>
                                    <td>{{$formattedDate}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Assigned to:<span class="error-star" style="color:red;">*</span></label>
                <select class="form-control" name="assignedTo" id="assignedTo">

                    <option selected value="{{$rows['assignedTo']['id']}}">{{$rows['assignedTo']['name']}}</option>

                </select>
            </div>
        </div>
        @if($alter_name->role_designation == 'CGV')
        <div class="col-md-4">
            <div class="form-group m-2">
                <label>Status:<span class="error-star" style="color:red;">*</span></label>
                <select class="form-control" name="cgvStatus" id="cgvStatus">
                    <option value="">Select Status</option>
                    <option value="approve">Approve</option>
                    <option value="defer">Defer</option>
                    <option value="reject">Reject</option>

                </select>
            </div>
        </div>
        @endif

        @if($type =='edit')
        <div class="form-group m-2">
            <label class="control-label">Comments</label>
            <textarea class="form-control" rows="10" type="text" id="comments" name="comments" placeholder="Enter the Comments" value=""></textarea>
        </div>
        @endif

        <input type="hidden" name="government_task_id" id="government_task_id" value="{{$row['government_task_id']}}">

        <div class="row align-items-center mb-2">
            <div class="col d-flex justify-content-center align-items-center">
                <a type="button" class="btn btn-labeled btn-info back_button mr-3" href="/instruction" title="next">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back
                </a>
                @if($alter_name->role_designation == 'CGV')
                @if($type =='edit')
                <a id="cgvApprove" class="btn btn-labeled btn-info approve_button" title="Update">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-up"></i></span>Update
                </a>

                @endif
                @else
                @if($type =='edit')
                <a id="upwardApproval" class="btn btn-labeled btn-info approve_button" title="Update">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-up"></i></span>Approve
                </a>
                @endif
                @endif
            </div>
        </div>
    </section>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
<script>
    $(document).on('click', '#upwardApproval', function() {
        const assignedTo = $('#assignedTo').val();
        const government_task_id = $('#government_task_id').val();
        const comments = $('#comments').val();
        Swal.fire({
            title: 'Are you sure?',
            text: "you want submit all the Instructions",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Submit it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('/instruction/upwardapproval')}}",
                    type: "POST",
                    dataType: "json",
                    async: false,
                    data: {
                        government_task_id: government_task_id,
                        assignedTo: assignedTo,
                        comments: comments
                    },
                    success: function(data) {
                        if (data) {
                            Swal.fire("Success!", data.message, "success").then((result) => {
                                window.location.href = '/instruction';
                            });
                        } else {
                            swal.fire(data.message, "", "error");

                        }
                    }
                });

            }
        })
    });


    $(document).on('click', '#cgvApprove', function() {
        const assignedTo = $('#assignedTo').val();
        const government_task_id = $('#government_task_id').val();
        const comments = $('#comments').val();
        const status = $('#cgvStatus').val();

        if (status == '') {
            swal.fire("Please select the Status", "", "error");
            return false;
        }

        if(status == "reject"){
            swal.fire("Something went wrong, Please try again later", "", "error");
            return false;
        }

        if (comments == '') {
            swal.fire("Please Enter the Comments", "", "error");
            return false;
        }

        $.ajax({
            url: "/instruction/cgvApproval",
            type: 'post',
            data: {
                government_task_id: government_task_id,
                assignedTo: assignedTo,
                comments: comments,
                status: status
            },
            error: function() {},
            success: function(data) {
                if (data) {
                    Swal.fire("Success!", data.message, "success").then((result) => {
                        window.location.href = '/instruction';
                    });
                } else {
                    swal.fire(data.message, "", "error");
                }

            }
        })

    });
</script>
@include('GovernmentInstruction.models.taskSubmission')
@include('Registration.formmodal')
<script>
    $(document).on('click', '.taskDetailFetch', function(e) {
        const instructionID = $(e.target).data('id');
        $.ajax({
            url: "{{ url('/instruction/getData')}}",
            type: "GET",
            dataType: "json",
            async: false,
            data: {
                id: instructionID,
            },
            success: function(data) {
                if (data != 500) {
                    $('.existingFileName').addClass('d-none');
                    $('.newFileName').removeClass('d-none');
                    $('.changeFile').hide();
                    $('#instructionNameModal').val(data.instructionData.instruction_name);
                    $('#instructionDescriptionModal').val(data.instructionData.description);
                    $('#taskIdModal').val(data.instructionData.government_task_id);
                    $('#instructionId').val(instructionID);
                    $('#instructionComments').val(data.instructionData.comments);
                    $('.formButton').text('Save');
                    $('#instructionFileUpload').prop("required", true);

                    if (data.instructionData.file_name != null) {
                        $('#instructionFileUpload').prop("required", false);
                        $('.existingFileName').removeClass('d-none');
                        $('.newFileName').addClass('d-none');
                        $('#fileName').text(data.instructionData.file_name);
                        const fileSource = '/' + data.instructionData.file_path + '/' + data.instructionData.file_name;
                        $('#fileView').data('file', fileSource);
                        $('.formButton').text('Update');
                        // $('.changeFile').show();
                    }
                    var is_view = $(e.target).attr('title');
                    console.log(is_view);
                    if (is_view == 'View') {
                        $('.approve_button:last').hide();
                    } else {
                        $('.approve_button:last').show();
                    }
                    $('#approvalSubmission').modal('show');

                } else {
                    console.log("something went wrong");
                }

            }
        });

    });

    const getproposaldocument = (id) => {
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
    $(document).on('click', '#fileView', function() {
        const fileName = $(this).data('file');
        getproposaldocument(fileName);
    })
</script>

@endsection