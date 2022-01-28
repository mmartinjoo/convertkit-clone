<?php

namespace Database\Factories;

use Domain\Subscriber\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition()
    {
        return [
            'title' => $this->faker->words(1, true),
        ];
    }
}
