<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Domain\Statistics\Actions\SentMails\GetSentMailsTrackingAction;
use Domain\Statistics\DataTransferObjects\SentMails\SentMailsTrackingData;

class GetSentMailsTrackingController extends Controller
{
    public function __invoke(): SentMailsTrackingData
    {
        return GetSentMailsTrackingAction::execute();
    }
}
