<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subscriber;
use Validator;
use Storage;

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
      $subscribers = Subscriber::all();

      // Store the uploaded file if there is one
      if ($request->alertImage){
        $path = $request->file('alertImage')->store('public/images');
        $url = $request->root() . Storage::url($path);
        dd($url);

        // make a Twilio request with the alert message and the image path
      } else {
        // If no uploaded file, only make a Twilio request with the alert message
      }

    }
}
