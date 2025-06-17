




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
        /* background-image: linear-gradient(to right, #3f9a9d, #3f9a9d, #3f9a9d, #3f9a9d, #3f9a9d); */
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
            <div class="" style="height:100%; padding: 15px">{{ Breadcrumbs::render('Registration.index') }}

                <form method="POST" id="registration_form" enctype="multipart/form-data" onsubmit="return false">
                    @csrf
<div id="tab5">
    <section class="section">


        <div class="section-body mt-0">


            <div class="row" id="committee_review">

                <div class="col-12">
                    <a type="hidden" style="font-size:15px;" class="" title="add payment" id="payment" data-toggle="modal" data-target="#addpayment"></a>

                    <div class="card mt-0">
                        <div class="card-header note">
                            <h3>Please Note</h3>
                        </div>

                        <input type="hidden" class="commitee_approve" id="commitee_approve" value="{{$rows['committe'][0]['COUNT(id)']}}">
                        <div class="card-body">
                            <p>Your Application is on Review, We will notify you via email when you got approved, if it has been a week kindly <b>Contact us</b> <a href="mlhudsupport@gmail.com">mlhudsupport@gmail.com</a></p>


                            <input type="hidden" class="payment_c" id="payment_c" value="0">
                            <input type="hidden" class="celigqa" id="requested_at" value="0">
                        </div>
                    </div>
                </div>
            </div>



            <div class="row d-none" id="committee_reviewed">

                <div class="col-12">
                    <a type="hidden" style="font-size:15px;" class="" title="add payment" id="payment" data-toggle="modal" data-target="#addpayment"></a>

                    <div class="card mt-0">
                        <div class="card-header note">
                            <h3>Please Note</h3>
                        </div>

                        <input type="hidden" class="commitee_approve" id="commitee_approve" value="{{$rows['committe'][0]['COUNT(id)']}}">
                        <div class="card-body">
                            <p>Your Application is Reviewed by TALENTRA</p>


                            <input type="hidden" class="payment_c" id="payment_c" value="0">
                            <input type="hidden" class="celigqa" id="requested_at" value="0">
                        </div>
                    </div>
                </div>
            </div>





            <div class="col-lg-12" id="register">

                <form action="{{ route('valuerlist.store') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="col-md-12 text-center">

                        <input type="hidden" class="form-control" required id="reg_status" name="reg_status" value="">
                        <input type="hidden" class="form-control" required id="user_id" name="user_id" value="">
                        <input type="hidden" class="form-control" name="registration_status" value="Registered">

                        <a type="button" class="btn btn-labeled btn-info" href="{{ url()->previous() }}" title="next" style="background: red !important; border-color:red !important; color:white !important; margin-top:15px">
                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>
                            
                    </div>
                </form>
            </div>





    </section>


</div>

<script>

var commitee_approve = document.getElementById('commitee_approve').value;

if (commitee_approve == '0') {
    document.getElementById('paymentct').style.display = "none";
    document.getElementById('payment').style.display = "inline-block";
    document.getElementById('paymentcheckbox').checked = false;

} else {
    
    document.getElementById('committee_reviewed').classList.remove('d-none');
    document.getElementById('committee_review').classList.add('d-none');


}
</script>
@include('Registration.eligibleedit')



@include('Registration.generalcreate')
@include('Registration.payment')
@include('Registration.eligiblecreate')
@include('Registration.eligibleshow')
@include('Registration.edit')
@include('Registration.show')
@endsection