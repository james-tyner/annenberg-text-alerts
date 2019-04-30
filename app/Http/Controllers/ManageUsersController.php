<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserRequest;
use App\Mail\PWResetEmail;
use App\Mail\RequestAccepted;
use App\Mail\RequestRejected;
use Validator;
use DB;
use Mail;

class ManageUsersController extends Controller
{
    public function index(){
      $users = User::all();
      $requests = UserRequest::all();

      return view("users.users", [
        'users' => $users,
        'requests' => $requests,
        'userMessage' => ""
      ]);
    }

    public function acceptRequest(Request $request){

      // check to see if user was previously deleted — if so, reactivate the old one rather than create a new one in order to avoid duplicate unique email addresses
      $checkPast = User::onlyTrashed()->where('email', $request->request_email)->get();

      if(sizeof($checkPast) > 0){
        // restore the previous account
        $checkPast[0]->restore();

        // delete the request for a new one
        UserRequest::where('email', $request->request_email)->firstOrFail()->delete();

        return redirect()->back()->with([
          'userMessage' => $checkPast[0]->fname . " " . $checkPast[0]->lname . " had an account before. That account has been restored with its previous password and phone number."
        ]);
      } else {
        $newUser = new User;

        $newUser->fname = $request->request_fname;
        $newUser->lname = $request->request_lname;
        $newUser->email = $request->request_email;

        // these will go through without validation. User is expected to change them immediately
        $newUser->password = "00";
        $newUser->phone = 0;
        $newUser->super = false;

        $newUser->save();

        // GO THROUGH THE PASSWORD RESET PROCESS
        $token = bin2hex(random_bytes(20));

        //create a new token to be sent to the user.
        DB::table('password_resets')->insert([
          'email' => $request->request_email,
          'token' => $token,
          'created_at' => date("Y-m-d h:i:s")
        ]);

        $setupLink = $request->root() . "/users/setup/" . $token;

        $data = [
          'setupLink' => $setupLink,
          'userName' => $request->request_fname
        ];

        Mail::to($request->request_email)->send(new RequestAccepted($data));

        UserRequest::where('email', $request->request_email)->firstOrFail()->delete();

        return redirect()->back()->with([
          'userMessage' => "Successfully created an account for " . $request->request_fname . " " . $request->request_lname . ". They should receive a password reset email soon."
        ]);
      }
    }

    public function denyRequest(Request $request){
      $existingRequest = UserRequest::where('email', $request->request_email)->firstOrFail();

      $data = [
        'denier' => $request->denier
      ];

      Mail::to($request->request_email)->send(new RequestRejected($data));

      $existingRequest->delete();

      return redirect()->back()->with([
        'userMessage' => "You’ve denied " . $request->request_fname . " " . $request->request_lname . "’s account request."
      ]);
    }

    public function changeUserLevel(Request $request){
      $specificUser = User::find($request->user_id);

      $specificUser->super = $request->super;

      $specificUser->save();

      return redirect()->back()->with([
        'userMessage' => "Successfully changed the permissions for " . $specificUser->fname . " " . $specificUser->lname . "."
      ]);
    }

    public function resetPassword(Request $request){
      $specificUser = User::find($request->user_id);

      // GO THROUGH THE PASSWORD RESET PROCESS
      $token = bin2hex(random_bytes(20));

      //create a new token to be sent to the user.
      DB::table('password_resets')->insert([
        'email' => $specificUser->email,
        'token' => $token,
        'created_at' => date("Y-m-d h:i:s")
      ]);

      $resetLink = $request->root() . "/password/reset/" . $token;

      $data = [
        'resetLink' => $resetLink,
        'userName' => $specificUser->fname
      ];

      // Emails do not work!!!
      Mail::to($specificUser->email)->send(new PWResetEmail($data));

      return redirect()->back()->with([
        'userMessage' => $specificUser->fname . " " . $specificUser->lname . " should have a password reset link in their email inbox soon."
      ]);
    }

    public function deleteUser(Request $request){
      $specificUser = User::find($request->user_id);

      $specificUser->delete();

      return redirect()->back()->with([
        'userMessage' => "You’ve deactivated " . $specificUser->fname . " " . $specificUser->lname . "’s account."
      ]);
    }

    public function getDirectAddForm(){
      return view("users.add");
    }

    public function directAddUser(Request $request){
      $input = $request->all();
      $validation = Validator::make($input, [
        'email' => 'required|email',
        'fname' => 'required',
        'lname' => 'required',
        'phone' => 'required|numeric',
        'super' => 'required'
      ]);

      //if validation fails, redirect back to form with an error message
      if ($validation->fails()){
        return redirect()->back()
          ->withErrors($validation)
          ->withInput();
      }

      $newUser = new User;

      $newUser->fname = $request->fname;
      $newUser->lname = $request->lname;
      $newUser->email = $request->email;

      // these will go through without validation
      $newUser->password = "00";
      $newUser->phone = $request->phone;
      $newUser->super = $request->super;

      $newUser->save();

      // GO THROUGH THE PASSWORD RESET PROCESS
      $token = bin2hex(random_bytes(20));

      //create a new token to be sent to the user.
      DB::table('password_resets')->insert([
        'email' => $request->email,
        'token' => $token,
        'created_at' => date("Y-m-d h:i:s")
      ]);

      $resetLink = $request->root() . "/password/reset/" . $token;

      $data = [
        'resetLink' => $resetLink,
        'userName' => $request->fname
      ];

      // Emails do not work!!!
      Mail::to($request->email)->send(new PWResetEmail($data));

      return redirect("/users", [
        "userMessage" => "You’ve successfully created an account for " . $request->fname . " " . $request->lname . ". They should receive a password reset email soon."
      ]);
    }
}
