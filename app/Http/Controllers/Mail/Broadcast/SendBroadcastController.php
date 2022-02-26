<?php

namespace App\Http\Controllers\Mail\Broadcast;

use App\Http\Controllers\Controller;
use Domain\Mail\Jobs\Broadcast\SendBroadcastJob;
use Domain\Mail\Models\Broadcast\Broadcast;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SendBroadcastController extends Controller
{
    public function __invoke(Broadcast $broadcast): Response
    {
        SendBroadcastJob::dispatch($broadcast);

        return response('', Response::HTTP_ACCEPTED);
    }
}
