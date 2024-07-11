@extends('layouts.adminnav')

@section('content')
<style>
    .tab {
        overflow: hidden;
    }

    /* Style the buttons inside the tab */
    .tab button {
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
        font-size: 17px;
        background-color: transparent;
        font-weight: bold;
    }

    .tab button:hover {
        color: #50cd89 !important;
    }

    .tab button.active {
        color: #50cd89 !important;
    }


    /* Create an active/current tablink class */


    /* Style the tab content */
    .tabcontent {
        display: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
    }

    .textstyle {

        font-family: 'FontAwesome';
    }

    .proff_head {
        text-align: center !important;

        height: 50px;
        background: #3f9a9d;
    }

    .proff_head h4 {
        font-size: 18px;
        padding: 14px;
        color: #fff;
    }

    .proff-body {
        height: 100px;

    }

    .form-control111 {
        font-size: 20px;
        color: #000;
        display: block !important;
    }

    .form-control123 {
        font-size: 22px;
        color: #000;
        display: block !important;
        margin-top: 10px;
    }

    .dispaly_row {
        display: flex !important;
        align-items: baseline !important;
    }
</style>

<div class="main-content">
    @if (session('success'))

    <input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data').val();
            swal({
                title: "Success",
                text: message,
                type: "success",
            });

        }
    </script>
    @elseif(session('error'))

    <input type="hidden" name="session_data" id="session_data1" class="session_data" value="{{ session('error') }}">
    <script type="text/javascript">
        window.onload = function() {
            var message = $('#session_data1').val();
            swal({
                title: "Info",
                text: message,
                type: "info",
            });

        }
    </script>
    @endif
    @php $exist=$rows4; @endphp


    <div class="container-fluid">

        @if($exist ==0)
        <div class="row">

            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card" style="width:100%">
                    <div class="proff_head">
                        <h4>Criteria Needs to Apply For Professional Member</h4>
                    </div>
                    <div class="card-body">
                        <div class="content proff-body">
                            <div class="row dispaly_row">
                                <div class="col-md-2"></div>
                                <div class="col-md-4">

                                    <label class="form-control111">Ethic Test : </label>
                                </div>
                                <div class="col-md-4">
                                    <input type="checkbox" disabled name="" style="transform: scale(1.5);" class="form-control123">
                                </div>
                                <div class="col d-flex justify-content-center">
                                    <a type="button" class="btn btn-labeled btn-info" href="{{ url()->previous() }}" title="next" style="background: red !important; border-color:red !important; color:white !important; margin-top:15px !important;">
                                        <span class="btn-label" style="font-size:13px !important;"><i class="fa fa-arrow-left"></i></span>Back</a>
                                </div>

                            </div>




                        </div>

                    </div>

                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>


    @else
    <div class="col-lg-12 text-center">
        <h4>Professional Abilities</h4>
    </div>
    <div class="card">
        <div class="card-body textstyle">
            <div style="text-align:center;" class="offset-4 col-md-6">
                <button style="background-color:#50cd89; display: none;" class="btn btn-primary competency_selection" data-toggle="modal" data-target="#addModal">+Select compentencies</button>
            </div>
            <div>
                <div class="tab">
                    <button class="tablinks" style="color:#009ef7" id="tab1" onclick="">Mandatory</button>
                    <button class="tablinks" style="color:#009ef7" id="tab2" onclick="">Professional-Core</button>
                    <button class="tablinks d-none" style="color:#009ef7" id="tab3" onclick="">Technical-optional</button>
                </div>
                <hr>
                <div class="content">
                    <div class="tab1" id="Mandatory">
                        <div class="row" style="margin:1rem 1rem">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div style="display:flex">
                                        <div style="margin-top:1%;width:5%;font-size:28px">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        </div>
                                        <div style="width:68%">
                                            <h4 style="color:#7239ea!important"> Accounting principles and procedures </h4>
                                            <p>Demonstrate knowledge and understanding of the principles, behaviour and dynamics of working in a team.</p>
                                        </div>
                                        @php $id="accounting_principles";
                                        $exist="";
                                        @endphp
                                        <div style="width:25%;margin-top:3%;">
                                            @if(isset($rows))
                                            @foreach($rows as $row)
                                            @if($row['route_url']=="accounting_principles")
                                            @php $exist="0"; @endphp
                                            <h5> progress {{$row['Percentage']}}% </h5>
                                            <div class="progress-bar bg-success" role="progressbar" style="height:5px;width: {{ $row['Percentage'] }}%;"></div>
                                            @endif
                                            @endforeach
                                            @else
                                            <h5> progress {{$row['Percentage']}}% </h5>
                                            @endif
                                            @if($exist!='0')
                                            <h5> progress 0% </h5>

                                            @endif
                                        </div>
                                    </div>

                                    <div style="margin-left:20%; font-size:25px;display:flex;">
                                        <input type="hidden" name="route_url" value="accounting_principles">
                                        <a style="width:100%;text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                            @if(isset($rows))
                                            @foreach($rows as $row)
                                            @if($row['route_url']=="accounting_principles")
                                            @php $exist="0"; @endphp
                                            @if($row['is_submitted'] == '0')
                                            <span style="margin-left:1%;color:#50cd89">Edit Experience</span>
                                            @elseif($row['is_submitted'] == '1')
                                            <span style="margin-left:1%;color:#50cd89">Edit Experience</span>
                                            @endif
                                            @endif
                                            @endforeach
                                            @else
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span>
                                            @endif
                                            @if($exist!='0')
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span>
                                            @endif
                                        </a>

                                    </div>
                                </div>


                            </div>

                        </div>
                        <div class="row" style="margin:2rem 1rem">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div style="display:flex">
                                        <div style="margin-top:1%;width:5%;font-size:28px">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        </div>
                                        @php $id="business_planning";
                                        $exist="";
                                        @endphp
                                        <div style="width:68%">
                                            <h4 style="color:#7239ea!important"> Business planning </h4>
                                            <p>Demonstrate knowledge and understanding of the principles, behaviour and dynamics of working in a team.</p>
                                        </div>
                                        <div style="width:20%;margin-top:3%;">
                                            @if(isset($rows))
                                            @foreach($rows as $row)
                                            @if($row['route_url']=="business_planning")
                                            @php $exist="0"; @endphp
                                            <h5> progress {{$row['Percentage']}}% </h5>
                                            <div class="progress-bar bg-success" role="progressbar" style="height:5px;width: {{ $row['Percentage'] }}%;"></div>
                                            @endif
                                            @endforeach
                                            @else
                                            <h5> progress {{$row['Percentage']}}% </h5>
                                            @endif
                                            @if($exist!='0')
                                            <h5> progress 0% </h5>

                                            @endif
                                        </div>
                                    </div>

                                    <div style="margin-left:20%;font-size:25px;display:flex">
                                        <a style="width:100%; text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                            @if(isset($rows))
                                            @foreach($rows as $row)
                                            @if($row['route_url']=="business_planning")
                                            @php $exist="0"; @endphp
                                            @if($row['is_submitted'] == '0')
                                            <span style="margin-left:1%;color:#50cd89">Edit Experience</span>
                                            @elseif($row['is_submitted'] == '1')
                                            <span style="margin-left:1%;color:#50cd89">View Experience</span>
                                            @endif
                                            @endif
                                            @endforeach
                                            @else
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span>
                                            @endif
                                            @if($exist!='0')
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span>
                                            @endif
                                        </a>


                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin:2rem 1rem">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div style="display:flex">
                                        <div style="margin-top:1%;width:5%;font-size:28px">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        </div>
                                        <div style="width:68%">
                                            <h4 style="color:#7239ea!important"> Client care </h4>
                                            <p>Demonstrate knowledge and understanding of the principles, behaviour and dynamics of working in a team.</p>
                                        </div>
                                        @php $id="client_care"; $exist="";@endphp
                                        <div style="width:20%;margin-top:3%;">
                                            @if(isset($rows))
                                            @foreach($rows as $row)
                                            @if($row['route_url']=="client_care")
                                            @php $exist="0"; @endphp
                                            <h5> progress {{$row['Percentage']}}% </h5>
                                            <div class="progress-bar bg-success" role="progressbar" style="height:5px;width: {{ $row['Percentage'] }}%;"></div>
                                            @endif
                                            @endforeach
                                            @else
                                            <h5> progress {{$row['Percentage']}}% </h5>
                                            @endif
                                            @if($exist!='0')
                                            <h5> progress 0% </h5>
                                            @endif
                                        </div>


                                    </div>

                                    <div style="margin-left:20%;font-size:25px;display:flex">
                                        <a style="width:100%; text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                            @if(isset($rows))
                                            @foreach($rows as $row)
                                            @if($row['route_url']=="client_care")
                                            @php $exist="0"; @endphp
                                            @if($row['is_submitted'] == '0')
                                            <span style="margin-left:1%;color:#50cd89">Edit Experience</span>
                                            @elseif($row['is_submitted'] == '1')
                                            <span style="margin-left:1%;color:#50cd89">View Experience</span>
                                            @endif
                                            @endif
                                            @endforeach
                                            @else
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span>
                                            @endif
                                            @if($exist!='0')
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span>
                                            @endif
                                        </a>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="row" style="margin:2rem 1rem">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div style="display:flex">
                                        <div style="margin-top:1%;width:5%;font-size:28px">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        </div>
                                        <div style="width:68%">
                                            <h4 style="color:#7239ea!important"> Communication and negotiation </h4>
                                            <p>Demonstrate knowledge and understanding of the principles, behaviour and dynamics of working in a team.</p>
                                        </div>
                                        @php $id="communication_negotiation";$exist=""; @endphp
                                        <div style="width:20%;margin-top:3%;">
                                            @if(isset($rows))
                                            @foreach($rows as $row)
                                            @if($row['route_url']=="communication_negotiation")
                                            @php $exist="0"; @endphp
                                            <h5> progress {{$row['Percentage']}}% </h5>
                                            <div class="progress-bar bg-success" role="progressbar" style="height:5px;width: {{ $row['Percentage'] }}%;"></div>
                                            @endif
                                            @endforeach
                                            @else
                                            <h5> progress {{$row['Percentage']}}% </h5>
                                            @endif
                                            @if($exist!='0')
                                            <h5> progress 0% </h5>
                                            @endif
                                        </div>


                                    </div>

                                    <div style="margin-left:20%;font-size:25px;display:flex">
                                        <a style="width:100%; text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                            @if(isset($rows))
                                            @foreach($rows as $row)
                                            @if($row['route_url']=="communication_negotiation")
                                            @php $exist="0"; @endphp
                                            @if($row['is_submitted'] == '0')
                                            <span style="margin-left:1%;color:#50cd89">Edit Experience</span>
                                            @elseif($row['is_submitted'] == '1')
                                            <span style="margin-left:1%;color:#50cd89">View Experience</span>
                                            @endif
                                            @endif
                                            @endforeach
                                            @else
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span>
                                            @endif
                                            @if($exist!='0')
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span>
                                            @endif
                                        </a>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="row" style="margin:2rem 1rem">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div style="display:flex">
                                        <div style="margin-top:1%;width:5%;font-size:28px">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        </div>
                                        <div style="width:68%">
                                            <h4 style="color:#7239ea!important"> Conduct rules, ethics and professional practice </h4>
                                            <p>Demonstrate knowledge and understanding of the principles, behaviour and dynamics of working in a team.</p>
                                        </div>
                                        @php $id="conduct_rules"; $exist=""; @endphp

                                        <div style="width:20%;margin-top:3%;">
                                            @if(isset($rows))
                                            @foreach($rows as $row)
                                            @if($row['route_url']=="conduct_rules")
                                            @php $exist="0"; @endphp
                                            <h5> progress {{$row['Percentage']}}% </h5>
                                            <div class="progress-bar bg-success" role="progressbar" style="height:5px;width: {{ $row['Percentage'] }}%;"></div>
                                            @endif
                                            @endforeach
                                            @else
                                            <h5> progress {{$row['Percentage']}}% </h5>
                                            @endif
                                            @if($exist!='0')
                                            <h5> progress 0% </h5>
                                            @endif
                                        </div>


                                    </div>
                                    <div style="margin-left:20%;font-size:25px;display:flex">
                                        <a style="width:100%; text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                            @if(isset($rows))
                                            @foreach($rows as $row)
                                            @if($row['route_url']=="conduct_rules")
                                            @php $exist="0"; @endphp
                                            @if($row['is_submitted'] == '0')
                                            <span style="margin-left:1%;color:#50cd89">Edit Experience</span>
                                            @elseif($row['is_submitted'] == '1')
                                            <span style="margin-left:1%;color:#50cd89">View Experience</span>
                                            @endif
                                            @endif
                                            @endforeach
                                            @else
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span>
                                            @endif
                                            @if($exist!='0')
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span>
                                            @endif
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row" style="margin:2rem 1rem">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div style="display:flex">
                                        <div style="margin-top:1%;width:5%;font-size:28px">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        </div>
                                        <div style="width:68%">
                                            <h4 style="color:#7239ea!important"> Conflict avoidance, management and dispute resolution procedures </h4>
                                            <p>Demonstrate knowledge and understanding of the principles, behaviour and dynamics of working in a team.</p>
                                        </div>
                                        @php $id="conflict_avoidance"; $exist="";@endphp
                                        <div style="width:20%;margin-top:3%;">
                                            @if(isset($rows))
                                            @foreach($rows as $row)
                                            @if($row['route_url']=="conflict_avoidance")
                                            @php $exist="0"; @endphp
                                            <h5> progress {{$row['Percentage']}}% </h5>
                                            <div class="progress-bar bg-success" role="progressbar" style="height:5px;width: {{ $row['Percentage'] }}%;"></div>
                                            @endif
                                            @endforeach
                                            @else
                                            <h5> progress {{$row['Percentage']}}% </h5>
                                            @endif
                                            @if($exist!='0')
                                            <h5> progress 0% </h5>
                                            @endif
                                        </div>


                                    </div>

                                    <div style="margin-left:20%;font-size:25px;display:flex">
                                        <a style="width:100%; text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                            @if(isset($rows))
                                            @foreach($rows as $row)
                                            @if($row['route_url']=="conflict_avoidance")
                                            @php $exist="0"; @endphp
                                            @if($row['is_submitted'] == '0')
                                            <span style="margin-left:1%;color:#50cd89">Edit Experience</span>
                                            @elseif($row['is_submitted'] == '1')
                                            <span style="margin-left:1%;color:#50cd89">View Experience</span>
                                            @endif
                                            @endif
                                            @endforeach
                                            @else
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span>
                                            @endif
                                            @if($exist!='0')
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span>
                                            @endif
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="row" style="margin:2rem 1rem">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div style="display:flex">
                                        <div style="margin-top:1%;width:5%;font-size:28px">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        </div>
                                        <div style="width:68%">
                                            <h4 style="color:#7239ea!important"> Data management </h4>
                                            <p>Demonstrate knowledge and understanding of the principles, behaviour and dynamics of working in a team.</p>
                                        </div>
                                        @php $id="data_management"; $exist="";@endphp
                                        <div style="width:20%;margin-top:3%;">
                                            @if(isset($rows))
                                            @foreach($rows as $row)
                                            @if($row['route_url']=="data_management")
                                            @php $exist="0"; @endphp
                                            <h5> progress {{$row['Percentage']}}% </h5>
                                            <div class="progress-bar bg-success" role="progressbar" style="height:5px;width: {{ $row['Percentage'] }}%;"></div>
                                            @endif
                                            @endforeach
                                            @else
                                            <h5> progress {{$row['Percentage']}}% </h5>
                                            @endif
                                            @if($exist!='0')
                                            <h5> progress 0% </h5>
                                            @endif
                                        </div>


                                    </div>
                                    <div style="margin-left:20%;font-size:25px;display:flex">
                                        <a style="width:100%; text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                            @if(isset($rows))
                                            @foreach($rows as $row)
                                            @if($row['route_url']=="data_management")
                                            @php $exist="0"; @endphp
                                            @if($row['is_submitted'] == '0')
                                            <span style="margin-left:1%;color:#50cd89">Edit Experience</span>
                                            @elseif($row['is_submitted'] == '1')
                                            <span style="margin-left:1%;color:#50cd89">View Experience</span>
                                            @endif
                                            @endif
                                            @endforeach
                                            @else
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span>
                                            @endif
                                            @if($exist!='0')
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span>
                                            @endif
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row" style="margin:2rem 1rem">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div style="display:flex">
                                        <div style="margin-top:1%;width:5%;font-size:28px">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        </div>
                                        <div style="width:68%">
                                            <h4 style="color:#7239ea!important"> Health and safety </h4>
                                            <p>Demonstrate knowledge and understanding of the principles, behaviour and dynamics of working in a team.</p>
                                        </div>
                                        @php $id="health_safety"; $exist="";@endphp
                                        <div style="width:20%;margin-top:3%;">
                                            @if(isset($rows))
                                            @foreach($rows as $row)
                                            @if($row['route_url']=="health_safety")
                                            @php $exist="0"; @endphp
                                            <h5> progress {{$row['Percentage']}}% </h5>
                                            <div class="progress-bar bg-success" role="progressbar" style="height:5px;width: {{ $row['Percentage'] }}%;"></div>
                                            @endif
                                            @endforeach
                                            @else
                                            <h5> progress {{$row['Percentage']}}% </h5>
                                            @endif
                                            @if($exist!='0')
                                            <h5> progress 0% </h5>
                                            @endif
                                        </div>

                                    </div>

                                    <div style="margin-left:20%;font-size:25px;display:flex">
                                        <a style="width:100%; text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                            @if(isset($rows))
                                            @foreach($rows as $row)
                                            @if($row['route_url']=="health_safety")
                                            @php $exist="0"; @endphp
                                            @if($row['is_submitted'] == '0')
                                            <span style="margin-left:1%;color:#50cd89">Edit Experience</span>
                                            @elseif($row['is_submitted'] == '1')
                                            <span style="margin-left:1%;color:#50cd89">View Experience</span>
                                            @endif
                                            @endif
                                            @endforeach
                                            @else
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span>
                                            @endif
                                            @if($exist!='0')
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span>
                                            @endif
                                        </a>
                                    </div>
                                </div>

                            </div>


                        </div>
                        <div class="row" style="margin:2rem 1rem">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div style="display:flex">
                                        <div style="margin-top:1%;width:5%;font-size:28px">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        </div>
                                        <div style="width:68%">
                                            <h4 style="color:#7239ea!important"> Sustainability </h4>
                                            <p>Demonstrate knowledge and understanding of the principles, behaviour and dynamics of working in a team.</p>
                                        </div>
                                        @php $id="sustainability"; $exist="";@endphp

                                        <div style="width:20%;margin-top:3%;">
                                            @if(isset($rows))
                                            @foreach($rows as $row)
                                            @if($row['route_url']=="sustainability")
                                            @php $exist="0"; @endphp
                                            <h5> progress {{$row['Percentage']}}% </h5>
                                            <div class="progress-bar bg-success" role="progressbar" style="height:5px;width: {{ $row['Percentage'] }}%;"></div>
                                            @endif
                                            @endforeach
                                            @else
                                            <h5> progress {{$row['Percentage']}}% </h5>
                                            @endif
                                            @if($exist!='0')
                                            <h5> progress 0% </h5>
                                            @endif
                                        </div>

                                    </div>
                                    <div style="margin-left:20%;font-size:25px;display:flex">
                                        <a style="width:100%; text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                            @if(isset($rows))
                                            @foreach($rows as $row)
                                            @if($row['route_url']=="sustainability")
                                            @php $exist="0"; @endphp
                                            @if($row['is_submitted'] == '0')
                                            <span style="margin-left:1%;color:#50cd89">Edit Experience</span>
                                            @elseif($row['is_submitted'] == '1')
                                            <span style="margin-left:1%;color:#50cd89">View Experience</span>
                                            @endif
                                            @endif
                                            @endforeach
                                            @else
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span>
                                            @endif
                                            @if($exist!='0')
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span>
                                            @endif
                                        </a>
                                    </div>
                                </div>

                            </div>


                        </div>

                        <div class="row" style="margin:2rem 1rem">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div style="display:flex">
                                        <div style="margin-top:1%;width:5%;font-size:28px">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        </div>
                                        <div style="width:68%">
                                            <h4 style="color:#7239ea!important"> Team working </h4>
                                            <p>Demonstrate knowledge and understanding of the principles, behaviour and dynamics of working in a team.</p>
                                        </div>
                                        @php $id="team_working"; $exist="";@endphp
                                        <div style="width:20%;margin-top:3%;">
                                            @if(isset($rows))
                                            @foreach($rows as $row)
                                            @if($row['route_url']=="team_working")
                                            @php $exist="0"; @endphp
                                            <h5> progress {{$row['Percentage']}}% </h5>
                                            <div class="progress-bar bg-success" role="progressbar" style="height:5px;width: {{ $row['Percentage'] }}%;"></div>
                                            @endif
                                            @endforeach
                                            @else
                                            <h5> progress {{$row['Percentage']}}% </h5>
                                            @endif
                                            @if($exist!='0')
                                            <h5> progress 0% </h5>
                                            @endif
                                        </div>
                                    </div>


                                    <div style="margin-left:20%;font-size:25px;display:flex">
                                        <a style="width:100%; text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                            @if(isset($rows))
                                            @foreach($rows as $row)
                                            @if($row['route_url']=="team_working")
                                            @php $exist="0"; @endphp
                                            @if($row['is_submitted'] == '0')
                                            <span style="margin-left:1%;color:#50cd89">Edit Experience</span>
                                            @elseif($row['is_submitted'] == '1')
                                            <span style="margin-left:1%;color:#50cd89">View Experience</span>
                                            @endif
                                            @endif
                                            @endforeach
                                            @else
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span>
                                            @endif
                                            @if($exist!='0')
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span>
                                            @endif
                                        </a>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>
                    <div class="tab2" id="professional">
                        @if( count($rows3) !=0)
                        @foreach($rows3 as $row)
                        @php $id="inspection"; $exist="";@endphp
                        @if($row['route_url']=="inspection")
                        <div class="row" style="margin:1rem 1rem">

                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div style="display:flex">
                                        <div style="margin-top:1%;width:5%;font-size:28px">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        </div>
                                        <div style="width:68%">
                                            <h4 style="color:#7239ea!important">Inspection</h4>
                                            <p>This competency is about property and asset inspection, fundamental to providing accurate advice on machinery and business assets or property. It is important that candidates are able to demonstrate knowledge and understanding of the core requirements of property and asset inspection. Assessors will be seeking confirmation that all candidates have good knowledge of building construction, location analysis and defects.</p>
                                        </div>

                                        <div style="width:25%;margin-top:3%;">
                                            @if(isset($rows))
                                            @foreach($rows as $row)
                                            @if($row['route_url']=="inspection")
                                            @php $exist="0"; @endphp
                                            <h5> progress {{$row['Percentage']}}% </h5>
                                            <div class="progress-bar bg-success" role="progressbar" style="height:5px;width: {{ $row['Percentage'] }}%;"></div>
                                            @endif
                                            @endforeach
                                            @else
                                            <h5> progress {{$row['Percentage']}}% </h5>
                                            @endif
                                            @if($exist!='0')
                                            <h5> progress 0% </h5>
                                            @endif
                                        </div>
                                    </div>

                                    <div style="margin-left:20%;font-size:25px;display:flex">
                                        <a style="width:100%; text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                            @if(isset($rows))
                                            @foreach($rows as $row)
                                            @if($row['route_url']=="inspection")
                                            @php $exist="0"; @endphp
                                            @if($row['is_submitted'] == '0')
                                            <span style="margin-left:1%;color:#50cd89">Edit Experience</span>
                                            @elseif($row['is_submitted'] == '1')
                                            <span style="margin-left:1%;color:#50cd89">Edit Experience</span>
                                            @endif
                                            @endif
                                            @endforeach
                                            @else
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span>
                                            @endif
                                            @if($exist!='0')
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span>
                                            @endif
                                        </a>
                                    </div>
                                </div>


                            </div>

                        </div>
                        @endif
                        @endforeach
                        @foreach($rows3 as $row)
                        @php $id="valuation"; $exist="";@endphp

                        @if($row['route_url']=="valuation")

                        <div class="row" style="margin:2rem 1rem">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div style="display:flex">
                                        <div style="margin-top:1%;width:5%;font-size:28px">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        </div>
                                        <div style="width:68%">
                                            <h4 style="color:#7239ea!important"> Valuation </h4>
                                            <p>This competency is about the preparation of property valuation advice, made in accordance with the appropriate valuation standards, to enable clients make informed decisions.</p>
                                        </div>

                                        <div style="width:20%;margin-top:3%;">
                                            @if(isset($rows))
                                            @foreach($rows as $row)
                                            @if($row['route_url']=="valuation")
                                            @php $exist="0"; @endphp
                                            <h5> progress {{$row['Percentage']}}% </h5>
                                            <div class="progress-bar bg-success" role="progressbar" style="height:5px;width: {{ $row['Percentage'] }}%;"></div>
                                            @endif
                                            @endforeach
                                            @else
                                            <h5> progress {{$row['Percentage']}}% </h5>
                                            @endif
                                            @if($exist!='0')
                                            <h5> progress 0% </h5>
                                            @endif
                                        </div>
                                    </div>
                                    <div style="margin-left:20%;font-size:25px;display:flex">
                                        <a style="width:100%; text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                            @if(isset($rows))
                                            @foreach($rows as $row)
                                            @if($row['route_url']=="valuation")
                                            @php $exist="0"; @endphp
                                            @if($row['is_submitted'] == '0')
                                            <span style="margin-left:1%;color:#50cd89">Edit Experience</span>
                                            @elseif($row['is_submitted'] == '1')
                                            <span style="margin-left:1%;color:#50cd89">View Experience</span>
                                            @endif
                                            @endif
                                            @endforeach
                                            @else
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span>
                                            @endif
                                            @if($exist!='0')
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span>
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach


                        @foreach($rows3 as $row)
                        @php $id="measurement"; $exist="";@endphp
                        @if($row['route_url']=="measurement")

                        <div class="row" style="margin:2rem 1rem">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div style="display:flex">
                                        <div style="margin-top:1%;width:5%;font-size:28px">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        </div>
                                        <div style="width:68%">
                                            <h4 style="color:#7239ea!important"> Measurement of Land and Property </h4>
                                            <p>This competency is relevant to all data capture and measurement of land, property and assets.</p>
                                        </div>
                                        <div style="width:20%;margin-top:3%;">
                                            @if(isset($rows))
                                            @foreach($rows as $row)
                                            @if($row['route_url']=="measurement")
                                            @php $exist="0"; @endphp
                                            <h5> progress {{$row['Percentage']}}% </h5>
                                            <div class="progress-bar bg-success" role="progressbar" style="height:5px;width: {{ $row['Percentage'] }}%;"></div>
                                            @endif
                                            @endforeach
                                            @else
                                            <h5> progress {{$row['Percentage']}}% </h5>
                                            @endif
                                            @if($exist!='0')
                                            <h5> progress 0% </h5>
                                            @endif
                                        </div>
                                    </div>


                                    <div style="margin-left:20%;font-size:25px;display:flex">
                                        <a style="width:100%" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                            @if(isset($rows))
                                            @foreach($rows as $row)
                                            @if($row['route_url']=="measurement")
                                            @php $exist="0"; @endphp
                                            @if($row['is_submitted'] == '0')
                                            <span style="margin-left:1%;color:#50cd89">Edit Experience</span>
                                            @elseif($row['is_submitted'] == '1')
                                            <span style="margin-left:1%;color:#50cd89">View Experience</span>
                                            @endif
                                            @endif
                                            @endforeach
                                            @else
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span>
                                            @endif
                                            @if($exist!='0')
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span>
                                            @endif
                                        </a>
                                    </div>
                                </div>

                            </div>

                        </div>
                        @endif
                        @endforeach
                        @else

                        <div class="row" style="margin:1rem 1rem">

                            <div class="card" style="width:100%">
                                <div class="card-body d-flex align-items-center justify-content-center" style="height:100px">
                                    <strong class="">No Competencies were selected</strong>
                                </div>


                            </div>

                        </div>
                        @endif

                        <!-- <div class="row" style="margin:2rem 1rem">
                                <div class="card" style="width:100%">
                                    <div class="card-body">
                                        <div style="display:flex">
                                            <div style="margin-top:1%;width:5%;font-size:28px">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                            </div>
                                            <div style="width:68%">
                                                <h4 style="color:#7239ea!important"> Communication and negotiation </h4>
                                                <p>Demonstrate knowledge and understanding of the principles, behaviour and dynamics of working in a team.</p>
                                            </div>
                                            <div style="width:20%;margin-top:3%;margin-left">
                                                <h5> progress 0% </h5>
                                            </div>


                                        </div>
                                        <div style="margin-left:20%;font-size:25px;display:flex">
                                            <a style="width:100%" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                                <span style="margin-left:3%;color:#50cd89">Record Experience</span></a>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="row" style="margin:2rem 1rem">
                                <div class="card" style="width:100%">
                                    <div class="card-body">
                                        <div style="display:flex">
                                            <div style="margin-top:1%;width:5%;font-size:28px">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                            </div>
                                            <div style="width:68%">
                                                <h4 style="color:#7239ea!important"> Conduct rules, ethics and professional practice </h4>
                                                <p>Demonstrate knowledge and understanding of the principles, behaviour and dynamics of working in a team.</p>
                                            </div>
                                            <div style="width:20%;margin-top:3%;">
                                                <h5> progress 0% </h5>
                                            </div>


                                        </div>
                                        <div style="margin-left:20%;font-size:25px;display:flex">
                                            <a style="width:100%" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                                <span style="margin-left:3%;color:#50cd89">Record Experience</span></a>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row" style="margin:2rem 1rem">
                                <div class="card" style="width:100%">
                                    <div class="card-body">
                                        <div style="display:flex">
                                            <div style="margin-top:1%;width:5%;font-size:28px">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                            </div>
                                            <div style="width:68%">
                                                <h4 style="color:#7239ea!important"> Conflict avoidance, management and dispute resolution procedures </h4>
                                                <p>Demonstrate knowledge and understanding of the principles, behaviour and dynamics of working in a team.</p>
                                            </div>
                                            <div style="width:20%;margin-top:3%;">
                                                <h5> progress 0% </h5>
                                            </div>


                                        </div>
                                        <div style="margin-left:20%;font-size:25px;display:flex">
                                            <a style="width:100%" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                                <span style="margin-left:3%;color:#50cd89">Record Experience</span></a>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <div class="row" style="margin:2rem 1rem">
                                <div class="card" style="width:100%">
                                    <div class="card-body">
                                        <div style="display:flex">
                                            <div style="margin-top:1%;width:5%;font-size:28px">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                            </div>
                                            <div style="width:68%">
                                                <h4 style="color:#7239ea!important"> Data management </h4>
                                                <p>Demonstrate knowledge and understanding of the principles, behaviour and dynamics of working in a team.</p>
                                            </div>
                                            <div style="width:20%;margin-top:3%;">
                                                <h5> progress 0% </h5>
                                            </div>


                                        </div>
                                        <div style="margin-left:20%;font-size:25px;display:flex">
                                            <a style="width:100%" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                                <span style="margin-left:3%;color:#50cd89">Record Experience</span></a>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row" style="margin:2rem 1rem">
                                <div class="card" style="width:100%">
                                    <div class="card-body">
                                        <div style="display:flex">
                                            <div style="margin-top:1%;width:5%;font-size:28px">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                            </div>
                                            <div style="width:68%">
                                                <h4 style="color:#7239ea!important"> Health and safety </h4>
                                                <p>Demonstrate knowledge and understanding of the principles, behaviour and dynamics of working in a team.</p>
                                            </div>
                                            <div style="width:20%;margin-top:3%;">
                                                <h5> progress 0% </h5>
                                            </div>

                                        </div>
                                        <div style="margin-left:20%;font-size:25px;display:flex">
                                            <a style="width:100%" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                                <span style="margin-left:3%;color:#50cd89">Record Experience</span></a>
                                        </div>
                                    </div>

                                </div>


                            </div>
                            <div class="row" style="margin:2rem 1rem">
                                <div class="card" style="width:100%">
                                    <div class="card-body">
                                        <div style="display:flex">
                                            <div style="margin-top:1%;width:5%;font-size:28px">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                            </div>
                                            <div style="width:68%">
                                                <h4 style="color:#7239ea!important"> Sustainability </h4>
                                                <p>Demonstrate knowledge and understanding of the principles, behaviour and dynamics of working in a team.</p>
                                            </div>
                                            <div style="width:20%;margin-top:3%;">
                                                <h5> progress 0% </h5>
                                            </div>

                                        </div>
                                        <div style="margin-left:20%;font-size:25px;display:flex">
                                            <a style="width:100%" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                                <span style="margin-left:3%;color:#50cd89">Record Experience</span></a>
                                        </div>
                                    </div>

                                </div>


                            </div>

                            <div class="row" style="margin:2rem 1rem">
                                <div class="card" style="width:100%">
                                    <div class="card-body">
                                        <div style="display:flex">
                                            <div style="margin-top:1%;width:5%;font-size:28px">
                                                <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                            </div>
                                            <div style="width:68%">
                                                <h4 style="color:#7239ea!important"> Team working </h4>
                                                <p>Demonstrate knowledge and understanding of the principles, behaviour and dynamics of working in a team.</p>
                                            </div>
                                            <div style="width:20%;margin-top:3%;">
                                                <h5> progress 0% </h5>
                                            </div>
                                        </div>
                                        <div style="margin-left:20%;font-size:25px;display:flex">
                                            <a style="width:100%" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                                <span style="margin-left:3%;color:#50cd89">Record Experience</span></a>
                                        </div>
                                    </div>

                                </div>


                            </div> -->
                    </div>

                    <div class="tab3 d-none" id="Technical">
                        <div class="row" style="margin:1rem 1rem">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div style="display:flex">
                                        <div style="margin-top:1%;width:5%;font-size:28px">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        </div>
                                        <div style="width:68%">
                                            <h4 style="color:#7239ea!important"> Access and Rights over Land </h4>
                                            <p>This competency is about access and easements for power, water and communications infrastructure including way-leaves and the differing methods of acquisition and compensation negotiations, including fees.</p>
                                        </div>
                                        <div style="width:25%;margin-top:3%;">
                                            <h5> progress 0% </h5>
                                        </div>
                                    </div>
                                    <div style="margin-left:20%;font-size:25px;display:flex">
                                        <a style="width:100%; text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span></a>
                                    </div>
                                </div>


                            </div>

                        </div>
                        <div class="row" style="margin:2rem 1rem">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div style="display:flex">
                                        <div style="margin-top:1%;width:5%;font-size:28px">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        </div>
                                        <div style="width:68%">
                                            <h4 style="color:#7239ea!important"> Conflict Avoidance, Management, and Dispute Resolution Procedures </h4>
                                            <p>This competency covers knowledge, understanding and application of a range of processes related to dispute/ conflict avoidance, management and dispute resolution.</p>
                                        </div>
                                        <div style="width:20%;margin-top:3%;">
                                            <h5> progress 0% </h5>
                                        </div>
                                    </div>
                                    <div style="margin-left:20%;font-size:25px;display:flex">
                                        <a style="width:100%; text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin:2rem 1rem">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div style="display:flex">
                                        <div style="margin-top:1%;width:5%;font-size:28px">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        </div>
                                        <div style="width:68%">
                                            <h4 style="color:#7239ea!important"> Auctioneering </h4>
                                            <p>This competency reflects the complex factors governing auctioneering including online auctions. It includes aspects of law of sale and contract, misdescription etc., as well as requiring the candidate to have knowledge of the auction process and reasons for recommending sale by auction (or otherwise) over and above other methods of disposal.</p>
                                        </div>
                                        <div style="width:20%;margin-top:3%;">
                                            <h5> progress 0% </h5>
                                        </div>


                                    </div>
                                    <div style="margin-left:20%;font-size:25px;display:flex">
                                        <a style="width:100%; text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span></a>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="row" style="margin:2rem 1rem">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div style="display:flex">
                                        <div style="margin-top:1%;width:5%;font-size:28px">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        </div>
                                        <div style="width:68%">
                                            <h4 style="color:#7239ea!important"> Building Pathology </h4>
                                            <p>Building pathology is core to many areas of surveying. It is essential that all candidates have an understanding of defects analysis, and the likely resultant defects from failures in building fabric. This ranges from the effects of a defective waterproof covering at simple building pathology, to much complex defects such as interstitial condensation, and the possible effects on the building fabric. Candidates will need to have detailed construction technology knowledge.</p>
                                        </div>
                                        <div style="width:20%;margin-top:3%;">
                                            <h5> progress 0% </h5>
                                        </div>


                                    </div>
                                    <div style="margin-left:20%;font-size:25px;display:flex">
                                        <a style="width:100%; text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span></a>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="row" style="margin:2rem 1rem">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div style="display:flex">
                                        <div style="margin-top:1%;width:5%;font-size:28px">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        </div>
                                        <div style="width:68%">
                                            <h4 style="color:#7239ea!important"> Capital Taxation </h4>
                                            <p>This competency includes valuations and negotiations for inheritance tax, capital gains tax, etc. which may also include advising on stamp duty, capital allowances and advising on litigation. It involves measurement of and analysis of comparables and application of evidence to resolve negotiations. It also includes application of statute and case law.</p>
                                        </div>
                                        <div style="width:20%;margin-top:3%;">
                                            <h5> progress 0% </h5>
                                        </div>


                                    </div>
                                    <div style="margin-left:20%;font-size:25px;display:flex">
                                        <a style="width:100%; text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span></a>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row" style="margin:2rem 1rem">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div style="display:flex">
                                        <div style="margin-top:1%;width:5%;font-size:28px">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        </div>
                                        <div style="width:68%">
                                            <h4 style="color:#7239ea!important"> Compulsory Purchase and Compensation </h4>
                                            <p>The understanding and practical application, within the appropriate legal framework, of compulsory purchase powers, including the assessment of and claim for compensation. The candidate is expected to have an understanding from both the acquiring authority and claimant’s position.</p>
                                        </div>
                                        <div style="width:20%;margin-top:3%;">
                                            <h5> progress 0% </h5>
                                        </div>


                                    </div>
                                    <div style="margin-left:20%;font-size:25px;display:flex">
                                        <a style="width:100%; text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span></a>
                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="row" style="margin:2rem 1rem">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div style="display:flex">
                                        <div style="margin-top:1%;width:5%;font-size:28px">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        </div>
                                        <div style="width:68%">
                                            <h4 style="color:#7239ea!important"> Corporate Recovery and Insolvency </h4>
                                            <p>Covers our role when working with surveyors acting as Fixed Charge Receivers, or advising Insolvency Practitioners/ Lenders or providing advice to parties when a business is struggling to meet its commitments.</p>
                                        </div>
                                        <div style="width:20%;margin-top:3%;">
                                            <h5> progress 0% </h5>
                                        </div>


                                    </div>
                                    <div style="margin-left:20%;font-size:25px;display:flex">
                                        <a style="width:100%" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span></a>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row" style="margin:2rem 1rem">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div style="display:flex">
                                        <div style="margin-top:1%;width:5%;font-size:28px">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        </div>
                                        <div style="width:68%">
                                            <h4 style="color:#7239ea!important"> Development Appraisals </h4>
                                            <p>This competency is about the role of development appraisals in residential and commercial development. Development appraisals also have a role in residual valuations of development sites but it should be remembered that the two are different activities.</p>
                                        </div>
                                        <div style="width:20%;margin-top:3%;">
                                            <h5> progress 0% </h5>
                                        </div>

                                    </div>
                                    <div style="margin-left:20%;font-size:25px;display:flex">
                                        <a style="width:100%;text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span></a>
                                    </div>
                                </div>

                            </div>


                        </div>
                        <div class="row" style="margin:2rem 1rem">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div style="display:flex">
                                        <div style="margin-top:1%;width:5%;font-size:28px">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        </div>
                                        <div style="width:68%">
                                            <h4 style="color:#7239ea!important"> Indirect Investment Vehicles </h4>
                                            <p>This competency is about developing an understanding of indirect investment vehicles (Investment Trusts, REITS, LPs, etc.) and debt structures. It requires an awareness of existing vehicles and trends in the market and an ability to advise clients on optimal indirect investment solutions. </p>
                                        </div>
                                        <div style="width:20%;margin-top:3%;">
                                            <h5> progress 0% </h5>
                                        </div>

                                    </div>
                                    <div style="margin-left:20%;font-size:25px;display:flex">
                                        <a style="width:100%; text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span></a>
                                    </div>
                                </div>

                            </div>


                        </div>
                        <div class="row" style="margin:2rem 1rem">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div style="display:flex">
                                        <div style="margin-top:1%;width:5%;font-size:28px">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        </div>
                                        <div style="width:68%">
                                            <h4 style="color:#7239ea!important"> Insurance </h4>
                                            <p>In this context many candidates will be involved with insurance in relation to re-instatement and owner/tenant liability in the context of property/ assets. The candidate should demonstrate a thorough working knowledge of how insurance in relation to your area of practice is dealt with, and likely costs in the market place. </p>
                                        </div>
                                        <div style="width:20%;margin-top:3%;">
                                            <h5> progress 0% </h5>
                                        </div>

                                    </div>
                                    <div style="margin-left:20%;font-size:25px;display:flex">
                                        <a style="width:100%; text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span></a>
                                    </div>
                                </div>

                            </div>


                        </div>
                        <div class="row" style="margin:2rem 1rem">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div style="display:flex">
                                        <div style="margin-top:1%;width:5%;font-size:28px">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        </div>
                                        <div style="width:68%">
                                            <h4 style="color:#7239ea!important"> Investment Management (including fund and portfolio management) </h4>
                                            <p>Be conversant with the key principles of investment management theory and practice. Acquire and develop detailed asset management expertise and knowledge across a broad range of sectors and be able to apply these in a strategic contect.</p>
                                        </div>
                                        <div style="width:20%;margin-top:3%;">
                                            <h5> progress 0% </h5>
                                        </div>

                                    </div>
                                    <div style="margin-left:20%;font-size:25px;display:flex">
                                        <a style="width:100%; text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span></a>
                                    </div>
                                </div>

                            </div>


                        </div>
                        <div class="row" style="margin:2rem 1rem">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div style="display:flex">
                                        <div style="margin-top:1%;width:5%;font-size:28px">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        </div>
                                        <div style="width:68%">
                                            <h4 style="color:#7239ea!important"> Landlord and Tenant (including Rent Reviews and Lease Renewals) </h4>
                                            <p>This competency is about the management of the landlord and tenant relationship. It has a broad scope covering all aspects of lease negotiations arising between landlord and tenant. The candidate will be expected to understand the issues and how they affect both parties.</p>
                                        </div>
                                        <div style="width:20%;margin-top:3%;">
                                            <h5> progress 0% </h5>
                                        </div>

                                    </div>
                                    <div style="margin-left:20%;font-size:25px;display:flex">
                                        <a style="width:100%; text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span></a>
                                    </div>
                                </div>

                            </div>


                        </div>
                        <div class="row" style="margin:2rem 1rem">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div style="display:flex">
                                        <div style="margin-top:1%;width:5%;font-size:28px">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        </div>
                                        <div style="width:68%">
                                            <h4 style="color:#7239ea!important"> Leasing/ Letting </h4>
                                            <p>This competency is specifically in relation to the market for leasehold property/ assets and includes assignments. Candidates should be able to demonstrate an understanding and experience (if appropriate) of working for both lessee and lessor. The candidate should have knowledge of the whole transactional market for property/assets.</p>
                                        </div>
                                        <div style="width:20%;margin-top:3%;">
                                            <h5> progress 0% </h5>
                                        </div>

                                    </div>
                                    <div style="margin-left:20%;font-size:25px;display:flex">
                                        <a style="width:100%; text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span></a>
                                    </div>
                                </div>

                            </div>


                        </div>
                        <div class="row" style="margin:2rem 1rem">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div style="display:flex">
                                        <div style="margin-top:1%;width:5%;font-size:28px">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        </div>
                                        <div style="width:68%">
                                            <h4 style="color:#7239ea!important"> Local taxation/ assessment </h4>
                                            <p>Valuation and negotiation of rating appeals which may include attendance at Valuation Tribunals. Inspection, measurement and analysis of comparables. Application of evidence when dealing with appeals to include an understanding of the use of comparable rental evidence. Application of statute and casework.</p>
                                        </div>
                                        <div style="width:20%;margin-top:3%;">
                                            <h5> progress 0% </h5>
                                        </div>

                                    </div>
                                    <div style="margin-left:20%;font-size:25px;display:flex">
                                        <a style="width:100%; text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span></a>
                                    </div>
                                </div>

                            </div>


                        </div>

                        <div class="row" style="margin:2rem 1rem">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div style="display:flex">
                                        <div style="margin-top:1%;width:5%;font-size:28px">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        </div>
                                        <div style="width:68%">
                                            <h4 style="color:#7239ea!important"> Planning </h4>
                                            <p>The planning system plays a vital role in the opportunities available for any potential development scheme. This means it is important for developers to have good working knowledge and experience of the processes involved to ensure successful development outcomes.</p>
                                        </div>
                                        <div style="width:20%;margin-top:3%;">
                                            <h5> progress 0% </h5>
                                        </div>

                                    </div>
                                    <div style="margin-left:20%;font-size:25px;display:flex">
                                        <a style="width:100%; text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span></a>
                                    </div>
                                </div>

                            </div>


                        </div>
                        <div class="row" style="margin:2rem 1rem">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div style="display:flex">
                                        <div style="margin-top:1%;width:5%;font-size:28px">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        </div>
                                        <div style="width:68%">
                                            <h4 style="color:#7239ea!important"> Property Finance Funding </h4>
                                            <p>This competency focusses on the candidates’ understanding of the range of finance available, their understanding of how this is sourced and how this may be used to assist with property/ asset investment and development scenarios. Candidates will be expected to apply this knowledge in order to provide advice to clients on their financing options and the impact of this on their returns.</p>
                                        </div>
                                        <div style="width:20%;margin-top:3%;">
                                            <h5> progress 0% </h5>
                                        </div>

                                    </div>
                                    <div style="margin-left:20%;font-size:25px;display:flex">
                                        <a style="width:100%; text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span></a>
                                    </div>
                                </div>

                            </div>


                        </div>
                        <div class="row" style="margin:2rem 1rem">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div style="display:flex">
                                        <div style="margin-top:1%;width:5%;font-size:28px">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        </div>
                                        <div style="width:68%">
                                            <h4 style="color:#7239ea!important">Property Management</h4>
                                            <p>This competency covers all aspects of day to day functions associated with property management, covering all matters arising between the client and agent in the management of the property. It includes issues relating to works, health and safety, landlord and tenant relationships, and service charges. In general, any matter associated with the smooth running of property. Property managers have a growing number of statutory requirements that they must comply with. Candidates must demonstrate appreciation and experience of dealing with these issues.</p>
                                        </div>
                                        <div style="width:20%;margin-top:3%;">
                                            <h5> progress 0% </h5>
                                        </div>

                                    </div>
                                    <div style="margin-left:20%;font-size:25px;display:flex">
                                        <a style="width:100%; text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span></a>
                                    </div>
                                </div>

                            </div>


                        </div>
                        <div class="row" style="margin:2rem 1rem">
                            <div class="card" style="width:100%">
                                <div class="card-body">
                                    <div style="display:flex">
                                        <div style="margin-top:1%;width:5%;font-size:28px">
                                            <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        </div>
                                        <div style="width:68%">
                                            <h4 style="color:#7239ea!important">Property Records and Information Systems</h4>
                                            <p>This competency deals with the use, management and development of property information systems (including automated valuation models) and systems for registering land and property rights. Property records and information systems are increasingly sophisticated and are used widely in the public sector (e.g. for tax assessment or property/ land title registration) and the private sector (e.g. for residential valuation, property management, etc.).</p>
                                        </div>
                                        <div style="width:20%;margin-top:3%;">
                                            <h5> progress 0% </h5>
                                        </div>

                                    </div>
                                    <div style="margin-left:20%;font-size:25px;display:flex">
                                        <a style="width:100%; text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                            <span style="margin-left:1%;color:#50cd89">Record Experience</span></a>
                                    </div>
                                </div>

                            </div>


                        </div>

                    </div>
                    <div class="row" style="margin:2rem 1rem">
                        <div class="card" style="width:100%">
                            <div class="card-body">
                                <div style="display:flex">
                                    <div style="margin-top:1%;width:5%;font-size:28px">
                                        <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                    </div>
                                    <div style="width:68%">
                                        <h4 style="color:#7239ea!important">Purchase and Sale</h4>
                                        <p>This competency relates to the purchase and sale of property/ assets on a freehold and leasehold basis. Candidates should have regard to all property/ asset markets and alternative uses and values. Similarly, the candidate should have awareness of other forms of disposal.</p>
                                    </div>
                                    <div style="width:20%;margin-top:3%;">
                                        <h5> progress 0% </h5>
                                    </div>

                                </div>
                                <div style="margin-left:20%;font-size:25px;display:flex">
                                    <a style="width:100%; text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                        <span style="margin-left:1%;color:#50cd89">Record Experience</span></a>
                                </div>
                            </div>

                        </div>


                    </div>

                    <div class="row" style="margin:2rem 1rem">
                        <div class="card" style="width:100%">
                            <div class="card-body">
                                <div style="display:flex">
                                    <div style="margin-top:1%;width:5%;font-size:28px">
                                        <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                    </div>
                                    <div style="width:68%">
                                        <h4 style="color:#7239ea!important">Strategic Real Estate Consultancy</h4>
                                        <p>This competency is about the provision of strategic consultancy advice to clients on real estate issues influencing the business.</p>
                                    </div>
                                    <div style="width:20%;margin-top:3%;">
                                        <h5> progress 0% </h5>
                                    </div>

                                </div>
                                <div style="margin-left:20%;font-size:25px;display:flex">
                                    <a style="width:100%; text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                        <span style="margin-left:1%;color:#50cd89">Record Experience</span></a>
                                </div>
                            </div>

                        </div>


                    </div>

                    <div class="row" style="margin:2rem 1rem">
                        <div class="card" style="width:100%">
                            <div class="card-body">
                                <div style="display:flex">
                                    <div style="margin-top:1%;width:5%;font-size:28px">
                                        <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                    </div>
                                    <div style="width:68%">
                                        <h4 style="color:#7239ea!important">Valuation of Businesses and Intangible Assets</h4>
                                        <p>This competency is about the preparation and provision of properly researched advice, made in accordance with the appropriate valuation standards, to enable clients make informed decisions regarding businesses and intangible assets.</p>
                                    </div>
                                    <div style="width:20%;margin-top:3%;">
                                        <h5> progress 0% </h5>
                                    </div>
                                </div>
                                <div style="margin-left:20%;font-size:25px;display:flex">
                                    <a style="width:100%; text-decoration:none;" href="{{route('level.competence', $id)}}"> <i class="fa fa-plus-circle" style="margin-top:1%;color:#50cd89" aria-hidden="true"></i>
                                        <span style="margin-left:1%;color:#50cd89">Record Experience</span></a>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>

            </div>


        </div>
    </div>

</div>
@endif
</section>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script>
    function change() {
        var category = $('#category').val();
        var Competency = $('#Competency').val();
        $.ajax({
            url: "{{ url('/competency/fetch') }}",
            type: 'GET',
            data: {
                'category': category,
                'Competency': Competency,
                _token: '{{csrf_token()}}'

            },
            beforeSend: function() {
                showLoader();
            },

            success: function(data) {
                hideLoader();
                $('#description_competency').addClass('d-none');
                $(`#level1`).addClass('d-none');
                $(`#level2`).addClass('d-none');
                $(`#level3`).addClass('d-none');
                console.log(data['rows'][0]['description']);
                $('#description_competency').removeClass('d-none');
                $('.description_competency').text(data['rows'][0]['description']);
                var levels = data['rows'][0]['no_levels'];
                for (let index = 1; index <= levels; index++) {
                    $(`#level${index}`).removeClass('d-none');
                }
            }
        })


    }

    function is_courseexisting(data) {

        for (const row of data) {


            $("#Competency option[value='" + row.assesment_id + "']").hide();

        }
    }

    function competency_submit() {

        var cate = $("#category").val();
        if (cate == 0) {
            swal("Please Select the Category", "", "error");
            return false;
        }

        var compe = $("#Competency").val();
        if (compe == '') {
            swal("Please Select the Competency", "", "error");
            return false;
        }




        var category = $('#category').val();
        var Competency = $('#Competency').val();
        let tabID = Competency == "1" ? "tab1" : "tab2";
        $.ajax({
            url: "{{ url('/competency/store') }}",
            type: 'GET',
            data: {

                'category': category,
                'Competency': Competency,
                _token: '{{csrf_token()}}'

            },
            beforeSend: function() {
                showLoader();
            },

            success: function(data) {
                hideLoader();
                swal({
                        title: "Success",
                        text: "Competency Created Successfully.",
                        type: "success",
                    },
                    function() {
                        window.location.href = `/Professional/Competence?tab=${tabID}`;
                    });

            },


        })


    }


    $(document).ready(function() {
        $('#addModal').on('hidden.bs.modal', function()

            {
                $(this).find('form')[0].reset();
            });
    });
</script>

<script>
    $(document).ready(function() {

        $('.content').children().hide();
        $('.tab1').show();
        $('#tab1').addClass('active');
        const tab_buttons = document.querySelectorAll('.tablinks');
        for (const tab_button of tab_buttons) {

            tab_button.addEventListener('click', function(e) {

                $('.tablinks').removeClass('active');
                $('.content').children().hide();
                var current_tab = e.target.id;
                if ((current_tab) == "tab2") {
                    document.querySelector('.competency_selection').style.display = "block";

                } else if ((current_tab) == "tab3") {
                    document.querySelector('.competency_selection').style.display = "block";

                } else {
                    document.querySelector('.competency_selection').style.display = "none";

                }

                $(`.${current_tab}`).fadeIn();
                $(`#${current_tab}`).addClass('active');




            });

        }


    });


    function desc_finder(e) {

        var id = e.target.getAttribute('value');
        var btn_type = e.target.getAttribute('btn_type');

    }

    function competency_changer(e) {
        var category = e.target.value;

        if (category == '2') {
            $('#Competency').children().remove();
            var option = '<option value="0">--select--</option><option value="14">Access and Rights over Land </option><option value="15">Conflict Avoidance, Management, and Dispute Resolution Procedures </option><option value="16">Auctioneering </option>';
            $('#Competency').append(option);
        } else {
            $('#Competency').children().remove();
            var option = '<option value="">select</option><option value="11">Inspection</option><option value="12">Valuation</option><option value="13">Measurement of Land and Property</option>';
            $('#Competency').append(option);
        }


        is_courseexisting(JSON.parse('<?php echo json_encode($rows3); ?>'));
    }





    $(document).ready(function() {

        let url = new URL(window.location.href)
        let message = url.searchParams.get("message");
        if (message != null) {
            window.history.pushState("object or string", "Title", "/gtapprove");

            swal({
                title: "Success",
                text: "Rejected Successfully",
                type: "success",
            });
        }

    })



    $(document).ready(function() {
        let url = new URL(window.location.href);
        let message = url.searchParams.get("message");
        let tab_switch = url.searchParams.get("tab").replace(/"/g, '');
        if (tab_switch != null) {
            document.querySelector(`#${tab_switch}`).click();
        }

        if (message != null) {
            window.history.pushState("object or string", "Title", "/Professional/Competence");
        }
        if (tab_switch != null) {
            window.history.pushState("object or string", "Title", "/Professional/Competence");
        }
        // Get the current URL

        // Remove the URL parameters
        var cleanUrl = url.split('?')[0];

        // Modify the browser history without reloading the page
        window.history.replaceState({}, document.title, cleanUrl);


    })
</script>

<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-lg">


        <div class="modal-content" style="margin-left:10%; margin-top:10%">



            <form action="" method="post" id="professional_competence">

                <div class="modal-header mh">
                    <h4 class="modal-title">Select competencies</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <input name="stakeholder_id" type="hidden" value="">
                <div class="section-body mt-1">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group" style="display:flex;flex-direction:column">
                                <label class="control-label">Category <span style="color: red;font-size: 16px;">*</span></label>
                                <select class="form-control" type="text" name="category" id="category" onchange="competency_changer(event)">
                                    <option value="0">select category</option>
                                    <option value="1">Professional-core</option>
                                    <!-- <option value="2">Technical-optional</option> -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" style="display:flex;flex-direction:column">
                                <label class="control-label"> Competency <span style="color: red;font-size: 16px;">*</span></label>
                                <select class="form-control" type="text" name="Competency" id="Competency" onchange="change()">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="notice bg-light-success rounded border-success border border-dashed p-6 mt-10" style="border-style:dashed;background-color:#e8fff3!important;padding: 20px;">
                                <div class="d-none" id="description_competency">
                                    <h4>Description</h4>
                                    <p class="description_competency"></p>
                                    <div class="d-none" id="level1">
                                        <h4>Level 1</h4>
                                        <p class="level_desc" id="level1" style="line-height:1.2;">
                                            Demonstrate knowledge and understanding of field and office procedures for boundary and/or cadastral surveys appropriate to your national and/or international location. Understand legal and physical boundaries and provide examples of these. Understand the principles of land management.
                                        </p>
                                    </div>
                                    <div class="d-none" id="level2">
                                        <h4>Level 2</h4>
                                        <p class="level_desc" id="level-1" style="line-height:1.2;">
                                            Demonstrate knowledge and understanding of field and office procedures for boundary and/or cadastral surveys appropriate to your national and/or international location. Understand legal and physical boundaries and provide examples of these. Understand the principles of land management.
                                        </p>
                                    </div>
                                    <div class="d-none" id="level3">
                                        <h4>Level 3</h4>
                                        <p class="level_desc" id="level-1" style="line-height:1.2;">
                                            Demonstrate knowledge and understanding of field and office procedures for boundary and/or cadastral surveys appropriate to your national and/or international location. Understand legal and physical boundaries and provide examples of these. Understand the principles of land management.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12" style="text-align:center;margin-bottom:2%;margin-top:2%">
                        <a onclick="competency_submit();" class="btn btn-success">Submit</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection