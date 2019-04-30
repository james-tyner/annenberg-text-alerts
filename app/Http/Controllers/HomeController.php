<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscriber;
use App\UserRequest;
use App\MessageRecord;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $subscriberCount = Subscriber::count();
      $pendingRequestCount = UserRequest::count();

      $latestMessage = DB::table('message_history')
            ->join('users', 'users.id', '=', 'message_history.sender')
            ->select('message_history.*', 'users.fname', 'users.lname')
            ->latest()
            ->first();

        return view('dashboard', [
          'subscriberCount' => $subscriberCount,
          'pendingRequestCount' => $pendingRequestCount,
          'latestMessage' => $latestMessage
        ]);
    }
}
