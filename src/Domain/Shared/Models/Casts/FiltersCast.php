<?php

namespace Domain\Shared\Models\Casts;

use Domain\Broadcast\DataTransferObjects\BroadcastFilterData;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Collection;
use Spatie\LaravelData\DataCollection;

class FiltersCast implements CastsAttributes
{
    /**
     * @return Collection<BroadcastFilterData>
     */
    public function get($model, string $key, $value, array $attributes): Collection
    {
        $filtersArray = json_decode($value, true);
        $filtersData = collect([]);

        foreach ($filtersArray as $filter) {
            $filtersData[] = BroadcastFilterData::from([
                'type' => $filter['type'],
                'value' => $filter['value'],
            ]);
        }

        return $filtersData;
    }

    /**
     * @param DataCollection $value
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return [
            'filters' => json_encode($value),
        ];
    }
}
