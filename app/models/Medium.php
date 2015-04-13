<?php


class Medium extends Eloquent
{
	protected $fillable = ['medium'];

	protected $table = 'mediums';

	public function students()
	{
		return $this->hasMany('Student');
	}
}