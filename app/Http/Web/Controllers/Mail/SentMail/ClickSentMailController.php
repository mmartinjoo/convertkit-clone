<?php

namespace App\Http\Web\Controllers\Mail\SentMail;

use Domain\Mail\Models\SentMail;
use Illuminate\Http\Response;

class ClickSentMailController
{
    public function __invoke(SentMail $sentMail): Response
    {
        $sentMail->clicked_at = now();
        $sentMail->save();

        return response()->noContent();
    }
}
