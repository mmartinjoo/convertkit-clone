<?php

namespace App\Http\Web\Controllers\Mail\Broadcast;

use Domain\Mail\Jobs\Broadcast\SendBroadcastJob;
use Domain\Mail\Models\Broadcast\Broadcast;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SendBroadcastController
{
    public function __invoke(Broadcast $broadcast): Response
    {
        SendBroadcastJob::dispatch($broadcast);

        return response('', Response::HTTP_ACCEPTED);
    }
}
