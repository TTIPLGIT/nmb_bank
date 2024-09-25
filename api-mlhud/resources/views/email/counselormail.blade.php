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
	A New Graduate Trainee {{$data['user_name']}} , has been Registered with TALENTRA and the Trainee selected you as a suprevsior or counselor, kindly click the below link to review the application.
	<br /><br />
	Graduate Trainee has been registered and is awaiting for your approval. <br /><br /><br />
	<b>Access Link:</b>
	<br /><br />
	<a href="{{$data['base_url']}}">Click Here </a>
	<br /><br />
	<b>Email:</b> {{$data['email']}},
	<br /><br />
	Regards,
	<br /><br />
	Team TALENTRA
</body>

</html>