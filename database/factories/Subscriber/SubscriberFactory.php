<?php

namespace Database\Factories\Subscriber;

use Domain\Shared\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Domain\Subscriber\Models\Form;
use Domain\Subscriber\Models\Subscriber;

class SubscriberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subscriber::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email' => $this->faker->safeEmail(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'form_id' => Form::factory(),
            'user_id' => User::factory(),
        ];
    }
}
