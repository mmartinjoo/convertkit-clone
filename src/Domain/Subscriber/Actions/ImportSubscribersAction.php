<?php

namespace Domain\Subscriber\Actions;

use Domain\Shared\Actions\ReadCsvAction;
use Domain\Subscriber\DataTransferObjects\SubscriberData;
use Domain\Subscriber\Models\Subscriber;
use Domain\Subscriber\Models\Tag;

class ImportSubscribersAction
{
    public static function execute(string $path): int
    {
        return ReadCsvAction::execute($path)
            ->map(fn (array $row) => [
                ...$row,
                'tags' => collect(explode(',', $row['tags']))->filter()->toArray(),
            ])
            ->map(fn (array $row) => [
                ...$row,
                'tags' => self::getOrCreateTags($row['tags']),
            ])
            ->map(fn (array $row) => SubscriberData::from($row))
            ->filter(fn (SubscriberData $data) => !Subscriber::whereEmail($data->email)->exists())
            ->map(fn (SubscriberData $data) => CreateSubscriberAction::execute($data))
            ->count();
    }

    private static function getOrCreateTags(array $tags): array
    {
        return collect($tags)
            ->map(fn (string $title) => Tag::firstOrCreate([
                'title' => $title,
            ]))
            ->toArray();
    }
}
