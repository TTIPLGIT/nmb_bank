<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
    /* Your full original CSS is preserved */


    .certificate {
        position: relative;
        width: 612px;
        /* 8.5 inches */
        height: 792px;
        /* 11 inches */
        align-items: center !important;
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
        padding: 30px 60px 60px 60px;
        /* top, right, bottom, left */
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

    .signatures-row {
        padding-top: 129px;
    }

    .signature {
        width: 45%;
        text-align: center;
    }

    .signature-img {
        width: 100px;
        height: auto;
        margin-bottom: 10px;
    }

    .signature-line {
        width: 120px;
        height: 2px;
        background-color: #d4a017;
        margin: 5px auto;
    }

    .signature {
        float: left;
        width: 45%;
        margin-left: 5%;
    }

    .signature:last-child {
        float: right;
        margin-right: 0;
    }


    .g1 {
        position: absolute;
        top: 0;
        left: 10px;
        /* small offset from left edge */
        height: 10px;
        width: 500px;
        background-color: #d4a017;
        z-index: 1;
    }


    .g2 {
        position: absolute;
        bottom: 0;
        right: 10px;
        width: 500px;
        height: 10px;
        background-color: #d4a017;
        z-index: 1;
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

    .row,
    .col-12,
    .card,
    .card-body {
        padding: 0 !important;
        margin: 0 !important;
        border: none !important;
        background: none !important;
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
</head>

<body>

    <div class="certificate">
        <!-- Decorative Images -->
        <img src="{{ public_path('images/Certificate_template/NMB_level1/top_right_border.PNG') }}"
            class="top-right-image">
        <img src="{{ public_path('images/Certificate_template/NMB_level1/new_left_bottom.png') }}"
            class="bottom-left-image">

        <!-- Gold Edges -->
        <div class="g1"></div>
        <div class="gold-edge tl-gold">

        </div>
        <div class="gold-edge tr-gold"></div>
        <div class="gold-edge bl-gold"></div>
        <div class="gold-edge br-gold"></div>
        <div class="g2"></div>

        <!-- Certificate Body -->
        <div class="certificate-content">


            <div class="row">
                <div class="col-3">
                    <div class="nmb-logo">
                        <a href="/">
                            <img class="img-responsive" src="https://www.nmbbank.co.tz/images/nmb-white-logo.png"
                                alt="NMB Bank PLC">
                        </a>
                    </div>
                </div>
                <div class="col-9">
                    <div class="title">
                        <h1>CERTIFICATE</h1>
                        <h2>OF PARTICIPATION</h2>
                    </div>
                </div>
            </div>

            <div class="given">GIVEN TO</div>
            <div class="name">{{$data['name']}}</div>

            <div class="description">

                is thanked for their participation on {{$data['course_name']}}
                seminar organized by the NBA Organization.
            </div>

            <div class="date">Held on {{$data['date']}}</div>





            @php
            use BaconQrCode\Renderer\ImageRenderer;
            use BaconQrCode\Renderer\RendererStyle\RendererStyle;
            use BaconQrCode\Renderer\Image\SvgImageBackEnd;
            use BaconQrCode\Writer;

            use Illuminate\Support\Facades\Crypt;

            $encryptedId = Crypt::encryptString($data['course_id']);
            $url = route('certificate.verify', $encryptedId);


            $renderer = new ImageRenderer(
            new RendererStyle(75),
            new SvgImageBackEnd()
            );

            $writer = new Writer($renderer);

            $svg = $writer->writeString($url);

            $svgBase64 = 'data:image/svg+xml;base64,' . base64_encode($svg);
            @endphp

            <img src="{{ $svgBase64 }}" alt="QR Code" />







            <div class="signatures-row">
                @foreach ($data['signatories'] as $signatory)
                <div class="signature">
                    @if ($signatory->signature_path)
                    <img src="{{ config('setting.image_path') . $signatory->signature_path }}" class="signature-img">

                    @endif
                    <div class="signature-line"></div>
                    {{ $signatory->name }}<br>
                    <small>{{ $signatory->title }}</small>
                </div>
                @endforeach
            </div>



        </div>
    </div>

</body>

</html>