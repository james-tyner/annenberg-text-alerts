<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PWResetEmail extends Mailable
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
        $subject = 'Your password reset link for Annenberg Media Text Alerts';
        $name = 'USC Annenberg Media';

        return $this->view('emails.reset')
                    ->from($address, $name)
                    ->replyTo($address, $name)
                    ->subject($subject)
                    ->with([
                      'resetLink' => $this->data['resetLink'],
                      'userName' => $this->data['userName'] 
                    ]);
    }
}
