@extends('layouts.adminnav')
@section('content')



<title>Payment</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script> -->


<style>
    .column_size {
        width: 10%;
    }

    #firmerror {
        color: red;
    }

    #descriptionerror {
        color: red;
    }

    #certifierror {
        color: red;
    }

    a:hover,
    a:focus {
        text-decoration: none;
        outline: none;
    }

    .danger {
        background-color: #ffdddd;
        border-left: 6px solid #f44336;
    }

    #align {
        border-collapse: collapse !important;
    }

    #tabs {
        overflow: hidden;
        width: 100%;
        margin: 0;
        padding: 0;
        list-style: none;
        font-size: 16px !important;
    }

    .nav-tabs .nav-item.show .nav-link .nav-tabs .nav-link.active {
        /* background: #25867d !important; */

    }

    .nav-tabs {
        padding: 5px !important;
    }

    #tabs li {
        float: left;
        margin: 0 .5em 0 0;
    }

    .questions {
        color: #34395e !important;
        font-weight: 700;
        font-size: 20px;
    }

    #tabs a {
        color: #000000 !important;
        position: relative;
        background: #d8ddd3;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        padding: .4em 1.5em;
        float: left;
        text-decoration: none;
        color: #444;
        text-shadow: 0 1px 0 rgba(255, 255, 255, .8);
        border-radius: 5px 0 0 0;
        box-shadow: 0 2px 2px rgba(0, 0, 0, .4);
    }

    #tabs a:hover,
    #tabs a:hover::after,
    #tabs a:focus,
    #tabs a:focus::after {
        background: #d8ddd3;
    }

    #tabs a:focus {
        outline: 0;
    }

    #tabs a::after {
        content: '';
        position: absolute;
        z-index: 1;
        top: 0;
        right: -.5em;
        bottom: 0;
        width: 1em;
        background: #d8ddd3;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        box-shadow: 2px 2px 2px rgba(0, 0, 0, .4);
        transform: skew(10deg);
        border-radius: 0 5px 0 0;
    }

    .nav-justified {
        background-image: none;
    }

    #tabs #addition-tab::after {
        content: '';
        position: absolute;
        z-index: 1;
        top: 0;
        right: -.5em;
        bottom: 0;
        width: 1em;
        background: #25867d;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        box-shadow: 2px 2px 2px rgba(0, 0, 0, .4);
        transform: skew(10deg);
        border-radius: 0 5px 0 0;
    }

    #tabs #current a,
    #tabs #current a::after {
        background: #25867d;
        z-index: 3;
        color: white !important;
    }

    .tabs {
        overflow: hidden;
        width: 100%;
        margin: 0;
        padding: 0;
        list-style: none;
        font-size: 16px !important;
    }

    .tabs li {
        float: left;
        margin: 0 .5em 0 0;
    }

    .questions {
        color: #34395e !important;
        font-weight: 700;
        font-size: 20px;
    }

    .tabs a {
        color: white !important;
        position: relative;
        background: #25867d;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        padding: .4em 1.5em;
        float: left;
        text-decoration: none;
        color: #444;
        text-shadow: 0 1px 0 rgba(255, 255, 255, .8);
        border-radius: 5px 0 0 0;
        box-shadow: 0 2px 2px rgba(0, 0, 0, .4);
    }

    .tabs a:hover,
    .tabs a:hover::after,
    .tabs a:focus,
    .tabs a:focus::after {
        background: #25867d !important;
    }

    .tabs a:focus {
        outline: 0;
    }

    .tabs a::after {
        content: '';
        position: absolute;
        z-index: 1;
        top: 0;
        right: -.5em;
        bottom: 0;
        width: 1em;
        background: #25867d;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        box-shadow: 2px 2px 2px rgba(0, 0, 0, .4);
        transform: skew(10deg);
        border-radius: 0 5px 0 0;
    }

    .nav-justified {
        background-image: none;
    }

    .tabs #addition-tab::after {
        content: '';
        position: absolute;
        z-index: 1;
        top: 0;
        right: -.5em;
        bottom: 0;
        width: 1em;
        background: #25867d;
        /* background-image: linear-gradient(to bottom, #1c92d2, #f2fcfe); */
        box-shadow: 2px 2px 2px rgba(0, 0, 0, .4);
        transform: skew(10deg);
        border-radius: 0 5px 0 0;
    }

    .tabs #current a,
    .tabs #current a::after {
        background: #25867d;
        z-index: 3;
        color: white !important;
    }

    .ad {
        background-color: green !important;
        display: flex;
        align-items: center;
        margin-top: 35px;
        border-radius: 26px;
    }


    .mi {
        background-color: red !important;
        display: flex;
        align-items: center;
        margin-top: 35px;
        border-radius: 26px;
    }

    .sub {
        pointer-events: none;
    }

    .waitingbadge {
        display: flex;
        background-color: orange !important;
        outline-color: black !important;
        padding: 2px !important;
        font-size: 11px;

    }

    .text-truncate {

        max-width: 120px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;


    }

    .expanded {
        white-space: normal;
        overflow: visible;
        text-overflow: initial;
    }

    .card_body {
        border: none !important;
        box-shadow: none !important;
    }

    div.custom.tab {
        border: none !important;
        box-shadow: none !important;
    }

    #tabs a:hover,
    #tabs a:hover::after,
    #tabs a:focus,
    #tabs a:focus::after {
        background: #ffffff;
        color: #000000;
    }



    .select2.select2-container.select2-container--default {
        width: 100% !important;
    }

    .select2-selection__rendered {
        align-items: center !important;
        display: flex !important;
    }

    .ellipsis {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        max-width: 200px;
        /* Adjust the value to fit your desired width */
    }
</style>




<div class="main-content">
    @if (session('success'))
    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
    <script type="text/javascript">
        $(document).ready(function() {
            var message = $('#session_data').val();
            swal.fire({
                title: "Success",
                text: message,
                icon: "success",
            });

        })
    </script>
    @elseif(session('error'))

    <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
    <script type="text/javascript">
        $(document).ready(function() {
            var message = $('#session_data1').val();
            swal.fire({
                title: "Info",
                text: message,
                icon: "info",
            });

        });
    </script>
    @endif


    {{ Breadcrumbs::render('Registrationfirm_index') }}

    <section class="section">

        <div class="tile" id="tile-1" style="margin-top:10px !important;">

            <!-- Nav tabs -->

            <ul class="nav nav-tabs nav-justified " id="tabs" role="tablist">
                <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                    <a class="nav-link" id="home-tab1" name="tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-money" style="margin-right:5px"></i><b>Payment</b> <input type="checkbox" class="checkg" id="paymentpa" name="nationality" readonly value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                        <div class="check"></div>
                    </a>
                </li>
                <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                    <a class="nav-link" id="home-tab2" name="tab2" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-user"></i><b>Firm Registraion</b> <input type="checkbox" class="checkg" id="firmregis" name="nationality" readonly value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                        <div class="check"></div>
                    </a>
                </li>
            </ul>
        </div>

        <div class="card">
            <div class="card-body custom" id="card_header">
                <div id="content">
                    <div id="tab1">
                        <section class="section">
                            <div class="section-body mt-1">
                                <!-- <input type="hidden" class="form-control" required id="user_id" name="user_id" readonly value=""> -->
                                <input type="hidden" class="form-control" required id="g_payment" name="user_details" readonly value="general">

                                <div class="row">
                                    <div class="col-12">
                                        <form action="{!!route('payment')!!}" method="POST">
                                            @csrf
                                            <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="{{ config('setting.RAZORPAY_KEY') }}" data-amount="10000" data-button='false' data-name="MLHUD Payment" data-description="Payment" data-prefill.name="name" data-prefill.email="email" data-theme.color="#ff7529">
                                            </script>
                                            <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                                            @if(isset($rows['payment'][0]['name']) == false)
                                            <button type="submit" style="font-size:15px;" class="btn btn-success btn-lg margin_bottom_15" title="Create" id="gcb">Add Payment<i class="fa fa-plus" aria-hidden="true"></i></button>
                                            @endif
                                            <div class="card mt-0 card_body">
                                                <div class="card-body custom tab">
                                                    <div class="col-lg-12 text-center">
                                                        <h4>Firm Payment</h4>
                                                    </div>
                                                    <div class="table-wrapper">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="align2">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Sl.No</th>
                                                                        <th>Name</th>
                                                                        <th>Payment Type</th>
                                                                        <th>Transaction ID</th>
                                                                        <th>Amount</th>
                                                                        <th>Paid_on</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($rows['payment'] as $key=>$data)

                                                                    <tr>
                                                                        <td>{{$loop->iteration}}</td>
                                                                        <td>{{$data['name']}}</td>
                                                                        <td>{{$data['method']}}</td>
                                                                        <td>{{$data['bank_transaction_id']}}</td>
                                                                        <td>{{$data['amount']}}</td>
                                                                        <td>{{$data['paid_on']}}</td>
                                                                        <input type="hidden" class="cfn" id="fn" value="">
                                                                    </tr>
                                                                    @endforeach
                                                                    <input type="hidden" class="cfn" id="fn" value="0">

                                                                </tbody>

                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>



                                    <div class="col-lg-12 text-center ">
                                        <!-- <a type="button" id="registerbutton1" class="btn btn-labeled btn-info" title="Submit" style="background: green !important; border-color:green !important; color:white !important; margin-top:15px">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Submit</a> -->
                                        <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab2');" title="next" style="background: #4d94ff !important; border-color:#4d94ff !important; color:white !important;margin-top:15px">
                                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-right"></i></span>Next</a>
                                        <a type="button" class="btn btn-labeled btn-info" href="{{route('home')}}" title="next" style="background: red !important; border-color:red !important; color:white !important; margin-top:15px !important;">
                                            <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>

                                    </div>

                                </div>
                        </section>
                    </div>
                    <div id="tab2">
                        <section class="section">
                            <div class="section-body mt-1">

                                @php $comment = '' @endphp

                                @if(count($rows['firm_registration']) ==0)
                                <form action=" {{route('firm_reg')}}" method="post" id="firm_reg" enctype="multipart/form-data">
                                    @csrf
                                    <input name="stakeholder_id" type="hidden" value="align">
                                    <div class="section-body mt-1">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Firm Name <span style="color: red;font-size: 16px;">*</span></label>
                                                    <input class="form-control" type="text" id="firm_name" name="firm_name" value="{{$rows['firmname'][0]['name']}}">
                                                    <span class="span_message" id="firmerror"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label"> Description </label>
                                                    <textarea class="form-control" type="text" id="description" name="description" placeholder="Enter Description" autocomplete="off"></textarea>
                                                    <span class="span_message" id="descriptionerror"></span>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">URSB Certificate<span style="color: red;font-size: 16px;">*</span></label>
                                                    <input class="form-control" type="file" id="certifi" name="ursb" value="" accept=".pdf,.png" autocomplete="off">
                                                    <strong style="color: red;">Following files could be uploaded pdf,png</strong>
                                                    <span class="span_message" id="certifierror"></span>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label"> Proof Of Location<span style="color: red;font-size: 16px;">*</span></label>
                                                    <input class="form-control" type="file" id="location" name="locationproof" value="" accept=".pdf,.png" autocomplete="off">
                                                    <strong style="color: red;">Following files could be uploaded pdf,png</strong>
                                                    <span class="span_message" id="locationerror"></span>
                                                </div>
                                            </div>


                                            <div class="row list_partners">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">List Of Partners Name<span style="color: red;font-size: 16px;">*</span></label>
                                                        <select name="partner[]" id="partner1" class="form-control search_partner selectpartner validate_this">
                                                            <option value="">Select Partners Name</option>
                                                            @foreach($rows['firm_partners'] as $key=>$row)

                                                            <option value="{{ $row['id'] }}">{{$row['name']}}</option>

                                                            @endforeach
                                                        </select>
                                                        <span class="span_message" id="selectfirmerror"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Valid Practising Certificate<span style="color: red;font-size: 16px;">*</span></label>
                                                        <input class="form-control validate_this" type="file" id="validpractising" name="validpractisingcertificate[]" value="" accept=".pdf,.png" mulitiple="multiple" autocomplete="off">
                                                        <strong style="color: red;">Following files could be uploaded pdf,png</strong>
                                                        <span class="span_message" id="validpractisingerror"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Particulars Directors <span style="color: red;font-size: 16px;">*</span></label>
                                                        <input class="form-control validate_this" type="file" id="directors" name="particularsdirectors[]" value="" accept=".pdf,.png" autocomplete="off">
                                                        <strong style="color: red;">Following files could be uploaded pdf,png</strong>
                                                        <span class="span_message" id="directorserror"></span>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <button type="button" name="add" id="addplus" onclick="Add_firm(event)" class="btn btn-success ad"><i class="fas fa-plus" style="color:white"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12" style="text-align:center">
                                                <a onclick="submit(event)" class="btn btn-success btn-space form_submit_handle">Submit</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                @else
                                <div class="card mt-0">
                                    <div class="card-body custom">
                                        <div class="col-lg-12 text-center">
                                            <h4>Firm Registration List view </h4>
                                        </div>
                                        <div class="table-wrapper">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="align1">
                                                    <thead>
                                                        <tr>
                                                            <th>Sl.No</th>
                                                            <th>firm name</th>
                                                            <th scope="col">Description</th>
                                                            <th class="column_size">URSB Certificate</th>
                                                            <th class="column_size">location proof</th>
                                                            <th>Comments(CGV)</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($rows['firm_registration'] as $key=>$data)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$data['firm_name']}}</td>
                                                            <td class="text-truncate">{{$data['description']}}</td>
                                                            <td class="ellipsis">
                                                                <?php
                                                                $filePath = app_path('Http/Controllers/basicfunctionController.php');
                                                                include_once $filePath;
                                                                $obj = new common_function;
                                                                $file_type = $obj->file_type($data['certificate_name']);
                                                                ?>

                                                                <img style="width: 26px;" src="{{ asset('asset/image/' . $file_type . '.png') }}">

                                                                <a href="{{$data['certificate_path']}}/{{$data['certificate_name']}}" download>{{$data['certificate_name']}}</a>
                                                            </td>
                                                            @php $file_type = $obj->file_type($data['location_proof']); @endphp
                                                            <td class="ellipsis"><img style="width: 26px;" src="{{ asset('asset/image/' . $file_type . '.png') }}">

                                                                <a href="{{$data['location_proofpath']}}/{{$data['location_proof']}}" download>{{$data['location_proof']}}</a>
                                                            </td>
                                                            @php $comment= $data['comments'] != '' ? $data['comments'] : 'No Comments'; @endphp
                                                            <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                                                    Comments
                                                                </button></td>
                                                            @if($data['status']==0)
                                                            <td style="color:white;"><button class="btn btn-warning">Pending</button></td>
                                                            @elseif($data['status']==1)
                                                            <td style="color:white;"><span class="badge2 success rounded-pill text-bg-warning">Approved</span></td>
                                                            @else
                                                            <td style="color:white;"><span class="badge2 danger rounded-pill text-bg-warning">Rejected</span></td>
                                                            @endif
                                                            <td>
                                                                <a class="btn btn-link" title="show" href="{{route('firmregistration_show')}}"><i class="fas fa-eye" style="color:green"></i>
                                                                    @if($data['status']==2)
                                                                    <a class="btn btn-link" title="edit" href="{{route('firmregistration_edit')}}"><i class="fas fa-pencil-alt" style="color:darkblue"></i></a>
                                                                    @endif
                                                            </td>
                                                            <input type="hidden" class="cfn" id="fn" value="">
                                                        </tr>
                                                        @endforeach
                                                        <input type="hidden" class="cfn" id="fn" value="0">

                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 text-center ">
                                <a type="button" class="btn btn-labeled btn-info" onclick="DoAction('tab1')" data-toggle="tab" id="backBtn" title="next" style="background: red !important; border-color:red !important; color:white !important; margin-top:15px !important;">
                                    <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>
                            </div>
                            @endif
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">CGV Comments</h5>
            </div>
            <div class="modal-body">
                <div class="comment">
                    <ul>
                        <li style="list-style: none;">
                            <h5>{!! $comment !!}</h5>
                        </li>
                    </ul>
                </div>
                <!-- <input class="form-control" type="text" id="cgv_comment" value="{!! $comment !!}" name="cgv_comment" autocomplete="off"> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="general_payment">
    <div class="modal-dialog modal-lg">


        <div class="modal-content" style="margin-left:10%; margin-top:10%">



            <div class="container">
                <div class="row" style="justify-content:center !important">
                    <div class="col-md-6 offset-3 col-md-offset-6" style=" display: flex; justify-content: center;">

                        @if($message = Session::get('error'))
                        <div class="alert alert-danger alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <strong>Error!</strong> {{ $message }}
                        </div>
                        @endif

                        @if($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade {{ Session::has('success') ? 'show' : 'in' }}" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <strong>Success!</strong> {{ $message }}
                        </div>
                        @endif


                        <form action="" method="POST">
                            @csrf
                            <input class="form-control paymentscreen" type="text" id="enrollment_child_num" name="enrollment_child_num" value="EN/2022/12/025 (Kaviya)" autocomplete="off">
                            <input class="form-control paymentscreen" type="text" id="child_id" name="child_id" value="CH/2022/025" autocomplete="off">
                            <input class="form-control paymentscreen" type="text" id="child_name" value="child_name" name="child_name" autocomplete="off">
                            <input class="form-control paymentscreen" type="text" id="initiated_by" name="initiated_by" value=" elinaishead1@gmail.com" autocomplete="off">
                            <input class="form-control paymentscreen" type="text" id="initiated_to" name="initiated_to" value=" kaviya@talentakeaways.com" autocomplete="off">
                            <input class="form-control paymentscreen" id="payment_amount" name="payment_amount" value="20000" autocomplete="off">
                            <input class="form-control paymentscreen" type="text" id="payment_status" name="payment_status" value="New" autocomplete="off">
                            <textarea class="form-control paymentscreen" type="textarea" id="payment_process_description" name="payment_process_description" value="kindly Pay Rs.20000 for your CoMPASS Registration">kindly Pay Rs.20000 for your CoMPASS Registration</textarea>
                            <textarea class="form-control paymentscreen" type="textarea" id="notes" name="notes" value=""></textarea>
                            <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="rzp_test_KUJc3PyWmtOLvw" data-amount="2000000" data-buttontext="Proceed to Pay" data-name="Elinaservices.com" data-description="Rozerpay" data-image="http://localhost:10/Elina_ISMS/web/public/asset/image/Elina-icon.JPG" data-prefill.name="name" data-prefill.email="kaviya@talentakeaways.com" data-theme.color="green">
                            </script>
                            <a type="button" class="btn btn-labeled back-btn" title="Back" href="" style="color:white !important">
                                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>

                        </form>


                    </div>
                </div>

                <!-- <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label"> Name <span style="color: red;font-size: 16px;">*</span></label>
                                <input class="form-control" type="text" id="Instruction_name" name="Instruction_name" placeholder="Enter Name" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label"> Payment Type <span style="color: red;font-size: 16px;">*</span></label>
                                <input class="form-control" type="text" id="description" name="description" placeholder="Enter Payment Type" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label"> Transaction Id <span style="color: red;font-size: 16px;">*</span></label>
                                <input class="form-control" type="text" id="description" name="description" placeholder="Enter Transaction id" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label"> Amount <span style="color: red;font-size: 16px;">*</span></label>
                                <input class="form-control" type="text" id="description" name="description" placeholder="Enter Amount" autocomplete="off">
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12" style="text-align:center;margin-bottom:2%">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div> -->


            </div>

            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>

<script>
    const selectInitiate = () => {
        $('.selectpartner').select2();
    }
    selectInitiate();
</script>
<script>
    function DoAction(id) {
        //alert(id);
        $("#content").find("[id^='tab']").hide(); // Hide all content   
        $("#tabs li").removeClass("active"); //Reset id's
        $("#tabs a").removeClass("active"); //Reset id's
        $("a[name='" + id + "']").parent().addClass("active");
        $('#' + (id)).fadeIn(); // Show content for the current tab
    }
</script>

<script>
    $(document).ready(function() {
        $('.razorpay-payment-button').hide();

        $("#content").find("[id^='tab']").hide(); // Hide all content
        $("#tabs li:first").addClass("active"); // Activate the first tab
        $("#tab1").fadeIn(); // Show first tab's content
        $('#tabs a').click(function(e) {

            e.preventDefault();
            if ($(this).closest("li").attr("id") == "current") { //detection for current tab

                return;
            } else {
                if (!$('#gcb').attr('id')) {
                    $("#content").find("[id^='tab']").hide(); // Hide all content
                    $("#tabs li").removeClass("active"); //Reset id's
                    $(this).parent().addClass("active"); // Activate this
                    $('#' + $(this).attr('name')).fadeIn(); // Show content for the current tab

                } else {
                    swal.fire({
                        title: "info",
                        text: "Please do the Payment Process in order to proceed.",
                        type: "info",
                        icon: "info",
                    });
                }
            }
        });
    });

    $(document).ready(function() {
        let url = new URL(window.location.href);
        let message = url.searchParams.get("message");
        let tab_switch = url.searchParams.get("tab");
        if (tab_switch != null) {
            document.querySelector(`#${tab_switch}`).click();
        }
        if (message != null) {
            window.history.pushState("object or string", "Title", "/firm_index");

            swal.fire({
                icon: "Success",
                title: "Success",
                text: "Firm Registered Successfully",
                type: "success",
            });
        }
        window.history.replaceState({}, document.title, url);
    })
</script>



<script>
    function delete1() {
        $.ajax({
            url: "{{ route('destroygen') }}",
            type: 'POST',
            data: {

                _token: '{{csrf_token()}}'
            },
            error: function() {
                alert('Something is wrong');
            },
            success: function(data) {

                swal.fire({
                        title: "Success",
                        text: "General Details Deleted Successfully",
                        type: "success"
                    },
                    function() {

                        window.location.href = "{{ url('Registration') }}";

                    }
                );
            }
        });

    }

    function Remove_firm(e) {
        e.target.parentElement.parentElement.parentElement.remove();

    }
</script>

<script>
    function append_function() {
        var $j = jQuery.noConflict();

        const partners = $('.search_partner');
        for (const partner of partners) {
            $(partner).select2();

        }
    }
    $(document).ready(function() {
        append_function();
    })

    function validateInputs() {
        var validates = $(".validate_this");
        for (const validate of validates) {
            if ($(validate).val() === "") {
                swal.fire("Please Enter all Fields", "", "error");
                return false;
            }
        }
        return true;
    }

    function Add_firm(e) {
        if (!validateInputs()) {
            return false;
        }

        const addplus =
            `<div class="row align-items-baseline"><div class="col-md-4">
                <div class="form-group">
                    <select name="partner[]" id="" class="form-control search_partner selectpartner validate_this">
                        <option value="">Select Partners Name</option>
                            @foreach($rows['firm_partners'] as $key=>$row)
                                <option value="{{ $row['id'] }}">{{$row['name']}}</option>
                            @endforeach
                    </select><span class="span_message" id="selectfirmerror"></span>
                </div> </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input class="form-control validate_this" type="file" id="validpractising" name="validpractisingcertificate[]" value="" accept=".pdf, .png," autocomplete="off">
                        <strong style="color: red;">Following files could be uploaded pdf,png</strong>
                        <span class="span_message" id="validpractisingerror"></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input class="form-control validate_this" type="file" id="directors" name="particularsdirectors[]" value="" accept=".pdf,.png," autocomplete="off">
                        <strong style="color: red;">Following files could be uploaded pdf,png</strong>
                        <span class="span_message" id="directorserror"></span>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <button type="button"  name="minus" id="subminus" onclick="Remove_firm(event)" class="btn btn-danger mi"><i class="fa fa-minus sub" style="color:white"></i></button>
                    </div>
                </div>
            </div>`;
        setTimeout(() => {
            append_function();
            let selectElements = $('.selectpartner');
            for (const selectElement of selectElements) {
                let elementValue = $(selectElement).val();
                if (elementValue != "") {
                    $('.selectpartner:last').find(`option[value=${elementValue}]`).prop('disabled', true);
                }
            }
            selectInitiate();
        }, 50);

        const adjasent_html = document.querySelector(".list_partners");
        adjasent_html.insertAdjacentHTML("beforeend", addplus);

    }
</script>

<script>
    // $(document).on('change', '.selectpartner', function(e) {
    //     var selectedValue = $(e.target).val();
    //     let selectedSelects = $('.selectpartner');
    //     $('.selectpartner').not(e.target).find(`option`).prop('disabled', false);
    //     for (const selectedSelect of selectedSelects) {
    //         let currentValue = $(selectedSelect).val();
    //         $('.selectpartner').not(e.target).find(`option[value=${currentValue}]`).prop('disabled', true);
    //     }
    //     selectInitiate();
    // })

    $(document).on("change", ".selectpartner", function(e) {
        var selectedValue = $(e.target).val();
        let selectedSelects = $(".selectpartner");
        $(".selectpartner").not(e.target).find('option').prop("disabled", false);
        const elements = $(".selectpartner");
        const values = elements.map((index, element) => $(element).val()).get();

        elements.each(function(index, element) {
            const currentValue = $(element).val();
            elements.not(element).each(function(innerIndex, innerElement) {
                if ($(innerElement).val() !== currentValue) {
                    $(innerElement).find(`option[value="${currentValue}"]`).prop("disabled", true);
                }
            });
        });
        selectInitiate();
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var descriptionColumns = document.getElementsByClassName('text-truncate');
        for (var i = 0; i < descriptionColumns.length; i++) {
            var column = descriptionColumns[i];
            column.addEventListener('click', function() {
                if (this.classList.contains('expanded')) {
                    this.classList.remove('expanded');
                } else {
                    this.classList.add('expanded');
                }
            });
        }
    });
</script>


<script>
    function submit(event) {
        var firm = $("#firm_name").val();

        if (firm == '') {
            swal.fire("Please Enter the Firm Name", "", "error");
            return false;
        }

        var desc = $("#description").val();
        if (desc == '') {
            swal.fire("Please Enter the Description", "", "error");
            return false;
        }

        var cert = $("#certifi").val();
        if (cert == '') {
            swal.fire("Please Select the URSB Certificate", "", "error")
            return false;
        }

        var locat = $("#location").val();
        if (locat == '') {
            swal.fire("Please Select the Proof of Location", "", "error")
            return false;
        }

        var part = $("#partner1").val();
        if (part == '') {
            swal.fire("Please Select the Partner Name", "", "error")
            return false;
        }

        var valid = $("#validpractising").val();
        if (valid == '') {
            swal.fire("Please Select the Valid Practising File", "", "error")
            return false;
        }

        var parti = $("#directors").val();
        if (parti == '') {
            swal.fire("Please Select the Particular Directors", "", "error")
            return false;
        }
        if (!validateInputs()) {
            return false;
        } else {
            preventSubmitButton('form_submit_handle');
            document.getElementById('firm_reg').submit();
        }

    }
</script>



@endsection