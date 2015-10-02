<?php
namespace Admin;
use BaseController;
use Response;
use Auth;
use Input;
use View;


class AuthController extends BaseController{

    public function getLogin()
    {
      return View::make('Admin.login');
    }

    public function login()
    {
        $credentials = array(
            'email' => Input::get('email'),
            'password' => Input::get('password')
        );

        if(Auth::attempt($credentials))
        {
            if(Auth::user()->isAdmin() || Auth::user()->isTeacher()) {
              return Response::json(['data'=>Auth::user(), 'msg'=>'Successfully Logged In!'], 200);
            }
            else {
              Auth::logout();
              return Response::json(['msg' => 'You don\'t have enough privileges to access Admin Panel'], 403);
            }
        }
        else
        {
            return Response::json(['msg'=>'Incorrect Credentials.'], 401);
        }

        return Response::json(['shit'=>'happened'], 400);
    }

    public function logout()
    {
        Auth::logout();
    }

    public function changePassword()
    {
        $newPassword = Input::get('new');

        try {
          $user = Auth::user();
          $user->password = $newPassword;
          $user->save();
          return Response::json(['msg' => 'Your password has been changed. Use the new password to login from now onwards!'], 200);
        }
        catch (Exception $e) {
          return Response::json(['msg' => 'There was an error while changing your password. Please try again.'], 500);
        }
    }
}
