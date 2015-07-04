<?php
namespace mngr\Services\Questionnaire;
use Illuminate\Support\ServiceProvider;


class QuestionnaireServiceProvider extends ServiceProvider {
    public function register() {
        $this->app->bind('mngr\Services\Questionnaire\QuestionnaireInterface','mngr\Services\Questionnaire\Questionnaire');
    }
} 