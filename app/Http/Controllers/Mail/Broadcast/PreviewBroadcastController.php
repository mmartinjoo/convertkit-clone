<?php

namespace App\Http\Controllers\Mail\Broadcast;

use App\Http\Controllers\Controller;
use Domain\Mail\Mails\EchoMail;
use Domain\Mail\Models\Broadcast\Broadcast;

class PreviewBroadcastController extends Controller
{
    public function __invoke(Broadcast $broadcast): EchoMail
    {
        return new EchoMail($broadcast);
    }
}
