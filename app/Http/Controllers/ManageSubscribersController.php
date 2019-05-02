<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscriber;

class ManageSubscribersController extends Controller
{
    public function index(){
      $subscribers = Subscriber::all()->sortByDesc("created_at");

      return view("subscribers", [
        'subscribers' => $subscribers
      ]);
    }
}
