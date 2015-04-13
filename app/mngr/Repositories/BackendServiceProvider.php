<?php 
namespace mngr\Repositories;
use Illuminate\Support\ServiceProvider;


class BackendServiceProvider extends ServiceProvider{
    
    public function register(){
        
     $this->app->bind('mngr\Repositories\User\UserRepository','mngr\Repositories\User\EloquentUserRepository');   
     $this->app->bind('mngr\Repositories\Questions\QuestionsRepository','mngr\Repositories\Questions\EloquentQuestionsRepository');  
    }
    
    
    
}