<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use Validator;
use App\User;

class LoginController extends Controller
{
    public function login(){
      $loginWasSuccessful = Auth::attempt([
        "email" => request("adminEmail"),
        "password" => request("adminPass")
      ]);

      if ($loginWasSuccessful){
        return redirect("/dashboard");
      } else {
        return view('admin_landing', [
          "message" => "You couldn’t be logged in for some reason… sorry!",
          "status" => "danger"
        ]);
      }
    }

    public function logout(){
      Auth::logout();
      return redirect("/"); // back to landing
    }

    public function profile(){
      return view("users.profile");
    }

    public function updateProfile(Request $request){
      $input = $request->all();
      $validation = Validator::make($input, [
        'fname' => 'required',
        'lname' => 'required',
        'email' => 'required|email',
        'phone' => 'required|digits:10|unique:users,phone'
      ], [
       'required' => 'Every field is required.',
       'phone.unique' => 'An account has already been made with this phone number.',
       'phone.digits' => 'You have to enter a US or Canadian phone number of exactly 10 digits.'
      ]);

      //if validation fails, redirect back to form with an error message
      if ($validation->fails()){
        return redirect()->back()
          ->withErrors($validation)
          ->withInput();
      }

      $thisUser = User::where('id', Auth::user()->id);

      $thisUser->fname = $request->fname;
      $thisUser->lname = $request->lname;
      $thisUser->email = $request->email;
      $thisUser->phone = $request->phone;

      $thisUser->save();

      return redirect("/dashboard")->with("dashMessage", "Your profile was successfully updated.");
    }

    public function changePassword(Request $request){
      $storedCurrentPassword = Auth::user()->password;

      if (Hash::check($request->oldPassword, $storedCurrentPassword)){
        $thisUser = User::where('id', Auth::user()->id)->first();
        $thisUser->password = Hash::make($request->newPassword);
        $thisUser->save();

        return redirect("/dashboard")->with("dashMessage", "Your password was successfully changed.");
      } else {
        return redirect()->back()->with(
          "passwordError", "The password you entered doesn’t match your current password."
        );
      }
    }
}
