<?php

namespace Database\Factories;

use Domain\Automation\Models\Automation;
use Illuminate\Database\Eloquent\Factories\Factory;

class AutomationFactory extends Factory
{
    protected $model = Automation::class;

    public function definition()
    {
        return [
            'name' => $this->faker->words(3, true),
        ];
    }
}
