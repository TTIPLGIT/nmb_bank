@extends('layouts.elearningmain')

@section('content')
<style>
    /* remove card bocy shadow */
    .noShadow .card-body {
        box-shadow: none !important;
    }

    .card {
        box-shadow: none !important;
    }

    .main-content {
        padding-top: 80px !important;
        /* padding-left: 20px !important; */
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
        /* padding-top: 0px !important; */
        border-top: 0px solid white !important;
        background-color: white !important;
        border-radius: 10px;
        /* border-bottom-left-radius: 5px !important; */
        /* border-bottom-right-radius: 5px !important; */
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
        /* margin: 0.5rem !important; */
        border-radius: 15px !important;
        /* overflow-y: scroll; */
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
        /* padding: 0px 0px 7px 0px !important; */
        background-color: white !important;
        border-top-left-radius: 15px !important;
        border-top-right-radius: 15px !important;
    }

    .course .card-body {
        width: 100% !important;
        height: 344px;
        border-radius: 15px !important;
        /* padding: 0px !important; */
        background-color: white !important;
        border-top-left-radius: 0px !important;
        border-top-right-radius: 0px !important;
    }

    .course_and_schedule_body {
        flex-wrap: wrap !important;
        width: 100% !important;
        /* height: 420px; */
    }

    .schedule {
        width: 100% !important;
        height: auto !important;
        /* Changed from 300px to auto */
        min-height: 500px !important;
        /* Added min-height */
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
        /* height: 344px !important; */
        /* padding: 0px 0px !important; */
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
        /* height: 345px !important; */
        border: 0px !important;
        padding: 0px !important;
        /* margin: 0.5rem !important; */
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
        /* padding: 10px 0px 7px 0px !important; */
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
        /* padding: 0px !important; */
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
        width: 20% !important;
        height: 100%;
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
        width: 100%;
        height: 41%;
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

    @media (min-width:319.96px) {
        .schedule {
            width: 100% !important;
            height: auto !important;
        }
    }

    @media (min-width:424.96px) {
        /* .schedule {
            width: 70% !important;
            height: 500px !important;
        } */

        .course {
            width: 70% !important;
        }

        .overview_body .card {
            width: 80% !important;
        }

        .schedule {
            width: 100% !important;
            height: auto !important;
        }

        .noevents {
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 22px;
            font-weight: 600;
            height: 103px !important;
        }


    }

    @media (min-width:575.96px) {
        .schedule {
            width: 100% !important;
            height: auto !important;
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
    }

    @media (min-width:1024.96px) {
        .main-content {
            padding-top: 50px !important;
            padding-left: 200px !important;
        }

        .sidebar-mini .main-content {
            padding-left: 85px !important;
        }

        .sidebar-mini .main-content .overview_body .card {
            width: 204px !important;
        }

        .course {
            width: 100% !important;
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

        .main-sidebar.sidebar-style-2 {
            z-index: 0 !important;
            /* left: -250px !important; */
        }
    }

    @media (max-width:1424.96px) {
        .main-sidebar.sidebar-style-2 {
            z-index: 0 !important;
            /* left: -250px; */
        }
    }

    @media (min-width:1335.96px) {
        .main-content {
            padding-top: 80px !important;
            padding-left: 230px !important;
        }

        .main-sidebar.sidebar-style-2 {
            z-index: 0 !important;
            /* left: -250px; */
        }
    }

    @media (min-width:1440.96px) {
        .main-content {
            padding-top: 50px !important;
            padding-left: 200px !important;
        }

        .main-sidebar.sidebar-style-2 {
            z-index: 0 !important;
            /* left: -250px; */
        }
    }

    @media (min-width:1199.96px) {
        .overview_body {
            justify-content: spa ce-between !important;
        }

        .overview_body .card {
            width: 21.85% !important;
        }

        .sidebar-mini .main-content .overview_body .card {
            width: 220px !important;
        }
    }

    /* @media (min-width:1024.96px) {
        .main-sidebar.sidebar-style-2 {
            z-index: 0 !important;
            left: -250px !important;
        }
    } */

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
        /* box-shadow: 5px 5px 15px rgb(0 0 0 / 10%), -5px -5px 15px #edf1f4; */
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
        background-color: #680EDA;
        font-weight: 700;
        box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.1), -5px -5px 10px #fff;
    }

    #dycalendar table tr:first-child td:first-child {
        color: #fff;
        background-color: #FF8B4F;
    }

    #dycalendar table tr td:first-child {
        color: #FF8B4F;
    }

    .dycalendar-today-date,
    .dycalendar-today-date:hover {
        background-color: white !important;
        color: #680EDA !important;
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
        color: #680EDA;
        text-shadow: -3px 0px 5px #680EDA;
    }

    .dycalendar-prev-next-btn.next-btn:active {
        color: #680EDA;
        text-shadow: 3px 0px 5px #680EDA;
    }

    .dycalendar-span-month-year {
        font-size: 1.3rem;
        font-weight: 600;
        color: #680EDA;
    }


    @media (min-width:320px) and (max-width:575px) {
        .calendar-container {
            position: relative;
            border-radius: 10px;
            box-shadow: 5px 5px 15px rgb(0 0 0 / 10%), -5px -5px 15px #edf1f4;
            width: 100%;
            min-height: 326px;
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
            height: 568px;
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

    .nonotice {
        display: flex !important;
        justify-content: center !important;
        font-weight: 600 !important;
        font-size: 22px !important;
    }

    .caption {
        display: none;
    }

    @media (max-width: 575px) {
        .notice_board_list {
            width: 100%;
            /* Occupy full width */
        }
    }

    /* For screens between 576px and 768px (e.g., small tablets) */
    @media (min-width: 576px) and (max-width: 767px) {
        .col {
            width: 50%;
            /* Occupy half width */
        }
    }


    /* For screens between 768px and 992px (e.g., tablets) */
    @media (min-width: 768px) and (max-width: 991px) {
        .col {
            width: 33.33%;
            /* Occupy one-third width */
        }

        .main-content {
            padding-top: 80px !important;
            padding-left: 20px !important;
        }
    }

    /* For screens larger than 992px (e.g., desktops) */
    @media (min-width: 992px) {
        .col {
            width: 25%;
            /* Occupy one-fourth width */
        }
    }

    @media (min-width: 1440px) {
        .main-sidebar.sidebar-style-2 {
            z-index: 0 !important;

        }

        .main-content {
            padding-top: 80px !important;
            padding-left: 211px !important;
        }
    }


    @media (min-width: 1440px) and (max-width: 2560px) {
        .main-sidebar.sidebar-style-2 {
            z-index: 0 !important;

        }
    }
</style>
<style>
    .card-span {
        color: #680EDA !important;
        font-size: 12px;
        font-weight: bold;
    }

    .highlighted-date {
        background-color: blue;
        /* Yellow background for highlighted dates */
        color: #000;
        /* Optional: change text color for better contrast */
    }
</style>

<style>
    /* ============== FIXED EVENTS CAROUSEL STYLES ============== */

    /* Override the conflicting schedule style */
    .schedule {
        width: 100% !important;
        height: auto !important;
        min-height: 500px !important;
        border: 0px !important;
        margin: 0 !important;
        border-radius: 5px !important;
        overflow: hidden !important;
    }

    /* Main container layout */
    .course_and_schedule_body {
        display: flex !important;
        flex-direction: row !important;
        width: 100% !important;
        gap: 20px !important;
    }

    .schedule .card-body {
        display: flex !important;
        flex-direction: row !important;
        flex-wrap: nowrap !important;
        gap: 20px !important;
        padding: 20px !important;
        background: white !important;
        border-radius: 15px !important;
        min-height: 500px !important;
        width: 100% !important;
    }

    /* Calendar container - LEFT SIDE */
    .calendar-container {
        flex: 0 0 48% !important;
        max-width: 48% !important;
        min-width: 300px !important;
        min-height: 450px !important;
        background: #ffffff !important;
        border-radius: 10px !important;
        padding: 10px !important;
    }

    /* Events container - RIGHT SIDE */
    .events_today_wrapper {
        flex: 1 1 48% !important;
        min-width: 300px !important;
        height: 450px !important;
        max-height: 450px !important;
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        background: #f8f9fc !important;
        border-radius: 12px !important;
        padding: 0 !important;
        margin-top: 0 !important;
        position: relative !important;
        overflow: hidden !important;
    }

    /* Events carousel container */
    .events-carousel-container {
        background: #f8f9fc;
        border-radius: 12px;
        padding: 15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        width: 100%;
        height: 100% !important;
        display: flex;
        flex-direction: column;
    }





    /* Event Type Colors */
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

    /* Carousel Indicators */
    .carousel-indicators {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 10px;
        min-height: 15px;
        flex-shrink: 0;
    }

    .carousel-indicator {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #dee2e6;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-block;
    }

    .carousel-indicator:hover {
        background: #adb5bd;
    }

    .carousel-indicator.active {
        width: 20px !important;
        border-radius: 4px !important;
        background: #680EDA !important;
    }

    /* No Events Message */
    .noevents {
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 22px;
        font-weight: 600;
        height: 100% !important;
        color: #FF8B4F;
        background: #f8f9fc;
        border-radius: 12px;
        min-height: 300px;
    }

    /* Calendar Highlighted Dates */
    .highlighted-date {
        background-color: #680EDA !important;
        color: white !important;
        border-radius: 5px !important;
        font-weight: bold !important;
    }

    /* Marquee Styles */
    .events-marquee-container {
        background: #f8f9fc;
        border-radius: 12px;
        padding: 15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .marquee-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        flex-shrink: 0;
    }

    .marquee-header h4 {
        margin: 0;
        color: #680EDA !important;
        font-weight: 600;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
    }

    .marquee-header h4 i {
        margin-right: 8px;
        color: #680EDA;
    }

    .marquee-header h4 span {
        font-size: 0.85rem;
        color: #6c757d;
        margin-left: 8px;
        font-weight: normal;
    }

    .marquee-wrapper {
        flex: 1;
        overflow: hidden;
        position: relative;
        height: 100%;
        mask-image: linear-gradient(to bottom, transparent 0%, black 10%, black 90%, transparent 100%);
        -webkit-mask-image: linear-gradient(to bottom, transparent 0%, black 10%, black 90%, transparent 100%);
    }

    .marquee-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        will-change: transform;
    }

    /* Marquee Animation */
    @keyframes marquee-scroll {
        0% {
            transform: translateY(0);
        }

        100% {
            /* Move up by total height minus one item height to show all items once */
            transform: translateY(calc(-100% + 70px));
        }
    }

    .clone-item {
        opacity: 0.95;
        /* Slightly different to show it's a clone */
    }

    .marquee-wrapper::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 30px;
        background: linear-gradient(to bottom, transparent, #f8f9fc);
        pointer-events: none;
        z-index: 1;
    }

    /* Pause animation on hover */
    .marquee-wrapper:hover .marquee-list {
        animation-play-state: paused !important;
    }

    .marquee-item {
        flex-shrink: 0;
        width: 100%;
    }

    .marquee-item .card {
        margin: 0 !important;
        cursor: pointer;
        width: 100%;
        border-radius: 8px !important;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .marquee-item .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1) !important;
    }

    .marquee-item .card a {
        display: flex !important;
        justify-content: space-evenly !important;
        align-items: center !important;
        gap: 10px !important;
        text-decoration: none;
        color: inherit;
        padding: 10px !important;
    }

    .marquee-item .card img {
        height: 60px !important;
        width: 100px !important;
        object-fit: cover;
        border-radius: 5px;
    }

    .marquee-item .card .event-name {
        margin: 0;
        font-weight: 600;
        color: #333;
        max-width: 150px;
        font-size: 0.95rem;
    }

    .marquee-item .card small {
        color: #6c757d;
        font-size: 0.75rem;
        display: block;
    }


    /* Responsive */
    @media (min-width: 1200px) {
        .carousel-slide {
            flex: 0 0 280px;
            width: 280px;
        }
    }

    @media (min-width: 768px) and (max-width: 1199px) {
        .carousel-slide {
            flex: 0 0 240px;
            width: 240px;
        }

        .calendar-container,
        .events_today_wrapper {
            flex: 0 0 48% !important;
        }

        .events_today_wrapper {
            height: 400px !important;
            max-height: 400px !important;
        }
    }

    @media (max-width: 767px) {
        .course_and_schedule_body {
            flex-direction: column !important;
        }

        .schedule .card-body {
            flex-direction: column !important;
        }

        .calendar-container,
        .events_today_wrapper {
            flex: 0 0 100% !important;
            max-width: 100% !important;
            width: 100% !important;
        }

        .events_today_wrapper {
            margin-top: 20px !important;
            height: 350px !important;
            max-height: 350px !important;
        }

        .carousel-slide {
            flex: 0 0 240px;
            width: 240px;
        }
    }

    /* Caption hidden by default */
    .caption {
        display: none;
    }

    /* Ellipsis for long text */
    .ellipsis {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .expanded {
        white-space: normal;
        max-width: none;
    }

    /* Dycalendar styles */
    .dycalendar-today-date {
        background-color: white !important;
        color: #680EDA !important;
        font-weight: 700 !important;
    }

    .dycalendar-month-container .dycalendar-body table tr td {
        padding: 2px 6px;
        color: #777;
        border: 1px solid #edf1f4;
        border-radius: 5px !important;
        cursor: pointer;
        font-size: 0.8rem;
        font-weight: 500;
    }
</style>

<!-- recommended course -->
<style>
    .udemy-card {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        transition: 0.3s;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        cursor: pointer;
    }

    .udemy-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    /* IMAGE */
    .udemy-img {
        position: relative;
        overflow: hidden;
    }

    .udemy-img img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        transition: 0.4s;
    }

    .udemy-card:hover .udemy-img img {
        transform: scale(1.08);
    }

    /* BADGE */
    .udemy-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: #5624d0;
        color: #fff;
        padding: 3px 8px;
        font-size: 11px;
        border-radius: 4px;
    }

    /* CONTENT */
    .udemy-content {
        padding: 12px;
    }

    /* TITLE */
    .udemy-title {
        font-size: 14px;
        font-weight: 600;
        height: 40px;
        overflow: hidden;
    }

    /* INSTRUCTOR */
    .udemy-instructor {
        font-size: 12px;
        color: #777;
        margin-bottom: 5px;
    }

    /* RATING */
    .udemy-rating {
        font-size: 13px;
        font-weight: 600;
        color: #b4690e;
    }

    .udemy-rating span {
        color: #777;
        font-weight: normal;
    }

    /* META */
    .udemy-meta {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        margin-top: 5px;
        color: #666;
    }

    /* AI SCORE */
    .udemy-ai {
        margin-top: 8px;
        font-size: 12px;
        color: #5624d0;
        font-weight: 600;
    }

    .section-title {
        font-weight: 700;
        font-size: 20px;
        margin-bottom: 2px;
    }

    .section-subtitle {
        font-size: 13px;
        color: #777;
        margin-bottom: 0;
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


    <div class="section-body mt-1" style="position:absolute; z-index:-1">
        <div class="overview_container container-fluid">
            <div class="overview_header d-flex flex-row justify-content-between align-items-center" style="">

                <!-- <h2 class="overview_heading">
                        Overview
                        <div class="path">
                            <span>E-Learning</span>
                            <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                            <span>Dashboard</span>
                        </div>
                    </h2> -->

                <!-- <select class="custom-select overview_filter">
                        <option value="Yearly" selected>Overall</option>
                        <option value="Yearly">Yearly</option>
                        <option value="Monthly">Monthly</option>
                        <option value="Weekly">Weekly</option>
                        <option value="Daily">Daily</option>
                    </select> -->
            </div>
            <div class="container-fluid d-flex flex-row  justify-content-sm-start overview_body"
                style="display: flex !important;justify-content: space-between !important;">
                <div class="card noShadow">
                    <div class="card-body d-flex" style="align-items:center">
                        <div style="width:40%">
                            <img class="overview_img" id="overview_img_exception"
                                src="{{asset('asset/image/progresscourse.png')}}" alt="Course in Progress" width="40%">
                        </div>
                        <div class="justify-content-between align-items-center">

                            <span class="overview_count">{{$count['course_progress'][0]['course_progress']}}</span><br>
                            <span class="card-span">Course in Progress</span>
                        </div>
                    </div>
                </div>
                <div class="card noShadow">
                    <div class="card-body d-flex" style="align-items:center">
                        <div style="width:40%">
                            <img class="overview_img" id="overview_img_exception"
                                src="{{asset('asset/image/completed.png')}}" alt="Course Completed" width="40%">

                        </div>
                        <div class="justify-content-between align-items-center">
                            <span
                                class="overview_count">{{$count['course_completed'][0]['course_completed']}}</span><br>
                            <span class="card-span">Course Completed</span>
                        </div>
                    </div>
                </div>
                <!-- <div class="card noShadow">
                        <div class="card-header">
                            <span>Watching Time</span>
                        </div>
                        <div class="card-body d-flex flex-row justify-content-between align-items-center">
                            <span class="overview_count">10h <sub>20m</sub></span>
                            <img class="overview_img" src="{{asset('asset/image/watchingTime.png')}}" alt="Watching Time" width="40%">
                        </div>
                    </div> -->
                <div class="card noShadow">
                    <div class="card-body d-flex" style="align-items:center">
                        <div style="width:40%">
                            <img class="overview_img" id="overview_img_exception"
                                src="{{asset('asset/image/awards.png')}}" alt="Certificates Achieved" width="40%">
                        </div>
                        <div class="justify-content-between align-items-center">
                            <span
                                class="overview_count">{{$count['course_certificate'][0]['course_certificate']}}</span><br>
                            <span class="card-span">Certificates Earned</span>
                        </div>
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
                <div class="card noShadow">
                    <div class="card-body d-flex" style="align-items:center">
                        <div style="width:40%">
                            <img class="overview_img" id="overview_img_exception"
                                src="{{asset('asset/image/trophy.png')}}" alt="Credits Earned" width="40%">
                        </div>
                        <div class="justify-content-between align-items-center">
                            <span class="overview_count">{{ $total_cpd_points['total_points'] }}</span><br>
                            <span class="card-span">Credits Earned</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid course_and_schedule_container">
                <div class="d-flex flex-row course_and_schedule_body w-100">
                    <div class="card noShadow schedule" style="width: 100% !important;">

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

            <div class="container-fluid noticess course_and_schedule_container" style="margin-top:2%">
                <div class="d-flex flex-row course_and_schedule_body w-100">
                    <div class="card noShadow notice_board_list" style="width:100% !important">

                        @php $class_list = count($rows) == 0 ? "d-flex justify-content-center align-items-center" : '' @endphp
                        <div class="card-body {{$class_list}}">
                            @if(count($rows) == 0)
                            <div class="nonotice" style="color:#680EDA">No Notice Found</div>
                            @endif
                            @foreach($rows as $key => $row)
                            <div class="d-flex flex-row justify-content-around notice_board">
                                @php $path = $row['notice_path'] . '/' . $row['notice_banner'];@endphp
                                @if(file_exists(substr($path, 1)))
                                <img class="notice_board_poster noticeHasFancy"
                                    src="{{$row['notice_path']}}/{{$row['notice_banner']}}" alt="Notice Board"
                                    onclick="makeFancy(event, 'noticeHasFancy')">
                                <span class="caption">{!!html_entity_decode($row['notice_description'])!!}</span>


                                @else
                                <img class="notice_board_poster noticeHasFancy" src="{{$row['notice_path']}}/empty.jpg"
                                    alt="Notice Board" onclick="makeFancy(event, 'noticeHasFancy')">
                                <span class="caption">{!!html_entity_decode($row['notice_description'])!!}</span>


                                @endif

                                <!-- <img style="height:200px !important;width:300" class="notice_board_poster noticeHasFancy" src="{{$row['notice_path']}}/{{$row['notice_banner']}}" data-caption="{{$row['notice_description']}}" alt="Notice Board" onclick="makeFancy(event, 'noticeHasFancy')"> -->
                                <!-- <div class="hover_plus_wrapper">
                                                                                                <div class="hover_plus">
                                                                                                    <i class="bi bi-plus" aria-hidden="true"></i>
                                                                                                </div>
                                                                                            </div> -->

                                <div class="d-flex flex-column justify-content-around notice_board_heading">
                                    <h6 class="notice_board_event_name event-name ellipsis">
                                        {{$row['notice_name']}}
                                    </h6>
                                    <span class="notice_board_event_organiser">
                                        {{$row['notice_date']}}
                                    </span>
                                </div>
                                <br>

                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid course_and_schedule_container" style="margin-top:2%;margin-bottom:2%">
                <div class="card course_and_schedule_container" style="background-color:white;border-radius:15px !important">
                    <div class="noShadow recommended_courses_list ">
                        <div class="d-flex mb-3">
                            <div style="width:100%;text-align:center">
                                <h5 class="section-title" style="color:#680EDA">Recommended for You</h5>
                                <p class="section-subtitle" style="color:red">
                                    Courses picked based on your activity and interests
                                </p>
                            </div>

                        </div>
                        <div class="row">

                            @foreach($recommended as $row)
                            <div class="col-md-6 col-lg-3 mb-4">

                                <div class="udemy-card">

                                    <!-- Image -->
                                    <div class="udemy-img">
                                        @php
                                        $bannerPath = 'uploads/class/126/' . ($row['course_banner'] ?? '');
                                        @endphp

                                        <img src="{{ (!empty($row['course_banner']) && file_exists(public_path($bannerPath))) 
                                    ? asset($bannerPath) 
                                    : asset('uploads/class/126/empty.jpg') }}"
                                            alt="Course">

                                        <!-- AI Badge -->
                                        @if(!empty($row['recommendation_type']))
                                        <span class="udemy-badge">
                                            {{ ucfirst(str_replace('_', ' ', $row['recommendation_type'])) }}
                                        </span>
                                        @endif
                                    </div>

                                    <!-- Content -->
                                    <div class="udemy-content">

                                        <!-- Title -->
                                        <h6 class="udemy-title">
                                            {{ $row['course_name'] ?? 'Untitled Course' }}
                                        </h6>

                                        <!-- Instructor -->
                                        <p class="udemy-instructor">
                                            {{ $row['course_instructor'] ?? 'N/A' }}
                                        </p>

                                        <!-- Rating -->
                                        <div class="udemy-rating">
                                            ⭐ 4.5
                                            <span>(120)</span>
                                        </div>

                                        <!-- Meta -->
                                        <div class="udemy-meta">
                                            <span>⏱ {{ $row['duration'] ?? '-' }}</span>
                                            <span>👥 {{ ($row['total_student'] ?? 0) ?: '0' }}</span>
                                        </div>

                                        <!-- AI Confidence -->
                                        @if(isset($row['confidence_score']))
                                        <div class="udemy-ai">
                                            AI {{ round($row['confidence_score'] * 100) }}% Match
                                        </div>
                                        @endif

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
</div>
<!-- Vertically centered modal -->
<div class="modal fade" id="event_poster_modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
<div class="modal fade" id="fancyContainer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="fancyContainerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title" id="fancyContainerLabel">Modal title</h5> -->
                <div class="col-md-12" style="display: flex;justify-content: flex-end;">
                    <button class="closefancy" onclick="removefancy()"><span aria-hidden="true"><i class="fa fa-times"
                                aria-hidden="true"></i></span></button>
                </div>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body" id="fancyWrapper">

                <div id="fancyControls" class="carousel slide" data-bs-ride="carousel">
                    <!-- js code -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#fancyControls"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <!-- <span class="visually-hidden">Previous</span> -->
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#fancyControls"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <!-- <span class="visually-hidden">Next</span> -->
                    </button>
                </div>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button>
            </div> -->
        </div>
    </div>
</div>

<!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Course', 'Percentege'],
          ['Completed', 80],
          ['Pending', 20],
          
        ]);

        var options = {
          title: 'Course1',
          pieHole: 0.5,
          pieStartAngle: -45,
          chartArea:{
                    left:15,
                    right:15,
                    top:40,
                    bottom:20,
                    width:'50%',
                    height:'75%'
                }
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
</script> -->
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



<!-- events script -->
<script type="text/javascript" src="{{ asset('asset/js/calender.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- events script -->


<script>
    // ============== HELPER FUNCTIONS ==============
    function toggleExpansion(e) {
        e.target.classList.toggle("ellipsis");
    }

    function removefancy() {
        $('#fancyContainer').modal('hide');
        let fancycontrols = document.querySelector('#fancyControls');
        if (fancycontrols && fancycontrols.firstChild) {
            fancycontrols.removeChild(fancycontrols.firstChild);
        }
    }

    function makeFancy(e, selector) {
        const eventsgallery = document.querySelectorAll(`.${selector}`);
        if (!eventsgallery.length) return;

        let modalBody = document.createElement('div');
        modalBody.setAttribute('id', 'fancyContainerInner');
        modalBody.classList.add('carousel-inner');

        for (let eventGallery of eventsgallery) {
            let carouselItem = document.createElement('div');
            if (e.target === eventGallery) {
                carouselItem.classList.add('carousel-item', 'active');
            } else {
                carouselItem.classList.add('carousel-item');
            }
            let imgTag = document.createElement('img');
            imgTag.src = eventGallery.src;
            imgTag.style.width = '100%';
            imgTag.style.height = 'auto';

            let caption = eventGallery.parentElement?.querySelector('.caption')?.innerHTML || '';
            let captionContainer = document.createElement('div');
            captionContainer.innerHTML = caption;
            captionContainer.style.padding = '20px';
            captionContainer.style.textAlign = 'center';

            carouselItem.appendChild(imgTag);
            carouselItem.appendChild(captionContainer);
            modalBody.appendChild(carouselItem);
        }

        let fancyControls = document.querySelector('#fancyControls');
        if (fancyControls) {
            const existingInner = document.querySelector('#fancyContainerInner');
            if (existingInner) existingInner.remove();
            fancyControls.prepend(modalBody);
        }

        $('#fancyContainer').modal('show');
        setTimeout(() => {
            $('#fancyControls').carousel('cycle');
        }, 100);
    }

    // ============== CALENDAR INITIALIZATION ==============
    $(document).ready(function() {
        console.log('Document ready - initializing calendar and events');

        // Initialize calendar
        if (typeof dycalendar !== 'undefined') {
            dycalendar.draw({
                target: "#dycalendar",
                type: "month",
                highlighttoday: true,
                prevnextbutton: "show"
            });
        }

        // Load all events
        setTimeout(loadAllEvents, 500);

        // Calendar click handler
        function handleCalendarClick(e) {
            const td = e.target.closest('td');
            if (!td) return;

            const clickedDate = td.innerText.trim().padStart(2, '0');
            const monthYearElement = document.querySelector('.dycalendar-span-month-year');

            if (monthYearElement && clickedDate && !isNaN(parseInt(clickedDate))) {
                const monthYearText = monthYearElement.innerText;
                const dateObj = new Date(`${monthYearText} ${clickedDate}`);

                if (!isNaN(dateObj.getTime())) {
                    const month = (dateObj.getMonth() + 1).toString().padStart(2, '0');
                    const year = dateObj.getFullYear().toString();
                    const eventsdate = clickedDate + '-' + month + '-' + year;
                    console.log('Date clicked:', eventsdate);
                    get_event(eventsdate);
                }
            }
        }

        // Attach click handler
        function attachCalendarClick() {
            document.querySelectorAll('.dycalendar-body table td').forEach(td => {
                td.removeEventListener('click', handleCalendarClick);
                td.addEventListener('click', handleCalendarClick);
            });
        }

        setTimeout(attachCalendarClick, 1000);

        // Observer for calendar changes
        const calendarObserver = new MutationObserver(attachCalendarClick);
        const calendarElement = document.getElementById('dycalendar');
        if (calendarElement) {
            calendarObserver.observe(calendarElement, {
                childList: true,
                subtree: true
            });
        }
    });

    // ============== EVENTS CAROUSEL FUNCTIONS ==============

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

    function getSlidesPerView() {
        if (window.innerWidth >= 1200) return 3;
        if (window.innerWidth >= 768) return 2;
        return 1;
    }

    function highlightDates(eventDates) {
        setTimeout(() => {
            document.querySelectorAll('.dycalendar-body table td').forEach(td => {
                td.classList.remove('highlighted-date');
                td.style.backgroundColor = '';
                td.style.color = '';
                td.style.fontWeight = '';
            });

            eventDates.forEach(date => {
                if (!date) return;
                const day = date.split('-')[0];
                document.querySelectorAll('.dycalendar-body table td').forEach(td => {
                    if (td.innerText.trim() === day) {
                        td.classList.add('highlighted-date');
                        td.style.backgroundColor = '#680EDA';
                        td.style.color = 'white';
                        td.style.fontWeight = 'bold';
                    }
                });
            });
        }, 200);
    }

    function displayEventsInCarousel(events, title) {
        console.log('displayEventsInCarousel called with:', events.length, 'events', title);

        // Clear existing content
        $('.events_today_wrapper').empty();

        if (!events || events.length == 0) {
            console.log('No events to display');
            $('.events_today_wrapper').html(`
            <div class="noevents">No Events Found</div>
        `);
            return;
        }

        console.log('Building marquee HTML with', events.length, 'events');

        let marqueeHtml = `
        <div class="events-marquee-container">
            <div class="marquee-header">
                <h4>
                    <i class="fas fa-calendar-alt"></i> ${title}
                    <span>(${events.length} events)</span>
                </h4>
            </div>
            <div class="marquee-wrapper">
                <div class="marquee-list">
        `;

        let count = 1;
        // Show each event exactly once
        events.forEach((row) => {
            if (count >= 5) count = 1;

            let imagePath = '/asset/image/empty.jpg';
            if (row.event_image && row.event_image !== '/empty.jpg') {
                imagePath = row.event_image.startsWith('/') ? row.event_image : `/uploads/notice/126/${row.event_image}`;
            }

            marqueeHtml += `
            <div class="marquee-item">
                <div class="card event_type event_type_${count}">
                    <a class="alignments">
                        <img class="events_image eventsHasFancy" 
                             src="${imagePath}" 
                             alt="${row.event_name}"
                             onclick="makeFancy(event, 'eventsHasFancy')"
                             onerror="this.src='/asset/image/empty.jpg'">
                        <span class="caption" style="display:none;">${row.event_description || ''}</span>
                        <div>
                            <p class="event-name ellipsis" title="${row.event_name}">${row.event_name}</p>
                            <small>${row.event_time || 'All Day'}</small>
                        </div>
                    </a>
                </div>
            </div>
        `;
            count++;
        });

        // ONLY add clone if there are MORE THAN 1 event
        if (events.length > 1) {
            // Add a clone of the first event at the end for seamless transition
            let firstEvent = events[0];
            let firstCount = 1;

            let firstImagePath = '/asset/image/empty.jpg';
            if (firstEvent.event_image && firstEvent.event_image !== '/empty.jpg') {
                firstImagePath = firstEvent.event_image.startsWith('/') ? firstEvent.event_image : `/uploads/notice/126/${firstEvent.event_image}`;
            }

            marqueeHtml += `
            <div class="marquee-item clone-item">
                <div class="card event_type event_type_${firstCount}">
                    <a class="alignments">
                        <img class="events_image eventsHasFancy" 
                             src="${firstImagePath}" 
                             alt="${firstEvent.event_name}"
                             onclick="makeFancy(event, 'eventsHasFancy')"
                             onerror="this.src='/asset/image/empty.jpg'">
                        <span class="caption" style="display:none;">${firstEvent.event_description || ''}</span>
                        <div>
                            <p class="event-name ellipsis" title="${firstEvent.event_name}">${firstEvent.event_name}</p>
                            <small>${firstEvent.event_time || 'All Day'}</small>
                        </div>
                    </a>
                </div>
            </div>
        `;
        }

        marqueeHtml += `
                </div>
            </div>
        </div>
        `;

        $('.events_today_wrapper').html(marqueeHtml);
        console.log('Marquee HTML appended to wrapper');

        // Initialize marquee animation
        setTimeout(() => {
            initializeMarquee(events.length);
        }, 100);

        setTimeout(() => {
            document.querySelectorAll(".event-name").forEach(el => {
                el.addEventListener("click", toggleExpansion);
            });
        }, 200);
    }

    // Update initializeMarquee function
    function initializeMarquee(eventCount) {
        const wrapper = document.querySelector('.marquee-wrapper');
        const list = document.querySelector('.marquee-list');

        if (!wrapper || !list) return;

        const items = list.children;
        if (items.length === 0) return;

        // Remove any existing animation
        list.style.animation = 'none';

        // If only one event, no need to animate
        if (eventCount <= 1) {
            console.log('Single event - no animation needed');
            return;
        }

        // Force reflow
        void list.offsetHeight;

        // Calculate total height
        const itemHeight = items[0].offsetHeight + 10; // height + gap
        const totalHeight = itemHeight * (items.length - 1); // Exclude clone from height calculation

        // Set animation duration based on number of items
        const duration = Math.max(15, items.length * 1.5);

        // Apply animation
        list.style.animation = `marquee-scroll ${duration}s linear infinite`;

        // Pause on hover
        wrapper.addEventListener('mouseenter', () => {
            list.style.animationPlayState = 'paused';
        });

        wrapper.addEventListener('mouseleave', () => {
            if (eventCount > 1) {
                list.style.animationPlayState = 'running';
            }
        });
    }

    // ============== API CALLS - FIXED FOR YOUR RESPONSE STRUCTURE ==============

    function loadAllEvents() {
        console.log('Loading all events...');
        $.ajax({
            url: "{{ url('/dashboardevents/fetch') }}",
            type: 'GET',
            data: {
                _token: '{{csrf_token()}}'
            },
            success: function(response) {
                console.log('All events response:', response);

                // FIX: Check if response has rows directly
                if (response && response.rows) {
                    displayEventsInCarousel(response.rows, 'All Events');
                    const eventDates = new Set(response.rows.map(row => row.event_date));
                    highlightDates(eventDates);
                }
                // FIX: Check if response has Data with rows
                else if (response && response.Data) {
                    let data = typeof response.Data === 'string' ? JSON.parse(response.Data) : response.Data;
                    if (data.rows) {
                        displayEventsInCarousel(data.rows, 'All Events');
                        const eventDates = new Set(data.rows.map(row => row.event_date));
                        highlightDates(eventDates);
                    } else {
                        displayEventsInCarousel([], 'All Events');
                    }
                } else {
                    console.log('No events data found in response');
                    displayEventsInCarousel([], 'All Events');
                }
            },
            error: function(xhr, status, error) {
                console.log('Error loading events:', error);
                displayEventsInCarousel([], 'All Events');
            }
        });
    }

    function get_event(eventsdate) {
        console.log('Loading events for date:', eventsdate);
        $.ajax({
            url: "{{ url('/dashboardevents/fetch') }}",
            type: 'GET',
            data: {
                'event_date': eventsdate,
                _token: '{{csrf_token()}}'
            },
            success: function(response) {
                console.log('Date events response:', response);

                // FIX: Check if response has rows directly
                if (response && response.rows) {
                    displayEventsInCarousel(response.rows, `Events for ${formatDisplayDate(eventsdate)}`);
                    const eventDates = new Set(response.rows.map(row => row.event_date));
                    highlightDates(eventDates);
                }
                // FIX: Check if response has Data with rows
                else if (response && response.Data) {
                    let data = typeof response.Data === 'string' ? JSON.parse(response.Data) : response.Data;
                    if (data.rows) {
                        displayEventsInCarousel(data.rows, `Events for ${formatDisplayDate(eventsdate)}`);
                        const eventDates = new Set(data.rows.map(row => row.event_date));
                        highlightDates(eventDates);
                    } else {
                        displayEventsInCarousel([], `Events for ${formatDisplayDate(eventsdate)}`);
                    }
                } else {
                    console.log('No events data found in response');
                    displayEventsInCarousel([], `Events for ${formatDisplayDate(eventsdate)}`);
                }
            },
            error: function(xhr, status, error) {
                console.log('Error loading date events:', error);
                displayEventsInCarousel([], `Events for ${formatDisplayDate(eventsdate)}`);
            }
        });
    }

    // Remove any duplicate event listeners that might be causing the error
    document.addEventListener('DOMContentLoaded', function() {
        // This ensures no duplicate listeners
    });
</script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script> -->

<!-- <script>
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
        protect: true
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