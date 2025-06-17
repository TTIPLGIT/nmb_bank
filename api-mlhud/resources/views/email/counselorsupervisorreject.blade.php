<!DOCTYPE html>
<html>

<head>
</head>
@php $baseUrl = url('/'); @endphp

<body>
 
    <br /><br />
    <br />
    Hello {{$data['name']}},
    <br /><br /><br />
    I regret to inform you that your application has been rejected by the {{$data['type']}}. Kindly click the link below to select another {{$data['type']}} to proceed further.

    Thank you for your understanding.
    <br /><br />
     <b>Access Link:</b>
    <br /><br />
    <a href="{{$data['base_url']}}">Click Here </a>
    <br /><br />
    <b>Email:</b> {{$data['email']}},
    <br /><br />
    Regards,
    <br /><br />
    Team TALENTRA
</body>

</html>