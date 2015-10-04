<?php
namespace Admin;
use BaseController;
use Response;
use Input;
use mngr\Repositories\Questions\QuestionsRepository;
use mngr\Exceptions\QuestionNotFoundException;
use Question;
use Option;
use Answer;

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
		$question = new Question();
		$question->question = Input::get('question');
    $question->chapter_id = Input::get('chapter_id');
		$question->save();
    $options = Input::get('options');
		try{

			foreach($options as $option)
			{
				$o = new Option();
				$o->option = $option['option'];
				$o->question_id = $question->id;
				$o->save();
                if($option['answer']) {
                    $answer = new Answer;
                    $answer->option_id = $o->id;
                    $answer->question_id = $question->id;
                    $answer->save();
                }
			}
		}
		catch (Exception $e){
			return Response::json($e->getLine(),400);
		}

        return Response::json(['msg'=>'Question Successfully Added!'], 200);
	}

    public function editQuestion($id)
    {
        try {
            $theQuestion = $this->question->getById($id);
            return $theQuestion;
            $theQuestion->question = Input::get('question');
            $theQuestion->chapter_id = Input::get('chapter_id');
            $theQuestion->save();

            $options = Input::get('options');
            try{
                $index = 0;
                $currentOptionCount = count($theQuestion->options);
                foreach($options as $option)
                {
                    if($index < $currentOptionCount)
                    {
                        $o = $theQuestion->options[$index];
                        $o->option = $option['option'];
                        $o->answer = $option['answer'];
                        $o->save();
                        $index++;
                    }
                    else
                    {
                        $o = new Option();
                        $o->option = $option['option'];
                        $o->question_id = $theQuestion->id;
                        $o->answer = $option['answer'];
                        $o->save();
                    }
                }
            }
            catch (Exception $e){
                return Response::json($e->getLine(),400);
            }

            return Response::json(['msg'=>'Question Successfully Edited!'], 200);

        }
        catch(QuestionNotFoundException $e) {
            return Response::json(['msg'=>'The Question You are trying to edit does not exist'],404);
        }

    }

    public function delete($id)
    {
        try {
            $this->question->delete($id);
            return Response::json(['msg'=>'Successfully Deleted Question.'],200);
        }
        catch (QuestionNotFoundException $e) {
            return Response::json(['msg'=>'The Question you are trying to delete, does not exist!'],404);
        }
    }
}
