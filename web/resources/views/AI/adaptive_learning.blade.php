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
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <section class="section">

        <div class="col-lg-12 text-center">
            <h4 style="color:darkblue;">Adaptive Learing</h4>
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
                            <h4><span>Filter By</span></h4>
                            <form action="{{route('adaptive_learning')}}"  method="GET">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>User Name <span style="color: red;">*</span></label>
                                            <select name="user_name" id="user_name" class="form-control select2">
                                                <option value="">---Select a User ---</option>
                                                @foreach($rows['users'] as $users)
                                                <option value="{{$users['id']}}">{{$users['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Course Name <span style="color: red;">*</span></label>
                                            <select name="course_name" id="course_name" class="form-control">
                                                <option value="">---Select a Course ---</option>
                                                @foreach($rows['courses'] as $courses)
                                                <option value="{{$courses['course_id']}}" data-users="{{ $courses['user_ids'] }}">{{$courses['course_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="text_cente" style="text-align:center">
                                    <button class="btn btn-success">Submit</button>
                                </div>
                            </form>

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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/table2excel.js') }}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    var $j = jQuery.noConflict();

    $j(document).ready(function() {
        $j('#user_name').select2();
    });

    $j(document).ready(function() {
        $j('#course_name').select2();
    });
</script>

<script>
    $(document).ready(function() {

        $('#user_name').on('change', function() {

            var userId = $(this).val();
            console.log("Selected User:", userId);

            $('#course_name option').each(function() {

                var users = $(this).attr('data-users');

                if (!users) {
                    $(this).hide();
                    return;
                }

                var userArray = users.split(',').map(s => s.trim());

                if (userArray.includes(userId)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

            $('#course_name').val('');
        });

    });
</script>

<script>
document.getElementById('adaptiveForm').addEventListener('submit', function(e){

    e.preventDefault();

    var user = document.getElementById('user_name').value;
    var course = document.getElementById('course_name').value;

    if(!user || !course){
        alert("Please select user and course");
        return;
    }

    var url = "{{ url('adaptive/learning') }}/" + user + "/" + course;

    window.location.href = url;
});
</script>







@endsection