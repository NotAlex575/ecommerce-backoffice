@extends('layouts.app')

@section("title")
    Benvenuto nel backoffice di Ecommercione
@endsection

@section('content')

<div class="p-5 bg-dark text-light rounded-4 shadow-lg border border-primary text-center">


    <h1 class="display-5 fw-bold text-primary mb-3">
        Backoffice Control Panel
    </h1>

    <h4 class="fw-bold text-info mb-4">
        Created by: Alessandro Agnello
    </h4>

    <p class="col-md-8 mx-auto fs-5 text-light">
        Gestisci l’anagrafica clienti e gli ordini effettuati sull’ecommerce
        attraverso le funzionalità del pannello Laravel.
    </p>

    <p class="col-md-8 mx-auto fs-5 text-info mt-3">
        Effettua il login o registrati per accedere alla dashboard.
    </p>

    <div class="mt-4 d-flex justify-content-center gap-3 flex-wrap">
        <a href="{{ route('login') }}" class="btn btn-primary px-4 rounded-pill fw-semibold">
            Login
        </a>

        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="btn btn-outline-info px-4 rounded-pill fw-semibold">
                Register
            </a>
        @endif
    </div>

</div>

@endsection