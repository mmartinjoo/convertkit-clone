<?php

namespace Domain\Mail\Actions\Sequence;

use Domain\Mail\DataTransferObjects\Sequence\SequenceMailData;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Mail\Models\Sequence\SequenceMailSchedule;

class UpsertSequenceMailAction
{
    public static function execute(SequenceMailData $data, Sequence $sequence): SequenceMail
    {
        $schedule = SequenceMailSchedule::updateOrCreate(
            [
                'id' => $data->schedule->id
            ],
            $data->schedule->toArray()
        );

        $mail = $sequence->mails()->updateOrCreate(
            [
                'id' => $data->id,
            ],
            [
                ...$data->toArray(),
                'sequence_mail_schedule_id' => $schedule->id,
            ]
        );

        return $mail->load(['sequence', 'schedule']);
    }
}
