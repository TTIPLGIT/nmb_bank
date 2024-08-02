@extends('layouts.adminnav')
@section('content')



<title>Payment</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>


<style>
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
        background: white;
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
        background: white;
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
        background: white;
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
        background: white;
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

    .cert {
        height: 40px;
    }
</style>




<div class="main-content">
    @if (session('success'))

    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data').val();
            swal.fire({
                icon: "Success",
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
            swal.fire({
                icon: "Info",
                title: "Info",
                text: message,
                type: "info",
            });

        }
    </script>
    @endif



    <section class="section">

        <div class="col-lg-12 text-center">

            <h4 style="color:darkblue;">Firm Registraion</h4>
        </div>
        <div class="tile" id="tile-1" style="margin-top:10px !important;">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-justified " id="tabs" role="tablist">
                <li class="nav-items navv" class="active" style="flex-basis: 1 !important;">
                    <a class="nav-link  " id="home-tab" name="tab1" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true"><i class="fa fa-user"></i><b>Firm Registraion</b> <input type="checkbox" class="checkg" id="firmregis" name="nationality" readonly value="0" onchange="submitval(this)" readonly style="background-color:solid green !important; color:green !important; visibility:hidden !important; ">
                        <div class="check"></div>
                    </a>
                </li>
            </ul>
        </div>


        <div id="content">
            <div id="tab1">
                <section class="section">
                    <div class="section-body mt-1">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Firm Name<span style="color: red;font-size: 16px;">*</span></label>
                                            <input class="form-control" type="text" id="firm_name" name="firm_name" value="{{$rows['firmregister_show'][0]['firm_name']}}" disabled autocomplete="off">

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Description</label>

                                            <textarea class="form-control" type="text" id="description" name="description" disabled autocomplete="off">{{$rows['firmregister_show'][0]['description']}}</textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">URSB<span style="color: red;font-size: 16px;">*</span></label>
                                                <span class="file_color d-flex align-items-baseline" id="document" name="" value="" accept=".pdf, .doc, .png," disabled autocomplete="off"><b>{{$rows['firmregister_show'][0]['certificate_name']}}</b>
                                                    <div class="form-group">
                                                        <div class="dropdown show">
                                                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" title="URSB" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                ...
                                                            </a>

                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                <a class="dropdown-item cert" title="view Document" data-toggle="modal" data-target="#templates" onClick="getproposaldocument('{{$rows['firmregister_show'][0]['certificate_path']}}/{{$rows['firmregister_show'][0]['certificate_name']}}')">View</a>

                                                                <a type="button" class="dropdown-item cert" title="Download Documents" href="{{$rows['firmregister_show'][0]['certificate_path']}}/{{$rows['firmregister_show'][0]['certificate_name']}}" download>Download</a>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>




                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Proof Of Location<span style="color: red;font-size: 16px;">*</span></label>
                                                <span class="file_color d-flex align-items-baseline" id="document" name="" value="" accept=".pdf, .doc, .png," disabled autocomplete="off"><b>{{$rows['firmregister_show'][0]['location_proof']}}</b>
                                                    <div class="form-group">
                                                        <div class="dropdown show">
                                                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" title="Proof Of Location" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                ...
                                                            </a>

                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                <a class="dropdown-item cert" title="view Document" data-toggle="modal" data-target="#templates" onClick="getproposaldocument('{{$rows['firmregister_show'][0]['location_proofpath']}}/{{$rows['firmregister_show'][0]['location_proof']}}')">View</a>
                                                                <a type="button" class="dropdown-item cert " title="Download Documents" href="{{$rows['firmregister_show'][0]['location_proofpath']}}{{$rows['firmregister_show'][0]['location_proof']}}" download>Download</a>


                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>




                                    </div>




                                    @foreach($rows['firmregister_show'] as $key=>$rows)

                                    <div class="row list_partners">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label">Partner Name<span style="color: red;font-size: 16px;">*</span></label>
                                                <select name="partner" id="partner" class="form-control" disabled>
                                                    <option value="{{$rows['partner_id']}}" selected>{{$rows['name']}}</option>
                                                </select>
                                                <span class="span_message" id="selectfirmerror"></span>
                                            </div>
                                        </div>



                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label class="control-label">Valid Practising Certificate<span style="color: red;font-size: 16px;">*</span></label>
                                                <span class="file_color d-flex align-items-baseline" id="document" name="" value="" accept=".pdf, .doc, .png," disabled autocomplete="off"><b>{{$rows['validpractisingcertificate_name']}}</b>
                                                    <div class="form-group">
                                                        <div class="dropdown show">
                                                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" title="Valid Practising Certificate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                ...
                                                            </a>

                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                <a class="dropdown-item cert" title="view Document" data-toggle="modal" data-target="#templates" onClick="getproposaldocument('{{$rows['validpractisingcertificate_path']}}/{{$rows['validpractisingcertificate_name']}}')">View</a>
                                                                <a type="button" class="dropdown-item cert" title="Download Documents" href="{{$rows['validpractisingcertificate_path']}}{{$rows['validpractisingcertificate_name']}}" download>Download</a>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>


                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label class="control-label">Particulars Directors<span style="color: red;font-size: 16px;">*</span></label>
                                                <span class="file_color d-flex align-items-baseline" id="document" name="" value="" accept=".pdf, .doc, .png," disabled autocomplete="off"><b>{{$rows['particulardirectorscertificate_name']}}</b>
                                                    <div class="form-group">
                                                        <div class="dropdown show">
                                                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" title="Particulars Directors" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                ...
                                                            </a>

                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                <a class="dropdown-item cert" title="view Document" data-toggle="modal" data-target="#templates" onClick="getproposaldocument('{{$rows['particulardirectorscertificate_path']}}/{{$rows['particulardirectorscertificate_name']}}')">View</a>
                                                                <a type="button" class="dropdown-item cert" title="Download Documents" href="{{$rows['particulardirectorscertificate_path']}}{{$rows['particulardirectorscertificate_name']}}" download>Download</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>

                                        @endforeach

                                        <div class="row justify-content-center mb-4">
                                            <a type="button" class="btn btn-labeled btn-info" href="/firm_index?tab=home-tab2" title="next" style="background: red !important; border-color:red !important; color:white !important; margin-top:15px !important;">
                                                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>
                                        </div>

                                    </div>




                                </div>
                            </div>
                        </div>

                    </div>
            </div>





        </div>





    </section>
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

                $("#content").find("[id^='tab']").hide(); // Hide all content
                $("#tabs li").removeClass("active"); //Reset id's
                $(this).parent().addClass("active"); // Activate this
                $('#' + $(this).attr('name')).fadeIn(); // Show content for the current tab


            }
        });


    });




    $(document).ready(function() {

        let url = new URL(window.location.href)
        let message = url.searchParams.get("message");
        if (message != null) {
            window.history.pushState("object or string", "Title", "/firm_index");

            swal.fire({
                icon: "Success",
                title: "Success",
                text: "Firm Registered Successfully",
                type: "success",
            });
        }

    })
</script>



<script>
    function getproposaldocument(id) {

        var data = (id);
        $('#modalviewdiv').html('');
        $("#loading_gif").show();
        console.log(id);

        $("#loading_gif").hide();
        var proposaldocuments = "<div class='removeclass' id='modalviewdiv' style=' height:100%'><iframe src='" + data + "' class='document_ifarme_view' style='width:100%; height:100%'></iframe></div>";
        $('.removeclass').remove();
        var document = $('#template').append(proposaldocuments);

    };
</script>



@include('Registration.formmodal')
@endsection