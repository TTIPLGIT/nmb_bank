@extends('layouts.adminnav')

@section('content')
<style>
.certificate-wrapper {
    background-color: #f4f4f4;
    margin: 0 auto;
    font-family: 'Segoe UI', sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
}

.certificate {
    background: #fff;
    width: 768px;
    height: auto;
    padding: 50px 40px;
    border: 5px solid #3b7d3b;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    text-align: center;
}

h1 {
    font-size: 32px;
    color: #245f24;
    margin-bottom: 10px;
}

.signature-img {
    width: 100px;

}

.company {
    color: #245f24;
    margin-bottom: 40px;
}

.label {
    font-size: 18px;
    color: #444;
}

.recipient {
    font-size: 28px;
    color: #1e4620;
    margin: 20px 0;
}

.description {
    font-size: 16px;
    color: #333;
    margin-bottom: 50px;
}

.footer {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-top: 30px;
    flex-wrap: wrap;
}

.signature-block {
    text-align: center;
    width: 30%;
}

.signature-line {
    width: 150px;
    height: 2px;
    background-color: #245f24;
    margin: 0 auto 8px;
}

.name {
    font-weight: bold;
    color: #2a462a;
    margin-bottom: 2px;
}

.title {
    font-size: 14px;
    color: #666;
}

.certificate-info {
    text-align: center;
    font-size: 14px;
    line-height: 1.5;
    color: #333;
    width: 30%;
}
</style>
<div class="main-content">
    {{ Breadcrumbs::render('certificate_template.show', $template['certificate_templates_id']) }}
    @if (session('fail'))
    <div class="alert alert-danger">
        {{ session('fail') }}
    </div>
    @endif
    <section class="section">
        <div class="section-body mt-1">
            <h5 style="color:darkblue">{{$template['template_name']}} Certificate Preview</h5>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">



                            <!DOCTYPE html>
                            <html lang="en">

                            <head>
                                <meta charset="UTF-8">
                                <title>Completion Certificate</title>
                                <link rel="stylesheet" href="style.css">
                            </head>

                            <div class="certificate-wrapper">
                                <div class="certificate">
                                    <h1>COMPLETION CERTIFICATE</h1>
                                    <h3 class="company">🏢 COMPANY NAME</h3>

                                    <p class="label">This certificate is granted to</p>
                                    <h2 class="recipient">Peter Gallagher</h2>

                                    <p class="description">
                                        Successfully completed the <strong>Corporate Governance course</strong>.<br>
                                        Skills and knowledge acquired: knowledge of organizational<br>
                                        and legal forms of legal entities.
                                    </p>

                                    <div class="footer">
                                        <div class="signature-block">
                                            <img src="{{asset('images/Certificate_template/NMB_level1/lorna.PNG')}}"
                                                alt="Lorna Signature" class="signature-img">
                                            <div class="signature-line"></div>
                                            <p class="name">Nathan Day</p>
                                            <p class="title">Chief Accountant</p>
                                        </div>

                                        <div class="certificate-info">
                                            <p><strong>Certificate ID No:</strong> 759-375-485</p>
                                            <p><strong>Date of issue:</strong> 12.06.2024</p>
                                        </div>

                                        <div class="signature-block">
                                            <img src="{{asset('images/Certificate_template/NMB_level1/silva.PNG')}}"
                                                alt="Juliana Signature" class="signature-img">
                                            <div class="signature-line"></div>
                                            <p class="name">Toby Stevens</p>
                                            <p class="title">Tax Management Professor</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            </html>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection