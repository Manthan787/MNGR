<?php
namespace Desk\Controller;
use BaseController;
use View;
use mngr\Services\Mail\Notifier;
use Input;
use Student;
use User;

class Auth extends BaseController{
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
            //Add entry to USER table
            $password = \Str::random(8);
            $email = $student->email;
            $v = \Validator::make(array('email'=> $email),array('email'=>'unique:users'));
            if($v->fails())
            {
                return \Redirect::back()->with('error','The student account with this email ID has already been activated!');
            }
            else
            {
                $user = new User;
                $user->email = $student->email;
                $user->temp_password = 1;
                $user->password = $password;
                $user->student_id = $student->id;
                $user->role_id = 4;
                $user->save();

                $data = array(
                    'name' => $student->name,
                    'password' => $password
                );
                $this->notifier->from('manthant15@gmail.com')->to($student->email)->notify('EmailNotification.activate',$data);
                return \Redirect::back()->with('success','Your account has been activated. Check your email!');
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
} 