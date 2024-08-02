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

    .remove1 {
        height: 40px !important;
    }
</style>
<div class="container_fluid ">

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
    @elseif(session('fail'))

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
    <div class="main-content">

        {{ Breadcrumbs::render('accept/reject_data') }}
        <section class="section">

            <div class="col-lg-12 text-center">

                <h4> Instruction View </h4>
            </div>



            <div class="card">
                <div class="card-body" id="card_header">
                    <div id="content">
                        <div id="tab1">

                            <div class="col-lg-12 text-center">

                                <h4>Task Header</h4>
                            </div>
                            <section class="section">
                                <div class="section-body mt-1">

                                    <form action="" method="post">
                                        @csrf


                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label"> Task Name </label>
                                                    <input class="form-control" type="text" id="task_name" name="task_name" value="{{$rows['instruction'][0]['task_name']}}" Readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label"> Description </label>
                                                    <input class="form-control" type="text" id="task_name" name="task_name" value="{{$rows['instruction'][0]['inst_description']}}" Readonly>
                                                </div>
                                            </div>


                                        </div>
                                    </form>

                                </div>
                            </section>
                        </div>

                    </div>
                </div>

            </div>

            <div class="card" style="margin-top:3%">
                <div class="card-body" id="card_header">
                    <div class="col-lg-12 text-center">

                        <h4> Task Details </h4>
                    </div>
                    <div class="table-wrapper">
                        <div class="table-responsive">
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
                                    @foreach($rows['instruction'] as $data)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$data['instruction_name']}}</td>
                                        <td>{{$data['description']}}</td>
                                        @if($data['status'] == 0 || $data['status'] == 1)
                                        <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending</span></td>
                                        @elseif($data['status'] == 2)
                                        <td style="color:white;"><span class="badge2 success rounded-pill text-bg-danger">Completed</span></td>
                                        @elseif($data['status'] == 3)
                                        <td style="color:white;"><span class="badge2 success rounded-pill text-bg-danger">Approved</span></td>
                                        @else
                                        <td style="color:white;"><span class="badge2 danger rounded-pill text-bg-warning">Rejected</span></td>
                                        @endif
                                        @if($data['status'] == 0)
                                        <td>-</td>
                                        @elseif($data['status'] == 1)
                                        <td><button data-toggle="modal" instruction="{{$data['instruction_name']}}" instruction_id="{{$data['insruction_id']}}" task_id="{{$data['id']}}" description="{{$data['description']}}" data-target="#Editmodal" style="border: none;" onclick="edit(event)"><i class="fas fa-pencil-alt" style="color: blue !important;border: none;pointer-events:none;"></i></button></td>
                                        @else($data['status'] == 2)
                                        <td><button data-toggle="modal" data-target="#showmodal" onclick="Getshow(<?php echo $data['valuer_id'] ?>,<?php echo $data['insruction_id'] ?>)" style="border: none;"><i class="fas fa-eye" style="color:green"></i></button></td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>



                        </div>
                    </div>

                    @if($rows['instruction'][0]['cgv_comment'] !=null)
                    <div class="col-md-12 form-group">
                        <div id="" style="margin: 20px;">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="form-label" for="textAreaExample">Rejected Response From CGV</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row d-flex align-items-center">
                                        <span><b>CGV-</b></span>
                                        <span> {!! $rows['instruction'][0]['cgv_comment'] !!}</span>
                                        <span> 2023-03-23 17:21:4</span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($rows['instruction'][0]['status']==0)
                    <div style="text-align:center">
                        <a type="btn" class="btn btn-danger" href="{{ url()->previous() }}" style="background: red !important; border-color:red !important; color:white !important;">Back</a>
                        <button type="btn" id="approve" class="btn btn-success" onclick="GetChilddetails()">Accept</button>
                        <button type="btn" id="reject" class="btn btn-danger" onclick="reject(<?php echo $data['stakeholder_id'] ?> )">Reject</button>

                    </div>
                    @endif
                    @if($rows['instruction'][0]['stakeholder_comment'] != null)

                    <input type="hidden" name="valuer_id" value="{{$data['valuer_id']}}">
                    @if($data['status'] == 3)
                    @php $stakeholder_comment=explode("'",$rows['instruction'][0]['stakeholder_comment'] ); $valuer_comment=explode("'",$rows['instruction'][0]['valuer_comment'] );$registar_comment=explode("'",$rows['instruction'][0]['registar_comment'] );@endphp

                    <div class="col-md-12 form-group">
                        <div id="" style="margin: 20px;">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="form-label" for="textAreaExample">Previous Feedback</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row d-flex align-items-center">
                                        <span><b>Stakeholder-</b></span>
                                        <span> {!! $stakeholder_comment[0] !!}</span>
                                    </div>
                                    <span> {{$stakeholder_comment[1]}}</span>
                                    @if($rows['instruction'][0]['valuer_comment'] != null)

                                    <div class="row d-flex align-items-center">
                                        <span><b>valuer-</b></span>
                                        <span> {!! $valuer_comment[0] !!}</span>
                                    </div>
                                    <span> {{$valuer_comment[1]}}</span>
                                    @endif
                                    @if($rows['instruction'][0]['registar_comment'] != null)
                                    <div class="row d-flex align-items-center">
                                        <span><b>registar</b></span>
                                        <span> {!! $registar_comment[0] !!}</span>
                                    </div>
                                    <span> {{$registar_comment[1]}}</span>
                                    @endif



                                </div>
                            </div>
                        </div>
                    </div>




                </div>
            </div>

            @endif


            @endif









            <form action="{{route('valuer_feedback')}}" method="post">
                @csrf
                <input type="hidden" name="valuer_id" value="{{$data['valuer_id']}}">
                @if($data['status'] == 3 && $data['stakeholder_comment'] != null && $data['valuer_comment'] == null )
                <div class="col-md-12 form-group">
                    <div id="previousnotes" style="margin: 20px;">
                        <div id="editor"></div>
                        <div class="form-group scroll_flow_class" style="display: contents;">

                            <div class="form-outline">
                                <div class="card-header" style="display:block">
                                    <label class="form-label" for="textAreaExample" style="font-size: 23px;font-weight:bold;">Valuer Feedback</label>
                                    <textarea name="valuer_feedback" style="color:white" class="form-control" id="cgvapprove" name="graduate_trainee" rows="6"></textarea>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div style="text-align:center" class="mb-4">
                    <a type="button" class="btn btn-labeled btn-info" href="{{ url()->previous() }}" title="next" style="background: red !important; border-color:red !important; color:white !important;">
                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>
                    <button type="submit" id="submit" class="btn btn-success">Submit</button>
                </div>

                @endif
            </form>
            <!-- @if($rows['instruction'][0]['status']!=0)
            <div class="d-flex justify-content-center">
                <a type="button" class="btn btn-labeled btn-info" href="{{ url()->previous() }}" title="next" style="background: red !important; border-color:red !important; color:white !important; margin-top:15px !important;">
                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>
            </div>
            @endif -->

    </div>
</div>
</section>
</div>

<div class="modal fade" id="Editmodal">
    <div class="modal-dialog modal-lg">


        <div class="modal-content" style="margin-left:10%; margin-top:10%">

            <form action="{{route('instrucion.edit')}}" method="post" class="reset" enctype="multipart/form-data" id="submit_swal">
                {{ csrf_field() }}
                <input type="hidden" name="stakeholder_id" value="{{$data['stakeholder_id']}}">
                <input type="hidden" name="id" id="ins_id">
                @if($data['cgv_approval']==3)
                <input type="hidden" name="action" value="cgv_approval">
                @else
                <input type="hidden" name="action" value="stake_holder_process">
                @endif


                <div class="modal-header mh">
                    <h4 class="modal-title">Instruction</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>



                <div class="section-body mt-1">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Instruction Name</label>
                                <input class="form-control" type="text" id="Instruction_name" name="Instruction_name" disabled value="" autocomplete="off">
                            </div>
                        </div>



                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Description</label>

                                <input class="form-control" type="text" id="description" name="description" value="" disabled autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">File <span style="color: red;font-size: 16px;">*</span></label>
                                <span style="color: rgb(246, 15, 15); display: block;margin: 5px 0px 0px 0px;">*Pdf & Png format Only</span>
                                <div class="multi-field-wrapper">
                                    <div class="multi-fields">

                                        <div class="multi-field" style="display: flex;margin-bottom: 5px;  gap:7px;">


                                            <input class="form-control fileupload" type="file" id="file" name="sample[]" value="" accept=".pdf, .png" autocomplete="off">
                                            <button class="remove-field btn btn-danger pull-right remove1" id="remove-f" type='button'>X </button>


                                            &nbsp;

                                        </div>
                                    </div>
                                    <button type="button" class="add-field btn btn-success">Add</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <div id="previousnotes" style="margin: 20px;">
                                <div id="editor"></div>
                                <div class="form-group scroll_flow_class" style="display: contents;">

                                    <div class="form-outline">
                                        <div class="card-header">
                                            <label class="form-label" for="textAreaExample" style="font-size: 23px;">Instruction Notes <span style="color: red;font-size: 16px;">*</span></label>
                                            <textarea name="valuer_comments" style="color:white" class="form-control cgv_approve" id="cgvapprove" name="graduate_trainee" rows="6"></textarea>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                    <input type="hidden" value="" id="instruction_id_edit" name="instruction_id">
                    <div class="col-md-12" style="text-align:center;margin-bottom:2%">

                        <a onclick="valuer_edit()" id="edit" class="btn btn-success">Submit</a>
                    </div>

                </div>

            </form>
        </div>

    </div>
</div>
<div class="modal fade" id="showmodal">
    <div class="modal-dialog modal-lg">


        <div class="modal-content" style="margin-left:10%; margin-top:10%">

            <form>

                <input type="hidden" name="id" id="ins_id">

                <div class="modal-header mh">
                    <h4 class="modal-title">Instruction</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" readonly>&times;</button>
                </div>



                <div class="section-body mt-1">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Instruction Name <span style="color: red;font-size: 16px;">*</span></label>
                                <input class="form-control" type="text" id="Instruction_name_show" name="Instruction_name" value="" autocomplete="off" readonly>
                            </div>
                        </div>



                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"> Description <span style="color: red;font-size: 16px;">*</span></label>
                                <input class="form-control" type="text" id="description_show" name="description" value="" autocomplete="off" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">File <span style="color: red;font-size: 16px;">*</span></label>
                                <div class="multi-field-wrapper">
                                    <div class="multi-fields">

                                        <div class="multi-field" style="margin-bottom: 5px;">

                                            <div style="display:flex">
                                                <input class="form-control" type="text" id="file_name_show" name="sample[]" value="" autocomplete="off" readonly>
                                                <a class="btn btn-link" title="Show" id="file_show" href="" target="_blank"><i class="fa fa-eye" style="color:green"></i></a>


                                            </div>

                                            &nbsp;
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">

                            <label class="form-label" style="font-size: 23px;">Instruction Notes</label>
                            <div class="form-outline">
                                <div class="card-header">

                                    <div class="form-group scroll_flow_class">
                                        <span id="valuer_comments_show"> </span>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                    <div style="text-align:center; padding-bottom:1%">
                        <button type="button" data-dismiss="modal" aria-hidden="true" readonly="" class="btn btn-labeled btn-info back" title="back" style="background: red !important; border-color:red !important; color:white !important; margin-top:15px !important;">
                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</button>
                    </div>

                    <input type="hidden" value="" id="instruction_id_edit" name="instruction_id">


                </div>

            </form>


        </div>

    </div>
</div>

<script>
    $(document).ready(function() {

        $("#content").find("[id^='tab']").hide(); // Hide all content
        $("#tabs li:first").addClass("active"); // Activate the first tab
        $("#tab1").fadeIn(); // Show first tab's content



        $('#tabs a').click(function(e) {

            e.preventDefault();
            if ($(this).closest("li").attr("id") == "current") { //detection for current tab

                return;
            } else {

                $("#content").find("[id^='tab']").hide(); // Hide all content
                $("#tabs li").removeClass("active"); //Reset id's
                $(this).parent().addClass("active"); // Activate this
                $('#' + $(this).attr('name')).fadeIn(); // Show content for the current tab


            }
        });


    });

    function data(e) {

        var id = e.target.getAttribute('value');
        var btn_type = e.target.getAttribute('btn_type');


        $.ajax({
            url: "{{ url('/stakeholder/show') }}",
            type: 'GET',
            data: {
                'id': id,
                _token: '{{csrf_token()}}'

            },

            success: function(data) {
                console.log(data[0].instruction_name);
                var instruction_name = data[0].instruction_name;
                var description = data[0].description;
                var instruction_id = data[0].instruction_id;
                $('#Instruction_name_edit').val(instruction_name);
                $('#description_edit').val(description);
                $('#instruction_id_edit').val(instruction_id);
                if (btn_type == "show_modal") {
                    $('#Instruction_name_edit').prop('disabled', true);

                    $('#description_edit').prop('disabled', true);
                    $('#edit').text('cancel')
                    $('#form_data').attr('Action', ' ');

                } else {
                    $('#edit').text('Update')
                    $('#form_data').attr('Action', '{{route("stakeholder.update")}}');

                }




            }
        })

    }
</script>

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>

<script type="application/javascript">
    function myFunction(id) {
        swal.fire({
                title: "Confirmation For Delete ?",
                text: "Are You Sure to delete this data.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {

                if (isConfirm) {
                    swal.fire("Deleted!", "Data Deleted successfully!", "success");
                    var url = $('#' + id).val();
                    window.location.href = url;
                } else {
                    swal.fire("Cancelled", "Your Data is safe :)", "error");
                    e.preventDefault();
                }
            });
    }
</script>
<script>
    var i = 1;

    function GetChilddetails() {

        Swal.fire({

            title: "Are you want to Accept",
            text: "Please click yes,If you want to Accept the following instruction.",
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
            if (result.value) {

                $.ajax({
                    url: "{{ url('/instruction/approve') }}",
                    type: 'GET',
                    data: {
                        _token: '{{csrf_token()}}'

                    },
                    beforeSend: function() {
                        showLoader();
                    },

                    success: function(data) {
                        hideLoader();
                        Swal.fire("success!", 'Task accepted successfully!', 'success').then((result) => {

                            location.replace(`/Instruction/Process`);

                        })


                    }
                })


            }
        })
    };
    //VALUER REJECT

    function reject(id) {

        Swal.fire({

            title: "Are you want to Reject",
            text: "Please click yes,If you want to reject the instruction.",
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
            if (result.value) {
                $.ajax({
                    url: "{{ url('/instruction/reject/store') }}",
                    type: 'GET',
                    data: {
                        id: id,
                        _token: '{{csrf_token()}}',
                        action: 'valuer'
                    },
                    beforeSend: function() {
                        showLoader();
                    },

                    success: function(data) {
                        hideLoader();
                        Swal.fire("success!", "Rejected the instruction successfully!", "success"

                        ).then((result) => {

                            location.replace(`/Instruction/Process`);

                        })
                    }
                })
            }
        })

    };

    $('.multi-field-wrapper').each(function() {

        var $wrapper = $('.multi-fields', this);
        console.log($wrapper);


        $(".add-field", $(this)).click(function(e) {

            $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();
            $('#file_field').append('<div class="multi-field" style="display: flex;margin-bottom: 5px; margin-top: 2rem"><input class="form-control" type="file" id="file" name="file[]" value="" autocomplete="off"></div>');
        });

        $('.multi-field .remove-field', $wrapper).click(function() {
            if ($('.multi-field', $wrapper).length > 1)
                $(this).parent('.multi-field').remove();

            else swal.fire("info", "Cannot be Removed, atleast one file upload is needed", "info");


        });
    });
</script>
<script>
    $(document).ready(function() {

        tinymce.init({
            selector: 'textarea#cgvapprove',
            height: 180,
            menubar: 'table',
            branding: false,
            plugins: 'table',
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help' + 'table tabledelete | tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
        // event.preventDefault()
    });

    function edit(e) {
        var instruction_name = e.target.getAttribute('instruction');
        var task_id = e.target.getAttribute('task_id');
        var instruction_id = e.target.getAttribute('instruction_id');
        var description = e.target.getAttribute('description');

        $('#Instruction_name').val(instruction_name);
        $('#description').val(description);
        $('#ins_id').val(task_id);
        $('#instruction_id_edit').val(instruction_id);

    }
</script>



<script>
    function valuer_edit() {
        const fileupload = document.querySelector('.fileupload');
        if (fileupload.value == '') {
            swal.fire("Please Upload the File", "", "error");
            return false;
        }
        // Get the TinyMCE editor instance
        var editor = tinymce.get(document.querySelector('.cgv_approve').id);
        // Check if the editor instance and its content exist
        if (editor && editor.getContent().trim() === '') {
            swal.fire("Please Fill the Instruction Notes", "", "error");
            return false;
        } else {
            Swal.fire({

                title: "Are you want to Submit",
                text: "Please click yes,If you want to submit the instruction.",
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
                    document.getElementById('submit_swal').submit();
                }
            })
        }
    }
</script>




<script>
    $(document).ready(function() {

        $(document).on('hidden.bs.modal', function()

            {
                console.log($(this).find('form'))
                $(this).find('form.reset')[0].reset();
            });
    });


    function decodeEntities(encodedString) {
        var textArea = document.createElement('textarea');
        textArea.innerHTML = encodedString;
        return textArea.value;
    }

    function Getshow(id, i_id) {

        $.ajax({
            url: "{{ url('/instruction/data/show') }}",
            type: 'GET',
            data: {
                _token: '{{csrf_token()}}',
                id: id,
                initiation_id: i_id

            },
            success: function(response) {

                var data = response.Data.show;
                var data_length = Object.keys(data).length;

                var instruction_name = data[0].instruction_name;

                var description = data[0].description;
                var file_name = data[0].file_name;
                var file_path = data[0].file_path;
                var valuer_comments = data[0].valuer_comments.replace(/<\/?p>/g, '');
                const decodedContent = decodeURIComponent(valuer_comments);
                $('#Instruction_name_show').val(instruction_name);
                $('#description_show').val(description);
                $('#valuer_comments_show').text(valuer_comments);
                for (let index = 0; index < data_length; index++) {
                    if (index == 0) {

                        $('#file_name_show').val(data[index].file_name);
                        $('#file_show').attr('href', `${file_path}/${file_name}`);

                    } else {
                        $('.multi-field').append(`<div style="display:flex"><input class="form-control" type="text" id="file_show" name="sample[]" value="${data[index].file_name}" autocomplete="off"><a class="btn btn-link" title="show" target="_blank" href="${file_path}/${file_name}"><i class="fas fa-eye" style="color:green"></i></a></div>`);

                    }

                }

            }

        })

    }
    var modal = document.getElementById("showmodal");

    // add an event listener to the modal
    $('#showmodal').on('hidden.bs.modal', function(e) {
        // reset the form elements in the modal
        var form = modal.querySelector("form");
        form.reset();
    })
</script>

@endsection