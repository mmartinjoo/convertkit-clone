<?php

namespace Database\Factories\Mail;

use Domain\Mail\Models\Broadcast\Broadcast;
use Domain\Mail\Models\SentMail;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Database\Eloquent\Factories\Factory;
use function now;

class SentMailFactory extends Factory
{
    protected $model = SentMail::class;

    public function definition()
    {
        return [
            'sendable_id' => Broadcast::factory(),
            'sendable_type' => Broadcast::class,
            'subscriber_id' => Subscriber::factory(),
            'sent_at' => now(),
        ];
    }
}
