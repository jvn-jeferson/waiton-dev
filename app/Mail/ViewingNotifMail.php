<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ViewingNotifMail extends Mailable
{
    use Queueable, SerializesModels;

    public $client, $host, $staff, $has_video;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($client, $host, $staff, $has_video)
    {
        $this->client = $client;
        $this->host = $host;
        $this->staff = $staff;
        $this->has_video = $has_video;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject('【保管資料 '.$this->has_video.' '.$this->client->name.'】アップロード通知')
                    ->markdown('email.viewing-complete-mail');
    }
}
