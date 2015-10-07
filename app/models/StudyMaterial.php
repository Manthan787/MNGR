<?php

class StudyMaterial extends Eloquent{
    protected $table = 'study_material';
    protected $appends = array('subject');
    protected $fillable = ['topic','text'];
    public function chapter()
    {
        return $this->belongsTo('Chapter');
    }

    public function getSubjectAttribute()
    {
        return $this->chapter->subject;
    }
}
