<!DOCTYPE html>
<html>

<head>
</head>


<body>
	<br />
	Hello {{$data['name']}},
	<br /><br /><br />
    We regret to inform you that you did not pass the Exam for the eLearning program. Your test results indicate that you have not achieved a passing score.
	<br /><p style="font-weight:600 !important;">Score:{{$data['score']}}</p><br /><br />
	<b>Access Link:</b>
	<br /><br />
	<a href="{{$data['base_url']}}?exlink=exam/quiz/list">Click Here to start the exam.</a>
	<br /><br />
	<b>Email:</b> {{$data['email']}},
	<br /><br />
	Regards,
	<br /><br />
	Team TALENTRA
</body>

</html>