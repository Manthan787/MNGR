<?php

class StudyMaterial extends Eloquent{
    protected $table = 'study_material';
    protected $fillable = ['topic','text'];
    public function chapter()
    {
        return $this->belongsTo('Chapter');
    }
} 