<?php

namespace Database\Factories\Mail;

use Domain\Mail\Enums\Broadcast\BroadcastStatus;
use Domain\Mail\Models\Broadcast\Broadcast;
use Domain\Shared\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BroadcastFactory extends Factory
{
    protected $model = Broadcast::class;

    public function definition()
    {
        return [
            'subject' => $this->faker->words(2, true),
            'content' => $this->faker->randomHtml(),
            'filters' => [],
            'status' => BroadcastStatus::Draft,
            'user_id' => User::factory(),
        ];
    }
}
