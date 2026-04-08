@extends('layouts.adminnav')

@section('content')

<style>
/* Course Header Styles */
.course-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    color: white;
    padding: 30px;
    border-radius: 10px;
    margin-bottom: 30px;
    position: relative;
}

.course-intro-box {
    background: #f8fafc;
    padding: 18px;
    border-radius: 10px;
    line-height: 1.7;
    font-size: 15px;
}

.course-intro-box strong {
    color: #2c7a7b;
}

.course-banner {
    width: 100%;
    height: 80px;
    background-size: cover;
    background-position: center;
    border-radius: 8px;

    display: flex;
    align-items: center;
    justify-content: center;
}

.course-banner-placeholder {
    background: rgba(0, 0, 0, 0.3);
    padding: 20px;
    border-radius: 8px;
    color: white;
    text-align: center;
}

.course-meta-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-top: 20px;
}

.meta-card {
    background: rgba(255, 255, 255, 0.1);
    padding: 15px;
    border-radius: 8px;
    backdrop-filter: blur(10px);
}

/* Tab Content Area */
.tab-content-area {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}


.class-card {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    margin-bottom: 15px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.class-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.class-card-header {
    background: #f8f9fa;
    padding: 15px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: background 0.3s ease;
}

.class-card-header:hover {
    background: #e9ecef;
}

.class-details {
    padding: 20px;
    border-top: 1px solid #dee2e6;
    background: white;
}


.slide-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 15px;
    background: #f8f9fa;
    border-radius: 6px;
    margin-bottom: 8px;
    transition: background 0.3s ease;
}

.slide-item:hover {
    background: #e9ecef;
}

/* Question Cards */
.question-card {
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 15px;
    transition: all 0.3s ease;
}

.question-card:hover {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.form-check-input {
    margin-right: 10px;
}

/* True/False specific styles */
.true-false-container {
    display: flex;
    gap: 20px;
    margin-top: 10px;
}

.true-false-option {
    display: flex;
    align-items: center;
    gap: 8px;
}

.true-false-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-weight: 500;
}

.true-badge {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.false-badge {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

/* Buttons */
.preview-btn {
    background: #282da7;
    color: white;
    border: none;
    /* padding: 6px 15px; */
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.3s ease;
}

.preview-btn:hover {
    background: #141985;
    transform: translateY(-1px);
}

/* Sticky Footer */
.sticky-footer {
    position: fixed;
    bottom: 0;
    left: 250px;
    right: 0;
    background: white;
    padding: 15px 20px;
    border-top: 2px solid #dee2e6;
    box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.1);
    z-index: 1050;
    transition: left 0.3s ease, width 0.3s ease;
}




.tab-content-area {
    padding-bottom: 100px;
}


.select-all-container {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 12px 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    border-left: 4px solid #667eea;
}


.nav-tabs {
    border-bottom: 2px solid #dee2e6;
    margin-bottom: 20px;
}

.nav-tabs .nav-link {
    border: none !important;
    color: #6c757d !important;
    font-weight: 500 !important;
    padding: 10px 20px !important;
    margin-right: 5px !important;
    border-radius: 8px 8px 0 0 !important;
    transition: all 0.3s ease !important;
}

.nav-tabs .nav-link:hover {
    color: #495057 !important;
    background-color: #f8f9fa !important;
}

.nav-tabs .nav-link.active {
    color: #fff !important;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    border: none !important;
    border-radius: 8px 8px 0 0 !important;
}

/* Badge Styles */
.badge-info {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    font-size: 14px;
    padding: 8px 15px;
    border-radius: 20px;
}

/* Submit Button */
.btn-success {
    background: linear-gradient(135deg, #28a745 0%, #218838 100%);
    border: none;
    padding: 10px 30px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-success:hover {
    background: linear-gradient(135deg, #218838 0%, #1e7e34 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
}

/* Course Introduction Card */
.card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
    margin-bottom: 25px;
}

.card-body {
    padding: 25px;
}

/* Correct Answer Highlight */
.text-success {
    color: #28a745 !important;
    font-weight: 600;
}

/* Long answer styles */
.long-answer {
    background: #f8f9fa;
    border-left: 4px solid #17a2b8;
    padding: 15px;
    border-radius: 6px;
    margin-top: 10px;
}

.long-answer-label {
    font-weight: 600;
    color: #17a2b8;
    margin-bottom: 5px;
}

/* Scrollbar Styling */
.tab-content-area::-webkit-scrollbar {
    width: 6px;
}

.tab-content-area::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.tab-content-area::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

.tab-content-area::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .content-wrapper {
        margin-left: 0 !important;
        width: 100% !important;
        padding: 15px;
    }

    .sticky-footer {
        left: 0 !important;
        width: 100% !important;
        padding: 10px 15px;
    }

    .course-header {
        padding: 20px;
    }

    .course-meta-grid {
        grid-template-columns: 1fr;
    }

    .course-banner {
        height: 200px;
    }
}

.tab-icon {
    color: #42147c !important;
}

/* Modal Enhancements */
.modal-content {
    border: none;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
}

.modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px 12px 0 0;
    padding: 20px;
}

/* Animation for class toggle */
.class-details {
    animation: slideDown 0.3s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Selection counts display */
.selection-counts {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.selection-count-item {
    background: #e9ecef;
    padding: 8px 15px;
    border-radius: 20px;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.selection-count-item i {
    font-size: 12px;
}
</style>

<!-- Main Content Wrapper -->
<div class="main-content">
    <section class="section">
        <div class="col-lg-12 text-center">
            <h4 style="color:darkblue;">Course Details</h4>
        </div>
        <!-- Course Banner -->







        <!-- Course Header -->
        <div class="course-header">
            <h1>{{ $course['course_name'] }}</h1>
            <p class="lead">{{ $course['course_description'] }}</p>

            <div class="course-meta-grid">
                <div class="meta-card">
                    <small>Category</small>
                    <div class="fw-bold">{{ $course['category'] }}</div>
                </div>
                <div class="meta-card">
                    <small>Role</small>
                    <div class="fw-bold">{{ $course['role'] }}</div>
                </div>
                <div class="meta-card">
                    <small>Designation</small>
                    <div class="fw-bold">{{ $course['designation'] }}</div>
                </div>
                <div class="meta-card">
                    <small>Type</small>
                    <div class="fw-bold">{{ $course['course_type'] ?? 'Technical' }}</div>
                </div>
                <div class="meta-card">
                    <small>Duration</small>
                    <div class="fw-bold">{{ $course['course_duration'] }}</div>
                </div>
                <div class="meta-card">
                    <small>Classes</small>
                    <div class="fw-bold">{{ $course['class_count'] }}</div>
                </div>
                <div class="meta-card">
                    <small>Completion Logic</small>
                    <div class="fw-bold">{{ $course['completion_points_logic'] }}</div>
                </div>
            </div>
        </div>

        <!-- Course Introduction -->
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="fas fa-info-circle mr-2"></i>Course Introduction
                </h5>

                <div class="course-intro-box">
                    {!! nl2br(e($course['course_introduction'])) !!}
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <ul class="nav nav-tabs" id="courseTabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#classes">
                    <i class="fas fa-book mr-2 tab-icon"></i>Classes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#quiz">
                    <i class="fas fa-question-circle mr-2 tab-icon"></i>Quiz
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#exam_section">
                    <i class="fas fa-graduation-cap mr-2 tab-icon"></i>Final Exam
                </a>
            </li>
        </ul>

        <div class="tab-content-area">
            <div class="tab-content">

                <div class="tab-pane fade show active" id="classes">
                    <div id="classesAccordion">
                        @foreach($course['classes'] as $cIndex => $class)
                        <div class="class-card">
                            <div class="class-card-header" onclick="toggleClass({{ $cIndex }})">
                                <div class="d-flex align-items-center">
                                    <!-- ADD THIS CHECKBOX -->
                                    <input type="checkbox" class="form-check-input class-check" id="class_{{ $cIndex }}"
                                        data-index="{{ $cIndex }}" checked disabled>
                                    <label class="mb-0 ml-2 fw-bold" for="class_{{ $cIndex }}">
                                        <i class="fas fa-chalkboard-teacher mr-2"></i>
                                        {{ $class['class_name'] }}
                                        <small class="text-muted ml-2">({{ $class['estimated_duration'] }})</small>
                                    </label>
                                </div>
                                <i class="fas fa-chevron-down text-secondary" id="classIcon{{ $cIndex }}"></i>
                            </div>

                            <div class="class-details" id="classDetails{{ $cIndex }}" style="display: none;">
                                <p class="mb-3">{{ $class['class_description'] }}</p>

                                @if(isset($class['video_slides']) && count($class['video_slides']) > 0)
                                <h6 class="mt-4 mb-3">
                                    <i class="fas fa-images mr-2"></i>Slides ({{ count($class['video_slides']) }})
                                </h6>
                                <div class="slides-container">
                                    @foreach($class['video_slides'] as $sIndex => $slide)
                                    <div class="slide-item">
                                        <span class="d-flex align-items-center">
                                            <i class="fas fa-file-powerpoint mr-2"></i>
                                            Slide {{ $sIndex + 1 }}: {{ $slide['title'] }}
                                        </span>
                                        <button type="button" class="preview-btn"
                                            onclick="showSlideModal('{{ $slide['title'] }}', `{{ addslashes($slide['visual_text']) }}`, `{{ addslashes($slide['voiceover_script']) }}`, '{{ $slide['voiceover_audio_url'] ?? '' }}')">
                                            <i class="fas fa-eye mr-1"></i> Preview
                                        </button>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Quiz Tab -->
                <div class="tab-pane fade" id="quiz">
                    <div class="select-all-container">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="selectAllQuiz" checked>
                            <label class="form-check-label fw-bold" for="selectAllQuiz">
                                <i class="fas fa-check-double mr-2"></i>Select All Quiz Questions
                            </label>
                        </div>
                    </div>

                    @foreach($course['classes'] as $cIndex => $class)
                    @if(isset($class['quiz']) && !empty(array_filter($class['quiz'])))
                    <div class="mb-4">
                        <h5 class="card-title">
                            <i class="fas fa-chalkboard-teacher mr-2"></i>{{ $class['class_name'] }}
                        </h5>

                        <!-- Long Answer Questions -->
                        @if(isset($class['quiz']['long']) && count($class['quiz']['long']) > 0)
                        <h6 class="mb-3 text-secondary">
                            <i class="fas fa-align-left mr-2"></i>Long Answer Questions
                        </h6>
                        @foreach($class['quiz']['long'] as $qIndex => $q)
                        <div class="question-card">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input question-check"
                                    id="quiz_long_{{ $cIndex }}_{{ $qIndex }}" data-type="long"
                                    data-class="{{ $cIndex }}" data-index="{{ $qIndex }}" checked>
                                <label class="form-check-label fw-bold" for="quiz_long_{{ $cIndex }}_{{ $qIndex }}">
                                    {{ $q['question_text'] }}
                                </label>
                            </div>
                            <div class="long-answer mt-2">
                                <div class="long-answer-label">Answer:</div>
                                <div>{{ $q['answer'] }}</div>
                            </div>
                        </div>
                        @endforeach
                        @endif

                        <!-- MCQ Questions -->
                        @if(isset($class['quiz']['mcq']) && count($class['quiz']['mcq']) > 0)
                        <h6 class="mb-3 text-secondary">
                            <i class="fas fa-list-ol mr-2"></i>MCQ Questions
                        </h6>
                        @foreach($class['quiz']['mcq'] as $qIndex => $q)
                        <div class="question-card">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input question-check"
                                    id="quiz_mcq_{{ $cIndex }}_{{ $qIndex }}" data-type="mcq" data-class="{{ $cIndex }}"
                                    data-index="{{ $qIndex }}" checked>
                                <label class="form-check-label fw-bold" for="quiz_mcq_{{ $cIndex }}_{{ $qIndex }}">
                                    {{ $q['question_text'] }}
                                </label>
                            </div>
                            <ul class="list-unstyled ml-4 mt-2">
                                @foreach($q['options'] as $opt)
                                <li
                                    class="{{ $opt['option_id'] == $q['correct_option_id'] ? 'text-success' : '' }} mb-1">
                                    <i class="fas fa-circle fa-xs mr-2"></i>
                                    {{ $opt['option_id'] }}. {{ $opt['text'] }}
                                    @if($opt['option_id'] == $q['correct_option_id'])
                                    <small class="badge badge-success ml-2">
                                        <i class="fas fa-check mr-1"></i>Correct
                                    </small>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endforeach
                        @endif

                        <!-- Short Answer Questions -->
                        @if(isset($class['quiz']['short']) && count($class['quiz']['short']) > 0)
                        <h6 class="mb-3 text-secondary">
                            <i class="fas fa-pen-alt mr-2"></i>Short Answer Questions
                        </h6>
                        @foreach($class['quiz']['short'] as $qIndex => $q)
                        <div class="question-card">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input question-check"
                                    id="quiz_short_{{ $cIndex }}_{{ $qIndex }}" data-type="short"
                                    data-class="{{ $cIndex }}" data-index="{{ $qIndex }}" checked>
                                <label class="form-check-label fw-bold" for="quiz_short_{{ $cIndex }}_{{ $qIndex }}">
                                    {{ $q['question_text'] }}
                                </label>
                            </div>
                            <div class="bg-light p-3 rounded mt-2 border">
                                <strong><i class="fas fa-lightbulb mr-2 text-warning"></i>Answer:</strong>
                                <span class="ml-1">{{ $q['answer'] }}</span>
                            </div>
                        </div>
                        @endforeach
                        @endif

                        <!-- True/False Questions -->
                        @if(isset($class['quiz']['true_false']) && count($class['quiz']['true_false']) > 0)
                        <h6 class="mb-3 text-secondary">
                            <i class="fas fa-check-circle mr-2"></i>True/False Questions
                        </h6>
                        @foreach($class['quiz']['true_false'] as $qIndex => $q)
                        <div class="question-card">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input question-check"
                                    id="quiz_tf_{{ $cIndex }}_{{ $qIndex }}" data-type="true_false"
                                    data-class="{{ $cIndex }}" data-index="{{ $qIndex }}" checked>
                                <label class="form-check-label fw-bold" for="quiz_tf_{{ $cIndex }}_{{ $qIndex }}">
                                    {{ $q['question_text'] }}
                                </label>
                            </div>
                            <div class="true-false-container mt-2">
                                <!-- <div class="true-false-option">
                                <span class="true-false-badge true-badge">True,{{ $q['answer'] }}</span>
                                @if($q['answer'] == 'True')
                                <small class="badge badge-success ml-2">
                                    <i class="fas fa-check mr-1"></i>Correct Answer
                                </small>
                                @endif
                            </div>
                            <div class="true-false-option">
                                <span class="true-false-badge false-badge">False</span>
                                @if($q['answer'] == 'False')
                                <small class="badge badge-success ml-2">
                                    <i class="fas fa-check mr-1"></i>Correct Answer
                                </small>
                                @endif
                            </div> -->
                                <div class="mt-2">
                                    <small class="text-success">
                                        <i class="fas fa-check mr-1"></i>
                                        Correct Answer:
                                        {{ $q['answer'] == 'True' ? 'True' : 'False' }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    @endif
                    @endforeach
                </div>

                <!-- Final Exam Tab -->
                <div class="tab-pane fade" id="exam_section">
                    <div class="select-all-container">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="selectAllExam" checked>
                            <label class="form-check-label fw-bold" for="selectAllExam">
                                <i class="fas fa-check-double mr-2"></i>Select All Exam Questions
                            </label>
                        </div>
                    </div>

                    <!-- Long Answer Questions -->
                    @if(isset($course['final_exam']['long']) && count($course['final_exam']['long']) > 0)
                    <h6 class="mb-3 text-secondary">
                        <i class="fas fa-align-left mr-2"></i>Long Answer Questions
                    </h6>
                    @foreach($course['final_exam']['long'] as $qIndex => $q)
                    <div class="question-card">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input question-check" id="exam_long_{{ $qIndex }}"
                                data-type="long" data-index="{{ $qIndex }}" checked>
                            <label class="form-check-label fw-bold" for="exam_long_{{ $qIndex }}">
                                {{ $q['question_text'] }}
                            </label>
                        </div>
                        <div class="long-answer mt-2">
                            <div class="long-answer-label">Answer:</div>
                            <div>{{ $q['answer'] }}</div>
                        </div>
                    </div>
                    @endforeach
                    @endif

                    <!-- MCQ Questions -->
                    @if(isset($course['final_exam']['mcq']) && count($course['final_exam']['mcq']) > 0)
                    <h6 class="mb-3 text-secondary">
                        <i class="fas fa-list-ol mr-2"></i>MCQ Questions
                    </h6>
                    @foreach($course['final_exam']['mcq'] as $qIndex => $q)
                    <div class="question-card">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input question-check" id="exam_mcq_{{ $qIndex }}"
                                data-type="mcq" data-index="{{ $qIndex }}" checked>
                            <label class="form-check-label fw-bold" for="exam_mcq_{{ $qIndex }}">
                                {{ $q['question_text'] }}
                            </label>
                        </div>
                        <ul class="list-unstyled ml-4 mt-2">
                            @foreach($q['options'] as $opt)
                            <li class="{{ $opt['option_id'] == $q['correct_option_id'] ? 'text-success' : '' }} mb-1">
                                <i class="fas fa-circle fa-xs mr-2"></i>
                                {{ $opt['option_id'] }}. {{ $opt['text'] }}
                                @if($opt['option_id'] == $q['correct_option_id'])
                                <small class="badge badge-success ml-2">
                                    <i class="fas fa-check mr-1"></i>Correct
                                </small>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endforeach
                    @endif

                    <!-- Short Answer Questions -->
                    @if(isset($course['final_exam']['short']) && count($course['final_exam']['short']) > 0)
                    <h6 class="mb-3 text-secondary">
                        <i class="fas fa-pen-alt mr-2"></i>Short Answer Questions
                    </h6>
                    @foreach($course['final_exam']['short'] as $qIndex => $q)
                    <div class="question-card">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input question-check" id="exam_short_{{ $qIndex }}"
                                data-type="short" data-index="{{ $qIndex }}" checked>
                            <label class="form-check-label fw-bold" for="exam_short_{{ $qIndex }}">
                                {{ $q['question_text'] }}
                            </label>
                        </div>
                        <div class="bg-light p-3 rounded mt-2 border">
                            <strong><i class="fas fa-lightbulb mr-2 text-warning"></i>Answer:</strong>
                            <span class="ml-1">{{ $q['answer'] }}</span>
                        </div>
                    </div>
                    @endforeach
                    @endif

                    <!-- True/False Questions -->
                    @if(isset($course['final_exam']['true_false']) && count($course['final_exam']['true_false']) > 0)
                    <h6 class="mb-3 text-secondary">
                        <i class="fas fa-check-circle mr-2"></i>True/False Questions
                    </h6>
                    @foreach($course['final_exam']['true_false'] as $qIndex => $q)
                    <div class="question-card">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input question-check" id="exam_tf_{{ $qIndex }}"
                                data-type="true_false" data-index="{{ $qIndex }}" checked>
                            <label class="form-check-label fw-bold" for="exam_tf_{{ $qIndex }}">
                                {{ $q['question_text'] }}
                            </label>
                        </div>
                        <div class="true-false-container mt-2">
                            <div class="true-false-option">
                                <span class="true-false-badge true-badge">True</span>
                                @if($q['answer'] == 'True')
                                <small class="badge badge-success ml-2">
                                    <i class="fas fa-check mr-1"></i>Correct Answer
                                </small>
                                @endif
                            </div>
                            <div class="true-false-option">
                                <span class="true-false-badge false-badge">False</span>
                                @if($q['answer'] == 'False')
                                <small class="badge badge-success ml-2">
                                    <i class="fas fa-check mr-1"></i>Correct Answer
                                </small>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
            <form action="{{ route('ai_course_store') }}" method="post" id="courseForm">
                @csrf
                <input type="hidden" name="course_data" id="courseData"
                    value="{{ json_encode($course, JSON_UNESCAPED_UNICODE) }}">
                <input type="hidden" name="selected_questions" id="selectedQuestions" value="">


                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="selection-counts" id="selectionCounts">
                            <div class="selection-count-item">
                                <i class="fas fa-book"></i>
                                <span id="classCount">Classes: 0</span>
                            </div>
                            <div class="selection-count-item">
                                <i class="fas fa-question-circle"></i>
                                <span id="quizCount">Quiz: 0</span>
                            </div>
                            <div class="selection-count-item">
                                <i class="fas fa-graduation-cap"></i>
                                <span id="examCount">Exam: 0</span>
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-success btn-lg px-4 py-2" id="submitBtn">
                                <i class="fas fa-paper-plane mr-2"></i>
                                <span id="submitText">Submit Course</span>
                                <span id="submitSpinner" class="spinner-border spinner-border-sm ml-2 d-none"
                                    role="status" aria-hidden="true"></span>
                            </button>
                            <a href="{{ route('ai_course_create') }}" class="btn btn-secondary btn-lg px-4 py-2 ml-3">
                                <i class="fas fa-times mr-2"></i>
                                Cancel
                            </a>

                        </div>
                    </div>

            </form>
        </div>

    </section>
</div>




<!-- Slide Modal -->
<div class="modal fade" id="slideModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="slideModalTitle"></h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <h6><i class="fas fa-list-alt mr-2"></i>Slide Content:</h6>
                    <div id="slideContent" class="border p-3 rounded"></div>
                </div>
                <div class="mt-4">
                    <h6><i class="fas fa-microphone mr-2"></i>Voice-over Script:</h6>
                    <div id="voiceoverScript" class="bg-light p-3 rounded border"></div>
                </div>
                <div id="audioSection" class="mt-4" style="display: none;">
                    <h6><i class="fas fa-volume-up mr-2"></i>Audio:</h6>
                    <audio controls id="slideAudio" class="w-100"></audio>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
// ==========================
// Class toggle
// ==========================
function toggleClass(index) {
    const details = document.getElementById('classDetails' + index);
    const icon = document.getElementById('classIcon' + index);

    if (details.style.display === 'none') {
        details.style.display = 'block';
        icon.classList.remove('fa-chevron-down');
        icon.classList.add('fa-chevron-up');
    } else {
        details.style.display = 'none';
        icon.classList.remove('fa-chevron-up');
        icon.classList.add('fa-chevron-down');
    }
}

// ==========================
// Slide modal
// ==========================
function showSlideModal(title, content, script, audioUrl) {
    document.getElementById('slideModalTitle').textContent = title;
    document.getElementById('slideContent').innerHTML = content;
    document.getElementById('voiceoverScript').textContent = script;

    const audioSection = document.getElementById('audioSection');
    const audioElement = document.getElementById('slideAudio');

    if (audioUrl && audioUrl.trim() !== '') {
        audioSection.style.display = 'block';
        audioElement.src = audioUrl;
        audioElement.load();
    } else {
        audioSection.style.display = 'none';
    }

    $('#slideModal').modal('show');
}

// ==========================
// Update counts
// ==========================
function updateCounts() {
    const classCount = document.querySelectorAll('.class-check:checked').length;
    const quizCount = document.querySelectorAll('#quiz .question-check:checked').length;
    const examCount = document.querySelectorAll('#exam_section .question-check:checked').length;

    document.getElementById('classCount').textContent = `Classes: ${classCount}`;
    document.getElementById('quizCount').textContent = `Quiz: ${quizCount}`;
    document.getElementById('examCount').textContent = `Exam: ${examCount}`;
}

// ==========================
// Select All (Quiz / Exam)
// ==========================
const selectAllQuiz = document.getElementById('selectAllQuiz');
const selectAllExam = document.getElementById('selectAllExam');

if (selectAllQuiz) {
    selectAllQuiz.addEventListener('change', function() {
        document
            .querySelectorAll('#quiz .question-check')
            .forEach(cb => cb.checked = this.checked);
        updateCounts();
    });
}

if (selectAllExam) {
    selectAllExam.addEventListener('change', function() {
        document
            .querySelectorAll('#exam_section .question-check')
            .forEach(cb => cb.checked = this.checked);
        updateCounts();
    });
}

// ==========================
// Checkbox change listener
// ==========================
document.addEventListener('change', function(e) {
    if (e.target.matches('.class-check, .question-check')) {
        updateCounts();
    }
});

// ==========================
// Form submit
// ==========================
// ==========================
// Form submit
// ==========================
document.getElementById('courseForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const selected = {
        classes: [],
        quiz: [],
        exam: []
    };

    // Classes
    document.querySelectorAll('.class-check:checked').forEach(cb => {
        selected.classes.push(parseInt(cb.dataset.index));
    });

    // Quiz questions
    document.querySelectorAll('#quiz .question-check').forEach(cb => {
        if (cb.checked) {
            selected.quiz.push({
                type: cb.dataset.type,
                classIndex: parseInt(cb.dataset.class),
                questionIndex: parseInt(cb.dataset.index)
            });
        }
    });

    // Exam questions
    document.querySelectorAll('#exam_section .question-check').forEach(cb => {
        if (cb.checked) {
            selected.exam.push({
                type: cb.dataset.type,
                questionIndex: parseInt(cb.dataset.index)
            });
        }
    });

    // Get original course data
    const originalCourseData = JSON.parse(document.getElementById('courseData').value);
    const filteredCourseData = JSON.parse(JSON.stringify(originalCourseData)); // Deep clone

    // Filter quiz questions
    filteredCourseData.classes = filteredCourseData.classes.map((classItem, classIndex) => {
        if (!selected.classes.includes(classIndex)) {
            // Remove quiz from unselected classes
            delete classItem.quiz;
            return classItem;
        }

        // For selected classes, filter quiz questions
        if (classItem.quiz) {
            const filteredQuiz = {};

            // Filter each question type
            ['long', 'mcq', 'short', 'true_false'].forEach(type => {
                if (classItem.quiz[type]) {
                    filteredQuiz[type] = classItem.quiz[type].filter((question, qIndex) => {
                        return selected.quiz.some(s =>
                            s.classIndex === classIndex &&
                            s.type === type &&
                            s.questionIndex === qIndex
                        );
                    });
                }
            });

            classItem.quiz = filteredQuiz;
        }

        return classItem;
    });

    // Filter final exam questions
    if (filteredCourseData.final_exam) {
        const filteredExam = {};

        ['long', 'mcq', 'short', 'true_false'].forEach(type => {
            if (filteredCourseData.final_exam[type]) {
                filteredExam[type] = filteredCourseData.final_exam[type].filter((question, qIndex) => {
                    return selected.exam.some(s =>
                        s.type === type &&
                        s.questionIndex === qIndex
                    );
                });
            }
        });

        filteredCourseData.final_exam = filteredExam;
    }

    // Remove classes that weren't selected
    filteredCourseData.classes = filteredCourseData.classes.filter((_, index) =>
        selected.classes.includes(index)
    );

    // Update counts in the course data
    filteredCourseData.class_count = filteredCourseData.classes.length;

    // Update course data in the hidden field
    document.getElementById('courseData').value = JSON.stringify(filteredCourseData);
    document.getElementById('selectedQuestions').value = JSON.stringify(selected);

    // if (
    //     confirm(
    //         `Submit with ${selected.classes.length} classes, ` +
    //         `${selected.quiz.length} quiz questions, ` +
    //         `${selected.exam.length} exam questions?`
    //     )
    // ) {
    // console.log('Filtered course data:', filteredCourseData);
    this.submit();
    // }
});

// ==========================
// Layout adjustment
// ==========================
function adjustLayoutForSidebar() {
    const body = document.body;
    const contentWrapper = document.querySelector('.content-wrapper');
    const stickyFooter = document.querySelector('.sticky-footer');

    const isCollapsed =
        body.classList.contains('sidebar-collapsed') ||
        body.classList.contains('collapsed') ||
        body.classList.contains('mini-sidebar');

    if (isCollapsed) {
        contentWrapper.style.marginLeft = '70px';
        contentWrapper.style.width = 'calc(100% - 70px)';
        stickyFooter.style.left = '70px';
        stickyFooter.style.width = 'calc(100% - 70px)';
    } else {
        contentWrapper.style.marginLeft = '250px';
        contentWrapper.style.width = 'calc(100% - 250px)';
        stickyFooter.style.left = '250px';
        stickyFooter.style.width = 'calc(100% - 250px)';
    }
}

// ==========================
// Init
// ==========================
document.addEventListener('DOMContentLoaded', function() {
    updateCounts();

    if (document.querySelector('.class-card')) {
        toggleClass(0);
    }

    console.log(
        'Course Data:',
        document.getElementById('courseData').value.substring(0, 100) + '...'
    );
    console.log(
        'Selected Questions:',
        document.getElementById('selectedQuestions').value
    );

    adjustLayoutForSidebar();

    const observer = new MutationObserver(adjustLayoutForSidebar);
    observer.observe(document.body, {
        attributes: true,
        attributeFilter: ['class']
    });

    $('#courseTabs a').on('click', function(e) {
        e.preventDefault();
        $(this).tab('show');
    });
});

window.addEventListener('resize', adjustLayoutForSidebar);
</script>
<script>
document.getElementById('courseForm').addEventListener('submit', function() {
    // Get elements

    const spinner = document.getElementById('submitSpinner');
    const button = document.getElementById('submitBtn');
    const buttonText = document.getElementById('submitText');

    // Disable button and show spinner
    spinner.classList.remove('d-none');
    button.disabled = true;
    buttonText.textContent = 'Submitting...';

    // The form will submit normally and redirect to your list page
    // No need for async/await or fetch if you're doing server-side redirect
});
</script>


@endsection