<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Domain\Broadcast\Models\Broadcast;
use Domain\Statistics\Actions\SentMails\GetTrackingAction;
use Domain\Statistics\DataTransferObjects\Tracking\TrackingData;

class GetBroadcastTrackingController extends Controller
{
    public function __invoke(Broadcast $broadcast): TrackingData
    {
        return GetTrackingAction::execute($broadcast);
    }
}
