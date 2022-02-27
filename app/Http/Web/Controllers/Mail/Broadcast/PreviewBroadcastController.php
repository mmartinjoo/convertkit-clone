<?php

namespace App\Http\Web\Controllers\Mail\Broadcast;

use Domain\Mail\Mails\EchoMail;
use Domain\Mail\Models\Broadcast\Broadcast;

class PreviewBroadcastController
{
    public function __invoke(Broadcast $broadcast): EchoMail
    {
        return new EchoMail($broadcast);
    }
}
