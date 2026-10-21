<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $fillable = [
        'alumno_id',
        'tipo',
        'archivo',
        'status',
        'fecha_entrega',
    ];

    protected $casts = [
        'fecha_entrega' => 'date',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }
}
