@extends('layouts.elearningmain')

@section('content')
<style>
    /* remove card bocy shadow */
    .noShadow .card-body {
        box-shadow: none !important;
    }

    /* main header */
    .wishlist_main_header {
        width: fit-content;
        color: #0006cc;
        font-weight: 900;
        font-size: 1.5rem !important;
        margin-bottom: 1rem !important;
    }

    /* sort and filter options */
    .form-control {
        background-color: #fdfdff !important;
        box-shadow: none !important;
        border: 1px solid #000 !important;
        border-radius: 0px !important;
    }

    /* search section */
    .wishlist_search_container {
        font-weight: 800;
        padding: 0px 30px !important;
        margin-left: auto;
        margin-bottom: 1.5rem;
        border-radius: 0px !important;
    }

    .wishlist_search_container input {
        color: #000 !important;
        background-color: #fff !important;
        width: 100% !important;
        height: 41px;
        font-size: 1.2rem;
    }

    .wishlist_search_container button {
        color: #fff !important;
        background-color: #000 !important;
        border: 1px solid #000;
        border-left: 0px !important;
        width: 3rem;
        margin-top: -10px;
        height: 41px;
        font-size: 1.2rem;
    }

    /* Course list section */
    .wishlist_courselist_container {
        margin-top: 1rem !important;
    }

    .wishlist_courselist {
        margin: 0px !important;
        margin-bottom: 2rem !important;
        border: 0px !important;
        box-shadow: none !important;
    }

    .wishlist_courselist .card-header {
        overflow: hidden !important;
        padding: 0px !important;
        height: 8rem !important;
    }

    .wishlist_courselist .card-body {
        padding: 0px !important;
    }

    .wishlist_courselist .card-title h5 {
        color: #000;
        font-size: 1.3rem;
        line-height: 2rem;
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
    }

    /* paginnation sectiion */
    .wishlist_paginate_container {
        margin-top: 2rem;
    }

    .wishlist_courses_paginate {
        margin-bottom: 0px !important;
    }

    .wishlist_pagination_page_number .page-link {
        color: #141ad8 !important;
        background-color: transparent !important;
        border: 0px solid #000 !important;
    }

    .wishlist_pagination_page_number .page-link.active {
        text-decoration: 2.2px underline #000;
    }

    .wishlist_pagination_nav .page-link {
        color: #000 !important;
        background-color: transparent !important;
        border: 1px solid #000 !important;
        border-radius: 50%;
    }

    /* courser price */
    .course_price {
        font-weight: 900;
        margin-right: 0.5rem;
    }

    .course_orginal_price {
        color: #6f6f6f;
        font-weight: 800;
        text-decoration: 1px line-through black;
    }

    @media (min-width:319.96px) {}

    @media (min-width:575.96px) {}

    @media (min-width:767.96px) {}

    @media (min-width:1024.96px) {
        .main-content {
            padding-left: 220px !important;
        }

        .sidebar-mini .main-content {
            padding-left: 85px !important;
        }

    }

    .course_paid {
        height: 30px !important;
        width: 25% !important;
        border-radius: 20px;
        position: absolute;
        padding: 5px 0px 0px 20px;
        color: #ffffff;
        margin-bottom: 15px;
        text-transform: capitalize;
    }

    .rating-color {
        color: #b4690e !important;
    }
</style>
<div class="main-content">
    <section class="section">
        <div class="section-body mt-1">

            <div
                class="container-fluid d-flex flex-column flex-sm-row justify-content-between align-items-center wishlist_search_container">
                @if (session('success'))

                    <input type="hidden" name="session_data" id="session_data" class="session_data"
                        value="{{ session('success') }}">
                    <script type="text/javascript">
                        window.onload = function () {
                            var message = $('#session_data').val();
                            swal({
                                title: "Success",
                                text: message,
                                type: "success",
                            });

                        }
                    </script>
                @elseif(session('error'))

                    <input type="hidden" name="session_data" id="session_data1" class="session_data"
                        value="{{ session('error') }}">
                    <script type="text/javascript">
                        window.onload = function () {
                            var message = $('#session_data1').val();
                            swal({
                                title: "Info",
                                text: message,
                                type: "info",
                            });

                        }
                    </script>
                @endif
                <h2 class="wishlist_main_header">
                    Wishlist
                    <div class="path">
                        <span>E-Learning</span>
                        <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                        <span>Wishlist</span>
                    </div>
                </h2> q
                <!-- <form class="d-flex flex-row justify-content-end align-items-center" action="#" method="get">
                    <input type="search" class="form-control" placeholder="Search">
                    <button type="submit">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </form> -->
            </div>

            <div class="container-fluid wishlist_courselist_container">

                <div class="row">
                    @php $count = 1;@endphp
                    @foreach($wishlistCourses as $wishlistCourse)

                                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                                            <div class="card noShadow wishlist_courselist">
                                                <div class="card-header">
                                                    <img src="../../uploads/course/126/{{$wishlistCourse->course_banner}}" alt=""
                                                        class="course_image">
                                                </div>
                                                <div class="card-body">
                                                    <div class="card-title">
                                                        <h5>
                                                            {{$wishlistCourse->course_name}}
                                                        </h5>
                                                    </div>
                                                    <div class="card-text">
                                                        <h6>{{$wishlistCourse->course_instructor}}</h6>
                                                    </div>
                                                    <div class="d-flex flex-row justify-content-start">
                                                        <span class="course_rating">

                                                        </span>
                                                        <span class="mx-2 course_rating_list ratingsset{{$count}}">
                                                            @php
                                                                $ratings = !empty($wishlistCourse->average_rating) ? $wishlistCourse->average_rating : 0;
                                                                $averageRating = $ratings * 2;
                                                                $actual_rating = intval($averageRating / 2);


                                                            @endphp
                                                            @for($i = 1; $i <= 5; $i++) @if($i <= $actual_rating) <i
                                                                class="fa fa-star rating-color"></i>
                                                            @else
                                                                <i class="fa fa-star unfilled-star"></i>
                                                            @endif
                                                            @endfor
                                                            @if($averageRating % 2 != 0)
                                                                <script>
                                                                    var fa_list = document.querySelector('.ratingsset{{$count}} .unfilled-star');
                                                                    fa_list.classList.remove('fa-star');
                                                                    fa_list.classList.add('fa-star-half-o');
                                                                    fa_list.classList.add('rating-color');
                                                                </script>
                                                            @endif
                                                        </span>
                                                        <span class="course_rating_count">
                                                            {{ $ratings }}
                                                        </span>
                                                        @php    $count++ @endphp
                                                    </div>
                                                    <!-- <div class="d-flex flex-row justify-content-start">
                                                                                                                                                                                                                                                                                                        <span class="course_total_hours">
                                                                                                                                                                                                                                                                                                            17 total hours
                                                                                                                                                                                                                                                                                                        </span>
                                                                                                                                                                                                                                                                                                        <span class="mx-1">
                                                                                                                                                                                                                                                                                                            -
                                                                                                                                                                                                                                                                                                        </span>
                                                                                                                                                                                                                                                                                                        <span class="course_contents">
                                                                                                                                                                                                                                                                                                            130 contents
                                                                                                                                                                                                                                                                                                        </span>
                                                                                                                                                                                                                                                                                                    </div> -->
                                                    <div class="d-flex flex-row justify-content-start">

                                                        @if($wishlistCourse->course_pay === 'paid')

                                                            <span class="course_price">
                                                                Rs. {{$wishlistCourse->course_price}}
                                                            </span>
                                                        @else($wishlistCourse->course_pay === 'free')

                                                            <span class="course_price">
                                                                <span style="background-color: #0ecf26;"
                                                                    class="course_paid">{{$wishlistCourse->course_pay}}</span>
                                                            </span>
                                                        @endif
                                                        <!-- <span class="course_orginal_price">
                                                                                                                                                                                                                                                                                                            USh 3499
                                                                                                                                                                                                                                                                                                        </span> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                    @endforeach

                </div>

                <div class="d-flex flex-row justify-content-center allCoursePagination">
                    {{ $wishlistCourses->links() }}


                </div>


            </div>

            <!-- <div class="container-fluid d-flex flex-row justify-content-center wishlist_paginate_container">
                <ul class="pagination wishlist_courses_paginate">
                    <li class="wishlist_pagination_nav" id="wishlist_pagination_previous">
                        <a href="#" aria-controls="all_courses" data-dt-idx="0" tabindex="0" class="page-link">
                            <i class="fa fa-chevron-left" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li class="wishlist_pagination_page_number">
                        <a href="#" aria-controls="all_courses" data-dt-idx="1" tabindex="0" class="page-link active">
                            1
                        </a>
                    </li>
                    <li class="wishlist_pagination_page_number">
                        <a href="#" aria-controls="all_courses" data-dt-idx="1" tabindex="0" class="page-link">
                            2
                        </a>
                    </li>
                    <li class="wishlist_pagination_nav" id="wishlist_pagination_next">
                        <a href="#" aria-controls="all_courses" data-dt-idx="2" tabindex="0" class="page-link">
                            <i class="fa fa-chevron-right" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>
            </div> -->

            <!-- <div class="container-fluid d-flex flex-row justify-content-center wishlist_info_container">
                <div class="wishlist_info">
                    1 to 6 of 6 Courses
                </div>
            </div> -->

        </div>
    </section>
</div>

@endsection