@extends('layouts.adminnav')

@section('content')
<style>
    input[type=checkbox] {
        display: inline-block;
    }

    .no-arrow {
        -moz-appearance: textfield;
    }

    .no-arrow::-webkit-inner-spin-button {
        display: none;
    }

    .no-arrow::-webkit-outer-spin-button,
    .no-arrow::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .nav-tabs {
        background-color: #0068a7 !important;
        border-radius: 29px !important;
        padding: 1px !important;

    }

    .nav-item.active {
        background-image: linear-gradient(to right, #2a675a, #2a675a, #2a675a, #2a675a, #2a675a);
        border-radius: 31px !important;
        height: 100% !important;
    }

    .nav-link.active {
        background-image: linear-gradient(to right, #2a675a, #2a675a, #2a675a, #2a675a, #2a675a);
        border-radius: 31px !important;
        height: 100% !important;
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

    .gender {
        display: flex;
        align-items: center;
        justify-content: space-evenly;
    }

    .egc {
        display: flex;
        border: 1px solid #350756;
        padding: 8px 25px 8px 8px;
        align-items: center;

        justify-content: space-between;
    }

    .dq {
        font-size: 16px;
        width: 80%;
        font-weight: 600;
    }

    .answer {
        width: 15%;
        display: flex;
        color: #04092e !important;
        justify-content: space-around;
    }

    .questions {
        color: #000c62 !important
    }

    input[type='radio']:checked:after {
        background-color: #34395e !important;
    }

    input[type='radio']:after {
        background-color: #34395e !important;
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
    .vl {
        border-left: 1px solid #350756;
        height: 40px;
    }

    .close {
        color: red;
        opacity: 1;
    }

    .close:hover {

        color: red;

    }

    .note {
        background-image: linear-gradient(to right, #3f9a9d, #3f9a9d, #3f9a9d, #3f9a9d, #3f9a9d);
    }
</style>


<style>
    #counselorerroredit {
        color: red;
    }

    #supervisorerroredit {
        color: red;
    }
</style>



<div class="main-content main_contentspace">
    <div class="row justify-content-center">
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
       
        <div class="col-lg-12 col-md-12">
            <div class="" style="height:100%; padding: 15px">{{ Breadcrumbs::render('workexp_index') }}

                <form method="POST" id="registration_form" enctype="multipart/form-data" onsubmit="return false">
                    @csrf

                    <div id="tab3">
                        <section class="section">


                            <div class="section-body mt-0">

                                <div class="row">
                                    <div class="col-12">
                                        @if($rows['Experience']['index'] == [])
                                        <a type="button" style="font-size:15px;" class="btn btn-success btn-lg mb-2 ml-2" title="Create" id="expcb" href="{{ route('nruworkexp_create') }}">Add Experience Profile <i class="fa fa-plus" aria-hidden="true"></i></a>
                                        @endif
                                        <div class="card mt-0">


                                            <div class="card-body">



                                                <div class="table-wrapper">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" id="align7">
                                                            <thead>
                                                                <tr>
                                                                    <th>Sl.No</th>

                                                                    <th>Company Name</th>
                                                                    <th>Relevent work experience</th>
                                                                    <th>No of Certification</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($rows['Experience']['index'] as $data)
                                                                <tr>
                                                                    <td>{{$loop->iteration}}</td>


                                                                    <td>{{$data['c_name']}}</td>
                                                                    <td>{{$data['exp']}}</td>
                                                                  
                                                                    <td>{{count($rows['Experience']['cert'])}}</td>
                                                                    <td>Submitted</td>

                                                                    @php $id = Crypt::encrypt($data['user_id']); @endphp
                                                                    <td style="width:100px">
                </form>
                <form id="nru_destroy" action="{{ route('destroyexp',$id) }}" method="POST">
                    <a class="btn btn-link" title="Edit" href="{{route('expedit',$id) }}"><i class="fas fa-pencil-alt" style="color:darkblue"></i></a>
                    <a class="btn btn-link" title="show" href="{{route('expshow',$id) }}"><i class="fas fa-eye" style="color:blue"></i></a>

                    @csrf
                    @method('put')
                    <!-- <button type="submit" title="Delete" onclick="return confirm('Are you sure you want to delete this Experience details ? You may Delelting the Critical  data');" class="btn btn-link"><i class="far fa-trash-alt" style="color:red"></i></button> -->
                    <a type="submit" title="Delete" onclick="nruexpdel()" class="btn btn-link"><i class="far fa-trash-alt" style="color:red"></i></a>

                </form>
                </td>
                </tr>
                @endforeach
                <input type="hidden" class="cexpexperience" id="expexperience" value="0">

                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>



<!-- <div class="col-lg-12 text-center ">

                    <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab2');" title="back" style="background: red !important; border-color:red !important; color:white !important; margin-top:15px">
                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>
                    <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab4');" title="next" style="background: #4d94ff !important; border-color:#4d94ff !important; color:white !important; margin-top:15px">
                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-right"></i></span>Next</a>

                </div> -->
</div>
</div>
</section>
</div>

<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>

<script>
    function nruexpdel() {

        Swal.fire({

                title: "Are you sure you want to delete this Experience details ? You may Deleting the Critical data",
                icon: "warning",
                customClass: 'swalalerttext',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: true,
                showLoaderOnConfirm: true,
                width: '550px',
            })
            .then((result) => {
                if (result.value) {
                    document.getElementById('nru_destroy').submit();
                }
            });

        return false;
    }
</script>




@endsection