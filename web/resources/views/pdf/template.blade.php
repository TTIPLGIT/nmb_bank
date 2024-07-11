<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
    <style>
        @page {
            size: landscape;
        }

        .container {
            text-align: center;
            height: 40vh;
        }

        .certificate {
            position: relative;
            width: 780px;
            /* Adjust the width for landscape view */
            height: 450px;
            /* Adjust the height as needed */
            margin: 0 auto;
            border: 2px solid #1a4011;
            text-align: center;
            font-family: Arial, sans-serif;
            padding: 20px;
            border-radius: 10px !important;
        }

        .medal {
            width: 100px !important;
            height: 200px !important;
            position: absolute;
            left: 800px !important;
            z-index: 2 !important;
        }

        .profile-image {
            width: 250px;
            height: 250px;
            position: absolute;
            top: 100px;
            z-index: -1;
            opacity: 0.2;
            left: 50%;
            transform: translateX(-50%);
        }

        .presented {
            margin-top: 20px;
        }

        .success_message {
            margin-top: 50px;
        }

        .certi_div {
            margin-top: 120px;
        }

        .sampleImg {
            width: 100px;
            height: 100px;
        }

        .sampleImg1 {
            width: 50px;
            height: 50px;
        }

        .text {
            text-align: center;
            color: red;
            font-weight: bold;
        }

        .align {
            text-align: center;
            font-weight: bold;
        }

        div.certificate-content h3,
        div.certificate-content p {
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card" style="padding:12px;">
            <div style="display:flex;align-items:center;width:100%;align-items:baseline;margin-top:8%">
                <div class="col-md-6">
                    <img class="sampleImg" src="{{asset('assets/images/logocnt.png')}}" style="width:35%;margin-left:5%">
                </div>
                <div class="col-md-6" style="display:flex;flex-direction:row-reverse">
                    <img class="sampleImg" src="{{asset('assets/images/logocnt.png')}}" style="margin-right:30%">
                </div>
            </div>
            <div style="text-align:center;margin-top:4%">
                <span style="text-align:center;font-size:30px;font-weight:bold">CERTIFICATE OF COMPLETION</span><bR>

            </div>
            <div style="margin-top:5%;font-size:18px;margin-left:5%;text-align:center">
                <span> Presented to </span><br>
                <span style="font-weight:bold;font-size:30px;color:blue">{{$name}}</span><br>

            </div>
            <div style="margin-top:5%;font-size:18px;margin-left:5%;text-align:center">
                <span>For successfully completing the online course</span><br>
                <span style="font-weight:bold">{{$course_name}}</span>
            </div>
            <div style="margin-top:5%;font-size:18px;margin-left:5%;text-align:center">
                <span style="font-size:15px">Provided By</span><br>
                <span style="font-weight:bold;padding:30px;">Talent Takeaways Infotech Private Limited</span><br>
                <span style="font-size:15px"> (on July 2024)</span>
            </div>
        </div>
        <!-- <img src="{{asset('assets/images/medal.png')}}" alt="" class="medal" />
        <div class="certificate">
            <h1>Certificate of Completion</h1>
            <div class="certi_div">
                <span class="presented" style="font-weight: 600;">Presented to</span><br />
                <span style="font-weight: 900; font-size: 20px !important;">{{$name}}</span>
                <br /><br /><br />
                <span class="success_message">For successfully completing this course </span><br />
                <span><b>{{$course_name}}</b> <b>on {{$date}}</b></span>
                <br /><br /><br />
                <span style="font-weight: 600">Presented by</span>
                <br>
                <img src="{{asset('assets/images/logocnt.png')}}" class="logo" style="width: 200px !important" />
            </div>
            <img src="{{asset('assets/images/MLHUD-IMG (1).png')}}" alt="" class="profile-image" />

        </div> -->
    </div>
</body>

</html>