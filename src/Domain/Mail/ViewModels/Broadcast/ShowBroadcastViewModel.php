<?php

namespace Domain\Mail\ViewModels\Broadcast;

use Domain\Mail\DataTransferObjects\Broadcast\BroadcastData;
use Domain\Mail\Models\Broadcast\Broadcast;
use Domain\Shared\ViewModels\ViewModel;
use Domain\Statistics\DataTransferObjects\Tracking\TrackingData;
use Domain\Subscriber\DataTransferObjects\FormData;
use Domain\Subscriber\DataTransferObjects\TagData;
use Domain\Subscriber\Models\Form;
use Domain\Subscriber\Models\Tag;
use Illuminate\Support\Collection;

class ShowBroadcastViewModel extends ViewModel
{
    public function __construct(private readonly Broadcast $broadcast)
    {
    }

    public function broadcast(): BroadcastData
    {
        return BroadcastData::from($this->broadcast);
    }

    /**
     * @return TrackingData
     */
    public function performance(): TrackingData
    {
        return $this->broadcast->getPerformance();
    }

    /**
     * @return Collection<TagData>
     */
    public function tags(): Collection
    {
        return Tag::all()->map(fn (Tag $tag) => TagData::from($tag));
    }

    /**
     * @return Collection<FormData>
     */
    public function forms(): Collection
    {
        return Form::all()->map(fn (Form $tag) => FormData::from($tag));
    }
}
