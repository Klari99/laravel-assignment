@extends('layouts.layout')

@section('title', 'Meglévő űrlapok')

@section('content')
    <div class="">
        <h1 class="d-inline p-2">{{ $form->title }}</h1>

        @if ($hasFillers)
            <span class="text-muted d-inline p-2">Az űrlapnak már van kitöltője, ezért nem módosítható.</span>
        @else
            <button type="button" class="btn btn-outline-primary d-inline p-2 px-2 mb-3">Módosítás</button>
        @endif
    </div>
    <hr />
    <div class="table-responsive">
        @foreach ($form->questions as $question)
            <div>
                <h2>{{ $question->question }}</h2>
                @if($question->answer_type != 'TEXTAREA')
                    @if ($question->answers->count() == 0)
                        <p>Még senki nem válaszolt a kérdésre.</p>
                    @endif
                    <ul>
                        @foreach ($question->choices->sortByDesc($question->answers->groupBy('choice_id')->count()) as $choice)
                            <li> {{ $choice->choice }} ({{ $question->answers->where('choice_id', '=', $choice->id)->count() }} felhasználó választotta)</li>
                        @endforeach
                    </ul>
                @elseif ($question->answer_type == 'TEXTAREA')
                    @if ($question->answers->count() > 0)
                        @foreach ($question->answers as $answer)
                            <p>
                                @isset($answer->user_id)
                                    {{ $fillers->where('id', '=', $answer->user_id)->first()->name}} válasza:
                                @else
                                    Vendég válasza:
                                @endisset
                            </p>
                            <p> {{ $answer->answer }}</p>
                            <br>
                        @endforeach
                    @else
                        <p>Még senki nem válaszolt a kérdésre.</p>
                    @endif
                @endif
            </div>
            <hr />
        @endforeach
    </div>
@endsection
