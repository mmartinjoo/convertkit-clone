<?php

namespace Domain\Subscriber\Actions;

use Domain\Shared\Actions\ReadCsvAction;
use Domain\Shared\Models\User;
use Domain\Subscriber\DataTransferObjects\SubscriberData;
use Domain\Subscriber\Models\Subscriber;
use Domain\Subscriber\Models\Tag;

class ImportSubscribersAction
{
    public static function execute(string $path, User $user): int
    {
        return ReadCsvAction::execute($path)
            ->map(fn (array $row) => [
                ...$row,
                'tags' => collect(explode(',', $row['tags']))->filter()->toArray(),
            ])
            ->map(fn (array $row) => [
                ...$row,
                'tags' => self::getOrCreateTags($row['tags'], $user),
            ])
            ->map(fn (array $row) => SubscriberData::from($row))
            ->filter(fn (SubscriberData $data) => !self::isSubscriberExist($data, $user))
            ->map(fn (SubscriberData $data) => UpsertSubscriberAction::execute($data, $user))
            ->count();
    }

    private static function getOrCreateTags(array $tags, User $user): array
    {
        return collect($tags)
            ->map(fn (string $title) => Tag::firstOrCreate([
                'title' => $title,
                'user_id' => $user->id,
            ]))
            ->toArray();
    }

    private static function isSubscriberExist(SubscriberData $data, User $user): bool
    {
        return Subscriber::query()
            ->whereEmail($data->email)
            ->whereUserId($user->id)
            ->exists();
    }
}
