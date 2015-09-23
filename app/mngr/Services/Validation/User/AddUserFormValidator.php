<?php namespace mngr\Services\Validation\User;

use mngr\Services\Validation\AbstractLaravelValidator;

class AddUserFormValidator extends AbstractLaravelValidator
{
	protected $rules = [
		'firstname' => 'required',
		'lastname'  => 'required',
		'email'		=> 'required | email',		

	];
}
