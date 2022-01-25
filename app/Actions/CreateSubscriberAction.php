<?php

namespace App\Actions;

use App\DataTransferObjects\SubscriberData;
use App\Models\Subscriber;

class CreateSubscriberAction
{
    public static function execute(SubscriberData $data): Subscriber
    {
        return Subscriber::create($data->all());
    }
}
