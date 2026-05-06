<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ordine extends Model
{
    protected $table = 'ordini';

    public $timestamps = false;

    public $incrementing = false;

    protected $keyType = 'int';

    protected $fillable = [
        'id',
        'cliente_id',
        'totale',
        'stato',
        'data_ordine',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function righe()
    {
        return $this->hasMany(RigaOrdine::class, 'ordine_id');
    }
}