<?php
namespace Admin;
use BaseController;
use Response;
use Input;
use Exception;
use Test;
use Log;
use PDF;
use Redirect;
use View;
use mngr\Services\Questionnaire\QuestionnaireInterface as Questionnaire;
use mngr\Exceptions\QuestionnaireLimitMismatchException;

class TestController extends BaseController{
    protected $questionnaire;
    public function __construct(Questionnaire $questionnaire)
    {
        $this->questionnaire = $questionnaire;
    }
    public function create()
    {
        try
        {
            $chapters = Input::get('chapters');
            $marks = Input::get('marks');
            $questions = $this->questionnaire->make($chapters)->setLimit($marks)->generate();
            $test = new Test;
            $test->name = Input::get('name');
            $test->subject_id = Input::get('subject_id');
            $test->marks = $marks;
            $test->is_online = Input::get('is_online');
            $test->layout = Input::get('layout');
            $test->save();
            $test->questions()->attach($questions);
            return Response::json(['msg'=>'Successfully Generated Test.','redirect'=>'tests/'.$test->id.'/show'],200);
        }
        catch(QuestionnaireLimitMismatchException $e)
        {
            Log::error('Error occurred while generating questionnaire.');
            return Response::json(['msg'=>'There are not enough questions in the system to generate test. Please add sufficient amount of questions first and then try again.'],500);
        }
    }

    public function show($id) {
        if($test = Test::find($id))
        {
            $questions = $test->questions()->with('options')->get();
            return View::make('Question.Questionnaire')->with('questions',$questions)->with('test',$test);
        }
        else
        {
            return Redirect::to('/');
        }
    }

    public function showAnswerSheet($id) {
      if($test = Test::find($id))
      {
          $questions = $test->questions()->with(['options', 'answer'])->get();
          $answers = [];
          foreach($questions as $i => $question)
          {
              foreach($question->options as $index => $option)
              {
                  if($option->id == $question->answer->option_id)
                      $answers[$i] = $index;
              }
          }
          return View::make('Question.AnswerSheet')->with('answers', $answers)->with('test', $test);
      }
      else
      {
          return Redirect::to('/');
      }
    }

    public function getAll() {
        $tests = Test::with(['subject'])->paginate(10);
        return $tests;
    }

    public function delete($testID) {
        $test = Test::find($testID);
        if($test) {
            $test->questions()->detach();
            $test->delete();
            return Response::json(['msg' => 'Successfully Deleted Test From The System.'], 200);
        }
    }
}
