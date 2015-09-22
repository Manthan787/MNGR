@extends('Desk.Auth.layout')

@section('title')
Forgot Password
@stop

@section('content')
<form method="post" id="activate-form">
  <h1>Forgot Password</h1>
  <div class="login-fields">
    <p>Enter your email ID</p>
    <div class="field">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" value="" placeholder="Email" class="form-control"/>
    </div>
  </div> <!-- /login-fields -->
  <div class="login-actions">

    <button class="button btn btn-success btn-large">Reset</button>
  </div> <!-- .actions -->
</form>
@stop
