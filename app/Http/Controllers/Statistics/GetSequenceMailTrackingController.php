<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Domain\Sequence\Models\SequenceMail;
use Domain\Statistics\Actions\SentMails\GetTrackingAction;
use Domain\Statistics\DataTransferObjects\Tracking\TrackingData;

class GetSequenceMailTrackingController extends Controller
{
    public function __invoke(SequenceMail $sequenceMail): TrackingData
    {
        return GetTrackingAction::execute($sequenceMail);
    }
}
