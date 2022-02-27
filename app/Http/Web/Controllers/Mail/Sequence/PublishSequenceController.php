<?php

namespace App\Http\Web\Controllers\Mail\Sequence;

use Domain\Mail\DataTransferObjects\Sequence\SequenceData;
use Domain\Mail\Enums\Sequence\SequenceStatus;
use Domain\Mail\Models\Sequence\Sequence;

class PublishSequenceController
{
    public function __invoke(Sequence $sequence): SequenceData
    {
        $sequence->status = SequenceStatus::Published;
        $sequence->save();

        return SequenceData::from($sequence);
    }
}
