<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Form;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $forms = Form::all();
        foreach ($forms as $form) {
            Question::factory(10)
                ->for($form)
                ->create(['form_id' => $form->id]);
        }
    }
}
