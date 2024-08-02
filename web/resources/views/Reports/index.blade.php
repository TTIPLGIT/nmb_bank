@extends('layouts.adminnav')

@section('content')
<style>
    .dt-buttons {
        display: block !important;
    }

    .main_contentspace {
        overflow-x: visible !important;
    }
    #tableExport2{
        width:100%;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>


<div class="main-content main_contentspace">
    <div class="row justify-content-center">
        @if (session('success'))
        <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
        <script type="text/javascript">
            window.onload = function() {
                var message = $('#session_data').val();
                swal.fire({
                    title: "success",
                    text: message,
                    icon: "success", // Add this line to set the success icon
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
                    icon: "success", // Add this line to set the success icon
                });


            }
        </script>
        @endif
        <div class="col-lg-12 col-md-12">{{ Breadcrumbs::render('reports') }}
            <div class="" style="height:100%; padding: 15px">

                <section class="section">
                    <div class="section-body mt-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="">
                                            <div class="row">
                                                <div class="col-lg-12 text-center">
                                                    <h4>Reports Filters</h4>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label"> Modules<span class="error-star" style="color:red;">*</span></label>
                                                        <select name="module_name" id="module_name" class="form-control" value="">
                                                            <option value="0" selected>Select Module</option>
                                                            <option id="1" value="1">User Management</option>
                                                            <option id="2" value="2">Instructions Module</option>
                                                            <option id="3" value="3">E-learning Module</option>
                                                            <option id="4" value="4">Administration Module</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Process<span class="error-star" style="color:red;">*</span></label>
                                                        <select name="process_name" id="process_name" class="form-control">
                                                            <option value="0" selected>Select Process</option>

                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 filter_display" id="user_filter_1" style="display:none">
                                                    <div class="form-group">
                                                        <label class="control-label">User Status<span class="error-star" style="color:red;">*</span></label>
                                                        <select name="status_by" id="status_by" class="form-control">
                                                            <option value="" selected>All</option>
                                                            <option id="1" value="0">Active</option>
                                                            <option id="2" value="1">De-Active</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 filter_display" id="user_filter_2" style="display:none">
                                                    <div class="form-group">
                                                        <label class="control-label">Role<span class="error-star" style="color:red;">*</span></label>
                                                        <select name="role_by" id="role_by" class="form-control">
                                                            <option value="" selected>All</option>
                                                            <option id="1" value="CGV">CGV</option>
                                                            <option id="2" value="GT">GT</option>
                                                            <option id="3" value="Professional Member">Professional Member</option>
                                                            <option id="4" value="SGV">SGV</option>
                                                            <option id="5" value="Goverment Stakeholder">Goverment Stakeholder</option>
                                                            <option id="6" value="Private Stakeholder">Private Stakeholder</option>
                                                            <option id="7" value="Register">Register</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 filter_display" id="license" style="display:none">
                                                    <div class="form-group">
                                                        <label class="control-label">License Status<span class="error-star" style="color:red;">*</span></label>
                                                        <select name="license_by" id="license_by" class="form-control">
                                                            <option value="" selected>All</option>
                                                            <option id="1" value="1">Active</option>
                                                            <option id="3" value="3">Expired</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 filter_display" id="licensestatus" style="display:none">
                                                    <div class="form-group">
                                                        <label class="control-label">License Status<span class="error-star" style="color:red;">*</span></label>
                                                        <select name="license_status" id="license_status" class="form-control">
                                                            <option value="" selected>All</option>
                                                            <option id="1" value="0">Active</option>
                                                            <option id="2" value="1">Expired</option>
                                                            <option id="3" value="2">Not Acquired</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 filter_display" id="gtstatusdisplay" style="display:none">
                                                    <div class="form-group">
                                                        <label class="control-label">GT Status<span class="error-star" style="color:red;">*</span></label>
                                                        <select name="gtstatus" id="gtstatus" class="form-control">
                                                            <option value="" selected>All</option>
                                                            <option id="1" value="Approved">Approved</option>
                                                            <option id="2" value="Pending">Pending</option>
                                                            <option id="3" value="Rejected">Rejected</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 filter_display" id="valuer_display" style="display:none">
                                                    <div class="form-group">
                                                        <label class="control-label">Valer Type<span class="error-star" style="color:red;">*</span></label>
                                                        <select name="valuer_type" id="valuer_type" class="form-control">
                                                            <option value="" selected>All</option>
                                                            <option id="1" value="1">Private Stakeholder</option>
                                                            <option id="2" value="2">Government Stakeholder</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 filter_display" id="valuer_status_display" style="display:none">
                                                    <div class="form-group">
                                                        <label class="control-label">Status<span class="error-star" style="color:red;">*</span></label>
                                                        <select name="valuer_status" id="valuer_status" class="form-control">
                                                            <option value="" selected>All</option>
                                                            <option id="1" value="0">Pending</option>
                                                            <option id="2" value="2">In-Review</option>
                                                            <option id="3" value="3">Received</option>
                                                            <option id="3" value="4">Rejected</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 filter_display" id="type_name" style="display:none">
                                                    <div class="form-group">
                                                        <label class="control-label">Status<span class="error-star" style="color:red;">*</span></label>
                                                        <select name="payment_type" id="payment_type" class="form-control">
                                                            <option value="" selected>All</option>
                                                            <option id="1" value="license payment">License Payment</option>
                                                            <option id="2" value="firm payment">Firm Payment</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 filter_display" id="course" style="display:none">
                                                    <div class="form-group">
                                                        <label class="control-label">Filter By<span class="error-star" style="color:red;">*</span></label>
                                                        <select name="course_details" id="course_details" class="form-control">
                                                            <option value="">Select the filter</option>
                                                            <option id="1" value="1">Course</option>
                                                            <option id="2" value="2">Events</option>
                                                            <option id="3" value="3">Notice Board</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 filter_display" id="course_list" style="display:none">
                                                    <div class="form-group">
                                                        <label class="control-label">Course List<span class="error-star" style="color:red;">*</span></label>
                                                        <select name="courselist" id="courselist" class="form-control">
                                                            <option value="">Select the Course name</option>
                                                            @foreach($course as $course)
                                                            <option id="{{$course->course_id}}" value="{{$course->course_id}}">{{$course->course_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label"> From Date </label>
                                                        <input type="date" class="form-control" id="from_date" name="from_date" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label"> To Date </label>
                                                        <input type="date" class="form-control" id="to_date" name="to_date" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" style="justify-content:center">
                                                <a class="btn btn-success" id="search_button">Search</a>
                                                <input type="reset" class="btn btn-danger" style="margin-left:3px" value="Reset">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-1" id="report_table" style="display:none">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title" style="text-align:center">
                                            <h4 id="module_name_display"></h4>
                                        </div>
                                        <div class="tableDiv"></div>
                                        <!-- <table class="table table-stripped tableExport2" id="tableExport2">
                                            <thead id="table_headers">
                                                <tr>
                                                </tr>

                                            </thead>
                                            <tbody id="table_data">

                                            </tbody>
                                        </table> -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById("module_name").addEventListener("change", function() {
        var selectedOption = this.value;
           document.getElementById("report_table").style.display = "none";
        
    });

    document.getElementById("process_name").addEventListener("change", function() {
        var selectedOption = this.value;
           document.getElementById("report_table").style.display = "none";
        
    });
    
</script>

<script>
    const moduleProcesses = {
        "1": [{
            text: "User Registration Report",
            value: 1
        }, {
            text: "Firm Management Reports",
            value: 2
        }, {
            text: "Licensed Users Report",
            value: 3
        }, {
            text: "GT Approval Reports",
            value: "4"
        }],
        "2": [{
            text: "Instructions Report",
            value: 5
        }],
        "3": [{
            text: "Professional Development Reports",
            value: 6
        }],
        "4": [{
            text: "User Engagement Reports",
            value: 7
        }, {
            text: "Financial Reports",
            value: 8
        }, {
            text: "Content Management Reports",
            value: 9
        }, {
            text: "System Maintenance Reports",
            value: 10
        }]
    };

    function updateProcessOptions(moduleId) {
        const processDropdown = document.getElementById("process_name");
        if (document.querySelectorAll('#process_name option:nth-child(n+2)')) {
            const optionsToRemove = document.querySelectorAll('#process_name option:nth-child(n+2)');
            optionsToRemove.forEach(option => option.remove());
        }

        const processes = moduleProcesses[moduleId] || [];

        processes.forEach((process, index) => {
            const option = document.createElement("option");
            option.value = process.value;
            option.text = process.text;
            processDropdown.appendChild(option);
        });
        // const table = document.getElementById("align_new");
        // if (table) {
        //     table.remove();
        // }
    }

    document.getElementById("module_name").addEventListener("change", function() {
        const selectedModuleId = this.value;
        updateProcessOptions(selectedModuleId);
    });
</script>

<!-- filter display -->
<script>
    document.getElementById('process_name').addEventListener('change', function() {
        var selectedProcess = this.value;
        var userStatusDropdown_1 = document.getElementById('user_filter_1');
        var userStatusDropdown_2 = document.getElementById('user_filter_2');
        var license = document.getElementById('license');
        var gtstatusdisplay = document.getElementById('gtstatusdisplay');
        $(".filter_display").hide();
        if (selectedProcess === '1') {
            userStatusDropdown_1.style.display = 'block';
            userStatusDropdown_2.style.display = 'block';
            // license.style.display = 'none';
        } else if (selectedProcess === '2') {
            license.style.display = 'block';
        } else if (selectedProcess === '3') {
            licensestatus.style.display = 'block';
        } else if (selectedProcess === '4') {
            gtstatusdisplay.style.display = 'block';
        } else if (selectedProcess === '5') {
            valuer_status_display.style.display = 'block';
            valuer_display.style.display = 'block';
        } else if (selectedProcess === '8') {
            type_name.style.display = 'block';
        } else if (selectedProcess === '6') {
            course.style.display = 'block';
        } else {
            userStatusDropdown_1.style.display = 'none';
            userStatusDropdown_2.style.display = 'none';
            license.style.display = 'none';
            gtstatusdisplay.style.display = 'none';
            licensestatus.style.display = 'none';
            valuer_status_display.style.display = 'none';
            valuer_display.status.display = 'none';
            type_name.style.display = 'none';
            course.style.display = 'none';

        }

    });

    $(document).ready(function() {
        $('#course_details').change(function() {
            if ($(this).val() == '1') {
                $('#course_list').show();
            } else {
                $('#course_list').hide();
            }
        });
    });
</script>

<!-- name display -->

<script>
    const moduleDropdown = document.getElementById("process_name");
    const moduleNameDisplay = document.getElementById("module_name_display");
    const filterby = document.getElementById("filterby");
    const reportTable = document.getElementById("report_table");
    const course_details = document.getElementById("course_details");
    const tableHeadersContainer = document.querySelector("#table_headers tr");
    let elearningColumns = [];
    // course


    moduleDropdown.addEventListener("change", function() {
        var selectedOption = this.options[this.selectedIndex];
        var selectedText = selectedOption.textContent;
        moduleNameDisplay.textContent = selectedText;
    });

   
</script>

<!-- validation -->

<script>
    let reportURL = "{{url('report_fetch')}}";
    let token = "{{csrf_token()}}";
    let image = "{{asset('images/MLHUD-IMG (1).png')}}";
</script>
<script src="{{ asset('js/table.js') }}"></script>

@endsection