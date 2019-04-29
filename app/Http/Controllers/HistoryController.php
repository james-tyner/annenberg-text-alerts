<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use App\MessageRecord;
use App\User;
use DB;

class HistoryController extends Controller
{
    public function index(Request $request){
      $messagesQuery = DB::table('message_history')
            ->join('users', 'users.id', '=', 'message_history.sender')
            ->select('message_history.*', 'users.fname', 'users.lname');

      if ($request->query('search')){
        $messagesQuery->where('message_history.message', 'like', '%'.$request->query('search').'%');
      }

      $messages = $messagesQuery->latest()
      ->simplePaginate(20);

      return view("history", [
        'messages' => $messages,
        'search' => $request->query("search")
      ]);
    }
}
