<?php

namespace App\Http\Api\Controllers\Subscriber;

use Domain\Subscriber\Actions\UpsertSubscriberAction;
use Domain\Subscriber\DataTransferObjects\SubscriberData;
use Illuminate\Http\Request;

class CreateSubscriberController
{
    public function __invoke(SubscriberData $data, Request $request): SubscriberData
    {
        $subscriber = UpsertSubscriberAction::execute($data, $request->user());

        return $subscriber->getData();
    }
}
