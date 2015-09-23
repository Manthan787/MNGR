<?php

class AuthController extends BaseController{

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
}
