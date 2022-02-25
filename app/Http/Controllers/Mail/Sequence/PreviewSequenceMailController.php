<?php

namespace App\Http\Controllers\Mail\Sequence;

use App\Http\Controllers\Controller;
use Domain\Mail\Mails\EchoMail;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Models\Sequence\SequenceMail;

class PreviewSequenceMailController extends Controller
{
    public function __invoke(Sequence $sequence, SequenceMail $mail): EchoMail
    {
        return new EchoMail($mail);
    }
}
