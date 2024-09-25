<!DOCTYPE html>
<html>

<head>
</head>


<body>
	<header>Congratulations...</header>
	<br /><br />
	Hello {{$data['name']}},
	<br /><br />
	We are pleased to inform you that your payment has been successfully processed. Now you can Apply for your Licence. and Please find the Payment Details Below.
	<br /><br />
	<b>Payment Details:</b>
	<br />
	<b>Amount:</b>{{$data['amount']}}
	<br />
	<b>Date:</b>{{$data['time']}}
	<br />
	<b>Transaction ID:</b>{{$data['bank_transaction_id']}}
	<br />
	<b>Payment Method:</b>{{$data['method']}}
	<br />
	
	If you have any questions or concerns regarding this transaction, please don't hesitate to contact us.
	<br />
	Thank you for choosing our service.
	<br /><br />
	<b>Access Link:</b>
	<br /><br />
	<a href="{{$data['base_url']}}">Click Here</a>
	<br /><br />
	<b>Email:</b> <a href="{{$data['email']}},">{{$data['email']}}</a>
	<br /><br />
	Regards,
	<br /><br />
	Team TALENTRA
</body>

</html>