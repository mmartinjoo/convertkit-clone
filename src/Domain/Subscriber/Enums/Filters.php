<?php

namespace Domain\Subscriber\Enums;

use Domain\Subscriber\Filters\Filter;
use Domain\Subscriber\Filters\FormFilter;
use Domain\Subscriber\Filters\TagFilter;

enum Filters: string
{
    case Tags = 'tag_ids';
    case Forms = 'form_ids';

    public function createFilter(array $ids): Filter
    {
        return match ($this) {
            self::Tags => new TagFilter($ids),
            self::Forms => new FormFilter($ids),
        };
    }
}
