<?php
class Test extends Eloquent {
    protected $fillable = ['name','subject_id','is_online','marks'];

    public function questions() {
        return $this->belongsToMany('Question');
    }

    public function subject() {
        return $this->belongsTo('Subject');
    }
}
