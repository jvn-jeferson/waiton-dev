<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HostUploadNoApprovalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $client, $host;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($client, $host)
    {
        $this->client = $client;
        $this->host = $host;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject('【From会計事務所（'.$this->host->name.'）】アップロード通知')
                    ->markdown('email.approval-not-required-mail');
    }
}
