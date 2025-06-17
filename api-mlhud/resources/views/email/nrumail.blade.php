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
	A New User {{$data['name']}} , has been Registered with TALENTRA .<br /><br />
	We are pleased to inform you that your account for the TALENTRA NRU Program has been successfully created. Welcome aboard! This email contains the necessary information to access your account and begin your journey with us.
	<br /><br /><br />
	<b>Access Link:</b>
	<br />
	<a href="{{$data['base_url']}}">click Here</a>
	<br /><br />
	<b>Email:</b> {{$data['email']}},
	<br /><br />
	Regards,
	<br /><br />
	Team TALENTRA
</body>

</html>