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
}

?>
