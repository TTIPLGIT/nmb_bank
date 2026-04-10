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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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

    <style>
    .user-level-display {
        display: flex;
        align-items: center;
        font-size: 14px;
        font-weight: bold;
        background: #eaf6ff;
        color: #1c3f5e;
        padding: 6px 12px;
        border-radius: 30px;
        margin-right: 15px;
    }

    .user-level-display i {
        font-size: 18px;
        color: #ff9900;
        margin-right: 6px;
    }

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
<div class="floating-chat-container">
    <button class="floating-chat-toggle" id="floatingChatToggle">
        <i class="fa fa-comments"></i>
        <span class="floating-chat-badge" id="floatingChatBadge" style="display: none;">1</span>
    </button>

    <div class="floating-chat-widget" id="floatingChatWidget">
        <div class="floating-chat-header">
            <h5><i class="fas fa-robot"></i> Talentra Assistant</h5>
            <div class="floating-chat-header-actions">
                <button class="floating-chat-minimize" id="floatingChatMinimize">
                    <i class="fa fa-minus"></i>
                </button>
                <button class="floating-chat-close" id="floatingChatClose">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>

        <div class="floating-chat-body" id="floatingChatBody">
            <div class="floating-chat-messages" id="floatingChatMessages">
                <div class="message bot">
                    <div class="message-content">
                        Hello! How can I help you today?
                    </div>
                    <div class="message-time">{{ now()->format('h:i A') }}</div>
                </div>
            </div>

            <div class="typing-indicator" id="typingIndicator" style="display: none;">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

        <div class="floating-chat-footer">
            <textarea class="floating-chat-input" id="chatMessageInput" placeholder="Type your message..."
                rows="1"></textarea>
            <button class="floating-chat-send" id="sendMessageBtn">
                <i class="fa fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

<script>
class FloatingChat {
    constructor() {
        this.isOpen = false;
        this.isMinimized = false;
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.loadFromStorage();
    }

    setupEventListeners() {
        // Toggle chat
        document.getElementById('floatingChatToggle').addEventListener('click', () => this.toggleChat());

        // Close chat
        document.getElementById('floatingChatClose').addEventListener('click', (e) => {
            e.stopPropagation();
            this.closeChat();
        });

        // Minimize chat
        document.getElementById('floatingChatMinimize').addEventListener('click', (e) => {
            e.stopPropagation();
            this.toggleMinimize();
        });

        // Send message
        document.getElementById('sendMessageBtn').addEventListener('click', () => this.sendMessage());
        document.getElementById('chatMessageInput').addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                this.sendMessage();
            }
        });

        // Auto-resize textarea
        document.getElementById('chatMessageInput').addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    }

    toggleChat() {
        const widget = document.getElementById('floatingChatWidget');
        const toggle = document.getElementById('floatingChatToggle');

        if (this.isOpen) {
            widget.style.display = 'none';
            toggle.style.display = 'flex';
            this.isOpen = false;
            this.hideNotification();
        } else {
            widget.style.display = 'flex';
            toggle.style.display = 'none';
            this.isOpen = true;
            this.isMinimized = false;
            document.getElementById('floatingChatBody').style.display = 'flex';
            document.querySelector('.floating-chat-footer').style.display = 'flex';
            document.querySelector('.floating-chat-minimize i').className = 'fa fa-minus';
        }
        this.saveToStorage();
    }

    toggleMinimize() {
        const body = document.getElementById('floatingChatBody');
        const footer = document.querySelector('.floating-chat-footer');
        const minimizeIcon = document.querySelector('.floating-chat-minimize i');

        if (this.isMinimized) {
            body.style.display = 'flex';
            footer.style.display = 'flex';
            minimizeIcon.className = 'fa fa-minus';
            this.isMinimized = false;
        } else {
            body.style.display = 'none';
            footer.style.display = 'none';
            minimizeIcon.className = 'fa fa-plus';
            this.isMinimized = true;
        }
        this.saveToStorage();
    }

    closeChat() {
        const widget = document.getElementById('floatingChatWidget');
        const toggle = document.getElementById('floatingChatToggle');

        widget.style.display = 'none';
        toggle.style.display = 'flex';
        this.isOpen = false;
        this.saveToStorage();
    }

    async sendMessage() {
        const input = document.getElementById('chatMessageInput');
        const message = input.value.trim();

        if (!message) return;

        // Clear input and reset height
        input.value = '';
        input.style.height = 'auto';

        // Add user message to chat
        this.addMessage(message, 'user');

        // Show typing indicator
        this.showTypingIndicator();

        try {
            const response = await this.callAPI(message);
            console.log(response);
            // Hide typing indicator
            this.hideTypingIndicator();

            if (response.success) {
                this.addMessage(response.response, 'bot');
            } else {
                this.addMessage('Sorry, I encountered an error. Please try again.', 'bot');
            }
        } catch (error) {
            this.hideTypingIndicator();
            this.addMessage('Network error. Please check your connection.', 'bot');
            console.error('Error:', error);
        }
    }

    async callAPI(message) {
        const response = await fetch('/global-chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                message: message
            })
        });

        return await response.json();
    }

    addMessage(text, sender) {
        const messagesContainer = document.getElementById('floatingChatMessages');
        const time = new Date().toLocaleTimeString([], {
            hour: '2-digit',
            minute: '2-digit'
        });

        const messageHTML = `
            <div class="message ${sender}">
                <div class="message-content">${this.escapeHtml(text)}</div>
                <div class="message-time">${time}</div>
            </div>
        `;

        messagesContainer.insertAdjacentHTML('beforeend', messageHTML);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    showTypingIndicator() {
        document.getElementById('typingIndicator').style.display = 'flex';
        const messagesContainer = document.getElementById('floatingChatMessages');
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    hideTypingIndicator() {
        document.getElementById('typingIndicator').style.display = 'none';
    }

    showNotification() {
        const badge = document.getElementById('floatingChatBadge');
        badge.style.display = 'block';
    }

    hideNotification() {
        const badge = document.getElementById('floatingChatBadge');
        badge.style.display = 'none';
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    saveToStorage() {
        localStorage.setItem('chatState', JSON.stringify({
            isOpen: this.isOpen,
            isMinimized: this.isMinimized
        }));
    }

    loadFromStorage() {
        const saved = localStorage.getItem('chatState');
        if (saved) {
            const state = JSON.parse(saved);
            this.isOpen = state.isOpen;
            this.isMinimized = state.isMinimized;

            const widget = document.getElementById('floatingChatWidget');
            const toggle = document.getElementById('floatingChatToggle');

            if (this.isOpen) {
                widget.style.display = 'flex';
                toggle.style.display = 'none';

                if (this.isMinimized) {
                    document.getElementById('floatingChatBody').style.display = 'none';
                    document.querySelector('.floating-chat-footer').style.display = 'none';
                    document.querySelector('.floating-chat-minimize i').className = 'fa fa-plus';
                }
            }
        }
    }
}

// Initialize chat when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.floatingChat = new FloatingChat();
});
</script>

<style>
/* Floating Chat Widget Styles */
.floating-chat-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 10000;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.floating-chat-toggle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #680EDA 0%, #4A0B8C 100%);
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(104, 14, 218, 0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.3s, box-shadow 0.3s;
    position: relative;
}

.floating-chat-toggle:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(104, 14, 218, 0.6);
}

.floating-chat-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #ff4757;
    color: white;
    font-size: 12px;
    padding: 2px 6px;
    border-radius: 10px;
    min-width: 20px;
    text-align: center;
    font-weight: bold;
}

.floating-chat-widget {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 350px;
    height: 500px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 5px 40px rgba(0, 0, 0, 0.2);
    display: none;
    flex-direction: column;
    overflow: hidden;
    animation: slideIn 0.3s ease;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.floating-chat-header {
    background: linear-gradient(135deg, #680EDA 0%, #4A0B8C 100%);
    color: white;
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: move;
}

.floating-chat-header h5 {
    margin: 0;
    font-size: 16px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 8px;
}

.floating-chat-header h5 i {
    font-size: 18px;
}

.floating-chat-header-actions {
    display: flex;
    gap: 10px;
}

.floating-chat-header-actions button {
    background: none;
    border: none;
    color: white;
    cursor: pointer;
    padding: 0;
    font-size: 16px;
    opacity: 0.8;
    transition: opacity 0.3s;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.floating-chat-header-actions button:hover {
    opacity: 1;
}

.floating-chat-body {
    flex: 1;
    overflow-y: auto;
    background: #f8f9fa;
    display: flex;
    flex-direction: column;
}

.floating-chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.floating-chat-messages .message {
    display: flex;
    flex-direction: column;
    max-width: 85%;
}

.floating-chat-messages .message.user {
    align-self: flex-end;
}

.floating-chat-messages .message.bot {
    align-self: flex-start;
}

.floating-chat-messages .message-content {
    padding: 10px 15px;
    border-radius: 18px;
    font-size: 13px;
    line-height: 1.4;
    word-wrap: break-word;
}

.floating-chat-messages .message.user .message-content {
    background: #680EDA;
    color: white;
    border-bottom-right-radius: 4px;
}

.floating-chat-messages .message.bot .message-content {
    background: white;
    color: #333;
    border-bottom-left-radius: 4px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
}

.floating-chat-messages .message-time {
    font-size: 10px;
    color: #999;
    margin-top: 5px;
    padding: 0 5px;
}

.floating-chat-messages .message.user .message-time {
    text-align: right;
}

.typing-indicator {
    display: flex;
    gap: 5px;
    padding: 15px 20px;
    background: white;
    border-radius: 18px;
    align-self: flex-start;
    margin: 0 20px 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
}

.typing-indicator span {
    width: 8px;
    height: 8px;
    background: #999;
    border-radius: 50%;
    animation: typing 1s infinite ease-in-out;
}

.typing-indicator span:nth-child(2) {
    animation-delay: 0.2s;
}

.typing-indicator span:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes typing {

    0%,
    60%,
    100% {
        transform: translateY(0);
        opacity: 0.6;
    }

    30% {
        transform: translateY(-10px);
        opacity: 1;
    }
}

.floating-chat-footer {
    padding: 15px;
    background: white;
    border-top: 1px solid #eee;
    display: flex;
    gap: 10px;
    align-items: flex-end;
}

.floating-chat-input {
    flex: 1;
    border: 1px solid #e0e0e0;
    border-radius: 20px;
    padding: 10px 15px;
    font-size: 13px;
    resize: none;
    max-height: 100px;
    outline: none;
    font-family: inherit;
}

.floating-chat-input:focus {
    border-color: #680EDA;
}

.floating-chat-send {
    background: #680EDA;
    color: white;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.3s, background 0.3s;
    flex-shrink: 0;
}

.floating-chat-send:hover {
    transform: scale(1.1);
    background: #4A0B8C;
}

.floating-chat-send:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none;
}

/* Mobile Responsive */
@media (max-width: 480px) {
    .floating-chat-widget {
        width: 300px;
        height: 450px;
        right: 10px;
        bottom: 10px;
    }

    .floating-chat-toggle {
        width: 50px;
        height: 50px;
        font-size: 20px;
    }
}

/* Dark mode support if needed */
@media (prefers-color-scheme: dark) {
    .floating-chat-widget {
        background: #2d2d2d;
    }

    .floating-chat-messages {
        background: #1e1e1e;
    }

    .floating-chat-messages .message.bot .message-content {
        background: #2d2d2d;
        color: #fff;
    }

    .floating-chat-footer {
        background: #2d2d2d;
        border-top-color: #404040;
    }

    .floating-chat-input {
        background: #404040;
        border-color: #505050;
        color: #fff;
    }

    .typing-indicator {
        background: #2d2d2d;
    }
}
</style>

<body class="light dark-sidebar theme-white">
    <div class="loader-container" id="loaderContainer">
        <div class="loader_ajax"></div>
    </div>
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <nav class="navbar nav11 navbar-expand-lg main-navbar" style="top:0px;">
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
                <div class="form-inline mr-auto d-md-inline-block d-none"
                    style="color: #2a0245!important; font-weight: 500; font-size: 26px;">
                    <span style=" class=" nav_heading"><b class="">Learning Management
                            System</b>
                        <span style="color: #9958ae; right: -90px;position: relative;"
                            class="user_name_nav"></span></span>

                </div>

                <div class="user-level-display" id="level-container">

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
                                        <?php if (!empty($modules['profile_image'])) { ?>
                                        <img class="prof_admin" value="" src="{{ $modules['profile_image']}}">
                                        <?php  } else {   ?>
                                        <img class="prof_admin" value=""
                                            src="{{config('profile_url')}}/images/user_profile.jpg">

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

                            </div>
                        </a>

                        @endif
                        <div class="dropdown-menu dropdown-menu-right">
                            @if($modules['data'] != "")
                            <p class="dropdown-item has-icon" style="color:black;pointer-events:none; font-size:small">
                                Welcome
                                {{ucfirst($modules['user_name'])}}
                            </p>
                            @endif
                            <a href="{{ url('profilepage') }}" class="dropdown-item has-icon">
                                <i class="far fa-user" style="color:black !important;"></i><b
                                    style="color:black !important;">Profile</b></a>
                            <!-- <a class="dropdown-item has-icon" href="{{ route('main_index') }}"><i
                                    class="fa fa-question-circle" style="color:black !important;"></i><b
                                    style="color:black !important;">FAQ</b></a> -->


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
                    <div class="sidebar-brand" style=" background-color:white!important;">

                        <img src="{{asset('asset/image/Talentra-1.svg')}}" class="logo"
                            style=" width: 70% !important; ">
                        </a>
                    </div>
                    <ul class="sidebar-menu">
                        @if(session()->get("gd_status") != '2')
                        <li class="dropdown "><a href="{{route('elearningDashboard')}}" class="nav-link"><i
                                    class="fas fa-home"></i><span>{{ __('dashboard.dashboard') }}</span></a>

                        </li>
                        @endif
                        <!-- <ul class="sidebar-menu">
                            <li>
                                <a href="{{ route('elearningDashboard') }}" class="nav-link sidebar_links">
                                    <i class="sidebar-icons fa fa-home" aria-hidden="true"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            @if($menus['alter_name'] == "graduate trainee" || $menus['alter_name'] == "professional_member"
                            || $menus['alter_name'] == "professional Member(NRU)" || $menus['alter_name'] == "sadmin" ||
                            $menus['alter_name'] == "student")
                            <li>
                                <a href="{{ route('elearning.allCourses') }}?sorted=Recently Added&tag=false&progress=false&q=false"
                                    class="nav-link sidebar_links">
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
                            
                            <li>
                                <a href="{{ route('elearning.wishlist') }}" class="nav-link sidebar_links">
                                    <i class="sidebar-icons bi bi-heart-fill" aria-hidden="true"></i>
                                    <span>Wish List</span>
                                </a>
                            </li>

                            <li>

                                @php $id = Crypt::encrypt("all"); @endphp
                                <a href="{{ route('elearningCart', $id)}}" class="nav-link sidebar_links">
                                    <i class="sidebar-icons bi bi-cart4" aria-hidden="true"></i>
                                    <span>Cart</span>
                                </a>
                            </li>
                            @endif
                            @if($menus['alter_name'] == "graduate trainee" || $menus['alter_name'] == "professional_member"
                            || $menus['alter_name'] == "professional Member(NRU)" || $menus['alter_name'] == "sadmin" ||
                            $menus['alter_name'] == "student")

                            <li>
                                <a href="{{ route('elearning.userquiz') }}" class="nav-link sidebar_links">
                                    <i class="sidebar-icons bi bi-patch-question-fill" aria-hidden="true"></i>
                                    <span>Quiz</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('your_achievements') }}" class="nav-link sidebar_links">
                                    <i class="sidebar-icons bi bi-trophy-fill" aria-hidden="true"></i>
                                    <span>Achievements</span>
                                </a>
                            </li>
                            @endif
                            <li>
                                <a href="/leaderboard" class="nav-link">
                                    <i class="sidebar-icons fa fa-star" aria-hidden="true"></i>
                                    <span>Leaderboard</span>
                                </a>
                            </li>





                            <li>
                                <a href="/elearningDashboard" class="nav-link">
                                    <i class="sidebar-icons fa fa-arrow-left" aria-hidden="true"></i>
                                    <span>Home</span>
                                </a>
                            </li>
                            

                        </ul>
                        </break>
                        <ul class="second_Menu sidebar-menu sidebar-secondary-menu">



                            <li>
                                <a href="http://20.255.58.187:8001/#/" class="nav-link sidebar_links">
                                    <i class="sidebar-icons fa fa-sign-out" aria-hidden="true"></i>
                                    <span>Logout</span>
                                </a>
                            </li>
                            
                        </ul> -->

                        @if($modules['data'] != "")
                        @foreach ($modules['data'] as $key => $module)
                        <li class="dropdown">
                            <a class="nav-link has-dropdown">
                                <i class="{{$module['class_name']}}" aria-hidden="true"></i>
                                <span>
                                    {{ $module['module_name'] }}
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
                        <li>
                            <a onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                class="nav-link sidebar_links">
                                <i class="sidebar-icons fa fa-sign-out" aria-hidden="true"></i>
                                <span>Logout</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf

                            </form>
                        </li>
                        @endif
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
    var months = current_date.getMonth() - created_date.getMonth() + (12 * (current_date.getFullYear() - created_date
        .getFullYear()));
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
            var container = $('#level-container');

            // Clear any previous data if needed
            container.empty();

            // Build new HTML with the returned data
            var html = `
                <i id="level" class="${data.level_icon}"></i>
                <span class="level-text"style="font-size:15px">${data.level_name.toUpperCase()}</span>
            `;


            // Append it to the container
            container.append(html);
            var count = data['Elearning_usernotifications_count'][0].countflow;
            var count2 = 0;
            var totalCount = count + count2;

            if (count == 0) {
                $('.user_alert_list_elearning').append(
                    '<div class="fade-in-text no_notification "><p>No new notifications</p></div>');

            } else {
                // $('.user_name_alertelearning').children().remove();
                $('.user_name_alertelearning').append('<span class="label user_name_alertelearning">' +
                    totalCount + '</span>');
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

                    $('.user_alert_list_elearning').append(
                        '<li class="hover_class" onclick="notification(' +
                        notification_id +
                        ')" class="notification-list-item"><p class="message p-1 m-0">' + alert_meg +
                        " " + formatted_date + '<p></li>');
                }


                // for (var count2 = 0; count2 < data['Elearning_expiry_data'].length; count2++) {
                //     var notification_id = data['Elearning_expiry_data'][count2].notification_id;
                //     var alert_meg = data['Elearning_expiry_data'][count2].alert_meg;
                //     var created_at = data['Elearning_expiry_data'][count2].created_at;
                //     var parts = created_at.split('-');
                //     var year = parts[0];
                //     var month = parts[1];
                //     var day = parts[2];

                //     // Create the formatted date in "dd-mm-yy" format
                //     var formatted_date = day + '-' + month + '-' + year;


                //     var time_ago = formatDateDifference(formatted_date);

                //     $('.user_alert_list_elearning').append(
                //         '<li class="hover_class" onclick="notification(' +
                //         notification_id +
                //         ')" class="notification-list-item"><p class="message p-1 m-0">' +
                //         alert_meg +
                //         " " + formatted_date + '<p></li>');
                // }


                var usercount = count;
                $('.notify').append('<span class="badge badge-light bell_notification">' + usercount +
                    '</span>');
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

            var url = "/elearning/allCourses?sorted=Recently%20Added&tag=false&progress=false&q=false";
            window.location.href = url;

        },
    });


}
</script>