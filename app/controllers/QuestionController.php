<?php 

use mngr\Repositories\Questions\QuestionsRepository;
use mngr\Exceptions\QuestionNotFoundException;

class QuestionController extends BaseController
{

	public function __construct(QuestionsRepository $question)
	{
		$this->question = $question;
	}


	public function getAll()
	{
		$allQuestions = $this->question->getAll();
		
		return Response::json($allQuestions, 200);
	}

	public function getById($id)
	{
		try
		{
			$question = $this->question->getById($id);
			return Response::json($question, 200);
		}
		catch(QuestionNotFoundException $e)
		{
			Log::error("Question Not Found:".$e->getMessage());
			return Response::json(['msg'=>'Looks like the question you are requesting, does not exist!',
									'redirect'=>'/'],404);
		}
	}

	public function postQuestion()
	{
		//return Response::json(Input::get('options'));
		$question = new Question();
		$question->question = Input::get('question');
		$question->save();
		$options = Input::get('options');
		try{

			foreach($options as $option)
			{
				$o = new Option();
				$o->option = $option['option'];
				$o->question_id = $question->id;
				$o->save();
			}
		}
		catch (Exception $e){
			return Response::json($e->getLine(),400);
		}
	}

 
}