<?php

namespace Database\Factories\Mail;

use Domain\Mail\Enums\Sequence\SequenceMailStatus;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Shared\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SequenceMailFactory extends Factory
{
    protected $model = SequenceMail::class;

    public function definition()
    {
        $statuses = SequenceMailStatus::cases();

        return [
            'sequence_id' => Sequence::factory(),
            'subject' => $this->faker->words(3, true),
            'content' => $this->faker->randomHtml(),
            'status' => $statuses[rand(0, count($statuses) - 1)],
            'user_id' => User::factory(),
        ];
    }

    public function published()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => SequenceMailStatus::Published,
            ];
        });
    }
}
