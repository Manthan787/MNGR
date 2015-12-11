@extends('Desk.Dashboard.layout')

@section('title')
Compile Online
@stop


@section('content')
<section ng-controller="CompilerController">
  <div class="row">
    <div class="span12">
      <div class="control-group">
          <label class="control-label">Select Programming Language</label>
          <select name="language" ng-model="compiler.language" ng-change="clear()">
              <option value="c">C</option>
              <option value="java">Java</option>
              <option value="cpp">C++</option>
          </select>
      </div>
      <div class="control-group" ng-if="showNameBox()">
          <label class="control-label">File Name</label>
          <input type="text" name="name" ng-model="compiler.name" placeholder="Demo.java">
          <span class="alert-error" ng-if="error">File Name is required!</span>
      </div>
    </div>
  </div>
  <div class="row">
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
</section>
@stop
