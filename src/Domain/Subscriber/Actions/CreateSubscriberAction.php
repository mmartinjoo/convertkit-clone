<?php

namespace Domain\Subscriber\Actions;

use Domain\Automation\Events\SubscribedToFormEvent;
use Domain\Subscriber\DataTransferObjects\SubscriberData;
use Domain\Subscriber\DataTransferObjects\TagData;
use Domain\Subscriber\Models\Subscriber;

class CreateSubscriberAction
{
    public static function execute(SubscriberData $data): Subscriber
    {
        $subscriber = Subscriber::create([
            ...$data->all(),
            'form_id' => $data->form?->id,
        ]);

        $data->tags->toCollection()->each(fn (TagData $tag) => $subscriber->tags()->attach($tag->id));

        if ($data->form) {
            event(new SubscribedToFormEvent($subscriber));
        }

        return $subscriber->load('tags');
    }
}
