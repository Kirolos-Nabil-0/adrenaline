<?php

namespace App\Mail;

use Ichtrojan\Otp\Otp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $message;
    public $fromEmail;
    public $subject;
    public $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message, $fromEmail, $subject, $email)
    {
        $this->message = $message;
        $this->fromEmail = $fromEmail;
        $this->subject = $subject;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $otp = $this->generateOtp($this->email);
        return $this->view('email', ['code' => $otp, 'username' => "Guest", 'massge' => $this->message, "subject" => $this->subject]);
    }
    protected function generateOtp($email)
    {
        // echo $email;
        $otp = new Otp;
        $otpCode = $otp->generate($email, 'numeric', 6, 60);
        return (string) $otpCode->token;
    }
}
