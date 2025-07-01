<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomePatientMail extends Mailable
{
    use Queueable, SerializesModels;

    public $patient;

    public function __construct($patient)
    {
        $this->patient = $patient;
    }

    public function build()
    {
        return $this->subject('Welcome to iTest Lab')
                    ->view('emails.welcome-patient');
    }
}
