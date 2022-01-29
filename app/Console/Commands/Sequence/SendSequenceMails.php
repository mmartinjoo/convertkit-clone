<?php

namespace App\Console\Commands\Sequence;

use Domain\Sequence\Actions\ProceedSequenceAction;
use Domain\Sequence\Models\Sequence;
use Domain\Sequence\Enums\SequenceStatus;
use Illuminate\Console\Command;

class SendSequenceMails extends Command
{
    protected $signature = 'sequence:send';
    protected $description = 'Send the next mail in sequences';

    public function handle(): int
    {
        Sequence::whereStatus(SequenceStatus::STARTED)
            ->get()
            ->each(fn (Sequence $sequence) => ProceedSequenceAction::execute($sequence));

        return self::SUCCESS;
    }
}
