<?php
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
            $test->save();
            $test->questions()->attach($questions);
            return Response::json(['msg'=>'Successfully Generated Test.','redirect'=>'back/tests/'.$test->id.'/show'],200);
        }
        catch(QuestionnaireLimitMismatchException $e)
        {
            \Log::error('Error occurred while generating questionnaire.');
            return Response::json(['msg'=>'There are not enough questions in the system to generate test. Please add sufficient amount of questions first and then try again.'],500);
        }

    }

    public function show($id) {
        if($test = Test::find($id))
        {
            $questions = $test->questions()->with('options')->get();
            return PDF::load(View::make('Question.Questionnaire')->with('questions',$questions)->with('test',$test))->show();
        }
        else
        {
            return Redirect::to('/');
        }
    }
} 