<?php

namespace App\Http\Web\Controllers\Mail\Sequence;

use Domain\Mail\Mails\EchoMail;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Models\Sequence\SequenceMail;

class PreviewSequenceMailController
{
    public function __invoke(Sequence $sequence, SequenceMail $mail): EchoMail
    {
        return new EchoMail($mail);
    }
}
