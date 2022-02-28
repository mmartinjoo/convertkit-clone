<?php

namespace Database\Factories\Automation;

use Domain\Automation\Models\Automation;
use Domain\Shared\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AutomationFactory extends Factory
{
    protected $model = Automation::class;

    public function definition()
    {
        return [
            'name' => $this->faker->words(3, true),
            'user_id' => User::factory(),
        ];
    }
}
