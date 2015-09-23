<?php
namespace Desk\Controller;
use BaseController;
use View;
use Input;
use Validator;
use Redirect;
use Auth;
use Session;
class Dashboard extends BaseController {
    public function getIndex()
    {
        return View::make('Desk.Dashboard.index');
    }

    public function getProfile()
    {
        return View::make('Desk.Dashboard.profile');
    }

    public function getChangePassword()
    {
        return View::make('Desk.Dashboard.change-password');
    }

    public function postChangePassword()
    {
        $messages = array(
            'new.required' => 'We need to know your new password in order to change your existing password',
            'new_again.required' => 'It is necessary to Re-Enter your new password to perform this task',
            'same' => 'Both of the password fields don\'t match'
        );
        $validator = Validator::make(Input::get(),array('new' => 'required', 'new_again' => 'required|same:new'), $messages);
        if($validator->passes())
        {
            $password = Input::get('new');
            $user = Auth::user();
            $user->password = $password;
            $user->temp_password = 0;
            $user->save();
            Session::flash('success', 'Successfully changed your password. Use this new password to login to this account from now on!');
            return Redirect::back();
        }
        else
        {
            return Redirect::back()->withErrors($validator);
        }
    }
}
