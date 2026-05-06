@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="my-4">Utenti</h2>

    <table class="table table-bordered table-striped">

        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Ruolo</th>
                <th>Azioni</th>
            </tr>
        </thead>

        <tbody>
            @forelse($utenti as $utente)
                <tr>
                    <td>{{ $utente->id }}</td>

                    <td>{{ $utente->name }}</td>

                    <td>{{ $utente->email }}</td>

                    <td>
                        <span class="badge {{ $utente->role === 'amministratore' ? 'bg-danger' : 'bg-secondary' }}">
                            {{ $utente->role }}
                        </span>
                    </td>

                    <td>
                        <a href="{{ route('utenti.show', $utente->id) }}" 
                           class="btn btn-primary btn-sm">
                            Dettaglio
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        Nessun utente trovato
                    </td>
                </tr>
            @endforelse
        </tbody>

    </table>

</div>
@endsection