<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ChoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = Question::all();
        foreach ($questions as $question) {

            if ($question->answer_type == 'TEXTAREA') {
                $numberOfChoices = 1;
            }
            else {
                $numberOfChoices = rand(3, 6);
            }

            Choice::factory(énumberOfChoices)
                ->for($question)
                ->create(['question_id' => $question->id]);
        }
    }
}
