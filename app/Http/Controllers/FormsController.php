<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                return redirect()->route('forms.getWithAuth', ['id' => $id]);
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
                        $fillers->push(User::findOrFail($answer->user_id));
                    }
                }
            }

            return view('site.form', ['form' => $form, 'hasFillers' => $hasFillers, 'fillers' => $fillers]);
        }
        else {
            return view('site.fill-form', ['form' => $form]);
        }
    }

    public function getWithAuth($id)
    {
        $form = Form::findOrFail($id);
        $users = User::all();

        if($form->user->id == Auth::user()->id) {

            $hasFillers = false;
            $fillers = collect();
            $questions = $form->questions;

            foreach ($questions as $question) {
                $answers = $question->answers;
                if($answers->count() > 0) {
                    $hasFillers = true;
                    foreach ($answers as $answer) {
                        $fillers->push(User::findOrFail($answer->user_id));
                    }
                }
            }

            return view('site.form', ['form' => $form, 'hasFillers' => $hasFillers, 'fillers' => $fillers]);
        }
        else {
            return view('site.fill-form', ['form' => $form]);
        }
    }
}
