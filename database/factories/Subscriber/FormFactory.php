<?php

namespace Database\Factories\Subscriber;

use Domain\Shared\Models\User;
use Domain\Subscriber\Models\Form;
use Illuminate\Database\Eloquent\Factories\Factory;

class FormFactory extends Factory
{
    protected $model = Form::class;

    public function definition()
    {
        return [
            'title' => $this->faker->words(2, true),
            'content' => $this->faker->randomHtml(),
            'user_id' => User::factory(),
        ];
    }
}
