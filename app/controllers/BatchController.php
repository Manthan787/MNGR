<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 04/07/15
 * Time: 8:16 PM
 */

class BatchController extends BaseController {

    public function getAll()
    {
        return Batch::all();
    }

    public function postAdd()
    {
        try {
            $batch = new Batch;
            $batch->name = Input::get('name');
            $batch->standard_id = Input::get('standard_id');
            $batch->save();
            $timings = Input::get('timings');
            foreach ($timings as $timing) {
                $t = new Timing;
                $t->day = $timing['day'];
                $t->from = date('H:i', strtotime($timing['from']));
                $t->to = date('H:i', strtotime($timing['to']));
                $t->batch_id = $batch->id;
                $t->save();
            }
            return Response::json(['msg' => 'Successfully Added Batch To The System!'], 200);
        }
        catch (Exception $e)
        {
            return Response::json(['msg'=>$e],500);
        }
    }
} 