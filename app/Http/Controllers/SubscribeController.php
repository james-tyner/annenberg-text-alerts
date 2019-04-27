<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscriber;
use Validator;

class SubscribeController extends Controller
{
    public function subscribe(Request $request){
      // Exists only for validation, does not render anything

      $this->validate($request, [
       'phoneNumber' => 'required|digits:10|unique:subscribers,phone',
       'optionalName' => 'nullable|sometimes|alpha_dash'
      ], [
       'phoneNumber.required' => 'You have to submit a US or Canada phone number to subscribe',
       'phoneNumber.digits' => 'You can only use a US or Canadian phone number that’s exactly 10 digits.',
       'phoneNumber.unique' => 'That phone number is already subscribed to alerts!'
     ]);

      $subscriber = new Subscriber();
      $subscriber->phone = request("phoneNumber");
      $subscriber->name = request("optionalName");
      $subscriber->save();
    }

    public function unsubscribe(Request $request){
      // Exists only for validation, does not render anything

      $this->validate($request, [
       'unsubscribePhone' => 'required|digits:10|exists:subscribers,phone'
      ], [
       'unsubscribePhone.required' => 'You have to submit a US or Canada phone number to unsubscribe',
       'unsubscribePhone.digits' => 'You can only use a US or Canadian phone number that’s exactly 10 digits.',
       'unsubscribePhone.exists' => 'That phone number isn’t subscribed to alerts.'
     ]);

      $requestedSubscriber = Subscriber::where("phone", request("unsubscribePhone"))->firstOrFail();
      $requestedSubscriber->delete();

      // TODO: Handle failure to find the number
      // TODO: Send one last text to confirm being unsubscribed
    }
}
