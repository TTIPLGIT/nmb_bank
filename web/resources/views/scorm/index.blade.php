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
                            <div class="col-md-6">
                                <form id="upload-form" action="{{ route('scorm.upload') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="input-group mb-6">
                                        <input type="file" name="scorm_file" class="form-control" accept=".zip"
                                            required>
                                        <button type="submit" class="btn btn-success btn-sm">
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
                                                @if(!$package->is_published)
                                                <button class="btn btn-sm btn-danger delete-package"
                                                    data-id="{{ $package->id }}">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                                @endif
                                                <a href="{{ url('/scorm/'.encrypt($package->id).'/view') }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fa fa-eye"></i> View
                                                </a>
                                                @if(!$package->is_published)
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                                    data-course-id="{{ $package->id }}" data-target="#publishModal">
                                                    <i class="fas fa-play mr-2"></i> Publish Course
                                                </button>
                                                @endif
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
                                <input type="text" class="form-control" id="course_name" name="course_name" required>
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

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>



<script>
// Add this after your other scripts
$(document).ready(function() {
    // Override the validateFileSize function for this page
    window.validateFileSize = function(inputFile) {
        var file = inputFile[0].files[0];
        if (!file) return true;

        var inputName = inputFile.attr('name');

        if (inputName === 'scorm_file') {
            // SCORM package - 500MB
            var maxSize = 500 * 1024 * 1024;
            if (file.size > maxSize) {
                alert('SCORM package must be 500MB or smaller');
                inputFile.val('');
                return false;
            }
        } else if (inputName === 'course_banner') {
            // Course banner - 5MB
            var maxSize = 5 * 1024 * 1024;
            if (file.size > maxSize) {
                alert('Course banner must be 5MB or smaller');
                inputFile.val('');
                return false;
            }
        }

        return true;
    };

    // Re-attach the change event to use the overridden function
    $('input[type="file"]').off('change').on('change', function(event) {
        validateFileSize($(this));
    });
});
$(document).ready(function() {


    $('#role_id').change(function() {

        let role_id = $(this).val();
        let designationSelect = $('#designation_id');

        designationSelect.html('<option value="">Loading...</option>');

        if (role_id === '') {
            designationSelect.html('<option value="">Please Select Designation</option>');
            return;
        }

        $.ajax({
            url: "{{ route('get.designation.by.role') }}",
            type: "POST",
            data: {
                role_id: role_id,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {

                designationSelect.html(
                    '<option value="">Please Select Designation</option>');

                if (response.length > 0) {
                    $.each(response, function(key, value) {
                        designationSelect.append(
                            '<option value="' + value.designation_id + '">' +
                            value.designation_name +
                            '</option>'
                        );
                    });
                }
            }
        });
    });
    var publishModal = new bootstrap.Modal(document.getElementById('publishModal'));

    // Override the click handler for the publish button to use Bootstrap 5
    $('button[data-target="#publishModal"]').on('click', function(e) {
        e.preventDefault();
        publishModal.show();
    });

    // Modal close button fix for Bootstrap 5
    $('#publishModal .close, #publishModal .btn-danger[data-dismiss="modal"]').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        publishModal.hide();

        // Remove modal backdrop manually if needed
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
    });

    // Also handle modal hide via the modal events
    $('#publishModal').on('hidden.bs.modal', function() {
        // Clean up any remaining backdrops
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');

        // Reset form when modal is hidden
        $('#publish_scorm_form')[0].reset();
        $('#user_id').val(null).trigger('change');
        $('#certificateFields').hide();
        $('#coursePeriodFields').hide();
        $('#pinField').hide();
        $('#expiryDateField').hide();

        // Remove any error messages
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();
    });

    if (typeof $.fn.select2 === 'undefined') {
        // console.error('Select2 not loaded! Trying to load dynamically...');

        // Dynamically load Select2 if not available
        var script = document.createElement('script');
        script.src = 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js';
        script.onload = function() {
            // console.log('Select2 loaded dynamically');
            initializeSelect2();
        };
        document.head.appendChild(script);

        // Also load CSS
        var link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css';
        document.head.appendChild(link);
    } else {
        // console.log('Select2 already loaded');
        initializeSelect2();
    }

    function initializeSelect2() {
        // console.log('Initializing Select2...');

        // Destroy any existing Select2 instance
        if ($('#user_id').hasClass('select2-hidden-accessible')) {
            $('#user_id').select2('destroy');
        }

        // Initialize Select2
        $('#user_id').select2({
            width: '100%',
            placeholder: "Select users",
            allowClear: true,
            closeOnSelect: false,
            dropdownParent: $('#publishModal'),
            language: {
                noResults: function() {
                    return "No users found";
                }
            }
        });

        // console.log('Select2 initialized successfully');
    }
    // Handle "All" selection logic
    $('#user_id').on('select2:select', function(e) {
        var data = e.params.data;
        // console.log('Selected:', data);

        if (data.id === 'All') {
            // If "All" is selected, clear all other selections and select only "All"
            $('#user_id').val('All').trigger('change');
        } else {
            // If any other option is selected, remove "All" if it exists
            var currentValues = $('#user_id').val();
            if (currentValues && currentValues.includes('All')) {
                // Remove 'All' from the array
                currentValues = currentValues.filter(function(value) {
                    return value !== 'All';
                });
                $('#user_id').val(currentValues).trigger('change');
            }
        }
    });

    $('#user_id').on('select2:unselect', function(e) {
        var data = e.params.data;
        // console.log('Unselected:', data);

        if (data.id === 'All') {
            // If "All" is unselected, clear everything
            $('#user_id').val(null).trigger('change');
        }
    });

    // Set form action when modal opens
    $('#publishModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var packageId = button.data('course-id');
        var form = $(this).find('form');

        // console.log('Modal opening for package:', packageId);

        // Set the action URL
        var action = '{{ route("scorm_course_publish", "") }}/' + packageId;
        form.attr('action', action);
        // console.log('Form action set to:', action);
    });

    // Validation function for required fields based on checkboxes
    function validateForm() {
        let isValid = true;
        let errorMessage = '';

        // Clear previous errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        // Check required fields
        if ($('#course_name').val().trim() === '') {
            markInvalid('#course_name', 'Course name is required');
            isValid = false;
        }

        if ($('#role_id').val() === '') {
            markInvalid('#role_id', 'Please select a role');
            isValid = false;
        }

        if ($('#designation_id').val() === '') {
            markInvalid('#designation_id', 'Please select a designation');
            isValid = false;
        }

        // Check if any user is selected
        var selectedUsers = $('#user_id').val();
        if (!selectedUsers || selectedUsers.length === 0) {
            markInvalid('#user_id', 'Please select at least one user');
            isValid = false;
        }

        // Check course banner
        if ($('#course_banner').get(0).files.length === 0) {
            markInvalid('#course_banner', 'Please select a course banner');
            isValid = false;
        }

        // Check certificate selection
        if (!$('input[name="course_certificate"]:checked').val()) {
            markInvalid('input[name="course_certificate"]', 'Please select Yes or No for certificate');
            isValid = false;
        }

        // If certificate is Yes, check template
        if ($('#course_certificate_yes').is(':checked')) {
            if ($('#certificate_template').val() === '') {
                markInvalid('#certificate_template', 'Please select a certificate template');
                isValid = false;
            }

            // If certificate expiry is Yes, check expiry date
            if ($('#expiry_yes').is(':checked')) {
                if ($('input[name="expiry_date"]').val() === '') {
                    markInvalid('input[name="expiry_date"]', 'Please select an expiry date');
                    isValid = false;
                }
            }
        }

        // If course has period, check start and end dates
        if ($('#course_noperiodyes').is(':checked')) {
            if ($('#course_start_period').val() === '') {
                markInvalid('#course_start_period', 'Please select start date');
                isValid = false;
            }
            if ($('#course_end_period').val() === '') {
                markInvalid('#course_end_period', 'Please select end date');
                isValid = false;
            }

            // Check if end date is after start date
            if ($('#course_start_period').val() && $('#course_end_period').val()) {
                if ($('#course_end_period').val() <= $('#course_start_period').val()) {
                    markInvalid('#course_end_period', 'End date must be after start date');
                    isValid = false;
                }
            }
        }

        // If restricted access is Yes, check PIN
        if ($('#restricted_yes').is(':checked')) {
            var pin = $('input[name="access_pin"]').val();
            if (!pin || pin.length < 4 || pin.length > 6) {
                markInvalid('input[name="access_pin"]', 'PIN must be 4-6 digits');
                isValid = false;
            } else if (!/^\d+$/.test(pin)) {
                markInvalid('input[name="access_pin"]', 'PIN must contain only numbers');
                isValid = false;
            }
        }

        return isValid;
    }

    function markInvalid(selector, message) {
        $(selector).addClass('is-invalid');

        // For select2 elements
        if ($(selector).hasClass('js-select2') || selector === '#user_id') {
            $(selector).next('.select2-container').find('.select2-selection').addClass('is-invalid');
        }

        // Add error message
        if ($(selector).next('.invalid-feedback').length === 0) {
            $('<div class="invalid-feedback">' + message + '</div>').insertAfter($(selector));
        } else {
            $(selector).next('.invalid-feedback').text(message);
        }
    }

    // Form submission with validation
    $('#publish_scorm_form').on('submit', function(e) {
        e.preventDefault();

        var form = this; // Store reference to form

        // Show SweetAlert2 confirmation
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
            buttonsStyling: false,
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading state
                $('#publishbutton').prop('disabled', true);
                $('#publishText').text('Publishing...');
                $('#publishSpinner').removeClass('d-none');

                // Submit the form
                form.submit();
            }
        });
    });

    // Initialize field toggles
    function initializeFieldToggles() {
        // Certificate fields toggle
        $('input[name="course_certificate"]').change(function() {
            if ($(this).val() == '1') { // Yes
                $('#certificateFields').show();
                // Make certificate template required when visible
                $('#certificate_template').prop('required', true);
                $('input[name="certificate_expiry"]').prop('required', true);
            } else { // No
                $('#certificateFields').hide();
                $('#expiryDateField').hide();
                // Remove required when hidden
                $('#certificate_template').prop('required', false);
                $('input[name="certificate_expiry"]').prop('required', false);
                $('input[name="expiry_date"]').prop('required', false);
            }
        });

        // Course period toggle
        $('input[name="course_noperiod"]').change(function() {
            if ($(this).val() == '1') { // Yes
                $('#coursePeriodFields').show();
                // Make date fields required
                $('#course_start_period').prop('required', true);
                $('#course_end_period').prop('required', true);
            } else { // No
                $('#coursePeriodFields').hide();
                // Remove required
                $('#course_start_period').prop('required', false);
                $('#course_end_period').prop('required', false);
            }
        });

        // Restricted access toggle
        $('input[name="restricted_access"]').change(function() {
            if ($(this).val() == '1') { // Yes
                $('#pinField').show();
                // Make PIN required
                $('input[name="access_pin"]').prop('required', true);
            } else { // No
                $('#pinField').hide();
                // Remove required
                $('input[name="access_pin"]').prop('required', false);
            }
        });

        // Certificate expiry toggle
        $('input[name="certificate_expiry"]').change(function() {
            if ($(this).val() == '1') { // Yes
                $('#expiryDateField').show();
                // Make expiry date required
                $('input[name="expiry_date"]').prop('required', true);
            } else { // No
                $('#expiryDateField').hide();
                // Remove required
                $('input[name="expiry_date"]').prop('required', false);
            }
        });
    }

    initializeFieldToggles();

    // Delete package functionality
    $(document).on('click', '.delete-package', function() {
        if (!confirm('Are you sure you want to delete this package?')) return;

        var id = $(this).data('id');
        var button = $(this);

        button.prop('disabled', true);
        button.html('<i class="fa fa-spinner fa-spin"></i> Deleting...');

        $.ajax({
            url: '{{ url("scorm") }}/' + id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.status) {
                    swal({
                        title: "Deleted!",
                        text: response.message,
                        icon: "success",
                        timer: 2000,
                        buttons: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    swal("Error", response.message, "error");
                    button.prop('disabled', false);
                    button.html('<i class="fa fa-trash"></i> Delete');
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                swal("Error", "Something went wrong!", "error");
                button.prop('disabled', false);
                button.html('<i class="fa fa-trash"></i> Delete');
            }
        });
    });
});
</script>

@endsection