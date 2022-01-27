<?php

namespace App\Http\Controllers\Broadcast;

use App\Http\Controllers\Controller;
use Domain\Broadcast\Actions\CreateBroadcastAction;
use Domain\Broadcast\DataTransferObjects\BroadcastData;

class CreateBroadcastController extends Controller
{
    public function __invoke(BroadcastData $data): BroadcastData
    {
        return BroadcastData::from(
            CreateBroadcastAction::execute($data)
        );
    }
}
