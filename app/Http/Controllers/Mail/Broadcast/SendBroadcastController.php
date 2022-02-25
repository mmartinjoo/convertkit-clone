<?php

namespace App\Http\Controllers\Mail\Broadcast;

use App\Http\Controllers\Controller;
use Domain\Mail\Actions\Broadcast\SendBroadcastAction;
use Domain\Mail\Exceptions\Broadcast\CannotSendBroadcast;
use Domain\Mail\Models\Broadcast\Broadcast;
use Illuminate\Http\RedirectResponse;
use Redirect;

class SendBroadcastController extends Controller
{
    public function __invoke(Broadcast $broadcast): RedirectResponse
    {
        try {
            SendBroadcastAction::execute($broadcast);

            return Redirect::route('broadcasts.index', $broadcast);
        } catch (CannotSendBroadcast $ex) {
            return Redirect::route(
                'broadcasts.index',
                $broadcast
            )->withErrors(['status' => $ex->getMessage()]);
        }
    }
}
