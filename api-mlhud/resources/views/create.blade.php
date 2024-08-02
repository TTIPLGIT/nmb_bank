
 <html>
<head>
	  <title>User Creation</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<style type="text/css">
	.text-uppercase{
		text-transform: uppercase;
	}
</style>
<body>
	<h4 class="text-uppercase">Dear  {{ $data['name'] }} , </h4>
<br/><br/>
	<p>Welcome To MLHUD </p>

	<p>Your access to MLHUD granted with below User Id & PWD</p>

	<p>User Name :  {{ $data['email'] }} </p>

	<p>Password :  {{ $data['password'] }} </p>

	<p>Please log-in into the system by using below URL</p>

	<a href="{{ config('setting.document_storage_path')}}" class="btn btn-success">{{ config('setting.document_storage_path')}}/login  </a>
	
	<p>Thanks & Regards,</p>
	<p>MLHUD Admin</p>

</body>
</html>