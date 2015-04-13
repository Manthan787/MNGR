<?php

class StudentController extends Controller
{
	public function getAll()
	{
		return Student::with(['standard','stream'])->get();
	}

	public function postStudent()
	{
		$student = new Student();

		$student->name              = Input::get('name', false);
		$student->address           = Input::get('address', false);
		$student->birthdate         = Input::get('birthdate', false) ;
		$student->standard_id       = Input::get('standard')['id'];
		$student->stream_id         = Input::get('stream')['id'];
		$student->email             = Input::get('email', false);
		$student->city              = Input::get('city', false);
		$student->phone             = Input::get('phone');
		$student->school            = Input::get('school', false);
		$student->parents_mobile    = Input::get('parent_mobile', false);
		$student->student_mobile    = Input::get('student_mobile', false);
		$student->medium_id         = Input::get('medium')['id'];
        $student->fees              = Input::get('fees');
		$student->save();
        //Attaching Subjects To Student
        $subjects = $this->getSubjectsArray(Input::get('subjects'));
        $student->subjects()->attach($subjects);
		return Response::json(['msg'=>'Successfully Added Student To The System!'],200);
	}

    protected function getSubjectsArray($subjects)
    {
        $array = array();
        $i = 0;
        foreach($subjects as $subject)
        {
            $array[$i] = $subject['id'];
            $i++;
        }
        return $array;
    }

    public function delete($studentID)
    {
        if($student = Student::find($studentID))
        {
            $student->delete();
            return Response::json(['msg' => 'Successfully Deleted Student From The System!'], 200);
        }
        else
        {
            return Response::json(['msg'=>'The Student You Are Trying To Delete Does Not Exist!'], 404);
        }
    }

    public function getById($studentID)
    {
       return Student::with(['standard', 'stream', 'subjects','medium'])->find($studentID);
    }

    public function update($studentID)
    {
        if($student = Student::find($studentID))
        {
            $student->name              = Input::get('name', false);
            $student->address           = Input::get('address', false);
            $student->birthdate         = Input::get('birthdate', false) ;
            $student->standard_id       = Input::get('standard')['id'];
            $student->stream_id         = Input::get('stream')['id'];
            $student->email             = Input::get('email', false);
            $student->city              = Input::get('city', false);
            $student->phone             = Input::get('phone');
            $student->school            = Input::get('school', false);
            $student->parents_mobile    = Input::get('parent_mobile', false);
            $student->student_mobile    = Input::get('student_mobile', false);
            $student->medium_id         = Input::get('medium')['id'];
            $student->fees              = Input::get('fees');
            $student->save();
            //Attaching Subjects To Student
            $subjects = $this->getSubjectsArray(Input::get('subjects'));
            $student->subjects()->sync($subjects);
            return Response::json(['msg'=>'Successfully Updated Student!'],200);
        }
    }
}