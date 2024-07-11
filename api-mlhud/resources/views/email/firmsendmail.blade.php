<!DOCTYPE html>
<html>

<head>
</head>


<body>
	<header>Congratulations...</header>
	<br /><br/>
	<br/>
	Dear {{$data['name']}},

	<br /><br /><br />
	A New Firm {{$data['name']}} , has been Registered with MLHUD .<br /><br />
    We are pleased to inform you that you have successfully logged in to [MLHUD].
	<br /><br />
    If you did not authorize this login or if you have any concerns regarding your account security, please contact our support team immediately.
    <br /><br />
	<b>Access Link:</b>
	<br /><br />
	<a href="{{$data['base_url']}}">Click Here </a>
	<br /><br/>
    <b>Email:</b> {{$data['email']}},
    <br/><br/>
	Regards,
	<br /><br />
	Team MLHUD
</body>

</html>