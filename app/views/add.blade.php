<html>

	<head><title>Add User</title></head>

	<body>
	@if($errors)
	@foreach($errors->all() as $error)
	<p>{{ $error }}</p>
	@endforeach
	@endif
		<form method="post" action="form">

		<input type="text" name="firstname"><br>
		<input type="text" name="lastname"><br>
		<input type="text" name="email" placeholder="email"><br>
		<input type="password" name="password" placeholder="pass"><br>
		<input type="password" name="password_again" placeholder="password_again"><br>

		<input type="submit">

		</form>

	</body>

</html>