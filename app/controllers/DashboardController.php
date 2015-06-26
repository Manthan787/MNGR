<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 26/06/15
 * Time: 9:27 PM
 */

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