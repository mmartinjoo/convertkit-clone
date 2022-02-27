<?php

namespace App\Http\Web\Controllers\Mail\SentMail;

use Domain\Mail\Models\SentMail;
use Illuminate\Http\Response;

class OpenSentMailController
{
    public function __invoke(SentMail $sentMail): Response
    {
        $sentMail->opened_at = now();
        $sentMail->save();

        return response()->noContent();
    }
}
