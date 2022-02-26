<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewClientAccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $login_id, $password, $client_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($login_id, $client_name, $password)
    {
        $this->login_id = $login_id;
        $this->password = $password;
        $this->client_name = $client_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))->subject('User Registration Success')->markdown('email.new-client-user-email');
    }
}
