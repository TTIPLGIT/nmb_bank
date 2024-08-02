@extends('layouts.adminnav')

@section('content')
@include('dashboard_css')
<style>
    .bg-muted {
        background-color: rgba(0, 0, 0, .03);
    }

    .gap_class {
        gap: 5px;
    }

    .tooltip {
        position: relative;
        display: inline-block;
        border-bottom: 1px dotted black;
    }

    .tooltip .tooltiptext {
        visibility: hidden;
        width: 120px;
        background-color: black;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px 0;

        /* Position the tooltip */
        position: absolute;
        z-index: 1;
    }

    .tooltip:hover .tooltiptext {
        visibility: visible;
    }

    .percentage {
        position: absolute;
        top: 106px;
        right: 58px;
    }

    .md-stepper-horizontal .md-step .md-step-bar-left,
    .md-stepper-horizontal .md-step .md-step-bar-right {
        top: 17px !important;
    }
</style>
<style>
    @media (min-width: 1025px) {

        .section-body {
            margin-top: 3rem;
            width: calc(100% - 280px);
        }

        .sidebar-mini .section-body {
            width: calc(100% - 90px) !important;
        }
    }

    #align1_length,
    #align1_filter {
        display: none !important;
    }

    #piechart {
        overflow: auto;
    }

    .dataTables_paginate {
        padding: 0 !important;
        margin: 0 !important;
        /* float: left !important; */
    }

    .dataTables_paginate {
        /* display: inline !important; */
    }

    .pagination {
        display: inline !important;
        float: right !important;
    }

    .bglred {
        background-color: #ff251b !important;
    }

    .cclr {
        color: #ebebec;
    }



    table.custom,
    tbody,
    tr,
    td {
        word-break: break-all !important
    }

    .main-contents {

        width: 100%;
        /* position: relative; */
    }



    #align td,
    #align th,
    #tableExport td,
    .tableExport td,
    #tableExport th,
    .tableExport th,
    #tableExport1 td,
    #tableExport1 th,
    #align1 td,
    #align1 th,
    #align2 td,
    #align2 th,
    #align3 td,
    #align3 th,
    #align4 td,
    #align4 th {
        padding: 8px !important;
        word-break: break-word !important;

    }
</style>

<style>
    html {
        -webkit-font-smoothing: antialiased !important;
        -moz-osx-font-smoothing: grayscale !important;
        -ms-font-smoothing: antialiased !important;
    }


    .main-content2 {
        width: 100% !important;
        padding-left: 35px !important;
        padding-right: 0px !important;
    }


    .md-stepper-horizontal {
        display: table;
        width: 100%;
        margin: 24px auto;
        background-color: transparent;
        /* box-shadow: 0 3px 8px -6px rgba(0,0,0,.50); */
    }

    .md-stepper-horizontal .md-step {
        display: table-cell;
        position: relative;
        padding: 24px !important;
    }

    .md-stepper-horizontal .md-step:active {
        border-radius: 15% / 75%;
    }

    .md-stepper-horizontal .md-step:first-child:active {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    .md-stepper-horizontal .md-step:last-child:active {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    .md-stepper-horizontal .md-step:hover .md-step-circle {
        background-color: #757575;
    }

    .md-stepper-horizontal .md-step:first-child .md-step-bar-left,
    .md-stepper-horizontal .md-step:last-child .md-step-bar-right {
        display: none;
    }

    .md-stepper-horizontal .md-step .md-step-circle {
        width: 30px;
        height: 30px;
        margin: 0 auto;
        background-color: #999999;
        border-radius: 50%;
        text-align: center;
        line-height: 30px;
        font-size: 16px;
        font-weight: 600;
        color: #FFFFFF;
    }

    .md-stepper-horizontal.green .md-step.active .md-step-circle {
        background-color: #00AE4D;
    }

    .md-stepper-horizontal.orange .md-step.active .md-step-circle {
        background-color: #F96302;
    }

    .md-stepper-horizontal .md-step.active .md-step-circle {
        background-color: rgb(33, 150, 243);
    }

    .md-stepper-horizontal .md-step.done .md-step-circle:before {
        font-family: 'FontAwesome';
        font-weight: 100;
        content: "\f00c";
    }

    .md-stepper-horizontal .md-step.done .md-step-circle *,
    .md-stepper-horizontal .md-step.editable .md-step-circle * {
        display: none;
    }

    .md-stepper-horizontal .md-step.editable .md-step-circle {
        -moz-transform: scaleX(-1);
        -o-transform: scaleX(-1);
        -webkit-transform: scaleX(-1);
        transform: scaleX(-1);
    }

    .md-stepper-horizontal .md-step.editable .md-step-circle:before {
        font-family: 'FontAwesome';
        font-weight: 100;
        content: "\f040";
    }

    .md-stepper-horizontal .md-step .md-step-title {
        margin-top: 16px;
        font-size: 16px;
        font-weight: 600;
    }

    .md-stepper-horizontal .md-step .md-step-title,
    .md-stepper-horizontal .md-step .md-step-optional {
        text-align: center;
        color: rgba(0, 0, 0, .26);
    }

    .md-stepper-horizontal .md-step.active .md-step-title {
        font-weight: 600;
        color: rgba(0, 0, 0, .87);
    }

    .md-stepper-horizontal .md-step.active.done .md-step-title,
    .md-stepper-horizontal .md-step.active.editable .md-step-title {
        font-weight: 600;
    }

    .md-stepper-horizontal .md-step .md-step-optional {
        font-size: 12px;
    }

    .md-stepper-horizontal .md-step.active .md-step-optional {
        color: rgba(0, 0, 0, .54);
    }

    .md-stepper-horizontal .md-step .md-step-bar-left,
    .md-stepper-horizontal .md-step .md-step-bar-right {
        position: absolute;
        top: 36px;
        height: 1px;
        border-top: 1px solid #DDDDDD;
    }

    .md-stepper-horizontal .md-step .md-step-bar-right {
        right: 0;
        left: 50%;
        margin-left: 20px;
    }

    .md-stepper-horizontal .md-step .md-step-bar-left {
        left: 0;
        right: 50%;
        margin-right: 20px;
    }

    .swiper-button-prev {
        margin: -33px 0px 0px 25px !important;
        background-image: url('/images/arrowL.png') !important;
    }

    .swiper-button-prev,
    .swiper-container-rtl .swiper-button-next {
        left: 9px;
        right: auto;
        top: 50px;
    }

    .swiper-button-next,
    .swiper-container-rtl .swiper-button-prev {
        right: 10px;
        left: auto;
        top: 44px;
    }



    .myheader {
        font-family: 'Cinzel Decorative', cursive;
        font-size: 30px;
        font-weight: bold;
        text-shadow: 0px 1px 1px rgba(0, 0, 0, 0.4),
            0px 2px 4px rgba(0, 0, 0, 0.1),
            0px 2px 5px rgba(0, 0, 0, 0.1);

    }

    .mysubheader {
        font-family: headfont;
        font-size: 26px;
        font-weight: bold;
        text-shadow: 0px 4px 3px rgba(0, 0, 0, 0.4),
            0px 8px 13px rgba(0, 0, 0, 0.1),
            0px 18px 23px rgba(0, 0, 0, 0.1);
    }

    .mytext {
        font-family: 'Oswald', sans-serif;
        font-family: 'Economica', sans-serif;
        font-size: 24px;
    }

    .chapterhead:before {
        content: "";
        border-style: solid;
        border-width: 0px 10px 10px 0;
        border-color: transparent #b2b3b2 transparent transparent;
        position: absolute;
        left: 5px;
        top: 100px;
    }

    .chapterhead:after {
        content: "";
        border-style: solid;
        border-width: 10px 10px 10px 0px;
        border-color: #b2b3b2 transparent transparent transparent;
        position: absolute;
        right: 5px;
        top: 100px;
    }

    .chapterfoot:before {
        content: "";
        border-style: solid;
        border-width: 10px 10px 0px 0;
        border-color: transparent #b2b3b2 transparent transparent;
        position: absolute;
        left: 5px;
        bottom: 140px;
    }

    .chapterfoot:after {
        content: "";
        border-style: solid;
        border-width: 0px 10px 10px 0;
        border-color: transparent transparent #b2b3b2 transparent;
        position: absolute;
        right: 5px;
        bottom: 140px;
    }

    /*... FOR THE TIMELINE ...*/

    .timeline {
        list-style: none;
        padding: 20px 0 20px;
        position: relative;

    }

    .timeline:before {
        top: 0;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 3px;
        background-color: #eeeeee;
        left: 50%;
        margin-left: -1.5px;
    }

    .timeline>li {
        margin-bottom: 20px;
        position: relative;
    }

    .timeline>li:before,
    .timeline>li:after {
        content: " ";
        display: table;
    }

    .timeline>li:after {
        clear: both;
    }

    .timeline>li:before,
    .timeline>li:after {
        content: " ";
        display: table;
    }

    .timeline>li:after {
        clear: both;
    }

    .timeline>li>.timeline-panel {
        width: 50%;
        float: left;
        border: 1px solid #d4d4d4;
        border-radius: 2px;
        padding: 20px;
        position: relative;
        background-color: #eee;
        -webkit-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
        box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
    }

    .timeline>li.timeline-inverted+li:not(.timeline-inverted),
    .timeline>li:not(.timeline-inverted)+li.timeline-inverted {
        margin-top: -60px;
    }

    .timeline>li:not(.timeline-inverted) {
        padding-right: 90px;
    }

    .timeline>li.timeline-inverted {
        padding-left: 90px;
    }

    .timeline>li>.timeline-panel:before {
        position: absolute;
        top: 26px;
        right: -15px;
        display: inline-block;
        border-top: 15px solid transparent;
        border-left: 15px solid #ccc;
        border-right: 0 solid #ccc;
        border-bottom: 15px solid transparent;
        content: " ";
    }

    .timeline>li>.timeline-panel:after {
        position: absolute;
        top: 27px;
        right: -14px;
        display: inline-block;
        border-top: 14px solid transparent;
        border-left: 14px solid #fff;
        border-right: 0 solid #fff;
        border-bottom: 14px solid transparent;
        content: " ";
    }

    .timeline>li>.timeline-badge {
        color: #fff;
        width: 50px;
        height: 50px;
        line-height: 50px;
        font-size: 1.4em;
        text-align: center;
        position: absolute;
        top: 16px;
        left: 50%;
        margin-left: -25px;
        background-color: #999999;
        z-index: 100;
        border-top-right-radius: 50%;
        border-top-left-radius: 50%;
        border-bottom-right-radius: 50%;
        border-bottom-left-radius: 50%;
    }

    .timeline>li.timeline-inverted>.timeline-panel {
        float: right;
    }

    .timeline>li.timeline-inverted>.timeline-panel:before {
        border-left-width: 0;
        border-right-width: 15px;
        left: -15px;
        right: auto;
    }

    .timeline>li.timeline-inverted>.timeline-panel:after {
        border-left-width: 0;
        border-right-width: 14px;
        left: -14px;
        right: auto;
    }

    .timeline-badge.primary {
        background-color: #2e6da4 !important;
    }

    .timeline-badge.success {
        background-color: #3f903f !important;
    }

    .timeline-badge.warning {
        background-color: #f0ad4e !important;
    }

    .timeline-badge.danger {
        background-color: #d9534f !important;
    }

    .timeline-badge.info {
        background-color: #5bc0de !important;
    }

    .timeline-title {
        margin-top: 0;
        color: inherit;
    }

    .timeline-body>p,
    .timeline-body>ul {
        margin-bottom: 0;
    }

    .timeline-body>p+p {
        margin-top: 5px;
    }

    .skin-green .main-header .navbar {
        background-color: #008975;
        border-bottom: 5px solid rgba(225, 225, 20, 0.4);
    }

    .affix {
        top: 0px;
        z-index: -1 !important;
        width: 100%;
    }

    /* Ensure layout covers the entire screen. */
    html {
        height: 100%;
    }

    /* Place drawer and content side by side. */
    .demo-body {
        display: flex;
        flex-direction: row;
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        height: 100%;
        width: 100%;
    }

    /* Stack toolbar and main on top of each other. */
    .demo-content {
        display: inline-flex;
        flex-direction: column;
        flex-grow: 1;
        height: 100%;
        box-sizing: border-box;
    }

    .demo-main {
        padding-left: 36px;
    }

    .cardpad {
        padding: 30px !important;
    }

    .card1 {
        height: 50px;
    }

    .card2 {
        margin-top: 17px;
    }
</style>

<style>
    html {
        -webkit-font-smoothing: antialiased !important;
        -moz-osx-font-smoothing: grayscale !important;
        -ms-font-smoothing: antialiased !important;
    }



    .md-stepper-horizontal {
        display: table;
        width: 100%;
        margin: 0 auto;
        background-color: transparent;
        margin-top: 68px;
        /* box-shadow: 0 3px 8px -6px rgba(0,0,0,.50); */
    }

    .md-stepper-horizontal .md-step {
        display: table-cell;
        position: relative;
        padding: 24px;
    }

    .md-stepper-horizontal .md-step:active {
        border-radius: 15% / 75%;
    }

    .md-stepper-horizontal .md-step:first-child:active {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    .md-stepper-horizontal .md-step:last-child:active {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    .md-stepper-horizontal .md-step:hover .md-step-circle {
        background-color: #757575;
    }

    .md-stepper-horizontal .md-step:first-child .md-step-bar-left,
    .md-stepper-horizontal .md-step:last-child .md-step-bar-right {
        display: none;
    }

    .md-stepper-horizontal .md-step .md-step-circle {
        width: 30px;
        height: 30px;
        margin: 0 auto;
        background-color: #999999;
        border-radius: 50%;
        text-align: center;
        line-height: 30px;
        font-size: 16px;
        font-weight: 600;
        color: #FFFFFF;
    }

    .md-stepper-horizontal.green .md-step.active .md-step-circle {
        background-color: #00AE4D;
    }

    .md-stepper-horizontal.orange .md-step.active .md-step-circle {
        background-color: #F96302;
    }

    .md-stepper-horizontal .md-step.active .md-step-circle {
        background-color: rgb(33, 150, 243);
    }

    .md-stepper-horizontal .md-step.done .md-step-circle:before {
        font-family: 'FontAwesome';
        font-weight: 100;
        content: "\f00c";
    }

    .md-stepper-horizontal .md-step.done .md-step-circle *,
    .md-stepper-horizontal .md-step.editable .md-step-circle * {
        display: none;
    }

    .md-stepper-horizontal .md-step.editable .md-step-circle {
        -moz-transform: scaleX(-1);
        -o-transform: scaleX(-1);
        -webkit-transform: scaleX(-1);
        transform: scaleX(-1);
    }

    .md-stepper-horizontal .md-step.editable .md-step-circle:before {
        font-family: 'FontAwesome';
        font-weight: 100;
        content: "\f040";
    }

    .md-stepper-horizontal .md-step .md-step-title {
        margin-top: 16px;
        font-size: 16px;
        font-weight: 600;
    }

    .md-stepper-horizontal .md-step .md-step-title,
    .md-stepper-horizontal .md-step .md-step-optional {
        text-align: center;
        color: rgba(0, 0, 0, .26);
    }

    .md-stepper-horizontal .md-step.active .md-step-title {
        font-weight: 600;
        color: rgba(0, 0, 0, .87);
    }

    .md-stepper-horizontal .md-step.active.done .md-step-title,
    .md-stepper-horizontal .md-step.active.editable .md-step-title {
        font-weight: 600;
    }

    .md-stepper-horizontal .md-step .md-step-optional {
        font-size: 12px;
    }

    .md-stepper-horizontal .md-step.active .md-step-optional {
        color: rgba(0, 0, 0, .54);
    }

    .md-stepper-horizontal .md-step .md-step-bar-left,
    .md-stepper-horizontal .md-step .md-step-bar-right {
        position: absolute;
        top: 36px;
        height: 1px;
        border-top: 1px solid #DDDDDD;
    }

    .md-stepper-horizontal .md-step .md-step-bar-right {
        right: 0;
        left: 50%;
        margin-left: 20px;
    }

    .md-stepper-horizontal .md-step .md-step-bar-left {
        left: 0;
        right: 50%;
        margin-right: 20px;
    }

    .swiper-button-prev {
        margin: -33px 0px 0px 25px !important;
        background-image: url('/images/arrowL.png') !important;
    }

    .swiper-button-prev,
    .swiper-container-rtl .swiper-button-next {
        left: 9px;
        right: auto;
        top: 50px;
    }

    .swiper-button-next,
    .swiper-container-rtl .swiper-button-prev {
        right: 10px;
        left: auto;
        top: 44px;
    }

    .circle {

        background: #c3c3d1;
        width: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 24px;
        font-weight: 500;
    }

    @media (min-width: 320px) {
        .md-stepper-horizontal .md-step {
            padding: 0px !important;
        }
    }
</style>
<!-- <style>
/**
 * The first commented line is your dabblet’s title
 */


.wrapper{
position: absolute;
margin-left: 10%;
margin-top: 15%;
}
.tooltip_custom{
    position:relative;
}

.tooltip_custom:hover span {
    opacity: 1;
    filter: alpha(opacity=100);
    z-index: 99;
    -webkit-transition: all 0.2s ease;
    -moz-transition: all 0.2s ease;
    -o-transition: all 0.2s ease;
    transition: all 0.2s ease;
}

.box b {
  color: #fff;
}

.tooltip_custom span {
    position: absolute;
    left: calc(50% - 120px);
    top: -6em;
    width: 240px;
}

.tooltip_custom span:after {
    border-color: #222 rgba(0, 0, 0, 0);
    border-style: solid;
    border-width: 15px 15px 0;
    bottom: -15px;
    content: "";
    display: block;
    left: calc(50% - 15px);
    position: absolute;
    width: 0;
}

</style>

 -->


<style>
    .tooltip_custom {
        position: relative;
    }

    .tooltip_custom span {
        display: none;
        width: 240px;
        position: absolute;
        top: calc(-100% - 15px);
        left: calc(50% - 120px);
        background-color: #FFFFFF;
        transition: all 1s ease-in-out;
        color: black;
    }

    .tooltip_custom:hover span {
        display: block;
        transition: all 1s ease-in-out;
    }

    .tooltip_custom span::before {
        content: '';
        position: absolute;
        width: 20px;
        height: 10px;
        background-color: #FFFFFF;
        top: 99%;
        left: calc(50% - 10px);
        clip-path: polygon(0 0, 50% 100%, 100% 0);
    }

    .card_buttons>button.btn-info.active {
        background-color: green !important;
    }

    .btn-info:hover {
        background-color: green !important;
    }

    .d_none {
        visibility: hidden;
    }

    .acc-btn {
        border-radius: 20px;
        background: #fff;
        text-decoration: none !important;
        padding: 10px !important;
        font-size: 14px !important;
        color: #000000 !important;

    }

    .acc-drop {

        flex-direction: column;
        row-gap: 18px;
        text-align: justify;
        padding: 5px;
        font-size: 15px;

    }

    .round_cir {
        padding: 12px !important;
    }

    .acc_border {
        border: 1px solid lightgrey !important;
    }
</style>
<style>
    .section-variant-three {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    @media (min-width: 992px) {
        .section-variant-three {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 20px;
        }
    }

    .line-chart {
        box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;
        background-color: #fff;
        padding: 1rem;
        border-radius: 0.375rem;
        height: 362px;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
    }

    .list-variant-one {
        gap: 10px;
    }

    .list-variant-one .list-group-item {
        border: 0;
        font-size: 13px;
        color: #004085;
        background-color: #b8daff;
        padding: 0;
        border-radius: 0.375rem;
    }

    .list-variant-one.pending .list-group-item {
        color: #856404;
        background-color: #ffeeba;
    }

    .list-variant-one.completed .list-group-item {
        color: #155724;
        background-color: #c3e6cb;
    }

    .list-variant-one .list-group-item a {
        display: block;
        padding: 0.5rem 1rem;
        text-decoration: none;
        color: inherit;
    }

    .list-variant-one .list-group-item .title {
        margin: 0 !important;
        line-height: normal;
        font-size: 100%;
        font-weight: 700;
    }

    .list-variant-one .list-group-item .sub-title {
        margin: 0 !important;
        line-height: normal;
        font-size: 60%;
        font-weight: 600;
    }

    .announcement {
        border: 0;
        font-size: 13px;
        padding: 0.5rem;
        border-radius: 0.375rem;
        color: #0c5460;
        background-color: #bee5eb;
        gap: 10px;
        cursor: pointer;
    }

    .announcement-poster {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 0.375rem;
    }

    .announcement-name {
        margin: 0 !important;
        line-height: normal;
        font-size: 100%;
        font-weight: 700;
    }

    .announcement-author {
        margin: 0 !important;
        line-height: normal;
        font-size: 60%;
        font-weight: 600;
    }

    #fancyHeader {
        padding: 1rem;
        color: #0c5460 !important;
        background-color: #bee5eb !important;
    }

    #fancyHeader .closefancy {
        border: 0;
        outline: 0;
        color: #0c5460;
        background-color: transparent;
        border-radius: 0.375rem;
    }

    #fancyHeader .closefancy:hover,
    #fancyHeader .closefancy:focus {
        background-color: #00000030;
    }

    #fancyContainerInner .card {
        --fancy-font-size: 2rem;
        border: 0px;
        padding: 0px;
    }

    #fancyContainerInner .card-body {
        box-shadow: none !important;
        background-color: transparent !important;
    }

    #fancyContainerInner .card-title {
        color: #0c5460 !important;
        font-size: var(--fancy-font-size);
        font-weight: 700;
        line-height: 1em;
        margin-bottom: 0.75rem;
    }

    #fancyContainerInner .card-subtitle {
        font-size: calc((60 * var(--fancy-font-size)) / 100);
        font-weight: 600;
        line-height: normal;
    }

    #fancyContainerInner .card-caption-text {
        background-color: #fff;
        padding: 1rem;
        border-radius: 0.375rem;
        max-height: 330px;
        overflow-y: auto;
        overflow-x: hidden;
        box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
    }

    #fancyControls .carousel-control-prev,
    #fancyControls .carousel-control-next {
        position: absolute;
        top: calc(50% - 25px);
        width: 15px;
        height: 50px;
        border: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 0.375rem;
        color: #0c5460 !important;
        background-color: #bee5eb !important;
        transition: all 300ms ease-in-out;
    }

    #fancyControls .carousel-control-prev {
        left: -10px;
    }

    #fancyControls .carousel-control-next {
        right: -10px;
    }

    .icon-hover:hover {
        box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
    }

    .lms-stat-card {
        height: 89%;
    }

    .lms-stat-card-body {
        height: 100%;
    }

    .lms-stat-text {
        font-weight: 700;
        color: #3d356f !important;
    }
</style>
<style>
    #pagination {
        margin-top: 10px;
        /* text-align: center; */
    }

    #pagination button {
        margin-right: 5px;
        padding: 5px 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    .navigationButtons {
        margin-right: 5px;
        padding: 5px 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    .navigationButtons:hover {
        background-color: #0056b3;
    }

    #pagination button:hover {
        background-color: #0056b3;
    }

    #pagination button.active {
        background-color: #24b300;
        font-weight: bold;
    }
</style>
<style>
    .icon {
        float: right;
        font-size: 500%;
        position: absolute;
        top: 0rem;
        right: -0.3rem;
        opacity: .16;
    }


    #container {
        width: 1200px;
        display: flex;
    }

    .grey-dark {
        background: #495057;
        color: #efefef;
    }

    .red-gradient {
        background: linear-gradient(180deg, rgba(207, 82, 82, 1) 0%, rgba(121, 9, 9, 1) 80%);
        color: #fff;
    }

    .red {
        background: #a83b3b;
        color: #fff;
    }


    .purple {
        background: #886ab5;
        color: #fff;
    }

    .orange {
        background: #ffc241;
        color: #fff;
    }

    .kpi-card {
        overflow: hidden;
        position: relative;
        box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.75);
        display: inline-block;
        float: left;
        padding: 1em;
        border-radius: 0.3em;
        font-family: sans-serif;
        width: 240px;
        min-width: 180px;
        margin-left: 0.5em;
        margin-top: 0.5em;
    }

    .card-value {
        display: block;
        font-size: 200%;
        font-weight: bolder;
    }

    .card-text {
        display: block;
        font-size: 1rem;
        font-weight: bold;
    }

    .my-course-section-icon {
        background-color: #FFFF00;
        padding: 0.5rem;
        border-radius: 5px;
        display: flex;
        flex-direction: row;
        align-items: center;
        font-size: 80%
    }
</style>
<style>
    .highcharts-color-1 {
        fill: Green;
    }

    .highcharts-color-2 {
        fill: gold;
    }

    g .highcharts-data-label text {
        fill: white !important;
    }

    .highcharts-legend.highcharts-no-tooltip {
        display: none;
    }

    /* g .highcharts-data-label-color-0 text {
        fill: red !important;
    } */
</style>
<!-- saranya -->
<style>
    .dataTables_length {
        text-align: left;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>

<div class="main-content contentpadding">
    @if (session('success'))
    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data').val();
            swal.fire({
                title: "Success",
                text: message,
                icon: "success",
                type: "success",
            });

        }
    </script>
    @elseif(session('error'))

    <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data1').val();
            swal.fire({
                title: "Info",
                text: message,
                icon: "info",
                type: "info",
            });

        }
    </script>
    @endif


    <!-- Main Content -->

    <div class="section-body" style="position:absolute; z-index:-1">
        <div class="row">


            <!-- Row 1 -->

            <!-- Admin Dashboard -->

            @if($rows['users']['role_id'] =='1')

            <div class="row">
                <div class="col-md-4">
                    <div class="users">
                        <div class="d-flex flex-row align-items-end mb-3 section-header" style="align-items: center !important;">
                            <div class="my-course-section-icon" style="color: #fff; background-color: #ff6c42 !important;">
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </div>
                            <div class="ml-2 my-course-section-heading" style="font-size: 16px;">Overall User Engagement</div>
                        </div>
                        <div id="row">
                            <!-- <div class="kpi-card orange">
                                <span class="card-value active_users">0</span>
                                <span class="card-text">Active User</span>
                                <i class="fa fa-user icon"></i>
                            </div> -->
                            <div class="kpi-card purple">
                                <span class="card-value totalUsers">{{$admin['licenceCount']}}</span>
                                <span class="card-text">Licensed Valuer</span>
                                <i class="fa fa-users icon"></i>
                            </div>
                            <div class="kpi-card grey-dark">
                                <span class="card-value totalAssessmentsCompleted">{{$admin['expiredLicenceCount']}}</span>
                                <span class="card-text">Expired Licence Users</span>
                                <i class="fa fa-times-circle-o icon"></i>
                            </div>
                            <div class="kpi-card red">
                                <span class="card-value totalCertifiedUsers">{{$admin['expiredFirmCount']}}</span>
                                <span class="card-text">Expired Firm Users</span>
                                <i class="fa fa-file icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="d-flex flex-row align-items-end mb-3 section-header">
                        <div class="my-course-section-icon" style="background-color: #ff6ca5; color: #fff;">
                            <i class="fa fa-bullseye" aria-hidden="true"></i>
                        </div>
                        <div class="ml-2 my-course-section-heading">User Statistics</div>
                    </div>
                    <div id="container" style="width: 600px; height: 400px;"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-3">
                    <div class="d-flex flex-row align-items-end mb-3 section-header">
                        <div class="my-course-section-icon" style="background-color: #3397e7; color: #fff;">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </div>
                        <div class="ml-2 my-course-section-heading">Critical Users Overview</div>
                    </div>
                    <div class="card" style="text-align:left">
                        <div class="card-body no-header" style="padding:1rem !important">
                            <div class="content-holder">
                                <table class="table table-stripped" id="align">
                                    <thead>
                                        <tr>
                                            <th>S.no</th>
                                            <th>Name</th>
                                            <th>Designation</th>
                                            <th>Registered Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($admin['tabledata'] as $row)

                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$row->name}}</td>
                                            <td>{{$row->role_designation ?$row->role_designation:$row->role_name}}</td>
                                            <td>{{date('Y-m-d', strtotime($row->created_at))}}</td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @elseif ($rows['users']['role_id'] == "27")

            <div class="row">
                <div class="col-12">
                    <div class="card" style="height: 148px;">
                        <div class="card-header card_class">
                            Profile Completion
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="swiper-button-prev swipenav" onclick="previousnexttab(event)" id="swiper_prev" tabindex="0" role="button" aria-label="Previous slide" aria-disabled="false" style="display: block;"></div>
                                    <div class="swiper-button-next swipenav" onclick="previousnexttab(event)" id="swiper_next" tabindex="0" role="button" aria-label="Next slide" aria-disabled="false" style="display: block;"></div>
                                    <div class="md-stepper-horizontal col-8">
                                        @php $status=0; @endphp
                                        @if( $rows['progress']['gen'] == [])
                                        <div class="md-step" value='1' name="tab_1" onclick="ticker(1)">

                                            @else
                                            <div class="md-step active" value='1' name="tab_1" onclick="ticker(1)">
                                                @php $status += 14.3; @endphp
                                                @endif
                                                <div class="md-step-circle tooltip_custom">1<span>General details</span></div>
                                                <div class="md-step-bar-left"></div>
                                                <div class="md-step-bar-right"></div>

                                            </div>
                                            @if( $rows['progress']['edu'] == [])
                                            <div class="md-step " value='2' name="tab_2" onclick="ticker(2)">
                                                @else
                                                @php $status += 14.3; @endphp
                                                <div class="md-step active" value='2' name="tab_2" onclick="ticker(2)">
                                                    @endif

                                                    <div class="md-step-circle tooltip_custom">2<span>Education details</span></div>
                                                    <div class="md-step-bar-left"></div>
                                                    <div class="md-step-bar-right"></div>

                                                </div>
                                                @if( $rows['progress']['exp'] == [])
                                                <div class="md-step " value='3' name="tab_3" onclick="ticker(3)">


                                                    @else
                                                    @php $status += 14.3; @endphp
                                                    <div class="md-step active" value='3' name="tab_3" onclick="ticker(3)">

                                                        @endif
                                                        <div class="md-step-circle tooltip_custom">3<span>Work Experience</span></div>
                                                        <div class="md-step-bar-left"></div>
                                                        <div class="md-step-bar-right"></div>

                                                    </div>
                                                    @if( $rows['progress']['gt_approveprocess'] == [])
                                                    <div class="md-step " value='4' name="tab_4" onclick="ticker(4)">
                                                        @else
                                                        @php $status += 14.3; @endphp
                                                        <div class="md-step active" value='4' name="tab_4" onclick="ticker(4)">

                                                            @endif
                                                            <div class="md-step-circle tooltip_custom">4<span>Supervision</span></div>
                                                            <div class="md-step-bar-left"></div>
                                                            <div class="md-step-bar-right"></div>

                                                        </div>
                                                        @if( $rows['progress']['ethics_test'] == [])
                                                        <div class="md-step " value='5' name="tab_5" onclick="ticker(5)">
                                                            @else
                                                            @php $status += 14.3; @endphp
                                                            <div class="md-step active" value='5' name="tab_5" onclick="ticker(5)">
                                                                @endif
                                                                <div class="md-step-circle tooltip_custom">5<span>Ethics Test</span></div>
                                                                <div class="md-step-bar-left"></div>
                                                                <div class="md-step-bar-right"></div>

                                                            </div>
                                                            <div class="md-step" value='6' name="tab_6" onclick="ticker(6)">
                                                                <div class="md-step-circle tooltip_custom">6<span>Critical Analysis Report</span></div>
                                                                <div class="md-step-bar-left"></div>
                                                                <div class="md-step-bar-right"></div>

                                                            </div>
                                                            <div class="md-step wrapper" value='7' name="tab_7" onclick="ticker(7)">
                                                                <div class="md-step-circle tooltip_custom">7<span>Undertake CPD</span></div>
                                                                <div class="md-step-bar-left"></div>
                                                                <div class="md-step-bar-right"></div>
                                                            </div>



                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="percentage">
                                                    <h2>{{$status}}%</h2>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div id="accordion" class="accordion mt-3 m-3">
                                    <div class="card acc_border">
                                        <div class="card-header" id="headingOne">
                                            <h5 class="mb-0 acc-btn">
                                                <button class="btn" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    Guidelines For Graduate Trainee
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                            <div class="card-body">
                                                <div class="row acc-drop" style="flex-direction: column; row-gap: 18px;">
                                                    <div class="col d-flex gap_class p-3">
                                                        <div class="rounded-circle circle">
                                                            1
                                                        </div>
                                                        =>
                                                        <span>First go to the Gereral Details menu under the Registration module and fill your General Details to complete the first Process.</span>
                                                    </div>
                                                    <div class="col d-flex gap_class p-3 bg-muted">
                                                        <div class="rounded-circle circle">
                                                            2
                                                        </div>
                                                        =>
                                                        <span>After the First Process, Go to the Education Details menu under the Registration module and fill your Academic Detials.</span>
                                                    </div>
                                                    <div class="col d-flex gap_class p-3">
                                                        <div class="rounded-circle circle round_cir">
                                                            3
                                                        </div>
                                                        =>
                                                        <span>Then Go to the Work Experience menu under the Registration module to fill your Experience(*Both Freshers and Experience Candidates can able to fill*).</span>
                                                    </div>
                                                    <div class="col d-flex gap_class p-3 bg-muted">
                                                        <div class="rounded-circle circle round_cir">
                                                            4
                                                        </div>
                                                        =>
                                                        <span>If the Above process are all completed, then Go to the supervision menu under the Registration module, And select your two Professional Member wait for them to approve, We will update you about the status of your application in the meantime, Next Wait for the Registrar to Approve Your application for this also we will notify you via Email and System Notification.</span>
                                                    </div>
                                                    <div class="col d-flex gap_class p-3">
                                                        <div class="rounded-circle circle round_cir">
                                                            5
                                                        </div>
                                                        =>
                                                        <span>After your Successful Registration, Now you are eligible to access the E-learning and use them to develop your validation skills. Now go to the E-learning module on that select <strong>Ethic Test</strong> and complete that.</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--Non Registered Ugandian Dashboard  -->

                                @elseif ($rows['users']['role_id'] == "35")

                                <div class="row">
                                    <div class="col-12">
                                        <div class="card" style="height: 148px;">
                                            <div class="card-header card_class">
                                                Profile Completion
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="swiper-button-prev swipenav" onclick="previousnexttab(event)" id="swiper_prev" tabindex="0" role="button" aria-label="Previous slide" aria-disabled="false" style="display: block;"></div>
                                                        <div class="swiper-button-next swipenav" onclick="previousnexttab(event)" id="swiper_next" tabindex="0" role="button" aria-label="Next slide" aria-disabled="false" style="display: block;"></div>
                                                        <div class="md-stepper-horizontal col-8">
                                                            @php $status=0; @endphp
                                                            @if( $rows['progress']['gen'] == [])
                                                            <div class="md-step" value='1' name="tab_1" onclick="ticker(1)">

                                                                @else
                                                                <div class="md-step active" value='1' name="tab_1" onclick="ticker(1)">
                                                                    @php $status += 20; @endphp
                                                                    @endif
                                                                    <div class="md-step-circle tooltip_custom">1<span>General details</span></div>
                                                                    <div class="md-step-bar-left"></div>
                                                                    <div class="md-step-bar-right"></div>


                                                                </div>
                                                                @if( $rows['progress']['edu'] == [])
                                                                <div class="md-step " value='2' name="tab_2" onclick="ticker(2)">
                                                                    @else
                                                                    @php $status += 20; @endphp
                                                                    <div class="md-step active" value='2' name="tab_2" onclick="ticker(2)">
                                                                        @endif
                                                                        <div class="md-step-circle tooltip_custom">2<span>Education details</span></div>
                                                                        <div class="md-step-bar-left"></div>
                                                                        <div class="md-step-bar-right"></div>

                                                                    </div>
                                                                    @if( $rows['progress']['exp'] == [])
                                                                    <div class="md-step " value='3' name="tab_3" onclick="ticker(3)">
                                                                        @else
                                                                        @php $status += 20; @endphp
                                                                        <div class="md-step active" value='3' name="tab_3" onclick="ticker(3)">
                                                                            @endif
                                                                            <div class="md-step-circle tooltip_custom">3<span>NRU Work Experience</span></div>
                                                                            <div class="md-step-bar-left"></div>
                                                                            <div class="md-step-bar-right"></div>

                                                                        </div>

                                                                        @if( $rows['progress']['gt_process'] == [])
                                                                        <div class="md-step" value='4' name="tab_4" onclick="ticker(4)">
                                                                            @else
                                                                            @php $status += 20; @endphp
                                                                            <div class="md-step active" value='4' name="tab_4" onclick="ticker(4)">
                                                                                @endif
                                                                                <div class="md-step-circle tooltip_custom">4<span>Approval Process</span></div>
                                                                                <div class="md-step-bar-left"></div>
                                                                                <div class="md-step-bar-right"></div>

                                                                            </div>
                                                                            @if( $rows['progress']['localadaptaion_test'] == [])
                                                                            <div class="md-step " value='5' name="tab_5" onclick="ticker(5)">
                                                                                @else
                                                                                @php $status += 20; @endphp
                                                                                <div class="md-step active" value='5' name="tab_5" onclick="ticker(5)">
                                                                                    @endif
                                                                                    <div class="md-step-circle tooltip_custom">5<span>Local Adaptaion Test</span></div>
                                                                                    <div class="md-step-bar-left"></div>
                                                                                    <div class="md-step-bar-right"></div>

                                                                                </div>


                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="percentage">
                                                                        <h2>{{$status}}%</h2>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                    <div id="accordion" class="accordion mt-3 m-3">
                                                        <div class="card acc_border">
                                                            <div class="card-header" id="headingOne">
                                                                <h5 class="mb-0 acc-btn">
                                                                    <button class="btn" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                        Guidelines For Non-Uganda Resident
                                                                    </button>
                                                                </h5>
                                                            </div>
                                                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                                                <div class="card-body">
                                                                    <div class="row acc-drop" style="flex-direction: column; row-gap: 18px;">
                                                                        <div class="col d-flex gap_class p-3">
                                                                            <div class="rounded-circle circle">
                                                                                1
                                                                            </div>
                                                                            =>
                                                                            <span>First go to the Gereral Details menu under the Registration module and fill your General Detials to complete the first Process.</span>
                                                                        </div>
                                                                        <div class="col d-flex gap_class p-3 bg-muted">
                                                                            <div class="rounded-circle circle">
                                                                                2
                                                                            </div>
                                                                            =>
                                                                            <span>After the First Process, Go to the Education Details menu under the Registration module and fill your Academic Detials.</span>
                                                                        </div>
                                                                        <div class="col d-flex gap_class p-3">
                                                                            <div class="rounded-circle circle">
                                                                                3
                                                                            </div>
                                                                            =>
                                                                            <span>Then Go to the Work Experience menu under the Registration module to fill your Experience.</span>
                                                                        </div>
                                                                        <div class="col d-flex gap_class p-3 bg-muted">
                                                                            <div class="rounded-circle circle">
                                                                                4
                                                                            </div>
                                                                            =>
                                                                            <span>Then Wait for the Registrar to Validate your Application, We'll update the Process via System and Mail Notification. </span>
                                                                        </div>
                                                                        <div class="col d-flex gap_class p-3">
                                                                            <div class="rounded-circle circle">
                                                                                5
                                                                            </div>
                                                                            =>
                                                                            <span> You are now qualified to access the e-learning and utilise it to hone your valuation abilities after completing your registration successfully. Go to the Local Adaptation Test option in the e-learning module for that and finish it. </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <!-- Counselor/Supervisor/Registrar/Dashboard -->

                                                    @elseif ( $rows['users']['role_id'] == "30")
                                                    <div class="row card_buttons">
                                                        <div class="col-2">
                                                            <button class="btn btn-info card_count first_button" style="width: 150px;" value="count_gt" aria-expanded="true">
                                                                GT Process
                                                            </button>
                                                        </div>
                                                        @if ($rows['users']['role_id'] != "28" && $rows['users']['role_id'] != "29" && $rows['users']['role_id'] == "30")

                                                        <div class="col-2">
                                                            <button class="btn btn-info card_count first_button" style="width: 150px;" value="count_nru" aria-expanded="true">
                                                                NRU Process
                                                            </button>
                                                        </div>
                                                        @endif


                                                        <div class="d-flex justify-content-around overview_body mt-5" id="dashboard_click">
                                                            <div class="card noShadow w-25">
                                                                <div class="card-header badge2 warning text-bg-danger">

                                                                    <span>
                                                                        <h4>Pending Requests</h4>
                                                                    </span>

                                                                </div>
                                                                <div class="card-body d-flex flex-row justify-content-between align-items-center cardpad">
                                                                    <span class="overview_count d-flex">
                                                                        <div class="d-none">
                                                                            <h6 class="count_gt cus_card d_none" id="pending_dashboard"><a href="javascript:void(0)" id="gt_pending" onclick="overview(event)">{{$rows['pending_count_gt'][0]['count']}}</a></h6>
                                                                        </div>
                                                                        @if(isset($rows['pending_count_nru']))
                                                                        <div class="d-none">
                                                                            <h6 class="count_nru cus_card d_none"><a href="javascript:void(0)" id="pending_count_nru" onclick="overview(event)">{{$rows['pending_count_nru'][0]['count']}}</a></h6>

                                                                        </div>
                                                                        @endif

                                                                    </span>
                                                                    <img class="overview_img" src="{{asset('asset/image/pending.png')}}" alt="Course in Progress" width="40%">
                                                                </div>
                                                            </div>
                                                            <div class="card noShadow w-25">
                                                                <div class="card-header badge2 success text-bg-danger">
                                                                    <span>
                                                                        <h4>Approved</h4>
                                                                    </span>
                                                                </div>
                                                                <div class="card-body d-flex flex-row justify-content-between align-items-center cardpad">
                                                                    <span class="overview_count d-flex">
                                                                        <div class="d-none">
                                                                            <h6 class="count_gt cus_card d_none" id="pending_dashboard"><a href="javascript:void(0)" id="gt_approve" onclick="overview(event)">{{$rows['approved_count_gt'][0]['count']}}</a></h6>
                                                                        </div>
                                                                        @if(isset($rows['approved_count_nru']))
                                                                        <div class="d-none">
                                                                            <h6 class="count_nru cus_card d_none"><a href="javascript:void(0)" id="approved_count_nru" onclick="overview(event)">{{$rows['approved_count_nru'][0]['count']}}</a></h6>

                                                                        </div>
                                                                        @endif
                                                                    </span>


                                                                    <img class="overview_img" src="{{asset('asset/image/courseCompleted.png')}}" alt="Course Completed" width="40%">
                                                                </div>
                                                            </div>
                                                            <div class="card noShadow w-25">
                                                                <div class="card-header badge2 danger text-bg-warning">
                                                                    <span>
                                                                        <h4>Rejected</h4>
                                                                    </span>
                                                                </div>
                                                                <div class="card-body d-flex flex-row justify-content-between align-items-center cardpad">
                                                                    <span class="overview_count d-flex">
                                                                        <div class="d-none">
                                                                            <h6 class="count_gt cus_card d_none" id="pending_dashboard"><a href="javascript:void(0)" id="gt_reject" onclick="overview(event)">{{$rows['reject_count_gt'][0]['count']}}</a></h6>
                                                                        </div>
                                                                        @if(isset($rows['reject_count_nru']))
                                                                        <div class="d-none">
                                                                            <h6 class="count_nru cus_card d_none"><a href="javascript:void(0)" id="reject_count_nru" onclick="overview(event)">{{$rows['reject_count_nru'][0]['count']}}</a></h6>

                                                                        </div>
                                                                        @endif
                                                                    </span>


                                                                    <img class="overview_img" src="{{asset('asset/image/icons8-multiply.png')}}" alt="Watching Time" width="40%">
                                                                </div>
                                                            </div>
                                                        </div>



                                                        <div class="col-md-12">
                                                            <div id="accordion" class="overview">
                                                                <div class="card overview_class">
                                                                    <div class="card-header" id="headingOne" style="background-color:#fff;">
                                                                        <h5 class="mb-0">
                                                                            <button class="btn btn-primary" id="list_overview" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                                List overview
                                                                            </button>
                                                                        </h5>
                                                                    </div>
                                                                    <div class="card-body" style="box-shadow: none !Important;">


                                                                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                                                            <div class="card">
                                                                                <div class="card-body" style="box-shadow: none !Important;">
                                                                                    <div class="genral_class gt_reject d-none">
                                                                                        <table class="table table-bordered" id="align">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th>Sl. No.</th>
                                                                                                    <th>Name</th>
                                                                                                    <th>Country</th>
                                                                                                    <th>Status</th>

                                                                                                </tr>
                                                                                            </thead>

                                                                                            <tbody>

                                                                                                @foreach($rows['gt_rejected'] as $data)


                                                                                                <tr>
                                                                                                    <td>{{$loop->iteration}}</td>
                                                                                                    <td>{{$data['name']}}</td>
                                                                                                    <!-- <td>{{$data['interest']}}</td> -->
                                                                                                    <td>{{$data['country']}}</td>
                                                                                                    @if($data['approval_status']=="Approved")
                                                                                                    <td style="color:white;"><span class="badge2 success rounded-pill text-bg-success">Approved</span></td>

                                                                                                    @elseif($data['approval_status']=="Pending")
                                                                                                    <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending</span></td>

                                                                                                    @elseif($data['approval_status']=="Rejected")
                                                                                                    <td style="color:white;"><span class="badge2 danger rounded-pill text-bg-warning">Rejected</span></td>

                                                                                                    @endif





                                                                                                </tr>
                                                                                                <!-- for stake holders -->

                                                                                                @endforeach
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                    <div class="genral_class d-none gt_approve">
                                                                                        <table class="table table-bordered" id="align5">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th>Sl. No.</th>
                                                                                                    <th>Name</th>
                                                                                                    <th>Interest</th>
                                                                                                    <th>Country</th>
                                                                                                    <th>Status</th>


                                                                                                </tr>
                                                                                            </thead>

                                                                                            <tbody>

                                                                                                @foreach($rows['gt_approved'] as $data)

                                                                                                <div>
                                                                                                    <!-- for other users -->
                                                                                                </div>


                                                                                                <tr>
                                                                                                    <td>{{$loop->iteration}}</td>
                                                                                                    <td>{{$data['name']}}</td>
                                                                                                    <td>{{$data['interest']}}</td>
                                                                                                    <td>{{$data['country']}}</td>
                                                                                                    @if($data['approval_status']=="Approved")
                                                                                                    <td style="color:white;"><span class="badge2 success rounded-pill text-bg-success">Approved</span></td>

                                                                                                    @elseif($data['approval_status']=="Pending")
                                                                                                    <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending</span></td>

                                                                                                    @elseif($data['approval_status']=="Rejected")
                                                                                                    <td style="color:white;"><span class="badge2 danger rounded-pill text-bg-warning">Rejected</span></td>

                                                                                                    @endif


                                                                                                </tr>
                                                                                                <!-- for stake holders -->

                                                                                                @endforeach
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>


                                                                                    <div class="genral_class d-none gt_pending">
                                                                                        <table class="table table-bordered" id="align3">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th>Sl. No.</th>
                                                                                                    <th>Name</th>
                                                                                                    <th>Interest</th>
                                                                                                    <th>Country</th>
                                                                                                    <th>Status</th>
                                                                                                    <th>Action</th>


                                                                                                </tr>
                                                                                            </thead>

                                                                                            <tbody>

                                                                                                @foreach($rows['gt_pending'] as $data)

                                                                                                <div>
                                                                                                    <!-- for other users -->
                                                                                                </div>


                                                                                                <tr>
                                                                                                    <td>{{$loop->iteration}}</td>
                                                                                                    <td>{{$data['name']}}</td>
                                                                                                    <td>{{$data['interest']}}</td>
                                                                                                    <td>{{$data['country']}}</td>
                                                                                                    @if($data['approval_status']=="Approved")
                                                                                                    <td style="color:white;"><span class="badge2 success rounded-pill text-bg-success">Approved</span></td>

                                                                                                    @elseif($data['approval_status']=="Pending")
                                                                                                    <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending</span></td>

                                                                                                    @elseif($data['approval_status']=="Rejected")
                                                                                                    <td style="color:white;"><span class="badge2 danger rounded-pill text-bg-warning">Rejected</span></td>

                                                                                                    @endif

                                                                                                    <form action="{{route('approve')}}" method="GET">
                                                                                                        @csrf


                                                                                                        <td>
                                                                                                            <button type="submit" title="Approve or Allocate" class="btn btn-link"><img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30"></button>
                                                                                                        </td>
                                                                                                        <input type="hidden" name="gt_id" id="gt_id" value="{{$data['user_id']}}">
                                                                                                        <input type="hidden" name="approval_persons_id" id="approval_persons_id" value="{{$data['approval_persons_id']}}">
                                                                                                        <input type="hidden" name="user_id" id="user_id" value="">

                                                                                                    </form>




                                                                                                </tr>
                                                                                                <!-- for stake holders -->

                                                                                                @endforeach
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                    @if(isset($rows['nru_reject']))
                                                                                    <div class="genral_class d-none reject_count_nru">
                                                                                        <table class="table table-bordered" id="align">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th>Sl.No</th>
                                                                                                    <th>file Name</th>
                                                                                                    <th>Comments</th>
                                                                                                    <th>Status</th>

                                                                                                </tr>


                                                                                            </thead>


                                                                                            <tbody>


                                                                                                @foreach($rows['nru_reject'] as $data)

                                                                                                <tr>
                                                                                                    <td>{{$loop->iteration}}</td>
                                                                                                    <td>{{$data['file_name']}}</td>
                                                                                                    @if($data['comments']==null)
                                                                                                    <td>-</td>
                                                                                                    @else
                                                                                                    <td> <a type="button" style="font-size:15px;" class="btn btn-success btn-lg" title="Create" id="eligcb" data-toggle="modal" data-target="#Approve_nrv_comments">Comment</a></td>
                                                                                                    @endif

                                                                                                    @if($data['status']==0)
                                                                                                    <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending</span></td>
                                                                                                    @elseif($data['status']==1)
                                                                                                    <td style="color:white;"><span class="badge2 success rounded-pill text-bg-success">Approved</span></td>
                                                                                                    @elseif($data['status']==2)
                                                                                                    <td style="color:white;"><span class="badge2 danger rounded-pill text-bg-warning">Rejected</span></td>
                                                                                                    @endif


                                                                                                </tr>
                                                                                                @endforeach
                                                                                            </tbody>

                                                                                        </table>
                                                                                    </div>
                                                                                    @endif
                                                                                    @if(isset($rows['nru_approved']))
                                                                                    <div class="genral_class d-none approved_count_nru">
                                                                                        <table class="table table-bordered" id="align5">
                                                                                            <thead>

                                                                                                <tr>
                                                                                                    <th>Sl.No</th>
                                                                                                    <th>file Name</th>
                                                                                                    <th>Comments</th>
                                                                                                    <th>Status</th>

                                                                                                </tr>

                                                                                            </thead>
                                                                                            <tbody>
                                                                                                @foreach($rows['nru_approved'] as $data)

                                                                                                <tr>
                                                                                                    <td>{{$loop->iteration}}</td>
                                                                                                    <td>{{$data['file_name']}}</td>
                                                                                                    @if($data['comments']==null)
                                                                                                    <td>-</td>
                                                                                                    @else
                                                                                                    <td> <a type="button" style="font-size:15px;" class="btn btn-success btn-lg" title="Create" id="eligcb" data-toggle="modal" data-target="#Approve_nrv_comments">Comment</a></td>
                                                                                                    @endif

                                                                                                    @if($data['status']==0)
                                                                                                    <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending</span></td>
                                                                                                    @elseif($data['status']==1)
                                                                                                    <td style="color:white;"><span class="badge2 success rounded-pill text-bg-success">Approved</span></td>
                                                                                                    @elseif($data['status']==2)
                                                                                                    <td style="color:white;"><span class="badge2 danger rounded-pill text-bg-warning">Rejected</span></td>
                                                                                                    @endif





                                                                                                </tr>
                                                                                                @endforeach
                                                                                            </tbody>

                                                                                        </table>
                                                                                    </div>
                                                                                    @endif
                                                                                    @if(isset($rows['nru_pending']))
                                                                                    <div class="genral_class d-none pending_count_nru">
                                                                                        <table class="table table-bordered" id="align3">
                                                                                            <thead>

                                                                                                <tr>
                                                                                                    <th>Sl.No</th>
                                                                                                    <th>file Name</th>
                                                                                                    <th>Comments</th>
                                                                                                    <th>Status</th>
                                                                                                    <th>Action</th>


                                                                                                </tr>


                                                                                            </thead>
                                                                                            <tbody>
                                                                                                @foreach($rows['nru_pending'] as $data)

                                                                                                <tr>
                                                                                                    <td>{{$loop->iteration}}</td>
                                                                                                    <td>{{$data['file_name']}}</td>
                                                                                                    @if($data['comments']==null)
                                                                                                    <td>-</td>
                                                                                                    @else
                                                                                                    <td> <a type="button" style="font-size:15px;" class="btn btn-success btn-lg" title="Create" id="eligcb" data-toggle="modal" data-target="#Approve_nrv_comments">Comment</a></td>
                                                                                                    @endif

                                                                                                    @if($data['status']==0)
                                                                                                    <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending</span></td>
                                                                                                    @elseif($data['status']==1)
                                                                                                    <td style="color:white;"><span class="badge2 success rounded-pill text-bg-success">Approved</span></td>
                                                                                                    @elseif($data['status']==2)
                                                                                                    <td style="color:white;"><span class="badge2 danger rounded-pill text-bg-warning">Rejected</span></td>
                                                                                                    @endif

                                                                                                    <form action="" method="GET">
                                                                                                        @csrf

                                                                                                        <!-- <td><a class="btn btn-link" title="show" href="{{route('Registration.show','') }}" data-toggle="modal" data-target="#showeligeModal"><i class="fas fa-eye" style="color:blue"></i></a>
                                                                                                    <td>-->
                                                                                                        <!-- <button type="submit" title="Approve or Allocate" class="btn btn-link"><img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30"></button> -->
                                                                                                        @if($data['status']==0)
                                                                                                        <a type='submit' title="Approve" class="btn btn-link" href="{{route('approve_screen', $data['user_id'])}}"><img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30"></a>
                                                                                                        @endif
                                                                                                        @if($data['status']==1 || ($data['status']==2))
                                                                                                        <a class="btn btn-link" title="show" href="{{route('approve_screen', $data['user_id'])}}"><i class="fas fa-eye" style="color:green"></i></a>
                                                                                                        @endif
                                                                                                        </td>


                                                                                                    </form>



                                                                                                </tr>
                                                                                                @endforeach
                                                                                            </tbody>

                                                                                        </table>
                                                                                    </div>

                                                                                    @endif

                                                                                </div>


                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>




                                                        <!-- CGV (Chief Government Valuer) Dashboard -->
                                                        @elseif ($rows['users']['role_id'] == "23")

                                                        <div class="d-flex justify-content-around overview_body mt-5" id="dashboard_click">
                                                            <div class="card noShadow w-25">
                                                                <div class="card-header badge2 warning text-bg-danger">

                                                                    <span>
                                                                        <h4>Pending Requests</h4>
                                                                    </span>

                                                                </div>
                                                                <div class="card-body d-flex flex-row justify-content-between align-items-center cardpad">
                                                                    <span class="overview_count">
                                                                        <h6 id="pending_dashboard"><a href="javascript:void(0)" id="cgv_pending_count" onclick="overview(event)">{{ $rows['pending_countfirm'][0]['count'] }}</a></h6>
                                                                    </span>
                                                                    <img class="overview_img" src="{{asset('asset/image/pending.png')}}" alt="Course in Progress" width="40%">
                                                                </div>
                                                            </div>
                                                            <div class="card noShadow w-25">
                                                                <div class="card-header badge2 success text-bg-danger">
                                                                    <span>
                                                                        <h4>Approved</h4>
                                                                    </span>
                                                                </div>
                                                                <div class="card-body d-flex flex-row justify-content-between align-items-center cardpad">
                                                                    <span class="overview_count">
                                                                        <h6 id="approve_dashboard"><a href="javascript:void(0)" id="cgv_approve_count" onclick="overview(event)">{{$rows['approved_countfirm'][0]['count']}}</a></h6>
                                                                    </span>
                                                                    <img class="overview_img" src="{{asset('asset/image/courseCompleted.png')}}" alt="Course Completed" width="40%">
                                                                </div>
                                                            </div>
                                                            <div class="card noShadow w-25">
                                                                <div class="card-header badge2 danger text-bg-warning">
                                                                    <span>
                                                                        <h4>Rejected</h4>
                                                                    </span>
                                                                </div>
                                                                <div class="card-body d-flex flex-row justify-content-between align-items-center cardpad">
                                                                    <span class="overview_count">
                                                                        <h6 id="reject_dashboard"><a href="javascript:void(0)" id="cgv_reject_count" onclick="overview(event)">{{$rows['reject_countfirm'][0]['count']}}</a></h6>
                                                                    </span>
                                                                    <img class="overview_img" src="{{asset('asset/image/icons8-multiply.png')}}" alt="Watching Time" width="40%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div id="accordion" class="overview">
                                                                <div class="card overview_class">
                                                                    <div class="card-header" id="headingOne" style="background-color:#fff;">
                                                                        <h5 class="mb-0">
                                                                            <button class="btn btn-primary" id="list_overview" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                                List overview
                                                                            </button>
                                                                        </h5>
                                                                    </div>
                                                                    <div class="card-body" style="box-shadow: none !Important;">


                                                                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                                                            <div class="card">
                                                                                <div class="card-body" style="box-shadow: none !Important;">
                                                                                    <div class="genral_class cgv_approve_count d-none">
                                                                                        <table class="table table-bordered" id="align5">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th>Sl. No.</th>
                                                                                                    <th>Firm Name</th>
                                                                                                    <th>Description</th>
                                                                                                    <th>Requested On</th>
                                                                                                    <th>Status</th>

                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                @foreach($rows['cgv_approve_count'] as $key=>$data)
                                                                                                <tr>
                                                                                                    <td>{{$loop->iteration}}</td>
                                                                                                    <td>{{$data['firm_name']}}</td>
                                                                                                    <td>{{$data['description']}}</td>
                                                                                                    <td>{{$data['created_at']}}</td>
                                                                                                    @if($data['status']==0)
                                                                                                    <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending</span></td>
                                                                                                    @elseif($data['status']==1)
                                                                                                    <td style="color:white;"><span class="badge2 success rounded-pill text-bg-success">Approved</span></td>
                                                                                                    @else
                                                                                                    <td style="color:white;"><span class="badge2 danger rounded-pill text-bg-warning">Rejected</span></td>
                                                                                                    @endif
                                                                                                    <form action="{{route('firm_show')}}" method="GET">
                                                                                                        @csrf
                                                                                                        <input type="hidden" class="show" id="id" name="id" value="{{$data['id']}}">

                                                                                                    </form>
                                                                                                </tr>

                                                                                                @endforeach

                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>

                                                                                    <div class="genral_class cgv_pending_count d-none">
                                                                                        <table class="table table-bordered" id="align">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th>Sl. No.</th>
                                                                                                    <th>Firm Name</th>
                                                                                                    <th>Description</th>
                                                                                                    <th>Requested On</th>
                                                                                                    <th>Status</th>
                                                                                                    <th>Action</th>

                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                @foreach($rows['cgv_pending_count'] as $key=>$data)
                                                                                                <tr>
                                                                                                    <td>{{$loop->iteration}}</td>
                                                                                                    <td>{{$data['firm_name']}}</td>
                                                                                                    <td>{{$data['description']}}</td>
                                                                                                    <td>{{$data['created_at']}}</td>
                                                                                                    @if($data['status']==0)
                                                                                                    <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending</span></td>
                                                                                                    @elseif($data['status']==1)
                                                                                                    <td style="color:white;"><span class="badge2 success rounded-pill text-bg-success">Approved</span></td>
                                                                                                    @else
                                                                                                    <td style="color:white;"><span class="badge2 danger rounded-pill text-bg-warning">Rejected</span></td>
                                                                                                    @endif
                                                                                                    <form action="{{route('firm_show')}}" method="GET">
                                                                                                        @csrf
                                                                                                        <input type="hidden" class="show" id="id" name="id" value="{{$data['id']}}">
                                                                                                        <td>
                                                                                                            <button type="submit" title="Approve or Allocate" class="btn btn-link"><img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30"></button>
                                                                                                        </td>
                                                                                                    </form>
                                                                                                </tr>

                                                                                                @endforeach

                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>


                                                                                    <div class="genral_class cgv_reject_count d-none">
                                                                                        <table class="table table-bordered" id="align5">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th>Sl. No.</th>
                                                                                                    <th>Firm Name</th>
                                                                                                    <th>Description</th>
                                                                                                    <th>Requested On</th>
                                                                                                    <th>Status</th>

                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                @foreach($rows['cgv_reject_count'] as $key=>$data)
                                                                                                <tr>
                                                                                                    <td>{{$loop->iteration}}</td>
                                                                                                    <td>{{$data['firm_name']}}</td>
                                                                                                    <td>{{$data['description']}}</td>
                                                                                                    <td>{{$data['created_at']}}</td>
                                                                                                    @if($data['status']==0)
                                                                                                    <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending</span></td>
                                                                                                    @elseif($data['status']==1)
                                                                                                    <td style="color:white;"><span class="badge2 success rounded-pill text-bg-success">Approved</span></td>
                                                                                                    @else
                                                                                                    <td style="color:white;"><span class="badge2 danger rounded-pill text-bg-warning">Rejected</span></td>
                                                                                                    @endif
                                                                                                    <form action="{{route('firm_show')}}" method="GET">
                                                                                                        @csrf
                                                                                                        <input type="hidden" class="show" id="id" name="id" value="{{$data['id']}}">

                                                                                                    </form>
                                                                                                </tr>

                                                                                                @endforeach

                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>


                                                                                </div>




                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        @endif

                                                    </div>


                                                    <!-- Private Stakeholder and Government Stakeholder -->



                                                    @if ($rows['users']['role_id'] == "31" || $rows['users']['role_id'] == "32")

                                                    <div class="d-flex justify-content-around overview_body mt-5" id="dashboard_click">
                                                        <div class="card noShadow w-25">
                                                            <div class="card-header badge2 warning text-bg-danger">

                                                                <span>
                                                                    <h4>InProgress</h4>
                                                                </span>

                                                            </div>
                                                            <div class="card-body d-flex flex-row justify-content-between align-items-center cardpad">
                                                                <span class="overview_count">
                                                                    <h6 id="pending_dashboard"><a href="javascript:void(0)" id="inprogress_count" onclick="overview(event)">{{count($rows['progress']['inprogress_count'])}}</a></h6>
                                                                </span>
                                                                <img class="overview_img" src="{{asset('asset/image/arrows.png')}}" alt="Course in Progress" width="40%">
                                                            </div>
                                                        </div>
                                                        <div class="card noShadow w-25">
                                                            <div class="card-header badge2 success text-bg-danger">
                                                                <span>
                                                                    <h4>Completed</h4>
                                                                </span>
                                                            </div>
                                                            <div class="card-body d-flex flex-row justify-content-between align-items-center cardpad">
                                                                <span class="overview_count">
                                                                    <h6 id="approve_dashboard"><a href="javascript:void(0)" id="complete_count" onclick="overview(event)">{{count($rows['progress']['complete_count'])}}</a></h6>
                                                                </span>
                                                                <img class="overview_img" src="{{asset('asset/image/courseCompleted.png')}}" alt="Course Completed" width="40%">
                                                            </div>
                                                        </div>
                                                        <div class="card noShadow w-25">
                                                            <div class="card-header badge2 danger text-bg-warning">
                                                                <span>
                                                                    <h4>Rejected</h4>
                                                                </span>
                                                            </div>
                                                            <div class="card-body d-flex flex-row justify-content-between align-items-center cardpad">
                                                                <span class="overview_count">
                                                                    <h6 id="reject_dashboard"><a href="javascript:void(0)" id="pending_count" onclick="overview(event)">{{count($rows['progress']['resend_count'])}}</a></h6>
                                                                </span>
                                                                <img class="overview_img" src="{{asset('asset/image/icons8-multiply.png')}}" alt="Watching Time" width="40%">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div id="accordion" class="overview">
                                                            <div class="card overview_class">
                                                                <div class="card-header" id="headingOne" style="background-color:#fff;">
                                                                    <h5 class="mb-0">
                                                                        <button class="btn btn-primary" data-toggle="collapse" id="list_overview" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                            List overview
                                                                        </button>
                                                                    </h5>
                                                                </div>
                                                                <div class="card-body" style="box-shadow: none !Important;">


                                                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                                                        <div class="card">
                                                                            <div class="card-body" style="box-shadow: none !Important;">
                                                                                <div class="genral_class complete_count d-none">
                                                                                    <table class="table table-bordered" id="align">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>Sl. No.</th>
                                                                                                <th>Task Name</th>
                                                                                                <th>Valuer Name/Firm Name</th>
                                                                                                <th>Status</th>
                                                                                                <th>Action</th>


                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            @php $last_task="";$iteration=1; @endphp

                                                                                            @foreach($rows['progress']['complete_count'] as $data)
                                                                                            @if($data['task_name'] !=$last_task)

                                                                                            <tr>
                                                                                                <td>{{$iteration}}</td>
                                                                                                <td>{{$data['task_name']}} </td>
                                                                                                <td>{{$data['name']}}</td>
                                                                                                @if($data['status'] == 0)
                                                                                                <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending</span></td>

                                                                                                @elseif($data['status'] == 1)
                                                                                                <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">In Progress</span></td>

                                                                                                @elseif($data['status'] == 3 && $data['cgv_approval']==0)
                                                                                                <td style="color:white;"><span class="badge2 success rounded-pill text-bg-danger">Approved</span></td>
                                                                                                @elseif($data['status'] == 3 && $data['cgv_approval']==1)
                                                                                                <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending(CGV )</span></td>

                                                                                                @elseif($data['status'] == 3 && $data['cgv_approval']==2)
                                                                                                <td style="color:white;"><span class="badge2 success rounded-pill text-bg-danger">Completed</span></td>

                                                                                                @elseif($data['status'] == 4)
                                                                                                <td style="color:white;"><span class="badge2 danger rounded-pill text-bg-warning">Rejected</span></td>
                                                                                                @else
                                                                                                <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">In Review</span></td>



                                                                                                @endif
                                                                                                <td>


                                                                                                    @if($data['status'] == 0 || $data['status'] == 1 )

                                                                                                    <a title="Show" href="{{route('valuer_show', $data['id'])}}" class="btn btn-link"><i class="fas fa-eye" style="color:green"></i></a>

                                                                                                    @endif


                                                                                                    @if($data['status'] == 2 && $data['type'] == 1)

                                                                                                    <a title="Show" href="{{route('valuer_show', $data['id'])}}" class="btn btn-link"><i class="fas fa-eye" style="color:green"></i></a>
                                                                                                    @if($rows['users']['role_id'] == 23 ||$rows['users']['role_id'] == 32||$rows['users']['role_id'] == 31)
                                                                                                    <a type="submit" href="{{route('valuer_show', $data['id'])}}" title="Approve or Allocate" class="btn btn-link"><img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30"></a>

                                                                                                    @endif
                                                                                                    @endif

                                                                                                    @if($data['status'] == 2 && $data['type'] == 2 && $data['cgv_approval']!=2)
                                                                                                    <a title="Show" href="{{route('valuer_show', $data['id'])}}" class="btn btn-link"><i class="fas fa-eye" style="color:green"></i></a>
                                                                                                    @if($rows['users']['role_id'] == 23 && $data['status']==5 ||$rows['users']['role_id'] == 32 && $data['status']==5||$rows['users']['role_id'] == 31 && $data['status']==5)
                                                                                                    <a type="submit" href="{{route('valuer_show', $data['id'])}}" title="Approve or Allocate" class="btn btn-link"><img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30"></a>

                                                                                                    @endif
                                                                                                    @endif
                                                                                                    @if($data['status'] == 2 && $data['type'] == 2 && $data['cgv_approval']==2)

                                                                                                    <a title="Show" href="{{route('valuer_show', $data['id'])}}" class="btn btn-link"><i class="fas fa-eye" style="color:green"></i></a>
                                                                                                    @if($rows['users']['role_id'] == 23 && $data['stakeholder_comment']==null||$rows['users']['role_id'] == 32 && $data['stakeholder_comment']==null||$rows['users']['role_id'] == 31 &&$data['stakeholder_comment']==null)
                                                                                                    <a href="{{route('valuer_show', $data['id'])}}" class="btn btn-primary" style="margin-inline:5px;background-color:cornsilk; border-color:transparent !important;color:#fff">
                                                                                                        <img src="{{asset('assets/images/volume-svgrepo-com.svg')}}" alt="" width="20" height="30">
                                                                                                    </a>

                                                                                                    @endif
                                                                                                    @endif


                                                                                                    <!-- <button type="submit" title="Approve or Allocate" class="btn btn-link"><img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30"></button> -->
                                                                                                    @if($data['status'] == 3 && $data['stakeholder_comment'] ==null && $data['cgv_approval'] ==0)
                                                                                                    <a href="{{route('valuer_show', $data['id'])}}" class="btn btn-primary" style="margin-inline:5px;background-color:cornsilk; border-color:transparent !important;color:#fff">
                                                                                                        <img src="{{asset('assets/images/volume-svgrepo-com.svg')}}" alt="" width="20" height="30">
                                                                                                    </a>
                                                                                                    @elseif($data['status'] == 3 && $data['stakeholder_comment'] ==null && $data['cgv_approval'] ==1)
                                                                                                    <a title="Show" href="{{route('valuer_show', $data['id'])}}" class="btn btn-link"><i class="fas fa-eye" style="color:green"></i></a>
                                                                                                    @elseif($data['status'] == 3 && $data['stakeholder_comment'] ==null && $data['cgv_approval'] ==2)
                                                                                                    <a title="Show" href="{{route('valuer_show', $data['id'])}}" class="btn btn-link"><i class="fas fa-eye" style="color:green"></i></a>
                                                                                                    <a href="{{route('valuer_show', $data['id'])}}" class="btn btn-primary" style="margin-inline:5px;background-color:cornsilk; border-color:transparent !important;color:#fff">
                                                                                                        <img src="{{asset('assets/images/volume-svgrepo-com.svg')}}" alt="" width="20" height="30">
                                                                                                    </a>
                                                                                                    @elseif($data['status'] == 3 && $data['stakeholder_comment'] !=null)
                                                                                                    <a title="Show" href="{{route('valuer_show', $data['id'])}}" class="btn btn-link"><i class="fas fa-eye" style="color:green"></i></a>
                                                                                                    @elseif($data['status'] == 4 && $data['type']==1)
                                                                                                    <a type="btn" title="Re-send" href="{{route('reject_edit', $data['id'])}}" class="btn btn-warning">Re-send</a>
                                                                                                    <!-- <button>Re-send</button> -->
                                                                                                    @elseif($data['status'] == 4 && $data['type']==2)
                                                                                                    <a type="btn" title="Re-send" href="{{route('firmreject_edit', $data['id'])}}" class="btn btn-warning">Re-send</a>
                                                                                                    <!-- <button>Re-send</button> -->
                                                                                                    @endif
                                                                                                    @if($data['status'] == 5 )
                                                                                                    <a href="{{ route('valuer_show', $data['id'])}}" class="btn" style="margin-inline:5px;background-color:cornsilk; border-color:transparent !important;color:#fff">
                                                                                                        <img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30">
                                                                                                    </a>
                                                                                                    @endif
                                                                                                </td>



                                                                                            </tr>
                                                                                            @php $last_task=$data['task_name'];$iteration=++$iteration @endphp
                                                                                            @endif
                                                                                            @endforeach


                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>

                                                                                <div class="genral_class inprogress_count d-none">
                                                                                    <table class="table table-bordered" id="align">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>Sl. No.</th>
                                                                                                <th>Task Name</th>
                                                                                                <th>Valuer Name/Firm Name</th>
                                                                                                <th>Status</th>
                                                                                                <th>Action</th>


                                                                                            </tr>
                                                                                        </thead>

                                                                                        <tbody>
                                                                                            @php $last_task="";$iteration=1; @endphp

                                                                                            @foreach($rows['progress']['inprogress_count'] as $data)
                                                                                            @if($data['task_name'] !=$last_task)

                                                                                            <tr>
                                                                                                <td>{{$iteration}}</td>
                                                                                                <td>{{$data['task_name']}} </td>
                                                                                                <td>{{$data['name']}}</td>
                                                                                                @if($data['status'] == 0)
                                                                                                <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending</span></td>

                                                                                                @elseif($data['status'] == 1)
                                                                                                <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">In Progress</span></td>

                                                                                                @elseif($data['status'] == 3 && $data['cgv_approval']==0)
                                                                                                <td style="color:white;"><span class="badge2 success rounded-pill text-bg-danger">Approved</span></td>
                                                                                                @elseif($data['status'] == 3 && $data['cgv_approval']==1)
                                                                                                <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending(CGV )</span></td>

                                                                                                @elseif($data['status'] == 3 && $data['cgv_approval']==2)
                                                                                                <td style="color:white;"><span class="badge2 success rounded-pill text-bg-danger">Completed</span></td>

                                                                                                @elseif($data['status'] == 4)
                                                                                                <td style="color:white;"><span class="badge2 danger rounded-pill text-bg-warning">Rejected</span></td>
                                                                                                @else
                                                                                                <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">In Review</span></td>



                                                                                                @endif
                                                                                                <td>


                                                                                                    @if($data['status'] == 0 || $data['status'] == 1 )

                                                                                                    <a title="Show" href="{{route('valuer_show', $data['id'])}}" class="btn btn-link"><i class="fas fa-eye" style="color:green"></i></a>

                                                                                                    @endif


                                                                                                    @if($data['status'] == 2 && $data['type'] == 1)

                                                                                                    <a title="Show" href="{{route('valuer_show', $data['id'])}}" class="btn btn-link"><i class="fas fa-eye" style="color:green"></i></a>
                                                                                                    @if($rows['users']['role_id'] == 23 ||$rows['users']['role_id'] == 32||$rows['users']['role_id'] == 31)
                                                                                                    <a type="submit" href="{{route('valuer_show', $data['id'])}}" title="Approve or Allocate" class="btn btn-link"><img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30"></a>

                                                                                                    @endif
                                                                                                    @endif

                                                                                                    @if($data['status'] == 2 && $data['type'] == 2 && $data['cgv_approval']!=2)
                                                                                                    <a title="Show" href="{{route('valuer_show', $data['id'])}}" class="btn btn-link"><i class="fas fa-eye" style="color:green"></i></a>
                                                                                                    @if($rows['users']['role_id'] == 23 && $data['status']==5 ||$rows['users']['role_id'] == 32 && $data['status']==5||$rows['users']['role_id'] == 31 && $data['status']==5)
                                                                                                    <a type="submit" href="{{route('valuer_show', $data['id'])}}" title="Approve or Allocate" class="btn btn-link"><img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30"></a>

                                                                                                    @endif
                                                                                                    @endif
                                                                                                    @if($data['status'] == 2 && $data['type'] == 2 && $data['cgv_approval']==2)

                                                                                                    <a title="Show" href="{{route('valuer_show', $data['id'])}}" class="btn btn-link"><i class="fas fa-eye" style="color:green"></i></a>
                                                                                                    @if($rows['users']['role_id'] == 23 && $data['stakeholder_comment']==null||$rows['users']['role_id'] == 32 && $data['stakeholder_comment']==null||$rows['users']['role_id'] == 31 &&$data['stakeholder_comment']==null)
                                                                                                    <a href="{{route('valuer_show', $data['id'])}}" class="btn btn-primary" style="margin-inline:5px;background-color:cornsilk; border-color:transparent !important;color:#fff">
                                                                                                        <img src="{{asset('assets/images/volume-svgrepo-com.svg')}}" alt="" width="20" height="30">
                                                                                                    </a>

                                                                                                    @endif
                                                                                                    @endif


                                                                                                    <!-- <button type="submit" title="Approve or Allocate" class="btn btn-link"><img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30"></button> -->
                                                                                                    @if($data['status'] == 3 && $data['stakeholder_comment'] ==null && $data['cgv_approval'] ==0)
                                                                                                    <a href="{{route('valuer_show', $data['id'])}}" class="btn btn-primary" style="margin-inline:5px;background-color:cornsilk; border-color:transparent !important;color:#fff">
                                                                                                        <img src="{{asset('assets/images/volume-svgrepo-com.svg')}}" alt="" width="20" height="30">
                                                                                                    </a>
                                                                                                    @elseif($data['status'] == 3 && $data['stakeholder_comment'] ==null && $data['cgv_approval'] ==1)
                                                                                                    <a title="Show" href="{{route('valuer_show', $data['id'])}}" class="btn btn-link"><i class="fas fa-eye" style="color:green"></i></a>
                                                                                                    @elseif($data['status'] == 3 && $data['stakeholder_comment'] ==null && $data['cgv_approval'] ==2)
                                                                                                    <a title="Show" href="{{route('valuer_show', $data['id'])}}" class="btn btn-link"><i class="fas fa-eye" style="color:green"></i></a>
                                                                                                    <a href="{{route('valuer_show', $data['id'])}}" class="btn btn-primary" style="margin-inline:5px;background-color:cornsilk; border-color:transparent !important;color:#fff">
                                                                                                        <img src="{{asset('assets/images/volume-svgrepo-com.svg')}}" alt="" width="20" height="30">
                                                                                                    </a>
                                                                                                    @elseif($data['status'] == 3 && $data['stakeholder_comment'] !=null)
                                                                                                    <a title="Show" href="{{route('valuer_show', $data['id'])}}" class="btn btn-link"><i class="fas fa-eye" style="color:green"></i></a>
                                                                                                    @elseif($data['status'] == 4 && $data['type']==1)
                                                                                                    <a type="btn" title="Re-send" href="{{route('reject_edit', $data['id'])}}" class="btn btn-warning">Re-send</a>
                                                                                                    <!-- <button>Re-send</button> -->
                                                                                                    @elseif($data['status'] == 4 && $data['type']==2)
                                                                                                    <a type="btn" title="Re-send" href="{{route('firmreject_edit', $data['id'])}}" class="btn btn-warning">Re-send</a>
                                                                                                    <!-- <button>Re-send</button> -->
                                                                                                    @endif
                                                                                                    @if($data['status'] == 5 )
                                                                                                    <a href="{{ route('valuer_show', $data['id'])}}" class="btn" style="margin-inline:5px;background-color:cornsilk; border-color:transparent !important;color:#fff">
                                                                                                        <img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30">
                                                                                                    </a>
                                                                                                    @endif
                                                                                                </td>



                                                                                            </tr>
                                                                                            @php $last_task=$data['task_name'];$iteration=++$iteration @endphp
                                                                                            @endif
                                                                                            @endforeach


                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>


                                                                                <div class="genral_class pending_count d-none">
                                                                                    <table class="table table-bordered" id="align">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>Sl. No.</th>
                                                                                                <th>Task Name</th>
                                                                                                <th>Valuer Name/Firm Name</th>
                                                                                                <th>Status</th>
                                                                                                <th>Action</th>


                                                                                            </tr>
                                                                                        </thead>

                                                                                        <tbody>
                                                                                            @php $last_task="";$iteration=1; @endphp

                                                                                            @foreach($rows['progress']['resend_count'] as $data)
                                                                                            @if($data['task_name'] !=$last_task)

                                                                                            <tr>
                                                                                                <td>{{$iteration}}</td>
                                                                                                <td>{{$data['task_name']}} </td>
                                                                                                <td>{{$data['name']}}</td>
                                                                                                @if($data['status'] == 0)
                                                                                                <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending</span></td>

                                                                                                @elseif($data['status'] == 1)
                                                                                                <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">In Progress</span></td>

                                                                                                @elseif($data['status'] == 3 && $data['cgv_approval']==0)
                                                                                                <td style="color:white;"><span class="badge2 success rounded-pill text-bg-danger">Approved</span></td>
                                                                                                @elseif($data['status'] == 3 && $data['cgv_approval']==1)
                                                                                                <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending(CGV )</span></td>

                                                                                                @elseif($data['status'] == 3 && $data['cgv_approval']==2)
                                                                                                <td style="color:white;"><span class="badge2 success rounded-pill text-bg-danger">Completed</span></td>

                                                                                                @elseif($data['status'] == 4)
                                                                                                <td style="color:white;"><span class="badge2 danger rounded-pill text-bg-warning">Rejected</span></td>
                                                                                                @else
                                                                                                <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">In Review</span></td>



                                                                                                @endif
                                                                                                <td>


                                                                                                    @if($data['status'] == 0 || $data['status'] == 1 )

                                                                                                    <a title="Show" href="{{route('valuer_show', $data['id'])}}" class="btn btn-link"><i class="fas fa-eye" style="color:green"></i></a>

                                                                                                    @endif


                                                                                                    @if($data['status'] == 2 && $data['type'] == 1)

                                                                                                    <a title="Show" href="{{route('valuer_show', $data['id'])}}" class="btn btn-link"><i class="fas fa-eye" style="color:green"></i></a>
                                                                                                    @if($rows['users']['role_id'] == 23 ||$rows['users']['role_id'] == 32||$rows['users']['role_id'] == 31)
                                                                                                    <a type="submit" href="{{route('valuer_show', $data['id'])}}" title="Approve or Allocate" class="btn btn-link"><img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30"></a>

                                                                                                    @endif
                                                                                                    @endif

                                                                                                    @if($data['status'] == 2 && $data['type'] == 2 && $data['cgv_approval']!=2)
                                                                                                    <a title="Show" href="{{route('valuer_show', $data['id'])}}" class="btn btn-link"><i class="fas fa-eye" style="color:green"></i></a>
                                                                                                    @if($rows['users']['role_id'] == 23 && $data['status']==5 ||$rows['users']['role_id'] == 32 && $data['status']==5||$rows['users']['role_id'] == 31 && $data['status']==5)
                                                                                                    <a type="submit" href="{{route('valuer_show', $data['id'])}}" title="Approve or Allocate" class="btn btn-link"><img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30"></a>

                                                                                                    @endif
                                                                                                    @endif
                                                                                                    @if($data['status'] == 2 && $data['type'] == 2 && $data['cgv_approval']==2)

                                                                                                    <a title="Show" href="{{route('valuer_show', $data['id'])}}" class="btn btn-link"><i class="fas fa-eye" style="color:green"></i></a>
                                                                                                    @if($rows['users']['role_id'] == 23 && $data['stakeholder_comment']==null||$rows['users']['role_id'] == 32 && $data['stakeholder_comment']==null||$rows['users']['role_id'] == 31 &&$data['stakeholder_comment']==null)
                                                                                                    <a href="{{route('valuer_show', $data['id'])}}" class="btn btn-primary" style="margin-inline:5px;background-color:cornsilk; border-color:transparent !important;color:#fff">
                                                                                                        <img src="{{asset('assets/images/volume-svgrepo-com.svg')}}" alt="" width="20" height="30">
                                                                                                    </a>

                                                                                                    @endif
                                                                                                    @endif


                                                                                                    <!-- <button type="submit" title="Approve or Allocate" class="btn btn-link"><img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30"></button> -->
                                                                                                    @if($data['status'] == 3 && $data['stakeholder_comment'] ==null && $data['cgv_approval'] ==0)
                                                                                                    <a href="{{route('valuer_show', $data['id'])}}" class="btn btn-primary" style="margin-inline:5px;background-color:cornsilk; border-color:transparent !important;color:#fff">
                                                                                                        <img src="{{asset('assets/images/volume-svgrepo-com.svg')}}" alt="" width="20" height="30">
                                                                                                    </a>
                                                                                                    @elseif($data['status'] == 3 && $data['stakeholder_comment'] ==null && $data['cgv_approval'] ==1)
                                                                                                    <a title="Show" href="{{route('valuer_show', $data['id'])}}" class="btn btn-link"><i class="fas fa-eye" style="color:green"></i></a>
                                                                                                    @elseif($data['status'] == 3 && $data['stakeholder_comment'] ==null && $data['cgv_approval'] ==2)
                                                                                                    <a title="Show" href="{{route('valuer_show', $data['id'])}}" class="btn btn-link"><i class="fas fa-eye" style="color:green"></i></a>
                                                                                                    <a href="{{route('valuer_show', $data['id'])}}" class="btn btn-primary" style="margin-inline:5px;background-color:cornsilk; border-color:transparent !important;color:#fff">
                                                                                                        <img src="{{asset('assets/images/volume-svgrepo-com.svg')}}" alt="" width="20" height="30">
                                                                                                    </a>
                                                                                                    @elseif($data['status'] == 3 && $data['stakeholder_comment'] !=null)
                                                                                                    <a title="Show" href="{{route('valuer_show', $data['id'])}}" class="btn btn-link"><i class="fas fa-eye" style="color:green"></i></a>
                                                                                                    @elseif($data['status'] == 4 && $data['type']==1)
                                                                                                    <a type="btn" title="Re-send" href="{{route('reject_edit', $data['id'])}}" class="btn btn-warning">Re-send</a>
                                                                                                    <!-- <button>Re-send</button> -->
                                                                                                    @elseif($data['status'] == 4 && $data['type']==2)
                                                                                                    <a type="btn" title="Re-send" href="{{route('firmreject_edit', $data['id'])}}" class="btn btn-warning">Re-send</a>
                                                                                                    <!-- <button>Re-send</button> -->
                                                                                                    @endif
                                                                                                    @if($data['status'] == 5 )
                                                                                                    <a href="{{ route('valuer_show', $data['id'])}}" class="btn" style="margin-inline:5px;background-color:cornsilk; border-color:transparent !important;color:#fff">
                                                                                                        <img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30">
                                                                                                    </a>
                                                                                                    @endif
                                                                                                </td>



                                                                                            </tr>
                                                                                            @php $last_task=$data['task_name'];$iteration=++$iteration @endphp
                                                                                            @endif
                                                                                            @endforeach


                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>

                                                                            </div>


                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    @endif



                                                    @if ($rows['users']['role_id'] == "33" || $rows['users']['role_id'] == "37")

                                                    <div class="d-flex justify-content-around overview_body mt-5" id="dashboard_click">
                                                        <div class="card noShadow w-25">
                                                            <div class="card-header badge2 warning text-bg-danger">

                                                                <span>
                                                                    <h4>InProgress</h4>
                                                                </span>

                                                            </div>
                                                            <div class="card-body d-flex flex-row justify-content-between align-items-center cardpad">
                                                                <span class="overview_count">
                                                                    <h6 id="pending_dashboard"><a href="javascript:void(0)" onclick="overview(event)"></a>0</h6>
                                                                </span>
                                                                <img class="overview_img" src="{{asset('asset/image/arrows.png')}}" alt="Course in Progress" width="40%">
                                                            </div>
                                                        </div>
                                                        <div class="card noShadow w-25">
                                                            <div class="card-header badge2 success text-bg-danger">
                                                                <span>
                                                                    <h4>Completed</h4>
                                                                </span>
                                                            </div>
                                                            <div class="card-body d-flex flex-row justify-content-between align-items-center cardpad">
                                                                <span class="overview_count">
                                                                    <h6 id="approve_dashboard"><a href="javascript:void(0)" onclick="overview(event)"></a>0</h6>
                                                                </span>
                                                                <img class="overview_img" src="{{asset('asset/image/courseCompleted.png')}}" alt="Course Completed" width="40%">
                                                            </div>
                                                        </div>
                                                        <div class="card noShadow w-25">
                                                            <div class="card-header badge2 danger text-bg-warning">
                                                                <span>
                                                                    <h4>Rejected</h4>
                                                                </span>
                                                            </div>
                                                            <div class="card-body d-flex flex-row justify-content-between align-items-center cardpad">
                                                                <span class="overview_count">
                                                                    <h6 id="reject_dashboard"><a href="javascript:void(0)" onclick="overview(event)"></a>0</h6>
                                                                </span>
                                                                <img class="overview_img" src="{{asset('asset/image/icons8-multiply.png')}}" alt="Watching Time" width="40%">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div id="accordion" class="overview">
                                                            <div class="card overview_class">
                                                                <div class="card-header" id="headingOne" style="background-color:#fff;">
                                                                    <h5 class="mb-0">
                                                                        <button class="btn btn-primary" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                            List overview
                                                                        </button>
                                                                    </h5>
                                                                </div>
                                                                <div class="card-body" style="box-shadow: none !Important;">


                                                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                                                        <div class="card">
                                                                            <div class="card-body" style="box-shadow: none !Important;">
                                                                                <table class="table table-bordered" id="align">
                                                                                    <thead>
                                                                                        <tr>

                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>


                                                                                    </tbody>
                                                                                </table>

                                                                            </div>


                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    @endif
                                                    @if ($rows['users']['role_id'] == "34" )
                                                    <!-- data -->
                                                    <div class="row d-flex justify-content-between align-items-center">

                                                        <div class="col-4">
                                                            <div class="card">
                                                                <div class="card-header p-0 ml-2">
                                                                    Licence Details
                                                                </div>
                                                                @php $licenseNumber = !empty($rows['license'][0]['license_number']) ? ($rows['license'][0]['license_number'] .' - '. $rows['license'][0]['valuer_type']) : 'No data found'; @endphp
                                                                <div class="card-body p-2">
                                                                    <h6 class="mt-2">
                                                                        {{ $licenseNumber }}
                                                                    </h6>
                                                                    @if (!empty($rows['license'][0]['renewal_date']))
                                                                    <small class="d-flex ml-2">Expiry Date:{{$rows['license'][0]['renewal_date']}} </small>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="card">
                                                                <div class="card-header p-0 ml-2">
                                                                    Firm Details
                                                                </div>
                                                                @php $firm_name = !empty($rows['firm_count'][0]['firm_name']) ? $rows['firm_count'][0]['firm_name'] : 'No data found'; @endphp

                                                                <div class="card-body p-2 card1">
                                                                    <h6 class="card2">
                                                                        {{ $firm_name }}
                                                                    </h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row card_buttons">
                                                        <div class="col-2">
                                                            <button class="btn btn-info card_count first_button" style="width: 150px;" value="count_gt" aria-expanded="true" onclick="displayOverviewCount()">
                                                                GT Process
                                                            </button>
                                                        </div>

                                                        <div class="col-2">
                                                            <button class="btn btn-info card_count first_button" style="width: 160px;" value="count_nru" aria-expanded="true" onclick="toggleInstructionCount()">
                                                                Instruction Process
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex justify-content-around overview_body mt-5" id="dashboard_click">
                                                        <div class="card noShadow w-25">
                                                            <div class="card-header badge2 danger text-bg-warning">
                                                                <span>
                                                                    <h4>Pending</h4>
                                                                </span>
                                                            </div>

                                                            <div class="card-body d-flex flex-row justify-content-between align-items-center cardpad">
                                                                <span class="overview_count">
                                                                    <h6 class="reject_dashboard" id="pending_professional"><a href="javascript:void(0)" id="professional_pending"></a>{{$gt_process['pending']}}</h6>
                                                                </span>
                                                                <span class="instruction_count" style="display:none">
                                                                    <h6 class="reject_dashboard" id="pending_professional"><a href="javascript:void(0)" id="professional_pending"></a>{{$instruction_professional['pending']}}</h6>
                                                                </span>
                                                                <img class="overview_img" src="{{asset('asset/image/pending.png')}}" alt="Course in Progress" width="40%">
                                                            </div>
                                                        </div>
                                                        <div class="card noShadow w-25">
                                                            <div class="card-header badge2 warning text-bg-danger">
                                                                <span>
                                                                    <h4>InProgress</h4>
                                                                </span>

                                                            </div>
                                                            <div class="card-body d-flex flex-row justify-content-between align-items-center cardpad">
                                                                <span class="overview_count_inprogress">
                                                                    <h6 class="inprogress_dashboard" id="inprogress_professional"><a href="javascript:void(0)" id="professional_inprogress">0</a></h6>
                                                                </span>
                                                                <span class="instruction_count_inprogress" style="display:none">
                                                                    <h6 class="inprogress_dashboard" id="inprogress_professional"><a href="javascript:void(0)" id="professional_inprogress">{{$instruction_professional['inprogress']}}</a></h6>
                                                                </span>
                                                                <img class="overview_img" src="{{asset('asset/image/arrows.png')}}" alt="Course in Progress" width="40%">

                                                            </div>
                                                        </div>
                                                        <div class="card noShadow w-25">
                                                            <div class="card-header badge2 success text-bg-danger">
                                                                <span>
                                                                    <h4>Completed</h4>
                                                                </span>
                                                            </div>
                                                            <div class="card-body d-flex flex-row justify-content-between align-items-center cardpad">
                                                                <span class="overview_count_approved">
                                                                    <h6 class="approve_dashboard" id="approved_professional"><a href="javascript:void(0)" id="professional_approved">0</a></h6>
                                                                </span>
                                                                <span class="instruction_count_approved" style="display:none">
                                                                    <h6 class="approve_dashboard" id="approved_professional"><a href="javascript:void(0)" id="professional_approved">{{$instruction_professional['approved']}}</a></h6>
                                                                </span>
                                                                <img class="overview_img" src="{{asset('asset/image/courseCompleted.png')}}" alt="Course Completed" width="40%">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 d-none">
                                                        <div id="accordion" class="overview">
                                                            <div class="card overview_class">
                                                                <div class="card-header" id="headingOne" style="background-color:#fff;">
                                                                    <h5 class="mb-0">
                                                                        <button class="btn btn-primary" id="list_overview" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                            List overview
                                                                        </button>
                                                                    </h5>
                                                                </div>
                                                                <div class="card-body" style="box-shadow: none !Important;">


                                                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                                                        <div class="card">
                                                                            <div class="card-body" style="box-shadow: none !Important;">
                                                                                <div class="genral_class professional_pending d-none">
                                                                                    <table class="table table-striped" id="align">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>Sl. No.</th>
                                                                                                <th>Task Name</th>
                                                                                                <th>Description</th>
                                                                                                <th>Status</th>
                                                                                                <th>Action</th>
                                                                                            </tr>
                                                                                        </thead>

                                                                                        <tbody>

                                                                                            @foreach($rows['pending_count_professional'] as $data)
                                                                                            <tr>
                                                                                                <td>{{$loop->iteration}}</td>
                                                                                                <td>{{$data['task_name']}}</td>
                                                                                                <td>{{$data['inst_description']}}</td>
                                                                                                @if($data['status'] == 0)
                                                                                                <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending</span></td>
                                                                                                @elseif($data['status'] == 1)
                                                                                                <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">In Progress</span></td>
                                                                                                @elseif($data['status'] == 2)
                                                                                                <td style="color:white;"><span class="badge2 success rounded-pill text-bg-danger">Submitted</span></td>
                                                                                                @else
                                                                                                <td style="color:white;"><span class="badge2 success rounded-pill text-bg-danger">Completed</span></td>

                                                                                                @endif
                                                                                                <!-- 0 for pending 1  -->
                                                                                                @if($data['status'] == 0)
                                                                                                <td>

                                                                                                    <a type="button" href="{{ route('initiation.create_data', $data['stakeholder_id']) }}" title="Approve" class="btn btn-success" style="text-decoration:none; color:white">Accept/Reject</a>
                                                                                                </td>
                                                                                                <!-- for valuer while stakehloder giving task -->
                                                                                                @elseif($data['status'] == 1 && $data['type'] == 1 || $data['status'] == 1 && $data['type'] == 2)
                                                                                                <td>
                                                                                                    <a type="button" href="{{ route('initiation.create_data', $rows['rows'][0]['stakeholder_id']) }}" title="Edit" class="btn btn-link" style="background-color:blue; text-decoration:none; color:white">Edit</a>
                                                                                                </td>
                                                                                                @endif



                                                                                                @if($data['status'] == 5 )
                                                                                                <td>
                                                                                                    <a type="button" href="{{ route('initiation.create_data', $data['stakeholder_id'])}}" title="show" class="btn btn-link" style="text-decoration:none; color:white"><i class="fas fa-eye" style="color:green"></i></a>
                                                                                                </td>
                                                                                                @endif
                                                                                                @if($data['status'] == 2 && $data['stakeholder_comment'] == null )
                                                                                                <td>
                                                                                                    <a type="button" href="{{ route('initiation.create_data', $data['stakeholder_id'])}}" title="show" class="btn btn-link" style="text-decoration:none; color:white"><i class="fas fa-eye" style="color:green"></i></a>
                                                                                                </td>
                                                                                                @endif
                                                                                                <!-- Valuer Feedback button showing after stakeholder feedback (volume after feedback)-->
                                                                                                @if($data['status'] == 3 && $data['stakeholder_comment'] != null && $data['valuer_comment'] == null)
                                                                                                <td>
                                                                                                    <a href="{{ route('initiation.create_data', $data['stakeholder_id'])}}" class="btn btn-link">
                                                                                                        <img src="{{asset('assets/images/volume-svgrepo-com.svg')}}" alt="" width="20" height="30">
                                                                                                    </a>
                                                                                                </td>
                                                                                                @elseif($data['status'] == 3 && $data['stakeholder_comment'] != null && $data['valuer_comment'] != null && $data['valuer_comment'] != null)
                                                                                                <td>
                                                                                                    <a href="{{ route('initiation.create_data', $data['stakeholder_id'])}}" class="btn btn-link">
                                                                                                        <i class="fas fa-eye" style="color:green"></i>
                                                                                                    </a>
                                                                                                </td>


                                                                                                @endif


                                                                                            </tr>
                                                                                            @endforeach

                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                                <div class="genral_class professional_inprogress d-none">
                                                                                    <table class="table table-striped" id="align1">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>Sl. No.</th>
                                                                                                <th>Task Name</th>
                                                                                                <th>Description</th>
                                                                                                <th>Status</th>
                                                                                                <th>Action</th>
                                                                                            </tr>
                                                                                        </thead>

                                                                                        <tbody>

                                                                                            @foreach($rows['pending_count_professional'] as $data)
                                                                                            <tr>
                                                                                                <td>{{$loop->iteration}}</td>
                                                                                                <td>{{$data['task_name']}}</td>
                                                                                                <td>{{$data['inst_description']}}</td>
                                                                                                @if($data['status'] == 0)
                                                                                                <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending</span></td>
                                                                                                @elseif($data['status'] == 1)
                                                                                                <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">In Progress</span></td>
                                                                                                @elseif($data['status'] == 2)
                                                                                                <td style="color:white;"><span class="badge2 success rounded-pill text-bg-danger">Submitted</span></td>
                                                                                                @else
                                                                                                <td style="color:white;"><span class="badge2 success rounded-pill text-bg-danger">Completed</span></td>

                                                                                                @endif
                                                                                                <!-- 0 for pending 1  -->
                                                                                                @if($data['status'] == 0)
                                                                                                <td>

                                                                                                    <a type="button" href="{{ route('initiation.create_data', $data['stakeholder_id']) }}" title="Approve" class="btn btn-success" style="text-decoration:none; color:white">Accept/Reject</a>
                                                                                                </td>
                                                                                                <!-- for valuer while stakehloder giving task -->
                                                                                                @elseif($data['status'] == 1 && $data['type'] == 1 || $data['status'] == 1 && $data['type'] == 2)
                                                                                                <td>
                                                                                                    <a type="button" href="{{ route('initiation.create_data', $rows['rows'][0]['stakeholder_id']) }}" title="Edit" class="btn btn-link" style="background-color:blue; text-decoration:none; color:white">Edit</a>
                                                                                                </td>
                                                                                                @endif



                                                                                                @if($data['status'] == 5 )
                                                                                                <td>
                                                                                                    <a type="button" href="{{ route('initiation.create_data', $data['stakeholder_id'])}}" title="show" class="btn btn-link" style="text-decoration:none; color:white"><i class="fas fa-eye" style="color:green"></i></a>
                                                                                                </td>
                                                                                                @endif
                                                                                                @if($data['status'] == 2 && $data['stakeholder_comment'] == null )
                                                                                                <td>
                                                                                                    <a type="button" href="{{ route('initiation.create_data', $data['stakeholder_id'])}}" title="show" class="btn btn-link" style="text-decoration:none; color:white"><i class="fas fa-eye" style="color:green"></i></a>
                                                                                                </td>
                                                                                                @endif
                                                                                                <!-- Valuer Feedback button showing after stakeholder feedback (volume after feedback)-->
                                                                                                @if($data['status'] == 3 && $data['stakeholder_comment'] != null && $data['valuer_comment'] == null)
                                                                                                <td>
                                                                                                    <a href="{{ route('initiation.create_data', $data['stakeholder_id'])}}" class="btn btn-link">
                                                                                                        <img src="{{asset('assets/images/volume-svgrepo-com.svg')}}" alt="" width="20" height="30">
                                                                                                    </a>
                                                                                                </td>
                                                                                                @elseif($data['status'] == 3 && $data['stakeholder_comment'] != null && $data['valuer_comment'] != null && $data['valuer_comment'] != null)
                                                                                                <td>
                                                                                                    <a href="{{ route('initiation.create_data', $data['stakeholder_id'])}}" class="btn btn-link">
                                                                                                        <i class="fas fa-eye" style="color:green"></i>
                                                                                                    </a>
                                                                                                </td>


                                                                                                @endif


                                                                                            </tr>
                                                                                            @endforeach

                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                                <div class="genral_class professional_approved d-none">
                                                                                    <table class="table table-striped" id="align2">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>Sl. No.</th>
                                                                                                <th>Task Name</th>
                                                                                                <th>Description</th>
                                                                                                <th>Status</th>
                                                                                                <th>Action</th>
                                                                                            </tr>
                                                                                        </thead>

                                                                                        <tbody>

                                                                                            @foreach($rows['pending_count_professional'] as $data)
                                                                                            <tr>
                                                                                                <td>{{$loop->iteration}}</td>
                                                                                                <td>{{$data['task_name']}}</td>
                                                                                                <td>{{$data['inst_description']}}</td>
                                                                                                @if($data['status'] == 0)
                                                                                                <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending</span></td>
                                                                                                @elseif($data['status'] == 1)
                                                                                                <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">In Progress</span></td>
                                                                                                @elseif($data['status'] == 2)
                                                                                                <td style="color:white;"><span class="badge2 success rounded-pill text-bg-danger">Submitted</span></td>
                                                                                                @else
                                                                                                <td style="color:white;"><span class="badge2 success rounded-pill text-bg-danger">Completed</span></td>

                                                                                                @endif
                                                                                                <!-- 0 for pending 1  -->
                                                                                                @if($data['status'] == 0)
                                                                                                <td>

                                                                                                    <a type="button" href="{{ route('initiation.create_data', $data['stakeholder_id']) }}" title="Approve" class="btn btn-success" style="text-decoration:none; color:white">Accept/Reject</a>
                                                                                                </td>
                                                                                                <!-- for valuer while stakehloder giving task -->
                                                                                                @elseif($data['status'] == 1 && $data['type'] == 1 || $data['status'] == 1 && $data['type'] == 2)
                                                                                                <td>
                                                                                                    <a type="button" href="{{ route('initiation.create_data', $rows['rows'][0]['stakeholder_id']) }}" title="Edit" class="btn btn-link" style="background-color:blue; text-decoration:none; color:white">Edit</a>
                                                                                                </td>
                                                                                                @endif



                                                                                                @if($data['status'] == 5 )
                                                                                                <td>
                                                                                                    <a type="button" href="{{ route('initiation.create_data', $data['stakeholder_id'])}}" title="show" class="btn btn-link" style="text-decoration:none; color:white"><i class="fas fa-eye" style="color:green"></i></a>
                                                                                                </td>
                                                                                                @endif
                                                                                                @if($data['status'] == 2 && $data['stakeholder_comment'] == null )
                                                                                                <td>
                                                                                                    <a type="button" href="{{ route('initiation.create_data', $data['stakeholder_id'])}}" title="show" class="btn btn-link" style="text-decoration:none; color:white"><i class="fas fa-eye" style="color:green"></i></a>
                                                                                                </td>
                                                                                                @endif
                                                                                                <!-- Valuer Feedback button showing after stakeholder feedback (volume after feedback)-->
                                                                                                @if($data['status'] == 3 && $data['stakeholder_comment'] != null && $data['valuer_comment'] == null)
                                                                                                <td>
                                                                                                    <a href="{{ route('initiation.create_data', $data['stakeholder_id'])}}" class="btn btn-link">
                                                                                                        <img src="{{asset('assets/images/volume-svgrepo-com.svg')}}" alt="" width="20" height="30">
                                                                                                    </a>
                                                                                                </td>
                                                                                                @elseif($data['status'] == 3 && $data['stakeholder_comment'] != null && $data['valuer_comment'] != null && $data['valuer_comment'] != null)
                                                                                                <td>
                                                                                                    <a href="{{ route('initiation.create_data', $data['stakeholder_id'])}}" class="btn btn-link">
                                                                                                        <i class="fas fa-eye" style="color:green"></i>
                                                                                                    </a>
                                                                                                </td>


                                                                                                @endif


                                                                                            </tr>
                                                                                            @endforeach

                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>

                                                                                <div class="card-body" style="box-shadow: none !Important;">
                                                                                    <div class="genral_class gt_reject d-none">
                                                                                        <table class="table table-bordered" id="align2">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th>Sl. No.</th>
                                                                                                    <th>Name</th>
                                                                                                    <!-- <th>Interest</th> -->
                                                                                                    <th>Country</th>
                                                                                                    <th>Status</th>

                                                                                                </tr>
                                                                                            </thead>

                                                                                            <tbody>

                                                                                                @foreach($rows['gt_rejected'] as $data)


                                                                                                <tr>
                                                                                                    <td>{{$loop->iteration}}</td>
                                                                                                    <td>{{$data['name']}}</td>
                                                                                                    <!-- <td>{{$data['interest']}}</td> -->
                                                                                                    <td>{{$data['country']}}</td>
                                                                                                    @if($data['approval_status']=="Approved")
                                                                                                    <td style="color:white;"><span class="badge2 success rounded-pill text-bg-success">Approved</span></td>

                                                                                                    @elseif($data['approval_status']=="Pending")
                                                                                                    <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending</span></td>

                                                                                                    @elseif($data['approval_status']=="Rejected")
                                                                                                    <td style="color:white;"><span class="badge2 danger rounded-pill text-bg-warning">Rejected</span></td>

                                                                                                    @endif





                                                                                                </tr>
                                                                                                <!-- for stake holders -->

                                                                                                @endforeach
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                    <div class="genral_class d-none gt_approve">
                                                                                        <table class="table table-bordered" id="align5">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th>Sl. No.</th>
                                                                                                    <th>Name</th>
                                                                                                    <!-- <th>Interest</th> -->
                                                                                                    <th>Country</th>
                                                                                                    <th>Status</th>


                                                                                                </tr>
                                                                                            </thead>

                                                                                            <tbody>

                                                                                                @foreach($rows['gt_approved'] as $data)

                                                                                                <div>
                                                                                                    <!-- for other users -->
                                                                                                </div>


                                                                                                <tr>
                                                                                                    <td>{{$loop->iteration}}</td>
                                                                                                    <td>{{$data['name']}}</td>
                                                                                                    <!-- <td>{{$data['interest']}}</td> -->
                                                                                                    <td>{{$data['country']}}</td>
                                                                                                    @if($data['approval_status']=="Approved")
                                                                                                    <td style="color:white;"><span class="badge2 success rounded-pill text-bg-success">Approved</span></td>

                                                                                                    @elseif($data['approval_status']=="Pending")
                                                                                                    <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending</span></td>

                                                                                                    @elseif($data['approval_status']=="Rejected")
                                                                                                    <td style="color:white;"><span class="badge2 danger rounded-pill text-bg-warning">Rejected</span></td>

                                                                                                    @endif


                                                                                                </tr>
                                                                                                <!-- for stake holders -->

                                                                                                @endforeach
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>


                                                                                    <div class="genral_class d-none gt_pending">
                                                                                        <table class="table table-bordered" id="align3">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th>Sl. No.</th>
                                                                                                    <th>Name</th>
                                                                                                    <!-- <th>Interest</th> -->
                                                                                                    <th>Country</th>
                                                                                                    <th>Status</th>
                                                                                                    <th>Action</th>


                                                                                                </tr>
                                                                                            </thead>

                                                                                            <tbody>

                                                                                                @foreach($rows['gt_pending'] as $data)

                                                                                                <div>
                                                                                                    <!-- for other users -->
                                                                                                </div>


                                                                                                <tr>
                                                                                                    <td>{{$loop->iteration}}</td>
                                                                                                    <td>{{$data['name']}}</td>
                                                                                                    <!-- <td>{{$data['interest']}}</td> -->
                                                                                                    <td>{{$data['country']}}</td>
                                                                                                    @if($data['approval_status']=="Approved")
                                                                                                    <td style="color:white;"><span class="badge2 success rounded-pill text-bg-success">Approved</span></td>

                                                                                                    @elseif($data['approval_status']=="Pending")
                                                                                                    <td style="color:white;"><span class="badge2 warning rounded-pill text-bg-danger">Pending</span></td>

                                                                                                    @elseif($data['approval_status']=="Rejected")
                                                                                                    <td style="color:white;"><span class="badge2 danger rounded-pill text-bg-warning">Rejected</span></td>

                                                                                                    @endif

                                                                                                    <form action="{{route('approve')}}" method="GET">
                                                                                                        @csrf


                                                                                                        <td>
                                                                                                            <button type="submit" title="Approve or Allocate" class="btn btn-link"><img src="{{asset('assets/images/stamp-solid.svg')}}" alt="" width="20" height="30"></button>
                                                                                                        </td>
                                                                                                        <input type="hidden" name="gt_id" id="gt_id" value="{{$data['user_id']}}">
                                                                                                        <input type="hidden" name="approval_persons_id" id="approval_persons_id" value="{{$data['approval_persons_id']}}">
                                                                                                        <input type="hidden" name="user_id" id="user_id" value="">

                                                                                                    </form>




                                                                                                </tr>
                                                                                                <!-- for stake holders -->

                                                                                                @endforeach
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>

                                                                                </div>


                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        @endif




                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


    <script>
        $('#dashboard_click').on('change', function() {

            $('#dashboardapproved').css('display', 'none');




            if ($(this).val() === 'approve_dashboard') {
                $('#dashboardapproved').css('display', 'block');
            }


        });
        $('.card_count').on('click', function(e) {

            $('.card_count').removeClass('active');
            e.target.classList.add('active');
            e.target.blur();

            var all_counts = document.querySelectorAll('.cus_card');

            for (const all_count of all_counts) {
                if (all_count.classList[2] != 'd_none') {
                    all_count.classList.add('d_none');
                }

            }
            var cus_class = e.target.value;

            $(`.cus_card`).parent().addClass('d-none');
            $(`.${cus_class}`).parent().removeClass('d-none');
            $(`.${cus_class}`).removeClass('d_none');
        });

        function collapse_click(id) {
            $('.genral_class').addClass('d-none');
            $(`.${id}`).removeClass('d-none');
            document.querySelector('#list_overview').click();

        }

        function overview(e) {
            var id = e.target.id;
            if (document.querySelector('#collapseOne').classList == "collapse show") {
                document.querySelector('#list_overview').click();
                setTimeout(function() {
                    collapse_click(id);
                }, 500);

            } else {
                collapse_click(id)

            }
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            if (document.querySelector('.first_button')) {
                document.querySelector('.first_button').click();

            }


        });
    </script>
    <!-- Pie Chart -->

    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],
                ['Work', 11],
                ['Eat', 2],
                ['Commute', 2],
                ['Watch TV', 2],
                ['Sleep', 7]
            ]);

            var options = {
                backgroundColor: 'transparent',
                pieSliceText: 'percentage',
                pieStartAngle: 100,
                chartArea: {
                    left: 25,
                    top: 30,
                    width: '100%',
                    height: '100%'
                },
                legend: {
                    alignment: 'center',
                    position: 'right',
                    maxLines: 10,
                    textStyle: {
                        color: 'blue',
                        fontSize: 12
                    }
                }
            };
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);
        }
    </script>
    <!-- Graph -->

    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Year', 'Sales', 'Expenses'],
                ['2013', 1000, 400],
                ['2014', 1170, 460],
                ['2015', 660, 1120],
                ['2016', 1030, 540]
            ]);

            var options = {
                backgroundColor: 'transparent',
                is3D: true,
                legend: 'none',
                'width': 500,
                'height': 250,
                pointSize: 7,
                hAxis: {
                    title: 'Year',
                    formate: 'MMM yy',
                    curveType: 'function',
                    pointSize: 100,
                    viewWindow: {
                        min: new Date(2022, 1),
                    }
                },
                vAxis: {
                    minValue: 0,
                    //maxValue: 100, //Remove maxValue if dont have end point
                    title: 'No of Valuation Evaluated'
                }
            };

            var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>
    <script>
        function getDocumentView(documentProcessID) {
            $(".loader_div").show();
            $('#viewDocument').html('');
            $.ajax({
                url: '/document/processing/document/view',
                type: 'GET',
                data: {
                    'documentProcessID': documentProcessID
                }
            }).done(function(data) {
                if (data.status == 401) {
                    window.location.href = "/unauthenticated";
                }
                if (data.status == 200) {
                    $('#viewDocument').html(data.html);
                }
                $(".loader_div").hide();
            })
        }
    </script>
    <script>
        function displayOverviewCount() {
            var overviewCount = document.querySelector('.overview_count');
            var overview_count_inprogress = document.querySelector('.overview_count_inprogress');
            var overview_count_approved = document.querySelector('.overview_count_approved');
            var instructionCount = document.querySelector('.instruction_count');
            var instruction_count_inprogress = document.querySelector('.instruction_count_inprogress');
            var instruction_count_approved = document.querySelector('.instruction_count_approved');

            overviewCount.style.display = 'block';
            overview_count_inprogress.style.display = 'block';
            overview_count_approved.style.display = 'block';
            instructionCount.style.display = 'none';
            instruction_count_inprogress.style.display = 'none';
            instruction_count_approved.style.display = 'none';
        }

        function toggleInstructionCount() {
            var overviewCount = document.querySelector('.overview_count');
            var overview_count_inprogress = document.querySelector('.overview_count_inprogress');
            var overview_count_approved = document.querySelector('.overview_count_approved');
            var instructionCount = document.querySelector('.instruction_count');
            var instruction_count_inprogress = document.querySelector('.instruction_count_inprogress');
            var instruction_count_approved = document.querySelector('.instruction_count_approved');

            overviewCount.style.display = 'none';
            overview_count_inprogress.style.display = 'none';
            overview_count_approved.style.display = 'none';
            instructionCount.style.display = 'block';
            instruction_count_inprogress.style.display = 'block';
            instruction_count_approved.style.display = 'block';
        }
    </script>

    <!-- admin charts -->

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>
        var data = [<?php echo $admin['registervaluer']; ?>, <?php echo $admin['graduatetrainee']; ?>, <?php echo $admin['registertrainee']; ?>];
        // var data[0]=;
        // var data[1]=;
        // var data[2]=;

        console.log(data);
        // Sample data for the chart
        // var data = [5, 10, 15];

        // Create the chart
        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'MLHUD'
            },
            credits: {
                enabled: false
            },
            xAxis: {
                categories: ['Registered Valuers', 'Graduate Trainee ', 'Registered Firms']
            },
            yAxis: {
                title: {
                    text: 'Counts'
                }

            },
            series: [{
                name: 'Data',
                data: [{
                    y: data[0], // Specify your data value
                    color: 'red' // Specify the color for this data point
                }, {
                    y: data[1],
                    color: 'blue',
                    backgroundColor: '#000000'
                }, {
                    y: data[2],
                    color: 'green'
                }]
            }]
        });
    </script>
    @endsection