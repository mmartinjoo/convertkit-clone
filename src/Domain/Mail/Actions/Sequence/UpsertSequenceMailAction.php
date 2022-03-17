<?php

namespace Domain\Mail\Actions\Sequence;

use Domain\Mail\DataTransferObjects\Sequence\SequenceMailData;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Shared\Models\User;

class UpsertSequenceMailAction
{
    public static function execute(SequenceMailData $data, Sequence $sequence, User $user): SequenceMail
    {
        $mail = $sequence->mails()->updateOrCreate(
            [
                'id' => $data->id,
            ],
            [
                ...$data->toArray(),
                'user_id' => $user->id,
            ],
        );

        $mail->schedule()->updateOrCreate(
            [
                'id' => $data->schedule->id
            ],
            [
                ...$data->schedule->toArray(),
                'user_id' => $user->id,
            ],
        );

        return $mail->load(['sequence', 'schedule']);
    }
}
