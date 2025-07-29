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
                <div class="section-body">{{ Breadcrumbs::render('level_master_page') }}


                    <div class="d-flex justify-content-start  ml-3 mb-3">
                        <a href="{{ route('level_add_page') }}" class="btn btn-success "
                            style="margin-right:100px">Level <i class="fa fa-plus" aria-hidden="true"></i></a>
                    </div>

                    <div class="row">

                        <div class="col-12">

                            <div class="card">

                                <div class="card-body">
                                    <h4 style="color:black; text-align: center;">Levels</h4>
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
                                                        <th>Level Number</th>
                                                        <th>Level Name</th>
                                                        <th>Minimum Point</th>
                                                        <th>Maximum Point</th>
                                                        <th>Level Icon</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach($levels as $level)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{ $level['level_number'] }}</td>
                                                        <td>{{ $level['level_name'] }}</td>
                                                        <td>{{ $level['min_point'] }}</td>
                                                        <td>{{ $level['max_point'] }}</td>
                                                        <td>{{ $level['level_icon'] }}</td>
                                                        <td><a class="btn btn-link" title="Edit" type="GET" id="gcb"
                                                                onclick="fetch_show({{$level['level_id']}},'edit')"
                                                                data-toggle="modal" data-target="#editModal"><i
                                                                    class="fas fa-pencil-alt"
                                                                    style="color: blue !important"></i></a>
                                                            <a class="btn btn-link" type="show"
                                                                onclick="fetch_show({{$level['level_id']}},'show')"
                                                                title="Show" id="gcb" href="" data-toggle="modal"
                                                                data-target="#editModal"><i class="fas fa-eye"
                                                                    style="color:green"></i></a>


                                                            <a type="button" title="Delete"
                                                                onclick="fetch_delete({{$level['level_id']}},'delete')"
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

<div class="modal fade" id="editModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('level_update') }}" enctype="multipart/form-data" id="levels_update">
                <button type="button" style="color:red;padding:20px" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                @csrf

                <input type="hidden" id="level_id" name="level_id">
                <h4 style="color:black;text-align:center;margin-bottom:20px" id="level_heading">Create Levels</h4>

                <div class="row">
                    <div class="col-6">
                        <label>Level Number<span class="error-star" style="color:red;">*</span></label>
                        <input type="number" class="form-control default" id="level_number" name="level_number"
                            required>
                    </div>
                    <div class="col-6">
                        <label>Level Name<span class="error-star" style="color:red;">*</span></label>
                        <input type="text" class="form-control default" id="level_name" name="level_name" min="0"
                            step="1">


                    </div>

                </div>

                <div class="row mt-3">
                    <div class="col-6">
                        <label>Minimum Point<span class="error-star" style="color:red;">*</span></label>
                        <input type="number" class="form-control default" id="min_point" name="min_point" step="1">

                    </div>
                    <div class="col-6">
                        <label>Maximum Point <span class="error-star" style="color:red;">*</span></label>
                        <input type="number" class="form-control default" id="max_point" name="max_point" step="1">
                    </div>

                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <label>Level Icons</label>
                        <input type="text" class="form-control default" id="level_icon" name="level_icon">
                    </div>

                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-center gap-2" style="margin-bottom:20px">
                            <button type="submit" id="updateButton" class="btn btn-success"
                                onclick="gencre(event)">Submit</button>
                            <a class="btn btn-danger btn-lg" href="{{ route('level_master_page') }}">Back</a>
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

        var level_number = $("#level_number").val().trim();
        var level_name = $("#level_name").val().trim();
        var min_point_val = $("#min_point").val().trim();
        var max_point_val = $("#max_point").val().trim();

        var min_point = parseInt(min_point_val);
        var max_point = parseInt(max_point_val);

        if (level_number === '') {
            Swal.fire("Please enter the Level Number", "", "error");
            return false;
        }
        if (level_name === '') {
            Swal.fire("Please enter the Level Name", "", "error");
            return false;
        }
        if (min_point_val === '') {
            Swal.fire("Please enter the Minimum Point", "", "error");
            return false;
        }
        if (max_point_val === '') {
            Swal.fire("Please enter the Maximum Point", "", "error");
            return false;
        }
        if (!isNaN(min_point) && !isNaN(max_point) && min_point > max_point) {
            Swal.fire("Minimum Point should not be greater than Maximum Point", "", "error");
            return false;
        }

        document.getElementById("levels_update").submit();
    }
</script>
<script>
    function fetch_show(level_id, type) {
        $.ajax({
            url: "{{ url('/level_show') }}",
            type: 'GET',


            data: {
                'level_id': level_id,
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                console.log(data);
                $('#level_number').prop('disabled', false).val(data.rows[0]['level_number']);
                $('#level_name').prop('disabled', false).val(data.rows[0]['level_name']);
                $('#min_point').prop('disabled', false).val(data.rows[0]['min_point']);
                $('#max_point').prop('disabled', false).val(data.rows[0]['max_point']);
                $('#level_icon').prop('disabled', false).val(data.rows[0]['level_icon']);
                $("#level_id").val(level_id);

                if (type === "show") {

                    $('#level_number').prop('disabled', true);
                    $('#level_name').prop('disabled', true);
                    $('#min_point').prop('disabled', true);
                    $('#max_point').prop('disabled', true);
                    $('#level_icon').prop('disabled', true);
                    $('#updateButton').hide();


                    document.getElementById("level_heading").innerHTML = "Levels";

                } else {
                    document.getElementById("level_heading").innerHTML = "Edit Levels";
                    document.getElementById("updateButton").innerHTML = "Update";
                    $('#updateButton').show();
                }
            }

        });
    }
</script>

<script>
    function fetch_delete(level_id, type) {
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
                    url: "{{ url('/level_delete') }}",
                    type: 'POST',
                    data: {
                        level_id: level_id,
                        _token: '{{ csrf_token() }}'
                    },
                    error: function() {
                        Swal.fire("Error!", "Something went wrong.", "error");
                    },
                    success: function(data) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Level Deleted Successfully.",
                            icon: "success"
                        }).then(() => {

                            window.location.href = "{{ route('level_master_page') }}";
                        });
                    }
                });
            }
        });

    }
</script>

@if(session('fail'))
<script>
    Swal.fire("{{ session('fail') }}", "", "error");
</script>
@endif

@endsection