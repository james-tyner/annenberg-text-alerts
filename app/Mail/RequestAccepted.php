<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestAccepted extends Mailable
{
  use Queueable, SerializesModels;

  public $data;

  public function __construct($data)
  {
    $this->data = $data;
  }

  public function build()
  {
      $address = 'annmedia@usc.edu';
      $subject = 'Your Annenberg Media Text Alerts account was created. Congrats!';
      $name = 'USC Annenberg Media';

      return $this->view('emails.request_accept')
                  ->from($address, $name)
                  ->replyTo($address, $name)
                  ->subject($subject)
                  ->with([
                    'setupLink' => $this->data['setupLink'],
                    'userName' => $this->data['userName']
                  ]);
  }
}
