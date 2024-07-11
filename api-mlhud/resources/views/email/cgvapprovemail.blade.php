<!DOCTYPE html>
<html>

<head>
</head>

<body>
	<br/>
	Hello {{$data['name']}},
	<br /><br /><br />
    Congratulations! Your firm have been Successfully Approved by CGV.You can proceed Further.
	<br /><br /><br />
	<b>Access Link:</b>
	<br /><br />
	<a href="{{$data['base_url']}}">Click Here </a>
	<br /><br />
    <b>Email:</b> {{$data['email']}},
    <br/><br/>
	Regards,
	<br /><br />
	Team MLHUD
</body>

</html>