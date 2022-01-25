<?php

namespace App\Actions;

use App\DataTransferObjects\SubscriberData;
use App\DataTransferObjects\TagData;
use App\Models\Subscriber;

class CreateSubscriberAction
{
    public static function execute(SubscriberData $data): Subscriber
    {
        $subscriber = Subscriber::create($data->all());
        $data->tags->toCollection()->each(fn (TagData $tag) => $subscriber->tags()->attach($tag->id));

        $subscriber->load('tags');

        return $subscriber;
    }
}
