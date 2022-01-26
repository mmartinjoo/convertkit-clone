<?php

namespace Domain\Broadcast\Actions;

use Domain\Broadcast\DataTransferObjects\BroadcastData;
use Domain\Broadcast\Models\Broadcast;
use Domain\Subscriber\Models\Subscriber;

class CreateBroadcastAction
{
    public static function execute(BroadcastData $data): Broadcast
    {
        $broadcast = Broadcast::create($data->all());
        // TODO: apply filters
        Subscriber::all()->each(fn (Subscriber $subscriber) => $broadcast->subscribers()->attach($subscriber->id));

        return $broadcast;
    }
}
