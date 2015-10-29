<?php


class Subject extends Eloquent
{
	protected $fillable=['name'];

	public function teachers()
	{
		return $this->belongsToMany('User');
	}

	public function chapters()
	{
		return $this->hasMany('Chapter');
	}

    public function materials()
    {
        return $this->hasManyThrough('StudyMaterial', 'Chapter', 'subject_id', 'chapter_id');
    }

	public function questions()
	{
		return $this->hasManyThrough('Question','Chapter','subject_id','Chapter_id');
	}

	public function standard()
	{
		return $this->belongsTo('Standard');
	}

	public function streams()
	{
		return $this->belongsToMany('Stream');
	}

	public function tests()
	{
		return $this->hasMany('Test');
	}


}
