@extends('Landing.partials.layout')

@section('title')
About
@stop

@section('content')
<div class="title">
  <div class="title-image"></div>
  <div class="container">
    <div class="row">
      <div class="col-sm-12 text-center">
        About Us
      </div>
    </div>
  </div>
</div>
<section id="content" class="alt-background">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">

        <p>
          Amee Computer Classes was established in 2005 by Mr. Ajay Shah, to make the computer education more accessible among students in Vadodara, Gujarat.
          Ever since its inception, Amee Computer Classes has been a huge proponent of "Learn By Doing". As a result, each student enrolled in
          class has access to a dedicated computer to apply their newly learned skills.
        </p>
        <p>
          Amee computer classes is also known for its interactive style of teaching. Students are presented with powerpoint slides, videos and
          screencasts via Projector. Students are provided with pamphlets and online study materials. Moreover, Students are frequently tested
          so that they can tackle their exams easily.
        </p>
        <p>
          We believe in cultivating an innovative environment, so that students "think out of the box" and march towards a better tomorrow.
        </p>
      </div>
    </div>
  </div>
</section>

<section id="content">
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
          <img src="Landing/images/ajay_sir.jpg" al="" class="image-responsive">
      </div>
      <div class="col-sm-6">
        <h1>Teacher Profile</h1>
        <p>
            Ajay Shah is the owner of Amee Computer Classes and has over 12 years of teaching experience. Apart from earning a B.Sc. Degree
            He's also a <b>Microsoft Certified Solutions Expert (MCSE)</b> and <b>Microsoft Certified Database Administrator.</b>
        </p>
        <p>
            Due to his humble nature and unique teaching methodologies, he's managed to be Students' favorite computer teacher. He has the ability
            to deconstuct any complex concept and convey its nuances eloquently in a way that is comprehensible by the students.
        </p>
        <p>
            His Pragmatic Approach towards teaching is evident in his class setups. He makes sure that every student has a dedicated Computer to
            perform all their learnings during the lessons.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- ========== REVIEWS START ========== -->

<section id="teachers-reviews">
  <div class="tint"></div>
  <div class="container">
    <div class="row">
      <div class="col-sm-12 text-center" data-scroll-reveal>
        <h1>What students say about Mr. Ajay Shah</h1>
        <!-- OWL CAROUSEL START -->
        <div class="owl-carousel">
          <div class="item">
            <blockquote>Ajay Sir builds your knowledge about the subject from the ground up and makes sure everytime you get out of the class, you've learnt something new.
                        At the end of the course, you've not only gained significant amount of knowledge but you end up loving the subject.
              <small>Hemant Chetwani, Computer Engineering Student at SVIT</small>
            </blockquote>
          </div>

          <div class="item">
            <blockquote>Ajay Sir's best teaching techniques and affectionate nature makes scoring and understanding so much easier.
              <small>Haard Shah, 99.73 percentile rank in 12th Science</small>
            </blockquote>
          </div>

        </div>
        <!-- OWL CAROUSEL END -->

      </div>
    </div>
  </div>
</section>

<!-- ========== REVIEWS END ========== -->
@stop
