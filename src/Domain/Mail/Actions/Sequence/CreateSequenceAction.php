<?php

namespace Domain\Mail\Actions\Sequence;

use Domain\Mail\DataTransferObjects\Sequence\SequenceData;
use Domain\Mail\DataTransferObjects\Sequence\SequenceMailData;
use Domain\Mail\DataTransferObjects\Sequence\SequenceMailScheduleDaysData;
use Domain\Mail\Enums\Sequence\SequenceMailStatus;
use Domain\Mail\Models\Sequence\Sequence;

class CreateSequenceAction
{
    public static function execute(SequenceData $data): Sequence
    {
        $sequence = Sequence::create($data->all());

        $mailData = SequenceMailData::from([
            'subject' => 'My Awesome E-mail',
            'content' => 'My Awesome Content',
            'status' => SequenceMailStatus::Draft,
            'schedule' => [
                'delay' => 1,
                'unit' => 'day',
                'days' => SequenceMailScheduleDaysData::empty(),
            ]
        ]);

        UpsertSequenceMailAction::execute($mailData, $sequence);
        return $sequence;
    }
}
