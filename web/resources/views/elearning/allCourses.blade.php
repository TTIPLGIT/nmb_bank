@extends('layouts.elearningmain')

@section('content')
<style>
/* main-container */


.all_courses_main_header {
    width: fit-content;
    color: #680EDA;
    font-weight: 900;
    font-size: 1.5rem !important;
    margin-bottom: 1rem !important;
}

/* remove card bocy shadow */
.noShadow .card-body {
    box-shadow: none !important;
}

/* filters mobile */
.filters_header {
    background: #eee !important;
    color: #000 !important;
}

/* sort and filter header*/
.all_courses_sort_header,
.all_courses_filter_header {
    display: none !important;
}

/* sort and filter options */
.form-control {
    background-color: #fdfdff !important;
    box-shadow: none !important;
    border: 1px solid #000 !important;
    border-radius: 0px !important;
}

.all_courses_sort_select {
    font-weight: 800;
    width: 20%;
    color: #000000 !important;
    border: 1px solid #000 !important;
    border-radius: 0px !important;
    margin-bottom: 1rem;
}

.all_courses_filter_container {
    font-weight: 800;
    width: 45%;
    margin-left: 2%;
    margin-bottom: 1rem;
    border-radius: 0px !important;
}

.all_courses_filter_select {
    font-weight: 800;
    width: 40%;
    color: #000000 !important;
    margin-right: 2%;
    border: 1px solid #000 !important;
    border-radius: 0px !important;
}

.all_courses_reset_btn {
    width: fit-content;
    text-align: left;
    color: #40c2b2 !important;
    border: 0px !important;
    padding: 0px 0px !important;
    background-color: transparent !important;
}

.all_courses_reset_btn:disabled {
    color: #1c1d1f !important;
}

/* search section */
.all_courses_search_container {
    font-weight: 800;
    width: 25%;
    margin-left: auto;
    margin-bottom: 1rem;
    border-radius: 0px !important;
}

.all_courses_search_container button {
    color: #fff !important;
    background-color: #000 !important;
    border: 1px solid #000;
    border-left: 0px !important;
    width: 3rem;
    margin-top: -10px;
    height: 41px;
    font-size: 1.2rem;
}

.all_courses_search_container .form-control::placeholder {
    color: #000000 !important;
}

/* Course list section */
.all_courses_courselist_container {
    margin-top: 1rem !important;
}

.all_courses_courselist {
    margin: 0px !important;
    margin-bottom: 2rem !important;
    border: 0px !important;
    box-shadow: none !important;
}

.all_courses_courselist .card-header {
    overflow: hidden !important;
    padding: 0px !important;
    height: 8rem !important;
}

.all_courses_courselist .card-body {
    padding: 5% !important;
}

.all_courses_courselist .card-title h5 {
    color: #000;
    font-size: 1.3rem;
    line-height: 2rem;
    text-transform: capitalize;
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
    margin-top: 30px;
}

/* paginnation sectiion */
.all_courses_paginate_container {
    margin-top: 2rem;
}

.all_courses_paginate {
    margin-bottom: 0px !important;
}

.all_courses_pagination_page_number .page-link {
    color: #141ad8 !important;
    background-color: transparent !important;
    border: 0px solid #000 !important;
}

.all_courses_pagination_page_number .page-link.active {
    text-decoration: 2.2px underline #000;
}

.all_courses_pagination_nav .page-link {
    color: #000 !important;
    background-color: transparent !important;
    border: 1px solid #000 !important;
    border-radius: 50%;
}

.all_courses_pagination_page_number {
    display: flex;
    flex-direction: row;
}

#searchResultnone {
    font-size: 25px;
    color: #ff443a;
    font-weight: 600;
}

.allCoursePagination .page-item:first-child .page-link,
.allCoursePagination .page-item:last-child .page-link {
    font-size: 2rem !important;
    line-height: 0.78em !important;
    font-weight: 600 !important;
    padding: .2rem .65rem .3rem .65rem !important;
}

.wishList-badge {
    position: absolute;
    top: 5px;
    right: 20px !important;
    width: 30px;
    height: 30px;
    font-size: 13px !important;
    color: red;
    background-color: transparent !important;
    border: 0px;
    border-radius: 5px !important;
    padding: 0px !important;
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
}

@media (min-width:319.96px) {

    /* .all_courses_sort_select{
            width: 100%;
        } */
    .all_courses_filters_popper {
        margin-bottom: 1rem !important;
        font-size: 1rem;
        font-weight: 700;
        background-color: #fff;
        padding: 0.5% 3%;
        color: #40c2b2;
        border: 0px !important;
        border-radius: 10px;
        box-shadow: 0.1rem 0.1rem 0.2rem #6c757d;
    }

    .all_courses_filters_popper i {
        font-size: 0.75rem;
        vertical-align: middle;
        color: #40c2b2;
        font-weight: 700;
    }

    .all_courses_filter_block2 {
        display: none !important;
    }
}

@media (min-width:767.96px) {
    .all_courses_sort_header {
        display: inline-block !important;
        width: 20%;
        color: #1c1d1f !important;
        margin-bottom: 0.75rem;
        text-align: left;
    }

    .all_courses_filter_header {
        display: inline-block !important;
        width: 20%;
        color: #1c1d1f !important;
        margin-left: 2%;
        margin-bottom: 0.75rem;
        text-align: left;
    }

    .all_courses_filters_popper {
        display: none !important;
    }

    .all_courses_filter_block2 {
        display: flex !important;
    }
}

@media (min-width:1024.96px) {
    .main-content {
        padding-left: 220px !important;
    }

    .sidebar-mini .main-content {
        padding-left: 85px !important;
    }
}

@media (min-width:320px) {
    .filter_align {
        display: flex;
        font-size: 12px;
        gap: 7px;
        align-items: center;
    }



}

.course_paid {
    height: 30px !important;
    width: 25% !important;
    border-radius: 20px;
    position: absolute;
    padding: 6px 0px 0px 18px;
    color: #ffffff;
    margin-left: 2%;
    font-size: 16px;
    margin-bottom: 15px;
    text-transform: capitalize;
}

.blinking-warning {
    background-color: #ff0015;
    color: white;
    padding: 2px 6px;
    border-radius: 20px;
    font-size: 12px;
    /* animation: blinker 2s linear infinite; */
}

@keyframes blinker {
    50% {
        opacity: 0;
    }
}

.highlight-new-course {
    border: 3px solid #4CAF50;
    box-shadow: 0 0 12px #4CAF50;
    transition: all 0.3s ease-in-out;
}
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>

<div class="main-content">
    <section class="section">
        <div class="section-body mt-1">

            <div class="container-fluid all_courses_container">

                <div class="d-flex flex-row justify-content-between align-items-end">
                    <h2 class="all_courses_main_header">
                        All Courses
                        <div class="path">
                            <span>E-Learning</span>
                            <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                            <span>All Courses</span>
                        </div>
                    </h2>
                    <a class="text-uppercase all_courses_filters_popper filter_align" href="#" data-toggle="modal"
                        data-target="#filters">
                        filters
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </a>
                </div>

                <div class="d-flex flex-row justify-content-start">
                    <span class="all_courses_sort_header">
                        Sort by
                    </span>
                    <span class="all_courses_filter_header">
                        Filter by
                    </span>
                </div>

                <form class="d-flex flex-row flex-wrap justify-content-start all_courses_filter_block2"
                    action="{{ route('elearningAllCourses') }}" method="POST">
                    @csrf
                    @method('GET')
                    <select class="form-control all_courses_sort_select" name="all_courses_sort_select">
                        <option value="Recently Added" selected>Recently Added</option>
                        <option value="Recently Enrolled">Recently Enrolled</option>
                        <option value="A to Z">A to Z</option>
                        <option value="Z to A">Z to A</option>
                    </select>
                    <div class="d-flex flex-row flex-wrap justify-content-evenly all_courses_filter_container">
                        <select class="form-control all_courses_filter_select" name="all_courses_filter_select">
                            <option value="false" selected>Tags</option>
                            @foreach($availableTags as $availableTag)
                            <option value="{{$availableTag}}">{{$availableTag}}</option>
                            @endforeach
                        </select>
                        <select class="form-control all_courses_filter_select" name="all_courses_filter_select">
                            <option value="false" selected>Progress</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                            <option value="Not Enrolled">Not Enrolled</option>
                        </select>
                        <button class="all_courses_reset_btn" type="reset" x>
                            <span>Reset</span>
                        </button>
                    </div>
                    <div class="all_courses_search_container">
                        <div class="d-flex flex-row justify-content-center align-items-center">
                            <input type="search" class="form-control" id="courseSearch" name="courseSearch"
                                placeholder="Search">
                            <button type="submit" id="courseSearchButton">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </form>

            </div>

            <div class="container-fluid all_courses_courselist_container">
                <div id="searchResultnone" style="display: none;">
                    <p>
                        Sorry, we couldn't find the matches
                    </p>
                </div>


                <div class="row">

                    @foreach($availableCourses as $key => $value)
                    @php
                    $showExpiryBadge = false;

                    if ($value->certificate_expiry == '1' && !empty($value->course_expiry_period)) {
                    $expiryDate = \Carbon\Carbon::parse($value->course_expiry_period);
                    $today = \Carbon\Carbon::today();
                    $oneMonthBefore = $expiryDate->copy()->subMonth();

                    if ($today->gte($oneMonthBefore)) {
                    $showExpiryBadge = true;
                    }
                    }
                    @endphp

                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3" id="course_{{$value->course_id}}" @if($value->
                        expired_course_id)
                        data-expired-course-id="{{ $value->expired_course_id }}"
                        @endif>
                        <div class="card noShadow all_courses_courselist">
                            <div class="card-header">
                                @php $isWishlisted = in_array($value->course_id, $wishlistedCourseIds);@endphp
                                <span class="btn btn-outline-danger wishList-badge"
                                    title="{{$isWishlisted  ? 'Added to Wishlist' : 'Add to Wishlist ❤️'}}"
                                    id="wish_{{$value->course_id}}">
                                    <i class="{{$isWishlisted ? 'fa fa-heart':'fa fa-heart-o'}}" aria-hidden="true"
                                        id="wishHeart_{{$value->course_id}}"></i>
                                </span>
                                @php $id = Crypt::encrypt($value->course_id); @endphp
                                <a href="{{ route('elearningCourse', $id) }}">
                                    @php
                                    $imageUrl = config('setting.base_url') . 'uploads/course/126/' .
                                    $value->course_banner;
                                    @endphp
                                    @if(file_exists(public_path('uploads/course/126/' . $value->course_banner)))
                                    <img src="{{ $imageUrl }}" alt="Course Image" class="course_image">
                                    @else
                                    <img src="{{ asset('assets/images/Talentra.jpg') }}" alt="Fallback Image"
                                        class="course_image">
                                    @endif
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="card-title" title="{{$value->course_name}}">
                                    <h5>
                                        {{$value->course_name}}


                                    </h5>
                                    <h5>

                                        @if($showExpiryBadge)
                                        <a href="javascript:void(0);"
                                            onclick="highlightCopiedCourse({{ $value->course_id }})">
                                            <span class="blinking-warning">
                                                {{ \Carbon\Carbon::parse($value->course_expiry_period)->isPast() ? 'Certificate Expired' : 'Certificate Expiring Soon.Do the Re-Certification' }}
                                            </span>
                                        </a>
                                        @endif

                                    </h5>
                                </div>
                                <script>
                                function highlightCopiedCourse(originalCourseId) {
                                    // Find the course card with expired_course_id == originalCourseId
                                    const matchingCard = document.querySelector(
                                        `[data-expired-course-id='${originalCourseId}']`);

                                    if (matchingCard) {
                                        // Scroll into view and highlight
                                        matchingCard.scrollIntoView({
                                            behavior: 'smooth',
                                            block: 'center'
                                        });

                                        matchingCard.classList.add('highlight-new-course');

                                        // Remove highlight after 2 seconds
                                        setTimeout(() => {
                                            matchingCard.classList.remove('highlight-new-course');
                                        }, 2000);
                                    } else {
                                        Swal.fire({
                                            title: "Please Contact your supervisor",
                                            text: "The new or copied course is not yet created.",
                                            icon: "info"
                                        });
                                    }
                                }
                                </script>



                                <div class="card-text">
                                    <h6>
                                        {{$value->course_instructor}}
                                        <?php    if ($value->course_pay == 'paid') { ?>
                                        <span style="background-color: #1d33d3;"
                                            class="course_paid">{{$value->course_pay}}</span>
                                        <?php    } elseif ($value->course_pay == 'free') { ?>
                                        <span style="background-color: #0ecf26;"
                                            class="course_paid">{{$value->course_pay}}</span>
                                        <?php    } ?>
                                    </h6>


                                </div>
                                <div class="progress course_total_progress">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{isset($courseProgress[$value->course_id]) ? $courseProgress[$value->course_id]->course_progress : '0'}}%"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span
                                    class="text-uppercase">{{isset($courseProgress[$value->course_id]) ? $courseProgress[$value->course_id]->course_progress : '0'}}%
                                    completed</span>
                                <!-- <input type="hidden" class="courseStartPeriod" id="startPeriod_{{$value->course_id}}" value="{{$value->course_start_period}}">
                                                    <input type="hidden" class="courseEndPeriod" id="endPeriod_{{$value->course_id}}" value="{{$value->course_end_period}}">
                                                    <input type="hidden" class="coursePay" id="pay_{{$value->course_id}}" value="{{$value->course_pay}}">
                                                    <input type="hidden" class="courseDescription" id="description_{{$value->course_id}}" value="{{$value->course_description}}">
                                                    <input type="hidden" class="courseIntroduction" id="introduction_{{$value->course_id}}" value="{{$value->course_introduction}}">
                                                    <input type="hidden" name="courseTags" id="tags_{{$value->course_id}}" value="{{$value->course_tags}}" />
                                                    <input type="hidden" class="courseSkillsRequired" id="skills_required_{{$value->course_id}}" value="{{$value->course_skills_required}}">
                                                    <input type="hidden" class="courseGainSkills" id="gain_skills_{{$value->course_id}}" value="{{$value->course_gain_skills}}"> -->
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="d-flex flex-row justify-content-center allCoursePagination">
                    {!! $availableCourses->links() !!}
                </div>
                <!-- <div>
                    <p class="text-sm text-gray-700 leading-5">
                        Showing
                        <span class="font-medium">1</span>
                        to
                        <span class="font-medium">2</span>
                        of
                        <span class="font-medium">5</span>
                        results
                    </p>
                </div> -->
            </div>
            <input type="hidden" class="courseSearch" id="searchMessage" value="{{$search}}">
            <input type="hidden" class="courseSort" id="sortMessage" value="{{$sort}}">
            <input type="hidden" class="courseFilter" id="filterTagMessage" value="{{$tagFilter}}">
            <input type="hidden" class="courseFilter" id="filterProgressMessage" value="{{$progressFilter}}">
            <script>
            let courseListContainer = document.querySelector('.all_courses_courselist_container .row');
            let searchResultnone = document.querySelector('#searchResultnone');
            let isSearch = document.querySelector('#searchMessage');
            let isSorted = document.querySelector('#sortMessage');
            let sortOption = document.querySelector('.all_courses_sort_select');
            let courseSearchInput = document.querySelector('#courseSearch');
            let courseSearchButton = document.querySelector('#courseSearchButton');
            let allCoursesForm = document.querySelector('.all_courses_filter_block2');
            let sortInput = document.querySelector('.all_courses_sort_select');
            let pageLinks = document.querySelectorAll('a.page-link');
            let filters = document.querySelectorAll('.all_courses_filter_select');
            let isTagFiltered = document.querySelector('#filterTagMessage');
            let isProgressFiltered = document.querySelector('#filterProgressMessage');
            let resetButton = document.querySelector('.all_courses_reset_btn');
            let wishListBadges = document.querySelectorAll('.wishList-badge');

            if (isSearch.value == "false") {
                courseSearchInput.value = "";
            } else {
                courseSearchInput.value = isSearch.value;
            }
            sortOption.value = isSorted.value;
            filters[0].value = isTagFiltered.value;
            filters[1].value = isProgressFiltered.value;

            if (courseListContainer.innerText == "") {
                searchResultnone.style.display = "block";
            }

            function courseSearch(e) {
                e.preventDefault();
                let url = new URL(allCoursesForm.action);
                url.searchParams.set('sorted', sortOption.value);
                url.searchParams.set('tag', filters[0].value);
                url.searchParams.set('progress', filters[1].value);
                url.searchParams.set('q', courseSearchInput.value);
                allCoursesForm.action = url;
                allCoursesForm.submit();
            }

            function courseSort(e) {
                let url = new URL(allCoursesForm.action);
                url.searchParams.set('sorted', sortOption.value);
                url.searchParams.set('tag', filters[0].value);
                url.searchParams.set('progress', filters[1].value);
                url.searchParams.set('q', isSearch.value);
                allCoursesForm.action = url;
                allCoursesForm.submit();
            }

            function sortOrder(e) {
                e.preventDefault()
                let url = new URL(e.target.href);
                url.searchParams.set('sorted', isSorted.value);
                url.searchParams.set('tag', filters[0].value);
                url.searchParams.set('progress', filters[1].value);
                url.searchParams.set('q', isSearch.value);
                e.target.href = url;
                window.location = url;
            }

            function filterBy(e) {
                let url = new URL(allCoursesForm.action);
                url.searchParams.set('sorted', sortOption.value);
                url.searchParams.set('tag', filters[0].value);
                url.searchParams.set('progress', filters[1].value);
                url.searchParams.set('q', isSearch.value);
                allCoursesForm.action = url;
                allCoursesForm.submit();
                // alert(`http://localhost:60157/elearningAllCourses/filter?sorted=${isSorted.value}&tag=${e.target.value}`);
                // window.location = `http://localhost:60157/elearningAllCourses/filter?sorted=${isSorted.value}&tag=${e.target.value}`;
            }

            function courseReset(e) {
                window.location =
                    `{{ route('elearningAllCourses') }}?sorted=Recently Added&tag=false&progress=false&q=false`;
            }

            courseSearchInput.addEventListener("keypress", (e) => {
                if (e.key === "Enter") {
                    e.preventDefault();
                    courseSearchButton.click();
                }
            });
            courseSearchButton.addEventListener("click", courseSearch);

            sortInput.addEventListener("change", courseSort);

            for (const pageLink of pageLinks) {
                pageLink.addEventListener("click", sortOrder);
            }

            resetButton.addEventListener("click", courseReset);

            for (const filter of filters) {
                filter.addEventListener("change", filterBy);
            }

            // wishlist addition
            function addWishList(e) {
                let id = `${e.target.id}`.replace(/\D/g, "");
                Swal.fire({
                    title: "Are you sure,you want to proceed the wishlist?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('/addWishList') }}",
                            type: 'GET',
                            data: {
                                'id': id,
                                _token: '{{csrf_token()}}'
                            },
                            success: function(data) {
                                // $('#submitSuccess').modal('show');
                                console.log(data);
                                //alert(data);                                                                                                                  
                                if (data == "wishlist added") {
                                    swal.fire({
                                        title: "Success",
                                        text: "Wishlist Added Successfully",
                                        icon: "success",
                                    });
                                } else if (data == "already added") {
                                    swal.fire({
                                        title: "Success",
                                        text: "Wishlist Removed Successfully",
                                        icon: "success",
                                    });
                                } else {
                                    Swal.fire("Error!", "Failed to add to Wishlist.", "error");
                                }
                            }
                            // error: function(error) {
                            //     console.log('error; ' + eval(error));
                            // }
                        });
                    }
                })

            }
            for (let wishListBadge of wishListBadges) {
                wishListBadge.addEventListener('click', addWishList);
            }
            </script>
        </div>
    </section>
</div>

<!-- Filters Modal -->
<div class="modal fade" id="filters" tabindex="-1" aria-labelledby="filtersLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal_filters">
            <div class="modal-header filters_header">
                <h5 class="modal-title" id="filtersLabel">Filters</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 filters_body">
                <div class="d-flex flex-row flex-wrap justify-content-between all_courses_filter_container w-100 m-0">
                    <select class="form-control all_courses_sort_select w-50 mb-3" name="all_courses_sort_select">
                        <option value="Recently Added" selected>Recently Added</option>
                        <option value="Recently Enrolled">Recently Enrolled</option>
                        <option value="A to Z">A to Z</option>
                        <option value="Z to A">Z to A</option>
                    </select>
                    <select class="form-control all_courses_filter_select m-0 mb-3" name="all_courses_filter_select">
                        <option selected>Category</option>
                        <option value="Survey and Mapping">Survey and Mapping</option>
                        <option value="Land Registration">Land Registration</option>
                        <option value="Land Administration">Land Administration</option>
                        <option value="Valuation">Valuation</option>
                    </select>
                    <select class="form-control all_courses_filter_select w-50 m-0 mb-3"
                        name="all_courses_filter_select">
                        <option selected>Progress</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Completed">Completed</option>
                        <option value="Not Enrolled">Not Enrolled</option>
                    </select>
                    <button class="all_courses_reset_btn mx-auto mb-3" type="button" disabled>
                        <span>Reset</span>
                    </button>
                    <div class="all_courses_search_container w-100">
                        <form class="d-flex flex-row justify-content-center align-items-center" action="#" method="get">
                            <input type="search" class="form-control" placeholder="Search">
                            <button type="submit">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection