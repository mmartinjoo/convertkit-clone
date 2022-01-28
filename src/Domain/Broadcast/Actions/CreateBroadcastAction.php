<?php

namespace Domain\Broadcast\Actions;

use Domain\Broadcast\DataTransferObjects\BroadcastData;
use Domain\Broadcast\Models\Broadcast;

class CreateBroadcastAction
{
    public static function execute(BroadcastData $data): Broadcast
    {
        return Broadcast::create($data->all());
    }
}
