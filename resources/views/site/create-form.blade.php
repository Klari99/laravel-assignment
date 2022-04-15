@extends('layouts.layout')

@section('title', 'Űrlap létrehozása')

@section('content')
    <h1 class="ps-3">Űrlap létrehozása</h1>
    <hr />
    <div class="table-responsive">
        <form method="post" action="{{ route('forms.create') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label" for="title">Űrlap címe:</label><br>
            <input
            class="form-control @error('title') is-invalid @enderror"
            type="text"
            id="title"
            name="title"
            value="{{ old('title') }}">
            @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
            <label class="form-label" for="expires_at">Érvényes eddig:</label>
            <input
            type="datetime-local"
            class="form-control @error('expires_at') is-invalid @enderror"
            id="expires_at"
            name="expires_at"
            value="{{ old('expires_at', Carbon::now()) }}">
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
            {{ old('auth_required') ? 'checked' : ''  }}>
            <label class="form-check-label" for="auth_required">Legyen bejelentkezéshez kötött</label><br><br>
            <button class="btn btn-primary" type="submit">Űrlap létrehozása</button>
        </div>
        </form>
    </div>
@endsection
