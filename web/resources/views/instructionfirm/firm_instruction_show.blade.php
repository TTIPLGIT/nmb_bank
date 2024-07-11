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

    #reject {
        color: white;
    }
</style>
<!-- for with out reject -->

<div class="main-content">
    {{ Breadcrumbs::render('firm_instruction_show', $rows[0]['id'], $rows[0]['type']) }}

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
                                <!-- <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label"> Firm Name </label>
                                            <select class="form-control" type="text" id="firm_name" name="valuer_name" placeholder="Select Firm Name" autocomplete="off" disabled>
                                                <option value="0">Select Firm Name</option>
                                                @foreach($firms as $key=>$row2)
                                                @if($rows[0]['valuer_id']==$row2['user_id'])
                                                <option value="{{ $row2['user_id'] }}" selected>{{$row2['firm_name']}}</option>
                                                @endif
                                                @endforeach

                                            </select>

                                        </div>
                                    </div>


                                </div> -->

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
                    <div class="col-lg-12 text-center">

                        <h4> Task Details </h4>
                    </div>

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
                                    @elseif($data['status'] == 2 ||$data['status'] == 5 )
                                    <td style="color:white;"><span class="badge2 success rounded-pill text-bg-danger">Completed</span></td>

                                    @elseif($data['status'] == 3)
                                    <td style="color:white;"><span class="badge2 success rounded-pill text-bg-danger">Approved</span></td>
                                    @else
                                    <td style="color:white;"><span class="badge2 danger rounded-pill text-bg-warning">Rejected</span></td>
                                    @endif
                                    @if($data['status'] == 0 || $data['status'] == 1)
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
                @if($data['stakeholder_comment'] != null)

                <input type="hidden" name="valuer_id" value="{{$data['valuer_id']}}">
                @if($data['status'] == 3)
                @php $stakeholder_comment=explode("'",$rows[0]['stakeholder_comment'] ); $valuer_comment=explode("'",$rows[0]['valuer_comment'] );@endphp

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
                                @if($data['valuer_comment'] != null)

                                <div class="row d-flex align-items-center">
                                    <span><b>Firm feedback-</b></span>
                                    <span> {!! $valuer_comment[0] !!}</span>
                                </div>
                                <span> {{$valuer_comment[1]}}</span>
                                @endif



                            </div>
                        </div>
                    </div>



                </div>
                <!-- <div style="text-align:center;margin-bottom:1%">
                    <a type="button" class="btn btn-labeled btn-info" href="{{ url()->previous() }}" title="next" style="background: red !important; border-color:red !important; color:white !important; margin-top:15px !important;">
                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>
                </div> -->
            </div>

            @endif


            @endif


            <form action="{{route('firm_submit')}}" method="post">
                @csrf
                <input type="hidden" name="valuer_id" value="{{$data['valuer_id']}}">
                <input type="hidden" name="stakeholder_id" value="{{$data['stakeholder_id']}}">
                @if($data['status'] == 2)

                @if($type==2)
                                        <!-- <div style="text-align:center">
                        <a type="button" class="btn btn-labeled btn-info mr-3" href="{{ url()->previous() }}" title="next" style="background: red !important; border-color:red !important; color:white !important;">
                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>
                    </div> -->

                <div style="text-align:center">
                    <a type="btn" href="{{ url()->previous() }}" id="back" title="next" class="btn btn-warning">Back</a>
                    <button type="submit" id="complete" class="btn btn-success">Submit</button>
                    <a type="btn" id="reject" style="color:white" onclick="reject(<?php echo $data['valuer_id'] ?> )" class="btn btn-danger d-none">Reject</a>
                </div>
                @endif
                @endif

            </form>
            @if($data['status'] == 2 && $data['stakeholder_comment'] != null && $data['valuer_comment'] == null && $data['cgv_approval'] == 2 )
            <form action="{{route('valuer_feedback')}}" method="post">
                @csrf
                <input type="hidden" name="valuer_id" value="{{$data['valuer_id']}}">
                @if($data['status'] == 2 && $data['stakeholder_comment'] != null && $data['valuer_comment'] == null )
                <div class="col-md-12 form-group">
                    <div id="previousnotes" style="margin: 20px;">
                        <div id="editor"></div>
                        <div class="form-group scroll_flow_class" style="display: contents;">

                            <div class="form-outline">
                                <div class="card-header" style="display:block">
                                    <label class="form-label" for="textAreaExample" style="font-size: 23px;font-weight:bold;">Firm Feedback</label>
                                    <textarea name="valuer_feedback" style="color:white" class="form-control" id="cgvapprove" name="graduate_trainee" rows="6"></textarea>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div style="text-align:center" class="mb-4">
                    <a type="button" class="btn btn-labeled btn-info mr-3" href="{{ url()->previous() }}" title="next" style="background: red !important; border-color:red !important; color:white !important;">
                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>
                    <button type="submit" id="submit" class="btn btn-success">Submit</button>
                </div>

                @endif
            </form>

            @endif

            <!-- @if($data['stakeholder_comment'] != null)
                @php $stakeholder_comment=explode("'",$rows[0]['stakeholder_comment'] ); $valuer_comment=explode("'",$rows[0]['valuer_comment'] );@endphp

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
                                @if($data['valuer_comment'] != null)

                                <div class="row d-flex align-items-center">
                                    <span><b>valuer-</b></span>
                                    <span> {!! $valuer_comment[0] !!}</span>
                                </div>
                                <span> {{$valuer_comment[1]}}</span>
                                @endif



                            </div>
                        </div>
                    </div>



                </div>
                @endif -->

            @if($data['status'] == 3 && $data['stakeholder_comment'] != null && $data['valuer_comment'] == null)
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
                                    <label class="form-label" for="textAreaExample" style="font-size: 23px;font-weight:bold;">Firm Feedback</label>
                                    <textarea name="valuer_feedback" style="color:white" class="form-control" id="cgvapprove" name="graduate_trainee" rows="6"></textarea>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div style="text-align:center" class="mb-4">
                    <a type="button" class="btn btn-labeled btn-info mr-3" href="{{ url()->previous() }}" title="next" style="background: red !important; border-color:red !important; color:white !important;">
                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>
                    <button type="submit" id="submit" class="btn btn-success">Submit</button>
                </div>

                @endif
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
                                            <a class="btn btn-link" title="Show" id="file_show" href="" target="_blank"><i class="fa fa-eye" style="color:green"></i></a>

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
                                    <span id="valuer_comments_show"></span>
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
                var valuer_comments = data[0].valuer_comments.replace(/<\/?p>/g, '');

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
                        action: 'firm'

                    },

                    success: function(data) {
                        Swal.fire("success!", "Rejected the instruction successfully!", "success"

                        ).then((result) => {

                            location.replace(`/Instruction/Process`);

                        })
                    }
                })
            } else {}
        })

    };

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