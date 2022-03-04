<?php

namespace Domain\Mail\Actions\Broadcast;

use Domain\Mail\DataTransferObjects\Broadcast\BroadcastData;
use Domain\Mail\Models\Broadcast\Broadcast;
use Domain\Shared\Models\User;

class UpsertBroadcastAction
{
    public static function execute(BroadcastData $data, User $user): Broadcast
    {
        return Broadcast::updateOrCreate(
            [
                'id' => $data->id,
            ],
            [
                ...$data->all(),
                'user_id' => $user->id,
            ],
        );
    }
}
