<?php 

class Option extends Eloquent
{
	protected $fillable = ['option'];

	public function question()
	{
		return $this->belongsTo('Question');
	}
}