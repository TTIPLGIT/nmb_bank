<!DOCTYPE html>
<html>

<head>
</head>

<body>
	<br/>
	Hello {{$data['name']}},
	<br /><br /><br />
	Unfortunately, your membership application is currently on hold. Our team is reviewing the application thoroughly, and we require some additional information to process it successfully. Rest assured, we are committed to resolving this matter as quickly as possible. We appreciate your patience and cooperation during this time. If you have any questions or need further assistance, please don't hesitate to contact us.
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