<Strong>Meeting Title :</Strong>
        <h3>{{ $meeting['topic'] }}</h3>

<br>
<br>
<strong>Meeting Agenda:</strong>
        <p>{{ $meeting['agenda'] ?? '' }}</p>

<br>
<br>

<p>
    <strong>Join URL:</strong><br>
    <a href="{{ $meeting['join_url'] }}">{{ $meeting['join_url'] }}</a>
</p>
<br>
<p>
    <strong>Meeting ID:</strong> {{ $meeting['id'] }}
</p>

<br>
<p>
    <strong>Start Time:</strong> {{ $meeting['start_time'] }}
</p>

<br>

Thanks & Regards
NMB Bank
