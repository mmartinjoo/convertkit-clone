<?php

namespace App\Http\Controllers\Broadcast;

use App\Http\Controllers\Controller;
use Domain\Broadcast\Actions\SendBroadcastAction;
use Domain\Broadcast\Models\Broadcast;
use Illuminate\Http\Response;

class SendBroadcastController extends Controller
{
    public function __invoke(Broadcast $broadcast): Response
    {
        SendBroadcastAction::execute($broadcast);
        return response('', Response::HTTP_ACCEPTED);
    }
}
