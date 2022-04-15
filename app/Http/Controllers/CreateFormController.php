<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CreateFormController extends Controller
{
    public function show()
    {
        return view('site/create-form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string:255',
            'expires_at' => 'required|date|after:tomorrow|before:2032-01-01T00:00',
        ],
        [
            'title.required' => "Kötelező címet megadni.",
            "date" => "Nem érvényes dátum.",
            "expires_at.required" => "Kötelező megadni egy dátumot.",
            "expires_at.after" => "Az űrlapnak legalább egy napig élnie kell.",
            "expires_at.before" => "Az űrlap maximum 2032.01.01-ig élhet.",
        ]);

        $form = new Form($validated);
        if($request->has('auth_required')) {
            $form->auth_required = true;
        }
        $form->user()->associate(Auth::user());
        $form->expires_at = Carbon::parse($form->expires_at);
        $form->save();

        return view('site.questions', ['form' => $form]);
    }
}
