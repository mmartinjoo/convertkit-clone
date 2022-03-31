<?php

namespace Tests\Feature\Subscriber;

use Domain\Shared\Models\User;
use Domain\Subscriber\Actions\ImportSubscribersAction;
use Domain\Subscriber\Models\Subscriber;
use Domain\Subscriber\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImportSubscribersTest extends TestCase
{
    use RefreshDatabase;

    private const NUMBER_OF_SUBSCRIBERS_IN_CSV = 4;
    private const NUMBER_OF_TAGS_IN_CSV = 4;

    /** @test */
    public function it_should_import_subscribers()
    {
        $user = User::factory()->create();

        ImportSubscribersAction::execute(storage_path('testing/subscribers.csv'), $user);

        $this->assertDatabaseCount('subscribers', self::NUMBER_OF_SUBSCRIBERS_IN_CSV);
    }

    /** @test */
    public function it_should_import_subscribers_with_tags()
    {
        $user = User::factory()->create();

        ImportSubscribersAction::execute(storage_path('testing/subscribers.csv'), $user);

        $subscriber = Subscriber::whereEmail('first@example.com')->first();
        $this->assertTags($subscriber, ['Laravel', 'Vue', 'Inertia']);

        $subscriber = Subscriber::whereEmail('second@example.com')->first();
        $this->assertTags($subscriber, []);

        $subscriber = Subscriber::whereEmail('third@example.com')->first();
        $this->assertTags($subscriber, ['Laravel', 'DDD']);

        $subscriber = Subscriber::whereEmail('fourth@example.com')->first();
        $this->assertTags($subscriber, ['DDD']);
    }

    /** @test */
    public function it_should_not_duplicate_existing_subscribers()
    {
        $user = User::factory()->create();

        Subscriber::factory([
            'email' => 'first@example.com',
        ])->for($user)->create();

        ImportSubscribersAction::execute(storage_path('testing/subscribers.csv'), $user);

        $this->assertDatabaseCount('subscribers', self::NUMBER_OF_SUBSCRIBERS_IN_CSV);
    }

    /** @test */
    public function it_should_not_duplicate_existing_tags()
    {
        $user = User::factory()->create();

        Tag::factory(['title' => 'Laravel'])->for($user)->create();
        Tag::factory(['title' => 'DDD'])->for($user)->create();

        ImportSubscribersAction::execute(storage_path('testing/subscribers.csv'), $user);

        $this->assertDatabaseCount('tags', self::NUMBER_OF_TAGS_IN_CSV);
    }

    private function assertTags(Subscriber $subscriber, array $expectedTitles): void
    {
        $this->assertCount(count($expectedTitles), $subscriber->tags);

        foreach ($expectedTitles as $title) {
            $this->assertContains($title, $subscriber->tags->pluck('title'));
        }
    }
}
