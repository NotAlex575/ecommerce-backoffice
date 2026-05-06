@extends('layouts.app')

@section('content')
<div class="container">

    <h2 class="my-4">Modifica Stato Ordine #{{ $ordine->id }}</h2>

    <div class="card">
        <div class="card-header">Aggiorna stato</div>

        <div class="card-body">

            <form action="{{ route('ordini.updateStatus', $ordine->id) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Stato ordine</label>

                    <select name="stato" class="form-select">

                        <option value="processing" {{ $ordine->stato === 'processing' ? 'selected' : '' }}>
                            Processing
                        </option>

                        <option value="completed" {{ $ordine->stato === 'completed' ? 'selected' : '' }}>
                            Completato
                        </option>

                        <option value="cancelled" {{ $ordine->stato === 'cancelled' ? 'selected' : '' }}>
                            Cancellato
                        </option>

                        <option value="refunded" {{ $ordine->stato === 'refunded' ? 'selected' : '' }}>
                            Rimborsato
                        </option>

                    </select>
                </div>

                <button class="btn btn-primary">
                    Salva modifica
                </button>

            </form>

        </div>
    </div>

    <a href="{{ route('ordini.show', $ordine->id) }}" class="btn btn-secondary mt-3">
        Torna al dettaglio
    </a>

</div>
@endsection