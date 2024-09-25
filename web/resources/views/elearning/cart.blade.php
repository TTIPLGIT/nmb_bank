@extends('layouts.elearningmain')

@section('content')
<style>
    /* remove card bocy shadow */
    .price_tag_container2 {
        margin: 0rem 0.4rem;
        font-size: 1rem;
        gap: 10px;
        color: #a435f0;

    }



    .checkout_cart_wrapper {
        max-width: 320px;
    }



    .noShadow .card-body {
        box-shadow: none !important;
    }

    .form-control {
        background-color: #fdfdff !important;
        box-shadow: none !important;
        border: 1px solid #000 !important;
        border-radius: 0px !important;
    }

    .shopping_main_header {
        width: fit-content;
        color: #0006cc;
        font-weight: 900;
        font-size: 1.5rem !important;
        margin-bottom: 1rem !important;
    }

    .text-0006cc {
        color: #0006cc !important;
    }

    /* courses in the cart */
    .courses_in_cart_container {
        width: 100%;
        margin: 1.5rem 0px;
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .course_image {
        width: 20%;
    }

    .price_tag_container {
        width: 15%;
        color: #a435f0;
    }

    .price_tag_container i {
        margin: 0rem 0.4rem;
        font-size: 1rem;
        color: #a435f0;
    }

    .course_cart_menus {
        width: 100%;
        gap: 9px;
    }

    .course_details_container {
        width: 36%;
    }

    .course_name h5,
    .course_instructor h6 {
        display: -webkit-box;
        max-width: 100%;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .course_orginal_price {
        text-decoration: line-through;
    }

    .course_price {
        font-weight: 700;
    }


    /* checkout */
    .overall-total {
        width: fit-content;
        color: #000;
        font-weight: 900;
        font-size: 1.5rem !important;
    }

    .overall_orginal_price {
        text-decoration: line-through;
    }

    .checkout_button {
        color: #fff;
        background-image: linear-gradient(to right, #3f9a9d, #3f9a9d, #3f9a9d, #3f9a9d, #3f9a9d);
        border: 0px;
        margin-top: 1rem;
        height: 3rem;
        border-radius: 8px;
        box-shadow: 3px 3px 3px gray !important;
        font-size: 16px;
    }

    .promotion_cart_header {
        border-top: 1px solid #fff;
        margin-top: 1rem;
        padding: 1rem;
    }

    .apply_button {
        color: #fff;
        border-radius: 8px;
        background-image: linear-gradient(to right, #3f9a9d, #3f9a9d, #3f9a9d, #3f9a9d, #3f9a9d);
    }

    @media (min-width:319.96px) {}

    @media (min-width:575.96px) {}

    @media (min-width:767.96px) {}

    @media (min-width:1024.96px) {
        .main-content {
            padding-left: 220px !important;
        }

        .sidebar-mini .main-content {
            padding-left: 85px !important;
        }
    }


    @media (min-width:320px) {
        .courses_in_cart_container {
            width: 100%;
            margin: 1.5rem 0px;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: space-between;
        }


    }

    @media (min-width:576px) {
        .course_cart_menus {


            flex-direction: column !important;

        }


    }

    @media (min-width:320px) and (max-width:991px) {
        .checkout_cart_wrapper {
            width: 100%;

        }

        .price_tag_container {
            display: none !important;
        }

    }

    @media (min-width:992px) {

        .price_tag_container2 {
            display: none !important;
            color: #a435f0;
        }

    }



    @media (min-width:320px) and (max-width:575px) {
        .course_image {
            width: 100%;
        }

        .shopping_cart_wrapper {
            width: 100%;
        }

        .course_details_container {
            width: 100%;
        }

        .course_cart_menus {
            padding-top: 0.5rem;
        }

        .cutoms_btn {
            font-size: 11px !important;
            padding: 4px;
            text-align: center;
            line-height: 1;
            box-shadow: 2px 2px 6px 0px #00000070 !important;
            background-color: #3abaf4;
            border-color: #3abaf4;
            color: white;
            border-radius: 3px;
        }
    }

    @media (min-width:576px) {

        .course_cart_menus {
            width: 25%;
            gap: 10px;
        }

    }


    /* checkout */
    @import url(https://fonts.googleapis.com/css?family=Lato:400,300,700);
    

    h2 {
        margin-bottom: 0px;
        margin-top: 25px;
        text-align: center;
        font-weight: 200;
        font-size: 19px;
        font-size: 1.2rem;

    }

    .container {
        height: 100%;
        -webkit-box-pack: center;
        -webkit-justify-content: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        /* background: -webkit-linear-gradient(#c5e5e5, #ccddf9); */
        /* background: linear-gradient(#c9e5e9,#ccddf9); */
    }

    .dropdown-select.visible {
        display: block;
    }

    .dropdown {
        position: relative;
    }

    ul {
        margin: 0;
        padding: 0;
    }

    ul li {
        list-style: none;
        padding-left: 10px;
        cursor: pointer;
    }

    ul li:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .dropdown-select {
        position: absolute;
        background: #77aaee;
        text-align: left;
        box-shadow: 0px 3px 5px 0px rgba(0, 0, 0, 0.1);
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px;
        width: 90%;
        left: 2px;
        line-height: 2em;
        margin-top: 2px;
        box-sizing: border-box;
    }

    .dropdown-btn {
        background: rgba(255, 255, 255, 0.1);
        width: 100%;
        border-radius: 5px;
        text-align: center;
        line-height: 1.5em;
        cursor: pointer;
        position: relative;
        -webkit-transition: background .2s ease;
        transition: background .2s ease;
        color: white;
    }

    .thin {
        font-weight: 400;
    }

    .small {
        font-size: 12px;
        font-size: .8rem;
    }

    .half-input-table {
        border-collapse: collapse;
        width: 100%;
    }

    .half-input-table td:first-of-type {
        border-right: 10px solid #4488dd;
        width: 49%;
        color: white;
    }

    .window {
        height: 540px;
        width: 100%;
        background: #fff;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        box-shadow: 0px 15px 50px 10px rgba(0, 0, 0, 0.2);
        border-radius: 30px;
        /* z-index: 10; */
        margin-top: 5%;
    }

    .order-info {
        height: 100%;
        width: 80%;
        padding-left: 25px;
        padding-right: 25px;
        box-sizing: border-box;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: center;
        -webkit-justify-content: center;
        -ms-flex-pack: center;
        justify-content: center;
        position: relative;
    }

    .price {
        bottom: 0px;
        position: initial;
        right: 0px;
        color: #4488dd;
    }

    .order-table td:first-of-type {
        width: 25%;
    }

    .order-table {
        position: relative;
    }

    .line {
        height: 1px;
        width: 100%;
        margin-top: 10px;
        margin-bottom: 10px;
        background: #ddd;
    }

    /* .order-table td:last-of-type {
    vertical-align: top;
    padding-left: 15px;
} */
    .order-info-content {
        table-layout: fixed;

    }

    .full-width {
        width: 100%;
        /* height: 54px; */

    }

    span.thin.small {
        font-size: 14px;
        padding: 20px;
    }

    .pay-btn {
        border: none;
        background: #22b877;
        line-height: 2em;
        border-radius: 10px;
        font-size: 19px;
        font-size: 1.2rem;
        color: #fff;
        cursor: pointer;
        position: absolute;
        bottom: 25px;
        width: calc(100% - 50px);
        -webkit-transition: all .2s ease;
        transition: all .2s ease;
    }

    .pay-btn:hover {
        background: #22a877;
        color: #eee;
        -webkit-transition: all .2s ease;
        transition: all .2s ease;
    }

    .total {
        margin-top: 25px;
        font-size: 20px;
        font-size: 1.3rem;
        position: absolute;
        bottom: 30px;
        right: 27px;
        left: 35px;
    }

    .dense {
        line-height: 1.2em;
        font-size: 16px;
        font-size: 1rem;
    }

    .input-field {
        background: rgba(255, 255, 255, 0.1);
        margin-bottom: 10px;
        margin-top: 3px;
        line-height: 1.5em;
        font-size: 20px;
        font-size: 1.3rem;
        border: none;
        padding: 5px 10px 5px 10px;
        color: #fff;
        box-sizing: border-box;
        width: 100%;
        margin-left: auto;
        margin-right: auto;
    }

    .credit-info {
        background: #2c847a;
        height: 100%;
        width: 50%;
        color: #eee;
        -webkit-box-pack: center;
        -webkit-justify-content: center;
        -ms-flex-pack: center;
        justify-content: center;
        font-size: 14px;
        font-size: .9rem;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        box-sizing: border-box;
        padding-left: 25px;
        padding-right: 25px;
        border-top-right-radius: 30px;
        border-bottom-right-radius: 30px;
        position: relative;
    }

    .dropdown-btn {
        background: rgba(255, 255, 255, 0.1);
        width: 100%;
        border-radius: 5px;
        text-align: center;
        line-height: 1.5em;
        cursor: pointer;
        position: relative;
        -webkit-transition: background .2s ease;
        transition: background .2s ease;
    }

    .dropdown-btn:after {
        content: '\25BE';
        right: 8px;
        position: absolute;
    }

    .dropdown-btn:hover {
        background: rgba(255, 255, 255, 0.2);
        -webkit-transition: background .2s ease;
        transition: background .2s ease;
    }

    .dropdown-select {
        display: none;
    }

    .credit-card-image {
        display: block;
        max-height: 80px;
        margin-left: auto;
        margin-right: auto;
        margin-top: 35px;
        margin-bottom: 15px;
    }

    .credit-info-content {
        margin-top: 25px;
        -webkit-flex-flow: column;
        -ms-flex-flow: column;
        flex-flow: column;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        width: 100%;
    }

    @media (max-width: 600px) {
        .window {
            width: 100%;
            height: 100%;
            display: block;
            border-radius: 0px;
        }

        .order-info {
            width: 100%;
            height: auto;
            padding-bottom: 100px;
            border-radius: 0px;
        }

        .credit-info {
            width: 100%;
            height: auto;
            padding-bottom: 100px;
            border-radius: 0px;
        }

        .pay-btn {
            border-radius: 0px;
        }
    }

    @media only screen and (max-width: 420px) {
        .full-width {
            width: 100%;
            /* height: 59px; */

        }

        .modal-header,
        .modal-body,
        .modal-footer {
            padding: 5px;
        }

    }

    .input-group-append {
        margin-left: -1px;
        height: 41px;
    }

    .btn.btn-primary {
        background-color: #0006cc !important;
        color: white !important;
        /* width: 159px !important; */
    }

    .rating-color {
        color: #b4690e !important;
    }
</style>
<!-- end checkout -->
<div class="main-content">
    <section class="section">
        <div class="section-body mt-1">

            <div class="col-md-12 d-flex flex-row align-items-center">
                <span class="col-md-7 shopping_main_header">
                    Shopping Cart
                </span>


            </div>


            <div class="row container-fluid">

                <div class="d-flex flex-column shopping_cart_wrapper col-8">
                    <div class="course_cart_wrapper">
                        <div class="w-100 course_cart_header">
                            <h6 class="text-capitalize">
                                <span>{{$rows['rows']['cart_count'][0]['total_count']}} Courses</span>
                                in cart
                            </h6>
                        </div>
                        @php $count = 1;@endphp
                        @foreach($rows['rows']['cart_list'] as $row)
                        <div class="card">
                            <div class="courses_in_cart_wrapper">
                                <div class="courses_in_cart_container">
                                    <img src="../../uploads/course/126/{{$row['course_banner']}}" alt="" class="course_image">
                                    <div class="d-flex flex-column course_details_container">
                                        <div class="course_name">
                                            <h5>
                                                {{ $row['course_name'] }}
                                            </h5>
                                        </div>
                                        <div class="course_instructor">
                                            <h6>{{ $row['course_instructor'] }}</h6>
                                        </div>
                                        <div class="text-left d-flex flex-row price_tag_container2">
                                            <!-- <span class="course_orginal_price">USh 3369<i class="fa fa-tag" aria-hidden="true"></i></span> -->
                                            <span class="course_price">USh {{ $row['course_price'] }} <i class="fa fa-tag" aria-hidden="true"></i></span>
                                        </div>
                                        <div class="d-flex flex-row justify-content-start">
                                            <span class="course_rating">
                                            </span>
                                            <span class="mx-2 course_rating_list ratingsset{{$count}}">
                                                @php $ratings= $row['average_rating']*2;

                                                $actual_rating=intval($ratings/2);

                                                @endphp
                                                @for($i=1;$i<=5;$i++) @if($i<=$actual_rating) <i class="fa fa-star rating-color"></i>
                                                    @else
                                                    <i class="fa fa-star unfilled-star"></i>
                                                    @endif
                                                    @endfor
                                                    @if($ratings%2 !=0)
                                                    <script>
                                                        var fa_list = document.querySelector('.ratingsset{{$count}} .unfilled-star');
                                                        fa_list.classList.remove('fa-star');
                                                        fa_list.classList.add('fa-star-half-o');
                                                        fa_list.classList.add('rating-color');
                                                    </script>
                                                    @endif
                                            </span>
                                            <span class="course_rating_count">
                                                {{ $row['average_rating'] }}
                                            </span>
                                        </div>
                                        @php $count++ @endphp
                                        <!-- <div class="d-flex flex-row justify-content-start">
                                            <span class="course_total_hours">
                                                13 total hours
                                            </span>
                                            <span class="mx-1">
                                                -
                                            </span>
                                            <span class="course_contents">
                                                180 content
                                            </span>
                                        </div> -->
                                    </div>

                                    <div class="d-flex flex-row  text-right course_cart_menus">
                                        <a class="cutoms_btn btn btn-primary" id="rmve_btn" role="button" onclick="remove_cart(event,{{ $row['id']}});" title="Remove from Cart">Remove</a>
                                        <!-- <a href="" class="cutoms_btn" role="button">Save for Later</a> -->
                                        @php
                                        $courseInWishlist = in_array($row['course_id'], $rows['wishListCourseIds']);

                                        @endphp
                                        
                                        @if (!$courseInWishlist)

                                        <a onclick="move_wish(event,{{ $row['course_id']}});" class="cutoms_btn btn btn-primary" id="move_btn" role="button" title="Add to Wishlist">Move to Wishlist</a>
                                        @else

                                        @endif
                                    </div>
                                    <div class="text-center d-flex flex-column price_tag_container">
                                        <!-- <span class="course_orginal_price">USh 3369<i class="fa fa-tag" aria-hidden="true"></i></span> -->
                                        <span class="course_price">USh {{ $row['course_price'] }}<i class="fa fa-tag" aria-hidden="true"></i></span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        @endforeach

                    
                    @php $is_display = $rows['rows']['cart_list'] ==[] ? 'd-none' : ''; @endphp
                    <div class="col-4 {{$is_display}}">
                        <div class="d-flex flex-column checkout_cart_wrapper">
                            @php
                            $totalPrice = 0;
                            $isEmpty = empty($rows['rows']['cart_list']);
                            @endphp
                            <div class="w-100 checkout_cart_header">
                                <h6 class="text-capitalize">
                                    <!-- Total -->
                                </h6>
                            </div>

                            <div class="w-100 d-flex flex-column checkout_container" @if($isEmpty) style="display: none;" @endif>
                                @foreach($rows['rows']['cart_list'] as $row)
                                @php
                                $totalPrice += $row['course_price'];
                                @endphp
                                @endforeach

                                <!-- <span class="offer-percentage"><span>86</span>% Off</span> -->
                                <span class="overall-total"><span>Total: USh {{ $totalPrice }}</span></span>
                            </div>
                            <a type="button" id="checkoutmodal" style="font-size:15px;width: 150px !important;" class="btn btn-success btn-lg question" title="Create" href="" data-toggle="modal" data-target="#addModal1" @if($isEmpty) style="display: none;" @endif>Checkout</a>


                        </div>

                    </div>
                    </div>
                    <br>
                    <br>
                    <div class="wishlist_cart_wrapper">
                        <div class="w-100 course_cart_header">
                            <h6 class="text-capitalize">
                                <span>{{$rows['rows']['wish_count'][0]['total_count']}} Recently Wishlist</span>
                            </h6>
                        </div>
                        @php $count2=0; @endphp
                        @foreach($rows['rows']['wish_list'] as $row2)
                        <div class="flex-lg-row courses_in_cart_container">
                            <img src="../../uploads/course/126/{{$row2['course_banner']}}" alt="" class="course_image">

                            <!-- <img src="{{asset('asset/image/recommended-course4.jpg')}}" alt="" class="course_image"> -->
                            <div class="d-flex flex-column course_details_container">
                                <div class="course_name">
                                    <h5>
                                        {{ $row2['course_name'] }}
                                    </h5>
                                </div>
                                <div class="course_instructor">
                                    <h6>{{ $row2['course_instructor'] }}</h6>
                                </div>
                                <div class="text-left d-flex flex-row price_tag_container2">
                                    <!-- <span class="course_orginal_price"><span>USh 3899</span><i class="fa fa-tag" aria-hidden="true"></i></span> -->
                                    <span class="course_price"><span> USh {{ $row2['course_price'] }}</span><i class="fa fa-tag" aria-hidden="true"></i></span>
                                </div>
                                <div class="d-flex flex-row justify-content-start">
                                    <span class="course_rating">

                                    </span>
                                    <span class="mx-2 course_rating_list wishlistset{{$count2}}">
                                        @php $ratings= $row2['average_rating']*2;
                                        $actual_rating=intval($ratings/2);

                                        @endphp
                                        @for($i=1;$i<=5;$i++) @if($i<=$actual_rating) <i class="fa fa-star rating-color"></i>
                                            @else
                                            <i class="fa fa-star unfilled-star"></i>
                                            @endif
                                            @endfor
                                            @if($ratings%2 !=0)
                                            <script>
                                                var fa_list = document.querySelector('.wishlistset{{$count2}} .unfilled-star');
                                                fa_list.classList.remove('fa-star');
                                                fa_list.classList.add('fa-star-half-o');
                                                fa_list.classList.add('rating-color');
                                            </script>
                                            @endif
                                    </span>
                                    <span class="course_rating_count">
                                        {{ $row2['average_rating'] }}
                                    </span>
                                </div>
                                @php $count2++ @endphp
                                <!-- <div class="d-flex flex-row justify-content-start">
                                    <span class="course_total_hours">
                                        15 total hours
                                    </span>
                                    <span class="mx-1">
                                        -
                                    </span>
                                    <span class="course_contents">
                                        106 content
                                    </span>
                                </div> -->
                            </div>
                            <div class="d-flex flex-row  text-right course_cart_menus">
                                <a onclick="remove_wish(event,{{ $row2['course_id']}});" class="cutoms_btn btn btn-primary" id="rmv_wish" role="button" title="Remove from Wishlist">Remove</a>
                                @if( $row2['course_price'] !=0)
                                <a onclick="move_cart(event,{{ $row2['course_id']}});" id="add_cart" class="cutoms_btn btn btn-primary" role="button" title="Add to Cart">Move to Cart</a>
                                @endif
                            </div>
                            <div class="text-center d-flex flex-column price_tag_container">
                                <!-- <span class="course_orginal_price"><span>USh 3899</span><i class="fa fa-tag" aria-hidden="true"></i></span> -->
                                <span class="course_price"><span>USh {{ $row2['course_price'] }}</span><i class="fa fa-tag" aria-hidden="true"></i></span>
                            </div>
                        </div>

                        @endforeach
                    </div>




                </div>

            </div>

        </div>

    </section>
</div>

<!-- modal checkout -->

<div class="modal fade" id="addModal1">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">


            <div class="modal-header mh">
                <h4 class="modal-title">Checkout</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" style="background-color: #f8fffb !important;">
                <input type="hidden" class="form-control" id="user_id" name="user_id" value="">
                <input type="hidden" class="form-control" id="user_details" name="user_details" value="general">

                <div class='container'>
                    <div class='window'>
                        <div class='order-info'>
                            <div class='order-info-content'>
                                <h2>Order Summary</h2>
                                @foreach($rows['rows']['cart_list'] as $row)
                                <div class='line'></div>
                                <table class='order-table'>
                                    <tbody>
                                        <tr>
                                            <td><img src="../../uploads/course/126/{{$row['course_banner']}}" class='full-width'></img>
                                            </td>
                                            <td>
                                                <br> <span class='thin'> {{ $row['course_name'] }}</span>
                                                <br>{{ $row['course_instructor'] }}<br> <span class='thin small'><br><br></span>

                                            </td>
                                            <td>
                                                <span class='price'>USh {{ $row['course_price'] }}</span>
                                            </td>
                                            <td><span><i class="fa fa-trash" aria-hidden="true" style="color: black;font-size: 23px !important;" id="rmve_sum" onclick="remove_summary(event,{{ $row['id']}});"></i></span></td>
                                        </tr>
                                        <!-- <tr>
                                                <td>
                                                    <div class='price'>USh {{ $row['course_price'] }}</div>
                                                </td>
                                            </tr> -->

                                    </tbody>

                                </table>
                                <!-- <div class='line'></div>
                                    <table class=' order-table'>
                                        <tbody>
                                            <tr>
                                                <td><img src='http://localhost:10/TALENTRAV3/web/resources/views/elearning/admin/noticeboard/image/images.jpeg' class='full-width'></img>
                                                </td>
                                                <td>
                                                    <br> <span class='thin'>CGM/GM</span>
                                                    <br>Executive Director on deputation<br> <span class='thin small'></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class='price'>USh 235.95</div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class='line'></div>
                                    <table class='order-table'>
                                        <tbody>
                                            <tr>
                                                <td><img src='http://localhost:10/TALENTRAV3/web/resources/views/elearning/admin/noticeboard/image/article-3.jpeg' class='full-width'></img>
                                                </td>
                                                <td>
                                                    <br> <span class='thin'>CGM/GM/DGM</span>
                                                    <br>Finance Division<br> <span class='thin small'></span>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class='price'>USh 25.95</div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class='line'></div> -->
                                @endforeach

                                <div class='total'>
                                    <span style='float:left;'>
                                        <div class='thin dense'></div>
                                        <div class='thin dense'></div>

                                    </span>
                                    <span style='float:right; text-align:right;'>
                                        <div class='thin dense'></div>
                                        <div class='thin dense'></div>

                                    </span>
                                </div>

                                <div class="offset-4 col-md-8">
                                    <form action="{!!route('course_summary.payment')!!}" method="POST">
                                        @csrf
                                        <input type="hidden" id="course_id" name="course_id" value="{{isset($rows['rows']['cart_list'][0]['course_id']) ? $rows['rows']['cart_list'][0]['course_id'] : 0 }}">
                                        <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="{{ config('setting.RAZORPAY_KEY') }}" data-amount="{{ number_format($totalPrice * 100, 2, '.', '') }}" data-button='false' data-name="TALENTRA Payment" data-description="Payment" data-prefill.name="name" data-prefill.email="email" data-theme.color="#ff7529">
                                        </script>
                                        <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                                        <button style="font-size:15px;" type="submit" class="btn btn-success btn-lg question">Proceed to Pay</button>
                                    </form>
                                </div>

                            </div>

                        </div>


                        <!-- <div class='credit-info'>
                                <div class='credit-info-content'>
                                    <table class='half-input-table'>
                                        <tr>
                                            <td>Please select your card: </td>
                                            <td>
                                                <div class='dropdown' id='card-dropdown'>
                                                    <div class='dropdown-btn' id='current-card'>Visa</div>
                                                    <div class='dropdown-select'>
                                                        <ul>
                                                            <li>Master Card</li>
                                                            <li>American Express</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <img src='http://localhost:10/TALENTRAV3/web/resources/views/elearning/admin/noticeboard/image/visa_logo.png' height='80' class='credit-card-image' id='credit-card-image'></img>
                                    Card Number
                                    <input class='input-field'></input>
                                    Card Holder
                                    <input class='input-field'></input>
                                    <table class='half-input-table'>
                                        <tr>
                                            <td> Expires
                                                <input class='input-field'></input>
                                            </td>
                                            <td>CVC
                                                <input class='input-field'></input>
                                            </td>
                                        </tr>
                                    </table>
                                    <button type="submit" class='pay-btn'>Checkout</button>

                                </div>

                            </div> -->
                    </div>
                </div>

            </div>

            </form>
        </div>




    </div>

</div>
<div class="modal fade" id="summary_payment">
    <div class="modal-dialog modal-lg">


        <div class="modal-content" style="margin-left:10%; margin-top:10%">



            <div class="container">
                <div class="row" style="justify-content:center !important">
                    <div class="col-md-6 offset-3 col-md-offset-6" style=" display: flex; justify-content: center;">

                        @if($message = Session::get('error'))
                        <div class="alert alert-danger alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <strong>Error!</strong> {{ $message }}
                        </div>
                        @endif

                        @if($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade {{ Session::has('success') ? 'show' : 'in' }}" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            <strong>Success!</strong> {{ $message }}
                        </div>
                        @endif


                        <form action="" method="POST">
                            @csrf
                            <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="rzp_test_KUJc3PyWmtOLvw" data-amount="2000000" data-buttontext="Proceed to Pay" data-name="Elinaservices.com" data-description="Rozerpay" data-image="http://localhost:10/Elina_ISMS/web/public/asset/image/Elina-icon.JPG" data-prefill.name="name" data-prefill.email="kaviya@talentakeaways.com" data-theme.color="green">
                            </script>
                            <a type="button" class="btn btn-labeled back-btn" title="Back" href="" style="color:white !important">
                                <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span> Back</a>

                        </form>


                    </div>
                </div>

            </div>

            </form>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>


<script>
    $(document).ready(function() {
        $('.razorpay-payment-button').hide();
    });

    function remove_cart(e, id) {
        if (e.target.id == "rmve_btn") {
            Swal.fire({
                title: "Are you sure,want to remove from Cart?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: "{{ url('/ElearningRemove/delete') }}",
                        type: 'GET',
                        data: {
                            'id': id,
                            _token: '{{csrf_token()}}'
                        },
                        error: function() {
                            alert('Something is wrong');
                        },
                        success: function(data) {
                            // alert('feef');
                            console.log(data);
                            if (result.value) {
                                Swal.fire("Success!", "Cart Removed Successfully!", "success").then((result) => {
                                    location.reload();
                                })
                            }

                        }

                    });

                }

            })
        }
    }

    function move_wish(e, id) {
        if (e.target.id == "move_btn") {
            Swal.fire({
                title: "Are you sure you want to add to wishlist?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/addWishList') }}",
                        type: 'GET',
                        data: {
                            'id': id,
                            _token: '{{csrf_token()}}'
                        },
                        error: function() {
                            alert('Something went wrong');
                        },

                        success: function(data) {
                            console.log(data);
                            if (result.value) {
                                Swal.fire("Success!", "Added to Wishlist!", "success").then((result) => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire("Error!", "Failed to add to Wishlist.", "error");
                            }
                        }
                    });
                }
            });
        }
    }

    function remove_wish(e, id) {

        if (e.target.id == "rmv_wish") {
            Swal.fire({
                title: "Are you sure you want to remove from wishlist?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/addWishList') }}",
                        type: 'GET',
                        data: {
                            'id': id,
                            _token: '{{csrf_token()}}'
                        },
                        error: function() {
                            alert('Something went wrong');
                        },

                        success: function(data) {
                            console.log(data);
                            if (result.value) {
                                Swal.fire("Success!", "Wishlist Removed Successfully!", "success").then((result) => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire("Error!", "Failed to add to Wishlist.", "error");
                            }
                        }
                    });
                }
            });
        }
    }

    function move_cart(e, course_id) {
        if (e.target.id == "add_cart") {
            Swal.fire({
                title: "Are you sure you want to add to cart?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/Elearningmovecart') }}",
                        type: 'GET',
                        data: {
                            'course_id': course_id,
                            _token: '{{csrf_token()}}'
                        },
                        error: function() {
                            alert('Something went wrong');
                        },

                        success: function(data) {
                            console.log(data);
                            if (result.value) {
                                Swal.fire("Success!", "Added to Cart!", "success").then((result) => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire("Error!", "Failed to add to Cart.", "error");
                            }
                        }
                    });
                }
            });
        }
    }

    function remove_summary(e, id) {
        if (e.target.id == "rmve_sum") {
            Swal.fire({
                title: "Are you sure,want to remove from Cart?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/ElearningRemove/delete') }}",
                        type: 'GET',
                        data: {
                            'id': id,
                            _token: '{{csrf_token()}}'
                        },
                        error: function() {
                            alert('Something is wrong');
                        },
                        success: function(data) {

                            console.log(data);
                            if (result.value) {
                                Swal.fire("Success!", "Cart Removed Successfully!", "success").then((result) => {
                                    location.reload();
                                })
                            }

                        }

                    });

                }

            })
        }
    }
</script>





@endsection