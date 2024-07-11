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

    #tabs a:hover,
    #tabs a:hover::after,
    #tabs a:focus,
    #tabs a:focus::after {
        background: #25867d;
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
        background: #25867d;
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



<div class="main-content">

    {{ Breadcrumbs::render('vpb_create') }}

    <section class="section">

        <div class="col-lg-12 text-center">

            <h4 style="color:darkblue;">Create Instruction</h4>
        </div>
        <div class="tile" id="tile-1" style="margin-top:10px !important;">

            <!-- Nav tabs -->

            <ul class="nav nav-tabs nav-justified " id="tabs" role="tablist">

                <li class="nav-items navv" class="active" style="flex-basis: 1 !important;cursor:pointer;">
                    <a class="nav-link  " id="home-tab" name="tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-user" style="margin-right:5px"></i><b>Instruction Initiate</b> <input type="checkbox" class="checkg" id="profile" name="nationality" readonly value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                        <div class="check"></div>
                    </a>

                </li>


            </ul>
        </div>

        <div class="card">
            <div class="card-body" id="card_header">
                <div id="content">
                    <div id="tab1">

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
                                                <input class="form-control" type="text" id="task_name" name="task_name" value="{{$rows['instruction'][0]['task_name']}}" autocomplete="off" disabled>
                                            </div>
                                        </div>

                                        <input name="stakeholder_id" type="hidden" id="stakeholder_id" value="{{$rows['instruction'][0]['stakeholder_id']}}">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Select Partners Name<span style="color: red;font-size: 16px;">*</span></label>
                                                <select name="partner[]" id="partner" name="partner" class="form-control">
                                                    <option value="">Select Partners Name</option>
                                                    @foreach($firm_partners as $key=>$row)

                                                    <option id="option{{ $row['partner_id'] }}" option_name="{{$row['name']}}" value="{{ $row['partner_id'] }}">{{$row['name']}}</option>

                                                    @endforeach

                                                </select>
                                                <span class="span_message" id="selectfirmerror"></span>
                                            </div>
                                        </div>




                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Select Instruction <span style="color: red;font-size: 16px;">*</span></label>
                                                    <select class="form-control" type="text" id="instruction_name" name="instruction_name" placeholder="Select Instruction Name" autocomplete="off">
                                                        <option value="0">Select Instruction</option>


                                                        @foreach($instruction as $key=>$row)

                                                        <option value="{{ $row['instruction_id'] }}">{{$row['instruction_name']}}</option>

                                                        @endforeach




                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label"> Description <span style="color: red;font-size: 16px;">*</span></label>
                                                    <input class="form-control" type="text" id="description" name="description" value="{{$rows['instruction'][0]['inst_description']}}" autocomplete="off" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-6" style="margin-top:4%;">
                                            <button type="button" class="btn" style="background-color:#2b9780 !important;color:white;" onclick="GetChilddetails()">ADD</button>
                                        </div> -->

                                        <div class="col-md-12" style="text-align:center">
                                            <a class="btn btn-labeled btn-info" href="{{ url()->previous() }}" id="backBtn" title="next" style="background: red !important; border-color:red !important; color:white !important; margin-top:0px !important;">
                                                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>
                                            <button type="button" class="btn" style="background-color:#cfc222 !important;color:white;" onclick="GetChilddetails()">Add other instruction</button>
                                            <a onclick="save()" class="btn btn-success">Submit</a>
                                        </div>

                                    </div>


                                </form>
                            </div>

                        </section>

                    </div>

                </div>
            </div>

        </div>
        <table class="table table-bordered d-none" id="table_list">
            <thead>
                <tr>
                    <th>Sl. No.</th>
                    <th>partner name</th>
                    <th>Instruction Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="instruction_table">


            </tbody>
        </table>

    </section>
    <div class="d-none" id="input_value">

    </div>

</div>

<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-lg">


        <div class="modal-content" style="margin-left:10%; margin-top:10%">



            <form action="{{ route('stakeholder.store') }}" method="post">
                {{ csrf_field() }}
                <div class="modal-header mh">
                    <h4 class="modal-title">Create Instruction</h4>
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
                                <input class="form-control" type="text" id="description" name="description" placeholder="Enter Description" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="text-align:center;margin-bottom:2%">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="showModal">
    <div class="modal-dialog modal-lg">


        <div class="modal-content" style="margin-left:10%; margin-top:10%">




            <div class="modal-header mh">
                <h4 class="modal-title">Instruction</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <input name="stakeholder_id" type="hidden" value="">

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
                                <input class="form-control" type="text" id="description_edit" name="description" value="">
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
                var partners = data[0].partners;
                var instruction_id = data[0].instruction_id;
                var current_partner_id = $('#partner').val();
                var current_partner_name = $(`#option${current_partner_id}`).attr('option_name');

                const total_values_exist_validations = document.querySelectorAll('.table_values');
                for (const total_values_exist_validation of total_values_exist_validations) {
                    if (total_values_exist_validation.id == `instruction${instruction_id}`) {
                        Swal.fire("Info!", "Instruction already Exit!", "info") //already exit
                        return false;

                    }
                }

                $('#instruction_table').append('<tr><td></td><td>' + current_partner_name + '</td><td>' + instruction_name + '</td><td> ' + description + '</td><td> <i class="fa fa-trash" value=' + instruction_id + ' style="color:#2b9780;cursor:pointer;" aria-hidden="true"></i></td> </tr>');
                var input = `<input type="hidden" class="table_values" partner_id="${current_partner_id}" id="instruction${instruction_id}" value="${instruction_id}">`;
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

                Swal.fire("Success!", "Instruction Added Successfully", "success");



            }
        })
    };

    let totalid = [];
    var totalid_index = 0;

    function save() {

        const total_values_validation = document.querySelectorAll('.table_values');

        if (total_values_validation.length == 0) {
            Swal.fire("Please select the Instruction", "", "error"); //please slect the any instruction
            return false;
        }
        const totalvalues = $('.table_values');
        for (const totalvalue of totalvalues) {
            totalid[totalid_index] = {
                'instruction_id': totalvalue.value,
                'partner_id': totalvalue.getAttribute('partner_id')
            };
            totalid_index = totalid_index + 1;

        }
        console.log(totalid);
        var task_name = $('#task_name').val();
        //for both firm and valuers
        var valuer_names = $('#partner').val();
        // for (const valuer_name of valuer_names) {
        //     if (valuer_name.classList[1] != 'd-none') {
        //         var valuer_name_new = valuer_name.children[0].children[2].value;
        //     }

        // }
        var description = $('#description').val();

        var type = $('#type').val();
        var stakeholder_id = $('#stakeholder_id').val();



        $.ajax({

            url: "{{ url('/firm_update') }}",
            type: 'GET',
            data: {

                'task_name': task_name,
                'valuer_name': valuer_names,
                'description': description,
                'type': type,
                'totalid': totalid,
                'stakeholder_id': stakeholder_id,
                _token: '{{csrf_token()}}'

            },


            success: function(data) {
                //console.log(data[0].description);

                Swal.fire("Success!", "Submitted Successfully", "success").then((result) => {

                    location.replace(`/Instruction/Process`);

                })

            }
        })

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





@endsection