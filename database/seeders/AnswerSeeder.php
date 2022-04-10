<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;
use App\Models\Answer;
use App\Models\User;
use App\Models\Form;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $numberOfForms = Form::all()->count();
        $forms = Form::all()->random($numberOfForms/2);

        foreach ($forms as $form) {
            $users = User::all();
            $tmpUsers = $users->where('id', '!=', $form->user_id)->random(5);
            $questions = $form->questions;

            foreach ($questions as $question) {
                $choices = $question->choices;

                foreach ($tmpUsers as $user) {

                    if ($question->answer_type == 'MULTIPLE_CHOICES') {
                        $numberOfAnswers = rand(1, count($question->choices));
                        $userChoices = $choices->random($numberOfAnswers);

                        foreach($userChoices as $choice) {
                            Answer::factory()
                            ->for($question)
                            ->create(['question_id' => $question->id,
                                    'user_id' => $user->id,
                                    'choice_id' => $choice->id,
                                    'answer' => null
                            ]);
                        }
                    }
                    else if ($question->answer_type == 'ONE_CHOICE') {
                        $choice = $choices->random(1)->first();

                        Answer::factory()
                        ->for($question)
                        ->create(['question_id' => $question->id,
                                'user_id' => $user->id,
                                'choice_id' => $choice->id,
                                'answer' => null
                        ]);
                    }
                    else {
                        $choice = $choices->random(1)->first();
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

        //
        /*$questions = Question::all();
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
        }*/
    }
}
