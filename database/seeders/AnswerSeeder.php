<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
        foreach ($questions as $question) {
            
            $tmpUsers = $users->where('id', '!=', $question->form()->created_by)->random(5);

            foreach ($questions->choices() as $choice) {
                foreach ($tmpUsers as $user) {

                    if ($question->answer_type == 'MULTIPLE_CHOICES') {
                        $numberOfAnswers = rand(1, count($question->choices()));

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
