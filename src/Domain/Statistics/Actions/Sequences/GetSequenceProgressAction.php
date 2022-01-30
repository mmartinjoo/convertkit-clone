<?php

namespace Domain\Statistics\Actions\Sequences;

use Domain\Sequence\Models\Sequence;
use Domain\Shared\Models\SentMail;
use Illuminate\Support\Facades\DB;

class GetSequenceProgressAction
{
    public static function execute(Sequence $sequence)
    {
        $mailCount = $sequence->mails()->count();

        return SentMail::query()
            ->select(DB::raw('subscriber_id, count(*) count'))
            ->whereIn('mailable_id', $sequence->mails()->pluck('id'))
            ->whereMailableType('Domain\\Sequence\\Models\\SequenceMail')
            ->groupBy('subscriber_id')
            ->get()
            ->map(function (SentMail $sentMail) use ($mailCount) {
                $sentMail->status = 'in-progress';
                if ($sentMail->count === $mailCount) {
                    $sentMail->status = 'completed';
                }

                return $sentMail;
            });
    }
}
