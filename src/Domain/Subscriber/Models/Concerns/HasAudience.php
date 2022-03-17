<?php

namespace Domain\Subscriber\Models\Concerns;

use Domain\Mail\DataTransferObjects\FilterData;
use Domain\Subscriber\Enums\Filters;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;

trait HasAudience
{
    abstract public function filters(): FilterData;
    abstract protected function audienceQuery(): Builder;

    /**
     * @return Collection<Subscriber>
     */
    public function audience(): Collection
    {
        $filters = collect($this->filters()->toArray())
            ->map(fn(array $ids, string $key) => Filters::from($key)->createFilter($ids))
            ->values()
            ->all();

        return app(Pipeline::class)
            ->send($this->audienceQuery()->whereBelongsTo($this->user))
            ->through($filters)
            ->thenReturn()
            ->get();
    }
}
