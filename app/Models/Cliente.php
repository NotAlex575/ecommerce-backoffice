<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    // Specifica il nome della tabella associata al modello
    protected $table = 'clienti';

    // Campi che possono essere assegnati in massa (mass assignment)
    // Cliente.php
    protected $fillable = [
        'nome',
        'cognome',
        'email',
        'indirizzo_fatturazione',
        'indirizzo_spedizione',
    ];

    // Relazione uno-a-molti:
    // un cliente può avere più ordini
    public function ordini()
    {
        return $this->hasMany(Ordine::class, 'cliente_id');
    }
}