@extends('layouts.adminnav')

@section('content')

<style>
    /* Modern Color Palette & Variables */
    :root {
        --primary-color: #3f9cb5;
        --secondary-color: #2c3e50;
        --success-color: #2ecc71;
        --warning-color: #f1c40f;
        --danger-color: #e74c3c;
        --light-bg: #f8f9fa;
        --card-shadow: 0 10px 20px rgba(0,0,0,0.08); /* Softer, deeper shadow */
        --card-hover-shadow: 0 15px 30px rgba(0,0,0,0.12);
    }

    /* Card Styling */
    .adaptive-card { 
        border: none; 
        border-radius: 16px; /* More rounded */
        box-shadow: var(--card-shadow); 
        margin-bottom: 24px; 
        background: white; 
        overflow: hidden; 
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .adaptive-card:hover {
        transform: translateY(-5px); /* Lift effect */
        box-shadow: var(--card-hover-shadow);
    }

    .adaptive-card h5 { 
        font-weight: 700; 
        color: var(--secondary-color); 
        margin-bottom: 20px; 
        border-bottom: 2px solid #f1f1f1; 
        padding-bottom: 12px; 
        font-size: 1.15rem; 
        display: flex;
        align-items: center;
    }
    
    .adaptive-card h5 i {
        margin-right: 10px;
        color: var(--primary-color);
        background: rgba(63, 156, 181, 0.1);
        padding: 8px;
        border-radius: 8px;
    }

    /* Stepper Styles - Enhanced */
    .stepper-wrapper {
        display: flex;
        justify-content: space-between;
        margin: 30px 0 50px;
        position: relative;
        padding: 0 20px;
    }
    .stepper-item {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
        z-index: 2;
    }
    .stepper-item::before {
        position: absolute;
        content: "";
        border-bottom: 4px solid #e0e0e0; /* Thicker line */
        width: 100%;
        top: 25px;
        left: -50%;
        z-index: 1;
        transition: border-color 0.4s ease;
    }
    .stepper-item:first-child::before { content: none; }
    
    .stepper-circle {
        width: 50px; /* Larger */
        height: 50px;
        border-radius: 50%;
        background-color: white;
        border: 4px solid #e0e0e0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: bold;
        color: #bbb;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); /* Bouncy transition */
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        z-index: 2;
    }
    
    .stepper-item.completed .stepper-circle { 
        border-color: var(--success-color); 
        background-color: var(--success-color); 
        color: white; 
        transform: scale(1.1);
    }
    .stepper-item.completed::before { border-color: var(--success-color); }
    
    .stepper-item.active .stepper-circle { 
        border-color: var(--primary-color); 
        background-color: var(--primary-color); 
        color: white; 
        box-shadow: 0 0 0 5px rgba(63, 156, 181, 0.2); /* Glow effect */
        transform: scale(1.2);
    }
    
    .stepper-title { 
        margin-top: 15px; 
        font-weight: 700; 
        color: #999; 
        font-size: 0.95rem; 
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: color 0.3s;
    }
    .stepper-item.active .stepper-title { color: var(--primary-color); }
    .stepper-item.completed .stepper-title { color: var(--success-color); }

    /* Detail Elements */
    .info-label { font-weight: 600; color: #888; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
    .info-value { font-weight: 600; color: var(--secondary-color); font-size: 1.05rem; }
    
    /* Recommendation Grid */
    .resource-card {
        background: var(--light-bg);
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 15px;
        border-left: 5px solid var(--primary-color);
        transition: all 0.2s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
    }
    .resource-card:hover {
        background: white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transform: translateX(5px);
    }
    .resource-icon {
        font-size: 1.2rem;
        color: var(--primary-color);
        margin-right: 15px;
        width: 30px;
        text-align: center;
    }
    .resource-title {
        font-weight: 600;
        color: #333;
    }
    
    .hero-banner {
        background: linear-gradient(135deg, #3f9cb5 0%, #2980b9 100%);
        color: white;
        padding: 40px; /* More padding */
        border-radius: 16px;
        margin-bottom: 40px;
        text-align: center;
        box-shadow: 0 10px 25px rgba(52, 152, 219, 0.3);
        position: relative;
        overflow: hidden;
    }
    /* Subtle background pattern for hero */
    .hero-banner::after {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background-image: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 20%),
                          radial-gradient(circle at 80% 30%, rgba(255,255,255,0.15) 0%, transparent 20%);
        pointer-events: none;
    }
    
    .score-box { text-align: center; padding: 15px; }
    .score-val { font-size: 3rem; font-weight: 800; color: var(--secondary-color); line-height: 1; margin-bottom: 5px; }
    .score-label { font-size: 0.8rem; color: #888; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; }

    .decision-alert { padding: 25px; border-radius: 12px; display: flex; align-items: flex-start; }
    .decision-icon { font-size: 2rem; margin-right: 20px; margin-top: 5px; }
    .decision-content { flex: 1; }
    
    .decision-PROCEED { background-color: #e8f5e9; color: #1b5e20; border-left: 6px solid #2ecc71; }
    .decision-PROCEED .decision-icon { color: #2ecc71; }
    
    .decision-RETAKE { background-color: #ffebee; color: #b71c1c; border-left: 6px solid #e74c3c; }
    .decision-RETAKE .decision-icon { color: #e74c3c; }
    
    .decision-REVIEW { background-color: #fff8e1; color: #f57f17; border-left: 6px solid #f1c40f; }
    .decision-REVIEW .decision-icon { color: #f1c40f; }

    /* Layout tweaks */
    .row.display-flex { display: flex; flex-wrap: wrap; }
    .row.display-flex > [class*='col-'] { display: flex; flex-direction: column; }
    
    .badge-custom { padding: 6px 12px; border-radius: 30px; font-weight: 600; font-size: 0.8rem; letter-spacing: 0.5px; }
    .badge-soft-primary { background: rgba(63, 156, 181, 0.15); color: #3f9cb5; }
    .badge-soft-secondary { background: rgba(108, 117, 125, 0.15); color: #6c757d; }
    .badge-soft-success { background: rgba(46, 204, 113, 0.15); color: #2ecc71; }
</style>

<div class="main-content">
<div class="container-fluid">
    <section class="section">
    <div class="row">
        <div class="col-12">
            <div class="hero-banner">
                <h2 class="mb-2"><i class="fa fa-sitemap"></i> Adaptive Learning Pathway</h2>
                <p class="mb-0" style="opacity: 0.9;">AI-Driven Insights for <strong>{{ $data['fetched_data']['user']['designation_name'] ?? 'Learner' }}</strong></p>
            </div>
        </div>
    </div>

    <!-- Stepper Visualization -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="stepper-wrapper">
                <div class="stepper-item completed">
                    <div class="stepper-circle"><i class="fa fa-check"></i></div>
                    <div class="stepper-title">Assessment</div>
                </div>
                <!-- Logic to determine active step could be more dynamic here if we had state, assuming Completed Assessment forces Next active -->
                <div class="stepper-item active">
                    <div class="stepper-circle"><i class="fa fa-cogs"></i></div>
                    <div class="stepper-title">AI Processing</div>
                </div>
                <div class="stepper-item">
                    <div class="stepper-circle"><i class="fa fa-arrow-right"></i></div>
                    <div class="stepper-title">Next Steps</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row display-flex">
        <!-- Left Column: Context -->
        <div class="col-md-4">
            <div class="adaptive-card p-4 h-100">
                <h5><i class="fa fa-user"></i> Learner Profile</h5>
                <div class="mb-4">
                    <div class="info-label">Name</div>
                    <div class="info-value">{{ $data['fetched_data']['user']['designation_name'] ?? 'N/A' }}</div>
                </div>
                <div class="mb-4">
                    <div class="info-label">Role</div>
                    <div class="info-value">{{ $data['fetched_data']['user']['role_name'] ?? 'N/A' }}</div>
                </div>
                <div class="mb-2">
                    <div class="info-label">Current CPT Points</div>
                    <span class="badge badge-custom badge-soft-primary">{{ $data['fetched_data']['user']['total_cptpoints'] ?? 0 }} Points</span>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="adaptive-card p-4 h-100">
                <h5><i class="fa fa-book"></i> Course Context</h5>
                <div class="mb-4">
                    <div class="info-label">Course Name</div>
                    <div class="info-value">{{ $data['fetched_data']['course']['course_name'] ?? 'Unknown Course' }}</div>
                </div>
                <div class="mb-3">
                    <div class="info-label">Skills Required</div>
                    <div class="mt-2">
                        @forelse($data['fetched_data']['course']['skills_required'] ?? [] as $skill)
                            <span class="badge badge-custom badge-soft-secondary mr-1 mb-1">{{ $skill }}</span>
                        @empty
                            <span class="text-muted small">No specific skills listed.</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Assessment Score -->
        <div class="col-md-4">
            <div class="adaptive-card p-4 h-100">
                <h5><i class="fa fa-chart-pie"></i> Assessment Results</h5>
                <div class="row align-items-center justify-content-center h-75">
                    <div class="col-6 border-right">
                        <div class="score-box">
                            <div class="score-val text-primary">{{ $data['fetched_data']['assessment']['assessment_percentage'] ?? 0 }}%</div>
                            <div class="score-label">Score</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="score-box">
                            <div class="score-val text-success">
                                {{ $data['fetched_data']['assessment']['passed_quizzes'] ?? 0 }}/{{ $data['fetched_data']['assessment']['total_quizzes'] ?? 0 }}
                            </div>
                            <div class="score-label">Quizzes Passed</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- AI Decision -->
        <div class="col-md-12">
            <div class="adaptive-card p-4">
                <h5><i class="fa fa-brain"></i> AI Decision Engine</h5>
                
                @php
                    $decision = strtoupper($data['adaptive_decision']['decision'] ?? 'REVIEW');
                    $alertClass = 'decision-REVIEW'; // Default
                    $icon = 'fa-exclamation-triangle';
                    
                    if(str_contains($decision, 'PROCEED') || str_contains($decision, 'PASS') || str_contains($decision, 'NEXT')) {
                        $alertClass = 'decision-PROCEED';
                        $icon = 'fa-check-circle';
                    } elseif(str_contains($decision, 'RETAKE') || str_contains($decision, 'FAIL')) {
                        $alertClass = 'decision-RETAKE';
                        $icon = 'fa-times-circle';
                    }
                @endphp

                <div class="decision-alert {{ $alertClass }} mb-3">
                    <div class="decision-icon">
                        <i class="fa {{ $icon }}"></i>
                    </div>
                    <div class="decision-content">
                        <h4 class="alert-heading text-capitalize font-weight-bold">{{ $data['adaptive_decision']['decision'] ?? 'Review Needed' }}</h4>
                        <p class="mb-2" style="font-size: 1.05rem;">{{ $data['adaptive_decision']['primary_reason'] ?? 'No reason provided.' }}</p>
                        <div class="mt-3 pt-3 border-top border-light">
                            <p class="mb-0"><strong><i class="fa fa-sliders-h"></i> Difficulty Adjustment:</strong> <span class="badge badge-light border">{{ $data['adaptive_decision']['difficulty_adjustment'] ?? 'None' }}</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recommendations -->
        <div class="col-md-12">
            <div class="adaptive-card p-4">
                <h5><i class="fa fa-bullseye"></i> Tailored Recommendations & Path Forward</h5>
                
                <div class="row">
                    <div class="col-md-5">
                         <h6 class="text-muted text-uppercase mb-4" style="font-size: 0.8rem; letter-spacing: 1px; font-weight: 700;">Recommended Focus Areas</h6>
                         <div class="d-flex flex-wrap">
                            @forelse($data['recommendations']['skill_focus'] ?? [] as $skill)
                                <div class="card p-3 mr-2 mb-2 border text-center shadow-sm" style="min-width: 140px; background: white; border-radius: 12px;">
                                    <i class="fa fa-crosshairs text-primary mb-2" style="font-size: 1.5rem;"></i>
                                    <small class="font-weight-bold d-block text-dark">{{ $skill }}</small>
                                </div>
                            @empty
                                <div class="text-muted pl-2">No specific focus areas recommended.</div>
                            @endforelse
                         </div>
                    </div>
                    <div class="col-md-7">
                        <h6 class="text-muted text-uppercase mb-4" style="font-size: 0.8rem; letter-spacing: 1px; font-weight: 700;">Suggested Resources</h6>
                        <div class="resources-grid">
                            @forelse($data['recommendations']['suggested_resources'] ?? [] as $r)
                                <div class="resource-card">
                                    <div class="resource-icon">
                                        <i class="fa fa-book-open"></i>
                                    </div>
                                    <div class="resource-title">{{ $r }}</div>
                                    <div class="ml-auto text-primary">
                                        <i class="fa fa-chevron-right"></i>
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-light text-center w-100">No additional resources suggested at this time.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </section>
</div>
</div>

@endsection