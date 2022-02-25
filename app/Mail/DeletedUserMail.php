<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeletedUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $login_id;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($login_id)
    {
        $this->login_id = $login_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))->subject('ユーザーの資格情報が削除されました！')->markdown('email.deleted-user-mail');
    }
}
