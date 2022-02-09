<?php

namespace Domain\Mail\Actions\Sequence;

use Domain\Mail\Enums\Sequence\SequenceStatus;
use Domain\Mail\Models\Sequence\Sequence;

class StartSequenceAction
{
    public static function execute(Sequence $sequence): void
    {
        $sequence->status = SequenceStatus::STARTED;
        $sequence->save();
    }
}
