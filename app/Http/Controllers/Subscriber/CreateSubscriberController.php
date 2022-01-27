<?php

namespace App\Http\Controllers\Subscriber;

use App\Http\Controllers\Controller;
use Domain\Subscriber\Actions\CreateSubscriberAction;
use Domain\Subscriber\DataTransferObjects\SubscriberData;

class CreateSubscriberController extends Controller
{
    public function __invoke(SubscriberData $data): SubscriberData
    {
        return SubscriberData::from(
            CreateSubscriberAction::execute($data)
        );
    }
}
