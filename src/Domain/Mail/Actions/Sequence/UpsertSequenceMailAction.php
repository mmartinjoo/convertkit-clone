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
        $mail = $sequence->mails()->updateOrCreate(
            [
                'id' => $data->id,
            ],
            $data->toArray(),
        );

        $mail->schedule()->updateOrCreate(
            [
                'id' => $data->schedule->id
            ],
            $data->schedule->toArray(),
        );

        return $mail->load(['sequence', 'schedule']);
    }
}
