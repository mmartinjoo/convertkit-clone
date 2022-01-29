<?php

namespace Domain\Sequence\Actions;

use Domain\Sequence\DataTransferObjects\SequenceMailData;
use Domain\Sequence\Models\Sequence;
use Domain\Sequence\Models\SequenceMail;
use Domain\Sequence\Models\SequenceMailSchedule;

class CreateSequenceMailAction
{
    public static function execute(SequenceMailData $data, Sequence $sequence): SequenceMail
    {
        $schedule = SequenceMailSchedule::create($data->schedule->toArray());
        $mail = $sequence->mails()->create([
            ...$data->toArray(),
            'sequence_mail_schedule_id' => $schedule->id,
        ]);

        return $mail->load(['sequence', 'schedule']);
    }
}
