<?php

namespace Database\Factories\Mail;

use Domain\Mail\Enums\Sequence\SequenceStatus;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Shared\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SequenceFactory extends Factory
{
    protected $model = Sequence::class;

    public function definition()
    {
        $statuses = SequenceStatus::cases();
        return [
            'title' => $this->faker->words(4, true),
            'status' => $statuses[rand(0, count($statuses) - 1)]->value,
            'user_id' => User::factory(),
        ];
    }
}
