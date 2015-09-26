<?php
namespace mngr\Services\Landing;
use Illuminate\Support\ServiceProvider;
use View;


class LandingServiceProvider extends ServiceProvider {

  public function boot()
  {
      $preferences = $this->app['config']->get('preferences');
      View::share('preferences', $preferences);
  }

  public function register()
  {

  }

}




?>
