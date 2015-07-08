@extends('Desk.Dashboard.layout')
@section('title')
Profile
@stop

@section('content')
<div class="row">
    <div class="span3">
        <div class="widget">

        </div>
    </div>
    <div class="span6">
        <div class="widget">
            <div class="widget-header">
            <h3><i class="icon-user"> Profile</i></h3>
            </div>
            <div class="widget-content">
                <div class="control-group">
                    <b>Name :</b> <span>{{Auth::user()->profile->name}}</span>
                </div>
                <div class="control-group">
                    <b>Birthdate :</b> <span>{{Auth::user()->profile->birthdate}}</span>
                </div>
                <div class="control-group">
                    <b>Email :</b> <span>{{Auth::user()->profile->email}}</span>
                </div>
                <div class="control-group">
                    <b>Standard :</b> <span>{{Auth::user()->profile->standard->division}}</span>
                </div>
                <div class="control-group">
                    <b>Subjects Enrolled In :</b>
                    <?php $subjects = Auth::user()->profile->subjects?>
                    @foreach($subjects as $subject)
                    <span>{{$subject->name}}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@stop