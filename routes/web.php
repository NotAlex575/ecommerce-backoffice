<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\OrdineController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WooCommerceOrderController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
| Se l’utente è già autenticato viene reindirizzato alla dashboard,
| altrimenti viene mostrata la welcome page.
*/
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
| Accessibile solo ad utenti autenticati e verificati.
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Rotte protette da autenticazione
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Profilo utente
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | ORDINI (Database locale)
    |--------------------------------------------------------------------------
    | index → lista ordini
    | show → dettaglio ordine
    */
    Route::resource('ordini', OrdineController::class)
        ->parameters(['ordini' => 'ordine'])
        ->only(['index', 'show', 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Modifica stato ordine
    |--------------------------------------------------------------------------
    | edit → form modifica stato
    | updateStatus → salva modifica (DB + WooCommerce)
    */
    Route::get('/ordini/{ordine}/edit', [OrdineController::class, 'edit'])
        ->name('ordini.edit');

    Route::post('/ordini/{ordine}/stato', [OrdineController::class, 'updateStatus'])
        ->name('ordini.updateStatus');

    /*
    |--------------------------------------------------------------------------
    | Sincronizzazione WooCommerce → DB
    |--------------------------------------------------------------------------
    | Recupera ordini "processing" e li salva nel database locale
    */
    Route::get('/sync-ordini', [WooCommerceOrderController::class, 'sync'])
        ->name('ordini.sync');

    /*
    |--------------------------------------------------------------------------
    | Test API WooCommerce
    |--------------------------------------------------------------------------
    | Visualizza direttamente i dati provenienti dalle API
    */
    Route::get('/ordini-woocommerce', [WooCommerceOrderController::class, 'index'])
        ->name('woocommerce.orders');

    /*
    |--------------------------------------------------------------------------
    | CLIENTI
    |--------------------------------------------------------------------------
    | index → lista clienti
    | show → dettaglio cliente
    */
    Route::resource('clienti', ClienteController::class)
        ->parameters(['clienti' => 'cliente'])
        ->only(['index', 'show']);

    /*
    |--------------------------------------------------------------------------
    | AREA AMMINISTRATORE
    |--------------------------------------------------------------------------
    | Accessibile solo agli utenti con ruolo "amministratore"
    */
    Route::middleware('admin')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Gestione utenti
        |--------------------------------------------------------------------------
        | index → lista utenti
        | show → dettaglio utente
        */
        Route::resource('utenti', UserController::class)
            ->parameters(['utenti' => 'utente'])
            ->only(['index', 'show']);
    });
});

/*
|--------------------------------------------------------------------------
| Rotte di autenticazione Laravel
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';