@extends('layouts.adminnav')

@section('content')
<style type="text/css">
    .buttons-html5 {
        background-color: #1bcd6b !important;
        padding: 10px;
        border: 1px;
        color: white;
    }

    .select2-container .select2-selection--single {
        height: 39px !important;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <section class="section">

        <div class="col-lg-12 text-center">
            <h4 style="color:darkblue;">Adaptive Learing</h4>
        </div>
        <div class="section-body mt-2">
            <style>
                .section {
                    margin-top: 20px;
                }
            </style>


            <div class="row">

                <div class="col-12">

                    <div class="mt-0">

                        <div class="card-body" id="card_header">
                            <div class="row">


                            </div>
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

                            <div class="row mb-4">

                                <div class="col-md-3">
                                    <div class="card text-center shadow-sm">
                                        <div class="card-body">
                                            <h6>Total Users</h6>
                                            <h3>{{ $aiData['total_users'] ?? 0 }}</h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="card text-center shadow-sm">
                                        <div class="card-body">
                                            <h6>Processed Users</h6>
                                            <h3>{{ $aiData['processed_users'] ?? 0 }}</h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="card text-center bg-danger text-white shadow-sm">
                                        <div class="card-body">
                                            <h6>High Risk</h6>
                                            <h3>{{ $aiData['risk_summary']['high'] ?? 0 }}</h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="card text-center bg-info text-white shadow-sm">
                                        <div class="card-body">
                                            <h6>Prediction</h6>
                                            <h5>Dropout Risk</h5>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-4">

                                <!-- Bar Chart -->
                                <div class="col-md-6">
                                    <div class="card shadow-sm">
                                        <div class="card-header">
                                            <h6 class="mb-0">Risk Distribution (Bar Chart)</h6>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="riskBarChart"></canvas>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pie Chart -->
                                <div class="col-md-6">
                                    <div class="card shadow-sm">
                                        <div class="card-header">
                                            <h6 class="mb-0">Risk Distribution (Pie Chart)</h6>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="riskPieChart"></canvas>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <table class="table table-bordered" id="align">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>User ID</th>
                                        <th>Course ID</th>
                                        <th>Risk Level</th>
                                        <th>Probability</th>
                                        <th>Prediction Type</th>
                                        <th>Reason</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php $i = 1; @endphp

                                    @if(!empty($aiData['data']))
                                    @foreach($aiData['data'] as $user)
                                    @foreach($user['courses'] as $course)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $user['user_id'] }}</td>
                                        <td>{{ $course['course_id'] }}</td>

                                        {{-- Risk Level with color --}}
                                        <td>
                                            @if($course['risk_level'] == 'high')
                                            <span class="badge badge-danger">High</span>
                                            @elseif($course['risk_level'] == 'medium')
                                            <span class="badge badge-warning">Medium</span>
                                            @else
                                            <span class="badge badge-success">Low</span>
                                            @endif
                                        </td>

                                        {{-- Probability --}}
                                        <td>{{ $course['probability'] * 100 }}%</td>

                                        {{-- Prediction Type --}}
                                        <td>{{ ucfirst(str_replace('_',' ', $course['prediction_type'])) }}</td>

                                        {{-- Reason (tooltip) --}}
                                        <td>
                                            <button class="btn btn-sm btn-info"
                                                data-toggle="tooltip"
                                                title="{{ $course['reason'] }}">
                                                View
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="7" class="text-center">No data available</td>
                                    </tr>
                                    @endif
                                </tbody>


                            </table>

                        </div>


                    </div>
                </div>
            </div>
    </section>
</div>







@if (session('success'))


<input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('success') }}">
<script type="text/javascript">
    window.onload = function() {
        var message = $('#session_data').val();

        bootbox.alert({
            title: "Success",
            centerVertical: true,
            message: message
        });
    }
</script>
@endif


@if (session('failed'))
<input type="hidden" name="session_data" id="session_data" class="session_data" value="{{ session('failed') }}">
<script type="text/javascript">
    window.onload = function() {
        var message = $('#session_data').val();

        bootbox.alert({
            title: "Success",
            centerVertical: true,
            message: message
        });
    }
</script>
@endif

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/table2excel.js') }}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    const riskData = {
        low: {{ $aiData['risk_summary']['low'] ?? 0 }},
        medium: {{ $aiData['risk_summary']['medium'] ?? 0 }},
        high: {{ $aiData['risk_summary']['high'] ?? 0 }}
    };

    /* ===== BAR CHART ===== */
    new Chart(document.getElementById('riskBarChart'), {
        type: 'bar',
        data: {
            labels: ['Low Risk', 'Medium Risk', 'High Risk'],
            datasets: [{
                label: 'Number of Learners',
                data: [riskData.low, riskData.medium, riskData.high],
                backgroundColor: ['#28a745', '#ffc107', '#dc3545']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            }
        }
    });

    /* ===== PIE CHART ===== */
    new Chart(document.getElementById('riskPieChart'), {
        type: 'pie',
        data: {
            labels: ['Low Risk', 'Medium Risk', 'High Risk'],
            datasets: [{
                data: [riskData.low, riskData.medium, riskData.high],
                backgroundColor: ['#28a745', '#ffc107', '#dc3545']
            }]
        },
        options: {
            responsive: true
        }
    });
</script>

<script>
    var $j = jQuery.noConflict();

    $j(document).ready(function() {
        $j('#user_name').select2();
    });

    $j(document).ready(function() {
        $j('#course_name').select2();
    });
</script>

<script>
    $(document).ready(function() {

        $('#user_name').on('change', function() {

            var userId = $(this).val();
            console.log("Selected User:", userId);

            $('#course_name option').each(function() {

                var users = $(this).attr('data-users');

                if (!users) {
                    $(this).hide();
                    return;
                }

                var userArray = users.split(',').map(s => s.trim());

                if (userArray.includes(userId)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });

            $('#course_name').val('');
        });

    });
</script>

<script>
    document.getElementById('adaptiveForm').addEventListener('submit', function(e) {

        e.preventDefault();

        var user = document.getElementById('user_name').value;
        var course = document.getElementById('course_name').value;

        if (!user || !course) {
            alert("Please select user and course");
            return;
        }

        var url = "{{ url('adaptive/learning') }}/" + user + "/" + course;

        window.location.href = url;
    });
</script>







@endsection