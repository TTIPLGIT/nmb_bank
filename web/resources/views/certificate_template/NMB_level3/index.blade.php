@extends('layouts.adminnav')

@section('content')
<style>
:root {
    --bank-navy: #0a2540;
    --bank-gold: #c6a43b;
    --bank-gold-light: #e8d5a3;
    --bank-silver: #eef2f5;
}

.bank-header-section {
    background: linear-gradient(135deg, var(--bank-navy) 0%, #1a4a6e 100%);
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 30px;
    color: white;
}

.stat-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    border-left: 4px solid var(--bank-gold);
    transition: transform 0.2s;
}

.stat-card:hover {
    transform: translateY(-3px);
}

.template-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
    gap: 25px;
    margin-top: 20px;
}

.template-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
}

.template-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.template-preview {
    height: 260px;
    position: relative;
    overflow: hidden;
}

.preview-portrait {
    background: linear-gradient(145deg, #f5f2e8 0%, #e8e2d0 100%);
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
}

.preview-landscape {
    background: linear-gradient(145deg, #e8e2d0 0%, #f5f2e8 100%);
}

.mini-cert {
    width: 85%;
    height: 85%;
    background: white;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    padding: 12px;
    text-align: center;
    position: relative;
}

.mini-cert::before {
    content: '';
    position: absolute;
    top: 5px;
    left: 5px;
    right: 5px;
    bottom: 5px;
    border: 1px solid var(--bank-gold);
    border-radius: 4px;
    pointer-events: none;
}

.template-actions {
    padding: 18px;
    border-top: 1px solid #eee;
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.btn-gold {
    background: var(--bank-gold);
    color: var(--bank-navy);
    border: none;
    padding: 8px 18px;
    border-radius: 30px;
    font-weight: 600;
    font-size: 0.85rem;
    transition: all 0.2s;
}

.btn-navy {
    background: var(--bank-navy);
    color: white;
    border: none;
    padding: 8px 18px;
    border-radius: 30px;
    font-weight: 600;
    font-size: 0.85rem;
}

.orientation-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: var(--bank-gold);
    color: var(--bank-navy);
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: bold;
    z-index: 2;
}
</style>

<div class="main-content">
    <div class="bank-header-section">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h1 style="color: var(--bank-gold); margin-bottom: 10px;">🏦 Bank Certificate Studio</h1>
                <p class="mb-0">Design & manage professional bank certificates with premium templates</p>
            </div>
            <a href="{{ route('certificate.templates.create') }}" class="btn"
                style="background: var(--bank-gold); color: var(--bank-navy); font-weight: bold; padding: 12px 28px; border-radius: 40px;">
                + Create New Template
            </a>
        </div>
    </div>

    <div class="stat-cards">
        <div class="stat-card">
            <h3 style="color: var(--bank-navy); font-size: 2rem; margin-bottom: 5px;">{{ $totalTemplates ?? 8 }}</h3>
            <p style="color: #666; margin: 0;">Total Templates</p>
        </div>
        <div class="stat-card">
            <h3 style="color: var(--bank-navy); font-size: 2rem; margin-bottom: 5px;">{{ $portraitCount ?? 4 }}</h3>
            <p style="color: #666; margin: 0;">Portrait Versions</p>
        </div>
        <div class="stat-card">
            <h3 style="color: var(--bank-navy); font-size: 2rem; margin-bottom: 5px;">{{ $landscapeCount ?? 4 }}</h3>
            <p style="color: #666; margin: 0;">Landscape Versions</p>
        </div>
        <div class="stat-card">
            <h3 style="color: var(--bank-navy); font-size: 2rem; margin-bottom: 5px;">{{ $certificatesIssued ?? 1250 }}
            </h3>
            <p style="color: #666; margin: 0;">Certificates Issued</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs mb-4" id="templateTabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#allTemplates"
                        style="color: var(--bank-navy); font-weight: 600;">📋 All Templates</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#portraitTemplates" style="color: var(--bank-navy);">📱
                        Portrait (8.5" x 11")</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#landscapeTemplates"
                        style="color: var(--bank-navy);">🖥️ Landscape (11" x 8.5")</a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="allTemplates">
                    <div class="template-grid">
                        @foreach($allTemplates as $template)
                        <div class="template-card">
                            <div
                                class="template-preview {{ $template['orientation'] == 'portrait' ? 'preview-portrait' : 'preview-landscape' }}">
                                <span class="orientation-badge">{{ ucfirst($template['orientation']) }}</span>
                                <div class="mini-cert">
                                    <div style="font-size: 8px; color: var(--bank-gold);">✦ CERTIFICATE ✦</div>
                                    <div style="font-size: 7px; margin-top: 8px;">{{ $template['template_name'] }}</div>
                                    <div
                                        style="height: 2px; background: var(--bank-gold); width: 60%; margin: 8px auto;">
                                    </div>
                                    <div style="font-size: 6px; color: #999;">Sample Preview</div>
                                </div>
                            </div>
                            <div class="template-actions">
                                <div style="flex: 1;">
                                    <strong>{{ $template['template_name'] }}</strong>
                                    <div>
                                        <small>{{ $template['description'] ?? 'Premium bank certificate template' }}</small>
                                    </div>
                                </div>
                                <a href="{{ route('certificate.preview', $template['id']) }}"
                                    class="btn-gold">Preview</a>
                                <a href="{{ route('certificate.edit', $template['id']) }}" class="btn-navy">Edit</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="tab-pane fade" id="portraitTemplates">
                    <div class="template-grid">
                        @foreach($portraitTemplates as $template)
                        <div class="template-card">...</div>
                        @endforeach
                    </div>
                </div>

                <div class="tab-pane fade" id="landscapeTemplates">
                    <div class="template-grid">
                        @foreach($landscapeTemplates as $template)
                        <div class="template-card">...</div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection