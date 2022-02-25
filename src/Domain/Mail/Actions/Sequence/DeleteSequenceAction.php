<?php

namespace Domain\Mail\Actions\Sequence;

use DB;
use Domain\Mail\Models\Sequence\Sequence;

class DeleteSequenceAction
{
    public static function execute(Sequence $sequence): void
    {
        DB::transaction(function () use ($sequence) {
            $sequence->subscribers()->detach();
            $sequence->mails->each->delete();
            $sequence->delete();
        });
    }
}
