<?php

namespace Database\Factories;

use Domain\Sequence\Enums\SequenceMailStatus;
use Domain\Sequence\Models\Sequence;
use Domain\Sequence\Models\SequenceMail;
use Domain\Sequence\Models\SequenceMailSchedule;
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
