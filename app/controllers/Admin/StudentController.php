<?php
namespace Admin;
use BaseController;
use Response;
use Input;
use Student;
use Validator;
use Exception;

class StudentController extends BaseController
{
	public function getAll()
	{
		return Student::with(['standard','stream'])->get();
	}

	public function postStudent()
	{
		$student = new Student();
		$validator = Validator::make(Input::get(),['email' => 'unique:students']);
		if($validator->passes())
		{
			$student->name              = Input::get('name', false);
			$student->address           = Input::get('address', false);
			$student->birthdate         = Input::get('birthdate', false) ;
			$student->standard_id       = Input::get('standard')['id'];
			$student->stream_id         = Input::get('stream')['id'];
			$student->email             = Input::get('email', false);
			$student->city              = Input::get('city', false);
			$student->phone             = Input::get('phone');
			$student->school            = Input::get('school') ? Input::get('school') : "";
			$student->parents_mobile    = Input::get('parents_mobile', false);
			$student->student_mobile    = Input::get('student_mobile', false);
			$student->medium_id         = Input::get('medium')['id'];
	    $student->fees              = Input::get('fees')? Input::get('fees'): "";
	    $student->entry_date        = Input::get('entry_date');
	    $student->year_id           = Input::get('year_id');
			$student->save();
	    //Attaching Subjects To Student
	    $subjects = $this->getObjectsArray(Input::get('subjects'));
	    $student->subjects()->attach($subjects);
	    if($batches = Input::get('batches'))
	    {
	        $student->batches()->attach($batches);
	    }
			return Response::json(['msg'=>'Successfully Added Student To The System!'],200);
		}
		else {
			return Response::json(['msg'=>'This Email is already assigned to some other student. Use a unique Email address.'], 500);
		}

	}

    protected function getObjectsArray($objects)
    {
        $array = array();
        $i = 0;
        foreach($objects as $object)
        {
            $array[$i] = $object['id'];
            $i++;
        }
        return $array;
    }

    public function delete($studentID)
    {
        if($student = Student::find($studentID))
        {
            $student->subjects()->detach();
            $student->delete();
						// Also DELETE corresponding user entry
						if($student->isActivated())
						{
							$student->getCorrespondingUser()->delete();
						}
            return Response::json(['msg' => 'Successfully Deleted Student From The System!'], 200);
        }
        else
        {
            return Response::json(['msg'=>'The Student You Are Trying To Delete Does Not Exist!'], 404);
        }
    }

    public function getById($studentID)
    {
       return Student::with(['standard', 'stream', 'subjects','medium','batches'])->find($studentID);
    }

    public function update($studentID)
    {
        try {
            if ($student = Student::find($studentID)) {
                $student->name = Input::get('name', false);
                $student->address = Input::get('address', false);
                $student->birthdate = Input::get('birthdate', false);
                $student->standard_id = Input::get('standard')['id'];
                $student->stream_id = Input::get('stream')['id'];
                $student->email = Input::get('email', false);
                $student->city = Input::get('city', false);
                $student->phone = Input::get('phone');
                $student->school = Input::get('school') ? Input::get('school') : "";
                $student->parents_mobile = Input::get('parents_mobile', false);
                $student->student_mobile = Input::get('student_mobile', false);
                $student->medium_id = Input::get('medium')['id'];
                $student->fees = Input::get('fees') ? Input::get('fees') : "";
                $student->entry_date = Input::get('entry_date');
                $student->year_id = Input::get('year_id');
                $student->save();
                //Syncing Subjects
                $subjects = $this->getObjectsArray(Input::get('subjects'));
                $student->subjects()->sync($subjects);
                //Syncing Batches
                if ($batches = Input::get('batches')) {
                    $student->batches()->sync($this->getObjectsArray($batches));
                }
                return Response::json(['msg' => 'Successfully Updated Student!'], 200);
            }
        } catch(Exception $e)
        {
            return Response::json($e);
        }
    }
}
