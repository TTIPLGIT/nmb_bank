<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Errors</title>

<body class="body_bg">



    <section class="page_404 ">
        <div class="container ">
            <img class="bg_image" src="images\TALENTRA-IMG (1).png" alt="">
            <div class="row">
                <div class="col-md-6 width-50  text-center">
                    <div class="contant_box_404">
                        <h3 class="h2">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf

                                Your Session has been Expired,<br> Please click here to go Back <br>
                                <button class="link_404" type="submit">Click Here</button>
                            </form>
                        </h3>

                    </div>
                </div>
                <div class="col-md-1 "></div>
                <div class="col-md-4 width-40  text-center">

                    <div class="four_zero_four_bg ">




                    </div>
                </div>
                <div class="col-md-1"></div>

            </div>
        </div>
    </section>



</body>
<style>
    /*======================
    404 page
=======================*/
.bg_image{
    position: absolute;
    width: 35%;
    margin: auto;
    left: 30%;
    opacity: 0.2;
}
    .body_bg {
        background-color: #f9f7f7;
        height: auto;
    }

    .width-50 {
        width: 50%;
        float: left;
        position: relative;
    }

    .width-40 {
        width: 40%;
        float: left;
        position: relative;
    }

    .text-center {
        text-align: center;

    }

    .page_404 {

        background: #fff;
        font-family: 'Arvo', serif;
    }

    .page_404 img {

    }

    .four_zero_four_bg {
        background-image: url(/asset/image/logo-mlhud.png);
        height: 400px;
        background-repeat: no-repeat;
        background-position: center;
        margin-top: 10%;
        background-size: contain;
    }


    .four_zero_four_bg h1 {
        font-size: 80px;
    }

    .four_zero_four_bg h3 {
        font-size: 80px;
    }

    .link_404 {
        color: #fff !important;
        padding: 10px 20px;
        background: #2f9d28;
        margin: 20px 0;
        cursor: pointer;
        font-size: 20px;
        border-radius: 20px;
        border: none;
        display: inline-block;
    }

    .contant_box_404 {
        font-size: 22px;
        font-weight: bold;
        margin-top: 20%;
        padding: 5%;
    }
</style>

</head>

</html>
