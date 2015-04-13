<?php 

class Role extends Eloquent{


	protected $fillable=['role'];

	public function users()
	{
		return $this->hasMany('User');
	}
}