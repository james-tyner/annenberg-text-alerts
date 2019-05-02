<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscriber;
use App\MessageRecord;
use Validator;
use Storage;
use Auth;
use Twilio\Rest\Client;

class AlertsController extends Controller
{
    public function index(){
      return view ("alerts");
    }

    public function send(Request $request){
      // validate the new playlist name
      $input = $request->all();
      $validation = Validator::make($input, [
        'alertText' => 'required',
        'alertImage' => 'nullable|sometimes|image|max:5000'
      ]);

      //if validation fails, redirect back to form with an error message
      if ($validation->fails()){
        return redirect("/alerts")
          ->withErrors($validation)
          ->withInput();
      }

      // Get list of subscribers
      $subscribers = Subscriber::all()->pluck('phone')->toArray();

      // Add +1 to the front for Twilio
      foreach($subscribers as &$subscriber){
        $subscriber = "+1" . $subscriber;
      }

      $account_sid = env("TWILIO_ACCOUNT_SID");
      $auth_token = env("TWILIO_AUTH_TOKEN");
      $twilio_number = "+12136994054";
      $client = new Client($account_sid, $auth_token);

      //placeholder
      $url = "";

      // Store the uploaded file if there is one
      if ($request->alertImage){
        $path = $request->file('alertImage')->store('public/images');
        $url = $request->root() . Storage::url($path);

        // make a Twilio request with the alert message and the image path
        foreach($subscribers as &$subscriber){
          $client->messages->create(
              $subscriber,
              array(
                  'from' => $twilio_number,
                  'body' => $request->alertText,
                  'mediaUrl' => $url
              )
          );
        }

      } else {
        // If no uploaded file, only make a Twilio request with the alert message

        foreach($subscribers as &$subscriber){
          $client->messages->create(
              $subscriber,
              array(
                  'from' => $twilio_number,
                  'body' => $request->alertText
              )
          );
        }
      }

      // Save the message to history database after it has sent successfully
      $messageRecord = new MessageRecord;
      $messageRecord->sender = Auth::user()->id;

      $messageRecord->message = $request->alertText;
      if ($request->alertImage){
        $messageRecord->mediaUrl = $url;
      }

      $messageRecord->save();


      return redirect("/history");

    }
}
