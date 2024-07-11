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
    Congratulations! Your application for the Non-Registered ugandian (NRU) program has been approved by the registrar. Now you will be able to access the E-learning services to complete the Local Adaptation Test to access the services for the Professional Member.
    <br /><br /><br />
    <b>Access Link:</b>  
    <a href="{{$data['base_url']}}">Click Here </a>
    <br /><br />
    <b>Email:</b> {{$data['email']}},
    <br /><br />
    Regards,
    <br /><br />
    Team MLHUD
</body>

</html>