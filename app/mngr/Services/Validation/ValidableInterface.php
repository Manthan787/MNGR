<?php namespace mngr\Services\Validation;

interface ValidableInterface{

	public function with(array $input);
	public function passes();
	public function getErrors();

}