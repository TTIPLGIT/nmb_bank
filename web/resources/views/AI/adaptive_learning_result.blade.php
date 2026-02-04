@extends('layouts.adminnav')

@section('content')
<style>
:root {
    --primary-blue: #3498db;
    --secondary-blue: #2980b9;
    --success-green: #27ae60;
    --warning-yellow: #f39c12;
    --danger-red: #e74c3c;
    --purple: #9b59b6;
    --text-dark: #2c3e50;
    --text-muted: #7f8c8d;
    --bg-light: #f8fafc;
    --card-border-radius: 12px;
    --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 20px rgba(0, 0, 0, 0.08);
    --shadow-lg: 0 8px 30px rgba(0, 0, 0, 0.12);
}

body {
    background-color: var(--bg-light);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Cards */
.dashboard-card {
    background: white;
    border-radius: var(--card-border-radius);
    padding: 25px;
    margin-bottom: 25px;
    box-shadow: var(--shadow-sm);
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
    height: 100%;
}

.dashboard-card:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
}

.stat-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
}

/* Progress Indicators */
.progress-ring {
    width: 120px;
    height: 120px;
    position: relative;
}

.progress-ring-circle {
    transition: stroke-dashoffset 0.35s;
    transform: rotate(-90deg);
    transform-origin: 50% 50%;
}

/* Tags & Badges */
.status-badge {
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.status-badge.low {
    background: #ffeaea;
    color: #c0392b;
}

.status-badge.medium {
    background: #fff3cd;
    color: #856404;
}

.status-badge.high {
    background: #d4edda;
    color: #155724;
}

.status-badge.none {
    background: #f8f9fa;
    color: #6c757d;
}

/* Timeline */
.learning-timeline {
    position: relative;
    padding-left: 30px;
}

.learning-timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(to bottom, #667eea, #764ba2);
}

.timeline-step {
    position: relative;
    margin-bottom: 25px;
    padding: 20px;
    background: white;
    border-radius: 10px;
    border-left: 4px solid #667eea;
    box-shadow: var(--shadow-sm);
}

.timeline-step::before {
    content: '';
    position: absolute;
    left: -26px;
    top: 28px;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background: #667eea;
    border: 3px solid white;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
}

/* Skill Meter */
.skill-meter {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 10px;
    margin-bottom: 15px;
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

/* Alert Cards */
.alert-card {
    background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
    color: #721c24;
    border: 1px solid #f5c6cb;
    padding: 20px;
    border-radius: var(--card-border-radius);
    margin-bottom: 20px;
}

.success-card {
    background: linear-gradient(135deg, #d4fc79 0%, #96e6a1 100%);
    color: #155724;
    border: 1px solid #c3e6cb;
}

/* Metrics Grid */
.metric-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin: 20px 0;
}

.metric-item {
    text-align: center;
    padding: 15px;
    background: white;
    border-radius: 10px;
    box-shadow: var(--shadow-sm);
}

.metric-value {
    font-size: 2rem;
    font-weight: 800;
    line-height: 1;
    margin: 10px 0;
}

/* Chart Containers */
.chart-container {
    position: relative;
    height: 300px;
    margin: 20px 0;
}

@media (max-width: 768px) {
    .chart-container {
        height: 250px;
    }

    .progress-ring {
        width: 100px;
        height: 100px;
    }

    .metric-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="main-content">
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="display-6 font-weight-800 text-dark mb-1">Learning Pathway Analysis</h1>
                        <p class="text-muted mb-0">
                            <i class="fa fa-user mr-2"></i>User: {{ $data['fetched_data']['user']['designation_name'] }}
                            <span class="mx-3">|</span>
                            <i class="fa fa-book mr-2"></i>Course: {{ $data['fetched_data']['course']['course_name'] }}
                        </p>
                    </div>
                    <div class="text-right">
                        <div class="h5 mb-0 text-primary">CPT Points:
                            {{ number_format($data['fetched_data']['user']['total_cptpoints']) }}</div>
                        <small class="text-muted">Total Earned</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- AI Decision & Confidence -->
        <div class="row mb-4">
            <div class="col-lg-8">
                <div class="dashboard-card" style="background: linear-gradient(135deg, #fdfcfb 0%, #e2d1c3 100%);">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <span class="text-uppercase letter-spacing-2 small font-weight-700 text-muted mb-3 d-block">
                                <i class="fa fa-robot mr-2"></i>AI-POWERED DECISION
                            </span>
                            <h2 class="text-dark mb-3">{{ ucfirst($data['adaptive_decision']['decision']) }} Path</h2>
                            <p class="lead mb-4">{{ $data['adaptive_decision']['primary_reason'] }}</p>

                            <div class="d-flex flex-wrap gap-3 mb-3">
                                <div>
                                    <div class="small text-muted mb-1">DIFFICULTY</div>
                                    <span
                                        class="status-badge {{ $data['adaptive_decision']['difficulty_adjustment'] == 'same' ? 'medium' : 'high' }}">
                                        <i
                                            class="fa fa-{{ $data['adaptive_decision']['difficulty_adjustment'] == 'increase' ? 'arrow-up' : ($data['adaptive_decision']['difficulty_adjustment'] == 'decrease' ? 'arrow-down' : 'minus') }}"></i>
                                        {{ ucfirst($data['adaptive_decision']['difficulty_adjustment']) }}
                                    </span>
                                </div>
                                <div>
                                    <div class="small text-muted mb-1">PRIORITY</div>
                                    <span class="status-badge {{ strtolower($data['recommendations']['priority']) }}">
                                        <i
                                            class="fa fa-{{ $data['recommendations']['priority'] == 'high' ? 'exclamation-triangle' : ($data['recommendations']['priority'] == 'medium' ? 'exclamation-circle' : 'check-circle') }}"></i>
                                        {{ ucfirst($data['recommendations']['priority']) }}
                                    </span>
                                </div>
                                <div>
                                    <div class="small text-muted mb-1">DECISION SOURCE</div>
                                    <span class="status-badge medium">
                                        <i class="fa fa-cogs"></i>
                                        {{ ucfirst(str_replace('_', ' ', $data['adaptive_decision']['decision_source'])) }}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-4">
                                <div class="small text-muted mb-2">SUPPORTING FACTORS</div>
                                <ul class="list-unstyled mb-0">
                                    @foreach($data['adaptive_decision']['all_reasons'] as $reason)
                                    <li class="mb-1">
                                        <i class="fa fa-check-circle text-success mr-2"></i>
                                        {{ $reason }}
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="progress-ring d-inline-block">
                                @php
                                $confidence = round($data['confidence'] * 100);
                                $circleLength = 2 * pi() * 45; // radius 45
                                $offset = $circleLength - ($confidence / 100 * $circleLength);
                                @endphp
                                <svg width="120" height="120" viewBox="0 0 120 120">
                                    <circle cx="60" cy="60" r="45" fill="none" stroke="#f0f0f0" stroke-width="10" />
                                    <circle cx="60" cy="60" r="45" fill="none"
                                        stroke="{{ $confidence >= 70 ? '#27ae60' : ($confidence >= 40 ? '#f39c12' : '#e74c3c') }}"
                                        stroke-width="10" stroke-linecap="round" stroke-dasharray="{{ $circleLength }}"
                                        stroke-dashoffset="{{ $offset }}" transform="rotate(-90 60 60)" />
                                    <text x="60" y="65" text-anchor="middle" font-size="24" font-weight="700"
                                        fill="{{ $confidence >= 70 ? '#27ae60' : ($confidence >= 40 ? '#f39c12' : '#e74c3c') }}">
                                        {{ $confidence }}%
                                    </text>
                                    <text x="60" y="85" text-anchor="middle" font-size="12" fill="#7f8c8d">
                                        Confidence
                                    </text>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="dashboard-card stat-card">
                    <div class="text-center">
                        <div class="mb-4">
                            <span class="ag-section-title" style="color: rgba(255,255,255,0.8);">LEARNER STATE</span>
                            <h3 class="text-white mb-2">{{ $data['learner_state']['current_level'] }}</h3>
                            <div class="status-badge" style="background: rgba(255,255,255,0.2); color: white;">
                                <i
                                    class="fa fa-{{ $data['learner_state']['engagement_status'] == 'high' ? 'rocket' : 'user' }}"></i>
                                {{ ucfirst($data['learner_state']['engagement_status']) }} Engagement
                            </div>
                        </div>

                        <div class="metric-grid">
                            <div class="metric-item"
                                style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                <div class="small text-white-80 mb-1">Mastery</div>
                                <div class="metric-value text-white">
                                    {{ $data['skill_analysis']['skill_mastery_percentage'] }}%
                                </div>
                            </div>
                            <div class="metric-item"
                                style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                                <div class="small text-white-80 mb-1">Engagement</div>
                                <div class="metric-value text-white">
                                    {{ $data['learner_state']['engagement_score'] }}/10
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance & Engagement Alert -->
        @if($data['fetched_data']['engagement_diagnostics']['engagement_risk'] == 'high')
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert-card">
                    <div class="d-flex align-items-center">
                        <div class="mr-3">
                            <i class="fa fa-exclamation-triangle fa-2x"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-1">High Engagement Risk Detected</h5>
                            <p class="mb-0">
                                User shows {{ $data['fetched_data']['engagement_diagnostics']['login_frequency'] }}
                                login frequency
                                with {{ $data['fetched_data']['engagement_diagnostics']['interaction_depth'] }}
                                interaction depth.
                                Consider additional motivational strategies.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Performance Metrics -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="dashboard-card">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-primary mr-3 d-flex align-items-center justify-content-center"
                            style="width: 50px; height: 50px;">
                            <i class="fa fa-chart-line text-white"></i>
                        </div>
                        <div>
                            <div class="small text-muted">ASSESSMENT SCORE</div>
                            <div class="h3 mb-0">{{ $data['fetched_data']['assessment']['assessment_percentage'] }}%
                            </div>
                        </div>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-primary"
                            style="width: {{ $data['fetched_data']['assessment']['assessment_percentage'] }}%"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="dashboard-card">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-success mr-3 d-flex align-items-center justify-content-center"
                            style="width: 50px; height: 50px;">
                            <i class="fa fa-clock text-white"></i>
                        </div>
                        <div>
                            <div class="small text-muted">HOURS SPENT</div>
                            <div class="h3 mb-0">{{ $data['fetched_data']['progress']['hours_spent'] }}</div>
                        </div>
                    </div>
                    <div class="text-muted small">
                        of {{ $data['fetched_data']['progress']['expected_hours'] }} expected
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="dashboard-card">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-warning mr-3 d-flex align-items-center justify-content-center"
                            style="width: 50px; height: 50px;">
                            <i class="fa fa-tasks text-white"></i>
                        </div>
                        <div>
                            <div class="small text-muted">PROGRESS</div>
                            <div class="h3 mb-0">{{ $data['fetched_data']['progress']['course_progress'] }}%</div>
                        </div>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-warning"
                            style="width: {{ $data['fetched_data']['progress']['course_progress'] }}%"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="dashboard-card">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-info mr-3 d-flex align-items-center justify-content-center"
                            style="width: 50px; height: 50px;">
                            <i class="fa fa-check-circle text-white"></i>
                        </div>
                        <div>
                            <div class="small text-muted">QUIZZES PASSED</div>
                            <div class="h3 mb-0">
                                {{ $data['fetched_data']['assessment']['passed_quizzes'] }}/{{ $data['fetched_data']['assessment']['total_quizzes'] }}
                            </div>
                        </div>
                    </div>
                    <div class="text-muted small">
                        {{ $data['fetched_data']['assessment']['total_quizzes'] == 0 ? 'No quizzes attempted' : 'Quiz completion rate' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Skill Gap Analysis -->
        <div class="row mb-4">
            <div class="col-lg-6">
                <div class="dashboard-card">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="text-uppercase letter-spacing-2 small font-weight-700 text-muted">
                            <i class="fa fa-brain mr-2"></i>SKILL ANALYSIS
                        </span>
                        <span class="status-badge {{ $data['skill_analysis']['gap_severity'] }}">
                            <i
                                class="fa fa-{{ $data['skill_analysis']['gap_severity'] == 'high' ? 'exclamation-triangle' : ($data['skill_analysis']['gap_severity'] == 'medium' ? 'exclamation-circle' : 'check-circle') }}"></i>
                            {{ ucfirst($data['skill_analysis']['gap_severity']) }} Gap Severity
                        </span>
                    </div>

                    <!-- Skill Mastery -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="font-weight-600">Overall Skill Mastery</span>
                            <span
                                class="font-weight-700 text-primary">{{ $data['skill_analysis']['skill_mastery_percentage'] }}%</span>
                        </div>
                        <div class="progress" style="height: 10px; border-radius: 5px;">
                            <div class="progress-bar bg-primary"
                                style="width: {{ $data['skill_analysis']['skill_mastery_percentage'] }}%"></div>
                        </div>
                    </div>

                    <!-- Gap Signal -->
                    <div class="mb-4">
                        <div class="small text-muted mb-2">GAP SIGNAL STRENGTH</div>
                        <div class="d-flex align-items-center">
                            @php
                            $signal = $data['fetched_data']['skill_gap_confidence']['gap_signal_strength'];
                            $signalWidth = $signal == 'strong' ? 100 : ($signal == 'moderate' ? 66 : 33);
                            @endphp
                            <div class="flex-grow-1 mr-3">
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-{{ $signal == 'strong' ? 'danger' : ($signal == 'moderate' ? 'warning' : 'info') }}"
                                        style="width: {{ $signalWidth }}%"></div>
                                </div>
                            </div>
                            <span
                                class="font-weight-600 text-{{ $signal == 'strong' ? 'danger' : ($signal == 'moderate' ? 'warning' : 'info') }}">
                                {{ ucfirst($signal) }}
                            </span>
                        </div>
                    </div>

                    <!-- Data Sources -->
                    <div>
                        <div class="small text-muted mb-2">DATA SOURCES</div>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($data['fetched_data']['skill_gap_confidence']['data_sources'] as $source)
                            <span class="badge badge-light border text-dark">
                                <i class="fa fa-database mr-1"></i>
                                {{ ucfirst(str_replace('_', ' ', $source)) }}
                            </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Learning Path Update -->
            <div class="col-lg-6">
                <div class="dashboard-card">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="text-uppercase letter-spacing-2 small font-weight-700 text-muted">
                            <i class="fa fa-map-signs mr-2"></i>LEARNING PATH UPDATE
                        </span>
                        <span class="status-badge high">
                            <i class="fa fa-bolt"></i>
                            {{ ucfirst($data['learning_path_update']['effective_timing']) }}
                        </span>
                    </div>

                    <!-- Target Module -->
                    <div class="mb-4 p-3 bg-light rounded">
                        <div class="small text-muted mb-1">TARGET MODULE</div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">{{ $data['learning_path_update']['target_module']['name'] }}</h5>
                                <div class="text-muted small">
                                    {{ ucfirst($data['learning_path_update']['target_module']['entity_type']) }} ID:
                                    {{ $data['learning_path_update']['target_module']['entity_id'] }}
                                </div>
                            </div>
                            @if($data['learning_path_update']['is_mandatory'])
                            <span class="badge badge-danger">MANDATORY</span>
                            @endif
                        </div>
                    </div>

                    <!-- Duration & Requirements -->
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="small text-muted mb-1">ESTIMATED DURATION</div>
                            <div class="h4 text-primary">{{ $data['learning_path_update']['estimated_duration_hours'] }}
                                hours</div>
                        </div>
                        <div class="col-6">
                            <div class="small text-muted mb-1">ACTION TYPE</div>
                            <div class="h5 text-capitalize">
                                {{ str_replace('_', ' ', $data['learning_path_update']['action_type']) }}</div>
                        </div>
                    </div>

                    <!-- Reason -->
                    <div class="p-3 bg-primary-light rounded">
                        <div class="small text-muted mb-1">REASON</div>
                        <div class="font-weight-600">{{ $data['learning_path_update']['reason'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recommendations & Content -->
        <div class="row mb-4">
            <div class="col-lg-8">
                <div class="dashboard-card">
                    <span class="text-uppercase letter-spacing-2 small font-weight-700 text-muted mb-4 d-block">
                        <i class="fa fa-lightbulb mr-2"></i>AI RECOMMENDATIONS
                    </span>

                    <!-- Content Types -->
                    <div class="mb-4">
                        <div class="small text-muted mb-2">SUGGESTED CONTENT TYPES</div>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($data['recommendations']['content_type_suggestion'] as $content)
                            <span class="badge badge-primary p-2">
                                <i
                                    class="fa fa-{{ $content == 'video' ? 'play-circle' : ($content == 'quiz' ? 'question-circle' : 'book') }} mr-1"></i>
                                {{ ucfirst($content) }}
                            </span>
                            @endforeach
                        </div>
                    </div>

                    <!-- Suggested Resources -->
                    <div class="mb-4">
                        <div class="small text-muted mb-2">SUGGESTED RESOURCES</div>
                        <div class="list-group">
                            @foreach($data['recommendations']['suggested_resources'] as $resource)
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-check-circle text-success mr-3"></i>
                                    <div>{{ $resource }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Time to Next Level -->
                    <div class="p-3 bg-success-light rounded">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small text-muted mb-1">ESTIMATED TIME TO NEXT LEVEL</div>
                                <div class="h4 mb-0">{{ $data['recommendations']['estimated_time_to_next_level'] }}
                                </div>
                            </div>
                            <i class="fa fa-clock fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- AI Reasoning & Tips -->
            <div class="col-lg-4">
                <div class="dashboard-card h-100">
                    <span class="text-uppercase letter-spacing-2 small font-weight-700 text-muted mb-4 d-block">
                        <i class="fa fa-comments mr-2"></i>AI GUIDANCE
                    </span>

                    <!-- Explanation -->
                    <div class="mb-4">
                        <div class="small text-muted mb-2">EXPLANATION</div>
                        <p class="font-italic">{{ $data['ai_reasoning']['ai_explanation'] }}</p>
                    </div>

                    <!-- Learning Tips -->
                    <div class="mb-4">
                        <div class="small text-muted mb-2">LEARNING TIPS</div>
                        <ul class="list-unstyled">
                            @foreach($data['ai_reasoning']['learning_tips'] as $tip)
                            <li class="mb-2">
                                <i class="fa fa-angle-right text-primary mr-2"></i>
                                {{ $tip }}
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Focus Areas -->
                    <div class="mb-4">
                        <div class="small text-muted mb-2">FOCUS AREAS</div>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($data['ai_reasoning']['focus_areas'] as $area)
                            <span class="badge badge-info">{{ $area }}</span>
                            @endforeach
                        </div>
                    </div>

                    <!-- Encouragement -->
                    <div class="p-3 bg-warning-light rounded mt-4">
                        <div class="small text-muted mb-1">ENCOURAGEMENT</div>
                        <div class="font-weight-600">{{ $data['ai_reasoning']['encouragement'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Performance Analysis -->
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <span class="text-uppercase letter-spacing-2 small font-weight-700 text-muted mb-4 d-block">
                        <i class="fa fa-chart-bar mr-2"></i>DETAILED PERFORMANCE ANALYSIS
                    </span>

                    <div class="row">
                        <!-- Performance Quality -->
                        <div class="col-md-4 mb-3">
                            <div class="p-3 border rounded h-100">
                                <div class="small text-muted mb-2">PERFORMANCE QUALITY</div>
                                <table class="table table-sm table-borderless mb-0">
                                    <tr>
                                        <td class="text-muted" width="60%">Accuracy Level</td>
                                        <td
                                            class="font-weight-600 text-{{ $data['fetched_data']['performance_quality']['accuracy_level'] == 'high' ? 'success' : ($data['fetched_data']['performance_quality']['accuracy_level'] == 'medium' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($data['fetched_data']['performance_quality']['accuracy_level']) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Attempt Efficiency</td>
                                        <td class="font-weight-600">
                                            {{ ucfirst($data['fetched_data']['performance_quality']['attempt_efficiency']) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Time Efficiency</td>
                                        <td class="font-weight-600">
                                            {{ ucfirst($data['fetched_data']['performance_quality']['time_efficiency']) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Error Type</td>
                                        <td class="font-weight-600">
                                            {{ ucfirst($data['fetched_data']['performance_quality']['error_type']) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Performance Confidence</td>
                                        <td class="font-weight-600">
                                            {{ round($data['fetched_data']['performance_quality']['performance_confidence'] * 100) }}%
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Impact Projection -->
                        <div class="col-md-4 mb-3">
                            <div class="p-3 border rounded h-100">
                                <div class="small text-muted mb-2">IMPACT PROJECTION</div>
                                <table class="table table-sm table-borderless mb-0">
                                    <tr>
                                        <td class="text-muted" width="70%">Expected Skill Improvement</td>
                                        <td class="font-weight-600 text-success">
                                            {{ $data['fetched_data']['impact_projection']['expected_skill_improvement'] }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Risk Reduction Level</td>
                                        <td class="font-weight-600">
                                            {{ $data['fetched_data']['impact_projection']['risk_reduction_level'] }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Post-Completion Confidence</td>
                                        <td class="font-weight-600 text-primary">
                                            {{ $data['fetched_data']['impact_projection']['post_completion_confidence'] }}%
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Decision Stability</td>
                                        <td class="font-weight-600">
                                            {{ ucfirst($data['fetched_data']['adaptive_context']['decision_stability']) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">False Positive Risk</td>
                                        <td
                                            class="font-weight-600 text-{{ $data['fetched_data']['skill_gap_confidence']['false_positive_risk'] == 'high' ? 'danger' : 'warning' }}">
                                            {{ ucfirst($data['fetched_data']['skill_gap_confidence']['false_positive_risk']) }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- UI Summary -->
                        <div class="col-md-4 mb-3">
                            <div class="p-3 border rounded h-100">
                                <div class="small text-muted mb-2">SUMMARY OVERVIEW</div>
                                <table class="table table-sm table-borderless mb-0">
                                    <tr>
                                        <td class="text-muted" width="60%">Learner State</td>
                                        <td class="font-weight-600">
                                            {{ $data['fetched_data']['ui_summary']['learner_state'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Performance Insight</td>
                                        <td class="font-weight-600">
                                            {{ $data['fetched_data']['ui_summary']['performance_insight'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Adaptive Label</td>
                                        <td class="font-weight-600">
                                            {{ $data['fetched_data']['ui_summary']['adaptive_label'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Focus Skills</td>
                                        <td class="font-weight-600">
                                            {{ $data['fetched_data']['ui_summary']['focus_skills'] }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Estimated Effort</td>
                                        <td class="font-weight-600">
                                            {{ $data['fetched_data']['ui_summary']['estimated_effort'] }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Additional JS for animations -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate progress bars
    const progressBars = document.querySelectorAll('.progress-bar');
    progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0';
        setTimeout(() => {
            bar.style.width = width;
        }, 100);
    });

    // Add tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endsection