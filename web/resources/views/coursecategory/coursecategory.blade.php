@extends('layouts.adminnav')

@section('content')
<style type="text/css">
    .dt-buttons.btn-group {
        display: none !important;
    }

    .mystyle {
        border: 2px solid red;
    }
</style>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.3/xlsx.full.min.js"></script>
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <section class="section">
                <div class="section-body">{{ Breadcrumbs::render('catagory_list') }}


                    <div class="d-flex justify-content-start  ml-3 mb-3">
                        <a href="{{ route('catagory_create') }}" class="btn btn-success " style="margin-right:100px">Create <i class="fa fa-plus"
                                            aria-hidden="true"></i></a>
                    </div>

                    <div class="row">

                        <div class="col-12">

                            <div class="card">

                                <div class="card-body">
                                    <h4 style="color:black; text-align: center;">List Catagory</h4>
                                    <div class="row">
                                        <!-- <div class="col-lg-12 text-center">
          <h4 style="color:darkblue;">Folder List</h4>
        </div> -->

                                    </div>
                                    @if (session('success'))


                                    @elseif(session('error'))


                                    @endif

                                    <div class="table-wrapper">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="align1">
                                                <thead>
                                                    <tr>
                                                        <th>Sl. No.</th>
                                                        <th>Catagory</th>
                                                        <!-- <th>Sub Catagory</th> -->
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach($categories as $catagory)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{ $catagory['catagory_name'] }}</td>
                                                        <!-- <td>{{ $catagory['sub_catagory'] }}</td> -->
                                                        <td> <a class="btn btn-link" title="Edit" type="GET" id="gcb"
                                                                onclick="fetch_show({{$catagory['catagory_id']}},'edit')"
                                                                data-toggle="modal" data-target="#addModal4"><i
                                                                    class="fas fa-pencil-alt"
                                                                    style="color: blue !important"></i></a>
                                                            <a class="btn btn-link" type="show"
                                                                onclick="fetch_show({{$catagory['catagory_id']}},'show')"
                                                                title="Show" id="gcb" href="" data-toggle="modal"
                                                                data-target="#addModal4"><i class="fas fa-eye"
                                                                    style="color:green"></i></a>


                                                            <a type="button" title="Delete"
                                                                onclick="fetch_delete({{$catagory['catagory_id']}},'delete')"
                                                                class="btn btn-link"><i class="far fa-trash-alt"
                                                                    style="color:red"></i></a>
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
        </div>
    </section>



</div>
</section>
</div>

<!-- This Model is for only view -->
<div class="modal fade" id="addModal4">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ url('/course/catagory_update') }}" enctype="multipart/form-data" id="catagory_Update">
                @csrf
                <input type="hidden" id="catagory_id" name="catagory_id">

                <div class="modal-header mh">
                    <h4 class="modal-title" id="title_name">Catagory</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="container edit longquestion">
                    <h4 class="modal-title long mt-3" id="sub_title_name" style="text-align: center; width: 100%;">Catagory</h4>

                    <div class="row">
                        <div class="col-6">
                            <label>Catagory<span class="error-star" style="color:red;">*</span></label>
                            <input type="text" class="form-control default" id="catagory_name" name="catagory_name">
                        </div>
                        <div class="col-6">
                            <label>Sub Catagory</label>
                            <input type="text" class="form-control default" id="sub_catagory" name="sub_catagory">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <label>Description</label>
                            <textarea class="form-control default" id="description" name="description" style="height:200px;"></textarea>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-center gap-2 mb-3">

                                <button type="submit" onclick=" gencre(event)" class="btn btn-success" id="updateButton">Update</button>

                                <a class="btn btn-danger btn-lg" style="color:white;" href="{{ route('catagory_list') }}">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>




<script>
    function gencre(event) {
        event.preventDefault();

        var catagory_name = $("#catagory_name").val();
        if (catagory_name == '') {
            swal.fire("Please Enter the Catagory Name", "", "error");
            return false;

        } else {
            document.getElementById('catagory_Update').submit();
        }
    }
</script>


<script>
    function fetch_show(catagory_id, type) {
        $.ajax({
            url: "{{ url('/course/catagory/fetch') }}",
            type: 'GET',


            data: {
                'catagory_id': catagory_id,
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                console.log(data);

                $('#catagory_name').prop('disabled', false).val(data.rows[0]['catagory_name']);
                $('#sub_catagory').prop('disabled', false).val(data.rows[0]['sub_catagory']);
                $('#description').prop('disabled', false).val(data.rows[0]['description']);
                $('#catagory_id').val(catagory_id);

                if (type === "show") {

                    $('#catagory_name').prop('disabled', true);
                    $('#sub_catagory').prop('disabled', true);
                    $('#description').prop('disabled', true);
                    $('#updateButton').hide();
                    document.getElementById("sub_title_name").innerHTML = "Catagory";
                    document.getElementById("title_name").innerHTML = "Catagory";
                } else {
                    document.getElementById("sub_title_name").innerHTML = "Edit Catagory";
                    document.getElementById("title_name").innerHTML = "Edit Catagory";

                    $('#updateButton').show();
                }
            }

        });
    }
</script>


<!-- <script>
    function fetch_update_edit(catagory_id, type) {
        $.ajax({
            url: "{{ url('/course/catagory/fetch') }}",
            type: 'GET',
            data: {
                catagory_id: catagory_id,
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                $('#catagory_name').val(data.rows[0]['catagory_name']);
                $('#sub_catagory').val(data.rows[0]['sub_catagory']);
                $('#description').val(data.rows[0]['description']);
                $('#catagory_id').val(data.rows[0]['catagory_id']);


                $('#catagory_name, #sub_catagory, #description').prop('disabled', false);
                $('#updateButton').show();

                $('#addModal4').modal('show');
            }
        });
    }
</script> -->

<script>
    function fetch_delete(catagory_id, type) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('/course_catagory_delete') }}",
                    type: 'POST',
                    data: {
                        catagory_id: catagory_id,
                        _token: '{{ csrf_token() }}'
                    },
                    error: function() {
                        Swal.fire("Error!", "Something went wrong.", "error");
                    },
                    success: function(data) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Course Category Deleted Successfully.",
                            icon: "success"
                        }).then(() => {

                            window.location.href = "{{ route('catagory_list') }}";
                        });
                    }
                });
            }
        });

    }
</script>

@endsection