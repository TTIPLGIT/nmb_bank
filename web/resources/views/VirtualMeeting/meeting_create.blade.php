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
                            <div class="row">


                            </div>
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

                            <div class="card">
                                <form action="{{route('meeting_store')}}" method="POST">
                                    @csrf
                                    <div class="card-body">

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Course <span class="text-danger">*</span></label>
                                                    <select name="course_id" id="course_id" class="form-control select2" required>
                                                        <option value="">Select a Courses</option>
                                                        @foreach($rows['courses'] as $courses)
                                                            <option value="{{ $courses['course_id'] }}">{{ $courses['course_name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Participants <span class="text-danger">*</span></label>
                                                    <select name="user_ids[]" class="form-control select2" required>
                                                        <option value="">Select a Users</option>
                                                        @foreach($rows['rows'] as $user)
                                                        <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div> -->

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Meeting Title <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" name="meeting_title" placeholder="Enter Meeting Title" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Meeting Description</label>
                                                    <textarea class="form-control" name="meeting_description" placeholder="Enter Description"></textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Meeting Date <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="date" name="meeting_date" required>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Start Time <span class="text-danger">*</span></label>
                                                    <input class="form-control" type="time" name="start_time" required>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
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
                                                    <select name="platform" class="form-control" required>
                                                        <option value="">Select Platform</option>
                                                        <option value="zoom">Zoom</option>
                                                        <option value="teams">Microsoft Teams</option>
                                                        <option value="google">Google Meet</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Meeting Access Type</label>
                                                    <select name="access_type" class="form-control">
                                                        <option value="open">Open Access</option>
                                                        <option value="pin">PIN Protected</option>
                                                    </select>
                                                </div>
                                            </div>

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
    </section>
</div>







@if (session('success'))


<input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
<script type="text/javascript">
    window.onload = function() {
        var message = $('#session_data').val();

        bootbox.alert({
            title: "Success",
            centerVertical: true,
            message: message
        });
    }
</script>
@endif


@if (session('failed'))
<input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('failed') }}">
<script type="text/javascript">
    window.onload = function() {
        var message = $('#session_data').val();

        bootbox.alert({
            title: "Success",
            centerVertical: true,
            message: message
        });
    }
</script>
@endif


<script src="{{ asset('js/table2excel.js') }}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    var $j = jQuery.noConflict();

    $j(document).ready(function() {
        $j('#course_id').select2();
    });

</script>




@endsection