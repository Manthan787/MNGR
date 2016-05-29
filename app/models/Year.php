<?php

class Year extends Eloquent {

    public $fillable = ['year', 'start_date','end_date'];

    public function students() {
        return $this->hasMany('Student');
    }

    public static function currentYear() {
        return Year::where('isCurrent', 1)->first();
    }
}
