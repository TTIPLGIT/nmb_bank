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
                                <form action="{{route('create_course')}}" method="post">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Course Category <span style="color: red;">*</span></label>
                                                    <select class="form-control" name="course_category_id" id="course_category_id_show">
                                                        <option value="">---Select Category---</option>

                                                        @foreach($rows['course_catagory_name'] as $data)
                                                        <option value="{{$data['catagory_id']}}" data-badge="">{{$data['catagory_name']}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Role <span style="color: red;">*</span></label>
                                                    <select name="role" id="role" class="form-control" required>
                                                        <option value="">Select Role</option>

                                                        @foreach($rows['rows'] as $role)
                                                            <option value="{{ $role['role_id'] }}">
                                                                {{ $role['role_name'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Designation <span style="color: red;">*</span></label>
                                                    <select class="form-control" name="designation_id" id="designation_id_show">
                                                        <!-- <option value="">Please Select Designation</option> -->
                                                        @foreach( $rows['designation'] as $values)
                                                        <option value="{{ $values['designation_id'] }}">{{ $values['designation_name'] }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Course Name <span style="color: red;">*</span></label>
                                                    <input class="form-control" type="text" name="course_name" placeholder="Enter Course Name" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Course Description <span style="color: red;">*</span></label>
                                                    <input class="form-control" type="text" name="course_description" placeholder="Enter Description" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Course Type <span style="color: red;">*</span></label>
                                                    <input class="form-control" type="text" name="course_type" placeholder="Enter Course Type" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Class Count <span style="color: red;">*</span></label>
                                                    <input class="form-control" type="text" name="class_count" placeholder="Enter Class Count" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Course Duration <span style="color: red;">*</span></label>
                                                    <select name="course_duration" id="course_duration" class="form-control">
                                                        <option value="15">15 - Mins</option>
                                                        <option value="30">30 - Mins</option>
                                                        <option value="1">1 HRS</option>
                                                        <option value="2">2 HRS</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="text-align:center">
                                        <button class="btn btn-success" type="submit">Submit</button>
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






@endsection