<?php

namespace Domain\Mail\Mails;

use Domain\Mail\Contracts\Sendable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EchoMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public readonly Sendable $mail)
    {
    }

    public function build()
    {
        return $this
            ->subject($this->mail->subject())
            ->view('emails.echo');
    }
}
