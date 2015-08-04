@extends('Desk.Dashboard.layout')

@section('title')
Dashboard
@stop

@section('content')
@if(Auth::user()->temp_password)
      <p class="alert alert-info" align="center">
        <button type="button" class="close" data-dismiss="alert">×</button>
        Why don't you change your password to something that you can remember? &nbsp <a href="/desk/change-password" class="btn btn-primary">Change Password</a>
      </p>
@endif

<div class="span6">
<h2>Welcome to the Student Desk!</h2>
</div>
@stop