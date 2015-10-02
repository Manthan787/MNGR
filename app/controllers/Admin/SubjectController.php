<?php
namespace Admin;
use Subject;
use Input;
use Exception;
use BaseController;
use Auth;

class SubjectController extends BaseController {

    public function all() {
      $user = Auth::user();
      if($user->isTeacher()) {
          return $user->subjects()->with(['chapters','standard','streams'])->get();
      }
      else {
          return Subject::with(['chapters','standard','streams'])->get();
      }

    }
}

?>
