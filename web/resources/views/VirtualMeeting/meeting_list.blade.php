@extends('layouts.adminnav')

@section('content')
<style>
a:hover,
a:focus {
    text-decoration: none;
    outline: none;
}

.danger {
    background-color: #ffdddd;
    border-left: 6px solid #f44336;
}

#align {
    border-collapse: collapse !important;
}

table.dataTable.no-footer {
    border-bottom: .5px solid #002266 !important;
}

thead th {
    height: 5px;
    border-bottom: solid 1px #ddd;
    font-weight: bold;
}

.status-completed {
    color: green;
    font-weight: bold;
}

.status-cancelled {
    color: red;
    font-weight: bold;
}

.status-scheduled {
    color: orange;
    font-weight: bold;
}
</style>

<div class="main-content module_space">
    {{ Breadcrumbs::render('meeting_list') }}

    <section class="section">
        <div class="section-body mt-2">
            <style>
            .section {
                margin-top: 20px;
            }
            </style>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <h4>Meeting List</h4>
                                </div>
                                <div class="row" style="justify-content:end">
                                    <a type="button" class="btn btn-labeled btn-success mb-2" title="Meeting Initiate"
                                        style="border-color:#a9ca !important; color:white !important;margin: 0 0 2px 15px;"
                                        href="{{route('virtual_meeting')}}">
                                        <span class="btn-label"
                                            style="font-size:15px !important; padding:8px !important"><i
                                                class="fa fa-plus"></i></span><span
                                            style="font-size:15px !important; padding:8px !important">Meeting
                                            Initiate</span>
                                    </a>
                                </div>
                            </div>

                            @if (session('success'))
                            <input type="hidden" name="session_data" id="session_data" class="session_data"
                                value="{{ session('success') }}">
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
                            <input type="hidden" name="session_data" id="session_data1" class="session_data"
                                value="{{ session('error') }}">
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

                            <div class="table-wrapper">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="align">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Meeting Name</th>
                                                <th>Meeting Date</th>
                                                <th>Join URL</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($rows['meeting'] as $meeting)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$meeting['topic']}}</td>
                                                <td>{{$meeting['meeting_date']}}</td>
                                                <td>
                                                    @if(!empty($meeting['join_url']))
                                                    <a href="{{$meeting['join_url']}}" target="_blank">Join Meeting</a>
                                                    @else
                                                    N/A
                                                    @endif
                                                </td>
                                                <td class="status-{{strtolower($meeting['status'])}}">
                                                    {{ucfirst($meeting['status'])}}
                                                </td>
                                                @if($meeting['status'] == 'scheduled')
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-sm btn-primary update-status-btn"
                                                        data-id="{{$meeting['id']}}"
                                                        data-status="{{$meeting['status']}}"
                                                        data-meeting="{{$meeting['topic']}}">
                                                        Update Status
                                                    </button>
                                                </td>
                                                @else
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-sm btn-primary update-status-btn"
                                                        data-id="{{$meeting['id']}}"
                                                        data-status="{{$meeting['status']}}"
                                                        data-meeting="{{$meeting['topic']}}" disabled>
                                                        Update Status
                                                    </button>
                                                </td>
                                                @endif
                                            </tr>
                                            @endforeach
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
</div>
<!-- Add these in your head section or before closing body tag -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>

<!-- Update Status Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" role="dialog" aria-labelledby="updateStatusModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStatusModalLabel">Update Meeting Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('meeting_update_status')}}" method="POST" id="updateStatusForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="meeting_id" id="meeting_id">

                    <div class="form-group">
                        <label>Meeting Name</label>
                        <input type="text" class="form-control" id="meeting_name" readonly>
                    </div>

                    <div class="form-group">
                        <label>Current Status</label>
                        <input type="text" class="form-control" id="current_status" readonly>
                    </div>

                    <div class="form-group">
                        <label>New Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="">Select Status</option>
                            <option value="scheduled">Scheduled</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="rescheduled">Rescheduled</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Notes <span class="text-danger">*</span></label>
                        <textarea name="notes" id="notes" class="form-control" rows="4"
                            placeholder="Enter meeting notes, summary, or reason for status change..."
                            required></textarea>
                        <small class="text-muted">Please provide details about the meeting outcome or reason for status
                            change.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script>
var $j = jQuery.noConflict();

$j(document).ready(function() {
    // Handle update status button click
    $j('.update-status-btn').click(function() {
        var meetingId = $j(this).data('id');
        var currentStatus = $j(this).data('status');
        var meetingName = $j(this).data('meeting');

        $j('#meeting_id').val(meetingId);
        $j('#meeting_name').val(meetingName);
        $j('#current_status').val(currentStatus);

        // Set the current status as selected in dropdown
        $j('#status').val(currentStatus);

        $j('#updateStatusModal').modal('show');
    });
});
</script>

@endsection