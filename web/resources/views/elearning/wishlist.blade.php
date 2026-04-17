@extends('layouts.elearningmain')

@section('content')
<style>
/* Modern CSS Variables for consistent theming */
:root {
    --primary-color: #4f46e5;
    --primary-dark: #4338ca;
    --primary-light: #eef2ff;
    --success-color: #10b981;
    --success-light: #d1fae5;
    --text-dark: #1f2937;
    --text-muted: #6b7280;
    --border-color: #e5e7eb;
    --card-radius: 1rem;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Remove card body shadow */
.noShadow .card-body {
    box-shadow: none !important;
}

/* Breadcrumb styling */
.breadcrumb-custom {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--text-muted);
    margin-top: 0.5rem;
}

.breadcrumb-custom span:first-child {
    color: var(--text-muted);
}

.breadcrumb-custom span:last-child {
    color: var(--primary-color);
    font-weight: 500;
}

.breadcrumb-custom i {
    font-size: 0.75rem;
    color: var(--text-muted);
}

/* Main header */
.wishlist_main_header {
    font-weight: 800;
    font-size: 2rem !important;
    margin-bottom: 0 !important;
    background: linear-gradient(135deg, var(--primary-color) 0%, #7c3aed 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    letter-spacing: -0.02em;
}

/* Search section */
.wishlist_search_container {
    background: white;
    padding: 1rem 2rem !important;
    margin-bottom: 2rem;
    border-radius: 1rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    border: 1px solid var(--border-color);
}

.search-input-wrapper {
    position: relative;
    width: 320px;
}

.search-input-wrapper i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    font-size: 1rem;
}

.search-input-wrapper input {
    width: 100%;
    height: 44px;
    padding-left: 2.5rem;
    padding-right: 1rem;
    border: 1px solid var(--border-color);
    border-radius: 2rem;
    font-size: 0.875rem;
    transition: var(--transition);
    background-color: #f9fafb;
}

.search-input-wrapper input:focus {
    outline: none;
    border-color: var(--primary-color);
    background-color: white;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

/* Stats bar */
.wishlist-stats {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: var(--primary-light);
    padding: 0.5rem 1.25rem;
    border-radius: 2rem;
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--primary-color);
}

.wishlist-stats i {
    font-size: 1rem;
}

/* Course card */
.wishlist_courselist {
    margin-bottom: 1.5rem !important;
    border: 1px solid var(--border-color) !important;
    border-radius: var(--card-radius) !important;
    overflow: hidden;
    transition: var(--transition);
    background: white;
    position: relative;
}

.wishlist_courselist:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.02) !important;
    border-color: transparent !important;
}

.wishlist_courselist .card-header {
    overflow: hidden;
    padding: 0 !important;
    height: 180px;
    position: relative;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.course_image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.wishlist_courselist:hover .course_image {
    transform: scale(1.05);
}

/* Price badge on image */
.price-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: rgba(0, 0, 0, 0.75);
    backdrop-filter: blur(4px);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 2rem;
    font-size: 0.75rem;
    font-weight: 600;
    z-index: 2;
}

.price-badge.free {
    background: var(--success-color);
}

.wishlist_courselist .card-body {
    padding: 1.25rem !important;
}

.wishlist_courselist .card-title h5 {
    color: var(--text-dark);
    font-size: 1.1rem;
    font-weight: 700;
    line-height: 1.4;
    margin-bottom: 0.5rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.course-instructor {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-muted);
    font-size: 0.813rem;
    margin-bottom: 0.75rem;
}

.course-instructor i {
    font-size: 0.875rem;
}

/* Rating stars */
.rating-wrapper {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.rating-color {
    color: #fbbf24 !important;
}

.unfilled-star {
    color: #d1d5db;
}

.rating-count {
    font-size: 0.75rem;
    font-weight: 500;
    color: var(--text-muted);
}

/* Price section */
.price-section {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 1rem;
    padding-top: 0.75rem;
    border-top: 1px solid var(--border-color);
}

.course_price {
    font-weight: 800;
    font-size: 1.25rem;
    color: var(--primary-color);
}

/* Action buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
    opacity: 0;
    transition: var(--transition);
}

.wishlist_courselist:hover .action-buttons {
    opacity: 1;
}

.btn-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--border-color);
    background: white;
    color: var(--text-muted);
    transition: var(--transition);
    cursor: pointer;
}

.btn-icon:hover {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
}

.btn-icon.remove:hover {
    background: #ef4444;
    border-color: #ef4444;
}

/* Pagination */
.wishlist_paginate_container {
    margin-top: 2.5rem;
    margin-bottom: 1rem;
}

.wishlist_courses_paginate {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 0;
}

.pagination .page-link {
    border-radius: 0.5rem !important;
    border: 1px solid var(--border-color);
    padding: 0.5rem 1rem;
    color: var(--text-dark);
    font-weight: 500;
    transition: var(--transition);
    background: white;
}

.pagination .page-link:hover {
    background: var(--primary-light);
    border-color: var(--primary-color);
    color: var(--primary-color);
}

.pagination .active .page-link {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
}

/* Empty state */
.empty-wishlist {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: var(--card-radius);
    border: 1px solid var(--border-color);
}

.empty-wishlist i {
    font-size: 5rem;
    color: var(--text-muted);
    margin-bottom: 1.5rem;
    opacity: 0.5;
}

.empty-wishlist h4 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: var(--text-dark);
}

.empty-wishlist p {
    color: var(--text-muted);
    margin-bottom: 1.5rem;
}

.btn-browse {
    background: var(--primary-color);
    color: white;
    border: none;
    padding: 0.625rem 1.5rem;
    border-radius: 2rem;
    font-weight: 600;
    transition: var(--transition);
}

.btn-browse:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
}

/* Responsive */
@media (max-width: 768px) {
    .wishlist_search_container {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch !important;
    }

    .search-input-wrapper {
        width: 100%;
    }

    .wishlist_main_header {
        font-size: 1.5rem !important;
    }

    .action-buttons {
        opacity: 1;
    }
}



/* Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.wishlist_courselist {
    animation: fadeInUp 0.4s ease forwards;
}
</style>

<div class="main-content">
    <section class="section">
        <div class="section-body mt-1">

            <!-- Success/Error Messages -->
            @if (session('success'))
            <input type="hidden" name="session_data" id="session_data" value="{{ session('success') }}">
            @elseif(session('error'))
            <input type="hidden" name="session_data" id="session_data1" value="{{ session('error') }}">
            @endif

            <!-- Header Section -->
            <div
                class="container-fluid wishlist_search_container d-flex flex-column flex-sm-row justify-content-between align-items-center">
                <div>
                    <h2 class="wishlist_main_header">
                        My Wishlist
                    </h2>
                    <div class="breadcrumb-custom">
                        <span>E-Learning</span>
                        <i class="fa fa-angle-double-right"></i>
                        <span>Wishlist</span>
                    </div>
                </div>

                <div class="d-flex flex-row align-items-center gap-3">
                    <div class="search-input-wrapper">
                        <i class="fa fa-search"></i>
                        <input type="search" id="searchCourse" placeholder="Search your wishlist...">
                    </div>
                    <div class="wishlist-stats">
                        <i class="fa fa-heart"></i>
                        <span>{{ $wishlistCourses->total() }} Courses</span>
                    </div>
                </div>
            </div>

            <!-- Course List Section -->
            <div class="container-fluid wishlist_courselist_container">
                <div class="row" id="courseListContainer">
                    @forelse($wishlistCourses as $index => $wishlistCourse)
                    @php
                    $ratings = !empty($wishlistCourse->average_rating) ? $wishlistCourse->average_rating : 0;
                    $fullStars = floor($ratings);
                    $hasHalfStar = ($ratings - $fullStars) >= 0.5;
                    @endphp
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3 course-item"
                        data-course-name="{{ strtolower($wishlistCourse->course_name) }}">
                        <div class="card noShadow wishlist_courselist">
                            <div class="card-header">
                                <img src="../../uploads/course/126/{{ $wishlistCourse->course_banner }}"
                                    alt="{{ $wishlistCourse->course_name }}" class="course_image"
                                    onerror="this.src='https://placehold.co/400x200/eef2ff/4f46e5?text=Course'">
                                <span class="price-badge {{ $wishlistCourse->course_pay === 'free' ? 'free' : '' }}">
                                    @if($wishlistCourse->course_pay === 'paid')
                                    ₹{{ number_format($wishlistCourse->course_price, 0) }}
                                    @else
                                    Free
                                    @endif
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="card-title">
                                    <h5>{{ $wishlistCourse->course_name }}</h5>
                                </div>
                                <div class="course-instructor">
                                    <i class="fa fa-user-circle-o"></i>
                                    <span>{{ $wishlistCourse->course_instructor ?? 'Expert Instructor' }}</span>
                                </div>

                                <div class="rating-wrapper">
                                    <div class="stars">
                                        @for($i = 1; $i <= 5; $i++) @if($i <=$fullStars) <i
                                            class="fa fa-star rating-color"></i>
                                            @elseif($i == $fullStars + 1 && $hasHalfStar)
                                            <i class="fa fa-star-half-o rating-color"></i>
                                            @else
                                            <i class="fa fa-star-o unfilled-star"></i>
                                            @endif
                                            @endfor
                                    </div>
                                    <span class="rating-count">({{ number_format($ratings, 1) }})</span>
                                </div>

                                <div class="price-section">
                                    @if($wishlistCourse->course_pay === 'paid')
                                    <span
                                        class="course_price">₹{{ number_format($wishlistCourse->course_price, 0) }}</span>
                                    @else
                                    <span class="course_price" style="color: var(--success-color);">Free</span>
                                    @endif


                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="empty-wishlist">
                            <i class="fa fa-heart-o"></i>
                            <h4>Your wishlist is empty</h4>
                            <p>Save your favorite courses here to access them easily</p>
                            <a href="{{ route('courses') }}" class="btn-browse">
                                <i class="fa fa-book"></i> Browse Courses
                            </a>
                        </div>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($wishlistCourses->total() > 0)
                <div class="d-flex flex-row justify-content-center wishlist_paginate_container">
                    {{ $wishlistCourses->links() }}
                </div>
                @endif
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
    // Handle session messages
    var successMsg = document.getElementById('session_data');
    var errorMsg = document.getElementById('session_data1');

    if (successMsg && successMsg.value) {
        swal({
            title: "Success!",
            text: successMsg.value,
            type: "success",
            timer: 3000,
            showConfirmButton: false
        });
    }

    if (errorMsg && errorMsg.value) {
        swal({
            title: "Info",
            text: errorMsg.value,
            type: "info",
            timer: 3000,
            showConfirmButton: false
        });
    }

    // Search functionality
    const searchInput = document.getElementById('searchCourse');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const courseItems = document.querySelectorAll('.course-item');

            courseItems.forEach(item => {
                const courseName = item.getAttribute('data-course-name') || '';
                if (courseName.includes(searchTerm)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }


});
</script>

@endsection