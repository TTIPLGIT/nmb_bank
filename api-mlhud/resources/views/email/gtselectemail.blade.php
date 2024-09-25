<!DOCTYPE html>
<html>

<head>
</head>

<body>
	<br />
	Hello {{$data['name']}},
	<br /><br /><br />
	Great news! You are now a Professional Member! Congratulations on completing the process.

	We've also updated our menu with fantastic new offerings. Explore it here: [Insert link]

	Enjoy the exclusive benefits and perks that come with your membership. We're thrilled to have you onboard!

	<br /><br /><br />
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