<?php

namespace Domain\Mail\Actions\SentMail;

use Domain\Mail\Models\SentMail;

class ClickSentMailAction
{
    public static function execute(SentMail $sentMail): void
    {
        $sentMail->clicked_at = now();
        $sentMail->save();
    }
}
