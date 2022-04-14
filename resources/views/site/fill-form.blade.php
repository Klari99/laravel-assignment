@extends('layouts.layout')

@section('title', 'Űrlap kitöltése')

@section('content')
    <h1 class="ps-3">{{ $form->title }}</h1>
    <hr />
    <div class="table-responsive">
        @if ($form->expires_at < Carbon::now())
            <div class="mb-3 alert alert-danger" role="alert">
                Ez az űrlap lejárt.
            </div>
        @else
            <form method="post" action="{{ route('forms.store', ['id' => $form->id]) }}" id="{{ $form->id }}">
            @csrf
            @foreach ($form->questions as $question)
                <div class="mb-3">
                    <h3>{{ $question->question }}@if ($question->required) <span style="color:red">*</span>@endif</h3>
                    @if ($question->answer_type == 'ONE_CHOICE')
                        @foreach ($question->choices as $choice)
                            <input
                            class="form-check-input @error("input-".strval($question->id)) is-invalid @enderror"
                            type="radio"
                            id="{{ $choice->id }}"
                            name="input-{{ $question->id }}"
                            value="{{ $choice->choice }}"
                            {{ old("input-".strval($question->id)) == $choice->choice ? 'checked' : '' }}>
                            <label class="form-check-label" for="{{ $choice->id }}">{{ $choice->choice }}</label><br>
                        @endforeach
                        @error("input-".strval($question->id))
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    @elseif ($question->answer_type == 'MULTIPLE_CHOICES')
                        @foreach ($question->choices as $choice)
                            <input
                            class="form-check-input @error("input-".strval($question->id)) is-invalid @enderror"
                            type="checkbox"
                            id="{{ $choice->id }}"
                            name="input-{{ $question->id }}[]"
                            value="{{ $choice->choice }}"
                            {{ (is_array(old("input-".strval($question->id))) && in_array($choice->choice, old("input-".strval($question->id)))) ? 'checked' : ''  }}>
                            <label class="form-check-label" for="{{ $choice->id }}">{{ $choice->choice }}</label><br>
                        @endforeach
                        @error("input-".strval($question->id))
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    @else
                        <textarea
                        class="form-control @error("input-".strval($question->id)) is-invalid @enderror" name="input-{{ $question->id }}"
                        form="{{ $form->id }}"
                        id="{{ $question->id }}"
                        placeholder="Ide írd a választ...">{{ old("input-".strval($question->id)) }}</textarea>
                        @error("input-".strval($question->id))
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    @endif
                </div>
            @endforeach
            <button class="btn btn-primary" type="submit">Űrlap elküldése</button>
            </form>
        @endif
    </div>
@endsection
