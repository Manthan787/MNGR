<?php
namespace mngr\Services\SMS;
use Manthan\Nuncio\MessageProcessor;
use Illuminate\Support\ServiceProvider;

class NotifierServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('mngr\Services\SMS\SMSNotifier', function($app) {

              return new SMSNotifier(
                  $app->make('mngr\Services\SMS\PlivoMessenger'),
                  new MessageProcessor()
              );
        });
    }
}

?>
