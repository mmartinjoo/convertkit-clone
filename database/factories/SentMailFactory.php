<?php

namespace Database\Factories;

use Domain\Mail\Models\Broadcast\Broadcast;
use Domain\Shared\Models\SentMail;
use Domain\Subscriber\Models\Subscriber;
use Illuminate\Database\Eloquent\Factories\Factory;

class SentMailFactory extends Factory
{
    protected $model = SentMail::class;

    public function definition()
    {
        return [
            'mailable_id' => Broadcast::factory(),
            'mailable_type' => Broadcast::class,
            'subscriber_id' => Subscriber::factory(),
            'sent_at' => now(),
        ];
    }
}
