<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'alumno_id',
        'tipo',
        'motivo',
        'fecha',
        'observaciones',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }
}
