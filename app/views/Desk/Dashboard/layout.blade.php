<!DOCTYPE html>
<html lang="en" ng-app="desk">
<head>
    <meta charset="utf-8">
    <title>@yield('title') - Student Desk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="{{URL::asset("studentApp/css/bootstrap.min.css")}}" rel="stylesheet">
    <link href="{{URL::asset("studentApp/css/bootstrap-responsive.min.css")}}" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
            rel="stylesheet">
    <link href="{{URL::asset("studentApp/css/font-awesome.css")}}" rel="stylesheet">
    <link href="{{URL::asset("studentApp/css/style.css")}}" rel="stylesheet">
    <link href="{{URL::asset("studentApp/css/pages/dashboard.css")}}" rel="stylesheet">
</head>
<body>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container"> <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span
                    class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </a><a class="brand" href="/desk">Student Desk </a>
      <div class="nav-collapse">
        <ul class="nav pull-right">
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                            class="icon-cog"></i> {{ Auth::user()->profile->name }} <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="/desk/profile">Profile</a></li>
              <li><a href="/desk/logout">Sign Out</a></li>
            </ul>
          </li>
        </ul>
      </div>
      <!--/.nav-collapse -->
    </div>
    <!-- /container -->
  </div>
  <!-- /navbar-inner -->
</div>
<!-- /navbar -->
<div class="subnavbar">
  <div class="subnavbar-inner">
    <div class="container" ng-controller="NavController">
      <ul class="mainnav">
        <li class="active"><a href="/desk"><i class="icon-dashboard"></i><span>Dashboard</span> </a> </li>
        <li class="active"><a href="/desk/test/practice"><i class="icon-list-alt"></i><span>Practice Test</span> </a> </li>
        <li class="active"><a href="/desk/study/"><i class="icon-file"></i><span>Online Study</span> </a> </li>
      </ul>
    </div>
    <!-- /container -->
  </div>
  <!-- /subnavbar-inner -->
</div>
<!-- /subnavbar -->
<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="row">
        @yield('content')
      </div>
      <!-- /row -->
    </div>
    <!-- /container -->
  </div>
  <!-- /main-inner -->
</div>
<!-- /main -->

<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.5/angular.min.js"></script>
 <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.5/angular-sanitize.js"></script>
<script src="{{URL::asset("studentApp/js/jquery-1.7.2.min.js")}}"></script>
<script src="{{URL::asset("studentApp/js/excanvas.min.js")}}"></script>
<script src="{{URL::asset("studentApp/js/chart.min.js")}}" type="text/javascript"></script>
<script src="{{URL::asset("studentApp/js/bootstrap.js")}}"></script>
<script src="{{URL::asset("studentApp/js/base.js")}}"></script>
<script src="{{URL::asset("studentApp/app.js")}}"></script>
<script src="{{URL::asset("studentApp/StudyController.js")}}"></script>
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</body>
</html>
