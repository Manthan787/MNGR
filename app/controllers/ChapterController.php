<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 18/05/15
 * Time: 1:32 PM
 */

class ChapterController extends BaseController{

    public function getAll()
    {
        return Chapter::all();
    }

    public function postChapter()
    {
        $chapter = new Chapter();
        $chapter->title = Input::get('title');
        $chapter->subject_id = Input::get('subject_id');
    }
} 