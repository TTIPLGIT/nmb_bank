<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Talentra</title>

    <!-- General CSS Files -->
    <link href="{{asset('asset/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('asset/bundles/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('asset/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}"
        rel="stylesheet" />

    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" type="text/css"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!--dropzone css -->
    <!-- jQuery -->
    <!-- <script src="//code.jquery.com/jquery-1.11.3.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.js"
        integrity="sha512-wvgsp3xEKrcb+x3VGdlHOTpVmqCbPmSUNbD4VYW3Ub1M49xNjQh7LjKKi6jrHFEw6AVRngaUtYYBiI8L4Vw22w=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>





    <!-- <script type="text/javascript" src="js/bootstrap/bootstrap-dropdown.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/jAlert@4.9.1/dist/jAlert.min.js"></script>


    <!-- <script src="alert/jAlert-v3.min.js"></script> -->
    <!-- <link rel="stylesheet" href="alert/jAlert-v3.css" /> -->

    <!-- Template CSS -->
    <link href="{{asset('asset/css/style.css')}}" type="text/css" rel="stylesheet" />

    <link href="{{asset('asset/css/components.css')}}" type="text/css" rel="stylesheet" />
    <!-- Custom style CSS -->
    <link href="{{asset('asset/css/custom.css')}}" type="text/css" rel="stylesheet" />
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" type="text/css"
        rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/hummingbird_v1.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/hummingbird_treeview.css') }}">
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('css/select2.min.css') }}" /> -->
    <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/dropzone.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/dropzone.js"></script>
    <script type="text/javascript" src="{{ asset('js/hummingbird_treeview.js') }}"></script>
    <!-- <script type="text/javascript" src="{{ asset('js/select2.js') }}"></script> -->

    <link href="{{asset('assets/css/adminnavbar.min.css')}}" rel="stylesheet" type="text/css" />
    <link rel="icon" href="{{asset('css/talentra-image.jpg')}}" sizes="40x40">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@700&display=swap" rel="stylesheet">


    <link href="{{asset('assets/css/updated-ui.css')}}" rel="stylesheet" type="text/css" />



    <!-- loading gif -->
    <!-- Ck editor -->
    <script src="https://cdn.tiny.cloud/1/3r7kjxhafm9hbckihumdmitzncsve258qw14txq1wqt2jo50/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <!-- <link rel="stylesheet" href="{{asset('asset/css/owl.carousel.css')}}"> -->
    <!-- <link rel="stylesheet" href="{{asset('asset/css/owl.theme.default.css')}}"> -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->

    <!-- <script src="{{asset('asset/js/owl.carousel.min.js')}}"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <style>
    .stamp {
        border: none !important;
    }


    .li {
        padding-top: 10px;
    }

    .nav11 {
        /* background-color: #398eb1 !important; */
        font-family: sans-serif;
        /* box-shadow: 0 .15rem 1.75rem 0 rgba(58, 59, 69, .15) !important; */
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

    .light.dark-sidebar.theme-white {
        height: 10px !important;
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

    .buttonedu {
        display: flex !important;
        justify-content: space-around !important;
        padding: 10px;
    }



    /* / Css of notification /  */
    .navigation {
        /*position: fixed;*/
        top: 0;
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
        /* background: #085a7e; */
        color: #000000;
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
        width: 300px;
        height: auto;
        max-height: 600px;
        overflow-y: hidden;
        padding: 0;
        margin: 0;
        background: #eee;
        margin-top: 3px;
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
        background: #6c757d;
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

    .error {
        color: red;
    }

    .dropdown {
        list-style: none;

    }

    /* / End css of notification /  */
    .pagination {
        display: inline !important;
        float: right !important;
    }


    .dataTables_paginate {
        display: inline !important;
    }

    .dataTables_info {
        display: inline !important;
    }

    .trc {
        background: #d8e7eb;

    }

    .goldenrod {
        color: goldenrod !important;
    }

    .darkcyan {
        color: darkcyan !important;
    }

    .indianred {
        color: indianred !important;

    }

    .indigo {
        color: indigo !important;
    }

    .lg {
        color: #70bd25 !important;
    }

    #ncount {
        padding: 0.20em 0.40em;
        border-radius: 50%;
        transform: translate(160%, -83%) !important;
        -ms-transform: translateX(50%);
        transform: translateY(50%);
        top: 50%;
    }

    .badges {
        background: #f00;
        width: 40px;
        height: 40px !important;
        border-radius: 50%;
        /* background-color: rgb(0, 34, 102); */
        color: white;
    }

    .text-black {
        color: black !important;
    }

    .badge {
        position: absolute !important;
        top: 18px !important;
        right: 66px !important;
        border-radius: 50% !important;
        background-color: red !important;
        color: white !important;
    }

    .fade-in-text {
        font-family: Arial;
        font-size: 17px;
        text-align: center;
        padding-top: 35%;
        animation: fadeIn 5s;
        -webkit-animation: fadeIn 5s;
        -moz-animation: fadeIn 5s;
        -o-animation: fadeIn 5s;
        -ms-animation: fadeIn 5s;
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    @-moz-keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    @-webkit-keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    @-o-keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    @-ms-keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }
    </style>

    <style>
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

    .table:not(.table-sm) thead th {
        color: #000000 !important;
    }

    .prof_admin {
        height: 35px;
        width: 35px !important;
        position: relative;
        margin-top: 8px;
        border-radius: 30px;

        /* margin-right: 19px;
      position: relative;
      width: 42px !important; */
    }

    .drop_bg {
        text-transform: capitalize;
        width: 200px;
    }

    .tox-statusbar {
        display: none !important;
    }

    .back_button {
        background: red !important;
        border-color: red !important;
        color: white !important;
    }

    .approve_button {
        background: green !important;
        border-color: green !important;
        color: white !important;
    }

    .loader-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.7);
        /* Faded background color */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 10000;
        /* Ensure the loader appears on top of other content */
        display: none;
        /* Hide initially */
    }

    .loader_ajax {
        border: 8px solid #f3f3f3;
        border-top: 8px solid #3498db;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .aligned-row {
        display: flex;
        text-wrap: nowrap;
    }

    /* saranya */
    .form-control {
        text-transform: none !important;
    }

    .nav-link i {
        color: #680EDA;
    }

    .circle i {
        color: #680EDA;
    }
    </style>




    <link href="{{ asset('assets/css/mediaquery.css') }}" rel="stylesheet" type="text/css" />


</head>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
// saranya
(function($) {
    // Define your function
    window.selectReinitialize = function(element) {
        $(`.${element}`).select2('destroy').select2();
    };


})(jQuery);
</script>

<body class="light dark-sidebar theme-white">
    <div class="loader-container" id="loaderContainer">
        <div class="loader_ajax"></div>
    </div>
    <div class="loader"></div>
    @if (session('success'))

    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
    <script type="text/javascript">
    window.onload = function() {
        var message = $('#session_data').val();
        swal.fire({
            title: "Success",
            text: message,
            icon: "success",
        });


    }
    </script>
    @elseif(session('error'))

    <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
    <script type="text/javascript">
    window.onload = function() {

        var message = $('#session_data1').val();
        swal.fire({
            title: "Success",
            text: message,
            icon: "success",
        });


    }
    </script>
    @endif

    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar nav11 navbar-expand-lg main-navbar">
                <div class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li>
                            <a href="#" data-toggle="sidebar" id="toggle" class="nav-link nav-link-lg collapse-btn "><i
                                    class="fas fa-bars navheading"></i></a>
                        </li>
                        <li>
                            <a href="#" class="nav-link nav-link-lg fullscreen-btn">
                                <i class="fas fa-expand navheading"></i>
                            </a>
                        </li>
                    </ul>

                </div>
                <div class="form-inline mr-auto d-md-inline-block d-none"
                    style="color: #2a0245 !important; font-weight: 500; font-size: 22px">
                    <span style="  color:white; padding: 10px;" class=""><b class="navheading">Learning Management
                            System </b>
                        <!-- <span style="color: #9958ae; right: -90px;position: relative;" class="user_name_nav"></span> --></span>

                </div>

                <ul class="navbar-nav navbar-right">
                    <nav class="navigation" style="">

                        <span class="badge badge-light badgeworkflow"
                            style="position: absolute; left: 51px; width:2%;margin-left:auto;"></span>

                        <ul class="inner-navigation">

                            <li class="left">
                                <!--span class="notification-label"></span-->

                                <div class="dropdown-container">
                                    <a href="#" data-dropdown="notificationMenu"
                                        class="menu-link has-notifications circle">
                                        <i class="fa fa-bell notify"></i><span
                                            class="badge badge-light bell_notification"></span>
                                    </a>
                                    <ul class="dropdown" name="notificationMenu" style="top: 80%;">

                                        <li class="notification-group">
                                            <div class="notification-tab">
                                                <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                                                <h4 style="font-size:15px" class="">Elearning</h4>
                                                <span class="user_name_alertelearning"></span>
                                            </div>
                                            <!-- tab -->
                                            <ul class="notification-list user_alert_list_elearning">




                                            </ul>
                                        </li>


                                    </ul>
                                </div>
                            </li>
                        </ul>

                    </nav>


                    <li class="dropdown drop_bg">
                        <a data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user"
                            style=" display:flex; align-items: center;flex-direction:column;">
                            @if($modules['data'] != "")

                            <div style="width: auto;height:auto">
                                <div style="float: left;">
                                    <span class="d-sm-none d-lg-inline-block">
                                        <?php  if (!empty($modules['profile_image'])) { ?>
                                        <img class="prof_admin" value="" src="{{ $modules['profile_image']}}">
                                        <?php  } else {   ?>
                                        <img class="prof_admin" value="" src="{{url()->to('/')}}/images/empty.jpg">

                                        <?php  } ?>
                                    </span>
                                </div>
                                <div style="float: right;line-height:1.5 !important">
                                    <div style="padding-left: 8px;">
                                        {{ucfirst($modules['user_name'])}}
                                    </div>
                                    <div style="padding-left:8px;margin-top:1px !important">
                                        <span class="d-sm-none d-lg-inline-block"
                                            style="font-weight:100;white-space: nowrap; overflow: hidden; text-overflow: ellipsis; width: 122px;"
                                            title="{{$modules['user_role']}}"> {{$modules['user_role']}}</span>
                                    </div>
                                </div>
                                <!-- <div class="profile-container" style="display: flex; justify-content:center">
              <div class="profile-image-container">
              <img src="http://localhost:6061/user_signature/126/YXZhdGFyNS5wbmc=.png" style="width: 25%;">
              </div>
              <div class="profile-details">
              <span>Viruma</span>
              <p>Admin</p>
              </div>
          </div> -->
                            </div>
                        </a>

                        @endif
                        <div class="dropdown-menu dropdown-menu-right">
                            @if($modules['data'] != "")
                            <p class="dropdown-item has-icon" style="color:black;pointer-events:none; font-size:small">
                                Welcome
                                {{ucfirst($modules['user_name'])}}</p>
                            @endif
                            <a href="{{ url('profilepage') }}" class="dropdown-item has-icon">
                                <i class="far fa-user" style="color:black !important;"></i><b
                                    style="color:black !important;">Profile</b></a>
                            <a class="dropdown-item has-icon" href="{{ route('main_index') }}"><i
                                    class="fa fa-question-circle" style="color:black !important;"></i><b
                                    style="color:black !important;">FAQ</b></a>


                            <a class="dropdown-item has-icon"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out" style="color:black !important;"></i><b
                                    style="color:black !important;">Logout</b></a>


                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf

                            </form>
                        </div>
                    </li>


                </ul>


            </nav>

            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand"
                        style="display:flex;align-items:center;text-align:center;justify-content:center;">

                        <img src="{{asset('asset/image/Talentra-1.svg')}}" class="logo"
                            style="  width: 70% !important;">
                        </a>
                    </div>
                    <ul class="sidebar-menu">
                        @if(session()->get("gd_status") != '2')
                        <li class="dropdown "><a href="{{route('admindashboard')}}" class="nav-link"><i
                                    class="fas fa-home"></i><span>Dashboard</span></a>

                        </li>
                        @endif

                        <!-- Professional member Firm Admin Screen -->
                        @if($modules['data'] != "")
                        <!-- @if($modules['user_role'] == "professional member")

        <li class="dropdown ">
          <a class="nav-link has-dropdown">
          <i class="fas fa-user-cog" aria-hidden="true"></i>
          <span>
            Firm Administration
          </span>
          </a>
          <ul class="dropdown-menu active" style="display: none;">

          <li class=""><a class="nav-link " href="{{route('firm_admin_index')}}">Firm Administration</a></li>
          </ul>


        </li>
        @endif -->
                        <!-- <li>
          <a href="{{ route('ethictest.index') }}" class="nav-link sidebar_links">
          <i class="sidebar-icons fa fa-pencil-square-o" aria-hidden="true"></i>
          <span>Ethics Test</span>
          </a>
        </li>
        <li>
          <a href="{{ route('localadaptationtest.index') }}" class="nav-link sidebar_links">
          <i class="sidebar-icons fa fa-globe" aria-hidden="true"></i>
          <span>Local Adaptation Test</span>
          </a>
        </li> -->
                        @endif

                        @if($modules['data'] != "")
                        @foreach ($modules['data'] as $key => $module)
                        <li class="dropdown">

                            <a class="nav-link has-dropdown">
                                <i class="{{$module['class_name']}}" aria-hidden="true"></i>
                                <span>
                                    {{$module['module_name']}}
                                </span>
                            </a>

                            <ul class="dropdown-menu active" style="display: none;">
                                @if($screens != "")
                                @foreach ($screens as $key => $screen)
                                @if($module['module_id'] == $screen['module_id'])

                                <li><a class="nav-link "
                                        href="{{ config('setting.base_url')}}{{ $screen['route_url'] }}">{{$screen['screen_name']}}</a>
                                </li>
                                @endif

                                @endforeach
                                @endif
                            </ul>

                        </li>

                        @endforeach

                        @endif
                    </ul>






                    <!-- end module -->




                </aside>

                <input type="hidden" name="testing_id" id="testing_id" value="{{URL::to('/')}}">
            </div>






        </div>
    </div>

    <main class="py-4">



        @yield('content')
    </main>




</body>
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2/js/bootstrap.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.js"
    integrity="sha512-wvgsp3xEKrcb+x3VGdlHOTpVmqCbPmSUNbD4VYW3Ub1M49xNjQh7LjKKi6jrHFEw6AVRngaUtYYBiI8L4Vw22w=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@include('layouts.script')

</html>

<script type="text/javascript">
// $('.form_submit_handle').on('click',function(e){
//   handleFormButtonClick(e);
// })
// const handleFormButtonClick = (e) => {
//   e.target.setAttribute('disabled',true);
//   e.target.innerText = "Submitting";
//   return;
// }

const preventSubmitButton = (cl) => {
    $(`.${cl}`).attr('disabled', true);
    $(`.${cl}`).text('Submitting...');

}

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
            var data2 = data;
            console.log(data2, 'A');
            var count = data2['registration_count'][0].countflow;
            var count2 = data2['General_notifications_count'][0].countflow;
            var count3 = data2['approval_nrv_count'][0].countflow;
            var count4 = data2['Elearning_notifications_count'][0].countflow;

            // var count_data_1 = data2['count_data'][0].countflow;
            // $('.badgeworkflow').text(count_data_1);

            if (count == 0 && count3 == 0) {
                $('.registration_data_list').append(
                    '<div class="fade-in-text no_notification "><p>No new notifications</p></div>');
            } else {
                $('.user_name_alert').append('<span class="label user_name_alert2">' + count + '</span>');
                for (var count = 0; count < data2['registration_data'].length; count++) {
                    var notification_id = data2['registration_data'][count].notification_id;
                    var alert_meg = data2['registration_data'][count].alert_meg;
                    $('.registration_data_list').append('<li onclick="notification(' + notification_id +
                        ')" class="notification-list-item"><p class="message">' + alert_meg +
                        '</p></li>');
                }
                // NRU //
                if ($('.user_name_alert span')) {
                    var exist_count = $('.user_name_alert span').val();
                }
                for (var count = 0; count < data2['approval_nrv_data'].length; count++) {
                    var notification_id = data2['approval_nrv_data'][count].notification_id;
                    var alert_meg = data2['approval_nrv_data'][count].alert_meg;
                    $('.registration_data_list').append('<li onclick="notification(' + notification_id +
                        ')" class="notification-list-item"><p class="message">' + alert_meg +
                        '</p></li>');
                }
            }



            if (count2 == 0) {
                $('.user_alert_list').append('<div class="fade-in-text"><p>No new notifications</p></div>');
            } else {
                $('.user_name_alert1').append('<span class="label  user_name_alert1">' + count2 +
                    '</span>');
                for (var count_1 = 0; count_1 < data2['General_notifications_data'].length; count_1++) {
                    var notification_id = data2['General_notifications_data'][count_1].notification_id;
                    var alert_meg = data2['General_notifications_data'][count_1].alert_meg;

                    $('.user_alert_list').append('<li onclick="notification(' + notification_id +
                        ')" class="notification-list-item"><p class="message">' + alert_meg +
                        '</p></li>');
                }
            }

            function formatDateDifference(formatted_date) {
                var created_date = new Date(formatted_date);
                var current_date = new Date();
                var time_difference = current_date - created_date;
                var seconds = Math.floor(time_difference / 1000);
                var minutes = Math.floor(seconds / 60);
                var hours = Math.floor(minutes / 60);
                var days = Math.floor(hours / 24);
                var weeks = Math.floor(days / 7);
                var months = current_date.getMonth() - created_date.getMonth() + (12 * (current_date
                    .getFullYear() - created_date.getFullYear()));
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

            if (count4 == 0) {
                $('.user_alert_list_elearning').append(
                    '<div class="fade-in-text"><p>No new notifications</p></div>');
            } else {
                $('.user_name_alertelearning').append('<span class="label  user_name_alertelearning">' +
                    count4 + '</span>');
                for (var count_4 = 0; count_4 < data2['Elearning_notifications_data'].length; count_4++) {
                    var notification_id = data2['Elearning_notifications_data'][count_4].notification_id;
                    var alert_meg = data2['Elearning_notifications_data'][count_4].alert_meg;
                    var created_at = data2['Elearning_notifications_data'][count_4].created_at;
                    var parts = created_at.split('-');
                    var year = parts[0];
                    var month = parts[1];
                    var day = parts[2];

                    // Create the formatted date in "dd-mm-yy" format
                    var formatted_date = day + '-' + month + '-' + year;


                    var time_ago = formatDateDifference(formatted_date);

                    $('.user_alert_list_elearning').append('<li onclick="notification(' + notification_id +
                        ')" class="notification-list-item"><p class="message">' + alert_meg +
                        '</p><p>' + formatted_date + '</span></li>');
                }
            }


            // if (count3 == 0 && count == 0) {
            //   $('.no_notification').remove();
            //   $('.registration_data_list').append('<div class="fade-in-text no_notification"><p>No new notifications</p></div>');
            // } else {
            //   $('.no_notification').remove();
            //   $('.user_name_alert1').append('<span class="label user_name_alert1">' + count3 + '</span>');
            //   for (var count_2 = 0; count_2 < data2['approval_nrv_cdata'].length; count_2++) {
            //     var notification_id = data2['approval_nrv_cdata'][count_2].notification_id;
            //     var alert_meg = data2['approval_nrv_cdata'][count_2].alert_meg;
            //     $('.registration_data_list').append('<li onclick="notification(' + notification_id + ')" class="notification-list-item"><p class="message">' + alert_meg + '</p></li>');
            //   }
            // }
            var count = data2['registration_count'][0].countflow;
            var count2 = data2['General_notifications_count'][0].countflow;
            var count3 = data2['approval_nrv_count'][0].countflow;
            var count4 = data2['Elearning_notifications_count'][0].countflow;



            var usercount = count + count2 + count3 + count4;
            $('.notify').append('<span class="badge badge-light bell_notification">' + usercount +
                '</span>');
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

<script>
function toggle() {
    var body_class = document.querySelector('body');
    if (window.innerWidth < 1025) {
        document.querySelector('.logo').src = "{{('assets/images/Talentra.jpg')}}";

    }
    // var mini =document.querySelector('sidebar-mini');
    else if (body_class.classList.contains("sidebar-mini") == true) {


        document.querySelector('.logo').src = "{{asset('assets/images/Talentra.jpg')}}";
    } else {
        document.querySelector('.logo').src = "{{asset('assets/images/Login-logo-dark.svg')}}"
    }
}
document.querySelector("#toggle").addEventListener('click', toggle);
</script>
<script>
function activateNavLink(route) {
    // Deactivate any currently active nav-links
    $(".nav-link.has-dropdown.active").removeClass("active");
    $(".dropdown-menu.active").hide();
    // Activate the selected nav-link based on the provided route (class)
    var $navLink = $("#nav-link-" + route);
    $navLink.addClass("active");
    $navLink.siblings(".dropdown-menu").show();
}

function showLoader() {
    document.getElementById('loaderContainer').style.display = 'flex';
    document.body.style.overflow = 'hidden'; // Prevent scrolling
}

function hideLoader() {
    document.getElementById('loaderContainer').style.display = 'none';
    document.body.style.overflow = 'visible'; // Restore scrolling
}
</script>