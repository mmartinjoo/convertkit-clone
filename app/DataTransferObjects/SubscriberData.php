<?php

namespace App\DataTransferObjects;

use App\Models\Subscriber;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Lazy;

class SubscriberData extends Data
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $email,
        public readonly string $first_name,
        public readonly string $last_name,
        /** @var DataCollection<TagData> */
        public readonly null|Lazy|DataCollection $tags,
    ) {}

    public static function fromModel(Subscriber $subscriber): self
    {
        return self::from([
            ...$subscriber->toArray(),
            'tags' => Lazy::whenLoaded('tags', $subscriber, fn () => TagData::collection($subscriber->tags)),
        ]);
    }
}
