<?php

namespace Database\Factories;

use App\Models\Documento;
use App\Models\Alumno;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentoFactory extends Factory
{
    protected $model = Documento::class;

    public function definition()
    {
        $tipos = [
            'Acta de nacimiento',
            'CURP',
            'Certificado de primaria',
            'Comprobante de domicilio',
        ];

        return [
            'alumno_id' => Alumno::factory(),
            'tipo' => $this->faker->randomElement($tipos),
            'archivo' => null,
            'status' => $this->faker->randomElement(['Pendiente', 'Entregado']),
            'fecha_entrega' => $this->faker->optional(0.5)->date('Y-m-d'),
        ];
    }
}
