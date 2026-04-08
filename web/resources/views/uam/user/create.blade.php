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

.select2-container .select2-selection--single {
    height: 39px !important;
}

.select2-selection__choice {
    background-color: #680EDA !important;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: red !important;
}
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<div class="main-content">
    <h5 class="text-center" style="color:darkblue">Users Create</h5>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ session('warning') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    {{ Breadcrumbs::render('user.create') }}

    <!-- Main Content -->
    <section class="section">
        <div class="section-body mt-1">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form class="form-horizontal" name="uam_modules" method="POST" id="user_creation"
                                action="{{ route('user.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">User Name <span
                                                    style="color: red;font-size: 16px;">*</span></label>
                                            <input class="form-control" type="text" id="name" name="name"
                                                placeholder="Enter User Name" autofill="off">
                                            @error('name')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Email <span
                                                    style="color: red;font-size: 16px;">*</span></label>
                                            <input class="form-control" type="email" id="email" name="email"
                                                placeholder="Enter Email">
                                            @error('email')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Password <span
                                                    style="color: red;font-size: 16px;">*</span></label>
                                            <input class="form-control" type="text" id="password" name="password"
                                                pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+"
                                                title="Password must contain uppercase, lowercase, number and special character"
                                                placeholder="Enter Password">
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
                                            <label class="control-label">Confirm Password <span
                                                    style="color: red;font-size: 16px;">*</span></label>
                                            <input class="form-control" type="password" id="confirm_password"
                                                name="confirm_password" placeholder="Enter Password">
                                            @error('confirm_password')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Role Names<span
                                                    style="color: red;font-size: 16px;">*</span></label>
                                            <select class="form-control" name="roles_id" id="roles_id"
                                                onchange="filterDesignations()">
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
                                            <label class="control-label">Designation<span
                                                    style="color: red;font-size: 16px;">*</span></label>
                                            <select class="form-control" name="designation_id" id="designation_id">
                                                <option value="">Please Select Designation</option>
                                                {{-- Designation options will be populated by JS --}}
                                            </select>

                                            @error('designation_id')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Custom Field</label>
                                            <select class="form-control select2" name="custom_field_id[]"
                                                id="custom_field" Multiple>
                                                <option value="">---Select---</option>
                                                @foreach($custom_field as $field)
                                                <option value="{{ $field['id'] }}"
                                                    data-type="{{ $field['field_type'] }}"
                                                    data-label="{{ $field['field_label'] }}"
                                                    data-name="{{ $field['field_name'] }}"
                                                    data-options="{{ $field['field_options'] }}">
                                                    {{ $field['field_label'] }}
                                                </option>
                                                @endforeach
                                            </select>

                                            @error('roles_id')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6" id="dynamic_field_container"></div>


                                </div>

                                <input id="displayItems" name="displayItems" class="form-control" type="hidden">
                                <input id="displayItems1" name="directorate_department" class="form-control"
                                    type="hidden">
                                <input id="displayItems2" name="displayItems2" class="form-control" type="hidden">
                                <div class="para"></div>
                                <input class="form-control" type="hidden" id="user_type" name="user_type"
                                    placeholder="Enter Password" value="AD">
                                <div class="row text-center">
                                    <div class="col-md-12 mt-3">
                                        <button onclick="user()" id="usersubmit" class="btn btn-success"
                                            type="submit"><i class="fa fa-check"></i> Submit</button>&nbsp;
                                        <button class="btn btn-primary" type="reset"><i class="fa fa-undo"></i> Undo
                                        </button>&nbsp;
                                        <a class="btn btn-danger footer_btn_cancel" href="{{ route('user.index') }}"><i
                                                class="fa fa-times" aria-hidden="true"></i> Cancel </a>&nbsp;
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>




            <script>
            const input = document.querySelector("#phone");
            const iti = window.intlTelInput(input, {
                initialCountry: "ug",
                utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js?1706723638591"
            });
            </script>
            <!-- custom Field -->
            <!-- custom Field -->
            <script>
            $(document).ready(function() {

                $('#custom_field').select2({
                    placeholder: "Select Custom Fields",
                    width: '100%',
                    closeOnSelect: false,
                    allowClear: true
                });

            });

            $(document).on('change', '#custom_field', function() {

                let selectedOptions = $('#custom_field option:selected');
                let container = $('#dynamic_field_container');
                container.html("");

                selectedOptions.each(function() {

                    let fieldType = $(this).data('type');
                    let fieldLabel = $(this).data('label');
                    let fieldId = $(this).val();
                    let fieldOptions = $(this).data('options');

                    if (!fieldType || !fieldId) return;

                    let inputField = '';

                    if (fieldType === 'text') {
                        inputField = `<div class="form-group">
                    <label>${fieldLabel} <span style="color: red;">*</span></label>
                    <input type="text" 
                        name="custom_field_value[${fieldId}]" 
                        class="form-control custom-field-input"
                        data-field-id="${fieldId}"
                        required>
                    <div class="error-message" style="color: red; font-size: 12px; display: none;">${fieldLabel} is required</div>
                </div>`;
                    }

                    if (fieldType === 'email') {
                        inputField = `<div class="form-group">
                    <label>${fieldLabel} <span style="color: red;">*</span></label>
                    <input type="email" 
                        name="custom_field_value[${fieldId}]" 
                        class="form-control custom-field-input"
                        data-field-id="${fieldId}"
                        required>
                    <div class="error-message" style="color: red; font-size: 12px; display: none;">${fieldLabel} is required</div>
                </div>`;
                    }

                    if (fieldType === 'number') {
                        inputField = `<div class="form-group">
                    <label>${fieldLabel} <span style="color: red;">*</span></label>
                    <input type="number" 
                        name="custom_field_value[${fieldId}]" 
                        class="form-control custom-field-input"
                        data-field-id="${fieldId}"
                        required>
                    <div class="error-message" style="color: red; font-size: 12px; display: none;">${fieldLabel} is required</div>
                </div>`;
                    }

                    if (fieldType === 'date') {
                        inputField = `<div class="form-group">
                    <label>${fieldLabel} <span style="color: red;">*</span></label>
                    <input type="date" 
                        name="custom_field_value[${fieldId}]" 
                        class="form-control custom-field-input"
                        data-field-id="${fieldId}"
                        required>
                    <div class="error-message" style="color: red; font-size: 12px; display: none;">${fieldLabel} is required</div>
                </div>`;
                    }

                    if (fieldType === 'dropdown') {
                        let options = '';
                        if (fieldOptions) {
                            let optionArray = fieldOptions.split(',');
                            optionArray.forEach(function(opt) {
                                options +=
                                    `<option value="${opt.trim()}">${opt.trim()}</option>`;
                            });
                        }

                        inputField = `<div class="form-group">
                    <label>${fieldLabel} <span style="color: red;">*</span></label>
                    <select name="custom_field_value[${fieldId}]" class="form-control custom-field-input" data-field-id="${fieldId}" required>
                        <option value="">Select</option>
                        ${options}
                    </select>
                    <div class="error-message" style="color: red; font-size: 12px; display: none;">${fieldLabel} is required</div>
                </div>`;
                    }

                    container.append(inputField);
                });
            });
            </script>




            <script>
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
                var password = $("#password").val();
                var confpass = $("#confirm_password").val();

                var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

                if (password == '') {
                    swal("Please Enter the Password", "", "error");
                    event.preventDefault();
                    return false;
                }

                if (!passwordPattern.test(password)) {
                    swal("Password must contain minimum 8 characters, including 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character.",
                        "", "error");
                    event.preventDefault();
                    return false;
                }

                if (confpass == '') {
                    swal("Please Enter the Confirm Password", "", "error");
                    event.preventDefault();
                    return false;
                }

                if (password != confpass) {
                    swal("Password and Confirm Password do not match", "", "error");
                    event.preventDefault();
                    return false;
                }

                var scrrole = $("select[name='roles_id']").val();
                if (scrrole == '') {
                    swal("Please Select the Screen Roles", "", "error");
                    event.preventDefault();
                    return false;
                }

                var designation_id = $("select[name='designation_id']").val();
                if (designation_id == '') {
                    swal("Please Select the Designation", "", "error");
                    event.preventDefault();
                    return false;
                }

                // NEW: Validate Custom Fields
                var customFields = $('#custom_field').val() || [];
                var customFieldErrors = [];

                for (var i = 0; i < customFields.length; i++) {
                    var fieldId = customFields[i];
                    var fieldValue = $('[name="custom_field_value[' + fieldId + ']"]').val();

                    if (!fieldValue || fieldValue.trim() === '') {
                        var fieldLabel = $('#custom_field option[value="' + fieldId + '"]').data('label');
                        customFieldErrors.push(fieldLabel);

                        // Highlight the field with error
                        $('[name="custom_field_value[' + fieldId + ']"]').addClass('is-invalid');
                        $('[name="custom_field_value[' + fieldId + ']"]').closest('.form-group').find('.error-message')
                            .show();
                    } else {
                        $('[name="custom_field_value[' + fieldId + ']"]').removeClass('is-invalid');
                        $('[name="custom_field_value[' + fieldId + ']"]').closest('.form-group').find('.error-message')
                            .hide();
                    }
                }

                if (customFieldErrors.length > 0) {
                    swal("Please fill required custom fields: " + customFieldErrors.join(", "), "", "error");
                    event.preventDefault();
                    return false;
                }

                document.getElementById("user_creation").submit();
            }
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



            <script>
            var $j = jQuery.noConflict();

            $j(document).ready(function() {
                $j('#custom_field').select2();
            });
            </script>



            @endsection