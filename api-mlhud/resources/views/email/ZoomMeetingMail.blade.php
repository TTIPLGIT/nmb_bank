<h3>{{ $meeting['topic'] }}</h3>

<br>
<br>
<p>{{ $meeting['agenda'] ?? '' }}</p>

<br>
<br>

<p>
    <strong>Join URL:</strong><br>
    <a href="{{ $meeting['join_url'] }}">{{ $meeting['join_url'] }}</a>
</p>
<br>
<br>
<p>
    <strong>Meeting ID:</strong> {{ $meeting['id'] }}
</p>

<br>
<br>
<p>
    <strong>Start Time:</strong> {{ $meeting['start_time'] }}
</p>

<br>
<br>
