<?php namespace mngr\Services\Validation;

use mngr\Services\Validation\ValidableInterface;
use Illuminate\Validation\Factory as Validator;


abstract class AbstractLaravelValidator implements ValidableInterface
{
	/**
	 * Laravel Validator
	 * 
	 * @var Illuminate\Validation\Factory
	 */
	protected $validator;
	/**
	 * Data to be validated.
	 * 
	 * @var array
	 */
	protected $input;
	/**
	 * Validation Rules For Addition.
	 * @var array
	 */
	protected $rules = [];
	
	public function __construct(Validator $validator)
	{
		$this->validator = $validator;
	}

	/**
	 * Setter for $input, used for chaining purposes.
	 * 
	 * @param  array  $input User Input
	 * 
	 * @return mngr\Services\Validation\LaravelValidator
	 */
	public function with(array $input)
	{
		$this->input = $input;

		return $this;
	}

	/**
	 * Check Whether Validation Passes Or Not. 
	 * 
	 * @return boolean
	 */
	public function passes()
	{
		$validator=$this->validator->make($this->input,$this->rules);

		if(!$validator->fails())
		{
			return true;
		}
		
		return false;
	}
	/**
	 *Get Validation Errors
	 *
	 * @return MessageBag 
	 */

	public function getErrors()
	{
		return $this->validator->make($this->input,$this->rules)->messages();
	}

}