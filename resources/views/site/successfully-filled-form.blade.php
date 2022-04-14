@extends('layouts.layout')

@section('title', $form->title)

@section('content')
    <h1 class="ps-3">{{ $form->title }}</h1>
    <hr />
    <div class="table-responsive">
        @if (!$success)
            <div class=" mb-3 alert alert-danger" role="alert">
                Ez az űrlap a kitöltés közben lejárt. Válaszát nem tudtuk rögzíteni.
            </div>
        @else
            <div class="mb-3 alert alert-success" role="alert">
                Válaszát rögzítettük.
            </div>
            <div class="mb-3">
                <a href="{{ route('menu') }}">Vissza a kezdőlapra</a>
            </div>
        @endif
    </div>
@endsection
