<?php
namespace admin;
use BaseController;
use Response;
use Attendance;
use Input;
use mngr\Services\SMS\SMSNotifier;
use Manthan\Nuncio\MessengerInterface;
use Config;

class AttendanceController extends BaseController {

  protected $notifier;

  protected $messenger;

  public function __construct(SMSNotifier $notifier, MessengerInterface $messenger)
  {
      $this->notifier  = $notifier;  // For Messages processed by Manthan\Nuncio
      $this->messenger = $messenger; // For Quick Messages
  }

  public function create() {
      $attendance = new Attendance();
      $attendance->date = Input::get('date');
      $attendance->batch_id =  Input::get('batch');
      $attendance->save();
      $students = Input::get('students');
      $this->processStudents($attendance, $students, Input::get('notify'));
      return Response::json(['msg' => 'Successfully Marked Attendance.'], 200);
  }

  private function processStudents($attendance, $students, $notify) {
      $message = "Your ward {{name}} is absent today.";
      if($notify) {
        foreach($students as $student) {
            $attendance->students()->attach($student['id'], array("present" => $student['present']));
            if(!$student['present']) {
              $student = json_decode(json_encode($student), FALSE);
              $this->notifier->from(Config::get('plivo.src'))->to([$student])->send('Attendance', $message);
            }
        }
      }
      else {
        foreach($students as $student) {
            $attendance->students()->attach($student['id'], array("present" => $student['present']));
        }
      }
  }

}



?>
