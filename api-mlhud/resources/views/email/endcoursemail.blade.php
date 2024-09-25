<!DOCTYPE html>
<html>

<head>
</head>


<body>
	<br />
	Hello {{$data['name']}},
	<br /><br /><br />
	Thankyou for take parting in E-learning courses,titled has "{{$data['course_name']}}" that to expanding your knowledge and skills
		<br /><br />
	<b>Access Link:</b>
	<br /><br />
	please click on the following link:
	<a href="{{$data['base_url']}}?exlink=elearning/allCourses">Click Here to view the progress.</a>
	<br /><br />
	We hope you find this course has enjoyable. Should you have any questions or need further assistance, please don't hesitate to reach out to us.
	<br /><br />
	<b>Email:</b> {{$data['email']}},
	<br /><br />
	Regards,
	<br /><br />
	Team TALENTRA
</body>

</html>