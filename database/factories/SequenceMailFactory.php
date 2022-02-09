<?php

namespace Database\Factories;

use Domain\Mail\Enums\Sequence\SequenceMailStatus;
use Domain\Mail\Models\Sequence\Sequence;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Mail\Models\Sequence\SequenceMailSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class SequenceMailFactory extends Factory
{
    protected $model = SequenceMail::class;

    public function definition()
    {
        $statuses = SequenceMailStatus::cases();
        return [
            'sequence_id' => Sequence::factory(),
            'sequence_mail_schedule_id' => SequenceMailSchedule::factory(),
            'title' => $this->faker->words(3, true),
            'content' => $this->faker->randomHtml(),
            'status' => $statuses[rand(0, count($statuses) - 1)],
        ];
    }
}
