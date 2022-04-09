@extends('layouts.layout')

@section('title', 'Főmenü')

@section('content')
    <h1 class="ps-3">Válassz egy opciót</h1>
    <hr />
    <div class="table-responsive">
        <p><a href="{{ route('create-form') }}">Új űrlap létrehozása</a></p>
        <p><a href="{{ route('forms') }}">Meglévő űrlapok böngészése</a></p>
    </div>
@endsection
