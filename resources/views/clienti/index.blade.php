@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="my-4">Clienti</h2>

    <table class="table table-bordered table-striped">

        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Numero ordini</th>
                <th>Azioni</th>
            </tr>
        </thead>

        <tbody>
            @forelse($clienti as $cliente)
                <tr>
                    <td>{{ $cliente->id }}</td>

                    <td>
                        {{ $cliente->nome }} {{ $cliente->cognome }}
                    </td>

                    <td>{{ $cliente->email }}</td>

                    <td>
                        {{ $cliente->ordini->count() }}
                    </td>

                    <td>
                        <a href="{{ route('clienti.show', $cliente->id) }}" 
                           class="btn btn-primary btn-sm">
                            Dettaglio
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        Nessun cliente trovato
                    </td>
                </tr>
            @endforelse
        </tbody>

    </table>

</div>
@endsection