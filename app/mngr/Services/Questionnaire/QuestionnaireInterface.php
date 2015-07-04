<?php
namespace mngr\Services\Questionnaire;

interface QuestionnaireInterface {
    public function make(array $chapters);
    public function setLimit($limit);
    public function generate();
}