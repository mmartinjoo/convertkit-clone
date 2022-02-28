<?php

namespace Database\Seeders\Subscriber;

use Carbon\Carbon;
use Database\Seeders\DatabaseSeeder;
use Domain\Subscriber\Models\Form;
use Domain\Subscriber\Models\Subscriber;
use Domain\Subscriber\Models\Tag;
use Illuminate\Support\Collection;
use function collect;
use function now;

class SubscriberSeeder extends DatabaseSeeder
{
    public function run()
    {
        $demoUser = $this->demoUser();

        $tags = $this->tags()->map(fn (string $title) =>
            Tag::factory(compact('title'))->for($demoUser)->create()
        );

        $forms = $this->forms()->map(fn (string $title) =>
            Form::factory(compact('title'))->for($demoUser)->create()
        );

        $subscribers = $this->range(1, 200)->map(fn () =>
            Subscriber::factory([
                'form_id' => $this->byChance(0.67, $forms, fn (Collection $forms) => $forms->random()),
                'subscribed_at' => $this->last30Days(),
            ])
            ->for($demoUser)
            ->create()
        );

        $subscribers->each(function (Subscriber $subscriber) use ($tags) {
            $this->byChance(0.67, $tags, fn (Collection $tags) =>
            $tags
                ->take(rand(1, 10))
                ->each(fn (Tag $tag) => $subscriber->tags()->attach($tag->id))
            );
        });
    }

    /**
     * @return Collection<string>
     */
    private function tags(): Collection
    {
        return collect([
            'Laravel', 'Vue', 'MySQL', 'Inertia', 'DDD', 'TDD', 'Clean Code', 'Microservices', 'Docker',
        ]);
    }

    /**
     * @return Collection<string>
     */
    private function forms(): Collection
    {
        return collect([
            'Waiting List', 'Join The Newsletter', 'Free Tutorial',
        ]);
    }

    private function byChance(float $chance, Collection $items, callable $action): mixed
    {
        return rand(0, 100) <= $chance * 100
            ? $action($items)
            : null;
    }

    private function range(int $from, int $to): Collection
    {
        return collect(range($from, $to));
    }

    private function last30Days(): Carbon
    {
        return now()->subDays(rand(0, 30));
    }
}
