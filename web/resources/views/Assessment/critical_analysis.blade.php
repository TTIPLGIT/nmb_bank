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






<div class="main-content main_contentspace">
    <div class="row justify-content-center">
        @if (session('success'))

        <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
        <script type="text/javascript">
            window.onload = function() {
                var message = $('#session_data').val();
                swal({
                    title: "Success",
                    text: message,
                    type: "success",
                });

            }
        </script>
        @elseif(session('error'))

        <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
        <script type="text/javascript">
            window.onload = function() {
                var message = $('#session_data1').val();
                swal({
                    title: "Info",
                    text: message,
                    type: "info",
                });

            }
        </script>
        @endif
        <div class="col-lg-12 col-md-12">

            <form method="POST" id="registration_form" enctype="multipart/form-data" onsubmit="return false">
                @csrf

                <!-- Tab panes -->

                <div id="content">



                    <div id="tab2">

                        <section class="section">


                            <div class="section-body mt-1">


                                <div class="row">
                                    <div class="col-12">
                                       
                                        <a type="button" style="font-size:15px;" class="btn btn-success btn-lg" title="Create" id="educb" href="{{ route('educreate') }}">Add Education Profile <i class="fa fa-plus" aria-hidden="true"></i></a>
                                        <div class="card mt-0">


                                            <div class="card-body">

                                                <!-- @if ($message = Session::get('success'))
                                                                    <div class="alert alert-success alert-block">
                                                                        <button type="button" class="close" data-dismiss="alert">�</button>
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                    @endif

                                                                    @if ($message = Session::get('error'))
                                                                    <div class="alert alert-success alert-block">
                                                                        <button type="button" class="close" data-dismiss="alert">�</button>
                                                                        <strong>{{ $message }}</strong>
                                                                    </div>
                                                                    @endif -->
                                                <div class="table-wrapper">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" id="align3">
                                                            <thead>
                                                                <tr>
                                                                    <th>Sl.No</th>
                                                                    <th>critical_name</th>
                                                                    <th>view-comments</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>


                                                                <tr>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                             
                                                                    <input type="hidden" class="ceduid" id="eduid" value="{{$data['id']}}">

                                                                    <td style="width:max-content;">
            </form>


            <!-- <form action="{{ route('destroyedu',$id) }}" method="POST">
                <a class="btn btn-link" title="Edit" href=""><i class="fas fa-pencil-alt" style="color:darkblue"></i></a>
                <a class="btn btn-link" title="show" href=""><i class="fas fa-eye" style="color:blue"></i></a>
                <input type="hidden" class="form-control" required id="user_detail" name="user_detail" value="educate">

                @method('put')
                @csrf
                <button type="submit" title="Delete" onclick="return confirm('Are you sure you want to delete this general Profile ? You may Delelting the Critical  data');" class="btn btn-link"><i class="far fa-trash-alt" style="color:red"></i></button>



            </form> -->

            </td>

                                                                </tr>
           
            <input type="hidden" class="ceduid" id="eduid" value="0">

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


<div class="col-md-12 text-center">

</div>
</div>


</form>
</div>

</div>

</div>
</div>


@include('Registration.eligibleedit')



@include('Registration.generalcreate')
@include('Registration.payment')
@include('Registration.eligiblecreate')
@include('Registration.eligibleshow')
@include('Registration.edit')
@include('Registration.show')

@endsection