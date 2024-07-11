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
            <div class="" style="height:100%; padding: 15px">{{ Breadcrumbs::render('Registration.index') }}

                <form method="POST" id="registration_form" class="reset_form" enctype="multipart/form-data" onsubmit="return false">
                    @csrf  
                    <div id="tab4">
                        <section class="section">
                            <div class="section-body mt-0">
                                <div class="row">
                                    <div class="col-12">
                                        @if($rows['data2'] == [])
                                        <a type="button" style="font-size:15px; gap:5px;" class="btn btn-success btn-lg mb-2 ml-2" title="Create" id="eligcb" href="{{ route('Registration.create') }}" data-toggle="modal" data-target="#addeligModal">Select The Supervisors<i class="fa fa-plus pl-2" aria-hidden="true"></i></a>
                                        @endif
                                        @if($rows['reject'][0]['COUNT(id)'] > 0)
                                        <a type="button" style="font-size:15px; gap:5px;" class="btn btn-success btn-lg mb-2 ml-2" title="Create" id="elig" href="{{ route('Registration.create') }}" data-toggle="modal" data-target="#uniqueModal">Select The Supervisors<i class="fa fa-plus pl-2" aria-hidden="true"></i></a>
                                        @endif
                                        @if($rows['no_response'][0]['COUNT(id)'] > 0)
                                        <a type="button" style="font-size:15px; gap:5px;" class="btn btn-warning btn-lg mb-2 ml-2" title="Create" id="eligcr" href="{{ route('Registration.create') }}" data-toggle="modal" data-target="#respondModal">Reselect The Professional Member<i class="fa fa-plus pl-2" aria-hidden="true"></i></a>
                                        @endif
                                        @if($rows['approved'][0]['COUNT(id)'] > 0 && count($rows['is_change_request']) > 0) 

                                        <a type="button" style="font-size:15px;" class="btn btn-success btn-lg mb-2 ml-2" title="Create" id="eligaprrove" href="{{ route('Registration.create') }}" data-toggle="modal" data-target="{{count($rows['specialRequest']) == 0 ? '#approveModal' : '#viewResponse'}}">Change Request<i class="fa fa-plus" aria-hidden="true"></i></a>
                                        @endif
                                        <div class="card mt-0">
                                            <div class="card-body">
                                                <div class="table-wrapper">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" id="align7">
                                                            <thead>

                                                                <tr>
                                                                    <th>Sl.No</th>
                                                                    <th>Name</th>
                                                                    <th>Designation </th>
                                                                    <th>Status</th>

                                                                </tr>

                                                            </thead>
                                                            <tbody>
                                                                @if($rows['data2'] !=[])

                                                                @foreach($rows['data2'] as $data)
                                                                <tr>
                                                                    <td>{{$loop->iteration}}</td>
                                                                    <td>{{$data['name']}}</td>

                                                                    <td>{{$data['is_supervisor']==1 ? "Supervisor" : "counselor"}}</td>
                                                                    @if($data['approval_status']=="Approved")
                                                                    <td style="color:white;"><span class="badge2 success rounded-pill text-bg-success">Approved</span></td>

                                                                    @elseif($data['approval_status']=="Pending")
                                                                    <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending</span></td>

                                                                    @elseif($data['approval_status']=="No Response")
                                                                    <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">No Response</span></td>

                                                                    @elseif($data['approval_status']=="Rejected")
                                                                    <td style="color:white;"><span class="badge2 danger rounded-pill text-bg-warning">Rejected</span></td>

                                                                    @endif


                                                                </tr>

                                                                @endforeach
                                                                @endif


                                                            </tbody>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                <div class="col-lg-12" id="register">

                                    <form action="" method="POST">
                                        @csrf

                                        <div class="col-md-12 text-center">

                                            <input type="hidden" class="form-control" required id="reg_status" name="reg_status" value="">
                                            <input type="hidden" class="form-control" required id="user_id" name="user_id" value="">
                                            <input type="hidden" class="form-control" name="registration_status" value="Registered">





                                        </div>
                                    </form>
                                </div>


                                <div class="col-lg-12" id="registr">

                                    <form action="" method="POST">
                                        @csrf

                                        <div class="col-md-12 text-center">

                                            <input type="hidden" class="form-control" required id="reg_status" name="reg_status" value="">
                                            <input type="hidden" class="form-control" required id="user_id" name="user_id" value="">
                                            <input type="hidden" class="form-control" name="registration_status" value="Registered">
                                            <!-- <label style="color:black"><i><b>Please Click Submit to Complete Supplier Registration </b></i></label><br>
                                  
                                        <a type="button" id="registerbutton" class="btn btn-labeled btn-info" title="Submit" style="background: #4d94ff !important; border-color:#4d94ff !important; color:white !important">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-thumbs-up"></i></span>Submit</a> -->

                                        </div>
                                    </form>
                                </div>


                                <div class="col-md-12 text-center">

                                    <input type="hidden" class="form-control" required id="reg_status" name="reg_status" value="">
                                    <input type="hidden" class="form-control" required id="user_id" name="user_id" value="">
                                    <input type="hidden" class="form-control" name="registration_status" value="Registered">







                                </div>
                            </div>


                        </section>
                    </div>
                </form>
            </div>


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
                $('.reset_form')[index].reset();

            }

        })

    })
</script>


@include('Registration.eligibleedit')
@include('Registration.generalcreate')
@include('Registration.payment')
@include('Registration.eligiblecreate')
@include('Registration.eligibleshow')

@endsection