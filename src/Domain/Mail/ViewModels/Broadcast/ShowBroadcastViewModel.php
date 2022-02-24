<?php

namespace Domain\Mail\ViewModels\Broadcast;

use Domain\Mail\Actions\GetPerformanceAction;
use Domain\Mail\DataTransferObjects\Broadcast\BroadcastData;
use Domain\Mail\Models\Broadcast\Broadcast;
use Domain\Shared\ViewModels\Concerns\HasForms;
use Domain\Shared\ViewModels\Concerns\HasTags;
use Domain\Shared\ViewModels\ViewModel;
use Domain\Report\DataTransferObjects\PerformanceData;

class ShowBroadcastViewModel extends ViewModel
{
    use HasTags;
    use HasForms;

    public function __construct(private readonly Broadcast $broadcast)
    {
    }

    public function broadcast(): BroadcastData
    {
        return $this->broadcast->getData();
    }

    /**
     * @return PerformanceData
     */
    public function performance(): PerformanceData
    {
        return GetPerformanceAction::execute($this->broadcast);
    }
}
