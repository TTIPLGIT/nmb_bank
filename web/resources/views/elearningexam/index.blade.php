@extends('layouts.adminnav')

@section('content')
<style>
    .no-arrow::-webkit-inner-spin-button {
        display: none;
    }

    .no-arrow::-webkit-outer-spin-button,
    .no-arrow::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
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


    .close {
        color: red;
        opacity: 1;
    }

    .close:hover {

        color: red;

    }







    @media only screen and (max-width: 425px) {
        .col-sm-2.addquizmodal {
            margin-bottom: 12px;
        }

        textarea#quistion {
            width: 100%;
        }

        textarea#quistions2 {
            width: 100%;
        }

        textarea#quistion11 {
            width: 100%;
        }
    }

    @media only screen and (max-width: 1024px) {
        .btn.btn-lg {
            padding: 10px 9px;
            font-size: 12px;
        }
    }

    .btn.btn-lg {
        padding: 10px 10px;
        font-size: 12px;
    }

    .ellipsis,
    .ellipsis p {
        overflow: hidden !important;
        white-space: nowrap !important;
        text-overflow: ellipsis !important;
        max-width: 100px !important;
        /* Adjust the value to fit your desired width */
    }
</style>


<style>
    #counselorerroredit {
        color: red;
    }

    #supervisorerroredit {
        color: red;
    }

    .breadcrumb {
        display: inline-block !important;
        overflow: hidden !important;
        border-radius: 5px !important;
        counter-reset: flag !important;
        width: 249px;
        margin-left: 16px;
    }
</style>

<style>
    .select2-container {
        min-width: 258px !important;
    }

    .select2-container--default .select2-search--inline .select2-search__field {
        width: 300px !important;
    }

    .select2-results__option {
        padding-right: 20px;
        vertical-align: middle;
    }
</style>

<div class="main-content main_contentspace">
    <div class="row">
        {{ Breadcrumbs::render('elearningexam.index') }}
        <div class=" col-md-12">
            <section class="section5">
                <div class="section-body mt-2">
                    <a type="button" style="font-size:15px;margin: 0 0px 5px 15px; border-color:#a9ca !important;" class="btn btn-success btn-lg" title="Test Create" id="gcb" href="" data-toggle="modal" data-target="#addModal1">Exam
                        <span class="col-md-1" style="font-size:15px !important;padding:8px !important"><i class="fa fa-plus" aria-hidden="true"></i></span></a>
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



                    <div class="row">
                        <div class="col-12">

                            <div class="card mt-0">
                                <div class="card-body">
                                    <div class="col-lg-12 text-center">
                                        <h4>Exam List View</h4>
                                    </div>
                                    <div class="table-wrapper">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="align1">
                                                <thead>
                                                    <tr>
                                                        <th>SI.No</th>
                                                        <th>Category</th>
                                                        <th>Exam Name</th>
                                                        <th>Quiz Name</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="background-color: #cfe0e8;">

                                                    @foreach($rows['rows']['quiz_list'] as $data)

                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$data['role_name']}}</td>
                                                        <td class="ellipsis">{{$data['exam_name']}}</td>
                                                        <td class="ellipsis">{{$data['quiz_name']}}</td>
                                                        <td style="display:flex;justify-content:space-evenly;">

                                                            <a class="" title="Edit" id="edit" onclick="fetch_update({{$data['id']}},'edit')" data-toggle="modal" data-target="#addModal2" style="padding-top: 6px;"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>
                                                            <a class="btn btn-link" id="show" onclick="fetch_update({{$data['id']}},'show')" data-toggle="modal" data-target="#addModal3" style="padding-top: 6px;" title="show"><i class="fas fa-eye" style="color:green"></i></a>


                                                            <button type="submit" title="Delete" onclick="delete1(({{$data['id']}}))" class="btn btn-link"><i class="far fa-trash-alt" style="color:red"></i></button>


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

</div>



<!-- create -->
<div class="modal fade modalreset" id="addModal1">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="POST" id="create_form" enctype="multipart/form-data" class="reset">
                {{ csrf_field() }}

                <div class="modal-header mh">
                    <h4 class="modal-title">Create Exam</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" style="background-color: #ffffff !important;">
                    <input type="hidden" class="form-control" id="user_id" name="user_id" value="">
                    <input type="hidden" class="form-control" id="user_details" name="user_details" value="general">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label required">Category:<span class="error-star" style="color:red;">*</span></label>
                                <select class="form-control default" name="user_category" id="user_category">
                                    <option value="">Select User Category</option>
                                    @foreach($rows['rows']['user_category'] as $key=>$row)

                                    <option value="{{ $row }}">{{ $key }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Exam Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="exam_name" name="exam_name" autocomplete="off" placeholder="Please Enter the Exam Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label required">Quiz Name:<span class="error-star" style="color:red;">*</span></label>
                                <select class="form-control" name="quiz_id" id="quiz_id">
                                    <option value="">Select Quiz Name</option>
                                    @foreach($rows['rows']['quiz_dropdown'] as $key=>$row)

                                    <option value="{{ $row['quiz_id'] }}">{{ $row['quiz_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <button class="btn btn-success btn-space" type="button" onclick="gencre(1)" id="savebutton">Submit</button>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </div>

            </form>
        </div>




    </div>

</div>
<!-- Edit -->
<div class="modal fade modalreset" id="addModal2">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form action="{{route('elearningexam.update',1)}}" method="POST" id="ethnicupdate" enctype="multipart/form-data" class="reset">
                @method('put')
                @csrf
                <input type="hidden" name="eid" class="eid" id="eid">

                <div class="modal-header mh">
                    <h4 class="modal-title">Edit Exam</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" style="background-color: #ffffff !important;">
                    <input type="hidden" class="form-control" id="user_id" name="user_id" value="">
                    <input type="hidden" class="form-control" id="user_details" name="user_details" value="general">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label required">Category:<span class="error-star" style="color:red;">*</span></label>
                                <select class="form-control" name="user_category" id="user_categoryedit">
                                    <option value="">Select User Category</option>
                                    @foreach($rows['rows']['user_category'] as $key=>$row)

                                    <option value="{{ $row }}">{{ $key }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Exam Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="exam_nameedit" name="exam_name" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label required">Quiz Name:<span class="error-star" style="color:red;">*</span></label>
                                <select class="form-control" name="quiz_id" id="quiz_idedit">
                                    <option value="">Select Quiz Name</option>
                                    @foreach($rows['rows']['quiz_dropdown'] as $key=>$row)

                                    <option value="{{ $row['quiz_id'] }}">{{ $row['quiz_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <button class="btn btn-success btn-space" type="button" onclick="gencre(2)" id="savebutton">Update</button>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </div>

            </form>
        </div>




    </div>

</div>
<!-- Show -->
<div class="modal fade modalreset" id="addModal3">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="" id="ethnicshow" enctype="multipart/form-data" class="reset">
                @method('put')
                @csrf
                <input type="hidden" name="eidshow" class="eidshow" id="eidshow">

                <div class="modal-header mh">
                    <h4 class="modal-title">Show Exam</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" style="background-color: #ffffff !important;">
                    <input type="hidden" class="form-control" id="user_id" name="user_id" value="">
                    <input type="hidden" class="form-control" id="user_details" name="user_details" value="general">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label required">Category:<span class="error-star" style="color:red;">*</span></label>
                                <select class="form-control" name="user_category" id="user_categoryshow">
                                    <option value="">Select User Category</option>
                                    @foreach($rows['rows']['user_category'] as $key=>$row)

                                    <option value="{{ $row }}">{{ $key }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Exam Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="exam_nameshow" name="exam_name" autocomplete="off" style="background-color: #e9ecef !important;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label required">Quiz Name:<span class="error-star" style="color:red;">*</span></label>
                                <select class="form-control" name="quiz_id" id="quiz_idshow">
                                    <option value="">Select Quiz Name</option>
                                    @foreach($rows['rows']['quiz_dropdown'] as $key=>$row)

                                    <option value="{{ $row['quiz_id'] }}">{{ $row['quiz_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </div>

            </form>
        </div>




    </div>

</div>





<script>
    $(document).ready(function() {
        $(document).on('hidden.bs.modal', function() {
            // const form = this.querySelector('.reset');

            // form.reset();
            const form_count = document.querySelectorAll('form.reset');
            for (let index = 0; index < form_count.length; index++) {
                $('.reset')[index].reset();

            }

        })

    })

    function gencre(id) {

        if (id == "1") {
            var c_name = $("#user_categoryshow").val();

            // if (c_name == '') {
            //     swal.fire("Please Select User Category", "", "error");
            //     return false;
            // }
            var t_name = $("#exam_name").val();
            if (t_name == '') {
                swal.fire("Please Enter the Exam Name", "", "error");
                return false;
            }
            var q_name = $("#quiz_id").val();
            if (q_name == '') {
                swal.fire("Please Enter the Quiz Name", "", "error");
                return false;
            } else {
                $('#savebutton').prop('disabled', true);

                document.getElementById('create_form').submit();
            }
        } else if (id == "2") {
            var c_nameedit = $("#user_categoryedit").val();

            if (c_nameedit == '') {
                swal.fire("Please Select User Category", "", "error");
                return false;
            }
            var t_nameedit = $("#exam_nameedit").val();
            if (t_nameedit == '') {
                swal.fire("Please Enter the Exam Name", "", "error");
                return false;
            }
            var q_nameedit = $("#quiz_idedit").val();
            if (q_nameedit == '') {
                swal.fire("Please Enter the Quiz Name", "", "error");
                return false;
            }
            document.getElementById('ethnicupdate').submit();

        }



    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    var $j = jQuery.noConflict();

    $j(document).ready(function() {
        $j('#quiz_id').select2();
        $j('#quiz_idedit').select2();
        //alert('egeg');
        $(document).on('change', '#quiz_idedit', function() {
           // alert('fe');
            $j('#quiz_idedit').select2('destroy').select2();

        });

    });
</script>



<script>
    function fetch_update(id, type) {




        $.ajax({
            url: "{{ url('/exam/fetch') }}",
            type: 'GET',
            data: {
                'id': id,
                _token: '{{csrf_token()}}'

            },

            success: function(data) {
                console.log(data);
                if (type == "edit") {
                    $('#user_categoryedit').val(data.rows[0]['user_category']);
                    $('#exam_nameedit').val(data.rows[0]['exam_name']);
                    $('#quiz_idedit').val(data.rows[0]['quiz_id']).trigger('change');
                    $('#eid').val(data.rows[0]['id']);

                } else {
                    $('#user_categoryshow').val(data.rows[0]['user_category']);
                    $('#exam_nameshow').val(data.rows[0]['exam_name']);
                    $('#quiz_idshow').val(data.rows[0]['quiz_id']);
                    $('#eidshow').val(data.rows[0]['id']);

                    $('#user_categoryshow').prop('disabled', true);
                    $('#exam_nameshow').prop('disabled', true);
                    $('#quiz_idshow').prop('disabled', true);
                    $('#eidshow').attr('Action', '');


                }


            }
        });

    }
</script>
<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>


<script>
    function delete1(id) {
        Swal.fire({
            title: "Are you  you want to delete the Exam?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Delete",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('/exam/delete') }}",
                    type: 'GET',
                    data: {
                        'id': id,
                        _token: '{{csrf_token()}}'

                    },


                    success: function(data) {
                        console.log(data);
                        if (result.value) {

                            Swal.fire("Success!", "Exam Deleted Successfully!", "success").then((result) => {
                                location.replace(`/elearningexam`);

                            })
                        }

                    }
                });
            }
        })




    }
    // 
</script>





<script>
    const myModal = document.querySelectorAll('.modalreset');

    for (const myModals of myModal) {

        myModals.addEventListener('hidden.bs.modal', function() {

            const form = this.querySelector('.reset');

            form.reset();
        });

    }
</script>




@endsection