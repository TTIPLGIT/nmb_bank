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
<!-- for with out reject -->


<div class="main-content">
<input type="hidden" name="process_type" id="process_type" value="1">
    {{ Breadcrumbs::render('valuer_show', $rows[0]['id']) }}

    <section class="section">

        <div class="col-lg-12 text-center">

            <h4 style="color:darkblue;"> Instruction View </h4>
        </div>

        <div class="card">
            <div class="card-body" id="card_header">
                <div id="content">
                    <div id="tab1">
                        <section class="section">
                            <div class="section-body mt-1">
                                <!-- <input type="hidden" class="form-control" required id="user_id" name="user_id" readonly value=""> -->
                                <input type="hidden" class="form-control" required id="user_details" name="user_details" readonly value="general">
                                <input type="hidden" id="previous_element"  value="{{$instruction[0]['valuer_id']}}">
                                <form action="" method="post">
                                    @csrf
                                    <!-- <input type="hidden" class="form-control" required id="user_id" name="user_id" readonly value=""> -->
                                    <input type="hidden" class="form-control" required id="user_details" name="user_details" readonly value="general">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label"> Task Name <span style="color: red;font-size: 16px;">*</span></label>
                                                <input class="form-control" type="text" id="task_name" name="task_name" placeholder="Enter Instruction Name" autocomplete="off" value="{{$rows[0]['task_name']}}">
                                            </div>
                                        </div>  
                                        <div class="col-md-6 valuer_name" id="valuer">
                                            <div class="form-group">
                                                <label class="control-label"> Select Valuer Name <span style="color: red;font-size: 16px;">*</span><span style="color: black;font-size: 16px;">OR</span></label>
                                                <button type="button" class="btn control-label" style="background-color:#25867d !important;color:white !important;" onclick="GetvaluerName()">Select Firm</button>

                                                <select class="form-control" type="text" id="valuer_name" name="valuer_name" placeholder="Select Valuer Name" autocomplete="off">

                                                    <option value="0">Select Valuer</option>
                                                    @foreach($valuer_2 as $key=> $row)

                                                    <option value="{{ $row['id'] }}">{{$row['name']}}</option>

                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>


                                        <div class="col-md-6 d-none valuer_name" id="firm_name">
                                            <div class="form-group">
                                                <label class="control-label"> Select Firm Name <span style="color: red;font-size: 16px;">* OR</span></label>
                                                <button type="button" class="btn control-label" style="background-color:darkgray !important;color:black !important;" onclick="GetFirmName()">Select Valuer</button>

                                                <select class="form-control" type="text" id="firm_name" name="valuer_name" placeholder="Select Firm Name" autocomplete="off">

                                                    <option value="0">Select Firm Name</option>
                                                    @foreach($firm as $key=>$row)

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
                                                    @foreach($valuer_1 as $key=>$row)

                                                    <option value="{{ $row['instruction_id'] }}">{{$row['instruction_name']}}</option>

                                                    @endforeach

                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label"> Description <span style="color: red;font-size: 16px;">*</span></label>
                                                <input class="form-control" type="text" id="description" name="description" placeholder="Enter Instruction Name" autocomplete="off" value="{{$rows[0]['inst_description']}}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">

                                        </div>
                                        <div class="col-md-12" style="text-align:center">
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
        <div class="d-none" id="input_value">
            @foreach($instruction as $data)

            <input type="hidden" class="table_values" id="instruction{{$data['insruction_id']}}" value="{{$data['insruction_id']}}">
            @endforeach

        </div>


        <div class="card" style="margin-top:3%">
            <div class="card-body" id="card_header">
                <div class="table-wrapper">
                    <div class="table-responsive">

                        <table class="table table-bordered">
                            <thead>

                                <tr>
                                    <th>S. No</th>
                                    <th>Instruction Name</th>
                                    <th>Description</th>
                                    <th>Action</th>


                                </tr>
                            </thead>


                            <tbody id="instruction_table">

                                @foreach($instruction as $data)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$data['instruction_name']}}</td>
                                    <td>{{$data['description']}}</td>

                                    <td><button data-toggle="modal" instruction="{{$data['instruction_name']}}" instruction_id="{{$data['insruction_id']}}" task_id="{{$data['id']}}" description="{{$data['description']}}" data-target="#Editmodal" style="border: none;" onclick="edit(event)"><i class="fas fa-trash" style="color: blue !important;border: none;pointer-events:none;"></i></button></td>
                                </tr>

                                @endforeach

                            </tbody>
                        </table>

                    </div>
                </div>






            </div>
        </div>

    </section>
</div>





<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
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
<script>
    function GetvaluerName() {
        document.getElementById('firm_name').classList.remove('d-none');
        document.getElementById('valuer').classList.add('d-none');
        document.querySelector('#process_type').value = '2';
        document.querySelector('#type').value = '2';



    }

    function GetFirmName() {
        document.getElementById('valuer').classList.remove('d-none');
        document.getElementById('firm_name').classList.add('d-none');
        document.querySelector('#process_type').value = '1';

        document.querySelector('#type').value = '1';



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

        // if (valuer_name == '0') {
        //     swal.fire("Please select the Valuer Name:", "", "error");
        //     return false;
        // }
        // var instruction_name = $('#instruction_name').val();

        // if (instruction_name == '0') {
        //     swal.fire("Please select the Instruction Name:", "", "error");
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
                'instruction_id': totalvalue.value
            };
            totalid_index = totalid_index + 1;

        }
        console.log(totalid);
        var task_name = $('#task_name').val();
        var valuer_names = $('.valuer_name');
        for (const valuer_name of valuer_names) {
            console.log(valuer_name);
            if (valuer_name.classList[1] != 'd-none') {
                var valuer_name_new = valuer_name.children[0].children[2].value;
            }

        }
        var description = $('#description').val();
        var process_type = $('#process_type').val();
        var previous_element = $('#previous_element').val();
        
        console.log(previous_element);

        $.ajax({
            url: "{{ url('/firmreject/store') }}",
            type: 'GET',
            data: {

                'task_name': task_name,
                'valuer_name': valuer_name_new,
                'description': description,
                'totalid': totalid,
                'process_type':process_type,
                'previous_element': previous_element,
                _token: '{{csrf_token()}}'

            },


            success: function(data) {
               
                //console.log(data[0].description);

                Swal.fire("Success!", "Submitted Successfully", "success").then((result) => {

                    location.replace(`/initiation`);

                })

            }
        })

    }
</script>
@endsection