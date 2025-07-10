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
    position: relative;
    width: 712px;
    height: 650px;
    background: #fff;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    overflow: hidden;
}

.corner-block {
    position: absolute;
    width: 60px;
    height: 60px;
    background: #0c1b33;
    z-index: 1;
}

.gold-edge {
    position: absolute;
    background-color: #d4a017;
}

.tl-gold {
    top: 0;
    left: 0;
    width: 10px;
    height: 300px;
}

.tr-gold {
    top: 0;
    right: 0;
    width: 10px;
    height: 200px;
}

.bl-gold {
    bottom: 0;
    left: 0;
    width: 10px;
    height: 200px;
}

.br-gold {
    bottom: 0;
    right: 0;
    width: 10px;
    height: 300px;
}

.certificate-content {
    position: relative;
    z-index: 2;
    padding: 60px;
    text-align: center;
}

.logo {
    text-align: left;
    font-weight: bold;
    color: #0c1b33;
}

.title {
    margin-top: 2px;
    letter-spacing: 1px;
}

.title h1 {
    font-size: 2.5em;
    margin: 0;
    color: #2d2d2d;
    letter-spacing: 2px;
    margin-top: 10px;

}

.title h2 {
    font-size: 25px;
    font-weight: normal;
    letter-spacing: 3px;
    color: #888;
    margin-top: -1px;
}

.given {
    margin-top: 30px;
    font-size: 25px;
    color: #5c5c5c;
    letter-spacing: 2px;
}

.name {
    font-size: 30px;
    font-weight: bold;
    color: #2d2d2d;
    margin: 20px 0;
    border-bottom: 2px solid #d4a017;
    width: 400px;
    display: inline-block;
    padding: 5px 30px;
}

.description {
    margin: 30px auto;
    max-width: 400px;
    font-size: 1em;
    color: #444;
    margin-top: -6px;
}

.date {
    margin-top: 10px;
    font-style: italic;
    color: #888;
}

.signatures {
    display: flex;
    justify-content: space-between;
    margin-top: -75px;
    padding: 0 20px;
}

.signature {
    text-align: center;
}

.signature-line {
    width: 150px;
    height: 2px;
    background: #d4a017;
    margin: 0 auto 5px;
}

.signature-img {
    width: 100px;

}

.g1 {
    height: 10px;
    width: 500px;
    background-color: #d4a017;
}

.g2 {
    position: absolute;
    bottom: 0;
    right: 10px;
    width: 500px;
    height: 10px;
    background-color: #d4a017;

}

.top-right-image {
    position: absolute;
    top: 0;
    right: 0;
    width: 150px;
    height: auto;
    z-index: 4;
}

.bottom-left-image {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 150px;
    height: auto;
    z-index: 4;
}

.border-line {
    position: absolute;
    z-index: 1;
}

.top-line {
    top: 0;
    left: 0;
    width: 100%;
    height: 8px;
    background-color: #f26f21;
}

.bottom-line {
    bottom: 0;
    left: 0;
    width: 100%;
    height: 8px;
    background-color: #0045a5;
}

.left-line {
    top: 0;
    left: 0;
    width: 8px;
    height: 100%;
    background-color: #f26f21;
}

.right-line {
    top: 0;
    right: 0;
    width: 8px;
    height: 100%;
    background-color: #0045a5;
}

.nmb-logo {
    background-color: #004A99;
    /* NMB blue or choose your color */
    padding: 10px;
    display: inline-block;
    border-radius: 6px;
    /* Optional: for rounded corners */
}

.nmb-logo img {
    max-height: 60px;
    height: auto;
    display: block;
    background-color: transparent;
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

                            <head>
                                <meta charset="UTF-8">
                                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                <title>Certificate of Participation</title>
                                <link href="cer.css" rel="stylesheet" />
                            </head>

                            <div class="certificate-wrapper">
                                <div class="certificate">

                                    <div class="border-line top-line"></div>
                                    <div class="border-line bottom-line"></div>
                                    <div class="border-line left-line"></div>
                                    <div class="border-line right-line"></div>

                                    <div class="certificate-content">
                                        <div class="nmb-logo">
                                            <a href="/">
                                                <img class="img-responsive"
                                                    src="https://www.nmbbank.co.tz/images/nmb-white-logo.png"
                                                    alt="NMB Bank PLC">
                                            </a>
                                        </div>
                                        <div class="title">
                                            <h1>CERTIFICATE</h1>
                                            <h2>OF PARTICIPATION</h2>
                                        </div>

                                        <div class="given">GIVEN TO</div>
                                        <div class="name">Margarita Perez</div>

                                        <div class="description">
                                            is thanked for their participation on "Technology in Entrepreneurship"
                                            seminar organized by the Ingoude Company.
                                        </div>

                                        <div class="date">Held on "16 December 2023"</div>
                                        @php
                                        use BaconQrCode\Renderer\ImageRenderer;
                                        use BaconQrCode\Renderer\RendererStyle\RendererStyle;
                                        use BaconQrCode\Renderer\Image\SvgImageBackEnd;
                                        use BaconQrCode\Writer;



                                        $renderer = new ImageRenderer(
                                        new RendererStyle(50),
                                        new SvgImageBackEnd()
                                        );

                                        $writer = new Writer($renderer);

                                        $svg = $writer->writeString('https://www.nmbbank.co.tz/');
                                        @endphp

                                        <div>

                                            {!! $svg !!}
                                        </div>

                                        <div class="signatures">
                                            <div class="signature"><br><br><br>
                                                <img src="{{asset('images/Certificate_template/NMB_level1/lorna.PNG')}}"
                                                    alt="Lorna Signature" class="signature-img">
                                                <div class="signature-line"></div>
                                                Lorna Alvarado<br>
                                                <small>CEO of Wardiere Inc.</small>
                                            </div>
                                            <div class="signature"><br><br><br>
                                                <div class="newsign"><img
                                                        src="{{asset('images/Certificate_template/NMB_level1/silva.PNG')}}"
                                                        alt="Juliana Signature" class="signature-img"><br></div>
                                                <div class="signature-line"></div>
                                                Juliana Silva<br>
                                                <small>Event Director</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection