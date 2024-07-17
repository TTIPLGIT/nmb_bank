<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>TTIPL - LMS</title>

    <!-- General CSS Files -->
    <link href="{{asset('asset/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('asset/bundles/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('asset/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />

    <!-- Bootstrap v4.3.1 CSS File -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <link href="{{ asset('css/bootstrap-icons.css') }}" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-icons.1.8.2.css') }}" />

    <!-- Font-Awesome v4.2.0 -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" type="text/css" rel="stylesheet" />

    <!--dropzone css -->
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('js/jquery.3.5.1.min.js') }}"></script>
    <script src="{{ asset('js/jAlert.4.9.1.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/jAlert@4.9.1/dist/jAlert.min.js"></script>


    <link href="{{asset('css/select2.css')}}" type="text/css" rel="stylesheet" />

    <!-- Template CSS -->
    <link href="{{asset('asset/css/style.css')}}" type="text/css" rel="stylesheet" />
    <link href="{{asset('asset/css/components.css')}}" type="text/css" rel="stylesheet" />
    <!-- Custom style CSS -->
    <link href="{{asset('asset/css/custom.css')}}" type="text/css" rel="stylesheet" />
    <link type="text/css" href="{{ asset('css/smoothness_jquery-ui.css') }}" rel="stylesheet">

    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" type="text/css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="{{ asset('css/hummingbird_v1.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/hummingbird_treeview.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/select2.css') }}" />

    <!-- <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css"> -->
    <link href="{{ asset('css/sweet-alertv2.css') }}" rel="stylesheet">
    <script src="{{ asset('js/sweetalert_1.1.3_ajax.min.js') }}"></script>

    <link rel="stylesheet" href="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <link href="{{ asset('css/dropzone_4.3.0.css') }}" rel="stylesheet">



    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/dropzone.css" rel="stylesheet">
    <script src="{{ asset('js/sweetalert_1.1.3_ajax.min.js') }}"></script>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script> -->

    <script src="{{ asset('js/dropzone.js') }}"></script>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/dropzone.js"></script> -->

    <script type="text/javascript" src="{{ asset('js/hummingbird_treeview.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/select2.js') }}"></script>



    <link href="{{asset('assets/css/adminnavbar.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{asset('assets/css/calender.css')}}" rel="stylesheet" type="text/css" />
    <!-- <link rel="icon" href="{{ url('css/favicon.png') }}" sizes="32x32"> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/fonts_family.css') }}" />

    <!-- <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@700&display=swap" rel="stylesheet"> -->



    <link href="{{ asset('assets/css/mediaquery.css') }}" rel="stylesheet" type="text/css" />


    <!-- loading gif -->
    <!-- Ck editor -->
    <script type="text/javascript" src="{{ asset('js/tinymce.min.js') }}"></script>

    <!-- <script src="https://cdn.tiny.cloud/1/1pvpoo3olz0n1t42br79z0fne5gce6ayj2lt9hmmcg04gqkg/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> -->

    <style>
        ul.second_Menu {
            position: relative !important;
            margin-top: 0px !important;
        }

        .li {
            padding-top: 10px;
        }

        .nav11 {
            background-color: #D1812E !important;

        }
    </style>
    <style>
        .fs-7 {
            font-size: 0.8rem !important;
        }

        .fs-8 {
            font-size: 0.6rem !important;
        }

        .p-01 {
            padding: 0.1rem !important;
        }

        .border-0d6efd63 {
            border-color: #0d6efd63 !important;
        }

        /* .border-00ffff{
                border-color: #00ffff !important;
            } */
        .card-height {
            height: 20rem !important;
        }

        .card-body-height {
            height: 10rem !important;
        }

        .card-header-height {
            height: 13rem !important;
        }

        .bg-fff5cc {
            background-color: #a190f0 !important;
        }

        .bg-99ffbb {
            background-color: #8974ec !important;
        }

        .bg-ccffff {
            background-color: #eaf5f3 !important;
        }

        .text-d8c4c4 {
            color: #d8c4c4 !important;
        }

        .text-f2bf26 {
            color: black !important;
        }

        .text-b34700 {
            color: #da6969 !important;
        }

        .text-fae333 {
            color: #fae333 !important;
            font-weight: 600 !important;
        }

        .bg-fae333 {
            background-color: #fcee85 !important;
        }

        .bg-ffcccc {
            background-color: #ffcccc !important;
        }

        .bg-smokewhite {
            background-color: white !important;
        }

        .scroll {
            -ms-overflow-style: none;
            scrollbar-width: none;
            height: 200px;
            display: flex;
            flex-direction: column;
            overflow-y: scroll;
        }

        .flow-width {
            width: 4.5rem !important;
        }

        @media (min-width:374.96px) {
            .flow-width {
                width: 2.5rem !important;
            }

            .navnotify {
                padding-right: 12px !important;
            }

        }

        @media (min-width:424.96px) {
            .flow-width {
                width: 2.5rem !important;
            }

            .navigation {
                /* position: fixed; */
                top: 0;
                display: flex !important;
                align-items: end !important;
                margin-left: 0px !important;
            }

            .navnotify {
                padding-right: 0px !important;
            }
        }

        @media (min-width:575.96px) {
            .flow-width {
                width: 2.5rem !important;
            }

            .navnotify {
                padding-right: 90px !important;
            }
        }

        @media (min-width:767.96px) {
            .flow-width {
                width: 2.5rem !important;
            }

            .navnotify {
                padding-right: 20px !important;
            }

            .navigation {
                display: flex !important;
                align-items: end !important;
                margin-left: 145px !important;

            }
        }

        @media (min-width:991.96px) {
            .col-lg-2-5 {
                flex: 0 0 auto;
                width: 20.5%;
            }

            .flow-width {
                width: 3.5rem !important;
            }
        }

        @media (min-width:1199.96px) {
            .flow-width {
                width: 4.5rem !important;
            }

        }
    </style>
    <style>
        .fs-7 {
            font-size: 0.8rem !important;
        }

        .fs-8 {
            font-size: 0.6rem !important;
        }

        .p-01 {
            padding: 0.1rem !important;
        }

        .border-0d6efd63 {
            border-color: #0d6efd63 !important;
        }

        /* .border-00ffff{
                border-color: #00ffff !important;
            } */
        .card-height {
            height: 20rem !important;
        }

        .card-body-height {
            height: 10rem !important;
        }

        .card-header-height {
            height: 13rem !important;
        }

        .bg-fff5cc {
            background-color: #a190f0 !important;
        }

        .bg-99ffbb {
            background-color: #8974ec !important;
        }

        .bg-ccffff {
            background-color: #eaf5f3 !important;
        }

        .text-d8c4c4 {
            color: #d8c4c4 !important;
        }

        .text-f2bf26 {
            color: black !important;
        }

        .text-b34700 {
            color: #da6969 !important;
        }

        .text-fae333 {
            color: #fae333 !important;
            font-weight: 600 !important;
        }

        .bg-fae333 {
            background-color: #fcee85 !important;
        }

        .bg-ffcccc {
            background-color: #ffcccc !important;
        }

        .bg-smokewhite {
            background-color: white !important;
        }

        .scroll {
            -ms-overflow-style: none;
            scrollbar-width: none;
            height: 200px;
            display: flex;
            flex-direction: column;
            overflow-y: scroll;
        }

        .flow-width {
            width: 4.5rem !important;
        }

        @media (min-width:374.96px) {
            .flow-width {
                width: 2.5rem !important;
            }
        }

        @media (min-width:424.96px) {
            .flow-width {
                width: 2.5rem !important;
            }
        }

        @media (min-width:575.96px) {
            .flow-width {
                width: 2.5rem !important;
            }
        }

        @media (min-width:767.96px) {
            .flow-width {
                width: 2.5rem !important;
            }
        }

        @media (min-width:991.96px) {
            .col-lg-2-5 {
                flex: 0 0 auto;
                width: 20.5%;
            }

            .flow-width {
                width: 3.5rem !important;
            }
        }

        @media (min-width:1199.96px) {
            .flow-width {
                width: 4.5rem !important;
            }
        }
    </style>

    <style>
        @media (min-width:319.96px) {
            .search-box {
                width: 140px !important;
                position: relative !important;
            }

            #bell {
                position: absolute;
                top: 18px !important;
                right: 60px !important;
            }

            .nav11 {
                padding: 0px !important;
            }

            .navigation {

                display: flex !important;
                align-items: end !important;
                margin-left: 0px !important;

            }
        }

        @media (min-width:374.96px) {
            .search-box {
                width: 186px !important;
            }

            .navigation {
                /* position: fixed; */
                top: 0;
                display: flex !important;
                align-items: end !important;
                margin-left: 0px !important;
            }
        }

        @media (min-width:424.96px) {
            .search-box {
                width: 190px !important;
            }

            .navigation {
                display: flex !important;
                align-items: end !important;
                margin-left: 0px !important;

            }
        }

        @media (min-width:575.96px) {
            .search-box {
                width: 330px !important;
            }

            #bell {
                position: absolute;
                top: 4px !important;
                right: 12px !important;
            }
        }

        @media (min-width:767.96px) {
            .nav11 {
                padding: 0.5rem 1rem !important;
            }

            .search-box {
                width: fit-content !important;
            }

            .search-input:focus {
                -webkit-box-shadow: 1px 1px #141ad8;
                box-shadow: 1px 1px #141ad8;
            }

            .portal_name {
                font-size: 1rem !important;
            }

            .search-box {
                width: 200px !important;
                position: relative !important;
            }
        }

        @media (min-width:1024.96px) {
            .nav11 {
                left: 200px !important;
            }

            .portal_name {
                font-size: 1.2rem !important;
            }

            .navbar .navbar-nav {
                -webkit-box-orient: horizontal;
                -webkit-box-direction: normal;
                -ms-flex-direction: row;
                flex-direction: row;
                padding-left: 20px !important;
            }

            .navigation {
                display: flex !important;
                align-items: end !important;
                margin-left: 145px !important;

            }
        }

        @media (min-width:1359.96px) {
            .nav11 {
                left: 200px !important;
            }

            .portal_name {
                font-size: 1.2rem !important;
            }

            .navbar .navbar-nav {
                -webkit-box-orient: horizontal;
                -webkit-box-direction: normal;
                -ms-flex-direction: row;
                flex-direction: row;
                /* padding-left: 0px !important; */
            }

            .navigation {
                display: flex !important;
                align-items: end !important;
                margin-left: 145px !important;

            }
        }

        @media (min-width:1199.96px) {
            .portal_name {
                font-size: 1.8rem !important;
            }
        }

        .main-sidebar {
            width: 200px !important;
        }

        .sidebar-mini .navbar {
            left: 65px !important;
        }

        .sidebar-mini .main-sidebar {
            width: 65px !important;
        }

        .sidebar-mini .main-sidebar .sidebar-menu>li {
            padding-top: 0px !important;
            padding-bottom: 0px !important;
        }

        .sidebar-menu {
            margin-top: 1rem !important;
        }

        .sidebar-secondary-menu {
            position: absolute;
            left: 0px !important;
            bottom: 0px !important;
        }

        .sidebar-icons {
            font-size: 1.5rem !important;
        }

        .collapse_btn {
            margin-top: auto !important;
            margin-bottom: auto !important;
        }

        .collapse_btn_icon {
            color: #000 !important;
        }

        .fullscreen_btn {
            margin-top: auto !important;
            margin-bottom: auto !important;
        }

        .fullscreen_btn_icon {
            color: #000 !important;
        }

        .search-input {
            color: #000 !important;
            width: 100% !important;
            box-sizing: border-box !important;
            border: 0px !important;
            border-radius: 25px !important;
            font-size: 16px !important;
            background-color: white !important;
            padding-top: 8px !important;
            padding-bottom: 8px !important;
            padding-left: 40px !important;
            z-index: 0 !important;
            transition: 0.4s ease-in-out !important;
            outline: none !important;
        }

        .search-input::placeholder {
            color: #40c2b2 !important;
            font-weight: 500;
            padding-top: 0px !important;
            padding-bottom: 0px !important;
        }

        .search-icon {
            color: #000 !important;
            position: absolute;
            left: 0px !important;
            z-index: 1 !important;
            font-size: 1.2rem !important;
            padding: 12px !important;
        }

        .nav11 {
            background-image: none;
            background-color: white !important;
        }

        .main-sidebar .sidebar-menu li a span {
            width: auto !important;
        }

        .profile_pic_icon {
            color: #000 !important;
            font-size: 1.5rem !important;
        }

        .vertical_center {
            align-items: center !important;
        }
    </style>
    <!-- newly added -->
    <style>
        body {
            background-color: #f8f9fc !important;
        }

        .sidebar_links.active {
            background-color: #001b52 !important;
        }

        .portal_name {
            width: fit-content;
            color: #000;
            font-weight: 500;
            margin: auto 0rem auto 0.75rem;
            font-size: 23px !important;
            color: black;
        }

        ul.navbar-nav a i.fa,
        ul.navbar-nav a i.fas.fullscreen_btn_icon {
            /* color: black !important; */
        }

        div.search-box i {
            color: black !important;
        }

        ::placeholder {
            color: red !important;
            opacity: 1 !important;
            /* Firefox */
        }

        :-ms-input-placeholder {
            /* Internet Explorer 10-11 */
            color: red !important;
        }

        .path {
            margin-top: 0.5rem;
            margin-left: 1rem;
            color: black;
            font-weight: 600;
            font-size: 1rem;
        }

        .path i {
            font-weight: 500;
        }

        .badges {
            /* background-color: #085a7e !important; */
        }

        /* .dark-sidebar .main-sidebar {
            background-color: #2c847a !important;
        } */

        .dark-sidebar.sidebar-mini .main-sidebar:after {
            background-color: #fff !important;
        }


        /* colors */
        .text-00e600 {
            color: #00e600 !important;
        }

        .bg-00e600 {
            background-color: #00e600 !important;
        }

        ::-webkit-input-placeholder {
            /* Chrome/Opera/Safari */
            color: red;
        }

        ::-moz-placeholder {
            /* Firefox 19+ */
            color: red;
        }

        :-ms-input-placeholder {
            /* IE 10+ */
            color: red;
        }

        :-moz-placeholder {
            /* Firefox 18- */
            color: red;
        }
    </style>
    <style>
        .navigation {
            /*position: fixed;*/
            /* top: 0;
            display: flex !important;
            align-items: end !important;
            margin-left: 92px !important; */
            /*  width: 100%;
      height: 60px;
      background: #3f9cb5;*/
        }

        .navigation .inner-navigation {
            padding: 0;
            margin: 0;
        }

        .navigation .inner-navigation li {
            list-style-type: none;
        }

        .navigation .inner-navigation li .menu-link {
            color: #085a7e;
            line-height: 3.7em;
            padding: 20px 18px;
            text-decoration: none;
            transition: background 0.5s, color 0.5s;
        }

        .navigation .inner-navigation li .menu-link.menu-anchor {
            padding: 20px;
            margin: 0;
            background: #bea20f;
            color: #FFF;
        }

        .navigation .inner-navigation li .menu-link.has-notifications {
            color: #FFF;
        }

        .navigation .inner-navigation li .menu-link.circle {
            line-height: 3.8em;
            padding: 14px 18px;
            border-radius: 50%;
        }

        .navigation .inner-navigation li .menu-link.circle:hover {
            /* background: #085a7e; */
            color: #FFF;
        }

        .navigation .inner-navigation li .menu-link.square:hover {
            /* background: #085a7e; */
            color: #FFF;
            transition: background 0.5s, color 0.5s;
        }

        .dropdown-container {
            overflow-y: hidden;
        }

        .dropdown-container.expanded .dropdown {
            -webkit-animation: fadein 0.5s;
            -moz-animation: fadein 0.5s;
            -ms-animation: fadein 0.5s;
            -o-animation: fadein 0.5s;
            animation: fadein 0.5s;
            display: block;
        }

        .dropdown-container .dropdown {
            -webkit-animation: fadeout 0.5s;
            -moz-animation: fadeout 0.5s;
            -ms-animation: fadeout 0.5s;
            -o-animation: fadeout 0.5s;
            animation: fadeout 0.5s;
            display: none;
            position: absolute;
            width: 226px;
            height: auto;
            max-height: 600px;
            overflow-y: hidden;
            padding: 0;
            margin: 0;
            background: #eee;
            margin-top: -2px;
            margin-right: -15px;
            /* border-top: 4px solid #085a7e; */
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
            -webkit-box-shadow: 2px 2px 15px -5px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: 2px 2px 15px -5px rgba(0, 0, 0, 0.75);
            box-shadow: 2px 2px 15px -5px rgba(0, 0, 0, 0.75);
            /*
      &:before{
        position: absolute;
        content: ' ';
        width: 0; 
        height: 0; 
        top: -13px;
        right: 7px;
        border-left: 8px solid transparent;
        border-right: 8px solid transparent;
        border-bottom: 10px solid $secondary-color; 
      }
      */
        }

        .dropdown-container .dropdown .notification-group {
            border-bottom: 1px solid #e3e3e3;
            overflow: hidden;
            min-height: 65px;
        }

        .dropdown-container .dropdown .notification-group:last-child {
            border-bottom: 0;
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
        }

        .dropdown-container .dropdown .notification-group .notification-tab {
            padding: 0px 25px;
            min-height: 65px;
        }

        .dropdown-container .dropdown .notification-group .notification-tab:hover {
            cursor: pointer;
            background: #6c757d;
        }

        .dropdown-container .dropdown .notification-group .notification-tab:hover .fa,
        .dropdown-container .dropdown .notification-group .notification-tab:hover h4,
        .dropdown-container .dropdown .notification-group .notification-tab:hover .label {
            color: #FFF;
            display: inline-block;
        }

        .dropdown-container .dropdown .notification-group .notification-tab:hover .label {
            background: #085a7e;
            border-color: #085a7e;
        }

        .dropdown-container .dropdown .notification-group .notification-list {
            padding: 0;
            overflow-y: auto;
            height: 0px;
            max-height: 250px;
            transition: height 0.5s;
        }

        .dropdown-container .dropdown .notification-group .notification-list .notification-list-item {
            padding: 5px 25px;
            border-bottom: 1px solid #e3e3e3;
        }

        .dropdown-container .dropdown .notification-group .notification-list .notification-list-item .message {
            margin: 5px 5px 10px;
        }

        .dropdown-container .dropdown .notification-group .notification-list .notification-list-item .item-footer a {
            color: #3f9cb5;
            text-decoration: none;
        }

        .dropdown-container .dropdown .notification-group .notification-list .notification-list-item .item-footer .date {
            float: right;
        }

        .dropdown-container .dropdown .notification-group .notification-list .notification-list-item:nth-of-type(odd) {
            background: #e3e3e3;
        }

        .dropdown-container .dropdown .notification-group .notification-list .notification-list-item:hover {
            cursor: pointer;
        }

        .dropdown-container .dropdown .notification-group .notification-list .notification-list-item:last-child {
            border-bottom: 0;
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
        }

        .dropdown-container .dropdown .notification-group.expanded .notification-tab {
            /* background: #6c757d; */
        }

        .dropdown-container .dropdown .notification-group.expanded .notification-tab .fa,
        .dropdown-container .dropdown .notification-group.expanded .notification-tab h4,
        .dropdown-container .dropdown .notification-group.expanded .notification-tab .label {
            color: #FFF;
            display: inline-block;
        }

        .dropdown-container .dropdown .notification-group.expanded .notification-tab .label {
            background: #085a7e;
            border-color: #085a7e;
        }

        .dropdown-container .dropdown .notification-group.expanded .notification-list {
            height: 250px;
            max-height: 250px;
            transition: height 0.5s;
        }

        .dropdown-container .dropdown .notification-group .fa,
        .dropdown-container .dropdown .notification-group h4,
        .dropdown-container .dropdown .notification-group .label {
            color: #333;
            display: inline-block;
        }

        .dropdown-container .dropdown .notification-group .fa {
            margin-right: 5px;
            margin-top: 25px;
        }

        .dropdown-container .dropdown .notification-group .label {
            float: right;
            margin-top: 20px;
            color: #3f9cb5;
            border: 1px solid #3f9cb5;
            padding: 0px 7px;
            border-radius: 15px;
        }

        .tile-body-height {
            height: 60vh;
            overflow-y: overlay;
            padding-right: 25px;
        }

        .right {
            float: right;
        }

        .left {
            float: left;
            list-style: none;
        }

        @media only screen and (max-width: 321px) {
            .dropdown-container .dropdown .notification-group .notification-tab h4 {
                display: none;
            }

            .dropdown-container .dropdown .notification-group .notification-tab:hover h4 {
                display: none;
            }

            .dropdown-container .dropdown .notification-group.expanded .notification-tab h4 {
                display: none;
            }
        }

        @media only screen and (max-width: 514px) {
            .dropdown-container .dropdown {
                width: 100%;
                margin: 0px;
                left: 0;
            }
        }

        @keyframes fadein {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @media (min-width: 1400px) {
            .navigation {

                display: flex !important;
                align-items: end !important;
                margin-left: 0px !important;
            }
        }

        @-moz-keyframes fadein {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @-webkit-keyframes fadein {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @-ms-keyframes fadein {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @-o-keyframes fadein {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeout {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }

        @-moz-keyframes fadeout {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }

        @-webkit-keyframes fadeout {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }

        @-ms-keyframes fadeout {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }

        @-o-keyframes fadeout {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }

        .badges {
            /* background: #f00; */
            width: 40px;
            height: 40px !important;
            border-radius: 50%;
            /* background-color: rgb(0, 34, 102); */
            color: white;
        }

        .fade-in-text {
            font-family: Arial;
            font-size: 17px;
            text-align: center;
            /* padding-top: 35%; */
            animation: fadeIn 5s;
            -webkit-animation: fadeIn 5s;
            -moz-animation: fadeIn 5s;
            -o-animation: fadeIn 5s;
            -ms-animation: fadeIn 5s;
            min-height: 200px !important;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* .notificationMenu.fade-in-text:hover {
            background-color: #eeeeee !important;
        } */

        .dropdown-container {
            overflow-y: hidden;
            width: 40px;
            height: 40px;
            margin-top: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px !important;
        }

        .navigation .inner-navigation li .menu-link.circle {
            line-height: 100%;
            padding: 0px;
            border-radius: 50%;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;

        }


        .badge {
            position: absolute;
            top: 7px;
            right: 140px !important;
            border-radius: 50%;
            background-color: red !important;
            color: white !important;
        }

        a>i>.badge.badge-light.bell_notification {
            top: -12px !important;
            position: absolute !important;
            /* left: 0px !important; */
            right: -8px !important;
        }

        a>.notify {
            position: relative !important;
        }

        .nav-link {
            cursor: pointer;
        }

        /* .main-content {
            width: 100% !important;
            padding-left: 195px;
            padding-right: 0px;

        } */

        a>i>.badge.badge-light.bell_notification {
            top: -3px !important;
            position: absolute !important;
            /* left: 0px !important; */
            right: -16px !important;
        }

        #bell {
            position: absolute;
            top: 4px !important;
            right: 4px !important;
        }

        .no_notification:hover {
            background-color: transparent !important;
        }

        .notification-tab:hover {
            background-color: transparent !important;

        }

        .hover_class :hover {
            background: #6c757d;
        }

        .main-sidebar.sidebar-style-2 {
            z-index: 0 !important;

        }
        .nav-link i{
            color:#680EDA !important;
        }
        @media (min-width:1024.96px) {
            .main-sidebar.sidebar-style-2 {
                z-index: 0 !important;


            }
        }

        /* @media (min-width:1024.96px) {
            .main-sidebar.sidebar-style-2 {
                z-index: 0 !important;

            }
        } */


        @media (max-width:1424.96px) {
            .main-sidebar.sidebar-style-2 {
                z-index: 0 !important;

            }
        }

        @media (min-width:1024.96px) {
            .main-content {
                padding-top: 50px !important;
                padding-left: 200px !important;
            }
        }
    </style>
</head>

<body class="light dark-sidebar theme-white">
    <div class="loader-container" id="loaderContainer">
        <div class="loader_ajax"></div>
    </div>
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <nav class="navbar nav11 navbar-expand-lg main-navbar">
                <div class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li class="collapse_btn">
                            <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn">
                                <i class="fa fa-bars collapse_btn_icon" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li class="fullscreen_btn">
                            <a href="#" class="nav-link nav-link-lg fullscreen-btn">
                                <i class="fas fa-expand fullscreen_btn_icon"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="form-inline mr-auto d-md-inline-block d-none" style="color: #2a0245!important; font-weight: 500; font-size: 23px">
                    <!-- <span style="color:black; padding: 10px;" class="nav_heading"><b class="">Talentra - Learning Management System</b> -->
                        <span style="color: #9958ae; right: -90px;position: relative;" class="user_name_nav"></span></span>
                </div>
                <ul class="navbar-nav navbar-right">
                    <nav class="navigation">
                        <span class="badge badge-light badgeworkflow" style="position: absolute; left: 51px; width:2%;margin-left:auto;"></span>
                        <ul class="inner-navigation navnotify">

                            <li class="left">
                                <div class="dropdown-container">
                                    <a href="#" id="eleaning_notification" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg badges">
                                        <i id="bell" class="far fa-bell notify"></i>
                                        <span class="badge badge-light bell_notification"></span>
                                        <!-- <span id="notifier"></span> -->
                                        <span class="badge badge-danger badge-counter"></span>

                                    </a>
                                    <ul class="dropdown" name="notificationMenu" style="top: 110%;border-radius: 15px !important;">
                                        <li class="notification-group">
                                            <div class="notification-tab p-0 m-0">
                                                <span class="user_name_alertelearning"></span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                        <li class="dropdown">
                            <a data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                <i class="fas fa-user profile_pic_icon"></i>
                                <span class="d-sm-none d-lg-inline-block" style="color:#000 !important;"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="{{route('profilepage')}}" class="dropdown-item has-icon">
                                    <i class="far fa-user"></i>
                                    <b>Profile</b>
                                </a>
                            </div>
                        </li>
                    </nav>
                </ul>
            </nav>


            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand" style=" background-color:white!important;">

                        <img src="{{asset('assets/images/Talentra.jpg')}}" class="logo" style="  width: 70% !important;">
                        </a>
                    </div>
                    <ul class="sidebar-menu">
                        <li>
                            <a href="{{ route('elearningDashboard') }}" class="nav-link sidebar_links">
                                <i class="sidebar-icons fa fa-home" aria-hidden="true"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        @if($menus['alter_name'] == "graduate trainee" || $menus['alter_name'] == "professional_member" || $menus['alter_name'] == "professional Member(NRU)" || $menus['alter_name'] == "sadmin" || $menus['alter_name'] == "student")
                        <li>
                            <a href="{{ route('elearning.allCourses') }}?sorted=Recently Added&tag=false&progress=false&q=false" class="nav-link sidebar_links">
                                <i class="sidebar-icons fa fa-graduation-cap" aria-hidden="true"></i>
                                <span>All Courses</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('elearning.cpt_index') }}" class="nav-link sidebar_links">
                                <i class="sidebar-icons bi bi-patch-question-fill" aria-hidden="true"></i>
                                <span>CPD Points</span>
                            </a>
                        </li>
                        <!-- <li>
                            <a href="" class="nav-link">
                                <i class="sidebar-icons fa fa-spinner" aria-hidden="true"></i>
                                <span>Progress</span>
                            </a>
                        </li> -->
                        <li>
                            <a href="{{ route('elearning.wishlist') }}" class="nav-link sidebar_links">
                                <i class="sidebar-icons bi bi-heart-fill" aria-hidden="true"></i>
                                <span>Wish List</span>
                            </a>
                        </li>

                        <li>

                            @php $id=Crypt::encrypt("all"); @endphp
                            <a href="{{ route('elearningCart',$id)}}" class="nav-link sidebar_links">
                                <i class="sidebar-icons bi bi-cart4" aria-hidden="true"></i>
                                <span>Cart</span>
                            </a>
                        </li>
                        @endif
                        @if($menus['alter_name'] == "graduate trainee" || $menus['alter_name'] == "professional_member" || $menus['alter_name'] == "professional Member(NRU)" || $menus['alter_name'] == "sadmin" || $menus['alter_name'] == "student")

                        <li>
                            <a href="{{ route('elearning.userquiz') }}" class="nav-link sidebar_links">
                                <i class="sidebar-icons bi bi-patch-question-fill" aria-hidden="true"></i>
                                <span>Quiz</span>
                            </a>
                        </li>
                        @endif
                        <!-- <li>
                            <a href="{{ route('elearningAssessment') }}" class="nav-link sidebar_links">
                                <i class="sidebar-icons fa fa-trophy" aria-hidden="true"></i>
                                <span>Assessment</span>
                            </a>
                        </li> -->

                        @if($menus['alter_name'] == "graduate trainee" || $menus['alter_name'] == "professional_member" || $menus['alter_name'] == "professional Member(NRU)" || $menus['alter_name'] == "sadmin" || $menus['alter_name'] == "student")

                        <!-- <li>
                            <a href="{{ route('ethictest.list') }}" class="nav-link sidebar_links">
                                <i class="sidebar-icons fa fa-pencil-square-o" aria-hidden="true"></i>
                                <span>Ethic Test</span>
                            </a>
                        </li> -->
                        @endif
                        @if($menus['alter_name'] == "professional Member(NRU)" || $menus['alter_name'] == "sadmin" || $menus['alter_name'] == "student")
                        <!-- <li>
                            <a href="{{ route('localadaptation.list') }}" class="nav-link sidebar_links">
                                <i class="sidebar-icons fa fa-globe" aria-hidden="true"></i>
                                <span>Local Adaptation Test</span>
                            </a>
                        </li> -->
                        @endif
                        <!-- @if($menus['alter_name'] == "graduate trainee" || $menus['alter_name'] == "professional_member")

                        <li>
                            <a href="{{ route('exam.list') }}" class="nav-link sidebar_links">
                                <i class="sidebar-icons fa fa-pencil-square-o" aria-hidden="true"></i>
                                <span>Exam</span>
                            </a>
                        </li>
                        @endif -->
                        <li>
                            <a href="/" class="nav-link sidebar_links">
                                <i class="sidebar-icons fa fa-sign-out" aria-hidden="true"></i>
                                <span>Logout</span>
                            </a>
                            <form id="logout-form" action="" method="POST" class="d-none">
                            </form>
                        </li>
                    </ul>
                    </break>
                    <ul class="second_Menu sidebar-menu sidebar-secondary-menu">
                        <!-- <li>
                            <a href="/home" class="nav-link">
                                <i class="sidebar-icons fa fa-arrow-left" aria-hidden="true"></i>
                                <span>Home</span>
                            </a>
                        </li> -->
                        <!-- <li>
                            <a href="" class="nav-link">
                                <i class="sidebar-icons fa fa-info" aria-hidden="true"></i>
                                <span>About Us</span>
                            </a>
                        </li>
                        <li>
                            <a href="" class="nav-link">
                                <i class="sidebar-icons fa fa-map-marker" aria-hidden="true"></i>
                                <span>Contact Us</span>
                            </a>
                        </li> -->
                    </ul>
                </aside>

                <input type="hidden" name="testing_id" id="testing_id" value="{{URL::to('/')}}">
            </div>
        </div>
    </div>
    <main class="py-4">
        @yield('content')
    </main>
</body>
<script>
    // let link = document.querySelectorAll(".sidebar_links");
    // link[0].classList.toogle("active");
    //search
    let searchInput = document.querySelector('.search-input');

    function eLearningSearch() {
        let url = new URL("http://localhost:60157/elearningAllCourses");
        url.searchParams.set('sorted', "Recently Added");
        url.searchParams.set('tag', "false");
        url.searchParams.set('progress', "false");
        url.searchParams.set('q', searchInput.value);
        window.location = url;
    }
    searchInput.addEventListener("keypress", (e) => {
        if (e.key === "Enter") {
            e.preventDefault();
            eLearningSearch();
        }
    });
</script>
</body>
@include('layouts.script')

</html>
<script>
    //Dropdown collapsile tabs
    $('.notification-toggle').click(function(e) {

        $('#eleaning_notification').parent().toggleClass('expanded');

    })

    function formatDateDifference(formatted_date) {
        var created_date = new Date(formatted_date);
        var current_date = new Date();
        var time_difference = current_date - created_date;
        var seconds = Math.floor(time_difference / 1000);
        var minutes = Math.floor(seconds / 60);
        var hours = Math.floor(minutes / 60);
        var days = Math.floor(hours / 24);
        var weeks = Math.floor(days / 7);
        var months = current_date.getMonth() - created_date.getMonth() + (12 * (current_date.getFullYear() - created_date.getFullYear()));
        var years = Math.floor(months / 12);

        if (years >= 1) {
            return years + (years === 1 ? ' year ago' : ' years ago');
        } else if (months >= 1) {
            return months + (months === 1 ? ' month ago' : ' months ago');
        } else if (weeks >= 1) {
            return weeks + (weeks === 1 ? ' week ago' : ' weeks ago');
        } else if (days >= 1) {
            return days + (days === 1 ? ' day ago' : ' days ago');
        } else if (hours >= 1) {
            return hours + (hours === 1 ? ' hour ago' : ' hours ago');
        } else if (minutes >= 1) {
            return minutes + (minutes === 1 ? ' minute ago' : ' minutes ago');
        } else {
            return 'just now';
        }
    }
</script>



<script type="text/javascript">
    function notification_fetch() {
        var id = "user_id";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ url('/user/notifications')}}",
            type: "POST",
            dataType: "json",
            async: false,
            data: {
                id: id,
                _token: '{{csrf_token()}}'
            },
            success: function(data) {
                //alert("das");
                console.log(data);
                var count = data['Elearning_usernotifications_count'][0].countflow;


                if (count == 0) {
                    $('.notification-tab').append('<div class="fade-in-text no_notification "><p>No new notifications</p></div>');

                } else {
                    $('.notification-tab').children().remove();
                    //  $('.user_name_alertelearning').append('<span class="label user_name_alertelearning">' + count + '</span>');
                    for (var count = 0; count < data['Elearning_usernotifications_data'].length; count++) {
                        var notification_id = data['Elearning_usernotifications_data'][count].notification_id;
                        var alert_meg = data['Elearning_usernotifications_data'][count].alert_meg;
                        var created_at = data['Elearning_usernotifications_data'][count].created_at;
                        var parts = created_at.split('-');
                        var year = parts[0];
                        var month = parts[1];
                        var day = parts[2];

                        // Create the formatted date in "dd-mm-yy" format
                        var formatted_date = day + '-' + month + '-' + year;


                        var time_ago = formatDateDifference(formatted_date);

                        $('.notification-tab').append('<li class="hover_class" onclick="notification(' + notification_id + ')" class="notification-list-item"><p class="message p-1 m-0">' + alert_meg + " " + formatted_date + '<p></li>');
                    }
                    var usercount = count;
                    $('.notify').append('<span class="badge badge-light bell_notification">' + usercount + '</span>');
                }
            },
        });
    }


    $(document).ready(function() {
        //alert('fefe');

        notification_fetch();


    });

    // $(document).click(function(){
    //   $('ul.dropdown').children().remove();
    //   notification_fetch();
    // })

    function notification(notificationid) {
        //alert(notificationid);
        var id = notificationid;



        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ url('/user/notified')}}",
            type: "POST",
            dataType: "json",
            async: false,
            data: {
                id: id,
                _token: '{{csrf_token()}}'
            },
            success: function(data) {

                var url = data['notify_link'][0].notification_url;
                window.location.href = url;

            },
        });


    }
</script>