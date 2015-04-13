<?php namespace mngr\Services\Forms;

use Illuminate\Support\ServiceProvider;
use mngr\Services\Forms\User\AddUserForm;
use mngr\Services\Validation\User\AddUserFormValidator;

class FormServiceProvider extends ServiceProvider{


	public function register()
	{
		$this->app->bind('\mngr\Services\Forms\User\AddUserForm',function($app){

			return new AddUserForm(

				new AddUserFormValidator($app['validator']),
				$app->make('mngr\Repositories\User\UserRepository')


			);

		});

		$this->app->bind('\mngr\Services\Forms\Question\AddQuestionForm',function($app){

			return new AddQuestionForm(

				new AddQuestionFormValidator($app['validator']),
				$app->make('mngr\Repositories\Questions\QuestionsRepository')


			);

		});
	}
}