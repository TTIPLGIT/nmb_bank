<!DOCTYPE html>
<html>

<head>
</head>


<body>
    <header>Congratulations...</header>
    <br /><br />
    <br />
    Hello {{$data['name']}},
    <br /><br /><br />
    We regret to inform you that your application for the Graduate Trainee program has been rejected by the registrar. Please resubmit your application with the necessary details.
    <br /> <br /> <br />
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