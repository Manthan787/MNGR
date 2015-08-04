@extends('Desk.Dashboard.layout')

@section('title')
Change Password
@stop

@section('content')
<div class="row">
    <div class="span3">
        <div class="widget">

        </div>
    </div>
    <div class="span6">
        <div class="widget">
            @if($errors->has())
            <span class="alert-error">
                Following errors occured.
                <ul>
                @foreach($errors->all() as $error)
                <li>
                    {{ $error }}
                </li>
                @endforeach
                </ul>
            </span>
            @endif
            @if(Session::has('success'))
            <p class="alert alert-success">{{ Session::get('success') }}</p>
            @endif
            <div class="widget-header">
            <h3><i class="icon-user"> Change Password</i></h3>
            </div>

            <div class="widget-content">
                <form class="form-horizontal" method="POST" action="/desk/change-password">
                    <div class="control-group">
                        <lable class="control-label">New Password</lable>
                        <div class="controls">
                             <input type="password" name="new">
                        </div>
                    </div>
                    <div class="control-group">
                        <lable class="control-label">Re-Enter New Password</lable>
                        <div class="controls">
                            <input type="password" name="new_again">
                        </div>
                    </div>
                    <div class="control-group">
                        <div align="center">
                            <input type="submit" class="btn btn-primary" value="Change Password">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@stop

