<?php

namespace Domain\Mail\Actions\Sequence;

use DB;
use Domain\Automation\Enums\Actions;
use Domain\Automation\Models\AutomationStep;
use Domain\Mail\Models\Sequence\Sequence;

class DeleteSequenceAction
{
    public static function execute(Sequence $sequence): void
    {
        DB::transaction(function () use ($sequence) {
            $sequence->mails()->delete();

            AutomationStep::query()
                ->whereName(Actions::AddToSequence)
                ->where('value->id', $sequence->id)
                ->delete();

            $sequence->delete();
        });
    }
}
