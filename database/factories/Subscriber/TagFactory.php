<?php

namespace Database\Factories\Subscriber;

use Domain\Shared\Models\User;
use Domain\Subscriber\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition()
    {
        return [
            'title' => $this->faker->words(3, true),
            'user_id' => User::factory(),
        ];
    }
}
