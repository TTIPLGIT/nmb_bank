@extends('layouts.adminnav')

@section('content')
<style>
:root {
    --primary: #4361ee;
    --primary-dark: #3a56d4;
    --success: #2ecc71;
    --warning: #f39c12;
    --danger: #e74c3c;
    --info: #3498db;
    --dark: #2c3e50;
    --light: #ecf0f1;
    --gray: #95a5a6;
    --white: #ffffff;
    --shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    --shadow-hover: 0 4px 15px rgba(0, 0, 0, 0.12);
}

.container-fluid {
    background: #f8f9fc;
    min-height: 100vh;
}

/* Header Section */
.header-section {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    border-radius: 16px;
    padding: 25px 30px;
    margin-bottom: 25px;
    color: white;
    box-shadow: var(--shadow);
}

.header-section h1 {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 8px;
}

/* Stat Cards */
.stat-card {
    background: var(--white);
    border: none;
    border-radius: 16px;
    transition: all 0.3s ease;
    box-shadow: var(--shadow);
    overflow: hidden;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-hover);
}

.stat-card .card-body {
    padding: 20px;
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.stat-icon.primary {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
}

.stat-icon.danger {
    background: linear-gradient(135deg, var(--danger), #c0392b);
    color: white;
}

.stat-icon.warning {
    background: linear-gradient(135deg, var(--warning), #e67e22);
    color: white;
}

.stat-icon.success {
    background: linear-gradient(135deg, var(--success), #27ae60);
    color: white;
}

.stat-value {
    font-size: 28px;
    font-weight: 700;
    color: var(--dark);
    line-height: 1.2;
    margin-bottom: 5px;
}

.stat-label {
    font-size: 13px;
    color: var(--gray);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 500;
}

/* Course Sections (Admin View) */
.course-section {
    background: var(--white);
    border-radius: 16px;
    margin-bottom: 20px;
    box-shadow: var(--shadow);
    transition: all 0.3s ease;
    overflow: hidden;
}

.course-section:hover {
    box-shadow: var(--shadow-hover);
}

.course-header {
    padding: 18px 22px;
    cursor: pointer;
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    background: var(--white);
}

.course-header:hover {
    background: #fafbfc;
}

.course-header.high-risk {
    border-left-color: var(--danger);
}

.course-header.medium-risk {
    border-left-color: var(--warning);
}

.course-header.low-risk {
    border-left-color: var(--success);
}

.course-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0;
}

.course-stats {
    display: inline-flex;
    gap: 12px;
    align-items: center;
    flex-wrap: wrap;
}

.stat-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.stat-badge.students {
    background: #e8f0fe;
    color: var(--primary);
}

.stat-badge.high {
    background: rgba(231, 76, 60, 0.1);
    color: var(--danger);
}

.stat-badge.medium {
    background: rgba(243, 156, 18, 0.1);
    color: var(--warning);
}

.stat-badge.low {
    background: rgba(46, 204, 113, 0.1);
    color: var(--success);
}

/* Risk Badges */
.risk-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 14px;
    border-radius: 25px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.risk-badge.high {
    background: linear-gradient(135deg, #f093fb, #f5576c);
    color: white;
}

.risk-badge.medium {
    background: linear-gradient(135deg, #fa709a, #fee140);
    color: #2c3e50;
}

.risk-badge.low {
    background: linear-gradient(135deg, #4facfe, #00f2fe);
    color: white;
}

/* User Course Cards (User View) */
.user-course-card {
    background: var(--white);
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: var(--shadow);
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
}

.user-course-card:hover {
    transform: translateX(5px);
    box-shadow: var(--shadow-hover);
}

.user-course-card.high {
    border-left-color: var(--danger);
}

.user-course-card.medium {
    border-left-color: var(--warning);
}

.user-course-card.low {
    border-left-color: var(--success);
}

/* Probability Bar */
.probability-wrapper {
    flex: 1;
}

.probability-bar-container {
    background: #f0f0f0;
    border-radius: 10px;
    height: 8px;
    overflow: hidden;
}

.probability-fill {
    height: 100%;
    border-radius: 10px;
    transition: width 0.6s ease;
}

.probability-fill.high {
    background: linear-gradient(90deg, #f093fb, #f5576c);
}

.probability-fill.medium {
    background: linear-gradient(90deg, #fa709a, #fee140);
}

.probability-fill.low {
    background: linear-gradient(90deg, #4facfe, #00f2fe);
}

.probability-text {
    font-size: 13px;
    font-weight: 700;
    color: var(--dark);
    min-width: 45px;
}

.reason-text {
    font-size: 15px;
    color: black;
    line-height: 1.5;
    background: #f8f9fa;
    padding: 12px;
    border-radius: 12px;
    margin-top: 12px;
    border-left: 3px solid var(--primary);
}

/* Buttons */
.btn-gradient {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    border: none;
    padding: 8px 20px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-gradient:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(67, 97, 238, 0.4);
    color: white;
}

.btn-outline-gradient {
    background: transparent;
    border: 2px solid var(--primary);
    color: var(--primary);
    padding: 6px 18px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-outline-gradient:hover {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    transform: translateY(-2px);
}

/* User Row (Admin View) */
.user-row {
    background: #fafbfd;
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 12px;
    transition: all 0.3s ease;
}

.user-row:hover {
    background: #ffffff;
    transform: translateX(5px);
    box-shadow: var(--shadow);
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 14px;
}

/* Modal */
.modal-content-gradient {
    border-radius: 20px;
    overflow: hidden;
    border: none;
}

.modal-header-gradient {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    border: none;
    padding: 20px 25px;
}

.modal-header-gradient .close {
    color: white;
    opacity: 0.8;
    text-shadow: none;
}

/* Toggle Icon */
.toggle-icon {
    transition: transform 0.3s ease;
    font-size: 18px;
    color: var(--primary);
}

.toggle-icon.rotated {
    transform: rotate(180deg);
}

/* Animations */
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

.course-section,
.user-course-card {
    animation: fadeInUp 0.5s ease-out;
}

@media (max-width: 768px) {
    .course-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }

    .course-stats {
        justify-content: flex-start;
    }

    .user-row {
        flex-direction: column;
    }

    .stat-value {
        font-size: 22px;
    }

    .header-section h1 {
        font-size: 1.3rem;
    }
}
</style>
<div class="main-content">
    <div class="container-fluid py-4">
        @if(isset($processedData['mode']) && $processedData['mode'] == 'admin')
        {{-- ADMIN VIEW --}}
        <!-- Header -->
        <div class="header-section">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h1><i class="fas fa-chart-line mr-3"></i>Predictive Analysis Dashboard</h1>
                    <p class="mb-0 opacity-8"><i class="fas fa-robot mr-2"></i>AI-Powered Course-Based Dropout Risk
                        Prediction</p>
                </div>
                <div class="text-center mt-2 mt-md-0">
                    <div class="stat-value text-white">{{ $processedData['total_users'] ?? 0 }}</div>
                    <div class="stat-label text-white-50">Total Students Analyzed</div>
                </div>
            </div>
        </div>

        <!-- Admin Statistics Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stat-value">{{ $processedData['total_courses'] ?? 0 }}</div>
                                <div class="stat-label">Total Courses</div>
                            </div>
                            <div class="stat-icon primary"><i class="fas fa-book-open"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stat-value text-danger">{{ $processedData['risk_summary']['high'] ?? 0 }}
                                </div>
                                <div class="stat-label">High Risk Courses</div>
                            </div>
                            <div class="stat-icon danger"><i class="fas fa-exclamation-triangle"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stat-value text-warning">{{ $processedData['risk_summary']['medium'] ?? 0 }}
                                </div>
                                <div class="stat-label">Medium Risk Courses</div>
                            </div>
                            <div class="stat-icon warning"><i class="fas fa-chart-line"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stat-value text-success">{{ $processedData['risk_summary']['low'] ?? 0 }}
                                </div>
                                <div class="stat-label">Low Risk Courses</div>
                            </div>
                            <div class="stat-icon success"><i class="fas fa-check-circle"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @php
        // Build course-based data for admin view
        $courseBasedData = [];
        if(isset($processedData['data']) && is_array($processedData['data'])) {
        foreach($processedData['data'] as $userData) {
        foreach($userData['courses'] ?? [] as $course) {
        $courseId = $course['course_id'];
        if(!isset($courseBasedData[$courseId])) {
        $courseBasedData[$courseId] = [
        'course_id' => $courseId,
        'users' => [],
        'risk_counts' => ['high' => 0, 'medium' => 0, 'low' => 0]
        ];
        }
        $riskLevel = strtolower($course['risk_level']);
        $courseBasedData[$courseId]['users'][] = [
        'user_id' => $userData['user_id'],
        'risk_level' => $course['risk_level'],
        'probability' => $course['probability'],
        'reason' => $course['reason']
        ];
        $courseBasedData[$courseId]['risk_counts'][$riskLevel]++;
        }
        }

        foreach($courseBasedData as $courseId => $courseData) {
        if($courseData['risk_counts']['high'] > 0) {
        $courseBasedData[$courseId]['overall_risk'] = 'high';
        } elseif($courseData['risk_counts']['medium'] > 0) {
        $courseBasedData[$courseId]['overall_risk'] = 'medium';
        } else {
        $courseBasedData[$courseId]['overall_risk'] = 'low';
        }
        $courseBasedData[$courseId]['total_students'] = count($courseData['users']);
        }
        }
        @endphp

        <!-- Admin Course List -->
        @if(count($courseBasedData) > 0)
        @foreach($courseBasedData as $courseId => $courseData)
        @php
        $courseInfo = DB::table('elearning_courses')->where('course_id', $courseId)->first();
        $overallRisk = $courseData['overall_risk'];
        $totalStudents = $courseData['total_students'];
        $atRiskPercentage = $totalStudents > 0 ? round((($courseData['risk_counts']['high'] +
        $courseData['risk_counts']['medium']) / $totalStudents) * 100) : 0;
        @endphp
        <div class="course-section">
            <div class="course-header {{ $overallRisk }}-risk" onclick="toggleCourse(this, 'course-{{ $courseId }}')">
                <div class="d-flex align-items-center">
                    <div class="mr-3"><i class="fas fa-chalkboard-teacher fa-2x" style="color: var(--primary);"></i>
                    </div>
                    <div>
                        <h5 class="course-title mb-1">{{ $courseInfo->course_name ?? 'Course #'.$courseId }}</h5>
                        <div class="course-stats mt-2">
                            <span class="stat-badge students"><i class="fas fa-users"></i> {{ $totalStudents }}
                                Students</span>
                            <span class="stat-badge high"><i class="fas fa-skull-crosswalk"></i>
                                {{ $courseData['risk_counts']['high'] }} High</span>
                            <span class="stat-badge medium"><i class="fas fa-chart-line"></i>
                                {{ $courseData['risk_counts']['medium'] }} Medium</span>
                            <span class="stat-badge low"><i class="fas fa-check-circle"></i>
                                {{ $courseData['risk_counts']['low'] }} Low</span>
                            <span class="risk-badge {{ $overallRisk }}"><i class="fas fa-flag-checkered"></i>
                                {{ ucfirst($overallRisk) }} Risk</span>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="text-center mr-3">
                        <div class="small text-muted">At-Risk Rate</div>
                        <div class="font-weight-bold">{{ $atRiskPercentage }}%</div>
                    </div>
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </div>
            </div>

            <div id="course-{{ $courseId }}" class="p-4" style="display: none; background: #fafbfd;">
                @foreach($courseData['users'] as $user)
                @php $riskLevel = strtolower($user['risk_level']); $probability = round($user['probability'] * 100);
                $student_name = DB::table('users')->where('id', $user['user_id'])->value('name');
                @endphp
                <div class="user-row d-flex flex-wrap align-items-start justify-content-between">
                    <div class="d-flex align-items-center mb-2 mb-md-0">

                        <div>
                            <div class="font-weight-bold">Employee #{{ $student_name }}</div>
                            <div class="d-flex align-items-center mt-1">
                                <span class="risk-badge {{ $riskLevel }} mr-2">{{ $user['risk_level'] }} RISK</span>
                                <div class="probability-wrapper ml-2">
                                    <div class="d-flex align-items-center">
                                        <div class="probability-bar-container flex-grow-1 mr-2" style="width: 100px;">
                                            <div class="probability-fill {{ $riskLevel }}"
                                                style="width: {{ $probability }}%"></div>
                                        </div>
                                        <span class="probability-text">{{ $probability }}%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn-outline-gradient"
                        onclick="showUserDetails({{ json_encode($user) }}, '{{ addslashes($courseInfo->course_name ?? 'Course') }}')">
                        <i class="fas fa-eye mr-1"></i> Details
                    </button>
                    <div class="reason-text w-100 mt-3"><i class="fas fa-robot"></i>
                        {{ Str::limit($user['reason'], 120) }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
        @else
        <div class="text-center py-5 bg-white rounded-3 shadow-sm">
            <i class="fas fa-chart-line fa-4x text-muted mb-3"></i>
            <h5>No Data Available</h5>
            <p class="text-muted">No risk analysis data found at this time.</p>
        </div>
        @endif

        @else
        {{-- USER VIEW --}}
        <!-- User Header -->
        <div class="header-section">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h1><i class="fas fa-chart-line mr-3"></i>Your Learning Progress</h1>
                    <p class="mb-0 opacity-8"><i class="fas fa-robot mr-2"></i>AI-Powered Personal Risk Assessment</p>
                </div>

            </div>
        </div>



        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stat-value">{{ $processedData['total_courses'] ?? 0 }}</div>
                                <div class="stat-label">Your Courses</div>
                            </div>
                            <div class="stat-icon primary"><i class="fas fa-book"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stat-value text-danger">{{ $processedData['risk_summary']['high'] ?? 0 }}
                                </div>
                                <div class="stat-label">Need Attention</div>
                            </div>
                            <div class="stat-icon danger"><i class="fas fa-exclamation-triangle"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stat-value text-success">{{ $processedData['risk_summary']['low'] ?? 0 }}
                                </div>
                                <div class="stat-label">On Track</div>
                            </div>
                            <div class="stat-icon success"><i class="fas fa-check-circle"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course List - Same style as Admin -->
        @if(isset($processedData['courses']) && count($processedData['courses']) > 0)
        @foreach($processedData['courses'] as $course)
        @php
        $courseInfo = DB::table('elearning_courses')->where('course_id', $course['course_id'])->first();
        $riskLevel = strtolower($course['risk_level']);
        $probability = round($course['probability'] * 100);
        $overallRisk = $riskLevel;
        @endphp
        <div class="course-section">
            <div class="course-header {{ $overallRisk }}-risk"
                onclick="toggleCourse(this, 'course-{{ $course['course_id'] }}')">
                <div class="d-flex align-items-center">
                    <div class="mr-3">
                        <i class="fas fa-chalkboard-teacher fa-2x" style="color: var(--primary);"></i>
                    </div>
                    <div>
                        <h5 class="course-title mb-1">{{ $courseInfo->course_name ?? 'Course #'.$course['course_id'] }}
                        </h5>
                        <div class="course-stats mt-2">
                            <span class="risk-badge {{ $overallRisk }}">
                                <i class="fas fa-flag-checkered"></i> {{ ucfirst($overallRisk) }} Risk
                            </span>
                            <span class="stat-badge students">
                                <i class="fas fa-percent"></i> {{ $probability }}% Probability
                            </span>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="text-center mr-3">
                        <div class="small text-muted">Risk Level</div>
                        <div
                            class="font-weight-bold {{ $riskLevel == 'high' ? 'text-danger' : ($riskLevel == 'medium' ? 'text-warning' : 'text-success') }}">
                            {{ ucfirst($riskLevel) }}
                        </div>
                    </div>
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </div>
            </div>

            <div id="course-{{ $course['course_id'] }}" class="p-4" style="display: none; background: #fafbfd;">
                <!-- Course Details -->



                <div class="reason-text">
                    <i class="fas fa-robot"></i> {{ $course['reason'] }}
                </div>

                <div class="mt-3 pt-2">
                    <button class="btn-outline-gradient"
                        onclick="showCourseDetails({{ json_encode($course) }}, '{{ addslashes($courseInfo->course_name ?? 'Course') }}')">
                        <i class="fas fa-chart-line mr-1"></i> View Detailed Analysis
                    </button>
                </div>

            </div>
        </div>
        @endforeach
        @else
        <div class="text-center py-5 bg-white rounded-3 shadow-sm">
            <i class="fas fa-smile-wink fa-4x text-success mb-3"></i>
            <h5>No Risk Detected!</h5>
            <p class="text-muted">Great job! All your courses are on track.</p>
        </div>
        @endif
        @endif
    </div>
</div>
<!-- Modal (Shared for both views) -->
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-gradient">
            <div class="modal-header-gradient">
                <h5 class="modal-title" id="modalTitle"><i class="fas fa-chart-line mr-2"></i>Risk Analysis Details</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body p-4" id="modalBody"></div>
            <div class="modal-footer border-0 pb-4">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>

<script>
// Toggle course expansion (Admin only)
function toggleCourse(element, courseId) {
    const content = document.getElementById(courseId);
    const icon = element.querySelector('.toggle-icon');
    if (content.style.display === 'none') {
        content.style.display = 'block';
        icon.classList.remove('fa-chevron-down');
        icon.classList.add('fa-chevron-up');
    } else {
        content.style.display = 'none';
        icon.classList.remove('fa-chevron-up');
        icon.classList.add('fa-chevron-down');
    }
}

// Show user details (Admin)
function showUserDetails(user, courseName) {
    const riskLevel = user.risk_level.toLowerCase();
    const probability = Math.round(user.probability * 100);

    const recommendations = riskLevel === 'high' ? ['📞 Schedule immediate counseling session',
            '📧 Send personalized intervention email',
            '👥 Assign mentor support', '📊 Create recovery plan'
        ] :
        (riskLevel === 'medium' ? ['📧 Send motivational message', '📅 Schedule check-in call',
            '📚 Recommend additional resources'
        ] : ['👏 Send positive reinforcement', '📈 Monitor progress', '🎯 Encourage continued success']);

    document.getElementById('modalBody').innerHTML = `
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm"><div class="card-body">
                    <h6><i class="fas fa-user text-primary mr-2"></i>Student Information</h6><hr>
                   
                    <p><strong>Course:</strong> ${courseName}</p>
                    <p><strong>Risk Level:</strong> <span class="risk-badge ${riskLevel} ml-2">${user.risk_level}</span></p>
                    <p><strong>Probability:</strong> ${probability}%</p>
                    <div class="probability-bar-container mt-2"><div class="probability-fill ${riskLevel}" style="width: ${probability}%"></div></div>
                </div></div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm"><div class="card-body">
                    <h6><i class="fas fa-robot text-primary mr-2"></i>AI Analysis</h6><hr>
                    <p class="small">${user.reason}</p>
                </div></div>
            </div>
            <div class="col-12">
                <div class="card border-0 shadow-sm"><div class="card-body">
                    <h6><i class="fas fa-lightbulb text-warning mr-2"></i>Recommended Actions</h6><hr>
                    <ul class="list-unstyled mb-0">${recommendations.map(r => `<li><i class="fas fa-chevron-right text-primary mr-2"></i>${r}</li>`).join('')}</ul>
                </div></div>
            </div>
        </div>
    `;
    $('#detailsModal').modal('show');
}

// Show course details (User)
function showCourseDetails(course, courseName) {
    const riskLevel = course.risk_level.toLowerCase();
    const probability = Math.round(course.probability * 100);

    const tips = riskLevel === 'high' ? ['📞 Contact your instructor for support', '📅 Create a study schedule',
            '🎯 Set small daily goals',
            '💪 Don\'t give up - we\'re here to help!'
        ] :
        (riskLevel === 'medium' ? ['📧 Check your email for resources', '📚 Review course materials',
            '🤝 Join study groups',
            '📈 Track your progress daily'
        ] : ['🎉 Great job staying on track!', '📖 Keep up the good work', '⭐ Aim for excellence',
            '🚀 You\'re doing amazing!'
        ]);

    document.getElementById('modalBody').innerHTML = `
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm"><div class="card-body">
                    <h6><i class="fas fa-book text-primary mr-2"></i>Course Information</h6><hr>
                    <p><strong>Course:</strong> ${courseName}</p>
                    <p><strong>Risk Level:</strong> <span class="risk-badge ${riskLevel} ml-2">${course.risk_level}</span></p>
                    <p><strong>Risk Probability:</strong> ${probability}%</p>
                    <div class="probability-bar-container mt-2"><div class="probability-fill ${riskLevel}" style="width: ${probability}%"></div></div>
                </div></div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm"><div class="card-body">
                    <h6><i class="fas fa-robot text-primary mr-2"></i>AI Analysis</h6><hr>
                    <p class="small">${course.reason}</p>
                </div></div>
            </div>
            <div class="col-12">
                <div class="card border-0 shadow-sm"><div class="card-body">
                    <h6><i class="fas fa-lightbulb text-warning mr-2"></i>Recommendations for You</h6><hr>
                    <ul class="list-unstyled mb-0">${tips.map(t => `<li><i class="fas fa-chevron-right text-primary mr-2"></i>${t}</li>`).join('')}</ul>
                </div></div>
            </div>
        </div>
    `;
    $('#detailsModal').modal('show');
}

function sendSupport() {
    alert('✅ Support request has been sent. A counselor will contact you soon.');
    $('#detailsModal').modal('hide');
}

// Animate progress bars on load - ALL COURSES DEFAULT CLOSED
document.addEventListener('DOMContentLoaded', function() {
    // REMOVED auto-expand functionality - all courses start closed
    // All course sections have display: none by default in the HTML

    // Animate progress bars
    setTimeout(() => {
        document.querySelectorAll('.probability-fill').forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.width = width;
            }, 100);
        });
    }, 200);
});
</script>
@endsection