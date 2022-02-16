<?php

namespace Domain\Mail\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class FilterData extends Data
{
    public function __construct(
        public readonly array $form_ids,
        public readonly array $tag_ids,
    ) {}

    /**
     * @param Request $request
     * @return DataCollection<FilterData>
     */
    public static function collectionFromRequest(Request $request): DataCollection
    {
        $filters = [];
        $formIds = $request->input('filters.form_ids');
        $tagIds = $request->input('filters.tag_ids');

        if ($formIds) {
            $filters[] = [
                'type' => 'form',
                'value' => $formIds,
            ];
        }

        if ($tagIds) {
            $filters[] = [
                'type' => 'tag',
                'value' => $tagIds,
            ];
        }

        return self::collection($filters);
    }
}
