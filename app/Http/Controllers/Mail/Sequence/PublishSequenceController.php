<?php

namespace App\Http\Controllers\Mail\Sequence;

use App\Http\Controllers\Controller;
use Domain\Mail\DataTransferObjects\Sequence\SequenceData;
use Domain\Mail\Enums\Sequence\SequenceStatus;
use Domain\Mail\Models\Sequence\Sequence;

class PublishSequenceController extends Controller
{
    public function __invoke(Sequence $sequence): SequenceData
    {
        $sequence->status = SequenceStatus::Published;
        $sequence->save();

        return SequenceData::from($sequence);
    }
}
