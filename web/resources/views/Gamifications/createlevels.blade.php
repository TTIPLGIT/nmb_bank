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
                <div class="section-body">{{ Breadcrumbs::render('final_assesment') }}

                    <div class="ml-5">



                    </div>
                    <div class="row">

                        <div class="col-12">

                            <div class="card">

                                <div class="card-body">
                                    <form method="POST"   action="{{ route('level_store') }}" id="levels_submit">
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
                                                <label>Maximum Point</label>
                                                <input type="number" class="form-control default" id="min_points" name="min_points" min="0" step="1">
                                            </div>
                                            <div class="col-6">
                                                <label>Minimum Point</label>
                                                <input type="number" class="form-control default" id="max_points" name="max_points" min="0" step="1">

                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-12">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <button type="submit" class="btn btn-success" onclick="gencre(event)">Submit</button>
                                                    <a class="btn btn-danger btn-lg" style="color:white;" href="{{ route('level_master_page') }}">Back</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>




            </section>



        </div>
    </section>

</div>

<link rel="stylesheet" href="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
<script>
    function gencre(event) {
        event.preventDefault(); // prevent default form submission

        var level_number = $("#level_number").val();
        var level_name = $("#level_name").val();
        if (level_number === '') {
            Swal.fire("Please Enter the Level Number ", "", "error");
            return false;
        }
        else if (level_name === '') {
            Swal.fire("Please Enter the Level Name ", "", "error");
            return false;
        }

        document.getElementById('levels_submit').submit();
    }
</script>
@endsection