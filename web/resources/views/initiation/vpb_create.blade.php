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

    #tabs {
        overflow: hidden;
        width: 100%;
        margin: 0;
        padding: 0;
        list-style: none;
        font-size: 16px !important;
    }

    .nav-tabs .nav-item.show .nav-link,
    .nav-tabs .nav-link.active {
        background: #25867d !important;

    }

    .nav-tabs {
        padding: 5px !important;
    }

    #tabs li {
        float: left;
        margin: 0 .5em 0 0;
    }

    .questions {
        color: #34395e !important;
        font-weight: 700;
        font-size: 20px;
    }

    #tabs a {
        color: #000000 !important;
        position: relative;
        background: #d8ddd3;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        padding: .4em 1.5em;
        float: left;
        text-decoration: none;
        color: #444;
        text-shadow: 0 1px 0 rgba(255, 255, 255, .8);
        border-radius: 5px 0 0 0;
        box-shadow: 0 2px 2px rgba(0, 0, 0, .4);
    }

    #tabs a:hover,
    #tabs a:hover::after,
    #tabs a:focus,
    #tabs a:focus::after {
        background: #ffffff;
    }

    #tabs a:focus {
        outline: 0;
    }

    #tabs a::after {
        content: '';
        position: absolute;
        z-index: 1;
        top: 0;
        right: -.5em;
        bottom: 0;
        width: 1em;
        background: #d8ddd3;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        box-shadow: 2px 2px 2px rgba(0, 0, 0, .4);
        transform: skew(10deg);
        border-radius: 0 5px 0 0;
    }

    .nav-justified {
        background-image: none;
    }

    #tabs #addition-tab::after {
        content: '';
        position: absolute;
        z-index: 1;
        top: 0;
        right: -.5em;
        bottom: 0;
        width: 1em;
        background: #25867d;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        box-shadow: 2px 2px 2px rgba(0, 0, 0, .4);
        transform: skew(10deg);
        border-radius: 0 5px 0 0;
    }

    #tabs #current a,
    #tabs #current a::after {
        background: #25867d;
        z-index: 3;
        color: white !important;
    }

    .tabs {
        overflow: hidden;
        width: 100%;
        margin: 0;
        padding: 0;
        list-style: none;
        font-size: 16px !important;
    }

    .tabs li {
        float: left;
        margin: 0 .5em 0 0;
    }

    .questions {
        color: #34395e !important;
        font-weight: 700;
        font-size: 20px;
    }

    .tabs a {
        color: white !important;
        position: relative;
        background: #25867d;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        padding: .4em 1.5em;
        float: left;
        text-decoration: none;
        color: #444;
        text-shadow: 0 1px 0 rgba(255, 255, 255, .8);
        border-radius: 5px 0 0 0;
        box-shadow: 0 2px 2px rgba(0, 0, 0, .4);
    }

    .tabs a:hover,
    .tabs a:hover::after,
    .tabs a:focus,
    .tabs a:focus::after {
        background: #25867d !important;
    }

    .tabs a:focus {
        outline: 0;
    }

    .tabs a::after {
        content: '';
        position: absolute;
        z-index: 1;
        top: 0;
        right: -.5em;
        bottom: 0;
        width: 1em;
        background: #25867d;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        box-shadow: 2px 2px 2px rgba(0, 0, 0, .4);
        transform: skew(10deg);
        border-radius: 0 5px 0 0;
    }

    .nav-justified {
        background-image: none;
    }

    .tabs #addition-tab::after {
        content: '';
        position: absolute;
        z-index: 1;
        top: 0;
        right: -.5em;
        bottom: 0;
        width: 1em;
        background: #25867d;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        box-shadow: 2px 2px 2px rgba(0, 0, 0, .4);
        transform: skew(10deg);
        border-radius: 0 5px 0 0;
    }

    .tabs #current a,
    .tabs #current a::after {
        background: #25867d;
        z-index: 3;
        color: white !important;
    }
</style>
<link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css" rel="stylesheet">


<div class="main-content">

    {{ Breadcrumbs::render('vpb_create') }}


    <section class="section">


        <div class="tile" id="tile-1" style="margin-top:10px !important;">

            <!-- Nav tabs -->

            <ul class="nav nav-tabs nav-justified " id="tabs" role="tablist">

                <li class="nav-items navv" class="active" style="flex-basis: 1 !important;cursor:pointer;">
                    <a class="nav-link  " id="home-tab" name="tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-database" style="margin-right:5px"></i><b></b> Instruction Master<input type="checkbox" class="checkg" id="profile" name="nationality" readonly value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                        <div class="check"></div>
                    </a>

                </li>

                <li class="nav-items navv" class="active" style="flex-basis: 1 !important;cursor:pointer;">
                    <a class="nav-link  " id="home-tab" name="tab2" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-tasks"></i><b> Instruction Initiate</b> <input type="checkbox" class="checkg" id="profile" name="nationality" readonly value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                        <div class="check"></div>
                    </a>

                </li>





            </ul>
        </div>

        <div class="card">
            <div class="card-body" id="card_header">
                <div class="col-lg-12 text-center">

                    <h4>Create Instruction</h4>
                </div>
                <div id="content">
                    <div id="tab2">

                        <section class="section">
                            <div class="section-body mt-1">
                                <form action="{{ route('instruction.store') }}" method="post">
                                    @csrf
                                    <!-- <input type="hidden" class="form-control" required id="user_id" name="user_id" readonly value=""> -->
                                    <input type="hidden" class="form-control" required id="user_details" name="user_details" readonly value="general">
                                    <input type="hidden" name="type" id="type" value="1">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label"> Task Name <span style="color: red;font-size: 16px;">*</span></label>
                                                <input class="form-control" type="text" id="task_name" name="task_name" placeholder="Enter Task Name" autocomplete="off">
                                            </div>
                                        </div>
                                        @if(session('role_name')=='gtstake')
                                        <input type="hidden" name="processType" value="government">
                                        <div class="col-md-6 valuer_name" id="valuer">
                                            <div class="form-group">
                                                <label class="control-label"> Assigned to<span style="color: red;font-size: 16px;">*</span></label>
                                                <!-- <button type="button" class="btn control-label" style="background-color:#25867d !important;color:white !important;" onclick="GetvaluerName()">Select Firm</button> -->

                                                <select class="form-control" type="text" id="valuer_name" name="valuer_name" placeholder="Select Valuer Name" autocomplete="off">

                                                    <option value="0">Select Chief Government Valuer</option>
                                                    @foreach($rows['cgv_users'] as $key=>$row)

                                                    <option value="{{ $row['id'] }}">{{$row['name']}}</option>

                                                    @endforeach

                                                </select>

                                            </div>
                                        </div>
                                        @else
                                        <input type="hidden" name="processType" value="private">

                                        <div class="col-md-6 valuer_name" id="valuer">
                                            <div class="form-group">
                                                <label class="control-label"> Select Valuer<span style="color: red;font-size: 16px;">*</span><span style="color: black;font-size: 16px;">OR</span></label>
                                                <button type="button" class="btn control-label" style="background-color:#25867d !important;color:white !important;" onclick="GetvaluerName()">Select Firm</button>

                                                <select class="form-control" type="text" id="valuer_name" name="valuer_name" placeholder="Select Valuer Name" autocomplete="off">

                                                    <option value="0">Select Valuer</option>
                                                    @foreach($rows['valuer'] as $key=>$row)

                                                    <option value="{{ $row['id'] }}">{{$row['name']}}</option>

                                                    @endforeach

                                                </select>

                                            </div>
                                        </div>
                                        @endif




                                        <div class="col-md-6 d-none valuer_name" id="firm_name">
                                            <div class="form-group">
                                                <label class="control-label"> Select Firm Name <span style="color: red;font-size: 16px;">* OR</span></label>
                                                <button type="button" class="btn control-label" style="background-color:#25867d !important;;color:#ffffff !important;" onclick="GetFirmName()">Select Valuer</button>

                                                <select class="form-control" type="text" id="firm_name" name="valuer_name" placeholder="Select Firm Name" autocomplete="off">

                                                    <option value="0">Select Firm Name</option>
                                                    @foreach($rows['firm'] as $key=>$row)

                                                    <option value="{{ $row['user_id'] }}">{{$row['firm_name']}}</option>

                                                    @endforeach



                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Select Instruction <span style="color: red;font-size: 16px;">*</span></label>
                                                <select class="form-control" type="text" id="instruction_name" name="instruction_name" placeholder="Select Instruction Name" autocomplete="off">
                                                    <option value="0">Select Instruction</option>
                                                    @foreach($rows['instruction'] as $key=>$row)

                                                    <option value="{{ $row['instruction_id'] }}">{{$row['instruction_name']}}</option>

                                                    @endforeach

                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label"> Description</label>
                                                <textarea class="form-control" id="description" name="description" placeholder="Enter Description" cols="10" rows="10" autocomplete="off"></textarea>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-6" style="margin-top:4%;">
                                            <button type="button" class="btn" style="background-color:#2b9780 !important;color:white;" onclick="GetChilddetails()">ADD</button>
                                        </div> -->
                                        <div class="col-12">

                                        </div>
                                        <div class="col-md-12" style="text-align:center">
                                            <a class="btn btn-labeled btn-info" href="{{ url()->previous() }}" id="backBtn" title="next" style="background: red !important; border-color:red !important; color:white !important; margin-top:0px !important;">
                                                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>
                                            <a onclick="save()" class="btn btn-success">Submit</a>
                                            <button type="button" class="btn" style="background-color:#cfc222 !important;color:white;" onclick="GetChilddetails()">Add the instruction</button>
                                        </div>



                                    </div>
                                </form>

                            </div>
                        </section>
                    </div>
                    <div id="tab1">

                        <section class="section">
                            <a type="button" href="" value="" class="btn btn-labeled btn-success" title="Initiate" style="border-color:#a9ca !important; color:white !important;margin: 0 0 2px 15px;margin-left:87%" data-toggle="modal" data-target="#addModal">
                                <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">create</span></a>
                            <div class="section-body mt-1">

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

                                <div class="card">
                                    <div class="card-body" id="card_header">
                                        <div class="table-wrapper">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="align">
                                                    <thead>
                                                        <tr>
                                                            <th>Sl. No.</th>
                                                            <th>Instruction Name</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @foreach($rows['instruction'] as $data)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$data['instruction_name']}}</td>
                                                            <td>
                                                                <a title="Show" btn_type="show_modal" value="{{$data['instruction_id']}}" id="stake_show" class="btn btn-link" data-toggle="modal" data-target="#editModal" onclick="data(event)"><i class="fas fa-eye" style="color:green; pointer-events:none"></i></a>
                                                                <a title="Edit" btn_type="edit_modal" value="{{$data['instruction_id']}}" id="stake_edit" class="btn btn-link" data-toggle="modal" data-target="#editModal" onclick="data(event)"><i class="fas fa-pencil-alt" style="color: blue !important;pointer-events:none"></i></a>
                                                                <a title="Delete" class="btn btn-link" href="{{route('stakeholder.delete',($data['instruction_id']))}}" onclick="confirmDelete(event);"><i class="far fa-trash-alt" style="color:red;pointer-events:nonex"></i></a>
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
                        </section>
                    </div>
                </div>
            </div>

        </div>
        <div class="table-wrapper" id="inst_scroll">
            <table class="table table-bordered d-none" id="table_list">
                <thead>
                    <tr>
                        <th>Sl. No.</th>
                        <th>Instruction Name</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="instruction_table">


                </tbody>
            </table>
        </div>


    </section>
    <div class="d-none" id="input_value">

    </div>
</div>

<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-lg">


        <div class="modal-content" style="margin-left:10%; margin-top:10%">



            <form action="{{ route('stakeholder.store') }}" method="post" id="instruct" class="reset">
                {{ csrf_field() }}
                <div class="modal-header mh">
                    <h4 class="modal-title">Create </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <input name="stakeholder_id" type="hidden" value="">
                <div class="section-body mt-1">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Instruction Name <span style="color: red;font-size: 16px;">*</span></label>
                                <input class="form-control" type="text" id="Instruction_name" name="Instruction_name" placeholder="Enter Instruction Name" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label"> Description <span style="color: red;font-size: 16px;">*</span></label>
                                <textarea class="form-control custom_desc" id="description" name="description" placeholder="Enter Description" autocomplete="off"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="text-align:center;margin-bottom:2%">
                        <a class="btn btn-success btn-space" type="button" onclick="instcrea()" id="savedetails">Submit</a>
                        <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">

                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="editModal">
    <div class="modal-dialog modal-lg">


        <div class="modal-content" style="margin-left:10%; margin-top:10%">




            <div class="modal-header mh">
                <h4 class="modal-title">Instruction</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <input name="stakeholder_id" type="hidden" value="" id="edit_instruction">

            <div class="section-body mt-1">
                <form action="" id="form_data" method="GET">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Instruction Name <span style="color: red;font-size: 16px;">*</span></label>
                                <input class="form-control" type="text" id="Instruction_name_edit" name="Instruction_name" placeholder="Enter Instruction Name" value="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label"> Description <span style="color: red;font-size: 16px;">*</span></label>
                                <textarea class="form-control" id="description_edit" name="description" value=""></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" value="" id="instruction_id_edit" name="instruction_id">
                    <div class="col-md-12" style="text-align:center;margin-bottom:2%">
                        <button type="submit" id="edit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>


        </div>
    </div>
</div>



<script>
    $(document).ready(function() {

        $(document).on('hidden.bs.modal', function()

            {
                console.log($(this).find('form'))
                $(this).find('form.reset')[0].reset();
            });
    });






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
                    // alert('ef');
                    $('#Instruction_name_edit').remove('disabled', true);
                    $('#description_edit').remove('disabled', true);
                    $('#edit').text('Update')
                    $('#form_data').attr('Action', '{{route("stakeholder.update")}}');

                }




            }
        })

    }


    $(document).ready(function() {

        let url = new URL(window.location.href)
        let message = url.searchParams.get("message");
        if (message != null) {
            window.history.pushState("object or string", "Title", "/gtapprove");

            swal({
                title: "Success",
                text: "Rejected Successfully",
                type: "success",
            });
        }

    })
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
    function number_realignment() {

        const table_ids = document.querySelectorAll('#instruction_table tr');
        var num = 1;
        for (const table_id of table_ids) {
            table_id.firstChild.innerText = num;
            num = num + 1;

        }
    }
    var i = 1;

    function GetChilddetails() {


        var task_name = $('#task_name').val();

        if (task_name == '') {
            swal.fire("Please Enter Task Name:", "", "error");
            return false;
        }

        // var valuer_name = $('#valuer_name').val();
        // var firm_name = $('#firm_name').val();

        // if (valuer_name == '0' ) {
        //     swal.fire("Please select the Valuer Name:", "", "error");
        //     return false;
        // }
        var instruction_name = $('#instruction_name').val();

        if (instruction_name == '0') {
            swal.fire("Please select the Instruction Name:", "", "error");
            return false;
        }



        var id = instruction_name;
        $.ajax({
            url: "{{ url('/stakeholder/show') }}",
            type: 'GET',
            data: {
                'id': id,
                _token: '{{csrf_token()}}'

            },

            success: function(data) {
                // console.log(data[0].instruction_name);
                var instruction_name = data[0].instruction_name;
                var description = data[0].description;
                var instruction_id = data[0].instruction_id;
                const total_values_exist_validations = document.querySelectorAll('.table_values');
                for (const total_values_exist_validation of total_values_exist_validations) {
                    if (total_values_exist_validation.id == `instruction${instruction_id}`) {
                        Swal.fire("Info!", "Instruction already Exit!", "info") //already exit
                        return false;

                    }
                }

                $('#instruction_table').append('<tr><td></td><td>' + instruction_name + '</td><td> ' + description + '</td><td> <i class="fa fa-trash" value=' + instruction_id + ' style="color:#2b9780;cursor:pointer;" aria-hidden="true"></i></td> </tr>');
                var input = `<input type="hidden" class="table_values" id="instruction${instruction_id}" value="${instruction_id}">`;
                $('#input_value').append(input);
                $('#instruction_table').on('click', '.fa-trash', function(e) {
                    $(this).closest('tr').remove(); // Remove the row containing the trash icon
                    var instruction_value = e.target.getAttribute('value');
                    $(`#instruction${instruction_value}`).remove();
                    swal.fire("Success", "Instruction Removed Successfully", "success");
                    number_realignment();


                });
                number_realignment();
                document.getElementById('table_list').classList.remove('d-none');
                // i = i++;

                Swal.fire("Success!", "Instruction added successfully", "success");
                document.querySelector("#inst_scroll").scrollIntoView();


            }
        })
    };

    let totalid = [];
    var totalid_index = 0;

    function save() {




        var description = $('#description').val();

        var type = $('#type').val();
        Swal.fire({
            title: 'Are you sure?',
            text: "you want to create this Instruction",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Submit it!'
        }).then((result) => {
            console.log(result);
            if (result.isConfirmed) {
                const totalvalues = $('.table_values');
                for (const totalvalue of totalvalues) {
                    totalid[totalid_index] = {
                        'instruction_id': totalvalue.value
                    };
                    totalid_index = totalid_index + 1;

                }
                console.log(totalid);
                var task_name = $('#task_name').val();
                var process_type = $('input[name="processType"]').val();

                const total_values_validation = document.querySelectorAll('.table_values');

                if (total_values_validation.length == 0) {
                    Swal.fire("Please select the Instruction", "", "error"); //please slect the any instruction
                    return false;
                }
                //for both firm and valuers
                if (process_type != 'government') {
                    var valuer_names = $('.valuer_name');
                    for (const valuer_name of valuer_names) {
                        console.log(valuer_name);
                        if (!$(valuer_name).hasClass('d-none')) {
                            var valuer_name_new = valuer_name.children[0].children[2].value;
                        }

                    }

                } else {
                    var valuer_name_new = $('#valuer_name').val();
                }
                $.ajax({
                    url: "{{ url('/instruction/store') }}",
                    type: 'GET',
                    data: {

                        'task_name': task_name,
                        'valuer_name': valuer_name_new,
                        'description': description,
                        'process_type': process_type,
                        'type': type,
                        'totalid': totalid,
                        _token: '{{csrf_token()}}'

                    },
                    beforeSend: function() {
                        // This function will be called before the request is sent
                        showLoader();
                    },
                    success: function(data) {
                        hideLoader();
                        Swal.fire("Success!", "Submitted Successfully", "success").then((result) => {
                            if (process_type == "government") {
                                location.replace(`/instruction`);
                            } else {
                                location.replace(`/initiation`);
                            }


                        })

                    },
                    error: function() {
                        hideLoader();
                        Swal.fire("info!", "Something went wrong", "info").then((result) => {})

                    }
                })

            }
        });



    }
</script>



<script>
    function confirmDelete(event) {
        event.preventDefault(); // Prevent the default behavior of the link

        Swal.fire({
            title: "Confirmation For Delete ?",
            text: "Are You Sure to delete this data.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes',
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: false
        }).then((result) => {
            if (result.isConfirmed) {
                const href = event.target.getAttribute('href');
                window.location.href = href; // Redirect to the delete URL
            }
        });
    }
</script>

<script>
    function GetvaluerName() {
        document.getElementById('firm_name').classList.remove('d-none');
        document.getElementById('valuer').classList.add('d-none');
        document.querySelector('#type').value = '2';


    }

    function GetFirmName() {
        document.getElementById('valuer').classList.remove('d-none');
        document.getElementById('firm_name').classList.add('d-none');
        document.querySelector('#type').value = '1';



    }
</script>


<script>
    function instcrea() {
        var instruct = $("#Instruction_name").val();
        if (instruct == '') {
            swal.fire("Please Enter the Instruction", "", "error");
            return false;
        }
        var describe = $(".custom_desc").val();
        if (describe == '') {
            swal.fire("Please Enter the Description", "", "error");
            return false;
        }
        document.getElementById('instruct').submit();

    }
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<!-- Include jQuery -->

<!-- Include Bootstrap JS -->

<!-- Include Bootstrap Select JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

<!-- Include Bootstrap Select CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

<script>
    $(document).ready(function() {
        $('.selectpicker').selectpicker();
    });
</script>




@endsection