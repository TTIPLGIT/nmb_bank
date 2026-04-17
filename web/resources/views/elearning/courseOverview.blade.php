@extends('layouts.elearningmain')

@section('content')
<style>
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
    --danger-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
}

/* Modern Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background: #f8fafc;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

/* Modern Card Styles */
.modern-card {
    background: white;
    border-radius: 24px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.modern-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
}

/* Hero Section */
.course-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 32px;
    padding: 50px;
    position: relative;
    overflow: hidden;
    margin-bottom: 40px;
}

.course-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 1%, transparent 1%);
    background-size: 50px 50px;
    animation: shimmer 20s linear infinite;
}

@keyframes shimmer {
    0% {
        transform: translate(0, 0);
    }

    100% {
        transform: translate(50px, 50px);
    }
}

/* Stats Cards */
.stat-card {
    background: white;
    border-radius: 20px;
    padding: 25px;
    text-align: center;
    transition: all 0.3s ease;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
}

.stat-icon {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 28px;
    background: linear-gradient(135deg, #667eea20 0%, #764ba220 100%);
}

/* Course Content Items */
.content-item {
    background: #f8fafc;
    border-radius: 16px;
    padding: 16px 20px;
    margin-bottom: 12px;
    transition: all 0.3s ease;
    cursor: pointer;
    border: 1px solid #e2e8f0;
}

.content-item:hover {
    background: white;
    transform: translateX(8px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    border-color: #667eea;
}

.content-number {
    width: 36px;
    height: 36px;
    background: var(--primary-gradient);
    color: white;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin-right: 15px;
    font-size: 14px;
}

/* Price Card */
.price-card {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    border-radius: 24px;
    padding: 30px;
    position: sticky;
    top: 20px;
    text-align: center;
}

.price-tag {
    font-size: 48px;
    font-weight: 800;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 10px;
}

/* Modern Buttons */
.btn-modern {
    padding: 12px 24px;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn-primary-modern {
    background: var(--primary-gradient);
    color: white;
}

.btn-primary-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
}

.btn-outline-modern {
    background: transparent;
    border: 2px solid #667eea;
    color: #667eea;
}

.btn-outline-modern:hover {
    background: var(--primary-gradient);
    color: white;
    border-color: transparent;
}

/* Tags */
.tag-modern {
    display: inline-block;
    padding: 6px 16px;
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    color: #4b5563;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 500;
    margin-right: 8px;
    margin-bottom: 8px;
    transition: all 0.3s ease;
}

.tag-modern:hover {
    background: var(--primary-gradient);
    color: white;
    transform: translateY(-2px);
}

/* Prerequisites */
.prereq-item {
    padding: 12px 0;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: all 0.3s ease;
}

.prereq-item:hover {
    transform: translateX(5px);
    color: #667eea;
}

.prereq-icon {
    width: 28px;
    height: 28px;
    background: var(--success-gradient);
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 12px;
}

/* Progress Bar */
.progress-modern {
    height: 8px;
    border-radius: 10px;
    background: #e2e8f0;
    overflow: hidden;
}

.progress-modern-bar {
    height: 100%;
    background: var(--success-gradient);
    border-radius: 10px;
    transition: width 0.5s ease;
}

/* Rating Stars */
.rating-stars {
    color: #fbbf24;
    font-size: 16px;
}

/* Alert */
.alert-modern {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    border: none;
    border-radius: 16px;
    padding: 20px;
    color: #991b1b;
    font-weight: 500;
    margin-bottom: 30px;
}

/* Responsive */
@media (max-width: 768px) {
    .course-hero {
        padding: 30px;
    }

    .price-card {
        position: relative;
        margin-top: 30px;
    }

    .stat-card {
        margin-bottom: 20px;
    }

    .content-item {
        padding: 12px 16px;
    }
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fadeInUp {
    animation: fadeInUp 0.6s ease forwards;
}

/* Course Includes Section */
.course-includes-modern {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    border-radius: 32px;
    padding: 40px;
    margin: 40px 0;
}

/* Badge Styles */
.badge-modern {
    padding: 6px 12px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 500;
}

.badge-free {
    background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
    color: #064e3b;
}
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

@php
use Carbon\Carbon;

$expiryMessage = null;
if (!empty($courseDetails[0]->expiry_type) && !empty($courseDetails[0]->expiry_input)) {
if ($courseDetails[0]->expiry_type === 'month') {
$expiryDate = Carbon::now()->addMonths($courseDetails[0]->expiry_input);
$daysLeft = Carbon::now()->diffInDays($expiryDate, false);
if ($daysLeft <= 30 && $daysLeft>= 0) {
    $expiryMessage = "⚠️ Your course will expire on {$expiryDate->format('d M Y')} (in {$daysLeft} days).";
    }
    }
    }
    @endphp

    <div class="main-content">
        @if (session('success'))
        <input type="hidden" name="session_data" id="session_data" class="session_data"
            value="{{ session('success') }}">
        <script>
        window.onload = function() {
            var message = $('#session_data').val();
            swal({
                title: "Success",
                text: message,
                type: "success"
            });
        }
        </script>
        @elseif(session('error'))
        <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
        <script>
        window.onload = function() {
            var message = $('#session_data1').val();
            swal({
                title: "Info",
                text: message,
                type: "info"
            });
        }
        </script>
        @endif

        <section class="section">
            <div class="section-body mt-1">
                @if(!empty($expiryMessage))
                <div class="alert-modern animate-fadeInUp">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $expiryMessage }}
                </div>
                @endif

                @foreach($courseDetails as $courseDetail)
                <!-- Hero Section -->
                <div class="col" style="display:flex;">

                    <a href="/elearning/allCourses?sorted=Recently+Added&tag=false&progress=false&q=false&course_id={{ $courseDetail->course_id }}"
                        class="btn btn-primary">Back</a>


                </div>
                </br>
                <div class="course-hero animate-fadeInUp">
                    <div class="row align-items-center">
                        <div class="col-lg-7 mb-4 mb-lg-0">

                            <h1 class="text-white mb-3" style="font-size: 2.5rem; font-weight: 800;">
                                {{$courseDetail->course_name}}
                            </h1>
                            <p class="text-white-50 mb-3" style="font-size: 1.1rem;">
                                <i class="bi bi-person-circle me-2"></i>by {{$courseDetail->course_instructor}}
                            </p>
                            <div class="d-flex align-items-center gap-3 mb-3 flex-wrap">
                                <div class="rating-stars">
                                    @php
                                    $ratings = !empty($ratings[0]->rating_point) ? $ratings[0]->rating_point : 0;
                                    $averageRating = $ratings * 2;
                                    $actual_rating = intval($averageRating / 2);
                                    @endphp
                                    @for($i=1;$i<=5;$i++) @if($i<=$actual_rating) <i class="bi bi-star-fill"></i>
                                        @elseif($i == $actual_rating + 1 && $averageRating % 2 != 0)
                                        <i class="bi bi-star-half"></i>
                                        @else
                                        <i class="bi bi-star"></i>
                                        @endif
                                        @endfor
                                        <span class="text-white ms-2">{{ $ratings }} ({{ $ratings_count ?? 0 }}
                                            ratings)</span>
                                </div>
                                @if($courseDetail->course_pay == "free")
                                <span class="badge-modern badge-free">
                                    <i class="bi bi-gift-fill me-1"></i>Free Course
                                </span>
                                @endif
                            </div>
                            <p class="text-white-50 mb-0" style="font-size: 1rem; line-height: 1.6;">
                                {{$courseDetail->course_description}}
                            </p>
                            <div class="mt-4" id="courseTagsHolder"></div>
                        </div>
                        <div class="col-lg-5 text-center">
                            @php
                            $file = $courseDetail->course_introduction;
                            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                            $fileUrl = url('uploads/course/126/' . $file);
                            @endphp

                            @if($extension === 'mp4')
                            <div class="position-relative">
                                <video class="rounded-4 shadow-lg" height="250" controls width="100%"
                                    style="border-radius: 20px;">
                                    <source src="{{ $fileUrl }}" type="video/mp4">
                                </video>
                            </div>
                            @elseif(in_array($extension, ['png','jpg','jpeg','gif','webp']))
                            <img src="{{ $fileUrl }}" alt="Course Image" class="rounded-4 shadow-lg"
                                style="width:100%; max-height:280px; object-fit:cover; border-radius: 20px;">
                            @elseif($extension === 'pdf')
                            <object data="{{ $fileUrl }}#toolbar=0" type="application/pdf" width="100%" height="280px"
                                style="border-radius: 20px;">
                                <p>PDF preview not available. <a href="{{ $fileUrl }}">Download PDF</a></p>
                            </object>
                            @endif
                        </div>
                    </div>
                </div>



                <!-- What You'll Learn Section -->
                <div class="modern-card mb-4 animate-fadeInUp">
                    <div class="card-body p-4">
                        <h3 class="mb-4 fw-bold">
                            <i class="bi bi-lightbulb-fill text-warning me-2"></i>
                            What You'll Learn
                        </h3>
                        <input type="hidden" id="courseGainSkils" value="{{$courseDetail->course_gain_skills}}">
                        <div class="row" id="gainSkillsContainer"></div>
                    </div>
                </div>

                <!-- Course Includes Section -->
                <div class="course-includes-modern animate-fadeInUp">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <h2 class="fw-bold mb-2">
                                <i class="bi bi-card-checklist me-2"></i>
                                Course Includes
                            </h2>
                            <p class="text-muted">Everything you need to succeed</p>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="text-center">
                                <div class="stat-icon mx-auto mb-3">
                                    <i class="bi bi-mic-fill fs-2"></i>
                                </div>
                                <h6 class="fw-bold">Audio Lessons</h6>
                                <p class="small text-muted">Learn on the go</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="text-center">
                                <div class="stat-icon mx-auto mb-3">
                                    <i class="bi bi-play-circle-fill fs-2"></i>
                                </div>
                                <h6 class="fw-bold">Video Content</h6>
                                <p class="small text-muted">HD quality videos</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="text-center">
                                <div class="stat-icon mx-auto mb-3">
                                    <i class="bi bi-file-earmark-pdf-fill fs-2"></i>
                                </div>
                                <h6 class="fw-bold">PDF Resources</h6>
                                <p class="small text-muted">Downloadable materials</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="text-center">
                                <div class="stat-icon mx-auto mb-3">
                                    <i class="bi bi-award-fill fs-2"></i>
                                </div>
                                <h6 class="fw-bold">Certificate</h6>
                                <p class="small text-muted">Upon completion</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Course Content and Sidebar -->
                <div class="row mb-4">
                    <div class="col-lg-8 mb-4 mb-lg-0">
                        <div class="modern-card">
                            <div class="card-body p-4">
                                <h3 class="mb-4 fw-bold">
                                    <i class="bi bi-journal-bookmark-fill me-2"></i>
                                    Course Contents
                                </h3>
                                <div id="courseContentsContainer"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <!-- Price Card -->
                        <div class="price-card mb-4 animate-fadeInUp">
                            @if($enrolled == "False")
                            @if($courseDetail->course_pay == "free")
                            <div class="price-tag">Free</div>
                            <p class="text-muted mb-3">Complete access at no cost</p>
                            @else
                            <div class="price-tag">{{ number_format($courseDetail->course_price) }} UGX</div>
                            <p class="text-muted mb-3">One-time payment • Lifetime access</p>
                            @endif

                            @if($courseDetail->course_pay == "paid")
                            @php
                            $id = Crypt::encrypt($courseDetail->course_id);
                            $baseUrl = url('/');
                            $filePath = app_path('Http/Controllers/basicfunctionController.php');
                            include_once $filePath;
                            $common_function = new common_function;
                            $is_added = $common_function->add_to_cart($courseDetail->course_id);
                            @endphp

                            <div class="d-grid gap-2 mb-3">
                                @if($is_added == 0)
                                <button onclick="cart_store('{{$courseDetail->course_id}}');"
                                    class="btn btn-primary-modern btn-modern">
                                    <i class="bi bi-cart-plus me-2"></i> Add to Cart
                                </button>
                                <button onclick="move_wish(event,'{{ $courseDetail->course_id}}');"
                                    class="btn btn-outline-modern btn-modern" id="move_btn">
                                    <i class="bi bi-heart me-2"></i> Add to Wishlist
                                </button>
                                @elseif($is_added == 1)
                                <a href="{{ route('elearningCart',$id) }}" class="btn btn-primary-modern btn-modern">
                                    <i class="bi bi-cart-check me-2"></i> Go to Cart
                                </a>
                                @endif
                            </div>

                            @php $is_bought = $common_function->buy_to_take($courseDetail->course_id); @endphp
                            <form action="{{ route('razorpaycoursepurchase')}}" method="post">
                                @csrf
                                <input type="hidden" name="course_id" value="{{$courseDetail->course_id}}">
                                @if($is_bought == 0)
                                <button class="btn btn-primary-modern btn-modern w-100">
                                    <i class="bi bi-lock me-2"></i> Buy Now
                                </button>
                                @endif
                            </form>
                            @else
                            @php $id = Crypt::encrypt($courseDetail->course_id); @endphp
                            <a href="{{ route('elearningCourse/class',$id) }}"
                                class="btn btn-primary-modern btn-modern w-100">
                                <i class="bi bi-play-circle me-2"></i> Start Learning Now
                            </a>
                            @endif
                            @else
                            @php $id = Crypt::encrypt($courseDetail->course_id); @endphp
                            @if($isEnrolled[0]->status != 2)
                            <a href="{{ route('elearningCourse/class',$id) }}"
                                class="btn btn-primary-modern btn-modern w-100">
                                <i class="bi bi-arrow-repeat me-2"></i> Continue Learning
                            </a>
                            @elseif($isEnrolled[0]->status == 2)
                            <!-- <button href="{{ route('elearningCourse/class',$id) }}" class="btn btn-success w-100"
                                style="border-radius: 50px; padding: 12px;">
                                <i class="bi bi-check-circle-fill me-2"></i> Course Completed! 🎉
                            </button> -->
                            <a href="{{ route('elearningCourse/class',$id) }}"
                                class="btn btn-primary-modern btn-modern w-100">
                                <i class="bi bi-arrow-repeat me-2"></i> Course Completed!
                            </a>
                            @endif

                            @if(isset($courseProgress[$courseDetail->course_id]))
                            <div class="mt-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <small class="fw-bold">Your Progress</small>
                                    <small
                                        class="fw-bold text-primary">{{$courseProgress[$courseDetail->course_id]->course_progress}}%</small>
                                </div>
                                <div class="progress-modern">
                                    <div class="progress-modern-bar"
                                        style="width: {{$courseProgress[$courseDetail->course_id]->course_progress}}%">
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endif
                        </div>

                        <!-- Prerequisites -->
                        <div class="modern-card">
                            <div class="card-body p-4">
                                <h5 class="mb-3 fw-bold">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    Prerequisites
                                </h5>
                                <input type="hidden" id="courseSkillsRequired"
                                    value="{{$courseDetail->course_skills_required}}">
                                <div id="prerequisitesContainer"></div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    $(document).ready(function() {
        // Course Tags
        var courseTags = document.querySelector('.courseTags');
        if (courseTags && courseTags.value) {
            var tags = courseTags.value;
            var tagList = tags.split(", ");
            var tagsHtml = '';
            for (var i = 0; i < tagList.length; i++) {
                tagsHtml += '<span class="tag-modern">#' + tagList[i] + '</span>';
            }
            $('#courseTagsHolder').html(tagsHtml);
        }

        // Gain Skills
        var courseGainSkils = document.querySelector('#courseGainSkils');
        if (courseGainSkils && courseGainSkils.value) {
            var gainSkills = courseGainSkils.value;
            var gainSkillsList = gainSkills.split(", ");
            var skillsHtml = '';
            for (var i = 0; i < gainSkillsList.length; i++) {
                if (gainSkillsList[i].trim()) {
                    skillsHtml += `
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill text-success me-2 fs-5"></i>
                            <span class="fw-500">${gainSkillsList[i]}</span>
                        </div>
                    </div>
                `;
                }
            }
            $('#gainSkillsContainer').html(skillsHtml);
        }

        // Prerequisites
        var courseSkillsRequired = document.querySelector('#courseSkillsRequired');
        if (courseSkillsRequired && courseSkillsRequired.value) {
            var SkillsRequired = courseSkillsRequired.value;
            var SkillsRequiredList = SkillsRequired.split(", ");
            var prereqHtml = '';
            for (var i = 0; i < SkillsRequiredList.length; i++) {
                if (SkillsRequiredList[i].trim()) {
                    prereqHtml += `
                    <div class="prereq-item">
                        <div class="prereq-icon">
                            <i class="bi bi-check"></i>
                        </div>
                        <span>${SkillsRequiredList[i]}</span>
                    </div>
                `;
                }
            }
            $('#prerequisitesContainer').html(prereqHtml);
        }

        // Duration Calculation
        function secondsToHms(second) {
            var h = Math.floor(second / 3600);
            var m = Math.floor(second % 3600 / 60);

            var hDisplay = h > 0 ? h + (h == 1 ? " hour " : " hours ") : "";
            var mDisplay = m > 0 ? m + (m == 1 ? " minute " : " minutes ") : "";
            return hDisplay + mDisplay;
        }

        function convertToSeconds(hours, minutes, seconds) {
            return Number(hours) * 60 * 60 + Number(minutes) * 60 + Number(seconds);
        }

        var totalSecond = 0;
        var courseDurations = document.querySelectorAll('.courseDuration');
        for (var i = 0; i < courseDurations.length; i++) {
            var duration = courseDurations[i].value;
            if (duration) {
                var parts = duration.split(':');
                if (parts.length === 3) {
                    totalSecond += convertToSeconds(parts[0], parts[1], parts[2]);
                }
            }
        }

        var totalDuration = secondsToHms(totalSecond);
        $('#totalHours').html(totalDuration || '0 hours');
    });

    // Cart Function
    function cart_store(course_id) {
        $.ajax({
            url: "{{ url('/elearningCart/store') }}",
            type: 'post',
            data: {
                'course_id': course_id,
                _token: '{{csrf_token()}}'
            },
            success: function(data) {
                if (data != 0) {
                    Swal.fire("Success!", "Course added to cart successfully!", "success").then(function() {
                        location.reload();
                    });
                } else {
                    Swal.fire("Error!", "Failed to add to cart.", "error");
                }
            }
        });
    }

    // Wishlist Function
    function move_wish(e, id) {
        Swal.fire({
            title: "Add to Wishlist?",
            text: "This course will be added to your wishlist",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, add it!"
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('/addWishList') }}",
                    type: 'GET',
                    data: {
                        'id': id,
                        _token: '{{csrf_token()}}'
                    },
                    success: function(data) {
                        Swal.fire("Success!", "Added to wishlist!", "success").then(function() {
                            location.reload();
                        });
                    },
                    error: function() {
                        Swal.fire("Error!", "Failed to add to wishlist.", "error");
                    }
                });
            }
        });
    }
    </script>

    <!-- Course Contents from Server -->
    @php
    $contentsHtml = '';
    foreach($courseDetails as $courseDetail) {
    $classIds = explode(',', $courseDetail->course_classes);
    $classes = DB::table('elearning_classes')->whereIn('class_id', $classIds)->get();
    $counter = 1;
    foreach($classes as $class) {
    $contentsHtml .= '<div class="content-item">
        <div class="d-flex align-items-center">
            <div class="content-number">' . $counter . '</div>
            <div class="flex-grow-1">
                <h6 class="mb-0 fw-semibold">' . htmlspecialchars($class->class_name) . '</h6>
                <small class="text-muted">
                    <i class="bi bi-clock me-1"></i> ' . htmlspecialchars($class->class_duration) . '
                </small>
            </div>
            <i class="bi bi-play-circle-fill fs-4 text-primary opacity-50"></i>
        </div>
        <input type="hidden" class="courseDuration" value="' . htmlspecialchars($class->class_duration) . '">
    </div>';
    $counter++;
    }
    }
    @endphp

    <script>
    var courseContentsHtml = `{!! $contentsHtml !!}`;
    if (courseContentsHtml && $('#courseContentsContainer').length) {
        $('#courseContentsContainer').html(courseContentsHtml);
    }
    </script>

    @endsection