Hello {{ $name }},

<br><br>

You have been enrolled in the course:
<strong>{{ $course_name }}</strong>
@if($course_pin)
<br><br>

Your Course Regenerate PIN is:

<br><br>

<strong>{{ $course_pin }}</strong>

<br><br>

Please use this PIN to access the course.

<!-- Kindly note that the PIN is valid for <strong>24 hours</strong> only. -->

<br><br>
@endif
Thanks,<br>
LMS Team