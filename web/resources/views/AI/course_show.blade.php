@extends('layouts.adminnav')

@section('content')
<style type="text/css">
.buttons-html5 {
    background-color: #1bcd6b !important;
    padding: 10px;
    border: 1px;
    color: white;
}

/* Course Detail Page Specific Styles */
.course-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    overflow: hidden;
}

.course-banner {
    width: 100%;
    max-width: 100%;
    height: 250px;
    background-size: cover;
    background-position: center;
    border-radius: 8px;
    margin-bottom: 15px;
}

.course-meta-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 10px;
    margin-top: 15px;
}

.meta-card {
    background: rgba(255, 255, 255, 0.1);
    padding: 12px;
    border-radius: 6px;
    backdrop-filter: blur(10px);
}

.content-card {
    background: white;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 1px 10px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

/* Fix horizontal scroll issues */
* {
    box-sizing: border-box;
}

body {
    overflow-x: hidden;
}

.main-content {
    width: 100%;
    max-width: 100%;
    overflow-x: hidden;
    padding: 15px;
}

.section {
    width: 100%;
    max-width: 100%;
    margin: 0;
    padding: 0;
}

.row {
    margin-right: 0;
    margin-left: 0;
}

.col-12 {
    padding-right: 0;
    padding-left: 0;
}

/* Tab Styles - Fixed for responsive */
.nav-tabs-custom {
    border-bottom: 2px solid #e0e0e0;
    margin-bottom: 20px;
    display: flex;
    flex-wrap: nowrap;
    overflow-x: auto;
    overflow-y: hidden;
    -webkit-overflow-scrolling: touch;
    -ms-overflow-style: -ms-autohiding-scrollbar;
    scrollbar-width: none;
}

.nav-tabs-custom::-webkit-scrollbar {
    display: none;
}

.nav-tabs-custom .nav-link {
    border: none;
    color: #6c757d;
    font-weight: 500;
    padding: 10px 15px;
    white-space: nowrap;
    border-radius: 6px 6px 0 0;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.nav-tabs-custom .nav-link:hover {
    color: #495057;
    background-color: #f8f9fa;
}

.nav-tabs-custom .nav-link.active {
    color: #667eea;
    background-color: white;
    border-bottom: 3px solid #667eea;
}

.tab-content {
    padding: 15px 0;
    width: 100%;
    overflow: hidden;
}

/* Class Card Styles */
.class-card {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    margin-bottom: 15px;
    overflow: hidden;
}

.class-header {
    background: #f8f9fa;
    padding: 15px;
    border-bottom: 1px solid #dee2e6;
}

.class-content {
    padding: 15px;
}

.question-card {
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    padding: 12px;
    margin-bottom: 12px;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.quiz-info {
    background: #f8f9fa;
    padding: 12px;
    border-radius: 6px;
    margin-bottom: 15px;
    overflow: hidden;
}

/* Statistics Grid Fix */
.stat-card {
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 15px;
    text-align: center;
    margin-bottom: 15px;
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
    color: #667eea;
    margin-bottom: 8px;
}

/* Button fixes */
.btn-back {
    background: #6c757d;
    color: white;
    padding: 8px 15px;
    border-radius: 5px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 15px;
    white-space: nowrap;
}

/* Modal Styles */
.modal-lg {
    max-width: 900px;
}

.modal-content {
    border-radius: 10px;
    overflow: hidden;
}

.modal-header.mh {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    padding: 20px;
    border-bottom: none;
}

.modal-title {
    font-weight: 600;
    margin: 0;
}

/* Responsive fixes */
@media (max-width: 768px) {
    .main-content {
        padding: 10px;
    }

    .course-header {
        padding: 15px;
    }

    .course-banner {
        height: 200px;
    }

    .content-card {
        padding: 15px;
    }

    .course-meta-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .nav-tabs-custom .nav-link {
        padding: 8px 12px;
        font-size: 14px;
    }

    h1 {
        font-size: 1.5rem;
    }

    h2 {
        font-size: 1.3rem;
    }

    h3 {
        font-size: 1.1rem;
    }

    /* Fix flex display for mobile */
    .d-flex {
        flex-wrap: wrap;
    }

    .modal-lg {
        max-width: 95%;
        margin: 10px auto;
    }
}

@media (max-width: 576px) {
    .course-meta-grid {
        grid-template-columns: 1fr;
    }

    .course-header {
        padding: 12px;
    }

    .content-card {
        padding: 12px;
    }

    .class-header,
    .class-content {
        padding: 12px;
    }

    .btn-back {
        padding: 6px 12px;
        font-size: 14px;
    }
}

/* Modal form styles */
.longquestion {
    padding: 20px;
}

.long {
    color: #28a745;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e9ecef;
}

.form-group {
    margin-bottom: 20px;
}

.form-control.default {
    border: 1px solid #ced4da;
    border-radius: 4px;
    padding: 8px 12px;
    height: 38px;
}

.form-control.default:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
}

.btn-check:checked+.btn-outline-primary {
    background-color: #28a745;
    border-color: #28a745;
    color: white;
}

.btn-outline-primary {
    border-color: #28a745;
    color: #28a745;
}

.btn-outline-primary:hover {
    background-color: #28a745;
    border-color: #28a745;
    color: white;
}

._table {
    width: 100%;
    margin-bottom: 0;
}

._table td {
    padding: 5px;
    vertical-align: middle;
}

.action_container {
    display: flex;
    gap: 5px;
}

.action_container button {
    padding: 5px 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.action_container .success {
    background-color: #28a745;
    color: white;
}

.action_container .danger {
    background-color: #dc3545;
    color: white;
}

.examname {
    margin-top: 20px;
    padding: 15px;
    background-color: #f8f9fa;
    border-radius: 6px;
}

#certificateFields,
#expiryDateField,
#pinField,
#paid,
#free,
.examname {
    transition: all 0.3s ease;
}

/* Select2 customization */
.select2-container--default .select2-selection--multiple {
    border: 1px solid #ced4da;
    border-radius: 4px;
    min-height: 38px;
}

.select2-container--default.select2-container--focus .select2-selection--multiple {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
}
</style>

<!-- Session Messages -->
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

<div class="main-content">
    <section class="section">
        <div class="col-lg-12 text-center">
            <h4 style="color:darkblue;">Course Details</h4>
        </div>

        <div class="section-body mt-2">
            <div class="row">
                <div class="col-12">
                    <div class="course-show-container">
                        <!-- Back Button -->
                        <a href="{{ route('ai_course_list') }}" class="btn-back">
                            <i class="fas fa-arrow-left"></i> Back to Courses
                        </a>

                        <!-- Course Banner -->
                        @if($course->course_banner)
                        <div class="course-banner" style="background-image: url('{{ $course->course_banner }}');"></div>
                        @endif

                        <!-- Course Header -->
                        <div class="course-header">
                            <div class="d-flex justify-content-between align-items-start">
                                <div style="max-width: 100%;">
                                    <h1 style="word-break: break-word;">{{ $course->course_name }}</h1>
                                    <p class="lead mb-0" style="word-break: break-word;">
                                        {{ $course->course_description }}</p>
                                    <span class="status-badge status-active mt-2">
                                        <i class="fas fa-check-circle mr-1"></i> Active
                                    </span>
                                </div>
                            </div>

                            <div class="course-meta-grid">
                                <div class="meta-card">
                                    <small>Category</small>
                                    <div class="fw-bold">{{ $course->course_category }}</div>
                                </div>
                                <div class="meta-card">
                                    <small>Duration</small>
                                    <div class="fw-bold">10</div>
                                </div>
                                <div class="meta-card">
                                    <small>Classes</small>
                                    <div class="fw-bold">{{ $classes->count() }}</div>
                                </div>
                                <div class="meta-card">
                                    <small>Status</small>
                                    <div class="fw-bold">{{ $course->drop_course == '0' ? 'Active' : 'Archived' }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Course Description -->
                        <div class="content-card">
                            <h3 class="mb-4">
                                <i class="fas fa-info-circle mr-2"></i>Course Overview
                            </h3>
                            <div class="bg-light p-4 rounded">
                                <p class="mb-0" style="word-break: break-word;">{{ $course->course_description }}</p>
                            </div>
                        </div>

                        <!-- Tab Navigation -->
                        <div class="content-card">
                            <ul class="nav nav-tabs nav-tabs-custom" id="courseTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="classes-tab" data-bs-toggle="tab"
                                        data-bs-target="#classes" type="button" role="tab">
                                        <i class="fas fa-book mr-2"></i>Classes ({{ $classes->count() }})
                                    </button>
                                </li>
                                @if($exam)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="exam-tab" data-bs-toggle="tab" data-bs-target="#exam"
                                        type="button" role="tab">
                                        <i class="fas fa-graduation-cap mr-2"></i>Final Exam
                                    </button>
                                </li>
                                @endif
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="statistics-tab" data-bs-toggle="tab"
                                        data-bs-target="#statistics" type="button" role="tab">
                                        <i class="fas fa-chart-bar mr-2"></i>Statistics
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content" id="courseTabsContent">
                                <!-- Classes Tab -->
                                <div class="tab-pane fade show active" id="classes" role="tabpanel">
                                    <h4 class="mb-4">Course Classes</h4>

                                    @foreach($classes as $index => $class)
                                    <div class="class-card">
                                        <div class="class-header">
                                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                                <div style="max-width: 100%;">
                                                    <h4 class="mb-1" style="word-break: break-word;">
                                                        <i class="fas fa-chalkboard-teacher mr-2"></i>
                                                        Class {{ $index + 1 }}: {{ $class->class_name }}
                                                    </h4>
                                                    <p class="mb-0 text-muted">
                                                        <i class="fas fa-clock mr-1"></i> {{ $class->class_duration }}
                                                    </p>
                                                </div>
                                                @if($class->class_quiz == 'yes')
                                                <span class="badge bg-success mt-2 mt-md-0">
                                                    <i class="fas fa-question-circle mr-1"></i> Quiz Included
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="class-content">
                                            <p class="mb-3" style="word-break: break-word;">
                                                {{ $class->class_description }}</p>

                                            <!-- Quiz Section -->
                                            @if($class->quiz)
                                            <div class="quiz-info">
                                                <h5 class="mb-3">
                                                    <i class="fas fa-question-circle mr-2"></i>
                                                    Class Quiz
                                                </h5>
                                                <div class="d-flex justify-content-between flex-wrap mb-3">
                                                    <div class="mb-2 mb-md-0">
                                                        <strong>Quiz Name:</strong> {{ $class->quiz->quiz_name }}
                                                    </div>
                                                    <div class="mb-2 mb-md-0">
                                                        <strong>Total Points:</strong> {{ $class->quiz->points }}
                                                    </div>
                                                    <div>
                                                        <strong>Questions:</strong>
                                                        {{ count($class->quiz->questions ?? []) }}
                                                    </div>
                                                </div>

                                                <!-- Quiz Questions -->
                                                @if(!empty($class->quiz->questions))
                                                <div class="mt-4">
                                                    <h6 class="mb-3">Quiz Questions:</h6>
                                                    @foreach($class->quiz->questions as $qIndex => $question)
                                                    <div class="question-card">
                                                        <div
                                                            class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                                            <strong style="word-break: break-word;">Question
                                                                {{ $qIndex + 1 }}
                                                                ({{ $question->question_type }}):</strong>
                                                            <span
                                                                class="badge bg-info mt-1 mt-md-0">{{ $question->points }}
                                                                points</span>
                                                        </div>
                                                        <p class="mb-2" style="word-break: break-word;">
                                                            {{ $question->question }}</p>

                                                        @if($question->question_type == 'mcq' &&
                                                        !empty($question->choices))

                                                        <div class="mt-2">
                                                            <small class="text-muted">Options:</small>
                                                            <ul class="mb-0 ps-3">

                                                                @php
                                                                $choices = explode(',', $question->choices);
                                                                @endphp

                                                                @foreach ($choices as $choice)
                                                                <p>{{ trim($choice) }}</p>
                                                                @endforeach

                                                            </ul>
                                                            <small class="text-success">
                                                                <i class="fas fa-check mr-1"></i>
                                                                Correct Answer: {{ $question->correct_choices }}
                                                            </small>
                                                        </div>
                                                        @elseif($question->question_type == 'boolean')
                                                        <div class="mt-2">
                                                            <small class="text-success">
                                                                <i class="fas fa-check mr-1"></i>
                                                                Correct Answer:
                                                                {{ $question->answer == 'on' ? 'True' : 'False' }}
                                                            </small>
                                                        </div>
                                                        @elseif(in_array($question->question_type, ['short', 'long']))
                                                        <div class="mt-2">
                                                            <small class="text-success">
                                                                <i class="fas fa-check mr-1"></i>
                                                                Answer Keywords: {{ $question->keywords }}
                                                            </small>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @endif
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <!-- Final Exam Tab -->

                                @if($exam)
                                <div class="tab-pane fade" id="exam" role="tabpanel">
                                    <h4 class="mb-4">Final Exam</h4>

                                    <div class="class-card">
                                        <div class="exam-header">
                                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                                <div style="max-width: 100%;">
                                                    <h4 class="mb-1" style="word-break: break-word;">
                                                        <i class="fas fa-graduation-cap mr-2"></i>
                                                        {{ $exam->quiz_name }}
                                                    </h4>
                                                    <p class="mb-0">Course Final Examination</p>
                                                </div>
                                                <span class="badge bg-warning mt-2 mt-md-0">
                                                    <i class="fas fa-star mr-1"></i> Required
                                                </span>
                                            </div>
                                        </div>

                                        <div class="class-content">
                                            <div class="quiz-info">
                                                <div class="d-flex justify-content-between flex-wrap mb-4">
                                                    <div class="text-center mb-3 mb-md-0"
                                                        style="flex: 1 1 25%; min-width: 120px;">
                                                        <strong>Total Points</strong>
                                                        <div class="h3 ">{{ $exam->points }}</div>
                                                    </div>
                                                    <div class="text-center mb-3 mb-md-0"
                                                        style="flex: 1 1 25%; min-width: 120px;">
                                                        <strong>Questions</strong>
                                                        <div class="h3 ">{{ count($exam->questions ?? []) }}
                                                        </div>
                                                    </div>
                                                    <div class="text-center mb-3 mb-md-0"
                                                        style="flex: 1 1 25%; min-width: 120px;">
                                                        <strong>Duration</strong>
                                                        <div class="h3 ">120 min</div>
                                                    </div>
                                                    <div class="text-center mb-3 mb-md-0"
                                                        style="flex: 1 1 25%; min-width: 120px;">
                                                        <strong>Passing Score</strong>
                                                        <div class="h3">70%</div>
                                                    </div>
                                                </div>

                                                <!-- Exam Questions -->
                                                @if(!empty($exam->questions))
                                                <div class="mt-4">
                                                    <h5 class="mb-4">Exam Questions:</h5>
                                                    @foreach($exam->questions as $qIndex => $question)
                                                    <div class="question-card">
                                                        <div
                                                            class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                                            <div style="max-width: 100%;">
                                                                <strong style="word-break: break-word;">Question
                                                                    {{ $qIndex + 1 }}
                                                                    ({{ $question->question_type }}):</strong>
                                                                <span class="badge bg-info ms-2">{{ $question->points }}
                                                                    points</span>
                                                            </div>

                                                        </div>
                                                        <p class="mb-3" style="word-break: break-word;">
                                                            {{ $question->question }}</p>

                                                        @if($question->question_type == 'mcq' &&
                                                        !empty($question->choices))
                                                        <div class="mt-3">
                                                            <small class="text-muted">Options:</small>
                                                            <div class="row mt-2">
                                                                @foreach(json_decode($question->choices, true) as
                                                                $choiceIndex => $choice)
                                                                <div class="col-12 col-sm-6 mb-2">
                                                                    <div class="p-2 border rounded {{ strpos($question->correct_choices, (string)($choiceIndex + 1)) !== false ? 'bg-success text-white' : '' }}"
                                                                        style="word-break: break-word;">
                                                                        {{ $choice }}
                                                                        @if(strpos($question->correct_choices,
                                                                        (string)($choiceIndex + 1)) !== false)
                                                                        <i class="fas fa-check ms-2"></i>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        @elseif($question->question_type == 'boolean')
                                                        <div class="mt-3">
                                                            <div class="alert alert-success">
                                                                <i class="fas fa-check-circle mr-2"></i>
                                                                Correct Answer:
                                                                <strong>{{ $question->answer == 'on' ? 'True' : 'False' }}</strong>
                                                            </div>
                                                        </div>
                                                        @elseif(in_array($question->question_type, ['short', 'long']))
                                                        <div class="mt-3">
                                                            <div class="alert alert-info">
                                                                <i class="fas fa-lightbulb mr-2"></i>
                                                                <strong>Answer Keywords:</strong>
                                                                {{ $question->keywords }}
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Statistics Tab -->
                                <div class="tab-pane fade" id="statistics" role="tabpanel">
                                    <h4 class="mb-4">Course Statistics</h4>

                                    <div class="row mb-4">
                                        <div class="col-md-3 col-sm-6 mb-3">
                                            <div class="stat-card">
                                                <div class="stat-number">{{ $classes->count() }}</div>
                                                <p class="mb-0 text-muted">Total Classes</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 mb-3">
                                            <div class="stat-card">
                                                @php
                                                $totalQuestions = 0;
                                                foreach($classes as $class) {
                                                if($class->quiz && !empty($class->quiz->questions)) {
                                                $totalQuestions += count($class->quiz->questions);
                                                }
                                                }
                                                if($exam && !empty($exam->questions)) {
                                                $totalQuestions += count($exam->questions);
                                                }
                                                @endphp
                                                <div class="stat-number">{{ $totalQuestions }}</div>
                                                <p class="mb-0 text-muted">Total Questions</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 mb-3">
                                            <div class="stat-card">
                                                @php
                                                $totalPoints = 0;
                                                foreach($classes as $class) {
                                                if($class->quiz) {
                                                $totalPoints += $class->quiz->points;
                                                }
                                                }
                                                if($exam) {
                                                $totalPoints += $exam->points;
                                                }
                                                @endphp
                                                <div class="stat-number">{{ $totalPoints }}</div>
                                                <p class="mb-0 text-muted">Total Points</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 mb-3">
                                            <div class="stat-card">
                                                <div class="stat-number">{{ $exam ? '1' : '0' }}</div>
                                                <p class="mb-0 text-muted">Final Exam{{ $exam ? '' : ' (Not Set)' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="content-card">
                            <div class="d-flex justify-content-between flex-wrap">
                                <div class="mb-2 mb-md-0">
                                    <a href="{{ route('ai_course_list') }}" class="btn btn-secondary">
                                        <i class="fas fa-list mr-2"></i> Back to List
                                    </a>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-success ms-0 ms-md-2" data-toggle="modal"
                                        data-target="#publishModal">
                                        <i class="fas fa-play mr-2"></i> Publish Course
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Publish Course Modal -->
<div class="modal fade" id="publishModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header mh">
                <h4 class="modal-title">Publish Course</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <!-- Long question -->
            <div class="card longquestion" id="">
                <h4 class="modal-title long">Edit Course & Publish:</h4>

                <form method="post" name="publish_course" action="{{ route('course_publish', $course->course_id) }}"
                    enctype="multipart/form-data" id="publish_course_form" class="reset">
                    @csrf
                    <input type="hidden" id="expired_course_id" name="expired_course_id" value="">
                    <input type="hidden" id="original_exam_id" name="original_exam_id" value="{{ $course->exam_id }}">

                    <div class="row">
                        <!-- Role Selection -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Role <span class="error-star" style="color:red;">*</span></label>
                                <select class="form-control" name="role_id" id="role_id" disabled>
                                    <option value="">---Select Role---</option>
                                    @foreach($roles as $values)
                                    <option value="{{ $values->role_id }}"
                                        {{ $course->role_id == $values->role_id ? 'selected' : '' }}>
                                        {{ $values->role_name }}
                                    </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Role cannot be changed after course creation</small>
                            </div>
                        </div>

                        <!-- Designation Selection -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Designation <span class="error-star" style="color:red;">*</span></label>
                                <select class="form-control" name="designation_id" id="designation_id" disabled>
                                    <option value="">Please Select Designation</option>
                                    @foreach($rows['designation'] as $designation)
                                    <option value="{{ $designation->designation_id }}"
                                        {{ $course->designation_id == $designation->designation_id ? 'selected' : '' }}>
                                        {{ $designation->designation_name }}
                                    </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Designation cannot be changed after course creation</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>User Name <span class="text-danger">*</span></label>
                                <select class="user_id_course form-control js-select2" name="user_ids[]" id="user_id"
                                    multiple="multiple">
                                    @php
                                    // Initialize variables
                                    $selectedUserIds = [];
                                    $userIdsString = $course->user_ids ?? '';

                                    // Try to decode as JSON first
                                    if (!empty($userIdsString) && is_string($userIdsString)) {
                                    $decoded = json_decode($userIdsString, true);
                                    if (json_last_error() === JSON_ERROR_NONE) {
                                    $selectedUserIds = $decoded;
                                    } else {
                                    // If not JSON, try comma-separated
                                    $selectedUserIds = explode(',', $userIdsString);
                                    }
                                    }

                                    // Ensure it's an array
                                    if (!is_array($selectedUserIds)) {
                                    $selectedUserIds = [];
                                    }

                                    // Check if "all" is selected
                                    $allSelected = in_array('all', $selectedUserIds);
                                    @endphp

                                    @php
                                    // Generate all user IDs
                                    $allUserIds = $rows['users']->pluck('id')->implode(',');
                                    @endphp
                                    <option value="{{ $allUserIds }}">All</option>
                                    @foreach($rows['users'] as $data)
                                    @php
                                    // Check if this user ID is selected (only if "all" is not selected)
                                    $isSelected = false;
                                    if (!$allSelected) {
                                    $isSelected = in_array((string)$data->id, array_map('strval', $selectedUserIds));
                                    }
                                    @endphp
                                    <option value="{{ $data->id }}" {{ $isSelected ? 'selected' : '' }}>
                                        {{ $data->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Select "All" to assign to all users</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Name:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="course_name" name="course_name"
                                    value="{{ $course->course_name }}" readonly>
                                <small class="text-muted">Course name cannot be changed</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Description:<span class="error-star"
                                        style="color:red;">*</span></label><br>
                                <textarea id="course_description" name="course_description" rows="3"
                                    class="form-control" readonly>{{ $course->course_description }}</textarea>
                                <small class="text-muted">Course description cannot be changed</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Course Certificate:</label><br>
                                <input type="radio" class="btn-check" name="course_certificate" value="1"
                                    id="course_certificate_yes" autocomplete="off"
                                    {{ $course->course_certificate == '1' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="course_certificate_yes">Yes</label>

                                <input type="radio" class="btn-check" name="course_certificate" value="2"
                                    id="course_certificate_no" autocomplete="off"
                                    {{ $course->course_certificate == '2' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="course_certificate_no">No</label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Course Exam:<span class="error-star" style="color:red;">*</span></label><br>
                                <input type="radio" class="btn-check course_exam" name="course_exam" value="1"
                                    id="course_examyes" autocomplete="off"
                                    {{ $course->course_exam == '1' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="course_examyes">Yes</label>

                                <input type="radio" class="btn-check course_exam" name="course_exam" value="2"
                                    id="course_examno" autocomplete="off"
                                    {{ $course->course_exam == '2' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="course_examno">No</label>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Type:<span class="error-star" style="color:red;">*</span></label>
                                <select class="form-control" name="course_pay" id="course_pay">
                                    <option value="">---Select Course Type---</option>
                                    <option value="paid" {{ $course->course_pay == 'paid' ? 'selected' : '' }}>Paid
                                        Course</option>
                                    <option value="free" {{ $course->course_pay == 'free' ? 'selected' : '' }}>Free
                                        Course</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6" id="paid"
                            style="display: {{ $course->course_pay == 'paid' ? 'block' : 'none' }};">
                            <div class="form-group">
                                <label>Course Price:<span class="error-star" style="color:red;">*</span></label>
                                <input type="number" class="form-control default" id="course_price"
                                    placeholder="Enter the Money(UGX)" name="course_price"
                                    value="{{ $course->course_price }}" autocomplete="off">
                            </div>
                        </div>

                    </div>

                    <!-- Certificate Template Fields -->
                    <div class="row" id="certificateFields"
                        style="display: {{ $course->course_certificate == '1' ? 'block' : 'none' }};">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Certificate Template:<span class="error-star" style="color:red;">*</span></label>
                                <select class="form-control" name="cetificate_template" id="cetificate_template">
                                    <option value="">---Select Certificate Template---</option>
                                    @foreach($rows1['certificate_templates'] as $row)
                                    <option value="{{ $row->certificate_templates_id }}"
                                        {{ $course->cetificate_template == $row->certificate_templates_id ? 'selected' : '' }}>
                                        {{ $row->template_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Certificate Expiry:<span class="error-star"
                                        style="color:red;">*</span></label><br>
                                <input type="radio" class="btn-check certificate_expiry" name="certificate_expiry"
                                    value="1" id="certificate_expiryyes" autocomplete="off"
                                    {{ $course->certificate_expiry == '1' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="certificate_expiryyes">Yes</label>

                                <input type="radio" class="btn-check certificate_expiry" name="certificate_expiry"
                                    value="2" id="certificate_expiryno" autocomplete="off"
                                    {{ $course->certificate_expiry == '2' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="certificate_expiryno">No</label>
                            </div>
                        </div>

                        <div class="col-md-3" id="expiryDateField"
                            style="display: {{ $course->certificate_expiry == '1' ? 'block' : 'none' }};">
                            <div class="form-group">
                                <label>Expiry Date:<span class="error-star" style="color:red;">*</span></label>
                                <input type='date' class="form-control default" id='course_expiry_period'
                                    name="course_expiry_period" placeholder="dd-mm-yy"
                                    value="{{ $course->course_expiry_period ? date('Y-m-d', strtotime($course->course_expiry_period)) : '' }}"
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <!-- Course Price Fields -->



                    <div class="row">
                        <div class="col-md-12 form-group"
                            style="display:flex;justify-content: space-evenly;align-items: center;">
                            <label>This Course has Start and End Period<span class="error-star"
                                    style="color:red;">*</span></label>
                            <div class="form-group">
                                <input type="radio" class="btn-check answer_show_on course_noperiod"
                                    name="course_noperiod" value="1" id="course_noperiodyes" autocomplete="off"
                                    {{ $course->course_noperiod == '1' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary answer_show_on1"
                                    for="course_noperiodyes">Yes</label>

                                <input type="radio" class="btn-check answer_show_off course_noperiod"
                                    name="course_noperiod" value="2" id="course_noperiodno" autocomplete="off"
                                    {{ $course->course_noperiod == '2' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary answer_show_off1"
                                    for="course_noperiodno">No</label>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="coursePeriodFields"
                        style="display: {{ $course->course_noperiod == '1' ? 'block' : 'none' }};">
                        <div class="col-md-3"><label class="course_period">Course Period:<span class="error-star"
                                    style="color:red;">*</span></label></div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Start Date:<span class="error-star" style="color:red;">*</span></label>
                                <input type='date' class="form-control default" id='course_start_period'
                                    name="course_start_period" title="Course Start Date"
                                    value="{{ $course->course_start_period ? date('Y-m-d', strtotime($course->course_start_period)) : '' }}"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>End Date:<span class="error-star" style="color:red;">*</span></label>
                                <input type='date' class="form-control default" id='course_end_period'
                                    name="course_end_period" title="Course End Date"
                                    value="{{ $course->course_end_period ? date('Y-m-d', strtotime($course->course_end_period)) : '' }}"
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 examname"
                        style="display: {{ $course->course_exam == '1' ? 'block' : 'none' }};">
                        <div class="row">
                            <div class="col-md-3 form-group"><label class="course_exam">Exam Details:<span
                                        class="error-star" style="color:red;">*</span></label></div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="control-label required">Exam Name:<span class="error-star"
                                            style="color:red;">*</span></label>

                                    <select class="form-control" name="exam_name" id="exam_name" disabled>
                                        <option value="">Select Exam Name</option>
                                        @php
                                        // Get the exam name from practice_quiz table using exam_id
                                        $examId = $course->exam_id;
                                        $examName = '';
                                        if ($examId) {
                                        $exam = DB::table('elearning_practice_quiz')
                                        ->where('quiz_id', $examId)
                                        ->first();
                                        $examName = $exam ? $exam->quiz_name : '';
                                        }
                                        @endphp
                                        @foreach($rows1['exam_list'] as $key => $row)
                                        <option value="{{ $row->id }}" {{ $row->id == $examId ? 'selected' : '' }}>
                                            {{ $row->quiz_name ?? $row->exam_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if($examId && !empty($examName))
                                    <small class="text-muted">Current exam: {{ $examName }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Exam Date:<span class="error-star" style="color:red;">*</span></label>
                                    <input type='date' class="form-control default" id="exam_date" name="exam_date"
                                        title="Course Exam Date"
                                        value="{{ $course->exam_date ? date('Y-m-d', strtotime($course->exam_date)) : '' }}"
                                        autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Pass Percentage:<span class="error-star" style="color:red;">*</span></label>
                                <div style="display:flex;align-items: baseline;">
                                    <input type="number" class="form-control default" id="pass_percentage"
                                        name="pass_percentage" value="{{ $course->pass_percentage }}"
                                        autocomplete="off">
                                    <span class="col-md-6" style="color:red;"><strong>(in percentage
                                            only)</strong></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Course Instructor:<span class="error-star" style="color:red;">*</span></label>
                                <input type="text" class="form-control default" id="course_instructor"
                                    name="course_instructor" value="{{ $course->course_instructor }}"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>CPD Points: <span class="error-star" style="color:red;">*</span></label>
                                <input type="number" class="form-control default" id="course_cpt_points"
                                    name="course_cpt_points" value="{{ $course->course_cpt_points }}"
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="row">


                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Restricted Course Access:<span class="error-star"
                                        style="color:red;">*</span></label><br>
                                <input type="radio" class="btn-check" name="restricted_access" value="1"
                                    id="restricted_yes" autocomplete="off"
                                    {{ $course->restricted_access == '1' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="restricted_yes">Yes</label>

                                <input type="radio" class="btn-check" name="restricted_access" value="0"
                                    id="restricted_no" autocomplete="off"
                                    {{ $course->restricted_access == '0' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="restricted_no">No</label>
                            </div>
                        </div>

                        <div class="col-md-6" id="pinField"
                            style="display: {{ $course->restricted_access == '1' ? 'block' : 'none' }};">
                            <div class="form-group">
                                <label>Access PIN:<span class="error-star" style="color:red;">*</span></label>
                                <input type="password" class="form-control default" name="course_pin" id="course_pin"
                                    placeholder="Enter 4-6 digit PIN" value="{{ $course->course_pin }}"
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <button class="btn btn-success btn-space savebutton" type="submit" id="publishbutton">
                                <i class="fas fa-check mr-2"></i> Publish Course
                            </button>
                            <input type="button" class="btn btn-danger" data-dismiss="modal" onclick="resetSelect2()"
                                value="Cancel">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- JavaScript for modal functionality -->
<!-- Replace the entire JavaScript section at the end with this: -->
<script type="text/javascript">
$(document).ready(function() {
    // Prevent horizontal scroll
    $('body').css('overflow-x', 'hidden');

    // Initialize Bootstrap 5 tabs
    var tabTriggerList = [].slice.call(document.querySelectorAll('#courseTabs button'));
    tabTriggerList.forEach(function(tabTriggerEl) {
        tabTriggerEl.addEventListener('click', function(event) {
            event.preventDefault();
            var tabTrigger = new bootstrap.Tab(tabTriggerEl);
            tabTrigger.show();
        });
    });

    // Check if select2 is available
    if (typeof $.fn.select2 === 'undefined') {
        console.error('Select2 is not loaded. Please include Select2 library.');
        // Load Select2 dynamically if not available
        $.getScript('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', function() {
            initializeSelect2();
        });
    } else {
        initializeSelect2();
    }

    function initializeSelect2() {
        // Initialize Select2
        $('.js-select2').select2({
            width: '100%',
            placeholder: "Select options",
            allowClear: true
        });

        // Initialize other select2 fields
        $('#course_classes').select2({
            width: '100%',
            placeholder: "Select classes",
            allowClear: true
        });
    }

    // Initialize fields based on current values
    function initializeFields() {
        // Show/Hide certificate fields
        if ($('input[name="course_certificate"]:checked').val() == '1') {
            $('#certificateFields').show();
        } else {
            $('#certificateFields').hide();
        }

        // Show/Hide exam fields
        if ($('input[name="course_exam"]:checked').val() == '1') {
            $('.examname').show();
        } else {
            $('.examname').hide();
        }

        // Show/Hide course period fields
        if ($('input[name="course_noperiod"]:checked').val() == '1') {
            $('#coursePeriodFields').show();
        } else {
            $('#coursePeriodFields').hide();
        }

        // Show/Hide PIN field
        if ($('input[name="restricted_access"]:checked').val() == '1') {
            $('#pinField').show();
        } else {
            $('#pinField').hide();
        }

        // Show/Hide expiry date field
        if ($('input[name="certificate_expiry"]:checked').val() == '1') {
            $('#expiryDateField').show();
        } else {
            $('#expiryDateField').hide();
        }
    }

    // Initialize fields on page load
    initializeFields();

    // Event handlers for field changes
    $('input[name="course_certificate"]').change(function() {
        if ($(this).val() == '1') {
            $('#certificateFields').show();
        } else {
            $('#certificateFields').hide();
            $('#expiryDateField').hide();
        }
    });

    $('input[name="course_exam"]').change(function() {
        if ($(this).val() == '1') {
            $('.examname').show();
        } else {
            $('.examname').hide();
        }
    });

    $('#course_pay').change(function() {
        if ($(this).val() == 'paid') {
            $('#paid').show();
            $('#free').hide();
        } else if ($(this).val() == 'free') {
            $('#free').show();
            $('#paid').hide();
        }
    });

    $('input[name="course_noperiod"]').change(function() {
        if ($(this).val() == '1') {
            $('#coursePeriodFields').show();
        } else {
            $('#coursePeriodFields').hide();
        }
    });

    $('input[name="restricted_access"]').change(function() {
        if ($(this).val() == '1') {
            $('#pinField').show();
        } else {
            $('#pinField').hide();
        }
    });

    $('input[name="certificate_expiry"]').change(function() {
        if ($(this).val() == '1') {
            $('#expiryDateField').show();
        } else {
            $('#expiryDateField').hide();
        }
    });

    // Initialize Bootstrap 5 modal for publishModal
    var publishModal = new bootstrap.Modal(document.getElementById('publishModal'));

    // Add click handler for the publish button
    $('button[data-target="#publishModal"]').click(function(e) {
        e.preventDefault();
        publishModal.show();
    });

    // Initialize fields on modal show
    $('#publishModal').on('shown.bs.modal', function() {
        initializeFields();
    });

    // Form submission with SweetAlert confirmation
    $('#publish_course_form').submit(function(e) {
        e.preventDefault();

        // Show confirmation dialog
        Swal.fire({
            title: "Confirm Publication",
            text: "Are you sure you want to publish this course? Once published, it will be available to enrolled users.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#28a745",
            confirmButtonText: "Yes, publish it!",
            cancelButtonText: "Cancel",
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                // Remove the event handler to allow default form submission
                $('#publish_course_form').off('submit').submit();
            }
        });
    });
});

// Function to add new row to tables
function create_tr(tableId) {
    var table = document.getElementById(tableId);
    var newRow = table.insertRow(-1);
    newRow.innerHTML = `
        <td>
            <input type="text" class="form-control default" name="${tableId === 'table_body' ? 'course_tags[]' : 'course_skills_required[]'}" autocomplete="off">
        </td>
        <td>
            <div class="action_container">
                <button class="danger" type="button" onclick="remove_tr(this)">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </td>
    `;
}

function create_tr1(tableId) {
    var table = document.getElementById(tableId);
    var newRow = table.insertRow(-1);
    newRow.innerHTML = `
        <td>
            <input type="text" class="form-control default" name="course_skills_required[]" autocomplete="off">
        </td>
        <td>
            <div class="action_container">
                <button class="danger" type="button" onclick="remove_tr(this)">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </td>
    `;
}

function create_tr3(tableId) {
    var table = document.getElementById(tableId);
    var newRow = table.insertRow(-1);
    newRow.innerHTML = `
        <td>
            <input type="text" class="form-control default" name="course_gain_skills[]" autocomplete="off">
        </td>
        <td>
            <div class="action_container">
                <button class="danger" type="button" onclick="remove_tr(this)">
                    <i class="fa fa-close"></i>
                </button>
            </div>
        </td>
    `;
}

function remove_tr(button) {
    var row = button.closest('tr');
    row.parentNode.removeChild(row);
}

function resetSelect2() {
    $('.js-select2').val(null).trigger('change');
    $('#course_classes').val(null).trigger('change');
}
</script>

<!-- Bootstrap JS for Tabs -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    // Prevent horizontal scroll
    $('body').css('overflow-x', 'hidden');

    // Initialize Select2 with better "All" handling
    $('.js-select2').select2({
        width: '100%',
        placeholder: "Select options",
        allowClear: true,
        closeOnSelect: false
    });

    // Handle "All" selection logic
    $('#user_id').on('select2:select', function(e) {
        var data = e.params.data;

        if (data.id === 'all') {
            // If "All" is selected, deselect all other options
            $('#user_id').val(['all']).trigger('change');
        } else {
            // If any other option is selected, remove "all" if it exists
            var currentValues = $('#user_id').val();
            if (currentValues && currentValues.includes('all')) {
                currentValues = currentValues.filter(function(value) {
                    return value !== 'all';
                });
                $('#user_id').val(currentValues).trigger('change');
            }
        }
    });

    $('#user_id').on('select2:unselect', function(e) {
        var data = e.params.data;

        if (data.id === 'all') {
            // If "All" is deselected, ensure no other options remain
            $('#user_id').val(null).trigger('change');
        }
    });
    // Initialize fields based on current values
    function initializeFields() {
        // Show/Hide certificate fields
        if ($('input[name="course_certificate"]:checked').val() == '1') {
            $('#certificateFields').show();
        } else {
            $('#certificateFields').hide();
        }

        // Show/Hide exam fields
        if ($('input[name="course_exam"]:checked').val() == '1') {
            $('.examname').show();
        } else {
            $('.examname').hide();
        }

        // Show/Hide course period fields
        if ($('input[name="course_noperiod"]:checked').val() == '1') {
            $('#coursePeriodFields').show();
        } else {
            $('#coursePeriodFields').hide();
        }

        // Show/Hide PIN field
        if ($('input[name="restricted_access"]:checked').val() == '1') {
            $('#pinField').show();
        } else {
            $('#pinField').hide();
        }

        // Show/Hide expiry date field
        if ($('input[name="certificate_expiry"]:checked').val() == '1') {
            $('#expiryDateField').show();
        } else {
            $('#expiryDateField').hide();
        }
    }

    // Initialize fields on page load
    initializeFields();

    // Event handlers for field changes
    $('input[name="course_certificate"]').change(function() {
        if ($(this).val() == '1') {
            $('#certificateFields').show();
        } else {
            $('#certificateFields').hide();
            $('#expiryDateField').hide();
        }
    });

    $('input[name="course_exam"]').change(function() {
        if ($(this).val() == '1') {
            $('.examname').show();
        } else {
            $('.examname').hide();
        }
    });

    $('#course_pay').change(function() {
        if ($(this).val() == 'paid') {
            $('#paid').show();
        } else {
            $('#paid').hide();
        }
    });

    $('input[name="course_noperiod"]').change(function() {
        if ($(this).val() == '1') {
            $('#coursePeriodFields').show();
        } else {
            $('#coursePeriodFields').hide();
        }
    });

    $('input[name="restricted_access"]').change(function() {
        if ($(this).val() == '1') {
            $('#pinField').show();
        } else {
            $('#pinField').hide();
        }
    });

    $('input[name="certificate_expiry"]').change(function() {
        if ($(this).val() == '1') {
            $('#expiryDateField').show();
        } else {
            $('#expiryDateField').hide();
        }
    });

    // Initialize Bootstrap modal
    var publishModal = new bootstrap.Modal(document.getElementById('publishModal'));

    // Add click handler for the publish button
    $('button[data-target="#publishModal"]').click(function(e) {
        e.preventDefault();
        // Make sure the exam ID is properly populated
        var examId = $('#original_exam_id').val();
        if (examId) {
            // Set the exam name dropdown
            $('#exam_name').val(examId).trigger('change');
        }
        publishModal.show();
    });

    // Initialize fields on modal show
    $('#publishModal').on('shown.bs.modal', function() {
        initializeFields();

        // Disable non-editable fields
        $('#role_id, #designation_id, #course_name, #course_description').prop('disabled', true);

        // Add readonly styling
        $('#course_name, #course_description').css({
            'background-color': '#f8f9fa',
            'cursor': 'not-allowed'
        });
    });

    $('#publish_course_form').submit(function(e) {
        e.preventDefault();

        // Process user_ids - if "all" is selected, convert to comma-separated all user IDs
        var selectedUserIds = $('#user_id').val();
        var allUserIds = [];

        if (selectedUserIds && selectedUserIds.includes('all')) {
            // Get all user IDs except "all"
            $('#user_id option').each(function() {
                var value = $(this).val();
                if (value !== 'all' && value !== '') {
                    allUserIds.push(value);
                }
            });

            // Create hidden input with all user IDs
            $('<input>').attr({
                type: 'hidden',
                name: 'user_ids[]',
                value: 'all' // Send 'all' as a special value
            }).appendTo('#publish_course_form');

            // Also store the actual IDs in another field
            $('<input>').attr({
                type: 'hidden',
                name: 'all_user_ids_string',
                value: allUserIds.join(',')
            }).appendTo('#publish_course_form');

            console.log('All User IDs selected, sending "all" as value');

            // Clear the original user_ids field to prevent conflict
            $('#user_id').val('');
        } else {
            // If specific users are selected, ensure it's not empty
            if (!selectedUserIds || selectedUserIds.length === 0) {
                Swal.fire({
                    title: "Error",
                    text: "Please select at least one user or select 'All'",
                    icon: "error",
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "OK",
                    customClass: {
                        confirmButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                });
                return false;
            }
        }

        // Show confirmation dialog
        Swal.fire({
            title: "Confirm Publication",
            text: "Are you sure you want to publish this course? Once published, it will be available to enrolled users.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#28a745",
            confirmButtonText: "Yes, publish it!",
            cancelButtonText: "Cancel",
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form
                $(this).off('submit').submit();
            }
        });
    });

    // Re-enable fields when modal is hidden
    $('#publishModal').on('hidden.bs.modal', function() {
        $('#role_id, #designation_id, #course_name, #course_description').prop('disabled', false);
        $('#course_name, #course_description').css({
            'background-color': '',
            'cursor': ''
        });
        // Remove any hidden inputs added
        $('input[name="all_user_ids"]').remove();
    });
});

function resetSelect2() {
    $('.js-select2').val(null).trigger('change');
}
</script>

@endsection