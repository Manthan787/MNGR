<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth.student', function()
{
	if(Auth::check() && Auth::user()->isStudent())
    {
        return Redirect::to('/desk');
    }
});

Route::filter('teacher',function(){

	if(Auth::check())
	{
		if(! (Auth::user()->isAdmin() | Auth::user()->isTeacher()))
			return Response::json(['msg' => 'You do not have enough privileges to access this page. ',
								   'redirect' => '/'],401);
	}
	else
	{

		return Response::json(['msg' => 'You need to login to access this page!',
								   'redirect' => 'login'],401);
	}

});

Route::filter('student',function(){

    if(Auth::check())
    {
        if(!Auth::user()->isStudent())
            return Redirect::to('/desk/login')->with('message','You don\'t have enough privileges to view this page.');
    }
    else
    {
        return Redirect::to('/desk/login')->with('message','You need to login to access the desk.');
    }

});

Route::filter('admin',function(){
	if(Auth::check())
	{
		if(!Auth::user()->isAdmin())
		{
			return Response::json(['msg' => 'You do not have enough privileges to access this page.',
									'redirect'=>'/'],401 );
		}
	}
	else
	{
		return Response::json(['msg' => 'You need to login to access this page!',
								   'redirect' => 'login'],401);
	}
});

Route::filter('hasAccessToAdminPanel',function(){
    if(Auth::check())
    {
        if(!Auth::user()->hasAccessToAdminPanel())
        {
            return Redirect::to('/');
        }
    }
    else
    {
        return Redirect::to('/admin/login');
    }
});

Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() !== Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
