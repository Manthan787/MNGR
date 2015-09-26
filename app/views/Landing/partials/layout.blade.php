<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Smartway - HTML Template">
		<meta name="author" content="Coffeecream Themes, info@coffeecream.eu">
		<title>@yield('title') | {{ $preferences['INSTITUTE_NAME'] }}</title>
		<link rel="shortcut icon" href="images/favicon.png">

		<!-- Main Stylesheet -->
		<link href="{{URL::asset("Landing/css/style.css")}}" rel="stylesheet">

		<!-- HTML5 shiv and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
		<script src="js/respond.min.js"></script>
		<![endif]-->

	</head>
	<body>
		@yield('pre-header')

		<!-- ========== HEADER START ========== -->

		<header>

			<!-- ==== TOOLS START ==== -->
			<div class="tools">
				<div class="container">
					<ul class="pull-left">
						<li><a href="tel:1800123456"><i class="fa fa-phone"></i><span>{{ $preferences['CONTACT_NO'] }}</span></a></li>
						<li><a href="mailto:info@smartway.com"><i class="fa fa-envelope"></i><span>{{ $preferences['CONTACT_EMAIL'] }}</span></a></li>
					</ul>
					<nav class="pull-right">
						<ul>
							<li><a href="/admin/login"><i class="fa fa-lock"></i><span>Log In</span></a></li>
              <li><a href="/desk/login"><span class="icon icon-093"></span>  <span>Student Desk</span></a></li>
						</ul>
					</nav>
				</div>
			</div>
			<!-- ==== TOOLS END ==== -->

      <!-- ==== NAVBAR START ==== -->
			<div class="navbar navbar-default navbar-static-top" role="navigation">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a href="/" class="navbar-brand"></a>
					</div>
					<nav class="navbar-collapse collapse">
						<ul class="nav navbar-nav navbar-right">
							<li class="active"><a href="/">Home</a></li>
							<li><a href="/about">About</a></li>
							<li><a href="/contact">Contact</a></li>
						</ul>
					</nav>
				</div>
			</div>
			<!-- ==== NAVBAR END ==== -->

		</header>
    <!-- ========== HEADER END ========== -->


      @yield('content')


		<!-- ========== PREFOOTER START ========== -->

		<div id="prefooter">
			<div class="container">
				<div class="row">

					<!-- ==== ABOUT START == -->
					<div class="col-sm-6">
						<h3>About Us</h3>
						<div class="row">
							<div class="col-sm-5">
								<p><img src="Landing/images/about.jpg" alt="" class="img-responsive" /></p>
							</div>
							<div class="col-sm-7">
								<p>Morbi nec quam sed elit pharetra faucibus. Cras vel massa viverra ligula suscipit interdum eget nec est. Cras nibh mi, faucibus at ligula eu, eleifend tincidunt justo. Nunc porttitor massa at nisi condimentum fringilla. Nullam finibus, nibh eu hendrerit suscipit, tellus mi commodo lectus, sit amet dictum sem lorem sed neque.<br>
								<a href="#">Read More <i class="fa fa-angle-right"></i></a></p>
							</div>
						</div>
					</div>
					<!-- ==== ABOUT END == -->

					<!-- ==== APPLY FOR TEACHER START == -->
					<div class="col-sm-3">

					</div>
					<!-- ==== APPLY FOR TEACHER END == -->

					<!-- ==== CONTACT START == -->
					<div class="col-sm-3">
						<h3>Contact</h3>
						<p>
						  {{ LandingHelper::generateAddress($preferences) }}
						</p>

						<p>Phone: <a href="tel:1800123456">{{ $preferences['CONTACT_NO'] }}</a><br>
						Email: <a href="mailto:{{ $preferences['CONTACT_EMAIL'] }}">{{ $preferences['CONTACT_EMAIL'] }}</a></p>

						<p><a href="/contact">Get Directions <i class="fa fa-angle-right"></i></a></p>
					</div>
					<!-- ==== CONTACT END == -->

				</div>
			</div>
		</div>

		<!-- ========== PREFOOTER END ========== -->

		<!-- ========== FOOTER START ========== -->

		<footer>
			<div class="container">
				<div class="row">

					<!-- ==== CREDITS START == -->
					<div class="col-sm-8">
						Powered By<a href="http://acharyapp.com" target="_blank">Acharya</a>
					</div>
					<!-- ==== CREDITS END == -->

					<!-- ==== SOCIAL ICONS START == -->
					<div class="col-sm-4 text-right">
            {{ LandingHelper::generateSocialLinks($preferences) }}
					</div>
					<!-- ==== SOCIAL ICONS END == -->

				</div>
			</div>
		</footer>

		<!-- ========== FOOTER END ========== -->

		<!-- Modernizr Plugin -->
		<script src="{{URL::asset("Landing/js/modernizr.custom.97074.js")}}"></script>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="{{URL::asset("Landing/js/jquery-1.11.1.min.js")}}"></script>

		<!-- Bootstrap Plugins -->
		<script src="{{URL::asset("Landing/js/bootstrap.min.js")}}"></script>

		<!-- Retina Plugin -->
		<script src="{{URL::asset("Landing/js/retina-1.1.0.min.js")}}"></script>

		<!-- Superslides Plugin -->
		<script src="{{URL::asset("Landing/js/jquery.easing.1.3.js")}}"></script>
		<script src="{{URL::asset("Landing/js/jquery.animate-enhanced.min.js")}}"></script>
		<script src="{{URL::asset("Landing/js/jquery.superslides.js")}}"></script>

		<!-- Owl Carousel Plugin -->
		<script src="{{URL::asset("Landing/js/owl.carousel.min.js")}}"></script>

		<!-- Parallax ImageScroll Plugin -->
		<script src="{{URL::asset("Landing/js/jquery.parallax-1.1.3.js")}}"></script>

		<!-- Fancybox Plugin -->
		<script src="{{URL::asset("Landing/js/jquery.fancybox.js")}}"></script>

		<!-- ImagesLoaded Plugin -->
		<script src="{{URL::asset("Landing/js/imagesloaded.pkgd.min.js")}}"></script>

		<!-- Masonry Plugin -->
		<script src="{{URL::asset("Landing/js/masonry.pkgd.min.js")}}"></script>

		<!-- Progressbar Plugin -->
		<script src="{{URL::Asset("Landing/js/bootstrap-progressbar.js")}}"></script>

		<!-- Scroll Reveal Plugin -->
		<script src="{{URL::asset("Landing/js/scrollReveal.js")}}"></script>

		<!-- Magic Form Processing -->
		<script src="{{URL::asset("Landing/js/magic.js")}}"></script>

		<!-- jQuery Settings -->
		<script src="{{URL::asset("Landing/js/settings.js")}}"></script>

	</body>
</html>
