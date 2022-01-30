<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Domain\Statistics\Actions\SentMails\GetSentMailsTrackingAction;
use Domain\Statistics\DataTransferObjects\Tracking\TrackingData;

class GetAllTrackingController extends Controller
{
    public function __invoke(): TrackingData
    {
        return GetSentMailsTrackingAction::execute();
    }
}
