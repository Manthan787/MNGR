<?php


class Student extends Eloquent
{
	protected $guarded = ['id'];

	public function standard()
	{
		return $this->belongsTo('Standard');
	}

	public function medium()
	{
		return $this->belongsTo('Medium');
	}

	public function stream()
	{
		return $this->belongsTo('Stream');
	}

	public function school()
	{
		return $this->belongsTo('School');
	}

  public function subjects()
  {
      return $this->belongsToMany('Subject');
  }

  public function batches()
  {
      return $this->belongsToMany('Batch');
  }

	public function account()
	{
			return $this->hasOne('User');
	}

	public function attendances()
	{
			return $this->belongsToMany('Attendance');
	}

  public function setPhoneAttribute($phone)
	{
		if(is_null($phone))
		{
			$this->attributes['phone'] = 0;
		}
		else
		{
			$this->attributes['phone'] = $phone;
		}
	}

	public function setStreamIdAttribute($id)
	{
		if(is_null($id))
		{
			$this->attributes['stream_id'] = 0;
		}
		else
		{
			$this->attributes['stream_id'] = $id;
		}
	}

  public function getPhoneAttribute()
  {
      if(!$this->attributes['phone'])
      {
          return null;
      }
      else
      {
          return $this->attributes['phone'];
      }
  }

  public function getStudentMobileAttribute()
  {
      if(!$this->attributes['student_mobile'])
      {
         return null;
      }
      else
      {
          return $this->attributes['student_mobile'];
      }
  }

  public function getParentsMobileAttribute()
  {
      if(!$this->attributes['parents_mobile'])
      {
          return null;
      }
      else
      {
          return $this->attributes['parents_mobile'];
      }
  }

	public function isActivated()
	{

		if($this->getCorrespondingUser())
			return true;

		return false;
	}

	public function getCorrespondingUser()
	{
		return User::where('student_id', $this->id)->first();
	}
}
