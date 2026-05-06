@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="my-4">
        Cliente: {{ $cliente->nome }} {{ $cliente->cognome }}
    </h2>

    {{-- DATI CLIENTE --}}
    <div class="card mb-4">
        <div class="card-header">Dati Cliente</div>

        <div class="card-body">
            <p><strong>Nome:</strong> {{ $cliente->nome }}</p>
            <p><strong>Cognome:</strong> {{ $cliente->cognome }}</p>
            <p><strong>Email:</strong> {{ $cliente->email }}</p>
            <p><strong>Indirizzo fatturazione:</strong> {{ $cliente->indirizzo_fatturazione }}</p>
            <p><strong>Indirizzo spedizione:</strong> {{ $cliente->indirizzo_spedizione }}</p>
        </div>
    </div>

    {{-- ORDINI DEL CLIENTE --}}
    <div class="card">
        <div class="card-header">Ordini del cliente</div>

        <div class="card-body">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Ordine</th>
                        <th>Totale</th>
                        <th>Stato</th>
                        <th>Data</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($cliente->ordini as $ordine)
                        <tr>
                            <td>{{ $ordine->id }}</td>
                            <td>{{ $ordine->totale }} €</td>
                            <td>{{ $ordine->stato }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($ordine->data_ordine)->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">
                                Nessun ordine per questo cliente
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

    <a href="{{ route('clienti.index') }}" class="btn btn-secondary mt-3">
        Torna indietro
    </a>

</div>
@endsection