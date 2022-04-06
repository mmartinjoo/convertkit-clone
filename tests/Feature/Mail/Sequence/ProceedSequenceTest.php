<?php

namespace Tests\Feature\Mail\Sequence;

use Domain\Mail\Actions\Sequence\CreateSequenceAction;
use Domain\Mail\Actions\Sequence\ProceedSequenceAction;
use Domain\Mail\Actions\Sequence\UpsertSequenceMailAction;
use Domain\Mail\DataTransferObjects\FilterData;
use Domain\Mail\DataTransferObjects\Sequence\SequenceData;
use Domain\Mail\DataTransferObjects\Sequence\SequenceMailData;
use Domain\Mail\DataTransferObjects\Sequence\SequenceMailScheduleAllowedDaysData;
use Domain\Mail\Enums\Sequence\SequenceMailUnit;
use Domain\Mail\Enums\Sequence\SubscriberStatus;
use Domain\Mail\Mails\EchoMail;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Shared\Models\User;
use Domain\Subscriber\Models\Subscriber;
use Domain\Subscriber\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mail;
use Tests\TestCase;

class ProceedSequenceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
    }

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

        $laravelMailFilter = FilterData::from([
            'form_ids' => [],
            'tag_ids' => [$laravel->id],
        ]);

        $laravelMail = $this->createMail($sequence, $user, $laravelMailFilter);

        $vueMailFilter = FilterData::from([
            'form_ids' => [],
            'tag_ids' => [$vue->id],
        ]);

        $vueMail = $this->createMail($sequence, $user, $vueMailFilter);
        $generalMail = $this->createMail($sequence, $user);

        ProceedSequenceAction::execute($sequence);

        $this->assertMailSent($laravelMail, $laravelSubscriber);
        $this->assertMailSent($vueMail, $vueSubscriber);

        $this->assertInProgress($sequence, $laravelSubscriber);
        $this->assertInProgress($sequence, $vueSubscriber);

        $this->travelTo(now()->addHours(2), function () use ($sequence, $laravelSubscriber, $vueSubscriber, $generalMail) {
            ProceedSequenceAction::execute($sequence);

            $this->assertMailSent($generalMail, $laravelSubscriber);
            $this->assertMailSent($generalMail, $vueSubscriber);

            $this->assertCompleted($sequence, $laravelSubscriber);
            $this->assertCompleted($sequence, $vueSubscriber);
        });
    }

    /** @test */
    public function it_should_proceed_subscribers_at_the_same_phase()
    {
        $user = User::factory()->create();

        $subscriber1 = Subscriber::factory()->for($user)->create();
        $subscriber2 = Subscriber::factory()->for($user)->create();

        $sequence = CreateSequenceAction::execute(
            SequenceData::from(Sequence::factory()->for($user)->make()),
            $user
        );

        $mail1 = $this->createMail($sequence, $user);
        $mail2 = $this->createMail($sequence, $user);

        ProceedSequenceAction::execute($sequence);

        $this->assertMailSent($mail1, $subscriber1);
        $this->assertMailSent($mail1, $subscriber2);

        $this->assertInProgress($sequence, $subscriber1);
        $this->assertInProgress($sequence, $subscriber2);

        $this->travelTo(now()->addHours(2), function () use ($sequence, $subscriber1, $subscriber2, $mail2) {
            ProceedSequenceAction::execute($sequence);

            $this->assertMailSent($mail2, $subscriber1);
            $this->assertMailSent($mail2, $subscriber2);

            $this->assertCompleted($sequence, $subscriber1);
            $this->assertCompleted($sequence, $subscriber2);
        });
    }

    /** @test */
    public function it_should_not_send_mails_if_its_too_early()
    {
        $user = User::factory()->create();

        $subscriber1 = Subscriber::factory()->for($user)->create();
        $subscriber2 = Subscriber::factory()->for($user)->create();

        $sequence = CreateSequenceAction::execute(
            SequenceData::from(Sequence::factory()->for($user)->make()),
            $user
        );

        $mail1 = $this->createMail($sequence, $user);
        $mail2 = $this->createMail($sequence, $user);

        ProceedSequenceAction::execute($sequence);

        $this->assertMailSent($mail1, $subscriber1);
        $this->assertMailSent($mail1, $subscriber2);

        ProceedSequenceAction::execute($sequence);

        $this->assertMailNotSent($mail2, $subscriber1);
        $this->assertMailNotSent($mail2, $subscriber2);

        $this->assertInProgress($sequence, $subscriber1);
        $this->assertInProgress($sequence, $subscriber2);
    }

    /** @test */
    public function it_should_not_send_mails_if_its_not_the_right_day()
    {
        $user = User::factory()->create();

        $subscriber1 = Subscriber::factory()->for($user)->create();
        $subscriber2 = Subscriber::factory()->for($user)->create();

        $sequence = CreateSequenceAction::execute(
            SequenceData::from(Sequence::factory()->for($user)->make()),
            $user
        );

        $mail1Data = SequenceMail::factory()->for($sequence)->for($user)->published()->make();
        $mail = UpsertSequenceMailAction::execute(
            SequenceMailData::from([
                ...$mail1Data->toArray(),
                'filters' => [],
                'schedule' => [
                    'delay' => 1,
                    'unit' => SequenceMailUnit::Hour->value,
                    'allowed_days' => [
                        'monday' => true,
                        'tuesday' => false,
                        'wednesday' => false,
                        'thursday' => false,
                        'friday' => false,
                        'saturday' => false,
                        'sunday' => false,
                    ],
                ]
            ]),
            $sequence,
            $user
        );

        // Not monday
        $this->travelTo('2022-03-30', function () use ($sequence, $mail, $subscriber1, $subscriber2) {
            ProceedSequenceAction::execute($sequence);

            $this->assertMailNotSent($mail, $subscriber1);
            $this->assertMailNotSent($mail, $subscriber2);

            $this->assertNotStarted($sequence, $subscriber1);
            $this->assertNotStarted($sequence, $subscriber2);
        });
    }

    private function assertMailSent(SequenceMail $mail, Subscriber $subscriber): void
    {
        $this->assertDatabaseHas('sent_mails', [
            'sendable_id' => $mail->id,
            'subscriber_id' => $subscriber->id,
        ]);

        Mail::assertQueued(EchoMail::class, fn (EchoMail $echoMail) =>
            $echoMail->mail->id() === $mail->id
        );
    }

    private function assertMailNotSent(SequenceMail $mail, Subscriber $subscriber): void
    {
        $this->assertDatabaseMissing('sent_mails', [
            'sendable_id' => $mail->id,
            'subscriber_id' => $subscriber->id,
        ]);

        Mail::assertNotQueued(EchoMail::class, fn (EchoMail $echoMail) =>
            $echoMail->mail->id() === $mail->id
        );
    }

    private function assertInProgress(Sequence $sequence, Subscriber $subscriber): void
    {
        $this->assertDatabaseHas('sequence_subscriber', [
            'sequence_id' => $sequence->id,
            'subscriber_id' => $subscriber->id,
            'status' => SubscriberStatus::InProgress,
        ]);
    }

    private function assertCompleted(Sequence $sequence, Subscriber $subscriber): void
    {
        $this->assertDatabaseHas('sequence_subscriber', [
            'sequence_id' => $sequence->id,
            'subscriber_id' => $subscriber->id,
            'status' => SubscriberStatus::Completed,
        ]);
    }

    private function assertNotStarted(Sequence $sequence, Subscriber $subscriber): void
    {
        $this->assertDatabaseHas('sequence_subscriber', [
            'sequence_id' => $sequence->id,
            'subscriber_id' => $subscriber->id,
            'status' => null,
        ]);
    }

    private function createMail(Sequence $sequence, User $user, ?FilterData $filters = null): SequenceMail
    {
        $generalMailData = SequenceMail::factory()->for($sequence)->for($user)->published()->make();

        return UpsertSequenceMailAction::execute(
            SequenceMailData::from([
                ...$generalMailData->toArray(),
                'filters' => $filters ?? [],
                'schedule' => [
                    'delay' => 1,
                    'unit' => SequenceMailUnit::Hour->value,
                    'allowed_days' => SequenceMailScheduleAllowedDaysData::empty(),
                ]
            ]),
            $sequence,
            $user
        );
    }
}
