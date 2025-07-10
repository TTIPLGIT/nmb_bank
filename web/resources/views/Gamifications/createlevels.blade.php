@extends('layouts.adminnav')

@section('content')
<style type="text/css">
    .dt-buttons.btn-group {
        display: none !important;
    }

    .mystyle {
        border: 2px solid red;
    }

    .submit_category button {
        display: flex;
        flex-direction: end;
        align-items: end;
    }
</style>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.3/xlsx.full.min.js"></script>
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <section class="section">
                <div class="section-body"> {{ Breadcrumbs::render('level_add_page') }}

                    <div class="ml-5">



                    </div>
                    <div class="row">

                        <div class="col-12">

                            <div class="card">

                                <div class="card-body">
                                    <form method="POST" action="{{ route('levels_store') }}" enctype="multipart/form-data" id="levels_submit">
                                        @csrf
                                        <h4 style="color:black;text-align:center;margin-bottom:20px">Create Levels</h4>

                                        <div class="row">
                                            <div class="col-6">
                                                <label>Level Number<span class="error-star" style="color:red;">*</span></label>
                                                <input type="number" class="form-control default" id="level_number" name="level_number" required>
                                            </div>
                                            <div class="col-6">
                                                <label>Level Name<span class="error-star" style="color:red;">*</span></label>
                                                <input type="text" class="form-control default" id="level_name" name="level_name" min="0" step="1">
                                            </div>

                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-6">
                                                <label>Minimum Point<span class="error-star" style="color:red;">*</span></label>
                                                <input type="number" class="form-control default" id="min_points" name="min_point" min="0" step="1">
                                            </div>
                                            <div class="col-6">
                                                <label>Maximum Point<span class="error-star" style="color:red;">*</span></label>
                                                <input type="number" class="form-control default" id="max_points" name="max_point" min="0" step="1">

                                            </div>


                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-6">
                                                <label>Level Icons<span class="error-star" style="color:red;">*</span></label>
                                                <input type="text" class="form-control default" id="level_icon" name="level_icon">
                                            </div>

                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-12">
                                                <div class="d-flex justify-content-center gap-2">

                                                    <a class="btn btn-success btn-space classsavebutton" type="submit" onclick="gencre(event)"
                                                        id="submitBtn">Submit</a>
                                                    <a class="btn btn-danger btn-lg" style="color:white;" href="{{ route('level_master_page') }}">Back</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </section>



        </div>
    </section>

</div>

<link rel="stylesheet" href="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
<script>
    function gencre(event) {
        event.preventDefault(); 

        let existingLevels = @json($allRecords['levels']);

        var level_number = $("#level_number").val().trim();
        var level_name = $("#level_name").val().trim();
        var min_point_val = $("#min_points").val().trim();
        var max_point_val = $("#max_points").val().trim();
        var level_icon = $("#level_icon").val().trim();

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
        if (level_icon === '') {
            Swal.fire("Please enter the Level Icon", "", "error");
            return false;
        }

     
        if (!isNaN(min_point) && !isNaN(max_point) && min_point > max_point) {
            Swal.fire("Minimum Point should not be greater than Maximum Point", "", "error");
            return false;
        }

     
        let conflict = existingLevels.some(level => {
            return level.min_point == min_point || level.max_point == max_point;
        });

        if (conflict) {
            Swal.fire("The minimum or maximum value already exists.");
            return false;
        }

    
        $('#classsavebutton').css('pointer-events', 'none');
        document.getElementById("levels_submit").submit();
    }
</script>


@if(session('fail'))
<script>
    Swal.fire("{{ session('fail') }}", "", "error");
</script>
@endif

@if(session('success'))
<script>
    Swal.fire("{{ session('success') }}", "", "success");
</script>
@endif




@endsection