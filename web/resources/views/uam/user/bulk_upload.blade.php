@extends('layouts.adminnav')
@section('content')
<style type="text/css">
.dt-buttons.btn-group {
    display: none !important;
}

.mystyle {
    border: 2px solid red;
}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.3/xlsx.full.min.js"></script>

<div class="main-content">
    <section class="section my-5">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="col-12">
                                <h5 style="display: inline;">Bulk Users Creation</h5>
                                <button type="button"
                                    style="float:right;font-size: 14px; margin-top: -10px; text-align: center;border-radius: 3px;"
                                    data-toggle="modal" data-target="#exampleModal" class="btn btn-warning">
                                    Download Template
                                </button>
                            </div>
                        </div>
                        <div class="card-body" id="bom-card">
                            <div class="row">
                                <div class="col-lg-6 mx-auto">
                                    <div class="form-group">
                                        <label>Users Creation File<span style="color: red">*</span></label>
                                        <input type="file" id="fileUpload" class="form-control"
                                            style="margin: 0px;padding: 5px" required=""
                                            accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                        <input type="hidden" name="excel_row" id="excel_row12" class="">
                                        <input type="hidden" name="default_password" id="default_password"
                                            value="Welcome@123">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-center mt-2 pt-4">
                                <button type="button" class="btn btn-success" id="uploadBtn"
                                    onclick="readExcelFile()">Upload</button>
                                <a href="{{ route('user.index') }}" class="btn btn-danger"
                                    style="border-radius: 3px;">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" id="table-edit" style="display: none">
                <div class="col-md-12 content-bottom-position">
                    <div class="card p-3">
                        <div class="table-responsive" style="overflow-x:auto;">
                            <table class="table table-hover table-bordered" id="datatable" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width: 25%">User Name *</th>
                                        <th style="width: 35%">Email *</th>
                                        <th style="width: 15%">Role ID *</th>
                                        <th style="width: 25%">Designation ID *</th>
                                    </tr>
                                </thead>
                                <tbody id="boxavail"></tbody>
                            </table>
                            <div class="text-center mt-3">
                                <button type="button" class="btn btn-success" id="submitBulkUpload">Submit All
                                    Users</button>
                                <button type="button" class="btn btn-secondary" id="cancelBulk">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Template Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-yellow">
                <h5 class="modal-title" id="formModal">Instructions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="arrow">
                    <li><strong>Required columns:</strong> user_name, email, screen_role_id, designation_id</li>
                    <li>Default password will be: <strong>Welcome@123</strong></li>
                    <li>Do not add / delete / modify any columns</li>
                    <li>Do not rename the excel file</li>
                    <li>Do not attach any image files</li>
                    <li>No macros & Pivot tables are allowed</li>
                </ul>
            </div>
            <div class="text-center">
                <a href="{{ asset('images/user_creation_bulk.xlsx') }}" class="btn btn-warning" id="exampleModalclose">
                    <span>Download Template</span>
                </a>
            </div>
            <br>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#datatable').DataTable({
        "scrollY": "500px",
        "scrollCollapse": true,
        "paging": false,
        "filter": false,
        "bSort": false,
        "destroy": true
    });
});

$("#exampleModalclose").click(function() {
    $('#exampleModal').modal('toggle');
    $("#exampleModal").hide();
});

function readExcelFile() {
    var fileUpload = document.getElementById("fileUpload");
    var file = fileUpload.files[0];

    if (!file) {
        Swal.fire("Error", "Please select a file to upload", "error");
        return false;
    }

    var filename = file.name;
    var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.xls|.xlsx)$/;

    if (!regex.test(filename.toLowerCase())) {
        Swal.fire("Error", "Please upload a valid Excel file (.xls or .xlsx)", "error");
        return false;
    }

    var reader = new FileReader();
    reader.onload = function(e) {
        var data = new Uint8Array(e.target.result);
        var workbook = XLSX.read(data, {
            type: 'array'
        });
        var firstSheet = workbook.Sheets[workbook.SheetNames[0]];
        var excelRows = XLSX.utils.sheet_to_json(firstSheet);

        if (excelRows.length === 0) {
            Swal.fire("Error", "Excel file is empty", "error");
            return;
        }

        displayExcelData(excelRows);
    };
    reader.readAsArrayBuffer(file);
}

function displayExcelData(rows) {
    $("#table-edit").show();
    $("#fileUpload").prop("disabled", true);

    // Clear existing table data
    $('#datatable').DataTable().clear().draw();

    for (var i = 0; i < rows.length; i++) {
        var user_name = rows[i].user_name || '';
        var email = rows[i].email || '';
        var screen_role_id = rows[i].screen_role_id || '';
        var designation_id = rows[i].designation_id || '';

        $('#datatable').DataTable().row.add([
            '<input type="text" name="user_name[]" id="user_name_' + i +
            '" class="form-control user_name" value="' + escapeHtml(user_name) + '">',
            '<input type="email" name="email[]" id="email_' + i + '" class="form-control email" value="' +
            escapeHtml(email) + '">',
            '<input type="number" name="screen_role_id[]" id="screen_role_id_' + i +
            '" class="form-control screen_role_id" value="' + escapeHtml(screen_role_id) + '">',
            '<input type="number" name="designation_id[]" id="designation_id_' + i +
            '" class="form-control designation_id" value="' + escapeHtml(designation_id) + '">'
        ]).draw();
    }
}

function escapeHtml(str) {
    if (!str) return '';
    return str.toString().replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

$("#submitBulkUpload").click(function() {
    var btn = $(this);
    btn.prop('disabled', true);

    var users = [];
    var rowCount = $('#datatable').DataTable().rows().count();
    var isValid = true;
    var errors = [];

    for (var i = 0; i < rowCount; i++) {
        var userName = $('#user_name_' + i).val().trim();
        var email = $('#email_' + i).val().trim();
        var roleId = $('#screen_role_id_' + i).val().trim();
        var designationId = $('#designation_id_' + i).val().trim();

        // Validation
        if (!userName) {
            $('#user_name_' + i).addClass('mystyle');
            isValid = false;
            errors.push("Row " + (i + 1) + ": User name is required");
        } else {
            $('#user_name_' + i).removeClass('mystyle');
        }

        if (!email) {
            $('#email_' + i).addClass('mystyle');
            isValid = false;
            errors.push("Row " + (i + 1) + ": Email is required");
        } else if (!isValidEmail(email)) {
            $('#email_' + i).addClass('mystyle');
            isValid = false;
            errors.push("Row " + (i + 1) + ": Invalid email format");
        } else {
            $('#email_' + i).removeClass('mystyle');
        }

        if (!roleId) {
            $('#screen_role_id_' + i).addClass('mystyle');
            isValid = false;
            errors.push("Row " + (i + 1) + ": Role ID is required");
        } else if (isNaN(roleId) || roleId <= 0) {
            $('#screen_role_id_' + i).addClass('mystyle');
            isValid = false;
            errors.push("Row " + (i + 1) + ": Role ID must be a positive number");
        } else {
            $('#screen_role_id_' + i).removeClass('mystyle');
        }

        if (!designationId) {
            $('#designation_id_' + i).addClass('mystyle');
            isValid = false;
            errors.push("Row " + (i + 1) + ": Designation ID is required");
        } else if (isNaN(designationId) || designationId <= 0) {
            $('#designation_id_' + i).addClass('mystyle');
            isValid = false;
            errors.push("Row " + (i + 1) + ": Designation ID must be a positive number");
        } else {
            $('#designation_id_' + i).removeClass('mystyle');
        }

        users.push({
            name: userName,
            email: email,
            roles_id: parseInt(roleId),
            designation_id: parseInt(designationId),
            user_type: 'web', // default user type
            password: $('#default_password').val(),
            confirm_password: $('#default_password').val()
        });
    }

    if (!isValid) {
        Swal.fire("Validation Error", errors.join("\n"), "error");
        btn.prop('disabled', false);
        return false;
    }

    submitBulkUsers(users, btn);
});

function isValidEmail(email) {
    var re = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    return re.test(email);
}

function submitBulkUsers(users, btn) {
    Swal.fire({
        title: 'Creating Users',
        text: 'Please wait while we create the users...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        url: '{{ url("/user/bulk-store") }}',
        type: "POST",
        data: {
            users: users,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.status === 'success') {
                let message = response.created_count + " user(s) created successfully";
                if (response.failed_count > 0) {
                    message += "\n\n" + response.failed_count + " user(s) failed:\n" + response.errors.join(
                        "\n");
                }
                Swal.fire({
                    title: response.created_count > 0 ? "Success!" : "Failed!",
                    text: message,
                    icon: response.created_count > 0 ? "success" : "error"
                }).then(() => {
                    if (response.created_count > 0) {
                        window.location.href = '{{ route("user.index") }}';
                    } else {
                        btn.prop('disabled', false);
                    }
                });
            } else {
                Swal.fire("Error", response.message, "error");
                btn.prop('disabled', false);
            }
        },
        error: function(xhr) {
            var errorMsg = xhr.responseJSON?.message || "Failed to create users";
            Swal.fire("Error", errorMsg, "error");
            btn.prop('disabled', false);
        }
    });
}

$("#cancelBulk").click(function() {
    $("#table-edit").hide();
    $("#fileUpload").prop("disabled", false);
    $("#fileUpload").val('');
    $('#datatable').DataTable().clear().draw();
    location.reload();
});
</script>
@endsection