<?php

namespace App\Http\Controllers;

use App\Models\Cliente;

class ClienteController extends Controller
{
    // Mostra l'elenco dei clienti presenti nel database locale.
    public function index()
    {
        $clienti = Cliente::with('ordini')->get();

        return view('clienti.index', compact('clienti'));
    }

    // Mostra il dettaglio di un cliente con i suoi ordini collegati.
    public function show(Cliente $cliente)
    {
        $cliente->load('ordini');

        return view('clienti.show', compact('cliente'));
    }
}