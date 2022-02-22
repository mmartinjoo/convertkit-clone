<?php

namespace Database\Factories;

use Domain\Automation\Models\Automation;
use Domain\Automation\Models\AutomationStep;
use Illuminate\Database\Eloquent\Factories\Factory;

class AutomationStepFactory extends Factory
{
    protected $model = AutomationStep::class;

    public function definition()
    {
        $types = [
            'event',
            'action',
        ];
        $names = [
            'addToSequence',
            'addTag',
        ];

        return [
            'type' => collect($types)->random(),
            'name' => collect($names)->random(),
            'automation_id' => Automation::factory(),
            'value' => [],
        ];
    }
}
