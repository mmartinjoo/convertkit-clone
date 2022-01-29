<?php

namespace Domain\Sequence\Actions;

use Domain\Sequence\DataTransferObjects\SequenceMailData;
use Domain\Sequence\Models\Sequence;
use Domain\Sequence\Models\SequenceMail;

class CreateSequenceMailAction
{
    public static function execute(SequenceMailData $data, Sequence $sequence): SequenceMail
    {
        $mail = $sequence->mails()->create($data->toArray());
        return $mail->load('sequence');
    }
}
