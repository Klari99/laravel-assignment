@extends('layouts.layout')

@section('title', 'Meglévő űrlapok')

@section('content')
    <div class="">
        <h1 class="d-inline p-2">{{ $form->title }}</h1>

        @if ($hasFillers)
            <span class="text-muted d-inline p-2">Az űrlapnak már van kitöltője, ezért nem módosítható.</span>
        @else
        <form class="d-inline p-2 px-2 mb-3" method="get" action="{{ route('form.modify', ['id' => $form->id]) }}">
            <button type="submit" class="btn btn-outline-primary d-inline p-2 px-2 mb-3">Módosítás</button>
        </form>
        @endif
    </div>
    <hr />
    <div class="table-responsive">
        @foreach ($form->questions as $question)
            <div>
                <p class="text-muted p-2">Kérdés típusa:
                    @if ($question->answer_type == 'TEXTAREA')
                        szöveges válasz.
                    @elseif ($question->answer_type == 'ONE_CHOICE')
                        egy válaszlehetőség.
                    @else
                        több válaszlehetőség.
                    @endif
                </p>
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
                            <p>
                            @if ($answer->answer != null && $answer->answer != "")
                            {{ $answer->answer }}
                            @else
                            Nem válaszolt erre a kérdésre.
                            @endif</p>
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
