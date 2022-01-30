<?php

namespace App\Console\Commands\Sequence;

use Domain\Sequence\Actions\ProceedSequenceAction;
use Domain\Sequence\Models\Sequence;
use Domain\Sequence\Enums\SequenceStatus;
use Illuminate\Console\Command;

class ProceedSequenceMailsCommand extends Command
{
    protected $signature = 'sequence:proceed';
    protected $description = 'Send the next mail in sequences';

    public function handle(): int
    {
        $countsBySequence = Sequence::with('mails.schedule')
            ->whereStatus(SequenceStatus::STARTED)
            ->get()
            ->map(fn (Sequence $sequence) => ProceedSequenceAction::execute($sequence));

        $this->info("{$countsBySequence->sum()} mails have been sent to subscribers");
        return self::SUCCESS;
    }
}
