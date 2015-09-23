<?php

class MaterialController extends BaseController{

    public function add()
    {
        try {
            $material = new StudyMaterial;
            $material->topic = Input::get('topic');
            $material->text = Input::get('text');
            $material->chapter_id = Input::get('chapter_id');
            $material->save();
            return Response::json(['msg' => 'Successfully Added This Topic To The System'], 200);
        }
        catch(Exception $e)
        {
            return Response::json($e->getMessage());
        }
    }

    public function getRecent()
    {
        return StudyMaterial::orderBy('created_at', 'DESC')->with(['chapter'])->get()->take(10);
    }

    public function getById($id)
    {
        return StudyMaterial::find($id);
    }

    public function edit($id)
    {
        $material = StudyMaterial::find($id);
        try {
            $material->topic = Input::get('topic');
            $material->text = Input::get('text');
            $material->chapter_id = Input::get('chapter_id');
            $material->save();
            return Response::json(['msg' => 'Successfully Edited This Topic'], 200);
        }
        catch(Exception $e)
        {
            return Response::json($e->getMessage());
        }
    }

    public function delete($id)
    {
        $material = StudyMaterial::find($id);
        $material->delete();
        return Response::json(['msg'=>'Successfully Deleted Material!'],200);
    }
}
