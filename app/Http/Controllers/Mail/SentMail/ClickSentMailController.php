<?php

namespace App\Http\Controllers\Mail\SentMail;

use App\Http\Controllers\Controller;
use Domain\Mail\Models\SentMail;
use Illuminate\Http\Response;

class ClickSentMailController extends Controller
{
    public function __invoke(SentMail $sentMail): Response
    {
        $sentMail->clicked_at = now();
        $sentMail->save();

        return response()->noContent();
    }
}
