@extends('layouts.elearningmain')

@section('content')
<style>
.meeting-card {
    transition: transform 0.3s;
    margin-bottom: 20px;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.meeting-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
}

.status-badge {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
}

.status-scheduled {
    background-color: #ff9800;
    color: white;
}

.status-completed {
    background-color: #4CAF50;
    color: white;
}

.status-cancelled {
    background-color: #f44336;
    color: white;
}

.status-rescheduled {
    background-color: #2196F3;
    color: white;
}

.join-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 8px 20px;
    border-radius: 5px;
    transition: all 0.3s;
}

.join-btn:hover {
    transform: scale(1.05);
    color: white;
}

.platform-icon {
    font-size: 20px;
    margin-right: 5px;
}

.tab-content {
    padding: 20px;
    background: #f8f9fa;
    border-radius: 10px;
    margin-top: 20px;
}

.nav-tabs .nav-link {
    color: #333;
    font-weight: 500;
}

.nav-tabs .nav-link.active {
    color: #667eea;
    font-weight: bold;
    border-bottom: 2px solid #667eea;
}

.empty-state {
    text-align: center;
    padding: 50px;
    background: white;
    border-radius: 10px;
}

.empty-state i {
    font-size: 60px;
    color: #ccc;
    margin-bottom: 20px;
}
</style>

<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-video"></i> My Meetings</h4>
                        </div>
                        <div class="card-body">

                            <!-- Tabs -->
                            <ul class="nav nav-tabs" id="meetingTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="upcoming-tab" data-toggle="tab" href="#upcoming"
                                        role="tab">
                                        <i class="fas fa-calendar-alt"></i> Upcoming Meetings

                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="all-tab" data-toggle="tab" href="#all" role="tab">
                                        <i class="fas fa-list"></i> All Meetings
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="past-tab" data-toggle="tab" href="#past" role="tab">
                                        <i class="fas fa-history"></i> Past Meetings
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <!-- Upcoming Meetings Tab -->
                                <div class="tab-pane fade show active" id="upcoming" role="tabpanel">
                                    @if($upcomingMeetings->isEmpty())
                                    <div class="empty-state">
                                        <i class="fas fa-calendar-check"></i>
                                        <h5>No Upcoming Meetings</h5>
                                        <p>You don't have any scheduled meetings at the moment.</p>
                                    </div>
                                    @else
                                    <div class="row">
                                        @foreach($upcomingMeetings as $meeting)
                                        <div class="col-md-6 col-lg-4">
                                            <div class="meeting-card card">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <h5 class="card-title">
                                                            @if($meeting->platform == 'zoom')
                                                            <i class="fab fa-zoom platform-icon"
                                                                style="color: #0B5CFF;"></i>
                                                            @elseif($meeting->platform == 'teams')
                                                            <i class="fab fa-microsoft platform-icon"
                                                                style="color: #7B83EB;"></i>
                                                            @else
                                                            <i class="fab fa-google platform-icon"
                                                                style="color: #EA4335;"></i>
                                                            @endif
                                                            {{ $meeting->topic }}
                                                        </h5>
                                                        <span class="status-badge status-{{ $meeting->status }}">
                                                            {{ ucfirst($meeting->status) }}
                                                        </span>
                                                    </div>

                                                    <div class="mt-3">
                                                        <p><i class="fas fa-calendar"></i> <strong>Date:</strong>
                                                            {{ date('d-m-Y', strtotime($meeting->meeting_date)) }}</p>
                                                        <p><i class="fas fa-clock"></i> <strong>Time:</strong>
                                                            {{ date('h:i A', strtotime($meeting->start_time)) }}</p>
                                                        <p><i class="fas fa-hourglass-half"></i>
                                                            <strong>Duration:</strong> {{ $meeting->duration }} minutes
                                                        </p>
                                                    </div>

                                                    @if($meeting->meeting_description)
                                                    <p class="text-muted">
                                                        <small>{{ Str::limit($meeting->meeting_description, 100) }}</small>
                                                    </p>
                                                    @endif

                                                    <div class="mt-3">
                                                        @if($meeting->join_url && $meeting->status != 'cancelled')
                                                        <a href="{{ $meeting->join_url }}" target="_blank"
                                                            class="btn join-btn btn-sm">
                                                            <i class="fas fa-video"></i> Join Meeting
                                                        </a>
                                                        @endif

                                                        @if($meeting->meeting_date == date('Y-m-d'))
                                                        <span class="badge badge-warning ml-2">Today</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>

                                <!-- All Meetings Tab -->
                                <div class="tab-pane fade" id="all" role="tabpanel">
                                    @if($meetings->isEmpty())
                                    <div class="empty-state">
                                        <i class="fas fa-video-slash"></i>
                                        <h5>No Meetings Found</h5>
                                        <p>No meetings have been scheduled for your courses yet.</p>
                                    </div>
                                    @else
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Meeting Title</th>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                    <th>Platform</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($meetings as $index => $meeting)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        <strong>{{ $meeting->topic }}</strong>
                                                        @if($meeting->meeting_description)
                                                        <br><small
                                                            class="text-muted">{{ Str::limit($meeting->meeting_description, 50) }}</small>
                                                        @endif
                                                    </td>
                                                    <td>{{ date('d-m-Y', strtotime($meeting->meeting_date)) }}</td>
                                                    <td>{{ date('h:i A', strtotime($meeting->start_time)) }}</td>
                                                    <td>
                                                        @if($meeting->platform == 'zoom')
                                                        <i class="fab fa-zoom"></i> Zoom
                                                        @elseif($meeting->platform == 'teams')
                                                        <i class="fab fa-microsoft"></i> Teams
                                                        @else
                                                        <i class="fab fa-google"></i> Google Meet
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="status-badge status-{{ $meeting->status }}">
                                                            {{ ucfirst($meeting->status) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if($meeting->join_url && $meeting->status != 'cancelled')
                                                        <a href="{{ $meeting->join_url }}" target="_blank"
                                                            class="btn btn-sm btn-success">
                                                            <i class="fas fa-video"></i> Join
                                                        </a>
                                                        @else
                                                        <button class="btn btn-sm btn-secondary" disabled>
                                                            <i class="fas fa-ban"></i> Not Available
                                                        </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                </div>

                                <!-- Past Meetings Tab -->
                                <div class="tab-pane fade" id="past" role="tabpanel">
                                    @if($pastMeetings->isEmpty())
                                    <div class="empty-state">
                                        <i class="fas fa-history"></i>
                                        <h5>No Past Meetings</h5>
                                        <p>You haven't attended any meetings yet.</p>
                                    </div>
                                    @else
                                    <div class="row">
                                        @foreach($pastMeetings as $meeting)
                                        <div class="col-md-6 col-lg-4">
                                            <div class="meeting-card card">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $meeting->topic }}</h5>
                                                    <p><i class="fas fa-calendar"></i>
                                                        {{ date('d-m-Y', strtotime($meeting->meeting_date)) }}</p>
                                                    <p><i class="fas fa-clock"></i>
                                                        {{ date('h:i A', strtotime($meeting->start_time)) }}</p>
                                                    <span class="status-badge status-{{ $meeting->status }}">
                                                        {{ ucfirst($meeting->status) }}
                                                    </span>
                                                    @if($meeting->status_notes)
                                                    <div class="mt-2">
                                                        <small class="text-muted"><strong>Notes:</strong>
                                                            {{ $meeting->status_notes }}</small>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
$(document).ready(function() {
    // Activate tooltips
    $('[data-toggle="tooltip"]').tooltip();
});
</script>

@endsection