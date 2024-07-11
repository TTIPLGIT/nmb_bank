@extends('layouts.elearningmain')

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

    @media (min-width: 1024.96px) {
        .main-content {
            padding-top: 80px !important;
            padding-left: 200px !important;
        }
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
</style>

<style>
    .select2-container {
        min-width: 300px !important;
    }

    .select2-container--default .select2-search--inline .select2-search__field {
        width: 300px !important;
    }

    .select2-results__option {
        padding-right: 20px;
        vertical-align: middle;
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


<div class="main-content main_contentspace">
    <div class="row">
        {{ Breadcrumbs::render('elearning.cpt_index') }}
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
                            <h6>Total CPD Points:{{$rows['rows']['total_cptpoints'][0]['total_cptpoints'] }}</h6>
                            <div class="card mt-0">
                                <div class="card-body">
                                    <div class="col-lg-12 text-center">
                                        <h4>CPD Points View</h4>
                                    </div>
                                    <div class="table-wrapper">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="align1">
                                                <thead>
                                                    <tr>
                                                        <th>SI.No</th>
                                                        <th>Course Name</th>
                                                        <th>CPD Points</th>
                                                        <th>Completed at</th>

                                                    </tr>
                                                </thead>
                                                <tbody style="background-color: #cfe0e8;">

                                                    @foreach($rows['rows']['quiz_list'] as $data)

                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$data['course_name']}}</td>
                                                        <td class="ellipsis">{{$data['cpt_points']}}</td>
                                                        <td class="ellipsis">{{date('d-m-Y', strtotime($data['created_at']))}}</td>
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

            </form>
        </div>

    </div>

</div>
















@endsection