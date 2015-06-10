<?php

class Question extends Eloquent
{
	protected $fillable = ['question','answer_id','user_id','subject_id','chapter_id'];

	public function options()
	{
		return $this->hasMany('Option');
	}

	public function chapter()
	{
		return $this->belongsTo('Chapter');
	}

	public function answer()
	{
		foreach($this->options as $option)
		{
			if ($option->answer)
				return $option;
		
		}
	}

    public function deleteOptions()
    {
        foreach($this->options as $option)
        {
            $option->delete();
        }
    }
}