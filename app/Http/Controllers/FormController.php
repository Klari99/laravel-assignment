<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    public function show()
    {
        //TODO: created_by instead of user_id
        $forms = Auth::user()->forms;
        return view('site.forms', ['forms' => $forms]);
    }
}
