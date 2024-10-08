<?php

namespace App\Notifications;

use App\Models\User;
use Ichtrojan\Otp\Otp;
use Illuminate\Bus\Queueable;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailverfyNotUserNotification extends Notification
{
    use Queueable;
    public $message;
    public $fromEmail;
    public $subject;
    public $email;
    public function __construct($message, $fromEmail, $subject, $email)
    {
        $this->message = $message;
        $this->fromEmail = $fromEmail;
        $this->subject = $subject;
        $this->email = $email;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $otp = $this->generateOtp($this->email);
        return (new MailMessage)->mailer("smtp")->from($this->fromEmail)->subject($this->subject)
            ->greeting('welcome ' . $notifiable->name)
            ->line($this->message)
            ->line('code : ' . $otp)->view('email', ['code' => $otp, 'username' => "Guest", 'massge' => $this->message, "subject" => $this->subject]);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }


    protected function generateOtp($email)
    {
        // echo $email;
        $otp = new Otp;
        $otpCode = $otp->generate($email, 'numeric', 6, 60);
        return (string) $otpCode->token;
    }
}
