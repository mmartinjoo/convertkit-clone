<?php

namespace Domain\Subscriber\Actions;

use Domain\Shared\Actions\ReadCsvAction;
use Domain\Shared\Models\User;
use Domain\Subscriber\DataTransferObjects\SubscriberData;
use Domain\Subscriber\Models\Subscriber;
use Domain\Subscriber\Models\Tag;

class ImportSubscribersAction
{
    public static function execute(string $path, User $user): void
    {
        ReadCsvAction::execute($path)
            ->each(function (array $row) use ($user) {
                $parsed = [
                    ...$row,
                    'tags' => self::parseTags($row, $user),
                ];

                $data = SubscriberData::from($parsed);

                if (self::isSubscriberExist($data, $user)) {
                    return;
                }

                UpsertSubscriberAction::execute($data, $user);
            });
    }

    /**
     * @param string[] $row
     * @param User $user
     * @return Tag[]
     */
    private static function parseTags(array $row, User $user): array
    {
        $tags = collect(explode(',', $row['tags']))
            ->filter()
            ->toArray();

        return self::getOrCreateTags($tags, $user);
    }

    /**
     * @param string[] $tags
     * @param User $user
     * @return Tag[]
     */
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
            ->whereBelongsTo($user)
            ->exists();
    }
}
