<style>
    .title {
        position: relative;
        margin-top: 30px;
        width: 100%;
        text-align: center;
    }

    .timeline {
        position: relative;
        width: 100%;
        padding: 30px 0;
    }

    .timeline .timeline-container {
        position: relative;
        width: 100%;
    }

    .timeline .timeline-end,
    .timeline .timeline-start,
    .timeline .timeline-year {
        position: relative;
        width: 100%;
        text-align: center;
        z-index: 1;
    }

    .timeline .timeline-end p,
    .timeline .timeline-start p,
    .timeline .timeline-year p {
        display: inline-block;
        width: 80px;
        height: 80px;
        margin: 0;
        padding: 30px 0;
        text-align: center;
        background: linear-gradient(#4F84C4, #00539C);
        border-radius: 100px;
        box-shadow: 0 0 5px rgba(0, 0, 0, .4);
        color: #ffffff;
        font-size: 14px;
        text-transform: uppercase;
    }

    .timeline .timeline-year {
        margin: 30px 0;
    }

    .timeline .timeline-continue {
        position: relative;
        width: 100%;
        padding: 60px 0;
    }

    .timeline .timeline-continue::after {
        position: absolute;
        content: "";
        width: 1px;
        height: 100%;
        top: 0;
        left: 50%;
        margin-left: -1px;
        background: #4F84C4;
    }

    .timeline .row.timeline-left,
    .timeline .row.timeline-right .timeline-date {
        text-align: right;
    }

    .timeline .row.timeline-right,
    .timeline .row.timeline-left .timeline-date {
        text-align: left;
    }

    .timeline .timeline-date {
        font-size: 14px;
        /* font-weight: 600; */
        margin: 41px 0 0 0;
    }

    .timeline .timeline-date::after {
        content: '';
        display: block;
        position: absolute;
        width: 14px;
        height: 14px;
        top: 45px;
        background: linear-gradient(#4F84C4, #00539C);
        box-shadow: 0 0 5px rgba(0, 0, 0, .4);
        border-radius: 15px;
        z-index: 1;
    }

    .timeline .row.timeline-left .timeline-date::after {
        left: -7px;
    }

    .timeline .row.timeline-right .timeline-date::after {
        right: -7px;
    }

    .timeline .timeline-box,
    .timeline .timeline-launch {
        position: relative;
        display: inline-block;
        margin: 15px;
        padding: 20px;
        border: 1px solid #dddddd;
        border-radius: 6px;
        background: #ffffff;
    }

    .timeline .timeline-launch {
        width: 100%;
        margin: 15px 0;
        padding: 0;
        border: none;
        text-align: center;
        background: transparent;
    }

    .timeline .timeline-box::after,
    .timeline .timeline-box::before {
        content: '';
        display: block;
        position: absolute;
        width: 0;
        height: 0;
        border-style: solid;
    }

    .timeline .row.timeline-left .timeline-box::after,
    .timeline .row.timeline-left .timeline-box::before {
        left: 100%;
    }

    .timeline .row.timeline-right .timeline-box::after,
    .timeline .row.timeline-right .timeline-box::before {
        right: 100%;
    }

    .timeline .timeline-launch .timeline-box::after,
    .timeline .timeline-launch .timeline-box::before {
        left: 50%;
        margin-left: -10px;
    }

    .timeline .timeline-box::after {
        top: 26px;
        border-color: transparent transparent transparent #ffffff;
        border-width: 10px;
    }

    .timeline .timeline-box::before {
        top: 25px;
        border-color: transparent transparent transparent #dddddd;
        border-width: 11px;
    }

    .timeline .row.timeline-right .timeline-box::after {
        border-color: transparent #ffffff transparent transparent;
    }

    .timeline .row.timeline-right .timeline-box::before {
        border-color: transparent #dddddd transparent transparent;
    }

    .timeline .timeline-launch .timeline-box::after {
        top: -20px;
        border-color: transparent transparent #dddddd transparent;
    }

    .timeline .timeline-launch .timeline-box::before {
        top: -19px;
        border-color: transparent transparent #ffffff transparent;
        border-width: 10px;
        z-index: 1;
    }

    .timeline .timeline-box .timeline-icon {
        position: relative;
        width: 40px;
        height: auto;
        float: left;
    }

    .timeline .timeline-icon i {
        font-size: 25px;
        color: #4F84C4;
    }

    .timeline .timeline-box .timeline-text {
        position: relative;
        width: calc(100% - 40px);
        float: left;
    }

    .timeline .timeline-launch .timeline-text {
        width: 100%;
    }

    .timeline .timeline-text h3 {
        font-size: 16px;
        /* font-weight: 600; */
        margin-bottom: 3px;
    }

    .timeline .timeline-text p {
        font-size: 14px;
        /* font-weight: 400; */
        margin-bottom: 0;
    }

    @media (max-width: 768px) {
        .timeline .timeline-continue::after {
            left: 40px;
        }

        .timeline .timeline-end,
        .timeline .timeline-start,
        .timeline .timeline-year,
        .timeline .row.timeline-left,
        .timeline .row.timeline-right .timeline-date,
        .timeline .row.timeline-right,
        .timeline .row.timeline-left .timeline-date,
        .timeline .timeline-launch {
            text-align: left;
        }

        .timeline .row.timeline-left .timeline-date::after,
        .timeline .row.timeline-right .timeline-date::after {
            left: 47px;
        }

        .timeline .timeline-box,
        .timeline .row.timeline-right .timeline-date,
        .timeline .row.timeline-left .timeline-date {
            margin-left: 55px;
        }

        .timeline .timeline-launch .timeline-box {
            margin-left: 0;
        }

        .timeline .row.timeline-left .timeline-box::after {
            left: -20px;
            border-color: transparent #ffffff transparent transparent;
        }

        .timeline .row.timeline-left .timeline-box::before {
            left: -22px;
            border-color: transparent #dddddd transparent transparent;
        }

        .timeline .timeline-launch .timeline-box::after,
        .timeline .timeline-launch .timeline-box::before {
            left: 30px;
            margin-left: 0;
        }


    }

    .pin {
        transform: rotate(45deg) !Important;
    }
</style>
<div class="modal fade" id="cocModal{{$modalID}}">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="title">
                <h2>COC</h2>
            </div>
            <div class="timeline">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="timeline-container">
                                <div class="timeline-end">
                                    <p>Task</p>
                                </div>
                                <div class="timeline-continue">
                                    @foreach($currentTraker as $row)
                                    @php
                                    $rightorLeft = $loop->iteration%2 == 1 ? 'timeline-left' : 'timeline-right';
                                    $dateTime = new DateTime($row['created_at']);
                                    $formattedDate = $dateTime->format('jS M Y');
                                    @endphp
                                    @if($rightorLeft =='timeline-right')
                                    <div class="row {{$rightorLeft}}">
                                        <div class="col-md-6">
                                            <p class="timeline-date">
                                                {{$formattedDate}}
                                            </p>
                                        </div>
                                        @if(isset(json_decode($row['comments'])[0]->comments))
                                        <div class="col-md-6">
                                            <div class="timeline-box">
                                                <div class="timeline-icon">
                                                    <i class="fa fa-thumb-tack pin" aria-hidden="true"></i>
                                                </div>
                                                <div class="timeline-text">
                                                    <h3>{{$row['name']}}-{{$row['role_designation']}}</h3>
                                                    <p>{{json_decode($row['comments'])[0]->comments}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <div class="col-md-6">
                                            <div class="timeline-box">
                                                <div class="timeline-icon d-md-none d-block">
                                                    <i class="fa fa-thumb-tack pin" aria-hidden="true"></i>
                                                </div>
                                                <div class="timeline-text">
                                                    <h3>{{$row['name']}}-{{$row['role_designation']}}</h3>
                                                </div>
                                                <div class="timeline-icon d-md-block d-none">
                                                    <i class="fa fa-thumb-tack pin" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    @else
                                    <div class="row timeline-left">
                                        <div class="col-md-6 d-md-none d-block">
                                            <p class="timeline-date">
                                                {{$formattedDate}}
                                            </p>
                                        </div>
                                        @if(isset(json_decode($row['comments'])[0]->comments))
                                        <div class="col-md-6">
                                            <div class="timeline-box">
                                                <div class="timeline-icon d-md-none d-block">
                                                    <i class="fa fa-thumb-tack pin" aria-hidden="true"></i>
                                                </div>
                                                <div class="timeline-text">
                                                    <h3>{{$row['name']}}-{{$row['role_designation']}}</h3>
                                                    <p>{{json_decode($row['comments'])[0]->comments}}</p>
                                                </div>
                                                <div class="timeline-icon d-md-block d-none">
                                                    <i class="fa fa-thumb-tack pin" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <div class="col-md-6">
                                            <div class="timeline-box">
                                                <div class="timeline-icon d-md-none d-block">
                                                    <i class="fa fa-thumb-tack pin" aria-hidden="true"></i>
                                                </div>
                                                <div class="timeline-text">
                                                    <h3>{{$row['name']}}-{{$row['role_designation']}}</h3>
                                                </div>
                                                <div class="timeline-icon d-md-block d-none">
                                                    <i class="fa fa-thumb-tack pin" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    @endif
                                    @endforeach
                                    @if($userTaskData != [])
                                    @if($rightorLeft =='timeline-left')
                                    <div class="row {{$rightorLeft}}">
                                        <div class="col-md-6">
                                            <p class="timeline-date">
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="timeline-box">
                                                <div class="timeline-icon d-md-none d-block">
                                                    <i class="fa fa-thumb-tack pin" aria-hidden="true"></i>
                                                </div>
                                                <div class="timeline-text">
                                                    <h3>{{$userTaskData['name']}} - {{$userTaskData['role_designation']}}</h3>
                                                </div>
                                                <div class="timeline-icon d-md-block d-none">
                                                    <i class="fa fa-thumb-tack pin" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="row timeline-left">
                                        <div class="col-md-6 d-md-none d-block">
                                            <p class="timeline-date">
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="timeline-box">
                                                <div class="timeline-icon d-md-none d-block">
                                                    <i class="fa fa-thumb-tack pin" aria-hidden="true"></i>
                                                </div>
                                                <div class="timeline-text">
                                                    <h3>{{$userTaskData['name']}} - {{$userTaskData['role_designation']}}</h3>
                                                </div>
                                                <div class="timeline-icon d-md-block d-none">
                                                    <i class="fa fa-thumb-tack pin" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>