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
Route::post("/login", "LoginController@login")->name("login");
Route::post("/request", "RequestAcctController@newRequest")->name("requestAcct");

// Subscribers
Route::post("/subscribe", "SubscribeController@subscribe")->name("subscribe");
Route::post("/unsubscribe", "SubscribeController@unsubscribe")->name("unsubscribe");

// For logged in admins
Route::get('/dashboard', 'HomeController@index')->name('dashboard')->middleware('auth');
