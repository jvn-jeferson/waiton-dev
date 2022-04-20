<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewClientAccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $password, $client_name, $name, $accountingOffice;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $client_name, $password, $name)
    {
        $this->user = $user;
        $this->password = $password;
        $this->client_name = $client_name;
        $this->name = $name;
        $this->accountingOffice = $user->clientStaff->client->host;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = url(route('first-time-login', ['token' => $this->user->remember_token]));
        return $this->from(config('mail.from.address'), config('mail.from.name'))->subject($this->client_name.' - 様のユーザー登録')->markdown('email.new-client-user-email', ['url' => $url] );
    }
}
