<!DOCTYPE html>
<html>

<head>
</head>
@php $baseUrl = url('/'); @endphp

<body>
    <header>Congratulations...</header>
    <br /><br />
    <br />
    Hello {{$data['name']}},
    <br /><br /><br />
    Congratulations! You have a Task Assigned by the Stakeholder.
    <br /><br /><br />
    <b>Access Link:</b>  
    <a href="{{$data['base_url']}}">Click Here </a>
    <br /><br />
    <b>Email:</b> {{$data['email']}},
    <br /><br />
    Regards,
    <br /><br />
    Team TALENTRA
</body>

</html>