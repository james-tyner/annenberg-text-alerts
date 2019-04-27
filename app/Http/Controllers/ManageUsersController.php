<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserRequest;

class ManageUsersController extends Controller
{
    public function index(){
      $users = User::all();
      $requests = UserRequest::all();

      return view("users", [
        'users' => $users,
        'requests' => $requests
      ]);
    }
}
