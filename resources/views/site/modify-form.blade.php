@extends('layouts.layout')

@section('title', 'Űrlap módosítása')

@section('content')
    <div class="mb-3">
    <form method="post" action="{{ route('form.update', ['id' => $form->id]) }}">
    @csrf
        <div class="mb-3">
            <label class="form-label h3" for="title">Űrlap címe:</label><br>
            <input
            class="form-control @error('title') is-invalid @enderror"
            type="text"
            id="title"
            name="title"
            value="{{ old('title', $form->title) }}">
            @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror<br>
            <label class="form-label h3" for="expires_at">Érvényes eddig:</label>
            <input
            type="datetime-local"
            class="form-control @error('expires_at') is-invalid @enderror"
            id="expires_at"
            name="expires_at"
            value="{{ old('expires_at', $form->expires_at) }}">
            @error('expires_at')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
            <br>
            <input
            class="form-check-input"
            type="checkbox"
            id="auth_required"
            name="auth_required"
            value="1"
            {{ old('auth_required', $form->auth_required) ? 'checked' : ''  }}>
            <label class="form-check-label" for="auth_required">Legyen bejelentkezéshez kötött</label><br>
        </div>
        <hr />
        <div class="table-responsive">
            @foreach ($form->questions as $question)
                <div>
                    <p class="text-muted">Kérdés típusa:
                        @if ($question->answer_type == 'TEXTAREA')
                            szöveges válasz.
                        @elseif ($question->answer_type == 'ONE_CHOICE')
                            egy válaszlehetőség.
                        @else
                            több válaszlehetőség.
                        @endif
                    </p>
                    <label class="form-label h3" for="{{ 'question-'.$question->id }}">Kérdés: {{ 'question-'.$question->id }}</label><br>
                    <input
                    class="form-control @error('question-'.$question->id) is-invalid @enderror"
                    type="text"
                    id="{{ 'question-'.$question->id }}"
                    name="{{ 'question-'.$question->id }}"
                    value="{{ old('question-'.$question->id, $question->question) }}">
                    @error('question-'.$question->id)
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <br>
                    @if($question->answer_type != 'TEXTAREA')
                        @foreach ($question->choices as $choice)
                            <label class="form-label" for="{{ 'choice-'.$choice->id }}">Válaszlehetőség:</label><br>
                            <input
                            class="form-control @error('choice-'.$choice->id) is-invalid @enderror"
                            type="text"
                            id="{{ $choice->id }}"
                            name="{{ 'choice-'.$choice->id }}"
                            value="{{ old('choice-'.$choice->id, $choice->choice) }}">
                            @error('choice-'.$choice->id)
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        @endforeach
                    @endif
                </div>
                <hr />
            @endforeach
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div>{{$error}}</div>
                @endforeach
            @endif
            <button class="btn btn-primary" type="submit">Űrlap módosítása</button>
        </div>
    </form>
    </div>
@endsection
