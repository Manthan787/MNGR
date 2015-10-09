<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield("title") - Student Desk</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <link href="{{URL::asset('studentApp/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset("studentApp/css/bootstrap-responsive.min.css")}}" rel="stylesheet" type="text/css" />

    <link href="{{URL::asset("studentApp/css/font-awesome.css")}}" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">

    <link href="{{URL::asset("studentApp/css/style.css")}}" rel="stylesheet" type="text/css">
    <link href="{{URL::asset("studentApp/css/pages/signin.css")}}" rel="stylesheet" type="text/css">

</head>

<body>

	<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">

		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<a class="brand" href="/desk">
				Student Desk
			</a>
		</div> <!-- /container -->

	</div> <!-- /navbar-inner -->

</div> <!-- /navbar -->
<br>
<br>

<div class="container">
    <div class="col-sm-10">
          @if(Session::has('message'))
          <p class="alert alert-info" align="center">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {{Session::get('message')}}
          </p>
          @endif

          @if(Session::has('error'))
          <p class="alert alert-error" align="center">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {{Session::get('error')}}
          </p>
          @endif
    </div>
</div>


<div class="account-container">

	<div class="content clearfix">
        @yield('content')
	</div> <!-- /content -->

</div> <!-- /account-container -->



<div class="login-extra">
	@yield('extra')
</div> <!-- /login-extra -->


<script src="{{URL::asset("studentApp/js/jquery-1.7.2.min.js")}}"></script>
<script src="{{URL::asset("studentApp/js/bootstrap.js")}}"></script>
<script src="{{URL::asset("studentApp/js/base.js")}}"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-68591249-1', 'auto');
  ga('send', 'pageview');

</script>

</body>

</html>
