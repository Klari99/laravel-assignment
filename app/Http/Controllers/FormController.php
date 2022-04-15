<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Question;
use App\Models\Choice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    public function show()
    {
        $forms = Auth::user()->forms;
        return view('site.forms', ['forms' => $forms]);
    }

    public function showModificationSite($id)
    {
        $form = Form::findOrFail($id);
        if(!Auth::user()->forms->contains($form)) {
            return redirect()->route('menu');
        }

        $questions = $form->questions;
        foreach ($questions as $question) {
            $answers = $question->answers;

            if($answers->count() > 0) {
                return redirect()->route('forms.get', ['id' => $id]);
            }
        }

        return view('site.modify-form', ['form' => $form]);
    }

    public function update(Request $request, $id)
    {
        $form = Form::findOrFail($id);
        if(Auth::user() == null || !Auth::user()->forms->contains($form)) {
            return redirect()->route('menu');
        }

        $questions = $form->questions;
        foreach ($questions as $question) {
            $answers = $question->answers;

            if($answers->count() > 0) {
                return redirect()->route('forms.get', ['id' => $id]);
            }
        }

        $rules = [];
        $newQuestions = [];
        $choices = [];

        $rules += [
            'title' => 'required|string:255',
            'expires_at' => 'required|date|after:tomorrow|before:2032-01-01T00:00',
        ];

        foreach ($questions as $question) {

            $rules += [
                'question-'.$question->id => 'required|string:255'
            ];

            $question = Question::findOrFail($question->id);
            $question->question = $request->input('question-'.$question->id);
            array_push($newQuestions, $question);

            foreach($question->choices as $choice) {
                $rules += [
                    'choice-'.$choice->id => 'required|string:255'
                ];

                $choice = Choice::findOrFail($choice->id);
                $choice->choice = $request->input('choice-'.$choice->id);
                array_push($choices, $choice);
            }
        }

        $customMessages = [
            'title.required' => "Kötelező címet megadni.",
            "date" => "Nem érvényes dátum.",
            "expires_at.required" => "Kötelező megadni egy dátumot.",
            "expires_at.after" => "Az űrlapnak legalább egy napig élnie kell.",
            "expires_at.before" => "Az űrlap maximum 2032.01.01-ig élhet.",
            "required" => "Nem lehet üresen hagyni.",
        ];
        $request->validate($rules, $customMessages);

        $form->title = $request->input('title');
        $form->expires_at = $request->input('expires_at');
        if($request->has('auth_required')) {
            $form->auth_required = $request->input('auth_required');
        }
        else{
            $form->auth_required = false;
        }

        $form->update();

        foreach($newQuestions as $question) {
            error_log($question->question);
            $question->update();
        }

        foreach($choices as $choice) {
            $choice->update();
        }

        return redirect()->route('forms.get', ['id' => $id]);
    }
}
