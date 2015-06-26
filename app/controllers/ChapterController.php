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
        $chapter->save();
        return Response::json(['msg'=>'Chapter Successfully Added To The System!'],200);
    }

    public function getDelete($id) {
        $chapter = Chapter::where('id',$id)->first();
        if(!is_null($chapter)) {
            $chapter->delete();
        }
        else {
            throw new Exception('The Chapter Doesn\'t exist');
            return Response::json(['msg'=>'The chapter you\'re trying to delete doesn\'t exist'],404);
        }
    }

    public function postEdit($id) {
        $chapter = Chapter::where('id',$id)->first();
        if(!is_null($chapter)) {
            $chapter->title = Input::get('title');
            $chapter->subject_id = Input::get('subject_id');
            $chapter->save();
        }

    }
} 