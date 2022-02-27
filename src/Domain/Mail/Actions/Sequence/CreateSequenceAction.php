<?php

namespace Domain\Mail\Actions\Sequence;

use Domain\Mail\DataTransferObjects\Sequence\SequenceData;
use Domain\Mail\DataTransferObjects\Sequence\SequenceMailData;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Subscriber\Models\Subscriber;

class CreateSequenceAction
{
    public static function execute(SequenceData $data): Sequence
    {
        $sequence = Sequence::create($data->all());
        $mailData = SequenceMailData::dummy();

        UpsertSequenceMailAction::execute($mailData, $sequence);

        $sequence->subscribers()->sync(Subscriber::select('id')->pluck('id'));

        return $sequence;
    }
}
