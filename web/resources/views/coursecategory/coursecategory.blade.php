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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.3/xlsx.full.min.js"></script>
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <section class="section">
                <div class="section-body">{{ Breadcrumbs::render('catagory_list') }}


                    <div class="d-flex justify-content-start  ml-3 mb-3">
                        <a href="{{ route('catagory_create') }}" class="btn btn-success " style="margin-right:100px">Create <i class="fa fa-plus"
                                aria-hidden="true"></i></a>
                    </div>

                    <div class="row">

                        <div class="col-12">

                            <div class="card">

                                <div class="card-body">
                                    <h4 style="color:black; text-align: center;">List Category</h4>
                                    <div class="row">
                                        <!-- <div class="col-lg-12 text-center">
          <h4 style="color:darkblue;">Folder List</h4>
        </div> -->

                                    </div>
                                    @if (session('success'))


                                    @elseif(session('error'))


                                    @endif

                                    <div class="table-wrapper">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="align1">
                                                <thead>
                                                    <tr>
                                                        <th>Sl. No.</th>
                                                        <th>Category</th>
                                                        <!-- <th>Sub Catagory</th> -->
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach($categories as $catagory)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{ $catagory['catagory_name'] }}</td>
                                                        <!-- <td>{{ $catagory['sub_catagory'] }}</td> -->
                                                        <td> <a class="btn btn-link" title="Edit" type="GET" id="gcb"
                                                                onclick="fetch_show({{$catagory['catagory_id']}},'edit')"
                                                                data-toggle="modal" data-target="#addModal4"><i
                                                                    class="fas fa-pencil-alt"
                                                                    style="color: blue !important"></i></a>
                                                            <a class="btn btn-link" type="show"
                                                                onclick="fetch_show({{$catagory['catagory_id']}},'show')"
                                                                title="Show" id="gcb" href="" data-toggle="modal"
                                                                data-target="#addModal4"><i class="fas fa-eye"
                                                                    style="color:green"></i></a>


                                                            <a type="button" title="Delete"
                                                                onclick="fetch_delete({{$catagory['catagory_id']}},'delete')"
                                                                class="btn btn-link"><i class="far fa-trash-alt"
                                                                    style="color:red"></i></a>
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

                </div>
        </div>
    </section>



</div>
</section>
</div>

<!-- This Model is for only view -->
<div class="modal fade" id="addModal4">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="card-body">
                <form method="POST" action="{{ url('/course/catagory_update') }}" id="catagory_Update">
                    <button type="button" style="color:red;padding:20px" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    @csrf
                    <input type="hidden" id="catagory_id" name="catagory_id">
                    <h4 style="color:black;text-align:center;margin-bottom:20px" id="sub_title_name">Create Category</h4>


                    <div class="row">
                        <div class="form-group col-6">
                            <label>Category<span class="text-danger">*</span></label>
                            <input type="text" class="form-control default" id="catagory_name" name="catagory_name" required>
                        </div>

                        <div class="form-group col-6">
                            <label>Description<span class="text-danger">*</span></label>
                            <input type="text" class="form-control default" id="description" name="description" required>
                        </div>

                        <div class="form-group col-4">
                            <label>Badge<span class="text-danger">*</span></label><br>
                            <input type="radio" class="btn-check" name="badge" value="1" id="badge_yes" autocomplete="off" onclick="toggleBadgeFields()">
                            <label class="btn btn-outline-primary" for="badge_yes">Yes</label>

                            <input type="radio" class="btn-check" name="badge" value="0" id="badge_no" autocomplete="off" onclick="toggleBadgeFields()">
                            <label class="btn btn-outline-primary" for="badge_no">No</label>
                        </div>


                    </div>

                    <!-- Badge Fields -->
                    <div class="row mt-3" id="badgeFields" style="display: none;">
                        <div class="form-group col-md-4">
                            <label>Badge Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="badge_name" id="badge_name">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Course to achieve this Badge<span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="badge_count" id="badge_count">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Badge Icon<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="badge_icon" id="badge_icon">
                        </div>
                    </div>

                    <div class="form-group col-6">

                        <label>Streak Challenge<span class="text-danger">*</span></label><br>
                        <input type="radio" class="btn-check" name="streak_challenge" value=1 id="streak_challenge_yes" autocomplete="off" onclick="toggleBadgeFields()">
                        <label class="btn btn-outline-primary" for="streak_challenge_yes">Yes</label>

                        <input type="radio" class="btn-check" name="streak_challenge" value=0 id="streak_challenge_no" autocomplete="off" onclick="toggleBadgeFields()">
                        <label class="btn btn-outline-primary" for="streak_challenge_no">No</label>

                    </div>
                    <!-- Streak Challenge Fields -->
                    <div class="row mt-3" id="StreakChallange" style="display: none;">
                        <div class="form-group col-md-4">
                            <label>Streak Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="streak_name" id="streak_name">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Course to achieve this Streak<span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="number_course_for_streak" id="streak_count">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Bonus Points<span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="bonus_point" id="streak_points">
                        </div>

                        <div class="form-group col-6">
                            <label>Complete within this <span class="text-danger">*</span></label><br>

                            <div class="form-group d-flex align-items-center flex-wrap gap-10">

                                <div>
                                    <input type="radio" class="btn-check" name="complete_within" value="Day" id="achieve_day" autocomplete="off" onclick="toggleAchieveInput()">
                                    <label class="btn btn-outline-primary" for="achieve_day" style="color:black">Day</label>
                                </div>


                                <div>
                                    <input type="radio" class="btn-check" name="complete_within" value="time" id="achieve_time" autocomplete="off" onclick="toggleAchieveInput()">
                                    <label class="btn btn-outline-primary" for="achieve_time" style="color:black">Hours</label>
                                </div>

                                <div style="flex-grow: 1; padding-left:30px; min-width: 150px;">
                                    <input type="number" class="form-control" name="complete_within_type" id="achieve_value" placeholder="Enter Time or Day">
                                </div>
                            </div>
                        </div>


                        <div class="form-group col-6">
                            <label>Streak Icon <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="streak_icon" id="achieve_icon">
                        </div>

                    </div>
                    <div class="form-group col-12">
                        <label class="form-label">Course Locked <span class="text-danger">*</span></label><br>

                        <input type="radio" class="btn-check" name="course_locked" value="1" id="course_locked_yes" autocomplete="off" onclick="toggleBadgeFields()">
                        <label class="btn btn-outline-primary" for="course_locked_yes" style="color:black">Yes</label>

                        <input type="radio" class="btn-check" name="course_locked" value="0" id="course_locked_no" autocomplete="off" onclick="toggleBadgeFields()">
                        <label class="btn btn-outline-primary" for="course_locked_no" style="color:black">No</label>
                    </div>

                    <div class="form-group  col-6" id="unlockPointsDiv" style="display: none;">
                        <label class="form-label">Points to Unlock<span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="points_to_unlock" placeholder="Enter points" id="points_to_unlock">


                    </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 mb-5 d-flex justify-content-center gap-2">
                    <button style="margin-right:10px" class="btn btn-success" id="updateButton" onclick="gencre(event)">Update</button>
                    <a class="btn btn-danger" style="color:white;" href="{{ route('catagory_list') }}">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>



<script>
    function gencre(event) {
        event.preventDefault();

        var category = $("#catagory_name").val().trim();
        var description = $("#description").val().trim();
        var badgeYes = $("#badge_yes").is(":checked");
        var badgeNo = $("#badge_no").is(":checked");
        var streakChallenge = $("#streak_challenge_yes").is(":checked");
        var streakNo = $("#streak_challenge_no").is(":checked");
        var day = $("#achieve_day").is(":checked");
        var time = $("#achieve_time").is(":checked");
        var courseLocked = $("#course_locked_yes").is(":checked") || $("#course_locked_no").is(":checked");

        // Category name
        if (category === '') {
            Swal.fire("Please Enter the Category", "", "error");
            return false;
        }

        // Description
        if (description === '') {
            Swal.fire("Please Enter the Category Description", "", "error");
            return false;
        }

        // Badge radio check
        if (!badgeYes && !badgeNo) {
            Swal.fire("Please select 'Yes' or 'No' for Badge.", "", "error");
            return false;
        }

        // Badge details if yes
        if (badgeYes) {
            if ($("#badge_name").val().trim() === '') {
                Swal.fire("Please Enter the Badge Name", "", "error");
                return false;
            }
            if ($("#badge_count").val().trim() === '') {
                Swal.fire("Please Enter the Badge Count", "", "error");
                return false;
            }
            if ($("#badge_icon").val().trim() === '') {
                Swal.fire("Please Enter the Badge Icon", "", "error");
                return false;
            }
        }

        // Streak challenge radio check
        if (!streakChallenge && !streakNo) {
            Swal.fire("Please select 'Yes' or 'No' for Streak Challenge.", "", "error");
            return false;
        }

        // Streak challenge details if yes
        if (streakChallenge) {
            if ($("#streak_name").val().trim() === '') {
                Swal.fire("Please Enter the Streak Name", "", "error");
                return false;
            }
            if ($("#streak_count").val().trim() === '') {
                Swal.fire("Please Enter the Number of Courses for Streak", "", "error");
                return false;
            }
            if ($("#streak_points").val().trim() === '') {
                Swal.fire("Please Enter the Bonus Points", "", "error");
                return false;
            }
            if (!day && !time) {
                Swal.fire("Please select either 'Day' or 'Time' for Completion Type.", "", "error");
                return false;
            }
            if ($("#achieve_value").val().trim() === '') {
                let message = day ? "Please enter the Day" : time ? "Please enter the Time" : "Please enter the Time or Date";
                Swal.fire(message, "", "error");
                return false;
            }
            if ($("#achieve_icon").val().trim() === '') {
                Swal.fire("Please Enter the Streak Icon", "", "error");
                return false;
            }
        }


        if (!courseLocked) {
            Swal.fire("Please select 'Yes' or 'No' for Course Locked.", "", "error");
            return false;

            if ($("#points_to_unlock").val().trim() === '') {
                Swal.fire("Please Enter the points to unlock", "error");
                return false;
            }
        }

        document.getElementById("catagory_Update").submit();

        $(document).ready(function() {
            toggleBadgeFields();
            $('input[name="badge"]').change(toggleBadgeFields);

        });



    }
</script>

<style>
    .btn-check:checked+.btn-outline-primary {
        background-color: #1a73e8 !important;
        color: black !important;
    }
</style>

<script>
    function fetch_show(catagory_id, type) {
        $.ajax({
            url: "{{ url('/course/catagory/fetch') }}",
            type: 'GET',
            data: {
                'catagory_id': catagory_id,
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                console.log(data);

                let row = data.rows[0];

                $('#catagory_name').prop('disabled', false).val(row.catagory_name);
                $('#sub_catagory').prop('disabled', false).val(row.sub_catagory);
                $('#description').prop('disabled', false).val(row.description);
                $('#badge_name').prop('disabled', false).val(row.badge_name);
                $('#badge_count').prop('disabled', false).val(row.badge_count);
                $('#badge_icon').prop('disabled', false).val(row.badge_icon);
                $('#streak_name').prop('disabled', false).val(row.streak_name);
                $('#streak_count').prop('disabled', false).val(row.number_course_for_streak);
                $('#streak_points').prop('disabled', false).val(row.bonus_point);
                $('#achieve_value').prop('disabled', false).val(row.complete_within_type);
                $('#achieve_icon').prop('disabled', false).val(row.streak_icon);
                $('#points_to_unlock').prop('disabled', false).val(row.points_to_unlock);
                $('#catagory_id').val(catagory_id);

                // Set badge radio buttons
                if (row.badge === 1) {
                    $('#badge_yes').prop('checked', true);
                    $('#label_badge_yes').addClass('active');
                    $('#label_badge_no').removeClass('active');
                } else if (row.badge === 0) {
                    $('#badge_no').prop('checked', true);
                    $('#label_badge_no').addClass('active');
                    $('#label_badge_yes').removeClass('active');
                }
                if (row.streak_challenge === 1) {
                    $('#streak_challenge_yes').prop('checked', true);
                } else {
                    $('#streak_challenge_no').prop('checked', true);
                }

                if (row.course_locked === 1) {
                    $('#course_locked_yes').prop('checked', true);
                } else {
                    $('#course_locked_no').prop('checked', true);
                }

                if (row.complete_within === "time") {
                    $('#achieve_time').prop('checked', true);
                    $('#label_achieve_time').addClass('active');
                    $('#label_achieve_day').removeClass('active');
                } else if (row.complete_within === "day") {
                    $('#achieve_date').prop('checked', true);
                    $('#label_achieve_day').addClass('active');
                    $('#label_achieve_time').removeClass('active');
                }




                toggleBadgeFields();

                if (type === "show") {
                    $('#catagory_name, #sub_catagory, #description, #badge_yes, #badge_no, #badge_name, #badge_count, #badge_icon,#streak_challenge_yes,#streak_challenge_no, #streak_name,#streak_count,#streak_points,#achieve_day,#achieve_time,#achieve_value,#achieve_icon,#course_locked_yes,#course_locked_no,#points_to_unlock').prop('disabled', true);
                    $('#updateButton').hide();
                    $('#sub_title_name').html("Category");
                    $('#title_name').html("Category");
                } else {
                    $('#catagory_name, #sub_catagory, #description, #badge_yes, #badge_no, #badge_name, #badge_count, #badge_icon,#streak_challenge_yes,#streak_challenge_no, #streak_name,#streak_count,#streak_points,#achieve_day,#achieve_time,#achieve_value,#achieve_icon,#course_locked_yes,#course_locked_no,#points_to_unlock').prop('disabled', false);
                    $('#updateButton').show();
                    $('#sub_title_name').html("Edit Category");
                    $('#title_name').html("Edit Category");
                }
            }
        });
    }

    function toggleBadgeFields() {

        if ($('#badge_yes').is(':checked')) {
            $('#badge_name, #badge_count, #badge_icon').closest('.form-group').show();
        } else {
            $('#badge_name, #badge_count, #badge_icon').closest('.form-group').hide();
        }
        if ($('#streak_challenge_yes').is(':checked')) {
            $('#streak_name, #streak_count, #streak_points,#achieve_value,#achieve_icon').closest('.form-group').show();
        } else {
            $('#streak_name, #streak_count, #streak_points,#achieve_value,#achieve_icon').closest('.form-group').hide();
        }
       


    }

    $(document).ready(function() {
        toggleBadgeFields();
    });
</script>
<script>
    function toggleAchieveInput() {
        const isDay = document.getElementById("achieve_day").checked;
        const isTime = document.getElementById("achieve_time").checked;
        const achieveInput = document.getElementById("achieve_value");

        if (isDay) {

            achieveInput.value = "";
            achieveInput.placeholder = "Please enter days";
        } else if (isTime) {
            achieveInput.value = "";
            achieveInput.placeholder = "Please enter the time";
        }
    }
</script>


<script>
    function fetch_update_edit(catagory_id, type) {
        $.ajax({
            url: "{{ url('/course/catagory/fetch') }}",
            type: 'GET',
            data: {
                catagory_id: catagory_id,
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                $('#catagory_name').val(data.rows[0]['catagory_name']);
                $('#sub_catagory').val(data.rows[0]['sub_catagory']);
                $('#description').val(data.rows[0]['description']);
                $('#catagory_id').val(data.rows[0]['catagory_id']);

                c
                $('#catagory_name, #sub_catagory, #description').prop('disabled', false);
                $('#updateButton').show();

                $('#addModal4').modal('show');
            }
        });
        document.getElementById("catagory_Update").submit();
    }
</script>
<script>
    function toggleBadgeFields() {
        const isBadgeYes = document.getElementById("badge_yes").checked;
        const badgeFields = document.getElementById("badgeFields");
        const streakCheck = document.getElementById("streak_challenge_yes").checked;
        const streakField = document.getElementById("StreakChallange");
        const points = document.getElementById("course_locked_yes").checked;
        const pointscheck = document.getElementById("unlockPointsDiv");


        if (isBadgeYes) {
            badgeFields.style.display = "flex";
        } else {
            badgeFields.style.display = "none";
        }
        if (streakCheck) {
            streakField.style.display = "flex";
        } else {
            streakField.style.display = "none";
        }
        if (points) {
            pointscheck.style.display = "block";
        } else {
            pointscheck.style.display = "none";
        }
    }
</script>

<script>
    function fetch_delete(catagory_id, type) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('/course_catagory_delete') }}",
                    type: 'POST',
                    data: {
                        catagory_id: catagory_id,
                        _token: '{{ csrf_token() }}'
                    },
                    error: function() {
                        Swal.fire("Error!", "Something went wrong.", "error");
                    },
                    success: function(data) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Course Category Deleted Successfully.",
                            icon: "success"
                        }).then(() => {

                            window.location.href = "{{ route('catagory_list') }}";
                        });
                    }
                });
            }
        });

    }
</script>

@endsection