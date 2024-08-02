
 <html>
<head>
	  <title>Reset Password</title>
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
	<h4 class="text-uppercase">Welcome To Our MLHUD </h4>

	<a href="{{ config('setting.document_storage_path')}}reset/{{ $data['token'] }}" class="btn btn-success"> Reset Password </a>
	 <h4>Above link will be expire with in 24 hours or 1 day.
	 </h4>
	<p>Thanks & Regards,</p>
	<p>MLHUD TEAM...</p>

</body>
</html>