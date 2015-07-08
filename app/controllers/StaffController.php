<?php

use mngr\Services\Mail\Notifier;

class StaffController extends BaseController{

    protected $notifier;

    public function __construct(Notifier $notifier)
    {
        $this->notifier = $notifier;
    }

    public function add()
    {
        $user = new User;
        $user->firstname = Input::get('firstname');
        $user->lastname = Input::get('lastname');
        $user->role_id = Input::get('role_id');
        $user->email = Input::get('email');
        //generate a password!
        $password = str_random(5);
        $user->password = $password;
        $user->temp_password = Crypt::encrypt($password);
        $user->save();
        if($user->role_id == 2)
        {
            $user->subjects()->attach(Input::get('subjects'));
        }
        $data = array(
            'name' => $user->firstname.' '.$user->lastname,
            'password' => $password
        );
        $this->notifier->to($user->email)->from('manthant15@gmail.com')->subject('You are now the staff Member!')->notify('EmailNotification.staff', $data);
        return Response::json(['msg'=>'Successfully Added Member To The System!'], 200);
    }
} 