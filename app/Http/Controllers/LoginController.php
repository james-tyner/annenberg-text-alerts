<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    // public function index(){
    //   return view("login");
    // }

    public function login(){
      $loginWasSuccessful = Auth::attempt([
        "email" => request("adminEmail"),
        "password" => request("adminPass")
      ]);

      if ($loginWasSuccessful){
        return redirect("/dashboard");
      } else {
        return view('landing', [
          "message" => "You couldn’t be logged in for some reason… sorry!",
          "status" => "danger"
        ]);
      }
    }

    public function logout(){
      Auth::logout();
      return redirect("/"); // back to landing
    }
}
