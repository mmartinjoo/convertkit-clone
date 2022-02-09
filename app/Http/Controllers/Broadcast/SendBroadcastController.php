<?php

namespace App\Http\Controllers\Broadcast;

use App\Http\Controllers\Controller;
use Domain\Mail\Actions\Broadcast\SendBroadcastAction;
use Domain\Mail\Exceptions\Broadcast\CannotSendBroadcast;
use Domain\Mail\Models\Broadcast\Broadcast;
use Illuminate\Http\Response;

class SendBroadcastController extends Controller
{
    public function __invoke(Broadcast $broadcast): Response
    {
        try {
            SendBroadcastAction::execute($broadcast);
            return response('', Response::HTTP_ACCEPTED);
        } catch (CannotSendBroadcast $ex) {
            return response([
                'errors' => [$ex->getMessage()],
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
