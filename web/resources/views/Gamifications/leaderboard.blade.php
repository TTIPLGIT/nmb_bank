@extends('layouts.adminnav')

@section('content')
<style>
    .main-content {
        background: linear-gradient(to right, #000428, #004e92);
        color: BLACK;

    }

    .leaderboard-title {
        text-align: center;
        font-size: 2rem;
        font-weight: bold;
        color: white;
    }

    .podium {
        display: flex;
        justify-content: center;
        align-items: flex-end;
        gap: 1.5rem;
        margin-bottom: 3rem;
        margin-top: 50px;
    }

    .user {
        display: flex;
        justify-content: center;
        align-items: flex-end;
        gap: 1.5rem;
        margin-bottom: 3rem;
        margin-top: 50px;
        margin-right: 120px;
        margin-left: 20px;
    }


    .podium-card {
        background-color: #1a1a2e;
        padding: 1rem;
        border-radius: 20px;
        width: 180px;
        position: relative;
        color: white;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
        transition: transform 0.3s;
    }

    .podium-card img {
        width: 80px;
        height: 80px;
        border-radius: 50px;
        border: 3px solid #ffffff;
        margin-bottom: 0.5rem;
    }

    .profile-img {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid white;
        margin-bottom: 0.5rem;
    }

    .crown {
        position: absolute;
        top: -65px;
        left: 50%;
        transform: translateX(-50%);
        width: 50px;
        z-index: 2;
        border-radius: 0 !important;
        border: none !important;
        box-shadow: none !important;
        background: transparent !important;
    }

    .position-badge {
        position: absolute;
        top: 0;
        left: 0;
        background: white;
        padding: 5px;
        border-bottom-right-radius: 10px;
    }

    .podium-card h6 {
        margin: 0.5rem 0 0.2rem;
        font-weight: 600;
    }

    .score {
        font-size: 14px;
        color: #ccc;
    }

    .position-badge img {
        width: 48px;
        height: 70px;
        background-color: transparent;
    }

    .first {
        height: 300px;
        top: 30px;
    }

    .second {
        height: 280px;
        top: 30px;
    }

    .third {
        height: 260px;
        top: 30px;
    }

    .userscard {
        height: 220px;
        position: absolute;
        top: 260px;
        margin-right: 40px;
        margin-left: 4px;
        border: 5px solid rgba(255, 215, 0, 0.6);
        border-radius: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }


    .podium-card h6 {
        margin-top: 0.5rem;
        color: #ffffff;
        font-size: 1rem;
    }



    .table-wrapper {
        background-color: #0c0c1f;
        border-radius: 1rem;
        padding: 1rem;
        max-width: 900px;
        margin: auto;
    }

    table.leaderboard-table {
        width: 100%;
        color: linear-gradient(to right, #000428, #004e92);
        border-collapse: collapse;
    }

    table.leaderboard-table th {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #444;
        color: linear-gradient(to right, #000428, #004e92);

    }



    table.leaderboard-table th {
        color: white;
        background-color: #0c0c1f;

    }

    .rank-icon {
        width: 20px;
    }

    .podium-card {
        transition: all 0.2s ease;
    }


    .podium-card:hover {
        transform: scale(1.05);
        box-shadow: 0 0 20px rgba(255, 215, 0, 0.6);
        background: linear-gradient(to right, #000428, #004e92);
    }


    .leaderboard-table tr:hover {

        background: linear-gradient(to right, #000428, #004e92);
        color: black;
        cursor: pointer;
        transform: scale(1.05);
        box-shadow: 0 0 20px rgba(255, 215, 0, 0.6);
        background-color: rgba(255, 255, 255, 0.05);
    }

    .leaderboard-table tr:hover {

        background: linear-gradient(to right, #000428, #004e92);
        color: black;
        cursor: pointer;
        transform: scale(1.05);
        box-shadow: 0 0 20px rgba(255, 215, 0, 0.6);
        background-color: rgba(255, 255, 255, 0.05);
    }



    .rank-badge {
        position: absolute;
        bottom: 10px;
        right: 50px;
        color: white;
        font-weight: bold;
        padding: 8px 12px;
        font-size: 16px;
        border-radius: 0 !important;
        border: none !important;
        box-shadow: none !important;
        background: transparent !important;
    }


    .custom-gap {
        gap: 1rem;
    }

    .modal-content {
        background-color: #004e92;
    }

    .dropdown-wrapper {

        color: white;

    }

    .dropdown-wrapper .form-label {
        color: #fff;
        font-weight: 600;
    }

    .form-select {
        /* background-color: #1e2a38; */
        color: #fff;
        padding: 8px 15px;
    }

    .gif-overlay {
        position: fixed;
        top: 50%;
        left: 60%;
        transform: translate(-50%, -50%);
        z-index: 9999;
        pointer-events: none;
    }

    .gif-overlay img {
        width: 1200px;
        height: 539px;

    }

    .btn-active {
        background-color: #0d6efd !important;

        color: white !important;
        border-color: #0d6efd !important;
    }

    .modal-dialog {
        background: white !important;
        box-shadow: none !important;
    }


    .modal-content {
        border: none !important;

        /* optional subtle shadow */
        background-color: white !important;
        /* ensures white bg */
        border-radius: 8px;
    }

    /* Remove close button padding if needed */
    .modal .close {
        position: absolute;
        top: 10px;
        right: 15px;
        padding: 0;
        background: transparent;
        border: none;
        font-size: 24px;
    }

    #filterclose {
        margin-top: -100px;
    }

    .card-body {
        margin-top: 100px;
    }

    .modal-header {
        background-color: white !important;
    }

    .modal-body {
        margin-top: 5px;
    }

    .table-wrapper {
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
    }

    /* Scrollable container */
    .leaderboard-scroll {
        max-height: 250px;
        overflow-y: auto;
    }

    /* Show scrollbar only when scroll-enabled is active */
    .scroll-enabled::-webkit-scrollbar {
        width: 6px;
    }

    .scroll-enabled::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: 10px;
    }

    .scroll-enabled::-webkit-scrollbar-track {
        background: transparent;
    }

    /* Optional: Keep style consistent */
    .leaderboard-table {
        width: 100%;
        border-collapse: collapse;
    }

    .leaderboard-table th {
        padding: 12px 15px;
        text-align: left;
        color: black;
        border-bottom: 1px solid #ddd;
    }
</style>

<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div id="main-content">
                <div class="d-flex justify-content-center">
                    <div class="leaderboard-title d-flex align-items-center gap-2">
                        <img src="/images/leaderboard/leaderboard.png" style="height: 40px; width: 40px; margin-right:10px " alt="Crown" />
                        <span style="font-size: 28px; font-weight: bold; color: white;">Leaderboard</span>
                    </div>
                </div>
                <div class="container dropdown-wrapper">

                    <div class="card p-3" style="border: none;">

                        <div class="d-flex justify-content-end align-items-center flex-wrap gap-3 mt-3">


                            <button class="btn bg-white text-dark d-flex align-items-center" style="margin-right:10px;padding:10px"
                                data-toggle="modal" data-target="#exampleModal">
                                <i class="fa fa-filter me-2"></i>
                            </button>


                            <div class="btn-group" role="group">
                                <button class="btn bg-white text-dark filter-btn" data-filter="ALL" style="margin-right:10px" onclick="applyFilter('ALL')">ALL</button>
                                <button class="btn bg-white text-dark filter-btn" data-filter="WEEKLY" style="margin-right:10px" onclick="applyFilter('WEEKLY')">WEEKLY</button>
                                <button class="btn bg-white text-dark filter-btn" data-filter="MONTHLY" onclick="applyFilter('MONTHLY')">MONTHLY</button>
                            </div>

                        </div>

                    </div>
                </div>




                <div class="row d-flex justify-content-center   ">


                    @if(session('show_gif'))
                    <div class="gif-overlay">
                        <img src="{{ asset('images/leaderboard/Celebrate.gif') }}" alt="Celebration" />
                    </div>

                    <script>
                        setTimeout(() => {
                            document.querySelector('.gif-overlay').style.display = 'none';
                        }, 3000);
                    </script>
                    @endif
                    @if(isset($filterMessageText))
                    <div id="filterMessageAlert"
                        class="alert alert-success alert-dismissible fade show mx-auto position-relative"
                        role="alert"
                        style="background-color: transparent; color: white;  padding: 10px 20px; width: 100%; text-align: center;">

                        <p class="mb-0">{!! $filterMessageText !!}</p>
                    </div>

                    <script>
                        setTimeout(function() {
                            let alertBox = document.getElementById('filterMessageAlert');
                            if (alertBox) {
                                alertBox.classList.remove('show');
                                alertBox.classList.add('hide');
                                setTimeout(() => {
                                    alertBox.remove();
                                }, 500);
                            }
                        }, 5000);
                    </script>
                    @endif


                    @if(isset($currentUserRank) && session('role_type') !== 'Admin')
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3 podium-card userscard text-center float-start"
                                style="cursor: pointer;"
                                data-toggle="modal"
                                data-target="#addModal4"
                                onclick="fetch_show({{ $user_id }}, 'show')">

                                <img src="/images/leaderboard/rank 2.jpg" alt="{{ $currentUserRank['name'] }}" class="profile-img" />

                                <div class="mt-3  fw-bold">
                                    🎉 Congratulations <span class="text-success">{{ $currentUserRank['name'] }}</span><br>
                                    You are ranked <span class="text-success">#{{ $currentUserRank['rank'] }}</span> with <span class="text-danger">{{ $currentUserRank['points'] }} pts</span>!
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif




                    @php
                    function getProfileImage($user) {
                    return $user->profile_image
                    ? config('setting.base_url') . $user->profile_image
                    : asset('images/empty.jpg');
                    }
                    @endphp

                    <div class="podium d-flex justify-content-center">

                        <div class="podium d-flex justify-content-center">
                            @if(isset($rows['top3'][1]))
                            <div id="second-place"
                                class="podium-card second position-relative text-center"
                                data-toggle="modal"
                                data-target="#profile_details"
                                style="cursor: pointer;"
                                data-name="{{ $rows['top3'][1]->name }}"
                                data-points="{{ $rows['top3'][1]->total_points }}"
                                data-img="{{ getProfileImage($rows['top3'][1]) }}"
                                data-userid="{{ $rows['top3'][1]->id }}">

                                <img id="second-img"
                                    src="{{ getProfileImage($rows['top3'][1]) }}"
                                    class="profile-img" />
                                <h6 id="second-name">{{ $rows['top3'][1]->name }}</h6>
                                <span class="score" id="second-points">{{ $rows['top3'][1]->total_points }} </span> Points<br>

                                @if(isset($rows['metric_type']) && $rows['metric_type'] === 'hours')
                                <span class="score" id="second-hours">{{ $rows['top3'][1]->total_hours }} Hours</span>

                                @endif

                                <img src="/images/leaderboard/2nd.png" class="rank-badge" />
                            </div>
                            @endif


                            @if(isset($rows['top3'][0]))
                            <div id="first-place"
                                class="podium-card first position-relative text-center"
                                data-toggle="modal"
                                data-target="#profile_details"
                                style="cursor: pointer;"
                                data-name="{{ $rows['top3'][0]->name }}"
                                data-points="{{ $rows['top3'][0]->total_points }}"
                                data-img="{{ getProfileImage($rows['top3'][0]) }}"
                                data-userid="{{ $rows['top3'][0]->id }}">

                                <img src="/images/leaderboard/crown.png" class="crown" />
                                <img id="first-img"
                                    src="{{ getProfileImage($rows['top3'][0]) }}"
                                    class="profile-img" />
                                <h6 id="first-name">{{ $rows['top3'][0]->name }}</h6>
                                <span class="score" id="first-points">{{ $rows['top3'][0]->total_points }} </span> Points
                                <br>
                                @if(isset($rows['metric_type']) && $rows['metric_type'] === 'hours')
                                <span class="score" id="first-hours">{{ $rows['top3'][0]->total_hours }} </span>Hours

                                @endif


                                <img src="/images/leaderboard/1st.png" class="rank-badge" />
                            </div>
                            @endif


                            @if(isset($rows['top3'][2]))
                            <div id="third-place"
                                class="podium-card third position-relative text-center"
                                data-toggle="modal"
                                data-target="#profile_details"
                                style="cursor: pointer;"
                                data-name="{{ $rows['top3'][2]->name }}"
                                data-points="{{ $rows['top3'][2]->total_points }}"
                                data-img="{{ getProfileImage($rows['top3'][2]) }}"
                                data-userid="{{ $rows['top3'][2]->id }}">

                                <img id="third-img"
                                    src="{{ getProfileImage($rows['top3'][2]) }}"
                                    class="profile-img" />
                                <h6 id="third-name">{{ $rows['top3'][2]->name }}</h6>
                                <span class="score" id="third-points">{{ $rows['top3'][2]->total_points }}</span> Points
                                <br>

                                @if(isset($rows['metric_type']) && $rows['metric_type'] === 'hours')
                                <span class="score" id="third-hours">{{ $rows['top3'][2]->total_hours }} Hours</span>

                                @endif

                                <img src="/images/leaderboard/3rd.png" class="rank-badge" />
                            </div>
                            @endif

                        </div>


                    </div>

                </div>

            </div>

            <div class="table-wrapper">

                <table class="leaderboard-table">
                    <thead>
                        <tr>
                            <th style="padding-left:50px; width: 50px;">Rank</th>
                            <th style="padding-left:130px;">Name</th>
                            <th style="padding-left:280px;">Points</th>
                            @if($rows['metric_type'] === 'hours')
                            <th style="padding-left:100px;">Hours</th>
                            @endif

                        </tr>

                </table>


                @php
                $remainingUsers = $rows['leaderboard']->skip(3);
                @endphp

                <div class="leaderboard-scroll {{ count($remainingUsers) > 3 ? 'scroll-enabled' : '' }}">
                    <table class="leaderboard-table ">
                        <tbody id="rankTableBody">
                            @foreach($remainingUsers as $key => $value)
                            <tr class="leaderboard-row"
                                data-toggle="modal"
                                data-target="#profile_details"
                                style="cursor: pointer;"
                                data-name="{{ $value->name }}"
                                data-points="{{ $value->total_points }}"
                                data-img="{{ $value->profile_image ? config('setting.base_url') . $value->profile_image : config('setting.base_url') . 'images/empty.jpg' }}">
                                <th style="padding-left:50px; width: 50px;">{{ $key + 1 }}</th>
                                <th style="padding-left:150px;">{{ $value->name }}</th>
                                <th style="padding-right:6px;">{{ $value->total_points }}</th>
                                @if($rows['metric_type'] === 'hours')
                                <th style="padding-left:1px;">{{ $value->total_hours ?? 0 }}</th>
                                @endif



                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>


        </div>
</div>
</section>
</div>

</section>
</div>
<!-- Bootstrap 5 CSS (optional, if not already included) -->
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->

<!-- Bootstrap 5 JS Bundle (required for modal functionality) -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->

<!-- Profile Modal -->
<div class="modal fade" id="profile_details" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true" style="height:500px; margin-top:-100px;">
    <div class="modal-dialog modal-dialog-centered" style="margin-top: 10px;">
        <div class="modal-content rounded-4" style="margin-top: 10px; box-shadow: none; border: none;">

            <div class="modal-header border-0" style="background-color:white;margin-top:-150px">
                <h5 class="modal-title" id="profileModalLabel">User Profile</h5>
                <button type="button"
                    style="color: red; font-size: 24px; border: none; padding: 10px; margin-top: -150px; margin-right: 10px; background-color: transparent;"
                    class="close"
                    data-dismiss="modal"
                    aria-hidden="true">
                    &times;
                </button>
            </div>

            <div class="modal-body text-center">
                <img id="modal-profile-img" src="" class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;" />
                <h5 id="modal-name" class="fw-bold mb-2"></h5>
                <p class="mb-0">Total Points: <span id="modal-points"></span></p>
            </div>

        </div>
    </div>
</div>





<!-- filter modal -->


<div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content  border-0 p-4">

            <div class="card-body position-relative">


                <button type="button" style="color:red;  font-size: 24px;padding:20px; " id="filterclose" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <form id="courseForm" method="POST" action="{{ route('leaderboard.filter') }}">


                    @csrf
                    <input type="hidden" name="metric_type" id="metric_type" value="">

                    <div class="row g-4 justify-content-center">
                        <div class="col-md-10">
                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label fw-bold">Role:</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="role" id="role_id" onchange="filterDesignations()">
                                        <option value="">---Select Role---</option>
                                        @foreach($rows['role'] as $values)
                                        <option value="{{ $values->role_id }}"
                                            {{ request()->input('role') == $values->role_id ? 'selected' : '' }}>
                                            {{ $values->role_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label fw-bold">Designation:</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="designation" id="designation_id">
                                        <option value="">---Select Designation---</option>
                                        @foreach($rows['designation'] as $values)
                                        <option value="{{ $values->designation_id }}"
                                            {{ request()->input('designation') == $values->designation_id ? 'selected' : '' }}>
                                            {{ $values->designation_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-4 col-form-label fw-bold">Course:</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="course_catagory" id="course_category_id" onclick="category()">
                                        <option value="">---Select Category---</option>
                                        @foreach($rows['elearning_courses'] as $data)
                                        <option value="{{ $data->course_id }}"
                                            {{ request()->input('course_catagory') == $data->course_id ? 'selected' : '' }}>
                                            {{ $data->course_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            @php
                            $courseCat = request()->input('course_catagory');
                            $metricType = request()->input('metric_type');
                            @endphp

                            <div class="d-flex justify-content-center align-items-center gap-4 mt-4 mb-4" id="filterbuttons"
                                style="{{ $courseCat ? 'display: flex;' : 'display: none ! important;' }}">
                                <button type="button" id="pointsbutton" onclick="toggleMetricType('points')" value="points"
                                    class="btn border border-dark rounded-3 px-4 py-2 bg-white text-dark mr-4 {{ $metricType === 'points' ? 'btn-active' : '' }}">
                                    Points
                                </button>
                                <button type="button" id="hoursbutton" onclick="toggleMetricType('hours')" value="hours"
                                    class="btn border border-dark rounded-3 px-4 py-2 bg-white text-dark {{ $metricType === 'hours' ? 'btn-active' : '' }}">
                                    Hours
                                </button>
                            </div>

                            <input type="hidden" id="metric_type" value="points">
                            <div class="modal-footer  border-top-0">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="clearForm()">Clear</button>

                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>

                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


<script>
    let currentMetric = 'hours';
    const baseUrl = 'http://localhost:6061/';


    function toggleMetricType(type) {
        currentMetric = type;


        document.getElementById('pointsbutton').classList.remove('btn-active');
        document.getElementById('hoursbutton').classList.remove('btn-active');

        if (type === 'points') {
            document.getElementById('pointsbutton').classList.add('btn-active');
        } else {
            document.getElementById('hoursbutton').classList.add('btn-active');
        }

        document.getElementById('metric_type').value = type;

    }

    function applyFilter(filterType) {
        $.ajax({
            url: '/leaderboard-data',
            type: 'GET',
            data: {
                filter: filterType,
                metric: currentMetric
            },
            success: function(response) {
                updatePodium(response.top3);
                updateLeaderboardTable(response.rankList);
            },
            error: function(xhr) {
                console.error('AJAX Error:', xhr.responseText);
            }
        });
    }


    function updatePodium(top3) {
        const positions = ['first', 'second', 'third'];

        for (let i = 0; i < 3; i++) {
            const user = top3[i];
            $('#' + positions[i] + '-name').text(user ? user.name : '---');
            $('#' + positions[i] + '-points').text(user ? user.total_metric : 0);

            const imgPath = user && user.profile_image ? baseUrl + user.profile_image : baseUrl + 'images/empty.jpg';
            $('#' + positions[i] + '-img').attr('src', imgPath);

            $('#podium-card-' + (i + 1))
                .attr('data-name', user ? user.name : '')
                .attr('data-points', user ? user.total_metric : '')
                .attr('data-img', imgPath);
        }
    }

    function updateLeaderboardTable(users) {
        let tbody = $('#rankTableBody');
        tbody.empty();

        $.each(users.slice(3), function(index, user) {
            const imgPath = baseUrl + (user.profile_image || 'images/empty.jpg');

            tbody.append(`
                <tr class="leaderboard-row"
                    data-name="${user.name}"
                    data-points="${user.total_metric}"
                    style="cursor: pointer;"
                    data-toggle="modal"
                    data-target="#profile_details">
                    <th>${index + 4}</th>
                    <th>${user.name}</th>
                    <th>${user.total_metric}</th>
                </tr>
            `);
        });
    }

    function fetch_show(user_id, type) {
        $.ajax({
            url: "{{ url('/level_show') }}",
            type: 'GET',
            data: {
                'user_id': user_id,
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                // handle show
            }
        });
    }

    function category() {
        var selectedValue = document.getElementById('course_category_id').value;
        var buttonsDiv = document.getElementById('filterbuttons');
        var pointsbutton = document.getElementById('pointsbutton');
        var hoursbutton = document.getElementById('hoursbutton');

        if (selectedValue !== "") {
            buttonsDiv.style.display = 'flex';
            pointsbutton.style.display = 'flex';
            hoursbutton.style.display = 'flex';
            document.getElementById('pointsbutton').click();
        } else {
            buttonsDiv.style.display = 'none';
            pointsbutton.style.display = 'none';
            hoursbutton.style.display = 'none';
        }
    }

    function clearForm() {
        const form = document.getElementById("courseForm");
        form.querySelectorAll("select").forEach(select => select.selectedIndex = 0);
        form.querySelectorAll("input[type='text'], input[type='hidden']").forEach(input => input.value = '');

        const pointsBtn = document.getElementById("pointsbutton");
        const hoursBtn = document.getElementById("hoursbutton");

        if (pointsBtn) {
            pointsBtn.classList.remove('btn-active', 'bg-dark', 'text-white');
            pointsBtn.classList.add('bg-white', 'text-dark');
            pointsBtn.style.display = 'none';
        }

        if (hoursBtn) {
            hoursBtn.classList.remove('btn-active', 'bg-dark', 'text-white');
            hoursBtn.classList.add('bg-white', 'text-dark');
            hoursBtn.style.display = 'none';
        }

        document.getElementById('designation_id').innerHTML = '<option value="">---Select Designation---</option>';
    }

    const allDesignations = @json($rows['designation']);

    function filterDesignations() {
        const roleId = document.getElementById('role_id').value;
        const designationSelect = document.getElementById('designation_id');

        designationSelect.innerHTML = '<option value="">---Select Designation---</option>';

        allDesignations.filter(d => d.role_id == roleId).forEach(d => {
            const opt = document.createElement('option');
            opt.value = d.designation_id;
            opt.textContent = d.designation_name;
            designationSelect.appendChild(opt);
        });
    }

    $(document).ready(function() {
        $('.filter-btn').on('click', function() {
            var filterType = $(this).data('filter');

            $('.filter-btn').removeClass('active btn-success').addClass('bg-white text-dark');
            $(this).removeClass('bg-white text-dark').addClass('active btn-success');

            applyFilter(filterType);
        });

        $(document).on('click', '.podium-card, .leaderboard-row', function() {
            const name = $(this).data('name') || 'N/A';
            const points = $(this).data('points') || 0;
            const img = $(this).data('img') || (baseUrl + 'images/empty.jpg');

            $('#modal-name, #modalProfileName').text(name);
            $('#modal-points, #modalProfilePoints').text(points);
            $('#modal-profile-img, #modalProfileImage').attr('src', img);

            $('#profile_details').modal('show');
        });
    });
</script>


@endsection