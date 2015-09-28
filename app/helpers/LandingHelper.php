<?php

class LandingHelper {

  public static function generateSocialLinks($preferences) {

    $keys = array('FACEBOOK', 'TWITTER', 'YOUTUBE');

    foreach($keys as $key) {
      if(!empty($link = $preferences[$key])) {
        echo '<a href="'.$link.'" target="_blank"><i class="fa fa-'.strtolower($key).' fa-lg"></i></a>';
      }
    }

  }

  public static function generateAddress($preferences) {

      $address = '';

      foreach($preferences['ADDRESS'] as $part_address) {
          $address .= $part_address . '<br/>';
      }

      return $address;

  }

  public static function generateCourses($courses) {

      foreach($courses as $course)
      {
        echo '<div class="col-sm-3">
  				      <p><img src="'.$course['logo'].'" alt="" /></p>
  				      <h3>'.$course['title'].'</h3>
                <p>'.$course['description'].'</p>
  			      </div>';
      }

  }

  public static function generateTestimonials($testimonials) {

      foreach($testimonials as $testimonial)
      {
        echo '<div class="item">
                  <blockquote>'.$testimonial['testimonial'].'
                    <small>'.$testimonial['student'].'</small>
                  </blockquote>
              </div>';
      }
  }
}

?>
