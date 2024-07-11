<!DOCTYPE html>
<html>

<head>
</head>


<body>
    <br />
    Hello {{$data['name']}},
    <br /><br /><br />
    Congratulations on successfully completing the {{$data['course_name']}}! Your dedication and active participation have been outstanding. Attached is your well-deserved course certificate.<br />
    <b>Access Link:</b>
    <br /><br />
    <a href="{{$data['base_url']}}?exlink=/elearningCourse/class/eyJpdiI6IkppVU1SRlkzQmJ3eUlNOFFGYnM1bHc9PSIsInZhbHVlIjoiL2Y5cEFZVGxJSnNrR2d5aDJkdDRkUT09IiwibWFjIjoiNGI1NGIxYWQxMTlmNzYxY2NjMGRjNzdkMjkzMmUzZjdlMjk1ZjcyNzgwYmVkNmM3YjExYzI1OWY2ZmNjMGViNiIsInRhZyI6IiJ9">Click Here to view the Certificate.</a>
    <br /><br />
    <b>Email:</b> {{$data['email']}},
    <br /><br />


    Regards,
    <br /><br />
    Team MLHUD
</body>

</html>