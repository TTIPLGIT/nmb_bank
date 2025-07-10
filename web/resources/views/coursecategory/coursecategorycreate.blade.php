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
                <div class="section-body">{{ Breadcrumbs::render('catagory_create') }}


                    <div class="ml-5">



                    </div>
                    <div class="row">

                        <div class="col-12">

                            <div class="card">

                                <div class="card-body">
                                    <form method="POST" action="{{ route('catagory.store') }}" id="catagory_submit">
                                        @csrf
                                        <h4 style="color:black;text-align:center;margin-bottom:20px">Create Category</h4>

                                        <div class="row">
                                            <div class="col-6">
                                                <label>Category<span class="error-star" style="color:red;">*</span></label>
                                                <input type="text" class="form-control default" id="catagory_name" name="catagory_name" required>
                                            </div>
                                            <!-- <div class="col-6">
                                                <label>Sub Category</label>
                                                <input type="text" class="form-control default" id="sub_catagory" name="sub_catagory">
                                            </div> -->
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <label>Description</label>
                                                <textarea class="form-control default" id="description" name="description" style="height:200px;"></textarea>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-12">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <button type="submit" class="btn btn-success" onclick="gencre(event)">Submit</button>
                                                    <a class="btn btn-danger btn-lg" style="color:white;" href="{{ route('catagory_list') }}">Back</a>
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

        var category = $("#catagory_name").val();
        if (category === '') {
            Swal.fire("Please Enter the Catagory", "", "error");
            return false;
        }

        document.getElementById('catagory_submit').submit();
    }
</script>








@endsection