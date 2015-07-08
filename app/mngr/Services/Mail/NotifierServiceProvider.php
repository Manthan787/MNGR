<?php
namespace mngr\Services\Mail;
use Illuminate\Support\ServiceProvider;

class NotifierServiceProvider extends ServiceProvider {
    public function register()
    {
        $this->app->bind('mngr\Services\Mail\Notifier','mngr\Services\Mail\EmailNotifier');
    }
} 