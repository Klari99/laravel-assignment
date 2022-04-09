@extends('layouts.layout')

@section('title', 'Meglévő űrlapok')

@section('content')
    <h1 class="ps-3">Meglévő űrlapok</h1>
    <hr />
    <div class="table-responsive">
        <table class="table align-middle table-hover">
            <thead class="text-center table-light">
                <tr>
                    <th style="width: 30%">Cím</th>
                    <th style="width: 10%">Lejárat</th>
                    <th style="width: 10%">Kötelező azonosítás</th>
                    <th style="width: 30%">Létrehozva</th>
                    <th style="width: 10%">Módosítva</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach ($forms as $form)
                    <tr class="">

                        <td>
                            <div>{{ $form->title }}</div>
                        </td>
                        <td>
                            <div>{{ $form->expires_at }}</div>
                        </td>
                        <td>
                            <div>
                                @if ($form->auth_required)
                                    Igen
                                @else
                                    Nem
                                @endif
                            </div>
                        </td>
                        <td>
                            <div>{{ $form->created_at }}</div>
                        </td>
                        <td>
                            <div>{{ $form->updated_at }}</div>
                        </td>

                        <td>
                            <div>
                                <a href="">Módosítás/böngészés</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
