<?php

namespace Domain\Mail\Actions\Sequence;

use Domain\Mail\Models\Sequence\SequenceMail;

class DeleteSequenceMailAction
{
    public static function execute(SequenceMail $mail): void
    {
        $mail->delete();
    }
}
