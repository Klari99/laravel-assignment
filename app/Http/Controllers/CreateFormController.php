<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreateFormController extends Controller
{
    public function show()
    {
        return view('site/create-form');
    }
}
