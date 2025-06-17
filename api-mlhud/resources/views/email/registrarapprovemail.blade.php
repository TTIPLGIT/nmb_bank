<!DOCTYPE html>
<html>

<head>
</head>
@php $baseUrl = url('/'); @endphp

<body>
	<br/>
	Hello {{$data['name']}},
	<br /><br /><br />
    Congratulations! Your application for the Graduate Trainee program has been approved by the registrar. Now you will be able to access the E-learning services to enhance your skills towards valuation.
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