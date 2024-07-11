@extends('layouts.elearningmain')

@section('content')
<style>
    /* remove card bocy shadow */
    .noShadow .card-body{
        box-shadow: none !important;
    }

    .form-control{
        background-color: #fdfdff !important;
        box-shadow: none !important;
        border: 1px solid #000 !important;
        border-radius: 0px !important;
    }
    /* main-container */
    .results_main_header{
        width: fit-content;
        color: #09A438;
        font-weight: 900;
        font-size: 1.5rem !important;
        margin-bottom: 1rem !important;
    }
    /* search section */
    .results_search_container{
        font-weight: 800;
        width: 25%;
        margin-left: auto;
        margin-bottom: 1rem;
        border-radius: 0px !important;
    }
    .results_search_container button{
        color: #fff !important;
        background-color: #000 !important;
        border: 1px solid #000;
        border-left: 0px !important;
        width: 3rem;
        height: 41px;
        font-size: 1.2rem;
    }
    .results_search_container .form-control::placeholder{
        color:  #000000 !important;
    }

    /* Course list section */
    .results_courselist_container{
        margin-top: 1rem !important;
    }
    .results_courselist{
        margin: 0px !important;
        margin-bottom: 2rem !important;
        border: 0px !important;
        box-shadow: none !important;
    }
    .results_courselist .card-header{
        overflow: hidden !important;
        padding: 0px !important;
        height: 8rem !important;
    }
    .results_courselist .card-body{
        padding: 0px !important;
    }
    .results_courselist .card-title h5{
        color: #000;
        font-size: 1.3rem;
        line-height: 2rem;
        white-space: nowrap;
        width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .course_image{
        width: 100%;
    }
    .course_total_progress{
        height: 0.25rem !important;
        box-shadow: none !important;
    }
    /* paginnation sectiion */
    .results_paginate_container{
        margin-top: 2rem;
    }
    .results_paginate{
        margin-bottom: 0px !important;
    }
    .results_pagination_page_number .page-link{
        color: #141ad8 !important;
        background-color: transparent !important;
        border: 0px solid #000 !important;
    }
    .results_pagination_page_number .page-link.active{
        text-decoration: 2.2px underline #000;
    }
    .results_pagination_nav .page-link{
        color: #000 !important;
        background-color: transparent !important;
        border: 1px solid #000 !important;
        border-radius: 50%;
    }
    /* Course list section */
    .results_courselist_container{
        margin-top: 1rem !important;
    }
    .results_courselist{
        margin: 0px !important;
        margin-bottom: 2rem !important;
        border: 0px !important;
        box-shadow: none !important;
    }
    .results_courselist .card-header{
        overflow: hidden !important;
        padding: 0px !important;
        height: 8rem !important;
    }
    .results_courselist .card-body{
        padding: 0px !important;
    }
    .results_courselist .card-title h5{
        color: #000;
        font-size: 1.3rem;
        line-height: 2rem;
        white-space: nowrap;
        width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .course_image{
        width: 100%;
    }
    /* courser price */
    .course_price{
        font-size: 1.2rem !important;
        font-weight: 900;
        margin-right: 0.5rem;
    }
    .course_orginal_price{
        color: #6f6f6f;
        font-weight: 800;
        text-decoration: 1px line-through black;
    }
    /* Enroll */
    .enroll_now{
        color: white;
        background-color:  #000000 !important;
        width: fit-content;
        border: 0px;
        padding: 0.3rem 1rem;
    }
    @media (min-width:319.96px) {
        
    }

    @media (min-width:767.96px) {
        
    }
    @media (min-width:1024.96px) {
        .main-content{
            padding-left: 220px !important;
        }
        .sidebar-mini .main-content{
            padding-left: 85px !important;
        }
    }
</style>
<div class="main-content">
    <section class="section">
        <div class="section-body mt-1">

            <div class="container-fluid results_container">
                
                <div class="d-flex flex-row justify-content-between align-items-end">
                    <h2 class="results_main_header">
                        Search Results
                        <div class="path">
                            <span>E-Learning</span>
                            <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                            <span>Results</span>
                        </div>
                    </h2>
                </div>

                <div class="results_search_container">
                    <form class="d-flex flex-row justify-content-center align-items-center" action="#" method="get">
                        <input type="search" class="form-control" placeholder="Search">
                        <button type="submit">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                    </form>
                </div>

            </div>

            <div class="container-fluid results_courselist_container">
                <div class="row">
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                        <div class="card noShadow results_courselist">
                            <div class="card-header">
                                <img src="{{asset('asset/image/recommended-course1.jpg')}}" alt="" class="course_image">
                            </div>
                            <div class="card-body">
                                <div class="card-title">
                                    <h5>
                                        Valuation and Financial Analysis
                                    </h5>
                                </div>
                                <div class="card-text">
                                    <h6>Colt Blue</h6>
                                </div>
                                <div class="d-flex flex-row justify-content-start">
                                    <span class="course_rating">
                                        4.5
                                    </span>
                                    <span class="mx-2 course_rating_list">
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                    </span>
                                    <span class="course_rating_count">
                                        (10245)
                                    </span>
                                </div>
                                <div class="d-flex flex-row justify-content-start">
                                    <span class="course_total_hours">
                                        17 total hours
                                    </span>
                                    <span class="mx-1">
                                        -
                                    </span>
                                    <span class="course_contents">
                                        130 content
                                    </span>
                                </div>
                                <div class="d-flex flex-row justify-content-start align-items-center">
                                    <span class="course_price">
                                        USh 455
                                    </span>
                                    <span class="course_orginal_price">
                                        USh 3499
                                    </span>
                                </div>
                                <div class="rounded-pill enroll_now">
                                    <span class="text-uppercase">enroll now</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                        <div class="card noShadow results_courselist">
                            <div class="card-header">
                                <img src="{{asset('asset/image/recommended-course2.jpg')}}" alt="" class="course_image">
                            </div>
                            <div class="card-body">
                                <div class="card-title">
                                    <h5>
                                    Advanced valuation and strategy
                                    </h5>
                                </div>
                                <div class="card-text">
                                    <h6>Albus Dumbledore</h6>
                                </div>
                                <div class="d-flex flex-row justify-content-start">
                                    <span class="course_rating">
                                        5
                                    </span>
                                    <span class="mx-2 course_rating_list">
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                    </span>
                                    <span class="course_rating_count">
                                        (3245)
                                    </span>
                                </div>
                                <div class="d-flex flex-row justify-content-start">
                                    <span class="course_total_hours">
                                        29 total hours
                                    </span>
                                    <span class="mx-1">
                                        -
                                    </span>
                                    <span class="course_contents">
                                        123 content
                                    </span>
                                </div>
                                <div class="d-flex flex-row justify-content-start align-items-center">
                                    <span class="course_price">
                                        USh 583
                                    </span>
                                    <span class="course_orginal_price">
                                        USh 4699
                                    </span>
                                </div>
                                <div class="rounded-pill enroll_now">
                                    <span class="text-uppercase">enroll now</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                        <div class="card noShadow results_courselist">
                            <div class="card-header">
                                <img src="{{asset('asset/image/recommended-course3.jpg')}}" alt="" class="course_image">
                            </div>
                            <div class="card-body">
                                <div class="card-title">
                                    <h5>
                                        Bussiness Valuation Course
                                    </h5>
                                </div>
                                <div class="card-text">
                                    <h6>Minerva McGonagall</h6>
                                </div>
                                <div class="d-flex flex-row justify-content-start">
                                    <span class="course_rating">
                                        3.2
                                    </span>
                                    <span class="mx-2 course_rating_list">
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                    </span>
                                    <span class="course_rating_count">
                                        (2045)
                                    </span>
                                </div>
                                <div class="d-flex flex-row justify-content-start">
                                    <span class="course_total_hours">
                                        11 total hours
                                    </span>
                                    <span class="mx-1">
                                        -
                                    </span>
                                    <span class="course_contents">
                                        110 content
                                    </span>
                                </div>
                                <div class="d-flex flex-row justify-content-start align-items-center">
                                    <span class="course_price">
                                        USh 345
                                    </span>
                                    <span class="course_orginal_price">
                                        USh 3199
                                    </span>
                                </div>
                                <div class="rounded-pill enroll_now">
                                    <span class="text-uppercase">enroll now</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                        <div class="card noShadow results_courselist">
                            <div class="card-header">
                                <img src="{{asset('asset/image/recommended-course4.jpg')}}" alt="" class="course_image">
                            </div>
                            <div class="card-body">
                                <div class="card-title">
                                    <h5>
                                        Discounted Cash Flow Modelling
                                    </h5>
                                </div>
                                <div class="card-text">
                                    <h6>Severus Snape</h6>
                                </div>
                                <div class="d-flex flex-row justify-content-start">
                                    <span class="course_rating">
                                        5
                                    </span>
                                    <span class="mx-2 course_rating_list">
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                    </span>
                                    <span class="course_rating_count">
                                        (9245)
                                    </span>
                                </div>
                                <div class="d-flex flex-row justify-content-start">
                                    <span class="course_total_hours">
                                        15 total hours
                                    </span>
                                    <span class="mx-1">
                                        -
                                    </span>
                                    <span class="course_contents">
                                        106 content
                                    </span>
                                </div>
                                <div class="d-flex flex-row justify-content-start align-items-center">
                                    <span class="course_price">
                                        USh 455 
                                    </span>
                                    <span class="course_orginal_price">
                                        USh 3899
                                    </span>
                                </div>
                                <div class="rounded-pill enroll_now">
                                    <span class="text-uppercase">enroll now</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                        <div class="card noShadow results_courselist">
                            <div class="card-header">
                                <img src="{{asset('asset/image/notice-board2.jpg')}}" alt="" class="course_image">
                            </div>
                            <div class="card-body">
                                <div class="card-title">
                                    <h5>
                                        Critiques Involved in Valuation 
                                    </h5>
                                </div>
                                <div class="card-text">
                                    <h6>Coltee</h6>
                                </div>
                                <div class="d-flex flex-row justify-content-start">
                                    <span class="course_rating">
                                        4.2
                                    </span>
                                    <span class="mx-2 course_rating_list">
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                    </span>
                                    <span class="course_rating_count">
                                        (1245)
                                    </span>
                                </div>
                                <div class="d-flex flex-row justify-content-start">
                                    <span class="course_total_hours">
                                        9 total hours
                                    </span>
                                    <span class="mx-1">
                                        -
                                    </span>
                                    <span class="course_contents">
                                        98 content
                                    </span>
                                </div>
                                <div class="d-flex flex-row justify-content-start align-items-center">
                                    <span class="course_price">
                                        USh 569
                                    </span>
                                    <span class="course_orginal_price">
                                        USh 3459
                                    </span>
                                </div>
                                <div class="rounded-pill enroll_now">
                                    <span class="text-uppercase">enroll now</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                        <div class="card noShadow results_courselist">
                            <div class="card-header">
                                <img src="{{asset('asset/image/notice-board3.jpg')}}" alt="" class="course_image">
                            </div>
                            <div class="card-body">
                                <div class="card-title">
                                    <h5>
                                        Analysis of Surveys and Mapping
                                    </h5>
                                </div>
                                <div class="card-text">
                                    <h6>Hermione Granger</h6>
                                </div>
                                <div class="d-flex flex-row justify-content-start">
                                    <span class="course_rating">
                                        3.8
                                    </span>
                                    <span class="mx-2 course_rating_list">
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                    </span>
                                    <span class="course_rating_count">
                                        (2450)
                                    </span>
                                </div>
                                <div class="d-flex flex-row justify-content-start">
                                    <span class="course_total_hours">
                                        13 total hours
                                    </span>
                                    <span class="mx-1">
                                        -
                                    </span>
                                    <span class="course_contents">
                                        180 content
                                    </span>
                                </div>
                                <div class="d-flex flex-row justify-content-start align-items-center">
                                    <span class="course_price">
                                        USh 415
                                    </span>
                                    <span class="course_orginal_price">
                                        USh 3369
                                    </span>
                                </div>
                                <div class="rounded-pill enroll_now">
                                    <span class="text-uppercase">enroll now</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid d-flex flex-row justify-content-center results_paginate_container">
                <ul class="pagination results_paginate">
                    <li class="results_pagination_nav" id="results_pagination_previous">
                        <a href="#" aria-controls="results" data-dt-idx="0" tabindex="0" class="page-link">
                            <i class="fa fa-chevron-left" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li class="results_pagination_page_number">
                        <a href="#" aria-controls="results" data-dt-idx="1" tabindex="0" class="page-link active">
                            1
                        </a>
                    </li>
                    <li class="results_pagination_page_number">
                        <a href="#" aria-controls="results" data-dt-idx="1" tabindex="0" class="page-link">
                            2
                        </a>
                    </li>
                    <li class="results_pagination_nav" id="results_pagination__next">
                        <a href="#" aria-controls="results" data-dt-idx="2" tabindex="0" class="page-link">
                            <i class="fa fa-chevron-right" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="container-fluid d-flex flex-row justify-content-center results_info_container">
                <div class="results_info">
                    1 to 6 of 6 Courses
                </div>
            </div>
                    
        </div>
    </section>
</div>
@endsection