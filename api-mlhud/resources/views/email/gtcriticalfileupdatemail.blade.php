<!DOCTYPE html>
<html>

<head>
</head>

<body>
	<header>Congratulations...</header>
	<br /><br/>
	<br/>
	Hello {{$data['name']}},
	<br /><br /><br />
	Graduate Trainee {{$data['gt_name']}} is updated the Critical Analysis Report Successfully and is awaiting For your approval.  
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