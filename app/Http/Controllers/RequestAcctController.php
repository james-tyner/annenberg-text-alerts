<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserRequest;
use Validator;

class RequestAcctController extends Controller
{

    public function newRequest(Request $request){
      $this->validate($request, [
        'requestEmail' => 'required|email|regex:/usc\.edu$/',
        'requestFirst' => 'required',
        'requestLast' => 'required'
      ], [
       'required' => 'Every field is required.',
       'requestEmail.email' => 'That doesn’t look like a valid email address.'
      ]);

      $user = new UserRequest();
      $user->email = request("requestEmail");
      $user->fname = request("requestFirst");
      $user->lname = request("requestLast");
      $user->save();
    }
}
