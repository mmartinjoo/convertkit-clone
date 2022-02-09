<?php

namespace Domain\Mail\Actions\Sequence;

use Domain\Mail\DataTransferObjects\Sequence\SequenceData;
use Domain\Mail\Models\Sequence\Sequence;

class CreateSequenceAction
{
    public static function execute(SequenceData $data): Sequence
    {
        return Sequence::create($data->all());
    }
}
