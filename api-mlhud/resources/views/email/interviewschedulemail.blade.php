<!DOCTYPE html>
<html>

<head>
</head>
@php $baseUrl = url('/'); @endphp

<body>
    <header>Sorry!...</header>
    <br /><br />
    <br />
    Hello {{$data['name']}},
    <br /><br /><br />
    I hope this email finds you well. I wanted to inform you that the registrar attempted to schedule an interview for your consideration. However, it appears that your current account does not yet meet the required 2 years of experience for this opportunity.

    You currently have [remaining months] left to achieve the necessary experience milestone. Rest assured, we will keep both you and the registrar informed as you approach the two-year mark. This way, we can proceed with scheduling the interview once you've met the eligibility criteria.

    Should you have any questions or need further assistance, please don't hesitate to reach out. We appreciate your dedication and look forward to supporting your continued growth.
    <br /><br /><br />
    <b>Access Link:</b>
    <a href="{{$data['base_url']}}">Click Here </a>
    <br /><br />
    <b>Email:</b> {{$data['email']}},
    <br /><br />
    Regards,
    <br /><br />
    Team TALENTRA
</body>

</html>