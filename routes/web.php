<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('landing');
})->name("landing");

// Users
// Auth::routes();

// Have this in case user reloads on login error screen
Route::get("/login", function(){ return redirect("/"); });

Route::post("/login", "LoginController@login")->name("login");
Route::post("/request", "RequestAcctController@newRequest")->name("requestAcct");
Route::post("/password/reset", "PasswordResetController@createAndSendToken")->name("createResetToken");
Route::get("/password/reset/{token}", "PasswordResetController@showResetForm");

Route::get("/logout", "LoginController@logout")->name("logout");

//Have this in case user reloads on new password screen
Route::get("/password/new", function(){ return redirect("/"); });
Route::post("/password/new", "PasswordResetController@doThePWReset")->name("doPWReset");

// Subscribers
Route::post("/subscribe", "SubscribeController@subscribe")->name("subscribe");
Route::post("/unsubscribe", "SubscribeController@unsubscribe")->name("unsubscribe");

// For logged in admins
Route::get('/dashboard', 'HomeController@index')->name('dashboard')->middleware('auth');

Route::get("/alerts", "AlertsController@index")->middleware("auth");

Route::post("/alerts/send", "AlertsController@send")->middleware("auth");
Route::get("/alerts/send", function(){
  return redirect("/alerts");
})->middleware("auth");

Route::get("/history", "HistoryController@index")->middleware("auth");
Route::get("/history/message/{id}", "HistoryController@getMessage");

Route::get("/subscribers", "ManageSubscribersController@index")->middleware("auth");

Route::get("/users", "ManageUsersController@index")->middleware("auth", "checkSuper");

Route::get("/users/profile", "LoginController@profile")->middleware("auth");
Route::post("/users/profile", "LoginController@updateProfile")->middleware("auth");
Route::post("/users/profile/password", "LoginController@changePassword")->middleware("auth");

Route::post("/users/request/accept", "ManageUsersController@acceptRequest")->middleware("auth", "checkSuper");
Route::post("/users/request/deny", "ManageUsersController@denyRequest")->middleware("auth", "checkSuper");

Route::get("/users/setup/{token}", "PasswordResetController@showNewUserForm");
Route::post("/users/setup", "PasswordResetController@setupNewUser");
Route::get("/users/setup", function(){ return redirect("/"); });

Route::post("/users/superness", "ManageUsersController@changeUserLevel")->middleware("auth", "checkSuper");

Route::post("/users/reset", "ManageUsersController@resetPassword")->middleware("auth", "checkSuper");
Route::post("/users/delete", "ManageUsersController@deleteUser")->middleware("auth", "checkSuper");

Route::get("/users/add", "ManageUsersController@getDirectAddForm")->middleware("auth", "checkSuper");
Route::post("/users/add", "ManageUsersController@directAddUser")->middleware("auth", "checkSuper");
