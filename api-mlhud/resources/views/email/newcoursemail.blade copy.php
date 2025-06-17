<!DOCTYPE html>
<html>

<head>
</head>


<body>
	<br />
	Hello {{$data['name']}},
	<br /><br /><br />
	We are excited to inform you that a new course has been added to our eLearning program. The course, titled "{{$data['course_name']}}" provides a comprehensive overview of the course.
	<br />
	If you are interested in expanding your knowledge and skills in the field of "{{$data['course_name']}}", we highly recommend enrolling in this course.
	<br /><br />
	<b>Access Link:</b>
	<br /><br />
	To enroll in the course and access the learning materials, please click on the following link:
	<a href="{{$data['base_url']}}?exlink=elearning/allCourses">Click Here to Enroll the Course.</a>
	<br /><br />
	We hope you find this new course valuable and enjoyable. Should you have any questions or need further assistance, please don't hesitate to reach out to us.
	<br /><br />
	<b>Email:</b> {{$data['email']}},
	<br /><br />
	Regards,
	<br /><br />
	Team TALENTRA
</body>

</html>