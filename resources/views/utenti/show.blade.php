@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="my-4">Dettaglio Utente #{{ $utente->id }}</h2>

    <div class="card">

        <div class="card-header">Dati Utente</div>

        <div class="card-body">
            <p><strong>Nome:</strong> {{ $utente->name }}</p>
            <p><strong>Email:</strong> {{ $utente->email }}</p>
            <p><strong>Ruolo:</strong> {{ $utente->role }}</p>
        </div>

    </div>

    <a href="{{ route('utenti.index') }}" class="btn btn-secondary mt-3">
        Torna indietro
    </a>

</div>
@endsection