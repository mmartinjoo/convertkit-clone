<?php

namespace Domain\Mail\Actions\Broadcast;

use Domain\Mail\Models\Broadcast\Broadcast;

class DeleteBroadcastAction
{
    public static function execute(Broadcast $broadcast): void
    {
        $broadcast->delete();
    }
}
