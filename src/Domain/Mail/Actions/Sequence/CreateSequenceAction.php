<?php

namespace Domain\Mail\Actions\Sequence;

use Domain\Mail\DataTransferObjects\Sequence\SequenceData;
use Domain\Mail\DataTransferObjects\Sequence\SequenceMailData;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Shared\Models\User;
use Domain\Subscriber\Models\Subscriber;

class CreateSequenceAction
{
    public static function execute(SequenceData $data, User $user): Sequence
    {
        $sequence = Sequence::create([
            ...$data->all(),
            'user_id' => $user->id,
        ]);

        $mailData = SequenceMailData::dummy();

        UpsertSequenceMailAction::execute($mailData, $sequence, $user);

        $sequence->subscribers()->sync(Subscriber::select('id')->pluck('id'));

        return $sequence;
    }
}
