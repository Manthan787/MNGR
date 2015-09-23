<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
	protected $fillable = ['firstname','lastname','email','password','temp_password'];
    /**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public function role()
	{
		return $this->belongsTo('Role');
	}

	public function subjects()
	{
		return $this->belongsToMany('Subject');
	}

    public function profile()
    {
        return $this->belongsTo('Student','student_id');
    }
	public function isAdmin()
	{
        return ($this->role_id == 1) ? true : false;
	}

	public function isTeacher()
	{
        return ($this->role_id == 2) ? true : false;
	}

  public function isStudent()
  {
      return ($this->role_id == 4) ? true : false;
  }

	public function setPasswordAttribute($password)
	{
		$this->attributes['password'] = Hash::make($password);
	}


}
