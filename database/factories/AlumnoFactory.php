<?php

namespace Database\Factories;

use App\Models\Alumno;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AlumnoFactory extends Factory
{
    protected $model = Alumno::class;

    public function definition()
    {
        $nombre = $this->faker->firstName();
        $apellido = $this->faker->lastName();
        $matricula = $this->faker->unique()->numerify('2026####');

        return [
            'matricula' => $matricula,
            'nombre' => $nombre,
            'apellido_paterno' => $apellido,
            'apellido_materno' => $this->faker->optional()->lastName(),
            'curp' => strtoupper($this->faker->regexify('[A-Z]{4}[0-9]{6}[A-Z]{6}[0-9]{2}')),
            'fecha_nacimiento' => $this->faker->date('Y-m-d', '-15 years'),
            'genero' => $this->faker->randomElement(['Masculino', 'Femenino', 'Otro']),
            'direccion' => $this->faker->address(),
            'telefono' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'grado' => $this->faker->randomElement(['1ro', '2do', '3ro']),
            'grupo' => $this->faker->randomElement(['A', 'B', 'C']),
            'password' => Hash::make('password'),
            'status' => 'Activo',
            'status_expediente' => $this->faker->randomElement(['Completo', 'Incompleto']),
            'fecha_inscripcion' => $this->faker->date('Y-m-d', 'now'),
        ];
    }
}
