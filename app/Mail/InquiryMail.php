<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $sender, $inquiry;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sender, $inquiry)
    {
        $this->sender = $sender;
        $this->inquiry = $inquiry;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject('A user has sent you an inquiry')
                    ->markdown('email.inquiry-mail');
    }
}
