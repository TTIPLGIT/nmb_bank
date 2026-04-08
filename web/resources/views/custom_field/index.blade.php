@extends('layouts.adminnav')

@section('content')
<style>
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

table.dataTable.no-footer {
    border-bottom: .5px solid #002266 !important;
}

thead th {
    height: 5px;
    border-bottom: solid 1px #ddd;
    font-weight: bold;
}
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<div class="main-content module_space">



    {{ Breadcrumbs::render('custom_field.index') }}

    <section class="section">


        <div class="section-body mt-2">
            <div style="text-align:end">
                <a type="button" style="font-size:15px; margin-bottom:15px;margin-right: 15px;"
                    class="btn btn-success btn-lg" href="{{ route('custom_filed_create') }}">New Custom Field </a>
            </div>
            <style>
            .section {
                margin-top: 20px;
            }
            </style>

            <div class="row">

                <div class="col-12">

                    <div class="card">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <h4>List of Custom Field</h4>
                                </div>

                            </div>
                            @if (session('success'))

                            <input type="hidden" name="session_data" id="session_data" class="session_data"
                                value="{{ session('success') }}">
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

                            <input type="hidden" name="session_data" id="session_data1" class="session_data"
                                value="{{ session('error') }}">
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



                            <div class="table-wrapper">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="align">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>

                                                <th>Field Label</th>
                                                <th>Field Type</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                            @foreach($rows as $key => $row)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $row['field_label'] }}</td>
                                                <td>{{ $row['field_type'] }}</td>
                                                <td style="text-align:center">

                                                    <!-- Edit -->
                                                    <a class=" btn btn-link" type="show"
                                                        onclick="fetch_show('{{ Crypt::encrypt($row['id']) }}','edit')"
                                                        title="Edit" id="gcb" href="" data-toggle="modal"
                                                        data-target="#showmodal"><i class="fas fa-pencil-alt"
                                                            style="color:blue"></i></a>

                                                    <!-- Show -->
                                                    <a class="btn btn-link" type="show"
                                                        onclick="fetch_show('{{ Crypt::encrypt($row['id']) }}','show')"
                                                        title="Edit" id="gcb" href="" data-toggle="modal"
                                                        data-target="#showmodal" href="javascript:void(0);"><i
                                                            class="fas fa-eye" style="color:green"></i></a>

                                                    <!-- Delete -->
                                                    <form id="delete-form-{{ $row['id'] }}"
                                                        action="{{ route('custom_filed_delete', \Crypt::encrypt($row['id'])) }}"
                                                        method="POST">
                                                        @csrf
                                                        <a type="button" title="Delete"
                                                            onclick="confirmDelete({{ $row['id'] }})"
                                                            class="btn btn-link p-0">
                                                            <i class="far fa-trash-alt" style="color:red"></i>
                                                        </a>
                                                    </form>

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

</div>

<div class="modal fade" id="showmodal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header mh">
                <h4 class="modal-title">Show Custom Field</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="card">

                <form method="POST" action="{{route('custom_field_update')}}" id="custom_field_Update">
                    @csrf
                    <input type="hidden" id="id" name="custom_id">
                    <h4 style="color:black;text-align:center;margin-bottom:20px" id="sub_title_name"></h4>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Field Label :<span style="color: red;">*</span></label>
                                <input class="form-control" type="text" id="field_label" name="field_label"
                                    placeholder="Enter Field Label" required>
                                @error('field_label')
                                <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Field Name :<span style="color: red;">*</span></label>
                                <input class="form-control" type="text" id="field_name" name="field_name"
                                    placeholder="Enter Field Name" required>
                                @error('field_name')
                                <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Field Type : <span style="color: red;">*</span></label>
                                <select class="form-control" name="field_type" id="field_type" required>
                                    <option value=""> ---Select--- </option>
                                    <option value="text">Text</option>
                                    <option value="email">Email</option>
                                    <option value="number">Number</option>
                                    <option value="date">Date</option>
                                    <option value="dropdown">Dropdown</option>
                                    <!-- <option value="checkbox">Checkbox</option> -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" style="display:none;" id="options_section">
                            <div class="form-group">
                                <label>Dropdown Options (Comma separated) : <span style="color: red;">*</span></label>
                                <input class="form-control" type="text" id="field_options" name="field_options"
                                    placeholder="Enter Field Name">
                                @error('field_options')
                                <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <label>Required Field :</label>
                                <input type="hidden" name="is_required" value="0">
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox"
                                        name="is_required" id="is_required" value="1">
                                    <label class="form-check-label" for="is_required">
                                        Yes / No
                                    </label>
                                </div>

                                @error('is_required')
                                <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> -->
                    </div>
                    <div class="row mt-4">
                        <div class="col-12 mb-5 d-flex justify-content-center gap-2">
                            <button style="margin-right:10px" class="btn btn-success" id="updateButton"
                                onclick="gencre(event)">Update</button>
                            <a class="btn btn-danger" style="color:white;" href="{{ route('custom_filed') }}">Back</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {

    swal({
            title: "Confirmation For Delete?",
            text: "Are you sure you want to delete this data?",
            icon: "warning",
            buttons: ["No", "Yes"],
            dangerMode: true,
        })
        .then((willDelete) => {

            if (willDelete) {
                document.getElementById('delete-form-' + id).submit();
            }

        });


}

function fetch_show(id, type) {
    $.ajax({
        url: "/custom_filed_fetch/" + id,
        type: 'GET',
        data: {
            'id': id,
            _token: '{{ csrf_token() }}'
        },
        success: function(data) {
            console.log(data);

            let row = data.rows[0];

            $('#field_label').prop('disabled', false).val(row.field_label);
            $('#field_name').prop('disabled', false).val(row.field_name);
            $('#field_type').prop('disabled', false).val(row.field_type);
            $('#field_options').prop('disabled', false).val(row.field_options);

            $('#id').val(id);

            if (type === "show") {
                $('#field_label,#field_name,#field_type,#field_options').prop('disabled', true);
                $('#updateButton').hide();
                $('#sub_title_name').html("Show Custom Field");
                $('#title_name').html("Show Custom Field");
            } else {
                $('#field_label,#field_name,#field_type,#field_options').prop('disabled', false);
                $('#updateButton').show();
                $('#sub_title_name').html("Edit Custom Field");
                $('#title_name').html("Edit Custom Field");
            }
        }
    });
}
</script>

@endsection