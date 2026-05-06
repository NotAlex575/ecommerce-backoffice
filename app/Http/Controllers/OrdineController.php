<?php

namespace App\Http\Controllers;

use App\Models\Ordine;
use App\Services\WooCommerceService;
use Illuminate\Http\Request;

class OrdineController extends Controller
{
    // Lista ordini con cliente associato
    public function index(Request $request)
{
    $query = Ordine::with('cliente');

    // filtro per cliente
    if ($request->filled('cliente')) {
        $query->whereHas('cliente', function ($q) use ($request) {
            $q->where('nome', 'like', '%' . $request->cliente . '%')
              ->orWhere('cognome', 'like', '%' . $request->cliente . '%');
        });
    }

    // filtro per stato
    if ($request->filled('stato')) {
        $query->where('stato', $request->stato);
    }

    $ordini = $query->get();

    return view('orders_db.index', compact('ordini'));
}

    // Dettaglio ordine con cliente e righe
    public function show(Ordine $ordine)
    {
        $ordine->load(['cliente', 'righe']);

        return view('orders_db.show', compact('ordine'));
    }

    public function edit(Ordine $ordine)
    {
        return view('orders_db.edit', compact('ordine'));
    }

    // Aggiornamento stato ordine (DB + WooCommerce)
    public function updateStatus(Request $request, Ordine $ordine, WooCommerceService $wooService)
    {
        // Validazione stato (evita valori non validi)
        $validated = $request->validate([
            'stato' => 'required|in:processing,completed,cancelled,refunded'
        ]);

        $newStatus = $validated['stato'];

        // Aggiorna DB locale
        $ordine->update([
            'stato' => $newStatus
        ]);

        // Aggiorna WooCommerce
        $wooService->updateOrderStatus($ordine->id, $newStatus);

        return redirect()
            ->route('ordini.show', $ordine->id)
            ->with('success', 'Stato aggiornato correttamente!');
    }
}