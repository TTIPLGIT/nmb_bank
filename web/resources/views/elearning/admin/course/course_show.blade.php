@extends('layouts.adminnav')

@section('content')

<style>
/* Modern Show Screen Styling */
.show-course-container {
    padding: 20px;
    background: #f8f9fc;
    min-height: calc(100vh - 100px);
}

.show-card {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.show-card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 20px 24px;
}

.show-card-header h4 {
    margin: 0;
    color: white;
    font-weight: 600;
    text-align: center;
}

.show-card-body {
    padding: 30px 24px;
}

.info-section {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 24px;
}

.section-title {
    font-size: 16px;
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 16px;
    padding-bottom: 8px;
    border-bottom: 2px solid #e2e8f0;
}

.info-row {
    display: flex;
    margin-bottom: 16px;
    flex-wrap: wrap;
}

.info-label {
    width: 180px;
    font-weight: 600;
    color: #2d3748;
    flex-shrink: 0;
}

.info-value {
    flex: 1;
    color: #4a5568;
}

.badge-status {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

.badge-paid {
    background: #d4edda;
    color: #155724;
}

.badge-free {
    background: #e2e3e5;
    color: #383d41;
}

.badge-yes {
    background: #d4edda;
    color: #155724;
}

.badge-no {
    background: #f8d7da;
    color: #721c24;
}

.badge-exam {
    background: #d1ecf1;
    color: #0c5460;
}

.preview-image {
    width: 200px;
    height: auto;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    padding: 4px;
    background: white;
}

.preview-iframe {
    width: 100%;
    max-width: 300px;
    height: 170px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
}

.select2-container--disabled .select2-selection {
    background-color: #e9ecef !important;
    opacity: 0.8;
}

.select2-container--disabled .select2-selection__choice {
    background-color: #680EDA !important;
    color: white;
}

.select2-container--disabled .select2-selection__choice__remove {
    display: none;
}

.form-control[disabled] {
    background-color: #e9ecef;
    opacity: 1;
}

.btn-back {
    background: #6c757d;
    border: none;
    padding: 10px 32px;
    font-weight: 500;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn-back:hover {
    background: #5a6268;
    transform: translateY(-2px);
}

.two-column-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
}

@media (max-width: 768px) {
    .two-column-grid {
        grid-template-columns: 1fr;
    }

    .info-row {
        flex-direction: column;
    }

    .info-label {
        width: 100%;
        margin-bottom: 4px;
    }
}

.tag-container {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.tag {
    background: #e9ecef;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    color: #495057;
}

.file-preview {
    background: #f1f3f5;
    border-radius: 8px;
    padding: 12px;
    text-align: center;
}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<div class="main-content">
    <div class="show-course-container">
        {{ Breadcrumbs::render('show_course') }}

        @if (session('success'))
        <input type="hidden" name="session_data" id="session_data" value="{{ session('success') }}">
        <script>
        $(document).ready(function() {
            Swal.fire({
                title: "Success",
                text: $('#session_data').val(),
                icon: "success",
                confirmButtonColor: "#667eea"
            });
        });
        </script>
        @elseif(session('error'))
        <input type="hidden" name="session_data" id="session_data1" value="{{ session('error') }}">
        <script>
        $(window).on('load', function() {
            Swal.fire({
                title: "Info",
                text: $('#session_data1').val(),
                icon: "info",
                confirmButtonColor: "#667eea"
            });
        });
        </script>
        @endif

        @php
        $course = $rows1['elearning_courses']->first();
        $userIds = explode(',', $course->user_ids ?? '');
        $classIds = explode(',', $course->course_classes ?? '');
        @endphp

        <div class="show-card">
            <div class="show-card-header">
                <h4><i class="fas fa-info-circle"></i> Course Information</h4>
            </div>

            <div class="show-card-body">
                <!-- Category, Role, Designation Row -->
                <div class="info-section">
                    <div class="section-title">
                        <i class="fas fa-tag"></i> Basic Information
                    </div>
                    <div class="two-column-grid">
                        <div class="info-row">
                            <div class="info-label">Category:</div>
                            <div class="info-value">
                                @foreach($rows['course_catagory_name'] as $data)
                                @if($course->course_category == $data->catagory_id)
                                {{$data->catagory_name}}
                                @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Role:</div>
                            <div class="info-value">
                                @foreach($roles as $values)
                                @if($course->role_id == $values->role_id)
                                {{ $values->role_name }}
                                @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Designation:</div>
                            <div class="info-value">
                                @foreach($rows['designation'] as $values)
                                @if($course->designation_id == $values->designation_id)
                                {{ $values->designation_name }}
                                @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Assigned Users:</div>
                            <div class="info-value">
                                @foreach($rows['users'] as $userId)
                                @if(in_array($userId->id, $userIds))
                                <span class="tag">{{$userId->name}}</span>
                                @endif
                                @endforeach
                                @if(empty(array_filter($userIds)))
                                <span class="text-muted">No users assigned</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Course Details -->
                <div class="info-section">
                    <div class="section-title">
                        <i class="fas fa-book"></i> Course Details
                    </div>
                    <div class="two-column-grid">
                        <div class="info-row">
                            <div class="info-label">Course Name:</div>
                            <div class="info-value">{{ $course->course_name ?? 'N/A' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Course Type:</div>
                            <div class="info-value">
                                <span
                                    class="badge-status {{ $course->course_pay == 'paid' ? 'badge-paid' : 'badge-free' }}">
                                    {{ ucfirst($course->course_pay) }}
                                </span>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Certificate:</div>
                            <div class="info-value">
                                <span
                                    class="badge-status {{ $course->course_certificate == 1 ? 'badge-yes' : 'badge-no' }}">
                                    {{ $course->course_certificate == 1 ? 'Yes' : 'No' }}
                                </span>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Exam Required:</div>
                            <div class="info-value">
                                <span class="badge-status {{ $course->course_exam == 1 ? 'badge-exam' : 'badge-no' }}">
                                    {{ $course->course_exam == 1 ? 'Yes' : 'No' }}
                                </span>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Has Start/End Period:</div>
                            <div class="info-value">
                                <span
                                    class="badge-status {{ $course->course_noperiod == 1 ? 'badge-yes' : 'badge-no' }}">
                                    {{ $course->course_noperiod == 1 ? 'Yes' : 'No' }}
                                </span>
                            </div>
                        </div>
                        @if($course->course_noperiod == 1)
                        <div class="info-row">
                            <div class="info-label">Start Date:</div>
                            <div class="info-value">{{ $course->course_start_period ?? 'N/A' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">End Date:</div>
                            <div class="info-value">{{ $course->course_end_period ?? 'N/A' }}</div>
                        </div>
                        @endif
                        <div class="info-row">
                            <div class="info-label">Pass Percentage:</div>
                            <div class="info-value">{{ $course->pass_percentage ?? '0' }}%</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Course Instructor:</div>
                            <div class="info-value">{{ $course->course_instructor ?? 'N/A' }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">CPD Points:</div>
                            <div class="info-value">{{ $course->course_cpt_points ?? '0' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Exam Details (if exam enabled) -->
                @if($course->course_exam == 1)
                <div class="info-section">
                    <div class="section-title">
                        <i class="fas fa-file-alt"></i> Exam Details
                    </div>
                    <div class="two-column-grid">
                        <div class="info-row">
                            <div class="info-label">Exam Name:</div>
                            <div class="info-value">
                                @foreach($rows1['exam_list'] as $exam)
                                @if(is_object($exam) && $course->exam_id == $exam->id)
                                {{ $exam->exam_name }}
                                @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Exam Date:</div>
                            <div class="info-value">{{ $course->exam_date ?? 'Not set' }}</div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Certificate Details (if certificate enabled) -->
                @if($course->course_certificate == 1)
                <div class="info-section">
                    <div class="section-title">
                        <i class="fas fa-certificate"></i> Certificate Details
                    </div>
                    <div class="two-column-grid">
                        <div class="info-row">
                            <div class="info-label">Certificate Template:</div>
                            <div class="info-value">
                                @foreach($rows1['certificate_templates'] as $row)
                                @if($course->cetificate_template == $row->certificate_templates_id)
                                {{ $row->template_name }}
                                @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Certificate Expiry:</div>
                            <div class="info-value">
                                <span
                                    class="badge-status {{ $course->certificate_expiry == 1 ? 'badge-yes' : 'badge-no' }}">
                                    {{ $course->certificate_expiry == 1 ? 'Yes' : 'No' }}
                                </span>
                            </div>
                        </div>
                        @if($course->certificate_expiry == 1)
                        <div class="info-row">
                            <div class="info-label">Expiry Date:</div>
                            <div class="info-value">{{ $course->course_expiry_period ?? 'Not set' }}</div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Classes -->
                <div class="info-section">
                    <div class="section-title">
                        <i class="fas fa-users"></i> Assigned Classes
                    </div>
                    <div class="tag-container">
                        @foreach($rows['elearning_classes'] as $data)
                        @if(in_array($data->class_id, $classIds))
                        <span class="tag">{{ $data->class_name }}</span>
                        @endif
                        @endforeach
                        @if(empty(array_filter($classIds)))
                        <span class="text-muted">No classes assigned</span>
                        @endif
                    </div>
                </div>

                <!-- Descriptions & Skills -->
                <div class="info-section">
                    <div class="section-title">
                        <i class="fas fa-align-left"></i> Description & Skills
                    </div>
                    <div class="info-row">
                        <div class="info-label">Course Description:</div>
                        <div class="info-value">{{ $course->course_description ?? 'N/A' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Course Tags:</div>
                        <div class="info-value">{{ $course->course_tags ?? 'N/A' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Skills Required:</div>
                        <div class="info-value">{{ $course->course_skills_required ?? 'N/A' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Gain Skills:</div>
                        <div class="info-value">{{ $course->course_gain_skills ?? 'N/A' }}</div>
                    </div>
                </div>

                <!-- Media Files -->
                <div class="info-section">
                    <div class="section-title">
                        <i class="fas fa-image"></i> Media Files
                    </div>
                    <div class="two-column-grid">
                        <div class="file-preview">
                            <label class="info-label">Course Introduction:</label>
                            @if(!empty($course->course_introduction))
                            <iframe
                                src="{{ config('setting.profile_url').$course->introduction_path.'/'.$course->course_introduction }}"
                                class="preview-iframe"></iframe>
                            @else
                            <p class="text-muted">No introduction video</p>
                            @endif
                        </div>
                        <div class="file-preview">
                            <label class="info-label">Course Banner:</label>
                            @if(!empty($course->course_banner))
                            <img src="{{ config('setting.profile_url').$course->banner_path.'/'.$course->course_banner }}"
                                class="preview-image" alt="Course Banner">
                            @else
                            <img src="{{ config('setting.profile_url') }}uploads/class/126/empty.jpg"
                                class="preview-image" alt="Default Banner">
                            @endif
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize select2 if needed (disabled for show mode)
    $('.js-select5').select2({
        width: '100%',
        placeholder: "Select Class Name",
        closeOnSelect: false,
        allowClear: true
    });

    $(".select2").select2({
        closeOnSelect: false,
        placeholder: "Select User Name",
        allowHtml: true,
        allowClear: true,
        tags: true
    });

    // Disable select2 for show mode
    $('.select2').prop('disabled', true);
    $('.js-select5').prop('disabled', true);
});
</script>

<!-- SweetAlert2 for better notifications -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection