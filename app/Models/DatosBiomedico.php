<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosBiomedico extends Model
{
    use HasFactory;

    protected $table = 'datos_biomedicos';

    protected $fillable = [
        'alumno_id',
        'tipo_sangre',
        'estatura',
        'peso',
        'numero_seguro',
        'alergias',
        'contacto_emergencia',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }
}