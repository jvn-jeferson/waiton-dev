<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token, $user, $password, $accounting_office;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $user, $password, $accounting_office)
    {
        $this->token = $token;
        $this->user = $user;
        $this->password = $password;
        $this->accounting_office = $accounting_office;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = url(route('first-time-login', ['token' => $this->user->remember_token]));

        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject('会計事務所名様からのご招待メール')
                    ->markdown('email.client-registration-success-mail', ['url' => $url]);
    }
}
