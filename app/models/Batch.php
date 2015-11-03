<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 04/07/15
 * Time: 5:07 PM
 */

class Batch extends Eloquent{
    protected $table = 'batches';
    protected $fillable = ['name','standard_id'];

    public function timings()
    {
        return $this->hasMany('Timing');
    }

    public function attendances()
    {
        return $this->hasMany('Attendance');
    }

    public function students()
    {
        return $this->belongsToMany('Student');
    }
}
