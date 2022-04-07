<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Choice;

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

            Choice::factory($numberOfChoices)
                ->for($question)
                ->create(['question_id' => $question->id]);
        }
    }
}
