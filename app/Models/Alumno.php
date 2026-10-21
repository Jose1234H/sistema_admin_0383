<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricula',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'curp',
        'fecha_nacimiento',
        'genero',
        'direccion',
        'telefono',
        'email',
        'grado',
        'grupo',
        'password',
        'status',
        'status_expediente',
        'fecha_inscripcion',
        'monto_inscripcion',
        'monto_pagado',
        'observaciones',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_inscripcion' => 'date',
    ];

    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }

    public function datosBiomedicos()
    {
        return $this->hasOne(DatosBiomedico::class);
    }
}
