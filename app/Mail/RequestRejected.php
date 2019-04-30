<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestRejected extends Mailable
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
      $subject = 'Your request for an Annenberg Media Text Alerts account was denied';
      $name = 'USC Annenberg Media';

      return $this->view('emails.request_reject')
                  ->from($address, $name)
                  ->replyTo($address, $name)
                  ->subject($subject)
                  ->with([
                    'denier' => $this->data['denier']
                  ]);
  }
}
