<!DOCTYPE html>
<html>

<head>
</head>

<body>
    <br />
    Hello {{$data['name']}},
    <br /><br /><br />
    Your Supervision Request has been Rejected by the Admin.
    <br /><br />
    <b>Access Link:</b>
    <br /><br />
    <a href="{{$data['base_url']}}">Click Here </a>
    <br /><br />
    <b>Email:</b> {{$data['email']}},
    <br /><br />
    Regards,
    <br /><br />
    Team MLHUD
</body>

</html>