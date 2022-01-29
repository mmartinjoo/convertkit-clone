<?php

namespace Database\Factories;

use Domain\Sequence\Enums\SequenceStatus;
use Domain\Sequence\Models\Sequence;
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
        ];
    }
}
