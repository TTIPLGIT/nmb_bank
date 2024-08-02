@extends('layouts.adminnav')

@section('content')
<style>
    /* remove card bocy shadow */
    .noShadow .card-body {
        box-shadow: none !important;
    }



    .card {
        box-shadow: none !important;
    }

    /* .main-content {
        padding-top: 80px !important;
        padding-left: 20px !important;
    } */

    .overview_header {
        margin: 0px 0.5rem !important;
    }

    .overview_heading {
        color: #000;
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
        color: #40c2b2 !important;
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
        padding-top: 0px !important;
        border-top: 0px solid white !important;
        background-color: white !important;
        border-bottom-left-radius: 5px !important;
        border-bottom-right-radius: 5px !important;
    }

    .overview_count {
        padding-left: 5% !important;
        font-size: 1.5rem !important;
        color: #000 !important;
        font-weight: 900 !important;
        text-align: center !important;
    }

    .overview_img {
        width: 35% !important;
    }

    .overview_img#overview_img_exception {
        margin: 0.6rem !important;
    }

    .course {
        width: 100% !important;
        height: 394px !important;
        border: 0px !important;
        padding: 0px !important;
        margin: 0.5rem !important;
        border-radius: 5px !important;
        overflow-y: scroll;
    }

    .course_heading {
        color: #000;
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
        //* padding: 0px 0px 7px 0px !important;*//
        background-color: #f8f9fc !important;
        border-top-left-radius: 5px !important;
        border-top-right-radius: 5px !important;
    }

    .course .card-body {
        width: 100% !important;
        height: 344px;
        border: 0px !important;
        padding: 0px !important;
        background-color: white !important;
    }

    /* 
    .course_and_schedule_body {
        flex-wrap: wrap !important;
        width: 100% !important;
        height: 520px;
    } */

    .schedule {
        width: 100% !important;
        height: 300px !important;
        border: 0px !important;
        margin-top: 0.5rem !important;
        margin-bottom: 0.5rem !important;
        margin-left: 0.5rem !important;
        margin-right: 0.5rem !important;
        border-radius: 5px !important;
        overflow: hidden !important;
    }

    .schedule_heading {
        color: #000;
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
        height: 344px !important;
        padding: 0px 0px !important;
        background-color: white !important;
        border-radius: 5px !important;
        overflow: hidden !important;
        display: flex;
        flex-wrap: wrap;
    }

    .group_lessons,
    .recommended_courses_list,
    .notice_board_list {
        width: 100% !important;
        height: 397px !important;
        border: 0px !important;
        padding: 0px !important;
        margin: 0.5rem !important;
        border-radius: 5px !important;
        overflow: hidden !important;
    }

    .group_lessons .card-header,
    .recommended_courses_list .card-header,
    .notice_board_list .card-header {
        width: 100% !important;
        height: 75px !important;
        color: #000;
        font-weight: 900;
        font-size: 1.5rem !important;
        /* padding: 10px 0px 7px 0px !important;*/
        background-color: #f8f9fc !important;
        border-top-left-radius: 5px !important;
        border-top-right-radius: 5px !important;
    }

    .group_lessons .card-body,
    .recommended_courses_list .card-body,
    .notice_board_list .card-body {
        width: 100% !important;
        height: 324px !important;
        border: 0px !important;
        padding: 0px !important;
        background-color: white !important;
        border-radius: 5px !important;
    }

    /* .calendar{
        width: 100% !important;
        height: 100% !important;
        padding: 10px 10px !important;
    }
    .calendar_header{
        width: 100% !important;
        height: 20% !important;
    }
    .calendar_body{
        width: 100% !important;
        height: 70% !important;+
    } */
    /* .week_days{
        background-color: #2196F3;
        padding: 5px;
    }
    .week_days > div{
        color: #000;
        text-align: center;
        font-size: 0.5rem;
    }
    .days{
        border: 1px solid #7ac0f8 !important;
        flex-wrap: wrap !important;
        width: fit-content !important;
        padding-top: 2px !important;
    }
    .days > div{
        border-bottom: 1px solid #7ac0f8 !important;
        padding: 5px !important;
        font-size: 0.5rem !important;
        color: #1a1a1a !important;
        width: calc(100%/7);
        text-align: center !important;
    }
    .days > div:nth-child(29),
    .days > div:nth-child(30),
    .days > div:nth-child(31){
        border-bottom: none !important;
    } */
    .event_indicator {
        width: 10px !important;
        height: 10px;
        color: #f69135;
        background-color: #f69135;
        border-radius: 50%;
    }

    /* calendar changes*/
    .schedule_frame {
        border: 0px !important;
    }

    .recommended_courses_list .card-body {
        overflow-y: auto;
        overflow-x: hidden;
    }

    .recommended_courses {
        width: 97%;
        height: 30%;
        overflow: hidden;
        margin: 0% 1.5% 5% 1.5%;
    }

    .recommended_courses:first-child {
        margin: 3% 1.5% 5% 1.5% !important;
    }

    .recommended_courses_poster {
        width: 100px;
        height: 100px;
        object-fit: cover !important;
    }

    .recommended_course_details {
        width: 65%;
        height: 100%;
    }

    .recommended_course_name {
        margin-bottom: 0px !important;
        color: #38aa9c;
    }

    .recommended_course_instructor {
        padding-left: 1%;
        color: #48dbc9;
    }

    .recommended_course_footer {
        padding-left: 1%;
        color: #b1b1b1;
    }

    .notice_board_list .card-body {
        overflow-y: auto;
        overflow-x: hidden;
    }

    .notice_board {
        width: 97%;
        height: 25%;
        overflow: hidden;
        margin: 0% 1.5% 5% 1.5%;
    }

    .notice_board:first-child {
        margin: 1.5% 1.5% 5% 1.5% !important;
    }

    .notice_board_poster {
        width: 100px;
        height: 100px;
        object-fit: cover !important;
    }

    .events_image {
        width: 100px;
        height: 100px;
        object-fit: cover !important;
    }

    .notice_board_heading {
        width: calc(100%-100px);
        height: 100%;
        padding: 0% 0% 0% 3%;
    }

    .notice_board_event_name {
        margin-bottom: 0px !important;
        color: #38aa9c;
    }

    .notice_board_event_organiser {
        padding-left: 0%;
        color: #48dbc9;
    }

    .notice_board_footer {
        padding-left: 1%;
        color: #b1b1b1;
    }

    .group_lessons .card-body {
        overflow-y: auto !important;
        padding: 0% 5% 0% 5% !important;
    }

    .lesson {
        height: 250px;
        border-bottom: 1px solid #141ad8;
        margin: 20px 0px 5px 0px !important;
    }

    .group_lesson_author {
        color: #38aa9c;
    }

    .group_lesson_course_name {
        color: #48dbc9;
    }

    .group_lesson_footer {
        margin-bottom: 10px !important;
    }

    .group_lesson_link {
        padding: 2px 5px;
        border: 1px solid #3bb0a0;
        border-radius: 5px;
    }

    .group_lesson_link a {
        color: #48dbc9 !important;
        font-weight: 800;
    }

    .group_lesson_link i {
        color: #48dbc9 !important;
    }

    .group_participants_container {
        width: 100%;
        height: 80px;
        margin: 20px 0px;
    }

    .group_participants_heading {
        width: 100%;
        font-weight: bold;
        height: 20px;
    }

    .group_participants_list {
        position: relative !important;
        width: 100% !important;
        height: 60px !important;
    }

    .group_participant1 {
        position: absolute;
        top: 10%;
        left: 5px;
        width: 30px;
        height: 30px;
        clip-path: circle(30px);
        overflow: hidden;
    }

    .group_participant1 img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
    }

    .group_participant2 {
        position: absolute;
        top: 10%;
        left: 25px;
        width: 30px;
        height: 30px;
        clip-path: circle(30px);
        overflow: hidden;
    }

    .group_participant2 img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
    }

    .group_participant3 {
        position: absolute;
        top: 10%;
        left: 45px;
        width: 30px;
        height: 30px;
        clip-path: circle(30px);
        overflow: hidden;
    }

    .group_participant3 img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
    }

    .group_participant4 {
        position: absolute;
        top: 10%;
        left: 65px;
        width: 30px;
        height: 30px;
        clip-path: circle(30px);
        overflow: hidden;
    }

    .group_participant4 img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
    }

    .group_participant5 {
        position: absolute;
        top: 10%;
        left: 85px;
        width: 30px;
        height: 30px;
        clip-path: circle(30px);
        overflow: hidden;
    }

    .group_participant5 img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
    }

    .group_participant_indicator {
        position: absolute;
        top: 10%;
        left: 105px;
        width: 30px;
        height: 30px;
        text-align: center;
        background-color: lightcyan;
        line-height: 30px;
        border-radius: 50%;
        clip-path: circle(30px);
    }

    .group_participant_indicator span {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        color: #000;
        font-size: 0.75rem;
        font-weight: 900;
        text-align: center;
    }

    @media (min-width: 320px) and (max-width: 575px) {
        .calendar-container {
            position: relative;
            border-radius: 10px;
            box-shadow: 5px 5px 15px rgb(0 0 0 / 10%), -5px -5px 15px #edf1f4;
            width: 100%;
            min-height: 326px;
        }


        .events_today_wrapper {
            width: 100% !important;
            height: 370px !important;
            text-align: center !important;
            overflow: auto !important;
            /* opacity: 0; */
            transition-property: opacity, left;
            transition-duration: 3s, 5s;
        }

        .noticesss {
            padding-top: 150px;

        }

        .noticess {
            padding-top: 177px;
        }

        .course_and_schedule_container {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
            height: 440px !important;
        }
    }

    @media (min-width:319.96px) {
        .schedule {
            width: 100% !important;
            height: 738px !important;
        }
    }

    @media (min-width:424.96px) {
        .schedule {
            width: 70% !important;
            height: 500px !important;
        }

        .course {
            width: 70% !important;
        }

        .overview_body .card {
            width: 80% !important;
        }

        .course_and_schedule_container {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
            height: 440px !important;
        }

        .schedule {
            width: 100% !important;
            height: 649px !important;
        }

        .noticess {
            padding-top: 113px;
        }
    }

    @media (min-width:575.96px) {
        .schedule {
            width: 100% !important;
            height: 394px !important;
        }

        .schedule_heading {
            font-size: 1.5rem !important;
        }

        .course_heading {
            font-size: 1.5rem !important;
        }

        .course {
            width: 50% !important;
        }

        .overview_filter {
            padding-right: 4% !important;
        }

        .overview_body .card {
            width: 46.5% !important;
        }
    }

    @media (min-width:767.96px) {
        .schedule {
            width: 70% !important;
        }

        .course {
            width: 70% !important;
        }

        .overview_body .card {
            width: 31% !important;
        }

        .noticess {
            padding-top: 0px;
        }
    }

    @media (min-width:1024.96px) {
        .main-content {
            padding-left: 280px !important;
        }

        .sidebar-mini .main-content {
            padding-left: 85px !important;
        }

        .sidebar-mini .main-content .overview_body .card {
            width: 204px !important;
        }

        .course {
            width: 47% !important;
        }

        .schedule {
            width: 58% !important;
        }

        .overview_body .card {
            width: 31% !important;
        }

        .overview_filter {
            padding-right: 2% !important;
        }

        .noticess {
            padding-top: 0px;
        }
    }

    @media (min-width:1199.96px) {
        .overview_body {
            justify-content: spa ce-between !important;
        }

        .overview_body .card {
            width: 22.85% !important;
        }

        .sidebar-mini .main-content .overview_body .card {
            width: 220px !important;
        }
    }

    @media (min-width:320px) and (max-width:502px) {
        .schedule .card-body {
            width: 100% !important;
            height: 450px !important;
            padding: 0px 0px !important;
            background-color: white !important;
            border-radius: 5px !important;
            overflow: hidden !important;
        }
    }

    @media (min-width:503px) and (max-width:502px) {
        .schedule .card-body {
            width: 100% !important;
            height: 450px !important;
            padding: 0px 0px !important;
            background-color: white !important;
            border-radius: 5px !important;
            overflow: hidden !important;
        }
    }
</style>

<style>
    .calendar-container {
        position: relative;
        border-radius: 10px;
        box-shadow: 5px 5px 15px rgb(0 0 0 / 10%), -5px -5px 15px #edf1f4;
        width: 50%;
        min-height: 344px;
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
        border-spacing: 10px !important;
    }

    .dycalendar-month-container .dycalendar-body table tr td {
        padding: 2px 6px;
        color: #777;
        border: 1px solid #edf1f4;
        border-radius: 5px !important;
        cursor: pointer;
        font-size: 0.8rem;
        font-weight: 500;
        box-shadow: 5px 5px 10px rgb(0 0 0 / 10%), -5px -5px 10px rgb(255 255 255);
    }

    .dycalendar-month-container .dycalendar-body table tr td:hover {
        box-shadow: inset 5px 5px 10px rgba(0, 0, 0, 0.1),
            inset -5px -5px 10px rgba(255, 255, 255, 1);
    }

    #dycalendar table tr:first-child td {
        color: #fff;
        background-color: #0ef3d8;
        font-weight: 700;
        box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.1), -5px -5px 10px #fff;
    }

    #dycalendar table tr:first-child td:first-child {
        color: #fff;
        background-color: #f92f60;
    }

    #dycalendar table tr td:first-child {
        color: #f92f60;
    }

    .dycalendar-today-date,
    .dycalendar-today-date:hover {
        background-color: white !important;
        color: #0ef3d8 !important;
        box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.1),
            -5px -5px 10px rgba(255, 255, 255, 1) !important;
        border: none !important;
        font-weight: 700 !important;
    }

    .dycalendar-header {
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: baseline;
        padding-left: 15px !important;
        padding-right: 15px !important;
    }

    .dycalendar-prev-next-btn {
        position: static !important;
        color: #777;
        padding: 0px 5px 0px 5px;
        /* border-radius: 10px !important; */
        cursor: pointer !important;
        font-size: 2rem;
        font-weight: 500;
        text-shadow: 3px 0px 5px #000;
        /* box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.1),
        -5px -5px 10px rgba(255, 255, 255, 1); */
    }

    .dycalendar-prev-next-btn.prev-btn {
        text-shadow: -3px 0px 5px #000;
    }

    .dycalendar-prev-next-btn.next-btn {
        text-shadow: 3px 0px 5px #000;
    }

    .dycalendar-prev-next-btn.prev-btn:active {
        color: #0ef3d8;
        text-shadow: -3px 0px 5px #0ef3d880;
    }

    .dycalendar-prev-next-btn.next-btn:active {
        color: #0ef3d8;
        text-shadow: 3px 0px 5px #0ef3d880;
    }

    .dycalendar-span-month-year {
        font-size: 1.3rem;
        font-weight: 600;
        color: #0ef3d8;
    }

    /* events */
    .events_today_wrapper {
        width: 50% !important;
        height: 344px !important;
        text-align: center !important;
        overflow: auto !important;
        transition-property: opacity, left;
        transition-duration: 3s, 5s;
    }

    .events_today_wrapper::-webkit-scrollbar {
        width: 6px;
    }

    .events_today_wrapper::-webkit-scrollbar-track {
        background-color: #eee;
    }

    .events_today_wrapper::-webkit-scrollbar-thumb {
        box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    }

    .event_type {
        margin: 10px !important;
        padding: 10px 5px !important;
        color: black !important;
    }

    .event_type_1 {
        background-color: #fef4ec !important;
        border-left: 5px solid #f0a880 !important;
    }

    .event_type_2 {
        background-color: #fef6d2 !important;
        border-left: 5px solid #e8cf57 !important;
    }

    .event_type_3 {
        background-color: #e4efff !important;
        border-left: 5px solid #4688e4 !important;
    }

    .event_type_4 {
        background-color: #e9f8ff !important;
        border-left: 5px solid #67c8e2 !important;
    }

    /* testing */
    .schedule {
        width: 58%;
    }


    @media (min-width:320px) and (max-width:575px) {
        .calendar-container {
            position: relative;
            border-radius: 10px;
            box-shadow: 5px 5px 15px rgb(0 0 0 / 10%), -5px -5px 15px #edf1f4;
            width: 100%;
            min-height: 326px;
        }

        .events_today_wrapper {
            width: 100% !important;
            height: 344px !important;
            text-align: center !important;
            overflow: auto !important;
            transition-property: opacity, left;
            transition-duration: 3s, 5s;
        }

        .dycalendar-month-container .dycalendar-body table tr td {
            padding: 1px 3px;
            color: #777;
            border: 1px solid #edf1f4;
            border-radius: 5px !important;
            cursor: pointer;
            font-size: 0.8rem;
            font-weight: 500;
            box-shadow: 5px 5px 10px rgb(0 0 0 / 10%), -5px -5px 10px rgb(255 255 255);
        }

        .course_and_schedule_body {
            flex-wrap: wrap !important;
            width: 100% !important;
            height: 416px !important;
        }

        .schedule .card-body {
            width: 100% !important;
            height: 688px !important;
            padding: 0px 0px !important;
            background-color: white !important;
            border-radius: 5px !important;
            overflow: hidden !important;
            gap: 20px;
        }

        .main-content {
            padding-right: 5px;
            width: 100% !important;
        }

        .main-content {
            padding-top: 80px !important;
            padding-left: 5px !important;
        }


    }

    .nonotice {
        display: flex !important;
        justify-content: center !important;
        font-weight: 600 !important;
        font-size: 22px !important;
    }

    /* .fancybox-caption__body {
        text-align: right;
        margin-bottom: 341px !important;
    } */
    .noevents {
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 22px;
        font-weight: 600;
        height: 300px !important;



    }

    .events_today_wrapper a {
        display: flex !important;
        justify-content: space-evenly !important;
        align-items: center !important;
        gap: 30px !important;
    }
</style>

<style>
    .carousel-item {
        text-align: center;
        width: 100%;
    }

    .carousel-item img {
        display: inline-block;
        vertical-align: middle;
        width: calc(50% - 57px) !important;
        height: 450px;
    }

    #fancyControls {
        border: none !important;
    }

    .carousel-item>div {
        display: inline-block;
        vertical-align: middle;
        width: calc(50% - 57px) !important;
        font-weight: 700;
        font-style: italic;
        font-size: 16px !important;
    }

    .carousel-control-next,
    .carousel-control-prev {
        position: absolute;
        top: 0;
        bottom: 0;
        z-index: 1;
        display: -ms-flexbox;
        display: -webkit-box;
        display: flex;
        -ms-flex-align: center;
        -webkit-box-align: center;
        align-items: center;
        -ms-flex-pack: center;
        -webkit-box-pack: center;
        justify-content: center;
        width: 5%;
        /* color: #fff; */
        text-align: center;
        opacity: .5;
        -webkit-transition: opacity .15s ease;
        transition: opacity .15s ease;
        border: none !important;
        background: transparent;

    }

    .modal-xl .modal-dialog {
        max-width: 800px;
        /* Set a custom maximum width */
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: black;
        border-radius: 25% !important;

    }

    .closefancy {

        background: transparent;

        color: white;
        border: none;
        /* font-size: 16px; */
    }

    .modal-content {
        background: transparent !important;
    }

    .modal-header {
        background: white !important;
    }

    .modal-body {
        background: white !important;
    }

    .fa-times {
        font-size: 20px;
        font-weight: 900 !important;
        color: #000 !important;
    }

    .text-overflow-ellipses {
        /* //border: 2px solid #2a70a5; */
        padding: 20px 0;
        white-space: nowrap;
        width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 50px;
    }

    .ellipsis {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        max-width: 200px;
        /* Adjust the value to fit your desired width */
    }

    .expanded {
        white-space: normal;
        max-width: none;
    }

    .caption {
        display: none;
    }
</style>

<style>
    @media (min-width: 576px) {

        .notice_board_list {
            width: 100% !important;
            height: 100% !important;
            border: 0px !important;
            padding: 0px !important;
            margin: 0.5rem !important;
            border-radius: 5px !important;
            overflow: hidden !important;
        }


    }

    @media (min-width: 768px) {

        .notice_board_list {
            width: 100% !important;
            height: 100% !important;
            border: 0px !important;
            padding: 0px !important;
            margin: 0.5rem !important;
            border-radius: 5px !important;
            overflow: hidden !important;
        }
    }

    @media (min-width: 992px) {
        .notice_board_list {
            width: 100% !important;
            height: 100% !important;
            border: 0px !important;
            padding: 0px !important;
            margin: 0.5rem !important;
            border-radius: 5px !important;
            overflow: hidden !important;
        }


    }

    @media (min-width: 1200px) {
        .notice_board_list {
            width: 100% !important;
            height: 100% !important;
            border: 0px !important;
            padding: 0px !important;
            margin: 0.5rem !important;
            border-radius: 5px !important;
            overflow: hidden !important;
        }


    }

    /* @media screen and (min-device-width: 320px) and (max-device-width: 576px) {
        .notice_board_list {
            width: 100% !important;
            height: 100% !important;
        }

    } */
</style>



<link href="{{asset('assets/css/jquery.fancybox.min.css')}}" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="{{ asset('assets/css/jquery.fancybox.min.js') }}"></script>
<div class="main-content">
    <section class="section">
        <div class="section-body mt-1">
            <div class="overview_container container-fluid">
                <div class="overview_header d-flex flex-row justify-content-between align-items-center">

                    <h2 class="overview_heading">
                        Admin Overview
                        <div class="path">
                            <span>E-Learning</span>
                            <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                            <span>Admin Dashboard</span>
                        </div>
                    </h2>
                </div>
                <div class="d-flex flex-row justify-content-center justify-content-sm-start overview_body">
                    <div class="card noShadow">
                        <div class="card-header">
                            <span>Total Courses</span>
                        </div>
                        <div class="card-body d-flex flex-row justify-content-between align-items-center">
                            <span class="overview_count">{{$count['total_course'][0]['numberofcourses']}}</span>
                            <img class="overview_img" src="{{asset('asset/image/progresscourse.png')}}" alt="Course in Progress" width="40%">
                        </div>
                    </div>
                    <div class="card noShadow">
                        <div class="card-header">
                            <span>Free Course</span>
                        </div>
                        <div class="card-body d-flex flex-row justify-content-between align-items-center">
                            <span class="overview_count">{{$count['free_course'][0]['numberofcourses']}}</span>
                            <img class="overview_img" src="{{asset('asset/image/completed.png')}}" alt="Course Completed" width="40%">
                        </div>
                    </div>
                    <div class="card noShadow">
                        <div class="card-header">
                            <span>Paid Course</span>
                        </div>
                        <div class="card-body d-flex flex-row justify-content-between align-items-center">
                            <span class="overview_count">{{$count['paid_course'][0]['numberofcourses']}}</span>
                            <img class="overview_img" src="{{asset('asset/image/paid-ads.png')}}" alt="Watching Time" width="40%">
                        </div>
                    </div>
                    <div class="card noShadow">
                        <div class="card-header">
                            <span>Certificate Course</span>
                        </div>
                        <div class="card-body d-flex flex-row justify-content-between align-items-center" style="height: 92px;">
                            <span class="overview_count">{{$count['certificate_course'][0]['numberofcourses']}}</span>
                            <img class="overview_img" id="overview_img_exception" src="{{asset('asset/image/awards.png')}}" alt="Certificates Achieved" width="40%">
                        </div>
                    </div>

                    <!-- <div class="card noShadow">
                        <div class="card-header">
                            <span>Certificates Achieved</span>
                        </div>
                        <div class="card-body d-flex flex-row justify-content-between align-items-center">
                            <span class="overview_count">05</span>
                            <img class="overview_img" src="{{asset('asset/image/certificateAchieved.png')}}" alt="Certificates Achieved" width="40%">
                        </div>
                    </div> -->
                    <!-- <div class="card noShadow">
                        <div class="card-header">
                            <span>Credits Earned</span>
                        </div>
                        <div class="card-body d-flex flex-row justify-content-between align-items-center">
                            <span class="overview_count">670</span>
                            <img class="overview_img" src="{{asset('asset/image/creditsEarned.png')}}" alt="Credits Earned" width="40%">
                        </div>
                    </div> -->
                </div>
            </div>
            <div class="container-fluid course_and_schedule_container">
                <div class="d-flex flex-row course_and_schedule_body w-100">
                    <div class="card noShadow schedule" style="width: 100% !important;">
                        <div class="card-header d-flex flex-row justify-content-center align-items-center">
                            <h2 class="schedule_heading">
                                Upcoming Events
                            </h2>
                        </div>
                        <div class="card-body">
                            <!-- <iframe class="schedule_frame" src="{{asset('asset/animated-calendar/index.html')}}" width="100%" height="100%"></iframe> -->

                            <div class="calendar-container">
                                <div id="dycalendar" class="dycalendar-container"></div>
                            </div>
                            <div class="events_today_wrapper no_event">




                            </div>
                        </div>
                    </div>



                </div>
            </div>
            <div class="row noticess">
                <div class="col-md-10 noticesss">

                    <div class="card noShadow notice_board_list" style="">
                        <div class="card-header">
                            Notice Board
                        </div>
                        @php $class_list=count ($rows)== 0 ? "d-flex justify-content-center align-items-center" : '' @endphp
                        <div class="card-body {{$class_list}}">
                            @if(count ($rows)== 0)
                            <div class="nonotice">No Notice Found</div>
                            @endif
                            @foreach($rows as $key=>$row)

                            <div class="d-flex flex-row justify-content-around notice_board">
                                @php $path=$row['notice_path'].'/'.$row['notice_banner'];@endphp
                                @if(file_exists(substr($path, 1)))
                                <img class="notice_board_poster noticeHasFancy" src="{{$row['notice_path']}}/{{$row['notice_banner']}}" alt="Notice Board" onclick="makeFancy(event, 'noticeHasFancy')">
                                <!-- <span class="caption">{{$row['notice_description']}}</span> -->
                                <span class="caption">{!!html_entity_decode($row['notice_description'])!!}</span>


                                @else
                                <img class="notice_board_poster noticeHasFancy" src="{{$row['notice_path']}}/empty.jpg" alt="Notice Board" onclick="makeFancy(event, 'noticeHasFancy')">
                                <span class="caption">{!!html_entity_decode($row['notice_description'])!!}</span>

                                @endif

                                <!-- <img style="height:200px !important;width:300" class="notice_board_poster noticeHasFancy" src="{{$row['notice_path']}}/{{$row['notice_banner']}}" data-caption="{{$row['notice_description']}}" alt="Notice Board" onclick="makeFancy(event, 'noticeHasFancy')"> -->

                                <div class="hover_plus_wrapper">
                                    <div class="hover_plus">

                                        <i class="bi bi-plus" aria-hidden="true"></i>
                                    </div>
                                </div>

                                <div class="d-flex flex-column justify-content-around notice_board_heading">
                                    <h6 class="notice_board_event_name event-name ellipsis">
                                        {{$row['notice_name']}}
                                    </h6>
                                    <span class="notice_board_event_organiser">
                                        {{$row['name']}}
                                    </span>
                                </div>
                                <br>

                            </div>
                            @endforeach

                        </div>
                    </div>

                </div>
            </div>
            <div class="container-fluid">
                <div class="row justify-content-between">
                    <div class="card noShadow course">
                        <div class="card-header d-flex flex-row justify-content-between align-items-center">
                            <h2 class="course_heading">
                                Study Statistics
                            </h2>

                            <select class="custom-select course_filter">
                                <option value="Weekly" selected>Weekly</option>
                                <option value="Monthly">Monthly</option>
                                <option value="Yearly">Yearly</option>
                                <option value="Yearly">Overall</option>
                            </select>
                        </div>
                        <div class="card-body">
                            <div id="line_top_x"></div>
                        </div>
                    </div>


                    <div class="col-12 col-sm-6 col-lg-6">
                        <div class="card noShadow recommended_courses_list">
                            <div class="card-header">
                                Recommended Courses
                            </div>
                            <div class="card-body">

                                @if(count($recommended)==0)
                                <div class="d-flex flex-row justify-content-around recommended_courses">

                                    <span style="margin-top: 48px;font-weight: 600;font-size: 22px !important;">No Recommended Courses</span>
                                </div>

                                @endif

                                @foreach($recommended as $key=>$row)
                                <div class="d-flex flex-row justify-content-around recommended_courses">
                                    <!--  -->
                                    @if(file_exists('uploads/class/126/'.$row['course_banner']))
                                    <img class="recommended_courses_poster recommendedfancy" src="uploads/class/126/{{$row['course_banner']}}" alt="Recommended Course" onclick="makeFancy(event, 'recommendedfancy')">
                                    <span class="caption">{!!html_entity_decode($row['course_description'])!!}</span>

                                    @else
                                    <img class="recommended_courses_poster recommendedfancy" src="uploads/class/126/empty.jpg" alt="Recommended Course" onclick="makeFancy(event, 'recommendedfancy')">
                                    <span class="caption">{!!html_entity_decode($row['course_description'])!!}</span>

                                    @endif




                                    <div class="d-flex flex-column justify-content-between recommended_course_details">
                                        <div class="recommended_course_header">
                                            <h6 class="recommended_course_name">
                                                {{$row['course_name']}}
                                            </h6>
                                            <span class="recommended_course_instructor">
                                                {{$row['course_instructor']}}
                                            </span>
                                        </div>
                                        <div class="recommended_course_footer">
                                            <span class="recommended_course_time">
                                                {{$row['duration']}}
                                            </span>
                                            <span class="recommended_course_divider">
                                                -
                                            </span>
                                            <span class="recommended_course_learners">
                                                @php $exist=$row['total_student']==0 ? "No Students Enrolled" : "Students" @endphp
                                                @if($row['total_student'] !=0){{$row['total_student']}}@endif {{$exist}}
                                            </span>
                                        </div>

                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>
</div>
<!-- Vertically centered modal -->
<div class="modal fade" id="event_poster_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button>
            </div>
        </div>
    </div>
</div>

<!-- fancy box modal start-->
<div class="modal fade" id="fancyContainer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="fancyContainerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title" id="fancyContainerLabel">Modal title</h5> -->
                <div class="col-md-12" style="display: flex;justify-content: flex-end;">
                    <button class="closefancy" onclick="removefancy()"><span aria-hidden="true"><i class="fa fa-times" aria-hidden="true" style="pointer-events: none !important;"></i></span></button>
                </div>

            </div>
            <div class="modal-body" id="fancyWrapper">

                <div id="fancyControls" class="carousel slide" data-bs-ride="carousel">
                    <!-- js code -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#fancyControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <!-- <span class="visually-hidden">Previous</span> -->
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#fancyControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <!-- <span class="visually-hidden">Next</span> -->
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- fancy box modal end-->

<!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['line']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = new google.visualization.DataTable();
        data.addColumn('number', 'Day');
        data.addColumn('number', 'Equity Research Course');
        data.addColumn('number', 'Finance of mergers and Acquistions');
        data.addColumn('number', 'Stock Valuation Analysis');

        data.addRows([
            [1, 37.8, 80.8, 41.8],
            [2, 30.9, 69.5, 32.4],
            [3, 25.4, 57, 25.7],
            [4, 11.7, 18.8, 10.5],
            [5, 11.9, 17.6, 10.4],
            [6, 8.8, 13.6, 7.7],
            [7, 7.6, 12.3, 9.6],
            [8, 12.3, 29.2, 10.6],
            [9, 16.9, 42.9, 14.8],
            [10, 12.8, 30.9, 11.6],
            [11, 5.3, 7.9, 4.7],
            [12, 6.6, 8.4, 5.2],
            [13, 4.8, 6.3, 3.6],
            [14, 4.2, 6.2, 3.4]
        ]);

        var options = {
            chart: {
                //   title: 'Box Office Earnings in First Two Weeks of Opening',
                //   subtitle: 'in millions of dollars (USD)'

            },
            width: '100%',
            height: 250,
            chartArea: {
                left: 15,
                right: 15,
                top: 0,
                bottom: 0,
                width: '100%',
                height: 250,
            },
            axes: {
                x: {
                    0: {
                        side: 'top'
                    }
                }
            }
        };

        var chart = new google.charts.Line(document.getElementById('line_top_x'));

        chart.draw(data, google.charts.Line.convertOptions(options));
    }
</script>


<script type="text/javascript" src="{{ asset('asset/js/calender.js') }}"></script>
<script>
    function makeFancy(e, selector) {
        const eventsgallery = document.querySelectorAll(`.${selector}`);

        let modalBody = document.createElement('div');
        modalBody.setAttribute('id', 'fancyContainerInner');
        modalBody.classList.add('carousel-inner');
        for (let eventGallery of eventsgallery) {
            let carouselItem = document.createElement('div');
            if (e.target === eventGallery) {
                carouselItem.classList.add('carousel-item');
                carouselItem.classList.add('active');
            } else {
                carouselItem.classList.add('carousel-item');
            }
            let imgTag = document.createElement('img');
            imgTag.src = eventGallery.src;
            let caption = eventGallery.parentElement.querySelector('.caption').innerHTML;
            //alert(caption);

            // let caption = eventGallery.getAttribute('data-caption');
            let captionContainer = document.createElement('div');
            captionContainer.innerHTML = caption ? caption : "";
            carouselItem.appendChild(imgTag);
            carouselItem.appendChild(captionContainer);
            modalBody.appendChild(carouselItem);
            console.log(carouselItem, 'in');
        }

        $('#fancyContainer').modal({
            backdrop: 'static',
            keyboard: false
        });
        $('#fancyContainer').modal('show');
        document.querySelector('#fancyControls').prepend(modalBody);
        // $('#fancyContainerInner').append(controls);
        $("#fancyControls").carousel("cycle");
    }
</script>

<script>
    function toggleExpansion(e) {
        e.target.classList.toggle("ellipsis");
    }

    function removefancy() {
        $('#fancyContainer').modal('hide');
        $('#fancyContainer').data('bs.modal', null);
        // document.querySelector('#fancyWrapper').innerHTML = "";
        let fancycontrols = document.querySelector('#fancyControls');
        fancycontrols.removeChild(fancycontrols.firstChild);
    }



    function get_event(eventsdate) {

        $.ajax({
            url: "{{ url('/admindashboardevents/fetch') }}",
            type: 'GET',
            data: {
                'event_date': eventsdate,
                _token: '{{csrf_token()}}'

            },

            success: function(data) {
                console.log(data);
                console.log(data.rows.length);
                var count = 1;
                $('.events_today_wrapper').children().remove();
                if (data.rows.length == 0) {
                    const nodata = '<div class="noevents">No Events Found</div>'
                    $('.no_event').append(nodata);

                } else {
                    for (const row of data.rows) {
                        console.log(row.event_description);
                        if (count == 5) {
                            count = 1;
                        } else {
                            count++;
                        }
                        const new_event = `<div class="card event_type event_type_${count}">
                        <a class="d-flex align-items-center justify-content-space-evenly gap-3" >
                                    <img style="height:60px !important;width:100px;object-fit:cover" class="events_image eventsHasFancy" src="/uploads/notice/126/${row.event_image}" alt="Events" onclick="makeFancy(event,'eventsHasFancy')" >
                                    <span class="caption">${row.event_description}</span>
                                    <p class="event-name ellipsis">${row.event_name}</p>
                                    <div class="hover_plus_wrapper">
                                            <div class="hover_plus">

                                                <i class="bi bi-plus" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>`


                        $('.events_today_wrapper').append(new_event);


                    }
                    var eventNames = document.querySelectorAll(".event-name");
                    for (const eventName of eventNames) {
                        eventName.addEventListener("click", toggleExpansion);

                    }
                }
            }
        });

    }
    //today calendar - with skin and shadow
    dycalendar.draw({
        target: "#dycalendar",
        type: "month",
        dayformat: "fulldate",
        highlighttoday: true,
        prevnextbutton: "show",
        monthformat: "full",
        dayformat: "ddd",
    });
    var myElement = document.getElementById('dycalendar');
    myElement.addEventListener('DOMSubtreeModified', attachEventListenersToCalendarDays, false);

    function attachEventListenersToCalendarDays() {
        const tdElements = document.querySelectorAll('.dycalendar-body table td');
        for (const tdElement of tdElements) {
            tdElement.addEventListener('click', (e) => {
                const clickedDate = e.target.innerText.padStart(2, '0');
                const monthYearElement = document.querySelector('.dycalendar-span-month-year');
                const monthYearText = monthYearElement.innerText;
                const dateObj = new Date(`${monthYearText} ${clickedDate}`);
                const month = (dateObj.getMonth() + 1).toString().padStart(2, '0');
                const year = dateObj.getFullYear().toString();
                const eventsdate = clickedDate + '-' + month + '-' + year;

                get_event(eventsdate);
            });
        }
    }

    // Initial attachment of event listeners
    attachEventListenersToCalendarDays();


    const tdElements = document.querySelectorAll('.dycalendar-body table td');
    for (const tdElement of tdElements) {
        tdElement.addEventListener('click', (e) => {
            //console.log(e);
            const clickedDate = e.target.innerText.padStart(2, '0');;
            console.log(clickedDate);

            const monthYearElement = document.querySelector('.dycalendar-span-month-year');
            console.log(monthYearElement);
            const monthYearText = monthYearElement.innerText;
            console.log(monthYearText);
            // const [month, year] = monthYearText.split(' ');
            // console.log(clickedDate, month, year);
            const dateObj = new Date(`${monthYearText} ${clickedDate}`);
            const month = (dateObj.getMonth() + 1).toString().padStart(2, '0');
            const year = dateObj.getFullYear().toString();
            const eventsdate = clickedDate + '-' + month + '-' + year;
            console.log(clickedDate, month, year, eventsdate);
            get_event(eventsdate);
            // const currentDate = new Date();
            // const currentMonth = (currentDate.getMonth() + 1).toString().padStart(2, '0');
            // const currentYear = currentDate.getFullYear().toString();
            // const eventscurrentdate = currentDate + '-' + currentMonth + '-' + currentYear;
            // console.log(currentDate, currentMonth, currentYear, eventscurrentdate);


        });

    }

    $(document).ready(function() {
        const currentDate = new Date();
        const currentMonth = (currentDate.getMonth() + 1).toString().padStart(2, '0');
        const currentYear = currentDate.getFullYear().toString();
        const formattedCurrentDate = currentDate.getDate().toString().padStart(2, '0') + '-' + currentMonth + '-' + currentYear;

        get_event(formattedCurrentDate);

        // Other code within the ready function
        // ...

        // Trigger previous slide
        $('.carousel-control-prev').click(function() {
            $('#fancyControls').carousel('prev');
        });

        // Trigger next slide
        $('.carousel-control-next').click(function() {
            $('#fancyControls').carousel('next');
        });
    });
</script>
<script>

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

<script>
    $('[data-fancybox="gallery"]').fancybox({
        buttons: [
            "slideShow",
            "thumbs",
            "zoom",
            "fullScreen",
            "share",
            "close"
        ],
        loop: false,
        protect: true,
        captionPosition: "inside"
    });
    $('[data-fancybox="gallery1"]').fancybox({
        buttons: [
            "slideShow",
            "thumbs",
            "zoom",
            "fullScreen",
            "share",
            "close"
        ],
        loop: false,
        protect: true,
        captionPosition: "inside"
    });
</script> -->

@endsection