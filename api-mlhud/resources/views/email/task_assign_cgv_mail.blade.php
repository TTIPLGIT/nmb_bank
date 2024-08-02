<!DOCTYPE html>
<html>

<head>
</head>

<body>
	<br /><br />
	<br />
	Hello {{$data['name']}},

	<br /><br /><br />
	A Stakeholder Named {{$data['stakeholder_name']}} , has Assigned you a Task, kindly look into it.
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