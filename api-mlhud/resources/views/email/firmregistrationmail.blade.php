<!DOCTYPE html>
<html>

<head>
</head>

<body>
	<br /><br/>
	<br/>
	Hello {{$data['name']}},
	<br /><br /><br />
	Your company has successfully registered and is awaiting CGV approval. We'll notify the status of your application via email and Notification.
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