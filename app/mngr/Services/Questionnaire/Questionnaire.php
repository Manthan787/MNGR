<?php
namespace mngr\Services\Questionnaire;
use \mngr\Exceptions\QuestionnaireLimitMismatchException as QuestionnaireLimitMismatchException;

class Questionnaire implements QuestionnaireInterface {
    protected $chapters = array();
    protected $limit;
    protected $indices;
    public function make(array $chapters)
    {
        $this->chapters = $chapters;
        return $this;
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function generate()
    {
        $questions = $this->gatherQuestions();
        if(count($questions) < $this->limit)
        {
            throw new QuestionnaireLimitMismatchException("Limit exceeds number of questions.");
        }
        else
        {
            $indices = array_rand($questions, $this->limit);
            return $this->getIDsFromIndices($indices, $questions);
        }

    }

    protected function getIDsFromIndices($indices, $questions)
    {
        $IDs = array();
        foreach($indices as $index)
        {
            $IDs[] = $questions[$index]->id;
        }
        return $IDs;
    }

    protected function gatherQuestions()
    {
        return \DB::table('questions')->whereIn('chapter_id',$this->chapters)->get();
    }
}
