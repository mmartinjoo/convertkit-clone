<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Domain\Sequence\Models\Sequence;
use Domain\Statistics\Actions\SentMails\GetSequenceTrackingAction;
use Domain\Statistics\DataTransferObjects\Tracking\TrackingData;

class GetSequenceTrackingController extends Controller
{
    public function __invoke(Sequence $sequence): TrackingData
    {
        return GetSequenceTrackingAction::execute($sequence);
    }
}
