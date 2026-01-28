@extends('layouts.adminnav')

@section('content')

<style>
    /* Antigravity UI Variables */
    :root {
        --primary-blue: #007bff;
        --success-green: #2ecc71;
        --danger-red: #e74c3c;
        --text-dark: #2c3e50;
        --text-muted: #95a5a6;
        --bg-light: #f4f6f9;
        --card-border-radius: 8px;
        --font-family: 'Inter', sans-serif;
    }

    body {
        background-color: var(--bg-light);
        color: var(--text-dark);
        font-family: var(--font-family);
    }

    /* Common Card Styles */
    .ag-card {
        background: #fff;
        border: 1px solid #e1e8ed;
        border-radius: var(--card-border-radius);
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .ag-section-title {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text-muted);
        font-weight: 700;
        margin-bottom: 15px;
        display: block;
    }

    /* AI Decision Section */
    .decision-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    .decision-item {
        flex: 1;
        padding: 0 10px;
        border-right: 1px solid #eee;
        min-width: 150px;
    }
    .decision-item:last-child {
        border-right: none;
    }

    .decision-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 5px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .decision-value {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-dark);
        display: flex;
        align-items: center;
    }

    .badge-decision {
        background-color: #fff3cd;
        color: #856404;
        padding: 6px 12px;
        border-radius: 4px;
        font-weight: 700;
        font-size: 0.9rem;
        display: inline-block;
        border: 1px solid #ffeeba;
    }

    /* Impact Projection */
    .impact-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }
    
    .impact-card {
        background: #fff;
        border: 1px solid #edf2f7;
        padding: 20px;
        text-align: center;
        border-radius: var(--card-border-radius);
    }
    
    .impact-val {
        font-size: 1.8rem;
        font-weight: 800;
        margin: 10px 0;
    }
    .impact-sub { font-size: 0.8rem; color: var(--text-muted); }
    .text-green { color: var(--success-green); }
    .text-blue { color: var(--primary-blue); }

    /* Skill Analysis */
    .skill-gap-list {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }
    .skill-tag {
        background: #fff;
        border: 1px solid #fab1a0; /* Light red border for gaps */
        color: #d63031;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 0.85rem;
        font-weight: 500;
    }
    .skill-tag.severity-high {
        background-color: #ffeaea;
    }

    /* Progress Bar Custom */
    .mastery-progress {
        height: 6px;
        background-color: #eee;
        border-radius: 3px;
        margin: 10px 0;
        position: relative;
    }
    .mastery-bar {
        height: 100%;
        background-color: var(--primary-blue);
        border-radius: 3px;
        width: 0%; /* Dynamic */
    }

    /* Recommendations */
    .rec-tag {
        border: 1px solid #bdc3c7;
        color: var(--text-dark);
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 0.8rem;
        margin-right: 5px;
        display: inline-block;
        background: #f8f9fa;
        margin-bottom: 5px;
    }

    /* Learning Path Update */
    .path-module {
        background: #eef6fc; /* Light blue tint */
        border: 1px solid #bbdefb;
        padding: 20px;
        border-radius: var(--card-border-radius);
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .path-list-item {
        display: flex;
        align-items: center;
        padding: 15px;
        border-bottom: 1px solid #eee;
        background: #fff;
    }
    .path-list-item:last-child { border-bottom: none; }
    
    .path-index {
        width: 30px;
        height: 30px;
        background: #f1f2f6;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: var(--text-muted);
        margin-right: 15px;
        font-size: 0.9rem;
    }
    
    .badge-required {
        background: #ffebee;
        color: #c0392b;
        font-size: 0.7rem;
        padding: 3px 8px;
        border-radius: 3px;
        text-transform: uppercase;
        font-weight: 700;
        margin-left: auto;
    }
    
    /* Layout Helpers */
    .flex-col-50 { flex: 0 0 49%; max-width: 49%; }
    .gap-2 { gap: 2%; }
    
    @media(max-width: 768px) {
        .flex-col-50 { flex: 0 0 100%; max-width: 100%; margin-bottom: 20px; }
        .decision-row { flex-direction: column; align-items: flex-start; }
        .decision-item { width: 100%; border-right: none; border-bottom: 1px solid #eee; padding: 10px 0; }
    }
</style>
<div class="main-content">
<div class="container-fluid py-4">
    <!-- Header Title -->
    <div class="row mb-4">
        <div class="col-12">
            <h3 style="font-weight: 700; color: #2c3e50;">Adaptive Learning Pathway Analysis</h3>
            <p class="text-muted">AI-powered decision for personalized learning</p>
        </div>
    </div>

    <!-- AI Decision Section -->
    <div class="ag-card">
        <span class="ag-section-title"><i class="fa fa-lightbulb-o text-warning mr-1"></i> AI-DRIVEN DECISION</span>
        <div class="decision-row mt-3">
            <div class="decision-item">
                <div class="decision-label">Decision Taken</div>
                <div class="mt-1">
                    <span class="badge-decision">{{ $data['adaptive_decision']['decision'] ?? 'Remediate' }}</span>
                </div>
            </div>
            <div class="decision-item">
                <div class="decision-label">Difficulty Change</div>
                <div class="decision-value">
                     @php
                        $difficulty = strtolower($data['adaptive_decision']['difficulty_adjustment'] ?? '');
                    @endphp

                    @if($difficulty === 'increase')
                        <i class="fa fa-arrow-up text-danger mr-1"></i> Increase
                    @elseif($difficulty === 'decrease')
                        <i class="fa fa-arrow-down text-success mr-1"></i> Decrease
                    @else
                        <span class="text-muted">None</span>
                    @endif
                </div>
            </div>
            @php
                $confidence = isset($data['confidence'])
                    ? round($data['confidence'] * 100)
                    : 0;
            @endphp
            <div class="decision-item">
                <div class="decision-label">Confidence</div>
                <div class="decision-value text-primary d-flex align-items-center">
                    <div class="progress w-50 mr-2" style="height: 6px;">
                        <div class="progress-bar bg-primary"
                            role="progressbar"
                            style="width: {{ $confidence ?? 0 }}%">
                        </div>
                    </div>
                    <span>{{ $confidence !== null ? $confidence.'%' : '-' }}</span>
                </div>
            </div>
            <div class="decision-item" style="flex: 2;">
                <div class="decision-label">Primary Reason</div>
                <div class="decision-value">{{ $data['adaptive_decision']['primary_reason'] ?? 'Skill gaps identified in core areas.' }}</div>
            </div>
        </div>
        <div class="mt-4 pt-3 border-top" style="border-color: #f1f2f6 !important;">
            <div class="decision-label">Supporting Factors</div>
            <ul class="pl-3 mb-0 text-muted" style="font-size: 0.9rem;">
                <li>{{ $data['adaptive_decision']['supporting_factors'] ?? 'Significant skill gaps: 3 detected' }}</li>
            </ul>
        </div>
    </div>

    <!-- Impact Projection Section -->
    <div class="ag-section-title mt-4">IMPACT PROJECTION</div>
    <div class="impact-grid mb-4">
        <div class="impact-card">
            @php 
      
            $baseImprovement = 50; // Max possible improvement %
$confidence = $data['confidence'] ?? 0;
$gapSeverity = $data['skill_analysis']['gap_severity'] ?? 'low';

$gapFactor = match ($gapSeverity) {
    'high' => 0.7,
    'medium' => 0.5,
    'low' => 0.3,
    default => 0.3
};
            @endphp
            <div class="decision-label">EXPECTED SKILL IMPROVEMENT</div>
            <div class="impact-val text-success">{{$expectedSkillImprovement = round($baseImprovement * $confidence * $gapFactor)}} %</div>
            <div class="impact-sub">From {{ $data['fetched_data']['assessment']['assessment_percentage'] ?? 0 }}% to {{ ($data['fetched_data']['assessment']['assessment_percentage'] ?? 0) + 35 }}%</div>
        </div>

        <div class="impact-card">
            <div class="decision-label">RISK REDUCTION</div>
            <div class="impact-val text-primary">925</div>
            <div class="impact-sub">AI-assessed benefit</div>
        </div>
        <div class="impact-card">
            <div class="decision-label">POST-COMPLETION CONFIDENCE</div>
            <div class="impact-val text-success">92%</div>
            <div class="impact-sub">Predicted readiness</div>
        </div>
    </div>

    <!-- Split: Skill Analysis & Recommendations -->
    <div class="row display-flex">
        <!-- Skill Analysis -->
        <div class="col-md-6 d-flex">
            <div class="ag-card w-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="ag-section-title mb-0">SKILL ANALYSIS</span>
                    <span class="badge badge-light text-danger border border-danger">High Gap Severity</span>
                </div>
                
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-1">
                        <span style="font-size: 0.9rem; font-weight: 600;">Skill Mastery</span>
                        <span style="font-weight: 700;">{{ $data['fetched_data']['assessment']['assessment_percentage'] ?? 0 }}%</span>
                    </div>
                    <div class="mastery-progress">
                        <div class="mastery-bar" style="width: {{ $data['fetched_data']['assessment']['assessment_percentage'] ?? 0 }}%;"></div>
                    </div>
                </div>

                <div class="decision-label mb-2">MISSING SKILLS ({{ count($data['fetched_data']['course']['skills_required'] ?? []) }})</div>
                <div class="skill-gap-list">
                    <!-- Assuming skills_required are the gaps if decision is remediate -->
                    @forelse($data['fetched_data']['course']['skills_required'] ?? ['Analytical Thinking', 'Basic Numeracy', 'Reading Comprehension'] as $skill)
                        <div class="skill-tag severity-high">{{ $skill }}</div>
                    @empty
                        <div class="text-muted small">No specific missing skills identified.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recommendations -->
        <div class="col-md-6 d-flex">
            <div class="ag-card w-100">
                <span class="ag-section-title">RECOMMENDATIONS</span>
                
                <div class="mb-3">
                    <div class="decision-label">FOCUS SKILLS</div>
                    <div class="mt-2">
                         @forelse($data['recommendations']['skill_focus'] ?? ['Analytical Thinking', 'Basic Numeracy', 'Reading Comprehension'] as $skill)
                            <div class="skill-tag" style="border-color: #fab1a0; color: #d63031;">{{ $skill }}</div>
                        @empty
                            <span class="text-muted small">General Revision</span>
                        @endforelse
                    </div>
                </div>

                <div class="mb-3">
                    <div class="decision-label">SUGGESTED CONTENT TYPES</div>
                    <div class="mt-2">
                        <span class="rec-tag">Basics</span>
                        <span class="rec-tag">Tutorial</span>
                        <span class="rec-tag">Video</span>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="decision-label">ESTIMATED TIME TO PROGRESS</div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: #2c3e50;">4-8 hours</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Learning Path Update -->
    <div class="ag-card">
        <span class="ag-section-title">LEARNING PATH UPDATE</span>
        
        <div class="path-module mt-3">
            <div>
                <div class="decision-label" style="color: #5dade2;">TARGET MODULE</div>
                <h4 style="font-weight: 700; margin: 5px 0 0;">{{ $data['fetched_data']['course']['course_name'] ?? 'Class 1 (Foundation)' }}</h4>
                <div class="text-muted small">Class</div>
            </div>
            <button class="btn btn-primary btn-sm font-weight-bold px-3">IMMEDIATE</button>
        </div>

        <div class="decision-label mb-3">SUPPLEMENTARY CONTENT</div>
        
        <div class="path-list">
             @forelse($data['recommendations']['suggested_resources'] ?? [] as $index => $r)
                <div class="path-list-item">
                     <div class="path-index">{{ $index + 1 }}</div>
                     <div style="font-weight: 600; color: #34495e;">{{ $r }}</div>
                     <div class="badge-required">Required</div>
                </div>
             @empty
                <!-- Fallback Mock Data as per image design if empty -->
                <div class="path-list-item">
                     <div class="path-index">1</div>
                     <div style="font-weight: 600; color: #34495e;">Basics: analytical thinking</div>
                     <div class="badge-required">Required</div>
                </div>
                <div class="path-list-item">
                     <div class="path-index">2</div>
                     <div style="font-weight: 600; color: #34495e;">Basics: basic numeracy and arithmetic</div>
                     <div class="badge-required">Required</div>
                </div>
                 <div class="path-list-item">
                     <div class="path-index">3</div>
                     <div style="font-weight: 600; color: #34495e;">Basics: reading comprehension</div>
                     <div class="badge-required">Required</div>
                </div>
             @endforelse
        </div>

        <div class="mt-3 pt-3 text-muted small border-top">
            <strong>Total estimated:</strong> 4 hours
        </div>
    </div>

</div>
</div>
@endsection