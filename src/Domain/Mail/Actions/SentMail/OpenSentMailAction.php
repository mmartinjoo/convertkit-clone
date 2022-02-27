<?php

namespace Domain\Mail\Actions\SentMail;

use Domain\Mail\Models\SentMail;

class OpenSentMailAction
{
    public static function execute(SentMail $sentMail): void
    {
        $sentMail->opened_at = now();
        $sentMail->save();
    }
}
