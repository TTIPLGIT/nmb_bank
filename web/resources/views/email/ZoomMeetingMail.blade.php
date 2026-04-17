<strong>Meeting Title :</strong>
<h3>{{ $meeting->topic }}</h3>

<br>
<br>
<strong>Meeting Agenda:</strong>
<p>{{ $meeting->agenda ?? 'No agenda provided' }}</p>

<br>
<br>

<p>
    <strong>Join URL:</strong><br>
    <a href="{{ $meeting->join_url }}">{{ $meeting->join_url }}</a>
</p>

<br>

<p>
    <strong>Start Time:</strong> {{ date('d-m-Y h:i A', strtotime($meeting->start_time)) }}
</p>

<br>

<p>
    <strong>Duration:</strong> {{ $meeting->duration }} minutes
</p>

<br>

<p>
    <strong>Platform:</strong> {{ ucfirst($meeting->platform) }}
</p>

<br>

Thanks & Regards<br>
<strong>NMB Bank</strong>