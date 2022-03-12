<?php

namespace App\Console\Commands\Mail;

use Domain\Mail\Jobs\Sequence\ProceedSequenceJob;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Enums\Sequence\SequenceStatus;
use Illuminate\Console\Command;

class ProceedSequencesCommand extends Command
{
    protected $signature = 'sequence:proceed';
    protected $description = 'Send the next mail in sequences';

    public function handle(): int
    {
        $count = Sequence::with('mails.schedule')
            ->whereStatus(SequenceStatus::Published)
            ->get()
            ->each(fn (Sequence $sequence) => ProceedSequenceJob::dispatch($sequence))
            ->count();

        $this->info("{$count} sequences are being proceeded");

        return self::SUCCESS;
    }
}
