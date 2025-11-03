@extends('layouts.adminnav')

@section('content')
<style>
    .main-content {
        background: linear-gradient(to right, #000428, #004e92);
        color: white;

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

    i#font-color {
        color: red;
    }

    @keyframes zoomPulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.3);
        }
    }

    .zoom-blink {
        animation: zoomPulse 1.5s ease-in-out infinite;
        color: orange;
        font-size: 30px;
    }
</style>

<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div id="main-content">
                <div class="d-flex justify-content-center">
                    <div class="leaderboard-title d-flex align-items-center gap-2">
                        <img src="/images/leaderboard/leaderboard.png" style="height: 30px; width: 40px; margin-right:10px " alt="Crown" />
                        <span style="font-size: 28px; font-weight: bold;">Leaderboard</span>
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


                    <div class="gif-overlay">
                        <img src="{{ asset('images/leaderboard/Celebrate.gif') }}" alt="Celebration" />
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            setTimeout(() => {
                                document.querySelector('.gif-overlay').style.display = 'none';
                            }, 3000);
                        });
                    </script>

                    @if(isset($rows['rows']['filterMessageText']))
                    <div id="filterMessageAlert"
                        class="alert alert-success alert-dismissible fade show mx-auto position-relative"
                        role="alert"
                        style="background-color: transparent; color: white;  padding: 10px 20px; width: 100%; text-align: center;">

                        <p class="mb-0">{{$rows['rows']['filterMessageText'] }}</p>
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



                    @if(isset($rows['rows']['currentUserRank']))
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3 userscard text-center float-start"
                                style="cursor: default; width:200px; height:100px">

                                <div class="mt-3 fw-bold">
                                    🎉 Congratulations <span class="text-success">{{ $rows['rows']['currentUserRank']['name'] }}</span><br>
                                    You are ranked <span class="text-success">#{{ $rows['rows']['currentUserRank']['rank'] }}</span>
                                    with
                                  
                                    @if($rows['rows']['metric_type'] === 'hours')
                                    <span class="text-danger">{{ $rows['rows']['currentUserRank']['total_hours'] }} hrs</span>
                                    @else
                                    <span class="text-danger">{{ $rows['rows']['currentUserRank']['points'] }} </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif









                    @php
                    function getProfileImage($user) {
                    return !empty($user['profile_image'])
                    ? config('setting.profile_url') . $user['profile_image']
                    : asset('images/empty.jpg');
                    }

                    @endphp


                    <div class="podium d-flex justify-content-center">

                        {{-- SECOND PLACE --}}
                        @if(isset($rows['rows']['top3'][1]))
                        @php $user = $rows['rows']['top3'][1]; @endphp

                        <div id="second-place"
                            class="podium-card second position-relative text-center"
                            data-toggle="modal"
                            data-target="#profile_details"
                            style="cursor: pointer;"
                            data-id="{{ $user['id'] ?? 'N/A' }}"
                            data-name="{{ $user['name'] ?? 'N/A' }}"

                            data-points="{{ $user['total_points'] ?? 0 }}"
                            data-hours="{{ $user['total_hours'] ?? 0 }}"
                            data-userid="{{ $user['id'] ?? '' }}"
                            data-level_name="{{ $user['level_name'] ?? 'N/A' }}"
                            data-level_icon="{{ $user['level_icon'] ?? '' }}"
                            data-img="{{ $user['profile_image']}}"
                            data-streak='@json($user["streaks"] ?? [])'
                            data-badge='@json($user["badges"] ?? [])'>

                            <img id="second-img" src="{{ getProfileImage($user) }}" class="profile-img" />
                            <h6 id="second-name">{{ $user['name'] }}</h6>
                            <span class="score" id="second-points">{{ $user['total_points'] ?? 0 }}</span> Points<br>

                            @php
                            $metricType = $rows['rows']['metric_type'] ?? 'points';
                            $leaderboardUsers = $rows['rows']['leaderboard']['leaderboard'] ?? [];
                            $userHours = null;
                            foreach ($leaderboardUsers as $lbUser) {
                            if ($lbUser['id'] == $user['id']) {
                            $userHours = $lbUser['total_hours'] ?? null;
                            break;
                            }
                            }
                            @endphp

                            @if($metricType === 'hours' && !is_null($userHours))
                            <span class="score" id="second-hours">{{ $userHours }} Hours</span>


                            @endif

                            <br><img src="/images/leaderboard/2nd.png" class="rank-badge" />
                        </div>
                        @endif

                        {{-- FIRST PLACE --}}
                        @if(isset($rows['rows']['top3'][0]))
                        @php $user = $rows['rows']['top3'][0];@endphp
                        <div id="first-place"
                            class="podium-card first position-relative text-center"
                            data-toggle="modal"
                            data-target="#profile_details"
                            style="cursor: pointer;"
                            data-id="{{ $user['id'] ?? 'N/A' }}"
                            data-name="{{ $user['name'] ?? 'N/A' }}"

                            data-points="{{ $user['total_points'] ?? 0 }}"
                            data-hours="{{ $user['total_hours'] ?? 0 }}"
                            data-userid="{{ $user['id'] ?? '' }}"
                            data-level_name="{{ $user['level_name'] ?? 'N/A' }}"
                            data-level_icon="{{ $user['level_icon'] ?? '' }}"
                            data-profile_image="{{ getProfileImage($user) }}"
                            data-streak='@json($user["streaks"] ?? [])'
                            data-badge='@json($user["badges"] ?? [])'>

                            <img src="/images/leaderboard/crown.png" class="crown" />
                            <img id="first-img" src="{{ getProfileImage($user) }}" class="profile-img" />
                            <h6 id="first-name">{{ $user['name'] }}</h6>
                            <span class="score" id="first-points">{{ $user['total_points'] ?? 0 }}</span> Points<br>

                            @php
                            $metricType = $rows['rows']['metric_type'] ?? 'points';
                            $leaderboardUsers = $rows['rows']['leaderboard']['leaderboard'] ?? [];
                            $userHours = null;
                            foreach ($leaderboardUsers as $lbUser) {
                            if ($lbUser['id'] == $user['id']) {
                            $userHours = $lbUser['total_hours'] ?? null;
                            break;
                            }
                            }
                            @endphp

                            @if($metricType === 'hours' && !is_null($userHours))
                            <span class="score" id="first-hours">{{ $userHours }} Hours</span>
                            @endif

                            <br><img src="/images/leaderboard/1st.png" class="rank-badge" />
                        </div>
                        @endif

                        {{-- THIRD PLACE --}}
                        @if(isset($rows['rows']['top3'][2]))
                        @php $user = $rows['rows']['top3'][2]; @endphp
                        <div id="third-place"
                            class="podium-card third position-relative text-center"
                            data-toggle="modal"
                            data-target="#profile_details"
                            style="cursor: pointer;"
                            data-id="{{ $user['id'] ?? 'N/A' }}"
                            data-name="{{ $user['name'] ?? 'N/A' }}"
                            data-points="{{ $user['total_points'] ?? 0 }}"
                            data-hours="{{ $user['total_hours'] ?? 0 }}"
                            data-userid="{{ $user['id'] ?? '' }}"
                            data-level_name="{{ $user['level_name'] ?? 'N/A' }}"
                            data-level_icon="{{ $user['level_icon'] ?? '' }}"
                            data-profile_image="{{ getProfileImage($user) }}"
                            data-streak='@json($user["streaks"] ?? [])'
                            data-badge='@json($user["badges"] ?? [])'>

                            <img id="third-img" src="{{ getProfileImage($user) }}" class="profile-img" />
                            <h6 id="third-name">{{ $user['name'] }}</h6>
                            <span class="score" id="third-points">{{ $user['total_points'] ?? 0 }}</span> Points<br>

                            @php
                            $metricType = $rows['rows']['metric_type'] ?? 'points';
                            $leaderboardUsers = $rows['rows']['leaderboard']['leaderboard'] ?? [];
                            $userHours = null;
                            foreach ($leaderboardUsers as $lbUser) {
                            if ($lbUser['id'] == $user['id']) {
                            $userHours = $lbUser['total_hours'] ?? null;
                            break;
                            }
                            }
                            @endphp


                            @if($metricType === 'hours' && !is_null($userHours))
                            <span class="score" id="third-hours">{{ $userHours }} Hours</span>
                            @endif

                            <br><img src="/images/leaderboard/3rd.png" class="rank-badge" />
                        </div>
                        @endif

                    </div>


                </div>

            </div>

            <div class="table-wrapper">
                <table class="leaderboard-table">
                    <thead>
                        <tr>
                            <th style="padding-left: 20px; width: 70px;">Rank</th>
                            <th style="padding-left: 10px; text-align: left;">Name</th>
                            <th style="padding-left: 320px; text-align:left;">Points</th>
                            @if($rows['rows']['metric_type'] === 'hours')
                            <th style="padding-left: 80px; text-align: right;">Hours</th>
                            @endif
                        </tr>
                    </thead>
                </table>

                @php
                $remainingUsers = array_slice($rows['rows']['leaderboard']['leaderboard'], 3);
                @endphp

                @if(count($remainingUsers) > 0)
                <div class="leaderboard-scroll {{ count($remainingUsers) > 3 ? 'scroll-enabled' : '' }}">
                    <table class="leaderboard-table">
                        <tbody id="rankTableBody">
                            @foreach($remainingUsers as $key => $value)
                            <tr class="leaderboard-row"
                                data-toggle="modal"
                                data-target="#profile_details"
                                style="cursor: pointer;"
                                data-id="{{ $value['id'] ?? 'N/A' }}"
                                data-name="{{ $value['name'] ?? 'N/A' }}"
                                data-points="{{ $value['total_points'] ?? 0 }}"
                                data-hours="{{ $value['total_hours'] ?? 0 }}"
                                data-img="{{ $value['profile_image'] ? config('setting.profile_url') . $value['profile_image'] : config('setting.profile_url') . 'images/empty.jpg' }}"
                                data-level_name="{{ $value['level_name'] ?? 'N/A' }}"
                                data-level_icon="{{ $value['level_icon'] ?? '' }}"
                                data-profile_image="{{ getProfileImage($user) }}"
                                data-streak='@json($value["streaks"] ?? [])'
                                data-badge='@json($value["badges"] ?? [])'>

                                <th style="padding-left: 20px; width: 70px;">{{ $key + 4 }}</th>
                                <th style="padding-left: 10px; text-align: left;">{{ $value['name'] }}</th>
                                <th style="padding-left: 200px; text-align: left;">
                                    {{ $rows['rows']['metric_type'] === 'hours' ? ($value['total_hours'] ?? 0) . ' Hrs' : ($value['total_points'] ?? 0)  }}
                                </th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center text-white" style="padding: 20px;">
                    No leaderboard data available
                </div>
                @endif

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

<div class="modal fade" id="profile_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 p-4">
            <div class="card-body position-relative">

                <!-- Close Button -->
                <button type="button" style="color: red; margin-top: -130px; font-size: 24px; padding: 20px; margin-right: -30px; background: transparent; border: none; outline: none; box-shadow: none;" id="filterclose" class="close" data-dismiss="modal" aria-hidden="true" onfocus="this.blur();">&times;</button>

                <!-- User Profile Content -->

                <div class="text-center" style="margin-top:-50px;border-radius:10px; background-color: #f2f2f2;">
                    <img id="modal-profile-img" src="config('setting.profile_url')images/empty.jpg" class=""
                        style="width: 100px; height: 100px;margin-top:-50px; object-fit: cover; border: 4px solid #fff;;border-radius:20px" />
                    <h1 class="mt-3 fw-semibold" id="modal-name"></h1>

                    <!-- Level Info -->
                    <div class="d-flex justify-content-center align-items-center gap-2 text-center mt-2" style="padding-bottom:10px">
                        <div>
                            <h4 class="fw-bold modal-level_name">{{ $currentUserRank['level_name'] ?? 'N/A' }}</h4>
                        </div>
                        <div id="modal-level_icon" style="margin-left: 10px;">
                            @if(!empty($currentUserRank['level_icon']))
                            <i class="{{ $currentUserRank['level_icon'] }}" style="font-size: 32px; color: orange;"></i>
                            @else
                            <i class="fas fa-star" style="color: yellow; font-size: 14px;"></i>
                            @endif
                        </div>
                    </div>



                </div>

                <!-- Info Cards -->
                <div class=" mt-4 g-2 px-2" style="border-radius:10px; background-color: #f2f2f2;">
                    <!-- Total Points -->
                    <!-- Stats Container -->

                    @php
                    // Check if 'hours' should be shown
                    $showHours = isset($rows['metric_type']) && $rows['metric_type'] === 'hours';

                    // Set column width based on how many items to show
                    $colWidth = $showHours ? 'col-4' : 'col-6';
                    @endphp

                    <div class="row justify-content-center text-center align-items-center g-3 mt-2">

                        <!-- Total Points -->
                        <div class="{{ $colWidth }}">
                            <div class="d-flex align-items-center justify-content-center">
                                <img src="/images/points_images.png" style="height: 100px; width: 100px;" class="me-2" />
                                <div class="text-start ps-3">
                                    <h5>Total Points</h5>
                                    <h2 class="fw-bold" id="modal-points">0</h2>
                                </div>
                            </div>
                        </div>

                        <!-- Total Hours (if applicable) -->
                        @if($showHours)
                        <div class="{{ $colWidth }}">
                            <div class="d-flex align-items-center justify-content-center">
                                <img src="/images/hours_images.png" style="height: 100px; width: 100px;" class="me-2" />
                                <div class="text-start ps-3">
                                    <h5>Total Hours</h5>
                                    <h2 class="fw-bold" id="modal-hours">0</h2>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Level -->
                        <div class="{{ $colWidth }}">
                            <div class="d-flex align-items-center justify-content-center">
                                <img src="/images/levels_images.png" style="height: 100px; width: 100px;padding-top:4px;" class="me-2" />
                                <div class="text-start ps-3">
                                    <h5>Level</h5>
                                    <h2 class="fw-bold modal-level_name" style="color: black;">
                                        {{ $currentUserRank['level_name'] ?? 'N/A' }}
                                    </h2>
                                </div>
                            </div>
                        </div>

                    </div>


                    <!-- Streaks -->

                    <div class="col-12 mb-3">
                        <div class="py-2 px-3" style="border-top: 3px solid #b9b6b6ff;">
                            <h2 class="text-center mb-2">🔥 Streaks</h2>

                            <div class="w-100 text-center">
                                <div id="streak-container"
                                    class="d-inline-flex gap-3"
                                    style="max-height: 120px; overflow-x: auto;">
                                    <!-- Filled dynamically by JS -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Badges -->
                    <div class="col-12 mb-3">
                        <div class="py-2 px-3" style="border-top: 3px solid #b9b6b6ff;">
                            <h2 class="text-center mb-2">🏅 Badges</h2>

                            <div class="w-100 text-center">
                                <div id="badge-container"
                                    class="d-inline-flex gap-3"
                                    style="max-height: 120px; overflow-x: auto;">

                                </div>
                            </div>
                        </div>
                    </div>


                </div>

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
                                        @foreach($rows['rows']['role'] as $values)
                                        <option value="{{ $values['role_id'] }}"
                                            {{ request()->input('role') == $values['role_id'] ? 'selected' : '' }}>
                                            {{ $values['role_name'] }}
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
                                        @foreach($rows['rows']['designation'] as $values)
                                        <option value="{{ $values['designation_id'] }}"
                                            {{ request()->input('designation') == $values['designation_id'] ? 'selected' : '' }}>
                                            {{ $values['designation_name'] }}
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
                                        @foreach($rows['rows']['elearning_courses'] as $data)
                                        <option value="{{ $data['course_id'] }}"
                                            {{ request()->input('course_catagory') == $data['course_id'] ? 'selected' : '' }}>
                                            {{ $data['course_name'] }}
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

                            <input type="hidden" id="metric_type" value="{{$metricType}}">
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
                const data = response.Data || response;
                updatePodium(data.top3);
                updateLeaderboardTable(data.rankList);
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
            const card = $(`#${positions[i]}-place`);


            if (user) {
                card.show();

                $('#' + positions[i] + '-id').text(user.id);
                $('#' + positions[i] + '-name').text(user.name);
                $('#' + positions[i] + '-points').text(user.total_metric);
                $('#' + positions[i] + '-level_name').text(user.level_name);
                $('#' + positions[i] + '-level_icon').text(user.level_icon);
                const imgPath = user.profile_image ? baseUrl + user.profile_image : baseUrl + 'images/empty.jpg';

                $('#' + positions[i] + '-img').attr('src', imgPath);


                card.attr({
                    'data-id': user.id,
                    'data-name': user.name,
                    'data-points': user.total_metric,
                    'data-img': imgPath,
                    'data-level_name': user.level_name || 'N/A',
                    'data-level_icon': user.level_icon || '',
                    'data-streak': JSON.stringify(user.streak || []),
                    'data-badge': JSON.stringify(user.badge || [])
                });

            } else {

                card.hide();

                $('#' + positions[i] + '-id').text('');
                $('#' + positions[i] + '-name').text('');
                $('#' + positions[i] + '-points').text('');
                $('#' + positions[i] + '-level_name').text('');
                $('#' + positions[i] + '-level_icon').text('');
                $('#' + positions[i] + '-img').attr('src', baseUrl + 'images/empty.jpg');
                card.removeAttr('data-name data-points data-img data-level_name data-level_icon data-streak data-badge');
            }
        }
    }


    function updateLeaderboardTable(users) {
        let tbody = $('#rankTableBody');
        let tableContainer = $('#leaderboardTableContainer'); // wrapper div for table
        tbody.empty();

        if (users && users.length > 0) {
            tableContainer.show(); // show table when data exists
            $.each(users, function(index, user) {
                const imgPath = baseUrl + (user.profile_image || 'images/empty.jpg');
                tbody.append(`
                <tr class="leaderboard-row"
                    data-id="${user.id}"    
                    data-name="${user.name}"
                    data-points="${user.total_points || 0}"
                    data-hours="${user.total_hours || 0}"
                    data-img="${imgPath}"
                    data-level_name="${user.level_name || 'N/A'}"
                    data-level_icon="${user.level_icon || ''}"
                    data-streak='${JSON.stringify(user.streak || [])}'
                    data-badge='${JSON.stringify(user.badge || [])}'
                    style="cursor: pointer;"    
                    data-toggle="modal"
                    data-target="#profile_details">

                    <th>${index + 4}</th>
                    <th>
                        <img src="${imgPath}" alt="profile" class="rounded-circle" width="40" height="40" style="margin-right:8px;">
                        ${user.name}
                    </th>
                    <th>
                        ${user.total_metric || 0} ${metricType === 'hours' ? 'Hrs' : 'Pts'}
                    </th>
                </tr>
            `);
            });
            $('#noDataMessage').hide(); // hide no-data message
        } else {
            tableContainer.hide(); // hide table
            $('#noDataMessage').show(); // show no-data text
        }
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

    const allDesignations = @json($rows['rows']['designation']);


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
        const rewardGrouped = @json($rows['rows']['leaderboard']['rewardsGrouped']);

        const leaderboardData = @json($rows['rows']['leaderboard']['leaderboard']);


        $(document).on('click', '.podium-card, .leaderboard-row', function() {
            const userId = $(this).attr('data-id');

            const name = $(this).attr('data-name') || 'N/A';
            const points = $(this).attr('data-points') || 0;
            const img = $(this).attr('data-img') || (baseUrl + 'images/empty.jpg');

            const level = $(this).attr('data-level_name') || 'N/A';
            const level_icon = $(this).attr('data-level_icon') || '';


            const userData = leaderboardData.find(u => u.id == userId);

            let streaks = [];
            let badges = [];

            if (userData) {
                streaks = userData.streaks || [];
                badges = userData.badges || [];
            }

            $('#modal-profile-img').attr('src', img);
            $('#modal-name').text(name);
            $('#modal-points').text(points);
            $('.modal-level_name').text(level);

            if (level_icon) {
                $('#modal-level_icon').html(`<i class="${level_icon}" style="font-size:32px; color:orange;"></i>`);
            } else {
                $('#modal-level_icon').html(`<i class="fas fa-star" style="color: yellow; font-size: 14px;"></i>`);
            }

            // Streaks
            $('#streak-container').empty();
            if (streaks.length > 0) {
                streaks.forEach(s => {
                    $('#streak-container').append(`
                <div class="text-center" style="min-width: 100px;">
                    <div style="font-size: 28px;">${s.icon ? `<i class="${s.icon} zoom-blink" style="color:gold;"></i>` : '🔥'}</div>
                    <div class="fw-bold small mt-1 pl-3">${s.reward_name || 'Streak'}</div>
                </div>
            `);
                });
            } else {
                $('#streak-container').append(`<div class="text-center">No streaks found</div>`);
            }

            // Badges
            $('#badge-container').empty();
            if (badges.length > 0) {
                badges.forEach(b => {
                    $('#badge-container').append(`
                <div class="text-center" style="min-width: 100px;">
                    <div style="font-size: 28px;">${b.icon ? `<i class="${b.icon} zoom-blink" style="color:#008080;"></i>` : '🏅'}</div>
                    <div class="fw-bold small mt-1 pl-3">${b.reward_name || 'Badge'}</div>
                </div>
            `);
                });
            } else {
                $('#badge-container').append(`<div class="text-center">No badges found</div>`);
            }

            $('#profile_details').modal('show');
        });




    });
</script>


<script>
    const rewardUserId = {
        {
            $rewardedUserId ?? 'null'
        }
    };
</script>


@endsection