<?php

namespace Database\Factories;

use Domain\Mail\Enums\Sequence\SequenceMailUnit;
use Domain\Mail\Models\Sequence\SequenceMail;
use Domain\Mail\Models\Sequence\SequenceMailSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class SequenceMailScheduleFactory extends Factory
{
    protected $model = SequenceMailSchedule::class;

    public function definition()
    {
        $units = SequenceMailUnit::cases();
        return [
            'sequence_mail_id' => SequenceMail::factory(),
            'delay' => rand(1, 5),
            'unit' => $units[rand(0, count($units) - 1)]->value,
            'days' => [
                'monday' => true,
                'tuesday' => true,
                'wednesday' => true,
                'thursday' => true,
                'friday' => true,
                'saturday' => true,
                'sunday' => true,
            ],
        ];
    }
}
