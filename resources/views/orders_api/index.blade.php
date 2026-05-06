@extends('layouts.app')

@section('content')
@php
    $nome = strtolower(request('nome'));
    $status = request('status');

    $filteredOrders = collect($orders)->filter(function ($order) use ($nome, $status) {
        $fullName = strtolower(
            ($order['billing']['first_name'] ?? '') . ' ' . ($order['billing']['last_name'] ?? '')
        );

        $matchNome = empty($nome) || str_contains($fullName, $nome);
        $matchStatus = empty($status) || ($order['status'] ?? '') === $status;

        return $matchNome && $matchStatus;
    });
@endphp

<div class="container">
    <h2 class="my-4">Ordini WooCommerce</h2>

    <form method="GET" class="row mb-4">
        <div class="col-md-4">
            <input 
                type="text"
                name="nome"
                class="form-control"
                placeholder="Cerca per nome cliente"
                value="{{ request('nome') }}"
            >
        </div>

        <div class="col-md-4">
            <select name="status" class="form-select">
                <option value="">Tutti gli stati</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>
                    Processing
                </option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                    Completed
                </option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                    Pending
                </option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                    Cancelled
                </option>
            </select>
        </div>

        <div class="col-md-4 d-flex gap-2">
            <button class="btn btn-primary">
                Filtra
            </button>

            <a href="{{ route('woocommerce.orders') }}" class="btn btn-secondary">
                Reset
            </a>
        </div>
    </form>

    @if($filteredOrders->isEmpty())
        <div class="alert alert-warning">
            Nessun ordine trovato.
        </div>
    @else
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Email</th>
                    <th>Totale</th>
                    <th>Stato</th>
                    <th>Data</th>
                </tr>
            </thead>

            <tbody>
                @foreach($filteredOrders as $order)
                    <tr>
                        <td>{{ $order['id'] }}</td>

                        <td>
                            {{ $order['billing']['first_name'] }}
                            {{ $order['billing']['last_name'] }}
                        </td>

                        <td>{{ $order['billing']['email'] }}</td>

                        <td>{{ $order['total'] }} €</td>

                        <td>
                            <span class="badge bg-warning text-dark">
                                {{ $order['status'] }}
                            </span>
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($order['date_created'])->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection