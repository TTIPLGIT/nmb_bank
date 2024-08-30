<!DOCTYPE html>
<html>

<head>
</head>

<body>
	<br/>
	Hello {{$data['name']}},
	<br /><br /><br />
    Congratulations! You Recived the Feedback from the Registrar.
	<br /><br /><br />
	<b>Access Link:</b>
	<br /><br />
	<a href="{{$data['base_url']}}">Click Here </a>
	<br /><br />
    <b>Email:</b> {{$data['email']}},
    <br/><br/>
	Regards,
	<br /><br />
	Team TALENTRA
</body>

</html>
	