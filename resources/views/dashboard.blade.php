@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="fs-4 text-secondary my-4">
        {{ __('Dashboard') }}
    </h2>

    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">{{ __('User Dashboard') }}</div>

                <div class="card-body">

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p class="fs-5">
                        Sei loggato {{ Auth::user()->name }}!
                    </p>

                    <p class="fs-5">
                        Qui ci sono tutte le sezioni disponibili.
                    </p>

                    <div class="d-grid gap-3">

                        {{-- Sync WooCommerce --}}
                        <a href="{{ route('ordini.sync') }}" class="btn btn-primary btn-lg">
                            Sincronizza ordini WooCommerce
                        </a>

                        {{-- Ordini --}}
                        <a href="{{ route('ordini.index') }}" class="btn btn-success btn-lg">
                            Gestione ordini
                        </a>

                        {{-- Clienti --}}
                        <a href="{{ route('clienti.index') }}" class="btn btn-info btn-lg">
                            Gestione clienti
                        </a>

                        {{-- Test API --}}
                        <a href="{{ route('woocommerce.orders') }}" class="btn btn-outline-warning btn-lg">
                            Test API WooCommerce
                        </a>

                        {{-- 👇 SOLO ADMIN --}}
                        @if(Auth::user()->role === 'amministratore')
                            <a href="{{ route('utenti.index') }}" class="btn btn-danger btn-lg">
                                Gestione utenti
                            </a>
                        @endif

                    </div>
                </div>
            </div>

            {{-- Messaggio successo --}}
            @if(session('success'))
                <div class="alert alert-success mt-5">
                    {{ session('success') }}
                </div>
            @endif

        </div>
    </div>
</div>
@endsection