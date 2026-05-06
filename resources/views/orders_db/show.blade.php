@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="my-4">Dettaglio Ordine #{{ $ordine->id }}</h2>

    {{-- DATI CLIENTE --}}
    <div class="card mb-4">
    <div class="card-header">Cliente</div>
        <div class="card-body">
            @if($ordine->cliente)
                <p><strong>Nome:</strong> {{ $ordine->cliente->nome }}</p>
                <p><strong>Cognome:</strong> {{ $ordine->cliente->cognome }}</p>
                <p><strong>Email:</strong> {{ $ordine->cliente->email }}</p>
                <p><strong>Indirizzo fatturazione:</strong> {{ $ordine->cliente->indirizzo_fatturazione }}</p>
                <p><strong>Indirizzo spedizione:</strong> {{ $ordine->cliente->indirizzo_spedizione }}</p>
            @else
                <div class="alert alert-warning">
                    Cliente non trovato per questo ordine.
                </div>
            @endif
        </div>
    </div>

    {{-- DATI ORDINE --}}
    <div class="card mb-4">
        <div class="card-header">Ordine</div>
        <div class="card-body">
            <p><strong>Totale (con spedizione):</strong> {{ $ordine->totale }} €</p>
            <p><strong>Stato:</strong> {{ $ordine->stato }}</p>
            <p><strong>Data:</strong> {{ \Carbon\Carbon::parse($ordine->data_ordine)->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    {{-- RIGHE ORDINE --}}
    <div class="card">
        <div class="card-header">Prodotti</div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Prodotto</th>
                        <th>Quantità</th>
                        <th>Prezzo (IVA inclusa)</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($ordine->righe as $riga)
                        <tr>
                            <td>{{ $riga->prodotto }}</td>
                            <td>{{ $riga->quantita }}</td>
                            <td>{{ $riga->prezzo }} €</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3 d-flex gap-2">

    {{-- Bottone modifica stato --}}
    <a href="{{ route('ordini.edit', $ordine->id) }}" class="btn btn-warning">
        Modifica stato
    </a>

    {{-- Bottone ritorno --}}
    <a href="{{ route('ordini.index') }}" class="btn btn-secondary">
        Torna indietro
    </a>

</div>

</div>
@endsection