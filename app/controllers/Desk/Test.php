<?php
namespace Desk\Controller;
use BaseController;
use View;
use mngr\Services\Questionnaire\QuestionnaireInterface as Questionnaire;
use mngr\Exceptions\QuestionnaireLimitMismatchException;
use mngr\Services\Scrutineer\Scrutineer as Scrutineer;
use Input;
use Question;
use Response;
class Test extends BaseController{
    protected $questionnaire;
    protected $scrutineer;
    public function __construct(Questionnaire $questionnaire, Scrutineer $scrutineer)
    {
        $this->questionnaire = $questionnaire;
        $this->scrutineer = $scrutineer;
    }
    public function getPractice()
    {
        return View::make('Desk.Dashboard.test');
    }

    public function generatePractice()
    {
        $marks = Input::get('marks');
        $subject_id = Input::get('subject_id');
        $chapters = Input::get('chapters');
        try {
            $questionIDs = $this->questionnaire->make($chapters)->setLimit($marks)->generate();
            return Question::with(['options','answer'])->findMany($questionIDs);
        }
        catch(QuestionnaireLimitMismatchException $e)
        {
            return Response::json(['msg'=>'There are not enough questions in the system to generate test. Please try again later.'],500);
        }
    }

    public function postAssess()
    {
        $questions = Input::get();
        $report = $this->scrutineer->make($questions)->scrutinize();
        return $report;
    }
} 