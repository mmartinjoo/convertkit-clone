<?php

namespace Tests\Feature\Sequence;

use Domain\Mail\Actions\Sequence\CreateSequenceAction;
use Domain\Mail\Actions\Sequence\ProceedSequenceAction;
use Domain\Mail\Actions\Sequence\UpsertSequenceMailAction;
use Domain\Mail\DataTransferObjects\FilterData;
use Domain\Mail\DataTransferObjects\Sequence\SequenceData;
use Domain\Mail\DataTransferObjects\Sequence\SequenceMailData;
use Domain\Mail\DataTransferObjects\Sequence\SequenceMailScheduleAllowedDaysData;
use Domain\Mail\Enums\Sequence\SequenceMailUnit;
use Domain\Mail\Enums\Sequence\SubscriberStatus;
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
    public function it_should_proceed_subscribers_at_a_different_phase()
    {
        $user = User::factory()->create();

        $laravel = Tag::factory([
            'title' => 'Laravel',
        ])->for($user)->create();

        $vue = Tag::factory([
            'title' => 'Vue',
        ])->for($user)->create();

        $laravelSubscriber = Subscriber::factory([
            'first_name' => 'Laravel',
        ])->for($user)->create();

        $vueSubscriber = Subscriber::factory([
            'first_name' => 'Vue',
        ])->for($user)->create();

        $laravelSubscriber->tags()->attach($laravel->id);
        $vueSubscriber->tags()->attach($vue->id);

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

        $generalMailData = SequenceMail::factory()->for($sequence)->for($user)->published()->make();
        $generalMail = UpsertSequenceMailAction::execute(
            SequenceMailData::from([
                ...$generalMailData->toArray(),
                'filters' => [],
                'schedule' => [
                    'delay' => 1,
                    'unit' => SequenceMailUnit::Hour->value,
                    'allowed_days' => SequenceMailScheduleAllowedDaysData::empty(),
                ]
            ]),
            $sequence,
            $user
        );

        ProceedSequenceAction::execute($sequence);

        $this->assertDatabaseHas('sent_mails', [
            'sendable_id' => $laravelMail->id,
            'subscriber_id' => $laravelSubscriber->id,
        ]);

        $this->assertDatabaseHas('sent_mails', [
            'sendable_id' => $vueMail->id,
            'subscriber_id' => $vueSubscriber->id,
        ]);

        $this->assertDatabaseHas('sequence_subscriber', [
            'sequence_id' => $sequence->id,
            'subscriber_id' => $laravelSubscriber->id,
            'status' => SubscriberStatus::InProgress,
        ]);

        $this->assertDatabaseHas('sequence_subscriber', [
            'sequence_id' => $sequence->id,
            'subscriber_id' => $vueSubscriber->id,
            'status' => SubscriberStatus::InProgress,
        ]);

        $this->travelTo(now()->addHours(2), function () use ($sequence, $laravelSubscriber, $vueSubscriber, $generalMail) {
            ProceedSequenceAction::execute($sequence);

            $this->assertDatabaseHas('sent_mails', [
                'sendable_id' => $generalMail->id,
                'subscriber_id' => $laravelSubscriber->id,
            ]);

            $this->assertDatabaseHas('sent_mails', [
                'sendable_id' => $generalMail->id,
                'subscriber_id' => $vueSubscriber->id,
            ]);

            $this->assertDatabaseHas('sequence_subscriber', [
                'sequence_id' => $sequence->id,
                'subscriber_id' => $laravelSubscriber->id,
                'status' => SubscriberStatus::Completed,
            ]);

            $this->assertDatabaseHas('sequence_subscriber', [
                'sequence_id' => $sequence->id,
                'subscriber_id' => $vueSubscriber->id,
                'status' => SubscriberStatus::Completed,
            ]);
        });
    }

    /** @test */
    public function it_should_proceed_subscribers_at_the_same_phase()
    {
        $user = User::factory()->create();

        $subscriber1 = Subscriber::factory()->for($user)->create();
        $subscriber2 = Subscriber::factory()->for($user)->create();

        $sequence = CreateSequenceAction::execute(
            SequenceData::from(Sequence::factory(['title' => 'My Seqi'])->for($user)->make()),
            $user
        );

        $mail1Data = SequenceMail::factory()->for($sequence)->for($user)->published()->make();
        $mail1 = UpsertSequenceMailAction::execute(
            SequenceMailData::from([
                ...$mail1Data->toArray(),
                'filters' => [],
                'schedule' => [
                    'delay' => 1,
                    'unit' => SequenceMailUnit::Hour->value,
                    'allowed_days' => SequenceMailScheduleAllowedDaysData::empty(),
                ]
            ]),
            $sequence,
            $user
        );

        $mail2Data = SequenceMail::factory()->for($sequence)->for($user)->published()->make();
        $mail2 = UpsertSequenceMailAction::execute(
            SequenceMailData::from([
                ...$mail2Data->toArray(),
                'filters' => [],
                'schedule' => [
                    'delay' => 1,
                    'unit' => SequenceMailUnit::Hour->value,
                    'allowed_days' => SequenceMailScheduleAllowedDaysData::empty(),
                ]
            ]),
            $sequence,
            $user
        );

        ProceedSequenceAction::execute($sequence);

        $this->assertDatabaseHas('sent_mails', [
            'sendable_id' => $mail1->id,
            'subscriber_id' => $subscriber1->id,
        ]);

        $this->assertDatabaseHas('sent_mails', [
            'sendable_id' => $mail1->id,
            'subscriber_id' => $subscriber2->id,
        ]);

        $this->assertDatabaseHas('sequence_subscriber', [
            'sequence_id' => $sequence->id,
            'subscriber_id' => $subscriber1->id,
            'status' => SubscriberStatus::InProgress,
        ]);

        $this->assertDatabaseHas('sequence_subscriber', [
            'sequence_id' => $sequence->id,
            'subscriber_id' => $subscriber2->id,
            'status' => SubscriberStatus::InProgress,
        ]);

        $this->travelTo(now()->addHours(2), function () use ($sequence, $subscriber1, $subscriber2, $mail2) {
            ProceedSequenceAction::execute($sequence);

            $this->assertDatabaseHas('sent_mails', [
                'sendable_id' => $mail2->id,
                'subscriber_id' => $subscriber1->id,
            ]);

            $this->assertDatabaseHas('sent_mails', [
                'sendable_id' => $mail2->id,
                'subscriber_id' => $subscriber2->id,
            ]);

            $this->assertDatabaseHas('sequence_subscriber', [
                'sequence_id' => $sequence->id,
                'subscriber_id' => $subscriber1->id,
                'status' => SubscriberStatus::Completed,
            ]);

            $this->assertDatabaseHas('sequence_subscriber', [
                'sequence_id' => $sequence->id,
                'subscriber_id' => $subscriber2->id,
                'status' => SubscriberStatus::Completed,
            ]);
        });
    }
}
