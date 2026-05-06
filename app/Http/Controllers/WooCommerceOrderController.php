<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Ordine;
use App\Models\RigaOrdine;
use App\Services\WooCommerceService;

class WooCommerceOrderController extends Controller
{
    // Recupera gli ordini direttamente dalle API WooCommerce
    // e li passa alla view (usato per test e verifica dati API)
    public function index(WooCommerceService $wooCommerceService)
    {
        $orders = $wooCommerceService->getProcessingOrders();

        return view('orders_api.index', compact('orders'));
    }

    // Sincronizza gli ordini WooCommerce nel database locale
    public function sync(WooCommerceService $wooCommerceService)
    {
        // Recupera gli ordini in stato "processing" dalle API
        $orders = $wooCommerceService->getProcessingOrders();

        foreach ($orders as $order) {

            // Crea il cliente se non esiste già.
            // Se esiste (stessa email), aggiorna i dati anagrafici.
            $cliente = Cliente::updateOrCreate(
                ['email' => $order['billing']['email']],
                [
                    'nome' => $order['billing']['first_name'],
                    'cognome' => $order['billing']['last_name'],
                    'indirizzo_fatturazione' => $order['billing']['address_1'] ?? null,
                    'indirizzo_spedizione' => $order['shipping']['address_1'] ?? null,
                ]
            );

            // Crea o aggiorna l'ordine nel database locale.
            // L'id dell'ordine corrisponde all'id WooCommerce.
            $ordine = Ordine::updateOrCreate(
                ['id' => $order['id']],
                [
                    'cliente_id' => $cliente->id,
                    'totale' => $order['total'],
                    'stato' => $order['status'],
                    'data_ordine' => $order['date_created'],
                ]
            );

            // Rimuove eventuali righe ordine già presenti
            // per evitare duplicazioni durante una nuova sincronizzazione
            RigaOrdine::where('ordine_id', $ordine->id)->delete();

            // Salva le righe dell'ordine (prodotti acquistati)
            foreach ($order['line_items'] as $item) {
                RigaOrdine::create([
                    'ordine_id' => $ordine->id,
                    'prodotto' => $item['name'],
                    'quantita' => $item['quantity'],
                    'prezzo' => $item['total'],
                ]);
            }
        }

        // Reindirizza alla dashboard con messaggio di conferma
        return redirect()
            ->route('dashboard')
            ->with('success', 'Ordini WooCommerce sincronizzati correttamente.');
    }
}