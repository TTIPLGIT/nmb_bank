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
    {{ Breadcrumbs::render('educationcourse_index') }}

    <section class="section">

        <div class="col-lg-12 text-center">
            <h4>List of Course Names</h4>
        </div>
        <div class="section-body mt-2">
            <a type="button" href="" value="" class="btn btn-labeled btn-success mb-2" title="Add_Course" style="border-color:#a9ca !important; color:white !important;margin: 0 0 2px 15px;" data-toggle="modal" data-target="#addeducationcourseModal">
                <span class="btn-label" style="font-size:15px !important; padding:8px !important"><i class="fa fa-plus"></i></span><span style="font-size:15px !important; padding:8px !important">create</span></a>

            <style>
                .section {
                    margin-top: 20px;
                }
            </style>

            <div class="row">

                <div class="col-12">

                    <div class="mt-0">

                        <div class="card-body" id="card_header">
                            <div class="row">


                            </div>
                            @if (session('success'))

                            <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
                            <script type="text/javascript">
                                window.onload = function() {
                                    var message = $('#session_data').val();
                                    swal.fire({
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



                            <div class="table-wrapper">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="align">
                                        <thead>
                                            <tr>
                                                <th>Sl. No.</th>
                                                <th>Course Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($rows['rows'] as $data)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$data['course_name']}}</td>
                                                <td>

                                                    <form action="" id="destroygen" method="POST">

                                                        <a class="" title="Edit" id="gcb" data-toggle="modal" data-target="#editeducationcourseModal" onclick="educationcourse_fetch({{$data['id']}},'edit')"><i class="fas fa-pencil-alt" style="color: blue !important"></i></a>
                                                        <a class="btn btn-link" title="show" data-toggle="modal" data-target="#editeducationcourseModal" onclick="educationcourse_fetch({{$data['id']}},'show')"><i class="fas fa-eye" style="color:green"></i></a>
                                                        @method('put')
                                                        @csrf

                                                        <a title="Delete" onclick="educationcourse_delete(<?php echo $data['id'] ?>)" class="btn btn-link"><i class="far fa-trash-alt" style="color:red"></i></a>
                                                    </form>
                                                </td>
                                            </tr>
                                            <!-- for stake holders -->
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>


<div class="modal fade" id="addeducationcourseModal">
    <div class="modal-dialog modal-lg">


        <div class="modal-content" style="margin-left:10%; margin-top:10%">



            <form action="{{route('educationcourse_store')}}" method="post" id="education_course" class="reset">
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
                                <label class="control-label">Course Name <span style="color: red;font-size: 16px;">*</span></label>
                                <input class="form-control" type="text" id="Course_name" name="Course_name" placeholder="Enter Course Name" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="text-align:center;margin-bottom:2%">
                        <a class="btn btn-success btn-space" type="button" onclick="educationcourse_name()" id="savedetails">Submit</a>
                        <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">

                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- end create -->
<!-- edit function -->
<div class="modal fade" id="editeducationcourseModal">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <form method="POST" action="{{route('educationcourse_update')}}" id="edit_form" enctype="multipart/form-data">

                @csrf
                <input type="hidden" name="id" class="id" id="editcourseid">

                <div class="modal-header mh">
                    <h4 class="modal-title">Edit CourseName</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group mb-2">
                            <label class="">Course Name<span class="error-star" style="color:red;">*</span></label>
                            <input type="text" class="form-control default" id="edit_course" name="edit_course" autocomplete="off">

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

<!-- --edit end-- -->

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>


<script>
    function educationcourse_name() {
        var education = $("#Course_name").val();
        if (education == '') {
            swal.fire("Please Enter the Course Name", "", "error");
            return false;
        }
        document.getElementById('education_course').submit();

    }
</script>

<script>
    function educationcourse_fetch(id, type) {

        // alert(id);


        $.ajax({
            url: "{{ url('/educationcourse/edit') }}",
            type: 'GET',
            data: {
                'id': id,
                _token: '{{csrf_token()}}'

            },

            success: function(data) {
                console.log(data);
                $('#editcourseid').val(data[0]['id']);
                if (type == "edit") {
                    $('#editeducationcourseModal .modal-title').text('Edit Course name')
                    $('#savebutton').show();
                    $('#edit_course').val(data[0]['course_name']).prop('disabled', false);

                } else {
                    // show course  

                    $('#editeducationcourseModal .modal-title').text('Show Course name')
                    $('#edit_course').val(data[0]['course_name']).prop('disabled', true);
                    $('#savebutton').hide();


                }


            }
        });

    }
</script>


<script>
    $(document).ready(function() {
        $('#addeducationcourseModal').on('hidden.bs.modal', function()

            {
                $(this).find('form')[0].reset();
            });
    });

    function educationcourse_delete(id) {
        Swal.fire({
            title: "Are you sure, you want to delete the Course Name?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Delete",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('educationcourse_delete') }}",
                    type: 'POST',
                    data: {
                        id: id,

                        _token: '{{csrf_token()}}'
                    },
                    success: function(data) {

                        if (result.value) {
                            Swal.fire("Success!", "Course Name Deleted Successfully!", "success").then((result) => {

                                location.replace(`education_course`);

                            })
                        }

                    }
                });
            }
        })
    }
</script>


@endsection