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

.risk-badge {
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.risk-badge.low {
    background: #d4edda;
    color: #155724;
}

.risk-badge.medium {
    background: #fff3cd;
    color: #856404;
}

.risk-badge.high {
    background: #f8d7da;
    color: #721c24;
}

.probability-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.9rem;
}

.probability-circle.low {
    background: #d4edda;
    color: #155724;
    border: 2px solid #c3e6cb;
}

.probability-circle.medium {
    background: #fff3cd;
    color: #856404;
    border: 2px solid #ffeaa7;
}

.probability-circle.high {
    background: #f8d7da;
    color: #721c24;
    border: 2px solid #f5c6cb;
}

.course-card {
    border-left: 4px solid;
    transition: all 0.3s ease;
}

.course-card:hover {
    transform: translateX(5px);
}

.course-card.low {
    border-left-color: #28a745;
}

.course-card.medium {
    border-left-color: #ffc107;
}

.course-card.high {
    border-left-color: #dc3545;
}

.reason-text {
    font-size: 0.9rem;
    color: #666;
    line-height: 1.5;
}

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
</style>

<div class="main-content">
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="display-6 font-weight-800 text-dark mb-1">Predictive Analysis Dashboard</h1>
                        <p class="text-muted mb-0">
                            <i class="fa fa-robot mr-2"></i>AI-Powered Dropout Risk Prediction System
                        </p>
                    </div>
                    <div class="text-right">
                        <div class="h5 mb-0 text-primary">{{ $processedData['processed_users'] }} User Analyzed</div>
                        <small class="text-muted">Real-time risk assessment</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="dashboard-card stat-card">
                    <div class="d-flex align-items-center">
                        <div class="mr-3">
                            <i class="fa fa-users fa-2x text-white-80"></i>
                        </div>
                        <div>
                            <div class="text-white-80 mb-1">Total Users</div>
                            <div class="h2 text-white mb-0">{{ $processedData['total_users'] }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="dashboard-card" style="background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);">
                    <div class="d-flex align-items-center">
                        <div class="mr-3">
                            <i class="fa fa-exclamation-triangle fa-2x text-danger"></i>
                        </div>
                        <div>
                            <div class="text-danger mb-1">At-Risk Courses</div>
                            <div class="h2 text-dark mb-0">
                                {{ $processedData['risk_summary']['high'] + $processedData['risk_summary']['medium'] }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="dashboard-card" style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);">
                    <div class="d-flex align-items-center">
                        <div class="mr-3">
                            <i class="fa fa-check-circle fa-2x text-success"></i>
                        </div>
                        <div>
                            <div class="text-success mb-1">Safe Courses</div>
                            <div class="h2 text-dark mb-0">{{ $processedData['risk_summary']['low'] }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="dashboard-card" style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);">
                    <div class="d-flex align-items-center">
                        <div class="mr-3">
                            <i class="fa fa-chart-pie fa-2x text-warning"></i>
                        </div>
                        <div>
                            <div class="text-warning mb-1">Total Courses</div>
                            <div class="h2 text-dark mb-0">{{ $processedData['total_courses'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Risk Distribution -->
        <div class="row mb-4">
            <div class="col-lg-4">
                <div class="dashboard-card">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="text-uppercase letter-spacing-2 small font-weight-700 text-muted">
                            <i class="fa fa-chart-pie mr-2"></i>RISK DISTRIBUTION
                        </span>
                    </div>

                    <div class="text-center">
                        <div class="progress-ring d-inline-block mb-4">
                            @php
                            $circleLength = 2 * pi() * 45;
                            $highPercent = $processedData['risk_percentages']['high'];
                            $mediumPercent = $processedData['risk_percentages']['medium'];
                            $lowPercent = $processedData['risk_percentages']['low'];
                            @endphp

                            <svg width="120" height="120" viewBox="0 0 120 120">
                                <!-- Low Risk -->
                                <circle cx="60" cy="60" r="45" fill="none" stroke="#d4edda" stroke-width="10"
                                    stroke-dasharray="{{ ($lowPercent/100) * $circleLength }} {{ $circleLength - ($lowPercent/100) * $circleLength }}"
                                    stroke-dashoffset="0" />

                                <!-- Medium Risk -->
                                <circle cx="60" cy="60" r="45" fill="none" stroke="#fff3cd" stroke-width="10"
                                    stroke-dasharray="{{ ($mediumPercent/100) * $circleLength }} {{ $circleLength - ($mediumPercent/100) * $circleLength }}"
                                    stroke-dashoffset="{{ -($lowPercent/100) * $circleLength }}" />

                                <!-- High Risk -->
                                <circle cx="60" cy="60" r="45" fill="none" stroke="#f8d7da" stroke-width="10"
                                    stroke-dasharray="{{ ($highPercent/100) * $circleLength }} {{ $circleLength - ($highPercent/100) * $circleLength }}"
                                    stroke-dashoffset="{{ -(($lowPercent + $mediumPercent)/100) * $circleLength }}" />
                            </svg>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                <div class="risk-badge high mb-2">High</div>
                                <div class="h4">{{ $processedData['risk_summary']['high'] }}</div>
                                <small class="text-muted">{{ $processedData['risk_percentages']['high'] }}%</small>
                            </div>
                            <div class="col-4">
                                <div class="risk-badge medium mb-2">Medium</div>
                                <div class="h4">{{ $processedData['risk_summary']['medium'] }}</div>
                                <small class="text-muted">{{ $processedData['risk_percentages']['medium'] }}%</small>
                            </div>
                            <div class="col-4">
                                <div class="risk-badge low mb-2">Low</div>
                                <div class="h4">{{ $processedData['risk_summary']['low'] }}</div>
                                <small class="text-muted">{{ $processedData['risk_percentages']['low'] }}%</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="dashboard-card">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="text-uppercase letter-spacing-2 small font-weight-700 text-muted">
                            <i class="fa fa-list mr-2"></i>COURSE RISK ANALYSIS
                        </span>
                        <span class="badge badge-primary">User ID:
                            {{ $processedData['data'][0]['user_id'] ?? 'N/A' }}</span>
                    </div>

                    @if(count($processedData['data']) > 0 && count($processedData['data'][0]['courses']) > 0)
                    <div class="row">
                        @foreach($processedData['data'][0]['courses'] as $course)
                        <div class="col-md-6 mb-3">
                            <div class="course-card {{ strtolower($course['risk_level']) }} p-3 rounded">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-1">Course ID: {{ $course['course_id'] }}</h6>
                                        <div class="d-flex align-items-center">
                                            <span class="risk-badge {{ strtolower($course['risk_level']) }} mr-2">
                                                {{ $course['risk_level'] }} RISK
                                            </span>
                                            <div class="probability-circle {{ strtolower($course['risk_level']) }}">
                                                {{ round($course['probability'] * 100) }}%
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="reason-text mt-2">
                                    {{ Str::limit($course['reason'], 120) }}
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <i class="fa fa-info-circle mr-1"></i>
                                        {{ $course['prediction_type'] }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="fa fa-check-circle fa-3x text-success mb-3"></i>
                        <h5>No Risk Detected</h5>
                        <p class="text-muted">All courses are showing low risk levels.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Detailed Analysis -->
        @if(count($processedData['data']) > 0 && count($processedData['data'][0]['courses']) > 0)
        <div class="row">
            <div class="col-12">
                <div class="dashboard-card">
                    <span class="text-uppercase letter-spacing-2 small font-weight-700 text-muted mb-4 d-block">
                        <i class="fa fa-search mr-2"></i>DETAILED RISK ANALYSIS
                    </span>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Course ID</th>
                                    <th>Risk Level</th>
                                    <th>Probability</th>
                                    <th>Prediction Type</th>
                                    <th>Reason</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($processedData['data'][0]['courses'] as $course)
                                <tr>
                                    <td>
                                        <strong>#{{ $course['course_id'] }}</strong>
                                    </td>
                                    <td>
                                        <span class="risk-badge {{ strtolower($course['risk_level']) }}">
                                            {{ $course['risk_level'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 mr-2" style="height: 6px;">
                                                <div class="progress-bar bg-{{ strtolower($course['risk_level']) == 'high' ? 'danger' : (strtolower($course['risk_level']) == 'medium' ? 'warning' : 'success') }}"
                                                    style="width: {{ $course['probability'] * 100 }}%"></div>
                                            </div>
                                            <span>{{ round($course['probability'] * 100) }}%</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ $course['prediction_type'] }}</span>
                                    </td>
                                    <td class="reason-text">
                                        {{ $course['reason'] }}
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" data-toggle="modal"
                                            data-target="#courseModal{{ $course['course_id'] }}">
                                            <i class="fa fa-eye"></i> View
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal for detailed view -->
                                <div class="modal fade" id="courseModal{{ $course['course_id'] }}" tabindex="-1"
                                    role="dialog">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Course #{{ $course['course_id'] }} - Risk
                                                    Analysis</h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <h6>Risk Assessment</h6>
                                                                <div
                                                                    class="risk-badge {{ strtolower($course['risk_level']) }} mb-2">
                                                                    {{ $course['risk_level'] }} RISK
                                                                </div>
                                                                <p>Probability:
                                                                    <strong>{{ round($course['probability'] * 100) }}%</strong>
                                                                </p>
                                                                <p>Type:
                                                                    <strong>{{ $course['prediction_type'] }}</strong>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <h6>Recommended Actions</h6>
                                                                <ul class="list-unstyled">
                                                                    @if(strtolower($course['risk_level']) == 'high')
                                                                    <li><i
                                                                            class="fa fa-exclamation-circle text-danger mr-2"></i>Immediate
                                                                        intervention required</li>
                                                                    <li><i
                                                                            class="fa fa-user-check text-danger mr-2"></i>Schedule
                                                                        counseling session</li>
                                                                    <li><i
                                                                            class="fa fa-bell text-danger mr-2"></i>Notify
                                                                        instructor</li>
                                                                    @elseif(strtolower($course['risk_level']) ==
                                                                    'medium')
                                                                    <li><i
                                                                            class="fa fa-comment-medical text-warning mr-2"></i>Send
                                                                        progress check email</li>
                                                                    <li><i
                                                                            class="fa fa-tasks text-warning mr-2"></i>Assign
                                                                        additional practice</li>
                                                                    <li><i
                                                                            class="fa fa-calendar-check text-warning mr-2"></i>Schedule
                                                                        follow-up</li>
                                                                    @else
                                                                    <li><i
                                                                            class="fa fa-thumbs-up text-success mr-2"></i>Continue
                                                                        current path</li>
                                                                    <li><i
                                                                            class="fa fa-star text-success mr-2"></i>Positive
                                                                        reinforcement</li>
                                                                    <li><i
                                                                            class="fa fa-chart-line text-success mr-2"></i>Monitor
                                                                        progress</li>
                                                                    @endif
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h6>AI Analysis Details</h6>
                                                        <p class="mb-0">{{ $course['reason'] }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary">Take Action</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>

<!-- JavaScript for interactivity -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Animate progress bars
    $('.progress-bar').each(function() {
        var width = $(this).attr('style');
        $(this).css('width', '0');
        setTimeout(() => {
            $(this).css('width', width);
        }, 100);
    });

    // Filter functionality
    $('.filter-btn').click(function() {
        var riskLevel = $(this).data('risk');
        $('.course-card').show();
        if (riskLevel !== 'all') {
            $('.course-card').not('.' + riskLevel).hide();
        }
    });
});
</script>
@endsection