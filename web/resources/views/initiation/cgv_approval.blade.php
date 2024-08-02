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
<div class="main-content">
    <section class="section">

        <div class="col-lg-12 text-center">

            <h4> Instruction View </h4>
        </div>

        <div class="card">
            <div class="card-body" id="card_header">
                <div id="content">
                    <div id="tab1">

                        <section class="section">
                            <div class="section-body mt-1">




                                <!-- <input type="hidden" class="form-control" required id="user_id" name="user_id" readonly value=""> -->
                                <input type="hidden" class="form-control" required id="user_details" name="user_details" readonly value="general">
                                @if($rows[0]['type']==1 )
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"> Task Name </label>
                                            <input class="form-control" type="text" id="task_name" name="task_name" value="{{$rows[0]['task_name'] }}" Readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"> Description </label>
                                            <input class="form-control" type="text" id="task_name" name="task_name" value="{{$rows[0]['inst_description'] }}" Readonly>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"> Valuer Name </label>
                                            <input class="form-control" type="text" id="task_name" name="task_name" value="{{$rows[0]['name'] }}" Readonly>
                                        </div>
                                    </div>


                                </div>


                                @elseif($rows[0]['type']==2)
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"> Task Name </label>
                                            <input class="form-control" type="text" id="task_name" name="task_name" value="{{$rows[0]['task_name'] }}" Readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"> Description </label>
                                            <input class="form-control" type="text" id="task_name" name="task_name" value="{{$rows[0]['inst_description'] }}" Readonly>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"> Firm Name </label>
                                            <select class="form-control" type="text" id="firm_name" name="valuer_name" placeholder="Select Firm Name" autocomplete="off" disabled>
                                                <option value="0">Select Firm Name</option>
                                                @foreach($firms as $key=>$row2)
                                                @if($rows[0]['firm_id']==$row2['user_id'])
                                                <option value="{{ $row2['user_id'] }}" selected>{{$row2['firm_name']}}</option>
                                                @endif
                                                @endforeach

                                            </select>

                                        </div>
                                    </div>


                                </div>

                                @endif





                            </div>

                        </section>
                    </div>

                </div>
            </div>

        </div>


        <div class="card" style="margin-top:3%">
            <div class="card-body" id="card_header">
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

                                @foreach($instruction as $data)
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
                @if($data['cgv_approval'] ==1)
                <form action="{{route('approve_cgv')}}" method="GET">
                    @csrf
                    <input type="hidden" name="valuer_id" value="{{$data['valuer_id']}}">
                    <input type="hidden" name="stakeholder_id" value="{{$data['stakeholder_id']}}">
                   
                    <div id="reject_comment" class="d-none">
                        <label class="form-label" for="textAreaExample" style="font-size: 23px;">CGV - Reject comment</label>
                        <textarea name="cgv_comments" id="cgvapprove" cols="30" rows="10"></textarea>

                    </div>
                    <div style="text-align:center">
                        <a type="btn" href="{{ url()->previous() }}" id="back" class="btn btn-warning">Back</a>
                        <button type="submit" id="complete" onclick="" class="btn btn-success">Approve</button>
                        <a type="btn" id="reject" class="btn btn-danger" style="color:white" onclick="reject(<?php echo $data['valuer_id'] ?>, <?php echo $data['stakeholder_id'] ?>  )">Reject</a>

                    </div>
                </form>
                @endif







            </div>
        </div>

    </section>
</div>

<div class="modal fade" id="showmodal">
    <div class="modal-dialog modal-lg">


        <div class="modal-content" style="margin-left:10%; margin-top:10%">



            <input type="hidden" name="id" id="ins_id">

            <div class="modal-header mh">
                <h4 class="modal-title">Instruction</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>



            <div class="section-body mt-1">
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Instruction Name <span style="color: red;font-size: 16px;">*</span></label>
                            <input class="form-control" type="text" id="Instruction_name_show" name="Instruction_name" value="" autocomplete="off">
                        </div>
                    </div>



                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label"> Description <span style="color: red;font-size: 16px;">*</span></label>
                            <input class="form-control" type="text" id="description_show" name="description" value="" autocomplete="off">
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
                                            <input class="form-control" type="text" id="file_name_show" name="sample[]" value="" autocomplete="off">
                                            <a class="btn btn-primary" title="view Document" data-toggle="modal" data-target="#templates" onClick=""><i class="fa fa-eye" style="color:white!important"></i></a>

                                        </div>
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
                <div style="text-align:center;margin-bottom:1%">
                    <a type="button" class="btn btn-labeled btn-info" href="{{ url()->previous() }}" title="next" style="background: red !important; border-color:red !important; color:white !important; margin-top:15px !important;">
                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>
                </div>

                <input type="hidden" value="" id="instruction_id_edit" name="instruction_id">

            </div>


        </div>

    </div>
</div>
<script>
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
                var valuer_comments = decodeEntities(data[0].valuer_comments);
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
</script>
<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
<script>
    function reject(valuer_id, s_id) {
        const comment_box = document.querySelector('#reject_comment');
        
        if (comment_box.classList[0] == 'd-none') {
            comment_box.classList.remove('d-none');
            return false;
        }

        Swal.fire({

            title: "Are you want to Reject",
            text: "Please click yes,If you want to reject the the instruction.",
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
            var editor = tinymce.get('cgvapprove');
            var content = editor.getContent({format: 'text'});
            
            if (result.value) {
                $.ajax({
                    url: "{{ url('/stakeholder/reject/store') }}",
                    type: 'GET',
                    data: {
                        _token: '{{csrf_token()}}',
                        valuer_id: valuer_id,
                        stakeholder_id: s_id,
                        cgv_comment:content
                    },

                    success: function(data) {

                        Swal.fire("success!", "Reject the instruction Successfully!", "success"

                        ).then((result) => {

                            location.replace(`/cgv/approve`);

                        })
                    }
                })
            }
        })
    }
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
</script>
@endsection