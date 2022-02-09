<?php

namespace Database\Factories;

use Domain\Mail\Models\Broadcast\Broadcast;
use Illuminate\Database\Eloquent\Factories\Factory;

class BroadcastFactory extends Factory
{
    protected $model = Broadcast::class;

    public function definition()
    {
        return [
            'title' => $this->faker->words(2, true),
            'content' => $this->faker->randomHtml(),
            'filters' => [],
            'status' => 'draft',
        ];
    }
}
