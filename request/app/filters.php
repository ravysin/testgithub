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

Route::filter('auth', function()
{
    $lang = Session::get('lang');
    if($lang=='en'||$lang=='kh')
        App::setLocale($lang);
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		return Redirect::guest('login');
	}
    
    // Check permission to access each module
    $per_a = UserController::set_permission();
    // If user no permission to access this link, system will redirect to Old URL
    if($per_a['can_' . $per_a['roll']]!=1){
        Session::flash('sms_warn',trans('sta.no_permission'));
        // If Old request can not access, system will redirect to Logout page.
        if(Session::get('count_r')==1){
            // Count the number of request that faild.
            Session::put('count_r',Session::get('count_r')+1);
            return Redirect::to(Session::get('url'));
        }else{
            Auth::logout();
            return Redirect::to('login');
        }
        
    }else{
        Session::put('url',Request::path());
        Session::put('count_r',1);
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
