<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UploadNotification extends Mailable
{
    use Queueable, SerializesModels;

    public  $target, $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $target, $message)
    {
        $this->target = $target;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject('アップロードに成功')
                    ->markdown('email.upload-success-mail');
    }
}
