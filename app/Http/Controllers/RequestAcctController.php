<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserRequest;
use Validator;

class RequestAcctController extends Controller
{

    public function newRequest(Request $request){
      $input = $request->all();
      $validation = Validator::make($input, [
        'requestEmail' => 'required|email',
        'requestFirst' => 'required',
        'requestLast' => 'required'
      ]);

      if ($validation->fails()){
        return redirect("/")
          ->withErrors($validation)
          ->withInput();
      }

      $user = new UserRequest();
      $user->email = request("requestEmail");
      $user->fname = request("requestFirst");
      $user->lname = request("requestLast");
      $user->save();

      return view('landing', [
        "message" => $message,
        "status" => "success"
      ]);
    }
}
