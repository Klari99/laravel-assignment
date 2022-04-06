<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $answer_types = ['TEXTAREA', 'ONE_CHOICE', 'MULTIPLE_CHOICES'];

        return [
            'question' => $this->faker->sentence(),
            'answer_type' => $this->$answer_types[rand(0, 3)],
            'required' => $this->faker->boolean()
        ];
    }
}
