@extends('layouts.elearningmain')

@section('content')
<style>
    /* remove card bocy shadow */
    .noShadow .card-body {
        box-shadow: none !important;
    }

    .img-size {
        width: 25%;
        margin-bottom: 20px;
        margin-left: 20px;
    }

    .card {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        background-clip: border-box;
        border: none;

    }

    .courseClassHeader {
        border: none;
        background-color: #fff !important;
    }

    .courseIncludes {
        background-color: #fff !important;

    }

    .bgWhite {
        background-color: #fff !important;
    }

    .bg-f8312f {
        background-color: #f8312f !important;
    }

    .addToCart {
        width: 80%;
    }

    .wishList {
        width: 18%;
        -webkit-box-shadow: 0 1px 3px #ee9aa2;
        box-shadow: 0 1px 3px #ee9aa2;
    }

    .buyNow {
        width: 100%;
    }

    .buyNow:hover {
        color: #fff !important;
    }

    .coursePriceTag {
        content: '';
        position: relative;
        display: block;
        left: -40px;
        top: -10px;
        width: 50%;
        padding: 10px;
        background-color: #a435f0;
        color: #fff;
        font-size: 100%;
        font-weight: 600;
        letter-spacing: 0px;
        text-transform: uppercase;
        text-align: center;
        transform: rotate(0deg);
    }

    .coursePriceTag:before {
        content: "";
        width: 14px;
        height: 99%;
        position: absolute;
        background-color: #a435f0;
        left: 0px;
        top: -4.1px;
        transform: skewY(-30deg);
        opacity: 0.8;
    }

    .courseOverviewProgress {
        -webkit-box-shadow: 0 0.2rem 0.4rem rgb(0 0 0 / 6%) !important;
        box-shadow: 0 0.2rem 0.4rem rgb(0 0 0 / 6%) !important;
    }

    .tags {
        display: inline-block;
        padding: 0.5em 0.8em;
        font-size: 80%;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        border-radius: 0.25rem;
        transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        position: unset !important;
        margin-right: 0.25rem !important;
    }

    .card-body {
        background-color: #fff !important;
    }

    .card {
        background-color: #fff !important;
    }

    @media (min-width:575.96px) {
        .classOverview {
            width: 100%;
            position: relative;
        }

        .classOverviewContent {
            width: 100%;
            background-color: #f8f8f8 !important;
        }

        .classOverviewContentBody {
            padding-right: calc(31% + 20px) !important;
        }

        .tags {
            display: inline-block;
            padding: 0.5em 0.8em;
            font-size: 80%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            border-radius: 0.25rem;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            position: unset !important;
            margin-right: 0.25rem !important;
        }

        .classOverviewinfo {
            position: absolute;
            top: 20%;
            right: 3%;
            width: 28%;
            z-index: 3;
        }

        .willLearn {
            padding-right: calc(31% + 20px) !important;
        }

        .willLearn .card {
            background-color: #fff !important;
            min-height: 150px !important;
        }

        .willLearn .card-body {
            background-color: #fff !important;
            height: 100%;
        }

        .willLearn ul {
            line-height: 1.5em;
        }

        .courseGainSkils {
            list-style-position: inside;
            list-style: none;
            width: 50% !important;
        }

        .courseGainSkils::before {
            content: "\2713";
            color: #28a745;
            display: inline-block;
            padding-right: 20px;
            font-weight: 900;
            font-size: 120%;
            height: 14px;
            width: 14px;
        }

        .courseIncludes {
            background-color: #fff !important;
            border: 1px solid #d1d7dc;
            padding: 40px 20px;
        }

        .courseIncludesHeader {
            background-color: #fff !important;
            border: 0px !important;
        }

        .courseIncludesHeader .card-body {
            background-color: #fff !important;
        }

        .hoursOfVideos.card {
            background-color: #fff !important;
            height: 100% !important;
            border-radius: 5px !important;
            overflow: hidden;
            box-shadow: 0px 2px 8px -4px rgb(0 0 0 / 30%);
        }

        .hoursOfVideos .card-body {
            background-color: #fff !important;
        }

        .hoursOfVideos img {
            width: 15%;
            margin: 25px auto 50px 25px;
        }

        .courseClassesAndPrerequisites .card {
            background-color: #fff !important;
            min-height: 150px !important;
        }

        .courseClassesAndPrerequisites .card-body {
            background-color: #fff !important;
            height: 370px;
            overflow-y: scroll;
            margin-bottom: 30px;
        }

        .courseClassHeader {
            background-color: #fff !important;
            border: 0px !important;
            padding-top: 20px !important;
            padding-left: 25px !important;
        }

        .courseClassHolder {
            line-height: 25px;
            box-shadow: 0px 2px 4px -4px rgb(0 0 0 / 30%);
        }

        .courseClassNum {
            width: 25px;
            height: 25px;
        }

        .courseClassHolder:hover .courseClassNum {
            background-color: #a9dcb5 !important;
        }

        .courseSkillsRequired {
            list-style-position: inside;
            list-style: none;
        }

        .courseSkillsRequired::before {
            content: "\2713";
            color: #28a745;
            display: inline-block;
            padding-right: 20px;
            font-weight: 900;
            font-size: 120%;
            height: 14px;
            width: 14px;
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

    @media (min-width:320px) and (max-width:1024px) {
        .courseClassNum {
            padding: 1px 7px !important;
            margin-top: 1px !important;
        }

        .coursePriceTag {
            width: 58% !important;
        }

        .img_shadow {

            border: 1px solid rgba(0, 0, 0, .125);
            box-shadow: 0px 2px 8px -4px rgb(0 0 0 / 30%);

        }
    }

    @media(min-width:320px) and (max-width:575px) {

        .line-align {
            padding: 20px 20px 0px 33px;
        }


    }


    @media(min-width:576px) and (max-width:767px) {
        .classOverviewinfo {
            position: unset;
            width: 100%;
        }

        .courseGainSkils {
            width: 100% !important;
        }

        .classOverviewContentBody {
            padding-right: 25px !important;
        }

        .main-content {
            width: 80% !important;
            margin-left: 10%;
        }

        .willLearn {
            padding-right: 0px !important;
        }

    }

    .razorpay-payment-button {
        display: none !important;

    }

    .card-title {
        margin-bottom: .75rem;
        text-transform: capitalize;
    }

    .course_completion {
        background: limegreen;
        color: white;
        border-radius: 20px !important;
        border-color: transparent !important;
    }

    .rating-color {
        color: #b4690e !important;
    }
</style>

<div class="main-content">
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

    <section class="section">
        <div class="section-body mt-1">
            <div class="row mb-3">
                @php $count = 1;@endphp
                @foreach($courseDetails as $courseDetail)
                <div class="classOverview">
                    <div class="col" style="display:flex;">
                        <a href="/elearning/allCourses?sorted=Recently Added&tag=false&progress=false&q=false" class="btn btn-primary">Back</a>
                    </div>
                    <br>
                    <h5 class="col-md-7 d-flex justify-content-center over">Course Introduction</h5>
                    <div class="card noShadow classOverviewContent">
                        <div class="card-body bgWhite classOverviewContentBody">
                            <h3 class="card-title">
                                {{$courseDetail->course_name}}
                            </h3>
                            <h6 class="card-subtitle mb-2 text-muted">
                                {{$courseDetail->course_instructor}}
                            </h6>
                            <p class="card-text">
                                {{$courseDetail->course_description}}
                            </p>

                            <p class="card-text d-flex flex-row justify-content-start">
                                <!-- <span class="course_rating">
                                    4.5
                                </span> -->
                                <span class="mx-2 course_rating_list ratingsset{{$count}}">
                                    @php
                                    $ratings = !empty($ratings[0]->rating_point) ? $ratings[0]->rating_point : 0;
                                    $averageRating = $ratings * 2;
                                    $actual_rating = intval($averageRating / 2);


                                    @endphp
                                    @for($i=1;$i<=5;$i++) @if($i<=$actual_rating) <i class="fa fa-star rating-color"></i>
                                        @else
                                        <i class="fa fa-star unfilled-star"></i>
                                        @endif
                                        @endfor
                                        @if($averageRating%2 !=0)
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
                                @php $count++ @endphp
                            </p>
                            <input type="hidden" name="courseTags" class="courseTags" id="tags_{{$courseDetail->course_id}}" value="{{$courseDetail->course_tags}}" />
                            <p class="card-text courseTagsHolder">

                            </p>
                            <input type="hidden" class="courseStartPeriod" id="startPeriod_{{$courseDetail->course_id}}" value="{{$courseDetail->course_start_period}}">
                            <input type="hidden" class="courseEndPeriod" id="endPeriod_{{$courseDetail->course_id}}" value="{{$courseDetail->course_end_period}}">
                            <p class="card-text courseDateHolder">

                            </p>
                        </div>
                    </div>
                    <div class="card noShadow classOverviewinfo mt-4 mt-md-0">


                        <video class="mt-2" height="200px" controls poster="http://localhost:60159/uploads/course/126/{{$courseDetail->course_banner}}" preload="metadata" width="100%">
                            <source src="http://localhost:60159/uploads/course/126/{{$courseDetail->course_introduction}}" type="video/mp4">
                            Download the
                            <a href="http://localhost:60159/uploads/course/126/{{$courseDetail->course_introduction}}">MP4</a>
                            video.
                        </video>
                        <div class="card-body bgWhite">
                            @if($enrolled == "False")

                            <?php if ($courseDetail->course_pay == "free") { ?>
                                <h5 class="card-title coursePriceTag" style="display:none;">

                                </h5>
                            <?php } else { ?>

                                <h5 class="card-title coursePriceTag">
                                    {{$courseDetail->course_price}} UGX
                                </h5>
                            <?php } ?>
                            @if($courseDetail->course_pay == "paid")
                            <div class="d-flex flex-row justify-content-between mb-2">
                                @php $id=Crypt::encrypt($courseDetail->course_id);
                                $course_id=$courseDetail->course_id;
                                @endphp
                                <?php
                                $baseUrl = url('/');
                                $filePath = app_path('Http/Controllers/basicfunctionController.php');
                                include_once $filePath;

                                $common_function = new common_function;
                                $is_added = $common_function->add_to_cart($course_id);

                                ?>

                                @if($is_added ==0)
                                <a onclick="cart_store('{{$courseDetail->course_id}}');" class="btn btn-success addToCart">
                                    Add to Cart
                                </a>
                                <a onclick="move_wish(event,'{{ $courseDetail->course_id}}');" class="btn btn-outline-danger wishList d-flex justify-content-center align-items-center" title="Wishlist" id="move_btn">
                                    <i class="fa fa-heart" aria-hidden="true" style="pointer-events: none;"></i>
                                </a>
                                @elseif($is_added ==1 )
                                <a class="btn btn-success addToCart" href="{{ route('elearningCart',$id) }}">
                                    Go to Cart
                                </a>
                                <!-- <a href="#" class="btn btn-outline-danger wishList d-flex justify-content-center align-items-center">
                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                </a> -->
                                @endif


                            </div>
                            @endif
                            <?php if ($courseDetail->course_pay == "paid") { ?>
                                <?php
                                $baseUrl = url('/');
                                $filePath = app_path('Http/Controllers/basicfunctionController.php');
                                include_once $filePath;

                                $common_function = new common_function;
                                $is_added = $common_function->buy_to_take($courseDetail->course_id);

                                ?>

                                <form action="{{ route('razorpaycoursepurchase')}}" method="post">
                                    @csrf
                                    <input type="hidden" id="course_id" name="course_id" value="{{$courseDetail->course_id}}">
                                    @if($is_added ==0)
                                    <button class="btn btn-info buyNow">
                                        Buy Now
                                    </button>
                                    <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="{{ config('setting.RAZORPAY_KEY') }}" data-amount="{{$courseDetail->course_price*100}}" data-button='false' data-name="TALENTRA Payment" data-description="Payment" data-prefill.name="name" data-prefill.email="email" data-theme.color="#ff7529">
                                    </script>
                                    @else
                                    @php $id=Crypt::encrypt($courseDetail->course_id); @endphp
                                    <a href="{{ route('elearningCourse/class',$id) }}" class="btn btn-info buyNow">
                                        Take Now
                                    </a>
                                    <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="{{ config('setting.RAZORPAY_KEY') }}" data-amount="{{$courseDetail->course_price*100}}" data-button='false' data-name="TALENTRA Payment" data-description="Payment" data-prefill.name="name" data-prefill.email="email" data-theme.color="#ff7529">
                                    </script>
                                    <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                                    @endif
                                </form>

                            <?php } else {  ?>
                                @php $id=Crypt::encrypt($courseDetail->course_id); @endphp
                                <a href="{{ route('elearningCourse/class',$id) }}" class="btn btn-info buyNow">
                                    Take Now
                                </a>




                            <?php } ?>
                            @endif

                            @if($enrolled == "True")
                            <div class="progress mb-4 courseOverviewProgress">
                                <div class="progress-bar bg-info" role="progressbar" style="width: {{isset($courseProgress[$courseDetail->course_id]) ? $courseProgress[$courseDetail->course_id]->course_progress : '0'}}% ;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{isset($courseProgress[$courseDetail->course_id]) ? $courseProgress[$courseDetail->course_id]->course_progress : '0'}}%</div>
                            </div>

                            <div class="d-flex flex-row justify-content-center mb-2">
                                @php $id=Crypt::encrypt($courseDetail->course_id); @endphp
                                @if($isEnrolled[0]->status != 2)
                                <a href="{{ route('elearningCourse/class',$id) }}" class="btn btn-success addToCart">
                                    Continue Course
                                </a>
                                @elseif($isEnrolled[0]->status == 2)

                                <a href="{{ route('elearningCourse/class',$id) }}" class="btn btn-success addToCart col-md-12 course_completion">
                                    Completed
                                </a>


                                @endif
                            </div>
                            @endif

                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="row mb-3 willLearn">
                <div class="card noShadow w-100">
                    <div class="card-body">
                        <h5 class="card-title mb-4">What You will Learn</h5>


                        @foreach($courseDetails as $courseDetail)
                        <input type="hidden" id="courseGainSkils" value="{{$courseDetail->course_gain_skills}}">
                        <ul class="card-text d-flex flex-row justify-content-between align-items-center flex-wrap">
                            <!-- Gain skills will be added here -->
                        </ul>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row courseIncludes">
                <div class="col-12 mb-3 p-0">
                    <div class="card noShadow courseIncludesHeader">
                        <div class="card-body p-0">
                            <div class="card-title">
                                <h5 class="line-align">
                                    This Course Includes
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="overflow-y: scroll;" class="col-12 col-sm-6 col-md-4 align-items-stretch px-2 px-md-4 pb-2 pb-md-0">


                    @php $audio_exist=$audio_exist==0 ? 'd-none' :''; @endphp
                    @php $video_exist=$video_exist==0 ? 'd-none' :''; @endphp
                    @php $pdf_exist=$pdf_exist==0 ? 'd-none' :''; @endphp

                    <div class="card noShadow hoursOfVideos img_shadow ">

                        <span class="{{$audio_exist}}">
                            <img src="{{asset('asset/image/play.png')}}" class="card-img-top img-size" alt="play-icon">
                        </span>
                        <span class="$video_exist">
                            <img src="../../uploads/class/126/mp4.png" class="card-img-top img-size" alt="play-icon">
                        </span>
                        <span class="$pdf_exist">

                            <img src="../../uploads/class/126/pdf.png" class="card-img-top img-size" alt="play-icon">
                        </span>
                    </div>

                </div>
                <div class="col-12 col-sm-6 col-md-4 align-items-stretch px-2 px-md-4 pb-2 pb-md-0">
                    <div class="card noShadow hoursOfVideos img_shadow">
                        <img src="{{asset('asset/image/play.png')}}" class="card-img-top img-size" alt="play-icon">
                        <div class="card-body">
                            <h6 class="card-title" id="totalHours">
                                <!-- total duration  -->
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4 align-items-stretch px-2 px-md-4 pb-2 pb-md-0">
                    <div class="card noShadow hoursOfVideos img_shadow">
                        <img src="{{asset('asset/image/resource.png')}}" class="card-img-top img-size" alt="play-icon">
                        <div class="card-body">
                            <h6 class="card-title">
                                {{$counts}} resources
                            </h6>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4 align-items-stretch px-2 px-md-4 pb-2 pb-md-0">

                    @foreach($courseDetails as $courseDetail)
                    @if($courseDetail->course_certificate=='1')

                    <div class="card noShadow hoursOfVideos img_shadow">
                        <img src="{{asset('asset/image/completion-certificate.png')}}" class="card-img-top img-size mt-2 mt-md-4" alt="play-icon">
                        <div class="card-body">
                            <h6 class="card-title">
                                Certificate of completion
                            </h6>
                        </div>
                    </div>
                    @elseif($courseDetail->course_certificate=='2')
                    <div class="card noShadow hoursOfVideos img_shadow" style="display: none;">
                        <img src="{{asset('asset/image/completion-certificate.png')}}" class="card-img-top img-size mt-2 mt-md-4" alt="play-icon">
                        <div class="card-body">
                            <h6 class="card-title">
                                Certificate of completion
                            </h6>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>

            <div class="row mt-3 courseClassesAndPrerequisites">
                <div class="col-12 col-md-6 p-0 pr-md-4">
                    <div class="card noShadow">
                        <h5 class="card-header courseClassHeader">
                            Course Contents
                        </h5>
                        <div class="card-body">
                            @foreach($courseDetails as $courseDetail)
                            @php
                            $classIds = explode(',', $courseDetail->course_classes);
                            $classes = DB::table('elearning_classes')->whereIn('class_id', $classIds)->get();
                            @endphp
                            <input type="hidden" id="availableClasses" value="class_{{$courseDetail->course_classes}}">
                            <input type="hidden" id="classOrder" value="class_{{$classOrder}}">
                            @foreach($classes as $class)
                            <div class="list-group-item list-group-item-action d-flex flex-row align=items-center rounded-pill mb-3  courseClassHolder">
                                <span class="d-flex flex-row justify-content-center align-items-center bg-light p-1 my-auto mr-2 rounded-circle  mb-sm-1 courseClassNum">
                                    {{$loop->iteration}}
                                </span>
                                <span>
                                    {{$class->class_name}}
                                </span>
                                <input type="hidden" name="courseDuration" class="courseDuration" id="duration_{{$loop->iteration}}" value="{{$class->class_duration}}">
                            </div>
                            @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 p-0 mt-3 mt-md-0">
                    <div class="card noShadow w-100 card-align">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Prerequisites</h5>
                            @foreach($courseDetails as $courseDetail)
                            <input type="hidden" id="courseSkillsRequired" value="{{$courseDetail->course_skills_required}}">
                            <ul class="card-text d-flex flex-column justify-content-center align-items-between">
                                <!-- Skills Required will be added here -->
                            </ul>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>

<script>
    function cart_store(course_id) {
        //alert(course_id);

        //var reply_details = document.querySelector('#Question_reply').value;

        $.ajax({
            url: "{{ url('/elearningCart/store') }}",
            type: 'post',
            data: {
                'course_id': course_id,
                _token: '{{csrf_token()}}'
            },
            success: function(data) {
                console.log(data);
                if (data != 0) {
                    Swal.fire("Success!", "Cart Added Successfully!", "success").then((result) => {

                        location.reload();

                    })
                } else {
                    Swal.fire("Error!", "Failed to add to Cart.", "error");
                }



            }
        });





    }
    // appending tags
    let courseTags = document.querySelector('.courseTags');
    let courseTagsHolder = document.querySelector('.courseTagsHolder');
    let tags = courseTags.value;
    const tagList = tags.split(", ");
    for (let tag of tagList) {
        let span = document.createElement('span');
        span.classList.add('badge-success');
        span.classList.add('tags');
        span.classList.add('mr-2');
        span.innerHTML = `${tag}`;
        courseTagsHolder.appendChild(span);
    }
    // appending course period
    let courseStartPeriod = document.querySelector('.courseStartPeriod');
    let courseEndPeriod = document.querySelector('.courseEndPeriod');
    let courseDateHolder = document.querySelector('.courseDateHolder');
    if (courseStartPeriod.value != "" && courseEndPeriod.value != "") {
        const [startDateValue, startTimeValue] = courseStartPeriod.value.split(' ');
        const [endDateValue, endTimeValue] = courseEndPeriod.value.split(' ');
        let Date = document.createElement('span');
        Date.innerText = `${startDateValue} - ${endDateValue}`;
        courseDateHolder.appendChild(Date);
    }
    // appending Gain Skills
    let courseGainSkils = document.querySelector('#courseGainSkils');
    let courseGainSkilsContainer = document.querySelector('#courseGainSkils + ul');
    let gainSkills = courseGainSkils.value;
    const gainSkillsList = gainSkills.split(", ");
    for (let gainskill of gainSkillsList) {
        let gainLi = document.createElement('li');
        gainLi.innerHTML = `${gainskill}`;
        gainLi.classList.add('courseGainSkils');
        courseGainSkilsContainer.appendChild(gainLi);
    }
    // appending Skills Required
    let courseSkillsRequired = document.querySelector('#courseSkillsRequired');
    let courseSkillsRequiredContainer = document.querySelector('#courseSkillsRequired + ul');
    let SkillsRequired = courseSkillsRequired.value;
    const SkillsRequiredList = SkillsRequired.split(", ");
    for (let SkillRequired of SkillsRequiredList) {
        let requiredLi = document.createElement('li');
        requiredLi.innerHTML = `${SkillRequired}`;
        requiredLi.classList.add('mb-2');
        requiredLi.classList.add('courseSkillsRequired');
        courseSkillsRequiredContainer.appendChild(requiredLi);
    }
    //addToCart function
    // let addToCartButton = document.querySelector('.addToCart');
    // function addTOCart(e){
    //     let url = "";
    // }
    // addToCartButton.addEventListener("click", addTOCart)

    // window.URL = window.URL || window.webkitURL;

    // function getDuration(control) {
    //     var video = document.createElement('video');
    //     window.URL.revokeObjectURL(video.src);
    //     alert("Duration : " + video.duration + " seconds");
    // }

    // Hours calculation
    function getExtension(url) {
        var file = url.split('.');
        return file[file.length - 1];
    }

    function secondsToHms(second) {
        d = Number(second);
        var h = Math.floor(second / 3600);
        var m = Math.floor(second % 3600 / 60);
        var s = Math.floor(second % 3600 % 60);

        var hDisplay = h > 0 ? h + (h == 1 ? " hour " : " hours ") : "";
        var mDisplay = m > 0 ? m + (m == 1 ? " minute " : " minutes ") : "";
        var sDisplay = s > 0 ? s + (s == 1 ? " second" : " seconds") : "";
        return hDisplay + mDisplay + sDisplay;
    }

    function convertToSeconds(hours, minutes, seconds) {
        return Number(hours) * 60 * 60 + Number(minutes) * 60 + Number(seconds);
    }

    let courseDurations = document.querySelectorAll('.courseDuration');
    let totalHours = document.querySelector('#totalHours');
    let second = 0;
    for (let courseDuration of courseDurations) {
        duration = courseDuration.value;
        console.log(duration);
        const [hours, minutes, seconds] = duration.split(':');
        let time = convertToSeconds(hours, minutes, seconds);
        second = second + time;
    }
    let totalDuration = secondsToHms(second);
    document.querySelector('#totalHours').innerHTML = totalDuration;
</script>
<script>
    function move_wish(e, id) {
        if (e.target.id == "move_btn") {
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
                        error: function() {
                            alert('Something went wrong');
                        },

                        success: function(data) {
                            console.log(data);
                            if (result.value) {
                                Swal.fire("Success!", "Done!", "success").then((result) => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire("Error!", "Failed to add to Wishlist.", "error");
                            }
                        }
                    });
                }
            });
        }
    }
</script>
@endsection