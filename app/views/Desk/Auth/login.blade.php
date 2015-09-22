@extends('Desk.Auth.layout')
@section('title')
Login
@stop

@section('content')
        <form method="post">
			<h1>Student Login</h1>
			<div class="login-fields">
				<p>Please provide your details</p>
				<div class="field">
					<label for="email">Email</label>
					<input type="text" id="email" name="email" value="" placeholder="Email" class="login username-field" />
				</div> <!-- /field -->
				<div class="field">
					<label for="password">Password:</label>
					<input type="password" id="password" name="password" value="" placeholder="Password" class="login password-field"/>
				</div> <!-- /password -->
			</div> <!-- /login-fields -->
			<div class="login-actions">
				<span class="login-checkbox">
					<label><a href="forgot-password">Forgot Password?</a></label>
				</span>
				<button class="button btn btn-success btn-large">Sign In</button>
			</div> <!-- .actions -->
		</form>
@stop

@section('extra')
<p class="help-block">If you haven't received your Password yet, activate your account!</p>
<a class="btn btn-primary pull-right" href="/desk/activate">Activate</a>
@stop
