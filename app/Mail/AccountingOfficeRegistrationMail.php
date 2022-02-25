<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountingOfficeRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $user;
    public $password;
    public $accountingOffice;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $user, $password, $accountingOffice)
    {
        $this->token = $token;
        $this->user = $user;
        $this->password = $password;
        $this->accountingOffice = $accountingOffice;
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
                    ->subject('経理部登録完了！')
                    ->markdown('email.registration-success-mail', ['url' => $url]);
    }
}



