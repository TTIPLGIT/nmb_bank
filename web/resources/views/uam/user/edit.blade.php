@extends('layouts.adminnav')

@section('content')

<style>
.select2-container {
    width: 100% !important;
}

.select2-container--default .select2-selection--multiple {
    height: auto !important;
    min-height: 45px !important;
    display: flex !important;
    align-items: center;
    flex-wrap: wrap;
}

.select2-selection__rendered {
    display: flex !important;
    flex-wrap: wrap;
    gap: 5px;
}

.select2-selection__choice {
    margin-top: 3px !important;
}

.select2-container--default .select2-selection--multiple {
    overflow: hidden !important;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #007bff;
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<div class="main-content">

    <!-- Main Content -->
    <section class="section">


        <div class="section-body mt-1">
            <h5 class="heading_align" style="color:darkblue">User Edit</h5>

            {{ Breadcrumbs::render('user.edit',$one_row[0]['id']) }}

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form class="form-horizontal" name="uam_modules" method="POST"
                                action="{{ route('update_user_data') }}">
                                @csrf
                                <div class="row">
                                    <input class="form-control" type="hidden" id="user_id" name="user_id"
                                        placeholder="Enter Module Name" value="{{ $one_row[0]['id']}}">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="control-label">User Name <span
                                                    style="color: red;font-size: 16px;">*</span></label>
                                            <input class="form-control" type="text" id="name" name="name"
                                                placeholder="Enter User Name" value="{{ $one_row[0]['name']}}">
                                            @error('name')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="control-label">Email <span
                                                    style="color: red;font-size: 16px;">*</span></label>
                                            <input class="form-control" type="email" id="email" name="email"
                                                placeholder="Enter Email" value="{{ $one_row[0]['email'] }}">
                                            @error('email')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="control-label">Roles <span
                                                    style="color: red;font-size: 16px;">*</span></label>
                                            <select class="form-control" name="roles_id" id="roles_id"
                                                onchange="filterDesignations()">
                                                <option value="">Please Select Role</option>
                                                @foreach($rows_data as $key => $row_data)
                                                <option value="{{ $row_data['role_id'] }}"
                                                    {{ $row_data['role_id'] == $one_row[0]['array_roles'] ? 'selected' : '' }}>
                                                    {{ $row_data['role_name'] }}
                                                </option>
                                                @endforeach
                                            </select>

                                            @error('roles_id')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        @php
                                        $designation_name = $one_row[0]['designation_id']

                                        @endphp
                                        <div class="col-md-6 form-group">
                                            <label class="control-label">Designation<span
                                                    style="color: red;font-size: 16px;">*</span></label>
                                            <select class="form-control" name="designation_id" id="designation_id">
                                                <option value="">Please Select Designation</option>
                                                @foreach($designation as $designations)
                                                <option value="{{ $designations['designation_id'] }}"
                                                    {{ $designations['designation_id'] == $designation_name ? 'selected' : '' }}>
                                                    {{ $designations['designation_name'] }}
                                                </option>
                                                @endforeach
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
                                                id="custom_field" multiple="multiple">
                                                <option value="">---Select---</option>
                                                @foreach($custom_field as $field)
                                                <option value="{{ $field['id'] }}"
                                                    data-type="{{ $field['field_type'] }}"
                                                    data-label="{{ $field['field_label'] }}"
                                                    data-name="{{ $field['field_name'] }}"
                                                    data-options="{{ $field['field_options'] }}"
                                                    {{ isset($user_custom_values[$field['id']]) ? 'selected' : '' }}>
                                                    {{ $field['field_label'] }}
                                                </option>
                                                @endforeach
                                            </select>

                                            @error('roles_id')
                                            <div class="error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row" id="dynamic_field_container"></div>

                                    <input id="displayItems" name="displayItems" class="form-control" type="hidden">
                                    <input id="displayItems1" name="directorate_department" class="form-control"
                                        type="hidden">
                                    <input id="displayItems2" name="displayItems2" class="form-control" type="hidden">
                                    <div class="para"></div>
                                    <input class="form-control" type="hidden" id="parent_node_id" name="parent_node_id"
                                        placeholder="Enter Password" value="">
                                    <input class="form-control" type="hidden" id="user_type" name="user_type"
                                        placeholder="Enter Password" value="AD">
                                </div>
                                <div class="row text-center">
                                    <div class="col-md-12">
                                        <button class="btn btn-success" type="submit">&nbsp;&nbsp; Update</button>&nbsp;
                                        <!-- <button class="btn btn-primary" type="reset"><i class="fa fa-undo"></i> Undo </button>&nbsp; -->
                                        <a class="btn btn-danger footer_btn_cancel" href="{{ route('user.index') }}"><i
                                                class="fa fa-times" aria-hidden="true"></i> Cancel </a>&nbsp;
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>
</div>


<script type="text/javascript">
document.getElementById("checkbox").checked = true;
</script>

<script>
let existingValues = @json($user_custom_values);
</script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<script type="text/javascript">
$("input#name").on({
    keydown: function(e) {
        if (e.which === 32)
            return false;
    },
    change: function() {
        this.value = this.value.replace(/\s/g, "");
    }
});



$(document).ready(function() {



    var array_roles = <?php echo (json_encode($one_row)); ?>
    var clean = array_roles.split();
    var string = JSON.stringify(clean);
    var newxcv = string.replace(/["]/g, '');
    var ncd = JSON.parse(newxcv);
    $('.roles_id').val(ncd);
    $(".js-select2").select2({
        closeOnSelect: false,
        placeholder: " Please Select Roles ",
        allowHtml: true,
        allowClear: true,
        tags: true // создает новые опции на лету
    });



});
</script>



<script type="text/javascript">
$(document).ready(function() {

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

});
</script>

<!-- custom Field -->
<script>
$(document).ready(function() {

    // Function to generate fields
    function generateDynamicFields() {

        let selectedOptions = $('#custom_field option:selected');
        let container = $('#dynamic_field_container');
        container.html("");

        selectedOptions.each(function() {
            let fieldType = $(this).data('type');
            let fieldLabel = $(this).data('label');
            let fieldId = $(this).val();
            let fieldOptions = $(this).data('options');
            let value = '';

            if (typeof existingValues !== 'undefined' && existingValues && existingValues[fieldId]) {
                value = existingValues[fieldId]['field_value'] || '';
            }

            let html = '<div class="col-md-6"><div class="form-group"><label>' + fieldLabel +
                ' <span style="color: red;">*</span></label>';

            if (fieldType === 'dropdown') {
                html += '<select name="custom_field_value[' + fieldId +
                    ']" class="form-control" required><option value="">Select</option>';
                if (fieldOptions) {
                    let options = fieldOptions.split(',');
                    for (let i = 0; i < options.length; i++) {
                        let opt = options[i].trim();
                        html += '<option value="' + opt + '" ' + (opt === value ? 'selected' : '') +
                            '>' + opt + '</option>';
                    }
                }
                html += '</select>';
            } else {
                html += '<input type="' + (fieldType === 'text' ? 'text' : fieldType) +
                    '" name="custom_field_value[' + fieldId + ']" value="' + value +
                    '" class="form-control" required>';
            }

            html += '</div></div>';
            container.append(html);
        });
    }

    // FORCE generate fields on page load
    generateDynamicFields();

    // Also when selection changes
    $('#custom_field').on('change', function() {
        generateDynamicFields();
    });

    // Validation
    $('#editUserForm').on('submit', function(e) {
        let errors = [];
        if (!$('#name').val()) errors.push('User Name is required');
        if (!$('#email').val()) errors.push('Email is required');
        if (!$('#roles_id').val()) errors.push('Roles is required');
        if (!$('#designation_id').val()) errors.push('Designation is required');

        let selectedFields = $('#custom_field').val() || [];
        for (let i = 0; i < selectedFields.length; i++) {
            let fieldId = selectedFields[i];
            let value = $('[name="custom_field_value[' + fieldId + ']"]').val();
            if (!value || value.trim() === '') {
                let fieldLabel = $('#custom_field option[value="' + fieldId + '"]').data('label');
                errors.push(fieldLabel + ' is required');
            }
        }

        if (errors.length > 0) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: errors.join('<br>'),
                confirmButtonText: 'OK'
            });
        }
    });
});
</script>

<script>
$(document).ready(function() {

    $('#custom_field').select2({
        placeholder: "Select Custom Fields",
        width: '100%',
        closeOnSelect: false,
        allowClear: true
    });
    setTimeout(() => {
        $('#custom_field').trigger('change');
    }, 200);

});


$(document).on('change', '#custom_field', function() {

    let selectedOptions = $('#custom_field option:selected').filter(function() {
        return $(this).val() !== "";
    });
    let container = $('#dynamic_field_container');

    container.html(""); // clear old fields

    selectedOptions.each(function() {

        let fieldType = $(this).data('type');
        let fieldLabel = $(this).data('label');
        let fieldId = $(this).val();
        let fieldOptions = $(this).data('options');

        let value = '';

        if (existingValues[fieldId]) {
            value = existingValues[fieldId]['field_value'];
        }

        let inputField = '';
        let wrapperStart = `<div class="col-md-6"><div class="form-group"><label>${fieldLabel}</label>`;
        let wrapperEnd = `</div></div>`;

        switch (fieldType) {

            case 'text':
                inputField = `${wrapperStart}
        <input type="text"
            name="custom_field_value[${fieldId}]"
            value="${value}"
            class="form-control">
    ${wrapperEnd}`;
                break;

            case 'email':
                inputField = `${wrapperStart}
        <input type="email"
            name="custom_field_value[${fieldId}]"
            value="${value}"
            class="form-control">
    ${wrapperEnd}`;
                break;

            case 'number':
                inputField = `${wrapperStart}
        <input type="number"
            name="custom_field_value[${fieldId}]"
            value="${value}"
            class="form-control">
    ${wrapperEnd}`;
                break;

            case 'date':
                inputField = `${wrapperStart}
        <input type="date"
            name="custom_field_value[${fieldId}]"
            value="${value}"
            class="form-control">
    ${wrapperEnd}`;
                break;

            case 'dropdown':

                let options = '';
                let optionArray = fieldOptions ? fieldOptions.split(',') : [];

                optionArray.forEach(function(opt) {
                    let selected = opt.trim() == value ? 'selected' : '';
                    options +=
                        `<option value="${opt.trim()}" ${selected}>${opt.trim()}</option>`;
                });

                inputField = `${wrapperStart}
        <select name="custom_field_value[${fieldId}]" class="form-control">
            <option value="">Select</option>
            ${options}
        </select>
    ${wrapperEnd}`;
                break;
        }

        container.append(inputField);
    });

});
</script>

<script>
var $j = jQuery.noConflict();

$j(document).ready(function() {
    $j('#custom_field').select2();
});
</script>



@endsection