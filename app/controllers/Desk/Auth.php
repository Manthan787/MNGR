<?php
namespace Desk\Controller;
use BaseController;
use View;
use mngr\Services\Mail\Notifier;
use Input;
use Student;
use User;
use Config;

class Auth extends BaseController {

    protected $notifier;

    public function __construct(Notifier $notifier)
    {
        $this->notifier = $notifier;
    }

    public function getActivate()
    {
        return View::make('Desk.Auth.activate');
    }

    public function postActivate()
    {
        $email = Input::get('email');
        $student = Student::where('email',$email)->first();
        if($student)
        {
            $email = $student->email;
            $v = \Validator::make(array('email'=> $email),array('email'=>'unique:users'));
            if($v->fails())
            {
                return \Redirect::back()->with('error','The student account with this email ID has already been activated!');
            }
            else
            {
                $password = \Str::random(8);
                $user = new User;
                $user->email = $student->email;
                $user->temp_password = 1;
                $user->password = $password;
                $user->student_id = $student->id;
                $user->role_id = 4;
                $user->save();

                $data = array(
                    'name'     => $student->name,
                    'password' => $password,
                    'base_url' => Config::get('preferences.BASE_URL')
                );

                $this->notifier->from(Config::get('preferences.EMAIL'))
                               ->subject("Student Desk Activation")
                               ->to($student->email)
                               ->notify('EmailNotification.activate',$data);
                return \Redirect::back()->with('message','Your account has been activated. Check your email!');
            }
        }
        else
        {
            return \Redirect::back()->with('error','The email ID is invalid. Please enter the email ID you provided during registration.');
        }
    }

    public function getLogin()
    {
        return View::make('Desk.Auth.login');
    }

    public function postLogin()
    {
        if(\Auth::attempt(['email'=>Input::get('email'),'password'=>Input::get('password')]))
        {
            return \Redirect::to('/desk');
        }
        else
        {
            return \Redirect::back()->with('error','Invalid Email/Password Combination!');
        }
    }

    public function getLogout()
    {
        \Auth::logout();
        return \Redirect::to('/desk/login');
    }

    public function getForgotPassword()
    {
        return View::make('Desk.Auth.forgot');
    }

    public function postForgotPassword()
    {
        $email = Input::get('email');
        $student = Student::where('email', $email)->first();

        if($student)
        {
            $user = User::where('student_id', $student->id)->first();
            if($user) {
              $password = \Str::random(8);

              $user->password      = $password;
              $user->temp_password = 1;
              $user->save();

              $data = array(
                  'name'     => $student->name,
                  'password' => $password,
                  'base_url' => Config::get('preferences.BASE_URL')
              );

              $this->notifier->from(Config::get('preferences.EMAIL'))
                             ->subject("Password Reset")
                             ->to($student->email)
                             ->notify('EmailNotification.forgot',$data);
              return \Redirect::back()->with('message','Password for your Student Desk account has been reset. You will shortly receive the newly generated password via email.');
          }
          else {
              return \Redirect::back()->with('error', 'This account has not been activated yet!');
          }
        }
        else {
            return \Redirect::back()->with('error', 'Invalid Email ID. Please enter correct Email!');
        }
    }
}
