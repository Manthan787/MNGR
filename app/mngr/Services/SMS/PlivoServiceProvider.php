<?php
namespace mngr\Services\SMS;
use Plivo\RestAPI;
use Illuminate\Support\ServiceProvider;

class PlivoServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('mngr\Services\SMS\PlivoMessenger', function($app) {

              $auth_id    = $app['config']->get('plivo.auth_id');
              $auth_token = $app['config']->get('plivo.auth_token');
              return new PlivoMessenger(
                     new RestAPI($auth_id, $auth_token)
              );
        });
    }
}

?>
