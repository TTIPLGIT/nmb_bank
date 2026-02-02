@extends('layouts.adminnav')

@section('content')
<style type="text/css">
.buttons-html5 {
    background-color: #1bcd6b !important;
    padding: 10px;
    border: 1px;
    color: white;
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
            <h4 style="color:darkblue;">Course List</h4>
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

                            <div id="content">
                                <!-- <div class="col-12"> -->
                                <div class="row" style="justify-content:end">
                                    <div class="col-md-2" id="addCourseButton">
                                        <a type="button" style="font-size:15px;margin-bottom: 15px;"
                                            class="btn btn-success btn-lg" title="Create"
                                            href="{{route('ai_course_create')}}">Add Course <span>
                                                <i class="fa fa-plus" aria-hidden="true"></i></span>
                                        </a>
                                    </div>
                                </div>
                            </div>


                            <div class="table-wrapper">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="align">
                                        <thead>
                                            <tr>
                                                <th>Sl. No.</th>
                                                <th>Course Name</th>
                                                <th>Course Duration</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($ai_courses as $index => $ai_courses)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    {{ $ai_courses['course_name'] }}
                                                    </a>
                                                </td>
                                                <td>{{ $ai_courses['course_duration'] }}</td>

                                                <td><a href="{{ route('ai_course.show', $ai_courses['course_id']) }}"
                                                        class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i> View
                                                    </a></td>
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






@endsection