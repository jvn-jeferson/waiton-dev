<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $target;
    public $name;
    public $temp_pass;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $password)
    {
        $this->target = $user;
        $this->temp_pass = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        switch($this->target->role_id)
        {
            case 1:
                $this->name = 'Upfiling Administrator';
                break;
            case 2:
            case 3:
                $this->name = $this->target->accountingOfficeStaff->name;
                break;
            case 4:
            case 5:
                $this->name = $this->target->clientStaff->name;
                break;
            default:
                break;
        }

        $url = url(route('update-password', ['remember_token' => $this->target->remember_token]));

        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject('【UpFiling】パスワードのリセット')
                    ->markdown('email.password-reset-mail', ['name' => $this->name, 'url' => $url]);
    }
}
