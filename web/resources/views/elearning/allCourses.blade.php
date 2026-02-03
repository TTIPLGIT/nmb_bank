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

.modal-backdrop.show {
    opacity: 0 !important;
}

.modal-backdrop {
    pointer-events: none !important;
}

.open_modal {
    z-index: 99999 !important;
}

.open_modal_contents {
    pointer-events: auto !important;
}

#entered_pin {
    pointer-events: auto !important;
    background: #fff !important;
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

                    if ($value->certificate_expiry === '1' && !empty($value->course_expiry_period)) {
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
                                $expiryMessage = "⚠️Your course will expire soon ".$daysLeft."days";
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


                                        </h5>
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
                                        id="wish_{{$value->course_id}}" style="position: absolute;top: 12px;right: 12px;background: #fff;border-radius: 50%;padding: 6px;
                                              box-shadow: 0 2px 5px rgba(0,0,0,0.1); z-index: 5;">
                                        <i class="{{ $isWishlisted ? 'fa fa-heart' : 'fa fa-heart-o' }}"
                                            aria-hidden="true" id="wishHeart_{{$value->course_id}}"
                                            style="color: {{ $isWishlisted ? '#ff4b5c' : '#999' }}; font-size:18px;">
                                        </i>
                                    </span>

                                    {{-- 📘 Course Image --}}
                                    @php
                                    $id = Crypt::encrypt($value->course_id);

                                    $imageUrl = config('setting.base_url') . 'uploads/course/126/' .
                                    $value->course_banner;
                                    @endphp
                                    @if($value->restricted_access == 1)
                                    <a href="javascript:void(0)" onclick="openPinModal('{{ $id }}')">
                                        <img src="{{ asset('assets/images/Talentra.jpg') }}" alt="Fallback Image"
                                            class="course_image"
                                            style="width:100%;height:150px;object-fit:cover;border-radius:10px;margin-bottom:10px;"></a>
                                    @else
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
                                    @endif

                                    {{-- 🧾 Card Body --}}
                                    <div class="card-body" style="padding: 10px 0;">
                                        <div class="card-title" title="{{ $value->course_name }}">
                                            <h5
                                                style="color:#1e2a78; font-weight:600; font-size:16px; margin-bottom:8px;">
                                                {{ $value->course_name }}
                                            </h5>

                                            {{-- 🔔 Expiry Section with Fixed Height --}}
                                            <div
                                                style="min-height: 40px; display: flex; justify-content: center;align-items: center;margin-bottom: 8px">
                                                @if($showExpiryBadge)
                                                <a href="javascript:void(0);"
                                                    onclick="highlightCopiedCourse({{ $value->course_id }})">
                                                    <div
                                                        style="background-color: #fff5e6; color: #b35c00; border-radius: 6px;
                                                         font-size: 13px;padding:4px 8px;display:inline-block;box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                                        ⚠
                                                        {{ \Carbon\Carbon::parse($value->course_expiry_period)->isPast() ? 'Certificate Expired' : 'Your Course Will Expire Soon' }}
                                                    </div>
                                                </a>
                                                @elseif($expiryMessage)
                                                <a href="javascript:void(0);"
                                                    onclick="highlightCopiedCourse({{ $value->course_id }})">
                                                    <div style="background-color: #f8d7da;color: #721c24;border-radius: 8px;font-size:13px;padding:6px 12px;
                                                           margin-top:-10px;box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
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
                                                <span
                                                    style="float:right;background-color: {{ $value->course_pay == 'paid' ? '#1d33d3' : '#0ecf26' }};
                                                   color:#fff;border-radius:4px;padding:2px 8px; margin-top:-5px;font-size:18px;text-transform:capitalize;box-shadow:0 2px 4px rgba(0,0,0,0.1);">
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

                                        <span
                                            style="font-size:12px; color:#444; font-weight:500; display:block; margin-top:6px;">
                                            {{ isset($courseProgress[$value->course_id]) ? $courseProgress[$value->course_id]->course_progress : '0' }}%
                                            COMPLETED
                                        </span>
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

                        </div>
                    </div>
                    @endforeach

                    <div class="modal fade open_modal" id="pinModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content open_modal_contents">
                                <div class="modal-header">
                                    <h5 class="modal-title">🔐 Enter Course PIN</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <input type="password" id="entered_pin" class="form-control"
                                        placeholder="Enter PIN">
                                    <input type="hidden" id="pin_course_id">
                                    <div class="text-danger mt-2" id="pinError"></div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-primary" onclick="verifyPin()">Access Course</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                    $('#pinModal').on('shown.bs.modal', function() {
                        $('#entered_pin').trigger('focus');
                    });

                    function openPinModal(courseId) {

                        $('#pin_course_id').val(courseId);
                        $('#entered_pin').val('');
                        $('#pinError').hide();
                        $('#pinModal').modal('show');
                    }

                    function verifyPin() {
                        let pin = $('#entered_pin').val();
                        let courseId = $('#pin_course_id').val();

                        if (pin == '') {
                            $('#pinError').text('Please enter PIN').show();
                            return;
                        }

                        $.ajax({
                            url: "{{ route('verify.course.pin') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                course_id: courseId,
                                pin: pin
                            },
                            success: function(res) {
                                if (res.status == true) {
                                    window.location.href = res.redirect;
                                } else {
                                    $('#pinError').text('Invalid PIN').show();
                                }
                            }
                        });
                    }
                    </script>

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

<!-- Filters Modal -->
<div class="modal fade" id="filters" tabindex="-1" aria-labelledby="filtersLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal_filters">
            <div class="modal-header filters_header">
                <h5 class="modal-title" id="filtersLabel">Filters</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 filters_body">
                <div class="d-flex flex-row flex-wrap justify-content-between all_courses_filter_container w-100 m-0">
                    <select class="form-control all_courses_sort_select w-50 mb-3" name="all_courses_sort_select">
                        <option value="Recently Added" selected>Recently Added</option>
                        <option value="Recently Enrolled">Recently Enrolled</option>
                        <option value="A to Z">A to Z</option>
                        <option value="Z to A">Z to A</option>
                    </select>
                    <select class="form-control all_courses_filter_select m-0 mb-3" name="all_courses_filter_select">
                        <option selected>Category</option>
                        <option value="Survey and Mapping">Survey and Mapping</option>
                        <option value="Land Registration">Land Registration</option>
                        <option value="Land Administration">Land Administration</option>
                        <option value="Valuation">Valuation</option>
                    </select>
                    <select class="form-control all_courses_filter_select w-50 m-0 mb-3"
                        name="all_courses_filter_select">
                        <option selected>Progress</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Completed">Completed</option>
                        <option value="Not Enrolled">Not Enrolled</option>
                    </select>
                    <button class="all_courses_reset_btn mx-auto mb-3" type="button" disabled>
                        <span>Reset</span>
                    </button>
                    <div class="all_courses_search_container w-100">
                        <form class="d-flex flex-row justify-content-center align-items-center" action="#" method="get">
                            <input type="search" class="form-control" placeholder="Search">
                            <button type="submit">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection