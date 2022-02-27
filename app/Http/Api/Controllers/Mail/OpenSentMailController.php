<?php

namespace App\Http\Api\Controllers\Mail;

use Domain\Mail\Actions\SentMail\OpenSentMailAction;
use Domain\Mail\Models\SentMail;
use Illuminate\Http\Response;

class OpenSentMailController
{
    public function __invoke(SentMail $sentMail): Response
    {
        OpenSentMailAction::execute($sentMail);

        return response()->noContent();
    }
}
