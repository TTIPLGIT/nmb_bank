<!DOCTYPE html>
<html>

<head>
</head>


<body>
	<br />
	Hello {{$data['name']}},
	<br /><br /><br />
	Congratulations on completing the Ethic Test for the eLearning program! We are pleased to inform you that your test results are now available. Based on your performance, you have achieved.
	<br /><p style="font-weight:600 !important;">Score:{{$data['score']}}</p><br /><br />
	<b>Access Link:</b>
	<br /><br />
	<a href="{{$data['base_url']}}?exlink=ethic/quiz/list">Click Here to start the ethic test.</a>
	<br /><br />
	<b>Email:</b> {{$data['email']}},
	<br /><br />
	Regards,
	<br /><br />
	Team TALENTRA
</body>

</html>