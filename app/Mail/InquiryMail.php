<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $staff, $affiliation, $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $staff, $affiliation, $content)
    {
        $this->user = $user;
        $this->staff = $staff;
        $this->affiliation = $affiliation;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject('【UpFiling】問い合わせあり')
                    ->markdown('email.inquiry-mail');
    }
}
