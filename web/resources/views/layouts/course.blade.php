<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Talentra</title>
    <link rel="icon" href="{{asset('css/talentra-image.jpg')}}" sizes="40x40">

    <!-- Bootstrap v4.3.1 CSS File -->
    <link href="{{asset('asset/css/app.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-icons.1.8.2.css') }}" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css">
    <!-- Font-Awesome v4.2.0 -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" type="text/css"
        rel="stylesheet" />

    <!--dropzone css -->
    <!-- jQuery -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->

    <script src="{{ asset('js/jquery.3.5.1.min.js') }}"></script>

    <link href="{{asset('css/select2.css')}}" type="text/css" rel="stylesheet" />

    <!-- Template CSS -->
    <link href="{{asset('asset/css/style.css')}}" type="text/css" rel="stylesheet" />
    <link href="{{asset('asset/css/components.css')}}" type="text/css" rel="stylesheet" />
    <!-- Custom style CSS -->
    <link href="{{asset('asset/css/custom.css')}}" type="text/css" rel="stylesheet" />
    <link type="text/css" href="{{ asset('css/smoothness_jquery-ui.css') }}" rel="stylesheet">

    <!-- <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" type="text/css" rel="stylesheet" /> -->

    <link rel="stylesheet" type="text/css" href="{{ asset('css/hummingbird_v1.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/hummingbird_treeview.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/select2.css') }}" />

    <!-- <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css"> -->

    <link href="{{ asset('css/sweet-alertv2.css') }}" rel="stylesheet">

    <!-- <link rel="stylesheet" href="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.css"> -->
    <script src="{{ asset('js/sweetalert_1.1.3_ajax.min.js') }}"></script>

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css"> -->
    <link href="{{ asset('css/dropzone_4.3.0.css') }}" rel="stylesheet">
    <script src="{{ asset('js/dropzone.js') }}"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/dropzone.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/dropzone.js"></script>

    <script type="text/javascript" src="{{ asset('js/hummingbird_treeview.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/select2.js') }}"></script>

    <link href="{{asset('assets/css/adminnavbar.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.4/simplePagination.css" integrity="sha512-emkhkASXU1wKqnSDVZiYpSKjYEPP8RRG2lgIxDFVI4f/twjijBnDItdaRh7j+VRKFs4YzrAcV17JeFqX+3NVig==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <!-- loading gif -->
    <!-- Ck editor -->

    <!-- pagination -->
    <!-- <link rel="stylesheet" href="https://pagination.js.org/dist/2.5.0/pagination.css"> -->
    <link href="{{ asset('css/pagination.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ asset('js/pagination.js') }}"></script>


    <!-- <script src="https://pagination.js.org/dist/2.5.0/pagination.js"></script> -->
    <!-- <script src="https://cdn.tiny.cloud/1/1pvpoo3olz0n1t42br79z0fne5gce6ayj2lt9hmmcg04gqkg/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> -->
    <script type="text/javascript" src="{{ asset('js/tinymce.min.js') }}"></script>

    <style>
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

        .courseContentsWrapper {
            display: none;
        }

        #aside-menu {
            display: none;
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

        .navnotify {
            padding-right: 12px !important;
        }
    }

    @media (min-width:424.96px) {
        .flow-width {
            width: 2.5rem !important;
        }

        .navnotify {
            padding-right: 90px !important;
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
            padding-right: 90px !important;
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

        .navnotify {
            padding-right: 90px !important;
        }
    }

    @media (min-width:1199.96px) {
        .flow-width {
            width: 4.5rem !important;
        }

        .navnotify {
            padding-right: 90px !important;
        }
    }
    </style>

    <style>
    @media (min-width:319.96px) {
        .search-box {
            width: 110px !important;
            position: relative !important;
        }

        #bell {
            position: absolute;
            top: 18px !important;
            right: -21px !important;
        }

        .nav11 {
            padding: 0px !important;
        }


    }

    @media (min-width:374.96px) {
        .search-box {
            width: 160px !important;
        }
    }

    @media (min-width:424.96px) {
        .search-box {
            width: 190px !important;
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
    }

    @media (min-width:1024.96px) {
        .nav11 {
            left: 200px !important;
        }

        .portal_name {
            font-size: 1.2rem !important;
        }

        .courseContentsWrapper {
            display: block;
        }

        #aside-menu {
            display: block;
        }
    }

    @media (min-width:1199.96px) {
        .portal_name {
            font-size: 1.8rem !important;
        }
    }

    @media (min-width: 1440px) {
        .courseContentsWrapper {
            display: block;
        }

        #aside-menu {
            display: block;
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
        color: #0000 !important;
    }

    .fullscreen_btn {
        margin-top: auto !important;
        margin-bottom: auto !important;
    }

    .fullscreen_btn_icon {
        color: #0000 !important;
    }

    .search-input {
        color: #000000 !important;
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
        color: #0000 !important;
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
        color: #0000 !important;
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
        color: #000000 !important;
        font-weight: 900;
        margin: auto 0rem auto 0.75rem;
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
        background-color: #085a7e !important;
    }

    .dark-sidebar .main-sidebar {
        background-color: #2c847a !important;
    }

    .dark-sidebar.sidebar-mini .main-sidebar:after {
        background-color: #2c847a !important;
    }


    /* colors */
    .text-00e600 {
        color: #00e600 !important;
    }

    .bg-00e600 {
        background-color: #00e600 !important;
    }
    </style>
    <style>
    .courseContentsWrapper {
        width: 300px;
        height: calc(100% - 71px);
        position: fixed;
        top: 71px;
        overflow-y: scroll !important;
        right: 0px;
        /* background-image: linear-gradient(to right, #2c847a, #2c847a, #2c847a, #2c847a, #2c847a) !important; */
        background-color: #ffffff !important;
        color: #000000 !important;
        font-size: 16px !important;
    }

    .courseContentsHeader {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }

    .courseContentsHeader {
        color: black !important;
        background-color: #ffffff !important;
    }

    .courseContent {
        color: ghostwhite;
        background-color: #ffffff10;
    }

    .doneMark {
        display: inline-block;
        transform: rotate(45deg);
        height: 20px;
        width: 10px;
        border-bottom: 5px solid #78b13f;
        border-right: 5px solid #78b13f;
        margin-right: 10px;
    }

    .classWrapper {
        padding-top: calc(70px + 1.5rem);
        padding-bottom: 1.5rem;
        padding-right: 300px;
    }

    .main-content {
        padding-left: 0% !important;
        padding-right: 0% !important;
    }

    .nav11 {
        left: 0px !important;
    }

    .sidebar-brand {
        display: block;
    }

    @media (max-width:991px) {
        .sidebar-brand {
            display: none;
        }

        /* .courseContentsWrapper {
                display: none;
            } */

        .classWrapper {
            padding-right: 0px;
        }
    }

    /* user selection */
    body {
        user-select: none !important;
        -webkit-user-select: none !important;
        -moz-user-select: none !important;
    }
    </style>
    <style>
    .navigation {
        /*position: fixed;*/
        top: 0;
        display: flex !important;
        align-items: end !important;
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
        background: #085a7e;
        color: #FFF;
    }

    .navigation .inner-navigation li .menu-link.circle {
        line-height: 3.8em;
        padding: 14px 18px;
        border-radius: 50%;
    }

    .navigation .inner-navigation li .menu-link.circle:hover {
        background: #085a7e;
        color: #FFF;
    }

    .navigation .inner-navigation li .menu-link.square:hover {
        background: #085a7e;
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
        background: #f00;
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


    /* .badge {
            position: absolute;
            top: 7px;
            right: 140px !important;
            border-radius: 50%;
            background-color: red !important;
            color: white !important;
        } */

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

    .main-content {
        width: 100% !important;
        padding-left: 195px;
        padding-right: 0px;

    }

    a>i>.badge.badge-light.bell_notification {
        top: -3px !important;
        position: absolute !important;
        /* left: 0px !important; */
        right: -16px !important;
    }

    #bellbell {
        position: absolute;
        top: 4px !important;
        right: -21px !important;
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

    .classhide {
        background: #00000030 !important;
        color: black !important;
    }

    .classhide:hover {
        background: #d8ddd3 !important;
        color: #ff0000 !important;
    }

    .classshow {
        color: #3300ff !important;
        background: #d8ddd3 !important;
    }

    .classcompleted {

        color: #0e9f12 !important;
    }

    .examcompleted {

        color: #0e9f12 !important;
    }

    .certificatehide {
        background: transparent !important;
        color: lightgray !important;

    }

    .col-md-12.certificatehide:hover {
        background: #d8ddd3 !important;
        color: #ff0000 !important;

    }

    .certificateshow {
        background: #0e9f12 !important;
        color: white !important;
        text-decoration: none;
    }

    .examhide {
        background: #00000030 !important;
        color: black !important;
    }

    .examhide:hover {
        background: #d8ddd3 !important;
        color: #ff0000 !important;
    }

    .examshow {
        color: #3300ff !important;
        background: #d8ddd3 !important;
    }
    </style>
</head>

<body>
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar nav11 navbar-expand-lg main-navbar">
                <div class="sidebar-brand" style=" background-color:white!important;">
                    <img src="{{asset('asset/image/Talentra-1.svg')}}" alt="logo" class="logo" width="150px"
                        style="margin-left:10px !important;">
                </div>
                <div class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li class="fullscreen_btn">
                            <a href="#" class="nav-link nav-link-lg fullscreen-btn">
                                <i class="fas fa-expand fullscreen_btn_icon"></i>
                            </a>
                        </li>
                        <!-- <li>
                            <div class="search-box">
                                <input type="text" class="search-input" placeholder="Search any keyword" aria-label="Username" aria-describedby="addon-wrapping">
                                <i class="fa fa-search search-icon" aria-hidden="true"></i>
                            </div>
                        </li> -->
                        <li class="d-none d-md-block portal_name">
                            <span>
                                <b> Learning Management System </b>
                            </span>
                        </li>
                    </ul>
                </div>
                <ul class="navbar-nav navbar-right">
                    <nav class="navigation" style="">
                        <span class="badge badge-light badgeworkflow"
                            style="position: absolute; left: 51px; width:2%;margin-left:auto;"></span>
                        <ul class="inner-navigation navnotify" style="">

                            <li class="dropdown dropdown-list-toggle">
                                <div class="dropdown-container">
                                    <a href="#" id="eleaning_notification" data-toggle="dropdown"
                                        class="nav-link notification-toggle nav-link-lg badges">
                                        <i id="bellbell" class="far fa-bell notify"></i>
                                        <span class="badge badge-light bell_notification"
                                            style="background-color:red !important;"></span>
                                        <!-- <span id="notifier"></span> -->
                                        <span class="badge badge-danger badge-counter"></span>

                                    </a>


                                    <ul class="dropdown" name="notificationMenu"
                                        style="top: 110%;border-radius: 15px !important;">
                                        <li class="notification-group">
                                            <div class="notification-tab p-0 m-0">
                                                <span class="user_name_alertelearning"></span>
                                            </div>
                                        </li>
                                    </ul>

                                </div>
                            </li>
                        </ul>
                        <aside class="sidebar">
                            <button type="button" class="btn btn-demo" id="toggleCourseContents">
                                <i class="fa fa-bars" id="bar" aria-hidden="true"></i>
                            </button>
                        </aside>
                        <!-- <li class="dropdown">
                            <a data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                <i class="fas fa-user profile_pic_icon"></i>
                                <span class="d-sm-none d-lg-inline-block" style="color:#000 !important;"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="#" class="dropdown-item has-icon">
                                    <i class="far fa-user"></i>
                                    <b>Profile</b>
                                </a>
                            </div>
                        </li> -->
                    </nav>
                </ul>
            </nav>
            <div class="courseContentsWrapper" id="aside-menu">
                <div class="list-group list-group-flush courseContentsbody">
                    <div class="list-group-item list-group-item-action courseContentsHeader">
                        <span><b>
                                Course Content</b>

                        </span>

                        <i class="fa fa-times" aria-hidden="true"></i>
                    </div>



                    <div class="container">
                        <div id="accordion" class="py-5">
                            @php $quizz_exist=0;@endphp
                            @foreach($selected_class as $classContent)

                            @if($classContent->class_status == 0)
                            @php $status_class="classhide"; @endphp
                            @endif
                            @if($classContent->class_status == 1)
                            @php $status_class="classshow"; @endphp

                            @endif
                            @if($classContent->class_status == 2)
                            @php $status_class="classcompleted"; @endphp
                            @endif



                            <div class="card border-0">
                                <div class="card-header p-0 border-0" id="heading-239">
                                    <button class="btn btn-link accordion-title border-0 collapse {{$status_class}}"
                                        style="display:flex;justify-content: space-between;align-items: center;">{{$classContent->class_name}}
                                        @if($classContent->class_status == 2)
                                        <img src="{{asset('asset/image/tickMark.png')}}" style="margin-right: 10px;"
                                            class="clss_completed {{$status_class}}" width="20px" alt="">
                                        @endif
                                    </button>
                                </div>
                                <div id="collapse-{{$classContent->class_id}}" class="collapse"
                                    aria-labelledby="heading-{{$classContent->class_id}}" data-parent="#accordion">
                                    <div class="card-body accordion-body">
                                        <p>{{$classContent->class_description}}</p>
                                    </div>
                                </div>


                            </div>


                            @if(isset($quizzesWithKey[$classContent->quiz_id]) && $classContent->class_quiz == "yes")

                            @php $quizz_exist=1;@endphp
                            @php $quizz_hide = $classContent->class_status == 1 ? "classhide" :
                            ($classContent->class_status == 2 && $classContent->quiz_status == 0 ? "classshow" :
                            ($classContent->quiz_status == 1 ? "classcompleted" : "classhide"));
                            @endphp

                            <div class="card border-0">
                                <div class="card-header p-0 border-0" id="heading-239">
                                    <button class="btn btn-link accordion-title border-0 collapse {{$quizz_hide}}"
                                        style="display:flex;justify-content:space-between;align-items: center;">{{$quizzesWithKey[$classContent->quiz_id]->quiz_name}}
                                        (Q)



                                        @if($classContent->quiz_status == 1)
                                        <img src="{{asset('asset/image/tickMark.png')}}" style="margin-right: 10px;"
                                            class="clss_completed {{$status_class}}" width="20px" alt="">

                                        @endif
                                    </button>
                                </div>


                            </div>
                            @else
                            @php $quizz_hide="" @endphp

                            @endif




                            @endforeach
                            @if(isset($course_certificate[0]->course_exam) && $course_certificate[0]->course_exam == 1)
                            @php
                            // Get the current date in the desired format (dd-mm-yyyy)
                            $currentDate = date('d-m-Y');

                            // Convert the exam date to the desired format (dd-mm-yyyy)
                            $examDate = date('d-m-Y', strtotime($course_certificate[0]->exam_date));

                            // Compare the current date with the exam date
                            $isCurrentDatePassed = strtotime($currentDate) >= strtotime($examDate);
                            @endphp

                            @if($isCurrentDatePassed)
                            @php $status_class = "examshow"; @endphp
                            @elseif($course_certificate[0]->exam_status == 2)
                            @php $status_class = "examcompleted"; @endphp
                            @else
                            @php $status_class = "examhide"; @endphp

                            @endif

                            @php
                            // Check if a record exists in the course_exam table for the user
                            $userHasExamRecord = DB::table('elearning_courseexam')
                            ->where('user_id', $user_id) // Replace with the appropriate column name for user_id
                            ->where('course_id', $course_certificate[0]->course_id)
                            ->exists();
                            @endphp

                            <div class="card border-0">
                                <div class="card-header p-0 border-0" id="heading-239">
                                    <button
                                        class="btn btn-link accordion-title border-0 collapse exam {{$status_class}}"
                                        exam-date="{{$course_certificate[0]->exam_date}}"
                                        style="display:flex;justify-content:space-between;align-items: center;"
                                        {{$userHasExamRecord ? 'disabled' : ''}}>
                                        {{$course_certificate[0]->exam_name}} (E)

                                        @if($course_certificate[0]->exam_status == 2)
                                        <img src="{{asset('asset/image/tickMark.png')}}" style="margin-right: 10px;"
                                            class="clss_completed" width="20px" alt="">
                                        @endif
                                    </button>
                                </div>
                            </div>

                            @endif

                            @if(isset($course_certificate[0]->course_certificate)&&($course_certificate[0]->course_certificate
                            == 1))
                            @php $is_display=$course_certificate[0]->status != 2 ? "certificatehide" :
                            "certificateshow"; @endphp

                            @if(isset($course_certificate[0]->course_certificate)&&
                            ($course_certificate[0]->get_certified == 1))
                            @php $certified="Download Certificate"; @endphp
                            @elseif(isset($course_certificate[0]->get_certified)&&($course_certificate[0]->get_certified
                            == 0))
                            @php $certified="Get Certified"; @endphp
                            @else
                            @php $certified="Get Certified"; @endphp

                            @endif
                            <div class="col-md-12">
                                @php
                                $course_exam_status = DB::table('elearning_courseexam')
                                ->where('user_id', $user_id) // Replace with the appropriate column name for user_id
                                ->where('course_id', $course_certificate[0]->course_id)
                                ->value('result'); // Assuming 'status' column holds the pass/fail status

                                @endphp

                                @php $id=Crypt::encrypt($course_certificate[0]->course_id); @endphp
                                @if($quizz_hide == "classshow")
                                <a style="display:flex;justify-content: center;align-items: center;"
                                    class="btn btn-link accordion-title col-md-12 certificatehide"
                                    href="{{$is_display=$course_certificate[0]->course_progress == 100 || $course_certificate[0]->get_certified == 3 ? route('generatePDF',$id) : 'javascript:void(0)' }}">Get
                                    Certified
                                </a>
                                @elseif($course_exam_status == 'PASS' && $course_certificate[0]->course_progress == 100
                                && $course_certificate[0]->get_certified == 0)
                                <a style="display:flex;justify-content: center;align-items: center;"
                                    class="btn btn-link accordion-title col-md-12  {{$is_display}} "
                                    href="{{route('generatePDF', $id)}}">{{$certified}}</a>
                                @elseif($course_exam_status == 'FAIL' && $course_certificate[0]->get_certified == 0)
                                <a style="display:flex;justify-content: center;align-items: center;"
                                    class="btn btn-link accordion-title col-md-12  certificatehide ">{{$certified}}</a>


                                @elseif($course_certificate[0]->get_certified == 1)
                                <a style="display:flex;justify-content: center;align-items: center;"
                                    class="btn btn-link accordion-title col-md-12 {{$is_display}}"
                                    href="{{asset('userdocuments/certificate/'.$course_certificate[0]->user_id.'/'.$course_certificate[0]->course_id.'/certificate.pdf')}}"
                                    download id="download_certificate">Download</a>
                                @endif

                            </div>
                            @endif



                        </div>

                    </div>


                    <!-- @foreach($selected_class as $classContent)
                    <div class="list-group-item list-group-item-action courseContent">
                        <div class="completionHolder"></div>
                         <input type="checkbox" class="form-check-input" id="class_{{$courseContent->class_name}}"> 
                        <span type="button">
                            {{$classContent->class_name}}
                        </span>
                    </div>
                    @endforeach -->
                </div>
            </div>
        </div>
    </div>
    <main class="classWrapper">
        @yield('content')
    </main>
    <!-- <script>
        // let link = document.querySelectorAll(".sidebar_links");
        // link[0].classList.toogle("active");
        let completionHolder = document.querySelector('.completionHolder');
        completionHolder.classList.add("doneMark");
    </script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.4/jquery.simplePagination.js" integrity="sha512-D8ZYpkcpCShIdi/rxpVjyKIo4+cos46+lUaPOn2RXe8Wl5geuxwmFoP+0Aj6wiZghAphh4LNxnPDiW4B802rjQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
</body>

<style>
[data-toggle="collapse"] i:before {
    content: "\f067";
}

[data-toggle="collapse"].collapsed i:before {
    content: "\f067";
}

.fas,
.far,
.fab,
.fal {
    font-size: 13px;
    top: 6px !important;
    float: right !important;
    margin-right: 20px !important;
    position: relative;
}

#accordion {
    padding-bottom: 1rem !important;
    margin-top: -20px !important;

    .card-header {
        margin-bottom: 8px;
    }


    .accordion-title {
        position: relative;
        display: block;
        padding: 8px 0 8px 15px;

        border-radius: 8px;
        overflow: hidden;
        text-decoration: none;

        font-size: 16px;
        font-weight: 700;
        width: 100%;
        text-align: left;
        transition: all .4s ease-in-out;

        i {
            position: absolute;
            width: 40px;
            height: 100%;
            left: 0;
            top: 0;
            color: #fff;
            background: radial-gradient(rgba(#213744, .8), #213744);
            text-align: center;
            border-right: 1px solid transparent;
        }

        &:hover {
            padding-left: 60px;
            background: #213744;
            color: #fff;

            i {
                border-right: 1px solid #fff;
            }
        }
    }

    .accordion-body {
        padding: 10px 20px;
        overflow-y: scroll;
        height: 200px;


        ul {
            list-style: none;
            margin-left: 0;
            padding-left: 0;
        }

        li {
            padding-left: 1.2rem;
            text-indent: -1.2rem;

            &:before {
                content: "\f10a";
                padding-right: 5px;
                font-family: "Flaticon";
                font-size: 16px;
                font-style: normal;
                color: #213744;
            }
        }
    }
}
</style>


@include('layouts.script')

</html>
<script>
function certification(course_id) {
    // alert(course_id);
    $.ajax({
        url: "{{ url('/generatepdf/{id}') }}",
        type: 'GET',
        data: {
            'course_id': course_id,
            _token: '{{csrf_token()}}'
        },
        success: function(data) {
            // alert('fe');
            console.log(data);
            // if (data != 0) {
            //     Swal.fire("Success!", "Reply Added Successfully!", "success").then((result) => {

            //         location.reload();

            //     })
            // }



        }
    });





}
</script>

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
            var count = data['Elearning_usernotifications_count'][0].countflow;


            if (count == 0) {
                $('.notification-tab').append(
                    '<div class="fade-in-text no_notification "><p>No new notifications</p></div>');

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
                    $('.notification-tab').append('<li class="hover_class" onclick="notification(' +
                        notification_id +
                        ')" class="notification-list-item"><p class="message p-1 m-0">' + alert_meg +
                        " " + formatted_date + '<p></li>');
                }
                var usercount = count;
                $('.notify').append(
                    '<span class="badge badge-light bell_notification" style="background-color:red !important;">' +
                    usercount + '</span>');
            }
        },
    });
}
$(document).on('click', '.certificateshow', function() {
    var href = $('.certificateshow').prop('href');
    if (href == "javascript:void(0)") {
        document.getElementById('download_certificate').click();

    }
})

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
$(document).on('click', '.certificatehide,.classhide', function() {

    swal.fire({
        title: "Kindly Complete All the Classes",

        icon: "info",
    });


})

$(document).on('click', '.certificatehide,.classhide', function() {

    swal.fire({
        title: "Kindly Complete All the Classes",

        icon: "info",
    });


})

$(document).on('click', '.examhide', function() {
    var examDate = $('.exam').attr('exam-date');
    var formattedDate = formatDate(examDate);

    swal.fire({
        title: "Exam is only available on \n" + formattedDate,
        icon: "info"
    });
});

function formatDate(dateString) {
    var dateParts = dateString.split('-');
    var day = parseInt(dateParts[0]);
    var month = parseInt(dateParts[1]);
    var year = parseInt(dateParts[2]);

    var formattedDay = getOrdinalSuffix(day);
    var monthName = getMonthName(month);

    return formattedDay + ' ' + monthName + ' ' + year;
}

function getOrdinalSuffix(day) {
    if (day >= 11 && day <= 13) {
        return day + 'th';
    } else {
        var lastDigit = day % 10;
        switch (lastDigit) {
            case 1:
                return day + 'st';
            case 2:
                return day + 'nd';
            case 3:
                return day + 'rd';
            default:
                return day + 'th';
        }
    }
}

function getMonthName(month) {
    var monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October',
        'November', 'December'
    ];
    return monthNames[month - 1];
}

// $(document).on('click', '.fa-times', function() {
//     document.querySelector('.courseContentsWrapper').style.display = "none";

// });
</script>
<script>
$(document).on('click', '.examshow', function() {
    document.getElementById('exam_details').style.display = "block";

});
document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.getElementById('toggleCourseContents');
    const sidebar = document.getElementById('aside-menu');

    toggleButton.addEventListener('click', function() {
        sidebar.classList.toggle('active');

        // Toggle the display of courseContentsWrapper based on the sidebar's active state
        if (sidebar.classList.contains('active')) {
            document.querySelector('.courseContentsWrapper').style.display = "block";
        } else {
            document.querySelector('.courseContentsWrapper').style.display = "none";
        }
    });

    // Close the sidebar when the fa-times icon is clicked
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('fa-times')) {
            sidebar.classList.remove('active');
            document.querySelector('.courseContentsWrapper').style.display = "none";
        }
    });
});
</script>

<style>
/* Hide courseContentsWrapper by default */
/* .courseContentsWrapper {
        width: 300px;
       
        transition: transform 0.3s ease;
        transform: translateX(-100%);
    } */

.courseContentsWrapper.active {
    transform: translateX(0);
}

/* Mobile Responsive Styles */
@media (max-width: 767px) {
    .courseContentsWrapper {
        width: 100%;
        /* Take full width on smaller screens */
        position: fixed;
        top: 0;
        left: -100%;
        height: 100%;
        background-color: white;
        z-index: 1000;
    }

    .courseContentsWrapper {
        display: none;
    }

    .courseContentsWrapper.active {
        transform: translateX(0);
        left: 0;
    }
}
</style>