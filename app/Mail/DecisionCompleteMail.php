<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DecisionCompleteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $client, $host, $staff;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($client, $host, $staff)
    {
        $this->client = $client;
        $this->host = $host;
        $this->staff = $staff;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject('【From会計事務所 '.$this->host->name.'】承認等の完了通知')
                    ->markdown('email.decision-complete-mail');
    }
}
