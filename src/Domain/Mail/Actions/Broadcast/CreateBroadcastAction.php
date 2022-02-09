<?php

namespace Domain\Mail\Actions\Broadcast;

use Domain\Mail\DataTransferObjects\Broadcast\BroadcastData;
use Domain\Mail\Models\Broadcast\Broadcast;

class CreateBroadcastAction
{
    public static function execute(BroadcastData $data): Broadcast
    {
        return Broadcast::create($data->all());
    }
}
