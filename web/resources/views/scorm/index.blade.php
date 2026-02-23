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

{{-- AJAX Scripts --}}
@push('scripts')
<script>
$('#upload-form').on('submit', function(e) {
    e.preventDefault();

    var formData = new FormData(this);

    $.ajax({
        url: '{{ route("scorm.upload") }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            swal("Success", "SCORM Package uploaded successfully", "success")
                .then(() => location.reload());
        },
        error: function(xhr) {
            swal("Error", xhr.responseJSON?.message || "Upload failed", "error");
        }
    });
});

// Delete
$('.delete-package').on('click', function() {

    if (!confirm('Are you sure you want to delete this package?')) return;

    var id = $(this).data('id');

    $.ajax({
        url: '/admin/scorm/' + id,
        type: 'DELETE',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function() {
            swal("Deleted", "Package deleted successfully", "success")
                .then(() => location.reload());
        }
    });
});
</script>
@endpush

@endsection