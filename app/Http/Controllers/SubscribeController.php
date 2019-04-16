<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscriber;
use Validator;

class SubscribeController extends Controller
{
    public function subscribe(Request $request){
      $input = $request->all();
      $validation = Validator::make($input, [
        'phoneNumber' => 'required|digits:10'
      ]);

      if ($validation->fails()){
        return view('landing', [
          "message" => "We couldn’t subscribe you. Did you enter your phone number correctly?",
          "status" => "danger"
        ]);
      }

      $subscriber = new Subscriber();
      $subscriber->phone = request("phoneNumber");
      if(null !== request("optionalName")){
        $subscriber->name = request("optionalName");
      }
      $subscriber->save();

      return view('landing', [
        "message" => "You’re subscribed!",
        "status" => "success"
      ]);
    }

    public function unsubscribe(Request $request){
      $input = $request->all();
      $validation = Validator::make($input, [
        'unsubscribePhone' => 'required|digits:10'
      ]);

      if ($validation->fails()){
        return view('landing', [
          "message" => "We couldn’t unsubscribe you. Did you enter your phone number correctly?",
          "status" => "danger"
        ]);
      }

      $requestedSubscriber = Subscriber::where("phone", request("unsubscribePhone"))->firstOrFail();
      $requestedSubscriber->delete();

      // TODO: Send one last text to confirm being unsubscribed

      return view('landing', [
        "message" => "You’re unsubscribed. Goodbye 👋",
        "status" => "success"
      ]);
    }
}
