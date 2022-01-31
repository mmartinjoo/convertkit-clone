<?php

namespace Domain\Statistics\ViewModels\Tracking;

use Domain\Sequence\Models\Sequence;
use Domain\Shared\Models\SentMail;
use Domain\Shared\ViewModels\ViewModel;
use Domain\Statistics\DataTransferObjects\Tracking\TrackingData;
use Domain\Statistics\ValueObjects\Percent;
use Illuminate\Database\Eloquent\Builder;

class GetSequenceTrackingViewModel extends ViewModel
{
    public function __construct(private readonly Sequence $sequence)
    {
    }

    public function __invoke(): TrackingData
    {
        $total = $this->sentMails($this->sequence)->count();

        if ($total === 0) {
            return new TrackingData(
                total_sent_mails: 0,
                average_open_rate: Percent::from(0),
                average_click_rate: Percent::from(0),
            );
        }

        return new TrackingData(
            total_sent_mails: $total,
            average_open_rate: $this->averageOpenRate($total),
            average_click_rate: $this->averageClickRate($total),
        );
    }

    private function averageOpenRate(int $total): Percent
    {
        return Percent::from(
            $this->sentMails()
                ->whereOpened()
                ->count() / $total
        );
    }

    private function averageClickRate(int $total): Percent
    {
        return Percent::from(
            $this->sentMails()
                ->whereClicked()
                ->count() / $total
        );
    }

    private function sentMails(): Builder
    {
        return SentMail::query()
            ->whereIn('mailable_id', $this->sequence->mails()->pluck('id'))
            ->whereMailableType("Domain\\Sequence\\Models\\SequenceMail");
    }
}
