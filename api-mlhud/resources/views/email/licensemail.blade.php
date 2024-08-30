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

	We are delighted to inform you that your professional member license has been successfully registered. As a valued member, we appreciate your commitment to maintaining your professional standing in our organization.
	<br /><br />
	<b>License Details: </b>
	<br />
	<b>License Number: </b>{{$data['licence_number']}}
	<br />
	<b>Renewal Date: </b> {{$data['renewal_date']}}
	<br /><br />
	<b>Access Link: </b>
	<br />
	<a href="{{$data['base_url']}}">Click Here </a>
	<br /><br />
	<b>Email: </b> <a href="{{$data['email']}},">{{$data['email']}}</a>
	<br /><br />
	Regards,
	<br /><br />
	Team TALENTRA
</body>

</html>