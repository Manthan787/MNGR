@extends('Landing.partials.layout')

@section('title')
	Home
@stop

@section('pre-header')
<div id="home"></div>
@stop

@section('content')
<!-- ========== BANNER START ========== -->
<div id="slides">
	<div class="slides-container">
		<img src="{{URL::asset("Landing/images/bg.png")}}" alt="" />
		<img src="{{URL::asset("Landing/images/bg.png")}}" alt="" />
	</div>

	<div class="tint"></div>

	<!-- SLIDER OFFERS START -->
	<div class="slider-offers text-center">
		<ul>
			<li>
				<h3>{{ $preferences['INSTITUTE_NAME'] }}</h3>
				<h4>Vadodara's only Hands-On Computer Class</h4>
				<p><a href="/contact" class="btn btn-primary">Contact Now</a></p>
			</li>
			<li>
				<h3>Study Online</h3>
				<h4>Sign In to Student Desk for online tests and materials.</h4>
				<p><a href="/desk/login" class="btn btn-primary">Student Desk</a></p>
			</li>
		</ul>
	</div>
	<!-- SLIDER OFFERS END -->

	<a class="arrow" href="#welcome">
		<i class="fa fa-arrow-down fa-2x"></i>
	</a>
</div>

<!-- ========== BANNER END ========== -->

<!-- ========== WELCOME START ========== -->

<section id="welcome">
	<div class="container">
		<div class="row text-center">

			{{ LandingHelper::generateCourses($Landing_Config['courses']) }}

		</div>
	</div>
</section>

<!-- ========== WELCOME END ========== -->

<!-- ========== OUR SERVICES START ========== -->

<section id="services" class="alt-background">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h2 class="text-center carousel-title">Stay Connected, 24 X 7<br>
					<small>Along with our classes, we also provide you with an immersive online learning experience.</small>
				</h2>
			</div>
		</div>
		<div class="row text-center">
			<div class="col-sm-3">
				<p><span class="icon icon-049 fa-lg"></span></p>
				<h3>Online Tests</h3>
				<p>Students can login with their dedicated Student Desk account and give online tests to prepare themselves for the exams.</p>
			</div>
			<div class="col-sm-3">
				<p><span class="icon icon-020 fa-lg"></span></p>
				<h3>Online Study Material</h3>
				<p>Our interactive Study Material consists of multimedia content which will help you grasp even the most complex concepts easily. You can access it, anytime, and from anywhere in the world.</p>
			</div>
			<div class="col-sm-3">
				<p><span class="icon icon-043 fa-lg"></span></p>
				<h3>Performance Monitoring</h3>
				<p>We keep track of your test performance and help you improve your performance significantly.</p>
			</div>
			<div class="col-sm-3">
				<p><span class="icon icon-098 fa-lg"></span></p>
				<h3>SMS Notifications</h3>
				<p>Parents will be notified test marks, attendance reports and performance reports. Our SMS Notifications help us keep parents in the loop.</p>
			</div>
		</div>
	</div>
</section>

<!-- ========== OUR SERVICES END ========== -->

<!-- ========== REVIEWS START ========== -->

<section id="about-reviews">
	<div class="tint"></div>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center" data-scroll-reveal>

				<h2>What Our Students Say</h2>

				<!-- OWL CAROUSEL START -->
				<div class="owl-carousel">

					{{ LandingHelper::generateTestimonials($Landing_Config['testimonials']) }}

				</div>
				<!-- OWL CAROUSEL END -->

			</div>
		</div>
	</div>
</section>

<!-- ========== REVIEWS END ========== -->



<!-- ========== POPULAR COURSES START ========== -->

<section id="popular-courses">
	<div class="container text-center">
		<div class="row">
			<div class="col-sm-12">
				<h2 class="carousel-title">
					Popular Course
				</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4">

			</div>
			<div class="col-sm-4">
				<p><img src="Landing/images/popularcourse.jpg" alt="" class="img-responsive" /></p>
			</div>
			<div class="col-sm-4">

			</div>
		</div>
	</div>
</section>

<!-- ========== POPULAR COURSES END ========== -->

<!-- ========== SEARCH START ========== -->

<section id="search">
	<div class="tint"></div>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center" data-scroll-reveal>

				<h2 class="carousel-title">
					Enroll Now
				</h2>

				<a href="/contact">
					<button class="btn btn-primary btn-lg"> Contact Us </button>
				</a>

			</div>
		</div>
	</div>
</section>

<!-- ========== SEARCH END ========== -->


@stop
