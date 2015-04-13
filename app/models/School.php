<?php

class School extends Eloquent
{
	protected $fillable = ['name'];

	public function students()
	{
		return $this->hasMany('Student');
	}
}