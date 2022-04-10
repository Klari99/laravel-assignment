<?php

namespace App\Http\Controllers;

use App\Models\Form;
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
        if($form->user->id == Auth::user()->id) {
            return view('site.form', ['form' => $form]);
        }
        else {
            return view('site.fill-form', ['form' => $form]);
        }
    }
}
