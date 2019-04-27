<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscriber;

class ManageSubscribersController extends Controller
{
    public function index(){
      $subscribers = Subscriber::all();

      return view("subscribers", [
        'subscribers' => $subscribers
      ]);
    }
}
