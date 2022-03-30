<?php

namespace Tests\Feature\Sequence;

use Domain\Mail\Actions\Sequence\CreateSequenceAction;
use Domain\Mail\Actions\Sequence\UpsertSequenceMailAction;
use Domain\Mail\DataTransferObjects\FilterData;
use Domain\Mail\DataTransferObjects\Sequence\SequenceData;
use Domain\Mail\DataTransferObjects\Sequence\SequenceMailData;
use Domain\Mail\DataTransferObjects\Sequence\SequenceMailScheduleAllowedDaysData;
use Domain\Mail\Enums\Sequence\SequenceMailUnit;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Shared\Models\User;
use Domain\Subscriber\Models\Subscriber;
use Domain\Subscriber\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProceedSequenceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_proceed_a_sequence()
    {
        $user = User::factory()->create();

        $laravel = Tag::factory([
            'title' => 'Laravel',
        ])->for($user)->create();

        $vue = Tag::factory([
            'title' => 'Vue',
        ])->for($user)->create();

        $subscriber1 = Subscriber::factory([
            'first_name' => 'Laravel',
        ])->for($user)->create();

        $subscriber2 = Subscriber::factory([
            'first_name' => 'Vue',
        ])->for($user)->create();

        $subscriber1->tags()->attach($laravel->id);
        $subscriber2->tags()->attach($vue->id);

        $sequence = CreateSequenceAction::execute(
            SequenceData::from(Sequence::factory()->for($user)->make()),
            $user
        );

        $laravelMailData = SequenceMail::factory()->for($sequence)->for($user)->published()->make();
        $laravelMailFilter = FilterData::from([
            'form_ids' => [],
            'tag_ids' => [$laravel->id],
        ]);

        $laravelMail = UpsertSequenceMailAction::execute(
            SequenceMailData::from([
                ...$laravelMailData->toArray(),
                'filters' => $laravelMailFilter,
                'schedule' => [
                    'delay' => 1,
                    'unit' => SequenceMailUnit::Hour->value,
                    'allowed_days' => SequenceMailScheduleAllowedDaysData::empty(),
                ]
            ]),
            $sequence,
            $user
        );

        $vueMailData = SequenceMail::factory()->for($sequence)->for($user)->published()->make();
        $vueMailFilter = FilterData::from([
            'form_ids' => [],
            'tag_ids' => [$vue->id],
        ]);

        $vueMail = UpsertSequenceMailAction::execute(
            SequenceMailData::from([
                ...$vueMailData->toArray(),
                'filters' => $vueMailFilter,
                'schedule' => [
                    'delay' => 1,
                    'unit' => SequenceMailUnit::Hour->value,
                    'allowed_days' => SequenceMailScheduleAllowedDaysData::empty(),
                ]
            ]),
            $sequence,
            $user
        );

        $this->artisan('sequence:proceed');
    }
}
