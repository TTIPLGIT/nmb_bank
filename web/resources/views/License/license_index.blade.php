@extends('layouts.adminnav')
@section('content')




<title>Payment</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>


<style>
    #firmerror {
        color: red;
    }

    .is-invalid {
        border: 1px solid red !important;
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

    .nav-tabs .nav-item.show .nav-link,
    .nav-tabs .nav-link.active {
        background: #25867d !important;

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
        color: #000000;
        text-shadow: 0 1px 0 rgba(255, 255, 255, .8);
        border-radius: 5px 0 0 0;
        box-shadow: 0 2px 2px rgba(0, 0, 0, .4);
    }

    #tabs a:hover,
    #tabs a:hover::after,
    #tabs a:focus,
    #tabs a:focus::after {
        background: #ffffff;
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

    .card_body {
        border: none !important;
        box-shadow: none !important;
    }

    div.custom.tab {
        border: none !important;
        box-shadow: none !important;
    }

    .tabs #current a,
    .tabs #current a::after {
        background: #25867d;
        z-index: 3;
        color: white !important;
    }
</style>




<div class="main-content">
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



    <section class="section">
        {{ Breadcrumbs::render('license_index') }}





        <!-- <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                    <a class="nav-link  " id="home-tab" name="tab2" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-file" style="margin-right:5px"></i><b>License</b> <input type="checkbox" class="checkg" id="firmregis" name="nationality" readonly value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                        <div class="check"></div>
                    </a>
                </li> -->


        <div class="row">
            <div class="col-md-4">
                <div class="tile" id="tile-1" style="margin-top:10px !important;">

                    <!-- Nav tabs -->

                    <ul class="nav nav-tabs nav-justified " id="tabs" role="tablist">

                        <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                            <a class="nav-link  " id="home-tab" name="tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-money" style="margin-right:5px"></i><b>Payment</b> <input type="checkbox" class="checkg" id="paymentpa" name="nationality" readonly value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                                <div class="check"></div>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <select class="form-control default type-select" id="type_select" name="type-select">
                    <option value="" data-target="">Select Valuer Type</option>
                    @if(!isset($rows['payment_license'][0]))
                    <option value="Government Valuer" data-target="1">Government Valuer</option>
                    <option value="Private Valuer" data-target="2">Private Valuer</option>
                    @else
                    <option selected>{{$rows['payment_license'][0]['valuer_type']}}</option>
                    @endif
                </select>
            </div>
        </div>






        <div class="card">
            <div class="card-body custom" id="card_header">
                <div id="content">
                    <div id="tab1">
                        <section class="section">
                            <div class="section-body mt-1">

                                <!-- <input type="hidden" class="form-control" required id="user_id" name="user_id" readonly value=""> -->
                                <input type="hidden" class="form-control" required id="li_payment" name="user_details" readonly value="general">

                                <div class="row">
                                    <div class="col-lg-12 text-center">

                                        <h4>Individual License Process</h4>
                                    </div>
                                    <div class="col-12">
                                        <form action="{!!route('licensepayment')!!}" method="POST">
                                            @csrf
                                            <input type="hidden" name="valuerType" id="valuerType">
                                            <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="{{ config('setting.RAZORPAY_KEY') }}" data-amount="199900" data-button='false' data-name="MLHUD Payment" data-description="Payment" data-prefill.name="name" data-prefill.email="email" data-theme.color="#ff7529">
                                            </script>
                                            

                                            @if(!isset($rows['payment_license'][0]['status']) || $rows['payment_license'][0]['status']==1 )
                                            <button type="submit" style="font-size:15px;" class="btn btn-success btn-lg margin_bottom_15" title="Create" id="gcb">{{!isset($rows['payment_license'][0]['status'])? 'Add Payment' : 'Renew License'}}<i class="fa fa-plus" aria-hidden="true"></i></button>
                                            @endif
                                            <div class="card mt-0 card_body">
                                                <div class="card-body custom tab">
                                                    <div class="table-wrapper">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" id="align3">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Sl.No</th>
                                                                        <th>Professional MemberName</th>
                                                                        <th>Payment Type</th>
                                                                        <th>Transaction ID</th>
                                                                        <th>Amount</th>
                                                                        <th>Amount_Paid_on</th>
                                                                        <th>License Number</th>
                                                                        <th>Renewal Date</th>
                                                                        <th>Valuer Type</th>


                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($rows['payment_license'] as $key=>$data)

                                                                    <tr>

                                                                        <td>{{$loop->iteration}}</td>
                                                                        <td>{{$data['name']}}</td>
                                                                        <td>{{$data['method']}}</td>
                                                                        <td>{{$data['bank_transaction_id']}}</td>
                                                                        <td>{{$data['amount']}}</td>
                                                                        <td>{{$data['amount_paid_on']}}</td>
                                                                        <td>{{$data['license_number']}}</td>
                                                                        <td>{{$data['renewal_date']}}</td>
                                                                        <td>{{$data['valuer_type']}}</td>

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





                                </div>









                        </section>

                    </div>



                    <div id="tab2">
                        <section class="section">
                            <div class="section-body mt-1">

                                @if(count($rows['payment_license']) ==0 || ($rows['payment_license'][0]['status']) !=0 )
                                <form action="{{route('license_reg')}}" method="post" id="firm_reg" enctype="multipart/form-data">
                                    @csrf
                                    <input name="user_id" type="hidden" value="">
                                    <div class="section-body mt-1">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label"> Proof of Annual CPD <span style="color: red;font-size: 16px;">*</span></label>
                                                    <input class="form-control" type="text" id="certifi" name="annualcpd" value="20" autocomplete="off" required disabled>

                                                    <span class="span_message" id="certifierror"></span>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Enrolled Firm Name</label>
                                                    <select name="firm" id="firm" class="form-control" disabled>
                                                        @if($rows['firm_license'] !=[])
                                                        @foreach($rows['firm_license'] as $key=>$row2)
                                                        <option value="{{ $row2['partner_id'] }}" selected>{{$row2['firm_name']}}</option>
                                                        @endforeach
                                                        @else
                                                        <option value="" selected>Not Enrolled in any Firms</option>
                                                        @endif
                                                    </select>
                                                    <span class="span_message" id="selectfirmerror"></span>
                                                </div>
                                            </div>






                                            <div class="col-md-12" style="text-align:center">
                                                <button type="submit" class="btn btn-success btn-space">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                @else
                                <div class="card mt-0">
                                    <div class="card-body">
                                        <div class="table-wrapper">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="align1">
                                                    <thead>
                                                        <tr>
                                                            <th>Sl.No</th>
                                                            <th>License Number</th>
                                                            <th>Renewal Date</th>
                                                            <th>Annual CPD Points </th>



                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        @foreach($rows['payment_license'] as $key=>$data)
                                                        <tr>

                                                            <td>{{$loop->iteration}}</td>
                                                            <td>{{$data['license_number']}}</td>
                                                            <td>{{$data['renewal_date']}}</td>
                                                            <td>20</td>

                                                            <input type="hidden" class="cfn" id="valuer_id" value="">

                                                        </tr>

                                                        @endforeach
                                                        <input type="hidden" class="cfn" id="fn" value="1">

                                                    </tbody>

                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 text-center ">
                                    <!-- <a type="button" id="registerbutton1" class="btn btn-labeled btn-info" title="Submit" style="background: green !important; border-color:green !important; color:white !important; margin-top:15px">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-check"></i></span>Submit</a> -->
                                    <a type="button" class="btn btn-labeled btn-danger" onclick="DoAction('tab1');" title="next" style="background: red !important; border-color:#4d94ff !important; color:white !important;margin-top:15px">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>

                                </div>


                            </div>


                            @endif





                    </div>



    </section>


</div>


</div>
</div>
</div>

</section>
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

                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
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
                                    swal({
                                        title: "info",
                                        text: "Please do the Payment Process in order to proceed.",
                                        type: "info",
                                    });
                                }
                            }
                        });


                    });





                    $(document).ready(function() {

                        let url = new URL(window.location.href)
                        let message = url.searchParams.get("message");
                        if (message != null) {
                            window.history.pushState("object or string", "Title", "/firm_index");

                            swal({
                                title: "Success",
                                text: "Firm Registered Successfully",
                                type: "success",
                            });
                        }

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

                                swal({
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
                </script>
                <script>
                    function DoAction(id) {

                        $("#content").find("[id^='tab']").hide(); // Hide all content   
                        $("#tabs li").removeClass("active"); //Reset id's
                        $("#tabs a").removeClass("active"); //Reset id's
                        $("a[name='" + id + "']").parent().addClass("active");
                        $('#' + (id)).fadeIn(); // Show content for the current tab

                    }
                </script>

                <script>
                    function submit(e) {


                        const firm_name = document.getElementById("firm_name");
                        const description = document.getElementById("description");
                        const certifi = document.getElementById("certifi");
                        const location = document.getElementById("location");

                        e.preventDefault();

                        if (firm_name.value == "") {

                            document.getElementById("firmerror").innerHTML = "**Please Enter the Professional Member name**";

                        } else {
                            document.getElementById("firmerror").innerText = "";
                        }



                        if (certifi.value == "") {
                            document.getElementById("certifierror").innerHTML =
                                "**Please Upload the certification**";
                            return;
                        } else {
                            document.getElementById("certifierror").innerText = "";
                        }








                        $("#firm_reg").submit();

                    }
                    const licenceSubmit = (e) => {
                        e.preventDefault();
                        let valuerType = $('#type_select');
                        var valuerTypeValue = valuerType.val();
                        if (valuerTypeValue === '') {
                            valuerType.addClass('is-invalid');
                            Swal.fire("Info!", "Plese enter the valuer type", "info")
                            return false;
                        } else {
                            valuerType.removeClass('is-invalid');
                            Swal.fire({
                                title: 'Are you sure?',
                                text: `You have Selected the valuer type as ${valuerTypeValue}.`,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, Submit it!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#valuerType').val(valuerTypeValue);
                                    $('#gcb').submit();
                                }
                            })

                        }
                    }
                    $(document).on('click', '#gcb', function(event) {
                        licenceSubmit(event);
                    })
                </script>

                @endsection