<!DOCTYPE html>
<html>

<head>
</head>


<body>
	<br />
	Hello {{$data['name']}},
	<br /><br /><br />
	Congratulations on completing the Course {{$data['course_name']}} for the eLearning program
	<br /><p style="font-weight:600 !important;">Your CPD points of this course has CPD:{{$data['cpt_points']}}</p><br /><br />
	<p style="font-weight:600 !important;">Total CPD Points:{{$data['total_cptpoints']}}</p><br /><br />
    <b>Access Link:</b>
	<br /><br />
	<a href="{{$data['base_url']}}?exlink=elearning/cpt">Click Here to view the CPD Points.</a>
	<br /><br />
	<b>Email:</b> {{$data['email']}},
	<br /><br />
	Regards,
	<br /><br />
	Team TALENTRA
</body>

</html>