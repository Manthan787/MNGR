<?php namespace mngr\Repositories\Questions;

use Question;
use mngr\Exceptions\QuestionNotFoundException;

class EloquentQuestionsRepository implements QuestionsRepository
{

	/**
	 * Question Property
	 *
	 */
	protected $question;

	public function __construct(Question $question)
	{
		$this->question = $question;
	}

	public function getAll()
	{
		//Fetch All Questions With Their Options
		return $this->question->with('options','answer')->get();


	}

	public function getById($id)
	{

		if (! is_null($question = $this->findById($id)))
		{
			return $question;
		}

		throw new QuestionNotFoundException("Error finding Question in EloquentQuestionsRepository at getById($id) ");
	}

	public function findById($id)
	{
		return $this->question->with('options', 'answer')->find($id);
	}

	public function add(array $input)
	{

	}

    public function delete($id)
    {
        if(! is_null($question = $this->findById($id)))
        {
            $question->deleteOptions();
            $question->delete();
            return true;
        }

        throw new QuestionNotFoundException("Error finding Question in EloquentQuestionsRepository at getById($id) ");
    }
}
