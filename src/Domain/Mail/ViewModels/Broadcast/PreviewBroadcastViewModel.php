<?php

namespace Domain\Mail\ViewModels\Broadcast;

use Domain\Mail\Mails\EchoMail;
use Domain\Shared\ViewModels\ViewModel;

class PreviewBroadcastViewModel extends ViewModel
{
    public function __construct(private readonly EchoMail $mail)
    {
    }

    public function subject(): string
    {
        return $this->mail->mail->subject();
    }

    public function content(): string
    {
        return $this->mail->mail->content();
    }
}
