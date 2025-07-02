@extends('layouts.adminnav')
@section('content')

<style type="text/css">
    .dropdown-check-list {
        display: inline-block;
    }

    .dropdown-check-list .anchor {
        position: relative;
        cursor: pointer;
        display: inline-block;
        padding: 5px 50px 5px 10px;
        border: 2px solid #ccc;
        width: 300px;
    }

    .dropdown-check-list .anchor:after {
        position: absolute;
        content: "";
        border-left: 2px solid black;
        border-top: 2px solid black;
        padding: 5px;
        right: 10px;
        top: 20%;
        -moz-transform: rotate(-135deg);
        -ms-transform: rotate(-135deg);
        -o-transform: rotate(-135deg);
        -webkit-transform: rotate(-135deg);
        transform: rotate(-135deg);
    }

    .dropdown-check-list .anchor:active:after {
        right: 8px;
        top: 21%;
    }

    .dropdown-check-list ul.items {
        padding: 2px;
        display: none;
        margin: 0;
        border: 1px solid #ccc;
        border-top: none;
    }

    .dropdown-check-list ul.items li {
        list-style: none;
    }

    .dropdown-check-list.visible .anchor {
        color: #0094ff;
    }

    .dropdown-check-list.visible .items {
        display: block;
    }

    #professionalFields {
        display: none;
    }

    #professionalFields_1 {
        display: none;
    }

    .mobile_input {
        display: block;
        width: 100%;
        height: calc(1.5em + 0.75rem + 2px);
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        -webkit-transition: border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
        transition: border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
    }
</style>


<div class="main-content">
    <h5 class="text-center" style="color:darkblue">Users Create</h5>
    {{ Breadcrumbs::render('user.create') }}

    <!-- Main Content -->
    <section class="section">
        <div class="section-body mt-1">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form class="form-horizontal" name="uam_modules" method="POST" id="user_creation" action="{{ route('user.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">User Name <span style="color: red;font-size: 16px;">*</span></label>
                                            <input class="form-control" type="text" id="name" name="name" placeholder="Enter User Name" autofill="off">
                                            @error('name')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Email <span style="color: red;font-size: 16px;">*</span></label>
                                            <input class="form-control" type="email" id="email" name="email" placeholder="Enter Email">
                                            @error('email')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Password <span style="color: red;font-size: 16px;">*</span></label>
                                            <input class="form-control" type="text" id="password" name="password" placeholder="Enter Password">
                                            <!-- <label style="color:#f30202!important">Notes</label>
                                            <p> Validation Format - at least 1 uppercase character (A-Z),
                                                at least 1 lowercase character (a-z),
                                                at least 1 digit (0-9),
                                                at least 1 special character (punctuation)</p> -->
                                            @error('password')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Confirm Password <span style="color: red;font-size: 16px;">*</span></label>
                                            <input class="form-control" type="password" id="confirm_password" name="confirm_password" placeholder="Enter Password">
                                            @error('confirm_password')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Role Names<span style="color: red;font-size: 16px;">*</span></label>
                                            <select class="form-control" name="roles_id" id="roles_id" onchange="filterDesignations()">
                                                <option value="">Please Select Role</option>
                                                @foreach($rows as $key => $row)
                                                <option value="{{ $row['role_id'] }}">{{ $row['role_name'] }}</option>
                                                @endforeach
                                            </select>

                                            @error('roles_id')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Designation<span style="color: red;font-size: 16px;">*</span></label>
                                            <select class="form-control" name="designation_id" id="designation_id">
                                                <option value="">Please Select Designation</option>
                                                {{-- Designation options will be populated by JS --}}
                                            </select>

                                            @error('designation_id')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="professionalFields_1">
                                        <div class="form-group">
                                            <div class="col d-flex justify-content-start flex-column">
                                                <label class="control-label custom_label" for="newreval">Gender<span style="color: red;font-size: 16px;">*</span></label>
                                                <div class="col-12 d-flex align-items-baseline ml-4" style="gap:10px">
                                                    <input type="radio" id="gender" name="gender" value="" class="gender">
                                                    <label class="fw-light" for="male">Male</label>
                                                    <input type="radio" id="gender" name="gender" value="" class="gender">
                                                    <label for="female">Female</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="professionalFields" style="width:100%">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="custom_label" for="">Country<span style="color: red;font-size: 16px;">*</span></label>
                                                    <select class="form-control" id="country" name="country" value="">
                                                        <option value="uganda" selected>Uganda</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group" style="display:flex;flex-direction:column">
                                                    <label class="custom_label" for="Mobile Number">Mobile Number<span style="color: red;font-size: 16px;">*</span></label>
                                                    <input type="tel" id="phone" name="Mobile_no" value="" placeholder="" class="mobile_input" oninput="contactphonenumber(event)">
                                                    <span class="span_message" id="mobileerror"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <h4>Does this Professional Member have Registered License</h4>
                                        <div class="form-group">
                                            <div class="col d-flex justify-content-between">
                                                <div class="col-12 d-flex align-items-baseline ml-4" style="gap:10px">
                                                    <input type="radio" id="yes" name="license" onchange="toggleLicenseDetails(this)" value="yes" class="yes">
                                                    <label class="fw-light" for="yes">Yes</label>
                                                    <input type="radio" id="no" name="license" onchange="toggleLicenseDetails(this)" value="no" class="no">
                                                    <label for="no">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="licenseDetails" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="custom_label" for="license_number">Valuer Type</label>
                                                        <select name="valuertype" id="valuertype" class="form-control">
                                                            <option value="">Select Counsellor</option>
                                                            <option value="Government Valuer">Government Valuer</option>
                                                            <option value="Private Valuer">Private Valuer</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="custom_label" for="license_number">License Number</label>
                                                        <input type="text" id="license" name="license" value="" placeholder="Enter License Number" class="form-control default">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="custom_label" for="payment">Payment Method</label>
                                                        <input type="text" id="payment_method" name="payment" value="" placeholder="Enter Payment Method" class="form-control default">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="custom_label" for="bank_name">Bank Name</label>
                                                        <input type="text" id="bank_name" name="bank_name" value="" placeholder="Enter Bank Name" class="form-control default">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="custom_label" for="bank_name">Bank Transaction Id</label>
                                                        <input type="number" id="bank_transaction_id" name="bank_transaction_id" value="" placeholder="Enter Bank Transaction Id" class="form-control default">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="custom_label" for="amount">Amount</label>
                                                        <input type="number" id="amount" name="amount" value="" placeholder="Enter Amount" class="form-control default">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="custom_label" for="amount">Amount Paid On</label>
                                                        <input type="date" id="amount_paid_on" name="amount_paid_on" value="" placeholder="Enter Amount Paid On" class="form-control default">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="custom_label" for="renewal">Renewal Date</label>
                                                        <input type="date" id="renewal_date" name="renewal_date" value="" class="form-control default">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="custom_label" for="designation_notes">Notes<span style="color: red;font-size: 16px;">*</span></label>
                                                        <span style="color:Red">If you want to change the designation to professional member, kindly change the role in designation menu </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input id="displayItems" name="displayItems" class="form-control" type="hidden">
                                <input id="displayItems1" name="directorate_department" class="form-control" type="hidden">
                                <input id="displayItems2" name="displayItems2" class="form-control" type="hidden">
                                <div class="para"></div>
                                <input class="form-control" type="hidden" id="user_type" name="user_type" placeholder="Enter Password" value="AD">
                                <div class="row text-center">
                                    <div class="col-md-12 mt-3">
                                        <button onclick="user()" id="usersubmit" class="btn btn-success" type="submit"><i class="fa fa-check"></i> Submit</button>&nbsp;
                                        <button class="btn btn-primary" type="reset"><i class="fa fa-undo"></i> Undo </button>&nbsp;
                                        <a class="btn btn-danger footer_btn_cancel" href="{{ route('user.index') }}"><i class="fa fa-times" aria-hidden="true"></i> Cancel </a>&nbsp;
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div class="container-fluid" style="display: none">
                <div class="row">
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-5 text-center">
                        <div class="text-left">Override some defaults:</div>
                        <form id="override_options_form" method="POST" action="" style="display: none">
                            <div class="form-group">
                                <div class="checkbox text-left">
                                    <label><input id="checkbox_doubles" name="checkbox_doubles" value="1" type="checkbox" checked>Enable checking for n-tupel (doubles, triplets, ...) nodes</label>
                                </div>
                                <div class="checkbox text-left">
                                    <label><input id="checkbox_get_items" name="checkbox_get_items" type="checkbox" value="1" checked>Getting number of checked nodes on the fly</label>
                                </div>
                                <input type="hidden" name="select_tree" value="<br />
                    <b>Notice</b>: Undefined index: select_tree in <b>/storage/ssd4/607/2172607/public_html/hummingbird_v1.php</b> on line <b>317</b><br />">
                                <input type="hidden" name="override_options_form" value="1">
                                <button class="btn btn-responsive btn-block btn-primary" type="submit" id="submit_options">Submit</button>
                            </div>
                        </form>
                        <hr>
                    </div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css" />
            <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
            <script>
                const input = document.querySelector("#phone");
                const iti = window.intlTelInput(input, {
                    initialCountry: "ug",
                    utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js?1706723638591"
                });
            </script>
            <script type="text/javascript">
                $(".js-select2").select2({
                    closeOnSelect: false,
                    placeholder: " Please Select Roles ",
                    allowHtml: true,
                    allowClear: true,
                    tags: true // создает новые опции на лету
                });
                $(".js-select5").select2({
                    closeOnSelect: false,
                    placeholder: " Please Select Dashboard List ",
                    allowHtml: true,
                    allowClear: true,
                    tags: true // создает новые опции на лету
                });
            </script>

            <script type="text/javascript">
                $(document).ready(function() {
                    $("#treeview_example_code_button").on("click", function() {
                        var that_code = $("#treeview_example_code");
                        that_code.toggle();
                        //console.log($("#treeview_example_code").css("display"))
                        var that_code_display = that_code.css("display");
                        if (that_code_display == "none") {
                            $(this).text("Show HTML");
                        } else {
                            $(this).text("Hide HTML");
                        }
                    });


                    $("#treeview_example_search_html").on("click", function() {
                        var that_code = $("#treeview_example_search_html_display");
                        that_code.toggle();
                        //console.log($("#treeview_example_code").css("display"))
                        var treeview_example_search_html_mode = that_code.css("display");
                        if (treeview_example_search_html_mode == "none") {
                            $(this).text("Show HTML");
                        } else {
                            $(this).text("Hide HTML");
                        }
                    });

                    $("#treeview_example_search_css").on("click", function() {
                        var that_code = $("#treeview_example_search_css_display");
                        that_code.toggle();
                        //console.log($("#treeview_example_code").css("display"))
                        var treeview_example_search_css_mode = that_code.css("display");
                        if (treeview_example_search_css_mode == "none") {
                            $(this).text("Show CSS");
                        } else {
                            $(this).text("Hide CSS");
                        }
                    });


                    //---------------------measure time-------------------------------//
                    var responseTime = [];
                    var actualTime = [];
                    var responseTimeSend = false;
                    var responseTimeCounter = 0;



                    var startTime, endTime;

                    function measure_start() {
                        startTime = new Date();
                    };

                    function measure_end() {
                        endTime = new Date();
                        var timeDiff = endTime - startTime; //in ms
                        // strip the ms
                        timeDiff /= 1000;

                        // get seconds
                        //var seconds = Math.round(timeDiff % 60);
                        var seconds = timeDiff;
                        //console.log(seconds + " sec");
                        $("#time_measure").val(seconds + " sec");
                        //return seconds;
                    }

                    $.fn.hummingbird.defaults.collapseAll = true;
                    $.fn.hummingbird.defaults.checkboxes = "enabled";
                    $.fn.hummingbird.defaults.checkDoubles = false;
                    //override defaults
                    if ($("#checkbox_doubles").prop("checked") == true) {
                        $.fn.hummingbird.defaults.checkDoubles = true; //false //default="false"
                    } else {
                        $.fn.hummingbird.defaults.checkDoubles = false; //false //default="false"
                    }
                    //initializing
                    $("#treeview").hummingbird();
                    $("#treeview2").hummingbird();
                    $("#treeview2").hummingbird("expandNode", {
                        attr: "id",
                        name: "xnode-0-1",
                        expandParents: true
                    });
                    $('#treeview2').css({
                        "pointer-events": "none"
                    });
                    $("#treeview").hummingbird("expandNode", {
                        attr: "id",
                        name: "node-0",
                        expandParents: true
                    });
                    $("#CheckAll").on("click", function() {
                        measure_start();
                        $("#treeview").hummingbird("checkAll");
                        measure_end();
                    });
                    $("#UnCheckAll").on("click", function() {
                        measure_start();
                        $("#treeview").hummingbird("uncheckAll");
                        measure_end();
                    });
                    $("#CollapseAll").on("click", function() {
                        measure_start();
                        $("#treeview").hummingbird("collapseAll");
                        measure_end();
                    });
                    $("#ExpandAll").on("click", function() {
                        measure_start();
                        $("#treeview").hummingbird("expandAll");
                        measure_end();
                    });
                    $("#checkNode").on("click", function() {
                        measure_start();
                        $("#treeview").hummingbird("checkNode", {
                            attr: "id",
                            name: $("#checkNodeOnID").val(),
                            expandParents: false
                        });
                        measure_end();
                    });
                    $("#uncheckNode").on("click", function() {
                        measure_start();
                        $("#treeview").hummingbird("uncheckNode", {
                            attr: "id",
                            name: $("#uncheckNodeOnID").val(),
                            collapseChildren: false
                        });
                        measure_end();
                    });
                    $("#expandNode").on("click", function() {
                        measure_start();
                        $("#treeview").hummingbird("expandNode", {
                            attr: "id",
                            name: $("#expandNodeOnID").val(),
                            expandParents: true
                        });
                        measure_end();
                    });

                    $("#collapseNode").on("click", function() {
                        measure_start();
                        $("#treeview").hummingbird("collapseNode", {
                            attr: "id",
                            name: $("#collapseNodeOnID").val(),
                            collapseChildren: true
                        });
                        measure_end();
                    });
                    $("#enableNode").on("click", function() {
                        measure_start();
                        var state = $("#enable_state_true").prop("checked");
                        var enableChildren = $("#enable_state_true_children").prop("checked");
                        console.log("enableChildren= " + enableChildren)
                        $("#treeview").hummingbird("enableNode", {
                            attr: "id",
                            name: $("#enableNodeOnID").val(),
                            state: state,
                            enableChildren: enableChildren
                        });
                        measure_end();
                    });
                    $("#getItems").on("click", function() {
                        measure_start();
                        var List = {
                            "id": [],
                            "dataid": [],
                            "text": [],
                            "module": []
                        };
                        $("#treeview").hummingbird("getChecked", {
                            list: List,
                            onlyParents: true
                        });
                        $("#displayItems").val(List.dataid.join(","));
                        //$("#displayItems1").html(List.text.join("<br>"));
                        var L = List.id.length;
                        if (L == 1) {
                            $("#num").val(L + " item checked");
                        } else {
                            $("#num").val(L + " items checked");
                        }
                    });

                    $("#getItems").on("click", function() {
                        measure_start();
                        var List1 = {
                            "id": [],
                            "dataid": [],
                            "text": [],
                            "module": []
                        };
                        $("#treeview").hummingbird("getChecked", {
                            list: List1,
                            onlyEndNodes: true
                        });
                        console.log(List1);
                        $("#displayItems1").val(List1.dataid.join(":"));
                        $("#displayItems2").val(List1.id.join("-"));
                        //$("#displayItems1").html(List.text.join("<br>"));
                        var L = List1.id.length;
                        if (L == 1) {
                            $("#num").val(L + " item checked");
                        } else {
                            $("#num").val(L + " items checked");
                        }
                    });







                    if ($("#checkbox_get_items").prop("checked") == true) {

                        //do it once on initialisation
                        var List = {
                            "id": [],
                            "dataid": [],
                            "text": [],
                            "module": []
                        };
                        $("#treeview").hummingbird("getChecked", {
                            list: List,
                            onlyParents: true
                        });
                        $("#displayItems").val(List.dataid.join(","));
                        var L = List.id.length;
                        if (L == 1) {
                            $("#num").val(L + " item checked");
                        } else {
                            $("#num").val(L + " items checked");
                        }


                        var List1 = {
                            "id": [],
                            "dataid": [],
                            "text": [],
                            "module": []
                        };
                        $("#treeview").hummingbird("getChecked", {
                            list: List1,
                            onlyEndNodes: true
                        });
                        console.log(List1);
                        $("#displayItems1").val(List1.dataid.join(":"));
                        $("#displayItems2").val(List1.id.join("-"));
                        var L = List1.id.length;
                        if (L == 1) {
                            $("#num").val(L + " item checked");
                        } else {
                            $("#num").val(L + " items checked");
                        }


                        $("#treeview").on("CheckUncheckDone", function() {
                            var List = {
                                "id": [],
                                "dataid": [],
                                "text": [],
                                "module": []
                            };
                            $("#treeview").hummingbird("getChecked", {
                                list: List,
                                onlyParents: true
                            });
                            $("#displayItems").val(List.dataid.join(","));
                            var L = List.id.length;
                            if (L == 1) {
                                $("#num").val(L + " item checked");
                            } else {
                                $("#num").val(L + " items checked");
                            }
                        });


                        $("#treeview").on("CheckUncheckDone", function() {
                            var List1 = {
                                "id": [],
                                "dataid": [],
                                "text": [],
                                "dataid1": []
                            };
                            console.log($("#treeview").hummingbird("getChecked", {
                                list: List1,
                                onlyEndNodes: true
                            }));
                            console.log(List1);

                            $("#displayItems1").val(List1.id.join(":"));
                            $("#displayItems2").val(List1.dataid.join("-"));
                            var L = List1.id.length;
                            if (L == 1) {
                                $("#num").val(L + " item checked");
                            } else {
                                $("#num").val(L + " items checked");
                            }
                        });

                    }




                    $("#treeview").hummingbird("checkNode", {
                        attr: "id",
                        name: ["node-2-29"],
                        expandParents: false
                    });


                    /* $("#treeview").hummingbird("search",{treeview_container:"body",search_input:"search_input",search_output:"search_output",search_button:"search_button",scrollOffset:0,onlyEndNodes:false});*/

                    $("#treeview").hummingbird("search", {
                        treeview_container: "treeview_container",
                        search_input: "search_input",
                        search_output: "search_output",
                        search_button: "search_button",
                        scrollOffset: -515,
                        onlyEndNodes: false
                    });

                });
            </script>

            <script>
                function contactphonenumber(event) {
                    let value = event.target.value || '';
                    // value = removeURLs(value);
                    // if (urlPattern.test(value)) {
                    //     event.target.value = "";
                    //     return false;
                    // }
                    value = value.replace(/[^0-9+ ]/, '', );
                    event.target.value = value;
                    var get_phone = $('#phone').val();
                    var p1 = window.intlTelInputGlobals.getInstance(input).isValidNumber();
                    if (p1 == true) {
                        document.getElementById('mobileerror').style.color = 'green';
                        document.getElementById('mobileerror').innerHTML = 'Valid Number';
                    } else {
                        document.getElementById('mobileerror').style.color = 'red';
                        document.getElementById('mobileerror').innerHTML = 'Invalid Number';
                    }

                    document.getElementById("phone").innerHTML = get_phone;
                    document.getElementById('phone').value = get_phone;
                    // completeCheck(1);
                }


                function user() {
                    var uname = $("#name").val();
                    if (uname == '') {
                        swal("Please Enter the User Name", "", "error");
                        event.preventDefault();
                        return false;
                    }
                    var mail = $("#email").val();
                    if (mail == '') {
                        swal("Please Enter the Email", "", "error");
                        event.preventDefault();
                        return false;
                    }
                    var passw = $("#password").val();
                    if (passw == '') {
                        swal("Please Enter the Password", "", "error");
                        event.preventDefault();
                        return false;
                    }
                    var confpass = $("#confirm_password").val();
                    if (confpass == '') {
                        swal("Please Enter the Confirm Password", "", "error");
                        event.preventDefault();
                        return false;
                    }
                    var scrrole = $("select[name='roles_id']").val();
                    if (scrrole == '') {
                        swal("Please Select the Screen Roles", "", "error");
                        event.preventDefault();
                        return false;
                    } else {
                        document.getElementById("user_creation").submit();
                    }
                }
            </script>

            <script>
                function toggleProfessionalFields() {
                    var professionRole = document.getElementById('profession_role').value;
                    var professionalFields = document.getElementById('professionalFields');

                    if (professionRole === '34') {
                        professionalFields.style.display = 'block';
                        professionalFields_1.style.display = 'block';
                    } else {
                        professionalFields.style.display = 'none';
                        professionalFields_1.style.display = 'none';
                    }
                }
            </script>

            <script>
                function toggleLicenseDetails(radio) {
                    const licenseDetails = document.getElementById("licenseDetails");

                    if (radio.value === "yes") {
                        licenseDetails.style.display = radio.checked ? "block" : "none";
                    } else if (radio.value === "no") {
                        licenseDetails.style.display = "none";
                    }
                }
            </script>

            <!-- renewal date -->

            <script>
                $(document).ready(function() {
                    $('#amount_paid_on').change(function() {
                        var paidDate = new Date($('#amount_paid_on').val());
                        var newRenewalDate = new Date(paidDate.getFullYear() + 1, paidDate.getMonth(), paidDate.getDate());

                        // Format the date to match the input's date format
                        var formattedRenewalDate = newRenewalDate.toISOString().slice(0, 10);

                        // Set the renewal date input value
                        $('#renewal_date').val(formattedRenewalDate);
                    });
                });
            </script>
            <script>
                const allDesignations = @json($designation);
            </script>

            <script>
                function filterDesignations() {
                    const roleId = document.getElementById('roles_id').value;
                    const designationSelect = document.getElementById('designation_id');

                    // Clear old options
                    designationSelect.innerHTML = '<option value="">Please Select Designation</option>';

                    // Filter and append new options
                    const filtered = allDesignations.filter(d => d.role_id == roleId);

                    filtered.forEach(d => {
                        const opt = document.createElement('option');
                        opt.value = d.designation_id; // or role_id if that's the unique ID
                        opt.textContent = d.designation_name;
                        designationSelect.appendChild(opt);
                    });
                }
            </script>



            @endsection