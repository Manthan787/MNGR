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
				<p><a href="/desk/login" class="btn btn-primary"><span class="icon icon-093" /> Student Desk</a></p>
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
			<div class="col-sm-3">
				<p><img src="Landing/images/c.jpg" alt="" /></p>
				<h3>C/C++ Programming</h3>
				<p>Non ipsum vulputate condimentum eu id tellus. Praesent commodo arcu quis rhoncus porttitor. Suspendisse volutpat, quam eu rutrum laoreet, ex sapien pellentesque.</p>
				<p><a href="#" target="_blank" class="btn btn-primary">Read More</a></p>
			</div>
			<div class="col-sm-3">
				<p><img src="Landing/images/java.png" alt="" /></p>
				<h3>Introduction to Java</h3>
				<p>Non ipsum vulputate condimentum eu id tellus. Praesent commodo arcu quis rhoncus porttitor. Suspendisse volutpat, quam eu rutrum laoreet, ex sapien pellentesque.</p>
				<p><a href="#" target="_blank" class="btn btn-primary">Read More</a></p>
			</div>
			<div class="col-sm-3">
				<p><img src="Landing/images/javascript.jpg" alt="" /></p>
				<h3>Web Programming</h3>
				<p>Non ipsum vulputate condimentum eu id tellus. Praesent commodo arcu quis rhoncus porttitor. Suspendisse volutpat, quam eu rutrum laoreet, ex sapien pellentesque.</p>
				<p><a href="#" target="_blank" class="btn btn-primary">Read More</a></p>
			</div>
			<div class="col-sm-3">
				<p><img src="Landing/images/ubuntu.png" alt="" /></p>
				<h3>Linux</h3>
				<p>Linux Programming.</p>
				<p><a href="#" target="_blank" class="btn btn-primary">Read More</a></p>
			</div>
		</div>
	</div>
</section>

<!-- ========== WELCOME END ========== -->

<!-- ========== REVIEWS START ========== -->

<section id="about-reviews">
	<div class="tint"></div>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center" data-scroll-reveal>

				<h2>What Our Students Say</h2>

				<!-- OWL CAROUSEL START -->
				<div class="owl-carousel">

					<div class="item">
						<blockquote>Donec varius ante in turpis faucibus sagittis. Vestibulum lacinia ante eget fringilla lobortis. Nunc sollicitudin, arcu at fringilla varius, turpis dui venenatis augue, at adipiscing ante ipsum vel leo. In a sem sit amet mi condimentum semper. Nulla eleifend convallis gravida. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec blandit erat eu suscipit porttitor. Sed vestibulum mauris sit amet eros feugiat egestas. Ut rhoncus imperdiet est eget ullamcorper. Fusce at orci sed augue aliquam malesuada. <small>Sally Peterson, Student</small></blockquote>
					</div>

					<div class="item">
						<blockquote>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam semper consectetur nunc ac pretium. Nullam vel lectus non augue imperdiet porta. Proin commodo malesuada faucibus. Integer at lacinia lacus. Vestibulum dignissim imperdiet est vel ornare. Sed vehicula luctus massa, sit amet porta purus feugiat a. Cras tincidunt neque vitae enim pellentesque, nec congue mauris suscipit. Praesent sit amet odio lacus. <small>Malcolm Carr, Student</small></blockquote>
					</div>

					<div class="item">
						<blockquote>Integer faucibus orci eu lorem vulputate, non semper odio consectetur. Phasellus eu commodo lectus, interdum molestie nunc. Maecenas aliquet sagittis elementum. Nulla lobortis diam nisl, id consectetur nunc faucibus viverra. Donec vel porta augue, eget accumsan lorem. Sed dictum consequat ipsum eget porta. Donec imperdiet dolor at ante interdum, sed viverra orci iaculis. Donec vestibulum nulla at tortor molestie, vel convallis neque vestibulum. Phasellus luctus purus ut tincidunt imperdiet. <small>Antonia Owen, Student</small></blockquote>
					</div>

					<div class="item">
						<blockquote>Vestibulum viverra dolor lorem, vitae ornare velit facilisis eget. Phasellus ornare, mauris id interdum cursus, velit libero dictum dolor, a vehicula lacus enim id tortor. Vestibulum faucibus nec elit id iaculis. Aenean lorem ante, pretium ac iaculis non, tincidunt in quam. Nunc lobortis dictum dui. Pellentesque sagittis luctus posuere. Sed suscipit mi vitae orci accumsan, ut imperdiet odio molestie. <small>Jared Murray, Student</small></blockquote>
					</div>

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
					Popular Courses
					<a href="courses-list-right-sidebar.html">View All Courses</a>
				</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4">
				<p><a href="courses-details-right-sidebar.html"><img src="http://placehold.it/370x170.jpg" alt="" class="img-responsive" /></a></p>
			</div>
			<div class="col-sm-4">
				<p><a href="courses-details-right-sidebar.html"><img src="http://placehold.it/370x170.jpg" alt="" class="img-responsive" /></a></p>
			</div>
			<div class="col-sm-4">
				<p><a href="courses-details-right-sidebar.html"><img src="http://placehold.it/370x170.jpg" alt="" class="img-responsive" /></a></p>
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
