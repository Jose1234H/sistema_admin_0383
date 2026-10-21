<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'alumno_id',
        'concepto',
        'monto',
        'monto_pagado',
        'status',
        'metodo_pago',
        'folio',
        'fecha',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }
}
