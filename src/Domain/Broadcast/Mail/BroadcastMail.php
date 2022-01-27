<?php

namespace Domain\Broadcast\Mail;

use Domain\Broadcast\Models\Broadcast;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BroadcastMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public readonly Broadcast $broadcast)
    {
    }

    public function build()
    {
        return $this
            ->subject($this->broadcast->title)
            ->view('emails.broadcast');
    }
}
