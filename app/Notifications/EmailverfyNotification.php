<?php

namespace App\Notifications;


use Ichtrojan\Otp\Otp;
use Illuminate\Bus\Queueable;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailverfyNotification extends Notification
{
    use Queueable;
    public $massge;
    public $fromemail;
    public $mailer;
    public $subject;
    // public $otp;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->massge = "Please use the following OTP to verify your email address";
        $this->fromemail = "mail@adrenaline-edu.com";
        $this->subject = "verfication needed";
        $this->mailer = "smtp";
        //   $this->otp=new Otp;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $otp = $this->generateOtp($notifiable->email); //$this->otp->generate($notifiable->email, 6, 60);
        return (new MailMessage)->mailer("smtp")->subject($this->subject)->greeting('welcome ' . $notifiable->name)->line($this->massge)->line('code : ' . $otp)->view('email', ['code' => $otp, 'username' => $notifiable->name, 'massge' => $this->massge, "subject" => $this->subject]);
    }
    function generateOtp($email)
    {
        $otp = new Otp;
        $otpCode = $otp->generate($email, 'numeric', 6, 60);
        return (string) $otpCode->token;
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}