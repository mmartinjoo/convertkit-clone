<?php

namespace Database\Seeders\Automation;

use Database\Seeders\DatabaseSeeder;
use Domain\Automation\Enums\Actions;
use Domain\Automation\Enums\AutomationStepType;
use Domain\Automation\Enums\Events;
use Domain\Automation\Models\Automation;
use Domain\Automation\Models\AutomationStep;
use Domain\Mail\Actions\Broadcast\SendBroadcastAction;
use Domain\Mail\Enums\Broadcast\BroadcastStatus;
use Domain\Mail\Models\Broadcast\Broadcast;
use Domain\Mail\Models\SentMail;
use Domain\Mail\Models\Sequence\Sequence;
use Queue;

class AutomationSeeder extends DatabaseSeeder
{
    public function run()
    {
        $demoUser = $this->demoUser();
        $automation = Automation::create([
            'name' => 'Add To Newsletter',
            'user_id' => $demoUser->id,
        ]);

        $automation->steps()->create([
            'type' => AutomationStepType::Event,
            'name' => Events::SubscribedToForm,
            'value' => ['id' => $this->formId('Waiting List')],
        ]);

        $automation->steps()->create([
            'type' => AutomationStepType::Action,
            'name' => Actions::AddToSequence,
            'value' => ['id' => Sequence::whereTitle('My Newsletter')->firstOrFail()->id],
        ]);
    }
}
