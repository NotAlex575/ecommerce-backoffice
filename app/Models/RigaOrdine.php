<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RigaOrdine extends Model
{
    protected $table = 'righe_ordine';

    public $timestamps = false;

    protected $fillable = [
        'ordine_id',
        'prodotto',
        'quantita',
        'prezzo',
    ];

    public function ordine()
    {
        return $this->belongsTo(Ordine::class, 'ordine_id');
    }
}