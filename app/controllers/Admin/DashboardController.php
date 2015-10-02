<?php
namespace Admin;
use BaseController;
use Response;
use Student;
use User;
use Question;

class DashboardController extends BaseController{

    public function getStats() {
        $student_count = count(Student::all());
        $staff_count = count(User::all());
        $question_count = count(Question::all());
        $test_count = 40;
        return Response::json(
            [
                'student_count' => $student_count,
                'staff_count'   => $staff_count,
                'question_count'=> $question_count,
                'test_count'    => $test_count
            ],200);
    }
}
