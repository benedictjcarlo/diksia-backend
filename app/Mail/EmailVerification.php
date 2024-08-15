<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        $verificationUrl = url('/api/verify-email/' . $this->user->verification_token);

        return $this->subject('Email Verification')
                    ->view('emails.verif')
                    ->with([
                        'name' => $this->user->name,
                        'verificationUrl' => $verificationUrl
                    ]);
    }
}
