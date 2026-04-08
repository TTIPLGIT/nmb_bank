@extends('layouts.adminnav')

@section('content')
<style>
.preview-container {
    background: #eef2f5;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px;
    min-height: 100vh;
}

/* PREMIUM PORTRAIT CERTIFICATE */
.bank-cert-portrait {
    width: 650px;
    min-height: 880px;
    background: #ffffff;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    position: relative;
    overflow: hidden;
    font-family: 'Georgia', 'Times New Roman', serif;
}

/* Watermark pattern */
.cert-watermark {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: radial-gradient(circle at 20% 40%, rgba(198, 164, 59, 0.03) 2px, transparent 2px);
    background-size: 30px 30px;
    pointer-events: none;
}

/* Ornate border */
.ornate-border {
    position: absolute;
    top: 20px;
    left: 20px;
    right: 20px;
    bottom: 20px;
    border: 2px solid #c6a43b;
    pointer-events: none;
}

.inner-ornate {
    position: absolute;
    top: 28px;
    left: 28px;
    right: 28px;
    bottom: 28px;
    border: 1px solid #e8d5a3;
    pointer-events: none;
}

/* Corner flourishes */
.corner-flourish {
    position: absolute;
    width: 80px;
    height: 80px;
    z-index: 2;
}

.corner-flourish::before,
.corner-flourish::after {
    content: '';
    position: absolute;
    background: #c6a43b;
}

.corner-flourish.tl {
    top: 12px;
    left: 12px;
}

.corner-flourish.tl::before {
    top: 0;
    left: 0;
    width: 25px;
    height: 3px;
}

.corner-flourish.tl::after {
    top: 0;
    left: 0;
    width: 3px;
    height: 25px;
}

.corner-flourish.tr {
    top: 12px;
    right: 12px;
}

.corner-flourish.tr::before {
    top: 0;
    right: 0;
    width: 25px;
    height: 3px;
}

.corner-flourish.tr::after {
    top: 0;
    right: 0;
    width: 3px;
    height: 25px;
}

.corner-flourish.bl {
    bottom: 12px;
    left: 12px;
}

.corner-flourish.bl::before {
    bottom: 0;
    left: 0;
    width: 25px;
    height: 3px;
}

.corner-flourish.bl::after {
    bottom: 0;
    left: 0;
    width: 3px;
    height: 25px;
}

.corner-flourish.br {
    bottom: 12px;
    right: 12px;
}

.corner-flourish.br::before {
    bottom: 0;
    right: 0;
    width: 25px;
    height: 3px;
}

.corner-flourish.br::after {
    bottom: 0;
    right: 0;
    width: 3px;
    height: 25px;
}

/* Content */
.cert-content-portrait {
    position: relative;
    z-index: 5;
    padding: 55px 45px 50px;
    text-align: center;
}

.bank-seal {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

.seal-circle {
    width: 70px;
    height: 70px;
    background: #0a2540;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #c6a43b;
    font-size: 32px;
    font-weight: bold;
}

.cert-title-portrait h1 {
    font-size: 2.8rem;
    letter-spacing: 6px;
    color: #0a2540;
    margin: 0;
    font-weight: 700;
}

.cert-title-portrait p {
    color: #c6a43b;
    letter-spacing: 4px;
    font-size: 0.9rem;
    border-top: 1px solid #e8d5a3;
    display: inline-block;
    padding-top: 8px;
}

.award-statement {
    margin: 30px 0 15px;
    font-size: 1.1rem;
    color: #5a6e7c;
    text-transform: uppercase;
}

.recipient-name-portrait {
    font-size: 2.2rem;
    font-weight: 800;
    color: #0a2540;
    background: linear-gradient(to right, #faf8f0, #fff);
    display: inline-block;
    padding: 8px 35px;
    border-bottom: 3px solid #c6a43b;
    letter-spacing: 1px;
}

.cert-description {
    margin: 30px auto;
    max-width: 85%;
    color: #3a4a5a;
    line-height: 1.6;
}

.signature-grid {
    display: flex;
    justify-content: center;
    gap: 70px;
    margin: 40px 0 20px;
}

.signature-item-portrait {
    text-align: center;
}

.sig-line {
    width: 150px;
    height: 2px;
    background: #c6a43b;
    margin: 10px auto 8px;
}

.qr-footer {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 15px;
    margin-top: 20px;
}

.action-buttons-bar {
    margin-top: 30px;
    text-align: center;
    padding: 20px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
}
</style>

<div class="preview-container">
    <div class="bank-cert-portrait">
        <div class="cert-watermark"></div>
        <div class="ornate-border"></div>
        <div class="inner-ornate"></div>

        <div class="corner-flourish tl"></div>
        <div class="corner-flourish tr"></div>
        <div class="corner-flourish bl"></div>
        <div class="corner-flourish br"></div>

        <div class="cert-content-portrait">
            <div class="bank-seal">
                <div class="seal-circle">🏦</div>
            </div>

            <div class="cert-title-portrait">
                <h1>CERTIFICATE</h1>
                <p>OF EXCELLENCE & PARTICIPATION</p>
            </div>

            <div class="award-statement">This certificate is proudly awarded to</div>

            <div class="recipient-name-portrait">
                {{ $data['recipient_name'] ?? 'Mr. Jonathan M. Kibaki' }}
            </div>

            <div class="cert-description">
                In recognition of outstanding participation and valuable contribution to the
                <strong>{{ $data['course_name'] ?? 'Executive Banking & Financial Leadership Summit' }}</strong>
                organized by <strong>{{ $bankName ?? 'NMB Bank Plc' }}</strong>.
                This certificate honors dedication to professional excellence in the banking sector.
            </div>

            <div style="color: #888; font-style: italic;">
                📅 Awarded on: {{ $data['event_date'] ?? now()->format('F d, Y') }}
            </div>

            <div class="signature-grid">
                <div class="signature-item-portrait">
                    @if(!empty($data['signatory1_signature']))
                    <img src="{{ $data['signatory1_signature'] }}" style="height: 55px;">
                    @else
                    <div style="width: 150px; height: 45px;"></div>
                    @endif
                    <div class="sig-line"></div>
                    <strong>{{ $data['signatory1_name'] ?? 'Dr. Sarah W. Mrema' }}</strong><br>
                    <small>Director of Banking Operations</small>
                </div>
                <div class="signature-item-portrait">
                    <div style="width: 150px; height: 45px;"></div>
                    <div class="sig-line"></div>
                    <strong>{{ $data['signatory2_name'] ?? 'Mr. James K. Mwita' }}</strong><br>
                    <small>Chief Executive Officer</small>
                </div>
            </div>

            <div class="qr-footer">
                <div
                    style="width: 65px; height: 65px; background: #f5f2e8; border: 1px solid #c6a43b; display: flex; align-items: center; justify-content: center;">
                    <span style="font-size: 10px;">QR</span>
                </div>
                <div style="font-size: 10px; color: #888;">
                    Scan to verify authenticity<br>
                    Cert ID: {{ $data['certificate_id'] ?? 'NMB-P-2025-001' }}
                </div>
            </div>
        </div>
    </div>
</div>


@endsection