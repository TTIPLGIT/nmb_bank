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

.stat-icon.info {
    background: linear-gradient(135deg, var(--info), #2980b9);
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

/* Course Sections */
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

.stat-badge.info {
    background: rgba(52, 152, 219, 0.1);
    color: var(--info);
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

/* Progress Bars */
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

/* Skill Meter */
.skill-meter {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 10px 0;
}

.skill-meter-bar {
    flex: 1;
    height: 8px;
    background: #e9ecef;
    border-radius: 4px;
    overflow: hidden;
}

.skill-meter-fill {
    height: 100%;
    border-radius: 4px;
    transition: width 1s ease;
}

/* Quiz Score Items */
.quiz-score-item {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 12px;
    margin-bottom: 10px;
}

.quiz-score-bar {
    height: 6px;
    background: #e9ecef;
    border-radius: 3px;
    overflow: hidden;
    margin-top: 8px;
}

.quiz-score-fill {
    height: 100%;
    border-radius: 3px;
    transition: width 0.5s ease;
}

/* Reason Text */
.reason-text {
    font-size: 14px;
    color: #2c3e50;
    line-height: 1.5;
    background: #f8f9fa;
    padding: 12px 15px;
    border-radius: 12px;
    margin-top: 12px;
    border-left: 3px solid var(--primary);
}

.reason-text i {
    color: var(--primary);
    margin-right: 8px;
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

/* Info Row */
.info-row {
    background: #fafbfd;
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 12px;
    transition: all 0.3s ease;
}

.info-row:hover {
    background: #ffffff;
    transform: translateX(5px);
    box-shadow: var(--shadow);
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

.course-section {
    animation: fadeInUp 0.5s ease-out;
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

/* Responsive */
@media (max-width: 768px) {
    .course-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }

    .course-stats {
        justify-content: flex-start;
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
        {{-- USER VIEW (Single Learner) --}}
        <!-- Header -->
        <div class="header-section">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    @php
                    $username = DB::table('users')->where('id',
                    $data['fetched_data']['user']['user_id'])->value('name');
                    @endphp
                    <h1><i class="fas fa-chart-line mr-3"></i>Your Learning Pathway Analysis</h1>
                    <p class="mb-0 opacity-8">
                        <i class="fas fa-user mr-2"></i>{{ $username }} |
                        <i class="fas fa-book ml-2 mr-2"></i>{{ $data['fetched_data']['course']['course_name'] }}
                    </p>
                </div>
                <div class="text-center mt-2 mt-md-0">
                    <div class="stat-value text-white">{{ $data['fetched_data']['user']['total_cptpoints'] }}</div>
                    <div class="stat-label text-white-50">CPT Points Earned</div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stat-value">
                                    {{ $data['fetched_data']['assessment']['assessment_percentage'] }}%</div>
                                <div class="stat-label">Assessment Score</div>
                            </div>
                            <div class="stat-icon primary"><i class="fas fa-chart-line"></i></div>
                        </div>
                        <div class="probability-bar-container mt-3">
                            <div class="probability-fill {{ $data['fetched_data']['assessment']['assessment_percentage'] < 50 ? 'high' : ($data['fetched_data']['assessment']['assessment_percentage'] < 70 ? 'medium' : 'low') }}"
                                style="width: {{ $data['fetched_data']['assessment']['assessment_percentage'] }}%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stat-value">
                                    {{ $data['fetched_data']['assessment']['passed_quizzes'] }}/{{ $data['fetched_data']['assessment']['total_quizzes'] }}
                                </div>
                                <div class="stat-label">Quizzes Passed</div>
                            </div>
                            <div class="stat-icon info"><i class="fas fa-puzzle-piece"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stat-value">{{ $data['fetched_data']['progress']['course_progress'] }}%
                                </div>
                                <div class="stat-label">Course Progress</div>
                            </div>
                            <div class="stat-icon warning"><i class="fas fa-tasks"></i></div>
                        </div>
                        <div class="probability-bar-container mt-3">
                            <div class="probability-fill low"
                                style="width: {{ $data['fetched_data']['progress']['course_progress'] }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="stat-value">{{ $data['skill_analysis']['skill_mastery_percentage'] }}%</div>
                                <div class="stat-label">Skill Mastery</div>
                            </div>
                            <div class="stat-icon success"><i class="fas fa-brain"></i></div>
                        </div>
                        <div class="probability-bar-container mt-3">
                            <div class="probability-fill low"
                                style="width: {{ $data['skill_analysis']['skill_mastery_percentage'] }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- AI Decision Card -->
        <div class="course-section">
            <div class="course-header {{ $data['adaptive_decision']['decision'] == 'remediate' ? 'high-risk' : 'low-risk' }}"
                onclick="toggleCourse(this, 'ai-decision')">
                <div class="d-flex align-items-center">
                    <div class="mr-3">
                        <i class="fas fa-robot fa-2x" style="color: var(--primary);"></i>
                    </div>
                    <div>
                        <h5 class="course-title mb-1">AI-Powered Decision:
                            {{ ucfirst($data['adaptive_decision']['decision']) }} Path</h5>
                        <div class="course-stats mt-2">
                            <span
                                class="risk-badge {{ $data['adaptive_decision']['decision'] == 'remediate' ? 'high' : 'low' }}">
                                <i class="fas fa-flag-checkered"></i>
                                {{ ucfirst($data['adaptive_decision']['decision']) }}
                            </span>
                            <span class="stat-badge info">
                                <i class="fas fa-chart-line"></i> Confidence: {{ round($data['confidence'] * 100) }}%
                            </span>
                            <span class="stat-badge students">
                                <i
                                    class="fas fa-arrow-{{ $data['adaptive_decision']['difficulty_adjustment'] == 'increase' ? 'up' : ($data['adaptive_decision']['difficulty_adjustment'] == 'decrease' ? 'down' : 'right') }}"></i>
                                Difficulty: {{ ucfirst($data['adaptive_decision']['difficulty_adjustment']) }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="text-center mr-3">
                        <div class="small text-muted">Priority</div>
                        <div
                            class="font-weight-bold {{ $data['recommendations']['priority'] == 'high' ? 'text-danger' : 'text-warning' }}">
                            {{ ucfirst($data['recommendations']['priority']) }}
                        </div>
                    </div>
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </div>
            </div>
            <div id="ai-decision" class="p-4" style="display: none; background: #fafbfd;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="reason-text mb-3">
                            <i class="fas fa-robot"></i> {{ $data['adaptive_decision']['primary_reason'] }}
                        </div>
                        <div class="mt-3">
                            <strong>Supporting Factors:</strong>
                            <ul class="mt-2">
                                @foreach($data['adaptive_decision']['all_reasons'] as $reason)
                                <li><i class="fas fa-check-circle text-success mr-2"></i>{{ $reason }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class=" p-3 rounded-3 shadow-sm">
                            <div class="small text-muted mb-2">DECISION CONFIDENCE</div>
                            <div class="d-flex align-items-center">
                                <div class="probability-bar-container flex-grow-1 mr-3">
                                    <div class="probability-fill low"
                                        style="width: {{ round($data['confidence'] * 100) }}%"></div>
                                </div>
                                <span class="probability-text">{{ round($data['confidence'] * 100) }}%</span>
                            </div>
                            <div class="small text-muted mt-2">Decision Source:
                                {{ ucfirst(str_replace('_', ' ', $data['adaptive_decision']['decision_source'])) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quiz Performance Breakdown -->
        <div class="course-section">
            <div class="course-header low-risk" onclick="toggleCourse(this, 'quiz-performance')">
                <div class="d-flex align-items-center">
                    <div class="mr-3">
                        <i class="fas fa-puzzle-piece fa-2x" style="color: var(--primary);"></i>
                    </div>
                    <div>
                        <h5 class="course-title mb-1">Quiz Performance Breakdown</h5>
                        <div class="course-stats mt-2">
                            <span class="stat-badge students"><i class="fas fa-chart-line"></i> Average:
                                {{ $data['fetched_data']['assessment']['assessment_percentage'] }}%</span>
                            <span class="stat-badge info"><i class="fas fa-repeat"></i> Retries:
                                {{ $data['fetched_data']['progress']['retry_count'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="text-center mr-3">
                        <div class="small text-muted">Passed</div>
                        <div class="font-weight-bold">
                            {{ $data['fetched_data']['assessment']['passed_quizzes'] }}/{{ $data['fetched_data']['assessment']['total_quizzes'] }}
                        </div>
                    </div>
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </div>
            </div>
            <div id="quiz-performance" class="p-4" style="display: none; background: #fafbfd;">
                <div class="row">
                    @foreach($data['fetched_data']['assessment']['quiz_scores'] as $index => $score)
                    <div class="col-md-6 mb-3">
                        <div class="quiz-score-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Quiz {{ $index + 1 }}</strong>
                                    <span class="text-muted ml-2 small">(Attempt {{ $index + 1 }})</span>
                                </div>
                                <div
                                    class="font-weight-bold {{ $score >= 70 ? 'text-success' : ($score >= 40 ? 'text-warning' : 'text-danger') }}">
                                    {{ $score }}%
                                </div>
                            </div>
                            <div class="quiz-score-bar">
                                <div class="quiz-score-fill {{ $score >= 70 ? 'bg-success' : ($score >= 40 ? 'bg-warning' : 'bg-danger') }}"
                                    style="width: {{ $score }}%"></div>
                            </div>
                            @if($score < 50) <div class="small text-danger mt-2">
                                <i class="fas fa-exclamation-circle"></i> Below passing threshold
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Skill Gap Analysis -->
    <div class="course-section">
        <div class="course-header {{ $data['skill_analysis']['gap_severity'] }}-risk"
            onclick="toggleCourse(this, 'skill-analysis')">
            <div class="d-flex align-items-center">
                <div class="mr-3">
                    <i class="fas fa-brain fa-2x" style="color: var(--primary);"></i>
                </div>
                <div>
                    <h5 class="course-title mb-1">Skill Gap Analysis</h5>
                    <div class="course-stats mt-2">
                        <span class="risk-badge {{ $data['skill_analysis']['gap_severity'] }}">
                            <i class="fas fa-exclamation-triangle"></i>
                            {{ ucfirst($data['skill_analysis']['gap_severity']) }} Gap Severity
                        </span>
                        <span class="stat-badge info">
                            <i class="fas fa-chart-line"></i> Signal:
                            {{ ucfirst($data['fetched_data']['skill_gap_confidence']['gap_signal_strength']) }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <div class="text-center mr-3">
                    <div class="small text-muted">Mastery</div>
                    <div class="font-weight-bold">{{ $data['skill_analysis']['skill_mastery_percentage'] }}%</div>
                </div>
                <i class="fas fa-chevron-down toggle-icon"></i>
            </div>
        </div>
        <div id="skill-analysis" class="p-4" style="display: none; background: #fafbfd;">
            <div class="row">
                <div class="col-md-6">
                    @if(!empty($data['skill_analysis']['missing_skills']))
                    <div class="mb-3">
                        <strong class="text-danger">Missing Skills:</strong>
                        <div class="mt-2">
                            @foreach($data['skill_analysis']['missing_skills'] as $skill)
                            <span class="stat-badge high mr-2 mb-2 d-inline-block">
                                <i class="fas fa-exclamation-circle"></i> {{ ucfirst($skill) }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if(!empty($data['skill_analysis']['matched_skills']))
                    <div class="mb-3">
                        <strong class="text-success">Skills Acquired:</strong>
                        <div class="mt-2">
                            @foreach($data['skill_analysis']['matched_skills'] as $skill)
                            <span class="stat-badge low mr-2 mb-2 d-inline-block">
                                <i class="fas fa-check-circle"></i> {{ ucfirst($skill) }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <div class=" p-3 rounded-3 shadow-sm">
                        <div class="small text-muted mb-2">Gap Signal Strength</div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="probability-bar-container flex-grow-1 mr-3">
                                @php
                                $signal = $data['fetched_data']['skill_gap_confidence']['gap_signal_strength'];
                                $signalWidth = $signal == 'strong' ? 100 : ($signal == 'moderate' ? 66 : 33);
                                @endphp
                                <div class="probability-fill {{ $signal == 'strong' ? 'high' : ($signal == 'moderate' ? 'medium' : 'low') }}"
                                    style="width: {{ $signalWidth }}%"></div>
                            </div>
                            <span class="probability-text">{{ ucfirst($signal) }}</span>
                        </div>
                        <div class="small text-muted">Data Sources:</div>
                        <div class="mt-1">
                            @foreach($data['fetched_data']['skill_gap_confidence']['data_sources'] as $source)
                            <span class="stat-badge info mr-1"><i class="fas fa-database"></i>
                                {{ ucfirst(str_replace('_', ' ', $source)) }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Learning Path Update -->
    <div class="course-section">
        <div class="course-header high-risk" onclick="toggleCourse(this, 'learning-path')">
            <div class="d-flex align-items-center">
                <div class="mr-3">
                    <i class="fas fa-map-signs fa-2x" style="color: var(--primary);"></i>
                </div>
                <div>
                    <h5 class="course-title mb-1">Recommended Learning Path</h5>
                    <div class="course-stats mt-2">
                        <span class="risk-badge high"><i class="fas fa-bolt"></i>
                            {{ ucfirst($data['learning_path_update']['effective_timing']) }} Action</span>
                        <span class="stat-badge info"><i class="fas fa-clock"></i>
                            {{ $data['learning_path_update']['estimated_duration_hours'] }} Hours</span>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <div class="text-center mr-3">
                    <div class="small text-muted">Mandatory</div>
                    <div class="font-weight-bold">{{ $data['learning_path_update']['is_mandatory'] ? 'Yes' : 'No' }}
                    </div>
                </div>
                <i class="fas fa-chevron-down toggle-icon"></i>
            </div>
        </div>
        <div id="learning-path" class="p-4" style="display: none; background: #fafbfd;">
            <div class="row">
                <div class="col-md-6">
                    <div class="reason-text mb-3">
                        <i class="fas fa-info-circle"></i> {{ $data['learning_path_update']['reason'] }}
                    </div>
                    @php
                    $class_name =
                    DB::table('elearning_classes')->where('class_id',$data['learning_path_update']['target_module']['entity_id'])->value('class_name');

                    @endphp
                    <div class=" p-3 rounded-3 shadow-sm mb-3">
                        <strong>Target Module:</strong>
                        <p class="mb-0 mt-1">{{ $class_name }}</p>
                        <small class="text-muted">Type:
                            {{ ucfirst($data['learning_path_update']['action_type']) }}</small>
                    </div>
                </div>
                <div class="col-md-6">
                    @if(!empty($data['learning_path_update']['supplementary_content']))
                    <div class="mb-3">
                        <strong>Supplementary Content:</strong>
                        <div class="mt-2">
                            @foreach($data['learning_path_update']['supplementary_content'] as $content)
                            <div class="info-row">
                                <i class="fas fa-book mr-2"></i> {{ $content['name'] }}
                                @if($content['is_optional'])
                                <span class="stat-badge info ml-2">Optional</span>
                                @else
                                <span class="risk-badge high ml-2" style="font-size: 9px;">Required</span>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    <div class="bg-warning bg-opacity-10 p-3 rounded-3" style="background: #fff3cd;">
                        <i class="fas fa-chart-line mr-2"></i>
                        {{ $data['learning_path_update']['progress_impact'] }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- AI Recommendations & Guidance -->
    <div class="course-section">
        <div class="course-header low-risk" onclick="toggleCourse(this, 'recommendations')">
            <div class="d-flex align-items-center">
                <div class="mr-3">
                    <i class="fas fa-lightbulb fa-2x" style="color: var(--primary);"></i>
                </div>
                <div>
                    <h5 class="course-title mb-1">AI Recommendations & Guidance</h5>
                    <div class="course-stats mt-2">
                        <span class="stat-badge info"><i class="fas fa-clock"></i>
                            {{ $data['recommendations']['estimated_time_to_next_level'] }}</span>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <div class="text-center mr-3">
                    <div class="small text-muted">Focus Skills</div>
                    <div class="font-weight-bold">{{ $data['fetched_data']['ui_summary']['focus_skills'] }}</div>
                </div>
                <i class="fas fa-chevron-down toggle-icon"></i>
            </div>
        </div>
        <div id="recommendations" class="p-4" style="display: none; background: #fafbfd;">
            <div class="row">
                <div class="col-md-4">
                    <div class=" p-3 rounded-3 shadow-sm mb-3">
                        <strong><i class="fas fa-file-alt mr-2"></i> Content Types</strong>
                        <div class="mt-2">
                            @foreach($data['recommendations']['content_type_suggestion'] as $content)
                            <span class="stat-badge info mr-2 mb-2 d-inline-block">
                                <i
                                    class="fas fa-{{ $content == 'video' ? 'video' : ($content == 'basics' ? 'book' : 'puzzle-piece') }}"></i>
                                {{ ucfirst($content) }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                    <div class=" p-3 rounded-3 shadow-sm">
                        <strong><i class="fas fa-bookmark mr-2"></i> Focus Areas</strong>
                        <div class="mt-2">
                            @foreach($data['ai_reasoning']['focus_areas'] as $area)
                            <div class="mb-1"><i class="fas fa-crosshairs text-danger mr-2"></i> {{ ucfirst($area) }}
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class=" p-3 rounded-3 shadow-sm mb-3">
                        <strong><i class="fas fa-graduation-cap mr-2"></i> Suggested Resources</strong>
                        <div class="mt-2">
                            @foreach($data['recommendations']['suggested_resources'] as $resource)
                            <div class="mb-1"><i class="fas fa-chevron-right text-primary mr-2"></i> {{ $resource }}
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class=" p-3 rounded-3 shadow-sm mb-3">
                        <strong><i class="fas fa-lightbulb text-warning mr-2"></i> Learning Tips</strong>
                        <div class="mt-2">
                            @foreach($data['ai_reasoning']['learning_tips'] as $tip)
                            <div class="mb-1"><i class="fas fa-check-circle text-success mr-2"></i> {{ $tip }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Encouragement -->
            <div class="reason-text mt-3" style="border-left-color: var(--success);">
                <i class="fas fa-heart text-danger"></i> {{ $data['ai_reasoning']['encouragement'] }}
            </div>
        </div>
    </div>

    <!-- Performance Quality Details -->
    <div class="course-section">
        <div class="course-header low-risk" onclick="toggleCourse(this, 'performance-details')">
            <div class="d-flex align-items-center">
                <div class="mr-3">
                    <i class="fas fa-chart-bar fa-2x" style="color: var(--primary);"></i>
                </div>
                <div>
                    <h5 class="course-title mb-1">Detailed Performance Analysis</h5>
                    <div class="course-stats mt-2">
                        <span class="stat-badge {{ $data['fetched_data']['performance_quality']['accuracy_level'] }}">
                            <i class="fas fa-bullseye"></i> Accuracy:
                            {{ ucfirst($data['fetched_data']['performance_quality']['accuracy_level']) }}
                        </span>
                        <span class="stat-badge info">
                            <i class="fas fa-chart-line"></i> Confidence:
                            {{ round($data['fetched_data']['performance_quality']['performance_confidence'] * 100) }}%
                        </span>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center">
                <div class="text-center mr-3">
                    <div class="small text-muted">Error Type</div>
                    <div class="font-weight-bold">
                        {{ ucfirst($data['fetched_data']['performance_quality']['error_type']) }}</div>
                </div>
                <i class="fas fa-chevron-down toggle-icon"></i>
            </div>
        </div>
        <div id="performance-details" class="p-4" style="display: none; background: #fafbfd;">
            <div class="row">
                <div class="col-md-6">
                    <div class=" p-3 rounded-3 shadow-sm mb-3">
                        <strong>Performance Quality</strong>
                        <table class="table table-sm mt-2 mb-0">
                            <tr>
                                <td class="text-muted">Accuracy Level</td>
                                <td
                                    class="font-weight-bold text-{{ $data['fetched_data']['performance_quality']['accuracy_level'] == 'high' ? 'success' : ($data['fetched_data']['performance_quality']['accuracy_level'] == 'medium' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($data['fetched_data']['performance_quality']['accuracy_level']) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Attempt Efficiency</td>
                                <td class="font-weight-bold">
                                    {{ ucfirst($data['fetched_data']['performance_quality']['attempt_efficiency']) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Time Efficiency</td>
                                <td class="font-weight-bold">
                                    {{ ucfirst($data['fetched_data']['performance_quality']['time_efficiency']) }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Error Type</td>
                                <td class="font-weight-bold">
                                    {{ ucfirst($data['fetched_data']['performance_quality']['error_type']) }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Performance Confidence</td>
                                <td class="font-weight-bold">
                                    {{ round($data['fetched_data']['performance_quality']['performance_confidence'] * 100) }}%
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class=" p-3 rounded-3 shadow-sm mb-3">
                        <strong>Impact Projection</strong>
                        <table class="table table-sm mt-2 mb-0">
                            <tr>
                                <td class="text-muted">Expected Skill Improvement</td>
                                <td class="font-weight-bold text-success">
                                    +{{ $data['fetched_data']['impact_projection']['expected_skill_improvement'] }}%
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Risk Reduction Level</td>
                                <td class="font-weight-bold">
                                    {{ $data['fetched_data']['impact_projection']['risk_reduction_level'] }}%</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Post-Completion Confidence</td>
                                <td class="font-weight-bold">
                                    {{ number_format($data['fetched_data']['impact_projection']['post_completion_confidence'], 1) }}%
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Decision Stability</td>
                                <td class="font-weight-bold">
                                    {{ ucfirst($data['fetched_data']['adaptive_context']['decision_stability']) }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">False Positive Risk</td>
                                <td
                                    class="font-weight-bold text-{{ $data['fetched_data']['skill_gap_confidence']['false_positive_risk'] == 'high' ? 'danger' : 'warning' }}">
                                    {{ ucfirst($data['fetched_data']['skill_gap_confidence']['false_positive_risk']) }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Risk Alert if needed -->
            @if($data['fetched_data']['engagement_diagnostics']['engagement_risk'] == 'high' ||
            $data['ai_reasoning']['risk_level'] == 'High')
            <div class="alert alert-danger mt-3">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <strong>High Risk Alert:</strong> {{ $data['ai_reasoning']['admin_insights'] }}
                @if($data['ai_reasoning']['intervention_recommended'])
                <br><small>Intervention recommended immediately.</small>
                @endif
            </div>
            @endif
        </div>
    </div>

</div>
</div>

<!-- Modal for Details -->
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-gradient">
            <div class="modal-header-gradient">
                <h5 class="modal-title" id="modalTitle"><i class="fas fa-chart-line mr-2"></i>Learning Details</h5>
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
// Toggle course expansion
function toggleCourse(element, sectionId) {
    const content = document.getElementById(sectionId);
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

// Animate progress bars on load
document.addEventListener('DOMContentLoaded', function() {
    // All sections start closed
    // Animate progress bars
    setTimeout(() => {
        document.querySelectorAll('.probability-fill, .quiz-score-fill, .skill-meter-fill').forEach(
            bar => {
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