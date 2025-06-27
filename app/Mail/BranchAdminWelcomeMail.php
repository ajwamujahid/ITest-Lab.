<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BranchAdminWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name, $email, $plainPassword;

    public function __construct($name, $email, $plainPassword)
    {
        $this->name = $name;
        $this->email = $email;
        $this->plainPassword = $plainPassword;
    }

    public function build()
    {
        return $this->subject('Welcome to iTestLab - Your Branch Admin Account')
                    ->view('emails.branch_admin_welcome');
    }
}
