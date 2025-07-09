<!DOCTYPE html>
<html>

<head>
    <title>Certificate Verification</title>
</head>

<body>
    <h1>Certificate Status</h1>

    <p><strong>Course Name:</strong> {{ $course }}</p>
    <p><strong>Expiry Date:</strong> {{ $date }}</p>
    <p><strong>Status:</strong>
        <span style="color: {{ $status == 'Expired' ? 'red' : 'green' }};">
            {{ $status }}
        </span>
    </p>
</body>

</html>