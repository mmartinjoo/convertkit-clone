<?php

namespace Domain\Mail\Models\Casts;

use Domain\Shared\DataTransferObjects\FilterData;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Collection;
use Spatie\LaravelData\DataCollection;
use function collect;

class FiltersCast implements CastsAttributes
{
    /**
     * @return Collection<FilterData>
     */
    public function get($model, string $key, $value, array $attributes): Collection
    {
        $filtersArray = json_decode($value, true);
        $filtersArray = $filtersArray ?: [];
        $filtersData = collect([]);

        foreach ($filtersArray as $filter) {
            $filtersData[] = FilterData::from([
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
