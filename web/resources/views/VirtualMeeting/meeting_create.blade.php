@extends('layouts.adminnav')

@section('content')
<style type="text/css">
.buttons-html5 {
    background-color: #1bcd6b !important;
    padding: 10px;
    border: 1px;
    color: white;
}

.select2-container .select2-selection--single {
    height: 39px !important;
}

.platform-link-field {
    display: none;
}
</style>

<div class="main-content">

    @if (session('success'))
    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
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
    <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
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
    {{ Breadcrumbs::render('meeting_create') }}
    <section class="section">
        <div class="col-lg-12 text-center">
            <h4 style="color:darkblue;">Meeting Initiate</h4>
        </div>
        <div class="section-body mt-2">
            <style>
            .section {
                margin-top: 20px;
            }
            </style>

            <div class="row">
                <div class="col-12">
                    <div class="mt-0">
                        <div class="card-body" id="card_header">
                            <div class="card">
                                <form action="{{route('meeting_store')}}" method="POST">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Course <span class="text-danger">*</span></label>
                                                    <select name="course_id" id="course_id" class="form-control select2"
                                                        required>
                                                        <option value="">Select a Courses</option>
                                                        @foreach($rows['courses'] as $courses)
                                                        <option value="{{ $courses['course_id'] }}">
                                                            {{ $courses['course_name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Meeting Title <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" name="meeting_title"
                                                        placeholder="Enter Meeting Title" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Meeting Description</label>
                                                    <textarea class="form-control" name="meeting_description"
                                                        placeholder="Enter Description"></textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Meeting Date <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="date" name="meeting_date"
                                                        id="meeting_date" min="{{ date('Y-m-d') }}" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Start Time <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="time" name="start_time"
                                                        id="start_time" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Duration <span class="text-danger">*</span></label>
                                                    <select name="duration" class="form-control" required>
                                                        <option value="">Select Duration</option>
                                                        <option value="15">15 Minutes</option>
                                                        <option value="30">30 Minutes</option>
                                                        <option value="60">1 Hour</option>
                                                        <option value="120">2 Hours</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Meeting Platform <span class="text-danger">*</span></label>
                                                    <select name="platform" id="platform" class="form-control" required>
                                                        <option value="">Select Platform</option>
                                                        <option value="zoom">Zoom</option>
                                                        <option value="teams">Microsoft Teams</option>
                                                        <!-- <option value="google">Google Meet</option> -->
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Custom link field for Teams and Google Meet -->
                                            <div class="col-md-6" id="custom_link_field" style="display:none;">
                                                <div class="form-group">
                                                    <label>Meeting Link <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="url" name="custom_link"
                                                        placeholder="Enter meeting link (e.g., https://meet.google.com/xxx)">
                                                    <small class="text-muted">Please enter the full meeting URL</small>
                                                </div>
                                            </div>
                                            <div type="hidden" name="access_type" value="open"></div>

                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button class="btn btn-success" type="submit">Initiate Meeting</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="{{ asset('js/table2excel.js') }}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
var $j = jQuery.noConflict();

$j(document).ready(function() {
    $j('#course_id').select2();

    // Show/hide custom link field based on platform selection
    $j('#platform').change(function() {
        var platform = $j(this).val();
        if (platform === 'teams' || platform === 'google') {
            $j('#custom_link_field').show();
            $j('input[name="custom_link"]').prop('required', true);
        } else {
            $j('#custom_link_field').hide();
            $j('input[name="custom_link"]').prop('required', false);
        }
    });
});
</script>

@endsection