<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FormFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->words(2, true),
        ];
    }
}
