<?php

namespace Database\Factories;

use App\Models\Movimiento;
use App\Models\Alumno;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovimientoFactory extends Factory
{
    protected $model = Movimiento::class;

    public function definition()
    {
        return [
            'alumno_id' => Alumno::factory(),
            'tipo' => $this->faker->randomElement(['Alta', 'Baja']),
            'motivo' => $this->faker->sentence(5),
            'fecha' => $this->faker->date('Y-m-d', 'now'),
            'observaciones' => $this->faker->optional(0.6)->sentence(8),
        ];
    }
}
