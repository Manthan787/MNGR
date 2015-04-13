<?php namespace mngr\Services\Forms\User;

use mngr\Repositories\User\UserRepository;
use mngr\Services\Validation\ValidableInterface;

class AddUserForm{

	/**
	 * User Instance
	 * @var mngr\Repositories\User\UserRepository
	 */
	protected $user;
	/**
	 * Application's Validator
	 * @var mngr\Services\Validation\ValidableInterface
	 */
	protected $validator;

	public function __construct(ValidableInterface $validator, UserRepository $user)
	{
		$this->validator = $validator;
		$this->user = $user;
	}

	/**
	 * Process Form. 
	 * 
	 * @return boolean
	 */

	public function create(array $input)
	{
		if($this->user->create($input))
		{
			return true;
		}
		return false;
	}
	/**
	 * Process Form For Updation
	 *
	 * @return  boolean 
	 */

	public function update(array $input)
	{

	}

	public function valid(array $input)
	{
		if($this->validator->with($input)->passes()) 
			return true;
		
		return false;
	}

	public function errors()
	{
		return $this->validator->getErrors();
	}
}