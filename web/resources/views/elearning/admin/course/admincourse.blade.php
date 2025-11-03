@extends('layouts.elearningmain')

@section('content')
<style>
    /* main-container */


    .all_courses_main_header {
        width: fit-content;
        color: #680EDA;
        font-weight: 900;
        font-size: 1.5rem !important;
        margin-bottom: 1rem !important;
    }

    /* remove card bocy shadow */
    .noShadow .card-body {
        box-shadow: none !important;
    }

    /* filters mobile */
    .filters_header {
        background: #eee !important;
        color: #000 !important;
    }

    /* sort and filter header*/
    .all_courses_sort_header,
    .all_courses_filter_header {
        display: none !important;
    }

    /* sort and filter options */
    .form-control {
        background-color: #fdfdff !important;
        box-shadow: none !important;
        border: 1px solid #000 !important;
        border-radius: 0px !important;
    }

    .all_courses_sort_select {
        font-weight: 800;
        width: 20%;
        color: #000000 !important;
        border: 1px solid #000 !important;
        border-radius: 0px !important;
        margin-bottom: 1rem;
    }

    .all_courses_filter_container {
        font-weight: 800;
        width: 45%;
        margin-left: 2%;
        margin-bottom: 1rem;
        border-radius: 0px !important;
    }

    .all_courses_filter_select {
        font-weight: 800;
        width: 40%;
        color: #000000 !important;
        margin-right: 2%;
        border: 1px solid #000 !important;
        border-radius: 0px !important;
    }

    .all_courses_reset_btn {
        width: fit-content;
        text-align: left;
        color: #40c2b2 !important;
        border: 0px !important;
        padding: 0px 0px !important;
        background-color: transparent !important;
    }

    .all_courses_reset_btn:disabled {
        color: #1c1d1f !important;
    }

    /* search section */
    .all_courses_search_container {
        font-weight: 800;
        width: 25%;
        margin-left: auto;
        margin-bottom: 1rem;
        border-radius: 0px !important;
    }

    .all_courses_search_container button {
        color: #fff !important;
        background-color: #000 !important;
        border: 1px solid #000;
        border-left: 0px !important;
        width: 3rem;
        margin-top: -10px;
        height: 41px;
        font-size: 1.2rem;
    }

    .all_courses_search_container .form-control::placeholder {
        color: #000000 !important;
    }

    /* Course list section */
    .all_courses_courselist_container {
        margin-top: 1rem !important;
    }

    .all_courses_courselist {
        margin: 0px !important;
        margin-bottom: 2rem !important;
        border: 0px !important;
        box-shadow: none !important;
    }

    .all_courses_courselist .card-header {
        overflow: hidden !important;
        padding: 0px !important;
        height: 8rem !important;
    }

    .all_courses_courselist .card-body {
        padding: 5% !important;
    }

    .all_courses_courselist .card-title h5 {
        color: #000;
        font-size: 1.3rem;
        line-height: 2rem;
        text-transform: capitalize;
        white-space: nowrap;
        width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .course_image {
        width: 100%;
    }

    .course_total_progress {
        height: 0.25rem !important;
        box-shadow: none !important;
        margin-top: 50px;
    }

    /* paginnation sectiion */
    .all_courses_paginate_container {
        margin-top: 2rem;
    }

    .all_courses_paginate {
        margin-bottom: 0px !important;
    }

    .all_courses_pagination_page_number .page-link {
        color: #141ad8 !important;
        background-color: transparent !important;
        border: 0px solid #000 !important;
    }

    .all_courses_pagination_page_number .page-link.active {
        text-decoration: 2.2px underline #000;
    }

    .all_courses_pagination_nav .page-link {
        color: #000 !important;
        background-color: transparent !important;
        border: 1px solid #000 !important;
        border-radius: 50%;
    }

    .all_courses_pagination_page_number {
        display: flex;
        flex-direction: row;
    }

    #searchResultnone {
        font-size: 25px;
        color: #ff443a;
        font-weight: 600;
    }

    .allCoursePagination .page-item:first-child .page-link,
    .allCoursePagination .page-item:last-child .page-link {
        font-size: 2rem !important;
        line-height: 0.78em !important;
        font-weight: 600 !important;
        padding: .2rem .65rem .3rem .65rem !important;
    }

    .wishList-badge {
        position: absolute;
        top: 5px;
        right: 20px !important;
        width: 30px;
        height: 30px;
        font-size: 13px !important;
        color: red;
        background-color: transparent !important;
        border: 0px;
        border-radius: 5px !important;
        padding: 0px !important;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
    }

    @media (min-width:319.96px) {

        /* .all_courses_sort_select{
            width: 100%;
        } */
        .all_courses_filters_popper {
            margin-bottom: 1rem !important;
            font-size: 1rem;
            font-weight: 700;
            background-color: #fff;
            padding: 0.5% 3%;
            color: #40c2b2;
            border: 0px !important;
            border-radius: 10px;
            box-shadow: 0.1rem 0.1rem 0.2rem #6c757d;
        }

        .all_courses_filters_popper i {
            font-size: 0.75rem;
            vertical-align: middle;
            color: #40c2b2;
            font-weight: 700;
        }

        .all_courses_filter_block2 {
            display: none !important;
        }
    }

    @media (min-width:767.96px) {
        .all_courses_sort_header {
            display: inline-block !important;
            width: 20%;
            color: #1c1d1f !important;
            margin-bottom: 0.75rem;
            text-align: left;
        }

        .all_courses_filter_header {
            display: inline-block !important;
            width: 20%;
            color: #1c1d1f !important;
            margin-left: 2%;
            margin-bottom: 0.75rem;
            text-align: left;
        }

        .all_courses_filters_popper {
            display: none !important;
        }

        .all_courses_filter_block2 {
            display: flex !important;
        }
    }

    @media (min-width:1024.96px) {
        .main-content {
            padding-left: 220px !important;
        }

        .sidebar-mini .main-content {
            padding-left: 85px !important;
        }
    }

    @media (min-width:320px) {
        .filter_align {
            display: flex;
            font-size: 12px;
            gap: 7px;
            align-items: center;
        }



    }

    .course_paid {
        height: 30px !important;
        width: 25% !important;
        border-radius: 20px;
        position: absolute;
        padding: 6px 0px 0px 15px;
        color: #ffffff;
        align-items: center;
        margin-left: 2%;
        font-size: 16px;
        margin-bottom: 15px;
        text-transform: capitalize;
    }

    .blinking-warning {
        background-color: #ff0015;
        color: white;
        padding: 2px 6px;
        border-radius: 20px;
        font-size: 12px;
        /* animation: blinker 2s linear infinite; */
    }

    @keyframes blinker {
        50% {
            opacity: 0;
        }
    }

    .highlight-new-course {
        border: 3px solid #4CAF50;
        box-shadow: 0 0 12px #4CAF50;
        transition: all 0.3s ease-in-out;
    }

    .locked-course-card {
        pointer-events: none;
        opacity: 0.7;

    }

    .locked-overlay {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background: rgb(17 52 80 / 60%);
        z-index: 10;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        color: #fff;
        font-weight: bold;
        font-size: 16px;
        border-radius: 5px;
    }

    .lock-icon {
        font-size: 70px;
        margin-bottom: 8px;
        color: #000000ff;
    }

    .locked-text {
        font-weight: bold;
        font-size: 25px;
        color: #000000ff;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
<?php

use Carbon\Carbon; ?>

<div class="main-content">
    <section class="section">
        <div class="section-body mt-1">

            <div class="container-fluid all_courses_container">

                <div class="d-flex flex-row justify-content-between align-items-end">
                    <h2 class="all_courses_main_header">
                        All Courses
                        <div class="path">
                            <span>E-Learning</span>
                            <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                            <span>All Courses</span>
                        </div>
                    </h2>
                    <a class="text-uppercase all_courses_filters_popper filter_align" href="#" data-toggle="modal"
                        data-target="#filters">
                        filters
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </a>
                </div>

                <div class="d-flex flex-row justify-content-start">
                    <span class="all_courses_sort_header">
                        Sort by
                    </span>
                    <span class="all_courses_filter_header">
                        Filter by
                    </span>
                </div>

                <form class="d-flex flex-row flex-wrap justify-content-start all_courses_filter_block2"
                    action="{{ route('elearningAllCourses') }}" method="POST">
                    @csrf
                    @method('GET')
                    <select class="form-control all_courses_sort_select" name="all_courses_sort_select">
                        <option value="Recently Added" selected>Recently Added</option>
                        <option value="Recently Enrolled">Recently Enrolled</option>
                        <option value="A to Z">A to Z</option>
                        <option value="Z to A">Z to A</option>
                    </select>
                    <div class="d-flex flex-row flex-wrap justify-content-evenly all_courses_filter_container">
                        <select class="form-control all_courses_filter_select" name="all_courses_filter_select">
                            <option value="false" selected>Tags</option>
                            @foreach($availableTags as $availableTag)
                            <option value="{{$availableTag}}">{{$availableTag}}</option>
                            @endforeach
                        </select>
                        <select class="form-control all_courses_filter_select" name="all_courses_filter_select">
                            <option value="false" selected>Progress</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                            <option value="Not Enrolled">Not Enrolled</option>
                        </select>
                        <button class="all_courses_reset_btn" type="reset" x>
                            <span>Reset</span>
                        </button>
                    </div>
                    <div class="all_courses_search_container">
                        <div class="d-flex flex-row justify-content-center align-items-center">
                            <input type="search" class="form-control" id="courseSearch" name="courseSearch"
                                placeholder="Search">
                            <button type="submit" id="courseSearchButton">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </form>

            </div>

            <div class="container-fluid all_courses_courselist_container">
                <div id="searchResultnone" style="display: none;">
                    <p>
                        Sorry, we couldn't find the matches
                    </p>
                </div>


                <div class="row">

                    @foreach($availableCourses as $key => $value)
                    @php
                    $Courseslocked = DB::table('course_catagory as uc')
                    ->select('*')
                    ->where('uc.course_locked','=' , 1)
                    ->where('uc.catagory_id','=' , $value->course_category)
                    ->first();

                    $userPoints = DB::table('users')
                    ->where('id', $user_id)
                    ->where('active_flag', 0)
                    ->value('total_cptpoints');

                    $showExpiryBadge = false;

                    // Certificate Expiry Logic

                    if ($value->certificate_expiry == '1' && !empty($value->course_expiry_period)) {
                    $expiryDate = \Carbon\Carbon::parse($value->course_expiry_period);
                    $today = \Carbon\Carbon::today();
                    $oneMonthBefore = $expiryDate->copy()->subMonth();

                    if ($today->gte($oneMonthBefore)) {
                    $showExpiryBadge = true;
                    }
                    }

                    // Lock logic
                    $isLocked = false;
                    $canUnlock = true;
                    if ($Courseslocked && $Courseslocked->points_to_unlock > 0 && $Courseslocked->course_locked == 1) {
                    $isLocked = true;
                    $canUnlock = $userPoints >= $Courseslocked->points_to_unlock;
                    }
                    @endphp

                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3" id="course_{{$value->course_id}}" @if($value->
                        expired_course_id) data-expired-course-id="{{ $value->expired_course_id }}" @endif>

                        <div
                            class="card noShadow all_courses_courselist position-relative {{ $isLocked && !$canUnlock ? 'locked-course-card' : '' }}">
                            @if($isLocked && !$canUnlock)
                            <div class="locked-overlay">
                                <i class="fa fa-lock lock-icon"></i>
                                <div class="locked-text">
                                    <br>
                                    {{ $Courseslocked->points_to_unlock }} Pts Needed
                                </div>
                            </div>
                            @endif


                            @php

                            $expiryMessage = null;

                            // check user_course_relation for enrolled status
                            $isEnrolled = DB::table('user_course_relation')
                            ->where('course_id', $value->course_id)

                            ->where('course_status', 'Enrolled')
                            ->exists();

                            if ($isEnrolled && !empty($value->expiry_type) && !empty($value->expiry_input)) {
                            if ($value->expiry_type === 'month') {
                            // expiry date = today + expiry_input months
                            $expiryDate = Carbon::now()->addMonths($value->expiry_input);

                            // days left
                            $daysLeft = Carbon::now()->diffInDays($expiryDate, false);

                            // show warning only if within 30 days
                            if ($daysLeft <= 30 && $daysLeft>= 0) {
                                $expiryMessage = "⚠️Your course will expire soon ";
                                }
                                }
                                }
                                @endphp
                                <!-- <div class="card-header">
                                    @php $isWishlisted = in_array($value->course_id, $wishlistedCourseIds); @endphp
                                    <span class="btn btn-outline-danger wishList-badge"
                                        title="{{ $isWishlisted ? 'Added to Wishlist' : 'Add to Wishlist ❤️' }}"
                                        id="wish_{{$value->course_id}}">
                                        <i class="{{ $isWishlisted ? 'fa fa-heart' : 'fa fa-heart-o' }}" aria-hidden="true"
                                            id="wishHeart_{{$value->course_id}}"></i>
                                    </span>

                                    @php $id = Crypt::encrypt($value->course_id);
                                    @endphp
                                    <a href="{{ route('elearningCourse', $id) }}">
                                        @php
                                        $imageUrl = config('setting.base_url') . 'uploads/course/126/' .
                                        $value->course_banner;
                                        @endphp
                                        @if(file_exists(public_path('uploads/course/126/' . $value->course_banner)))
                                        <img src="{{ $imageUrl }}" alt="Course Image" class="course_image" style="width:250px">
                                        @else
                                        <img src="{{ asset('assets/images/Talentra.jpg') }}" alt="Fallback Image"
                                            class="course_image">
                                        @endif
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="card-title" title="{{ $value->course_name }}">

                                        <h5>{{ $value->course_name }}</h5>
                                        <h5>
                                            @if($showExpiryBadge)
                                            <a href="javascript:void(0);"
                                                onclick="highlightCopiedCourse({{ $value->course_id }})">

                                                <span class="blinking-warning">
                                                    {{ \Carbon\Carbon::parse($value->course_expiry_period)->isPast() ? 'Certificate Expired' : 'Certificate Expiring Soon. Do the Re-Certification' }}
                                                </span>
                                            </a>
                                            @endif
                                            @if($expiryMessage)
                                            <a href="javascript:void(0);"
                                                onclick="highlightCopiedCourse({{ $value->course_id }})">
                                                <div style="
                                               background-color: #f8d7da;   /* light red */
                                               color: #721c24;             /* dark red text */
                                               border-radius: 8px;
                                               font-size:15px;
                                               padding-right:10px;
                                               margin: 20px auto;
                                               width: fit-content;
                                               box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                                            ">

                                                    <span>{!! $expiryMessage !!}</span>
                                                </div>
                                                @endif





                    </div>
                </div>
            </section>







            </form>
        </div>

    </div>

</div>
</div>
<div class="modal fade" id="addModalquiz1">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="" id="show_class" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="modal-header mh">
                    <h4 class="modal-title">Show Class</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" style="background-color: #f8fffb !important;">
                    <input type="hidden" class="form-control" id="class_idshow" name="class_id">

                    <div class="row">


                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Class Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default"  style="background-color: #e9ecef !important;" id="class_nameshow"
                                    name="class_nameshow">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Class Description:<span class="error-star" style="color:red;">*</span></label>
                                <textarea class="form-control default"  style="background-color: #e9ecef !important;" id="class_descriptionshow"
                                    name="class_descriptionshow"></textarea>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Class Resource:<span class="error-star" style="color:red;">*</span></label>
                                <iframe id="resource_nameshow" class="img-fluidshow" alt="Banner Image" title=""
                                    width="300" height="150" style="width:100% !important;"></iframe>


                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Class Duration:<span class="error-star" style="color:red;">*</span></label>
                                <input type="number" min="1" max="200" class="form-control default"
                                    id="class_durationshow"  style="background-color: #e9ecef !important;" name="class_durationshow">
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Class Quiz:<span class="error-star" style="color:red;">*</span></label>
                                <input type="test" min="1"  style="background-color: #e9ecef !important;" max="200" class="form-control default" id="class_quizshow"
                                    name="class_quizshow">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Quiz Name:<span class="error-star" style="color:red;">*</span></label>
                                <select class="form-control" name="quiz_id" id="quiz_idshow">
                                    <option value="">Select Quiz Name</option>
                                    @foreach($rows1['quiz_dropdown'] as $key => $row)

                                    <option value="{{ $row->quiz_id }}">{{ $row->quiz_name }}</option>
                                    @endforeach
                                </select>





                            </div>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </div>

            </form>
        </div>




    </div>

</div>



                                    <script>
                                        function highlightCopiedCourse(originalCourseId) {
                                            const matchingCard = document.querySelector(
                                                `[data-expired-course-id='${originalCourseId}']`);
                                            if (matchingCard) {
                                                matchingCard.scrollIntoView({
                                                    behavior: 'smooth',
                                                    block: 'center'
                                                });
                                                matchingCard.classList.add('highlight-new-course');
                                                setTimeout(() => {
                                                    matchingCard.classList.remove('highlight-new-course');
                                                }, 2000);
                                            } else {
                                                Swal.fire({
                                                    title: "Please Contact your supervisor",
                                                    text: "The new or copied course is not yet created.",
                                                    icon: "info"
                                                });
                                            }
                                        }
                                    </script>

                                    <div class="card-text" style="margin-bottom:10px;">
                                        <h6>
                                            <span style="color:#000;">{{ $value->course_instructor }}</span>
                                            @if ($value->course_pay == 'paid')
                                            <div style="display:flex; justify-content:end; align-items:right;margin-top:-30px;">

                                                <span class="course_paid" style="background-color: #1d33d3; border-radius:4px; margin:10px;">
                                                    {{ $value->course_pay }}
                                                </span>
                                            </div>

                                            @elseif ($value->course_pay == 'free')
                                            <div style="display:flex; justify-content:end; align-items:right;margin-top:-30px;">

                                                <span class="course_paid" style="background-color:#0ecf26; border-radius:4px; margin:10px;">
                                                    {{ $value->course_pay }}
                                                </span>
                                            </div>

                                            @endif
                                        </h6>
                                    </div>

                                    <div class="progress course_total_progress">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: {{ isset($courseProgress[$value->course_id]) ? $courseProgress[$value->course_id]->course_progress : '0' }}%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span class="text-uppercase" style="color:black">
                                        {{ isset($courseProgress[$value->course_id]) ? $courseProgress[$value->course_id]->course_progress : '0' }}%
                                        completed
                                    </span>
                                </div> -->
                                <div class="card"
                                    style="border: 2px solid #dcdcdc;border-radius: 14px;background: #fff;box-shadow: 0 3px 8px rgba(0,0,0,0.08);padding: 15px;transition: all 0.3s ease-in-out;
                                    text-align: center;width: 270px; margin: 15px auto; overflow: hidden;position: relative;min-height: 380px; /* consistent height */"
                                    onmouseover="this.style.boxShadow='0 6px 14px rgba(0,0,0,0.15)'; this.style.borderColor='#6c63ff'; this.style.transform='translateY(-5px)';"
                                    onmouseout="this.style.boxShadow='0 3px 8px rgba(0,0,0,0.08)'; this.style.borderColor='#dcdcdc'; this.style.transform='translateY(0)';">

                                    {{-- ❤️ Wishlist Icon --}}
                                    @php $isWishlisted = in_array($value->course_id, $wishlistedCourseIds); @endphp
                                    <span class="btn btn-outline-danger wishList-badge"
                                        title="{{ $isWishlisted ? 'Added to Wishlist' : 'Add to Wishlist ❤️' }}"
                                        id="wish_{{$value->course_id}}"
                                        style="position: absolute;top: 12px;right: 12px;background: #fff;border-radius: 50%;padding: 6px;
                                              box-shadow: 0 2px 5px rgba(0,0,0,0.1); z-index: 5;">
                                        <i class="{{ $isWishlisted ? 'fa fa-heart' : 'fa fa-heart-o' }}"
                                            aria-hidden="true"
                                            id="wishHeart_{{$value->course_id}}"
                                            style="color: {{ $isWishlisted ? '#ff4b5c' : '#999' }}; font-size:18px;">
                                        </i>
                                    </span>

                                    {{-- 📘 Course Image --}}
                                    @php
                                    $id = Crypt::encrypt($value->course_id);
                                    $imageUrl = config('setting.base_url') . 'uploads/course/126/' . $value->course_banner;
                                    @endphp
                                    <a href="{{ route('elearningCourse', $id) }}">
                                        @if(file_exists(public_path('uploads/course/126/' . $value->course_banner)))
                                        <img src="{{ $imageUrl }}" alt="Course Image" class="course_image"
                                            style="width:100%;height:150px;object-fit:cover;border-radius:10px;margin-bottom:10px;">
                                        @else
                                        <img src="{{ asset('assets/images/Talentra.jpg') }}" alt="Fallback Image"
                                            class="course_image"
                                            style="width:100%;height:150px;object-fit:cover;border-radius:10px;margin-bottom:10px;">
                                        @endif
                                    </a>

                                    {{-- 🧾 Card Body --}}
                                    <div class="card-body" style="padding: 10px 0;">
                                        <div class="card-title" title="{{ $value->course_name }}">
                                            <h5 style="color:#1e2a78; font-weight:600; font-size:16px; margin-bottom:8px;">
                                                {{ $value->course_name }}
                                            </h5>

                                            {{-- 🔔 Expiry Section with Fixed Height --}}
                                            <div style=" min-height: 40px; display: flex; justify-content: center;align-items: center;margin-bottom: 8px">
                                                @if($showExpiryBadge)
                                                <a href="javascript:void(0);" onclick="highlightCopiedCourse({{ $value->course_id }})">
                                                    <div style="background-color: #fff5e6; color: #b35c00; border-radius: 6px;
                                                         font-size: 13px;padding:4px 8px;display:inline-block;box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                                        ⚠ {{ \Carbon\Carbon::parse($value->course_expiry_period)->isPast() ? 'Certificate Expired' : 'Your Course Will Expire Soon' }}
                                                    </div>
                                                </a>
                                                @elseif($expiryMessage)
                                                <a href="javascript:void(0);" onclick="highlightCopiedCourse({{ $value->course_id }})">
                                                    <div style="background-color: #f8d7da; color: #721c24;border-radius: 8px;font-size:13px;padding:6px 12px;
                                                           margin-top:-30px;box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                                        {!! $expiryMessage !!}
                                                    </div>
                                                </a>
                                                @else
                                                {{-- Empty space to maintain height --}}
                                                <div style="height: 20px; visibility: hidden;">placeholder</div>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- 👨‍🏫 Instructor + Paid/Free --}}
                                        <div class="card-text" style="margin-bottom:10px;">
                                            <h6 style="font-size:13px; color:#333;">
                                                <span>{{ $value->course_instructor }}</span>
                                                <span style="float:right;background-color: {{ $value->course_pay == 'paid' ? '#1d33d3' : '#0ecf26' }};
                                                   color:#fff;border-radius:4px;padding:2px 8px;margin-top:-20px;font-size:20px;text-transform:capitalize;box-shadow:0 2px 4px rgba(0,0,0,0.1);">
                                                    {{ $value->course_pay }}
                                                </span>
                                            </h6>
                                        </div>

                                        {{-- 📊 Progress Bar --}}
                                        <div class="progress course_total_progress" style=" height:10px; border-radius:5px; overflow:hidden;
                                             background-color:#eaeaea;margin-top:10px;">
                                            <div class="progress-bar" role="progressbar"
                                                style="width: {{ isset($courseProgress[$value->course_id]) ? $courseProgress[$value->course_id]->course_progress : '0' }}%;
                                                background: linear-gradient(90deg, #5cb85c, #9be15d);transition: width 0.6s ease;">
                                            </div>
                                        </div>


                        <div class="col-md-3">
                            <div class="form-group" onclick="course_exam()">

                                <label>Course Exam:<span class="error-star" style="color:red;">*</span></label><br>
                                <input type="radio" class="btn-check course_exam" name="course_exam" value="1"
                                    id="course_examyes" autocomplete="off">
                                <label class="btn btn-outline-primary" for="course_examyes">Yes</label>

                                <input type="radio" class="btn-check course_exam" name="course_exam" value="2"
                                    id="course_examno" autocomplete="off">
                                <label class="btn btn-outline-primary" for="course_examno">No</label>


                            </div>
                        </div>

                        <div class="row mt-3" id="certificateFields" style="display: none;">
                            <div class="col-md-3.5" style="margin-left:20px">
                                <div class="form-group">
                                    <label> Certificate Template:<span class="error-star"
                                            style="color:red;">*</span></label>
                                    <select class="form-control" name="cetificate_template" id="cetificate_template">
                                        <option value="">---Select Certificate Template---</option>
                                        @foreach($rows1['certificate_templates'] as $row)
                                        <option value="{{ $row->certificate_templates_id }}">{{ $row->template_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Course Expiry:<span class="error-star"
                                            style="color:red;">*</span></label><br>
                                    <input type="radio" class="btn-check certificate_expiry" name="certificate_expiry"
                                        value="1" id="certificate_expiryyes" autocomplete="off">
                                    <label class="btn btn-outline-primary" for="certificate_expiryyes">Yes</label>

                                    <input type="radio" class="btn-check certificate_expiry" name="certificate_expiry"
                                        value="2" id="certificate_expiryno" autocomplete="off">
                                    <label class="btn btn-outline-primary" for="certificate_expiryno">No</label>
                                </div>
                            </div>

                            <div class="col-md-3" id="expiryDateField" style="display: none;">
                                <div class="form-group">
                                    <!-- <label>Expiry Date:<span class="error-star" style="color:red;">*</span></label>
                                    <input type='date' class="form-control default hasDatepicker"
                                        id='course_expiry_period' name="course_expiry_period" placeholder="dd-mm-yy"
                                        autocomplete="off"> -->
                                    <div class="form-group ">
                                        <label>Expiry Type:<span class="error-star" style="color:red;">*</span></label><br>
                                        <div class="d-flex align-items-center gap-3">

                                            <!-- Month radio -->
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="expiry_type" id="expiry_month" value="month">
                                                <label class="btn btn-outline-primary" for="expiry_month" style="color:black">Month</label>
                                            </div>

                                            <!-- Year radio -->
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="expiry_type" id="expiry_year" value="week">
                                                <label class="btn btn-outline-primary" for="expiry_year" style="color:black">Week</label>
                                            </div>

                                            <!-- Dynamic input box -->
                                            <div id="expiry_input" style="display:none;">
                                                <input type="number" class="form-control" name="expiry_input" placeholder="Period" min="1" style="width:100px;">
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>



                        </div>
                    </div>


                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Introduction:<span class="error-star" style="color:red;">*</span></label>
                                <input type="file" class="form-control default" id="course_introduction"
                                    name="course_introduction" required>
                                <span style="color:red !important"><strong>Following files could be uploaded as
                                        mp4,mp3,png,jpg</strong></span>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Banner:<span class="error-star" style="color:red;">*</span></label>
                                <input type="file" class="form-control default" id="course_banner" name="course_banner"
                                    accept="image/*" autocomplete="off" required>
                                <span style="color:red !important"><strong>Following files could be uploaded as
                                        jpeg,png,jpg</strong></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Summary for chatbot:<span class="error-star"
                                        style="color:red;">*</span></label>
                                <input type="file" class="form-control default" id="course_summary"
                                    name="course_summary" required>
                                <span style="color:red !important"><strong>Following files could be uploaded as
                                        mp3,pdf,txt</strong></span>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Type:<span class="error-star" style="color:red;">*</span></label>
                                <select class="form-control" name="course_pay" id="course_pay">
                                    <option value="">---Select Course Type---</option>
                                    <option value="paid">Paid Course</option>
                                    <option value="free">Free Course</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6" id="paid" style="display:none;">
                            <div class="form-group">
                                <label>Course Price:<span class="error-star" style="color:red;">*</span></label>
                                <input type="number" class="form-control default" id="course_price"
                                    placeholder="Enter the Money(UGX)" name="course_price" autocomplete="off">
                            </div>
                        </div>



                    </div>

                    <div class="col-md-12 form-group"
                        style="display:flex;justify-content: space-evenly;align-items: center;"
                        onclick="no_period()"><label>This Course has Start and End Period<span class="error-star"
                                style="color:red;">*</span></label>
                        <div class="form-group">
                            <input type="radio" class="btn-check answer_show_on course_noperiod"
                                name="course_noperiod" value="1" id="course_noperiodyes" autocomplete="off">
                            <label class="btn btn-outline-primary answer_show_on1"
                                for="course_noperiodyes">Yes</label>

                            <input type="radio" class="btn-check answer_show_off course_noperiod"
                                name="course_noperiod" value="2" id="course_noperiodno" autocomplete="off" checked>
                            <label class="btn btn-outline-primary answer_show_off1"
                                for="course_noperiodno">No</label>

                        </div>



                    </div>






                    <div class="row course_period_container" style="display: none;">
                        <div class="col-md-3"><label class="course_period">Course Period:<span class="error-star"
                                    style="color:red;">*</span></label></div>

                        <div class="col-md-4">

                            <div class="form-group">
                                <label>Start Date:<span class="error-star" style="color:red;">*</span></label>
                                <input type='text' class="form-control default startdate" id='course_start_period'
                                    readonly name="course_start_period" title="Course Start Date" placeholder="dd-mm-yy"
                                    autocomplete="off">
                            </div>

                        </div>

                        <div class="col-md-4">


                            <div class="form-group">
                                <label>End Date:<span class="error-star" style="color:red;">*</span></label>
                                <input type='text' class="form-control default enddate" id='course_end_period' readonly
                                    name="course_end_period" title="Course End Date" placeholder="dd-mm-yy"
                                    onchange="autodateupdate(this)" onclick="end_date();" autocomplete="off">
                            </div>
                        </div>

                    </div>






                    <div class="col-md-12 examname" style="display:none !important;">
                        <div class="row">
                            <div class="col-md-3 form-group"><label class="course_exam">Exam Details:<span
                                        class="error-star" style="color:red;">*</span></label></div>

                            <div class="col-md-5">

                                <div class="form-group">
                                    <label class="control-label required">Exam Name:<span class="error-star"
                                            style="color:red;">*</span></label>
                                    <select class="form-control" name="exam_name" id="exam_name">
                                        <option value="">Select Exam Name</option>
                                        @foreach($rows1['exam_list'] as $key => $row)
                                        <option value="{{ $row->id }}">{{ $row->exam_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">

                                <div class="form-group">
                                    <label>Exam Date:<span class="error-star" style="color:red;">*</span></label>
                                    <input type='text' class="form-control default exam_date" id="exam_date"
                                        name="exam_date" title="Course Exam Date" placeholder="dd-mm-yy"
                                        autocomplete="off">
                                </div>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Pass Percentage:<span class="error-star" style="color:red;">*</span></label>
                                <div style="display:flex;align-items: baseline;">
                                    <input type="number" class="form-control default" id="pass_percentage"
                                        name="pass_percentage" autocomplete="off"><span class="col-md-6"
                                        style="color:red;"><strong>(in percentage only)</strong></span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Instructor:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="course_instructor"
                                    name="course_instructor" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Course Tags:<span class="error-star" style="color:red;">*</span></label>
                                <div class="wordquestion">

                                    <table class="_table">

                                        <tbody id="table_body">
                                            <tr>

                                                <td>
                                                    <input type="text" class="form-control default" id="course_tags"
                                                        name="course_tags[]" autocomplete="off">
                                                </td>
                                                <td>
                                                    <div class="action_container">
                                                        <button class="danger" onclick="remove_tr(this)">
                                                            <i class="fa fa-close"></i>
                                                        </button>
                                                    </div>
                                                    <div style="margin-top:-10px" class="action_container" width="50px">
                                                        <button class="success" type="button"
                                                            onclick="create_tr('table_body')">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>

                                                </td>


                                            </tr>

                                        </tbody>


                                    </table>



                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Skill Required:<span class="error-star" style="color:red;">*</span></label>
                                <div class="wordquestion">

                                    <table class="_table">

                                        <tbody id="table_body1">
                                            <tr>

                                                <td>
                                                    <input type="text" class="form-control default"
                                                        id="course_skills_required" name="course_skills_required[]"
                                                        autocomplete="off">
                                                </td>
                                                <td>
                                                    <div class="action_container">
                                                        <button class="danger" onclick="remove_tr(this)">
                                                            <i class="fa fa-close"></i>
                                                        </button>
                                                    </div>
                                                    <div style="margin-top:-10px" class="action_container" width="50px">
                                                        <button class="success" type="button"
                                                            onclick="create_tr1('table_body1')">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>


                                                </td>


                                            </tr>

                                        </tbody>


                                    </table>


                                </div>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Gain Skill:<span class="error-star" style="color:red;">*</span></label>
                                <div class="wordquestion">

                                    <table class="_table">

                                        <tbody id="table_body3">
                                            <tr>

                                                <td>
                                                    <input type="text" class="form-control default"
                                                        id="course_gain_skills" name="course_gain_skills[]"
                                                        autocomplete="off">
                                                </td>
                                                <td>
                                                    <div class="action_container">
                                                        <button class="danger" onclick="remove_tr(this)">
                                                            <i class="fa fa-close"></i>
                                                        </button>
                                                    </div>
                                                    <div style="margin-top:-10px" class="action_container" width="50px">
                                                        <button class="success" type="button"
                                                            onclick="create_tr3('table_body3')">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>

                                                </td>


                                            </tr>

                                        </tbody>


                                    </table>



                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>CPD Points: <span class="error-star" style="color:red;">*</span></label>
                                <input type="number" class="form-control default" id="course_cpt_points"
                                    name="course_cpt_points" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Classes:<span class="error-star" style="color:red;">*</span></label>

                                <br>
                                <select style="width:100%" class="js-select2" name="course_classes[]" id="course_classes"
                                    multiple="multiple" style="width:220px !important;">


                                    @foreach($rows['elearning_classes'] as $data)
                                    <option value="{{$data->class_id}}" data-badge="">{{$data->class_name}}</option>
                                    @endforeach

                                </select>

                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <a class="btn btn-success btn-space savebutton" type="submit" onclick="gencre1(1)"
                                id="savebutton">Submit </a>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" onclick="resetSelect2()"
                                value="Cancel">
                        </div>
                    </div>
                </form>
            </div>

            <!-- end -->
            <!-- Mcq -->




            <!-- end -->
        </div>
    </div>
</div>


<style>
    .select2-container {
        /* min-width: 268px !important; */
    }

    .select2-container--default .select2-selection--multiple .select2-selection__rendered li {
        list-style: none;
        color: #000 !important;
    }

    .select2-container--default .select2-search--inline .select2-search__field {
        width: 300px !important;
    }

    .select2-results__option {
        padding-right: 20px;
        vertical-align: middle;
    }

    .select2-results__option:before {
        content: "";
        display: inline-block;
        position: relative;
        height: 25px;
        width: 20px;
        border: 2px solid #e9e9e9;
        border-radius: 4px;
        background-color: #fff;
        margin-right: 20px;
        vertical-align: middle;
    }

    .select2-results__option[aria-selected=true]:before {
        font-family: fontAwesome;
        content: "\f00c";
        color: #fff;
        background-color: #f77750;
        border: 0;
        display: inline-block;
        padding-left: 3px;
    }

    .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #fff;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #78f1f1;
        color: #272727;
        font-weight: bold;
    }

    .select2-results__option[aria-selected] {
        cursor: pointer;
        color: #060606 !important;
        font-weight: bold;
    }

    .select2-container--default .select2-selection--multiple {
        margin-bottom: 10px;
    }

    .select2-container--default.select2-container--open.select2-container--below .select2-selection--multiple {
        border-radius: 4px;
    }

    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: #f77750;
        border-width: 2px;
    }

    .select2-container--default .select2-selection--multiple {
        border-width: 2px;
    }

    .select2-container--open .select2-dropdown--below {

        border-radius: 6px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);

    }

    .select2-selection .select2-selection--multiple:after {
        content: 'hhghgh';
    }

    /* select with icons badges single*/
    .select-icon .select2-selection__placeholder .badge {
        display: none;
    }

    .select-icon .placeholder {
        /* 	display: none; */
    }

    .select-icon .select2-results__option:before,
    .select-icon .select2-results__option[aria-selected=true]:before {
        display: none !important;
        /* content: "" !important; */
    }

    .select-icon .select2-search--dropdown {
        display: none;
    }

    .course_period {
        font-size: 18px;

        margin-top: 30px;
        font-weight: bold;

    }

    tr:first-child .danger {
        display: none;
    }

    .container {
        max-width: 900px;
        width: 100%;
        background-color: #fff;
        margin: auto;
        padding: 15px;
        box-shadow: 0 2px 20px #0001, 0 1px 6px #0001;
        border-radius: 5px;
        overflow-x: auto;
    }

    .action_container1 {
        float: right;
        position: relative;
        left: 60px;
        top: 40px;
        z-index: 999;
    }

    .action_container2 {
        float: right;
        position: relative;
        left: 60px;
        top: 40px;
        z-index: 999;
    }

    div#align1_length {
        position: relative;
        top: 15px;
    }

    div#align1_filter {
        float: right;
    }

    div#align0_length {
        position: relative;
        top: 35px;
    }

    div#align0_filter {
        float: right;
    }

    .action_container3 {
        float: right;
        position: relative;
        left: 60px;
        top: 40px;
        z-index: 999;
    }

    ._table {
        width: 100%;
        border-collapse: collapse;
    }

    ._table :is(th, td) {}

    /* form field design start */
    .form_control {
        border: 1px solid #0002;
        background-color: transparent;
        outline: none;
        padding: 8px 12px;
        font-family: 1.2rem;
        width: 100%;
        color: #333;
        font-family: Arial, Helvetica, sans-serif;
        transition: 0.3s ease-in-out;
    }

    .form_control::placeholder {
        color: inherit;
        opacity: 0.5;
    }

    .form_control:is(:focus, :hover) {
        box-shadow: inset 0 1px 6px #0002;
    }

    /* form field design end */


    .success {
        background-color: #24b96f !important;
    }

    .warning {
        background-color: #ebba33 !important;
    }

    .primary {
        background-color: #259dff !important;
    }

    .secondery {
        background-color: #00bcd4 !important;
    }

    .danger {
        background-color: #ff5722 !important;
    }



    .action_container>* {
        border: none;
        outline: none;
        color: #fff;
        text-decoration: none;
        display: inline-block;
        padding: 8px 14px;
        cursor: pointer;
        transition: 0.3s ease-in-out;
        border-radius: 50px;
    }

    .action_container1>* {
        border: none;
        outline: none;
        color: #fff;
        text-decoration: none;
        display: inline-block;
        padding: 8px 14px;
        cursor: pointer;
        transition: 0.3s ease-in-out;
    }

    .action_container2>* {
        border: none;
        outline: none;
        color: #fff;
        text-decoration: none;
        display: inline-block;
        padding: 8px 14px;
        cursor: pointer;
        transition: 0.3s ease-in-out;
    }

    .action_container3>* {
        border: none;
        outline: none;
        color: #fff;
        text-decoration: none;
        display: inline-block;
        padding: 8px 14px;
        cursor: pointer;
        transition: 0.3s ease-in-out;
    }

    .ui-datepicker-trigger {
        position: absolute;
        right: 0px;
        top: 53%;
        left: 80%;
        transform: translateY(-50%);
        height: 25%;
    }
</style>

                                <script>
                                    function highlightCopiedCourse(originalCourseId) {
                                        const matchingCard = document.querySelector(`[data-expired-course-id='${originalCourseId}']`);
                                        if (matchingCard) {
                                            matchingCard.scrollIntoView({
                                                behavior: 'smooth',
                                                block: 'center'
                                            });
                                            matchingCard.classList.add('highlight-new-course');
                                            setTimeout(() => {
                                                matchingCard.classList.remove('highlight-new-course');
                                            }, 2000);
                                        } else {
                                            Swal.fire({
                                                title: "Please Contact your supervisor",
                                                text: "The new or copied course is not yet created.",
                                                icon: "info"
                                            });
                                        }
                                    }
                                </script>

                                <style>
                                    .highlight-new-course {
                                        border: 3px solid #007bff !important;
                                        box-shadow: 0 0 15px rgba(0, 123, 255, 0.6) !important;
                                        transition: all 0.3s ease;
                                    }
                                </style>



                        </div>
                    </div>
                    @endforeach

                </div>
                <div class="d-flex flex-row justify-content-center allCoursePagination">
                    {!! $availableCourses->links() !!}
                </div>
                <!-- <div>
                    <p class="text-sm text-gray-700 leading-5">
                        Showing
                        <span class="font-medium">1</span>
                        to
                        <span class="font-medium">2</span>
                        of
                        <span class="font-medium">5</span>
                        results
                    </p>
                </div> -->
            </div>
            <input type="hidden" class="courseSearch" id="searchMessage" value="{{$search}}">
            <input type="hidden" class="courseSort" id="sortMessage" value="{{$sort}}">
            <input type="hidden" class="courseFilter" id="filterTagMessage" value="{{$tagFilter}}">
            <input type="hidden" class="courseFilter" id="filterProgressMessage" value="{{$progressFilter}}">
            <script>
                let courseListContainer = document.querySelector('.all_courses_courselist_container .row');
                let searchResultnone = document.querySelector('#searchResultnone');
                let isSearch = document.querySelector('#searchMessage');
                let isSorted = document.querySelector('#sortMessage');
                let sortOption = document.querySelector('.all_courses_sort_select');
                let courseSearchInput = document.querySelector('#courseSearch');
                let courseSearchButton = document.querySelector('#courseSearchButton');
                let allCoursesForm = document.querySelector('.all_courses_filter_block2');
                let sortInput = document.querySelector('.all_courses_sort_select');
                let pageLinks = document.querySelectorAll('a.page-link');
                let filters = document.querySelectorAll('.all_courses_filter_select');
                let isTagFiltered = document.querySelector('#filterTagMessage');
                let isProgressFiltered = document.querySelector('#filterProgressMessage');
                let resetButton = document.querySelector('.all_courses_reset_btn');
                let wishListBadges = document.querySelectorAll('.wishList-badge');

                if (isSearch.value == "false") {
                    courseSearchInput.value = "";
                } else {
                    courseSearchInput.value = isSearch.value;
                }
                sortOption.value = isSorted.value;
                filters[0].value = isTagFiltered.value;
                filters[1].value = isProgressFiltered.value;

                if (courseListContainer.innerText == "") {
                    searchResultnone.style.display = "block";
                }

                function courseSearch(e) {
                    e.preventDefault();
                    let url = new URL(allCoursesForm.action);
                    url.searchParams.set('sorted', sortOption.value);
                    url.searchParams.set('tag', filters[0].value);
                    url.searchParams.set('progress', filters[1].value);
                    url.searchParams.set('q', courseSearchInput.value);
                    allCoursesForm.action = url;
                    allCoursesForm.submit();
                }

                function courseSort(e) {
                    let url = new URL(allCoursesForm.action);
                    url.searchParams.set('sorted', sortOption.value);
                    url.searchParams.set('tag', filters[0].value);
                    url.searchParams.set('progress', filters[1].value);
                    url.searchParams.set('q', isSearch.value);
                    allCoursesForm.action = url;
                    allCoursesForm.submit();
                }

                function sortOrder(e) {
                    e.preventDefault()
                    let url = new URL(e.target.href);
                    url.searchParams.set('sorted', isSorted.value);
                    url.searchParams.set('tag', filters[0].value);
                    url.searchParams.set('progress', filters[1].value);
                    url.searchParams.set('q', isSearch.value);
                    e.target.href = url;
                    window.location = url;
                }

                function filterBy(e) {
                    let url = new URL(allCoursesForm.action);
                    url.searchParams.set('sorted', sortOption.value);
                    url.searchParams.set('tag', filters[0].value);
                    url.searchParams.set('progress', filters[1].value);
                    url.searchParams.set('q', isSearch.value);
                    allCoursesForm.action = url;
                    allCoursesForm.submit();
                    // alert(`http://localhost:60157/elearningAllCourses/filter?sorted=${isSorted.value}&tag=${e.target.value}`);
                    // window.location = `http://localhost:60157/elearningAllCourses/filter?sorted=${isSorted.value}&tag=${e.target.value}`;
                }

                function courseReset(e) {
                    window.location =
                        `{{ route('elearningAllCourses') }}?sorted=Recently Added&tag=false&progress=false&q=false`;
                }

                courseSearchInput.addEventListener("keypress", (e) => {
                    if (e.key === "Enter") {
                        e.preventDefault();
                        courseSearchButton.click();
                    }
                });
                courseSearchButton.addEventListener("click", courseSearch);

                sortInput.addEventListener("change", courseSort);

                for (const pageLink of pageLinks) {
                    pageLink.addEventListener("click", sortOrder);
                }

                resetButton.addEventListener("click", courseReset);

                for (const filter of filters) {
                    filter.addEventListener("change", filterBy);
                }

                // wishlist addition
                function addWishList(e) {
                    let id = `${e.target.id}`.replace(/\D/g, "");
                    Swal.fire({
                        title: "Are you sure,you want to proceed the wishlist?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ url('/addWishList') }}",
                                type: 'GET',
                                data: {
                                    'id': id,
                                    _token: '{{csrf_token()}}'
                                },
                                success: function(data) {
                                    // $('#submitSuccess').modal('show');
                                    console.log(data);
                                    //alert(data);                                                                                                                  
                                    if (data == "wishlist added") {
                                        swal.fire({
                                            title: "Success",
                                            text: "Wishlist Added Successfully",
                                            icon: "success",
                                        });
                                    } else if (data == "already added") {
                                        swal.fire({
                                            title: "Success",
                                            text: "Wishlist Removed Successfully",
                                            icon: "success",
                                        });
                                    } else {
                                        Swal.fire("Error!", "Failed to add to Wishlist.", "error");
                                    }
                                }
                                // error: function(error) {
                                //     console.log('error; ' + eval(error));
                                // }
                            });
                        }
                    })

                }
                for (let wishListBadge of wishListBadges) {
                    wishListBadge.addEventListener('click', addWishList);
                }
            </script>
        </div>
    </section>
</div>

                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Class Resource:<span class="error-star" style="color:red;">*</span></label>
                                <input type="file" class="form-control default" id="cresource" required
                                    name="resource_name" accept=".pdf,.mp3,.mp4">
                                <span class="input-Message" id="resourceerror" style="color:red;"></span>
                                <span style="color:red !important"><strong>Following files could be uploaded as
                                        pdf,mp3,mp4</strong></span>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Class Duration:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" readonly class="form-control default" id="cduration" min="1"
                                    max="200" value="0.00" name="class_duration">
                                <span class="input-Message" id="durationerror" style="color:red;">
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Class Quiz:<span class="error-star" style="color:red;">*</span></label>

                                <select class="form-control" name="class_quiz" id="class_quiz" onchange="data(event);">
                                    <option value="">---Select Quiz Type---</option>
                                    <option value="yes">Yes </option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" id="yes" style="display:none;">
                            <div class="form-group">
                                <label>Quiz Name:<span class="error-star" style="color:red;">*</span></label>

                                <select class="form-control" name="quiz_id" id="quiz_id">
                                    <option value="">---Select Quiz Type---</option>
                                    @foreach($rows1['quiz_dropdown'] as $key => $row)
                                    <option value="{{ $row->quiz_id }}">{{ $row->quiz_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <a class="btn btn-success btn-space classsavebutton" type="submit" onclick="gencre()"
                                id="classsavebutton">Submit</a>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </div>

            </form>
        </div>




    </div>

</div>

<!-- edit quiz -->
<div class="modal fade" id="addModal4">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="POST" action="{{route('elearning.class_update', 1)}}" id="edit_form"
                enctype="multipart/form-data">

                @csrf
                <input type="hidden" name="eid" class="eid" id="eid">

                <div class="modal-header mh">
                    <h4 class="modal-title">Edit Class</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>


                <div class=" container edit  longquestion">
                    <h4 class="modal-title long">Edit Class</h4>


                    <div class="row">


                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Class Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="class_nameedit"
                                    name="class_nameedit" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="">Class Description<span class="error-star"
                                        style="color:red;">*</span></label>
                                <textarea class="form-control " id="class_descriptionedit" name="class_descriptionedit"
                                    rows="18" columns="10" required></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Class Duration:<span class="error-star" style="color:red;">*</span></label>
                            <input type="text" class="form-control default" id="class_durationedit"
                                name="class_durationedit" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">

                            <label>Class Resource:<span class="error-star" style="color:red;">*</span></label>
                            <div class="col-md-10"
                                style="display: flex;justify-content: space-between;margin-bottom: 15px;">
                                <a class="btn btn-link btn-warning" onclick="changeimage(event);"
                                    id="change_banner">Change Resource</a>
                                <a class="btn btn-link btn-warning" onclick="changeimage(event);" id="change_cancel"
                                    style="display:none;">Cancel</a>

                            </div>


                            <input type="file" class="form-control default" id="resourse_nameedit"
                                name="resource_nameedit" style="display:none;" autocomplete="off"
                                accept=".pdf, .mp3,.mp4">

                            <iframe style="height:300px;width:50% " class="img-fluid" alt="Banner Image" title=""></iframe>



                        </div>
                        <span style="color:red !important"><strong>Following files could be uploaded as
                                pdf,mp3,mp4</strong></span>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Class Quiz:<span class="error-star" style="color:red;">*</span></label>

                                <select class="form-control" name="class_quizedit" id="class_quizedit"
                                    onchange="data(event);">
                                    <option value="">---Select Quiz Type---</option>
                                    <option value="yes">Yes </option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" id="yesedit">
                            <div class="form-group">
                                <label>Quiz Name:<span class="error-star" style="color:red;">*</span></label>

                                <select class="form-control" name="quiz_idedit" id="quiz_idedit">
                                    <option value="">---Select Quiz Type---</option>
                                    @foreach($rows1['quiz_dropdown'] as $key => $row)
                                    <option value="{{ $row->quiz_id }}">{{ $row->quiz_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>


                    </div>

                    <!-- <h style="color:black"><b>Address:</b></h> -->


                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <button class="btn btn-success btn-space savebutton" type="submit"
                                onclick="gencre11('edit')" id="savebutton">Update</button>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </div>
            </form>
        </div>


    </div>
</div>
<!-- end -->




<div class="modal fade" id="addModal3">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">



            <div class="modal-header mh">
                <h4 class="modal-title">Edit Course</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

            </div>




            <!-- Long question -->

            <div class="card longquestion" id="">
                <h4 class="modal-title long">Edit Course:</h4>
                <form method="POST" id="course_form_edit" action="{{url('/elearning/course/update/1')}}"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="course_edit" class="course_edit" id="course_edit">

                    <div class="row">
                    

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="course_nameedit" name="course_name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Description:<span class="error-star"
                                        style="color:red;">*</span></label><br>
                                <textarea id="course_descriptionedit" name="course_description" rows="3"
                                    class="form-control"></textarea>

                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Certificate:</label><br>
                                <input type="radio" class="btn-check answer_edit_on" name="course_certificate" value="1"
                                    id="course_certificateedit" autocomplete="off">
                                <label class="btn btn-outline-primary" for="btnradio1">Yes</label>

                                <input type="radio" class="btn-check answer_edit_off" name="course_certificate"
                                    value="2" id="course_certificateedit" autocomplete="off">
                                <label class="btn btn-outline-primary" for="btnradio2">No</label>


                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Course Introduction:<span class="error-star" style="color:red;">*</span></label>
                                <div class="col-md-10"
                                    style="display: flex;justify-content: space-between;margin-bottom: 15px;">
                                    <a class="btn btn-link btn-warning" onclick="changeimage1(event);"
                                        id="change_banner1">Change Introduction</a>
                                    <a class="btn btn-link btn-warning" onclick="changeimage1(event);"
                                        id="change_cancel1" style="display:none;">Cancel</a>
                                </div>
                                <input type="file" class="form-control default" id="course_introductionedit"
                                    name="course_introductionedit" style="display:none;" autocomplete="off">

                                <iframe id="course_introductionedit" class="img-fluid1" alt="Banner Image" width="300"
                                    height="150"></iframe>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>Course Banner:<span class="error-star" style="color:red;">*</span></label>
                                <div class="col-md-10"
                                    style="display: flex;justify-content: space-between;margin-bottom: 15px;">
                                    <a class="btn btn-link btn-warning" onclick="changeimage2(event);"
                                        id="change_banner2">Change Banner</a>
                                    <a class="btn btn-link btn-warning" onclick="changeimage2(event);"
                                        id="change_cancel2" style="display:none;">Cancel</a>
                                </div>
                                <input type="file" class="form-control default" id="course_banneredit"
                                    name="course_banneredit" style="display:none;" accept="image/*" autocomplete="off">
                                <?php if (!empty($data->course_banner)) { ?>

                                    <img class="img-fluid2" alt="Banner Image" title="">

                                <?php } else { ?>
                                    <img class="" src="uploads/class/126/empty.jpg" alt="Banner Image" width="200px"
                                        height="200px" title="">

                                <?php } ?>





                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">


                            <div class="form-group">
                                <label> Course Type:<span class="error-star" style="color:red;">*</span></label>

                                <select class="form-control" name="course_pay" id="course_payedit">
                                    <option value="">---Select Course Type---</option>
                                    <option value="paid">Paid Course</option>
                                    <option value="free">Free Course</option>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-6" id="paid1" style="display:none;">
                            <div class="form-group">
                                <label>Course Price:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="course_priceedit"
                                    name="course_price">
                            </div>

                        </div>
                        <div class="col-md-6" id="free1" style="display:none;">
                            <div class="form-group">
                                <label>Course Price:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" readonly class="form-control default" value="0" id="course_price"
                                    name="course_price">
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3"><label class="course_period">Course Period:<span class="error-star"
                                    style="color:red;">*</span></label></div>

                        <div class="col-md-4">

                            <div class="form-group">
                                <label>Start Date:<span class="error-star" style="color:red;">*</span></label>
                                <input type='text' class="form-control default startdate" id='course_start_periodedit'
                                    disabled name="course_start_period" title="Meeting Start Date"
                                    placeholder="dd-mm-yy" onchange="autodateupdate(this)" required autocomplete="off">
                            </div>

                        </div>

                        <div class="col-md-4">


                            <div class="form-group">
                                <label>End Date:<span class="error-star" style="color:red;">*</span></label>
                                <input type='text' class="form-control default startdate" id='course_end_periodedit'
                                    disabled name="course_end_period" title="Meeting Start Date" placeholder="dd-mm-yy"
                                    onchange="autodateupdate(this)" required autocomplete="off">
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Instructor:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="course_instructoredit"
                                    name="course_instructor">
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Course Tags:<span class="error-star" style="color:red;">*</span></label>
                                <div class="wordquestion">

                                    <table class="_table">

                                        <tbody id="table_bodyedit">
                                            <tr>

                                                <td>
                                                    <input type="text" class="form-control default" id="course_tagsedit"
                                                        name="course_tags[]">
                                                </td>
                                                <td>
                                                    <div class="action_container">
                                                        <button class="danger" onclick="remove_tr(this)">
                                                            <i class="fa fa-close"></i>
                                                        </button>
                                                    </div>

                                                </td>


                                            </tr>

                                        </tbody>


                                    </table>

                                    <div class="action_container" width="50px">
                                        <button class="success" type="button" onclick="create_tr('table_bodyedit')">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <h style="color:black"><b>Address:</b></h> -->


                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Skill Required:<span class="error-star" style="color:red;">*</span></label>
                                <div class="wordquestion">

                                    <table class="_table">

                                        <tbody id="table_body1edit">
                                            <tr>

                                                <td>
                                                    <input type="text" class="form-control default"
                                                        id="course_skills_required[]" name="course_skills_required">
                                                </td>
                                                <td>
                                                    <div class="action_container">
                                                        <button class="danger" onclick="remove_tr(this)">
                                                            <i class="fa fa-close"></i>
                                                        </button>
                                                    </div>

                                                </td>


                                            </tr>

                                        </tbody>


                                    </table>

                                    <div class="action_container" width="50px">
                                        <button class="success" type="button" onclick="create_tr1('table_body1edit')">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Gain Skill:<span class="error-star" style="color:red;">*</span></label>
                                <div class="wordquestion">

                                    <table class="_table">

                                        <tbody id="table_body2edit">
                                            <tr>

                                                <td>
                                                    <input type="text" class="form-control default"
                                                        id="course_gain_skills" name="course_gain_skills">
                                                </td>
                                                <td>
                                                    <div class="action_container">
                                                        <button class="danger" onclick="remove_tr(this)">
                                                            <i class="fa fa-close"></i>
                                                        </button>
                                                    </div>

                                                </td>


                                            </tr>

                                        </tbody>


                                    </table>

                                    <div class="action_container" width="50px">
                                        <button class="success" type="button" onclick="create_tr('table_body2edit')">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>



                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>CPD Points: <span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="course_cpt_pointsedit"
                                    name="course_cpt_points">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Classes:<span class="error-star" style="color:red;">*</span></label>

                                <br>
                                <select class="js-select6 course_classesedit" name="course_classes[]"
                                    id="course_classesedit" multiple="multiple">


                                    @foreach($rows['elearning_classes'] as $data)
                                    <option value="{{$data->class_id}}" data-badge="">{{$data->class_name}}</option>
                                    @endforeach

                                </select>

                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-lg-12 text-center">

                            <button class="btn btn-success btn-space" type="button" onclick="gencre1('edit');"
                                id="savebutton">Update</button>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </div>
                </form>
            </div>

            <!-- end long-->
        </div>
    </div>
</div>

<!-- iyya -->

<div class="modal fade" id="addModal5">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">



            <div class="modal-header mh">
                <h4 class="modal-title">Show Course</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

            </div>




            <!-- Long question -->

            <div class="card longquestion" id="">
                <h4 class="modal-title long">Show Course:</h4>
                <form method="POST" id="course_form_show" action="{{url('/elearning/course/show/1')}}"
                    enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="course_editshow" class="course_edit" id="course_editshow">

                    <div class="row">
                       
                        </div> 

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Catagory<span class="error-star" style="color:red;">*</span></label>

                                <select class="form-control" name="course_category_id" id="course_category_id_show">
                                    <option value="">---Select Category---</option>

                                    @foreach($rows['course_catagory_name'] as $data)
                                    <option value="{{$data->catagory_id}}" data-badge="">{{$data->catagory_name}}
                                    </option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <label>Sub Catagory<span class="error-star" style="color:red;">*</span></label>

                            <select class="form-control" name="course_category" id="course_category" onchange="fetch_show(this.value, 'edit')">
                                <option value="">---Select Category---</option>
                                @foreach($rows['course_catagory_name'] as $data)
                                <option value="{{ $data->catagory_id }}">{{ $data->sub_catagory }}</option>
                                @endforeach
                            </select>

                        </div> -->


                        <!-- Role Selection -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Role <span class="error-star" style="color:red;">*</span></label>
                                <select class="form-control" name="role_id" id="role_id_show">
                                    <option value="">---Select Role---</option>
                                    @foreach($roles as $values)
                                    <option value="{{ $values->role_id }}">{{ $values->role_name }}</option>
                                    @endforeach
                                </select>
                                @error('role_id') {{-- corrected from roles_id --}}
                                <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Designation Selection -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Designation <span class="error-star" style="color:red;">*</span></label>
                                <select class="form-control" name="designation_id" id="designation_id_show">
                                    <!-- <option value="">Please Select Designation</option> -->
                                    @foreach( $rows['designation'] as $values)
                                    <option value="{{ $values->designation_id }}">{{ $values->designation_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('designation_id')
                                <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>User Name <span class="text-danger">*</span></label>
                                <select style="height:100px" class="user_id_course form-control js-select5"
                                    name="user_ids[]" id="user_ids_show" multiple="multiple"
                                    style="width:208px !important;">
                                    @foreach($rows['users'] as $data)
                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="course_nameshow" name="course_name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Description:<span class="error-star"
                                        style="color:red;">*</span></label><br>
                                <textarea id="course_descriptionshow" name="course_description" rows="3"
                                    class="form-control"></textarea>

                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Certificate:</label><br>
                                <input type="radio" class="btn-check answer_show_on course_certificateshow"
                                    name="course_certificate" value="1" id="course_certificateshow" autocomplete="off">
                                <label class="btn btn-outline-primary answer_show_on1" for="btnradio1">Yes</label>

                                <input type="radio" class="btn-check answer_show_off course_certificateshow"
                                    name="course_certificate" value="2" id="course_certificateshow" autocomplete="off">
                                <label class="btn btn-outline-primary answer_show_off1" for="btnradio2">No</label>


                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Exam:<span class="error-star" style="color:red;">*</span></label><br>
                                <input type="radio" class="btn-check exam_show_on course_examshow" name="course_exam"
                                    value="1" id="course_examshow" autocomplete="off">
                                <label class="btn btn-outline-primary exam_show_on1" for="btnradio1">Yes</label>

                                <input type="radio" class="btn-check exam_show_off course_examshow" name="course_exam"
                                    value="2" id="course_examshow" autocomplete="off">
                                <label class="btn btn-outline-primary exam_show_off1" for="btnradio2">No</label>


                            </div>
                        </div>

                        <div class="row">
                            <!-- Course Introduction -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Course Introduction:<span class="error-star" style="color:red;">*</span></label>
                                    <div class="d-flex justify-content-between mb-2">
                                        <iframe id="course_introductionshow" class="img-fluid1" alt="Banner Image"
                                            width="200" height="150"></iframe>
                                        <input type="file" class="form-control default" id="course_introduction"
                                            name="course_introduction" style="display:none;" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <!-- Course Banner -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Course Banner:<span class="error-star" style="color:red;">*</span></label>
                                    <input type="file" class="form-control default" id="course_banner"
                                        name="course_banner" style="display:none;" accept="image/*" autocomplete="off">
                                    <img class="img-fluid2" alt="Banner Image" title=""
                                        style="width:200px;height:200px !important;">
                                </div>
                            </div>

                            <!-- Course Summary -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Course Summary for chatbot:<span class="error-star" style="color:red;">*</span></label>
                                    <input type="file" class="form-control default" id="course_summary"
                                        name="course_summary" style="display:none;" accept="image/*" autocomplete="off">
                                    <img class="img-fluid2" alt="Summary Image" title=""
                                        style="width:200px;height:200px !important;">
                                </div>
                            </div>
                        </div>



                        <div class="col-md-6">


                            <div class="form-group">
                                <label> Course Type:<span class="error-star" style="color:red;">*</span></label>

                                <select class="form-control" name="course_pay" id="course_payshow">
                                    <option value="">---Select Course Type---</option>
                                    <option value="paid">Paid Course</option>
                                    <option value="free">Free Course</option>
                                </select>

                            </div>
                        </div>

                        <div class=" col md-6" id="certificateFields_edit" style="display: none;">
                            <!-- <div class="col-md"> -->
                            <div class="form-group">
                                <label> Certificate Template:<span class="error-star"
                                        style="color:red;">*</span></label>
                                <select class="form-control" name="cetificate_template" id="cetificate_template_show">
                                    <option value="">---Select Certificate Template---</option>
                                    @foreach($rows1['certificate_templates'] as $row)
                                    <option value="{{ $row->certificate_templates_id }}">{{ $row->template_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Certificate Expiry:<span class="error-star"
                                            style="color:red;">*</span></label><br>
                                    <input type="radio" class="btn-check certificate_expiry" name="certificate_expiry"
                                        value="1" id="certificate_expiryyes_show" autocomplete="off">
                                    <label class="btn btn-outline-primary" for="certificate_expiryyes_show">Yes</label>

                                    <input type="radio" class="btn-check certificate_expiry" name="certificate_expiry"
                                        value="2" id="certificate_expiryno_show" autocomplete="off">
                                    <label class="btn btn-outline-primary" for="certificate_expiryno_show">No</label>
                                </div>
                            </div>

                            <div class="col-md-6" id="expiryDateField_show" style="display: none;">
                                <div class="form-group">
                                    <label>Expiry Date:<span class="error-star" style="color:red;">*</span></label>
                                    <input type='date' class="form-control default hasDatepicker"
                                        id='course_expiry_period_show' name="course_expiry_period"
                                        placeholder="dd-mm-yy" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" id="paid2" style="display:none;">
                            <div class="form-group">
                                <label>Course Price:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="course_priceshow"
                                    name="course_price">
                            </div>

                        </div>
                        <div class="col-md-6" id="free2" style="display:none;">
                            <div class="form-group">
                                <label>Course Price:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" readonly class="form-control default" value="0" id="course_priceshow"
                                    name="course_price">
                            </div>

                        </div>

                        <div class="col-md-12 form-group"
                            style="display:flex;justify-content: space-evenly;align-items: center;"><label>This Course
                                has Start and End Period<span class="error-star" style="color:red;">*</span></label>
                            <div class="col-md-4 form-group">
                                <input type="radio" class="btn-check answer_show_on course_noperiodshow"
                                    name="course_noperiod" value="1" id="course_noperiodshow" autocomplete="off">
                                <label class="btn btn-outline-primary answer_show_on1"
                                    for="course_noperiodyes">Yes</label>

                                <input type="radio" class="btn-check answer_show_off course_noperiodshow"
                                    name="course_noperiod" value="2" id="course_noperiodshow" autocomplete="off">
                                <label class="btn btn-outline-primary answer_show_off1"
                                    for="course_noperiodno">No</label>

                            </div>



                        </div>



                        <div class="col-md-3"><label class="course_period">Course Period:<span class="error-star"
                                    style="color:red;">*</span></label>
                        </div>

                        <div class="col-md-4">

                            <div class="form-group">
                                <label>Start Date:<span class="error-star" style="color:red;">*</span></label>
                                <input type='text' class="form-control default" id='course_start_periodshow' disabled
                                    name="course_start_period" title="Meeting Start Date" placeholder="dd-mm-yy"
                                    onchange="autodateupdate(this)" required autocomplete="off">
                            </div>

                        </div>

                        <div class="col-md-4">


                            <div class="form-group">
                                <label>End Date:<span class="error-star" style="color:red;">*</span></label>
                                <input type='text' class="form-control default" id='course_end_periodshow' disabled
                                    name="course_end_period" title="Meeting Start Date" placeholder="dd-mm-yy"
                                    onchange="autodateupdate(this)" required autocomplete="off">
                            </div>
                        </div>


                        <div class="col-md-12 examnameshow">
                            <div class="">
                                <div class="col-md-3"><label class="course_period">Exam Details:<span class="error-star"
                                            style="color:red;">*</span></label></div>

                                <div class="col-md-5">

                                    <div class="form-group">
                                        <label class="control-label required">Exam Name:<span class="error-star"
                                                style="color:red;">*</span></label>
                                        <select class="form-control" name="exam_nameshow" id="exam_nameshow">
                                            <option value="">Select Exam Name</option>
                                            @foreach($rows1['exam_list'] as $key => $row)
                                            <option value="{{ $row->id }}">{{ $row->exam_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label>Exam Date:<span class="error-star" style="color:red;">*</span></label>
                                        <input type='text' class="form-control default exam_dateshow" id='exam_dateshow'
                                            name="exam_dateshow" title="Course Exam Date" autocomplete="off">
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Pass Percentage:<span class="error-star" style="color:red;">*</span></label>
                                    <div style="display:flex;align-items: baseline;">
                                        <input type="text" class="form-control default" id="pass_percentageshow"
                                            name="pass_percentageshow"><span class="col-md-6"
                                            style="color:red;"><strong>(in
                                                percentage only)</strong></span>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Instructor:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="course_instructorshow"
                                    name="course_instructor">
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Course Tags:<span class="error-star" style="color:red;">*</span></label>
                                <div class="wordquestion">
                                    <textarea class="form-control default" id="course_tagsshow" name="course_tags"
                                        style="background-color: #e9ecef !important;"></textarea>

                                </div>
                            </div>
                        </div>
                        <!-- <h style="color:black"><b>Address:</b></h> -->



                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Skill Required:<span class="error-star" style="color:red;">*</span></label>
                                <div class="wordquestion">
                                    <textarea class="form-control default" id="course_skills_requiredshow"
                                        name="course_skills_required"
                                        style="background-color: #e9ecef !important;"></textarea>

                                </div>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Gain Skill:<span class="error-star" style="color:red;">*</span></label>
                                <div class="wordquestion">
                                    <textarea class="form-control default" id="course_gain_skillsshow"
                                        name="course_gain_skills"
                                        style="background-color: #e9ecef !important;"></textarea>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>CPD Points: <span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="course_cpt_pointsshow"
                                    name="course_cpt_points">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Classes:<span class="error-star" style="color:red;">*</span></label>

                                <br>
                                <select class="js-select5  course_classesshow" name="course_classes[]"
                                    id="course_classesshow" multiple="multiple" style="width:208px !important;">

                                    @foreach($rows['elearning_classes'] as $key => $data)
                                    <option value="{{$data->class_id}}" data-badge="">{{$data->class_name}}</option>
                                    @endforeach

                                </select>



                            </div>
                        </div>

                        <div class="col-lg-12 text-center">
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                </form>
            </div>

            <!-- end long-->
        </div>
    </div>
</div>



<script>
    function handleExpiredCourse(course_id) {
        Swal.fire({
            title: 'Expired Certificate Course Detected',
            icon: 'warning',
            html: `
            <ul style="text-align: left;">
                <li>If content changes annually, <b>create a new course</b>.</li>
                <li>If the same content is reused, <b>Copy & reassign the existing course for maintaining existing data</b>.</li>
            </ul>
        `,
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Create New Course',
            denyButtonText: `Copy & Reassign Existing`,
            cancelButtonText: 'Close',
        }).then((result) => {
            if (result.isConfirmed) {
                // Trigger the "Add Course" modal
                $('#expired_course_id').val(course_id);
                $('#addModal').modal('show');
            } else if (result.isDenied) {
                // Redirect to reassign logic
                Swal.fire({
                    title: "Copy Course Options",
                    html: `
        <div style="text-align: left;">
            <label style="margin-bottom: 6px;">Certificate Expiry: <span style="color:red">*</span></label><br>

            <input type="radio" class="btn-check" name="certificate_expiry" value="1"
                id="certificate_expiryyes" autocomplete="off">
            <label class="btn btn-outline-primary mb-2" for="certificate_expiryyes">Yes</label>

            <input type="radio" class="btn-check" name="certificate_expiry" value="2"
                id="certificate_expiryno" autocomplete="off">
            <label class="btn btn-outline-primary mb-2" for="certificate_expiryno">No</label>

            <div id="expiry_date_container" style="display:none; margin-top:10px;">
                <label for="expiry_date">Expiry Month: <span style="color:red">*</span></label>
                <input type="number" id="expiry_date" class="swal2-input" />
            </div>
        </div>
    `,
                    showCancelButton: true,
                    confirmButtonText: 'Copy Course',
                    cancelButtonText: 'Cancel',
                    didOpen: () => {
                        const dateContainer = document.getElementById('expiry_date_container');

                        document.querySelectorAll('input[name="certificate_expiry"]').forEach((
                            radio) => {
                            radio.addEventListener('change', function() {
                                if (this.value === "1") {
                                    dateContainer.style.display = 'block';
                                } else {
                                    dateContainer.style.display = 'none';
                                    document.getElementById('expiry_date').value = '';
                                }
                            });
                        });
                    },
                    preConfirm: () => {
                        const selected = document.querySelector(
                            'input[name="certificate_expiry"]:checked');
                        const expiryDate = document.getElementById('expiry_date').value;

                        if (!selected) {
                            Swal.showValidationMessage(
                                "Please select 'Yes' or 'No' for Certificate Expiry");
                            return false;
                        }

                        if (selected.value === "1" && !expiryDate) {
                            Swal.showValidationMessage(
                                "Please enter an expiry date when 'Yes' is selected");
                            return false;
                        }

                        return {
                            certificate_expiry: selected.value,
                            course_expiry_period: selected.value === "1" ? expiryDate : null
                        };
                    }
                }).then((result) => {
                    if (!result.isConfirmed) return;

                    const formData = result.value;

                    $.ajax({
                        url: "{{ route('course_copy') }}",
                        type: 'POST',
                        data: {
                            course_id: course_id,
                            certificate_expiry: formData.certificate_expiry,
                            course_expiry_period: formData.course_expiry_period,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            if (data.data == 0) {
                                Swal.fire("Info", data.message_cus, "info");
                            } else {
                                Swal.fire("Success", "Course copied successfully!", "success")
                                    .then(() => {
                                        location.href = `/admincourse`;
                                    });
                            }
                        },
                        error: function() {
                            Swal.fire("Error", "Something went wrong", "error");
                        }
                    });
                });


            }
        });
    }

    function showReplacementMessage(course_id) {
        Swal.fire({
            title: 'Course Already Replaced',
            icon: 'info',
            html: `
            <p>This course has already been <b>replaced</b> with a new or copied version.</p>
            <p>No further action is needed.</p>
        `,
            confirmButtonText: 'OK'
        });
    }



    function gencre() {

        var cname = $("#cname").val();
        if (cname == '') {
            swal.fire("Please Enter the Class Name", "", "error");
            return false;
        }
        var cdescription = $("#cdescription").val();
        if (cdescription == '') {
            swal.fire("Please Enter The Class Description", "", "error")
            return false;
        }
        var cresource = $("#cresource").val();
        if (cresource == '') {
            swal.fire("Please Enter The Resourse", "", "error");
            return false;
        }
        var class_quiz = $("#class_quiz").val();
        if (class_quiz == '') {
            swal.fire("Please Select the Class Quiz", "", "error");
            return false;

        }

        // if (class_quiz === 'yes') {
        //     var quiz_id = $("#quiz_id").val();
        //     if (quiz_id == '') {
        //         swal.fire("Please Select the Quiz Name", "", "error");
        //         return false;

        //     }


        // } 
        else {
            $('#classsavebutton').css('pointer-events', 'none');
            document.getElementById('class_form').submit();
        }

    }
</script>
<link rel="stylesheet" href="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>

<script>
    function resetSelect2() {
        // Get the Select2 element by its ID
        $(".js-select2").empty();

    }
    $('.close').on('click', function() {
        resetSelect2();
    });
    }
    $('.close').on('click', function() {
        resetSelect2();
    });
</script>
<script>
    $(document).ready(function() {
        // Course Certificate toggle
        $('input[name="course_certificate"]').change(function() {
            if ($(this).val() == '1') {
                $('#certificateFields').slideDown();
            } else {
                $('#certificateFields').slideUp();
                $('#cetificate_template').val('');
                $('input[name="certificate_expiry"]').prop('checked', false);
                $('#course_expiry_period').val('');
                $('#expiryDateField').hide(); // Also hide date field
            }
        });

        // Certificate Expiry toggle
        $(document).on('change', 'input[name="certificate_expiry"]', function() {
            if ($(this).val() == '1') {
                $('#expiryDateField').slideDown();
            } else {
                $('#expiryDateField').slideUp();
                $('#course_expiry_period').val('');
            }
        });


    });
</script>
<script>
    $(document).ready(function() {
        // Course Certificate toggle
        $('input[name="course_certificate"]').change(function() {
            if ($(this).val() == '1') {
                $('#certificateFields').slideDown();
            } else {
                $('#certificateFields').slideUp();
                $('#cetificate_template').val('');
                $('input[name="certificate_expiry"]').prop('checked', false);
                $('#course_expiry_period').val('');
                $('#expiryDateField').hide(); // Also hide date field
            }
        });

        // Certificate Expiry toggle
        $(document).on('change', 'input[name="certificate_expiry"]', function() {
            if ($(this).val() == '1') {
                $('#expiryDateField').slideDown();
            } else {
                $('#expiryDateField').slideUp();
                $('#course_expiry_period').val('');
            }
        });


    });
</script>

<script>
    function gencre1(id) {



        if (id == "1") {
            var course_category = $("#course_category").val();

            if (course_category == '') {
                swal.fire("Please Select the Course Category", "", "error");
                return false;
            }

            var course_name = $("#course_name").val();
            if (course_name == '') {
                swal.fire("Please Enter the Course Name", "", "error");
                return false;
            }

            var course_description = $("#course_description").val();
            if (course_description == '') {
                swal.fire("Please Enter the Course Description", "", "error");
                return false;
            }


            const input_array = document.querySelectorAll('input[name="course_certificate"]');


            let AnswerSelected = false;
            for (let row of input_array) {
                if (row.checked === true) {
                    AnswerSelected = true;
                }
            }
            if (AnswerSelected === false) {

                swal.fire("Please Select the Course Certificate", "", "error");
                return false;
            }


            const input_array2 = document.querySelectorAll('input[name="course_exam"]');

            let AnswerSelected2 = false;
            for (let row of input_array2) {
                if (row.checked === true) {
                    AnswerSelected2 = true;
                }
            }
            if (AnswerSelected2 === false) {

                swal.fire("Please Select the Course Exam", "", "error");
                return false;
            }



            var course_introduction = $("#course_introduction").val();
            if (course_introduction == '') {
                swal.fire("Please Upload the Course Introduction", "", "error")
                return false;
            }

            var course_banner = $("#course_banner").val();
            if (course_banner == '') {
                swal.fire("Please Upload the Course Banner", "", "error")
                return false;
            }
            var course_summary = $("#course_summary").val();
            if (course_summary == '') {
                swal.fire("Please Upload the Course Summary", "", "error")
                return false;
            }
            // var course = $("#course").val();
            // if (course == '') {
            //     swal.fire("Please Select the Course Type", "", "error")
            //     return false;
            // }

            var course_pay = $("#course_pay").val();
            if (course_pay == '') {
                swal.fire("Please Enter the Course Type", "", "error")
                return false;
            }

            var course_price = $("#course_price").val();
            if (course_pay == 'paid') {
                if (course_price == '') {
                    swal.fire("Please Enter the Course Price", "", "error");
                    return false;

                }
            }
            var course_noperiod = $(".course_noperiod").val();
            // if (course_noperiod == '2') {
            //     var course_start_period = $("#course_start_period").val();

            //     if (course_start_period == '') {
            //         swal.fire("Please Select the Course Start Period", "", "error")
            //         return false;
            //     }
            //     var course_end_period = $("#course_end_period").val();
            //     if (course_end_period == '') {
            //         swal.fire("Please Select the Course End Period", "", "error")
            //         return false;
            //     }
            //     var pass_percentage = $("#pass_percentage").val();
            //     if (pass_percentage == '') {
            //         swal.fire("Please Enter the Pass Percentage", "", "error")
            //         return false;
            //     }
            // }
            // if (course_noperiod == '1') {
            //     var exam_date = $("#exam_date").val();

            //     if (exam_date == '') {
            //         swal.fire("Please Select the Exam Date", "", "error")
            //         return false;
            //     }
            //     var exam_name = $("#exam_name").val();
            //     if (exam_name == '') {
            //         swal.fire("Please Select the Exam name", "", "error")
            //         return false;
            //     }
            //     var pass_percentage = $("#pass_percentage").val();
            //     if (pass_percentage == '') {
            //         swal.fire("Please Enter the Pass Percentage", "", "error")
            //         return false;
            //     }
            // }


            // const input_array1 = document.querySelectorAll('.course_exam');
            // let AnswerSelected1 = false;
            // for (let row of input_array1) {
            //     if (row.checked === true) {
            //         AnswerSelected1 = true;
            //         var exam_name = $("#exam_name").val();
            //         if (exam_name == '') {
            //             swal.fire("Please Select the Exam Name", "", "error")
            //             return false;
            //         }
            //         var exam_date = $("#exam_date").val();
            //         if (exam_date == '') {
            //             swal.fire("Please Select the Exam Date", "", "error")
            //             return false;
            //         }
            //         var pass_percentage = $("#pass_percentage").val();
            //         if (pass_percentage == '') {
            //             swal.fire("Please Enter the Pass Percentage", "", "error")
            //             return false;
            //         }

            //     }
            // }
            // if (AnswerSelected1 === false) {

            //     swal.fire("Please Select the Course Exam", "", "error");
            //     return false;
            // }
            var course_instructor = $("#course_instructor").val();
            if (course_instructor == '') {
                swal.fire("Please Enter the Course Instructor", "", "error")
                return false;
            }

            var course_tags = $("#course_tags").val();
            if (course_tags == '') {
                swal.fire("Please Enter the Course Tags", "", "error")
                return false;
            }

            var course_skills_required = $("#course_skills_required").val();
            if (course_skills_required == '') {
                swal.fire("Please Enter the Course Skills Required", "", "error")
                return false;
            }

            var course_gain_skills = $("#course_gain_skills").val();
            if (course_gain_skills == '') {
                swal.fire("Please Enter the Course Gain Skills", "", "error")
                return false;
            }
            var course_cpt_points = $("#course_cpt_points").val();
            if (course_cpt_points == '') {
                swal.fire("Please Enter the Course CPD Points", "", "error")
                return false;
            }

            var course_classes = $("#course_classes").val();
            if (course_classes == '') {
                swal.fire("Please Enter the Course Classes", "", "error")
                return false;
            } else {
                $('#savebutton').css('pointer-events', 'none');
                document.getElementById('course_form').submit();
            }
        }



        if (id == "edit") {
            var course_category = $("#course_categoryedit").val();
            if (course_category == '') {
                swal.fire("Please Select the Course Category", "", "error");
                return false;
            }

            var course_name = $("#course_nameedit").val();
            if (course_name == '') {
                swal.fire("Please Enter the Course Name", "", "error");
                return false;
            }

            var course_description = $("#course_descriptionedit").val();
            if (course_description == '') {
                swal.fire("Please Enter the Course Description", "", "error");
                return false;
            }


            const input_array = document.querySelectorAll('#course_certificateedit');
            let AnswerSelected = false;
            for (let row of input_array) {
                if (row.checked === true) {
                    AnswerSelected = true;
                }
            }
            if (AnswerSelected === false) {

                swal.fire("Please Select the Course Certificate", "", "error");
                return false;
            }

            // var course_introduction = $("#course_introductionedit").val();
            // if (course_introduction == '') {
            //     swal.fire("Please Upload the Course Introduction", "", "error")
            //     return false;
            // }

            // var course_banner = $("#course_banneredit").val();
            // if (course_banner == '') {
            //     swal.fire("Please Upload the Course Banner", "", "error")
            //     return false;
            // }
            var course = $("#course_payedit").val();
            if (course == '') {
                swal.fire("Please Select the Course Type", "", "error")
                return false;
            }

            // var course = $("#course_price").val();
            // if (course == '') {
            //     swal.fire("Please Enter the Course Price", "", "error")
            //     return false;
            // }

            var course_start_period = $("#course_start_periodedit").val();
            if (course_start_period == '') {
                swal.fire("Please Select the Course Start Period", "", "error")
                return false;
            }

            var course_end_period = $("#course_end_periodedit").val();
            if (course_end_period == '') {
                swal.fire("Please Select the Course End Period", "", "error")
                return false;
            }

            var course_instructor = $("#course_instructoredit").val();
            if (course_instructor == '') {
                swal.fire("Please Enter the Course Instructor", "", "error")
                return false;
            }



            var course_tags = document.querySelectorAll('#course_tagsedit');
            var keyword_key = 0;
            for (const course_tagsedit of course_tags) {
                if (keyword_key != 0 && course_tagsedit.value == '') {
                    swal.fire("Please Enter the Course Tags", "", "error");
                    return false;
                }
                keyword_key++;

            }


            var course_skills_required1 = document.querySelectorAll('#course_skills_required');
            var keyword_key = 0;
            for (const course_skills_required of course_skills_required1) {
                if (keyword_key != 0 && course_skills_required.value == '') {
                    swal.fire("Please Enter the Course Skills Required", "", "error");
                    return false;
                }
                keyword_key++;

            }

            var course_gain_skills1 = document.querySelectorAll('#course_skills_required');
            var keyword_key = 0;
            for (const course_skills_required of course_gain_skills1) {
                if (keyword_key != 0 && course_skills_required.value == '') {
                    swal.fire("Please Enter the Course Gain Skills", "", "error");
                    return false;
                }
                keyword_key++;

            }

            var course_cpt_points = $("#course_cpt_pointsedit").val();
            if (course_cpt_points == '') {
                swal.fire("Please Enter the Course CPD Points", "", "error")
                return false;
            }

            var course_classes = $("#course_classesedit").val();
            if (course_classes == '') {
                swal.fire("Please Enter the Course Classes", "", "error")
                return false;
            } else {
                // $('#savebutton').css('pointer-events', 'none');
                document.getElementById('course_form_edit').submit();
            }
        }

    }
</script>



<!-- end create -->
<!-- edit function -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    var $j = jQuery.noConflict();

    $j(document).ready(function() {


        // Initialize Select2 plugin
        // $j('#exam_name').select2();
        // $j('#exam_name').removeAttr('multiple');

        //alert('egeg');

    });
</script>




<script type="text/javascript">
    var letters = /^[A-Za-z]+$/;
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var number = /^\(?(\d{0})\)?[- ]?(\d{0})[- ]?(\d{4})$/;
    var number2 = /^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/;

    function validate(e) {


        const cname = document.getElementById("cname");
        const resource = document.getElementById("resource");
        const duration = document.getElementById("duration");


        e.preventDefault();
        if (cname.value == "") {
            document.getElementById("cnameerror").innerHTML =
                "**Please Enter the Class Name**";
            return;
        } else {
            document.getElementById("cnameerror").innerText = "";
        }


        e.preventDefault();
        if (resource.value == "") {
            document.getElementById("resourceerror").innerHTML =
                "**Please Enter the Validate Resource **";
            return;
        } else {
            document.getElementById("resourceerror").innerText = "";
        }



        e.preventDefault();
        if (duration.value == "") {
            document.getElementById("durationerror").innerHTML =
                "**Please Enter the Valid Duration**";
            return;
        } else {
            document.getElementById("durationerror").innerText = "";
        }


        $("#validate").submit();


    }


    function changeimage(e) {
        if (e.target.id == "change_banner") {
            document.querySelector('#resourse_nameedit').style.display = "block";
            document.querySelector('#change_cancel').style.display = "block";
            document.querySelector('#change_banner').style.display = "none";
        } else if (e.target.id == "change_cancel") {
            document.querySelector('#change_cancel').style.display = "none";
            document.querySelector('#resourse_nameedit').style.display = "none";
            document.querySelector('#change_banner').style.display = "block";


        } else {
            document.querySelector('#resourse_nameedit').style.display = "none";
            document.querySelector('#change_cancel').style.display = "none";
            document.querySelector('#change_banner').style.display = "block";

        }

    }



    function changeimage1(e) {
        if (e.target.id == "change_banner1") {
            document.querySelector('#course_introductionedit').style.display = "block";
            document.querySelector('#change_cancel1').style.display = "block";
            document.querySelector('#change_banner1').style.display = "none";
        } else if (e.target.id == "change_cancel1") {
            document.querySelector('#change_cancel1').style.display = "none";
            document.querySelector('#course_introductionedit').style.display = "none";
            document.querySelector('#change_banner1').style.display = "block";


        } else {
            document.querySelector('#course_introductionedit').style.display = "none";
            document.querySelector('#change_cancel1').style.display = "none";
            document.querySelector('#change_banner1').style.display = "block";

        }

    }

    function changeimage2(e) {
        if (e.target.id == "change_banner2") {
            document.querySelector('#course_banneredit').style.display = "block";
            document.querySelector('#change_cancel2').style.display = "block";
            document.querySelector('#change_banner2').style.display = "none";
        } else if (e.target.id == "change_cancel2") {
            document.querySelector('#change_cancel2').style.display = "none";
            document.querySelector('#course_banneredit').style.display = "none";
            document.querySelector('#change_banner2').style.display = "block";


        } else {
            document.querySelector('#course_banneredit').style.display = "none";
            document.querySelector('#change_cancel2').style.display = "none";
            document.querySelector('#change_banner2').style.display = "block";

        }

    }

    function course_exam() {
        const course_exam = document.querySelector('.course_exam:checked');

        if (course_exam && course_exam.value === "1") {

            document.querySelector('.examname').style.display = "block";
            $('.exam_date').datepicker({
                dateFormat: 'dd-mm-yy',
                showButtonPanel: true,
                changeMonth: true,
                changeYear: true,
                // yearRange: '2023:2024',
                showOn: "button",
                buttonImage: `${base_url}/asset/image/calendar.png`,
                buttonImageOnly: true,
                minDate: 0,
                maxDate: '+30Y',
                inline: true
            })
        } else {
            document.querySelector('.examname').style.display = "none";

        }
    }
</script>
<script>
    function updateEndDate() {
        const startDateInput = document.getElementById('course_start_period');
        const endDateInput = document.getElementById('course_end_period');

        const startDate = new Date(startDateInput.value);
        const endDate = new Date(startDate.getTime() + (10 * 24 * 60 * 60 *
            1000)); // Adding 10 days (10 * 24 * 60 * 60 * 1000 milliseconds)

        endDateInput.value = endDate.toISOString().split('T')[0]; // Setting the value of the end date input

        // Enable the end date input
        endDateInput.disabled = false;
    }

    function no_period() {
        const course_exam = document.querySelector('.course_noperiod:checked');
        //alert(course_exam);

        if (course_exam && course_exam.value === "1") {

            // document.querySelector('.examname').style.display = "block";
            $('.startdate').prop('disabled', false);
            $('.enddate').prop('disabled', false);
            // $('.startdate').datepicker();
            // $('.enddate').datepicker();
            start_end_date();
            $('#exam_date').prop('readonly', true);
            $('.exam_date').datepicker('destroy');
            $('.exam_date').css('background', 'grey !important');
            // Remove any associated event handlers or bindings
            $('.exam_date').off();
            $('.exam_date').removeClass('ui-datepicker-trigger');

            // Remove the gray background color
            $('.startdate').css('background', '');
            $('.enddate').css('background', '');
        } else {
            // alert("bj");
            $('.startdate').datepicker('destroy');
            $('.startdate').css('background', 'grey !important');
            // Remove any associated event handlers or bindings
            $('.startdate').off();
            $('.startdate').removeClass('ui-datepicker-trigger');

            // Disable the form control
            $('.startdate').prop('disabled', true);
            $('.startdate').val('');
            $('.enddate').val('');

            $('.enddate').datepicker('destroy');

            // Remove any associated event handlers or bindings
            $('.enddate').off();
            $('.enddate').removeClass('ui-datepicker-trigger');

            // Disable the form control
            $('.enddate').prop('disabled', true);
            $('#exam_date').prop('readonly', false);
            document.querySelector("#exam_date").addEventListener("keypress", function(evt) {
                var charCode = evt.which || evt.keyCode;
                var charStr = String.fromCharCode(charCode);

                if (/[\d\.,\/;:`]/.test(charStr)) {
                    evt.preventDefault(); // Prevent entering the character
                }
            });

            enddatepicker();

        }
    }
    document.querySelector("[type='number']").addEventListener("keypress", function(evt) {
        if ((evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57) || (evt.which === 46)) {
            evt.preventDefault();
        }
    });
</script>

<!-- saranya -->
<script>
    function toggleButton() {
        var selectBox = document.getElementById("result");
        var button = document.getElementById("addClassButton");
        if (selectBox.value === "classlist") {
            button.style.display = "block";
        } else {
            button.style.display = "none";
        }
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const courseTypeSelect = document.getElementById('course_pay');
        const priceDiv = document.getElementById('paid');

        function togglePriceInput() {
            if (courseTypeSelect.value === 'paid') {
                priceDiv.style.display = 'block'; // Show input for Paid
            } else {
                priceDiv.style.display = 'none'; // Hide input for Free or empty
            }
        }

        // Run when the value changes
        courseTypeSelect.addEventListener('change', togglePriceInput);

        // Run on page load in case a value is already selected
        togglePriceInput();
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all radio buttons with name course_noperiod
        const radios = document.querySelectorAll('input[name="course_noperiod"]');
        const periodContainer = document.querySelector('.course_period_container');

        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === '1') { // Yes selected
                    periodContainer.style.display = 'flex'; // or 'block'
                } else { // No selected
                    periodContainer.style.display = 'none';
                }
            });
        });
    });
</script>



@endsection