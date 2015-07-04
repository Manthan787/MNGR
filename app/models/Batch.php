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
} 