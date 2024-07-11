<!DOCTYPE html>
<html>

<head>
</head>

<body>
	<br/>
	Hello {{$data['name']}},
	<br /><br /><br />
	We regret to inform you that your membership application has been rejected at this time. We carefully evaluate all applications, and while we appreciate your interest, we have determined that your qualifications do not meet our current membership criteria. Please note that this decision is not a reflection of your worth or abilities, and we encourage you to reapply in the future if you believe your circumstances have changed.
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