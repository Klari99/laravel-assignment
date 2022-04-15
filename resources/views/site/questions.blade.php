@extends('layouts.layout')

@section('title', 'Űrlap létrehozása')

@section('content')
    <h1 class="ps-3">Űrlap létrehozása</h1>
    <hr />
    <div class="table-responsive">
        KÉRDÉSEK HOZZÁADÁSA - Ez nem készült el :(
        <div class="mb-3">
            <a href="{{ route('forms.get', ['id' => $form->id]) }}">A létrehozott űrlap linkje.</a>
        </div>
    </div>
@endsection
