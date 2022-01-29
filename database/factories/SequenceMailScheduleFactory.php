<?php

namespace Database\Factories;

use Domain\Sequence\Enums\SequenceMailUnit;
use Domain\Sequence\Models\SequenceMailSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class SequenceMailScheduleFactory extends Factory
{
    protected $model = SequenceMailSchedule::class;

    public function definition()
    {
        $units = SequenceMailUnit::cases();
        return [
            'delay' => rand(1, 5),
            'unit' => $units[rand(0, count($units) - 1)]->value,
            'days' => [1,2,3,4,5,6,7],
        ];
    }
}