<?php


class Stream extends Eloquent
{
	public $fillable = ['stream', 'standard_id'];

	public $table = 'streams';

	public function students()
	{
		return $this->hasMany('Student');
	}

	public function standard()
	{
		return $this->belongsTo('Standard');
	}

	public function subjects()
	{
		return $this->hasMany('Subject');
	}
}