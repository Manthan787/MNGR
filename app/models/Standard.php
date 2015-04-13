<?php


class Standard extends Eloquent
{
	protected $fillable = ['division'];

	public function students()
	{
		return $this->hasMany('Student');
	}

	public function streams()
	{
		return $this->hasMany('Stream');
	}

	public function subjects()
	{
		return $this->hasMany('Subject');
	}

	public function hasStreams()
	{
		

		if(! count($this->streams) > 0)
		{
			return false;
		}

		return true;
	}

	public function hasSubjects()
	{
		

		if(! count($this->subjects) > 0)
		{
			return false;
		}

		return true;
	}
}