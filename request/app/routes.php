<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::group(array('before' => 'auth'), function()
{ 
    
    Route::controller('branch_request','BranchRequestController');
    
    Route::get('/',function(){
       return View::make('home'); 
    });
    

});

/* === Route for Request Staff === */  
Route::controller('request_staff','StaffRequestController');
/* === End Route === */

/* === Route for Plan === */  
Route::controller('plan','PlanController');
/* === End Route === */

/* === Route for Item Type === */  
Route::controller('itemtype','ItemtypeController');
/* === End Route === */

/* === Route for Unit === */  
Route::controller('unit','UnitController');
/* === End Route === */


Route::get('logout', function(){
    Auth::logout();
    Session::flush();
    return Redirect::to('login');
});
Route::get('login', function(){
    return View::make('login');
});

Route::post('login', array('before' => 'csrf', function(){
    if(Input::has('login')){
        $user = Input::get('user');
        $password = Input::get('password');
    	if (Auth::attempt(array('user' => $user, 'password' => $password, 'active' => 1)) && Auth::user()->employee->is_deleted==0)
        {
            Session::flash('sms_info', trans('sta.login_success'));
            return Redirect::to('/');
        }else{
            Session::flash('sms_error', trans('sta.login_fail'));
            Auth::logout();
            return Redirect::to('login');
        }
    }
}));
Route::get('error', function(){
    return "Connect to database error " . mysqli_error();
});


/* Test one 1 */