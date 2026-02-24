@extends('layouts.adminnav')

@section('content')

<style type="text/css">
.buttons-html5 {
    background-color: #1bcd6b !important;
    padding: 10px;
    border: 1px;
    color: white;
}

.section {
    margin-top: 20px;
}

.modal-lg {
    max-width: 900px;
}

.modal-content {
    border-radius: 10px;
    overflow: hidden;
}

.modal-header.mh {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    padding: 20px;
    border-bottom: none;
}

.modal-title {
    font-weight: 600;
    margin: 0;
}

/* Add to your CSS file */
.modal-header .close {
    z-index: 9999 !important;
    position: relative;
}

.modal-header {
    position: relative;
    z-index: 1;
}
</style>

<div class="main-content">

    {{-- Session Messages --}}
    @if (session('success'))
    <input type="hidden" id="session_success" value="{{ session('success') }}">
    <script>
    window.onload = function() {
        swal({
            title: "Success",
            text: document.getElementById('session_success').value,
            type: "success",
        });
    }
    </script>
    @elseif(session('error'))
    <input type="hidden" id="session_error" value="{{ session('error') }}">
    <script>
    window.onload = function() {
        swal({
            title: "Info",
            text: document.getElementById('session_error').value,
            type: "info",
        });
    }
    </script>
    @endif

    <section class="section">

        <div class="col-lg-12 text-center">
            <h4 style="color:darkblue;">SCORM Package List</h4>
        </div>

        <div class="section-body mt-2">
            <div class="row">
                <div class="col-12">
                    <div class="card-body" id="card_header">

                        {{-- Upload Button --}}
                        <div class="row" style="justify-content:end">
                            <div class="col-md-3">
                                <form id="upload-form" action="{{ route('scorm.upload') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <input type="file" name="file" class="form-control" accept=".zip" required>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-upload"></i> Upload
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- Table --}}
                        <div class="table-wrapper">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="align">
                                    <thead>
                                        <tr>
                                            <th>Sl. No.</th>
                                            <th>Title</th>
                                            <th>Identifier</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($scormPackages as $index => $package)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $package->title }}</td>
                                            <td>{{ $package->identifier }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-danger delete-package"
                                                    data-id="{{ $package->id }}">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                                <a href="{{ url('/scorm/'.$package->id.'/launch') }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fa fa-play"></i> Publish
                                                </a>
                                                <button type="button" class="btn btn-success ms-0 ms-md-2"
                                                    data-toggle="modal" data-course-id="{{ $package->id }}"
                                                    data-target="#publishModal">
                                                    <i class="fas fa-play mr-2"></i> Publish Course
                                                </button>
                                            </td>

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
        <!-- Publish Course Modal -->


    </section>
</div>
<!-- Publish Course Modal -->
<div class="modal fade" id="publishModal" tabindex="-1" role="dialog" aria-labelledby="publishModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header mh">
                <h4 class="modal-title">Publish SCORM Package</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="card longquestion">
                <h4 class="modal-title long">Publish SCORM Package to Users:</h4>

                <!-- SINGLE FORM - removed the outer form and kept only this one -->
                <form method="POST" name="publish_scorm" action="" enctype="multipart/form-data"
                    id="publish_scorm_form">
                    @csrf

                    <div class="row">
                        <!-- Role Selection -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Role <span class="text-danger">*</span></label>
                                <select class="form-control" name="role_id" id="role_id" required>
                                    <option value="">---Select Role---</option>
                                    @foreach($roles as $role)
                                    <option value="{{ $role->role_id }}">{{ $role->role_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Designation Selection -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Designation <span class="text-danger">*</span></label>
                                <select class="form-control" name="designation_id" id="designation_id" required>
                                    <option value="">---Select Designation---</option>
                                    @foreach($designations as $designation)
                                    <option value="{{ $designation->designation_id }}">
                                        {{ $designation->designation_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Assign to Users <span class="text-danger">*</span></label>
                                <select name="user_ids[]" class="form-control js-select2" id="user_id" required
                                    multiple="multiple">
                                    <option value="All">All Users</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Select "All Users" to assign to everyone</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="course_name" name="course_name"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Banner:<span class="error-star" style="color:red;">*</span></label>
                                <input type="file" class="form-control default" id="course_banner" name="course_banner"
                                    accept="image/*" autocomplete="off" required>
                                <span style="color:red !important"><strong>Following files could be uploaded as
                                        jpeg,png,jpg</strong></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Course Certificate:<span class="error-star"
                                        style="color:red;">*</span></label><br>
                                <input type="radio" class="btn-check" name="course_certificate" value="1"
                                    id="course_certificate_yes" autocomplete="off" required>
                                <label class="btn btn-outline-primary" for="course_certificate_yes">Yes</label>

                                <input type="radio" class="btn-check" name="course_certificate" value="2"
                                    id="course_certificate_no" autocomplete="off" required>
                                <label class="btn btn-outline-primary" for="course_certificate_no">No</label>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="certificateFields">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Certificate Template:</label>
                                <select class="form-control" name="certificate_template" id="certificate_template">
                                    <option value="">Select Template</option>
                                    @foreach($certificate_templates as $template)
                                    <option value="{{ $template->certificate_templates_id }}">
                                        {{ $template->template_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Certificate Expiry:</label><br>
                                <input type="radio" class="btn-check certificate_expiry" name="certificate_expiry"
                                    value="1" id="expiry_yes" autocomplete="off">
                                <label class="btn btn-outline-primary" for="expiry_yes">Yes</label>

                                <input type="radio" class="btn-check certificate_expiry" name="certificate_expiry"
                                    value="2" id="expiry_no" autocomplete="off" checked>
                                <label class="btn btn-outline-primary" for="expiry_no">No</label>
                            </div>
                        </div>

                        <div class="col-md-3" id="expiryDateField" style="display: none;">
                            <div class="form-group">
                                <label>Expiry Date:</label>
                                <input type="date" class="form-control default" name="expiry_date"
                                    min="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 form-group"
                            style="display:flex;justify-content: space-evenly;align-items: center;">
                            <label>This Course has Start and End Period<span class="error-star"
                                    style="color:red;">*</span></label>
                            <div class="form-group">
                                <input type="radio" class="btn-check answer_show_on course_noperiod"
                                    name="course_noperiod" value="1" id="course_noperiodyes" autocomplete="off"
                                    required>
                                <label class="btn btn-outline-primary answer_show_on1"
                                    for="course_noperiodyes">Yes</label>

                                <input type="radio" class="btn-check answer_show_off course_noperiod"
                                    name="course_noperiod" value="2" id="course_noperiodno" autocomplete="off" required>
                                <label class="btn btn-outline-primary answer_show_off1"
                                    for="course_noperiodno">No</label>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="coursePeriodFields">
                        <div class="col-md-3"><label class="course_period">Course Period:<span class="error-star"
                                    style="color:red;">*</span></label></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Start Date:<span class="error-star" style="color:red;">*</span></label>
                                <input type='date' class="form-control default" id='course_start_period'
                                    name="course_start_period" title="Course Start Date" value="" autocomplete="off"
                                    min="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>End Date:<span class="error-star" style="color:red;">*</span></label>
                                <input type='date' class="form-control default" id='course_end_period'
                                    name="course_end_period" title="Course End Date" value="" autocomplete="off"
                                    min="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Restricted Access:</label><br>
                                <input type="radio" class="btn-check" name="restricted_access" value="1"
                                    id="restricted_yes" autocomplete="off">
                                <label class="btn btn-outline-primary" for="restricted_yes">Yes</label>

                                <input type="radio" class="btn-check" name="restricted_access" value="0"
                                    id="restricted_no" autocomplete="off" checked>
                                <label class="btn btn-outline-primary" for="restricted_no">No</label>
                            </div>
                        </div>

                        <div class="col-md-6" id="pinField" style="display: none;">
                            <div class="form-group">
                                <label>Access PIN:</label>
                                <input type="password" class="form-control default" name="access_pin"
                                    placeholder="Enter 4-6 digit PIN" maxlength="6">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="btn btn-success" id="publishbutton">
                                <span id="publishText">Publish SCORM</span>
                                <span id="publishSpinner" class="spinner-border spinner-border-sm d-none" role="status"
                                    aria-hidden="true"></span>
                            </button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
$(document).on('click', '.delete-package', function() {

    if (!confirm('Are you sure you want to delete this package?')) return;

    var id = $(this).data('id');

    $.ajax({
        url: '{{ url("scorm") }}/' + id,
        type: 'DELETE',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {

            if (response.status) {
                swal("Deleted", response.message, "success")
                    .then(() => location.reload());
            } else {
                swal("Error", response.message, "error");
            }
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
});
</script>

<script>
$('#publishModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var packageId = button.data('course-id'); // Extract package ID

    var form = $(this).find('form');
    var action = "{{ route('scorm_course_publish', ':id') }}";
    action = action.replace(':id', packageId);
    form.attr('action', action);
});
</script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- JavaScript for modal functionality -->
<!-- Replace the entire JavaScript section at the end with this: -->
<script type="text/javascript">
$(document).ready(function() {
    // Prevent horizontal scroll
    $('body').css('overflow-x', 'hidden');

    // Initialize Bootstrap 5 tabs
    var tabTriggerList = [].slice.call(document.querySelectorAll('#courseTabs button'));
    tabTriggerList.forEach(function(tabTriggerEl) {
        tabTriggerEl.addEventListener('click', function(event) {
            event.preventDefault();
            var tabTrigger = new bootstrap.Tab(tabTriggerEl);
            tabTrigger.show();
        });
    });

    // Check if select2 is available
    if (typeof $.fn.select2 === 'undefined') {
        console.error('Select2 is not loaded. Please include Select2 library.');
        // Load Select2 dynamically if not available
        $.getScript('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', function() {
            initializeSelect2();
        });
    } else {
        initializeSelect2();
    }

    function initializeSelect2() {
        // Initialize Select2
        $('.js-select2').select2({
            width: '100%',
            placeholder: "Select options",
            allowClear: true
        });

        // Initialize other select2 fields
        $('#course_classes').select2({
            width: '100%',
            placeholder: "Select classes",
            allowClear: true
        });
    }

    // Initialize fields based on current values
    function initializeFields() {
        // Show/Hide certificate fields
        if ($('input[name="course_certificate"]:checked').val() == '1') {
            $('#certificateFields').show();
        } else {
            $('#certificateFields').hide();
        }

        // Show/Hide exam fields
        if ($('input[name="course_exam"]:checked').val() == '1') {
            $('.examname').show();
        } else {
            $('.examname').hide();
        }

        // Show/Hide course period fields
        if ($('input[name="course_noperiod"]:checked').val() == '1') {
            $('#coursePeriodFields').show();
        } else {
            $('#coursePeriodFields').hide();
        }

        // Show/Hide PIN field
        if ($('input[name="restricted_access"]:checked').val() == '1') {
            $('#pinField').show();
        } else {
            $('#pinField').hide();
        }

        // Show/Hide expiry date field
        if ($('input[name="certificate_expiry"]:checked').val() == '1') {
            $('#expiryDateField').show();
        } else {
            $('#expiryDateField').hide();
        }
    }

    // Initialize fields on page load
    initializeFields();

    // Event handlers for field changes
    $('input[name="course_certificate"]').change(function() {
        if ($(this).val() == '1') {
            $('#certificateFields').show();
        } else {
            $('#certificateFields').hide();
            $('#expiryDateField').hide();
        }
    });

    $('input[name="course_exam"]').change(function() {
        if ($(this).val() == '1') {
            $('.examname').show();
        } else {
            $('.examname').hide();
        }
    });

    $('#course_pay').change(function() {
        if ($(this).val() == 'paid') {
            $('#paid').show();
            $('#free').hide();
        } else if ($(this).val() == 'free') {
            $('#free').show();
            $('#paid').hide();
        }
    });

    $('input[name="course_noperiod"]').change(function() {
        if ($(this).val() == '1') {
            $('#coursePeriodFields').show();
        } else {
            $('#coursePeriodFields').hide();
        }
    });

    $('input[name="restricted_access"]').change(function() {
        if ($(this).val() == '1') {
            $('#pinField').show();
        } else {
            $('#pinField').hide();
        }
    });

    $('input[name="certificate_expiry"]').change(function() {
        if ($(this).val() == '1') {
            $('#expiryDateField').show();
        } else {
            $('#expiryDateField').hide();
        }
    });

    // Initialize Bootstrap 5 modal for publishModal
    var publishModal = new bootstrap.Modal(document.getElementById('publishModal'));

    // Add click handler for the publish button
    $('button[data-target="#publishModal"]').click(function(e) {
        e.preventDefault();
        publishModal.show();
    });

    // Initialize fields on modal show
    $('#publishModal').on('shown.bs.modal', function() {
        initializeFields();
    });

    // Form submission with SweetAlert confirmation
    // $('#publish_course_form').submit(function(e) {
    //     e.preventDefault();

    //     // Show confirmation dialog
    //     Swal.fire({
    //         title: "Confirm Publication",
    //         text: "Are you sure you want to publish this course? Once published, it will be available to enrolled users.",
    //         icon: "warning",
    //         showCancelButton: true,
    //         confirmButtonColor: "#28a745",
    //         confirmButtonText: "Yes, publish it!",
    //         cancelButtonText: "Cancel",
    //         customClass: {
    //             confirmButton: 'btn btn-success',
    //             cancelButton: 'btn btn-secondary'
    //         },
    //         buttonsStyling: false
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             // Remove the event handler to allow default form submission
    //             $('#publish_course_form').off('submit').submit();
    //         }
    //     });
    // });
});
</script>

<!-- Bootstrap JS for Tabs -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    // Prevent horizontal scroll
    $('body').css('overflow-x', 'hidden');

    // Initialize Select2 with better "All" handling
    $('.js-select2').select2({
        width: '100%',
        placeholder: "Select options",
        allowClear: true,
        closeOnSelect: false
    });

    // Handle "All" selection logic
    $('#user_id').on('select2:select', function(e) {
        var data = e.params.data;

        if (data.id === 'all') {
            // If "All" is selected, deselect all other options
            $('#user_id').val(['all']).trigger('change');
        } else {
            // If any other option is selected, remove "all" if it exists
            var currentValues = $('#user_id').val();
            if (currentValues && currentValues.includes('all')) {
                currentValues = currentValues.filter(function(value) {
                    return value !== 'all';
                });
                $('#user_id').val(currentValues).trigger('change');
            }
        }
    });

    $('#user_id').on('select2:unselect', function(e) {
        var data = e.params.data;

        if (data.id === 'all') {
            // If "All" is deselected, ensure no other options remain
            $('#user_id').val(null).trigger('change');
        }
    });
    // Initialize fields based on current values
    function initializeFields() {
        // Show/Hide certificate fields
        if ($('input[name="course_certificate"]:checked').val() == '1') {
            $('#certificateFields').show();
        } else {
            $('#certificateFields').hide();
        }

        // Show/Hide exam fields
        if ($('input[name="course_exam"]:checked').val() == '1') {
            $('.examname').show();
        } else {
            $('.examname').hide();
        }

        // Show/Hide course period fields
        if ($('input[name="course_noperiod"]:checked').val() == '1') {
            $('#coursePeriodFields').show();
        } else {
            $('#coursePeriodFields').hide();
        }

        // Show/Hide PIN field
        if ($('input[name="restricted_access"]:checked').val() == '1') {
            $('#pinField').show();
        } else {
            $('#pinField').hide();
        }

        // Show/Hide expiry date field
        if ($('input[name="certificate_expiry"]:checked').val() == '1') {
            $('#expiryDateField').show();
        } else {
            $('#expiryDateField').hide();
        }
    }

    // Initialize fields on page load
    initializeFields();

    // Event handlers for field changes
    $('input[name="course_certificate"]').change(function() {
        if ($(this).val() == '1') {
            $('#certificateFields').show();
        } else {
            $('#certificateFields').hide();
            $('#expiryDateField').hide();
        }
    });

    $('input[name="course_exam"]').change(function() {
        if ($(this).val() == '1') {
            $('.examname').show();
        } else {
            $('.examname').hide();
        }
    });

    $('#course_pay').change(function() {
        if ($(this).val() == 'paid') {
            $('#paid').show();
        } else {
            $('#paid').hide();
        }
    });

    $('input[name="course_noperiod"]').change(function() {
        if ($(this).val() == '1') {
            $('#coursePeriodFields').show();
        } else {
            $('#coursePeriodFields').hide();
        }
    });

    $('input[name="restricted_access"]').change(function() {
        if ($(this).val() == '1') {
            $('#pinField').show();
        } else {
            $('#pinField').hide();
        }
    });

    $('input[name="certificate_expiry"]').change(function() {
        if ($(this).val() == '1') {
            $('#expiryDateField').show();
        } else {
            $('#expiryDateField').hide();
        }
    });

    // Initialize Bootstrap modal
    var publishModal = new bootstrap.Modal(document.getElementById('publishModal'));

    // Add click handler for the publish button
    $('button[data-target="#publishModal"]').click(function(e) {
        e.preventDefault();
        // Make sure the exam ID is properly populated
        var examId = $('#original_exam_id').val();
        if (examId) {
            // Set the exam name dropdown
            $('#exam_name').val(examId).trigger('change');
        }
        publishModal.show();
    });

    // Initialize fields on modal show
    $('#publishModal').on('shown.bs.modal', function() {
        initializeFields();

        // Disable non-editable fields
        $('#role_id, #designation_id, #course_name, #course_description').prop('disabled', true);

        // Add readonly styling
        $('#course_name, #course_description').css({
            'background-color': '#f8f9fa',
            'cursor': 'not-allowed'
        });
    });

    $('#publish_course_form').submit(function(e) {
        e.preventDefault();

        // Process user_ids - if "all" is selected, convert to comma-separated all user IDs
        var selectedUserIds = $('#user_id').val();
        var allUserIds = [];

        if (selectedUserIds && selectedUserIds.includes('all')) {
            // Get all user IDs except "all"
            $('#user_id option').each(function() {
                var value = $(this).val();
                if (value !== 'all' && value !== '') {
                    allUserIds.push(value);
                }
            });

            // Create hidden input with all user IDs
            $('<input>').attr({
                type: 'hidden',
                name: 'user_ids[]',
                value: 'all' // Send 'all' as a special value
            }).appendTo('#publish_course_form');

            // Also store the actual IDs in another field
            $('<input>').attr({
                type: 'hidden',
                name: 'all_user_ids_string',
                value: allUserIds.join(',')
            }).appendTo('#publish_course_form');

            console.log('All User IDs selected, sending "all" as value');

            // Clear the original user_ids field to prevent conflict
            $('#user_id').val('');
        } else {
            // If specific users are selected, ensure it's not empty
            if (!selectedUserIds || selectedUserIds.length === 0) {
                Swal.fire({
                    title: "Error",
                    text: "Please select at least one user or select 'All'",
                    icon: "error",
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "OK",
                    customClass: {
                        confirmButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                });
                return false;
            }
        }

        // Show confirmation dialog
        Swal.fire({
            title: "Confirm Publication",
            text: "Are you sure you want to publish this course? Once published, it will be available to enrolled users.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#28a745",
            confirmButtonText: "Yes, publish it!",
            cancelButtonText: "Cancel",
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form
                $(this).off('submit').submit();
            }
        });
    });

    // Re-enable fields when modal is hidden
    $('#publishModal').on('hidden.bs.modal', function() {
        $('#role_id, #designation_id, #course_name, #course_description').prop('disabled', false);
        $('#course_name, #course_description').css({
            'background-color': '',
            'cursor': ''
        });
        // Remove any hidden inputs added
        $('input[name="all_user_ids"]').remove();
    });
});

function resetSelect2() {
    $('.js-select2').val(null).trigger('change');
}
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get form and button elements
    const form = document.getElementById('publish_course_form');
    const publishButton = document.getElementById('publishbutton');
    const publishText = document.getElementById('publishText');
    const publishSpinner = document.getElementById('publishSpinner');

    // Flag to track if we're submitting
    let isSubmitting = false;

    // Form submit handler
    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Always prevent default first
        e.stopPropagation(); // Stop event bubbling

        console.log('Form submit event triggered'); // Debug

        // Prevent multiple submissions
        if (isSubmitting) {
            console.log('Already submitting, ignoring');
            return false;
        }

        // Validate form before submission
        const isValid = validateForm();
        console.log('Validation result:', isValid); // Debug

        if (!isValid) {
            console.log('Validation failed - stopping submission');

            // Show error message
            Swal.fire({
                title: "Validation Error",
                text: "Please correct the errors in the form before submitting.",
                icon: "error",
                confirmButtonColor: "#dc3545",
            });

            return false; // Stop execution
        }



        // Set submitting flag
        isSubmitting = true;

        // Show loader and disable button
        publishButton.disabled = true;
        publishText.textContent = 'Publishing...';
        publishSpinner.classList.remove('d-none');

        // Create a new form element and submit it to avoid event listeners
        setTimeout(() => {
            console.log('Executing form submission');

            // Method 1: Clone the form and submit the clone
            const formClone = form.cloneNode(true);
            formClone.style.display = 'none';
            document.body.appendChild(formClone);

            // Remove event listeners from clone
            const newForm = formClone.cloneNode(true);
            formClone.parentNode.replaceChild(newForm, formClone);

            // Submit the clean form
            newForm.submit();

            // Method 2: Use AJAX instead (better approach)
            // submitFormViaAjax();

        }, 500);

        return false;
    });

    // Form validation function
    function validateForm() {
        let isValid = true;

        console.log('Starting validation...'); // Debug

        // Clear previous error messages
        clearErrors();

        // Validate Course Type
        const courseType = document.getElementById('course_pay');
        if (!courseType.value) {
            showError(courseType, 'Course Type is required');
            isValid = false;
            console.log('Course Type validation failed');
        }

        // If paid course, validate price
        if (courseType.value === 'paid') {
            const coursePrice = document.getElementById('course_price');
            if (!coursePrice.value || parseFloat(coursePrice.value) <= 0) {
                showError(coursePrice, 'Valid course price is required for paid courses');
                isValid = false;
                console.log('Course Price validation failed');
            }
        }

        // Validate Certificate Template if certificate is yes
        const certificateYes = document.getElementById('course_certificate_yes');
        if (certificateYes.checked) {
            const certificateTemplate = document.getElementById('cetificate_template');
            if (!certificateTemplate.value) {
                showError(certificateTemplate, 'Certificate Template is required when certificate is enabled');
                isValid = false;
                console.log('Certificate Template validation failed');
            }

            // Validate expiry date if certificate expiry is yes
            const expiryYes = document.getElementById('certificate_expiryyes');
            if (expiryYes.checked) {
                const expiryDate = document.getElementById('course_expiry_period');
                if (!expiryDate.value) {
                    showError(expiryDate, 'Expiry Date is required when certificate expiry is enabled');
                    isValid = false;
                    console.log('Expiry Date validation failed');
                }
            }
        }

        // Validate Course Period dates if enabled
        const periodYes = document.getElementById('course_noperiodyes');
        if (periodYes.checked) {
            const startDate = document.getElementById('course_start_period');
            const endDate = document.getElementById('course_end_period');

            if (!startDate.value) {
                showError(startDate, 'Start Date is required');
                isValid = false;
                console.log('Start Date validation failed');
            }
            if (!endDate.value) {
                showError(endDate, 'End Date is required');
                isValid = false;
                console.log('End Date validation failed');
            }

            // Validate date range
            if (startDate.value && endDate.value) {
                const start = new Date(startDate.value);
                const end = new Date(endDate.value);
                if (start >= end) {
                    showError(endDate, 'End Date must be after Start Date');
                    isValid = false;
                    console.log('Date Range validation failed');
                }
            }
        }

        // Validate Exam fields if exam is enabled
        const examYes = document.getElementById('course_examyes');
        if (examYes.checked) {
            const examDate = document.getElementById('exam_date');
            const passPercentage = document.getElementById('pass_percentage');

            if (!examDate.value) {
                showError(examDate, 'Exam Date is required');
                isValid = false;
                console.log('Exam Date validation failed');
            }

            if (!passPercentage.value || passPercentage.value < 1 || passPercentage.value > 100) {
                showError(passPercentage, 'Pass Percentage must be between 1 and 100');
                isValid = false;
                console.log('Pass Percentage validation failed');
            }
        }

        // Validate CPD Points
        const cpdPoints = document.getElementById('course_cpt_points');
        if (!cpdPoints.value || parseFloat(cpdPoints.value) < 0) {
            showError(cpdPoints, 'Valid CPD Points are required');
            isValid = false;
            console.log('CPD Points validation failed');
        }

        // Validate Instructor
        const instructor = document.getElementById('course_instructor');
        if (!instructor.value.trim()) {
            showError(instructor, 'Course Instructor is required');
            isValid = false;
            console.log('Instructor validation failed');
        }

        // Validate PIN if restricted access is yes
        const restrictedYes = document.getElementById('restricted_yes');
        if (restrictedYes.checked) {
            const pin = document.getElementById('course_pin');
            if (!pin.value || !/^\d{4,6}$/.test(pin.value)) {
                showError(pin, 'PIN must be 4-6 digits');
                isValid = false;
                console.log('PIN validation failed');
            }
        }

        // Validate User selection
        const userId = document.getElementById('user_id');
        // For Select2, get the value differently
        const selectedUsers = $(userId).val(); // Using jQuery for Select2
        if (!selectedUsers || selectedUsers.length === 0) {
            showError(userId, 'At least one user must be selected');
            isValid = false;
            console.log('User selection validation failed');
        }

        console.log('Validation complete. Is valid?', isValid);
        return isValid;
    }

    function showError(element, message) {
        // Add error class to element
        element.classList.add('is-invalid');

        // Create error message element
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback d-block';
        errorDiv.textContent = message;

        // Insert after element
        element.parentNode.appendChild(errorDiv);

        // Scroll to first error
        if (!window.scrolledToError) {
            element.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
            window.scrolledToError = true;
        }
    }

    function clearErrors() {
        // Remove error classes
        document.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });

        // Remove error messages
        document.querySelectorAll('.invalid-feedback').forEach(el => {
            el.remove();
        });

        window.scrolledToError = false;
    }


    // Better: Only handle display, NOT required attributes
    document.getElementById('course_pay').addEventListener('change', function() {
        const priceField = document.getElementById('paid');
        if (this.value === 'paid') {
            priceField.style.display = 'block';
        } else {
            priceField.style.display = 'none';
        }
    });
});
$(document).ready(function() {
    function closeModalForce() {
        console.log('Force closing modal');

        // Method 1: Standard Bootstrap
        $('#publishModal').modal('hide');

        // Method 2: Trigger dismiss event
        $('#publishModal').trigger('click.dismiss.bs.modal');

        // Method 3: Manually hide
        $('#publishModal').removeClass('show');
        $('#publishModal').css('display', 'none');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();

        // Method 4: Use data attributes
        $('#publishModal').data('bs.modal', null);
    }

    // Bind events
    $('#publishModal .close').on('click', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        closeModalForce();
        return false;
    });

    $('#publishModal .btn-danger[data-dismiss="modal"]').on('click', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        closeModalForce();
        return false;
    });
});
</script>



@endsection