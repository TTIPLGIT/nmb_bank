@extends('layouts.elearningmain')

@section('content')
<style>
/* ========== YOUR EXISTING STYLES (PRESERVED & ENHANCED) ========== */
/* Add to your existing styles */
.modal-backdrop {
    z-index: 1040 !important;
}

.modal {
    z-index: 1050 !important;
}

#eventDetailModal .modal-content {
    border-radius: 24px;
    overflow: hidden;
    border: none;
}

.noShadow .card-body {
    box-shadow: none !important;
}

.card {
    box-shadow: none !important;
}

.main-content {
    padding-top: 80px !important;
}

.overview_header {
    margin: 0px 0.5rem !important;
}

.overview_heading {
    color: #000000;
    font-weight: 900;
    font-size: 1.5rem !important;
}

.overview_filter {
    border: 0px !important;
    border-radius: 5px !important;
    padding: 5px !important;
    font-weight: 600 !important;
    font-size: 1rem !important;
    letter-spacing: 2px !important;
    width: fit-content !important;
    padding-right: 7% !important;
}

.overview_filter .dropdown-menu {
    width: fit-content !important;
}

.overview_body {
    flex-wrap: wrap !important;
}

.overview_body .card {
    width: 100% !important;
    border: 0px !important;
    margin-top: 0.5rem !important;
    margin-bottom: 0.5rem !important;
    margin-left: 0.5rem !important;
    margin-right: 0.5rem !important;
    border-radius: 5px !important;
}

.overview_body .card-header {
    color: #680EDA !important;
    background-color: white !important;
    font-weight: 600 !important;
    padding-left: 1rem !important;
    border-bottom: 0px solid white !important;
    padding-bottom: 0px !important;
    min-height: 31px !important;
    border-top-left-radius: 5px !important;
    border-top-right-radius: 5px !important;
}

.overview_body .card-body {
    padding: 10px 10px !important;
    border-top: 0px solid white !important;
    background-color: white !important;
    border-radius: 10px;
}

.overview_count {
    padding-left: 5% !important;
    font-size: 1.5rem !important;
    color: #000 !important;
    font-weight: 900 !important;
    text-align: center !important;
}

.overview_img {
    width: 45% !important;
}

.overview_img#overview_img_exception {
    margin: 0.6rem !important;
}

.course {
    width: 100% !important;
    height: 394px !important;
    border: 0px !important;
    padding: 0px !important;
    border-radius: 15px !important;
}

.course_heading {
    color: #680EDA;
    font-weight: 900;
    font-size: 1rem !important;
    width: fit-content !important;
}

.course_filter {
    border: 0px !important;
    border-radius: 5px !important;
    padding: 5px !important;
    font-weight: 600 !important;
    font-size: 1rem !important;
    letter-spacing: 2px !important;
    width: fit-content !important;
    padding-right: 7% !important;
}

.course_filter .dropdown-menu {
    width: fit-content !important;
}

.course .card-header {
    width: 100% !important;
    height: 50px !important;
    background-color: white !important;
    border-top-left-radius: 15px !important;
    border-top-right-radius: 15px !important;
}

.course .card-body {
    width: 100% !important;
    height: 344px;
    border-radius: 15px !important;
    background-color: white !important;
    border-top-left-radius: 0px !important;
    border-top-right-radius: 0px !important;
}

.course_and_schedule_body {
    flex-wrap: wrap !important;
    width: 100% !important;
}

.schedule {
    width: 100% !important;
    height: auto !important;
    min-height: 500px !important;
    border: 0px !important;
    margin-top: 0.5rem !important;
    margin-bottom: 0.5rem !important;
    margin-left: 0.5rem !important;
    margin-right: 0.5rem !important;
    border-radius: 5px !important;
    overflow: hidden !important;
}

.schedule_heading {
    color: #000000;
    font-weight: 900;
    font-size: 1rem !important;
    width: fit-content !important;
}

.schedule .card-header {
    width: 100% !important;
    height: 50px !important;
    padding: 0px 0px 7px 0px !important;
    background-color: #f8f9fc !important;
    border-top-left-radius: 5px !important;
    border-top-right-radius: 5px !important;
}

.schedule .card-body {
    width: 100% !important;
    background-color: white !important;
    border-radius: 15px !important;
    overflow: hidden !important;
    display: flex;
    flex-wrap: wrap;
}

.group_lessons,
.recommended_courses_list,
.notice_board_list {
    width: 100% !important;
    border: 0px !important;
    padding: 0px !important;
    border-radius: 15px !important;
    overflow: hidden !important;
}

.group_lessons .card-header,
.recommended_courses_list .card-header,
.notice_board_list .card-header {
    width: 100% !important;
    height: 71px !important;
    color: #680EDA;
    font-weight: 900;
    font-size: 1.5rem !important;
    background-color: white !important;
    border-bottom-left-radius: 0px !important;
    border-bottom-right-radius: 0px !important;
    border-radius: 15px;
    text-align: center;
}

.group_lessons .card-body,
.recommended_courses_list .card-body,
.notice_board_list .card-body {
    width: 100% !important;
    height: 324px !important;
    border: 0px !important;
    background-color: white !important;
    border-radius: 5px !important;
}

/* Calendar Styles - Enhanced */
.calendar-container {
    position: relative;
    border-radius: 10px;
    width: 50%;
    min-height: 344px;
    background: #fff;
    padding: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

#dycalendar {
    width: 100%;
    padding: 5px 5px 0px 5px;
    border: 0px !important;
    user-select: none;
}

#dycalendar .dycalendar-body {
    margin-bottom: 0px !important;
}

#dycalendar table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 8px !important;
}

.dycalendar-month-container .dycalendar-body table tr td {
    padding: 8px 6px;
    color: #4a5568;
    border: 1px solid #e9ecef;
    border-radius: 12px !important;
    cursor: pointer;
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.2s ease;
    background: #f8fafc;
    text-align: center;
}

.dycalendar-month-container .dycalendar-body table tr td:hover {
    background: #f0eefe;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(104, 14, 218, 0.15);
    border-color: #680EDA;
}

#dycalendar table tr:first-child td {
    color: #fff;
    background-color: #680EDA;
    font-weight: 700;
    box-shadow: none;
    border: none;
    border-radius: 12px !important;
}

#dycalendar table tr:first-child td:first-child {
    background-color: #FF8B4F;
}

#dycalendar table tr td:first-child {
    color: #FF8B4F;
}

.dycalendar-today-date,
.dycalendar-today-date:hover {
    background: linear-gradient(135deg, #680EDA, #9b4dff) !important;
    color: white !important;
    box-shadow: 0 4px 12px rgba(104, 14, 218, 0.3) !important;
    border: none !important;
    font-weight: 700 !important;
}

.dycalendar-header {
    width: 100%;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    padding: 10px 15px !important;
    background: #fff;
    border-bottom: 1px solid #f0f0f0;
}

.dycalendar-prev-next-btn {
    position: static !important;
    color: #680EDA;
    padding: 0px 10px;
    cursor: pointer !important;
    font-size: 1.5rem;
    font-weight: 500;
    transition: all 0.2s;
}

.dycalendar-prev-next-btn:hover {
    color: #9b4dff;
    transform: scale(1.1);
}

.dycalendar-span-month-year {
    font-size: 1.2rem;
    font-weight: 700;
    color: #1e293b;
    letter-spacing: 0.5px;
}

/* ========== ENHANCED NOTICEBOARD STYLES ========== */
.notice-board-modern {
    background: #ffffff;
    border-radius: 24px;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    margin-bottom: 1.25rem;
    box-shadow: 0 2px 12px rgba(104, 14, 218, 0.06);
    border: 1px solid rgba(104, 14, 218, 0.08);
}

.notice-board-modern:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 30px -12px rgba(104, 14, 218, 0.15);
    border-color: rgba(104, 14, 218, 0.2);
}

.notice-inner-wrapper {
    display: flex;
    gap: 1.25rem;
    padding: 1.25rem;
    align-items: center;
    flex-wrap: wrap;
}

.notice-image-container {
    flex-shrink: 0;
    width: 120px;
    height: 120px;
    border-radius: 20px;
    overflow: hidden;
    background: linear-gradient(135deg, #f5f3ff, #ede9fe);
    cursor: pointer;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 6px 14px rgba(104, 14, 218, 0.08);
}

.notice-image-container:hover {
    transform: scale(1.03);
    box-shadow: 0 12px 24px rgba(104, 14, 218, 0.15);
}

.notice-image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.notice-image-container:hover img {
    transform: scale(1.05);
}

.notice-content-area {
    flex: 1;
    min-width: 200px;
}

.notice-title-section {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
    margin-bottom: 0.5rem;
}

.notice-title {
    font-size: 1.1rem;
    font-weight: 800;
    color: #1e293b;
    margin: 0;
    letter-spacing: -0.2px;
    line-height: 1.4;
}

.notice-badge-new {
    background: linear-gradient(135deg, #680EDA, #9b4dff);
    color: white;
    font-size: 0.65rem;
    padding: 3px 10px;
    border-radius: 30px;
    font-weight: 600;
    letter-spacing: 0.3px;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        opacity: 1;
        transform: scale(1);
    }

    50% {
        opacity: 0.8;
        transform: scale(0.98);
    }

    100% {
        opacity: 1;
        transform: scale(1);
    }
}

.notice-date-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #f8fafc;
    padding: 5px 12px;
    border-radius: 30px;
    font-size: 0.75rem;
    color: #475569;
    margin-bottom: 0.75rem;
    border: 1px solid #e2e8f0;
}

.notice-description-preview {
    color: #475569;
    font-size: 0.85rem;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 0.75rem;
}

.notice-action-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: transparent;
    border: 1.5px solid #e2e8f0;
    padding: 6px 20px;
    border-radius: 40px;
    font-size: 0.75rem;
    font-weight: 600;
    color: #680EDA;
    transition: all 0.2s;
    cursor: pointer;
}

.notice-action-btn:hover {
    background: #680EDA;
    color: white;
    border-color: #680EDA;
    transform: translateX(3px);
}

/* ========== ENHANCED EVENTS SECTION STYLES ========== */
.events-modern-container {
    background: #ffffff;
    border-radius: 24px;
    padding: 1.25rem;
    box-shadow: 0 8px 24px rgba(104, 14, 218, 0.06);
    height: 100%;
    display: flex;
    flex-direction: column;
    border: 1px solid rgba(104, 14, 218, 0.1);
}

.events-header {
    border-bottom: 2px solid #f1eefc;
    padding-bottom: 0.75rem;
    margin-bottom: 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}

.events-header h4 {
    font-weight: 800;
    background: linear-gradient(135deg, #680EDA, #9b4dff);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    margin: 0;
    font-size: 1.2rem;
    display: flex;
    align-items: center;
    gap: 8px;
}

.events-header h4 i {
    background: none;
    color: #680EDA;
}

.events-count-badge {
    background: #f0eef8;
    color: #680EDA;
    padding: 4px 12px;
    border-radius: 40px;
    font-size: 0.75rem;
    font-weight: 600;
}

.events-marquee-wrapper {
    flex: 1;
    overflow: hidden;
    position: relative;
    min-height: 380px;
    border-radius: 16px;
}

.events-marquee-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
    will-change: transform;
}

.event-card-modern {
    background: white;
    border-radius: 18px;
    transition: all 0.25s;
    border: 1px solid #f0edfa;
    cursor: pointer;
}

.event-card-modern:hover {
    border-color: #d9ceff;
    transform: translateX(4px);
    box-shadow: 0 8px 20px rgba(104, 14, 218, 0.12);
    background: #fefbff;
}

.event-card-link {
    display: flex !important;
    gap: 14px;
    align-items: center;
    padding: 12px 16px !important;
    text-decoration: none;
}

.event-card-image {
    width: 60px !important;
    height: 60px !important;
    border-radius: 16px !important;
    object-fit: cover;
    background: #f5f3ff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.event-card-details {
    flex: 1;
}

.event-card-name {
    font-weight: 700;
    color: #1e293b;
    font-size: 0.9rem;
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
}

.event-type-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
    animation: pulse 1.5s infinite;
}

.event-card-time {
    font-size: 0.7rem;
    color: #6c757d;
    display: flex;
    align-items: center;
    gap: 5px;
}

/* No Events State */
.no-events-modern {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 2.5rem 1rem;
    background: #faf9ff;
    border-radius: 20px;
}

.no-events-modern i {
    font-size: 2.5rem;
    color: #680EDA;
    opacity: 0.5;
    margin-bottom: 1rem;
}

/* Empty Notice State */
.empty-notice-state {
    text-align: center;
    padding: 2.5rem;
    background: #faf9ff;
    border-radius: 24px;
}

.empty-notice-state i {
    font-size: 2.5rem;
    color: #680EDA;
    opacity: 0.5;
    margin-bottom: 1rem;
}

/* Marquee Animation - Optimized */
@keyframes smooth-marquee {
    0% {
        transform: translateY(0);
    }

    100% {
        transform: translateY(calc(-100% + 80px));
    }
}

/* Loading Skeleton */
.loading-skeleton {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
    border-radius: 12px;
}

@keyframes loading {
    0% {
        background-position: 200% 0;
    }

    100% {
        background-position: -200% 0;
    }
}

/* Course Card Styles - Enhanced */
.course-card {
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    border: 1px solid #f0f0f0;
}

.course-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 30px -12px rgba(104, 14, 218, 0.2) !important;
    border-color: rgba(104, 14, 218, 0.2);
}

.card-span {
    color: #680EDA !important;
    font-size: 12px;
    font-weight: bold;
}

.highlighted-date {
    background: linear-gradient(135deg, #680EDA, #9b4dff) !important;
    color: white !important;
    font-weight: bold !important;
    transform: scale(1.02);
}

/* Event Modal Styles */
.event-modal-image {
    max-width: 100%;
    max-height: 400px;
    object-fit: cover;
    border-radius: 16px;
    margin-bottom: 1rem;
}

/* Responsive Styles */
@media (min-width: 320px) and (max-width: 575px) {
    .calendar-container {
        width: 100%;
        min-height: auto;
    }

    .dycalendar-month-container .dycalendar-body table tr td {
        padding: 6px 2px;
        font-size: 0.7rem;
    }

    .dycalendar-header {
        padding: 8px 10px !important;
    }

    .dycalendar-span-month-year {
        font-size: 1rem;
    }

    .schedule .card-body {
        flex-direction: column !important;
        gap: 20px;
    }

    .main-content {
        padding-right: 12px;
        padding-left: 12px !important;
        padding-top: 80px !important;
        width: 100% !important;
    }

    .notice-inner-wrapper {
        flex-direction: column;
        align-items: flex-start;
        padding: 1rem;
    }

    .notice-image-container {
        width: 100%;
        height: 160px;
    }

    .notice-action-btn {
        width: 100%;
        justify-content: center;
    }

    .events-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
}

@media (min-width: 576px) and (max-width: 767px) {
    .schedule .card-body {
        flex-direction: column !important;
    }

    .calendar-container {
        width: 100%;
    }

    .events_today_wrapper {
        margin-top: 20px !important;
        width: 100%;
    }

    .notice-inner-wrapper {
        gap: 1rem;
    }

    .notice-image-container {
        width: 100px;
        height: 100px;
    }
}

@media (min-width: 768px) and (max-width: 1023px) {
    .schedule .card-body {
        flex-direction: row !important;
        gap: 20px;
    }

    .calendar-container {
        flex: 0 0 48%;
    }

    .events_today_wrapper {
        flex: 0 0 48%;
    }

    .notice-image-container {
        width: 100px;
        height: 100px;
    }
}

@media (min-width: 1024px) {
    .main-content {
        padding-top: 50px !important;
        padding-left: 200px !important;
    }

    .sidebar-mini .main-content {
        padding-left: 85px !important;
    }

    .schedule {
        width: 100% !important;
    }

    .schedule .card-body {
        flex-direction: row !important;
        gap: 24px;
    }

    .calendar-container {
        flex: 0 0 48%;
    }

    .events_today_wrapper {
        flex: 0 0 48%;
    }

    .overview_body .card {
        width: 23% !important;
    }

    .notice-board-modern {
        margin-bottom: 1.25rem;
    }
}

@media (min-width: 1440px) {
    .main-content {
        padding-top: 80px !important;
        padding-left: 211px !important;
    }
}

/* Loading Spinner */
.loading-spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 2px solid rgba(104, 14, 218, 0.2);
    border-top-color: #680EDA;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

/* Modal Enhancements */
.modal-content {
    border-radius: 24px;
    overflow: hidden;
    border: none;
}

.modal-header {
    border-bottom: 1px solid #f0eef8;
}

.modal-footer {
    border-top: 1px solid #f0eef8;
}

#noticeDetailImage {
    border-radius: 20px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}
</style>

<link href="{{asset('assets/css/jquery.fancybox.min.css')}}" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="{{ asset('assets/css/jquery.fancybox.min.js') }}"></script>

<div class="main-content contentpadding" style="min-height: 498px;">
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

    <div class="section-body mt-1">
        <div class="overview_container container-fluid">
            <div class="overview_header d-flex flex-row justify-content-between align-items-center"></div>

            <!-- Overview Cards - Enhanced with hover effects -->
            <div class="container-fluid d-flex flex-row justify-content-sm-start overview_body"
                style="display: flex !important; justify-content: space-between !important;">
                <div class="card noShadow" style="transition: transform 0.2s; cursor: pointer;">
                    <div class="card-body d-flex" style="align-items:center">
                        <div style="width:40%">
                            <img class="overview_img" id="overview_img_exception"
                                src="{{asset('asset/image/progresscourse.png')}}" alt="Course in Progress" width="40%">
                        </div>
                        <div class="justify-content-between align-items-center">
                            <span
                                class="overview_count">{{$count['course_progress'][0]['course_progress'] ?? 0}}</span><br>
                            <span class="card-span">Course in Progress</span>
                        </div>
                    </div>
                </div>
                <div class="card noShadow" style="transition: transform 0.2s; cursor: pointer;">
                    <div class="card-body d-flex" style="align-items:center">
                        <div style="width:40%">
                            <img class="overview_img" id="overview_img_exception"
                                src="{{asset('asset/image/completed.png')}}" alt="Course Completed" width="40%">
                        </div>
                        <div class="justify-content-between align-items-center">
                            <span
                                class="overview_count">{{$count['course_completed'][0]['course_completed'] ?? 0}}</span><br>
                            <span class="card-span">Course Completed</span>
                        </div>
                    </div>
                </div>
                <div class="card noShadow" style="transition: transform 0.2s; cursor: pointer;">
                    <div class="card-body d-flex" style="align-items:center">
                        <div style="width:40%">
                            <img class="overview_img" id="overview_img_exception"
                                src="{{asset('asset/image/awards.png')}}" alt="Certificates Achieved" width="40%">
                        </div>
                        <div class="justify-content-between align-items-center">
                            <span
                                class="overview_count">{{$count['course_certificate'][0]['course_certificate'] ?? 0}}</span><br>
                            <span class="card-span">Certificates Earned</span>
                        </div>
                    </div>
                </div>
                <div class="card noShadow" style="transition: transform 0.2s; cursor: pointer;">
                    <div class="card-body d-flex" style="align-items:center">
                        <div style="width:40%">
                            <img class="overview_img" id="overview_img_exception"
                                src="{{asset('asset/image/trophy.png')}}" alt="Credits Earned" width="40%">
                        </div>
                        <div class="justify-content-between align-items-center">
                            <span class="overview_count">{{ $total_cpd_points['total_points'] ?? 0 }}</span><br>
                            <span class="card-span">Credits Earned</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calendar + Events Section -->
            <div class="container-fluid course_and_schedule_container">
                <div class="d-flex flex-row course_and_schedule_body w-100">
                    <div class="card noShadow schedule" style="width: 100% !important;">
                        <div class="card-body">
                            <div class="calendar-container">
                                <div id="dycalendar" class="dycalendar-container"></div>
                            </div>
                            <div class="events_today_wrapper">
                                <!-- Events will be loaded dynamically with loading state -->
                                <div class="events-modern-container loading-skeleton" style="min-height: 380px;">
                                    <div class="events-header">
                                        <h4><i class="fas fa-calendar-alt"></i> Loading Events...</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recommended Courses Section - Enhanced -->
            <div class="container-fluid course_and_schedule_container" style="margin-top:2%;margin-bottom:2%">
                <div class="card course_and_schedule_container"
                    style="background-color:white;border-radius:24px !important; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
                    <div class="noShadow recommended_courses_list" style="height: auto !important;">
                        <div class="d-flex mb-4 mt-4">
                            <div style="width:100%;text-align:center">
                                <h5 class="section-title" style="color:#680EDA; font-weight:800; font-size: 1.5rem;">
                                    <i class="fas fa-robot" style="color:#680EDA;"></i> Recommended for You
                                </h5>
                                <p class="section-subtitle" style="color:#6c757d; font-size:0.9rem;">
                                    <i class="fas fa-chart-line" style="color:#dc3545;"></i> Courses picked based on
                                    your activity and interests
                                </p>
                            </div>
                        </div>

                        <div class="row" style="padding: 0 20px 20px 20px;">
                            @if(empty($recommendations['recommendations']))
                            <div class="col-12">
                                <div
                                    style="text-align: center; padding: 3rem; background: #faf9ff; border-radius: 24px;">
                                    <i class="fas fa-compass"
                                        style="font-size: 3rem; color: #680EDA; opacity: 0.6;"></i>
                                    <h5 style="margin-top: 1rem; color: #1e293b; font-weight: 600;">No recommendations
                                        yet</h5>
                                    <p style="color: #64748b;">Complete more courses to see personalized recommendations
                                    </p>
                                </div>
                            </div>
                            @else
                            @foreach($recommendations['recommendations'] as $index => $row)
                            @php
                            $badgeIcon = match($row['recommendation_type'] ?? 'recommended') {
                            'next_level' => '🚀',
                            'skill_gap' => '📚',
                            'popular' => '🔥',
                            'trending' => '📈',
                            default => '✨'
                            };
                            $confidencePercent = round($row['confidence_score'] * 100);
                            $course_name = DB::table('elearning_courses')->where('course_id',
                            $row['recommended_course_id'])->first();
                            @endphp
                            <div class="col-md-6 col-lg-3 mb-4">
                                <div class="course-card">
                                    <div
                                        style="padding:12px 16px; background:#fafafa; border-bottom:1px solid #f0f0f0; display:flex; justify-content:space-between; align-items:center;">
                                        <span
                                            style="background:#e8f0ff; color:#0066cc; padding:4px 12px; border-radius:20px; font-size:0.7rem; font-weight:500;">
                                            {{ $badgeIcon }}
                                            {{ ucfirst(str_replace('_', ' ', $row['recommendation_type'] ?? 'recommended')) }}
                                        </span>
                                        <span style="font-size:0.7rem; color:#6c757d;"><i
                                                class="fas fa-chart-simple"></i> AI Match:
                                            {{ $confidencePercent }}%</span>
                                    </div>
                                    <div style="padding: 1.25rem; flex: 1;">
                                        <h6
                                            style="font-weight: 700; font-size: 1rem; margin-bottom: 0.75rem; color: #1e293b; line-height: 1.4;">
                                            {{ $course_name->course_name ?? 'Course' }}
                                        </h6>
                                        <div style="margin: 0.75rem 0 1rem 0;">
                                            <div
                                                style="display: flex; justify-content: space-between; font-size: 0.7rem; margin-bottom: 6px;">
                                                <span style="color: #680EDA;"><i class="fas fa-brain"></i> Match
                                                    Score</span>
                                                <span
                                                    style="font-weight: 700; color: #680EDA;">{{ $confidencePercent }}%</span>
                                            </div>
                                            <div
                                                style="background: #e9ecef; border-radius: 10px; height: 8px; overflow: hidden;">
                                                <div
                                                    style="width: {{ $confidencePercent }}%; background: linear-gradient(90deg, #680EDA, #9b4dff); height: 100%; border-radius: 10px;">
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            style="background: #f8fafc; padding: 0.75rem; border-radius: 16px; border-left: 3px solid #680EDA;">
                                            <i class="fas fa-lightbulb" style="color: #680EDA; font-size: 0.7rem;"></i>
                                            <span
                                                style="font-size: 0.75rem; color: #475569; margin-left: 6px;">{{ $row['reason'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Notice Board -->
            <div class="container-fluid noticess course_and_schedule_container" style="margin-top:2%; margin-bottom:2%">
                <div class="d-flex flex-row course_and_schedule_body w-100">
                    <div class="card noShadow notice_board_list"
                        style="width:100% !important; background: transparent; border: none; height: auto !important;">
                        <div class="card-header bg-transparent border-0"
                            style="background:transparent !important; padding: 1.5rem 1.5rem 0 1.5rem;">
                            <h5 style="font-weight: 800; color: #680EDA; margin-bottom: 0; font-size: 1.4rem;">
                                <i class="fas fa-bullhorn me-2"></i> Announcements & Updates
                            </h5>

                        </div>
                        <div class="card-body" style="height: auto !important; padding: 1.5rem;">
                            @if(count($rows) == 0)
                            <div class="empty-notice-state">
                                <i class="fas fa-newspaper fa-3x mb-3"></i>
                                <h6 style="color: #680EDA; font-weight: 600;">No Announcements</h6>
                                <p class="small text-muted mb-0">Check back later for updates</p>
                            </div>
                            @else
                            @foreach($rows as $key => $row)
                            <div class="notice-board-modern">
                                <div class="notice-inner-wrapper">
                                    <div class="notice-image-container"
                                        onclick="openNoticeFancy('{{ $row['notice_path'] }}/{{ $row['notice_banner'] }}', '{!! addslashes(html_entity_decode($row['notice_description'])) !!}')">
                                        @php $path = $row['notice_path'] . '/' . $row['notice_banner']; @endphp
                                        @if(file_exists(substr($path, 1)))
                                        <img src="{{ $row['notice_path'] }}/{{ $row['notice_banner'] }}"
                                            alt="{{ $row['notice_name'] }}"
                                            onerror="this.src='{{asset('asset/image/empty.jpg')}}'">
                                        @else
                                        <img src="{{ asset('asset/image/empty.jpg') }}" alt="Notice">
                                        @endif
                                    </div>
                                    <div class="notice-content-area">
                                        <div class="notice-title-section">
                                            <h6 class="notice-title">{{ $row['notice_name'] }}</h6>
                                            @if($key < 3) <span class="notice-badge-new"><i
                                                    class="fas fa-star-of-life"></i> NEW</span>
                                                @endif
                                        </div>
                                        <div class="notice-date-chip">
                                            <i class="far fa-calendar-alt"></i>
                                            {{ \Carbon\Carbon::parse($row['notice_date'])->format('M d, Y') }}
                                        </div>
                                        <div class="notice-description-preview">
                                            {!! Str::limit(strip_tags(html_entity_decode($row['notice_description'])),
                                            120) !!}
                                        </div>
                                        <button class="notice-action-btn"
                                            onclick="openNoticeDetail('{{ addslashes($row['notice_name']) }}', '{{ \Carbon\Carbon::parse($row['notice_date'])->format('F d, Y') }}', '{!! addslashes(html_entity_decode($row['notice_description'])) !!}', '{{ $row['notice_path'] }}/{{ $row['notice_banner'] }}')">
                                            Read More <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fancy Modal for Images -->
<div class="modal fade" id="fancyContainer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="fancyContainerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content" style="background: transparent !important; border: none;">
            <div class="modal-header" style="background: white; border-radius: 20px 20px 0 0; border-bottom: none;">
                <button type="button" class="btn-close" onclick="removefancy()"></button>
            </div>
            <div class="modal-body" style="background: white; border-radius: 0 0 20px 20px; padding: 20px;"
                id="fancyWrapper">
                <div id="fancyControls" class="carousel slide">
                    <button class="carousel-control-prev" type="button" data-bs-target="#fancyControls"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"
                            style="background-color: #680EDA; border-radius: 50%; padding: 20px;"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#fancyControls"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"
                            style="background-color: #680EDA; border-radius: 50%; padding: 20px;"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Event Detail Modal -->
<div class="modal fade" id="eventDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header"
                style="background: linear-gradient(135deg, #680EDA, #9b4dff); color: white; border: none;">
                <h5 class="modal-title"><i class="fas fa-calendar-alt me-2"></i>Event Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 1.5rem;">
                <div class="text-center mb-4">
                    <img id="eventDetailImage" src=""
                        style="max-width: 100%; max-height: 350px; border-radius: 20px; object-fit: cover; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                </div>
                <h4 id="eventDetailName" class="fw-bold mb-3" style="color: #1e293b;"></h4>
                <div class="mb-3">
                    <i class="far fa-clock me-2" style="color: #680EDA;"></i>
                    <span id="eventDetailTime" style="color: #475569; font-weight: 500;"></span>
                </div>
                <div class="mt-3">
                    <h6 style="color: #680EDA; font-weight: 700; margin-bottom: 0.75rem;">
                        <i class="fas fa-info-circle me-2"></i>Description
                    </h6>
                    <p id="eventDetailDescription" style="line-height: 1.7; color: #334155; font-size: 1rem;"></p>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #f0eef8;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    style="border-radius: 30px; padding: 8px 24px;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal for Notices - Enhanced -->
<div class="modal fade" id="noticeDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header"
                style="background: linear-gradient(135deg, #680EDA, #9b4dff); color: white; border: none;">
                <h5 class="modal-title" id="noticeDetailTitle"><i class="fas fa-info-circle me-2"></i>Notice Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 1.5rem;">
                <div class="text-center mb-4">
                    <img id="noticeDetailImage" src=""
                        style="max-width: 100%; max-height: 300px; border-radius: 20px; object-fit: cover; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                </div>
                <h6 id="noticeDetailName" class="fw-bold mb-2" style="color: #1e293b; font-size: 1.3rem;"></h6>
                <p class="text-muted small mb-3"><i class="far fa-calendar-alt me-2"></i> <span
                        id="noticeDetailDate"></span>
                </p>
                <div id="noticeDetailDescription" style="line-height: 1.7; color: #334155; font-size: 1rem;"></div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #f0eef8;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    style="border-radius: 30px;">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="{{ asset('asset/js/calender.js') }}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<script>
// ========== GLOBAL FUNCTIONS ==========
let currentAnimationInterval = null;

function removefancy() {
    $('#fancyContainer').modal('hide');
    let fancycontrols = document.querySelector('#fancyControls');
    if (fancycontrols && fancycontrols.firstChild) {
        while (fancycontrols.firstChild) {
            fancycontrols.removeChild(fancycontrols.firstChild);
        }
    }
}

function openNoticeFancy(imgSrc, description) {
    const modalBodyInner = document.querySelector('#fancyControls');
    if (modalBodyInner) {
        let innerDiv = document.createElement('div');
        innerDiv.classList.add('carousel-inner');
        innerDiv.innerHTML = `
            <div class="carousel-item active">
                <img src="${imgSrc}" style="width:100%; max-height:70vh; object-fit:contain; border-radius: 16px;">
                <div class="p-4 text-center" style="background: white; border-radius: 16px; margin-top: 15px;">${description || 'No additional description'}</div>
            </div>
        `;
        const existing = document.querySelector('#fancyContainerInner');
        if (existing) existing.remove();
        innerDiv.id = 'fancyContainerInner';
        modalBodyInner.prepend(innerDiv);
        $('#fancyContainer').modal('show');
    }
}

function openNoticeDetail(title, date, description, imgSrc) {
    $('#noticeDetailTitle').text(title);
    $('#noticeDetailName').text(title);
    $('#noticeDetailDate').text(date);
    $('#noticeDetailDescription').html(description || 'No additional details available.');
    $('#noticeDetailImage').attr('src', imgSrc);
    $('#noticeDetailModal').modal('show');
}

// NEW FUNCTION: Open Event Detail Modal

function openEventDetail(imgSrc, name, description, time) {
    console.log('Opening event modal:', {
        imgSrc,
        name,
        description,
        time
    });

    try {
        // Set modal content
        $('#eventDetailName').text(name || 'Event Details');
        $('#eventDetailTime').text(time || 'Time not specified');
        $('#eventDetailDescription').html(description || 'No additional details available.');

        // Set image with fallback
        const imageElement = $('#eventDetailImage');
        imageElement.attr('src', imgSrc);

        // Handle image load error
        imageElement.off('error').on('error', function() {
            $(this).attr('src', '/asset/image/empty.jpg');
        });

        // Show modal using jQuery (works with Bootstrap 4 and 5)
        $('#eventDetailModal').modal('show');

    } catch (error) {
        console.error('Error opening event modal:', error);
        // Fallback alert for debugging
        alert('Event: ' + name + '\nTime: ' + time + '\n\n' + description);
    }
}

function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

function formatDisplayDate(dateStr) {
    if (!dateStr || dateStr === 'Invalid Date') return 'Invalid Date';
    const parts = dateStr.split('-');
    if (parts.length === 3) {
        const day = parts[0];
        const month = parts[1];
        const year = parts[2];
        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const monthIndex = parseInt(month) - 1;
        return `${monthNames[monthIndex]} ${day}, ${year}`;
    }
    return dateStr;
}

function displayEventsMarquee(events, title) {
    const wrapperDiv = $('.events_today_wrapper');

    if (!events || events.length === 0) {
        wrapperDiv.html(`
            <div class="events-modern-container">
                <div class="events-header">
                    <h4><i class="fas fa-calendar-alt"></i> ${escapeHtml(title)}</h4>
                    <span class="events-count-badge">0 events</span>
                </div>
                <div class="no-events-modern">
                    <i class="far fa-calendar-times"></i>
                    <p class="mb-0">No events scheduled</p>
                    <small class="text-muted">Select a date to view events</small>
                </div>
            </div>
        `);
        return;
    }

    let eventsHtml = `
        <div class="events-modern-container">
            <div class="events-header">
                <h4><i class="fas fa-calendar-alt"></i> ${escapeHtml(title)}</h4>
                <span class="events-count-badge">${events.length} event${events.length > 1 ? 's' : ''}</span>
            </div>
            <div class="events-marquee-wrapper">
                <div class="events-marquee-list">
    `;

    const eventTypeColors = ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7', '#DDA0DD'];

    events.forEach((ev, idx) => {
        let imagePath = '/asset/image/empty.jpg';
        if (ev.event_image && ev.event_image !== '/empty.jpg') {
            imagePath = ev.event_image.startsWith('/') ? ev.event_image :
                `/uploads/notice/126/${ev.event_image}`;
        }

        const typeColor = eventTypeColors[idx % eventTypeColors.length];

        // Store data in data attributes
        const eventName = escapeHtml(ev.event_name || 'Event');
        const eventTime = escapeHtml(ev.event_time || 'All Day');
        const eventDesc = escapeHtml(ev.event_description || '');

        eventsHtml += `
            <div class="event-card-modern" 
                 data-event-name="${eventName.replace(/"/g, '&quot;')}" 
                 data-event-time="${eventTime.replace(/"/g, '&quot;')}" 
                 data-event-desc="${eventDesc.replace(/"/g, '&quot;')}" 
                 data-event-image="${imagePath}">
                <div class="event-card-link">
                    <img class="event-card-image" src="${imagePath}" onerror="this.src='/asset/image/empty.jpg'">
                    <div class="event-card-details">
                        <div class="event-card-name">
                            <span class="event-type-dot" style="background: ${typeColor};"></span>
                            ${eventName}
                        </div>
                        <div class="event-card-time">
                            <i class="far fa-clock"></i> ${eventTime}
                        </div>
                    </div>
                </div>
            </div>
        `;
    });

    if (events.length > 1) {
        let firstEvent = events[0];
        let firstImagePath = '/asset/image/empty.jpg';
        if (firstEvent.event_image && firstEvent.event_image !== '/empty.jpg') {
            firstImagePath = firstEvent.event_image.startsWith('/') ? firstEvent.event_image :
                `/uploads/notice/126/${firstEvent.event_image}`;
        }

        const firstName = escapeHtml(firstEvent.event_name || 'Event');
        const firstTime = escapeHtml(firstEvent.event_time || 'All Day');
        const firstDesc = escapeHtml(firstEvent.event_description || '');

        eventsHtml += `
            <div class="event-card-modern clone-item" 
                 data-event-name="${firstName.replace(/"/g, '&quot;')}" 
                 data-event-time="${firstTime.replace(/"/g, '&quot;')}" 
                 data-event-desc="${firstDesc.replace(/"/g, '&quot;')}" 
                 data-event-image="${firstImagePath}">
                <div class="event-card-link">
                    <img class="event-card-image" src="${firstImagePath}" onerror="this.src='/asset/image/empty.jpg'">
                    <div class="event-card-details">
                        <div class="event-card-name">
                            <span class="event-type-dot" style="background: ${eventTypeColors[0]};"></span>
                            ${firstName}
                        </div>
                        <div class="event-card-time">
                            <i class="far fa-clock"></i> ${firstTime}
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    eventsHtml += `</div></div></div>`;
    wrapperDiv.html(eventsHtml);

    // Attach click event using event delegation
    $('.events_today_wrapper').off('click', '.event-card-modern').on('click', '.event-card-modern', function(e) {
        e.preventDefault();
        const $this = $(this);
        const eventName = $this.data('event-name');
        const eventTime = $this.data('event-time');
        const eventDesc = $this.data('event-desc');
        const eventImage = $this.data('event-image');

        console.log('Event clicked:', {
            eventName,
            eventTime,
            eventDesc,
            eventImage
        });
        openEventDetail(eventImage, eventName, eventDesc, eventTime);
    });

    // Marquee animation
    setTimeout(() => {
        const list = document.querySelector('.events-marquee-list');
        if (list && events.length > 1) {
            const items = list.children;
            if (items.length > 0) {
                const itemHeight = items[0]?.offsetHeight + 12 || 85;
                const totalItems = items.length;
                const duration = Math.max(12, totalItems * 1.5);
                list.style.animation = `smooth-marquee ${duration}s linear infinite`;

                const wrapper = document.querySelector('.events-marquee-wrapper');
                if (wrapper) {
                    const newWrapper = wrapper.cloneNode(true);
                    wrapper.parentNode.replaceChild(newWrapper, wrapper);

                    newWrapper.addEventListener('mouseenter', () => {
                        if (list) list.style.animationPlayState = 'paused';
                    });
                    newWrapper.addEventListener('mouseleave', () => {
                        if (list) list.style.animationPlayState = 'running';
                    });
                }
            }
        }
    }, 100);
}

function highlightDates(eventDates) {
    setTimeout(() => {
        const allCells = document.querySelectorAll('.dycalendar-body table td');
        allCells.forEach(td => {
            td.classList.remove('highlighted-date');
            td.style.backgroundColor = '';
            td.style.color = '';
        });

        eventDates.forEach(date => {
            if (!date) return;
            const day = String(date).split('-')[0];
            allCells.forEach(td => {
                if (td.innerText.trim() === day) {
                    td.classList.add('highlighted-date');
                }
            });
        });
    }, 200);
}

// ========== API CALLS ==========
function loadAllEvents() {
    console.log('Loading all events...');
    $.ajax({
        url: "{{ url('/dashboardevents/fetch') }}",
        type: 'GET',
        data: {
            _token: '{{csrf_token()}}'
        },
        success: function(response) {
            console.log('Events loaded:', response);
            if (response && response.rows) {
                displayEventsMarquee(response.rows, 'Upcoming Events');
                const eventDates = new Set(response.rows.map(row => row.event_date));
                highlightDates(eventDates);
            } else if (response && response.Data) {
                let data = typeof response.Data === 'string' ? JSON.parse(response.Data) : response.Data;
                if (data.rows) {
                    displayEventsMarquee(data.rows, 'Upcoming Events');
                    const eventDates = new Set(data.rows.map(row => row.event_date));
                    highlightDates(eventDates);
                } else {
                    displayEventsMarquee([], 'Upcoming Events');
                }
            } else {
                displayEventsMarquee([], 'Upcoming Events');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error loading events:', error);
            displayEventsMarquee([], 'Upcoming Events');
        }
    });
}

function get_event(eventsdate) {
    console.log('Loading events for date:', eventsdate);
    // Show loading state
    $('.events_today_wrapper').html(`
        <div class="events-modern-container">
            <div class="events-header">
                <h4><i class="fas fa-calendar-alt"></i> Loading...</h4>
            </div>
            <div class="loading-skeleton" style="height: 300px; border-radius: 16px;"></div>
        </div>
    `);

    $.ajax({
        url: "{{ url('/dashboardevents/fetch') }}",
        type: 'GET',
        data: {
            'event_date': eventsdate,
            _token: '{{csrf_token()}}'
        },
        success: function(response) {
            if (response && response.rows) {
                displayEventsMarquee(response.rows, `Events for ${formatDisplayDate(eventsdate)}`);
                const eventDates = new Set(response.rows.map(row => row.event_date));
                highlightDates(eventDates);
            } else if (response && response.Data) {
                let data = typeof response.Data === 'string' ? JSON.parse(response.Data) : response.Data;
                if (data.rows) {
                    displayEventsMarquee(data.rows, `Events for ${formatDisplayDate(eventsdate)}`);
                    const eventDates = new Set(data.rows.map(row => row.event_date));
                    highlightDates(eventDates);
                } else {
                    displayEventsMarquee([], `Events for ${formatDisplayDate(eventsdate)}`);
                }
            } else {
                displayEventsMarquee([], `Events for ${formatDisplayDate(eventsdate)}`);
            }
        },
        error: function() {
            displayEventsMarquee([], `Events for ${formatDisplayDate(eventsdate)}`);
        }
    });
}

// ========== CALENDAR INITIALIZATION ==========
$(document).ready(function() {
    // Initialize calendar with custom options
    if (typeof dycalendar !== 'undefined') {
        dycalendar.draw({
            target: "#dycalendar",
            type: "month",
            highlighttoday: true,
            prevnextbutton: "show",
            monthformat: "full"
        });
    } else {
        console.warn('dycalendar not loaded');
    }

    // Load events after calendar is ready
    setTimeout(loadAllEvents, 100);

    // Calendar click handler with improved stability
    function handleCalendarClick(e) {
        const td = e.target.closest('td');
        if (!td) return;

        // Skip header row cells
        if (td.parentElement && td.parentElement.rowIndex === 0) return;

        const clickedDate = td.innerText.trim().padStart(2, '0');
        const monthYearElement = document.querySelector('.dycalendar-span-month-year');

        if (monthYearElement && clickedDate && !isNaN(parseInt(clickedDate))) {
            const monthYearText = monthYearElement.innerText;
            const dateObj = new Date(`${monthYearText} ${clickedDate}`);

            if (!isNaN(dateObj.getTime())) {
                const month = (dateObj.getMonth() + 1).toString().padStart(2, '0');
                const year = dateObj.getFullYear().toString();
                const eventsdate = clickedDate + '-' + month + '-' + year;
                get_event(eventsdate);
            }
        }
    }

    function attachCalendarClick() {
        const cells = document.querySelectorAll('.dycalendar-body table td');
        cells.forEach(td => {
            // Skip header row cells by checking parent row index
            if (td.parentElement && td.parentElement.rowIndex === 0) return;
            td.removeEventListener('click', handleCalendarClick);
            td.addEventListener('click', handleCalendarClick);
        });
    }

    // Initial attach with delay for calendar render
    setTimeout(attachCalendarClick, 500);

    // Observer for calendar changes (month navigation)
    const calendarObserver = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList' || mutation.type === 'subtree') {
                setTimeout(attachCalendarClick, 100);
            }
        });
    });

    const calendarElement = document.getElementById('dycalendar');
    if (calendarElement) {
        calendarObserver.observe(calendarElement, {
            childList: true,
            subtree: true
        });
    }

    // Cleanup on page unload
    $(window).on('beforeunload', function() {
        if (calendarObserver) calendarObserver.disconnect();
        if (currentAnimationInterval) clearTimeout(currentAnimationInterval);
    });
});
</script>
@endsection