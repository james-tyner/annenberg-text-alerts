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
});

// Users
Auth::routes();
Route::post("/request", "RequestController@index")->name("request");

// Subscribers
Route::post("/subscribe", "SubscribeController@index")->name("subscribe");
Route::post("/unsubscribe", "SubscribeController@unsubscribe")->name("unsubscribe");

// For logged in admins 
Route::get('/dashboard', 'HomeController@index')->name('dashboard');
