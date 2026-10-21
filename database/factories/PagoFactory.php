<?php

namespace Database\Factories;

use App\Models\Pago;
use App\Models\Alumno;
use Illuminate\Database\Eloquent\Factories\Factory;

class PagoFactory extends Factory
{
    protected $model = Pago::class;

    public function definition()
    {
        $statuses = ['Pagado', 'Pendiente', 'Parcial'];

        return [
            'alumno_id' => Alumno::factory(),
            'concepto' => $this->faker->randomElement(['Inscripción', 'Colegiatura', 'Materiales']),
            'monto' => $this->faker->randomFloat(2, 300, 1500),
            'monto_pagado' => function (array $attributes) {
                return $attributes['status'] !== 'Pendiente' ? $this->faker->randomFloat(2, 100, $attributes['monto']) : 0;
            },
            'status' => $status = $this->faker->randomElement($statuses),
            'metodo_pago' => $this->faker->randomElement(['Transferencia', 'Efectivo', 'Tarjeta']),
            'folio' => $this->faker->optional(0.7)->numerify('FOLIO-####'),
            'fecha' => $this->faker->date('Y-m-d', 'now'),
        ];
    }
}
