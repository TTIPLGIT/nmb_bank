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
    Assigned Task has been Rejected by a Valuer.<br /><br />
    <br /><br />
    <b>Access Link:</b>
    <br /><br />
    <a href="{{$data['base_url']}}">click Here</a>
    <br /><br />
    <b>Email:</b> {{$data['email']}},
    <br /><br />
    Regards,
    <br /><br />
    Team MLHUD
</body>

</html>