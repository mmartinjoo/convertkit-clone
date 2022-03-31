<?php

namespace Tests\Feature\Automation;

use Domain\Automation\Actions\UpsertAutomationAction;
use Domain\Automation\DataTransferObjects\AutomationData;
use Domain\Automation\DataTransferObjects\AutomationStepData;
use Domain\Automation\Enums\Actions;
use Domain\Automation\Enums\Events;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Shared\Models\User;
use Domain\Subscriber\Actions\UpsertSubscriberAction;
use Domain\Subscriber\DataTransferObjects\SubscriberData;
use Domain\Subscriber\Models\Form;
use Domain\Subscriber\Models\Subscriber;
use Domain\Subscriber\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class RunAutomationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_add_tags()
    {
        $user = User::factory()->create();
        $form = Form::factory()->create();

        $laravel = Tag::factory(['title' => 'Laravel'])->create();
        $ddd = Tag::factory(['title' => 'DDD'])->create();

        UpsertAutomationAction::execute(
            AutomationData::from([
                'name' => 'Test Automation',
                'event' => new AutomationStepData(null, Events::SubscribedToForm->value, $form->id),
                'actions' => [
                    new AutomationStepData(null, Actions::AddTag->value, $laravel->id),
                    new AutomationStepData(null, Actions::AddTag->value, $ddd->id),
                ]
            ]),
            $user
        );

        $subscriber = UpsertSubscriberAction::execute(
            SubscriberData::from([
                'email' => 'test@example.net',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'subscribed_at' => now(),
                'form' => $form,
                'tags' => [],
            ]),
            $user
        );

        $this->assertTrue($subscriber->tags()->where('tags.id', $laravel->id)->exists());
        $this->assertTrue($subscriber->tags()->where('tags.id', $ddd->id)->exists());
    }

    /** @test */
    public function it_should_add_a_subscriber_to_a_sequence()
    {
        $user = User::factory()->create();
        $form = Form::factory()->create();

        $sequence = Sequence::factory()->create();

        UpsertAutomationAction::execute(
            AutomationData::from([
                'name' => 'Test Automation',
                'event' => new AutomationStepData(null, Events::SubscribedToForm->value, $form->id),
                'actions' => [
                    new AutomationStepData(null, Actions::AddToSequence->value, $sequence->id),
                ]
            ]),
            $user
        );

        $subscriber = UpsertSubscriberAction::execute(
            SubscriberData::from([
                'email' => 'test@example.net',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'subscribed_at' => now(),
                'form' => $form,
                'tags' => [],
            ]),
            $user
        );

        $this->assertTrue($sequence->subscribers()->where('subscriber_id', $subscriber->id)->exists());
    }

    /** @test */
    public function it_should_not_run_automations_if_subscriber_doesnt_have_the_form()
    {
        $user = User::factory()->create();
        $form = Form::factory()->create();

        $laravel = Tag::factory(['title' => 'Laravel'])->create();
        $ddd = Tag::factory(['title' => 'DDD'])->create();

        UpsertAutomationAction::execute(
            AutomationData::from([
                'name' => 'Test Automation',
                'event' => new AutomationStepData(null, Events::SubscribedToForm->value, $form->id),
                'actions' => [
                    new AutomationStepData(null, Actions::AddTag->value, $laravel->id),
                    new AutomationStepData(null, Actions::AddTag->value, $ddd->id),
                ]
            ]),
            $user
        );

        Queue::fake();

        UpsertSubscriberAction::execute(
            SubscriberData::from([
                'email' => 'test@example.net',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'subscribed_at' => now(),
                'form' => null,
                'tags' => [],
            ]),
            $user
        );

        Queue::assertNothingPushed();
    }

    /** @test */
    public function it_should_not_run_automations_if_the_subscriber_is_being_updated()
    {
        $user = User::factory()->create();
        $form = Form::factory()->create();

        $subscriber = Subscriber::factory(['form_id' => $form->id])->create();
        $sequence = Sequence::factory()->create();

        UpsertAutomationAction::execute(
            AutomationData::from([
                'name' => 'Test Automation',
                'event' => new AutomationStepData(null, Events::SubscribedToForm->value, $form->id),
                'actions' => [
                    new AutomationStepData(null, Actions::AddToSequence->value, $sequence->id),
                ]
            ]),
            $user
        );

        Queue::fake();

        UpsertSubscriberAction::execute(
            SubscriberData::from([
                ...$subscriber->load(['form', 'tags'])->getData()->all(),
            ]),
            $user
        );

        Queue::assertNothingPushed();
    }
}
