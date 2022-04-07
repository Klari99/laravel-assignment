<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Answer;
use App\Models\User;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = Question::all();
        $users = User::all();
        foreach ($questions as $question) {

            //TODO: created_by instead of user_id
            $tmpUsers = $users->where('id', '!=', $question->form->user_id)->random(5);
            $choices = $question->choices;

            foreach ($choices as $choice) {
                foreach ($tmpUsers as $user) {

                    if ($question->answer_type == 'MULTIPLE_CHOICES') {
                        $numberOfAnswers = rand(1, count($question->choices));

                        Answer::factory($numberOfAnswers)
                        ->for($question)
                        ->create(['question_id' => $question->id,
                                  'user_id' => $user->id,
                                  'choice_id' => $choice->id,
                                  'answer' => null
                        ]);

                    }
                    else if ($question->answer_type == 'ONE_CHOICE') {
                        Answer::factory()
                        ->for($question)
                        ->create(['question_id' => $question->id,
                                  'user_id' => $user->id,
                                  'choice_id' => $choice->id,
                                  'answer' => null
                        ]);
                    }
                    else {
                        Answer::factory()
                        ->for($question)
                        ->create(['question_id' => $question->id,
                                  'user_id' => $user->id,
                                  'choice_id' => $choice->id
                        ]);
                    }
                }
            }
        }
    }
}
