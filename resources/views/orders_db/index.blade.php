@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Titolo pagina --}}
    <h2 class="my-4">Ordini (Database)</h2>

    {{-- FILTRI --}}
    <form method="GET" action="{{ route('ordini.index') }}" class="row mb-4">

        {{-- Filtro per nome cliente --}}
        <div class="col-md-4">
            <input type="text" 
                   name="cliente" 
                   class="form-control"
                   placeholder="Cerca per nome cliente"
                   value="{{ request('cliente') }}">
        </div>

        {{-- Filtro per stato --}}
        <div class="col-md-3">
            <select name="stato" class="form-select">
                <option value="">Tutti gli stati</option>
                <option value="processing" {{ request('stato') == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="completed" {{ request('stato') == 'completed' ? 'selected' : '' }}>Completato</option>
                <option value="cancelled" {{ request('stato') == 'cancelled' ? 'selected' : '' }}>Cancellato</option>
                <option value="refunded" {{ request('stato') == 'refunded' ? 'selected' : '' }}>Rimborsato</option>
            </select>
        </div>

        {{-- Bottoni --}}
        <div class="col-md-5 d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                Filtra
            </button>

            <a href="{{ route('ordini.index') }}" class="btn btn-secondary">
                Reset
            </a>
        </div>

    </form>

    {{-- Tabella elenco ordini --}}
    <table class="table table-bordered table-striped">

        {{-- Intestazione --}}
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Email</th>
                <th>Totale</th>
                <th>Stato</th>
                <th>Data</th>
                <th>Azioni</th>
            </tr>
        </thead>

        <tbody>

            {{-- Lista ordini --}}
            @forelse($ordini as $ordine)
                <tr>

                    <td>{{ $ordine->id }}</td>

                    <td>
                        {{ $ordine->cliente->nome }}
                        {{ $ordine->cliente->cognome }}
                    </td>

                    <td>{{ $ordine->cliente->email }}</td>

                    <td>{{ $ordine->totale }} €</td>

                    <td>
                        <span class="badge bg-warning text-dark">
                            {{ $ordine->stato }}
                        </span>
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($ordine->data_ordine)->format('d/m/Y H:i') }}
                    </td>

                    {{-- Azioni --}}
                    <td>
                        <a href="{{ route('ordini.show', $ordine->id) }}" 
                           class="btn btn-primary btn-sm">
                            Dettaglio
                        </a>
                    </td>

                </tr>

            {{-- Nessun ordine --}}
            @empty
                <tr>
                    <td colspan="7" class="text-center">
                        Nessun ordine trovato
                    </td>
                </tr>
            @endforelse

        </tbody>

    </table>

</div>
@endsection