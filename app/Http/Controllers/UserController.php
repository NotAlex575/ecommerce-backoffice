<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    // Mostra l'elenco degli utenti registrati nell'applicazione
    public function index()
    {
        $utenti = User::all();

        return view('utenti.index', compact('utenti'));
    }

    // Mostra il dettaglio di un singolo utente
    public function show(User $utente)
    {
        return view('utenti.show', compact('utente'));
    }
}