@extends('Landing.partials.layout')

@section('title')
Contact Us
@stop

@section('content')
<!-- ========== TITLE START ========== -->

<div class="title">
  <div class="title-image"></div>
  <div class="container">
    <div class="row">
      <div class="col-sm-12 text-center">
        Contact
      </div>
    </div>
  </div>
</div>

<!-- ========== TITLE END ========== -->

<!-- ========== MAP START ========== -->

<!-- Google Map Script -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDoRMxiPsqJ9SUuaK1KsCAjd3gqnecjlBw&amp;sensor=false"></script>
<script type="text/javascript">
  INSTITUTE_NAME = '<?php echo $preferences['INSTITUTE_NAME']; ?>';
  LATITUDE       = '<?php echo $preferences['LATITUDE']; ?>';
  LONGITUDE      = '<?php echo $preferences['LONGITUDE']; ?>';
  SOCIETY        = '<?php echo $preferences['ADDRESS']['Society']; ?>';
  CITY           = '<?php echo $preferences['ADDRESS']['City']; ?>';
  PIN            = '<?php echo $preferences['ADDRESS']['PIN']; ?>';

  function initialize() {

    // Create an array of styles.
    var styles = [
      {
        "featureType": "water",
        "stylers": [
          { "hue": "#89909a" },
          { "lightness": 60 }
        ]
      },{
        featureType: "road",
        elementType: "geometry",
        stylers: [
          { lightness: 50 },
          { visibility: "simplified" }
        ]
      },{
        featureType: "road",
        elementType: "labels",
        stylers: [
          { visibility: "on" }
        ]
      }
    ];

    // Create a new StyledMapType object, passing it the array of styles,
    // as well as the name to be displayed on the map type control.
    var styledMap = new google.maps.StyledMapType(styles,
    {name: "Styled Map"});


          var mapOptions = {
            scrollwheel: false,
            zoom: 15,
            center: new google.maps.LatLng(LATITUDE,LONGITUDE),
    mapTypeControlOptions: {
      mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
    }
    }
    var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

    //Associate the styled map with the MapTypeId and set it to display.
    map.mapTypes.set('map_style', styledMap);
    map.setMapTypeId('map_style');

    setMarkers(map, places);
  }
//
  var places = [
    ['<b>'+INSTITUTE_NAME+'</b><br>'+SOCIETY+'<br>'+CITY+'<br>'+PIN, LATITUDE, LONGITUDE, 1]
  ];

  function setMarkers(map, locations) {
    // Add markers to the map
    var image = {
      url: '/Landing/images/marker.jpg',
      // This marker is 40 pixels wide by 42 pixels tall.
      size: new google.maps.Size(40, 42),
      // The origin for this image is 0,0.
      origin: new google.maps.Point(0,0),
      // The anchor for this image is the base of the pin at 20,42.
      anchor: new google.maps.Point(15, 42)
    };

      var infowindow = new google.maps.InfoWindow();

      var marker, i;
      var markers = new Array();

      for (var i = 0; i < locations.length; i++) {
        var place = locations[i];
        var myLatLng = new google.maps.LatLng(place[1], place[2], place[3]);
        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          icon: image,
          title: place[0],
          zIndex: place[3],
          animation: google.maps.Animation.DROP
        });

        markers.push(marker);

        google.maps.event.addListener(marker, 'click', (function(marker, i) {
          return function() {
            infowindow.setContent(locations[i][0]);
            infowindow.open(map, marker);
          }
        })(marker, i));
      }
  }

  google.maps.event.addDomListener(window, 'load', initialize);
</script>

<div id="map-canvas"></div>

<!-- ========== MAP END ========== -->

<!-- ========== CONTENT START ========== -->

<section id="content">
  <div class="container">
    <div class="row">
      <div class="col-sm-5">
        <div class="row">
          <div class="col-xs-12">
            <h1>Contact Details</h1>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-2 col-xs-3">
            <i class="fa fa-map-marker fa-5x primary-color"></i>
          </div>
          <div class="col-lg-10 col-xs-9">
            <h3 class="no-margin">Address</h3>
            {{ LandingHelper::generateAddress($preferences) }}
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <hr>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-2 col-xs-3">
            <i class="fa fa-phone fa-5x primary-color"></i>
          </div>
          <div class="col-lg-10 col-xs-9">
            <h3 class="no-margin">Phone</h3>
            Phone: <a href="tel:{{ $preferences['CONTACT_NO'] }}">{{ $preferences['CONTACT_NO'] }}</a><br>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <hr>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-2 col-xs-3">
            <i class="fa fa-envelope fa-4x primary-color"></i>
          </div>
          <div class="col-lg-10 col-xs-9">
            <h3 class="no-margin">Email</h3>
            Email: <a href="mailto:{{ $preferences['CONTACT_NO'] }}">{{ $preferences['CONTACT_EMAIL'] }}</a><br>
          </div>
        </div>
      </div>
      <div class="col-sm-7">
        <p>&nbsp;</p>
        <img src="Landing/images/class.jpg" alt="" class="img-responsive" />
      </div>
    </div>
  </div>
</section>

<!-- ========== CONTENT END ========== -->

<!-- ========== CONTACT FORM START ========== -->

<section id="contact" class="alt-background">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 text-center">
        <h2>Contact Form</h2>
      </div>
    </div>
    <form role="form" name="contact-form" id="contact-form" action="process-contact.php">
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group" id="contact-name-group">
            <label for="contact-input-name">Name</label>
            <input type="text" class="form-control" id="contact-input-name" placeholder="Enter your name">
          </div>
          <div class="form-group" id="contact-email-group">
            <label for="contact-input-email">Email</label>
            <input type="email" class="form-control" id="contact-input-email" placeholder="Enter your email">
          </div>
          <div class="form-group" id="contact-subject-group">
            <label for="contact-input-subject">Subject</label>
            <input type="text" class="form-control" id="contact-input-subject" placeholder="Enter your subject">
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group" id="contact-message-group">
            <label for="contact-input-message">Message</label>
            <textarea class="form-control" id="contact-input-message" rows="8"></textarea>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12 text-center">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </form>
  </div>
</section>

<!-- ========== CONTACT FORM END ========== -->

@stop
