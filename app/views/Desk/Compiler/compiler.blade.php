@extends('Desk.Dashboard.layout')

@section('title')
Compile Online
@stop

@section('extra-css')
<style>
  .styled {
    width: 99%;
    height: 600px;
    padding: 10px;
    margin-right: 5px;
    font-family: Tahoma, sans-serif;
    outline: none;
    color: white;
    overflow: scroll;
    /*color: #DF635B;*/
    background: #464646;
    background-position: bottom right;
    background-repeat: no-repeat;
  }
</style>
@stop

@section('content')
<div class="row" ng-controller="CompilerController">
  <div class="alert alert-info">
    <h3>Notes</h3>
    <ul>
    <li>You can write or paste any valid C Program in the editor below.</li>
    <li>This online compiler does not support the header file <b>conio.h</b> and all the functions defined in conio.h like <b>clrscr()</b>, so do not include those in your programs.</li>
    <li>If your program requires command line arguments, be sure to provide those arguments in the <b>Inputs box</b> below. For example, scanf() requires values to be passed in the command line. Pass those arguments in the inputs box.</li>
    </ul>
  </div>
  <div class="span8">
    <form class="form-horizontal" method="POST" ng-submit="compile()">
      <div class="control-group">
        <textarea name="program" class="styled" id="code" spellcheck="false" ng-model="compiler.program"></textarea>
      </div>
      <div class="control-group">
        <label class="control-label"><h4>Inputs</h4> Enter all the scanf and other command line values here. e.g. 140,30</label>
        <div class="controls">
          <textarea name="inputs" ng-model="compiler.inputs"></textarea>
        </div>
      </div>
      <div class="control-group">
      <div class="control-group">
        <div align="center">
          <input type="submit" value="Run" class="btn btn-success">
        </div>
      </div>
    </div>
    </form>
  </div>
  <div class="span4">
    <div class="styled">
      <h4> Output </h4>
      <p ng-if="loading">Loading...</p>
      <p ng-repeat="line in output track by $index">@{{ line }}</p>
    </div>
  </div>
</div>
@stop
