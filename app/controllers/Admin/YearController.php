<?php
namespace Admin;
use BaseController;
use Response;
use Exception;
use Year;
use Input;

class YearController extends BaseController{
    public function getAll() {
        $years = Year::all();
        if(count($years)==0) {
            return Response::json(['msg'=>'You haven\'t added any financial years in the system yet!'],400);
        }
        else {
            return $years;
        }
    }

    public function postAdd() {
        try
        {
            $year = new Year;
            $year->year = Input::get('year');
            $start_year = Input::get('start');
            $year->start_date = $start_year.'/04/01';
            $end_year = Input::get('end');
            $year->end_date = $end_year.'/03/31';
            $year->isCurrent = Input::get('isCurrent');
            if($year->isCurrent == 1) {
                $this->deactivatePrevious();
            }
            if ($year->save()) {
                return Response::json(['msg' => 'Year Successfully Added To The System!'], 200);
            } else {
                return Response::json(['msg' => 'There was an error while adding new financial year. Please Try Again Later.'], 500);
            }
        } catch (Exception $e)
        {
            return Response::json(['msg'=>$e->getMessage()],500);
        }
    }

    public function getDelete($id) {
        $year = Year::where('id',$id)->first();
        if(!isset($year)) {
            throw new Exception('The Year Does Not Exist!');
            return Response::json(['msg'=>'The Year trying to delete does not exit.'],500);
        }
        else {
            $year->delete();
            return Response::json(['msg'=>'Successfully Deleted Year.'],200);
        }
    }

    public function postEdit($id) {
        $year = Year::where('id',$id)->first();
        if(is_null($year)){
            throw new Exception('The Year Doesn\'t Exist!');
            return Response::json(['msg'=>'The year you are trying to edit, doesn\'t exist'],404);
        }
        else {
            $year->year = Input::get('year');
            $year->isCurrent = Input::get('isCurrent');
            if($year->isCurrent == 1) {
                $this->deactivatePrevious();
            }
            $year->save();
            return Response::json(['msg'=>'The Year was successfully edited.'],200);
        }
    }

    public function getCurrent() {
        $year = Year::where('isCurrent',1)->first();
        return $year;
    }
    protected function deactivatePrevious() {
        $year = Year::where('isCurrent',1)->first();
        if(!is_null($year)) {
            $year->isCurrent = 0;
            $year->save();
        }
    }

}
