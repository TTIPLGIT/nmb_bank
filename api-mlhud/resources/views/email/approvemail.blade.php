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
    I am pleased to inform you that your request/application has been approved by your counselor/supervisor. Congratulations!	However, please be aware that the final decision is still pending the review and approval of the committee. The committee will carefully evaluate your request/application and make the final determination. We appreciate your patience during this process, and we will notify you promptly once the committee review is completed.<br /><br /><br />
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