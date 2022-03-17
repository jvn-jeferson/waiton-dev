<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OTPMail extends Mailable
{
    use Queueable, SerializesModels;

    public $password, $url, $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($password, $url, $user)
    {
        $this->password = $password;
        $this->url = $url;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject('【UpFiling】ワンタイムパスワード通知 '.$this->user->client->name)
                    ->markdown('email.otp-mail');
    }
}
