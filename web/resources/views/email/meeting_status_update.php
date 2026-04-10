<div style="font-family: Arial, sans-serif;">
    <h3>Meeting Status Update</h3>

    <p>Dear Participant,</p>

    <p>Meeting "<strong>{{ $meeting->topic }}</strong>" status has been changed to:
        <strong>{{ ucfirst($status) }}</strong>
    </p>

    <p><strong>Notes:</strong> {{ $notes }}</p>

    <hr>

    <p><strong>Meeting Details:</strong><br>
        Date: {{ date('d-m-Y', strtotime($meeting->meeting_date)) }}<br>
        Time: {{ date('h:i A', strtotime($meeting->start_time)) }}<br>
        Duration: {{ $meeting->duration }} minutes</p>

    @if($meeting->join_url)
    <p>Join URL: <a href="{{ $meeting->join_url }}">{{ $meeting->join_url }}</a></p>
    @endif

    <hr>

    <p>Thanks & Regards,<br>
        LMS Team</p>

    <small>This is an automated notification.</small>
</div>