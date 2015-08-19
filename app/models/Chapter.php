<?php 


class Chapter extends Eloquent
{
	protected $fillable = ['title','subject_id'];

	public function subject()
	{
		return $this->belongsTo('Subject');
	}

	public function questions()
	{
		return $this->hasMany('Question');
	}

    public function material()
    {
        return $this->hasMany('StudyMaterial','chapter_id');
    }

}