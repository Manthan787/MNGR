<?php namespace mngr\Services\Forms\Question;

use mngr\Services\Validation\ValidableInterface;
use mngr\Repositories\Questions\QuestionsRepository;

class AddQuestionForm
{
	public function __construct(ValidableInterface $validator, QuestionsRepository $question)
	{
		$this->validator = $validator;
		$this->question = $question;
	}


}