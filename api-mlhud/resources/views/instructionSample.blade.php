<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid #ccc;
        }

        section {
            margin-top: 20px;
        }

        .qr-code {
            position: absolute;
            top: 20px;
            right: 20px;
        }
    </style>
</head>

<body>

    <header>
        <h1>Your Report Title</h1>
        <p>Subtitle or additional information about the report</p>
    </header>

    <div class="qr-code">
        <!-- Replace 'your.qr.code.route' with the actual route or URL to generate the QR code -->
        <img src="{{public_path('images/qrcode.png')}}" alt="QR Code" width="100">
        <p>Scan QR Code for more information</p>
    </div>

    <section>
        <h2>Section 1</h2>
        <p>Content for section 1 goes here...</p>
    </section>

    <section>
        <h2>Section 2</h2>
        <p>Content for section 2 goes here...</p>
    </section>

    <!-- Add more sections as needed -->

</body>

</html>