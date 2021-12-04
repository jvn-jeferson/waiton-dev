<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendPasswordNotification extends Notification
{
    use Queueable;

    public $token;

    public static $createUrlCallback;

    public static $toMailCallback;


    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail(User $notifiable): MailMessage
    {
        if($notifiable->role_id == 2 || $notifiable->role_id == 3){
            $target = $notifiable->accountingOffice;
        }
        else if ($notifiable->role_id == 4 || $notifiable->role_id == 5){
            $target = $notifiable->client;
        }
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        if (static::$createUrlCallback) {
            $url = call_user_func(static::$createUrlCallback, $notifiable, $this->token);
        } else {
            $url = url(route('password.reset', [
                'token' => $this->token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));
        }


        return (new MailMessage())
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject("Reset Password")
            ->view('email.registration-success-mail', [
                'data' => [
                    'title' => 'Send Password Notification',
                    'name' => $target->representative,
                    'company' => $target->name,
                    'content' => " <a style='
                        width: 30%;
                        margin: 0 auto;
                        color: #FFFFFF;
                        text-align: center;
                        text-decoration: none;
                        display: block;
                        background-color: #E02D3F;
                        border: 1px solid #E02D3F;
                        padding: 14px;
                        border-radius: 0px;
                        -moz-border-radius: 0px;
                        -webkit-border-radius: 0px;
                    '
                    target=_blank
                    href=$url>
                        Reset Password
                    </a>"
                ],
            ]);
    }
}
