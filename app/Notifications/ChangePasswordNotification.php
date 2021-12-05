<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ChangePasswordNotification extends Notification
{
    use Queueable;

    public $token;
    public $login_id;

    public static $createUrlCallback;

    public static $toMailCallback;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, $login_id)
    {
        $this->token = $token;
        $this->login_id = $login_id;
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
    public function toMail($notifiable) : MailMessage
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
            $url = url(route('password.request-reset', [
                'token' => $this->token,
                'login_id' => $this->login_id,
            ], false));
        }


        return (new MailMessage())
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject("Request for password reset granted.")
            ->view('email.update-password', [
                'data' => [
                    'title' => 'Request for reset password has been granted.',
                    'name' => $target->representative,
                    'company' => $target->name,
                    'login_id' => $this->login_id,
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
