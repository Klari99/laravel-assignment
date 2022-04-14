<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\User;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class FormsController extends Controller
{
    public function show()
    {
        //TODO: created_by instead of user_id
        $forms = Form::where('user_id', Auth::id())->orderBy('updated_at', 'DESC')->paginate(5);
        return view('site.forms', compact('forms'));
    }

    public function get($id)
    {
        $form = Form::findOrFail($id);
        $users = User::all();

        if(Auth::user() == null) {
            if($form->auth_required) {
                return redirect()->route('menu');
            }
            else {
                return view('site.fill-form', ['form' => $form]);
            }
        }
        elseif($form->user->id == Auth::user()->id) {

            $hasFillers = false;
            $fillers = collect();
            $questions = $form->questions;

            foreach ($questions as $question) {
                $answers = $question->answers;
                if($answers->count() > 0) {
                    $hasFillers = true;
                    foreach ($answers as $answer) {
                        $fillers->push(User::find($answer->user_id));
                    }
                }
            }

            return view('site.form', ['form' => $form, 'hasFillers' => $hasFillers, 'fillers' => $fillers]);
        }
        else {
            return view('site.fill-form', ['form' => $form]);
        }
    }

    public function store(Request $request, $id)
    {

        $form = Form::findOrFail($id);

        //TODO: maybe torolni
        if(Auth::user() == null) {
            if($form->auth_required) {
                return redirect()->route('menu');
            }
        }

        if($form->expires_at < Carbon::now()) {
            return view('site.successfully-filled-form', ['success' => false, 'form' => $form]);
        }

        $user_id = null;
            if(Auth::user() != null) {
                $user_id = Auth::user()->id;
            }

        $questions = $form->questions;
        $rules = [];
        $answers = [];

        foreach ($questions as $question) {

            $question_id = "input-" . strval($question->id);

            if ($question->answer_type == "ONE_CHOICE") {

                $possibleChoices = $question->choices;
                $choiceValues = [];

                foreach ($possibleChoices as $choice) {
                    array_push($choiceValues, $choice->choice);
                }

                if ($question->required) {
                    $rules += [
                        $question_id => ['required',
                        Rule::in($choiceValues)]
                    ];

                    if ($request->has($question_id)) {
                        $answerChoice = null;

                        foreach($possibleChoices as $choice) {
                            if($choice->choice == $request->input($question_id)) {
                                $answerChoice = $choice;
                            }
                        }

                        $answer = new Answer([
                            'user_id' => $user_id,
                            'choice_id' => $answerChoice->id,
                            'answer' => $answerChoice->choice,
                        ]);

                        if($user_id != null){
                            $answer->user()->associate(Auth::user());
                        }
                        $answer->choice()->associate($answerChoice);
                        $answer->question()->associate($question);
                        array_push($answers, $answer);
                    }
                }
                else {
                    if ($request->has($question_id)) {
                        $rules += [$question_id => Rule::in($choiceValues)];

                        $answerChoice = null;
                        error_log($request->input($question_id));
                        error_log("*******");

                        foreach($possibleChoices as $choice) {
                            error_log($choice->choice);
                            if($choice->choice == $request->input($question_id)) {
                                $answerChoice = $choice;
                            }
                        }

                        $answer = new Answer([
                            'user_id' => $user_id,
                            'choice_id' => $answerChoice->id,
                            'answer' => $answerChoice->choice,
                        ]);
                        if($user_id != null){
                            $answer->user()->associate(Auth::user());
                        }
                        $answer->choice()->associate($answerChoice);
                        $answer->question()->associate($question);
                        array_push($answers, $answer);
                    }
                }
            }
            elseif ($question->answer_type == 'MULTIPLE_CHOICES') {
                $possibleChoices = $question->choices;
                $choiceValues = [];
                foreach ($possibleChoices as $choice) {
                    array_push($choiceValues, $choice->choice);
                }
                if ($question->required) {
                    $rules += [
                        $question_id => ['required']
                    ];
                    $key = $question_id . ".*";
                    $rules += [$key => Rule::in($choiceValues)];

                    if ($request->has($question_id)) {
                        foreach($request->input($question_id) as $choiceRequest) {

                            $answerChoice = null;

                            foreach($possibleChoices as $choice) {
                                if($choice->choice == $choiceRequest) {
                                    $answerChoice = $choice;
                                }
                            }

                            $answer = new Answer([
                                'user_id' => $user_id,
                                'choice_id' => $answerChoice->id,
                                'answer' => null,
                            ]);
                            if($user_id != null){
                                $answer->user()->associate(Auth::user());
                            }
                            $answer->choice()->associate($answerChoice);
                            $answer->question()->associate($question);
                            array_push($answers, $answer);
                        }
                    }
                }
                else {
                    if ($request->has($question_id)) {
                        $key = $question_id . ".*";
                        $rules += [$key => Rule::in($choiceValues)];

                        foreach($request->input($question_id) as $choiceRequest) {

                            $answerChoice = null;

                            foreach($possibleChoices as $choice) {
                                if($choice->choice == $choiceRequest) {
                                    $answerChoice = $choice;
                                }
                            }

                            $answer = new Answer([
                                'user_id' => $user_id,
                                'choice_id' => $answerChoice->id,
                                'answer' => null,
                            ]);
                            if($user_id != null){
                                $answer->user()->associate(Auth::user());
                            }
                            $answer->choice()->associate($answerChoice);
                            $answer->question()->associate($question);
                            array_push($answers, $answer);
                        }
                    }
                }
            }
            elseif ($question->answer_type == 'TEXTAREA') {
                if ($question->required) {
                    $rules += [$question_id => 'required|max:1000'];

                    if ($request->has($question_id)) {
                        $answer = new Answer([
                            'user_id' => $user_id,
                            'choice_id' => null,
                            'answer' => $request->input($question_id),
                        ]);

                        if($user_id != null){
                            $answer->user()->associate(Auth::user());
                        }
                        $answer->question()->associate($question);
                        array_push($answers, $answer);
                    }
                }
                else {
                    $rules += [$question_id => 'min:0|max:1000'];

                    if ($request->has($question_id)) {
                        $answer = new Answer([
                            'user_id' => $user_id,
                            'choice_id' => null,
                            'answer' => $request->input($question_id),
                        ]);

                        if($user_id != null){
                            $answer->user()->associate(Auth::user());
                        }
                        $answer->question()->associate($question);
                        array_push($answers, $answer);
                    }
                }
            }
        }

        $customMessages = [
            "required" => "Erre a kérdésre kötelező válaszolni!",
            "max" => "A válasz nem lehet hosszabb 1000 karakternél!"
        ];
        $request->validate($rules, $customMessages);

        foreach($answers as $answer) {
            $answer->save();
        }

        return view('site.successfully-filled-form', ['success' => true, 'form' => $form]);
    }
}
