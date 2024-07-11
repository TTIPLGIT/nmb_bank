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

    .ellipsis,
    .ellipsis p {
        overflow: hidden !important;
        white-space: nowrap !important;
        text-overflow: ellipsis !important;
        max-width: 100px !important;
        /* Adjust the value to fit your desired width */
    }

    p {
        text-align: center !important;
    }
</style>

<div class="main-content main_contentspace">
    <div class="row">
        {{ Breadcrumbs::render('elearningadminqa.index') }}
        <div class=" col-md-12">
            <section class="section5">
                <div class="section-body mt-2">
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
                                        <h4>Question List View</h4>
                                    </div>
                                    <div class="table-wrapper">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="align1">
                                                <thead>
                                                    <tr>
                                                        <th>SI.No</th>
                                                        <th>Question Header</th>
                                                        <th>Question Description</th>
                                                        <th>No.of Follows</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody style="background-color: #cfe0e8;">

                                                    @foreach($rows['rows']['quiz_list'] as $data)

                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td class="ellipsis">{{$data['question_header']}}</td>
                                                        <td class="ellipsis">{!! $data['question_description'] !!}</td>
                                                        <td>{{$data['number_of_follows']}}</td>
                                                        <td style="display:flex;justify-content:space-evenly;">

                                                            <a class="btn btn-link" title="Reply" id="reply" href="{{route('adminquestion.reply_index',$data['question_id'])}}" style="padding-top: 6px;background: navy !important;color: #ffff !important;">Reply</a>
                                                            <a class="btn btn-link" id="show" style="padding-top: 6px;" onclick="fetch_update({{$data['question_id']}},'show')" data-toggle="modal" data-target="#addModal3" title="show"><i class="fas fa-eye" style="color:green"></i></a>


                                                            <button type="submit" title="Delete" onclick="delete1(({{$data['question_id']}}))" class="btn btn-link"><i class="far fa-trash-alt" style="color:red"></i></button>


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

<div class="modal fade modalreset" id="addModal3">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="" id="ethnicshow" enctype="multipart/form-data" class="reset">
                @method('put')
                @csrf
                <input type="hidden" name="eidshow" class="eidshow" id="eidshow">

                <div class="modal-header mh">
                    <h4 class="modal-title">Show Course Questrions</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" style="background-color: #ffffff !important;">
                    <input type="hidden" class="form-control" id="user_id" name="user_id" value="">
                    <input type="hidden" class="form-control" id="user_details" name="user_details" value="general">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Question Header:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="questionheader_nameshow" name="questionheader_nameshow" style="background-color: #e9ecef !important;">
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Question Description:<span class="error-star" style="color:red;">*</span></label>
                                <textarea class="form-control default" id="question_descriptionshow" name="question_descriptionshow" style="background-color: #e9ecef !important;"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="course_nameshow" name="course_nameshow" style="background-color: #e9ecef !important;">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Number of Follows: <span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="no_followshow" name="no_followshow" style="background-color: #e9ecef !important;">
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


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>

<script>
    function delete1(id) {
        //alert(id);
        Swal.fire({
            title: "Are you  you want to delete the Questions?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Delete",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('/adminqa/delete') }}",
                    type: 'GET',
                    data: {
                        'question_id': id,
                        _token: '{{csrf_token()}}'

                    },
                    success: function(data) {
                        console.log(data);
                        if (result.value) {
                            Swal.fire("Success!", "Questions Deleted Successfully!", "success").then((result) => {

                                location.replace(`/elearningadminqa`);

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
    function fetch_update(id, type) {
       // alert("bjsd");
        $.ajax({
            url: "{{ url('/adminqa/fetch') }}",
            type: 'GET',
            data: {
                'question_id': id,
                _token: '{{csrf_token()}}'

            },
            success: function(data) {
                console.log(data);
                if (type == "show") {
                    $('#questionheader_nameshow').val(data.rows[0]['question_header']);
                    $('#question_descriptionshow').html(data.rows[0]['question_description']);
                    $('#course_nameshow').val(data.rows[0]['course_name']);
                    $('#no_followshow').val(data.rows[0]['number_of_follows']);
                    $('#eidshow').val(data.rows[0]['question_id']);

                    $('#questionheader_nameshow').prop('disabled', true);
                    $('#question_descriptionshow').prop('disabled', true);
                    $('#course_nameshow').prop('disabled', true);
                    $('#no_followshow').prop('disabled', true);
                    $('#eidshow').attr('Action', '');

                } else {


                }


            }
        });

    }
</script>













@endsection