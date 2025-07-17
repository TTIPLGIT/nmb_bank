@extends('layouts.adminnav')

@section('content')
<style>
    .dt-buttons.btn-group {
        display: none !important;
    }

    .mystyle {
        border: 2px solid red;
    }

    .btn-check:checked+.btn-outline-primary {
        background-color: #5065cc !important;
        color: white !important;
        border-color: #5065cc !important;
    }

    .submit_category button {
        display: flex;
        justify-content: flex-end;
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.3/xlsx.full.min.js"></script>

<div class="main-content">
    <section class="section">
        <div class="section-body">
            {{ Breadcrumbs::render('catagory_create') }}

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <form method="POST" action="{{ route('catagory.store') }}" id="catagory_submit">
                                @csrf
                                <h4 style="color:black;text-align:center;margin-bottom:20px">Create Category</h4>

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
                                        <label>Number of Course to achieve this Badge<span class="text-danger">*</span></label>
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
                                <div class="row mt-3" id="StreakChallange" style="display:none;">
                                    <div class="form-group col-md-4">
                                        <label>Streak Name<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="streak_name" id="streak_name">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Number of Course to achieve this Streak<span class="text-danger">*</span></label>
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
                                                <input type="radio" class="btn-check" name="complete_within" value="date" id="achieve_date" autocomplete="off" onclick="updatePlaceholder()">
                                                <label class="btn btn-outline-primary" for="achieve_date" style="color:black">Day</label>
                                            </div>


                                            <div>
                                                <input type="radio" class="btn-check" name="complete_within" value="time" id="achieve_time" autocomplete="off" onclick="updatePlaceholder()">
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
                                    <label class="form-label">Course Locked</label><span class="text-danger">*</span><br>
                                    <input type="radio" class="btn-check" name="course_locked" value=1 id="course_locked_yes" autocomplete="off" onclick="toggleUnlockPoints()">
                                    <label class="btn btn-outline-primary" for="course_locked_yes" style="color:black" value=1>Yes</label>

                                    <input type="radio" class="btn-check" name="course_locked" value=1 id="course_locked_no" autocomplete="off" onclick="toggleUnlockPoints()">
                                    <label class="btn btn-outline-primary" for="course_locked_no" style="color:black" value=0>No</label>


                                </div>

                                <div class="form-group  col-6" id="unlockPointsDiv" style="display: none;">
                                    <label class="form-label">Points to Unlock<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="points_to_unlock" placeholder="Enter points" id="points_to_unlock">


                                </div>
                                <div class="row mt-4">
                                    <div class="col-12 d-flex justify-content-center gap-2">
                                        <button style="margin-right:10px" class="btn btn-success" onclick="gencre(event)">Submit</button>
                                        <a class="btn btn-danger" style="color:white;" href="{{ route('catagory_list') }}">Back</a>
                                    </div>
                                </div>
                        </div>
                        <!-- Buttons -->

                        </form>
                    </div>

                </div>
            </div>
        </div>

</div>
</section>
</div>

<!-- SweetAlert -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>

<!-- JS -->
<script>
    function gencre(event) {
        event.preventDefault();

        var category = $("#catagory_name").val().trim();
        var description = $("#description").val().trim();
        var badgeYes = $("#badge_yes").is(":checked");
        var badgeNo = $("#badge_no").is(":checked");
        var streakChallenge = $("#streak_challenge_yes").is(":checked");
        var streakNo = $("#streak_challenge_no").is(":checked");
        var day = $("#achieve_date").is(":checked");
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
                Swal.fire("Please select either 'Day' or 'Hours' for Completion Type.", "", "error");
                return false;
            }
            if ($("#achieve_value").val().trim() === '') {
                let message = day ? "Please enter the Day" : time ? "Please enter the Hours" : "Please enter the Hours or Date";
                Swal.fire(message, "", "error");
                return false;
            }
            if ($("#achieve_icon").val().trim() === '') {
                Swal.fire("Please Enter the Streak Icon", "", "error");
                return false;
            }
        }

        // Course Locked check (optional if mandatory)
        if (!courseLocked) {
            Swal.fire("Please select 'Yes' or 'No' for Course Locked.", "", "error");
            return false;
        }
        if ($("#points_to_unlock").val().trim() === '') {
            Swal.fire("Please Enter the points to unlock", "error");
            return false;
        }

        // Submit if all validations pass
        $("#catagory_submit").submit();
    }

    function toggleBadgeFields() {
        document.getElementById("badgeFields").style.display = document.getElementById("badge_yes").checked ? "flex" : "none";
        document.getElementById("StreakChallange").style.display = document.getElementById("streak_challenge_yes").checked ? "flex" : "none";
    }

    $(document).ready(function() {
        toggleBadgeFields();
        $('input[name="badge"]').change(toggleBadgeFields);
        $('input[name="streak_challenge"]').change(toggleBadgeFields);
    });


function updatePlaceholder() {
    const input = document.getElementById("achieve_value");
    const isDay = document.getElementById("achieve_date").checked;
    const isTime = document.getElementById("achieve_time").checked;

    if (isDay) {
        input.placeholder = "Please enter the total number of days";
    } else if (isTime) {
        input.placeholder = "Please enter the time";
    } else {
        input.placeholder = "Please enter the day or time";
    }
}
</script>
<script>
    function toggleUnlockPoints() {
        document.getElementById("unlockPointsDiv").style.display = document.getElementById("course_locked_yes").checked ? "block" : "none";

    }
</script>
@endsection