<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscriber;
use Validator;
use Twilio\Rest\Client;
use ReCaptcha;
use Log;

class SubscribeController extends Controller
{
    public function subscribe(Request $request){
      // Exists only for validation, does not render anything

      $this->validate($request, [
       'phoneNumber' => 'required|digits:10|unique:subscribers,phone',
       'optionalName' => 'nullable|sometimes|string',
       'recaptchaResponse' => 'recaptcha',
      ], [
       'phoneNumber.required' => 'You have to submit a US or Canada phone number to subscribe',
       'phoneNumber.digits' => 'You can only use a US or Canadian phone number that’s exactly 10 digits.',
       'phoneNumber.unique' => 'That phone number is already subscribed to alerts!',
       'recaptchaResponse.recaptcha' => 'You either failed or did not complete the reCAPTCHA test. Are you sure you’re not a robot? 🤖'
     ]);

      $subscriber = new Subscriber();
      $subscriber->phone = request("phoneNumber");
      $subscriber->name = request("optionalName");
      $subscriber->save();
    } // end subscribe function

    public function unsubscribe(Request $request){
      // Exists only for validation, does not render anything

      $this->validate($request, [
       'unsubscribePhone' => 'required|digits:10|exists:subscribers,phone'
      ], [
       'unsubscribePhone.required' => 'You have to submit a US or Canada phone number to unsubscribe',
       'unsubscribePhone.digits' => 'You can only use a US or Canadian phone number that’s exactly 10 digits.',
       'unsubscribePhone.exists' => 'That phone number isn’t subscribed to alerts.'
     ]);

      // Find the person
      try {
        $requestedSubscriber = Subscriber::where("phone", request("unsubscribePhone"))->firstOrFail();

        // Delete them!
        $requestedSubscriber->delete();
      } catch (ModelNotFoundException $e){
        abort(404);
      }


      // TODO: Send one last text to confirm unsubscribe
      // $account_sid = env("TWILIO_ACCOUNT_SID");
      // $auth_token = env("TWILIO_AUTH_TOKEN");
      // $twilio_number = "+12136994054";
      // $client = new Client($account_sid, $auth_token);
      //
      // $recipient = "+1" . $requestedSubscriber->phone;
      //
      // $client->messages->create(
      //     $recipient,
      //     array(
      //         'from' => $twilio_number,
      //         'body' => "You’ve been unsubscribed from Annenberg Media text alerts."
      //     )
      // );
    }
}
