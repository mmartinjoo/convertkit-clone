<?php

namespace Domain\Mail\Actions\Sequence;

use Domain\Mail\DataTransferObjects\Sequence\SequenceMailData;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Mail\Models\Sequence\SequenceMailSchedule;

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
