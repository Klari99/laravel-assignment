<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FormFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->words(5, true),
            'expires_at' => $this->faker->dateTimeInInterval(now(), '+5 months'),
            'auth_required' => $this->faker->boolean()
        ];
    }
}
