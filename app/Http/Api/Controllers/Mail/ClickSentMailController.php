<?php

namespace App\Http\Api\Controllers\Mail;

use Domain\Mail\Actions\SentMail\ClickSentMailAction;
use Domain\Mail\Models\SentMail;
use Illuminate\Http\Response;

class ClickSentMailController
{
    public function __invoke(SentMail $sentMail): Response
    {
        ClickSentMailAction::execute($sentMail);

        return response()->noContent();
    }
}
