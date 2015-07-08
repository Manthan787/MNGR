<?php
namespace mngr\Services\Scrutineer;
use mngr\Services\Scrutineer\Report as Report;
class Scrutineer
{
    protected $questions;
    protected $report;
    public function __construct(Report $report)
    {
        $this->report = $report;
    }
    public function make($questions)
    {
        $this->questions = $questions;
        return $this;
    }

    public function scrutinize()
    {
        $this->categorize();
        return $this->report->toJson();
    }

    protected function categorize()
    {
        $unattempted = array();
        $incorrect = array();
        $correct = array();
        foreach($this->questions as $question)
        {
            if($this->is_unattempted($question))
            {
                $unattempted[] = $question;
            }
            else
            {
                if($this->is_correct($question))
                {
                    $correct[] = $question;
                }
                else
                {
                    $incorrect[] = $question;
                }
            }
        }
        $this->prepareReport($unattempted, $incorrect, $correct);
    }

    protected function prepareReport($unattempted, $incorrect, $correct)
    {
        $this->report->setUnattempted($unattempted);
        $this->report->setIncorrect($incorrect);
        $this->report->setCorrect($correct);
        $this->report->setTotal(count($this->questions));
        $this->report->setMarks(count($correct));
    }
    protected function is_unattempted($question)
    {
        if ($question['attempted_answer'] == 0)
        {
            return true;
        }
            return false;
    }

    protected function is_correct($question)
    {
        if($question['attempted_answer'] == $question['answer']['option_id'])
        {
            return true;
        }
        return false;
    }

} 