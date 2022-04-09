<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UpdatedLoginCredentialsEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $login_id, $name, $email, $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($login_id, $name, $email, $password)
    {
        $this->login_id = $login_id;
        $this->name = $name;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))->subject('ログインクレデンシャルが更新されました！')->markdown('email.login-credentials-updated');
    }
}
