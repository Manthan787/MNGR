<?php
namespace mngr\Services\Scrutineer;

class Report
{
    protected $marks;
    protected $total;
    protected $correct = array();
    protected $incorrect = array();
    protected $unattempted = array();

    /**
     * @return array
     */
    public function getCorrect()
    {
        return $this->correct;
    }

    /**
     * @param array $correct
     */
    public function setCorrect($correct)
    {
        $this->correct = $correct;
    }

    /**
     * @return array
     */
    public function getIncorrect()
    {
        return $this->incorrect;
    }

    /**
     * @param array $incorrect
     */
    public function setIncorrect($incorrect)
    {
        $this->incorrect = $incorrect;
    }

    /**
     * @return mixed
     */
    public function getMarks()
    {
        return $this->marks;
    }

    /**
     * @param mixed $marks
     */
    public function setMarks($marks)
    {
        $this->marks = $marks;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @return array
     */
    public function getUnattempted()
    {
        return $this->unattempted;
    }

    /**
     * @param array $unattempted
     */
    public function setUnattempted($unattempted)
    {
        $this->unattempted = $unattempted;
    }

    public function toJson()
    {
        return json_encode(get_object_vars($this));
    }
} 