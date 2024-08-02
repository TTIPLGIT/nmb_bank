@extends('layouts.elearningmain')

@section('content')
<style>
    .no-arrow::-webkit-inner-spin-button {
        display: none;
    }

    .no-arrow::-webkit-outer-spin-button,
    .no-arrow::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }


    :root {
        --borderWidth: 5px;
        --height: 24px;
        --width: 12px;
        --borderColor: #78b13f;
    }




    .nav-justified {
        display: flex !important;
        align-items: center !important;
    }



    /* radiocss */
    .switch-field {
        display: flex;


    }

    .switch-field input {
        cur_valition: absolute !important;
        clip: rect(0, 0, 0, 0);
        height: 1px;
        width: 1px;
        border: 0;
        overflow: hidden;
    }

    .switch-field label {
        background-color: #e4e4e4;
        color: rgba(0, 0, 0, 0.6);
        font-size: 14px;
        line-height: 1;
        text-align: center;
        padding: 8px 16px;
        margin-right: -1px;
        border: 1px solid rgba(0, 0, 0, 0.2);
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
        transition: all 0.1s ease-in-out;
    }

    .switch-field label:hover {
        cursor: pointer;
    }

    .switch-field input:checked+label {
        background-color: #a5dc86;
        box-shadow: none;
    }

    .switch-field label:first-of-type {
        border-radius: 4px 0 0 4px;
    }

    .switch-field label:last-of-type {
        border-radius: 0 4px 4px 0;
    }

    /* endcss */


    .close {
        color: red;
        opacity: 1;
    }

    .close:hover {

        color: red;

    }

    @media only screen and (max-width: 425px) {
        .col-sm-2.addquizmodal {
            margin-bottom: 12px;
        }

        textarea#quistion {
            width: 100%;
        }

        textarea#quistions2 {
            width: 100%;
        }

        textarea#quistion11 {
            width: 100%;
        }
    }

    @media only screen and (max-width: 1024px) {
        .btn.btn-lg {
            padding: 10px 9px;
            font-size: 12px;
        }
    }

    .btn.btn-lg {
        padding: 10px 10px;
        font-size: 12px;
    }
</style>


<style>
    #counselorerroredit {
        color: red;
    }

    #supervisorerroredit {
        color: red;
    }

    .breadcrumb {
        display: inline-block !important;
        overflow: hidden !important;
        border-radius: 5px !important;
        counter-reset: flag !important;
        width: 249px;
        margin-left: 16px;
    }

    :root {
        --progress: 33%;
    }

    @keyframes growProgressBar {
        0% {
            background-image: conic-gradient(from 180deg,
                    rgb(48, 167, 40) 0%,
                    rgb(255, 255, 255) 0deg);
        }

        5% {
            background-image: conic-gradient(from 180deg,
                    rgb(48, 167, 40) calc((5 / 100) * var(--progress)),
                    rgb(255, 255, 255) 0deg);
        }

        10% {
            background-image: conic-gradient(from 180deg,
                    rgb(48, 167, 40) calc((10 / 100) * var(--progress)),
                    rgb(255, 255, 255) 0deg);
        }

        15% {
            background-image: conic-gradient(from 180deg,
                    rgb(48, 167, 40) calc((15 / 100) * var(--progress)),
                    rgb(255, 255, 255) 0deg);
        }

        20% {
            background-image: conic-gradient(from 180deg,
                    rgb(48, 167, 40) calc((20 / 100) * var(--progress)),
                    rgb(255, 255, 255) 0deg);
        }

        25% {
            background-image: conic-gradient(from 180deg,
                    rgb(48, 167, 40) calc((25 / 100) * var(--progress)),
                    rgb(255, 255, 255) 0deg);
        }

        30% {
            background-image: conic-gradient(from 180deg,
                    rgb(48, 167, 40) calc((30 / 100) * var(--progress)),
                    rgb(255, 255, 255) 0deg);
        }

        35% {
            background-image: conic-gradient(from 180deg,
                    rgb(48, 167, 40) calc((35 / 100) * var(--progress)),
                    rgb(255, 255, 255) 0deg);
        }

        40% {
            background-image: conic-gradient(from 180deg,
                    rgb(48, 167, 40) calc((40 / 100) * var(--progress)),
                    rgb(255, 255, 255) 0deg);
        }

        45% {
            background-image: conic-gradient(from 180deg,
                    rgb(48, 167, 40) calc((45 / 100) * var(--progress)),
                    rgb(255, 255, 255) 0deg);
        }

        50% {
            background-image: conic-gradient(from 180deg,
                    rgb(48, 167, 40) calc((50 / 100) * var(--progress)),
                    rgb(255, 255, 255) 0deg);
        }

        55% {
            background-image: conic-gradient(from 180deg,
                    rgb(48, 167, 40) calc((55 / 100) * var(--progress)),
                    rgb(255, 255, 255) 0deg);
        }

        60% {
            background-image: conic-gradient(from 180deg,
                    rgb(48, 167, 40) calc((60 / 100) * var(--progress)),
                    rgb(255, 255, 255) 0deg);
        }

        65% {
            background-image: conic-gradient(from 180deg,
                    rgb(48, 167, 40) calc((65 / 100) * var(--progress)),
                    rgb(255, 255, 255) 0deg);
        }

        70% {
            background-image: conic-gradient(from 180deg,
                    rgb(48, 167, 40) calc((70 / 100) * var(--progress)),
                    rgb(255, 255, 255) 0deg);
        }

        75% {
            background-image: conic-gradient(from 180deg,
                    rgb(48, 167, 40) calc((75 / 100) * var(--progress)),
                    rgb(255, 255, 255) 0deg);
        }

        80% {
            background-image: conic-gradient(from 180deg,
                    rgb(48, 167, 40) calc((80 / 100) * var(--progress)),
                    rgb(255, 255, 255) 0deg);
        }

        85% {
            background-image: conic-gradient(from 180deg,
                    rgb(48, 167, 40) calc((85 / 100) * var(--progress)),
                    rgb(255, 255, 255) 0deg);
        }

        90% {
            background-image: conic-gradient(from 180deg,
                    rgb(48, 167, 40) calc((90 / 100) * var(--progress)),
                    rgb(255, 255, 255) 0deg);
        }

        95% {
            background-image: conic-gradient(from 180deg,
                    rgb(48, 167, 40) calc((95 / 100) * var(--progress)),
                    rgb(255, 255, 255) 0deg);
        }

        100% {
            background-image: conic-gradient(from 180deg,
                    rgb(48, 167, 40) var(--progress),
                    rgb(255, 255, 255) 0deg);
        }
    }

    .circle {
        position: relative;
        width: 200px;
        height: 200px;
        margin: 0.5rem;
        border-radius: 50%;
        background-image: conic-gradient(from 180deg,
                rgb(48, 167, 40) var(--progress),
                rgb(255, 255, 255) 0deg);
        overflow: hidden;
        animation: growProgressBar 2s;
    }

    .circle .inner {
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 150px;
        height: 150px;
        background: black;
        border-radius: 50%;
        font-size: 2rem;
        font-weight: 300;
        color: (rgb(43 17 183) 0.75) !important;
    }
</style>
<script src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>

<div class="main-content main_contentspace">
    <div class="row">
        {{ Breadcrumbs::render('exam.list') }}
        <div class=" col-md-12">

            <section class="section5">
                <div class="section-body mt-2">
                    @if (session('success'))

                    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
                    <script type="text/javascript">
                        window.onload = function() {
                            var message = $('#session_data').val();
                            swal.fire({
                                title: "Success",
                                text: message,
                                icon: "success",
                                type: "success",
                            });

                        }
                    </script>
                    @elseif(session('error'))

                    <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
                    <script type="text/javascript">
                        window.onload = function() {
                            var message = $('#session_data1').val();
                            swal.fire({
                                title: "Info",
                                text: message,
                                icon: "info",
                                type: "info",
                            });

                        }
                    </script>
                    @endif



                    <div class="row">
                        <div class="col-12">

                            <div class="card mt-0">
                                <div class="card-body">
                                    <div class="col-lg-12 text-center">
                                        <h4>Exam View</h4>
                                    </div>
                                    <div class="table-wrapper">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="align1">
                                                <thead>
                                                    <tr>
                                                        <th>SI.No</th>
                                                        <th>Attempt</th>
                                                        <th>Score</th>
                                                        <th>Result/Actions</th>

                                                    </tr>
                                                </thead>
                                                <tbody style="background-color: #cfe0e8;">

                                                    @if($rows['rows']==[])
                                                    <tr>
                                                        <td>1</td>
                                                        <td>Attempt 1</td>
                                                        <td>-</td>
                                                        <td>
                                                            <a class="btn btn-primary" style="border-radius: 50px !important;background-color: darkblue;" href="{{ route('exam.quiz') }}">Take Test</a>

                                                        </td>

                                                    </tr>



                                                    @else

                                                    @foreach($rows['rows'] as $key=>$data)

                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>Attempt {{$data['attempt']}}</td>
                                                        <td>{{($data['score'])}}/{{$data['total_scores']}}
                                                            <button class="badge2 rounded-pill " style="width:45px !important;border:2px solid black;background-color: #000000 !important;" data-score="{{($data['score'])}}" data-total="{{$data['total_scores']}}" onclick="countanimate(event);"><i class="fa fa-th-list" style="pointer-events: none;" aria-hidden="true"></i></button>
                                                        </td>

                                                        <td style="color:#ffff;text-align: center;display: flex;justify-content: center;">
                                                            @if($data['result']=='PASS')
                                                            <span class="badge2 success rounded-pill text-bg-success" style="display: flex;width: 59px !important;justify-content: center;">{{$data['result']}}</span>
                                                            @else
                                                            <span class="badge2 danger rounded-pill text-bg-danger" style="display: flex;width: 59px !important;justify-content: center;">{{$data['result']}}</span>
                                                            @endif

                                                        </td>

                                                    </tr>

                                                    @if($data['result']=='PASS')
                                                    @php
                                                    $pass_confirmed=1;
                                                    @endphp
                                                    @endif
                                                    @endforeach

                                                    @if(!isset($pass_confirmed))
                                                    <tr>
                                                        <td>{{intval($key)+2}}</td>
                                                        <td>Attempt {{intval($key)+2}}</td>
                                                        <td>-</td>

                                                        <td>
                                                            <a class="btn btn-primary" style="border-radius: 50px !important;background-color: darkblue;" href="{{ route('exam.quiz') }}">Take Test</a>
                                                        </td>


                                                    </tr>

                                                    @endif
                                                    @endif

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>

            </section>

            </form>
        </div>

    </div>






</div>
<div class="modal fade" id="totalScore" tabindex="-1" role="dialog" aria-labelledby="totalScoreLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header px-3 py-3">
                <h5 class="modal-title" id="totalScoreLabel">Score Earned</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <h4 class="modal-body d-flex flex-row justify-content-center text-sucess bg-eee p-4 mb-0 totalScoreBody">
                <div class="circle">
                    <div class="inner" id="scoreCounter" style="color:white !important;"></div>
                </div>
            </h4>
            <!-- <div class="modal-footer justify-content-center bg-eee">
                <a type="button" href="" class="btn btn-primary" id="viewQuizResults">View Reults</a>
            </div> -->
        </div>
    </div>
</div>



<!-- <script>
    function totalScoreEval(e) {
        $('#totalScore').modal('show');

        // let viewScoreLink = document.createElement('a');
        // viewScoreLink.setAttribute('id', 'quizTotalScore');
        var score = parseFloat(e.target.getAttribute('data-score'));
        //alert(score, "score");
        var total = e.target.getAttribute('data-total');
        alert(total, "total");

        document.querySelector(':root').style.setProperty('--progress', `${score}%`);
        var element = document.querySelector('.totalScoreBody .inner');


        element.innerHTML = `0.00/${total}`;
        element.setAttribute('correct_value', `${(score.toFixed(2))}`);
        alert(element.getAttribute('correct_value'));
        // document.querySelector('#quizTotalScore').click();

        start_timer(total);
    }
</script> -->

<script>
    // // JavaScript code to update the score counter
    // var score = 0;
    // var stop = 1;

    // var scoreCounter = document.getElementById('scoreCounter');

    // var interval;

    // function updateScore(total) {
    //     var crt_value = $('.totalScoreBody .inner').attr('correct_value');

    //     if (!crt_value || crt_value == score.toFixed(2) || crt_value == 0) {
    //         stop = 0;

    //     } else {
    //         stop = 1;
    //         clearInterval(interval);
    //         start_timer();

    //     }
    //     scoreCounter.innerText = score.toFixed(2) + '/' + total;
    // }

    // // Example: Increment the score by 0.1 every second
    // function start_timer(total) {

    //     interval = setInterval(function() {
    //         updateScore(total);
    //         if (stop == 0) {
    //             return false;
    //         }
    //         score += 0.01;

    //     }, 0.001);

    // }

    // 

    // let countEnd = false;

    // function increment() {

    // }

    // function countanimate(e) {
    //     var score = parseFloat(e.target.getAttribute('data-score'));
    //     var total = e.target.getAttribute('data-total');
    //     document.querySelector('.inner') = `0/${total}`;

    //     if (score == 0) {
    //         countEnd = true;
    //     }
    //     if (!countEnd) {
    //         increment();
    //     }
    // }

    var id = null;

    function countanimate(e) {
        $('#totalScore').modal('show');
        var score = parseFloat(e.target.getAttribute('data-score'));
        var total = e.target.getAttribute('data-total');
        var elem = document.querySelector('.inner');
        var cur_val = 0;
        clearInterval(id);
        id = setInterval(frame, 4);
        document.querySelector(':root').style.setProperty('--progress', `${(score / total) * 100}%`);

        function frame() {
            if (cur_val >= score) {
                if (cur_val.toFixed(2) != 0) {
                    cur_val = cur_val.toFixed(2) - 0.01;
                }
                document.querySelector('.inner').innerHTML = `${cur_val.toFixed(2)}/${total}`;
                clearInterval(id);
            } else {
                cur_val = cur_val + 0.01;
                document.querySelector('.inner').innerHTML = `${cur_val.toFixed(2)}/${total}`;
            }
        }
    }
</script>








@endsection