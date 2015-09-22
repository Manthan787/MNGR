@extends('Desk.Auth.layout')

@section('title')
Activate
@stop
@section('content')
    <form method="post" id="activate-form">
    			<h1>Activate Account</h1>
    			<div class="login-fields">
    				<p>Enter your email ID provided during Student Registration</p>
    				<div class="field">
    					<label for="email">Email:</label>
    					<input type="email" id="email" name="email" value="" placeholder="Email" class="form-control"/>
    				</div>
    			</div> <!-- /login-fields -->
    			<div class="login-actions">

    				<button class="button btn btn-success btn-large">Activate</button>
    			</div> <!-- .actions -->
    		</form>
@stop

@section('extra')
<p class="help-block">After successful activation, You will receive a password as an email, which you can use to login to the Student Desk! </p>
@stop

<script>

</script>
