<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Hash;
use Validator;
use App\User;
use App\Mail\PWResetEmail;

class PasswordResetController extends Controller
{
  public function createAndSendToken(Request $request)
  {
    $this->validate($request, [
      'resetEmail' => 'required|email|exists:users,email'
    ], [
     'resetEmail.required' => 'You need to enter your email address.',
     'resetEmail.email' => 'That doesn’t look like a valid email address.',
     'resetEmail.exists' => 'There isn’t an account with that email address.'
    ]);

    $user = User::where('email', $request->resetEmail)->firstOrFail();
    $userName = $user->fname;
    $userEmail = $user->email;

    $token = bin2hex(random_bytes(20));

    //create a new token to be sent to the user.
    DB::table('password_resets')->insert([
      'email' => $user->email,
      'token' => $token,
      'created_at' => date("Y-m-d h:i:s")
    ]);

    $resetLink = $request->root() . "/password/reset/" . $token;

    $data = [
      'resetLink' => $resetLink,
      'userName' => $userName
    ];

    Mail::to($userEmail)->send(new PWResetEmail($data));
  }

  public function showResetForm($token)
  {
    $tokenData = DB::table('password_resets')
    ->where('token', $token)->first();

    if ( !$tokenData ){
      return view('admin_landing', [
        "message" => "Sorry, that password reset request wasn’t valid. Try requesting a new password again.",
        "status" => "danger"
      ]);
    }

    return view('password_reset', [
      'token' => $token
    ]);
  }

  public function doThePWReset(Request $request){

    $password = $request->resetPassword;
    $tokenData = DB::table('password_resets')
    ->where('token', $request->token)->first();

    $user = User::where('email', $tokenData->email)->first();
    if (!$user || !isset($user)){
      return view('landing', [
        "message" => "Sorry, that password reset request wasn’t valid. Try requesting a new password again.",
        "status" => "danger"
      ]);
    }

    $user->password = Hash::make($password);
    $user->update();

    DB::table('password_resets')->where('email', $user->email)->delete();

    return view('admin_landing', [
      "message" => "Your password is reset. Try to log in now.",
      "status" => "success"
    ]);
  }

  public function showNewUserForm($token){
    $tokenData = DB::table('password_resets')
    ->where('token', $token)->first();

    if ( !$tokenData ){
      return view('admin_landing', [
        "message" => "Sorry, that password reset request wasn’t valid. Try requesting a new password again.",
        "status" => "danger"
      ]);
    }

    return view('users.new_user', [
      'token' => $token
    ]);
  }

  public function setupNewUser(Request $request){

    $password = $request->resetPassword;
    $phoneNumber = $request->phoneNumber;

    $tokenData = DB::table('password_resets')
    ->where('token', $request->token)->first();

    $user = User::where('email', $tokenData->email)->first();
    if (!$user || !isset($user)){
      return view('admin_landing', [
        "message" => "Sorry, that password reset request wasn’t valid. Try requesting a new password again.",
        "status" => "danger"
      ]);
    }

    $user->password = Hash::make($password);
    $user->phone = $phoneNumber;
    $user->update();

    DB::table('password_resets')->where('email', $user->email)->delete();

    return view('admin_landing', [
      "message" => "Your new account is set up. Try to log in now.",
      "status" => "success"
    ]);
  }
}
